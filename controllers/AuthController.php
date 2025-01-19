<?php

namespace app\controllers;

use app\models\LoginForm;
use Yii;

class AuthController extends \yii\rest\Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // dd(Yii::$app->timeZone);
        $behaviors['authenticator'] = [
            'class' => \bizley\jwt\JwtHttpBearerAuth::class,
            'except' => [
                'register',
                'login',
                // 'refresh-token',
                // 'options',
            ],
        ];

        return $behaviors;
    }

    public function actionRegister()
    {
        $model = new \app\models\User();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            $model->setPassword($model->password);
            $model->save();

            Yii::$app->user->login($model, LoginForm::$timeToken);
            $user = Yii::$app->user->identity;

            $token = $this->generateJwt($user);

            $this->generateRefreshToken($user);

            return [
                'user' => $user,
                'token' => (string) $token,
            ];
        }


        Yii::$app->response->setStatusCode(422);
        return $model->getErrors();
    }

    public function actionLogin()
    {
        $model = new \app\models\LoginForm();
        if ($model->load(Yii::$app->request->post(), '') && $model->login()) {
            $user = Yii::$app->user->identity;

            $token = $this->generateJwt($user);

            $this->generateRefreshToken($user);

            return [
                'user' => $user,
                'token' => (string) $token,
            ];
        }

        Yii::$app->response->setStatusCode(422);
        return $model->getErrors();
    }

    public function actionRefreshToken()
    {
        $refreshToken = Yii::$app->request->cookies->getValue('refresh-token', false);
        if (!$refreshToken) {
            return new \yii\web\UnauthorizedHttpException('No refresh token found.');
        }

        $userRefreshToken = \app\models\UserRefreshToken::findOne(['urf_token' => $refreshToken]);

        if (Yii::$app->request->getMethod() == 'POST') {
            if (!$userRefreshToken) {
                return new \yii\web\UnauthorizedHttpException('The refresh token no longer exists.');
            }

            $user = \app\models\User::find()  //adapt this to your needs
                ->where(['userID' => $userRefreshToken->urf_userID])
                ->andWhere(['not', ['usr_status' => 'inactive']])
                ->one();
            if (!$user) {
                $userRefreshToken->delete();
                return new \yii\web\UnauthorizedHttpException('The user is inactive.');
            }

            $token = $this->generateJwt($user);

            return [
                'status' => 'ok',
                'token' => (string) $token,
            ];
        } elseif (Yii::$app->request->getMethod() == 'DELETE') {
            // Logging out
            if ($userRefreshToken && !$userRefreshToken->delete()) {
                return new \yii\web\ServerErrorHttpException('Failed to delete the refresh token.');
            }

            return ['status' => 'ok'];
        }

        return new \yii\web\UnauthorizedHttpException('The user is inactive.');
    }

    public function actionMe()
    {
        // dd(Yii::$app->user->identity);

        return [
            'user' => Yii::$app->user->identity
        ];
    }

    private function generateJwt(\app\models\User $user)
    {
        $jwt = Yii::$app->jwt;
        $jwtParams = Yii::$app->params['jwt'];
        $now = new \DateTimeImmutable();

        $token = $jwt->getBuilder()
            ->issuedBy($jwtParams['issuer'])
            ->permittedFor($jwtParams['audience'])
            // Configures the id (jti claim)
            ->identifiedBy($jwtParams['id'])
            // Configures the time that the token was issued (iat claim)
            ->issuedAt($now)
            // Configures the expiration time of the token (exp claim)
            ->expiresAt($now->modify('+' . LoginForm::$timeToken . ' seconds'))
            // Configures a new claim, called "uid"
            ->withClaim('uid', $user->getId())
            ->getToken(
                $jwt->getConfiguration()->signer(),
                $jwt->getConfiguration()->signingKey()
            );

        return $token->toString();
    }

    private function generateRefreshToken(\app\models\User $user): \app\models\UserRefreshToken
    {
        $refreshToken = Yii::$app->security->generateRandomString(200);

        // TODO: Don't always regenerate - you could reuse existing one if user already has one with same IP and user agent
        $userRefreshToken = new \app\models\UserRefreshToken([
            'urf_userID' => $user->id,
            'urf_token' => $refreshToken,
            'urf_ip' => Yii::$app->request->userIP,
            'urf_user_agent' => Yii::$app->request->userAgent,
            'urf_created' => gmdate('Y-m-d H:i:s'),
        ]);
        if (!$userRefreshToken->save()) {
            throw new \yii\web\ServerErrorHttpException('Failed to save the refresh token: ' . $userRefreshToken->getErrorSummary(true));
        }

        // Send the refresh-token to the user in a HttpOnly cookie that Javascript can never read and that's limited by path
        // Yii::$app->response->cookies->add(new \yii\web\Cookie([
        //     'name' => 'refresh-token',
        //     'value' => $refreshToken,
        //     'httpOnly' => true,
        //     'sameSite' => 'none',
        //     'secure' => true,
        //     'path' => '/v1/auth/refresh-token',  //endpoint URI for renewing the JWT token using this refresh-token, or deleting refresh-token
        // ]));

        return $userRefreshToken;
    }
}

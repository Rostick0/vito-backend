<?php

return [
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',

    'jwt' => [
        'issuer' => 'https://localhost:8080',  //name of your project (for information only)
        'audience' => 'https://localhost:8080',  //description of the audience, eg. the website using the authentication (for info only)
        'id' => 'UNIQUE-JWT-IDENTIFIER',  //a unique identifier for the JWT, typically a random string
        // 'expire' => 60 * 60 * 24,  //the short-lived JWT token is here set to expire after 24 h.
    ],
];

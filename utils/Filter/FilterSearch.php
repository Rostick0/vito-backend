<?php

namespace app\utils\Filter;

use app\utils\ProtectSearch;

class FilterSearch
{
    public function __construct(
        // public \yii\db\ActiveRecord $modelClass,
        public string $name_query_param = 'filter',
        // public 
    ) {}

    private $type_search = [
        'eq' => '=',
        'neq' => '!=',
        'geq' => '>=',
        'leq' => '<=',
        'ge' => '>',
        'le' => '<',
        'in' => 'in',
        'not_in' => 'not in',
        'like' => 'like',
        'is' => 'is ',
    ];

    public function setValue($val, $type_search)
    {
        if (array_search(
            $type_search,
            [$this->type_search['in'], $this->type_search['not_in'], $this->type_search['is']]
        ) !== false) return json_decode($val);

        return $val;
    }

    public function setWhere($value, &$query, $name_table)
    {
        if (is_array($value)) {
            foreach ($value as $type => $val) {
                if (isset($this->type_search[$type])) {
                    $query->andWhere([
                        $this->type_search[$type],
                        $name_table,
                        $this->setValue($val, $this->type_search[$type])
                    ]);
                }
            }
            return;
        }

        $query->andWhere([
            $this->type_search['eq'],
            $name_table,
            $value
        ]);
    }

    public function run(\yii\db\ActiveQuery &$query, $params)
    {
        foreach ($params[$this->name_query_param] as $key => $value) {
            if (str_contains($key, '.')) {
                $arr_key = explode('.', $key);
                $relat_key = implode(
                    '.',
                    array_splice($arr_key, 0, -1)
                );

                $query->joinWith([
                    $relat_key => function ($query) use ($value, $relat_key, $key) {
                        $attribute = str_replace($relat_key . '.', '', $key);
                        if (!ProtectSearch::issetAttribute($attribute, $query)) return;

                        $this->setWhere(
                            $value,
                            $query,
                            $query->modelClass::tableName() . ".$attribute"
                        );
                    }
                ]);
            } else {
                if (!ProtectSearch::issetAttribute($key, $query)) continue;
                $this->setWhere($value, $query, $query->modelClass::tableName() . '.' . $key);
            }
        }

        return $query;
    }
}

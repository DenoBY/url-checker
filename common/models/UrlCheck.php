<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class UrlCheck extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%url_checks}}';
    }

    public function rules(): array
    {
        return [
            [['url_id', 'status_code'], 'required'],
            [['url_id', 'status_code'], 'integer'],
        ];
    }

    public function getUrl(): ActiveQuery
    {
        return $this->hasOne(Url::class, ['id' => 'url_id']);
    }
}
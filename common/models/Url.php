<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

class Url extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%urls}}';
    }

    public function rules(): array
    {
        return [
            [['url', 'check_interval'], 'required'],
            [['url'], 'string', 'max' => 255],
            [['check_interval', 'retry_count', 'retry_delay'], 'integer'],
            [['url'], 'url'],
        ];
    }

    public function getChecks(): ActiveQuery
    {
        return $this->hasMany(UrlCheck::class, ['url_id' => 'id']);
    }
}

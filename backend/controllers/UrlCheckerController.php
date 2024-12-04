<?php

namespace backend\controllers;

use common\models\Url;
use common\models\UrlCheck;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class UrlCheckerController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['urls', 'checks'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionUrls(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Url::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('urls', ['dataProvider' => $dataProvider]);
    }

    public function actionChecks(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UrlCheck::find()
                ->with('url')
                ->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('checks', ['dataProvider' => $dataProvider]);
    }
}

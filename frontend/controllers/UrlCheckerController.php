<?php

namespace frontend\controllers;

use common\models\Url;
use console\jobs\UrlCheckJob;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class UrlCheckerController extends Controller
{
    public function actionIndex(): string
    {
        $model = new Url();

        return $this->render('index', ['model' => $model]);
    }

    public function actionStore(): Response
    {
        $model = new Url();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'URL added successfully');
        }

        Yii::$app->queue->push(new UrlCheckJob([
            'urlId' => $model->id,
        ]));

        return $this->redirect(['url-checker/index']);
    }
}

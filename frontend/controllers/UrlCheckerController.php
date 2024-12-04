<?php

namespace frontend\controllers;

use common\models\Url;
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

        return $this->redirect(['url-checker/index']);
    }
}

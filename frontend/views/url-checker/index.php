<?php

use common\models\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var Url $model */

$form = ActiveForm::begin(['action' => ['url-checker/store']]); ?>

<?= $form->field($model, 'url')->textInput() ?>
<?= $form->field($model, 'check_interval')->dropDownList([1 => '1 min', 5 => '5 min', 10 => '10 min']) ?>
<?= $form->field($model, 'retry_count')->textInput() ?>
<?= $form->field($model, 'retry_delay')->textInput() ?>

<div class="form-group">
    <?= Html::submitButton('Создать', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
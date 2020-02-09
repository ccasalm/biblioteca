<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Prestamos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="prestamos-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lector_id')->textInput() ?>

    <?= $form->field($model, 'libro_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'devolucion')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

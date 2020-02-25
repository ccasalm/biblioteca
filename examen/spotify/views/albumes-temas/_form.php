<?php

use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AlbumesTemas */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="albumes-temas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'album_id')->label('Album')->dropDownList($albumes) ?>
    <?= $form->field($model, 'tema_id')->label('Tema')->dropDownList($temas) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

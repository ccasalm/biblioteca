<?php

use app\models\Albumes;
use app\models\Temas;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AlbumesTemas */

$this->title = 'Update Albumes Temas: ' . $model->album_id;
$this->params['breadcrumbs'][] = ['label' => 'Albumes Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->album_id, 'url' => ['view', 'album_id' => $model->album_id, 'tema_id' => $model->tema_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="albumes-temas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'temas' => Temas::lista(),
        'albumes' => Albumes::lista(),
    ]) ?>

</div>

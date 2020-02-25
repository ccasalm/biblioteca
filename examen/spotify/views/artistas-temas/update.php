<?php

use app\models\Artistas;
use app\models\Temas;
use yii\bootstrap4\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistasTemas */

$this->title = 'Update Artistas Temas: ' . $model->artista_id;
$this->params['breadcrumbs'][] = ['label' => 'Artistas Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->artista_id, 'url' => ['view', 'artista_id' => $model->artista_id, 'tema_id' => $model->tema_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="artistas-temas-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'artistas' => Artistas::lista(),
        'temas' => Temas::lista(),
    ]) ?>

</div>

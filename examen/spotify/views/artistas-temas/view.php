<?php

use yii\bootstrap4\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistasTemas */

$this->title = $model->artista_id;
$this->params['breadcrumbs'][] = ['label' => 'Artistas Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="artistas-temas-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'artista_id' => $model->artista_id, 'tema_id' => $model->tema_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'artista_id' => $model->artista_id, 'tema_id' => $model->tema_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'artista_id',
            'tema_id',
        ],
    ]) ?>

</div>

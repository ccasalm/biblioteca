<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\Albumes */

$this->title = $album->id;
$this->params['breadcrumbs'][] = ['label' => 'Albumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="albumes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $album->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $album->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $album,
        'attributes' => [
            'id',
            'titulo',
            'anyo',
            [
                'attribute' => 'total',
                'value' => function ($album) {
                    return $album->totalFormat;
                }
            ],
        ],
    ]) ?>
    <?= GridView::widget([
        'dataProvider' => $temas,
        'columns' => ['duracion', 'titulo'],
    ]); ?>

    <?= ListView::widget([
        'dataProvider' => $artistas,
        'itemView' => '_post',
        'viewParams' => [
            'fullView' => true,
            'context' => 'main-page',
        ],
    ]); ?>

</div>
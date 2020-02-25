<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArtistasTemasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Artistas Temas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="artistas-temas-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Artistas Temas', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'artista.nombre',
            'tema.titulo',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

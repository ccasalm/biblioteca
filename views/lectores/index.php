<?php

use yii\bootstrap4\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LectoresSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lectores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lectores-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Registrar', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'nombre',
            'telefono',
            'poblacion',
            'created_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
            ]
        ],
    ]); ?>


</div>

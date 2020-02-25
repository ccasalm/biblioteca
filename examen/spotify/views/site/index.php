<?php

/* @var $this yii\web\View */

use yii\bootstrap4\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Busca lo que quieras</h1>

        <p class="lead">Busca por artista, tema o álbum.</p>

        <p>
            <?= Html::beginForm(['site/index'], 'get') ?>
                <div class="form-group">
                    <?= Html::textInput('cadena', $cadena, ['class' => 'form-control']) ?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
                </div>
            <?= Html::endForm() ?>
        </p>
    </div>

    <div class="body-content">
        <?php if ($albumes->totalCount > 0): ?>
            <h3>Álbumes</h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $albumes,
                    'columns' => [
                        'titulo',
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'albumes',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
        <?php if ($artistas->totalCount > 0): ?>
            <h3>Artistas</h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $artistas,
                    'columns' => [
                        'nombre',
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'artistas',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
        <?php if ($temas->totalCount > 0): ?>
            <h3>Temas</h3>
            <div class="row">
                <?= GridView::widget([
                    'dataProvider' => $temas,
                    'columns' => [
                        'titulo',
                        [
                            'class' => ActionColumn::class,
                            'controller' => 'temas',
                            'template' => '{view}',
                        ],
                    ],
                ]) ?>
            </div>
        <?php endif ?>
    </div>
</div>

<?php

use app\models\Artistas;
use app\models\Temas;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\ArtistasTemas */

$this->title = 'Create Artistas Temas';
$this->params['breadcrumbs'][] = ['label' => 'Artistas Temas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="artistas-temas-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'artistas' => Artistas::lista(),
        'temas' => Temas::lista(),
    ]) ?>

</div>

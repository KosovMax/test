<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Citymaps */

$this->title = $model->cityid;
$this->params['breadcrumbs'][] = ['label' => 'Citymaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citymaps-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cityid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cityid], [
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
            'cityid',
            'address',
            'coorYX',
            'color',
            'date',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Citymaps */

$this->title = 'Update Citymaps: ' . ' ' . $model->cityid;
$this->params['breadcrumbs'][] = ['label' => 'Citymaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cityid, 'url' => ['view', 'id' => $model->cityid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="citymaps-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

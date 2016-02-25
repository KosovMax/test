<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Citymaps */

$this->title = 'Create Citymaps';
$this->params['breadcrumbs'][] = ['label' => 'Citymaps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citymaps-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

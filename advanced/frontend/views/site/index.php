<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use kartik\export\ExportMenu;


$this->title = "Maps";

?>
<div class="site-index">
    <div class="tab">
        <div class="tab-cell">
            <?= $this->render('_upload',['upload'=>$upload]) ?>
            <hr />
           
            <?php $form = ActiveForm::begin(['action'=>['index'],'method'=>'get']); ?>
                <div class="tab2">
                    <div class="tab2-cell in_search">
                        <?= $form->field($model, 'search') ?>   
                    </div>
                    <div class="tab2-cell but_search">
                        <?= Html::submitButton('<i class="fa fa-search" ></i> Пошук', ['class'=>'btn btn-primary']); ?>
                    </div>
                    
                </div>
            <?php ActiveForm::end(); ?>
            <hr />
            <?= GridView::widget([
                'dataProvider' => $dataMaps,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'address',
                    'coorYX',
                    'color',
                    'date',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <div>
                <?= Html::a('<i class="fa fa-cloud-download" ></i> Download CSV',['download'],['class'=>'btn btn-primary but_down']);?>
            </div>
        </div>
        <div class="tab-cell">
            <div>
             <?= $map; ?>
            </div>
        </div>
    </div>

</div>


<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;

?>
<div class="site-search">
    <?php $form = ActiveForm::begin(['action'=>['index'],'method'=>'get']); ?>
    	<div class="tab2">
			<div class="tab2-cell">
				<?= $form->field($model, 'search') ?>	
			</div>
			<div class="tab2-cell">
				<?= Html::submitButton('<i class="fa fa-search" ></i> Пошук', ['class'=>'btn btn-primary']); ?>
			</div>
			
		</div>
    <?php ActiveForm::end(); ?>
</div>
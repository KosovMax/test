<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

?>
<div class="site-upload">
	<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

		<div class="tab2">
			<div class="tab2-cell">
				<?php
					echo $form->field($upload, 'file')->fileInput();
					// Usage with ActiveForm and model
					// echo $form->field($upload, 'file')->widget(FileInput::classname(), [
					//     'options' => ['accept' => 'uploads/*'],
					// ]);

					// // With model & without ActiveForm
					//  echo '<label class="control-label">Add Attachments</label>';
					// echo FileInput::widget([
					//     'name' => 'attachment_3',
					// ]);
				?>
				
			</div>
			<div class="tab2-cell">
				<?= Html::submitButton('Загрузить <i class="fa fa-cloud-upload" ></i>', ['class'=>'btn btn-primary']); ?>
			</div>
			
		</div>


    <?php ActiveForm::end(); ?>
</div>
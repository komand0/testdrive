<?php
/* @var $this NoteController */
/* @var $model Note */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('booster.widgets.TbActiveForm', array(
	'id'=>'note-form',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'author'); ?>
		<?php echo $form->textField($model,'author',array('size'=>60,'maxlength'=>255, 'value'=>Yii::app()->user->name)); ?>
		<?php echo $form->error($model,'author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php //echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>46)); ?>
		<?php
			$this->widget('booster.widgets.TbRedactorJs',
				array(
					'model'=>$model,
					'attribute'=>'content',
					'editorOptions'=>array(
						'fileUpload' => $this->createUrl('note/testFileUpload'),
						'imageUpload' => $this->createUrl('note/testImageUpload'),
						'imageGetJson'=> $this->createUrl('note/testImageThumbs'),
						'width'=>'100%',
						'height'=>'400px',
					)
				));
		?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('Note', 'Create') : Yii::t('Note', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
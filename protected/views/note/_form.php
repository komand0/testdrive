<?php
/* @var $this NoteController */
/* @var $model Note */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'note-form',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'Author'); ?>
		<?php echo $form->textField($model,'Author',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Author'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Title'); ?>
		<?php echo $form->textField($model,'Title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'Title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Content'); ?>
		<?php echo $form->textArea($model,'Content',array('rows'=>6, 'cols'=>46)); ?>
		<?php echo $form->error($model,'Content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('Note', 'Create') : Yii::t('Note', 'Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
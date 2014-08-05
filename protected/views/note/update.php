<?php
/* @var $this NoteController */
/* @var $model Note */

$this->breadcrumbs=array(
	Yii::t('Note', 'Notes')=>array('index'),
	$model->title=>array('view','id'=>$model->id_note),
	Yii::t('Note', 'Update'),
);

$this->menu=array(
	array('label'=>Yii::t('Note', 'Notes list'), 'url'=>array('index')),
	array('label'=>Yii::t('Note', 'Create note'), 'url'=>array('create')),
	array('label'=>Yii::t('Note', 'Update note'), 'url'=>array('update', 'id'=>$model->id_note)),
	array('label'=>Yii::t('Note', 'Delete note'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_note),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<!--<h1>Редактирование заметки <?php echo $model->id_note; ?></h1>-->

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
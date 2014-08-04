<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('Note', 'Notes')=>array('index'),
	Yii::t('Note', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('Note', 'Notes list'), 'url'=>array('index')),
);
?>

<h1><?php echo Yii::t('Note', 'Create note') ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>
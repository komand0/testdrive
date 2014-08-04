<?php

$this->breadcrumbs=array(
	Yii::t('Note', 'Notes')=>array('index'),
	$model->Title,
);

$this->menu=array(
	array('label'=>Yii::t('Note', 'Notes list'), 'url'=>array('index')),
	array('label'=>Yii::t('Note', 'Create note'), 'url'=>array('create'),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('Note', 'Update note'), 'url'=>array('update', 'id'=>$model->id_Note),'visible'=>!Yii::app()->user->isGuest),
	array('label'=>Yii::t('Note', 'Delete note'), 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest,
		  'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_Note),
		  					'confirm'=>Yii::t('Note', 'Are you sure you want to delete this item?'))),
);

echo "<table>\n";
echo "<tr><td><h3> ".nl2br(htmlspecialchars($model->Title))."</h3></td></tr>\n";
echo "<tr><td>\n";
echo "<p class=\"content\">\n";
echo nl2br(htmlspecialchars($model->Content,ENT_COMPAT|ENT_HTML401,"UTF-8"));
echo "</p>\n";
echo "</td></tr>\n";
echo "<tr><td>".Yii::t('Note', 'Author').": <i>".htmlspecialchars($model->Author)."</i><br>".Yii::t('Note', 'Date of last modification').": <i>".$model->Date."</i></td></tr>";
echo "</table>";

$this->renderPartial('_commentForm',array(
			'model'=>$CModel,
	));

//$dependecy = new CDbCacheDependency('SELECT COUNT(*) FROM '.$CModel->tableName().' WHERE id_Note='.$model->id_Note)

if($this->beginCache('c_'.$model->id_Note.Yii::app()->language.Yii::app()->user->isGuest, array(
	'dependency'=>array(
    	'class'=>'system.caching.dependencies.CDbCacheDependency',
    	'sql'=>'SELECT COUNT(*) FROM '.$CModel->tableName().' WHERE id_Note='.$model->id_Note
    	)
))) 
{ 
	$this->widget('application.components.widgets.CommentView',array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_commentItem',
		'title'=>Yii::t('Comment', 'Comments')
		));

	$this->endCache(); 
}
?>
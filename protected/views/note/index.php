<?php
/* @var $this NoteController */
/* @var $dataProvider CActiveDataProvider */
#@var q 
#@var auth

if($auth!==false){
	$breadcrumbs[Yii::t('Note', 'Notes')] = array('index');
	$breadcrumbs['author: '.$auth] = array('index','auth'=>urlencode($auth));
	if ($q!==false) {
		$breadcrumbs['query: '.$q] = array('index','q'=>$q);
	}
}
elseif ($q!==false){
	$breadcrumbs[Yii::t('Note', 'Notes')] = array('index');
	$breadcrumbs['query: '.$q] = array('index','q'=>$q);
}
else {
	$breadcrumbs = array(Yii::t('Note', 'Notes'));
}
$this->breadcrumbs = $breadcrumbs;

$this->menu = array(
	array('label' => Yii::t('Note', 'Create note'), 'url'=>array('create')),
	/*
	array('label'=> $this->renderPartial(
		'_search',
		array('q'=>($q!==false?$q:""),)
	)),//*/
);

echo "<h1>".yii::t('Note', 'Notes')."</h1>";
$this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
	'itemsTagName'=>'table',
	//'template'   => "<table>{items}</table>{pager}",
	#'sortableAttributes'=>array(
    #    'date',
    #),
  'id'=>'ajaxListView',//?
)); 

$this->renderPartial(
    '_search',
    array('q'=>($q!==false?$q:""),)
);
?>
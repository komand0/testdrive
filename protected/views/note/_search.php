<?php
/* @var $q*/
/* @var $form CActiveForm */


echo CHtml::beginForm(CHtml::normalizeUrl(array('index')), 'get', array('id'=>'filter-form'))
	. CHtml::textField('q', (isset($q)) ? $q : '', array('id'=>'q','tabindex'=>"1"))
	. CHtml::submitButton(Yii::t('Note', 'Search'), array('name'=>''))
	. CHtml::endForm();
Yii::app()->clientScript->registerScript('search',
	"var ajaxUpdateTimeout;
	var ajaxRequest;
	$('input#q').keyup(
		function()
		{
			ajaxRequest = $(this).serialize();
			clearTimeout(ajaxUpdateTimeout);
			ajaxUpdateTimeout = setTimeout(function () 
			{
				$.fn.yiiListView.update(
					// this is the id of the CListView
					'ajaxListView',
					{data: ajaxRequest}
				)
			},
			// this is the delay
			200);
		}
	);"
);

?>

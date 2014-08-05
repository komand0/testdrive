<?php
/* @var $this NoteController */
/* @var $data Note */

require_once("_header.php");
?>
<tr>
	<td> 
		<!-- <php echo CHtml::link(CHtml::encode($data->author), array('index', 'auth'=>urlencode($data->author))); ?> -->
		<?php //echo '<a href="'.Yii::app()->createUrl('auth/?'.urlencode($data->author)).'">'.$data->author.'</a>'; ?>
		<?php echo '<a href="'.Yii::app()->createUrl("note/index",array("auth"=>urlencode($data['author']))).'">'.htmlspecialchars($data->author).'</a>'; ?>
	</td>
	<td> 
		<?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id_note)); ?>
	</td>
	<td> 
		<?php echo CHtml::encode($data->date); ?>
	</td>
</tr>
<?php
/* @var $this NoteController */
/* @var $data Note */

require_once("_header.php");
?>
<tr>
	<td> 
		<!-- <?php echo CHtml::link(CHtml::encode($data->Author), array('index', 'auth'=>urlencode($data->Author))); ?> -->
		<?php //echo '<a href="'.Yii::app()->createUrl('auth/?'.urlencode($data->Author)).'">'.$data->Author.'</a>'; ?>
		<?php echo '<a href="'.Yii::app()->createUrl("note/index",array("auth"=>urlencode($data->Author))).'">'.htmlspecialchars($data->Author).'</a>'; ?>
	</td>
	<td> 
		<?php echo CHtml::link(CHtml::encode($data->Title), array('view', 'id'=>$data->id_Note)); ?>
	</td>
	<td> 
		<?php echo CHtml::encode($data->Date); ?>
	</td>
</tr>
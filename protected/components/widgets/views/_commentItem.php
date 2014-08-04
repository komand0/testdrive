<div class="commentItem">

	<b><?php echo CHtml::encode($data->getAttributeLabel('Author')); ?>:</b>
	<?php echo CHtml::encode($data->Author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('Content')); ?>:</b>
	<?php echo nl2br(CHtml::encode($data->Content)); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('Date')); ?>:</b>
	<?php echo CHtml::encode($data->Date); ?>
	<br />
	<b id="CActions">
	<div>
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>Yii::t('Comment', 'Delete'), 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest,
		  			'linkOptions'=>array('submit'=>array('delComment','id'=>$data->id,'id_Note'=>$data->id_Note),
		  			'confirm'=>Yii::t('Note', 'Are you sure you want to delete this item?'))),
			),
		)); ?>
	</div>
	</b>
</div>
<br />
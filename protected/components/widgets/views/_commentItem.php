<div class="commentItem">

	<b><?php echo CHtml::encode($data->getAttributeLabel('author')); ?>:</b>
	<?php echo CHtml::encode($data->author); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('content')); ?>:</b>
	<?php echo nl2br(CHtml::encode($data->content)); ?>
	<br />
	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::encode($data->date); ?>
	<br />
	<b id="CActions">
	<div>
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>Yii::t('Comment', 'Delete'), 'url'=>'#', 'visible'=>!Yii::app()->user->isGuest,
		  			'linkOptions'=>array('submit'=>array('delComment','id'=>$data->id,'id_note'=>$data->id_note),
		  			'confirm'=>Yii::t('Note', 'Are you sure you want to delete this item?'))),
			),
		)); ?>
	</div>
	</b>
</div>
<br />
<?php

?>
<tr>
	<th style="min-width:150px; width: 20%;"><?php echo CHtml::encode($data->getAttributeLabel('author')); ?></th>
	<th style="min-width:200px; width: 70%;"><?php echo CHtml::encode($data->getAttributeLabel('title')); ?></th>
	<th style="min-width:160px;"><?php echo CHtml::encode($data->getAttributeLabel('date')); ?></th>
</tr>
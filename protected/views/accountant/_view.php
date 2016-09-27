<?php
/* @var $this AccountantController */
/* @var $data LGUAccountant */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('accountant_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->accountant_name), array('view', 'id'=>$data->accountant_name)); ?>
	<br />


</div>
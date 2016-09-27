<?php
/* @var $this LGUInfoController */
/* @var $data LGUInfo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('LGU_name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->LGU_name), array('view', 'id'=>$data->LGU_name)); ?>
	<br />


</div>
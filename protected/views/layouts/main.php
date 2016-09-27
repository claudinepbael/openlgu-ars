<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<!--link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jqueryslidemenu.css" /-->

	<?php
		//Yii::app()->clientScript->registerScriptFile("".Yii::app()->request->baseUrl."/js/jqueryslidemenu.js");
	?>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainMbmenu">
		<?php $this->widget('application.extensions.mbmenu.MbMenu',array(
			'items'=>array(
				array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Chart of Accounts', 'url'=>array('/account/admin'),'visible'=>!Yii::app()->user->isGuest ),
				array('label'=>'Ledger', 'url'=>array('/ledger/admin'),'visible'=>!Yii::app()->user->isGuest,
					'items'=>array(
						array('label'=>'Create ledger entry', 'url'=>array('/ledger/create'),'visible'=>!Yii::app()->user->isGuest ),
					)
				 ),
			
				// array('label'=>'Journal Entries', 'url'=>array('/journal/index'),'visible'=>!Yii::app()->user->isGuest ),
				array('label'=>'Worksheet', 'url'=>array('/reports/worksheet'),'visible'=>!Yii::app()->user->isGuest ),
				array('label'=>'Reports','items'=>array(
					array('label'=>'Balance Sheet', 'url'=>array('/reports/balanceSheet'),'visible'=>!Yii::app()->user->isGuest ),
					array('label'=>'Income Statement', 'url'=>array('/reports/incomeStatement'),'visible'=>!Yii::app()->user->isGuest ),
				)),
				array('label'=>'Templates', 'items'=>array(
					array('label'=>'Balance Sheet Template', 'url'=>array('/balancesheetCategories/index'),'visible'=>!Yii::app()->user->isGuest ),
					array('label'=>'Income Statement Template', 'url'=>array('/incomestatementCategories/index'),'visible'=>!Yii::app()->user->isGuest ),
				)),
				array('label'=>'Information', 'items'=>array(
					array('label'=>'Update LGU Name', 'url'=>array('/lGUInfo/update'),'visible'=>!Yii::app()->user->isGuest ),
					array('label'=>'Update Accountant Name', 'url'=>array('/accountant/update'),'visible'=>!Yii::app()->user->isGuest ),
				)),
				//array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Claudine P. Bael.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>

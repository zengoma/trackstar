<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<?php if (!Yii::app()->user->isGuest): ?>
<b>Last Login: </b><?php echo Yii::app()->user->lastLogin ?>
<?php endif; ?>
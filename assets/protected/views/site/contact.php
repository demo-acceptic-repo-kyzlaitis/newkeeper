<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>
	<section id="main_section" >
		<div class="contacts">
			<a class="contact_logo" href="#"><img src="/images/logo2.png" alt=""></a>
			
			<p><?php echo $content->getText();?></p>
		</div>
	</section>
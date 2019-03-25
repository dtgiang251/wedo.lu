<?php 
/* Template name: Wedo Websites */ 
get_header(); the_post(); ?>
<?php if(isset($_POST['psts_mp_submit'])):?>
<div id="pagehead" class="vh-center large-pagehead">
    <img class="pagehead-image" src="<?php echo get_stylesheet_directory_uri();?>/assets/images/banner-new.jpg" alt="image">
    <div class="container">
        <h3 class="success-icon"><?php echo __('The activation of your website is in progress...', 'wedo-listing');?></h3>
		<h5><?php echo __('We will review the information received for your new website and send you an email as soon as your website is activated.', 'wedo-listing');?></h5>
		<?php $current_user = wp_get_current_user();?>
		<h5><?php _e('The email address we have is', 'wedo-listing');?>: <?php echo $current_user->user_email;?></h5>
    </div>
</div>
<div class="hidden">
<?php the_content() ?>
</div>
<?php else:?>
<div id="pagehead2">
	<figure>
		<img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/pagehead1.jpg">
	</figure>
</div>
     <div class="intro-section2">
        <div class="container">
           <div class="intro-box">
			  <h2 class="text-center"><?php _e('Build your website <br>or landing page','wedo-listing');?></h2>
			  <h4><?php _e('Please select the type of web project','wedo-listing');?></h4>

		   </div>
		   <div class="container">
				<p><?php _e('Our all-in-one platform includes everything you need to create your website or landing page. Our award-winning templates will present your ideas online in the most beautiful way. Stand out with a professional quality website or landing page. Whether you are starting out or as an established brand, our powerful platform helps you grow your business.','wedo-listing');?> </p>
		   
			   </div>
                   </div>
	 </div>
<?php $class='front-list';
if(isset($_GET['bid']) || isset($_GET['action'])):
	$class='';
endif;?>

	<div class="content-box">
			<div class="container website-list <?php echo $class;?>">
<?php the_content() ?>
</div>
	</div>
<?php endif;?>
<?php get_footer() ?>
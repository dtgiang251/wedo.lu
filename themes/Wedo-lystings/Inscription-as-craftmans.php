<?php /* Template name: Inscription as Craftmans */
get_header();?>
<?php while(have_posts()): the_post();?>
<?php if(isset($_GET['listing_type'])){ ?>
<?php the_content();?>

<?php } else {?>
<div class="wrap-content">

<div class="member-info">
    <div class="container">
        <div class="box1">
            <div class="box-wrapper">
                <div class="text-center">
                    <h2><?php the_field('members_title');?></h2>
                    <?php the_field('members_description');?>
                </div>
                <?php if(get_field('steps')):?>
                <ul class="login-steps group clearfix">
                    <?php $i=1; while(has_sub_field('steps')):?>
                    <li>
                        <span class="number"><?php echo $i;?></span>
                        <figure>
						<?php
							$media_id = giang_get_image_id(get_sub_field('icon')); ;
							$alt = 'image';
							if($media_id) $alt = giang_get_media_alt( $media_id );
						?>
                            <img src="<?php the_sub_field('icon');?>" alt="<?php echo $alt; ?>">
                        </figure>
                        <p><?php the_sub_field('title');?></p>
                    </li>
                    <?php $i++; endwhile;?>
                   
                </ul>
                <?php endif;?>

                <div class="row know-us">
                    <div class="col-sm-6">
                        <h5> <?php the_field('members_left_section_title');?></h5>
                        <p class="lead"> <?php the_field('members_left_section_content');?></p>
                    </div>
                    <div class="col-sm-6">
                        <h5><?php the_field('what_tutorial_title');?></h5>
                        <figure>
                        <?php the_field('watch_tutorial_iframe_code');?>
                        </figure>
                    </div>
                </div>
            </div>
            <footer>                   
                <form action="<?php echo home_url('/annuaire-2/');?>" method="GET">
                <p><input type="text" name="search_keywords" placeholder="<?php _e('Rechercher mon entreprise','wedo-listing');?>">
                    <input type="submit" value="<?php _e('Search','wedo-listing');?>" class="button-2"></p>
                </form>     
            </footer>
        </div>
    </div>
</div>

<div class="non-members">
    <div class="container">
        <div class="text-center">
            <h2><?php the_field('non_members_title');?></h2>
            <?php the_field('non_members_content');?>
        </div>
        <div class="form1">
            <?php echo do_shortcode(get_field('form'));?>
        </div>
    </div>
</div>

<div class="cta">
    <div class="container">
        <h2><?php _e('Contact new members','wedo-listing');?></h2>
        <div class="contact-me clearfix">
            <figure>
			<?php
				$media_id = giang_get_image_id(get_field('contact_image')); ;
				$alt = 'image';
				if($media_id) $alt = giang_get_media_alt( $media_id );
			?>
                <img src="<?php echo get_field('contact_image');?>" alt="<?php echo $alt; ?>">
            </figure>
            <div class="person-info">
                <h3 class="person-name"><?php echo get_field('name');?></h3>
                <p><?php echo get_field('designation');?></p>
                <ul class="call-me clearfix">
                    <li>
                    <a href="tel:<?php echo get_field('phone');?>">
                        <i class="fa fa-phone"></i>
                        <?php echo get_field('phone');?>
</a>   
                    </li>
                    <li>
                        <a href="mailto:<?php echo get_field('email');?>">
                            <i class="fa fa-envelope-o"></i>
                            <?php echo get_field('email');?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
</div>
<?php } ?>
<?php endwhile;?>
<?php get_footer();?>
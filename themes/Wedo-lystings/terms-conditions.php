<?php /* Template name: Terms and Conditions */
get_header();?>
<?php while(have_posts()): the_post();?>
<div id="banner">
    <div class="container">
        <h1><?php the_title();?></h1>
        <h5><?php the_field('subtitle');?></h5>
        <div class="two-column">
        <?php the_field('description');?>
        </div>
    </div>
</div>  

<?php if(get_field('list')):?>
<div class="wrap-content bg-white">
    <div class="container accordion">
       <?php while(has_sub_field('list')):?>
        <article class="post">
            <h3><?php the_sub_field('title');?> <i class="fa fa-angle-down"></i> </h3>
            <?php if(get_sub_field('content')):?>
            <div class="post-content">
                <?php the_sub_field('content');?>                
            </div>
            <?php endif;?>
            <?php if(get_sub_field('nested_list')):?>
            <div class="wrap">
                <?php while(has_sub_field('nested_list')):?>
                <h4><?php the_sub_field('title');?><i class="fa fa-angle-down"></i></h4>
                <div class="post-content">
                <?php the_sub_field('content');?>
                </div>
                 <?php endwhile;?>       
            </div>
             <?php endif;?>
        </article>

        <hr>
       <?php endwhile;?>                    
    </div>
</div>
<?php endif;?>
<?php endwhile;?>
<?php get_footer();?>
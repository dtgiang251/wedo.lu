<?php /* Template name: Project Success */
get_header();?>
 <div class="full-width">
        <div class="site-content" id="content">

            <!-- Drop Your New code-->
            <div class="quote-wrapper">
                <div class="container-fluid default-sidebar">
                    <div class="row">
                        <div class="col-lg-3 col-md-4" id="sidebar">
                            <div class="text-center sent-wrapper">
                                <figure>
                                    <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/sent-icon2.svg" alt="image">
                                </figure>
                                <h2><?php _e("It’s sent!",'box-theme');?></h2>
                                <p>
                                <?php _e("Your request will be analyzed. You will soon receive a list of professionals who will be contact with you.",'box-theme');?>
                                </p>
                            </div>
                        </div>
                        <?php if(isset($_GET['category']) && $_GET['category'] != ''):?>
                        <?php $term = get_term_by('id', $_GET['category'], 'project_cat');
                        if($term):
                        if(get_field('skills',$term)):
                        $skills = get_field('skills',$term);?>
                        <div class="col-lg-9 col-md-8 quotes-sub-category" id="main">
                            <h2><?php _e("Need more quotes?",'box-theme');?></h2>
                            <div class="row">
                            <?php $j=0; foreach($skills as $skill){ ?>
                                <div class="col-sm-6">
                                    <div class="card">
                                        <a href="<?php echo home_url('/quote/').$term->slug.'/'.$skill->slug;?>">
                                            <?php if(get_field('featured_image',$skill)):?>
                                            <img src="<?php echo get_field('featured_image',$skill);?>" alt="image">
                                            <?php endif;?>
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $skill->name;?></h5>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                            </div>
                        </div>
                        <?php endif; endif; endif;?>
                    </div>
                </div>
            </div>
        </div>
 </div>
<?php get_footer();?>
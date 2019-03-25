<?php
/**
 * @key:archive-project.php
 */
get_header(); ?>

<div class="quote-wrapper">
<div class="container-fluid">
    <div class="row">
            <div class="col-md-9 col-md-offset-3 col-sm-8 col-sm-offset-4 col" id="main">
                    <div class="search-form">
					        <form action="" class="full frm-search">							
							       <input type="text" name="s" id="keyword" required  placeholder="<?php _e('Que cherchez vous?','boxtheme');?>" value="<?php echo get_search_query();?>"/>
							       <input type="submit" value="<?php _e('Rechercher','boxtheme');?>">
							</form>  
                    </div>
                    </div>
    </div>
        <div class="row same-height">
              <div class="col-md-3 col-sm-4 col" id="sidebar">
                 <h2><?php _e('Filtres de recherche','boxtheme');?></h2>
                 <ul>
				 <?php
				  $terms = get_terms( array(
	                'taxonomy' => 'project_cat',
	                'hide_empty' => false,
	              ) );
	              if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
					foreach ( $terms as $key=>$term ) { ?>
					<li>
                       <label class="label-container"><?php echo $term->name;?>
                       <input type="checkbox" name="cat" class="search_cat" alt="<?php echo $key;?>"  value="<?php echo $term->term_id;?>">
                       <span class="checkmark"></span>
                       </label>
                    </li>
	              <?php  }
	            }
	     	?>
				 </ul>
				 <input type="hidden" name="post_type" id="post_type" value="project">
              </div>
              <div class="col-md-9 col-sm-8 col" id="main">
                 <div class="submitted-requests">
						<p class="text-right results">
                        <?php if($wp_query->found_posts!=1){
                         _e('Il y a','boxtheme');?> <?php echo $wp_query->found_posts;?> <?php _e('projets','boxtheme');
                        } else {
                         _e('There is','boxtheme');?> <?php echo $wp_query->found_posts;?> <?php _e('project','boxtheme');
                        } ?>
                        
                        </p>
					<?php if( have_posts() ): ?>
                    <ul class="quotes-list" id="ajax_result">
					       <?php   while( have_posts() ): the_post();
									$theid = get_the_id();
                                    $exp = get_field('expired_date');
									if( $exp == '19700101' ) {
										$exp = date('m/d/Y');
									}
									if( is_numeric( $exp ) ) {
										$year = substr( $exp, 0, 4 );
										$mo = substr( $exp, 4, 2 );
										$day = substr( $exp, 6, 2 );
										$exp = $mo . '/'. $day . '/'. $year;
									}
                                    $current_date = date('m/d/Y');
                                    $format = "m/d/Y";
                                    $date1  = DateTime::createFromFormat($format, $current_date);
                                    $date2  = DateTime::createFromFormat('d/m/Y', $exp);
                                    $date2->modify('+30 days');
									if ($date1 < $date2) {
										get_template_part( 'template-parts/project/project', 'loop' );
									} else {
										wp_trash_post($theid);
									} 
								endwhile;
								bx_pagenate();
									?>                               

					</ul>
				<?php else:
									echo '<h3>'.__('You have no projects to display','boxtheme').'</h3>';
								endif;
								wp_reset_query(); ?>
                 </div>
              </div>
           </div>
        </div>
     </div> 
<script type="text/template" data-template="project_template">
    <a href="${url}" class="list-group-item">
        <table>
            <tr>
                <td><img src="${img}"></td>
                <td><p class="list-group-item-text">${title}</p></td>
            </tr>
        </table>
    </a>
</script>
<?php
$premium_type = box_get_premium_types();
?>
<script type="text/html" id="tmpl-search-record">
	
	<li><a href="{{{data.guid}}}">
                                    <header>
                                       <h3>
									   {{{data.post_title}}}
                                       </h3>
                                       <p>Posted a semaine ago</p>
                                    </header>
                                    </a>
                                    <div class="meta-data">
                                       <ul class="list3">
                                          <li>
                                             <i><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/marker.svg" alt="image"></i> 
                                             <address>{{{data.address}}} </address>
                                          </li>
                                          <li><i><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/envelope.svg" alt="image"></i><a href="#">{{{data.mail}}} </a></li>
                                       </ul>
                                    </div>
                                    <div class="description">
                                      <p>{{{data.short_des}}} </p>                                
                                    </div>
                                 </li> <!-- . employer-info !-->
	
</script>
<script type="text/javascript">
	(function($){
		var h_right = $("#right_column").css('height'),
			h_left = $("#sidebar").css('height');
			$(".list-project").css('min-height',h_left);
		if( parseInt(h_left) > parseInt(h_right) ){
			$(".list-project").css('height',h_left);
		}
	})(jQuery);
</script>
<?php  get_footer();
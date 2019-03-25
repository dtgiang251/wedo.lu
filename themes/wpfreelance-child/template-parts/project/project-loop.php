<?php
global $post;
$premium_type = box_get_premium_types();
$project = BX_Project::get_instance()->convert($post);
$priority = get_post_meta( $project->ID , 'priority', true);
//var_dump($priority);
//echo '<pre>';var_dump($project);echo '</pre>';
?>
 <li><a href="<?php echo get_permalink();?>">
                          <header>
                             <h3>
                                <?php echo get_the_title();?>
                             </h3>
                             <p><?php printf(__('Enregistré il y a %s','boxtheme'), human_time_diff( get_the_time('U'), current_time('timestamp') ) );?></p>
                          </header>
                          </a>
                          <div class="meta-data">
                             <ul class="list3">
                                <li>
                                   <i><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/marker.svg" alt="image"></i> 
                                   <address><?php echo get_field('adresse_des_travaux');?></address>
                                </li>
                                <li><i><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/envelope.svg" alt="image"></i><a href="#"><?php echo get_field('votre_mail');?></a></li>
                             </ul>
                          </div>
                          <div class="description">
						  <p><?php echo wp_trim_words( get_the_content(), 62); ?></p>
                          </div>
                       </li>

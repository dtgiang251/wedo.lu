<?php /* Template name: Sub category page */
get_header();?>
<?php   $category = get_query_var( 'categories', '' );  ?>
<?php  $skills = get_query_var( 'skills','' ); 

if($skills):
$skills_object = get_term_by('slug', get_query_var( 'skills') , 'skill');
endif;
?>
<div class="full-width">
        <div class="site-content" id="content">
            <div id="quote-page-head" class="construction">
                <figure class="page-head-image">
                   <?php 
				  
					$term_id = $skills_object->term_id;
					if(get_field('main_banner_image',$skills_object)) {
						$url = get_field('main_banner_image',$skills_object);
					}
					else {
						$term_fr_id = icl_object_id( $term_id, 'skill', true, 'fr' );
						$old_languagle = ICL_LANGUAGE_CODE;
						global $sitepress;
						$sitepress->switch_lang('fr');

						$term_fr = get_term_by('id', $term_fr_id, 'skill');
						
						if(get_field('main_banner_image',$term_fr)) {
							$url = get_field('main_banner_image',$term_fr);
						}
						else {
							$url = get_stylesheet_directory_uri().'/new/assets/images/image7.jpg';
						}
						
						$sitepress->switch_lang( $old_languagle );
					}
				  ?>
                    <img src="<?php echo $url;?>" alt="image">
                </figure>
                <div class="container">
                    <div class="description">
                        <div class="title">
                       
                        <?php 
						if(get_field('page_title_icon',$skills_object)) {
							$url = get_field('page_title_icon',$skills_object);
                        } else {

							$term_fr_id = icl_object_id( $term_id, 'skill', true, 'fr' );
							$old_languagle = ICL_LANGUAGE_CODE;
							global $sitepress;
							$sitepress->switch_lang('fr');

							$term_fr = get_term_by('id', $term_fr_id, 'skill');
							
							if(get_field('page_title_icon',$term_fr)) {
								$url = get_field('page_title_icon',$term_fr);
							}
							else {
								$url = get_stylesheet_directory_uri().'/new/assets/images/home-icon.svg';
							}
							
							$sitepress->switch_lang( $old_languagle );
                        }
						?>
                            <img class="icon" src="<?php echo $url;?>" alt="icon">
                           
                            <h1><?php echo get_field('page_title',$skills_object);?></h1>
                            
                        </div>
                        <hr>
						<?php
							$description = get_field('page_description',$skills_object);
							if( $description ) {
								echo $description;
							}
							else {
								echo '<p>'; echo sprintf( __( '%s: Receive up to 7 free quotes for our luxembourgish artisans.', 'wedo-listing' ), get_field('page_title',$skills_object) ); echo '</p>';
							}
						?>
                    </div>
                </div>
            </div>
            <!-- Drop Your New code-->
            <div class="quote-wrapper">
                <div class="container-fluid default-sidebar">
                    <div class="row">
                        <div class="col-lg-3 col-sm-4" id="sidebar">
                            <div class="widget">
                                <h2><?php _e("How it works",'box-theme');?></h2>
                                <div class="content">
                                    <ul class="list1">
                                        <li class="clearfix step-wrapper">
                                            <figure class="icon">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/settings-icon.svg" alt="icon">
                                            </figure>
                                            <div class="step-details">
                                    <h3><?php _e("Step 1",'box-theme');?></h3>
                                    <p><?php _e("Select a category",'box-theme');?></p>
                                </div>
                                        </li>
                                        <li class="clearfix step-wrapper">
                                            <figure class="icon">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/doc-icon.svg" alt="icon">
                                            </figure>
                                            <div class="step-details">
                                    <h3><?php _e("Step 2",'box-theme');?></h3>
                                    <p><?php _e("Provide details",'box-theme');?></p>
                                </div>
                                        </li>
                                        <li class="clearfix step-wrapper">
                                            <figure class="icon">
                                                <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/sent-icon.svg" alt="icon">
                                            </figure>
                                            <div class="step-details">
                                    <h3><?php _e("Step 3",'box-theme');?></h3>
                                    <p><?php _e("Receive your quotes",'box-theme');?></p>
                                </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <hr>
                            <div class="widget hidden">
                                <h2><?php _e("Finance your work",'box-theme');?></h2>
                                <div class="content">
                                    <form class="calculator-form">
                                        <figure>
                                            <img src="<?php echo get_stylesheet_directory_uri();?>/new/assets/images/logo-bgl.png" alt="logo">
                                        </figure>
                                        <div class="form-group">
                                            <span class="selectbox">
                                    <select>
                                          <option>
                                          <?php _e("Property",'box-theme');?>
                                          </option>
                                          <option>
                                          <?php _e("Property",'box-theme');?>
                                          </option>
                                          <option>
                                          <?php _e("Property",'box-theme');?>
                                          </option>
                                       </select>
                                       </span>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label><?php _e("Amount",'box-theme');?></label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-wrapper">
                                                        <input type="text" placeholder="500.000" name="ageOutputName" id="ageOutputId">
                                                        <span>EUR</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="range" name="InputName" id="ageInputId" value="24" min="1" max="100" oninput="ageOutputId.value = ageInputId.value" step="0.1">

                                        </div>
                                        <div class="form-group ">
                                            <div class="row ">
                                                <div class="col-md-4 ">
                                                    <label><?php _e("Term",'box-theme');?></label>
                                                </div>
                                                <div class="col-md-8 ">
                                                    <div class="input-wrapper">
                                                        <input type="text" placeholder="500.000" name="term" id="termId">
                                                        <span><?php _e("years",'box-theme');?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="range" name="termName" id="termId" value="48" min="1" max="100" oninput="termId.value = termId.value" step="0.1">
                                        </div>
                                        <div class="form-group text-center">
                                            <input type="submit" placeholder="<?php _e('Simulate a loan','box-theme');?>">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-sm-8 " id="main">
                            <form class="quote-form form2" id="submit-project-new">
                            <input type="hidden" value="0" name="ID">
                            <?php  if(get_query_var( 'categories')):
                           $categories = get_term_by('slug', get_query_var( 'categories') , 'project_cat');?>
                           <input type="hidden" value="<?php echo $categories->term_id;?>" name="project_cat">
                           <?php endif; ?>
                          <?php  if(get_query_var( 'skills')):
                           $skills = get_term_by('slug', get_query_var( 'skills') , 'skill');?>
                           <input type="hidden" value="<?php echo $skills->term_id;?>" name="skill">
                           <?php endif; ?>
                           
                                <div class="box1 ">
                                    <h2><?php _e('Déscription de mon projet','boxtheme');?></h2>
                                    <hr>

                                    <div class="row ">
                                        <div class="col-md-12 col">
                                            <div class="form-group">
                                                <label><?php _e('Titre du projet','boxtheme');?></label>
                                                <input class="required" type="text"  tabindex="2" required name="post_title" value="<?php echo !empty($project) ? $project->post_title:'';?>"  placeholder="<?php _e('E.g.: Construction of an industrial building','boxtheme');?> " id="post-title-input">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6 col ">
                                            <div class="form-group ">
                                                <label><?php _e('Describe your project here','boxtheme');?></label>
                                                <textarea name="post_content" tabindex="1" class="required" required placeholder="<?php _e('Describe your project here...','boxtheme');?>"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col ">
                                            <div class="form-group ">
                                                <label><?php _e('Explain the project with an image or document','boxtheme');?></label>
                                                <div id="fileupload-container" >
		   

		      	
		      	<input type="hidden" class="nonce_upload_field" name="nonce_upload_field" value="<?php echo wp_create_nonce( 'box_upload_file' ); ?>" />
		      	<input type="file" name="upload[]" id="sp-upload" multiple="" class="fileupload-input custom-file-input">
		      	<input type="hidden" name="fileset" class="upload-fileset">
		      	<i class='fa fa-spinner fa-spin '></i>
		  	
	 	</div>
	 	<ul class="list-attach"></ul>
	 	<div id="fileupload-error" class="alert alert-error upload-alert fileupload-error hide"><?php _e('You have uploaded this file before','boxtheme');?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="col-md-6 col">
                                            <div class="form-group">
                                                <label><?php _e("Date d'expiration","boxtheme");?></label>
                                                <?php acf_form(array(
													'post_id'		=> 'new_post',
													'fields'        => array('field_5a58256641663'),
													'form' => false,
												)); ?>
												<label for="acf-field_5a58256641663" class="error"></label>
                                            </div>
                                            <div class="form-group acf-field" data-key="field_5ab8ab1066c9e">
                                                <label><?php _e('Adresse email','boxtheme');?></label>
                                                <input type="text" id="acf-field_5ab8ab1066c9e" tabindex="3" name="acf[field_5ab8ab1066c9e]" placeholder="<?php _e('Adresse email','boxtheme');?>" required="required">
                                            </div>
                                            <div class="form-group acf-field" data-key="field_5aa7a8ece3c6d">
                                                <label><?php _e('Adresse des travaux','boxtheme');?></label>
                                                <input type="text" id="acf-field_5aa7a8ece3c6d" tabindex="7" name="acf[field_5aa7a8ece3c6d]" placeholder="<?php _e('Adresse des travaux','boxtheme');?>" required="required">
                                            </div>
                                        </div>
                                        <div class="col-md-6 col">
                                            <div class="form-group acf-field" data-key="field_5ab8aa6eceb92">
                                                <label><?php _e('Votre nom','boxtheme');?></label>
                                                <input type="text" id="acf-field_5ab8aa6eceb92" tabindex="2" name="acf[field_5ab8aa6eceb92]" required="required" placeholder="<?php _e('Votre nom','boxtheme');?>">
                                            </div>
                                            <div class="form-group acf-field" data-key="field_5aafb243b3225">
                                                <label><?php _e('Numéro de téléphone','boxtheme');?></label>
                                                <input type="text" id="acf-field_5aafb243b3225" tabindex="4" name="acf[field_5aafb243b3225]" required="required" placeholder="<?php _e('Numéro de téléphone','boxtheme');?>">
                                            </div>
                                            <div class="form-group">
                                                <label><?php _e('Code','boxtheme');?></label>
                                                <div class="row captcha-row">
                                                    <div class="col-sm-2 ">
                                                       <label id="lcaptcha"></label>
                                                    </div>
                                                    <div class="col-sm-10 ">
                                                        
                                                        <input id="captcha" class="captcha" type="text" name="captcha" maxlength="2" required="required"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-7 ">
                                    <div class="form-group ">
                                        <div>
                                            <label class="label-container"><?php _e("By clicking on 'Send' you confirm that you have read and accepted the General Terms and Conditions.","boxtheme");?>
												<input type="checkbox" name="agree" id="agreement">
												<span class="checkmark"></span>
                                                </label>
                                          <label for="agreement" class="error"></label>
                                        </div>
                                        <div>
                                            <label class="label-container"><?php _e("En soumettant ce formulaire, j'accepte que les informations saisies soient utilisées dans le cadre de la demande de devis et dans la relation commerciale qui peut en découler","boxtheme");?>
												<input type="checkbox" name="radio" id="agreement1">
												<span class="checkmark"></span>
												</label></div>
                                    </div>
                                </div>
                                <div class="col-md-5 text-right ">
                                <?php wp_nonce_field( 'sync_project', 'nonce_insert_project' ); ?>
                                    <input type="submit" class="button-submit" value='<?php _e("Send","boxtheme");?>' disabled>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- /Drop Your New code-->


   
        </div>
    </div>
<?php get_footer();?>
<script>
jQuery(document).ready(function(){
	window.setInterval(function(){
		if( jQuery('.button-submit').attr('user-click') == undefined ) {
			if (jQuery('#agreement').is(':checked') && jQuery('#agreement1').is(':checked') ) {
			   jQuery('.button-submit').prop('disabled', false);
			} else {
				jQuery('.button-submit').prop('disabled', true);
			}
		}
	},200);
	
	jQuery('.button-submit').click(function(){
		jQuery('.button-submit').attr('user-click', 1);
	});
});



jQuery('#agreement , #agreement1').change(function() {
	
	if( jQuery( '#submit-project-new .button-submit' ).attr('first-click') == undefined ) {
		jQuery( '#submit-project-new .button-submit' ).click().attr('first-click', 1);
		jQuery('.button-submit').prop('disabled', true);
	}
	
	if (jQuery('#agreement').is(':checked') && jQuery('#agreement1').is(':checked')) {
	   // Do something...
	   jQuery('.button-submit').prop('disabled', false);
	} else {
		jQuery('.button-submit').prop('disabled', true);
	}
  });
</script>
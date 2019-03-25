<?php
/**
 * Job Submission Form
 */
if ( ! defined( 'ABSPATH' ) ) exit;

global $job_manager;

$wrap_in_block = apply_filters('case27_job_submit_wrap_in_block', false);
?>
<?php /* if(isset($_GET['action']) && $_GET['action']=="edit"){ ?>
<?php  $languages = icl_get_languages('skip_missing=1');?>
			    <div class="language-selector">
				<?php foreach($languages as $l){ 
					if($l['active']){ 
					?>
							<?php $active_url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-selected.png';
							} elseif($l['language_code']=="fr"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-selected.png';
							}elseif($l['language_code']=="de"){
								$active_url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-selected.png';
							}

							?>
							<span><img src="<?php echo $active_url;?>"></span>
				<?php } }?>
               <ul>
			   <?php foreach($languages as $l){ ?>
				<?php $url = $l['country_flag_url'];
							if($l['language_code']=="en"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/english-unselected.png';
							} elseif($l['language_code']=="fr"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/french-unselected.png';
							}elseif($l['language_code']=="de"){
								$url = get_stylesheet_directory_uri().'/header-assets/langauge-icons/german-unselected.png';
							}

							if($l['active']){
								$url = $active_url;
							}
                         ?>
						
					<li <?php if($l['active']){ echo 'class="active hidden-lg"';}?>><a href="<?php echo $l['url'];?>?action=edit&job_id=<?php echo apply_filters( 'wpml_object_id', $_GET['job_id'], 'job_listing', FALSE, $l['language_code'] );?>"><img src="<?php echo $url;?>"></a></li>
			 <?php   }?>
                </ul>
                            </div>
						<?php } */?>
<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-job-form" class="job-manager-form light-forms c27-submit-listing-form" enctype="multipart/form-data">
	<?php if ($wrap_in_block): ?>
		<section class="i-section">
			<div class="container">
				<div class="row section-body reveal reveal_visible">
					<div class="col-md-8 col-sm-12 col-md-offset-2">
						<div class="element">
							<div class="pf-head round-icon">
								<div class="title-style-1">
									<i class="icon-pencil-2"></i>
									<h5><?php echo apply_filters('case27_job_submit_title', __( 'Add a Listing', 'my-listing' )) ?></h5>
								</div>
							</div>
							<div class="pf-body">
							<?php endif ?>

								<?php do_action( 'submit_job_form_start' ); ?>

								<?php if ( apply_filters( 'submit_job_form_show_signin', true ) ) : ?>

									<?php get_job_manager_template( 'account-signin.php' ); ?>

								<?php endif; ?>

								<?php if ( job_manager_user_can_post_job() || job_manager_user_can_edit_job( $job_id ) ) : ?>

									<!-- Job Information Fields -->
									<?php do_action( 'submit_job_form_job_fields_start' ); ?>

									<?php foreach ( $job_fields as $key => $field ) : ?>

										<?php if ( $field['type'] == 'form-heading' ): ?>
											<?php if ( $wrap_in_block ): ?>
												</div></div></div></div></div></section>
												<section class="i-section add-listing-next-section">
													<div class="container">
														<div class="row section-body reveal reveal_visible">
															<div class="col-md-8 col-sm-12 col-md-offset-2">
																<div class="element">
																	<?php if ( ! empty( $field['icon'] ) && ! empty( $field['label'] ) ): ?>
																		<div class="pf-head round-icon">
																			<div class="title-style-1">
																				<i class="<?php echo esc_attr( $field['icon'] ) ?>"></i>
																				<h5><?php echo esc_html( $field['label'] ) ?></h5>
																			</div>
																		</div>
																	<?php endif ?>
																	<div class="pf-body">
											<?php else: ?>
												<?php if ( ! empty( $field['label'] ) ): ?>
													<div class="listing-form-heading">
														<?php echo esc_html( $field['label'] ) ?>
													</div>
												<?php endif ?>
											<?php endif ?>
										<?php else: ?>
											<div class="fieldset-<?php echo esc_attr( $key ); ?> form-group">
												<label for="<?php echo esc_attr( $key ); ?>"><?php echo $field['label'] . apply_filters( 'submit_job_form_required_label', $field['required'] ? '' : ' <small>' . __( '(optional)', 'my-listing' ) . '</small>', $field ); ?></label>
												<div class="field <?php echo $field['required'] ? 'required-field' : ''; ?>">
													<?php get_job_manager_template( 'form-fields/' . $field['type'] . '-field.php', array( 'key' => $key, 'field' => $field ) ); ?>
												</div>
											</div>
										<?php endif ?>
									<?php endforeach; ?>

									<?php do_action( 'submit_job_form_job_fields_end' ); ?>

									<?php do_action( 'submit_job_form_end' ); ?>

									<p style="height: 46px;">
										<input type="hidden" name="job_manager_form" value="<?php echo esc_attr( $form ); ?>" />
										<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
										<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
										<input type="submit" name="submit_job" class="button buttons button-2 full-width button-animated" value="<?php echo esc_attr( $submit_button_text ); ?>" />
									</p>

								<?php else : ?>

									<?php do_action( 'submit_job_form_disabled' ); ?>

								<?php endif; ?>

							<?php if ($wrap_in_block): ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif ?>
</form>

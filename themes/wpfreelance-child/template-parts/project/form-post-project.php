<?php
$p_id = isset($_GET['p_id']) ? $_GET['p_id'] : 0;
$project = array();
$lbl_btn = __('Post Job Now','boxtheme');
$skills = $cat_ids =$skill_ids = array();

?>
<div class="quote-wrapper">
<div id="quote-banner">

        <img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/pagehead12.jpg" alt="image">
        <!--<div class="container">
            <div class="description">
                    <h2>Obtenir un devis pour votre projet</h2>
            </div>
        </div>--> 

</div>
          <div class="container">
    <div class="get-in-touch">
        
        <div class="row">
            
            <div class="col-sm-12">
  
        <h2><?php _e('Demandez des devis pour tous vos projets sur wedo.lu','boxtheme');?></h2>
        <h3><?php _e('Sur wedo.lu vous pouvez entrer en relation avec:','boxtheme');?></h3>
            </div>
</div>
                <div class="row">
            
            <div class="col-sm-6">
              <div class="inner">  
                
                <ul class="list">
                <li>
                    
				<?php _e('des entreprises artisanales de tous les secteurs','boxtheme');?></li>
                        <li><?php _e('des entreprises de proximité','boxtheme');?></li>
                        <li><?php _e('des entreprises employant du personnel qualifié','boxtheme');?></li>
                        <li><?php _e('des entreprises offrant toutes les garanties légales','boxtheme');?></li>
                        <li><?php _e('des entreprises socialement responsables','boxtheme');?></li>
                    
                    
                </ul>
                
                    </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="inner">
                        <p>
                        <?php _e('Nous vous proposons de vous limiter à 3 devis par demande d’offre. Les entreprises s’efforcent de vous offrir des produits et prestations de qualité à un prix juste.','boxtheme');?>
                        </p>
                        </div>
                    </div>
        </div>
        
    </div>
    </div>

<div class="quote-step">
        <div class="container">
            <h2><?php _e('Comment ça marche','boxtheme');?></h2>
            <ul class="clearfix">
                <li>
                    <span class="number">1</span>
                    <figure><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/icon9.svg" alt="image"></figure>
                    <p><?php _e('Je décris','boxtheme');?></p>
                    <p><?php _e('Je décris mon projet de travaux','boxtheme');?></p>
                </li>

                <li>
                        <span class="number">2</span>
                        <figure><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/icon10.svg" alt="image"></figure>
                        <p><?php _e('Je reçois','boxtheme');?></p>
                        <p><?php _e('Je reçois des devis de professionnels','boxtheme');?></p>
                    </li>

                    <li>
                            <span class="number">3</span>
                            <figure><img src="<?php echo trailingslashit( get_stylesheet_directory_uri() );?>assets/images/icon11.svg" alt="image"></figure>
                            <p><?php _e('Je compare','boxtheme');?></p>
                            <p><?php _e('Je compare mes offres et je choisis la plus intéressantee','boxtheme');?></p>
                        </li>                    
            </ul>
        </div>
</div>


<form id="submit_project" class="frm-submit-project quote-form" >
<?php
	$id_field =  '<input type="hidden" value="0" name="ID" />'; // check insert or renew
	if($p_id){
		global $user_ID;
		$project = get_post($p_id);

		if( $project && $user_ID == $project->post_author ){ // only author can renew or view detail of this project

			$project = BX_Project::get_instance()->convert($project);
			$lbl_btn = __('Renew Your Job','boxtheme');


			$skills = get_the_terms( $project, 'skill' );

			if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){
				foreach ( $skills as $skill ) {
				  	$skill_ids[] = $skill->term_id;
				}
			}

			$cats = get_the_terms( $project, 'project_cat' );

			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){
				foreach ( $cats as $cat ) {
				  	$cat_ids[] = $cat->term_id;
				}

			}
			$id_field = '<input type="hidden" value="'.$p_id.'" name="ID" />';
		}
	}
	echo $id_field;


	$symbol = box_get_currency_symbol( ); ?>
    <div class="project-info">
        <div class="container">
            <h2 class="text-center"><?php if( ! $p_id){  _e('Détails sur mon projet','boxtheme');} else { _e('Renew project','boxtheme'); } ?></h2>
            <hr>
            <h3><?php _e('Catégories','boxtheme');?></h3>
            <h4><?php _e('Selectionnez une catégorie:','boxtheme');?></h4>
			
					
			<?php
				$pcats = get_terms( array(
					'taxonomy' => 'project_cat',
					'hide_empty' => false,
					)
				);
				if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){ ?>
            <ul class="categories-list clearfix">
			<?php foreach ( $pcats as $cat ) {
			$selected = '';
			if( in_array($cat->term_id, $cat_ids) ){
			$selected = 'select';
			} ?>
                <li class="<?php echo $selected;?>">
                    <div class="wrapper">
                        <input type="radio" class="radio-project" name="project_cat"  value="<?php echo $cat->term_id;?>" hidden />
                        <img class="svg-inject" src="<?php echo get_field('icon_image',$cat);?>" alt="image"> 
                        <p><?php echo $cat->name;?></p>
						<input type="hidden" value="<?php echo $cat->name;?>" class="category-name" />
                   </div>
                </li>
		<?php } ?>
             </ul>
			<?php } ?>
			<label for="project_cat" class="error"></label>
			 <hr>
			</div>
			 <?php
	      
	           
	              
	       ?>
		   <?php  	$skills = get_terms(
	       		array(
	           		'taxonomy' => 'skill',
	           		'hide_empty' => false,
	          	)
	       	);
		   if ( ! empty( $skills ) && ! is_wp_error( $skills ) ) { ?>
			<div class="sub-category">
					<div class="container">
             <div class="row">
                 <div class="col-sm-5">
                        <h4><?php _e('Sélectionnez une sous-catégorie:','boxtheme');?></h4>
                 </div>
                 <div class="col-sm-7">
				 <div class="choosen-container skill-selction">
                            <select name="skill" class="chosen-select" required id="skill-select" multiple  data-placeholder="<?php _e('Sélectionnez une sous-catégorie','boxtheme');?>" data-no_results_text="<?php _e('No results match','boxtheme');?>">
						<?php 	foreach ( $skills as $skill ) {
								$selected = '';
									if( in_array($skill->term_id, $skill_ids) ){
										$selected = 'selected';
									} 
                                	echo '<option '.$selected.' value="' . $skill->slug . '">' . $skill->name . '</option>';
	            } ?>
                            </select>
                     </div>
                 </div>
                
			 </div>
			</div>
		</div>
		   <?php  } ?>

        
    </div>
    <div class="project-description">
            <div class="container">
                    <h3><?php _e('Déscription de mon projet','boxtheme');?></h3>

                    <div class="row">
                            <div class="col-sm-6">
                                    <div class="form-group">
                                            <label class="textarea-label"><?php _e('Décrivez brièvement votre projet (type de construction, type de projet, surface, ...)','boxtheme');?></label>
										<textarea name="post_content" tabindex="1" class="required" required placeholder="<?php _e('Describe your project here...','boxtheme');?>"><?php echo !empty($project) ? $project->post_content :'';?></textarea>
										
                                        </div>  
                            </div>
                            <div class="col-sm-6">
                                <label><?php _e('Add any image or document that might be useful to explain your project description.','boxtheme');?></label>
                            
												
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


                    <div class="row">
                        <div class="col-sm-6">
						<div class="form-group">
                                        <label><?php _e('Titre du projet','boxtheme');?></label>
								  <input class="required" type="text"  tabindex="2" required name="post_title" value="<?php echo !empty($project) ? $project->post_title:'';?>"  placeholder="<?php _e('E.g.: Construction of an industrial building','boxtheme');?> " id="post-title-input">
                                    </div>  

        <div class="form-group acf-field" data-key="field_5ab8ab1066c9e">
                <label><?php _e('Adresse email','boxtheme');?></label>
		        <input type="text" id="acf-field_5ab8ab1066c9e" tabindex="3" name="acf[field_5ab8ab1066c9e]" placeholder="<?php _e('Adresse email','boxtheme');?>" required="required">
			</div>   
			
			<div class="form-group acf-field" data-key="field_5ad89be93293b">
                <label><?php _e('Votre adresse','boxtheme');?></label>
		        <input type="text" id="acf-field_5ad89be93293b" tabindex="5" name="acf[field_5ad89be93293b]" placeholder="<?php _e('Votre adresse','boxtheme');?>" required="required">
            </div>   
            


                        </div>
                        <div class="col-sm-6">
						        <div class="form-group acf-field" data-key="field_5ab8aa6eceb92" >	
	                            <label><?php _e('Votre nom','boxtheme');?></label>
								<input type="text" id="acf-field_5ab8aa6eceb92" tabindex="2" name="acf[field_5ab8aa6eceb92]" required="required" placeholder="<?php _e('Votre nom','boxtheme');?>">
								</div>   
                            
                                    <div class="form-group acf-field" data-key="field_5aafb243b3225">
                                            <label><?php _e('Numéro de téléphone','boxtheme');?></label>
									  <input type="text" id="acf-field_5aafb243b3225" tabindex="4" name="acf[field_5aafb243b3225]" required="required" placeholder="<?php _e('Numéro de téléphone','boxtheme');?>">
                                        </div>   
                                        <div class="form-group">
                                                <label><?php _e("Date d'expiration","boxtheme");?></label>
												<?php acf_form(array(
													'post_id'		=> 'new_post',
													'fields'        => array('field_5a58256641663'),
													'form' => false,
												)); ?>
												<label for="acf-field_5a58256641663" class="error"></label>
                                            </div>                                   
                                                        </div>
                                
					</div>
					<div class="row">
						<div class="col-md-12">
						<div class="form-group acf-field" data-key="field_5aa7a8ece3c6d">
                          <label><?php _e('Adresse des travaux','boxtheme');?></label>
			              <input type="text" id="acf-field_5aa7a8ece3c6d" tabindex="7" name="acf[field_5aa7a8ece3c6d]" placeholder="<?php _e('Adresse des travaux','boxtheme');?>" required="required">
                         </div>   
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
						<p><input type="checkbox" name="agree" id="agreement" tabindex="8"><?php _e("By clicking on 'Send' you confirm that you have read and accepted the General Terms and Conditions.","boxtheme");?></p>
							<label for="agreement" class="error"></label>
							
                        </div>
                        <div class="col-sm-5 text-right">
							
                        </div>
                    </div>
					
                    <div class="row">
						<div class="col-sm-7">
                            <p><input type="checkbox" name="checkbox2" required="required" id="checkbox-2" tabindex="9" value="1"><?php _e("En soumettant ce formulaire, j'accepte que les informations saisies soient utilisées dans le cadre de la demande de devis et dans la relation commerciale qui peut en découler","boxtheme");?></p>
							<label for="checkbox-2" class="error"></label>
                        </div>
                        <div class="col-sm-5 text-right">
							<?php wp_nonce_field( 'sync_project', 'nonce_insert_project' ); ?>
							<button type="submit" class="btn btn-action no-radius btn-submit" tabindex="10" disabled><?php _e("Send","boxtheme");?> &nbsp; <i class="fa fa-spinner fa-spin"></i></button>
                        </div>
                    </div>



            </div>
        </div>
</form>
</div> 


<?php /*<form id="submit_project" class="frm-submit-project">

	<?php
	$id_field =  '<input type="hidden" value="0" name="ID" />'; // check insert or renew
	if($p_id){
		global $user_ID;
		$project = get_post($p_id);

		if( $project && $user_ID == $project->post_author ){ // only author can renew or view detail of this project

			$project = BX_Project::get_instance()->convert($project);
			$lbl_btn = __('Renew Your Job','boxtheme');


			$skills = get_the_terms( $project, 'skill' );

			if ( ! empty( $skills ) && ! is_wp_error( $skills ) ){
				foreach ( $skills as $skill ) {
				  	$skill_ids[] = $skill->term_id;
				}
			}

			$cats = get_the_terms( $project, 'project_cat' );

			if ( ! empty( $cats ) && ! is_wp_error( $cats ) ){
				foreach ( $cats as $cat ) {
				  	$cat_ids[] = $cat->term_id;
				}

			}
			$id_field = '<input type="hidden" value="'.$p_id.'" name="ID" />';
		}
	}
	echo $id_field;


	$symbol = box_get_currency_symbol( );
	?>
	
	<div class="form-group ">
	 	<h1 class="page-title"><?php if( ! $p_id){ the_title();} else { _e('Renew project','boxtheme'); } ?></h1>
	</div>
	<?php do_action('box_post_job_fields',$project);?>
	<div class="form-group">
		<label for="post-title-input" class="col-3  col-form-label"><?php _e('PROJECT NAME:','boxtheme');?></label>
		<input class="form-control required" type="text" required name="post_title" value="<?php echo !empty($project) ? $project->post_title:'';?>"  placeholder="<?php _e('Ex: Build a website','boxtheme');?> " id="post-title-input">
	</div>

	<div class="form-group" id="budget_field">
	 	<label for="budget-text-input" class="col-3  col-form-label"><?php printf(__('What budget do you have in mind(%s)?','boxtheme'), '<small>'.$symbol.'</small>');?></label>
	 	<input class="form-control" type="number" step="any" value="1" required name="<?php echo BUDGET;?>"   placeholder="<?php printf(__('Set your budget here(%s)','boxtheme'), $symbol);?> " id="budget-text-input">
	</div>
	<div class="form-group ">
	

<select id="v_skill" style="display:none;">
  <option value="blank">&nbsp;</option>
</select>

	 	<label for="example-text-input" class="col-form-label"><?php _e('What type of work do you require?','boxtheme');?></label>

		 <select id="v_cat">
			<option value="Construction & rénovation">Select a category</option>
			<option value="Construction & rénovation">Construction & rénovation</option>
			<option value="Alimentation & événements">Alimentation & événements</option>
			<option value="Communication & multimedia">Communication & multimedia</option>
			<option value="Location">Location</option>
			<option value="Mode & santé">Mode & santé</option>
			<option value="Garagistes & mécanique">Garagistes & mécanique</option>
		</select>

	 	<select class="form-control required chosen-select" id="kolokithi" multiple name="project_cat"  data-placeholder="<?php _e('Select a category of work (optional)','boxtheme');?> ">
		    <?php
				$pcats = get_terms( array(
					'taxonomy' => 'project_cat',
					'hide_empty' => false,
					)
				);
				if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){
					foreach ( $pcats as $cat ) {
						$selected = '';
						if( in_array($cat->term_id, $cat_ids) ){
							$selected = 'selected';
						}
				   		echo '<option '.$selected.' value="' . $cat->term_id . '">' . $cat->name . '</option>';
					}
 				}
		    ?>
	 	</select>
	</div>

	<div class="form-group ">
	    <label for="skills-text-input" class="col-form-label"><?php _e('WHAT SKILLS ARE REQUIRED?','boxtheme');?></label>
	    <select id="skill_select" class="form-control required chosen-select" name="skill" required  multiple data-placeholder="<?php _e('What skills are required?','boxtheme');?> ">
	       	<?php
	       	$skills = get_terms(
	       		array(
	           		'taxonomy' => 'skill',
	           		'hide_empty' => false,
	          	)
	       	);
	       if ( ! empty( $skills ) && ! is_wp_error( $skills ) ) {
	            foreach ( $skills as $skill ) {
	            	$selected = '';
						if( in_array($skill->term_id, $skill_ids) ){
							$selected = 'selected';
						}
	              	echo '<option '.$selected.' value="' . $skill->slug . '">' . $skill->name . '</option>';
	            }
	        }
	       ?>
	    </select>
	</div>

	<div class="form-group ">
	 	<label for="example-text-input" class="col-3  col-form-label"><?php _e('DESCRIBE YOUR PROJECT','boxtheme');?></label>
	 	<textarea name="post_content" class="form-control required no-radius" required rows="6" cols="43" placeholder="<?php _e('Describe your project here...','boxtheme');?>"><?php echo !empty($project) ? $project->post_content :'';?></textarea>
	</div>
	<?php //do_action('box_post_job_fields',$project);?>
	<?php do_action('box_add_milestone_html',$project);?>
	<div class="form-group ">
	 	<div id="fileupload-container" class="file-uploader-area">
		    <span class="btn btn-plain btn-file-uploader border-color ">

		      	<span class="fl-icon-plus"></span>
		      	<input type="hidden" class="nonce_upload_field" name="nonce_upload_field" value="<?php echo wp_create_nonce( 'box_upload_file' ); ?>" />
		      	<span id="file-upload-button-text " class="text-color"><i class="fa fa-plus text-color" aria-hidden="true"></i> <?php _e('Upload Files','boxtheme');?></span>
		      	<input type="file" name="upload[]" id="sp-upload" multiple="" class="fileupload-input">
		      	<input type="hidden" name="fileset" class="upload-fileset">
		      	<i class='fa fa-spinner fa-spin '></i>
		  	</span>

	  		<p class="file-upload-text txt-term"><?php _e('Drag drop any images or documents that might be helpful in explaining your project brief here','boxtheme');?></p>

	 	</div>
	 	<ul class="list-attach"></ul>
	 	<div id="fileupload-error" class="alert alert-error upload-alert fileupload-error hide"><?php _e('You have uploaded this file before','boxtheme');?></div>

	</div>

	<!-- 1.1 !-->
	<?php
	wp_reset_query();
	global $box_currency;
	$symbol = box_get_currency_symbol($box_currency->code);
	$args = array(
                'post_type' => '_package',
                'meta_key' => 'pack_type',
                'meta_value' => 'premium_post'
            );
        $list_package = array();
        $the_query = new WP_Query($args);

        // The Loop
        if ( $the_query->have_posts() ) { 	?>
			<div class="form-group step">
				<label for="example-upgrade-fields" class="col-3  col-form-label"><?php _e('Optional Upgrades','boxtheme');?></label>
				<ul class="none-style ul-pack-type">
					<?php  while ( $the_query->have_posts() ) {

						$the_query->the_post();
						global $post;
						$price = get_post_meta(get_the_ID(),'price', true);
						$post->price = $price;
						$list_package[$post->ID] = $post;
						?>
						<li class="pack-type-item">
							<div class="col-md-1"><img src="https://www.f-cdn.com/assets/img/ppp/standard-project-icon-08417247.svg"></div>

							<div class="col-md-9">
								<label class="pay-type">
									<input type="radio" name="premium_post" class="input-pack-type " value="<?php the_ID();?>"> <?php the_title();?>
									<p class="UpgradeListing-desc  pack-type-desc"><?php the_content();?></p>
								</label>
							</div>
							<div class="col-md-2 text-right pack-price">
				                <span class="currency-sign"><?php echo $symbol;?></span><span id="featured-upgrade-price" data-robots="FeaturedUpgradePrice"><?php echo $price;?></span>
							</div>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	<!-- End 1.1 !-->
	<?php wp_nonce_field( 'sync_project', 'nonce_insert_project' ); ?>
	<div class="form-group row">

	 	<div class="col-md-7">
	    	<span class="txt-term"><?php _e("By clicking 'Post Job Now', you are indicating that you have read and agree to the Terms & Conditions and Privacy Policy","boxtheme");?></span>
	    </div>
	 	<div class="col-md-5 align-right pull-right">
	    	<button type="submit " class="btn btn-action no-radius btn-submit"><?php echo $lbl_btn;?> &nbsp; <i class="fa fa-spinner fa-spin"></i></button>
	 	</div>
	</div>
</form> */ ?>
<script type="text/template" id="json_packages"><?php   echo json_encode($list_package); ?></script>
<script>
jQuery(document).ready(function ($) {
	$('.hasDatepicker').attr('tabindex',6);
	$('#kolokithi_chosen, #skill_select_chosen').hide();
	$('#skill_select').show();
	$(".chosen-select").chosen({no_results_text: "Translated No results matched"});
	
	$( "#kolokithi" ).change(function() {
  		//console.log($('#kolokithi').val());
		console.log($( "#kolokithi option:selected" ).text());
	});

	var lookup = {
		<?php
				$pcats = get_terms( array(
					'taxonomy' => 'project_cat',
					'hide_empty' => false,
					)
				);
				if ( ! empty( $pcats ) && ! is_wp_error( $pcats ) ){ ?>
				<?php foreach ( $pcats as $cat ) { ?>
				'<?php echo $cat->name;?>': [<?php if(get_field('skills',$cat)){ $skills = get_field('skills',$cat); foreach($skills as $skill){ ?>"<?php echo $skill->name;?>",<?php } } ?>],
		<?php } } ?>
		
   
	};

	$('#v_cat').on('change', function() {
	
	var selectValue = $(this).val();
	$('#skill_select').empty();
	for (i = 0; i < lookup[selectValue].length; i++) {
		$('#skill_select').append("<option value='" + lookup[selectValue][i] + "'>" + lookup[selectValue][i] + "</option>");
	}
	
	//$('#skill_select').show();
	
	});

	$('#skill_select').on('change', function() {
	//alert($('#skill_select option:selected').text());
	
	});

	$('.categories-list li').on('click', function() {
	$('.categories-list li').removeClass('select');
	$(this).addClass('select');
	$(this).find('.radio-project').prop("checked", true);
	var selectValue = $(this).find('.category-name').val();
	selectValue = selectValue.replace("&", "&amp;");
	$('#skill-select').empty();
	for (i = 0; i < lookup[selectValue].length; i++) {
		$('#skill-select').append("<option value='" + lookup[selectValue][i] + "'>" + lookup[selectValue][i] + "</option>");
	}
	$('.chosen-select').trigger("chosen:updated");
	//$('#skill_select').show();
	
	});

	$('[name="agree"]').change(function()
      {
        if ($(this).is(':checked')) {
           // Do something...
           $('.btn-submit').prop('disabled', false);
        } else {
			$('.btn-submit').prop('disabled', true);
		}
      });

});
</script>
<style>
select#skill_select {
    height: 250px;
}
select#v_cat {
    display: inline-block;
    width: 100%;
    padding: 5px;
}
</style>
<?php
/**
 *	Template Name: Map Template
 */
get_header(); ?>
			<div class="left-search-bar col-md-4 no-padding-right">
				<div class="job_listings">
					<form class="job_filters">
						<div class="col-md-12"><center><h1><?php _e('Search a freelancer nearby location','boxtheme');?> </h1></center> <br /></div>
						<div class="search_jobs form-row">

							<div class="search_keywords col-md-7">
								<input type="text" name="keywords" class="form-control" id="search_keywords" placeholder="<?php _e('Keyword','boxtheme');?>" value="">
							</div>


							<div class="geo_address col-md-5 no-padding-left">
								<input type="text" class="form-control required" required  name="geo_address" id="autocomplete"  onFocus="geolocate()"  placeholder="<?php _e('Address ...','boxtheme');?>" value="" ><i class="fa fa-map-marker" aria-hidden="true"></i>
								<input type="hidden" name="lat_geo" id="lat_geo">
								<input type="hidden" name="lng_geo" id="lng_geo">
                <input type="hidden" name="short_name" id="short_name">
                <input type="hidden" name="long_name" id="long_name">
							<i class="locate-me"></i></div>

						</div>
						<div class="search_jobs form-row">
							<div class="search_keywords col-md-12">
								<?php box_tax_dropdown('skill', __('Enter skills','boxtheme') );?>
							</div>

						</div>

						<div class="search-radius-wrapper in-use full">
							<div class="search-radius-label full">
								<div class="col-md-12"><input type="text" name="distance" id="range_02"></div>
								<div class="col-md-12"><label><?php _e('Radius:','boxtheme');?></label> <label style="float:right"> <?php _e('< 1000 Miles','boxtheme');?> </label></div>
							</div>

						</div>
						<div class="col-md-12 " style="text-align: center; "><button type="submit" class="search-btn" id="update_results"><?php _e('Search','boxtheme');?></button></div>
					</form>
					<div class="result_filter">
						<div class="col-md-12">
								<?php
                  //map_remove_all_sample();
                  //insert_markers_sample();
									global $wpdb;
									$sql = " SELECT p.ID , p.post_title, p.post_author, ex.* FROM wp_posts p  LEFT JOIN {$wpdb->prefix}profile_extra ex on ex.profile_id = p.ID WHERE 1 = 1 AND  p.post_type = 'profile' AND post_status = 'publish'  GROUP BY p.ID ";
                  $markers = array();
									$results = $wpdb->get_results($sql);
									$text_result = __( 'No freelancer found.','boxtheme');

									if( $results ){
                    $text_result = sprintf(__(' %s freelancers found.','boxtheme'), $wpdb->num_rows );
										foreach ($results as $profile) {

												$skill_html = get_skill_html_profile($profile->ID);
												$professional_title = get_post_meta($profile->ID, 'professional_title', true);
												$marker['html'] = '<div class="user-marker"><div class="marker-avatar half-left">'.get_avatar($profile->post_author).'</div><div class="half-right half"><h2>'.$profile->post_title.'</h2><h3>'.$professional_title.'</h3><div class="full mk-skils">'.$skill_html.'</div></div>';
												$marker['lat_geo'] = $profile->lat_geo;
												$marker['lng_geo'] = $profile->lng_geo;
                        $marker['title'] = $profile->post_title;
												$markers[] = $marker;
										}
									}

								?>
							<p id="text_result"><?php echo $text_result;?></p>
						</div>
					</div>
				</div>
			</div>	<!-- en left search bar !-->
		<div  class="col-md-8" id="bmap" ></div>

     <?php get_template_part( 'modal/mobile', 'login' ); ?>
    <?php wp_footer();?>
</body>
 <script>
     var placeSearch, autocomplete;
      var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };

      function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

      function fillInAddress() {
      	console.log('fillInAddress');
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

        	var lat = place.geometry.location.lat();
		    var lng = place.geometry.location.lng();
		    document.getElementById('lat_geo').value = lat;
		    document.getElementById('lng_geo').value = lng;


        for (var component in componentForm) {
          document.getElementById(component).value = '';
          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
          if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;
          }
        }
      }

      // Bias the autocomplete object to the user's geographical location,
      // as supplied by the browser's 'navigator.geolocation' object.
      function geolocate() {
      	console.log('geolocate');
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

    </script>

<script src="//maps.google.com/maps/api/js?key=AIzaSyAqUWzOJHKpZ7VW_oEivFqtTP0A87d3cfM&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script type="text/template" id="json_list_profile"><?php echo json_encode($markers); ?></script>

  <style type="text/css">
  	.user-marker{
  		display: block;
  		width: 359px; overflow: hidden;
  		padding: 10px 0;
  		font-family: 'Raleway', sans-serif;
  	}
  	.user-marker .marker-avatar img{
  		max-width: 100px;
  		height: auto;
  		border:1px solid #f1f1f1;
  	}
	.user-marker .half-left {
	    width: 100px;
	    float: left;

	}
  	.user-marker .half-right{
  		width: 259px;
  		float: left;
  		padding-left: 15px;
  	}
  	.user-marker h2,.user-marker h3{
  		margin:0; padding: 0;     white-space: nowrap; text-overflow: ellipsis;
  		font-weight: bold;
  	}

  	.user-marker h2{
  		font-size: 16px;
  	}
  	.user-marker h3{
  		font-size: 15px;
  		padding-top: 5px;
  	}
  	.mk-skils{
  		margin-top: 10px;
  		font-size: 14px;
  	}
  	.job_filters{
  		clear: both;
  		display: block;
  		width: 100%;
  		float: left;
  	}
  	.job_filters .form-control{
  		margin-bottom: 25px;
  		height: 42px;
  		border-radius: 5px;
  		width: 100%;

  	}
  	body .chosen-container-multi .chosen-choices{
  		min-height: 39px; border-radius: 5px;

  	}
  	.chosen-container{
  		width: 100% !important;
  	}
  	.search-btn {
	    background: rgb(30, 159, 173);
	    margin-top: 40px;
	    width: 420px;
	    height: 50px;
	    border: none;
	    border-radius: 30px;
	    color: #FFF;
	    text-align: center;
	    box-shadow: 0 0 20px 0 #b0d6f4;
	}
	.irs-line{
		background: #eee;
	}
	.irs-bar-edge{
		background: rgb(30, 159, 173);
	}
	.result_filter {
	    border-top: 1px solid #ccc;
	    margin-top: 38px;
	    padding-top: 40px;
	    width: 100%;
	    float: left;
	    clear: both;
	}
	body{
		background: #fff !important;
	}
  </style>
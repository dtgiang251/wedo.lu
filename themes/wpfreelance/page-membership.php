 <?php
/**
 * Template Name: Member Ship
*/
get_header();
$step =1 ;
$current_step1 = 'current';
$current_step2 = '';
if ( is_user_logged_in() ){
  $step = 2;
  $current_step2 = 'current';
  $current_step1 = '';

}

?>
 	<!-- List job !-->
    <div class="container site-container membership">
        
    
        <div id="main_signup" class="sign-block col-xs-12 ">
           <div class="form-row">
                    <div class="col-md-12">
                        <div class="setup-header setup-org">
                        <h1><?php _e('Join Us Now','boxtheme');?></h1>
                        <p class="lead"><?php _e('The best way to get job, work, and earn money.','boxtheme');?></p>

                        <!-- Show steps if user is creating an organiation -->
                          <ol class="steps">
                            <li class="nav-register <?php echo $current_step1;?>">
                              <svg height="32" class="octicon octicon-person" viewBox="0 0 12 16" version="1.1" width="24" aria-hidden="true"><path fill-rule="evenodd" d="M12 14.002a.998.998 0 0 1-.998.998H1.001A1 1 0 0 1 0 13.999V13c0-2.633 4-4 4-4s.229-.409 0-1c-.841-.62-.944-1.59-1-4 .173-2.413 1.867-3 3-3s2.827.586 3 3c-.056 2.41-.159 3.38-1 4-.229.59 0 1 0 1s4 1.367 4 4v1.002z"></path></svg>
                              <?php _e('<strong class="step">Step 1:</strong>Create personal account','boxtheme');?>
                            </li>
                            <li class="nav-checkout <?php echo $current_step2;?>"">
                              <svg height="32" class="octicon octicon-versions" viewBox="0 0 14 16" version="1.1" width="28" aria-hidden="true"><path fill-rule="evenodd" d="M13 3H7c-.55 0-1 .45-1 1v8c0 .55.45 1 1 1h6c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 8H8V5h4v6zM4 4h1v1H4v6h1v1H4c-.55 0-1-.45-1-1V5c0-.55.45-1 1-1zM1 5h1v1H1v4h1v1H1c-.55 0-1-.45-1-1V6c0-.55.45-1 1-1z"></path></svg>
                              <?php _e('<strong class="step">Step 2:</strong>Checkout','boxtheme');?>  </li>
                          
                          </ol>
                    </div>
                  </div>
                </div>
              
              <div class="step <?php echo $current_step1; ?> full step-1 step-register">
                <form class="frm-signup col-md-8 no-padding-left"  id="signup" >
                  <div id="loginErrorMsg"  class="loginErrorMsg alert alert-error alert-warning hide">

                  </div>
                  <div class="form-row">
                      <label class="col-md-12"><?php _e('Username','boxtheme');?></label>
                      <div class="col-md-12">
                          <input type="text" class="form-control" name="user_login" id="user_login" required >
                      </div>
                  </div>
                  <div class="form-row">
                    <label class="col-md-12"><?php _e('Email address','boxtheme');?> </label>
                      <div class="col-md-12">
                          <input type="email" class="form-control" id="user_email" required name="user_email">
                      </div>
                  </div>
                  <input type="hidden" name="is_membership" value="1">

                  <div class="form-row">
                    <label class="col-md-12"><?php _e('Password','boxtheme');?> </label>
                      <div class="col-md-12">
                        
                          <input type="password" class="form-control" id="user_pass" required name="user_pass">
                      </div>
                  </div>
                  <?php signup_nonce_fields(); ?>
                 
                  <?php
                  box_add_captcha_field();
                  $tos_link =box_get_static_link('tos');
                  ?>
                  <div class="form-row">
                     <div class="col-md-12 tos-row">
                    <label><span><input type="checkbox" name="tos" id="tos" class="required" required></span><?php printf(__('By signing up, you are agreeing to our <a href="%s" target="_Blank">Terms of Service and Privacy Policies</a>.','boxtheme'),$tos_link);?></label>
                  </div>
                </div>

                  <div class="form-row">
                      <div class="col-md-12">
                          <button type="submit" class="btn btn-success btn-checkout-membership"> <?php _e('Create Account','boxtheme'); ?> &nbsp; <i class="fa fa-spinner fa-spin"></i></button>
                      </div>
                  </div>
                  <?php // bx_social_button_signup() ?>
              </form>
                   <div class="col-md-4 right-membership setup-secondary"> <!-- end left !-->

                  <div class="setup-info-module">
                    <h2>You’ll love our community</h2>
                    <ul class="features-list">
                      <li><strong>Unlimited</strong> post project</li>                    

                      <li class="list-divider"></li>

                      <li><svg class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path></svg> Great communication</li>
                      <li><svg class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path></svg> Frictionless development</li>
                      <li><svg class="octicon octicon-check" viewBox="0 0 12 16" version="1.1" width="12" height="16" aria-hidden="true"><path fill-rule="evenodd" d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path></svg> Open source community</li>
                    </ul>
                  </div>

              </div> <!-- right !-->
             </div> <!-- end step 1 !-->
            <div class="step step-2 <?php echo $current_step2; ?>  checkout-step">
              <form class="frm-membership">
              <div class="col-md-12">
                <table class="shop_table membership-order">
                  <thead>
                    <tr>
                      <th class="product-name">Item</th>
                      <th class="product-total">Amount</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <tr class="cart_item">
                        <?php 
                        global $symbol;
                        $pack_id = isset($_GET['plan']) ? $_GET['plan'] : 0;
                        $price = get_post_meta($pack_id,'price', true);
                        $plan = get_post($pack_id);
                        ?>
                          <td class="product-name"><?php printf(__('Pay for subcription the  <i>%s</i> plan.','boxtheme'),$plan->post_title);?> </td>
                          <td class="product-total">
                            <span class="woocommerce-Price-amount amount"><?php echo $price;?><span class="woocommerce-Price-currencySymbol"><?php echo $symbol;?></span></span>           </td>
                    </tr>
                                  
                  </tbody>
                  <tfoot>
                    <tr class="order-total">
                      <th>Total</th>
                      <td><strong><span class="woocommerce-Price-amount amount"><?php echo $price;?><span class="woocommerce-Price-currencySymbol"><?php echo $symbol;?></span></span></strong> </td>
                    </tr>

                    
                  </tfoot>
                </table>

                <ul class="list-payment none-style">
                 <li><label><input type="radio" name="_gateway" required value="paypal"> PayPal</label></li>
                 <li class="hide"><label><input type="radio" name="_gateway" value="stripe"> Stripe</label></li>
                 <input type="hidden" name="package_id" value="<?php echo $_GET['plan'];?>">
                </ul>
              </div>
  
              <div class="col-md-12">
                  <button type="submit" class="btn btn btn-success btn-block btn-submit"> <?php _e('Check out','boxtheme'); ?> &nbsp; <i class="fa fa-spinner fa-spin"></i></button>
              </div>
            </form>

            </div>
          </div> <!-- end left !-->
         
        </div> <!-- end sign_up !-->
    </div>
    <!-- End List Job !-->
    <script>
      // This example displays an address form, using the autocomplete feature
      // of the Google Places API to help users fill in the information.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

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
        console.log(navigator.geolocation.getCurrentPosition);
        //navigator.geolocation.getCurrentPosition
      }

      function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();

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
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            document.getElementById('lat').value=position.coords.latitude ;
            document.getElementById('lng').value=position.coords.longitude ;
            console.log(geolocation);
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
      }

    </script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqUWzOJHKpZ7VW_oEivFqtTP0A87d3cfM&libraries=places&callback=initAutocomplete" async defer></script>
<?php get_footer(); ?>
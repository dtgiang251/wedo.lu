<?php
global $post;
if ( ! class_exists( 'WP_Job_Manager' ) ) {
    return;
}
$listing = MyListing\Src\Listing::get( $post );
if ( ! $listing->type ) {
    return;
}
// Get the layout blocks for the single listing page.
$layout = $listing->type->get_layout();
$fields = $listing->type->get_fields();
$listing_logo = $listing->get_logo( 'medium' );
$user_listing_type = get_post_meta( get_the_ID(), '_user_package_id', true );
if( $user_listing_type == '' ) {
    $post_id = icl_object_id( get_the_ID(), 'job_listing',false, 'fr');
    $user_listing_type = get_post_meta( $post_id, '_user_package_id', true );
}
if( $user_listing_type == '' ) {
    $post_id = icl_object_id( get_the_ID(), 'job_listing',false, 'en');
    $user_listing_type = get_post_meta( $post_id, '_user_package_id', true );
}
if( $user_listing_type == '' ) {
    $post_id = icl_object_id( get_the_ID(), 'job_listing',false, 'de');
    $user_listing_type = get_post_meta( $post_id, '_user_package_id', true );
}
$listing_type = get_post_meta( get_the_ID(), '_package_id', true );
$product_id = get_post_meta( $user_listing_type, '_product_id', true);
$listing_claimed = false;
$listing_id_fr = apply_filters( 'wpml_object_id', get_the_ID(), 'job_listing', TRUE ,'fr' );
$listing_id_en = apply_filters( 'wpml_object_id', get_the_ID(), 'job_listing', TRUE ,'en' );
$listing_id_de = apply_filters( 'wpml_object_id', get_the_ID(), 'job_listing', TRUE ,'de' );
if(ICL_LANGUAGE_CODE=='en'){
    if(case27_paid_listing_is_claimed($listing_id_fr ) || case27_paid_listing_is_claimed($listing_id_de )){
        $listing_claimed = true;
    }
} elseif(ICL_LANGUAGE_CODE=='de'){
    if(case27_paid_listing_is_claimed($listing_id_en ) || case27_paid_listing_is_claimed($listing_id_fr )){
        $listing_claimed = true;
    }
}else{
    if(case27_paid_listing_is_claimed($listing_id_en ) || case27_paid_listing_is_claimed($listing_id_de )){
        $listing_claimed = true;
    }
}
// $listing_logo = job_manager_get_resized_image( $listing->get_field( 'job_logo' ), 'medium' );
?>
<!-- SINGLE LISTING PAGE -->
<?php $listing_listing_type = get_post_meta( get_the_ID(), '_case27_listing_type', true ); ?>
<?php if( !($listing_listing_type == 'offre-demploi' || $listing_listing_type=='offre-demploi-en'|| $listing_listing_type=='offre-demploi-de' )) : ?>
<div class="single-job-listing" id="c27-single-listing">
    <input type="hidden" id="case27-post-id" value="<?php echo esc_attr( get_the_ID() ) ?>">
    <input type="hidden" id="case27-author-id" value="<?php echo esc_attr( get_the_author_meta('ID') ) ?>">
<?php if(($user_listing_type == '' || $product_id == '11347' || $product_id == '40141' || $product_id == '40142' ) && ($listing_listing_type == 'place' || $listing_listing_type=='place-en'|| $listing_listing_type=='place-de')){ ?>
<div class="result-wrapper">
    <div id="page-head">
       <div class="container">
          <div class="row">
             <div class="col-lg-7">
                <header>
                <?php if ( $listing_logo ): ?>
                <?php
                    $media_id = giang_get_image_id($listing->get_logo( 'small' )); ;
                    $alt = 'image';
                    if($media_id) $alt = giang_get_media_alt( $media_id );
                ?>
                   <img src="<?php echo $listing->get_logo( 'small' );?>" alt="<?php echo $alt; ?>">
                <?php endif;?>
                   <h4><?php the_title() ?></h4>
                </header>
                <?php echo wpautop( $listing->get_field('job_description'), [] );?>
             </div>
             <div class="col-lg-5">
                 <ul class="sharing">
                 <?php $button = array();
             // $button['action'] = 'share';
             // $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/share.svg" alt="image"></i>'.__('Partager','wedo-listing');
             // $button['label_l10n'] = array('locale' => 'en_US');
             // $button['style'] = 'outlined';
             // $button['icon'] = 'mi redo';
             // $button['id'] = 'cover-button--5ac369656ea12';
             // $button['classes'] = array('button-2');
             // $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             // if ( $button_template = locate_template( $button_template_path ) ):
                 // require $button_template;
             // elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 // do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             // endif;
            ?>
            <?php $button = array();
             // $button['action'] = 'bookmark';
             // $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/heart.svg" alt="image"></i>'.__('Favoriser','wedo-listing');
             // $button['label_l10n'] = array('locale' => 'en_US');
             // $button['style'] = 'outlined';
             // $button['icon'] = 'mi redo';
             // $button['id'] = 'cover-button--5ac36c5a1879d';
             // $button['classes'] = array('button-2');
             // $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             // if ( $button_template = locate_template( $button_template_path ) ):
                 // require $button_template;
             // elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 // do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             // endif;
            ?>
            <!-- Call button -->
            <?php $button = array();
             $button['action'] = 'call';
             $button['label'] = '<i><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="512px" height="512px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
<g fill="#ffa602"><path d="M462.49,468.206l-33.937,33.937c-6.063,6.031-23.812,9.843-24.343,9.843c-107.435,0.906-210.869-41.279-286.883-117.309
    C41.096,318.46-1.137,214.619,0.035,106.872c0-0.063,3.891-17.312,9.938-23.312l33.937-33.968
    c12.453-12.437,36.295-18.062,52.998-12.5l7.156,2.406c16.703,5.562,34.155,23.999,38.78,40.967l17.093,62.717
    c4.64,17-1.594,41.186-14.031,53.623l-22.687,22.687c22.25,82.467,86.919,147.122,169.339,169.402l22.687-22.687
    c12.438-12.438,36.687-18.656,53.687-14.031l62.717,17.125c16.937,4.594,35.374,22.03,40.968,38.748l2.375,7.156
    C480.552,431.926,474.928,455.769,462.49,468.206z M287.995,255.993h31.999c0-35.343-28.655-63.998-63.998-63.998v31.999
    C273.636,223.994,287.995,238.368,287.995,255.993z M415.991,255.993c0-88.373-71.623-159.996-159.995-159.996v32
    c70.592,0,127.996,57.436,127.996,127.996H415.991z M255.996,0v31.999c123.496,0,223.993,100.497,223.993,223.994h31.999
    C511.988,114.622,397.367,0,255.996,0z"/></g>
</svg></i>'.__('Call','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac369656ea12';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            ?>
            <!-- Contact button -->
            <?php $button = array();
             $button['action'] = 'contact';
             $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/opened-email-envelope.svg" alt="image"></i>'.__('Contact','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac36c5a1879d';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            ?>
            <?php if(!$listing_claimed){
             $button = array();
             $button['action'] = 'claim-listing';
             $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/hand.svg" alt="image"></i>'.__('Proclamer','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac36c5a188a7';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            } ?>
            </ul>
             </div>
          </div>
          <?php if($listing->get_field('nombre-demploys')){?>
           <hr>
           <div class="row">
               <div class="col-sm-12 emp-count">
                   <i class="icon"><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/employee-icon.png" alt="image"></i>
                   <p><?php _e('Number of employees','wedo-listing');?>: <span><?php echo $listing->get_field('nombre-demploys');?></span></p>
               </div>
           </div>
          <?php } ?>
       </div>
    </div>
    <div class="details">
                    <div class="container">
                    <ul class="list3">
                    <?php if ( $listing->get_field( 'adresse' )) { ?>
                            <li> <i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/marker.svg" alt="image"></i><address><?php echo $listing->get_field( 'adresse' );?><br><?php echo $listing->get_field( 'code-postal-localit' );?></address></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'job_website' )) { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/web.svg" alt="image"></i><a href="<?php echo $listing->get_field( 'job_website' );?>"><?php echo remove_http($listing->get_field( 'job_website' ));?></a></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'tlphone' ) && $listing->get_field( 'tlphone' ) != '+352 ' && $listing->get_field( 'tlphone' ) != '+32 ' && $listing->get_field( 'tlphone' ) != '+33 ') { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/mobile.svg" alt="image"></i><a href="tel:<?php echo $listing->get_field( 'tlphone' );?>"><?php echo $listing->get_field( 'tlphone' );?></a></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'fax' ) && $listing->get_field( 'fax' ) != '+352 ' && $listing->get_field( 'fax' ) != '+32 ' && $listing->get_field( 'fax' ) != '+33 ') { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/fax.svg" alt="image"></i><a href="#"><?php echo $listing->get_field( 'fax' );?></a></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'job_email' )) { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/envelope.svg" alt="image"></i><a href="mailto:<?php echo $listing->get_field( 'job_email' );?>"><?php echo $listing->get_field( 'job_email' );?></a></li>
                            <?php } ?>
                    </ul>
            </div>
    </div>
    <div class="map">
    <?php if ( $listing->get_field( 'job_location' ) ) {
                                    if ( ! ( $listing_logo = $listing->get_logo( 'thumbnail' ) ) ) {
                                        $listing_logo = c27()->image( 'marker.jpg' );
                                    }
                                    $location_arr = [
                                        'address' => $listing->get_field( 'job_location' ),
                                        'marker_image' => ['url' => $listing_logo],
                                    ];
                                    if ( ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
                                        $location_arr = [
                                            'marker_lat' => $lat,
                                            'marker_lng' => $lng,
                                            'marker_image' => ['url' => $listing_logo],
                                        ];
                                    }
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 11,
                                            'draggable' => false,
                                            'skin' => 'skin5',
                                        ],
                                    ]);
                                } ?>
                    <div class="container">
                       <div class="form">
                       <h2><?php _e('Contact us','wedo-listing');?></h2>
                       <?php  if(ICL_LANGUAGE_CODE=="en"){                         $contact_form_id = 53714;                     } elseif(ICL_LANGUAGE_CODE=="fr"){                         $contact_form_id = 11822;                     }elseif(ICL_LANGUAGE_CODE=="de"){                         $contact_form_id = 53672;                     }
                                    $email_to = ['job_email'];
                                    $email_to = array_filter( $email_to );?>
                       <?php echo str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) );?>
                       </div>
                    </div>
    </div>
</div>
<?php } else { ?>
<div class="result-wrapper">
        <?php $image = $listing->get_cover_image( 'full' ); ?>
        <div id="page-head" class="member-login <?php if(!$image){ echo 'no-image';}?>">
        <?php if($image){
            $media_id = giang_get_image_id($image);
            $alt = '';
            if($media_id) $alt = giang_get_media_alt( $media_id );
        ?>
                        <img src="<?php echo $image;?>" alt="<?php echo $alt ? $alt : 'image'; ?>">
        <?php } ?>
                        <div class="container">
                        <div class="detail-box">
                        <?php if ( $listing->get_logo( 'medium' ) ): ?>
                        <?php
                            $media_id = giang_get_image_id($listing->get_logo( 'small' )); ;
                            $alt = 'image';
                            if($media_id) $alt = giang_get_media_alt( $media_id );
                        ?>
                        <figure> <img src="<?php echo $listing->get_logo( 'small' );?>" alt="<?php echo $alt; ?>"> </figure>
                         <?php endif;?>
                                <h1><?php the_title();?></h1>
                    <?php if( ! ( $listing_listing_type == 'offre-demploi' || $listing_listing_type=='offre-demploi-en'|| $listing_listing_type=='offre-demploi-de' ) ) : ?>
                        <?php if ( $tagline = $listing->get_field('job_tagline') ): ?>
                            <h2><?php echo esc_html( $tagline ) ?></h2>
                        <?php elseif ( $description = $listing->get_field('job_description') ): ?>
                            <h2><?php echo c27()->the_text_excerpt( wp_kses( $description, [] ), 77 ) ?></h2>
                        <?php endif ?>
                    <?php endif ?>
                    <ul class="sharing">
                 <?php $button = array();
             // $button['action'] = 'share';
             // $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/share.svg" alt="image"></i>'.__('Partager','wedo-listing');
             // $button['label_l10n'] = array('locale' => 'en_US');
             // $button['style'] = 'outlined';
             // $button['icon'] = 'mi redo';
             // $button['id'] = 'cover-button--5ac369656ea12';
             // $button['classes'] = array('button-2');
             // $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             // if ( $button_template = locate_template( $button_template_path ) ):
                 // require $button_template;
             // elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 // do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             // endif;
            ?>
            <?php $button = array();
             // $button['action'] = 'bookmark';
             // $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/heart.svg" alt="image"></i>'.__('Favoriser','wedo-listing');
             // $button['label_l10n'] = array('locale' => 'en_US');
             // $button['style'] = 'outlined';
             // $button['icon'] = 'mi redo';
             // $button['id'] = 'cover-button--5ac36c5a1879d';
             // $button['classes'] = array('button-2');
             // $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             // if ( $button_template = locate_template( $button_template_path ) ):
                 // require $button_template;
             // elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 // do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             // endif;
            ?>
            <!-- Contact button -->
            <?php if( $listing_listing_type == 'offre-demploi' || $listing_listing_type=='offre-demploi-en'|| $listing_listing_type=='offre-demploi-de' ) { ?>
                <?php $button = array();
                 $button['action'] = 'apply';
                 $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/job.svg" alt="image"></i>'.__('Apply','wedo-listing');
                 $button['label_l10n'] = array('locale' => 'en_US');
                 $button['style'] = 'outlined';
                 $button['icon'] = 'mi redo';
                 $button['id'] = 'cover-button--5ac36c5a18794';
                 $button['classes'] = array('button-2');
                 $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
                 if ( $button_template = locate_template( $button_template_path ) ):
                     require $button_template;
                 elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                     do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
                 endif;
                ?>
                <?php $button = array();
                 $button['action'] = 'information';
                 $button['label'] = '<i class="material-icons">view_headline</i>'.__('Informations','wedo-listing');
                 $button['label_l10n'] = array('locale' => 'en_US');
                 $button['style'] = 'outlined';
                 $button['icon'] = 'mi redo';
                 $button['id'] = 'cover-button--5ac36c5a18795';
                 $button['classes'] = array('button-2');
                 $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
                 if ( $button_template = locate_template( $button_template_path ) ):
                     require $button_template;
                 elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                     do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
                 endif;
                ?>
            <?php } else { ?>
            <!-- Call button -->
            <?php $button = array();
             $button['action'] = 'call';
             $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/phone-volume.svg" alt="image"></i>'.__('Call','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac369656ea12';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            ?>
            <!-- Contact button -->
            <?php $button = array();
             $button['action'] = 'contact';
             $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/opened-email-envelope.svg" alt="image"></i>'.__('Contact','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac36c5a1879d';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            ?>
            <?php } ?>
             <?php  if(!$listing_claimed){
             $button = array();
             $button['action'] = 'claim-listing';
             $button['label'] = '<i><img src="'.get_stylesheet_directory_uri().'/assets/images/hand.svg" alt="image"></i>'.__('Proclamer','wedo-listing');
             $button['label_l10n'] = array('locale' => 'en_US');
             $button['style'] = 'outlined';
             $button['icon'] = 'mi redo';
             $button['id'] = 'cover-button--5ac36c5a188a7';
             $button['classes'] = array('button-2');
             $button_template_path = sprintf( 'partials/single/buttons/%s.php', $button['action'] );
             if ( $button_template = locate_template( $button_template_path ) ):
                 require $button_template;
             elseif ( has_action( sprintf( 'case27\listing\cover\buttons\%s', $button['action'] ) ) ):
                 do_action( "case27\listing\cover\buttons\\{$button['action']}", $button, $listing );
             endif;
            }
            ?>
            </ul>
                        </div>
                        </div>
        </div>
        <div id="tabs-container">
                        <ul class="tabs-menu">
                                      <?php if($listing_listing_type == 'place' || $listing_listing_type == 'place-en' || $listing_listing_type == 'place-de'){?>
                                      <li class="current"><a href="#_tab_1"><?php _e('Profil','wedo-listing');?></a></li>
                                      <?php  } ?>
                                        <?php $i = 0;
                            foreach ((array) $layout['menu_items'] as $key => $menu_item): $i++;
                                if (
                                    $menu_item['page'] == 'bookings' &&
                                    $menu_item['provider'] == 'timekit' &&
                                    ! $listing->get_field( $menu_item['field'] )
                                ) { continue; }
                                if($i==1 && ($listing_listing_type == 'place' || $listing_listing_type == 'place-en' || $listing_listing_type == 'place-de')){ continue; }
                                ?><li class="<?php echo ($i == 1) ? 'current' : '' ?>">
                                    <a href="<?php echo "#_tab_{$i}" ?>" aria-controls="<?php echo esc_attr( "_tab_{$i}" ) ?>" data-section-id="<?php echo esc_attr( "_tab_{$i}" ) ?>"
                                       role="tab" class="tab-reveal-switch <?php echo esc_attr( "toggle-tab-type-{$menu_item['page']}" ) ?>">
                                        <?php echo esc_html( $menu_item['label'] ) ?>
                                        <?php if ($menu_item['page'] == 'comments'): ?>
                                            <span class="items-counter"><?php echo get_comments_number() ?></span>
                                        <?php endif ?>
                                        <?php if (in_array($menu_item['page'], ['related_listings', 'store'])):
                                            $vue_data_keys = ['related_listings' => 'related_listings', 'store' => 'products'];
                                            ?>
                                            <span class="items-counter" v-if="<?php echo esc_attr( $vue_data_keys[$menu_item['page']] ) ?>['_tab_<?php echo esc_attr( $i ) ?>'].loaded" v-cloak>
                                                {{ <?php echo $vue_data_keys[$menu_item['page']] ?>['_tab_<?php echo $i ?>'].count }}
                                            </span>
                                            <span v-else class="c27-tab-spinner">
                                                <i class="fa fa-circle-o-notch fa-spin"></i>
                                            </span>
                                        <?php endif ?>
                                    </a>
                                </li><?php
                            endforeach; ?>
                                     </ul>
                   <div class="tab">
                   <?php if($listing_listing_type == 'place' || $listing_listing_type == 'place-en' || $listing_listing_type == 'place-de'){?>
                      <div id="_tab_1" class="tab-content" style="display: block;">
        <div class="inner-wrapper">
                <div class="container">
                                <div class="details"><div class="container"><ul class="list3">
                                <?php if ( $listing->get_field( 'adresse' )) { ?>
                            <li> <i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/marker.svg" alt="image"></i><h3><address><?php echo $listing->get_field( 'adresse' );?><br><?php echo $listing->get_field( 'code-postal-localit' );?></address></h3></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'job_website' )) { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/web.svg" alt="image"></i><h3><a href="<?php echo $listing->get_field( 'job_website' );?>"><?php echo remove_http($listing->get_field( 'job_website' ));?></a></h3></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'tlphone' ) && $listing->get_field( 'tlphone' ) != '+352 ' && $listing->get_field( 'tlphone' ) != '+32 ' && $listing->get_field( 'tlphone' ) != '+33 ') { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/mobile.svg" alt="image"></i><h3><a href="tel:<?php echo $listing->get_field( 'tlphone' );?>"><?php echo $listing->get_field( 'tlphone' );?></a></h3></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'fax' ) && $listing->get_field( 'fax' ) != '+352 ' && $listing->get_field( 'fax' ) != '+32 ' && $listing->get_field( 'fax' ) != '+33 ') { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/fax.svg" alt="image"></i><h3><a href="#"><?php echo $listing->get_field( 'fax' );?></a></h3></li>
                            <?php } ?>
                            <?php if ( $listing->get_field( 'job_email' )) { ?>
                            <li><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/envelope.svg" alt="image"></i><h3><a href="mailto:<?php echo $listing->get_field( 'job_email' );?>"><?php echo $listing->get_field( 'job_email' );?></a></h3></li>
                            <?php } ?>
                            </ul></div></div>
                            <?php if($gallery = $listing->get_field( 'gallery' )){ ?>
                                                <div id="slideshow">
        <div class="row">
        <div class="col-sm-9 col">
                        <div class="slider slider-for">
                        <?php foreach ( $gallery as $gallery_image ): ?>
                        <?php
                            if ( $image = job_manager_get_resized_image( $gallery_image, 'large' ) ):
                            $media_id = giang_get_image_id($image);
                            $alt = '';
                            if($media_id) $alt = giang_get_media_alt( $media_id );
                        ?>
                                        <div>
                                           <img class="large-image" src="<?php echo $image;?>" alt="<?php echo $alt; ?>">
                                        </div>
                            <?php endif; endforeach;?>
                                     </div>
        </div>
        <div class="col-sm-3 col">
                        <div class="slider slider-nav">
                        <?php foreach ( $gallery as $gallery_image ): ?>
                        <?php if ( $image = job_manager_get_resized_image( $gallery_image, 'medium' ) ):
                            $media_id = giang_get_image_id($image);
                            $alt = '';
                            if($media_id) $alt = giang_get_media_alt( $media_id );
                        ?>
                                        <div>
                                           <img src="<?php echo $image;?>" alt="<?php echo $alt; ?>">
                                        </div>
                                        <?php endif; endforeach;?>
                                     </div>
                        </div>
        </div>
                                </div>
                            <?php } ?>
                        <?php if ( $description = $listing->get_field('job_description') ): ?>
                        <div class="box2">
                        <h2><?php echo sprintf( __('About %s','wedo-listing'), get_the_title() );?></h2>
                        <div class="two-column">
                        <?php echo wpautop( $description, [] ); ?>
                        </div>
                        <?php $social_links = $listing->get_field('links'); ?>
                        <?php if($social_links){ ?>
                        <div class="socialable">
                                <ul>
                                        <a href="#"></a>
                                        <?php foreach($social_links as $social_link){ ?>
                                            <?php if($social_link['network'] == "Facebook"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Twitter"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "LinkedIn"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Google+"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Instagram"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "YouTube"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Snapchat"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-snapchat" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Tumblr"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-tumblr" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Reddit"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-reddit-alien" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Pinterest"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "DeviantArt"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-deviantart" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "VKontakte"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-vk" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "SoundCloud"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-soundcloud" aria-hidden="true"></i></a></li>
                                           <?php } elseif($social_link['network'] == "Website"){ ?>
                                                <li><a href="<?php echo $social_link['url'];?>" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a></li>
                                           <?php } ?>
                                        <?php } ?>
                                </ul>
                        </div>
                        <?php } ?>
                        </div>
                        <?php endif ?>
                        <div class="row box5 languages-box">
        <?php $spoken_languages = $listing->get_field('langues-parles');?>
        <?php if($spoken_languages){ ?>
        <?php $spoken_array = explode(",",$spoken_languages);?>
        <div class="col-md-6 column">
<h2><?php _e('Spoken languages','wedo-listing');?>:</h2>
        <ul class="list5">
            <?php foreach($spoken_array as $spoken):?>
                <li><?php echo $spoken;?></li>
        <?php endforeach;?>
        </ul>
        </div>
        <?php } ?>
        <?php $facilits = $listing->get_field('facilits');?>
        <?php if($facilits){ ?>
        <?php $facilits_array = explode(",",$facilits);?>
        <div class="col-md-6 column">
                        <h2><?php _e('Facilities','wedo-listing');?>:</h2>
                                <ul class="list5">
                                <?php foreach($facilits_array as $facilit):?>
                <li><?php echo $facilit;?></li>
        <?php endforeach;?>
                                </ul>
                                </div>
        <?php } ?>
                        </div>
                        <?php $mode_of_payments = $listing->get_field('modes-de-paiement-accepts');?>
        <?php if($mode_of_payments){ ?>
                        <div class="row box5 languages-box">
        <?php $mode_of_payments_array = explode(",",$mode_of_payments);?>
        <div class="col-md-6 column">
<h2><?php _e('Accepted payment methods','wedo-listing');?>: </h2>
        <ul class="list5">
            <?php foreach($mode_of_payments_array as $mode_of_payment):?>
                <li><?php echo $mode_of_payment;?></li>
        <?php endforeach;?>
        </ul>
        </div>
        <?php
            $region = wp_get_post_terms( $post->ID, 'region', array("fields" => "all") );
            if( $region ) :
        ?>
        <div class="col-md-6 column">
            <h2><?php echo _n( 'Area of activity', 'Areas of activity', sizeof( $region ), 'wedo-listing' ); ?>: </h2>
            <ul class="list5">
            <?php foreach( $region as $t ) : ?>
                <li><a href="<?php echo get_term_link( $t, 'region' ); ?>"><?php echo $t->name;?></a></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
                        </div>
                        <?php } ?>
                </div>
                <div class="box4">
                <div class="container">
                                <?php $work_hours = $listing->get_field('work_hours');
                                    $daystatuses = [
                                        'enter-hours' => __( 'Enter hours', 'my-listing' ),
                                        'open-all-day' => __( 'Open all day', 'my-listing' ),
                                        'closed-all-day' => __( 'Closed all day', 'my-listing' ),
                                        'by-appointment-only' => __( 'By appointment only', 'my-listing' ),
                                    ];
                                ?>
                                <?php if ( $work_hours && $listing->schedule->get_status() !== 'not-available' ): ?>
                                <?php // if ( $listing->get_field('work_hours') && $listing->schedule->get_status() !== 'not-available' ): ?>
                                                <div class="row timing-section">
                                                                <div class="col-sm-3">
                                                                        <h2><?php _e('Opening hours','wedo-listing');?>:</h2>
                                                                </div>
                                                                <div class="col-sm-9">
                                                <?php $timings = array('Monday', 'Tuesday', 'Wednesday', 'Thursday','Friday','Saturday','Sunday');?>
                                                <?php $timings_translate = array(__('Lundi','wedo-listing'), __('Mardi','wedo-listing'),__('Mercredi','wedo-listing'),__('Jeudi','wedo-listing'),__('Vendredi','wedo-listing'),__('Samedi','wedo-listing'),__('Dimanche','wedo-listing'));?>
                                                        <ul class="timing-list">
                                                              <?php $j=0; foreach($timings as $timing):?>
                                                                <li><?php echo $timings_translate[$j];?></li>
                                                                <?php $day_ranges = $listing->get_schedule()->get_day_ranges($timing); ?>
                                                               <li> <?php $count = count($day_ranges);
                                                                if($count > 0){
                                                                    $i=0; foreach($day_ranges as $day_range){
                                                                   if($i>0){
                                                                       echo "    |    ";
                                                                   }
                                                                    echo $day_range['from'].' - '.$day_range['to'];
                                                                    $i++; }
                                                                } else {
                                                                    if( $daystatuses[$work_hours[$timing]['status']] ) {
                                                                        echo $daystatuses[$work_hours[$timing]['status']];
                                                                    }
                                                                    else {
                                                                        echo __('Fermé','wedo-listing');
                                                                    }
                                                                }
                                                                ?>
                                                                </li>
                                                              <?php $j++; endforeach;?>
                                                        </ul>
                                                                        </div>
                                                                </div>
                                <?php endif;?>
                                <?php $first_person = $listing->get_field('nom-et-prnom');
                                      $second_person = $listing->get_field('nom-et-prnomdeux');
                                      $third_person = $listing->get_field('nom-et-prnomttrois');
                                      $fourth_person = $listing->get_field('nom-et-prnomquatre');
                                       ?>
                                <?php if($first_person || $second_person || $third_person || $fourth_person ):?>
                                                <div class="row">
                                                                <div class="col-sm-12">
                                                                        <h2><?php echo sprintf( __('Contact persons at %s','wedo-listing') , get_the_title() );?>:</h2>
                                                                </div>
                                                                </div>
<div class="row">
        <?php if($first_person):?>
        <div class="col-md-3 col-sm-6">
                <div class="person-details">
                <h3><?php echo $first_person;?></h3>
                <?php if($listing->get_field('fonctionpremiere')):?>
                <p><?php echo $listing->get_field('fonctionpremiere');?></p>
                <?php endif;?>
                <?php if($listing->get_field('numro-de-telpremiere')):?>
                <p><a href="tel:<?php echo $listing->get_field('numro-de-telpremiere');?>"><?php echo $listing->get_field('numro-de-telpremiere');?></a></p>
                <?php endif;?>
                </div>
        </div>
        <?php endif;?>
        <?php if($second_person):?>
        <div class="col-md-3 col-sm-6">
                <div class="person-details">
                <h3><?php echo $second_person;?></h3>
                <?php if($listing->get_field('fonctiondeux')):?>
                <p><?php echo $listing->get_field('fonctiondeux');?></p>
                <?php endif;?>
                <?php if($listing->get_field('numro-de-teldeux')):?>
                <p><a href="tel:<?php echo $listing->get_field('numro-de-teldeux');?>"><?php echo $listing->get_field('numro-de-teldeux');?></a></p>
                <?php endif;?>
                </div>
        </div>
        <?php endif;?>
        <?php if($third_person):?>
        <div class="col-md-3 col-sm-6">
                <div class="person-details">
                <h3><?php echo $third_person;?></h3>
                <?php if($listing->get_field('fonctiontrois')):?>
                <p><?php echo $listing->get_field('fonctiontrois');?></p>
                <?php endif;?>
                <?php if($listing->get_field('numro-de-teltrois')):?>
                <p><a href="tel:<?php echo $listing->get_field('numro-de-teltrois');?>"><?php echo $listing->get_field('numro-de-teltrois');?></a></p>
                <?php endif;?>
                </div>
        </div>
        <?php endif;?>
        <?php if($fourth_person):?>
        <div class="col-md-3 col-sm-6">
                <div class="person-details">
                <h3><?php echo $fourth_person;?></h3>
                <?php if($listing->get_field('fonctionquatre')):?>
                <p><?php echo $listing->get_field('fonctionquatre');?></p>
                <?php endif;?>
                <?php if($listing->get_field('numro-de-telcinq')):?>
                <p><a href="tel:<?php echo $listing->get_field('numro-de-telcinq');?>"><?php echo $listing->get_field('numro-de-telcinq');?></a></p>
                <?php endif;?>
                </div>
        </div>
        <?php endif;?>
</div>
<?php endif;?>
                                        </div>
                </div>
                <div class="container more-about">
                    <h2><?php echo sprintf( __('More about %s','wedo-listing') , get_the_title() );?>:</h2>
                        <div class="row">
                        <?php $tags = $listing->get_field( 'job_tags' );?>
     <?php  $post_tags = $tags;?>
<?php if ( $post_tags ) { ?>
                                <div class="col-sm-6">
<div class="box3">
<h3><?php _e('Our activities and services','wedo-listing');?></h3>
<ul class="list4">
<?php  foreach( $post_tags as $tag ) { ?>
<li><h4><a href="<?php echo get_term_link($tag);?>"><i><img src="<?php echo get_stylesheet_directory_uri();?>/assets/images/bookmark.svg" alt="image"></i><span><?php  echo $tag->name;?></span></a></h4></li>
<?php  } ?>
</ul>
</div>
                                </div>
<?php } ?>
                                <div class="col-sm-6">
                                                <div class="box3">
                                                                <h3><?php _e('Administrative and financial information','wedo-listing');?></h3>
<?php if($listing->get_field('n-nace')){?>
<div class="line">
<p><?php _e('N° Nace','wedo-listing');?></p>
<span><?php echo $listing->get_field('n-nace');?> </span>
</div>
<?php }?>
<?php if($listing->get_field('n-registre-du-commerce')){?>
<div class="line">
<p><?php _e('Trade Register No.','wedo-listing');?></p>
<span><?php echo $listing->get_field('n-registre-du-commerce');?></span>
</div>
<?php }?>
<?php if($listing->get_field('n-tva-international')){?>
<div class="line">
<p><?php _e('International VAT number','wedo-listing');?></p>
<span><?php echo $listing->get_field('n-tva-international');?></span>
</div>
<?php }?>
<?php if($listing->get_field('n-tva-national')){?>
<div class="line">
<p><?php _e('National VAT number','wedo-listing');?></p>
<span><?php echo $listing->get_field('n-tva-national');?></span>
</div>
<?php }?>
<?php if($listing->get_field('ca')){?>
<div class="line">
<p><?php _e('Sales turnover','wedo-listing');?></p>
<span><?php echo $listing->get_field('ca');?></span>
</div>
<?php }?>
<?php if($listing->get_field('capital')){?>
<div class="line">
<p><?php _e('Capital','wedo-listing');?></p>
<span><?php echo $listing->get_field('capital');?></span>
</div>
<?php } ?>
<?php if($listing->get_field('nombre-demploys')){?>
<div class="line">
<p><?php _e('Number of employees','wedo-listing');?></p>
<span><?php echo $listing->get_field('nombre-demploys');?></span>
</div>
<?php } ?>
<?php if($listing->get_field('date-de-fondation')){?>
<div class="line">
<p><?php _e('Date of foundation','wedo-listing');?></p>
<span><?php echo $listing->get_field('date-de-fondation');?></span>
</div>
<?php } ?>
                                                                </div>
                                </div>
                        </div>
                </div>
                 <?php $produits = $listing->get_field('produits-et-services');?>
        <?php if($produits){ ?>
        <?php $produits_array = explode(",",$produits);?>
                <div class="container more-about">
                <div class="box6">
                        <div class="row">
                                <div class="col-md-3 col-sm-4">
                                        <h3><?php _e('Products and brands','wedo-listing');?>:</h3>
                                </div>
                                <div class="col-md-9 col-sm-8">
<ul>
<?php foreach($produits_array as $produit):?>
                <li><h4><?php echo $produit;?></h4></li>
        <?php endforeach;?>
</ul>
                                                                                </div>
                        </div>
                </div>
                </div>
        <?php } ?>
        <?php $certifications = $listing->get_field('certifications');?>
        <?php if($certifications){ ?>
        <?php $certifications_array = explode(",",$certifications);?>
                <div class="container">
                        <div class="box7">
                                <div class="row">
                                        <div class="col-md-3 col-sm-4">
                                                <h2><?php _e('Our certifications','wedo-listing');?>:</h2>
                                        </div>
                                        <div class="col-md-9 col-sm-8">
        <ul class="list6">
                <?php foreach($certifications_array as $certification):?>
                <li><?php echo $certification;?></li>
        <?php endforeach;?>
        </ul>
                                                                                        </div>
                                </div>
                        </div>
                        </div>
        <?php  } ?>
        </div>
<div class="map">
    <?php if ( $listing->get_field( 'job_location' ) ) {
                                    if ( ! ( $listing_logo = $listing->get_logo( 'thumbnail' ) ) ) {
                                        $listing_logo = c27()->image( 'marker.jpg' );
                                    }
                                    $location_arr = [
                                        'address' => $listing->get_field( 'job_location' ),
                                        'marker_image' => ['url' => $listing_logo],
                                    ];
                                    if ( ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
                                        $location_arr = [
                                            'marker_lat' => $lat,
                                            'marker_lng' => $lng,
                                            'marker_image' => ['url' => $listing_logo],
                                        ];
                                    }
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 11,
                                            'draggable' => false,
                                            'skin' => 'skin5',
                                        ],
                                    ]);
                                } ?>
                    <div class="container">
                       <div class="form">
                       <h2><?php echo sprintf( __('Contact %s','wedo-listing'), get_the_title() );?></h2>
                       <?php  if(ICL_LANGUAGE_CODE=="en"){
                                   $contact_form_id = 53714;                     } elseif(ICL_LANGUAGE_CODE=="fr"){                         $contact_form_id = 11822;                     }elseif(ICL_LANGUAGE_CODE=="de"){                         $contact_form_id = 53672;                     }
                                    $email_to = ['job_email'];
                                    $email_to = array_filter( $email_to );?>
                       <?php echo str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) );?>
                       </div>
                    </div>
    </div>
</div>
<?php } ?>
<?php $i = 0; ?>
        <?php foreach ((array) $layout['menu_items'] as $key => $menu_item): $i++; ?>
        <?php if($i==1 && ($listing_listing_type == "place" || $listing_listing_type == 'place-en' || $listing_listing_type == 'place-de')){ continue; } ?>
        <div id="_tab_<?php echo $i;?>" class="tab-content" <?php if( $i == 1 ) : ?>style="display:block;"<?php endif; ?>>
                <div class="container">
                <?php if ($menu_item['page'] == 'main' || $menu_item['page'] == 'custom'): ?>
                    <div class="container" >
                        <div class="row grid reveal">
                            <?php foreach ($menu_item['layout'] as $block):
                                $block_wrapper_class = 'col-md-6 col-sm-12 col-xs-12 grid-item';
                                if ( ! empty( $block['type'] ) ) {
                                    $block_wrapper_class .= ' block-type-' . esc_attr( $block['type'] );
                                }
                                if ( ! empty( $block['show_field'] ) ) {
                                    $block_wrapper_class .= ' block-field-' . esc_attr( $block['show_field'] );
                                }
                                if (
                                    $listing->type && ! empty( $block['show_field'] ) &&
                                    $listing->get_field( $block['show_field'] ) &&
                                    $listing->type->get_field( $block['show_field'] )
                                ) {
                                    $field = $listing->type->get_field( $block['show_field'] );
                                } else {
                                    $field = null;
                                }
                                // Text Block.
                                if ( $block['type'] == 'text' && isset( $block['show_field'] ) && ( $block_content = $listing->get_field( $block['show_field'] ) ) ) {
                                    $escape_html = true;
                                    $allow_shortcodes = false;
                                    if ( $field ) {
                                        if ( ! empty( $field['type'] ) && $field['type'] == 'wp-editor' ) {
                                            $escape_html = false;
                                        }
                                        if ( ! empty( $field['type'] ) && $field['type'] == 'texteditor' ) {
                                            $escape_html = empty( $field['editor-type'] ) || $field['editor-type'] == 'textarea';
                                            $allow_shortcodes = ! empty( $field['allow-shortcodes'] ) && $field['allow-shortcodes'] && ! $escape_html;
                                        }
                                    }
                                    c27()->get_section('content-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_headline',
                                        'title' => $block['title'],
                                        'content' => $block_content,
                                        'wrapper_class' => $block_wrapper_class,
                                        'escape_html' => $escape_html,
                                        'allow-shortcodes' => $allow_shortcodes,
                                        ]);
                                }
                                // Gallery Block.
                                if ( $block['type'] == 'gallery' && ( $gallery_items = (array) $listing->get_field( $block['show_field'] ) ) ) {
                                    $gallery_type = 'carousel';
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'gallery_type') $gallery_type = $option['value'];
                                    }
                                    if ( array_filter( $gallery_items ) ) {
                                        c27()->get_section('gallery-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://insert_photo',
                                            'title' => $block['title'],
                                            'gallery_type' => $gallery_type,
                                            'wrapper_class' => $block_wrapper_class,
                                            'gallery_items' => array_filter( $gallery_items ),
                                            'gallery_item_interface' => 'CASE27_JOB_MANAGER_ARRAY',
                                            ]);
                                    }
                                }
                                // Files Block.
                                if ( $block['type'] == 'file' && ( $files = (array) $listing->get_field( $block['show_field'] ) ) ) {
                                    if ( array_filter( $files ) ) {
                                        c27()->get_section('files-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://attach_file',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'items' => array_filter( $files ),
                                            ]);
                                    }
                                }
                                // Categories Block.
                                if ( $block['type'] == 'categories' && ( $terms = $listing->get_field( 'job_category' ) ) ) {
                                    c27()->get_section('listing-categories-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'terms' => $terms,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Tags Block.
                                if ( $block['type'] == 'tags' && ( $terms = $listing->get_field( 'job_tags' ) ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'items' => $terms,
                                        'item_interface' => 'WP_TERM',
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                if ( $block['type'] == 'terms' ) {
                                    // Keys = taxonomy name
                                    // Value = taxonomy field name
                                    $taxonomies = [
                                        'job_listing_category' => 'job_category',
                                        'case27_job_listing_tags' => 'job_tags',
                                        'region' => 'region',
                                    ];
                                    $taxonomy = 'job_listing_category';
                                    $template = 'listing-categories-block';
                                    if ( isset( $block['options'] ) ) {
                                        foreach ((array) $block['options'] as $option) {
                                            if ($option['name'] == 'taxonomy') $taxonomy = $option['value'];
                                            if ($option['name'] == 'style') $template = $option['value'];
                                        }
                                    }
                                    if ( ! isset( $taxonomies[ $taxonomy ] ) ) {
                                        continue;
                                    }
                                    if ( $terms = $listing->get_field( $taxonomies[ $taxonomy ] ) ) {
                                        if ( $template == 'list-block' ) {
                                            c27()->get_section('list-block', [
                                                'ref' => 'single-listing',
                                                'icon' => 'material-icons://view_module',
                                                'title' => $block['title'],
                                                'items' => $terms,
                                                'item_interface' => 'WP_TERM',
                                                'wrapper_class' => $block_wrapper_class,
                                            ]);
                                        } else {
                                            c27()->get_section('listing-categories-block', [
                                                'ref' => 'single-listing',
                                                'icon' => 'material-icons://view_module',
                                                'title' => $block['title'],
                                                'terms' => $terms,
                                                'wrapper_class' => $block_wrapper_class,
                                            ]);
                                        }
                                    }
                                }
                                // Location Block.
                                if ( $block['type'] == 'location' && isset( $block['show_field'] ) && ( $block_location = $listing->get_field( $block['show_field'] ) ) ) {
                                    if ( ! ( $listing_logo = $listing->get_logo( 'thumbnail' ) ) ) {
                                        $listing_logo = c27()->image( 'marker.jpg' );
                                    }
                                    $location_arr = [
                                        'address' => $block_location,
                                        'marker_image' => ['url' => $listing_logo],
                                    ];
                                    if ( $block['show_field'] == 'job_location' && ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
                                        $location_arr = [
                                            'marker_lat' => $lat,
                                            'marker_lng' => $lng,
                                            'marker_image' => ['url' => $listing_logo],
                                        ];
                                    }
                                    $map_skin = 'skin1';
                                    if ( ! empty( $block['options'] ) ) {
                                        foreach ((array) $block['options'] as $option) {
                                            if ($option['name'] == 'map_skin') $map_skin = $option['value'];
                                        }
                                    }
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'title' => $block['title'],
                                        'wrapper_class' => $block_wrapper_class,
                                        'template' => 'block',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 11,
                                            'draggable' => false,
                                            'skin' => $map_skin,
                                        ],
                                    ]);
                                }
                                // Contact Form Block.
                                if ($block['type'] == 'contact_form') {
                                    $contact_form_id = false;
                                    $email_to = ['job_email'];
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'contact_form_id') $contact_form_id = absint( $option['value'] );
                                        if ($option['name'] == 'email_to') $email_to = $option['value'];
                                    }
                                    $email_to = array_filter( $email_to );
                                    if ( $contact_form_id && count( $email_to ) ) {
                                        /* c27()->get_section('content-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://email',
                                            'title' => $block['title'],
                                            'content' => str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) ),
                                            'wrapper_class' => $block_wrapper_class,
                                            'escape_html' => false,
                                        ]); */ ?>
                                        <div class="<?php echo esc_attr( $block_wrapper_class ) ?>">
                                            <div class="element content-block wp-editor-content ">
                                                <div class="pf-head">
                                                    <div class="title-style-1 title-style-1">
                                                        <?php echo c27()->get_icon_markup('material-icons://email') ?>
                                                        <h5><?php esc_html_e( $block['title'], 'wedo-listing' ) ?></h5>
                                                    </div>
                                                </div>
                                                <div class="pf-body">
                                                    <p>
                                                        <?php echo str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) );?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                }
                                // Host Block.
                                if ($block['type'] == 'related_listing' && ( $related_listing = $listing->get_field( 'related_listing' ) ) ) {
                                    c27()->get_section('related-listing-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://layers',
                                        'title' => $block['title'],
                                        'related_listing' => $related_listing,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Countdown Block.
                                if ($block['type'] == 'countdown' && ( $countdown_date = $listing->get_field( $block['show_field'] ) ) ) {
                                    c27()->get_section('countdown-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://av_timer',
                                        'title' => $block['title'],
                                        'countdown_date' => $countdown_date,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Video Block.
                                if ($block['type'] == 'video' && ( $video_url = $listing->get_field( $block['show_field'] ) ) ) {
                                    c27()->get_section('video-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://videocam',
                                        'title' => $block['title'],
                                        'video_url' => $video_url,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                if ( in_array( $block['type'], [ 'table', 'accordion', 'tabs', 'details' ] ) ) {
                                    $rows = [];
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'rows') {
                                            foreach ((array) $option['value'] as $row) {
                                                if ( ! is_array( $row ) || empty( $row['show_field'] ) ) {
                                                    continue;
                                                }
                                                if ( ! ( $row_field = $listing->get_field( $row['show_field'] ) ) ) {
                                                    continue;
                                                }
                                                if ( is_array( $row_field ) ) {
                                                    $row_field = join( ', ', $row_field );
                                                }
                                                $rows[] = [
                                                    'title' => $row['label'],
                                                    'content' => $listing->compile_field_string( $row['content'], $row_field ),
                                                    'icon' => isset( $row['icon'] ) ? $row['icon'] : '',
                                                ];
                                            }
                                        }
                                    }
                                }
                                // Table Block.
                                if ( $block['type'] == 'table' && count( $rows ) ) {
                                    c27()->get_section('table-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Details Block.
                                if ( $block['type'] == 'details' && count( $rows ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'item_interface' => 'CASE27_DETAILS_ARRAY',
                                        'items' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Accordion Block.
                                if ( $block['type'] == 'accordion' && count( $rows ) ) {
                                    c27()->get_section('accordion-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Tabs Block.
                                if ( $block['type'] == 'tabs' && count( $rows ) ) {
                                    c27()->get_section('tabs-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Work Hours Block.
                                if ($block['type'] == 'work_hours' && ( $work_hours = $listing->get_field( 'work_hours' ) ) ) {
                                    c27()->get_section('work-hours-block', [
                                        'wrapper_class' => $block_wrapper_class . ' open-now sl-zindex',
                                        'ref' => 'single-listing',
                                        'title' => $block['title'],
                                        'icon' => 'material-icons://alarm',
                                        'hours' => (array) $work_hours,
                                    ]);
                                }
                                // Social Networks (Links) Block.
                                if ( $block['type'] == 'social_networks' && ( $networks = $listing->get_social_networks() ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'item_interface' => 'CASE27_LINK_ARRAY',
                                        'items' => $networks,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Author Block.
                                if ($block['type'] == 'author') {
                                    c27()->get_section('author-block', [
                                        'icon' => 'material-icons://account_circle',
                                        'ref' => 'single-listing',
                                        'author' => $listing->get_author(),
                                        'title' => $block['title'],
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Code block.
                                if ( $block['type'] == 'code' && ! empty( $block['content'] ) ) {
                                    if ( ( $content = $listing->compile_string( $block['content'] ) ) ) {
                                        c27()->get_section('raw-block', [
                                            'icon' => 'material-icons://view_module',
                                            'ref' => 'single-listing',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'content' => $content,
                                            'do_shortcode' => true,
                                        ]);
                                    }
                                }
                                // Raw content block.
                                if ( $block['type'] == 'raw' ) {
                                    $content = '';
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'content') $content = $option['value'];
                                    }
                                    if ( $content ) {
                                        c27()->get_section('raw-block', [
                                            'icon' => 'material-icons://view_module',
                                            'ref' => 'single-listing',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'content' => $content,
                                        ]);
                                    }
                                }
                                do_action( "case27/listing/blocks/{$block['type']}", $block );
                            endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'comments'): ?>
                    <div >
                        <?php $GLOBALS['case27_reviews_allow_rating'] = $listing->type->is_rating_enabled() ?>
                        <?php comments_template() ?>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'related_listings'): ?>
                    <input type="hidden" class="case27-related-listing-type" value="<?php echo esc_attr( $menu_item['related_listing_type'] ) ?>">
                    <div class="container c27-related-listings-wrapper reveal">
                        <div class="row listings-loading" v-show="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="loader-bg">
                                <?php c27()->get_partial('spinner', [
                                    'color' => '#777',
                                    'classes' => 'center-vh',
                                    'size' => 28,
                                    'width' => 3,
                                    ]); ?>
                            </div>
                        </div>
                        <div class="row section-body i-section" v-show="!related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="c27-related-listings" v-html="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].html" :style="!related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].show ? 'opacity: 0;' : ''"></div>
                        </div>
                        <div class="row">
                            <div class="c27-related-listings-pagination" v-html="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].pagination"></div>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'store'):
                    $selected_ids = isset($menu_item['field']) && $listing->get_field( $menu_item['field'] ) ? (array) $listing->get_field( $menu_item['field'] ) : [];
                    ?>
                    <input type="hidden" class="case27-store-products-ids" value="<?php echo json_encode(array_map('absint', (array) $selected_ids)) ?>">
                    <div class="container c27-products-wrapper woocommerce reveal">
                        <div class="row listings-loading" v-show="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="loader-bg">
                                <?php c27()->get_partial('spinner', [
                                    'color' => '#777',
                                    'classes' => 'center-vh',
                                    'size' => 28,
                                    'width' => 3,
                                    ]); ?>
                            </div>
                        </div>
                        <div class="section-body" v-show="!products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <ul class="c27-products products" v-html="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].html" :style="!products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].show ? 'opacity: 0;' : ''"></ul>
                        </div>
                        <div class="row">
                            <div class="c27-products-pagination" v-html="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].pagination"></div>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'bookings'): ?>
                    <div class="container" >
                        <div class="row">
                            <?php // Contact Form Block.
                            if ($menu_item['provider'] == 'basic-form') {
                                $contact_form_id = absint( $menu_item['contact_form_id'] );
                                $email_to = array_filter( [$menu_item['field']] );
                                if ( $contact_form_id && count( $email_to ) ) {
                                    c27()->get_section('content-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://email',
                                        'title' => __( 'Book now', 'my-listing' ),
                                        'content' => str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) ),
                                        'wrapper_class' => 'col-md-6 col-md-push-3 col-sm-8 col-sm-push-2 col-xs-12 grid-item',
                                        'escape_html' => false,
                                        ]);
                                }
                            }
                            ?>
                            <?php // TimeKit Widget.
                            if ($menu_item['provider'] == 'timekit' && ( $timekitID = $listing->get_field( $menu_item['field'] ) ) ): ?>
                                <div class="col-md-8 col-md-push-2 c27-timekit-wrapper">
                                    <iframe src="https://my.timekit.io/<?php echo esc_attr( $timekitID ) ?>" frameborder="0"></iframe>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endif ?>
                </div>
                </div>
        <?php endforeach; ?>
</div>
</div>
</div>
                            <?php } ?>
</div>
<?php if( 0 ) : ?>
<div class="single-job-listing hidden <?php echo ! $listing_logo ? 'listing-no-logo' : '' ?>" id="c27-single-listing">
    <input type="hidden" id="case27-post-id" value="<?php echo esc_attr( get_the_ID() ) ?>">
    <input type="hidden" id="case27-author-id" value="<?php echo esc_attr( get_the_author_meta('ID') ) ?>">
    <!-- <section> opening tag is omitted -->
    <?php
    /**
     * Cover section.
     */
    $cover_template_path = sprintf( 'partials/single/cover/%s.php', $layout['cover']['type'] );
    if ( $cover_template = locate_template( $cover_template_path ) ) {
        require $cover_template;
    } else {
        require locate_template( 'partials/single/cover/none.php' );
    }
    /**
     * Cover buttons.
     */
    require locate_template( 'partials/single/buttons/buttons.php' );
    ?>
    </section>
    <div class="profile-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div >
                        <?php if ( $listing_logo ):
                            $listing_logo_large = $listing->get_logo( 'full' ); ?>
                            <a class="profile-avatar open-photo-swipe"
                               href="<?php echo esc_url( $listing_logo_large ) ?>"
                               style="background-image: url('<?php echo esc_url( $listing_logo ) ?>')"
                               >
                            </a>
                        <?php endif ?>
                    </div>
                    <div class="profile-name" >
                        <h1 class="case27-primary-text"><?php the_title() ?></h1>
                        <?php if ( $listing->get_field('job_tagline') ): ?>
                            <h2 class="profile-tagline listing-tagline-field"><?php echo esc_html( $listing->get_field('job_tagline') ) ?></h2>
                        <?php elseif ( $listing->get_field('job_description') ): ?>
                            <h2 class="profile-tagline listing-description-field"><?php echo c27()->the_text_excerpt( wp_kses( $listing->get_field('job_description'), [] ), 77 ) ?></h2>
                        <?php endif ?>
                    </div>
                    <div class="cover-details" >
                        <ul></ul>
                    </div>
                    <div class="profile-menu">
                        <ul role="tablist">
                            <?php $i = 0;
                            foreach ((array) $layout['menu_items'] as $key => $menu_item): $i++;
                                if (
                                    $menu_item['page'] == 'bookings' &&
                                    $menu_item['provider'] == 'timekit' &&
                                    ! $listing->get_field( $menu_item['field'] )
                                ) { continue; }
                                ?><li class="<?php echo ($i == 1) ? 'active' : '' ?>">
                                    <a href="<?php echo "#_tab_{$i}" ?>" aria-controls="<?php echo esc_attr( "_tab_{$i}" ) ?>" data-section-id="<?php echo esc_attr( "_tab_{$i}" ) ?>"
                                       role="tab" class="tab-reveal-switch <?php echo esc_attr( "toggle-tab-type-{$menu_item['page']}" ) ?>">
                                        <?php echo esc_html( $menu_item['label'] ) ?>
                                        <?php if ($menu_item['page'] == 'comments'): ?>
                                            <span class="items-counter"><?php echo get_comments_number() ?></span>
                                        <?php endif ?>
                                        <?php if (in_array($menu_item['page'], ['related_listings', 'store'])):
                                            $vue_data_keys = ['related_listings' => 'related_listings', 'store' => 'products'];
                                            ?>
                                            <span class="items-counter" v-if="<?php echo esc_attr( $vue_data_keys[$menu_item['page']] ) ?>['_tab_<?php echo esc_attr( $i ) ?>'].loaded" v-cloak>
                                                {{ <?php echo $vue_data_keys[$menu_item['page']] ?>['_tab_<?php echo $i ?>'].count }}
                                            </span>
                                            <span v-else class="c27-tab-spinner">
                                                <i class="fa fa-circle-o-notch fa-spin"></i>
                                            </span>
                                        <?php endif ?>
                                    </a>
                                </li><?php
                            endforeach; ?>
                            <div id="border-bottom"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-content">
        <?php $i = 0; ?>
        <?php foreach ((array) $layout['menu_items'] as $key => $menu_item): $i++; ?>
            <section class="tab-pane profile-body <?php echo ($i == 1) ? 'active' : '' ?> <?php echo esc_attr( "tab-type-{$menu_item['page']}" ) ?>" id="<?php echo esc_attr( "_tab_{$i}" ) ?>" role="tabpanel">
                <?php if ($menu_item['page'] == 'main' || $menu_item['page'] == 'custom'): ?>
                    <div class="container" >
                        <div class="row grid reveal">
                            <?php foreach ($menu_item['layout'] as $block):
                                $block_wrapper_class = 'col-md-6 col-sm-12 col-xs-12 grid-item';
                                if ( ! empty( $block['type'] ) ) {
                                    $block_wrapper_class .= ' block-type-' . esc_attr( $block['type'] );
                                }
                                if ( ! empty( $block['show_field'] ) ) {
                                    $block_wrapper_class .= ' block-field-' . esc_attr( $block['show_field'] );
                                }
                                if (
                                    $listing->type && ! empty( $block['show_field'] ) &&
                                    $listing->get_field( $block['show_field'] ) &&
                                    $listing->type->get_field( $block['show_field'] )
                                ) {
                                    $field = $listing->type->get_field( $block['show_field'] );
                                } else {
                                    $field = null;
                                }
                                // Text Block.
                                if ( $block['type'] == 'text' && isset( $block['show_field'] ) && ( $block_content = $listing->get_field( $block['show_field'] ) ) ) {
                                    $escape_html = true;
                                    $allow_shortcodes = false;
                                    if ( $field ) {
                                        if ( ! empty( $field['type'] ) && $field['type'] == 'wp-editor' ) {
                                            $escape_html = false;
                                        }
                                        if ( ! empty( $field['type'] ) && $field['type'] == 'texteditor' ) {
                                            $escape_html = empty( $field['editor-type'] ) || $field['editor-type'] == 'textarea';
                                            $allow_shortcodes = ! empty( $field['allow-shortcodes'] ) && $field['allow-shortcodes'] && ! $escape_html;
                                        }
                                    }
                                    c27()->get_section('content-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_headline',
                                        'title' => $block['title'],
                                        'content' => $block_content,
                                        'wrapper_class' => $block_wrapper_class,
                                        'escape_html' => $escape_html,
                                        'allow-shortcodes' => $allow_shortcodes,
                                        ]);
                                }
                                // Gallery Block.
                                if ( $block['type'] == 'gallery' && ( $gallery_items = (array) $listing->get_field( $block['show_field'] ) ) ) {
                                    $gallery_type = 'carousel';
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'gallery_type') $gallery_type = $option['value'];
                                    }
                                    if ( array_filter( $gallery_items ) ) {
                                        c27()->get_section('gallery-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://insert_photo',
                                            'title' => $block['title'],
                                            'gallery_type' => $gallery_type,
                                            'wrapper_class' => $block_wrapper_class,
                                            'gallery_items' => array_filter( $gallery_items ),
                                            'gallery_item_interface' => 'CASE27_JOB_MANAGER_ARRAY',
                                            ]);
                                    }
                                }
                                // Files Block.
                                if ( $block['type'] == 'file' && ( $files = (array) $listing->get_field( $block['show_field'] ) ) ) {
                                    if ( array_filter( $files ) ) {
                                        c27()->get_section('files-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://attach_file',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'items' => array_filter( $files ),
                                            ]);
                                    }
                                }
                                // Categories Block.
                                if ( $block['type'] == 'categories' && ( $terms = $listing->get_field( 'job_category' ) ) ) {
                                    c27()->get_section('listing-categories-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'terms' => $terms,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Tags Block.
                                if ( $block['type'] == 'tags' && ( $terms = $listing->get_field( 'job_tags' ) ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'items' => $terms,
                                        'item_interface' => 'WP_TERM',
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                if ( $block['type'] == 'terms' ) {
                                    // Keys = taxonomy name
                                    // Value = taxonomy field name
                                    $taxonomies = [
                                        'job_listing_category' => 'job_category',
                                        'case27_job_listing_tags' => 'job_tags',
                                        'region' => 'region',
                                    ];
                                    $taxonomy = 'job_listing_category';
                                    $template = 'listing-categories-block';
                                    if ( isset( $block['options'] ) ) {
                                        foreach ((array) $block['options'] as $option) {
                                            if ($option['name'] == 'taxonomy') $taxonomy = $option['value'];
                                            if ($option['name'] == 'style') $template = $option['value'];
                                        }
                                    }
                                    if ( ! isset( $taxonomies[ $taxonomy ] ) ) {
                                        continue;
                                    }
                                    if ( $terms = $listing->get_field( $taxonomies[ $taxonomy ] ) ) {
                                        if ( $template == 'list-block' ) {
                                            c27()->get_section('list-block', [
                                                'ref' => 'single-listing',
                                                'icon' => 'material-icons://view_module',
                                                'title' => $block['title'],
                                                'items' => $terms,
                                                'item_interface' => 'WP_TERM',
                                                'wrapper_class' => $block_wrapper_class,
                                            ]);
                                        } else {
                                            c27()->get_section('listing-categories-block', [
                                                'ref' => 'single-listing',
                                                'icon' => 'material-icons://view_module',
                                                'title' => $block['title'],
                                                'terms' => $terms,
                                                'wrapper_class' => $block_wrapper_class,
                                            ]);
                                        }
                                    }
                                }
                                // Location Block.
                                if ( $block['type'] == 'location' && isset( $block['show_field'] ) && ( $block_location = $listing->get_field( $block['show_field'] ) ) ) {
                                    if ( ! ( $listing_logo = $listing->get_logo( 'thumbnail' ) ) ) {
                                        $listing_logo = c27()->image( 'marker.jpg' );
                                    }
                                    $location_arr = [
                                        'address' => $block_location,
                                        'marker_image' => ['url' => $listing_logo],
                                    ];
                                    if ( $block['show_field'] == 'job_location' && ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
                                        $location_arr = [
                                            'marker_lat' => $lat,
                                            'marker_lng' => $lng,
                                            'marker_image' => ['url' => $listing_logo],
                                        ];
                                    }
                                    $map_skin = 'skin1';
                                    if ( ! empty( $block['options'] ) ) {
                                        foreach ((array) $block['options'] as $option) {
                                            if ($option['name'] == 'map_skin') $map_skin = $option['value'];
                                        }
                                    }
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'title' => $block['title'],
                                        'wrapper_class' => $block_wrapper_class,
                                        'template' => 'block',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 11,
                                            'draggable' => false,
                                            'skin' => $map_skin,
                                        ],
                                    ]);
                                }
                                // Contact Form Block.
                           /*     if ($block['type'] == 'contact_form') {
                                    $contact_form_id = false;
                                    $email_to = ['job_email'];
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'contact_form_id') $contact_form_id = absint( $option['value'] );
                                        if ($option['name'] == 'email_to') $email_to = $option['value'];
                                    }
                                    $email_to = array_filter( $email_to );
                                    if ( $contact_form_id && count( $email_to ) ) {
                                        c27()->get_section('content-block', [
                                            'ref' => 'single-listing',
                                            'icon' => 'material-icons://email',
                                            'title' => $block['title'],
                                            'content' => str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) ),
                                            'wrapper_class' => $block_wrapper_class,
                                            'escape_html' => false,
                                        ]);
                                    }
                                } */
                                // Host Block.
                                if ($block['type'] == 'related_listing' && ( $related_listing = $listing->get_field( 'related_listing' ) ) ) {
                                    c27()->get_section('related-listing-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://layers',
                                        'title' => $block['title'],
                                        'related_listing' => $related_listing,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Countdown Block.
                                if ($block['type'] == 'countdown' && ( $countdown_date = $listing->get_field( $block['show_field'] ) ) ) {
                                    c27()->get_section('countdown-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://av_timer',
                                        'title' => $block['title'],
                                        'countdown_date' => $countdown_date,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Video Block.
                                if ($block['type'] == 'video' && ( $video_url = $listing->get_field( $block['show_field'] ) ) ) {
                                    c27()->get_section('video-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://videocam',
                                        'title' => $block['title'],
                                        'video_url' => $video_url,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                if ( in_array( $block['type'], [ 'table', 'accordion', 'tabs', 'details' ] ) ) {
                                    $rows = [];
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'rows') {
                                            foreach ((array) $option['value'] as $row) {
                                                if ( ! is_array( $row ) || empty( $row['show_field'] ) ) {
                                                    continue;
                                                }
                                                if ( ! ( $row_field = $listing->get_field( $row['show_field'] ) ) ) {
                                                    continue;
                                                }
                                                if ( is_array( $row_field ) ) {
                                                    $row_field = join( ', ', $row_field );
                                                }
                                                $rows[] = [
                                                    'title' => $row['label'],
                                                    'content' => $listing->compile_field_string( $row['content'], $row_field ),
                                                    'icon' => isset( $row['icon'] ) ? $row['icon'] : '',
                                                ];
                                            }
                                        }
                                    }
                                }
                                // Table Block.
                                if ( $block['type'] == 'table' && count( $rows ) ) {
                                    c27()->get_section('table-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Details Block.
                                if ( $block['type'] == 'details' && count( $rows ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'item_interface' => 'CASE27_DETAILS_ARRAY',
                                        'items' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Accordion Block.
                                if ( $block['type'] == 'accordion' && count( $rows ) ) {
                                    c27()->get_section('accordion-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Tabs Block.
                                if ( $block['type'] == 'tabs' && count( $rows ) ) {
                                    c27()->get_section('tabs-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'rows' => $rows,
                                        'wrapper_class' => $block_wrapper_class,
                                        ]);
                                }
                                // Work Hours Block.
                                if ($block['type'] == 'work_hours' && ( $work_hours = $listing->get_field( 'work_hours' ) ) ) {
                                    c27()->get_section('work-hours-block', [
                                        'wrapper_class' => $block_wrapper_class . ' open-now sl-zindex',
                                        'ref' => 'single-listing',
                                        'title' => $block['title'],
                                        'icon' => 'material-icons://alarm',
                                        'hours' => (array) $work_hours,
                                    ]);
                                }
                                // Social Networks (Links) Block.
                                if ( $block['type'] == 'social_networks' && ( $networks = $listing->get_social_networks() ) ) {
                                    c27()->get_section('list-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://view_module',
                                        'title' => $block['title'],
                                        'item_interface' => 'CASE27_LINK_ARRAY',
                                        'items' => $networks,
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Author Block.
                                if ($block['type'] == 'author') {
                                    c27()->get_section('author-block', [
                                        'icon' => 'material-icons://account_circle',
                                        'ref' => 'single-listing',
                                        'author' => $listing->get_author(),
                                        'title' => $block['title'],
                                        'wrapper_class' => $block_wrapper_class,
                                    ]);
                                }
                                // Code block.
                                if ( $block['type'] == 'code' && ! empty( $block['content'] ) ) {
                                    if ( ( $content = $listing->compile_string( $block['content'] ) ) ) {
                                        c27()->get_section('raw-block', [
                                            'icon' => 'material-icons://view_module',
                                            'ref' => 'single-listing',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'content' => $content,
                                            'do_shortcode' => true,
                                        ]);
                                    }
                                }
                                // Raw content block.
                                if ( $block['type'] == 'raw' ) {
                                    $content = '';
                                    foreach ((array) $block['options'] as $option) {
                                        if ($option['name'] == 'content') $content = $option['value'];
                                    }
                                    if ( $content ) {
                                        c27()->get_section('raw-block', [
                                            'icon' => 'material-icons://view_module',
                                            'ref' => 'single-listing',
                                            'title' => $block['title'],
                                            'wrapper_class' => $block_wrapper_class,
                                            'content' => $content,
                                        ]);
                                    }
                                }
                                do_action( "case27/listing/blocks/{$block['type']}", $block );
                            endforeach ?>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'comments'): ?>
                    <div >
                        <?php $GLOBALS['case27_reviews_allow_rating'] = $listing->type->is_rating_enabled() ?>
                        <?php comments_template() ?>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'related_listings'): ?>
                    <input type="hidden" class="case27-related-listing-type" value="<?php echo esc_attr( $menu_item['related_listing_type'] ) ?>">
                    <div class="container c27-related-listings-wrapper reveal">
                        <div class="row listings-loading" v-show="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="loader-bg">
                                <?php c27()->get_partial('spinner', [
                                    'color' => '#777',
                                    'classes' => 'center-vh',
                                    'size' => 28,
                                    'width' => 3,
                                    ]); ?>
                            </div>
                        </div>
                        <div class="row section-body i-section" v-show="!related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="c27-related-listings" v-html="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].html" :style="!related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].show ? 'opacity: 0;' : ''"></div>
                        </div>
                        <div class="row">
                            <div class="c27-related-listings-pagination" v-html="related_listings['<?php echo esc_attr( "_tab_{$i}" ) ?>'].pagination"></div>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'store'):
                    $selected_ids = isset($menu_item['field']) && $listing->get_field( $menu_item['field'] ) ? (array) $listing->get_field( $menu_item['field'] ) : [];
                    ?>
                    <input type="hidden" class="case27-store-products-ids" value="<?php echo json_encode(array_map('absint', (array) $selected_ids)) ?>">
                    <div class="container c27-products-wrapper woocommerce reveal">
                        <div class="row listings-loading" v-show="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <div class="loader-bg">
                                <?php c27()->get_partial('spinner', [
                                    'color' => '#777',
                                    'classes' => 'center-vh',
                                    'size' => 28,
                                    'width' => 3,
                                    ]); ?>
                            </div>
                        </div>
                        <div class="section-body" v-show="!products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].loading">
                            <ul class="c27-products products" v-html="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].html" :style="!products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].show ? 'opacity: 0;' : ''"></ul>
                        </div>
                        <div class="row">
                            <div class="c27-products-pagination" v-html="products['<?php echo esc_attr( "_tab_{$i}" ) ?>'].pagination"></div>
                        </div>
                    </div>
                <?php endif ?>
                <?php if ($menu_item['page'] == 'bookings'): ?>
                    <div class="container" >
                        <div class="row">
                            <?php // Contact Form Block.
                            if ($menu_item['provider'] == 'basic-form') {
                                $contact_form_id = absint( $menu_item['contact_form_id'] );
                                $email_to = array_filter( [$menu_item['field']] );
                                if ( $contact_form_id && count( $email_to ) ) {
                                    c27()->get_section('content-block', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://email',
                                        'title' => __( 'Book now', 'my-listing' ),
                                        'content' => str_replace('%case27_recipients%', join('|', $email_to), do_shortcode( sprintf( '[contact-form-7 id="%d"]', $contact_form_id ) ) ),
                                        'wrapper_class' => 'col-md-6 col-md-push-3 col-sm-8 col-sm-push-2 col-xs-12 grid-item',
                                        'escape_html' => false,
                                        ]);
                                }
                            }
                            ?>
                            <?php // TimeKit Widget.
                            if ($menu_item['provider'] == 'timekit' && ( $timekitID = $listing->get_field( $menu_item['field'] ) ) ): ?>
                                <div class="col-md-8 col-md-push-2 c27-timekit-wrapper">
                                    <iframe src="https://my.timekit.io/<?php echo esc_attr( $timekitID ) ?>" frameborder="0"></iframe>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                <?php endif ?>
            </section>
        <?php endforeach; ?>
    </div>
    <?php c27()->get_partial('report-modal', ['listing' => $post]) ?>
</div>
<?php endif; ?>
<?php echo apply_filters( 'mylisting\single\output_schema', $listing->schema->get_markup() ) ?>
<?php endif; ?>


<!-- Start: Phongba -->
<?php
if( $listing_listing_type == 'offre-demploi' || $listing_listing_type=='offre-demploi-en'|| $listing_listing_type=='offre-demploi-de' ) :
?>
<div class="c27-top-content-margin"></div>
<div class="single-job-listing p-single-jobboard" id="c27-single-listing">
    <input type="hidden" id="case27-post-id" value="<?php echo esc_attr( get_the_ID() ) ?>">
    <input type="hidden" id="case27-author-id" value="<?php echo esc_attr( get_the_author_meta('ID') ) ?>">
    <div class="p-result-wrapper">
        <?php $image = $listing->get_cover_image( 'full' ); ?>
        <div id="page-head" class="member-login">
        <?php if($image) {
            $media_id = giang_get_image_id($image);
            $alt = '';
            if($media_id) $alt = giang_get_media_alt( $media_id );
        ?>
            <img src="<?php echo $image;?>" alt="<?php echo $alt ? $alt : 'image'; ?>">
        <?php
            } else {
                echo '<img src="' . get_stylesheet_directory_uri() . '/assets/images/offre_d_emploi_luxembourg.jpg">';
            }
        ?>
            <div class="container clearfix">
                <div class="col-sm-12">
                    <div class="p-detail-box">
                        <?php if ( $listing->get_logo( 'medium' ) ): ?>
                        <?php
                            $media_id = giang_get_image_id($listing->get_logo( 'small' )); ;
                            $alt = 'image';
                            if($media_id) $alt = giang_get_media_alt( $media_id );
                        ?>
                            <img src="<?php echo $listing->get_logo( 'small' );?>" alt="<?php echo $alt; ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-main-content">
            <div class="container">
                <div class="headline clearfix">
                    <div class="col-sm-6 left">
                        <?php
                            $location_text = $listing->get_field('job_location');
                        ?>
                        <h2><?php the_title(); ?></h2>
                        <p><?= $listing->get_field('socit') ?><span class="margin"></span><?php if(!empty($location_text)) : ?><span class="location"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/location.svg"><?= $location_text ?></span><?php endif; ?></p>
                    </div>
                    <div class="col-sm-6 right">
                        <!-- <div class="report">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                              <g id="ico_report_default" transform="translate(-1185 -447)">
                                <rect id="bg_ico_report" width="40" height="40" transform="translate(1185 447)" fill="none"/>
                                <path id="ico_report" d="M22.043,16.756A2.708,2.708,0,0,1,19.7,20.8H2.594A2.7,2.7,0,0,1,.358,16.756L8.965,1.387a2.5,2.5,0,0,1,4.471,0l8.607,15.369Zm-1.752,1.061-.016-.028L11.669,2.419l-.058-.111a.482.482,0,0,0-.82,0l-.058.112L2.11,17.816a.62.62,0,0,0,.484.9H19.7a.63.63,0,0,0,.6-.9ZM11.1,6.24a.831.831,0,0,0-.916.714v4.812a.831.831,0,0,0,.916.714h.2a.831.831,0,0,0,.916-.714V6.954A.831.831,0,0,0,11.3,6.24Zm-.916,9.337a1.018,1.018,0,1,0,.3-.719,1.029,1.029,0,0,0-.3.719Z" transform="translate(1193.47 456.591)" fill="#b9b9b9"/>
                              </g>
                            </svg>
                        </div> -->
                        <div class="share">
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
                                  <g id="ico_share_default" transform="translate(-1255 -447)">
                                    <rect id="bg_ico_share" width="40" height="40" transform="translate(1255 447)" fill="none"/>
                                    <path id="ico_share" d="M97.645,132.873v-3.665a1.2,1.2,0,0,1,.691-1.108,1.066,1.066,0,0,1,1.221.26l7.84,8.4a1.26,1.26,0,0,1,0,1.7l-7.84,8.4a1.065,1.065,0,0,1-1.221.262,1.2,1.2,0,0,1-.691-1.11v-3.715c-.318-.024-.633-.035-.944-.035a11.912,11.912,0,0,0-9.365,4.476,1.073,1.073,0,0,1-1.247.412,1.2,1.2,0,0,1-.764-1.138C85.325,135.059,94.381,133.191,97.645,132.873Zm-1.238,7.282a14.266,14.266,0,0,1,2.1.182,1.209,1.209,0,0,1,1.053,1.153l-.266,3.093,6.181-6.975-6.181-6.824.266,3.285c0,.662-.848,1.255-1.466,1.255-1.019,0-8.979-.195-11.129,9.259C88.814,143.122,92.4,140.155,96.407,140.155Z" transform="translate(1178.557 329.151)" fill="#b9b9b9"/>
                                  </g>
                                </svg>
                            </div>
                            <ul>
                                <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_face.png">Facebook</a></li>
                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_link.png">Linkedin</a></li>
                                <li><a href="https://twitter.com/share?url=<?= get_the_permalink( get_the_ID()) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;" target="_blank"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_tw.png">Twitter</a></li>
                            </ul>
                        </div>
                        <div class="apply-now <?= ICL_LANGUAGE_CODE ?>">
                            <a href="#" class="apply-now desktop"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_btn_apply.png"><?php echo __('Apply now', 'wedo-listing'); ?></a>
                            <a href="#" class="apply-now mobile"><img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_btn_apply.png"><?php echo __('Apply now', 'wedo-listing'); ?></a>
                        </div>
                    </div>
                </div>
                <div class="p-tab-content clearfix">
                    <div class="left col-sm-6">
                        <?php if ( $description = $listing->get_field('job_description') ): ?>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_description.svg">
                                <?php _e('Job Decription', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <?php echo wpautop( $description, [] ); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                            $region_tax = wp_get_post_terms(get_the_ID(), 'region', array("fields" => "all"));
                            if($region_tax) :
                                $region_term = get_term( $region_tax[0]->term_id, 'region' );
                        ?>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_region.svg">
                                <?php _e('Area of activities', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><a href="<?= get_term_link($region_term) ?>"><?= $region_tax[0]->name; ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                            if(ICL_LANGUAGE_CODE=="en") {
                                $contact_form_shortcode = '[contact-form-7 id="40171" title="Job board EN"]';
                            } elseif(ICL_LANGUAGE_CODE=="fr") {
                                $contact_form_shortcode = '[contact-form-7 id="11780" title="Job Board FR"]';
                            } elseif(ICL_LANGUAGE_CODE=="de") {
                                $contact_form_shortcode = '[contact-form-7 id="40172" title="Job-Board DE"]';
                            }
                        ?>
                        <div class="tab desktop">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_apply.svg">
                                <?php _e('Apply Now', 'wedo-listing') ?>
                            </div>
                            <div class="content jobboard-form <?= ICL_LANGUAGE_CODE ?>">
                                <?= do_shortcode($contact_form_shortcode); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 right">
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_info.svg">
                                <?php _e('Information', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><?php _e('Role', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('job_title') ?></p>
                                </div>
                                <div class="p-row">
                                    <p><?php _e('Employment contract', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('contrat-de-travail') ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_employer.svg">
                                <?php _e('Employer', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><?php _e('Employment contract', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('contrat-de-travail') ?></p>
                                </div>
                                <?php if($listing->get_field('socit')) : ?>
                                <div class="p-row">
                                    <p><?php _e('Company', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('socit') ?></p>
                                </div>
                                <?php endif; ?>
                                <?php if($listing->get_field('personne-de-contact')) : ?>
                                <div class="p-row">
                                    <p><?php _e('Contact person', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('personne-de-contact') ?></p>
                                </div>
                                <?php endif; ?>
                                <?php if ( $listing->get_field( 'job_phone' ) ) { ?>
                                <div class="p-row">
                                    <p><?php _e('Tel', 'wedo-listing') ?></p>
                                    <p><a href="tel:<?php echo $listing->get_field( 'job_phone' );?>"><?php echo $listing->get_field( 'job_phone' );?></a></p>
                                </div>
                                <?php } ?>
                                <?php if ( $listing->get_field( 'job_email' )) { ?>
                                <div class="p-row email">
                                    <p><?php _e('Email', 'wedo-listing') ?></p>
                                    <p><a href="mailto:<?php echo $listing->get_field( 'job_email' );?>"><?php echo $listing->get_field( 'job_email' ); ?></a></p>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_language.svg">
                                <?php _e('Language levels required', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><?php _e('Luxemburgish', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('luxembourgeois') ?></p>
                                </div>
                                <div class="p-row">
                                    <p><?php _e('German', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('allemand') ?></p>
                                </div>
                                <div class="p-row">
                                    <p><?php _e('French', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('franais') ?></p>
                                </div>
                                <div class="p-row">
                                    <p><?php _e('English', 'wedo-listing') ?></p>
                                    <p><?= $listing->get_field('anglais') ?></p>
                                </div>
                            </div>
                        </div>
                        <?php
                            $numro_matricule_lentreprise = $listing->get_field('numro-matricule-de-lentreprise');
                            if($numro_matricule_lentreprise) :
                        ?>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_enterprise.svg">
                                <?php _e('Company number', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><?= $numro_matricule_lentreprise ?></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php
                            $related_listing_id = $listing->get_field('related_listing');
                            if($related_listing_id) :
                        ?>
                        <div class="tab">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_enterprise.svg">
                                <?php _e('Company', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <div class="p-row">
                                    <p><a href="<?= get_the_permalink($related_listing_id) ?>"><?= get_the_title($related_listing_id) ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="tab mobile">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_apply.svg">
                                <?php _e('Apply Now', 'wedo-listing') ?>
                            </div>
                            <div class="content jobboard-form <?= ICL_LANGUAGE_CODE ?>">
                                <?= do_shortcode($contact_form_shortcode); ?>
                            </div>
                        </div>
                        <div class="tab location">
                            <div class="title">
                                <img src="<?= get_stylesheet_directory_uri(); ?>/assets/images/ico_map.svg">
                                <?php _e('Location', 'wedo-listing') ?>
                            </div>
                            <div class="content">
                                <?php if ( $listing->get_field( 'job_location' ) ) {
                                    if ( ! ( $listing_logo = $listing->get_logo( 'thumbnail' ) ) ) {
                                        $listing_logo = c27()->image( 'marker.jpg' );
                                    }
                                    $location_arr = [
                                        'address' => $listing->get_field( 'job_location' ),
                                        'marker_image' => ['url' => $listing_logo],
                                    ];
                                    if ( ( $lat = $listing->get_data('geolocation_lat') ) && ( $lng = $listing->get_data('geolocation_long') ) ) {
                                        $location_arr = [
                                            'marker_lat' => $lat,
                                            'marker_lng' => $lng,
                                            'marker_image' => ['url' => $listing_logo],
                                        ];
                                    }
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 11,
                                            'draggable' => false,
                                            'skin' => 'skin5',
                                        ],
                                    ]);
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!-- End: Phongba -->
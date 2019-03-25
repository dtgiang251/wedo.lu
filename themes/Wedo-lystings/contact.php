<?php /* Template name: Contact */
get_header();?>
<div id="pagehead" class="vh-center">
	<?php
		$media_id = giang_get_image_id(get_field('page_banner')); ;
		$alt = 'image';
		if($media_id) $alt = giang_get_media_alt( $media_id );
	?>
    <img class="pagehead-image" src="<?php the_field('page_banner');?>" alt="<?php echo $alt; ?>">
    <div class="container">
        <h3><?php the_title();?></h3>
    </div>
</div>


<div class="wrap-content pt-0">
    <div class="map">
        <?php 
                    $location_arr = [
                                        'address' => get_field('address'),
                                        'marker_image' => ['url' => ''],
                                    ];
                                    
                                    c27()->get_section('map', [
                                        'ref' => 'single-listing',
                                        'icon' => 'material-icons://map',
                                        'options' => [
                                            'locations' => [ $location_arr ],
                                            'zoom' => 15,
                                            'draggable' => false,
                                            'skin' => 'skin5',
                                        ],
                                    ]); ?>
        <div class="container">
            <div class="box1">
                <ul class="contact-details">
                    <li>
                        <i class="fa fa-map-marker"></i>
                        <?php the_field('address');?>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        <?php the_field('phone');?>
                    </li>
                    <li>
                        <a href="mailto:<?php the_field('email');?>">
                            <i class="fa fa-envelope-o"></i>
                            <?php the_field('email');?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php the_field('website');?>" target="_blank">
                            <i class="fa fa-globe"></i>
                            <?php the_field('website');?>
                        </a>
                    </li>
                </ul>
            </div>            
        </div>
    </div>
</div>
<?php get_footer();?>
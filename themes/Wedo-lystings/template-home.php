<?php /* Template Name: Home Page */ ?>
<?php get_header();?>
<?php while(have_posts()): the_post(); $slideshow = get_field('slideshow'); ?>
<?php if( $slideshow ):  ?>
     <div id="slideshow-secondary">
        <?php
			$key = array_rand( $slideshow,1 );
			$image = $slideshow[$key]['image'];
			$media_id = giang_get_image_id( $image ); ;
			$alt = 'image';
			if($media_id) $alt = giang_get_media_alt( $media_id );
			
			$img_html = '<img class="banner-image" src="'. $image .'" alt="'. $alt .'">';
			echo $img_html;
		?>
     </div>
<?php endif;?>
     <div class="intro-section section1">
        <div class="container">
           <div class="search-box search-form">
              <h2 class="text-center"><?php the_field('search_box_heading');?></h2>
              <h3 class="text-center"><?php the_field('search_box_description');?></h3>
              <form method="GET" action="<?php echo home_url('/');?>annuaire-2/">						
			  <div class="explore-filter md-group wp-search-filter  md-active">
              <input type="text" v-model="facets['place']['search_keywords']" id="5ad486db6a5d5__facet" name="search_keywords" placeholder="<?php _e('What are you looking for ?','wedo-listing');?>" @keyup="getListings">
              <input type="submit" value="<?php _e('Find a craftsman','wedo-listing');?>">
              </div>
			<input type="hidden" name="tab" value="search-form">
    		 <input type="hidden" name="type" value="place">
			</form>
           </div>
          
        </div>
     </div>
     
<?php endwhile;?>
<?php get_footer();?>
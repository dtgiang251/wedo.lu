<?php
    // Post preview. Use within the loop.
    $defaults = [
        'wrap_in' => '',
    ];

	global $post;
	
    $categories = array_filter((array) get_the_terms(get_the_ID(), 'category'));

    $image = c27()->featured_image(get_the_ID(), 'large');

    if ( ! $image ) $image = c27()->get_setting('blog_default_post_image');

    if (is_array($image) && isset($image['sizes'])) {
        $image = $image['sizes']['large'];
    }
?>

<div class="blog-list">
<div class="img-wrap">
  <?php if($image) : ?><a href="<?php the_permalink(); ?>"><img src="<?php echo $image; ?>" alt="<?php the_title(); ?>"></a><?php endif; ?>
</div>
<div class="blog-content">
  <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
  <?php if ( ! is_wp_error( $categories ) && count( $categories ) ):
		$category_count = count( $categories );

		$first_category = array_shift($categories);
		$first_ctg = new MyListing\Src\Term( $first_category );
		$category_names = array_map(function($category) {
			return $category->name;
		}, $categories);
		$categories_string = join('<br>', $category_names);
		?>
  <div class="tips"><a href="<?php echo esc_url( $first_ctg->get_link() ) ?>"><?php echo esc_html( $first_ctg->get_name() ) ?></a> <span><?php echo $category_count - 1 ?></span></div>
  <?php endif ?>
  <span class="blog-date"><?php echo mysql2date('d M, Y', $post->post_date); ?></span>
  <p><?php c27()->the_excerpt(150) ?></p>
  <a href="<?php the_permalink(); ?>" class="b-r-more"><?php echo __('Read More', 'wedo-listing'); ?></a>
</div>
</div>
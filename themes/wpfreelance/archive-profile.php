<?php
/**
 * @key:archive-profile.php
 */
get_header(); ?>
<div class="full-width main-archive">
	<div class="container site-container">
		<div id="content" >
			<div class="set-bg full">
				<div class="col-md-3 sidebar sidebar-search set-bg box-shadown" id="sidebar">
					<?php get_template_part( 'sidebar/archive', 'profiles' ); ?>
				</div>
				<div class="col-md-9 no-padding-right" id="right_column">
					<div class="full set-bg box-shadown">
						<div class="col-md-12" id = "search_line">
							<form action="" class="full frm-search">
								<div class="input-group full">
							       <input type="text" name="s" id="keyword"  required placeholder="Search..." value="<?php echo get_search_query();?>" class="form-control required" />
							       <div class="input-group-btn">
							           <button class="btn btn-info primary-bg"> <i class="fa fa-search" aria-hidden="true"></i>  </button>
							       </div>
							   </div>
							</form>
							<div class="full hide" id="count_results">
								<h5> &nbsp;<?php printf( __('There are %s profiles.','boxtheme'), $wp_query->found_posts )?>	</h5>
							</div>
						</div>

						<div class="list-project" id="ajax_result">
							<?php
								global $wp_query;
								if( have_posts() ): ?>
								<div class="col-md-12 count-result"><div class="full"><h5><?php printf(__('There are %s profiles.','boxtheme'),$wp_query->found_posts);?></h5></div><div></div></div>
									<?php
									while( have_posts() ):the_post();
										get_template_part( 'template-parts/profile/profile', 'loop' );
									endwhile;
									bx_pagenate();
								endif;
								wp_reset_query();
							?>
						</div>
					</div>
				</div>
			</div><!-- .set bg !-->
		</div> <!-- .row !-->
	</div>
</div>
<script type="text/html" id="tmpl-search-record">
	<div class="archive-profile-item">
		<div class="full">
			<div class="col-md-2 no-padding col-xs-3 col-avatar">
				<a class="avatar" href = "{{{data.author_link}}}">{{{data.avatar}}}</a>
			</div>
			<div class="col-md-10 align-left  col-xs-9 res-content res-second-line no-padding-right">

				<h3 class="profile-title no-margin col-xs-12">
					<a class="" href = "{{{data.author_link}}}">{{{data.post_title}}}</a>
				</h3>
				<span class="inline second-line col-md-12 col-xs-12">
					<span class="item professional-title primary-color">{{{data.professional_title}}}</span>
				</span>

				<span class="inline list-info col-md-12 no-padding-right no-padding-left">
					<span class=" item hour-rate col-md-3  no-padding-left"><i class="fa fa-clock-o " aria-hidden="true"></i><span class="txt-rate">{{{data.hour_rate_text}}}</span></span>
					<span class=" item eared-txt col-md-3 col-xs-4 text-center">{{{data.earned_txt}}} </span>
					<span class=" item country-profile col-md-3 col-xs-4 text-center"> <i class="fa fa-map-marker" aria-hidden="true"></i> {{{data.country}}} </span>
					<span class="item profile-rating col-md-3 col-xs-4 no-padding-right text-right hidden-xs">
						<start class="rating-score {{{data.score_class}}}">
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
							<i class="fa fa-star" aria-hidden="true"></i>
						</start>
					</span>
				</span>
			</div>
			<div class="col-md-10 align-left  col-xs-12 res-content no-padding-right">
				<span class="overview-profile clear col-xs-12">{{{data.short_des}}}</span>
				<small class="clear skills">{{{data.skill_text}}}</small>
			</div>
		</div>
	</div>

</script>
<script type="text/javascript">
	(function($){
		var h_right = $("#right_column").css('height'),
			h_left = $("#sidebar").css('height');
			$(".list-project").css('min-height',h_left);
		if( parseInt(h_left) > parseInt(h_right) ){

			$(".list-project").css('height',h_left);
		}

	})(jQuery);
</script>
<?php get_footer();

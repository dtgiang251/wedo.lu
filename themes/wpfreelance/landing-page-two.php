<?php
/**
 *	Template Name: LandingPage 2
 */
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

<div class="full-width main-banner">
	<div class="container">
		<div class="heading-aligner">
	        <h1>#JOIN OUR FREELANCE COMMUNITY</h1>
	        <p>We know it's hard to find a online expert when you need one,
	            which is why we've set on a mission to bring them all to one place.
	        </p>
	        <!-- CREATE PRODILE BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="" class="btn review-btn btn-action">
	                Create a Profile            </a>
	        </div>
	        <!-- POST A PROJECT BUTTON -->
	        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	            <a href="<?php echo home_url("post-project");?>/" class="btn   review-btn find-btn btn-action">Post a Project</a>
	        </div>
	    </div>
	</div>
</div>
<div class="full-width top-profile">
	<div class=" container site-container">
		<div class="row">
		<div class="col-md-12">
			<h2> TOP RATING FREELANCER</h2>
		</div>
		<?php
		$profile_query = new WP_Query( array (
			'post_type' => PROFILE,
			'post_status' => 'publish',
			'orderby'   => 'meta_value_num',
			'meta_key'  => RATING_SCORE,
			'order'     => 'DESC',
			'orderby'    => 'meta_value_num',
			'order'      => 'DESC',

			'showposts' => 6
			)
		);
		if( $profile_query->have_posts() ){
			while( $profile_query->have_posts() ){
				global $post;
				$profile_query->the_post();
				$rating = get_post_meta($post->ID,RATING_SCORE, true);
				get_template_part( 'template-parts/profile/profile', 'loop' );
			}
		}
		?>

	</div>
	</div> <!-- .row !-->
</div>
<div class="full-width workflow">
	<div class=" container site-container">
		<di class="col-md-12">
			<h2> HOW WE WORK</h2>
			<div id="exTab1">
				<ul  class="nav nav-pills">
					<li class="active">
		        		<a  href="#1a" data-toggle="tab">Employer</a>
					</li>
					<li><a href="#2a" data-toggle="tab">Freelancer</a>
					</li>

				</ul>

					<div class="tab-content clearfix">
						<div class="tab-pane active" id="1a">
				          	<h3>As an employer</h3>
				          	On Upwork you’ll find a range of top talent, from programmers to designers, writers, customer support reps, and more.

							Start by posting a job. Tell us about your project and the specific skills required. Learn how.
							Upwork analyzes your needs. Our search functionality uses data science to highlight freelancers based on their skills, helping you find talent that’s a good match.
							We send you a shortlist of likely candidates. You can also search our site for talent, and freelancers can view your job and submit proposals too.

						</div>
						<div class="tab-pane" id="2a">
				        <h3> As a freelancer</h3>
						Start by posting a job. Tell us about your project and the specific skills required. Learn how.
						Upwork analyzes your needs. Our search functionality uses data science to highlight freelancers based on their skills, helping you find talent that’s a good match.
						We send you a shortlist of likely candidates. You can also search our site for talent, and freelancers can view your job and submit proposals too.
						</div>
				        <div class="tab-pane" id="3a">
				          <h3>List FAQ</h3>
		          			<label> how to withdraw money </label> <br />
		          			<label> how to withdraw money </label><br />
		          			<label> how to withdraw money </label><br />
		          			<label> how to withdraw money </label><br />
						</div>

				</div>
			</div> <!-- #exTab1 !-->
		</di>
	</div>
</div>
<div class="full-width packge-plan">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Basic</span>
			      		<span>For<strong> Small Business</strong></span>
						<span class="plan-monthly-old"><strike>$49/mo</strike></span>
						<span class="plan-free-trial">14 Day Post jobs.</span>
					</header>

		    		<ul class="plan-features">
						<li class="padding hide-annually"><a class="tooltips tooltips-big nodecorated"><b>3k</b>Visitors per month<span style="top: 25.9219px; left: 19.0156px;"><strong>~60 conversions/mo</strong>Assuming 2% Conversion Rate &amp; full use of monthly traffic</span></a></li>

				      	<li><span class="unavailable">Dedicated Account Manager</span></li>
				      	<li><a class="tooltips unavailable">Technical Support<span style="top: 25.9219px; left: 19.0156px;">Custom Scripts/Coding from our developers</span></a></li>

					</ul>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">START FREE TRIAL NOW</a>

				</div>
			</div>
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Premium</span>
			      		<span>For<strong> Big Business</strong></span>
						<span class="plan-monthly-old"><strike>$49/mo</strike></span>
						<span class="plan-free-trial">14 Day Post jobs.</span>
					</header>

		    		<ul class="plan-features">
						<li class="padding hide-annually"><a class="tooltips tooltips-big nodecorated"><b>3k</b>Visitors per month<span style="top: 25.9219px; left: 19.0156px;"><strong>~60 conversions/mo</strong>Assuming 2% Conversion Rate &amp; full use of monthly traffic</span></a></li>

				      	<li><span class="unavailable">Dedicated Account Manager</span></li>
				      	<li><a class="tooltips unavailable">Technical Support<span style="top: 25.9219px; left: 19.0156px;">Custom Scripts/Coding from our developers</span></a></li>

					</ul>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">TRAIL NOW</a>

				</div>
			</div>
			<div class="col-md-4">
				<div class="pricing-table-plan">
					<header data-plan="basic" class="pricing-plan-header basic-plan">
						<span class="plan-name">Standard</span>
			      		<span>For<strong> Small Business</strong></span>
						<span class="plan-monthly-old"><strike>$49/mo</strike></span>
						<span class="plan-free-trial">14 Day Post jobs.</span>
					</header>

		    		<ul class="plan-features">
						<li class="padding hide-annually"><a class="tooltips tooltips-big nodecorated"><b>3k</b>Visitors per month<span style="top: 25.9219px; left: 19.0156px;"><strong>~60 conversions/mo</strong>Assuming 2% Conversion Rate &amp; full use of monthly traffic</span></a></li>

				      	<li><span class="unavailable">Dedicated Account Manager</span></li>
				      	<li><a class="tooltips unavailable">Technical Support<span style="top: 25.9219px; left: 19.0156px;">Custom Scripts/Coding from our developers</span></a></li>

					</ul>
		            <a class="btn btn-primary1 btn-xlarge btn-orange" href="https://cloud.landerapp.com/Registration/Register?selectedPlanId=39&amp;origin=basic_pricing">BUY NOW</a>

				</div>
			</div>
		</div> <!-- end row !-->
	</div>
</div>

<div class="full-width system-static">
	<div class="container">
		<div class="col-md-4">
			<div class="round">
			<?php
				$count_posts = wp_count_posts(PROJECT);
				echo $count_posts->publish;
			?>

			</div>
			<center>Projects post</center>
		</div>
		<div class="col-md-4">
			<div class="round">
				100
			</div>
			<center>Freelancer register</center>
		</div>
		<div class="col-md-4">
			<div class="round">
				300
			</div>
			<center>Employer account</center>
		</div>
	</div>
</div>

<style type="text/css">
.top-profile{
	background: transparent;
	padding:0 0 30px 0;
}
.top-profile .container{
	background: transparent;
	background-clip: content-box;
}
.top-profile .container h2{
	padding: 5px 0 15px 0;
}

.col-md-6.archive-profile-item .full{
	-moz-box-shadow:    3px 3px 5px 6px #ccc;
  -webkit-box-shadow: 3px 3px 5px 6px #ccc;
  	box-shadow: 0px 0px 3px 3px #f3f3f3;
}

.workflow{
	padding: 20px 0 50px 0;
}
.workflow .nav-pills>li>a{
	border-radius: 0;
	text-transform: uppercase;
}
#exTab1 .tab-content {
  padding : 5px 0;
}
.workflow .nav{
	border-bottom: 1px solid #ccc;
}
.packge-plan{

	padding: 30px 0 50px 0;
	background: url('wp-content/themes/boxfreelance/img/wall1.jpg') #F0F0F0 center center / cover repeat;
}
.pricing-table-plan {
    border-radius: 5px;
    padding: 2em;
    text-align: center;
    width: 100%;
    background-color: #fff;
}
.plan-monthly {
    font-size: 2.5em;
    line-height: 140%;
}
.btn.btn-orange:hover {
    background-color: #f99e34 !important;
}
.plan-name {
    font-size: 1.75em;
    font-weight: 600;
    line-height: 100%;
    padding-top: .4em;
}
.pricing-table-plan {

}
.plan-features {
    width: 100%;
    margin: 2.2em 0;
    list-style: none;
    border-top: 1px solid #DFDFD0;
    text-align: center;
}
.plan-features > li {
    padding: 0;
    border-bottom: 1px solid #DFDFD0;
    font-size: .9375em;
    display: table;
    width: 100%;
    height: 3rem;
}
.plan-features > li span, .plan-features > li a {
    display: table-cell;
    vertical-align: middle;
}
.pricing-table-plan span{
	display: block;
}
.round {
    width: 100px;
    height: 100px;
    border-radius1: 50%;
    text-align: center;
    line-height: 100px;
    font-size: 30px;
    margin: 0 auto;
    border: 2px solid #fff;
    color: #FFA000;
    background: #fff;

}
.system-static{
	padding: 25px;
	background: #ececec;
}
.system-static center{
	font-size: 20px;
	padding-top: 21px;
}
@media only screen and (max-width: 768px) {
	.heading-aligner h1{
		font-size: 25px;
		line-height: 35px;
	}
	.heading-aligner > p{
		padding: 25px 20px 0;
	}
	.main-banner{
		height: 450px;
		min-height: 400px;
		padding-top: 50px;
	}
	.top-profile .container{
		background-clip: initial;
	}
	.archive-profile-item .col-md-3{
		padding-left: 0;
	}
	.archive-profile-item .col-xs-8{
		padding-right: 0;
	}
	.col-md-6.archive-profile-item .full{
		padding: 0;
	}
	.archive-profile-item .col-xs-12{
		padding-right: 0;
	}


	.archive-profile-item .col-xs-12{
		padding-left: 15px;
	}
	.container{
		padding-left: 10px;
		padding-right: 10px;
	}

	.small, small{
		font-size: 100%;
	}
}
</style>

<?php get_footer();

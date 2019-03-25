<?php /* Template Name: Job Board Page */ ?>
<?php get_header(); ?>
<?php
    if(ICL_LANGUAGE_CODE=="en") {
    	$case27_listing_type = 'offre-demploi-en';
    } elseif(ICL_LANGUAGE_CODE=="fr") {
    	$case27_listing_type = 'offre-demploi';
    } elseif(ICL_LANGUAGE_CODE=="de") {
    	$case27_listing_type = 'offre-demploi-de';
    }
?>
	<!-- Popup No Result -->
	<div class="popup-no-result">
		<div class="p-inner-box">
			<p><?php echo __('No Result found in', 'wedo-listing'); ?> "<span class="cat-name"></span>"</p>
			<a href="#" class="got-it"><?php echo __('Got It', 'wedo-listing'); ?></a>
		</div>
	</div>
	<!-- Inner Banner -->
	<section class="jobboard-banner" style="background-image: url('<?= get_stylesheet_directory_uri(); ?>/assets/images/jobboard-banner.jpg">
	  	<div class="inner-content">
			<h1><?php echo __('Job Board', 'wedo-listing'); ?></h1>
			<p><?php echo __('The latest job offers in Luxembourgish crafts', 'wedo-listing'); ?></p>
	  	</div>
	</section>
	<?php
		$cookie_name = 'template-job-board_php_' . ICL_LANGUAGE_CODE;
	?>
	<input type="hidden" class="p-page-name" value="template-job-board.php">
	<input type="text" class="p-current-page" value="<?php if(isset($_COOKIE[$cookie_name]) && $_COOKIE[$cookie_name] != 1) echo $_COOKIE[$cookie_name]; ?>">
	<input type="hidden" class="ICL_LANGUAGE_CODE" value="<?= ICL_LANGUAGE_CODE ?>">
	<main class="main-content jobboard-content">
		<div class="wrap-content clearfix">
			<div class="filter col-lg-3 col-sm-4">
				<div class="inner-filter">
					<p class="title"><?php echo __('Search filters', 'wedo-listing'); ?></p>
					<div class="contract-item item">
						<p class="tax menu-active"><?php echo __('Working Contract', 'wedo-listing'); ?><span class="count-number"></span></p>
						<div class="tax-sub">
							<p>
								<label class="wrap-checkbox">
									<?php echo __('All Contracts', 'wedo-listing'); ?>
								  	<input type="radio" checked="checked" disabled value="all">
								  	<span class="checkmark"></span>
								</label>
							</p>
							<p>
								<label class="wrap-checkbox">
									<?php echo __('CDI (Full-Time)', 'wedo-listing'); ?>
								  	<input type="checkbox" value="CDI" class="<?= contract_found_posts('CDI') ?>">
								  	<span class="checkmark"></span>
								</label>
							</p>
							<p>
								<label class="wrap-checkbox">
									<?php echo __('CDD (Part-Time)', 'wedo-listing'); ?>
								  	<input type="checkbox" value="CDD" class="<?= contract_found_posts('CDD') ?>">
								  	<span class="checkmark"></span>
								</label>
							</p>
							<p>
								<label class="wrap-checkbox">
									<?php echo __('Stage (Traineeship)', 'wedo-listing'); ?>
								  	<input type="checkbox" value="STAGE" class="<?= contract_found_posts('STAGE') ?>">
								  	<span class="checkmark"></span>
								</label>
							</p>
						</div>
					</div>
					<?php
						$icons_svg = array(
							'<svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 -3 34 34">
									  <g transform="translate(-140 -1087)">
									    <rect id="矩形_3112" data-name="矩形 3112" width="34" height="34" transform="translate(140 1087)" fill="none"></rect>
									    <g id="工具" transform="translate(142.849 1089.866)">
									      <path id="路径_5176" data-name="路径 5176" d="M5.942,10.135A.814.814,0,0,1,5.366,9.9L.241,4.771a.814.814,0,0,1,0-1.151L3.62.241a.814.814,0,0,1,1.151,0L9.9,5.365a.814.814,0,0,1,0,1.151L6.517,9.9a.814.814,0,0,1-.576.239ZM1.968,4.2,5.941,8.169,8.17,5.94,4.2,1.967Z" transform="translate(0 0)" fill="#5c5c68"></path>
									      <path id="路径_5177" data-name="路径 5177" d="M16.575,9.1l4.691,4.692L25.23,9.832a5.638,5.638,0,0,1,7.68-6.647l1.572.678L31.771,6.572l-.01.658.741-.01,2.672-2.67.678,1.575A5.64,5.64,0,0,1,29.209,13.8l-3.965,3.964L27.6,20.125l2-2,1.642,1.642-.67.667,4.512,4.513a3.047,3.047,0,1,1-4.309,4.309l-4.51-4.51-.667.668-1.642-1.642,2-2L23.6,19.413l-3.967,3.964a5.638,5.638,0,0,1-7.676,6.642l-1.574-.675,2.672-2.672.01-.741-.658.008L9.694,28.65l-.68-1.569A5.638,5.638,0,0,1,15.656,19.4l3.964-3.964-4.691-4.692M26.575,23.1l5.179,5.179a1.667,1.667,0,0,0,2.357-2.357l-5.177-5.18-1.022,1.022ZM12.809,28.87A4.257,4.257,0,0,0,18.2,23.416L18.053,23l5.236-5.237,5.546-5.547.412.146A4.256,4.256,0,0,0,34.7,6.973l-1.619,1.62-2.721.041L30.4,5.993l1.663-1.658a4.256,4.256,0,0,0-5.4,5.454l.149.412-5.546,5.544L16.031,20.98l-.412-.149a4.257,4.257,0,0,0-5.457,5.4l1.66-1.661,2.639-.037-.037,2.719Z" transform="translate(-8.313 -2.645)" fill="#5c5c68"></path>
									    </g>
									  </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 -3 34 34">
								  		<g transform="translate(-140 -1087)">
								    	<rect id="矩形_3112" data-name="矩形 3112" width="34" height="34" transform="translate(140 1087)" fill="none"></rect>
								    	<path id="food" d="M276.909,1568.55v-.3a12.438,12.438,0,0,0-9.63-12.1,3.33,3.33,0,1,0-5.561,0,12.437,12.437,0,0,0-9.63,12.1v.3H249v2.12a3.331,3.331,0,0,0,3.33,3.33h24.336a3.331,3.331,0,0,0,3.329-3.33v-2.12h-3.087Zm-13.924-14.23a1.514,1.514,0,1,1,1.513,1.51,1.514,1.514,0,0,1-1.513-1.51Zm-9.081,13.93a10.594,10.594,0,0,1,21.188,0v.3H253.9v-.3Zm24.276,2.42a1.518,1.518,0,0,1-1.513,1.52H252.331a1.517,1.517,0,0,1-1.514-1.52v-.3H278.18Z" transform="translate(-107 -458.988)" fill="#5c5c68" fill-rule="evenodd"></path>
								  		</g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="12 12 35 35">
								  		<g xmlns="http://www.w3.org/2000/svg" id="ico_categ_communication" transform="translate(16 15)">
								        <rect id="Rectangle_3111-6" data-name="Rectangle 3111" width="34" height="34" fill="none"/>
								        <path id="communication-2" data-name="communication" d="M262.5,2419.37a13.431,13.431,0,0,0-13.475,13.36v5.32a4.469,4.469,0,0,0,4.492,4.43h4.492v-12.41h-4.492a4.515,4.515,0,0,0-2.54.78,11.693,11.693,0,0,1,23.047,0,4.517,4.517,0,0,0-2.54-.78h-4.492v12.41h4.492a4.5,4.5,0,0,0,2.7-.89v1.83a2.679,2.679,0,0,1-2.7,2.66H265.04a2.66,2.66,0,1,0,0,1.78h6.443a4.469,4.469,0,0,0,4.491-4.44v-10.69a13.431,13.431,0,0,0-13.474-13.36Zm-8.085,12.47h1.8v8.86h-1.8Zm-1.8.15v8.56a2.657,2.657,0,0,1-1.8-2.5v-3.55a2.67,2.67,0,0,1,1.8-2.51Zm17.967,8.71h-1.8v-8.86h1.8Zm-8.086,7.16a.89.89,0,1,1,.9-.89.9.9,0,0,1-.9.89Zm11.679-9.81a2.658,2.658,0,0,1-1.8,2.5v-8.56a2.671,2.671,0,0,1,1.8,2.51Z" transform="translate(-245.025 -2417.37)" fill="#5c5c68" fill-rule="evenodd"/>
								      </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 -3 34 34">
								  		<g id="ico_categ_construction" transform="translate(-140 -1087)">
										    <rect width="34" height="34" transform="translate(140 1087)" fill="none"></rect>
										    <path id="construction" d="M278.2,480a2.826,2.826,0,0,0-2.816-2.829H272.1V472.75a6.266,6.266,0,0,0,1.977-9,6.2,6.2,0,0,0-2.886-2.254l-1.3-.5v4.2l-.9.558-.9-.558V461l-1.3.5a6.262,6.262,0,0,0-.859,11.282v1.3h-4.08l-5.175,4.18h-.675v-1.546H248.8V494h7.194v-1.835L259.5,494h13.914v-.053a66,66,0,0,1,3.157-6.5A581.216,581.216,0,0,0,278.2,480Zm-13.5-12.661a4.346,4.346,0,0,1,1.466-3.242v2.179l2.827,1.754,2.826-1.754V464.1a4.318,4.318,0,0,1-1.071,7.177l-.568.257v5.64h-2.33v-5.625l-.577-.253a4.316,4.316,0,0,1-2.573-3.954Zm-10.628,24.72h-3.341v-13.41h3.341Zm18.807,0h-12.9L256,489.978V480.2h1.354l5.174-4.18H265.9v3.092h9.484a.893.893,0,1,1,0,1.786H269.77v1.936h4.816a.893.893,0,1,1,0,1.786h-5.642v1.936h4.816a.893.893,0,0,1,0,1.786h-5.7v1.936h4.815a.893.893,0,0,1,0,1.784Z" transform="translate(-106.8 626.004)" fill="#5c5c68" fill-rule="evenodd"></path>
										  </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 -3 34 34">
								  		<g transform="translate(-140 -644)">
									    <rect width="34" height="34" transform="translate(140 644)" fill="none"></rect>
									    <path id="jiqiren" d="M76.158,147.052H74.768v-2.2a.732.732,0,0,0-.732-.732H71.109a.732.732,0,0,0-.732.732v2.2H68.86a5.13,5.13,0,0,0-5.07-4.391H62.619s-.005-4.85-.015-4.9a3.834,3.834,0,0,0-1.11-3.028l-3.868-3.868,4.58-4.58a3.1,3.1,0,0,0,.553-.75H67.3a.732.732,0,0,0,.732-.732v-.732h1.708v.733a.732.732,0,0,0,.366.634l2.537,1.465a.731.731,0,0,0,.732,0l2.537-1.465a.732.732,0,0,0-.732-1.268l-2.171,1.253-1.805-1.042V122.3l1.805-1.042,2.171,1.253a.732.732,0,1,0,.732-1.268l-2.537-1.465a.732.732,0,0,0-.732,0l-2.537,1.465a.732.732,0,0,0-.366.634v.733H68.035v-.732a.732.732,0,0,0-.732-.732H61.014a3.114,3.114,0,0,0-3.207.742l-5.324,5.324a4.206,4.206,0,0,0-1.765,7.524,3.849,3.849,0,0,0,.446.535l4.008,4.008v3.382h-.895a5.13,5.13,0,0,0-5.07,4.391,19.8,19.8,0,0,1-2.605,0,.732.732,0,0,0,0,1.464H76.158a.732.732,0,0,0,0-1.464Zm-9.587-24.443v1.464H63.115a3.113,3.113,0,0,0-.372-1.464Zm-7.729.314a1.647,1.647,0,1,1,2.329,2.329l-4.2,4.2a4.227,4.227,0,0,0-2.532-2.125Zm-8.368,8.432a2.744,2.744,0,1,1,2.744,2.744A2.748,2.748,0,0,1,50.474,131.354Zm3.039,4.2a4.216,4.216,0,0,0,3.737-2.991l3.21,3.21a2.378,2.378,0,0,1-3.364,3.364Zm7.643,4.917v2.193H56.635v-2.021a3.847,3.847,0,0,0,4.521-.173Zm-10.465,6.584a3.666,3.666,0,0,1,3.586-2.927H63.79a3.666,3.666,0,0,1,3.586,2.927Zm22.613,0H71.84v-1.464H73.3Zm-20.086-16.43a.732.732,0,1,0,.732.732A.733.733,0,0,0,53.218,130.623Z" transform="translate(95.264 526.723)" fill="#5c5c68"></path>
									  </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="33" height="30" viewBox="0 -3 34 34">
								  		<g transform="translate(-140 -644)">
									    <rect width="34" height="34" transform="translate(140 644)" fill="none"></rect>
									    <path d="M15.032,12.791a3.92,3.92,0,1,0-3.209,0,6.411,6.411,0,0,1,1.605-.225A6.372,6.372,0,0,1,15.032,12.791ZM10.8,9.222a2.631,2.631,0,1,1,2.632,2.632A2.631,2.631,0,0,1,10.8,9.222ZM14.626,18.4H8.273a5.184,5.184,0,0,1,8.671-3.164,8.06,8.06,0,0,1,.85-.556l.272-.14a6.479,6.479,0,0,0-3.035-1.755,3.852,3.852,0,0,1-1.6.354,3.9,3.9,0,0,1-1.605-.352,6.478,6.478,0,0,0-4.88,6.259.646.646,0,0,0,.644.646l6.195.116S14.549,18.57,14.626,18.4Zm.418-5.6a1.83,1.83,0,0,0-1.512-.463,2.208,2.208,0,0,0-1.7.463,3.513,3.513,0,0,0,3.209,0Zm7.523,8.079A1.843,1.843,0,0,0,20.955,24.2a1.743,1.743,0,0,0,.517.135,1.835,1.835,0,0,0,1.094-3.451Zm5.041,2.372q.908-.228,1.5-.436a7.345,7.345,0,0,0-.064-1.229c0-.036-.007-.071-.011-.107-.408-.1-.914-.187-1.532-.272a6.1,6.1,0,0,0-.33-1.013c.446-.433.8-.806,1.073-1.124a7.666,7.666,0,0,0-.732-1.118c-.4.12-.89.3-1.465.532a5.719,5.719,0,0,0-.792-.712c.17-.6.292-1.1.369-1.514a7.908,7.908,0,0,0-1.191-.605c-.043.049-.1.111-.144.161-.255.283-.536.614-.86,1.03-.109-.032-.225-.043-.335-.069a6.038,6.038,0,0,0-.7-.15c-.154-.6-.3-1.1-.438-1.491a7.286,7.286,0,0,0-1.225.06c-.043,0-.077.009-.112.015-.092.4-.189.914-.27,1.532a5.614,5.614,0,0,0-.939.307.673.673,0,0,0-.073.022c-.433-.448-.806-.806-1.124-1.073a7.14,7.14,0,0,0-.667.435c-.148.1-.311.184-.451.3.12.4.3.886.532,1.463a6.207,6.207,0,0,0-.68.759H16.78c-.538-.15-1.006-.264-1.384-.333-.066.1-.109.225-.169.333a7.56,7.56,0,0,0-.436.86c.154.144.328.3.526.465s.42.345.665.534a6.271,6.271,0,0,0-.215,1.045c-.6.15-1.1.3-1.495.436a7.538,7.538,0,0,0,.058,1.227l.017.109c.4.1.914.185,1.532.272.041.176.112.339.167.51s.094.341.161.5c-.259.253-.481.481-.684.695-.144.152-.279.3-.392.429a7.468,7.468,0,0,0,.732,1.124c.4-.12.89-.3,1.465-.536a5.828,5.828,0,0,0,.792.712,15.245,15.245,0,0,0-.369,1.512,7.254,7.254,0,0,0,1.191.6,15.193,15.193,0,0,0,1-1.19,5.9,5.9,0,0,0,1.043.219c.152.6.3,1.1.436,1.493a7.574,7.574,0,0,0,1.229-.06c.036,0,.071-.007.109-.013.1-.407.185-.916.268-1.534a5.862,5.862,0,0,0,1.012-.33c.433.448.809.806,1.126,1.075a7.278,7.278,0,0,0,1.118-.732,14.46,14.46,0,0,0-.532-1.465,6.168,6.168,0,0,0,.71-.791c.6.17,1.1.292,1.514.369a7.225,7.225,0,0,0,.605-1.2c-.305-.285-.7-.618-1.193-1A5.438,5.438,0,0,0,27.607,23.251ZM22.244,26.8a4.286,4.286,0,1,1,.849-8.282,4.367,4.367,0,0,1,1.193.624A4.284,4.284,0,0,1,22.244,26.8ZM11.053,22.479H4.532A2.623,2.623,0,0,1,1.91,19.857V4.5A2.623,2.623,0,0,1,4.532,1.873H19.893A2.623,2.623,0,0,1,22.516,4.5V11.41c0,.069,1.364.178,1.873.326V3.747A3.746,3.746,0,0,0,20.643,0H3.783A3.746,3.746,0,0,0,.037,3.747V20.606a3.746,3.746,0,0,0,3.747,3.747h7.555C11.207,23.841,11.106,22.479,11.053,22.479ZM9.682,11.569s-6.487-.35-6.483,7.124H4.488a5.4,5.4,0,0,1,5.2-5.833Zm0-5.961A3.368,3.368,0,0,0,6.245,9.046a3.483,3.483,0,0,0,3.439,3.437V11.313A2.435,2.435,0,0,1,7.505,9.046,2.26,2.26,0,0,1,9.684,6.688Z" transform="translate(142.524 646.14)" fill="#5c5c68"></path>
									  </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="38 12 35 35">
								  		<g xmlns="http://www.w3.org/2000/svg" id="ico_categ_mode" transform="translate(40 15)">
								        <rect width="34" height="34" fill="none"/>
								        <path d="M271.364,2191.23l-1.455-.67a6.182,6.182,0,0,0-5.676-3.75h-5.289a6.185,6.185,0,0,0-5.865,4.25l-.816.28a4.4,4.4,0,0,0-3.013,4.18v17.73h1.762v-2.98l1.763.88v3.86h1.763v-2.98l1.762.88v3.98h1.763v-10.75a9.974,9.974,0,0,0,1.1.06h1.549a7.964,7.964,0,0,0,4.407-1.34v8.39h1.762v-2.98l1.763.88v3.86H270.4v-2.98l1.762.88v3.98h1.763v-21.66a4.423,4.423,0,0,0-2.561-4Zm-6.25.87a3.526,3.526,0,1,1-3.526-3.53,3.526,3.526,0,0,1,3.526,3.53Zm-7.051,3.93a5.278,5.278,0,0,0,7.051,0v.47a2.651,2.651,0,0,1-2.644,2.65h-1.763a2.651,2.651,0,0,1-2.644-2.65v-.47Zm-1.763,14.91-5.288-2.64v-6.37a10.02,10.02,0,0,0,5.288,3.85Zm4.407-6.51h-1.549a8.136,8.136,0,0,1-8.146-8.14v-.77a2.651,2.651,0,0,1,1.763-2.5v4.36h1.763v-4.4a4.41,4.41,0,0,1,2.3-3.87,4.337,4.337,0,0,0-.538,2.1v5.29a4.415,4.415,0,0,0,4.407,4.41h1.763a4.353,4.353,0,0,0,2.644-.89v2.56a6.177,6.177,0,0,1-4.407,1.85Zm6.169-13.22a4.345,4.345,0,0,0-.537-2.1,4.41,4.41,0,0,1,2.3,3.87v6.17H270.4s0-6.34-.006-6.42l.23.1a2.657,2.657,0,0,1,1.538,2.4v15.71l-5.288-2.64v-17.09Z" transform="translate(-244.5 -2184.62)" fill="#5c5c68" fill-rule="evenodd"/>
								      </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="38 12 35 35">
								  		<g xmlns="http://www.w3.org/2000/svg" id="ico_categ_sante" transform="translate(40 15)">
								        <rect width="34" height="34" fill="none"/>
								        <g id="针" transform="translate(1.306 0.442)">
								          <path id="Path_5178" data-name="Path 5178" d="M.345,5.016a.032.032,0,0,0-.032.032V5.3a.03.03,0,0,0,.032.032h.4A.032.032,0,0,0,.778,5.3V5.048a.03.03,0,0,0-.032-.032h-.4M.345,5h.4a.05.05,0,0,1,.048.048V5.3a.05.05,0,0,1-.048.048h-.4A.05.05,0,0,1,.3,5.3V5.048A.045.045,0,0,1,.345,5Z" transform="translate(30.463 -4.923)" fill="#5c5c68"/>
								          <path id="Path_5179" data-name="Path 5179" d="M6.6,10.1H6.5v.016h.1Z" transform="translate(24.46 -9.858)" fill="#5c5c68"/>
								          <path id="Path_5180" data-name="Path 5180" d="M5.781,2.8H5.765v.1h.016Zm-.048-.184a.015.015,0,0,0-.016.016v.045h.113V2.632a.015.015,0,0,0-.016-.016H5.732m0-.016h.081a.03.03,0,0,1,.032.032v.061H5.7V2.632A.032.032,0,0,1,5.732,2.6Z" transform="translate(25.237 -2.6)" fill="#5c5c68"/>
								          <path id="Path_5181" data-name="Path 5181" d="M692.872,91.626l-3.249,3.249,1.629,1.629,3.249-3.249-1.629-1.629m.116-1.526,3.039,3.039-4.888,4.888L688.1,94.988Z" transform="translate(-686.959 -87.277)" fill="#5c5c68"/>
								          <path id="Path_5182" data-name="Path 5182" d="M86.179,66.4l-.7-.7-8.153,8.153.7.7Zm-3.131-1.54-1.006-.98-6.561,6.561,1.006.98Zm21.255,27L99.47,85.769l-1.98,1.868,5.995,5.042Z" transform="translate(-75.482 -62.17)" fill="#5c5c68"/>
								          <path id="Path_5183" data-name="Path 5183" d="M179.243,138.123l-4.385,4.562,15.524,15.524c.236.113,1.053-.087,2.608-1.69,1.481-1.526,1.878-2.687,1.774-2.875l-6.407-6.407-9.114-9.114m.116-1.523,9.817,9.817,6.407,6.407c1.674,1.674-4.891,8.23-6.559,6.559l-6.407-6.407-9.817-9.817Z" transform="translate(-170.163 -132.277)" fill="#5c5c68" stroke="#5c5c68" stroke-width="0.3"/>
								          <path id="Path_5184" data-name="Path 5184" d="M336.751,331.478l-.7-.7-3.3,3.3.7.7Zm-2.11-2.111-.7-.7-3.3,3.3.7.7Zm-2.114-2.111-.7-.7-3.3,3.3.7.7Zm-2.112-2.114-.7-.7-3.3,3.3.7.7Z" transform="translate(-316.015 -314.054)" fill="#5c5c68"/>
								        </g>
								        <path id="baojian" d="M22.786,11.179l-3.727,3.941-4.646,4.353L11.518,22.34a6.654,6.654,0,0,1-9.348,0,6.5,6.5,0,0,1,0-9.261L5.056,10.22l4.607-4.5,3.773-3.8a6.653,6.653,0,0,1,9.348,0,6.5,6.5,0,0,1,0,9.26ZM3.03,13.931a5.308,5.308,0,0,0,0,7.557,5.429,5.429,0,0,0,7.628,0L13.249,18.9l1.163.569,4.646-4.353-9.394-9.4-4.607,4.5.095,1.61ZM21.925,2.77a5.429,5.429,0,0,0-7.628,0l-3.78,3.778,7.712,7.382,3.7-3.6a5.307,5.307,0,0,0,0-7.556ZM8.509,20.8a.672.672,0,0,1,0-.956.688.688,0,0,1,.966,0,.671.671,0,0,1,0,.957A.686.686,0,0,1,8.509,20.8Zm-.938-2.852a.689.689,0,0,1-.966,0,.67.67,0,0,1,0-.956.687.687,0,0,1,.966,0A.674.674,0,0,1,7.571,17.947ZM5.639,19.862a.689.689,0,0,1-.966,0,.672.672,0,0,1,0-.957.688.688,0,0,1,.966,0A.673.673,0,0,1,5.639,19.862ZM3.75,16.076a.673.673,0,0,1,0-.957.687.687,0,0,1,.966,0,.671.671,0,0,1,0,.957A.687.687,0,0,1,3.75,16.076Z" transform="translate(5.007 4.758)" fill="#5c5c68" stroke="#5c5c68" stroke-width="0.6"/>
								        <path id="Path_5185" data-name="Path 5185" d="M3.036,0,5.5,2.119,1.6,6.659,0,5.212Z" transform="translate(19.055 18.135) rotate(3)" fill="#fff"/>
								        <path id="Path_5186" data-name="Path 5186" d="M2.888-1.166,3.962-.114-.4,4.048l-.746-.711Z" transform="translate(10.987 11.155)" fill="#fff"/>
								      </g>
									</svg>',
							'<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="38 12 35 35">
								  		<g xmlns="http://www.w3.org/2000/svg" id="ico_categ_services" transform="translate(40 15)">
								        <rect width="34" height="34" fill="none"/>
								        <g id="服务" transform="translate(2.479 3.386)">
								          <path id="Path_5187" data-name="Path 5187" d="M194.36,71.987h0a26.4,26.4,0,0,0,4.538-1.271c.182.182.363.545.545.545h2.9c.182,0,.545-.182.545-.363a17.133,17.133,0,0,0,4.175,1.089h.545a2.536,2.536,0,0,0,2.36-2V66c.182-1.089-1.271-2-2.178-2h-.363a16.048,16.048,0,0,0-4.356.908A1.177,1.177,0,0,0,201.984,64h-2.36c-.363,0-.726.545-.726.726v.182A17.419,17.419,0,0,0,194.541,64h0c-1.089,0-2.541.908-2.541,2v4.175C192,71.079,193.452,71.987,194.36,71.987Zm12.888-6.535a.466.466,0,0,1,.363,0,.647.647,0,0,1,.182.363V69.99s0,.272-.182.363a1.04,1.04,0,0,1-.545,0c-1.089-.182-2.36-.726-4.175-1.271V66.9C204.706,66.36,205.977,65.815,207.248,65.452Zm-5.446.726v3.086H200.35V66.178ZM193.815,66a.944.944,0,0,1,.306-.545.846.846,0,0,1,.6,0,45.323,45.323,0,0,0,4.538,1.452v2.36c-1.815.363-3.267.908-4.538,1.271a.846.846,0,0,1-.6,0,.944.944,0,0,1-.306-.545Z" transform="translate(-186.554 -64)" fill="#5c5c68"/>
								          <path id="Path_5188" data-name="Path 5188" d="M28.317,278.958l-2-1.452a1.587,1.587,0,0,0-2.36.545L14.521,293.48H14.34l-9.62-15.066a1.526,1.526,0,0,0-2-.726l-1.634.726A1.38,1.38,0,0,0,0,279.866v12.706a5.814,5.814,0,0,0,5.627,5.809H23.234a5.973,5.973,0,0,0,5.809-5.809V280.411A2.241,2.241,0,0,0,28.317,278.958Zm-1.089,13.614a4.029,4.029,0,0,1-3.993,3.993H5.627a3.766,3.766,0,0,1-3.812-3.993V279.866a.3.3,0,0,1,.157-.272l1.476-.635h0l9.439,15.248a1.84,1.84,0,0,0,1.546.756,2.063,2.063,0,0,0,1.359-.756L25.231,278.6c0-.181.182,0,.182,0l1.815,1.634v12.343Z" transform="translate(0 -271.153)" fill="#5c5c68"/>
								          <path id="Path_5189" data-name="Path 5189" d="M789.378,595.2h-1.452a.726.726,0,0,0,0,1.452h1.452a.726.726,0,1,0,0-1.452Z" transform="translate(-764.873 -580.134)" fill="#5c5c68"/>
								          <g id="Ellipse_626" data-name="Ellipse 626" transform="translate(12.521 14.614)" fill="#fff" stroke="#5c5c68" stroke-width="1.2">
								            <circle cx="2.1" cy="2.1" r="2.1" stroke="none"/>
								            <circle cx="2.1" cy="2.1" r="1.5" fill="none"/>
								          </g>
								          <g id="Ellipse_627" data-name="Ellipse 627" transform="translate(12.521 9.614)" fill="#fff" stroke="#5c5c68" stroke-width="1.2">
								            <circle cx="2.1" cy="2.1" r="2.1" stroke="none"/>
								            <circle cx="2.1" cy="2.1" r="1.5" fill="none"/>
								          </g>
								        </g>
								      </g>
									</svg>'
						);
						$category_icon_fr = array(
							291 => $icons_svg[0],
							2035 => $icons_svg[1],
							2039 => $icons_svg[2],
							2036 => $icons_svg[3],
							2037 => $icons_svg[4],
							2071 => $icons_svg[5],
							14593 => $icons_svg[6],
							2038 => $icons_svg[7],
							2040 => $icons_svg[8],
						);
						$category_icon_en = array(
							11678 => $icons_svg[2],
							11690 => $icons_svg[3],
							11946 => $icons_svg[6],
							11666 => $icons_svg[1],
							11843 => $icons_svg[4],
							11954 => $icons_svg[7],
							17355 => $icons_svg[0],
							11819 => $icons_svg[0],
							11701 => $icons_svg[8],
							11895 => $icons_svg[5],
							11651 => $icons_svg[0],
						);
						$category_icon_de = array(
							11691 => $icons_svg[3],
							11653 => $icons_svg[0],
							11894 => $icons_svg[5],
							11700 => $icons_svg[8],
							11955 => $icons_svg[7],
							17813 => $icons_svg[6],
							15681 => $icons_svg[4],
							11679 => $icons_svg[2],
							17815 => $icons_svg[0],
							15567 => $icons_svg[6],
							11818 => $icons_svg[0],
							11667 => $icons_svg[1],
							11650 => $icons_svg[0],
							11842 => $icons_svg[4],
						);
                        $category_terms = get_terms( array(
                            'taxonomy' => 'job_listing_category',
                            'hide_empty' => false,
                            'parent'   => 0
                        ) );
                        if(!empty($category_terms)) :
                    ?>
                    <div class="category-item item">
						<p class="tax menu-active"><?php echo __('Categories', 'wedo-listing'); ?><span class="count-number"></span></p>
						<div class="tax-sub">
							<p>
								<label class="wrap-checkbox checkbox-svg">
									<input type="radio" checked="checked" disabled value="all">
									<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 34 34">
									  <g id="ico_categ_all" transform="translate(-140 -1087)">
									    <rect id="矩形_3112" data-name="矩形 3112" width="34" height="34" transform="translate(140 1087)" fill="none"/>
									    <g id="目录" transform="translate(-32.78 918.922)">
									      <path id="路径_5199" data-name="路径 5199" d="M329.928,312.873h-9.681a.222.222,0,0,1-.222-.222v-1.638a.222.222,0,0,1,.222-.222h9.684a.222.222,0,0,1,.222.222v1.638A.228.228,0,0,1,329.928,312.873Zm0,13.264h-9.681a.222.222,0,0,1-.222-.222v-1.634a.222.222,0,0,1,.222-.222h9.684a.222.222,0,0,1,.222.222v1.634A.23.23,0,0,1,329.928,326.138Zm0-6.611h-9.681a.222.222,0,0,1-.222-.222v-1.638a.222.222,0,0,1,.222-.222h9.684a.222.222,0,0,1,.222.222v1.638A.228.228,0,0,1,329.928,319.527Z" transform="translate(-132.534 -133.207)" fill="#5c5c68"/>
									      <path id="路径_5200" data-name="路径 5200" d="M202.977,187.016V174.943a3.71,3.71,0,0,0-.545-1.805,2.757,2.757,0,0,0-2.5-1.237H189.779a.035.035,0,0,0-.019,0h-9.821a2.976,2.976,0,0,0-3.039,3.039l0,8.3v12.081a3.711,3.711,0,0,0,.541,1.8,2.757,2.757,0,0,0,2.5,1.237H190.1a.035.035,0,0,0,.019,0h9.817a2.976,2.976,0,0,0,3.039-3.039l0-8.3Zm-1.517,8.311a1.526,1.526,0,0,1-1.514,1.517h-20l-.148-.012a1.983,1.983,0,0,1-.93-.455,1.922,1.922,0,0,1-.455-1.016v-.027l0-20.4a1.526,1.526,0,0,1,1.514-1.517h20l.144.012a1.983,1.983,0,0,1,.93.455,1.913,1.913,0,0,1,.455,1.012.066.066,0,0,0,0,.027Z" transform="translate(0)" fill="#5c5c68"/>
									      <circle id="椭圆_628" data-name="椭圆 628" cx="1.5" cy="1.5" r="1.5" transform="translate(182.38 177.078)" fill="#5c5c68"/>
									      <circle id="椭圆_629" data-name="椭圆 629" cx="1.5" cy="1.5" r="1.5" transform="translate(182.38 183.378)" fill="#5c5c68"/>
									      <circle id="椭圆_630" data-name="椭圆 630" cx="1.5" cy="1.5" r="1.5" transform="translate(182.38 190.078)" fill="#5c5c68"/>
									    </g>
									  </g>
									</svg>
									<?php echo __('All Categories', 'wedo-listing'); ?>
								  	<span class="checkmark"></span>
								</label>
							</p>
							<?php
	                            foreach ($category_terms as $key => $value) :
	                        ?>
							<p>
								<label class="wrap-checkbox checkbox-svg">
									<input type="checkbox" value="<?= $value->term_id ?>" class="<?= category_found_posts($value->term_id); ?>">
									<?php
										if(ICL_LANGUAGE_CODE=="en") {
									    	echo $category_icon_en[$value->term_id];
									    } elseif(ICL_LANGUAGE_CODE=="fr") {
									    	echo $category_icon_fr[$value->term_id];
									    } elseif(ICL_LANGUAGE_CODE=="de") {
									    	echo $category_icon_de[$value->term_id];
									    }
										echo $value->name;
									?>
								  	<span class="checkmark"></span>
								</label>
							</p>
							<?php endforeach; ?>
						</div>
					</div>
                	<?php endif; ?>
					<?php
                        $regions_terms = get_terms( array(
                            'taxonomy' => 'region',
                            'hide_empty' => false,
                            'parent'   => 0
                        ) );
                        if(!empty($regions_terms)) :
                    ?>
					<div class="regions-item item">
						<p class="tax menu-active"><?php echo __('Regions', 'wedo-listing'); ?><span class="count-number"></span></p>
						<div class="tax-sub">
							<p>
								<label class="wrap-checkbox">
									<?php echo __('All Regions', 'wedo-listing'); ?>
								  	<input type="radio" checked="checked" disabled value="all">
								  	<span class="checkmark"></span>
								</label>
							</p>
							<?php
	                            foreach ($regions_terms as $key => $value) :
	                        ?>
							<p>
								<label class="wrap-checkbox">
									<?php echo __($value->name, 'wedo-listing'); ?>
								  	<input type="checkbox" value="<?= $value->term_id ?>" class="<?= region_found_posts($value->term_id); ?>">
								  	<span class="checkmark"></span>
								</label>
							</p>
							<?php endforeach; ?>
						</div>
					</div>
					<?php endif; ?>
				</div>
			</div>
			<div class="right-content col-lg-9 col-sm-8">
				<div class="inner-right-content">
					<div class="search-form">
						<form class="clearfix" id="p-search-form">
							<input type="text" name="" placeholder="<?php echo __('What are you looking for ?', 'wedo-listing'); ?>" required class="keyword">
							<input type="submit" name="" value="<?php echo __('Search', 'wedo-listing'); ?>">
						</form>
					</div>
					<div id="ajax_load_content">
						<div class="outer-posts">
							<div class="p-loading"><div class="loader"></div></div>
							<div class="posts">
								<?php
									$args = array(
										'post_type'  => 'job_listing',
										'posts_per_page' => 21,
										'post_status' => 'publish',
										'meta_query'     => array(
											array(
												'key'     => '_case27_listing_type',
												'value'   => $case27_listing_type,
												'compare' => '=',
											),
										),
									);
									$query = new WP_Query( $args );
									$max_result = 21;
									$total_row = $query->found_posts;
									$total_page = ceil($total_row/$max_result);
									if($query->have_posts()) :
										while($query->have_posts()) :
											$query->the_post();
											$post_id = $post->ID;
								?>
									<div class="item">
										<a href="<?php the_permalink(); ?>">
										<div class="wrapper">
											<img src="<?php if(get_field('_job_cover', $post_id) && @getimagesize(get_field('_job_cover', $post_id))) { echo get_field('_job_cover', $post_id); } else { echo get_stylesheet_directory_uri() . '/assets/images/offre_d_emploi_luxembourg.jpg'; } ?>">
											<span class="tag"><?= wp_trim_words(get_field('_socit', $post_id), 3, '...'); ?></span>
											<div class="bottom-text">
												<h3><?= get_the_title(); ?></h3>
												<?php
													$region_term = wp_get_post_terms($post_id, 'region', array("fields" => "names"));
													if($region_term) :
													echo '<div class="outer-location">';
														foreach ($region_term as $key => $name) :
												?>
													<p class="location"><?= $name; ?></p>
												<?php endforeach; echo "</div>"; endif; ?>
											</div>
										</div>
										</a>
									</div>
								<?php endwhile; endif; ?>
							</div>
						</div>
						<?php if($total_row > 21) : ?>
						<div class="pagination">
							<a href="#" class="arrow prev disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
							<a href="#" class="current">1</a>
							<?php
								for ($i=2; $i <= $total_page; $i++) {
									echo '<a href="#" class="active" data-number="' . $i . '">' . $i .'</a>';
								}
							?>
							<a href="#" class="arrow next active" data-number="2"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</main>
<?php get_footer();?>
(function($) {
	'use strict';
	// $(function() {
	$(document).ready(function() {
		/* ==========================================================================
           JobBoard contact form
           ========================================================================== */
		$(".jobboard-form.en .wpcf7-form-control-wrap.file-399").append('<span class="p-file-valid">No file selected</span>');
		$(".jobboard-form.fr .wpcf7-form-control-wrap.file-399").append('<span class="p-file-valid">Aucun fichier sélectionné</span>');
		$(".jobboard-form.de .wpcf7-form-control-wrap.file-399").append('<span class="p-file-valid">Keine Datei ausgewählt</span>');
		$(".jobboard-form input[type='file']").change(function(e) {
			var fileName = e.target.files[0].name;
			$(".jobboard-form span.p-file-valid").html(fileName);
		});
		$(".headline .share .icon").click(function(event) {
			event.preventDefault();
			$(this).toggleClass('active');
			$(this).next('ul').slideToggle();
		});
		$("html[lang=en-US] #cn-notice-text").html('By continuing to browse wedo.lu, you agree that cookies may be used to improve your user experience and provide you with personalized content.');
		/* ==========================================================================
           Ajax posts
           ========================================================================== */
		var w_window = $(window).width();
		var scroll_tab_name = $(".tab.desktop .jobboard-form");
		if (w_window < 767) {
			$(".jobboard-content .filter p.tax").click(function(event) {
				$(this).next('.tax-sub').slideToggle();
				$(this).toggleClass('menu-active');
			});
			$(".p-blog-content .filter p.title").click(function(event) {
				$(this).next('.item').slideToggle();
				$(this).toggleClass('menu-active');
			});
			scroll_tab_name = $(".tab.mobile .jobboard-form");
		}
		$(".headline .apply-now a").click(function(e) {
			$("html,body").animate({
				scrollTop: scroll_tab_name.offset().top - 150
			}, 500);
			$(".p-single-jobboard .headline .apply-now a.mobile").fadeOut();
			e.preventDefault();
		});
		if (w_window < 992) {
			// $(".p-single-jobboard .headline .apply-now.en a, .p-single-jobboard .headline .apply-now.fr a").html('Apply');
			// $(".p-single-jobboard .headline .apply-now.de a").html('Bewerben');
		}
		$("body").on('click', '.pagination a.disabled, .pagination a.current', function(event) {
			event.preventDefault();
		});

		function p_ajax_posts() {
			var keyword = $("form#p-search-form input.keyword").val();
			var contract_id = $(".contract-item input:checkbox:checked").map(function() {
				return $(this).val();
			}).get();
			var category_id = $(".category-item input:checkbox:checked").map(function() {
				return $(this).val();
			}).get();
			var regions_id = $(".regions-item input:checkbox:checked").map(function() {
				return $(this).val();
			}).get();
			var current_page = $("input.p-current-page").val();
			if (contract_id.length != 0) {
				$('.contract-item input[type="radio"]').removeAttr('checked');
				$('.contract-item input[type="radio"]').removeAttr('disabled');
			} else {
				$('.contract-item input[type="radio"]').attr({
					checked: 'checked',
					disabled: 'disabled'
				});
			}
			if (category_id.length != 0) {
				$('.category-item input[type="radio"]').removeAttr('checked');
				$('.category-item input[type="radio"]').removeAttr('disabled');
			} else {
				$('.category-item input[type="radio"]').attr({
					checked: 'checked',
					disabled: 'disabled'
				});
			}
			if (regions_id.length != 0) {
				$('.regions-item input[type="radio"]').removeAttr('checked');
				$('.regions-item input[type="radio"]').removeAttr('disabled');
			} else {
				$('.regions-item input[type="radio"]').attr({
					checked: 'checked',
					disabled: 'disabled'
				});
			}
			$.ajax({
				type: "post",
				dataType: "json",
				url: p_ajax_object.ajaxurl,
				data: {
					action: "p_ajax_posts",
					contract_id: contract_id,
					category_id: category_id,
					regions_id: regions_id,
					keyword: keyword,
					current_page: current_page
				},
				context: this,
				beforeSend: function() {
					$(".p-loading").fadeIn();
				},
				success: function(response) {
					$(".p-loading").hide();
					$("#ajax_load_content").html(response.data);
				},
			})
			return false;
		}

		function blog_ajax_posts() {
			var keyword = $("form#blog-search-form input.keyword").val();
			var category_id = $(".item.category input:checkbox:checked").map(function() {
				return $(this).val();
			}).get();
			var current_page = $("input.p-current-page").val();
			$.ajax({
				type: "post",
				dataType: "json",
				url: p_ajax_object.ajaxurl,
				data: {
					action: "blog_ajax_posts",
					category_id: category_id,
					keyword: keyword,
					current_page: current_page
				},
				context: this,
				beforeSend: function() {
					$(".p-loading").fadeIn();
				},
				success: function(response) {
					$(".p-loading").hide();
					$("#ajax_load_content").html(response.data);
				},
			})
			return false;
		}

		$(".popup-no-result a.got-it").click(function(event) {
			event.preventDefault();
			$(".popup-no-result").fadeOut();
		});

		$("body").on('change', '.filter .wrap-checkbox input', function(event) {
			$("input.p-current-page").val('');
			if ($(this).val() == 'all') {
				$(this).closest('.item').find('input:checkbox:checked').removeAttr('checked');
				$(this).attr({
					checked: 'checked',
					disabled: 'disabled'
				});
			}
			if ($(this).hasClass('no-post') && $(this).is(":checked")) {
				var cat_name = $(this).closest('label').text();
				$(".popup-no-result span.cat-name").html(cat_name);
				$(".popup-no-result").fadeIn();
				setTimeout(function() {
					$(".popup-no-result").fadeOut();
				}, 2000);
			} else {
				p_ajax_posts();
			}
		});

		$("body").on('change', '.p-blog-content .filter input', function(event) {
			$("input.p-current-page").val('');
			if ($(this).is(":checked")) {
				$(this).closest('label').addClass('active');
			} else {
				$(this).closest('label').removeClass('active');
			}
			blog_ajax_posts();
		});

		$("form#p-search-form").submit(function(event) {
			event.preventDefault();
			$("input.p-current-page").val('');
			p_ajax_posts();
		});
		$("form#blog-search-form").submit(function(event) {
			event.preventDefault();
			$("input.p-current-page").val('');
			blog_ajax_posts();
		});

		$("body").on('click', '.jobboard-content .pagination a.active', function(event) {
			event.preventDefault();
			console.log('p');
			$("input.p-current-page").val($(this).data('number'));
			var page_name = $("input.p-page-name").val();
			if (page_name == 'blog') {
				blog_ajax_posts();
			} else {
				p_ajax_posts();
			}
		});

		$(window).resize(function() {
			if (w_window < 992) {
				// $(".p-single-jobboard .headline .apply-now a").html('Apply');
				// $(".p-single-jobboard .headline .apply-now.de a").html('Bewerben');
			}
		}); // end window resize
	});
})(jQuery); // end JQuery namespace
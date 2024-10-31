(function( $ ) {
    $( document ).ready( function() {

		if (document.createStyleSheet) {
			document.createStyleSheet(nf_subpages.js_style_url);
		} else {
			$("head").append($("<link rel='stylesheet' href='" + nf_subpages.js_style_url + "' type='text/css' />"));
		}

		var length = $(".nf_subpage_wrap").length;
        $(".nf_subpage_wrap").each(function(index) {
			$(this).attr("data-index", index);

          	if(index == 0) {
				$(this).find(".nf_subpage_prev").css("display", "none");
				$(this).css("display", "block");
			}
			if(index == length - 1) {
				$(this).find(".nf_subpage_next").css("display", "none");
			}
        });

		$( document ).on("click", ".nf_subpage_prev", function() {
			var oldElement = $(this).parents(".nf_subpage_wrap");
			scrollPage(oldElement, oldElement.prev(".nf_subpage_wrap"));
		});

		$( document ).on("click", ".nf_subpage_next", function() {
			var oldElement = $(this).parents(".nf_subpage_wrap");
			scrollPage(oldElement, oldElement.next(".nf_subpage_wrap"));
		});

		function scrollPage(oldElement, newElement) {
			newElement.css("display", "block");
			oldElement.css("display","none");

			newElement.find(".nf_subpage_progressbar span").css("width", (parseInt(newElement.attr("data-index")) / (length - 1) * 100.0) + "%");
			newElement.find(".nf_subpage_progressbar_text").html((parseInt(newElement.attr("data-index")) / (length - 1) * 100.0) + "%");
			$(window).scrollTop($(".ninja-forms-cont").offset().top);
		}
    } );
} )( jQuery );
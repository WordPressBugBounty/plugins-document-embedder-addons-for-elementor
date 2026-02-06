// (function ($) {
// 	function initDearFlip() {
// 		if (typeof $.fn.dflip !== 'function') {
// 			console.error('DearFlip is not loaded. Check CDN or script inclusion.');
// 			return;
// 		}

// 		const $container = $("#flipbook-container");
// 		if ($container.length && !$container.hasClass('dflip-initialized')) {
// 			$container.addClass('dflip-initialized').dflip({
// 				source: "https://clearly-sound-scallop.jurassic.ninja/wp-content/uploads/2025/10/embedpdf-ebook.pdf",
// 				height: 600,
// 				width: "100%",
// 				pageMode: "3d",
// 				webgl: true,
// 				controls: {
// 					toolbar: false,
// 					zoom: true,
// 					layout: "double",
// 					autoZoom: true
// 				}
// 			});
// 		}
// 	}

// 	// Frontend load
// 	$(document).ready(function () {
// 		initDearFlip();
// 	});

// 	// Elementor editor load
// 	$(window).on('elementor/frontend/init', function () {
// 		elementorFrontend.hooks.addAction('frontend/element_ready/bae-3d-flip-pdf-viewer', function () {
// 			initDearFlip();
// 		});
// 	});
// })(jQuery);

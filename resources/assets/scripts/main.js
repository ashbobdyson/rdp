// import external dependencies
import 'jquery';

// Import everything from autoload
import "./autoload/**/*"

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import Barba from "barba.js";
import Masonry from "masonry-layout"; //eslint-disable-line

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

$('body').on('click', '.invert-theme', function(){
	$('body').toggleClass('alt-theme')
})

$('body').on('click', '.lightbox-btn', function(){
	$('body').addClass('lightbox-open')
	var src = $(this).parent().data('lightbox')
	console.log(src)
	$('.lightbox-wrapper').find('img').attr('src', src)
})

$('body').on('click', '.lightbox-close', function(){
	$('body').removeClass('lightbox-open')
})

// window.oncontextmenu = function () {
// 	return false;
//  }
//  document.onkeydown = function (e) { 
// 	if (window.event.keyCode == 123 || window.event.keyCode == 18 ||  e.button==2)    
// 	return false;
//  }

//BARBA JS - This controls the page transitions
//Create a transition for barba
var bodyClasses;
var anchor;
var slideAndFade = Barba.BaseTransition.extend({
	start: function() {
		$("body").addClass("transition-out");
		Promise.all([this.newContainerLoading, this.slideUp()]).then(
			this.finish.bind(this)
		);
	},
	slideUp: function() {
		return new Promise(function(resolve) {
			$("#transition")
				.removeClass("fade-in")
        .addClass("slide-up");
        $("body").addClass("transition-out");
        $("body").removeClass("loaded");
			setTimeout(function() {
				window.scrollTo(0, 0);
				resolve();
			}, 850);
		});
	},
	finish: function() {
		updateNavMenu(this.newContainer.baseURI);
		// doMasonry()
		$("body").attr("class", bodyClasses + " transition-out");
		routes.loadEvents();

		if (anchor) {
			// window.scrollTo(0, $('#'+anchor).offset().top)
			setTimeout(() => {
				$("html, body").animate(
					{
						scrollTop: $("#" + anchor).offset().top,
					},
					0
				);
			}, 500);
			setTimeout(() => {
				$("#transition")
					.addClass("fade-in")
          .removeClass("slide-up");
          $("body").addClass("transition-in");
			}, 600);
			setTimeout(() => {
				$("body").removeClass("transition-in");
			}, 1100);
		} else {
			$("#transition")
				.addClass("fade-in")
        .removeClass("slide-up");
        $("body").addClass("transition-in");
        $("body").removeClass("transition-out");
        // debugger; //eslint-disable-line
			setTimeout(() => {
        $("body").removeClass("transition-in");
        $("body").addClass("loaded");
        // debugger; //eslint-disable-line
			}, 1000);
		}
		this.done();
	},
});

$('body').on('click', '.mob-toggle', function(){
	$('body').toggleClass('nav-open')
  })

//Update the nav current item
function updateNavMenu(uri) {
	if (uri) {
		var $nav = $(".inner-nav");
		$nav.children(".current-menu-item").removeClass("current-menu-item");
		if (uri.indexOf("portfolio") > 0) {
			$nav.children(".nav-work").addClass("current-menu-item");
		} else if (uri.indexOf("press") > 0) {
			$nav.children(".nav-press").addClass("current-menu-item");
		} else if (uri.indexOf("shop") > 0) {
			$nav.children(".nav-shop").addClass("current-menu-item");
		} else if (uri.indexOf("cart") > 0) {
			$nav.children(".nav-shop").addClass("current-menu-item");
		} else if (uri.indexOf("checkout") > 0) {
			$nav.children(".nav-shop").addClass("current-menu-item");
		} else if (uri.indexOf("about") > 0) {
			$nav.children(".nav-about").addClass("current-menu-item");
		}
	}
}

// var grid
// var msnry //eslint-disable-line

// $(document).ready(function(){
// 	if( $('.m-grid').length > 0 ) {
// 		msnry.layout() // eslint-disable-line
// 	}
// })

// $(window).on('scroll', function(){
// 	if( $('.m-grid').length > 0 ) {
// 	msnry.layout() // eslint-disable-line
// 	console.log('scroll event main') // eslint-disable-line
// 	}
// })

// function doMasonry() {  
// 	if( $('.m-grid').length > 0 ) {
// 	grid = document.querySelector(".m-grid");
// 	/* eslint-disable */
// 	msnry = new Masonry(grid, {
// 		itemSelector: ".m-grid-item",
// 	});
// 	/* eslint-enable */

// 		$(document).ready(function(){
// 			if( $('.m-grid').length > 0 ) {
// 				msnry.layout() // eslint-disable-line
// 			}
// 		})
// 	}
// }

//Assign transition & config
Barba.Pjax.getTransition = function() {
	return slideAndFade;
};
Barba.Pjax.Dom.wrapperId = "wrapper";
Barba.Pjax.Dom.containerClass = "content";

Barba.Dispatcher.on("initStateChange", function() {
	// if (typeof ga === "function") {
	// 	ga("send", "pageview", location.pathname);
	// }
});

Barba.Dispatcher.on("linkClicked", function(e) {
	if (e.dataset.anchor) {
		anchor = e.dataset.anchor;
	} else {
		anchor = false;
	}
});

//This grabs the body classes and reassigns them when changing pages
//This is needed because the wrapper/content that barba changes exists inside of the body.
var originalFn = Barba.Pjax.Dom.parseResponse;
Barba.Pjax.Dom.parseResponse = function(response) {
	response = response.replace(
		/(<\/?)body( .+?)?>/gi,
		"$1notbody$2>",
		response
	);
	bodyClasses = $(response)
		.filter("notbody")
		.attr("class");
	return originalFn.apply(Barba.Pjax.Dom, arguments);
};

//Init Barba
Barba.Pjax.start();

//End of Barba

// Load Events
jQuery(document).ready(() => routes.loadEvents());

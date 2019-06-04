import Masonry from "masonry-layout"; //eslint-disable-line

export default {
  init() {
	// JavaScript to be fired on all pages

	barbaCheck()
	// startMasonry()

	function barbaCheck() {
		console.log('barba check') //eslint-disable-line
		if( $('body').hasClass('transition-in') ) {
			setTimeout(function(){
				barbaCheck()
			}, 50)
		} else {
			if( $('body').find('.m-grid').length > 0 ) { // eslint-disable-line
				console.log('fired') //eslint-disable-line
				$(document).ready(function(){
					console.log('ready') //eslint-disable-line
					// msnry.layout(); // eslint-disable-line
					startMasonry()
				})
			}
		}
	}

	// startMasonry()	//eslint-disable-line

    if( $('body').hasClass('single-product') ) {
      $('#menu-item-30').addClass('current-menu-item')
    }

	$(document).ready(function(){
		$('.logo').addClass('loaded')
		$('body').addClass('loaded')
		$('.spash-screen.real').attr('style', '')
		cartTotal()
		replaceRemove()
		startMasonry()
	})
	
	var mgrid
	var msnry

	function startMasonry() {
		setTimeout(function(){
			mgrid = document.querySelector(".m-grid");
			if( mgrid ) {
				/* eslint-disable */
				msnry = new Masonry(mgrid, {
					itemSelector: ".m-grid-item",
				});
				/* eslint-enable */

				$('body').find('.m-grid').css({
					'transform' : 'translateY(0)',
					'transition' : 'all 0.3s cubic-bezier(0.61, 0.34, 0.26, 0.79)',
					'opacity' : '1',
				})
			}
		}, 1000)
		
	}

    $( document.body ).on( 'updated_cart_totals', function(){
      replaceRemove()
    })

	$(window).on('scroll', function(){
		if( mgrid ) {
			msnry.layout() // eslint-disable-line
		}
	})

	$(document).ready(function(){
		if( mgrid ) { // eslint-disable-line
			msnry.layout(); // eslint-disable-line
		}
	})

    // function doMasonry() {  
    //   if( $('.m-grid').length > 0 ) {
    //     grid = document.querySelector(".m-grid");
    //     /* eslint-disable */
    //     msnry = new Masonry(grid, {
    //       itemSelector: ".m-grid-item",
    //     });
    //     /* eslint-enable */
    //   }
    // }

    function cartTotal() {
      var mnu = $('.menu-item-112')
      var counter = $('.cart-total-rdp').html()
      if( parseInt(counter) > 0 ) {
        if( $('.cart-total-menu').length == 0 ) {
          mnu.append(`<div class="cart-total-menu">${counter}</div>`)
        } else {
          $('.cart-total-menu').html(counter)
        }
      }
    }

    function replaceRemove() {
      $('.remove').html(`
      <svg width="25px" height="25px" viewBox="0 0 25 25" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
          <!-- Generator: Sketch 51.3 (57544) - http://www.bohemiancoding.com/sketch -->
          <title>search-to-close</title>
          <desc>Created with Sketch.</desc>
          <defs></defs>
          <g id="Desktop" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <g id="search-to-close" transform="translate(-1.000000, -1.000000)" stroke="#111111">
                  <path d="M1.5,1.5 L25.5,25.5" id="Shape" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="33.94"></path>
                  <path d="M25.5,1.5 L1.5,25.5" id="Shape" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="33.94"></path>
                  <circle id="Oval" opacity="0" stroke-linecap="square" cx="10.5" cy="10.5" r="10"></circle>
              </g>
          </g>
      </svg>`)
    }
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};

/**
 * Banner Close Button Handler
 * Security fix: Replace inline onclick handlers with event delegation
 * 
 * @package wpberita
 */

(function() {
'use strict';

// Delegated event handler for banner close buttons
document.addEventListener( 'click', function( e ) {
var target = e.target;

// Check if clicked element or its parent has the data-banner-close attribute
var closeButton = target.closest ? target.closest( '[data-banner-close]' ) : null;

if ( ! closeButton ) {
// Fallback for older browsers
while ( target && target !== document ) {
if ( target.getAttribute && target.getAttribute( 'data-banner-close' ) ) {
closeButton = target;
break;
}
target = target.parentNode;
}
}

if ( closeButton ) {
e.preventDefault();

// Find the closest banner container and remove it
var bannerContainer = closeButton.closest( '.gmr-floatbanner' ) || 
                      closeButton.closest( '.gmr-bannerpopup' );

if ( bannerContainer ) {
// Add fade-out effect if CSS supports it
bannerContainer.style.opacity = '0';
bannerContainer.style.transition = 'opacity 0.3s ease';

// Remove after transition
setTimeout( function() {
bannerContainer.parentNode.removeChild( bannerContainer );
}, 300 );
}
}
});
})();

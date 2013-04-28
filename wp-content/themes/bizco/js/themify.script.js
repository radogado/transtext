jQuery(document).ready(function($){
	
	/////////////////////////////////////////////
	// Initialize prettyPhoto					
	/////////////////////////////////////////////
	// To customize theme, use 'themify_overlay_gallery_theme' filter hook
	// Use light_rounded / pp_default / light_square / dark_rounded / dark_square / facebook
	if (screen.width>=600 && ($("a[rel^='prettyPhoto'], .gallery-icon a").length > 0) && typeof (jQuery.fn.prettyPhoto) !== 'undefined') {
		$("a[rel^='prettyPhoto'], .gallery-icon a").prettyPhoto({
			social_tools : false,
			deeplinking: false, overlay_gallery: false,
			theme : themifyScript.overlayTheme
		});
	}

	/////////////////////////////////////////////
	// HTML5 placeholder fallback	 							
	/////////////////////////////////////////////
	$('[placeholder]').focus(function() {
	  var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
	    input.val('');
	    input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
	    input.addClass('placeholder');
	    input.val(input.attr('placeholder'));
	  }
	}).blur();
	$('[placeholder]').parents('form').submit(function() {
	  $(this).find('[placeholder]').each(function() {
	    var input = $(this);
	    if (input.val() == input.attr('placeholder')) {
		 input.val('');
	    }
	  })
	});
	
	/////////////////////////////////////////////
	// Prepend zoom icon to highlights 							
	/////////////////////////////////////////////
	$('.home-highlights .lightbox').prepend('<span class="zoom"></span>');
	
	/////////////////////////////////////////////
	// Toggle menu on mobile 							
	/////////////////////////////////////////////
	$("#menu-icon").click(function(){
		$("#headerwrap #main-nav").fadeToggle();
		$("#headerwrap #searchform").hide();
		$(this).toggleClass("active");
	});

});
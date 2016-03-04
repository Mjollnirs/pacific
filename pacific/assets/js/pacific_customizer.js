jQuery(document).ready(function() {
	/* Block links in customizer */
	if( !jQuery( ".pacific-links" ).length ) {
		jQuery('#customize-theme-controls > ul').prepend('<li class="accordion-section pacific-links">');
		jQuery('.pacific-links').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://github.com/BrazenlyGeek/Pacific" class="button" target="_blank">{GitHub}</a>'.replace('{GitHub}', pacificCustomizerObject.GitHub));
		jQuery('.pacific-links').append('<a style="width: 80%; margin: 5px auto 5px auto; display: block; text-align: center;" href="https://wordpress.org/plugins/thesis-openhook/" class="button" target="_blank">{OpenHook}</a>'.replace('{OpenHook}', pacificCustomizerObject.OpenHook));
		jQuery('#customize-theme-controls > ul').prepend('</li>');
	}
});
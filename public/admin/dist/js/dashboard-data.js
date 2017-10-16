/*Dashboard Init*/
 
"use strict"; 

/*****Ready function start*****/
$(document).ready(function(){

});
/*****Ready function end*****/

/*****Load function start*****/
$(window).load(function(){
	window.setTimeout(function(){
		$.toast({
			heading: 'Welcome to Philbert',
			text: 'Use the predefined ones, or specify a custom position object.',
			position: 'top-right',
			loaderBg:'#f0c541',
			icon: 'success',
			hideAfter: 3500, 
			stack: 6
		});
	}, 3000);
});
/*****Load function* end*****/

jQuery(document).ready(function($) {
	$("ul.sf-menu").superfish({
        animation: {height:'show'},
        delay:     200 ,
        autoArrows:  false,
        speed: 200
    });
    $('.home-slider').flexslider({
        animation: "fade",
        controlNav: false,
        directionNav: true,
        keyboardNav: false
    });

    $('.project-slider').flexslider({
    	animation: "fade",
    	controlNav: false,
    	directionNav: true,
    	keyboardNav: false
    });

	$('a[data-rel]').each(function() {
	    $(this).attr('rel', $(this).data('rel'));
	});

	$("a[rel^='prettyPhoto']").prettyPhoto();

	$("<select id='comboNav' />").appendTo("#combo-holder");

	$("<option />", {
		"selected": "selected",
		"value"   : "",
		"text"    : "Menu"
	}).appendTo("#combo-holder select");

	$("#nav a").each(function() {
		var el = $(this);
		var label = $(this).parent().parent().attr('id');
		var sub = (label == 'nav') ? '' : '- ';

		$("<option />", {
		 "value"   : el.attr("href"),
		 "text"    :  sub + el.text()
		}).appendTo("#combo-holder select");
	});

	$("#comboNav").change(function() {
	  location = this.options[this.selectedIndex].value;
	});
});
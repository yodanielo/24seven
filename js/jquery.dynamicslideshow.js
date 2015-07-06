/*
 * jQuery Dynamic Slideshow 2.0
 * By Yusuf Najmuddin (http://ynzi.com)
 * Copyright (c) 2009-2010 Yusuf Najmuddin
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php

Usage:

The whole idea of this plugin is that in pages requiring image slideshow, the <img> tag is not used so as to keep the page size smaller and load time faster. So I use <a> tag instead.

// Hence the markup would be something like:

<div id="slider" style="position: relative; width: 200px; height: 200px;overflow: hidden;">
	<a href="image1.jpg" alt="http://example.com?1">Image 1</a><br /> 
	<a href="image2.jpg" alt="http://example.com?2">Image 2</a><br /> 

	<a href="imageN.jpg" alt="http://example.com?3">Image N</a><br /> 
</div>



// To start the slideshow:

$(function(){
	$("#slider").dynamicSlideshow(<optional args>);
});

// Description of args
args = {
duration: 3000, // The time duration between two images. Note: time = duration + load time of the image
img: 'href',    // The attribute which has the path to the image
url: 'alt',		// The attribute which has the hyperlink to the image
title: null		// The jquery css selector string where image description will be displayed. 
				   Image description is the innerHTML of the <a> anchor tag.
data: [[<image url>, <image title>, <image hyperlink>],...] // can be used if you want to start the slideshow using content via api etc.
}

All arguments are optional

*/


jQuery.fn.dynamicSlideshow = function(args) {
	args = args || {};
	args.duration = args.duration || 3000;
	args.img = args.img || 'href';
	args.url = args.url || 'alt';
	
	var isLinkable = false;
	var img = args.data || [];
	var container = null;
	var curr = 1;
	function initSlider() {
		setInterval( function(){
			if (curr == img.length) {
				curr = 0;
			}
			var i = new Image();
			$(i).load(function(){
				$(container).append(this);
				$(container).find('img:first').css({'z-index': 1});
				$(this).css({opacity: 0.0, 'z-index': 2}).animate({opacity: 1.0}, 1000, function() {
						$(container).find('img:first').remove();
						if (isLinkable && img[curr-1][2]) $(container).attr('href',img[curr-1][2] + '');
						else $(container).removeAttr('href');
						if (args.title) $(args.title).html(img[curr-1][1] + '');
				});
			}).attr('src', img[curr++][0]).css({position:'absolute',top:0,left:0,'z-index':8});
		}, args.duration );
	};

	$(this).each(function(){
		$(this).find("img").each(function(){
			if ($(this).attr(args.url)) isLinkable = true;
			img.push([$(this).attr('src'), $(this).attr('alt'), $(this).attr(args.url)]);		
		});
		$(this).find("a").each(function(){
			if ($(this).attr(args.url)) isLinkable = true;
			img.push([$(this).attr(args.img), $(this).html(), $(this).attr(args.url)]);		
		});
		
		$(this).empty();
		if (isLinkable) {
			$(this).html('<a></a>');
			container = $(this).find('a');
		} else container = this;

		var j = new Image();
		$(j).load(function(){
			$(container).append(this);
			if (isLinkable) $(container).attr('href',img[0][2]);
			if (args.title) $(args.title).html(img[0][1] + '');
			initSlider();
		}).attr('src', img[0][0]).css({position:'absolute',top:0,left:0,'z-index':0});
	});
}

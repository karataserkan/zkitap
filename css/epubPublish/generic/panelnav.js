
function loaded() {
	  $('.panel-sliding-rw, .panel-tutorial-rw, .panel-scrolling-rw').each(function (index) {
	      new iScroll($(this).attr('id'),{
	snap: true});
	   });
  	document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
	document.addEventListener('DOMContentLoaded', loaded, false);
}

$(document).ready(function() {
	setTimeout(function(){loaded()},5);
});

// Nisga'a Tribe jQuery UI elements for Client Side
// Triggers Framework events and client events
var N=new Nisga();
$( document ).ready(function () {
	
	console.log( T);
	console.log( N);
	console.log( C);


	function firs_time(){
		$( ".component" ).draggable({helper: "clone",revert: "valid"});
		$('#current_page').droppable({ drop: function (event,ui) { 
			//create a component object from dom object 
			//pass it to Tlingit
			var component;

		new Tlingit().componentHasCreated(component);
	 	} } );


	 	$('#zoom-pane').slider({
	      value:100,
	      min: 25,
	      max: 500,
	      step: 25,
	      slide: function( event, ui ) {
	        $('#author_pane').css({'zoom': (ui.value/100) });
	      }
	    });
	}

	

firs_time();
  


	
});

function Nisga (){
	this.createComponent=function(component){
		//get component and work on it on UI
		$(element).append('<div style="position:absolute;top:' + ( ui.offset.top-$(element).offset().top )+ 
			'px;left:' + ( ui.offset.left-$(element).offset().left )
			+ 'px;">Text</div>'); 

	}
}
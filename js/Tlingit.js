// Tlingit Tribe jQuery FrameWork for communitacions between Servers and Client Side
// Combines all events created by BackEnd, Co-Working and Client
// Triggers events accordingly and simultenously.
// Control layer for all events. All events here should be trigged to pass other controls by this class

var T=new Tlingit();
$( document ).ready(function () {




});

function Tlingit (){
	this.componentHasCreated=function(component){
		//co -workerlar yeni component yaratmış
		new Nisga().createComponent(component);
	}

	this.componentToJson=function(component){
		//build json of component
	}

	this.jsonToComponent=function(jsonComponent){
		//build component from json data
	}

	this.loadPage=function(page_id){
		//page ile ilgili componentların hepsini serverdan çek.
		// hepsi için createComponent
	}

	this.createComponent=function(component){
		//servera post et
		//co - workerlara
		// Nisga bildir.
	}

	
	this.snycServer=function(action,jsonComponent){
		//ajax to Server
	}

	this.snycCoworkers=function(action,jsonComponent){
		//Socket API for Co-Working
	}
}
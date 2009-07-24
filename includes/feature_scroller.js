var show_feature = 0;

var rotate = '';

var pause = '';

var filter = '';
var section = '';

$(document).ready(function(){
	
	//goto_feature(0,filter,section)
	//start_interval();
	
	$("#feature-scroller a").click(function(scroller){
		window.clearInterval(rotate);
		rotate = '';
		pause = setTimeout("start_interval()",60000);
		scroller.preventDefault();
		var id = $(this).attr('id');
		
		if(id == 'scroll-prev'){
			if(show_feature>0){
				show_feature-=1;
				prev_feature = show_feature;
			}else{
				show_feature = 4;
				prev_feature = 4;
			}
			
			goto_feature(prev_feature,filter,section);
			
		}else if(id == 'scroll-next'){
			if(show_feature<4){
				show_feature+=1;
				next_feature = show_feature;
				
			}else{
				show_feature = 0;
				next_feature = 0;
			}
			
			goto_feature(next_feature,filter,section);
			
		}else{
			var bit = id.split("-");
			goto_feature(bit[1],filter,section);
			
			var bitint = parseInt(bit[1]);
			
			show_feature = bitint;
			
			/*$(".active").removeClass("active");
			$("#scroll-"+bit[1]).addClass("active");*/
		}
		
	});

});

function start_interval(get_filter,get_section){
	
	filter = get_filter;
	section = get_section
	
	window.clearTimeout(pause);
	pause = '';
	
	window.clearInterval(rotate);
	rotate = '';

	rotate = setInterval(function(){
	
	/*$("#feature-holder").fadeOut("slow", function(){*/

		if(show_feature<4){
		
			show_feature++;
		
		}else{
			
			show_feature=0;
			
		}
		
		var feature_id = show_feature;
		
		goto_feature(feature_id,filter,section);
		
		//for( var x in document.getElementsByName('scroll-button')){
		//	document.getElementsByName('scroll-button').item(x).className="";
		//}
		
		//document.getElementById('scroll-'+show_feature).className="active";
		
		/*$(".active").removeClass("active");
		$("#scroll-"+show_feature).addClass("active");*/
	
	/*})*/},20000);
	
}

function goto_feature(feature_id,get_filter,get_section){
	
	filter = get_filter;
	section = get_section
	
	$(".active").removeClass("active");
	$("#scroll-"+feature_id).addClass("active");
	
	var xmlhttp;

	get_feature(feature_id,filter,section);
	
	function get_feature(feature_id,filter,section){
		
		xmlhttp=GetXmlHttpObject();
		
		if (xmlhttp==null){
			alert ("Your browser does not support AJAX!");
			return;
		}
		
		var url="http://www.scorecomms.com/fsn/includes/get_feature.php";
		url=url+"?f="+feature_id;
		url=url+"&filter="+filter;
		url=url+"&section="+section;
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=stateChanged;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	
	}
	
	function stateChanged(){
		
		if (xmlhttp.readyState==4){
			$("#feature-holder").fadeOut("slow", function(){
				$("#feature-holder").html(xmlhttp.responseText);
				$("#feature-holder").fadeIn("slow");
			});
		}
	
	}
	
	function GetXmlHttpObject(){
		
		if (window.XMLHttpRequest){
			
			// code for IE7+, Firefox, Chrome, Opera, Safari
			return new XMLHttpRequest();
		}
		
		if (window.ActiveXObject){
			
			// code for IE6, IE5
			return new ActiveXObject("Microsoft.XMLHTTP");
			
		}
		return null;
	}
	
}
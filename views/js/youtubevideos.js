function get_videos_num(){
  return document.getElementById("videos-list").children.length;
}

document.getElementById("load_more_videos").addEventListener('click', function(){
  document.getElementById("load_more_videos").style.display = "none";
  document.getElementById("loader").style.display = "block";
  toggle_nav();
  load_more_videos(xmlHttp,baseUrl+"/youtubevideos/ajax/more_videos");
}, false);

window.addEventListener('load', function(){
	var vid_count = parseInt(document.getElementsByClassName("video-count")[0].innerHTML);
	var view_count = parseInt(document.getElementsByClassName("view-count")[0].innerHTML);
	var sub_count = parseInt(document.getElementsByClassName("subscriber-count")[0].innerHTML);

	var i = 0;

	var fps = 60;
	var now;
	var then = Date.now();
	var interval = 1000/fps;
	var delta;
	var count_finished = false;

	function run_counting() {

		now = Date.now();
		delta = now - then;
		
		if (!count_finished){
			window.requestAnimationFrame(run_counting);
		}
     
    if (delta > interval) {

			then = now - (delta % interval);
			console.log(delta);

			if (i <= vid_count){
				yt_stats_increment_effect(vid_count, view_count, sub_count, i);
			}
			else{
				yt_stats_increment_effect(vid_count, view_count, sub_count, vid_count);
				count_finished = !count_finished;
			}
			i = i + (vid_count/(fps*2))*(delta/interval);
			
		}
	}

	run_counting();

});

function yt_stats_increment_effect(vid_count, view_count, sub_count, counter){
	document.getElementsByClassName("video-count")[0].innerHTML = Math.floor(vid_count*(counter/vid_count))
	document.getElementsByClassName("view-count")[0].innerHTML = Math.floor(view_count*(counter/vid_count))
	document.getElementsByClassName("subscriber-count")[0].innerHTML = Math.floor(sub_count*(counter/vid_count))
}

function load_more_videos(xmlHttp,file_location){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
    var videos_num = get_videos_num();
	  xmlHttp.open("GET", file_location+"/"+videos_num, true); //Creates the request. true is to make the request asynchronous
		//the last parameter is set to false in order for the request to be executed sychronously, so avoid different values to be returned from the XML php file. The reg parameter is used to check whether the sign up button is clicked.
		xmlHttp.onreadystatechange = function(){
      if(this.readyState==4){ //if the oibject is done communicating and response is ready
    		if(this.status==200){ //if communication went ok (so 200 means that communication was successful)
    			// //alert(xmlHttp.responseText)
    			// xmlResponse = xmlHttp.responseXML; //exttracting the xml file from the registerVal.php file
    			// xmlDocumentElement = xmlResponse.documentElement; //root of the xml file
    			// message = xmlDocumentElement.firstChild.data; //gets the result from the code executed within the response tags
    			// postsEl.removeChild(postsEl.children[postsEl.children.length-1]);
    			// document.getElementsByClassName('comments')[0].innerHTML = document.getElementsByClassName('comments')[0].innerHTML + message;
          document.getElementsByClassName("videos-cont")[0].innerHTML  += this.responseText;
          document.getElementById("loader").style.display= "none";
          document.getElementById("load_more_videos").style.display = "block";
          document.getElementsByClassName("videos-cont")[0].style.display = "inline-block";
    		}
    	}
		}
		xmlHttp.send(null); //sends the request ot the server
	}
	else{
		setTimeout('load_more_videos(file_location)',1000);
	}
}

window.addEventListener("load", function(){
//console.log(document.getElementById("videos-list").children)
  if (document.getElementById("videos-list").children.length == 0){
    document.getElementById("loader").style.display= "block";
    load_more_videos(xmlHttp,baseUrl+"/youtubevideos/ajax/more_videos");
  }
}, false);

// window.fbAsyncInit = function() {
//   FB.init({
//     appId            : 'your-app-id',
//     autoLogAppEvents : true,
//     xfbml            : true,
//     version          : 'v3.1'
//   });
// };
//
// (function(d, s, id){
//    var js, fjs = d.getElementsByTagName(s)[0];
//    if (d.getElementById(id)) {return;}
//    js = d.createElement(s); js.id = id;
//    js.src = "https://connect.facebook.net/en_US/sdk.js";
//    fjs.parentNode.insertBefore(js, fjs);
//  }(document, 'script', 'facebook-jssdk'));

var fbButton = document.getElementById('fb-share-button');
var url = window.location.href;

var getUrl = window.location;
var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];

if (fbButton != undefined){
  fbButton.addEventListener('click', function() {
      window.open('https://www.facebook.com/sharer/sharer.php?u=' + url,
          'facebook-share-dialog',
          'width=800,height=600'
      );
      return false;
  });
}

function toggle_nav(){
  if (document.getElementById("navbar-wrap-toggle") != null){
    var navbar = document.getElementById("navbar-wrap-toggle");
    var navbar_display = window.getComputedStyle(navbar,null).getPropertyValue("display");
  //console.log(navbar_display);
    if (navbar_display == "block")
      document.getElementById("navbar-wrap-toggle").style.display = "none";
    else
      document.getElementById("navbar-wrap-toggle").style.display = "block";
  }
}

if (document.getElementById("mobile-nav-btn") != null){
  document.getElementById("mobile-nav-btn").addEventListener('click', toggle_nav, false);
}
// document.body.addEventListener('click', toggle_nav, false);

if (document.getElementById("account") != null){
  document.getElementById('account').addEventListener('click', function(){
  	document.getElementById('js-profile-popup').style.display = "block";
  }, false);
}

window.addEventListener('click', function(event){
  if (document.getElementById("account") != null && document.getElementById("js-profile-popup") != null){
  	if(event.target.id != 'account' && event.target.id != 'js-profile-popup'){
  		document.getElementById('js-profile-popup').style.display = "none";
  	}
  }
}, false)

//youtube videos

function createXmlHttpReuestObject(){
	var xmlHttp;

	if(window.ActiveXObject){ //if user uses internet explorer
		try{
			xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(e){
			xmlHttp = false;
		}
	}
	else{
		try{
			xmlHttp = new XMLHttpRequest();
		}
		catch(e){
			xmlHttp = false;
		}
	}

	if(xmlHttp === false){
		alert("Cant validate");
	}
	else{
		return xmlHttp;
	}
}

var xmlHttp = createXmlHttpReuestObject();

if (document.getElementsByClassName("search-input")[0] != undefined){
  document.getElementsByClassName("search-input")[0].addEventListener("keyup", function(){
    similar_results(xmlHttp, baseUrl+"/universal/ajax/search_results/"+this.value);
  },false)
}

function similar_results(xmlHttp,file_location){
  if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
    xmlHttp.open("GET", file_location, true); //Creates the request. true is to make the request asynchronous
    //the last parameter is set to false in order for the request to be executed sychronously, so avoid different values to be returned from the XML php file. The reg parameter is used to check whether the sign up button is clicked.
    xmlHttp.onreadystatechange = function(){
      if(this.readyState==4){ //if the oibject is done communicating and response is ready
        if(this.status==200){ //if communication went ok (so 200 means that communication was successful)
            // document.getElementsByClassName("comments")[0].getElementsByClassName("comments-list")[0].innerHTML = this.responseText;
            // add_functionality(); //adds events to the comment section
            // var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.display;
            // if (document.getElementsByClassName("comments_pages_list")[0].children.length == 0){
            //   comments_pages_indicator(xmlHttp,baseUrl+"/blog/ajax/comm_sect_pages/"+article_id+"/"+display);
            // }
            //console.log(this.responseXML);
            // console.log(this.responseXML);

            if (this.responseText == "no results"){
              if (document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0] != undefined){
                document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0].innerHTML = "";
              }
              return;
            }

            if (document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0] != undefined){
              document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0].innerHTML = "";
              if (this.responseXML.documentElement.children.length != 0){
                for(var i = 0; i<this.responseXML.documentElement.children.length; i++){
                  var list_item = '<li class="result-item">';

                  list_item += '<div class="result-thumb-wrap"><img data-pin-nopin class="result-thumb" src=baseUrl+"/storage/images/blog/article-'+this.responseXML.documentElement.children[i].children[0].innerHTML+'/'+this.responseXML.documentElement.children[i].children[1].innerHTML+'"/></div>';
                  list_item += '<div class="result-title-wrap"><a class="result-title" href=baseUrl+"/blog/article/'+this.responseXML.documentElement.children[i].children[3].innerHTML+'"><p>'+this.responseXML.documentElement.children[i].children[2].innerHTML+'</p></a></div></li>';

                  document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0].innerHTML += list_item;
                }
              }
              else{
                document.getElementsByClassName("search-results")[0].getElementsByClassName("results-list")[0].innerHTML = "";
              }
            }
        }
      }
    }
    xmlHttp.send(null); //sends the request ot the server
  }
  else{
    setTimeout('similar_results(xmlHttp,file_location)',1000);
  }
}

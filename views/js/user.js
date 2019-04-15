/* comment settings */

function comment_settings(user_id){
  var order_dropdown_options = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("popup__action");
  var display_dropdown_options = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("popup__action");
	var type_dropdown_options = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("popup__action");
  var order_dropdown = document.getElementsByClassName("order-dropdown")[0];
  var display_dropdown = document.getElementsByClassName("display-dropdown")[0];
  var type_dropdown = document.getElementsByClassName("type-dropdown")[0];

  //applies the settings adjusted by the user
  function apply_settings(dropdown, options, setting_type){
    for (var btn = 0; btn < options.length; btn++){
      function closure(btn){
        options[btn].addEventListener("click", function(){

          var setting = this.getAttribute("data-"+setting_type); //getting the setting dropdown selection
          var setting_span = this.getElementsByClassName("option-title")[0].innerHTML; //getting the setting title
          dropdown.getElementsByClassName("button__toggle")[0].setAttribute("data-"+setting_type, setting); //changing the top toggle button
          dropdown.getElementsByClassName("button__toggle")[0].getElementsByClassName("option-title")[0].innerHTML = setting_span; //changing the toggle button title

          if (setting_type == "order"){ //if this is the order setting
            var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-display"); //getting the option sleected on the display setting
						var type = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-type"); //getting the option sleected on the comment type setting
            get_comments(xmlHttp,baseUrl+"/user/ajax/comments/"+user_id+"/"+setting+"/"+display+"/"+type+"/1"); // url parameters : artice_id/order/display/page
          }
					else if(setting_type == "display"){ //if this is the display setting
            var order = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-order"); //getting the option sleected on the other setting
						var type = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-type"); //getting the option sleected on the comment type setting
						document.getElementsByClassName("comments_pages_list")[0].innerHTML = "";
            get_comments(xmlHttp,baseUrl+"/user/ajax/comments/"+user_id+"/"+order+"/"+setting+"/"+type+"/1"); // url parameters : artice_id/order/display/page
          }
					else if(setting_type == "type"){ //if this is the display setting
						var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-display"); //getting the option sleected on the display setting
						var order = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("button__toggle")[0].getAttribute("data-order"); //getting the option sleected on the other setting
            document.getElementsByClassName("comments_pages_list")[0].innerHTML = "";
            get_comments(xmlHttp,baseUrl+"/user/ajax/comments/"+user_id+"/"+order+"/"+display+"/"+setting+"/1"); // url parameters : artice_id/order/display/page
          }
        }, false);
      }
      closure(btn);
    }
  }

  apply_settings(order_dropdown, order_dropdown_options, "order");
  apply_settings(display_dropdown, display_dropdown_options, "display");
  apply_settings(type_dropdown, type_dropdown_options, "type");
}

function comment_page(comments_nav_el, comments_nav_elements, index){
  var element = document.createElement("li");
  element.className = "comment_page";

  var button = document.createElement("button");
  button.setAttribute("type", "button");
  button.setAttribute("data-page", index);
  button.className = "page_btn";

  if (comments_nav_el.children.length == 0 && index == 1){
    button.classList.add("current_page");
  }

  var text_node = document.createTextNode(index);
  button.appendChild(text_node);
  element.appendChild(button);
  comments_nav_el.appendChild(element);

  button.addEventListener('click', function(){
    var user_id = document.getElementsByClassName("all-comments")[0].dataset.userId;
    var order = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.order;
    var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.display;
    var type = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.type;
    //console.log(order,display);

    get_comments(xmlHttp,baseUrl+"/user/ajax/comments/"+user_id+"/"+order+"/"+display+"/"+type+"/"+index);
    for (var list = 0; list < comments_nav_elements.length; list++){
      var comm_page_btns = comments_nav_elements[list].getElementsByClassName("page_btn");

      for (var btn = 0; btn < comm_page_btns.length; btn++){
        comm_page_btns[btn].classList.remove("current_page");
      }
      comments_nav_elements[list].getElementsByClassName("page_btn")[index-1].classList.add("current_page");
    }

    var comments_box = document.getElementsByClassName("comments-wrapper")[0];

    document.getElementsByClassName("all-comments")[0].scrollIntoView({ block: 'start',  behavior: 'smooth' });

    // button.classList.add("current_page");
  //console.log(button);
  }, false);
}

function comments_pages_indicator(xmlHttp, file_location){
  if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	  xmlHttp.open("GET", file_location, true); //Creates the request. true is to make the request asynchronous
		//the last parameter is set to false in order for the request to be executed sychronously, so avoid different values to be returned from the XML php file. The reg parameter is used to check whether the sign up button is clicked.
		xmlHttp.onreadystatechange = function(){
      if(this.readyState==4){ //if the oibject is done communicating and response is ready
    		if(this.status==200){ //if communication went ok (so 200 means that communication was successful)
        //console.log(this.responseText);
          if (this.responseText != undefined){
            var pages = this.responseText
            var comments_pages_lists = document.getElementsByClassName('comments_pages_list');
            for (var list = 0; list < comments_pages_lists.length; list++){
              var comments_nav_el = document.getElementsByClassName('comments_pages_list')[list];
              comments_nav_el.innerHTML = "";
              for (var page = 1; page <= pages; page++){
                comment_page(comments_nav_el, comments_pages_lists, page);
              }
            }
          }
    		}
    	}
		}
		xmlHttp.send(null); //sends the request ot the server
	}
	else{
		setTimeout('comments_pages_indicator(xmlHttp, file_location)',1000);
	}
}

function get_comments(xmlHttp,file_location){
	if(xmlHttp.readyState==0 || xmlHttp.readyState==4){
	  xmlHttp.open("GET", file_location, true); //Creates the request. true is to make the request asynchronous
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
          document.getElementsByClassName('comments')[0].innerHTML = this.responseText;
          if (document.getElementsByClassName("comments_pages_list")[0].children.length == 0){
            var user_id = document.getElementsByClassName("all-comments")[0].dataset.userId;
            var order = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.order;
            var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.display;
            var type = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.type;
            comments_pages_indicator(xmlHttp,baseUrl+"/user/ajax/comm_sect_pages/"+user_id+"/"+order+"/"+display+"/"+type);
          }
    		}
    	}
		}
		xmlHttp.send(null); //sends the request ot the server
	}
	else{
		setTimeout('get_comments(xmlHttp,file_location)',1000);
	}
}

window.addEventListener("load", function(){
  var order = document.getElementsByClassName("order-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.order;
  var display = document.getElementsByClassName("display-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.display;
	var type = document.getElementsByClassName("type-dropdown")[0].getElementsByClassName("button__toggle")[0].dataset.type;
	var user_id = document.getElementsByClassName("all-comments")[0].dataset.userId;
	comment_settings(user_id);
  get_comments(xmlHttp,baseUrl+"/user/ajax/comments/"+user_id+"/"+order+"/"+display+"/"+type+"/1");
}, false);

function tags_with_commas(tag_elements){
  var keywords = '';
  for (var tag = 0; tag<tag_elements.length; tag++){
    if (tag_elements.length -1 == tag){
      keywords += '"'+tag_elements[tag].childNodes[0].nodeValue+'"';
      break;
    }
    keywords += '"'+tag_elements[tag].childNodes[0].nodeValue+'",';
  }
  return keywords;
}

function add_keyword(keyword,keyword_box){
  var tag = document.createElement("span");
  var tag_label = document.createTextNode(keyword);
  var tag_cross = document.createElement("span");
  var cross = document.createTextNode("X");
  tag.appendChild(tag_label);
  tag_cross.appendChild(cross);
  tag.appendChild(tag_cross);
  tag_cross.className = "remove_tag";

  var blog_tags_el = keyword_box.getElementsByClassName("blog-tags")[0];
  blog_tags_el.insertBefore(tag, blog_tags_el.children[blog_tags_el.children.length-1]);

  tag.className = "keyword";
}

function remove_tags(keyword_box){ //adding the ability to remove tags once "X" is clicked
  var total_tags = keyword_box.getElementsByClassName("keyword");
  if (total_tags.length > 0){
    for (tag = 0; tag<total_tags.length; tag++){
      function closure (tag){
        total_tags[tag].addEventListener("click", function(){
          keyword_box.getElementsByClassName("blog-tags")[0].removeChild(this);
          keyword_box.getElementsByClassName("keywords_list")[0].value = tags_with_commas(total_tags);
        },false);
      }
      closure(tag);
    }
  }
}

function keywords_config(){
  var tag_boxes = document.getElementsByClassName("keywords-tags");
  for (tag = 0; tag<tag_boxes.length; tag++){

    function closure (tag){
      tag_boxes[tag].addEventListener("click", function(){
        tag_boxes[tag].getElementsByClassName("add-tag")[0].focus();
      },false);

      var add_tag_before_keyup = tag_boxes[tag].getElementsByClassName("add-tag")[0].value;

      tag_boxes[tag].getElementsByClassName("add-tag")[0].addEventListener("paste", function(e){
        setTimeout(function() {
          var tags = tag_boxes[tag].getElementsByClassName("add-tag")[0].value.replace(/"/g,'').split(",");
          var tags_modified = [];
          var keywords_list_el = tag_boxes[tag].getElementsByClassName("keywords_list")[0];

          for (var tag_span = 0; tag_span < tags.length; tag_span++){
            if (tags[tag_span].length > 1){
              if (tag_span == tags.length - 1){
                keywords_list_el.value += '"'+tags[tag_span]+'"';
                break;
              }
              keywords_list_el.value += '"'+tags[tag_span]+'",';

              add_keyword(tags[tag_span],tag_boxes[tag]);
            }
          }

          keywords_list_el.value = keywords_list_el.value.replace(/_([^,]*)$/, "");
          tag_boxes[tag].getElementsByClassName("add-tag")[0].value= ""; //emptying the input field
          tag_boxes[tag].getElementsByClassName("add-tag")[0].placeholder = "";
          add_tag_before_keyup = tag_boxes[tag].getElementsByClassName("add-tag")[0].value;
          remove_tags(tag_boxes[tag]);

        }, 0);
      },false);

      tag_boxes[tag].getElementsByClassName("add-tag")[0].addEventListener("keyup", function(e){
        if (e.key.length === 1 && e.key.match(/[a-z]/i)){
          this.placeholder = "";
          //document.getElementsByClassName("new_tag")[0].innerHTML += e.key;
          //searching through the children elements to remove the textnode
        }
        else{
          if(e.key == "Enter" || e.key == ","){ //add tag

            var add_tag = this.value.replace(/,/g,"");

            if (add_tag.length > 1){

              //adding the tag (by creating a SPAN tag)
              add_keyword(add_tag,tag_boxes[tag]);

              //don't insert comma if this is hte first tag added.
              if (tag_boxes[tag].getElementsByClassName("keywords_list")[0].value == ""){
                tag_boxes[tag].getElementsByClassName("keywords_list")[0].value = '"'+add_tag+'"';
              }
              else{
                tag_boxes[tag].getElementsByClassName("keywords_list")[0].value += ',"'+add_tag+'"';
              }

            }
            this.value = "";
          }
          else if (add_tag_before_keyup == "" && e.key == "Backspace"){ //removing tag by backspace if the add_tag input is empty

            //removing last tag
            var total_tags = tag_boxes[tag].getElementsByClassName("keyword");
            if (total_tags.length > 0){
              if (total_tags.length >= 1){
                var last_tag = tag_boxes[tag].getElementsByClassName("blog-tags")[0].children[total_tags.length-1];
              //console.log(last_tag);
                tag_boxes[tag].getElementsByClassName("blog-tags")[0].removeChild(last_tag);
              }

              this.value = last_tag.childNodes[0].nodeValue;

              //adding tags with commas in the hidden input element.

              tag_boxes[tag].getElementsByClassName("keywords_list")[0].value = tags_with_commas(total_tags);
            }
          }
          //adding tag remove events on every keyword added

          remove_tags(tag_boxes[tag]);

        }

        //adding the current value of the add_tag input just before the keyup event
        add_tag_before_keyup = this.value;

      },false)
    }
    closure(tag);
    remove_tags(tag_boxes[tag]); //adding remove functionalities to any possible existing tags
  }
}

keywords_config();

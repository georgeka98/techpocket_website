
for (var i = 0; i < document.getElementsByClassName("article-edit-form").length; i++){
  function closure(i){
    var edit_form = document.getElementsByClassName("article-edit-form")[i];
    edit_form.getElementsByClassName("submit-edits")[0].addEventListener('click', function() {
        var edit_title = edit_form.getElementsByClassName('edit-title')[0].innerHTML;
        var edit_text = edit_form.getElementsByClassName('edit-text')[0].innerHTML;
        var edit_teaser_par = edit_form.getElementsByClassName('edit-teaser-paragraph')[0].innerHTML;

        edit_form.getElementsByClassName("title-edited")[0].value = edit_title;
        edit_form.getElementsByClassName("text-edited")[0].value = edit_text;
        edit_form.getElementsByClassName('teaser-paragraph-edited')[0].value = edit_teaser_par;

        alert(edit_title)

        return true;
    });
  }
  closure(i);
}

/* adding plain text to contenteditable */

for(var i = 0; i < document.getElementsByClassName("edit__info").length - 1; i++){
  function closure(i){
    document.getElementsByClassName("edit__info")[i].addEventListener("paste", function(e) {
      // cancel paste
      e.preventDefault();

      // get text representation of clipboard
      var text = e.clipboardData.getData("Text");
    //console.log(text);

      // insert text manually
      document.execCommand("insertHTML", false, text);
    });
  }
  closure(i);
}

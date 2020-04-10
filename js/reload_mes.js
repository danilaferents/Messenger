function ReloadMessages(should_restart) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        document.getElementById("msgs").innerHTML = this.responseText;
        if (should_restart){
          setTimeout(ReloadMessages, 1000, true);
          }
    }
  };
  xhttp.open("GET", "/renovate_messages.php", true);
  xhttp.send();

}


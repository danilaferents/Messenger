function SendMessage() {
  var str = document.getElementById("mestext").value;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      ReloadMessages(false);
    }
  };
  xhttp.open("GET", "/send_message.php?mes="+str, true);
  xhttp.send();
}

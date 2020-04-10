

var chanel = 1;
var user = 2;
var user_name = "Spider Man";
var last_syn = "";

function LoadMessages() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        //document.getElementById("msgs").innerHTML = this.responseText;
	MakeMessage("Borisov Kolya", "Who are you?", "16:00:00 AM", "pics/Zelen.jpg");
	}
  };
  xhttp.open("GET", "php/load_messages.php?ch="+chanel, true);
  xhttp.send();
}

function MakeMessage(sender, text, date, pict_src)
{
   var sender = $('<div/>')
    .addClass("username")
      .text(sender).css("color", "lightblue");
   var text = $('<div/>')
    .addClass("msg-content").text(text);
   var msgtext = $('<div/>')
    .addClass("msg-text").append(sender).append(text);
   var avatar = $('<div/>').addClass("avatar").append($('<img/>', { src: pict_src }));
   var msg = $('<div/>').addClass("msg").append(avatar).append(msgtext);
   msg.append($('<div/>').addClass("msg-date").append($('<p/>').text(date)));
   var result = $('<div/>')
    .addClass("msg-back").append(msg);
   $('#all-messages').append(result);

}


function SendMessage() {
  var str = document.getElementById("write-form").innerHTML;
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      LoadMessages();
    }
  };
  xhttp.open("GET", "php/send_message.php?mes="+str+"&ch="+chanel+"&user="+user+"&username="+user_name, true);
  xhttp.send();
}



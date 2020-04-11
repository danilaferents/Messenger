

var chanel = 1;
var user = 2;
var user_name = "Spider Man";
var last_syn = "";

LoadMessages();
LoadChanels();
setTimeout(RenovateMessages, 1000, true);

function LoadMessages() {
  console.log(last_syn);
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		arr = JSON.parse(this.responseText);
		ShowMessages(arr);
		if (arr.length > 0){
			SetLastSynTime(arr[0]);
		}
	}
  };
  xhttp.open("GET", "php/load_messages.php?ch="+chanel+"&syn="+last_syn, true);
  xhttp.send();

}


function CleanMessages(){

	parent = document.getElementById('all-messages');
	arr = document.getElementsByClassName("msg-back");
	Array.from(arr).forEach((element) => parent.removeChild(element))
}

function PickChanel(item) {

	document.getElementsByClassName("chat active")[0].className = "chat";
	item.className = "chat active";
	CleanMessages();
	chanel = item.id;
	last_syn = "";
	console.log(chanel);
	LoadMessages();
}

function LoadChanels() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		arr = JSON.parse(this.responseText);
		ShowChanels(arr);
	}
  };
  xhttp.open("GET", "php/load_chanels.php", true);
  xhttp.send();

}


function RenovateMessages(renovate_again) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		//window.alert();
		arr = JSON.parse(this.responseText);
		ShowMessages(arr);
		if (arr.length > 0)
		{
			SetLastSynTime(arr[0]);
		}
		if (renovate_again)
		{
			setTimeout(RenovateMessages, 1000, true);
		}
	}
  };
  xhttp.open("GET", "php/load_messages.php?ch="+chanel+"&syn="+last_syn, true);
  xhttp.send();

}


function ShowMessages(arr){
	for (let i = arr.length - 1; i > -1; i--) {
        	MakeMessage(arr[i].sendername, arr[i].text, arr[i].created, arr[i].content); 
        }
}


function ShowChanels(arr){
	for (let i = arr.length - 1; i > -1; i--) {
        	MakeChanel(arr[i].id, arr[i].lastsender, arr[i].lasttext, arr[i].lasttime, arr[i].chanelavatar, arr[i].chanelname); 
        }
}

function SetLastSynTime(mes){
	last_syn = mes.created;
	//window.alert(last_syn);
}

function MakeMessage(sender, text, date, pict_src)
{
   if (pict_src == null)
  { 
	pict_src = "pics/noavatar.jpg";
  }
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
  var objDiv = document.getElementById("all-messages");
  objDiv.scrollTop = objDiv.scrollHeight;
}


function MakeChanel(id, lastsender, lasttext, lasttime, chanelavatar, chanelname)
{
   if (chanelavatar == null)
   { 
	chanelavatar = "pics/nochanelavatar.jpg";
   }
   var chat_logo = $('<div/>').addClass("chat-logo").append($('<img/>', { src: chanelavatar }));	
   var chat_text = $('<div/>').addClass("chat-text").append($('<div/>').addClass("chat-name").text(chanelname));
   var chat_last_message = $('<div/>')
    	.addClass("chat-last-msg").append($('<span/>').addClass("chat-last-msg-dude")
		.text(lastsender + ": ")).append($('<span/>').addClass("chat-last-msg-text").text(lasttext));
   chat_text.append(chat_last_message)
   var date = $('<div/>').addClass("chat-date").append($('<p/>').text(lasttime));
   var result = $('<div/>')
    	.addClass("chat").append(chat_logo).append(chat_text).append(date);
   result.prop('id', id);
   result.click(function(){PickChanel(this);});
   $('#chats').append(result);
}



function SendMessage() {
  var str = document.getElementById("write-form").innerHTML;
  if (str=="")
  {
	return;
  }
  document.getElementById("write-form").innerHTML = "";
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
         RenovateMessages(false);
    }
  };
  xhttp.open("GET", "php/send_message.php?mes="+str+"&ch="+chanel+"&user="+user+"&username="+user_name, true);
  xhttp.send();
}



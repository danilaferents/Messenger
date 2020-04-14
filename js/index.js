

var chanel = "";
var user = "";
var user_name = "";
var phone = "";
var avatar = "";
var last_syn = "";
var user_surname = "";

let users_info = {};
let all_messages = {};
let chanels_list;

//LoadUserData(user);
//LoadChanels();
//StartRenovating();
//setTimeout(RenovateUsersData, 60 * 1000, true);


function LoadUserData(cur_user){
    if (users_info.hasOwnProperty(cur_user))
    {
	if (users_info[cur_user] instanceof XMLHttpRequest)
	{
		users_info[cur_user].addEventListener('readystatechange', function() {
   	 		if (this.readyState == 4 && this.status == 200) {
				answer = JSON.parse(this.responseText);
				user_name = answer.name;
				user_surname = answer.surname;
				phone = answer.phone;
				avatar = answer.avatar;
				users_info[cur_user] = answer;
				SetUserData(user_name, avatar);
			}
 	 	});
	}
	else
	{
		user_name = users_info[cur_user].name;
		user_surname = users_info[cur_user].surname;
		phone = users_info[cur_user].phone;
		avatar = users_info[cur_user].avatar;
		SetUserData(user_name, avatar);
	}
    }
    else
    {	
    	  var xhttp = new XMLHttpRequest();
	  users_info[cur_user] = xhttp;
   	  xhttp.onreadystatechange = function() {
  	  if (this.readyState == 4 && this.status == 200) {
			answer = JSON.parse(this.responseText);
			user_name = answer.name;
			user_surname = answer.surname;
			phone = answer.phone;
			avatar = answer.avatar;
			users_info[cur_user] = answer;
     			if (avatar === null){
				avatar = "pics/users_avatars/noavatar.jpg";
     			}
			SetUserData(user_name, avatar);
		}

  	};
  	xhttp.open("GET", "php/load_user_data.php?id="+user+"&user="+cur_user, true);
  	xhttp.send();
     }

     console.log(avatar);
}


function StartRenovating(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		answer = JSON.parse(this.responseText);
		last_syn = answer.time;
		RenovateMessages(true);
	}
  };
  xhttp.open("GET", "php/get_last_message_time.php?id="+user, true);
  xhttp.send();
}


function LoadAllMessages()
{
	for (let i = 0; i < chanels_list.length; i++) {
        	LoadMessages(chanels_list[i].id); 
        }
}


function SetUserData(cur_user_name, cur_avatar){
	document.getElementsByClassName("profile-name")[0].textContent = cur_user_name;
	document.getElementsByClassName("author-avatar")[0].childNodes[0].src = cur_avatar;
}


function LoadUserData_callback(message_id, cur_user, callback){
    if (users_info.hasOwnProperty(cur_user))
    {
	if (users_info[cur_user] instanceof XMLHttpRequest)
	{
		users_info[cur_user].addEventListener('readystatechange', function() {
   	 		if (this.readyState == 4 && this.status == 200) {
				answer = JSON.parse(this.responseText);
				callback(answer.name + " " + answer.surname, answer.avatar, message_id);
				users_info[cur_user] = answer;
			}
 	 	});
	}
	else
	{
		callback(users_info[cur_user].name + " " + users_info[cur_user].surname, users_info[cur_user].avatar, 			message_id);
		
	}	
    }
    else
    {
   	 var xhttp = new XMLHttpRequest();
	 users_info[cur_user] = xhttp;
   	 xhttp.onreadystatechange = function() {
   	 if (this.readyState == 4 && this.status == 200) {
			answer = JSON.parse(this.responseText);
			if (answer.avatar === null){
				answer.avatar = "pics/users_avatars/noavatar.jpg";
     			}
			callback(answer.name + " " + answer.surname, answer.avatar, message_id);
			users_info[cur_user] = answer;
		}
 	 };
  	 xhttp.open("GET", "php/load_user_data.php?id="+user + "&user="+cur_user, true);
  	 xhttp.send();
     }
}


function LoadMessages(cur_chanel) {
  if (all_messages.hasOwnProperty(cur_chanel))
  {
	if (cur_chanel == chanel){
		ShowMessages(all_messages[cur_chanel]);
	}
  }
  else 
  {
  	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
  		if (this.readyState == 4 && this.status == 200) {
			arr = JSON.parse(this.responseText);
			all_messages[cur_chanel] = arr.reverse();
			if (arr.length > 0){
				if (cur_chanel == chanel){
					ShowMessages(arr);
				}
				RenovateChanelInfo(arr[arr.length - 1]);
			}
			//console.log(cur_chanel);
			//console.log(arr);

		}
	};
        xhttp.open("GET", "php/load_messages.php?ch="+cur_chanel+"&id="+user, true);
        xhttp.send();          
  }
}


function CleanMessages(){
	parent = document.getElementById('all-messages');
	arr = document.getElementsByClassName("msg-back");
	Array.from(arr).forEach((element) => parent.removeChild(element))
}


function PickFirstChanel(){
	var element = document.getElementsByClassName("chat")[0];
	element.className = "chat active";
	chanel = element.id;
}


function PickChanel(item) {
	//console.log(all_messages);
	document.getElementsByClassName("chat active")[0].className = "chat";
	item.className = "chat active";
	CleanMessages();
	chanel = item.id;
	LoadMessages(chanel);
}


function LoadChanels() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
		arr = JSON.parse(this.responseText);
		ShowChanels(arr);
		//console.log(document.getElementsByClassName("chat")[0]);
  		document.getElementsByClassName("chat")[0].className = "chat active";
		//chanel_syn = arr[0].lasttime;
		chanels_list = arr;
		PickFirstChanel();
		LoadAllMessages();
	}
  };
  xhttp.open("GET", "php/load_chanels.php?id="+user, true);
  xhttp.send();

}


function RenovateMessages(renovate_again) {
    //console.log(last_syn);
    if (last_syn == "")
    {
	//console.log("promlems228");
	setTimeout(RenovateMessages, 100, true);
	return;
    }
    //console.log(last_syn);
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
		arr = JSON.parse(this.responseText);
		if (arr.length > 0)
		{
			UpdateMessages(arr.reverse());
			//ShowNewMessages(all_messages[chanel]);
			SetLastSynTime(arr[0]);
		}
		if (renovate_again)
		{
			setTimeout(RenovateMessages, 100, true);
		}
	}
  };
  xhttp.open("GET", "php/reload_messages.php?syn="+last_syn+"&id="+user, true);
  xhttp.send();
}


function UpdateMessages(arr){
	//console.log(arr);
	elements_to_show = [];
	Array.from(arr).forEach(function(element){
		    RenovateChanelInfo(element);
		    //console.log(element);
                    var th_chanel = element.chanel;
		    all_messages[th_chanel].push(element);	
		    if (chanel == th_chanel){
			 elements_to_show.push(element);
			 
		    }
	     }
	)
	if (elements_to_show.length > 0)
	{
		ShowMessages(elements_to_show);
	}
}

function ShowMessages(arr){
	for (let i = 0; i < arr.length; i++) {
		id = "mes" + String(arr[i].id);
		MakeMessage(id, arr[i].text, arr[i].created);
		LoadUserData_callback(id, arr[i].senderid, UpdateMessage);
        }
}


function ShowChanels(arr){
	for (let i = arr.length - 1; i > -1; i--) {
        	MakeChanel(arr[i].id, "no data", "no data", "no data", arr[i].chanelavatar, arr[i].chanelname); 
        }
}


function SetLastSynTime(mes){
	last_syn = mes.created;
	//window.alert(last_syn);
}

function MakeMessage(id, text, date)
{
   //if (pict_src == null)
  //{ 
	//pict_src = "pics/noavatar.jpg";
 // }
   var el_sender = $('<div/>')
    .addClass("username")
      .text("sender").css("color", "lightblue");
   var el_text = $('<div/>')
    .addClass("msg-content").html(text);
   var msgtext = $('<div/>')
    .addClass("msg-text").append(el_sender).append(el_text);
   var avatar = $('<div/>').addClass("avatar").append($('<img/>', { src: "pics/noavatar.jpg" }));
   var msg = $('<div/>').addClass("msg").append(avatar).append(msgtext);
   msg.append($('<div/>').addClass("msg-date").append($('<p/>').text(date)));
   var result = $('<div/>')
    .addClass("msg-back").append(msg);
   result.prop("id", id);
   $('#all-messages').append(result);
   var objDiv = document.getElementById("all-messages");
   objDiv.scrollTop = objDiv.scrollHeight;	
   //RenovateActiveChanelInfo(sender, text, date);
}


function UpdateMessage(name, avatar, id){
	if (avatar === null){
		avatar = "pics/users_avatars/noavatar.jpg";
     	}
	var element = document.getElementById(id);
	element.getElementsByClassName("avatar")[0].childNodes[0].src = avatar;
	element.getElementsByClassName("username")[0].innerHTML = name;
}


function RenovateChanelInfo(info_obj)
{
	//console.log(info_obj);
	text =info_obj.text;
	sender = info_obj.sender + ": ";
	created = info_obj.created;	
	var active_chanel = document.getElementById(info_obj.chanel);
	active_chanel.getElementsByClassName("chat-last-msg-text")[0].innerHTML = text;
	active_chanel.getElementsByClassName("chat-date")[0].firstElementChild.innerHTML = created;	
	LoadUserData_callback_for_chanel_sender(info_obj.chanel, info_obj.senderid, UpdateChanel_last_sender);
}


function UpdateChanel_last_sender(id, sender){
	var element = document.getElementById(id);
	element.getElementsByClassName("chat-last-msg-dude")[0].innerHTML = sender + ": ";
}


function LoadUserData_callback_for_chanel_sender(chanel_id, sender_id, callback){
    if (users_info.hasOwnProperty(sender_id))
    {
	console.log('here1');
	console.log(typeof users_info[sender_id]);
	if (users_info[sender_id] instanceof XMLHttpRequest)
	{
		console.log('here2');
		console.log(users_info[sender_id]);
		users_info[sender_id].addEventListener('readystatechange',  function() {
   	 		if (this.readyState == 4 && this.status == 200) {
				answer = JSON.parse(this.responseText);
				callback(chanel_id, answer.name + " " + answer.surname);
				users_info[sender_id] = answer;
			}
 	 	});
	}
	else
	{
		console.log('here3');
		callback(chanel_id, users_info[sender_id].name + " " + users_info[sender_id].surname);
	}
    }
    else
    {
   	 var xhttp = new XMLHttpRequest();
	 users_info[sender_id] = xhttp;
   	 xhttp.onreadystatechange = function() {
   	 if (this.readyState == 4 && this.status == 200) {
			answer = JSON.parse(this.responseText);
			callback(chanel_id, answer.name + " " + answer.surname);
			users_info[sender_id] = answer;
		}
 	 };
  	 xhttp.open("GET", "php/load_user_data.php?id="+user + "&user="+sender_id, true);
  	 xhttp.send();
     }
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



function RenovateUsersData(recursive){
	users_info = {};
	if (recursive)
	{
		setTimeout(RenovateUsersData, 60 * 1000, true);
	}	
}


function SendMessage() {
  var str = document.getElementById("write-form").innerHTML;
  if (str=="")
  {
	return;
  }
  str = encodeURIComponent(str);
  document.getElementById("write-form").innerHTML = "";
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
         //RenovateMessages(false);
    }
  };
  xhttp.open("GET", "php/send_message.php?mes="+str+"&ch="+chanel+"&id="+user, true);
  xhttp.send();
}



function sendMessage(){
	var msg = {
			type: "get",
		};
		chrome.runtime.sendMessage(msg);
}

//alert("nihao");
setInterval("sendMessage()",5000);
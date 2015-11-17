function getDomainFromUrl(url){
	var host="null";
	if(typeof url=="undefined" || url==null){
		url=window.location.href;
	}
	var regex=/.*\:\/\/([^\/]*).*\?/;
	var match=url.match(regex);
	if(typeof match !="undefined" && null!=match){
		host=match[0];
	}
	return host;
}

function getDomainFromUrl1(url){
	var host1="null";
	if(typeof url=="undefined" || url==null){
		url=window.location.href;
	}
	var regex1=/.*\:\/\/([^\/]*)\/([^\/]+)\//;
	var match1=url.match(regex1);
	if(typeof match1 !="undefined" && null!=match1){
		host1=match1[0];
	}
	return host1;
}

function checkForValidUrl(tabId,changeInfo,tab){
	if(getDomainFromUrl(tab.url).toLowerCase()=="http://danbao.5173.com/auction/buy/common.aspx?"){
		chrome.tabs.remove(tabId);
	}
	if(getDomainFromUrl(tab.url).toLowerCase()=="http://consignment.5173.com/purchaseprocess/getgoods.aspx?"){
		chrome.tabs.remove(tabId);
	}
	if(getDomainFromUrl1(tab.url).toLowerCase()=="http://danbao.5173.com/detail/"){
		chrome.tabs.remove(tabId);
	}
	if(getDomainFromUrl1(tab.url).toLowerCase()=="http://consignment.5173.com/detail/"){
		chrome.tabs.remove(tabId);
	}
}

chrome.tabs.onUpdated.addListener(checkForValidUrl);

var articleData = {};
articleData.error = "加载中...";
chrome.runtime.onMessage.addListener(function(request, sender, sendRequest){
	if(request.type=="get"){
		urlData=request;
		urlData.firstAccess="获取中...";
		$.ajax({
			url: "http://localhost/web/extension/refresh.php",
			cache: false,
			type: "POST",
			data: {},
			dataType: "json",
			success:function(data){
				if(data.message){
					return;
				}
				if(data.error){
					return;
				}
				for(var key in data){
					if(typeof data[key]!="undefined" && null!=data[key]){
						chrome.tabs.create({url:data[key]});
					}
				}	
			},
			error:function(){
				
				
			},
		});
	}
		
		
		
		
			
 //     chrome.tabs.create({url:"http://www.baidu.com"});
//	articleData = request;
//	articleData.firstAccess = "获取中...";
//	if(!articleData.error){
//		$.ajax({
//			url: "http://localhost/aa/first_access.php",
//			cache: false,
//			type: "POST",
//			data: JSON.stringify({url:articleData.url}),
//			dataType: "json"
//		}).done(function(msg) {
//			if(msg.error){
//				articleData.firstAccess = msg.error;
//			} else {
//				articleData.firstAccess = msg.firstAccess;
//			}
//		}).fail(function(jqXHR, textStatus) {
//			articleData.firstAccess = textStatus;
//		});
//	}
});


	

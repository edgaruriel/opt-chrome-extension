$(document).ready(function(){  
		$('#btnUrl1').on('click', function() {
		  chrome.tabs.create({ url: "http://www.google.com" , active: false});
		});
		//document.getElementById("button1").addEventListener("click",openTab);
});  

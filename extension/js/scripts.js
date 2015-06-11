var track_load = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var total_groups = 5; //total record group(s)
	
$(document).ready(function(){
	
	$('#btnSearch').click(function(event){
		event.preventDefault();
		var text = $("#txtSearch").val();
		$.ajax({
			type:"POST",
			data: {text:text},
			url: "http://localhost/optChromeExtension/Feed/searchByText",
			success: function(result){
				$('#feed').empty();
				var FEEDS = jQuery.parseJSON(result);
				var i = 0;
				for(i=0;i<FEEDS.length;i++){
					var feed = FEEDS[i];
					var notice="";
					notice += "<a href=\"#\" class=\"list-group-item\"\">";
					notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span><\/button><\/h4>";
					notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span><\/button><\/p>";
					notice += "<\/a>";
					
					$('#feed').append(notice);
					
					$('#btnUrl'+feed.id).click(createTab(feed.link));
				}
		}});
	});
	
	$("#btnRefresh").click(getFeed);
	
	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() == $(document).height()) {
		   if(track_load <= total_groups && loading==false) //there's more data to load
				{
					loading = true; //prevent further ajax loading
					$('.animation_image').show(); //show loading image
					getFeed();
				}
	   }
	});
	
	getFeed();
}); 


function getFeed(){
	
	$.ajax({
		type:"POST",
		data: {page:track_load},
		url: "http://localhost/optChromeExtension/Feed/findNextPage",
		success: function(result){
			var FEEDS = jQuery.parseJSON(result);
			var i = 0;
			for(i=0;i<FEEDS.length;i++){
				var feed = FEEDS[i];
				var notice="";
				notice += "<a href=\"#\" class=\"list-group-item\"\">";
				notice += "<h4 class=\"list-group-item-heading\">"+feed.title+" <button id=\"btnFav"+feed.id+"\" class=\"btn pull-right btn-danger btn-xs\"><span class=\"glyphicon glyphicon-heart\"><\/span><\/button><\/h4>";
				notice += "<p class=\"list-group-item-text\">"+feed.description+"<button id=\"btnUrl"+feed.id+"\" class=\"btn pull-right btn-info btn-xs\"><span class=\"glyphicon glyphicon-eye-open\"><\/span><\/button><\/p>";
				notice += "<\/a>";
				
				$('#feed').append(notice);
				
				$('#btnUrl'+feed.id).click(createTab(feed.link));
			}
			track_load++;
			loading = false;
	}});
}

function createTab( url ){
  return function(){
    chrome.tabs.create({ url: url , active: false});
  }
}
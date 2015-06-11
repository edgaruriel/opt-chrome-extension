var track_load = 0; //total loaded record group(s)
var loading  = false; //to prevents multipal ajax loads
var total_groups = 5; //total record group(s)
var flagSearch = false; // bandera que se activa cuando seleccionan buscar y tenga algo escrito en el input
var textToSerach = ""; // se alamcena el texto del input, por si llega a borrar el texto y no da clic en buscar
	
$(document).ready(function(){
	
	$('#btnSearch').click(function(event){
		event.preventDefault();
		var text = $("#txtSearch").val();
		if(text != ""){
			textToSerach = text;
			flagSearch = true;
			track_load = 0;
			
			//en este punto se debe conocer cuantos bloques o registros existen de la busqueda y acutalizar el total_groups
			
			$.ajax({
				type:"POST",
				data: {text:textToSerach, page:track_load},
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
		}else{
			textToSerach = "";
			flagSearch = false;
		}
	});
	
	$("#btnRefresh").click(function(){
			getFeed();
	});
	
	$(window).scroll(function() {
	   if($(window).scrollTop() + $(window).height() == $(document).height()) {
		   if(track_load <= total_groups && loading==false) //there's more data to load
				{
			   	//preguntar por la bandera flagSearch y textToSerach y proceder a la busqueda por texto
			   // en caso contrario pasar a la siguiente pagina o bloque de todas las noticias.
			   
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
  };
}
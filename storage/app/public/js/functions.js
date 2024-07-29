        function setMapHeight(map)
        {
        	var screenWidth = $(window).outerWidth();
        	var factor = 50;
        	
        	if(screenWidth < 1416) factor = 60;
        	if(screenWidth < 1215) factor = 70;
        	if(screenWidth < 1007) factor = 100;
        	
        	var h = $('main').width() * factor / 100;
        	$('#osm-map').css('height', h + 'px');
        	map.invalidateSize();
        }
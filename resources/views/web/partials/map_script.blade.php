	<script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
	<link href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" rel="stylesheet"/>
	<script>
        var element = document.getElementById('osm-map');       
                
        var options = {
        	center: ['52.167874', '19.463265'],
        	zoom: 5
        };
        
        var map = L.map(element, options);
        
       	map.locate({watch: true})     
        
        L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
        
        L.control.scale({imperial: true, metric: true}).addTo(map);        
        
        var markerIcon = L.icon({
                    iconUrl: '{{ asset('storage/images/map_marker.png') }}',
                    iconSize: [30, 50],
                    iconAnchor: [15, 50],
                    popupAnchor: [0, -50],
        });
             
        var markers = [];     
                
        @foreach($pos as $p)
        @if(isset($admin) && $admin == true)
        L.marker(L.latLng('{{ $p->lat }}', '{{ $p->lng }}'), {icon: markerIcon}).addTo(map).bindPopup('<strong>{{ $p->category->name }}<hr class="my-2" />{{ $p->name }}</strong><br />{{ $p->city }}<br />{{ $p->street }}<hr class="my-2" /><a href="{{ route('admin.pos.edit', $p->id) }}"><button class="btn btn-sm btn-danger">Edytuj punkt</button></a>');
        @else
        L.marker(L.latLng('{{ $p->lat }}', '{{ $p->lng }}'), {icon: markerIcon}).addTo(map).bindPopup('<strong>{{ $p->category->name }}<hr class="my-2" />{{ $p->name }}</strong><br />{{ $p->city }}<br />{{ $p->street }}<hr class="my-2" /><a href="https://www.google.com/maps/dir/?api=1&destination={{ $p->lat }},{{ $p->lng }}" target="_blank"><button class="btn btn-sm btn-danger">Wyznacz trasę</button></a>');        
        @endif
        markers.push(L.marker(L.latLng('{{ $p->lat }}', '{{ $p->lng }}')));
        @endforeach
                                    
        $(document).ready(function() {                
        	setMapHeight(map);
        	
        	@if(request()->lat == null && request()->lng == null) 
        	
        	navigator.geolocation.getCurrentPosition(function(position) {
                map.setView(L.latLng(position.coords.latitude, position.coords.longitude), 12);
        		
                var icon = L.icon({
                    iconUrl: '{{ asset('storage/images/current_loc_marker.png') }}',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10],
                });
                
                L.marker([position.coords.latitude, position.coords.longitude], {icon: icon}).addTo(map).bindPopup('Jesteś tutaj');
                markers.push(L.marker([position.coords.latitude, position.coords.longitude]));
        	}); 
        	
        	@else        
                var icon = L.icon({
                    iconUrl: '{{ asset('storage/images/current_loc_marker.png') }}',
                    iconSize: [20, 20],
                    iconAnchor: [10, 10],
                    popupAnchor: [0, -10],
                });
                
                L.marker(['{{ request()->lat }}','{{ request()->lng }}'], {icon: icon}).addTo(map).bindPopup('Wybrany adres');      	
        		markers.push(L.marker(['{{ request()->lat }}','{{ request()->lng }}']));
        	@endif
        	
        	var group = new L.featureGroup(markers);
        	map.fitBounds(group.getBounds());
        });
        
        $(window).on("resize", function() {
        	setMapHeight(map);
        });        
	</script>
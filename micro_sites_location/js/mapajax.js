(function($) {
  $(function() {
		var image = {
			url: '/sites/default/files/round-img.png',
			//url: '/sites/default/files/contact-us-icon.gif',
		};
		
		$.fn.loadmap=function(){
			
				var isIOS = /iPad|iPhone|iPod/.test(navigator.platform);
				
				var iosclick	= 1;
			
				if (isIOS) {
					var map = new google.maps.Map(document.getElementById('map'), {
						 center: new google.maps.LatLng(41.850033, -87.6500523),
						  zoom: 2,
						  scrollwheel: false,
						  minZoom: 2,
						  mapTypeControl: false,
						  streetViewControl: false,
					});
				}else{
					var map = new google.maps.Map(document.getElementById('map'), {
					 center: new google.maps.LatLng(12.0,12.0),
					  zoom: 2,
					  scrollwheel: false,
					  minZoom: 2,
					  mapTypeControl: false,
					  streetViewControl: false,
					});
				}

				var infowindow = new google.maps.InfoWindow();

				var marker, i;	
				
			//console.log(Drupal.settings.micro_sites_locations_new);
			//console.log(Drupal.settings.micro_sites_locations);
			if(Drupal.settings.micro_sites_locations_new){
				var locations = JSON.parse(Drupal.settings.micro_sites_locations_new) ;
				//console.log('pawan');
			}else{
				var locations = JSON.parse(Drupal.settings.micro_sites_locations) ;
				
			}
			for (i = 0; i < locations.length; i++) { 	 
				
				 // map.setCenter(new google.maps.LatLng(parseFloat(locations[i]['lat']),  parseFloat(locations[i]['long'])));
				  
				if(locations[i]['is_publish']==1){
					image = {url: '/sites/default/files/round-img-green.png'};
				}else{
					image = {url: '/sites/default/files/round-img.png'};
				}
				  
				  marker = new google.maps.Marker({
					position: new google.maps.LatLng(parseFloat(locations[i]['lat']), parseFloat(locations[i]['long'])),
					 icon: image,
					 map: map
				  });

				  google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
					return function() {
					  infowindow.setContent(locations[i]['location']);
					  infowindow.open(map, marker);
					}
				  })(marker, i));
				  
				  google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						
						if(iosclick==1){
							//do nothing;
							iosclick = iosclick+1;
						}else{
							iosclick==1;
							showride(locations[i]['domain']);
							
						}
					  
					}
				  })(marker, i));
			}
		};
		
		$.fn.loadmap();
    });
})(jQuery);

function showride(domain){
	jQuery('#location_domain').val(domain);
	
	console.log(domain);
	jQuery('#edit-submit').mousedown();
}


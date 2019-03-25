
( function( $ ) {
	var bmap, mapclass;
	var box_map = {

		init: function() {

			var mapclass = this;
			$("#range_02").ionRangeSlider({
			    min: 00,
			    max: 10000,
			    from: 0
			});

			mapclass.bmap = new google.maps.Map(document.getElementById('bmap'), {
		      	zoom: 10,
		    	center: new google.maps.LatLng(-33.92, 151.25),
		      	mapTypeId: google.maps.MapTypeId.ROADMAP
		    });
		    mapclass.locations = [];
		    mapclass.profiles =JSON.parse( jQuery('#json_list_profile').html() );

		    mapclass.profiles.forEach(function(entry) {
			    var temp = [entry.html, entry.lat, entry.lng];
			    mapclass.locations.push(temp);
			});

		    mapclass.showMapMarkers( mapclass.bmap , mapclass.locations );

			$('.job_filters' ).on( 'submit', this.mapFilterFreelance );
		},
		initMap:function(){

		},
		showMapMarkers:function(map, locations){


			var infowindow = new google.maps.InfoWindow();
			var marker, i;
			var bounds = new google.maps.LatLngBounds();
			for (i = 0; i < locations.length; i++) {

				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map,
					title:locations[i][0],
				});
				//box_map.addMarker(locations[i], box_map.bmap);
				bounds.extend(marker.getPosition());
				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
					  infowindow.setContent(locations[i][0]);
					  infowindow.open(map, marker);
					}
				})(marker, i));
				map.fitBounds(bounds);
			}
		},
		renderResults: function(data){
			console.log('rende Resuls');
			console.log(data);

			//reset map to default- no markers
			box_map.bmap = new google.maps.Map(document.getElementById('bmap'), {
		      	zoom: 10,
		    	center: new google.maps.LatLng(-33.92, 151.25),
		      	mapTypeId: google.maps.MapTypeId.ROADMAP
		    });


		    box_map.locations = [];
		    $.each(data, function(i, item) {
			   var temp = [item.html, item.lat, item.lng];
			    box_map.locations.push(temp);
			});

			// add map markers from scratch.
			box_map.showMapMarkers( box_map.bmap , box_map.locations );
		},
		addMarker: function (location,map) {
			 marker = new google.maps.Marker({
			    position: new google.maps.LatLng(location[1], location[2]),
			    map: map,
			    title: location[0],
			 });
		  	marker.setMap(map);
		},
		mapFilterFreelance: function(event){

			console.log(box_map);
			event.preventDefault();

			var form 	= $(event.currentTarget);
			var data = {};
			form.find(' input[type=text], input[type=number],  input[type=hidden], input[type=email],textarea,select').each(function() {
		    	var key 	= $(this).attr('name');
		        data[key] 	= $(this).val();
		    });
			form.find('input:radio:checked').each(function() {
		    	var key 	= $(this).attr('name');
		        data[key] 	= $(this).val();
		    });

		    $.ajax({
		        emulateJSON: true,
		        method :'post',
		        url : bx_global.ajax_url,
		        data: {
		                action: 'nearby_filter',
		                request: data,
		        },
		        beforeSend  : function(event){
		        	console.log('beforeSend');
		        	form.find(".btn-submit").addClass("loading");
		        },
		        success: function(res){
		        	console.log(mapclass);
		        	//if(res && res.data.length > 0){
		        		box_map.renderResults(res.data);
		        	//}
		        },
		    });
		},

	}
	$(document).ready(function(){
		box_map.init();
	})
})( jQuery, window.ajaxSend );
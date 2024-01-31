@extends('layouts.app')

@push('styles')
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Setting</h1>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4>Setting</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Map</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                            general
                        </div>
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="section-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row mb-4">
                                                    <div class="col-4 col-12 col-md-6 col-lg-4">
                                                        <form id="search-form">
                                                            <div class="input-group">
                                                                <input type="text" id="address" class="form-control"
                                                                    placeholder="Enter your address">
                                                                <div class="input-group-append">
                                                                    <button class="btn btn-primary"
                                                                        id="search-button">Search</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <form id="location-form">
                                                        <div class="row mb-3">
                                                            <div class="col-md-4">
                                                                <label for="location-name">Location Name</label>
                                                                <input type="text" value="" class="form-control"
                                                                    id="location-name" readonly>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="latitude">Latitude</label>
                                                                <input type="text" value="" class="form-control"
                                                                    id="latitude" readonly>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="longitude">Longitude</label>
                                                                <input type="text" value="" class="form-control"
                                                                    id="longitude" readonly>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div id="map" data-height="400"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_KEY') }}&libraries=places&callback=initMap"></script>

    <script>
        var map;
        var geocoder;
        var autocomplete;
        var markers = [];
        var radiusCircle;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: -7.009073117087091,
                    lng: 107.54745053254088
                },
                zoom: 17
            });

            geocoder = new google.maps.Geocoder();

            // Default position
            var defaultPosition = new google.maps.LatLng(-7.009073117087091, 107.54745053254088);

            // Add default radius circle
            addRadiusCircle(defaultPosition, 100); // satuan meter (1000 meter = 1 km)

            // Autocomplete setup
            autocomplete = new google.maps.places.Autocomplete(
                document.getElementById('address'), {
                    types: ['geocode']
                }
            );

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                if (!place.geometry) {
                    alert("Place details not found for: " + place.name);
                    return;
                }

                // Clear previous markers and circle
                clearMarkers();
                clearRadiusCircle();

                // Set center of the map to the selected place
                map.setCenter(place.geometry.location);

                // Add a draggable marker at the selected place
                var marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location,
                    animation: google.maps.Animation.DROP,
                    draggable: true
                });

                markers.push(marker);

                // Update location information in the form
                updateLocationInfo(place.geometry.location.lat(), place.geometry.location.lng());

                addRadiusCircle(place.geometry.location, 100); // satunnya meter 1000 meter = 1 km

                // Add 'dragend' event listener to the marker
                google.maps.event.addListener(marker, 'dragend', function() {
                    updateLocationInfo(marker.getPosition().lat(), marker.getPosition().lng())

                    // Update the radius circle's center to match the new position of the marker
                    updateRadiusCircle(marker.getPosition());
                });
            });
        }

        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }

        function clearRadiusCircle() {
            if (radiusCircle) {
                radiusCircle.setMap(null);
                radiusCircle = null;
            }
        }

        function addRadiusCircle(center, radius) {
            radiusCircle = new google.maps.Circle({
                map: map,
                center: center,
                radius: radius,
                strokeColor: '#00bfff',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#00bfff',
                fillOpacity: 0.35
            });
        }

        function updateRadiusCircle(newCenter) {
            radiusCircle.setCenter(newCenter);
        }

        function updateLocationInfo(latitude, longitude) {
            geocoder.geocode({
                'location': {
                    lat: latitude,
                    lng: longitude
                }
            }, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        document.getElementById('location-name').value = results[0].formatted_address;
                        document.getElementById('latitude').value = latitude;
                        document.getElementById('longitude').value = longitude;
                    }
                }
            });
        }

        document.getElementById('search-form').addEventListener('submit', function(event) {
            event.preventDefault();
            geocodeAddress();
        });

        function geocodeAddress() {
            // Implementasi geocodeAddress sesuai kebutuhan Anda
        }
    </script>
@endpush

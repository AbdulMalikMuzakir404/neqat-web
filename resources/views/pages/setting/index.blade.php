@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                aria-controls="home" aria-selected="true">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="false">Map</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane active show fade" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <form class="form-general">
                                <div class="form-group">
                                    <label for="school-name">*School Name</label>
                                    <input type="text" name="school_name"
                                        value="{{ $data['setting'] ? $data['setting']->school_name : '' }}"
                                        class="form-control @error('username') is-invalid @enderror"
                                        placeholder="School Name" maxlength="50" required>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="school-time-from">*School Time From</label>
                                    <input type="time" name="school_time_from"
                                        value="{{ $data['setting'] ? $data['setting']->school_time_from : '' }}"
                                        class="form-control @error('school_time_from') is-invalid @enderror"
                                        id="school-time-from" placeholder="School Time From" required>
                                    @error('school_time_from')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="school-time-to">*School Time To</label>
                                    <input type="time" name="school_time_to"
                                        value="{{ $data['setting'] ? $data['setting']->school_time_to : '' }}"
                                        class="form-control @error('school_time_to') is-invalid @enderror"
                                        id="school-time-to" placeholder="School Time To" required>
                                    @error('school_time_to')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="school-hour-tolerance">*School Hour Tolerance</label>
                                    <input type="time" name="school_hour_tolerance"
                                        value="{{ $data['setting'] ? $data['setting']->school_hour_tolerance : '' }}"
                                        class="form-control @error('school_hour_tolerance') is-invalid @enderror"
                                        id="school-hour-tolerance" placeholder="School Hour Tolerance" required>
                                    @error('school_hour_tolerance')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <div class="control-label">Absen Status</div>
                                    <div class="custom-control custom-checkbox" id="checkboxContainer">
                                        <input type="checkbox" name="absen" value=""
                                            class="custom-control-input @error('absen') is-invalid @enderror" id="absen"
                                            {{ $data['setting']->absen == 1 ? 'checked' : '' }} required>
                                        <label class="custom-control-label"
                                            for="absen">{{ $data['setting']->absen == 1 ? 'on' : 'off' }}</label>
                                    </div>
                                    @error('absen')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <button type="button" id="save-general" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="section-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row-12 mb-4">
                                                    <div class="col-12 col-12 col-md-12 col-lg-12 mb-3">
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
                                                    <div class="col-12 col-12 col-md-12 col-lg-12">
                                                        <form id="location-form" class="form-map">
                                                            <div class="form-group">
                                                                <label for="location-name">*Name Location</label>
                                                                <input type="text" name="location_name"
                                                                    value="{{ $data['setting'] ? $data['setting']->location_name : '' }}"
                                                                    class="form-control @error('location_name') is-invalid @enderror"
                                                                    id="location-name" placeholder="Name Location"
                                                                    maxlength="100" readonly required>
                                                                @error('location_name')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="latitude">*Latitude</label>
                                                                <input type="text" name="latitude"
                                                                    value="{{ $data['setting'] ? $data['setting']->latitude : '' }}"
                                                                    class="form-control @error('latitude') is-invalid @enderror"
                                                                    id="latitude" placeholder="Latitude" maxlength="50"
                                                                    readonly required>
                                                                @error('latitude')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="longitude">*Longitude</label>
                                                                <input type="text" name="longitude"
                                                                    value="{{ $data['setting'] ? $data['setting']->longitude : '' }}"
                                                                    class="form-control @error('longitude') is-invalid @enderror"
                                                                    id="longitude" placeholder="Longitude" maxlength="50"
                                                                    readonly required>
                                                                @error('longitude')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="radius">*Radius</label>
                                                                <input type="text" name="radius"
                                                                    value="{{ $data['setting'] ? $data['setting']->radius : '' }}"
                                                                    class="form-control @error('radius') is-invalid @enderror"
                                                                    id="radius" placeholder="Radius" maxlength="11"
                                                                    autofocus required>
                                                                @error('radius')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>

                                                            <button type="button" id="save-map"
                                                                class="btn btn-primary">Simpan</button>
                                                        </form>
                                                    </div>

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
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAPS_KEY') }}&libraries=places&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @include('components.toastr.toastr')

    <script>
        // on off checkbox
        var checkbox = document.getElementById("absen");

        checkbox.addEventListener("change", function() {
            checkbox.value = checkbox.checked ? 1 : 0;

            var checkboxContainer = document.getElementById("checkboxContainer");
            if (checkbox.checked) {
                checkboxContainer.classList.add("checked");
            } else {
                checkboxContainer.classList.remove("checked");
            }
        });

        checkbox.value = checkbox.checked ? 1 : 0;
    </script>

    <script>
        // save data setting general
        $(document).ready(function() {
            $('#save-general').on('click', function() {
                updateGeneral();
            });

            function updateGeneral() {
                let formData = new FormData($('.form-general')[0]);

                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('setting.update.general') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message, 'Success');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            let errors = xhr.responseJSON.errors;
                            if (errors) {
                                // Display each error message
                                $.each(errors, function(key, value) {
                                    toastr.error(value[0], 'Error');
                                });
                            }
                        } else {
                            // Handle other types of errors
                            toastr.error("An error occurred: " + error, 'Error');
                        }
                    }
                });
            }
        });

        // save data setting map
        $(document).ready(function() {
            $('#save-map').on('click', function() {
                updateLocation();
            });

            function updateLocation() {
                let formData = new FormData($('.form-map')[0]);

                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('setting.update.map') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message, 'Success');
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON) {
                            let errors = xhr.responseJSON.errors;
                            if (errors) {
                                // Display each error message
                                $.each(errors, function(key, value) {
                                    toastr.error(value[0], 'Error');
                                });
                            }
                        } else {
                            // Handle other types of errors
                            toastr.error("An error occurred: " + error, 'Error');
                        }
                    }
                });
            }
        });
    </script>

    <script>
        var map;
        var geocoder;
        var autocomplete;
        var markers = [];
        var radiusCircle;

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: {{ $data['setting']->latitude }},
                    lng: {{ $data['setting']->longitude }}
                },
                zoom: 17
            });

            geocoder = new google.maps.Geocoder();

            // Default position
            var defaultPosition = new google.maps.LatLng({{ $data['setting']->latitude }},
                {{ $data['setting']->longitude }});

            // Add default radius circle
            addRadiusCircle(defaultPosition, {{ $data['setting']->radius }}); // satuan meter (1000 meter = 1 km)

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

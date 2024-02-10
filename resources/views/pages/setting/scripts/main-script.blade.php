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

            let absen = $('#absen').val();

            formData.append('absen', absen);

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

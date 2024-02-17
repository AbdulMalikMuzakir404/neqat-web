<script>
    // GOBAL SETUP AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    // Mendengarkan perubahan pada checkbox
    $(document).on('change', 'input[data-checkboxes="mygroup"]', function() {
        // Mengaktifkan atau menonaktifkan tombol hapus berdasarkan apakah ada baris yang dipilih
        if ($('input[data-checkboxes="mygroup"]:checked').length > 0) {
            $('#deleteBtn').prop('disabled', false);
        } else {
            $('#deleteBtn').prop('disabled', true);
        }
    });
</script>

<script>
    // KETIKA BTN DELETE DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#deleteBtn', function() {
            $('#deleteModal').modal('show');
        });
    });
</script>

<script>
    FilePond.registerPlugin(FilePondPluginImagePreview);

    // Konfigurasi FilePond
    let pond = FilePond.create(document.querySelector('#image'), {
        allowImagePreview: true,
        allowImageFilter: true,
        imagePreviewHeight: 100,
        allowMultiple: true,
        allowFileTypeValidation: true,
        allowRevert: true,
        acceptedFileTypes: ["image/png", "image/jpeg", "image/jpg"],
        maxFiles: 1,
        credits: false,
        server: {
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/announcement/temp/upload",
            process: false,
            revert: true,
            restore: "/announcement/temp/upload/delete",
            fetch: false,
        },
    });
</script>

<script>
    // AMBIL DATA SEMUA USER FILTER BY 10 DATA
    $(document).ready(function() {
        getData();
    });

    function getData() {
        if ($.fn.DataTable.isDataTable('#table-2')) {
            $('#table-2').DataTable().destroy();
        }

        $('#table-2').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('temporary.getalldata') }}",
                type: 'POST'
            },
            columns: [{
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id'
                },
                {
                    data: 'folder'
                },
                {
                    data: 'filename'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: []
        });
    }
</script>

<script>
    // KETIKA BTN DETAIL DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#detailBtn', function() {
            $('#detailLabel').text('Detail Data');
            $('#detailModal').modal('show');

            let dataId = $(this).data('id');

            detailData(dataId);
        });

        function detailData(dataId) {
            $.ajax({
                url: "/temporary/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    if (response.data) {
                        $('#detailFolder').text(response.data.folder ?? '-');
                        $('#detailFileName').text(response.data.filename ?? '-');
                        if (response.data.filename) {
                            let imageUrl = "{{ asset('orders/temp') }}" + "/" + response.data.folder + "/" + response.data.filename;

                            function openImagePage(imageUrl) {
                                window.open(imageUrl, '_blank');
                            }

                            $('#detailImage').html(
                                '<div class="gallery-item" data-image="' + imageUrl +
                                '" data-title="Image" href="' + imageUrl +
                                '" title="Image" style="height: 100px; background-image: url(&quot;' +
                                imageUrl + '&quot;);"></div>'
                            );

                            // Attach click event handler using jQuery
                            $('#detailImage').on('click', '.gallery-item', function() {
                                openImagePage($(this).data('image'));
                            });
                        } else {
                            let defaultImageUrl =
                                "{{ asset('template/assets/img/news/img10.jpg') }}";
                            $('#detailImage').html(
                                '<div class="gallery-item" data-image="' + defaultImageUrl +
                                '" data-title="Image" href="' + defaultImageUrl +
                                '" title="Image" style="height: 100px; background-image: url(&quot;' +
                                defaultImageUrl + '&quot;);"></div>'
                            );
                        }
                    } else {
                        console.log('Terjadi kesalahan response');
                        toastr.error("Terjadi kesalahan response", 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.responseJSON) {
                        let errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value[0], 'Error');
                            });
                        }
                    } else {
                        toastr.error("An error occurred: " + error, 'Error');
                    }
                }
            });
        }
    });
</script>

<script>
    // DELETE DATA YANG DI PILIH
    $(document).ready(function() {
        // Mendengarkan klik pada tombol konfirmasi hapus di dalam modal
        $('#confirm-delete').click(function() {
            // Mengumpulkan ID dari baris yang dipilih
            let formData = new FormData(); // Inisialisasi objek FormData
            $('input[data-checkboxes="mygroup"]:checked').each(function() {
                // Mengabaikan baris header
                let id = $(this).closest('tr').find('td:eq(1)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('temporary.delete') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');

                        // Hapus baris dari DOM
                        $('input[data-checkboxes="mygroup"]:checked').each(function() {
                            $(this).closest('tr').remove();
                        });

                        $('#deleteBtn').prop('disabled', true);
                        $('#deleteModal').modal('hide');
                    } else {
                        toastr.error("An error occurred: " + response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred: " + error, 'Error');
                }
            });
        });
    });
</script>

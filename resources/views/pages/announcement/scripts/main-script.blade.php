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
    // HAPUS CLASS JIKA MODAL DI TUTUP
    $(document).ready(function() {
        $('#dataModal').on('hidden.bs.modal', function(e) {
            $('#saveData').removeClass('storeData');
            $('#saveData').removeClass('updateData');
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
    // KETIKA BTN CREATE DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#createBtn', function() {
            $('#dataLabel').text('Create Data');
            $('#saveData').text('Save');
            $('#dataModal').modal('show');

            $('#saveData').addClass('storeData');

            $('#dataId').val("");
            $('#title').val("");
            $('#description').val("");

            // Hapus nilai input file
            $('#image').val("");

            // Hapus semua file yang dipilih dari FilePond
            pond.removeFiles();

            $('#viewImage').html('<div style="display: none; margin-top: -30px;"></div>');
        });
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
                url: "{{ route('announcement.getalldata') }}",
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
                    data: 'title'
                },
                {
                    data: 'description'
                },
                {
                    data: 'send_at'
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
    // SAVE DATA
    $(document).ready(function() {
        $(document).on('click', '.storeData', function() {
            let formData = new FormData($('.form-data')[0]);

            formData.append('_method', 'POST');

            // Mendapatkan nomor halaman saat ini
            let currentPage = $('#table-2').DataTable().page.info().page;

            storeData(formData, currentPage);
        });

        function storeData(formData, currentPage) {
            $.ajax({
                url: "{{ route('announcement.store') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#dataModal').modal('hide');

                    $('#dataId').val("");
                    $('#title').val("");
                    $('#description').val("");

                    $('#saveData').removeClass('storeData');

                    // Periksa apakah nomor halaman saat ini masih tersedia dalam data yang diperbarui
                    let table = $('#table-2').DataTable();
                    let info = table.page.info();
                    if (info.pages >= currentPage) {
                        // Jika nomor halaman masih tersedia, atur kembali tabel pada nomor halaman tersebut
                        table.page(currentPage).draw('page');
                    } else {
                        // Jika nomor halaman tidak tersedia, atur kembali tabel pada halaman pertama
                        table.page(0).draw('page');
                    }
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
                url: "/announcement/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    if (response.data) {
                        $('#detailTitle').text(response.data.title ?? '-');
                        $('#detailDescription').text(response.data.description ?? '-');
                        $('#detailSendAt').text(response.data.send_at ?? '-');
                        if (response.data.image) {
                            let imageUrl = "{{ asset('storage') }}" + "/" + response.data.image;
                            $('#detailImage').html(
                                '<div class="gallery-item" data-image="' + imageUrl + '" data-title="Image" href="' + imageUrl + '" title="Image" style="height: 100px; background-image: url(&quot;' + imageUrl + '&quot;);"></div>'
                            );
                        } else {
                            let defaultImageUrl = "{{ asset('template/assets/img/news/img10.jpg') }}";
                            $('#detailImage').html(
                                '<div class="gallery-item" data-image="' + defaultImageUrl + '" data-title="Image" href="' + defaultImageUrl + '" title="Image" style="height: 100px; background-image: url(&quot;' + defaultImageUrl + '&quot;);"></div>'
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
    // KETIKA BTN EDIT DI KLIK MUNCULKAN MODAL BESERTA DATA YANG DI PILIH
    $(document).ready(function() {
        $(document).on('click', '#editBtn', function() {
            let dataId = $(this).data('id');

            $('#dataModal').modal('show');
            $('#saveData').addClass('updateData');

            editData(dataId);
        });

        function editData(dataId) {
            $.ajax({
                url: "/announcement/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#dataLabel').text('Edit Data');
                    $('#saveData').text('Save and Change');
                    $('#hideImage').html('<div style="display: block;"></div>');

                    if (response.data) {
                        // Masukan data ke dalam field form edit
                        $('#dataId').val(response.data.id);
                        $('#title').val(response.data.title);
                        $('#description').val(response.data.description);

                        if (response.data.image) {
                            let imageUrl = "{{ asset('storage') }}" + "/" + response.data.image;
                            $('#viewImage').html(
                                '<div class="gallery-item" data-image="' + imageUrl + '" data-title="Image" href="' + imageUrl + '" title="Image" style="height: 100px; background-image: url(&quot;' + imageUrl + '&quot;);"></div>'
                            );
                        } else {
                            let defaultImageUrl = "{{ asset('template/assets/img/news/img10.jpg') }}";
                            $('#viewImage').html(
                                '<div class="gallery-item" data-image="' + defaultImageUrl + '" data-title="Image" href="' + defaultImageUrl + '" title="Image" style="height: 100px; background-image: url(&quot;' + defaultImageUrl + '&quot;);"></div>'
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

        // Mengembalikan promise untuk mendapatkan data peran
        function roleData() {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    url: "{{ route('user.getallrole') }}",
                    type: "GET",
                    cache: false,
                    success: function(response) {
                        resolve(response.data);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }

    });
</script>

<script>
    // UPDATE DATA
    $(document).ready(function() {
        $(document).on('click', '.updateData', function() {
            // Mendapatkan ID yang digunakan pada tombol
            let userId = $(this).attr('id').split('-').pop();
            // Mendapatkan nomor halaman saat ini
            let currentPage = $('#table-2').DataTable().page.info().page;

            // Memanggil fungsi saveEditUser dan memberikan ID pengguna serta nomor halaman saat ini
            updateData(userId, currentPage);
        });

        function updateData(userId, currentPage) {
            let formData = new FormData($('.form-data')[0]);
            formData.append('_method', 'POST');

            $.ajax({
                url: "{{ route('announcement.update') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#dataId').val("");
                    $('#title').val("");
                    $('#description').val("");

                    // Hapus nilai input file
                    $('#image').val("");

                    // Hapus semua file yang dipilih dari FilePond
                    pond.removeFiles();

                    $('#dataModal').modal('hide');

                    // Periksa apakah nomor halaman saat ini masih tersedia dalam data yang diperbarui
                    let table = $('#table-2').DataTable();
                    let info = table.page.info();
                    if (info.pages >= currentPage) {
                        // Jika nomor halaman masih tersedia, atur kembali tabel pada nomor halaman tersebut
                        table.page(currentPage).draw('page');
                    } else {
                        // Jika nomor halaman tidak tersedia, atur kembali tabel pada halaman pertama
                        table.page(0).draw('page');
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
                url: "{{ route('announcement.delete') }}",
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

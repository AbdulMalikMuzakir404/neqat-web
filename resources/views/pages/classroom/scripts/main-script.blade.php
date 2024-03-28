<script>
    // GOBAL SETUP AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    // MENDENGARKAN PERUBAHAN PADA CHECKBOX DELETE
    $(document).on('change', 'input[data-checkboxes="delete"]', function() {
        // Mengaktifkan atau menonaktifkan tombol hapus berdasarkan apakah ada baris yang dipilih
        if ($('input[data-checkboxes="delete"]:checked').length > 0) {
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
    // KETIKA BTN CREATE DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#createBtn', function() {
            $('#dataLabel').text('Create Data');
            $('#saveData').text('Save');
            $('#dataModal').modal('show');

            $('#saveData').addClass('storeData');

            $('#dataId').val("");
            $('#name').val("");
        });
    });
</script>

<script>
    // TRIGER BTN TEMPORARY
    $(document).ready(function() {
        $.ajax({
            url: "/classroom/data-trash",
            type: "GET",
            cache: false,
            success: function(response) {
                if (response.data) {
                    if (response.data.length >= 1) {
                        $("#btnTrash").show();
                    } else {
                        $("#btnTrash").hide();
                    }
                } else {
                    console.log('Terjadi kesalahan response');
                    toastr.error('Terjadi kesalahan response', 'Error');
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
    })
</script>

<script>
    // AMBIL DATA SEMUA USER FILTER BY 10 DATA
    $(document).ready(function() {
        getData();
    });

    // Fungsi untuk mengonversi HTML entities menjadi HTML yang sesuai
    function decodeEntities(encodedString) {
        var textArea = document.createElement('textarea');
        textArea.innerHTML = encodedString;
        return textArea.value;
    }

    function getData() {
        if ($.fn.DataTable.isDataTable('#table-2')) {
            $('#table-2').DataTable().destroy();
        }

        $('#table-2').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('classroom.getalldata') }}",
                type: 'POST'
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'checkbox',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'created_at',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: 'updated_at',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        return new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            order: [],
            lengthMenu: [10, 20, 50, 100, 150, 200],
            pageLength: 20,
            rowCallback: function(row, data, dataIndex) {
                var table = $('#table-2').DataTable();
                var info = table.page.info();
                $('td:eq(0)', row).html(info.start + dataIndex + 1);
            }
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
                url: "{{ route('classroom.store') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#dataModal').modal('hide');

                    $('#dataId').val("");
                    $('#name').val("");

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
                url: "/classroom/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {

                    function dateFormat(data) {
                        return new Date(data).toLocaleString('id-ID', {
                            day: '2-digit',
                            month: 'long',
                            year: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    }

                    if (response.data) {
                        $('#detailName').text(response.data.name ?? '-');
                        $('#detailCreatedAt').text(dateFormat(response.data.created_at) ?? '-');
                        $('#detailUpdatedAt').text(dateFormat(response.data.updated_at) ?? '-');
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

            $('#dataId').val("");
            $('#name').val("");

            editData(dataId);
        });

        function editData(dataId) {
            $.ajax({
                url: "/classroom/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#dataLabel').text('Edit Data');
                    $('#saveData').text('Save and Change');
                    $('#hideImage').html('<div style="display: block;"></div>');

                    if (response.data) {
                        // Masukan data ke dalam field form edit
                        $('#dataId').val(response.data.id);
                        $('#name').val(response.data.name);
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
                url: "{{ route('classroom.update') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#dataId').val("");
                    $('#name').val("");

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
            $('input[data-checkboxes="delete"]:checked').each(function() {
                // Mengabaikan baris header
                let id = $(this).closest('tr').find('td:eq(2)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('classroom.delete') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');

                        // Hapus baris dari DOM
                        $('input[data-checkboxes="delete"]:checked').each(function() {
                            $(this).closest('tr').remove();
                        });

                        $('#deleteBtn').prop('disabled', true);
                        $('#deleteModal').modal('hide');
                        $('#btnTrash').show();
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

<script>
    // GOBAL SETUP AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    // MENDENGARKAN PERUBAHAN PADA CHECKBOX
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
    $(document).ready(function() {
        $.ajax({
            url: "/user/data-trash",
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
            $('#username').val("");
            $('#email').val("");
            $('#password').val("");
            $('#role').val("");

            roleData();
        });

        function roleData() {
            $.ajax({
                url: "{{ route('user.getallrole') }}",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#role').empty();

                    // Iterasi melalui respons dan tambahkan opsi baru ke dalam elemen <select>
                    $.each(response.data, function(index, role) {
                        $('#role').append($('<option>', {
                            value: role.id,
                            text: role.name
                        }));
                    });
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
                url: "/user/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    if (response.data) {
                        $('#detailName').text(response.data.data.name ?? '-');
                        $('#detailUsername').text(response.data.data.username ?? '-');
                        $('#detailEmail').text(response.data.data.email ?? '-');
                        if (response.data.data.active == 1) {
                            $('#detailActive').html(
                                '<div class="badge badge-success">active</div>');
                        } else if (response.data.data.active == 0) {
                            $('#detailActive').html(
                                '<div class="badge badge-secondary">nonactive</div>');
                        } else {
                            $('#detailActive').html('<div class="badge badge-danger">-</div>');
                        }
                        if (response.data.data.email_verified == 1) {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-success">verified</div>');
                        } else if (response.data.data.email_verified == 0) {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-secondary">not verified</div>');
                        } else {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-danger">-</div>');
                        }
                        $('#detailRole').text(response.data.role ?? '-');
                        $('#detailIpAddress').text(response.data.data.ip_address ?? '-');
                        $('#detailEmailVerifiedAt').text(response.data.data.email_verified_at ??
                            '-');
                        $('#detailFcmToken').text(response.data.data.fcm_token ?? '-');
                        $('#detailActiveAt').text(response.data.data.active_at ?? '-');
                        $('#detailFirstAccess').text(response.data.data.first_access ?? '-');
                        $('#detailLastLogin').text(response.data.data.last_login ?? '-');
                        $('#detailLastAccess').text(response.data.data.last_access ?? '-');
                    } else {
                        console.log('Terjadi kesalahan response');
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
                url: "/user/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#dataLabel').text('Edit Data');
                    $('#saveData').text('Save and Change');

                    if (response.data) {
                        // Masukan data ke dalam field form edit
                        $('#dataId').val(response.data.data.id);
                        $('#name').val(response.data.data.name);
                        $('#username').val(response.data.data.username);
                        $('#email').val(response.data.data.email);

                        // Panggil roleData dan gunakan .then() setelahnya
                        roleData().then(function(roles) {
                            // Kosongkan opsi peran sebelum menambahkan yang baru
                            $('#role').empty();
                            // Tambahkan opsi peran baru ke dalam dropdown
                            roles.forEach(function(role) {
                                $('#role').append($('<option>', {
                                    value: role.id,
                                    text: role.name
                                }));
                            });
                            // Setel opsi peran yang dipilih berdasarkan data dari respons AJAX
                            $('#role').val(response.data.data.roles[0].id);
                        }).catch(function(error) {
                            console.error('Terjadi kesalahan:', error);
                        });
                    } else {
                        console.log('Terjadi kesalahan response');
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
                url: "{{ route('user.getalldata') }}",
                type: 'POST'
            },
            columns: [{
                    data: 'delete',
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
                    data: 'username'
                },
                {
                    data: 'email'
                },
                {
                    data: 'email_verified'
                },
                {
                    data: 'active'
                },
                {
                    data: 'role'
                },
                {
                    data: 'first_access'
                },
                {
                    data: 'last_access'
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
                url: "{{ route('user.store') }}",
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
                    $('#username').val("");
                    $('#email').val("");
                    $('#password').val("");
                    $('#role').val("");

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
                url: "{{ route('user.update') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#dataId').val("");
                    $('#name').val("");
                    $('#username').val("");
                    $('#email').val("");
                    $('#password').val("");
                    $('#role').val("");

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
    // UPDATE DATA USER ACTIVE
    $(document).ready(function() {
        // Mendengarkan klik pada tautan nonaktif
        $('#table-2').on('click', '#active', function(e) {
            e.preventDefault();

            // Menyimpan referensi ke tautan yang benar
            let $this = $(this);

            // Mendapatkan nomor halaman saat ini
            let currentPage = $('#table-2').DataTable().page.info().page;

            // Mendapatkan ID dari atribut data-id
            let dataId = $this.data('id');

            updateActive(dataId, currentPage);
        });

        function updateActive(dataId, currentPage) {
            // Membuat objek FormData
            let formData = new FormData();
            formData.append('id', dataId);
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('_method', 'POST');

            // Mengirimkan data update ke backend menggunakan Ajax
            $.ajax({
                url: "{{ route('user.update.active') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        // Periksa apakah response.data.user berisi data yang valid
                        if (response.data.data) {
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
                        } else {
                            console.log('Terjadi kesalahan response');
                            toastr.error("Terjadi kesalahan response", 'Error');
                        }
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error("An error occurred: " + error, 'Error');
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
                let id = $(this).closest('tr').find('td:eq(1)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('user.delete') }}",
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

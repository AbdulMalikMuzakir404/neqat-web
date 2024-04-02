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
            $('#deleteBtn').show();
        } else {
            $('#deleteBtn').hide();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#download-contoh-excel').click(function() {
            // Kirim permintaan AJAX untuk mengunduh file
            $.ajax({
                url: "{{ asset('assets/excel/Student_Example.xlsx') }}",
                method: 'GET',
                xhrFields: {
                    responseType: 'blob' // Mengatur respons ke tipe blob (binary large object)
                },
                success: function(data) {
                    // Buat URL objek untuk file
                    var url = window.URL.createObjectURL(data);

                    // Buat elemen <a> sementara untuk mengunduh file
                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'Student_Example.xlsx'; // Nama file yang diunduh
                    document.body.appendChild(a);

                    // Klik elemen <a> secara otomatis untuk mengunduh file
                    a.click();

                    // Hapus elemen <a> sementara setelah selesai
                    window.URL.revokeObjectURL(url);
                    a.remove();
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan saat mengunduh file:', error);
                }
            });
        });
    });
</script>

<script>
    // MENDENGARKAN PERUBAHAN PADA CHECKBOX EXPORT
    $(document).on('change', 'input[data-checkboxes="export"]', function() {
        // Mengaktifkan atau menonaktifkan tombol hapus berdasarkan apakah ada baris yang dipilih
        if ($('input[data-checkboxes="export"]:checked').length > 0) {
            $('#exportBtn').show();
        } else {
            $('#exportBtn').hide();
        }
    });
</script>

<script>
    // TRIGER BTN TRASH
    $(document).ready(function() {
        $.ajax({
            url: "/student/count-data-trash",
            type: "GET",
            cache: false,
            success: function(response) {
                if (response) {
                    if (response.data >= 1) {
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
    // KETIKA BTN IMPORT DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#importBtn', function() {
            $('#importModal').modal('show');
            $('#file').val("");
        });
    });
</script>

<script>
    // KETIKA BTN EXPORT DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#exportBtn', function() {
            $('#exportModal').modal('show');
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
            $('#classroom').val("");
            $('#pria').prop('checked', false);
            $('#wanita').prop('checked', false);
            $('#nis').val("");
            $('#nisn').val("");
            $('#phone').val("");
            $('#birth_place').val("");
            $('#birth_date').val("");
            $('#address').val("");

            classRoomData();
        });

        function classRoomData() {
            $.ajax({
                url: "{{ route('student.getallclassroom') }}",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#classroom').empty();

                    // Iterasi melalui respons dan tambahkan opsi baru ke dalam elemen <select>
                    $.each(response.data, function(index, classroom) {
                        $('#classroom').append($('<option>', {
                            value: classroom.id,
                            text: `${classroom.classname} - ${classroom.major}`
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
                url: "/student/get/" + dataId + "/data",
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
                        $('#detailName').text(response.data.user.name ?? '-');
                        $('#detailUsername').text(response.data.user.username ?? '-');
                        $('#detailEmail').text(response.data.user.email ?? '-');
                        if (response.data.user.active == 1) {
                            $('#detailActive').html(
                                '<div class="badge badge-success">active</div>');
                        } else if (response.data.user.active == 0) {
                            $('#detailActive').html(
                                '<div class="badge badge-secondary">nonactive</div>');
                        } else {
                            $('#detailActive').html('<div class="badge badge-danger">-</div>');
                        }
                        if (response.data.user.email_verified == 1) {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-success">verified</div>');
                        } else if (response.data.user.email_verified == 0) {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-secondary">not verified</div>');
                        } else {
                            $('#detailEmailVerified').html(
                                '<div class="badge badge-danger">-</div>');
                        }
                        $('#detailNIS').text(response.data.nis ?? '-');
                        $('#detailNISN').text(response.data.nisn ?? '-');
                        $('#detailClassRoom').text(response.data.classroom ? `${response.data.classroom.classname} - ${response.data.classroom.major}` : '-');
                        $('#detailGender').text(response.data.gender ?? '-');
                        $('#detailIpAddress').text(response.data.user.ip_address ?? '-');
                        $('#detailPhone').text(response.data.phone ?? '-');
                        $('#detailBirthPlace').text(response.data.birth_place ?? '-');
                        $('#detailBirthDate').text(response.data.birth_date ?? '-');
                        $('#detailAddress').text(response.data.address ?? '-');
                        $('#detailEmailVerifiedAt').text(response.data
                            .email_verified_at ? dateFormat(response.data
                                .email_verified_at) :
                            '-');
                        $('#detailFcmToken').text(response.data.user.fcm_token ?? '-');
                        $('#detailActiveAt').text(response.data.user.active_at ? dateFormat(response
                            .data.user.active_at) : '-');
                        $('#detailFirstAccess').text(response.data.user.first_access ? dateFormat(
                            response.data.user.first_access) : '-');
                        $('#detailLastLogin').text(response.data.user.last_login ? dateFormat(
                            response.data.user.last_login) : '-');
                        $('#detailLastAccess').text(response.data.user.last_access ? dateFormat(
                            response.data.user.last_access) : '-');
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
                url: "/student/get/" + dataId + "/data",
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#dataLabel').text('Edit Data');
                    $('#saveData').text('Save and Change');

                    if (response.data) {
                        // Masukan data ke dalam field form edit
                        $('#dataIdStudent').val(response.data.id);
                        $('#dataId').val(response.data.user.id);
                        $('#name').val(response.data.user.name);
                        $('#username').val(response.data.user.username);
                        $('#email').val(response.data.user.email);
                        $('#password').val('');

                        // Panggil classRoomData dan gunakan .then() setelahnya
                        classRoomData().then(function(classrooms) {
                            // Kosongkan opsi peran sebelum menambahkan yang baru
                            $('#classroom').empty();
                            // Tambahkan opsi peran baru ke dalam dropdown
                            classrooms.forEach(function(classroom) {
                                $('#classroom').append($('<option>', {
                                    value: classroom.id,
                                    text: `${classroom.classname} - ${classroom.major}`
                                }));
                            });
                            // Setel opsi peran yang dipilih berdasarkan data dari respons AJAX
                            $('#classroom').val(response.data.classroom.id);
                        }).catch(function(error) {
                            console.error('Terjadi kesalahan:', error);
                        });

                        if (response.data.gender === 'pria') {
                            $('#pria').prop('checked', true);
                        } else if (response.data.gender === 'wanita') {
                            $('#wanita').prop('checked', true);
                        }

                        $('#nis').val(response.data.nis);
                        $('#nisn').val(response.data.nisn);
                        $('#phone').val(response.data.phone);
                        $('#birth_place').val(response.data.birth_place);
                        $('#birth_date').val(response.data.birth_date);
                        $('#address').val(response.data.address);
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

            // Mengembalikan promise untuk mendapatkan data peran
            function classRoomData() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        url: "{{ route('student.getallclassroom') }}",
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
        }
    });
</script>

<script>
    // AMBIL DATA SEMUA STUDENT FILTER BY 10 DATA
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
                url: "{{ route('student.getalldata') }}",
                type: 'POST'
            },
            columns: [{
                    data: null,
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'delete',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'export',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'user.id'
                },
                {
                    data: 'user.name'
                },
                {
                    data: 'user.username'
                },
                {
                    data: 'user.email'
                },
                {
                    data: 'email_verified'
                },
                {
                    data: 'active'
                },
                {
                    data: 'nis'
                },
                {
                    data: 'nisn'
                },
                {
                    data: 'gender'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return row.classroom.classname + ' - ' + row.classroom.major;
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
            },
            "createdRow": function(row, data, dataIndex) {
                $(row).find('td:eq(12)').css('white-space', 'nowrap');
                $(row).find('td:eq(13)').css('white-space', 'nowrap');
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
                url: "{{ route('student.store') }}",
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
                    $('#classroom').val("");
                    $('#gender').val("");
                    $('#nis').val("");
                    $('#nisn').val("");
                    $('#phone').val("");
                    $('#birth_place').val("");
                    $('#birth_date').val("");
                    $('#address').val("");

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
                url: "{{ route('student.update') }}",
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
    // UPDATE DATA STUDENT ACTIVE
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
                url: "{{ route('student.update.active') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');
                        // Periksa apakah response.data.user berisi data yang valid
                        if (response.data) {
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
                let id = $(this).closest('tr').find('td:eq(3)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('student.delete') }}",
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

<script>
    // IMPORT DATA
    $(document).ready(function() {
        $(document).on('click', '#confirm-import', function() {
            let formData = new FormData($('.form-import')[0]);

            formData.append('_method', 'POST');

            // Mendapatkan nomor halaman saat ini
            let currentPage = $('#table-2').DataTable().page.info().page;

            storeData(formData, currentPage);
        });

        function storeData(formData, currentPage) {
            $.ajax({
                url: "{{ route('student.import') }}",
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Success');

                    $('#importModal').modal('hide');

                    $('#file').val("");

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
    // EXPORT DATA YANG DI PILIH
    $(document).ready(function() {
        // Mendengarkan klik pada tombol konfirmasi ekspor di dalam modal
        $('#confirm-export').click(function() {
            // Mengumpulkan ID dari baris yang dipilih
            let formData = new FormData(); // Inisialisasi objek FormData
            $('input[data-checkboxes="export"]:checked').each(function() {
                // Mengabaikan baris header
                let id = $(this).closest('tr').find('td:eq(3)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan ekspor menggunakan AJAX
            $.ajax({
                url: "{{ route('student.export') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Membuat blob dari data file
                        const decodedData = atob(response.file);
                        const buffer = new ArrayBuffer(decodedData.length);
                        const view = new Uint8Array(buffer);
                        for (let i = 0; i < decodedData.length; i++) {
                            view[i] = decodedData.charCodeAt(i) & 0xff;
                        }
                        const blob = new Blob([buffer], {
                            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                        });

                        // Membuat URL objek dari blob
                        const url = URL.createObjectURL(blob);

                        // Membuat link untuk mengunduh file
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = response.filename;

                        // Menambahkan link ke body dan memicu klik event
                        document.body.appendChild(link);
                        link.click();

                        // Membersihkan
                        document.body.removeChild(link);
                        URL.revokeObjectURL(url);

                        toastr.success(response.message, 'Success');

                        $('#exportBtn').prop('disabled', true);
                        $('#exportModal').modal('hide');
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

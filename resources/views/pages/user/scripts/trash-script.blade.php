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
    // MENDENGARKAN PERUBAHAN PADA CHECKBOX RECOVERY
    $(document).on('change', 'input[data-checkboxes="recovery"]', function() {
        // Mengaktifkan atau menonaktifkan tombol hapus berdasarkan apakah ada baris yang dipilih
        if ($('input[data-checkboxes="recovery"]:checked').length > 0) {
            $('#recoveryBtn').prop('disabled', false);
        } else {
            $('#recoveryBtn').prop('disabled', true);
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
    // KETIKA BTN RECOVERY DI KLIK MAKA MUNCULKAN MODAL
    $(document).ready(function() {
        $(document).on('click', '#recoveryBtn', function() {
            $('#recoveryModal').modal('show');
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
                        $('#detailEmailVerifiedAt').text(response.data.data.email_verified_at ?
                            dateFormat(response.data.data.email_verified_at) :
                            '-');
                        $('#detailFcmToken').text(response.data.data.fcm_token ?? '-');
                        $('#detailActiveAt').text(response.data.data.active_at ? dateFormat(response
                            .data.data.active_at) : '-');
                        $('#detailFirstAccess').text(response.data.data.first_access ? dateFormat(
                            response.data.data.first_access) : '-');
                        $('#detailLastLogin').text(response.data.data.last_login ? dateFormat(
                            response.data.data.last_login) : '-');
                        $('#detailLastAccess').text(response.data.data.last_access ? dateFormat(
                            response.data.data.last_access) : '-');
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
    // AMBIL DATA SEMUA USER TRASH FILTER BY 10 DATA
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
                url: "{{ route('user.getalldata.trash') }}",
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
                    data: 'recovery',
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
                    data: 'first_access',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            return new Date(data).toLocaleString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        } else {
                            return '-';
                        }
                    }
                },
                {
                    data: 'last_access',
                    orderable: false,
                    searchable: false,
                    render: function(data) {
                        if (data) {
                            return new Date(data).toLocaleString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            });
                        } else {
                            return '-';
                        }
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
                url: "{{ route('user.delete.permanen') }}",
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
    // RECOVERY DATA YANG DI PILIH
    $(document).ready(function() {
        // Mendengarkan klik pada tombol konfirmasi hapus di dalam modal
        $('#confirm-recovery').click(function() {
            // Mengumpulkan ID dari baris yang dipilih
            let formData = new FormData(); // Inisialisasi objek FormData
            $('input[data-checkboxes="recovery"]:checked').each(function() {
                // Mengabaikan baris header
                let id = $(this).closest('tr').find('td:eq(3)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('user.recovery') }}",
                type: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, 'Success');

                        // Hapus baris dari DOM
                        $('input[data-checkboxes="recovery"]:checked').each(function() {
                            $(this).closest('tr').remove();
                        });

                        $('#recoveryBtn').prop('disabled', true);
                        $('#recoveryModal').modal('hide');
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

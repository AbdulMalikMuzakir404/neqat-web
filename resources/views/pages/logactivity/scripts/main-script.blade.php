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
    // AMBIL DATA SEMUA LOG ACTIVITY FILTER BY 10 DATA
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
                url: "{{ route('logactivity.getalldata') }}",
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
                    data: 'delete',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'id'
                },
                {
                    data: 'user.name',
                },
                {
                    data: 'description',
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
                let id = $(this).closest('tr').find('td:eq(2)').text().trim();
                if (id !== '') {
                    formData.append('ids[]', id); // Menambahkan ID ke FormData
                }
            });

            formData.append('_method', 'POST');

            // Kirim permintaan penghapusan menggunakan AJAX
            $.ajax({
                url: "{{ route('logactivity.delete') }}",
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
    // EXPORT AND DELETE DATA YANG DI PILIH
    $(document).ready(function() {
        // Mendengarkan klik pada tombol konfirmasi ekspor di dalam modal
        $('#confirm-export-and-delete').click(function() {
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

            // Kirim permintaan ekspor menggunakan AJAX
            $.ajax({
                url: "{{ route('logactivity.exportanddelete') }}",
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

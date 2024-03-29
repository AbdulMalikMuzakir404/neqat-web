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
                url: "/announcement/get/" + dataId + "/data",
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
                        $('#detailTitle').text(response.data.title ?? '-');
                        $('#detailDescription').html(response.data.description ?? '-');
                        $('#detailSendAt').text(dateFormat(response.data.send_at) ?? '-');
                        if (response.data.image) {
                            let imageUrl = "{{ asset('') }}" + response.data.image;

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
    // AMBIL DATA SEMUA ANNOUNCEMENT TRASH FILTER BY 10 DATA
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
                url: "{{ route('announcement.getalldata.trash') }}",
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
                    data: 'recovery',
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
                    data: 'description',
                    render: function(data, type, full, meta) {
                        // Batasi deskripsi menjadi 100 karakter tanpa menghilangkan format HTML
                        var maxLength = 100;
                        if (data.length > maxLength) {
                            // Mengonversi HTML entities menjadi HTML yang sesuai
                            data = decodeEntities(data);
                            // Hapus tag HTML dan batasi jumlah karakter
                            data = data.replace(/<[^>]*>?/gm, '').slice(0, maxLength);
                            // Tambahkan elipsis jika teks dipotong
                            data += '...';
                        }
                        return decodeEntities(data);
                    }
                },
                {
                    data: 'send_at',
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
                    data: 'user.name'
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
                url: "{{ route('announcement.delete.permanen') }}",
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
                url: "{{ route('announcement.recovery') }}",
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

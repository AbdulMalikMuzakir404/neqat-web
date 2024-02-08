@extends('layouts.app')

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
    <div class="main-content">

        {{-- MODAL CREATE USER --}}
        <div class="modal fade" id="createUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUserLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-create-user">
                            <div class="form-group">
                                <label for="name">*Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Name"
                                    maxlength="50" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="username">*Username</label>
                                <input type="text" name="username" id="username" value="{{ old('username') }}"
                                    class="form-control @error('username') is-invalid @enderror" placeholder="Username"
                                    maxlength="50" required>
                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">*Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email Address"
                                    maxlength="70" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">*Password</label>
                                <input type="password" name="password" id="password" value="{{ old('password') }}"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    maxlength="100" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="role">*Role</label>
                                <select name="role" id="role" class="form-control select2" required>
                                    @foreach ($data['roles'] as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $role }}
                                    </div>
                                @enderror
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="save-create-user">Save</button>
                    </div>
                </div>
            </div>
        </div>

        @foreach ($data['users'] as $user)
            {{-- MODAL EDIT USER --}}
            <div class="modal fade" id="editUserModal-{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="editUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-edit-user-{{ $user->id }}">
                                <div class="form-group">
                                    <input type="hidden" name="user_id" id="user_id_{{ $user->id }}" value="{{ $user->id }}"
                                        class="form-control @error('user_id_{{ $user->id }}') is-invalid @enderror" placeholder="User ID"
                                        maxlength="11" required>
                                    @error('user_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="name_edit_{{ $user->id }}">*Name</label>
                                    <input type="text" name="name_edit" id="name_edit_{{ $user->id }}" value="{{ $user->name }}"
                                        class="form-control @error('name_edit_{{ $user->id }}') is-invalid @enderror" placeholder="Name"
                                        maxlength="50" required>
                                    @error('name_edit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="username_edit_{{ $user->id }}">*Username</label>
                                    <input type="text" name="username_edit" id="username_edit_{{ $user->id }}" value="{{ $user->username }}"
                                        class="form-control @error('username_edit_{{ $user->id }}') is-invalid @enderror" placeholder="Username"
                                        maxlength="50" required>
                                    @error('username_edit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email_edit_{{ $user->id }}">*Email</label>
                                    <input type="email_edit_{{ $user->id }}" name="email_edit" id="email_edit_{{ $user->id }}" value="{{ $user->email }}"
                                        class="form-control @error('email_edit_{{ $user->id }}') is-invalid @enderror" placeholder="Email Address"
                                        maxlength="70" required>
                                    @error('email_edit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_edit_{{ $user->id }}">*Password</label>
                                    <input type="password" name="password_edit" id="password_edit_{{ $user->id }}" value="{{ old('password_edit') }}"
                                        class="form-control @error('password_edit_{{ $user->id }}') is-invalid @enderror" placeholder="Password"
                                        maxlength="100" required>
                                    @error('password_edit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="role_edit_{{ $user->id }}">*Role</label>
                                    <select name="role_edit" id="role_edit_{{ $user->id }}" class="form-control select2" required>
                                        @foreach ($data['roles'] as $role)
                                            <option value="{{ $role->name }}" {{ $user->roles[0]->name == $role->name ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role_edit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="save-edit-user-{{ $user->id }}">Save and Change</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        @foreach ($data['users'] as $user)
            {{-- MODAL DETAIL USER --}}
            <div class="modal fade" id="detailUserModal-{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="detailUserLabel-{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailUserLabel-{{ $user->id }}">Create User</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name :</label>
                                            <p>{{ $user->name ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="username">Username :</label>
                                            <p>{{ $user->username ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="email">Email :</label>
                                            <p>{{ $user->email ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="active">Active :</label>
                                            @if ($user->active == true)
                                                <div class="badge badge-success">active</div>
                                            @elseif ($user->active == 0)
                                                <div class="badge badge-secondary">nonactive</div>
                                            @else
                                                <div class="badge badge-danger">-</div>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="email_verified">Email Verified :</label>
                                            @if ($user->email_verified == true)
                                                <div class="badge badge-success">verified</div>
                                            @elseif ($user->email_verified == 0)
                                                <div class="badge badge-secondary">not verified</div>
                                            @else
                                                <div class="badge badge-danger">-</div>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Role :</label>
                                            <p>{{ $user->getRoleNames()->first() ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="ip_addess">IP Address :</label>
                                            <p>{{ $user->ip_address ?? '-' }}</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email_verified_at">Email Verified At :</label>
                                            <p>{{ $user->email_verified_at ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="fcm_token">FCM Token :</label>
                                            <p>{{ $user->fcm_token ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="active_at">Active At :</label>
                                            <p>{{ $user->active_at ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="first_access">First Access :</label>
                                            <p>{{ $user->first_access ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="last_login">Last Login :</label>
                                            <p>{{ $user->last_login ?? '-' }}</p>
                                        </div>

                                        <div class="form-group">
                                            <label for="last_access">Last Access :</label>
                                            <p>{{ $user->last_access ?? '-' }}</p>
                                        </div>

                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        {{-- MODAL DELETE USER --}}
        <div class="modal fade" id="deleteUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="deleteUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserLabel">Create User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin menghapus data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm-delete">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>User</h1>
            </div>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">User Table</h4>
                            <div class="">
                                <button type="button" class="btn btn-danger" id="deleteButton" disabled>Delete <i class="ion ion-trash-a"
                                    style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#createUserModal">Create <i class="ion ion-plus"
                                        style="font-size: 12px"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="true">ID</th>
                                            <th data-orderable="false">Name</th>
                                            <th data-orderable="false">Username</th>
                                            <th data-orderable="false">Email</th>
                                            <th data-orderable="false">Verified</th>
                                            <th data-orderable="false">Active</th>
                                            <th data-orderable="false">Role</th>
                                            <th data-orderable="false">First Access</th>
                                            <th data-orderable="false">Last Access</th>
                                            <th data-orderable="false">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('template/assets/modules/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('template/assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js') }}"></script>
    <script src="{{ asset('template/assets/modules/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('template/assets/js/page/modules-datatables.js') }}"></script>

    <script>
        // Mendengarkan perubahan pada checkbox
        $(document).on('change', 'input[data-checkboxes="mygroup"]', function() {
            // Mengaktifkan atau menonaktifkan tombol hapus berdasarkan apakah ada baris yang dipilih
            if ($('input[data-checkboxes="mygroup"]:checked').length > 0) {
                $('#deleteButton').prop('disabled', false);
            } else {
                $('#deleteButton').prop('disabled', true);
            }
        });
    </script>

    <script>
        // GOBAL SETUP AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

    <script>
        // GET DATA USER
        $(document).ready(function() {
            getDataUser();
        });

        function getDataUser() {
            if ($.fn.DataTable.isDataTable('#table-2')) {
                $('#table-2').DataTable().destroy();
            }

            $('#table-2').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('user.getuser') }}",
                    type: 'POST'
                },
                columns: [
                    { data: 'checkbox', orderable: false, searchable: false },
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'username' },
                    { data: 'email' },
                    { data: 'email_verified' },
                    { data: 'active' },
                    { data: 'role' },
                    { data: 'first_access' },
                    { data: 'last_access' },
                    { data: 'action', orderable: false, searchable: false }
                ]
            });
        }
    </script>

    <script>
        // save data create user
        $(document).ready(function() {
            $('#save-create-user').on('click', function() {
                saveCreateUser();
            });

            function saveCreateUser() {
                let formData = new FormData($('.form-create-user')[0]);

                formData.append('_method', 'POST');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('user.store') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message, 'Success');

                        $('#name').val("");
                        $('#username').val("");
                        $('#email').val("");
                        $('#password').val("");
                        $('#role').val("");

                        $('#createUserModal').modal('hide');

                        getDataUser();
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
        // update data user
        $(document).ready(function() {
            $('[id^="save-edit-user"]').on('click', function() {
                // Mendapatkan ID yang digunakan pada tombol
                let userId = $(this).attr('id').split('-').pop();
                // Mendapatkan nomor halaman saat ini
                let currentPage = $('#table-2').DataTable().page.info().page;

                // Memanggil fungsi saveEditUser dan memberikan ID pengguna serta nomor halaman saat ini
                saveEditUser(userId, currentPage);
            });

            function saveEditUser(userId, currentPage) {
                let formData = new FormData($('.form-edit-user-' + userId)[0]);
                formData.append('_method', 'POST');
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "{{ route('user.update') }}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        toastr.success(response.message, 'Success');

                        $('#name_edit-' + userId).val("");
                        $('#username_edit-' + userId).val("");
                        $('#email_edit-' + userId).val("");
                        $('#password_edit' + userId).val("");
                        $('#role_edit' + userId).val("");

                        $('#editUserModal-' + userId).modal('hide');

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
        // update data user active
        $(document).ready(function() {
            // Mendengarkan klik pada tautan nonaktif
            $('#table-2').on('click', '#active', function(e) {
                e.preventDefault();

                // Menyimpan referensi ke tautan yang benar
                let $this = $(this);

                // Mendapatkan ID dari atribut data-id
                let id = $this.data('id');

                // Membuat objek FormData
                let formData = new FormData();
                formData.append('id', id);
                formData.append('_token', '{{ csrf_token() }}');

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

                            if ($.fn.DataTable.isDataTable('#table-2')) {
                                $('#table-2').DataTable().destroy();
                            }

                            // Mendapatkan instance DataTable yang ada
                            let dataTable = $('#table-2').DataTable({
                                columns: [
                                    { data: 'selected', orderable: false, searchable: false },
                                    { data: 'id' },
                                    { data: 'name' },
                                    { data: 'username' },
                                    { data: 'email' },
                                    { data: 'verified' },
                                    { data: 'active' },
                                    { data: 'role' },
                                    { data: 'first_access' },
                                    { data: 'last_access' },
                                    { data: 'action', orderable: false, searchable: false },
                                ]
                            });

                            // Periksa apakah response.data.user berisi data yang valid
                            if (response.data.user) {

                                // Mendapatkan indeks baris yang sesuai dengan ID dari database
                                var index = dataTable.column(1).data().indexOf(response.data.user.id.toString());

                                // Hapus baris dengan indeks yang ditemukan
                                if (index !== -1) {
                                    dataTable.row(index).remove().draw();
                                } else {
                                    toastr.error('Baris dengan ID ' + response.data.user.id + ' tidak ditemukan dalam DataTable.', 'Error');
                                    console.log('Baris dengan ID ' + response.data.user.id + ' tidak ditemukan dalam DataTable.');
                                }

                                // Tambahkan data pengguna ke dalam DataTable
                                dataTable.row.add({
                                    'selected': `<td>
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-${response.data.user.id}">
                                            <label for="checkbox-${response.data.user.id}" class="custom-control-label">&nbsp;</label>
                                        </div>
                                    </td>`,
                                    'id': response.data.user.id ? '<th data-orderable="false">' + response.data.user.id + '</th>' : '<th data-orderable="false">-</th>',
                                    'name': response.data.user.name ? '<th data-orderable="false">' + response.data.user.name + '</th>' : '<th data-orderable="false">-</th>',
                                    'username': response.data.user.username ? '<th data-orderable="false">' + response.data.user.username + '</th>' : '<th data-orderable="false">-</th>',
                                    'email': response.data.user.email ? '<th data-orderable="false">' + response.data.user.email + '</th>' : '<th data-orderable="false">-</th>',
                                    'verified': response.data.user.email_verified == 1 ? '<td><div class="badge badge-success">verified</div></td>' : '<td><div class="badge badge-secondary">not verified</div></td>',
                                    'active': response.data.user.active == 1 ? '<td><div class="badge badge-success"><a href="#" id="active" data-id="' + response.data.user.id + '" style="text-decoration: none; color: inherit; cursor: default">active</a></div></td>' : '<td><div class="badge badge-secondary"><a href="#" id="active" data-id="' + response.data.user.id + '" style="text-decoration: none; color: inherit; cursor: default">nonactive</a></div></td>',
                                    'role': response.data.role ? '<th data-orderable="false">' + response.data.role + '</th>' : '<th data-orderable="false">-</th>',
                                    'first_access': response.data.user.first_access ? '<th data-orderable="false">' + response.data.user.first_access + '</th>' : '<th data-orderable="false">-</th>',
                                    'last_access': response.data.user.last_access ? '<th data-orderable="false">' + response.data.user.last_access + '</th>' : '<th data-orderable="false">-</th>',
                                    'action': `<td>
                                        <button class="btn btn-secondary btn-sm"><i class="ion ion-eye" data-toggle="modal"
                                                data-target="#detailUserModal-${response.data.user.id}"></i></button>
                                        <button class="btn btn-primary btn-sm"><i class="ion ion-compose" data-toggle="modal"
                                                data-target="#editUserModal-${response.data.user.id}"></i></button>
                                    </td>`
                                }).draw();

                                dataTable.order([1, 'asc']).draw();
                            }
                        } else {
                            toastr.error(response.message, 'Error');
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
        // delete data user yang dipilih
        $(document).ready(function() {
            // Mendengarkan klik pada tombol hapus
            $('#deleteButton').click(function() {
                // Menampilkan modal konfirmasi
                $('#deleteUserModal').modal('show');
            });

            // Mendengarkan klik pada tombol konfirmasi hapus di dalam modal
            $('#confirm-delete').click(function() {
                // Mengumpulkan ID dari baris yang dipilih
                let formData = new FormData(); // Inisialisasi objek FormData
                $('input[data-checkboxes="mygroup"]:checked').each(function() {
                    // Mengabaikan baris header
                    var id = $(this).closest('tr').find('td:eq(1)').text().trim();
                    if (id !== '') {
                        formData.append('ids[]', id); // Menambahkan ID ke FormData
                    }
                });

                formData.append('_token', '{{ csrf_token() }}');

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
                            $('input[data-checkboxes="mygroup"]:checked').each(function() {
                                $(this).closest('tr').remove();
                            });

                            $('#deleteButton').prop('disabled', true);
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

@endpush

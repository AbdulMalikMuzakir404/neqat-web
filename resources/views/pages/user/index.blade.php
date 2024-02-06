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
                                <input type="text" name="name" value="{{ old('name') }}"
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
                                <input type="text" name="username" value="{{ old('username') }}"
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
                                <input type="email" name="email" value="{{ old('email') }}"
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
                                <input type="password" name="password" value="{{ old('password') }}"
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
                                <select name="role" class="form-control select2" required>
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
                            <button type="button" class="btn btn-success" data-toggle="modal"
                                data-target="#createUserModal">Create <i class="ion ion-plus"
                                    style="font-size: 12px"></i></button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="mygroup"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-all">
                                                    <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Verified</th>
                                            <th>Active</th>
                                            <th>Role</th>
                                            <th>First Access</th>
                                            <th>Last Access</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['users'] as $user)
                                            <tr>
                                                <td>
                                                    <div class="custom-checkbox custom-control">
                                                        <input type="checkbox" data-checkboxes="mygroup"
                                                            class="custom-control-input" id="checkbox-1">
                                                        <label for="checkbox-1"
                                                            class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>

                                                <td>{{ $user && $user->name ? $user->name : '-' }}</td>
                                                <td>{{ $user && $user->username ? $user->username : '-' }}</td>
                                                <td>{{ $user && $user->email ? $user->email : '-' }}</td>
                                                <td>
                                                    @if ($user && $user->email_verified == 1)
                                                        <div class="badge badge-success">verified</div>
                                                    @elseif ($user && $user->email_verified == 0)
                                                        <div class="badge badge-secondary"><a href="#"
                                                                id="not-verified"
                                                                style="text-decoration: none; color: inherit; cursor: default">not
                                                                verified</a></div>
                                                    @else
                                                        <div class="badge badge-danger">null</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($user && $user->active == 1)
                                                        <div class="badge badge-success">active</div>
                                                    @elseif ($user && $user->active == 0)
                                                        <div class="badge badge-secondary">inactive</div>
                                                    @else
                                                        <div class="badge badge-danger">null</div>
                                                    @endif
                                                </td>
                                                <td>{{ $user && $user->getRoleNames()->first() ? $user->getRoleNames()->first() : '-' }}</td>
                                                <td>{{ $user && $user->first_access ? $user->first_access : '-' }}</td>
                                                <td>{{ $user && $user->last_access ? $user->last_access : '-' }}</td>
                                                <td>
                                                    <button class="btn btn-secondary btn-sm"><i
                                                            class="ion ion-eye"></i></button>
                                                    <button class="btn btn-primary btn-sm"><i
                                                            class="ion ion-compose"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
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

                        if ($.fn.DataTable.isDataTable('#table-2')) {
                            $('#table-2').DataTable().destroy();
                        }

                        let dataTable = $('#table-2').DataTable({
                            columns: [
                                { data: 'id', orderable: false, searchable: false },
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

                        console.log(response.data.name);

                        // Tambahkan data baru
                        dataTable.row.add({
                            'id': '<td>\
                                        <div class="custom-checkbox custom-control">\
                                            <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input" id="checkbox-1">\
                                            <label for="checkbox-1" class="custom-control-label">&nbsp;</label>\
                                        </div>\
                                    </td>',
                            'name': response.data.name ?? '-',
                            'username': response.data.username ?? '-',
                            'email': response.data.email ?? '-',
                            'verified': response.data.email_verified == 1 ? '<div class="badge badge-success">verified</div>' :
                                (response.data.email_verified == 0 ? '<div class="badge badge-secondary"><a href="#" id="not-verified" style="text-decoration: none; color: inherit; cursor: default">not verified</a></div>' : '<div class="badge badge-danger">null</div>'),
                            'active': response.data.active == 1 ? '<div class="badge badge-success">active</div>' :
                                (response.data.active == 0 ? '<div class="badge badge-secondary">inactive</div>' : '<div class="badge badge-danger">null</div>'),
                            'role': response.data.roles && response.data.roles.length > 0 ? response.data.roles[0].name : '-',
                            'first_access': response.data.first_access ?? '-',
                            'last_access': response.data.last_access ?? '-',
                            'action': '<button class="btn btn-secondary btn-sm"><i class="ion ion-eye"></i></button>' +
                                '<button class="btn btn-primary btn-sm"><i class="ion ion-compose"></i></button>',
                        });

                        dataTable.draw(false);
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

@endpush

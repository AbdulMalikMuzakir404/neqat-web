@extends('layouts.app')

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endpush

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>User</h1>
            </div>

            {{-- MODAL CREATE USER --}}
            <div class="modal fade" id="createUserModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                aria-labelledby="createUserLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createUserLabel">Modal Title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Your modal content goes here -->
                            <p>This is the modal content.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
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
                                                        <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                                    </div>
                                                </td>

                                                <td>{{ $user ? $user->name : '-' }}</td>
                                                <td>{{ $user ? $user->username : '-' }}</td>
                                                <td>{{ $user ? $user->email : '-' }}</td>
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
                                                <td>{{ $user ? $user->first_access : '-' }}</td>
                                                <td>{{ $user ? $user->last_access : '-' }}</td>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('template/assets/js/page/modules-datatables.js') }}"></script>
@endpush

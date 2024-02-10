@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Announcement</title>
@endsection

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('pages.announcement.styles.main-style')
@endpush

@section('content')
    <div class="main-content">

        {{-- MODAL CREATE USER --}}
        <div class="modal fade" id="createDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="createDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDataLabel">Announcement</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-create-user">
                            <div class="form-group">
                                <label for="title">*Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Title"
                                    maxlength="50" required autofocus>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">*Description</label>
                                    <textarea name="description" id="description" value="{{ old('description') }}"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Title"
                                    maxlength="225" required cols="30" rows="10"></textarea>
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
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

        {{-- @foreach ($data['data'] as $data) --}}
            {{-- MODAL EDIT USER --}}
            {{-- <div class="modal fade" id="editUserModal-{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
                            <button type="button" class="btn btn-primary" id="btn-save-edit-{{ $user->id }}">Save and Change</button>
                        </div>
                    </div>
                </div>
            </div> --}}
        {{-- @endforeach --}}

        {{-- @foreach ($data['data'] as $data) --}}
            {{-- MODAL DETAIL USER --}}
            {{-- <div class="modal fade" id="detailUserModal-{{ $user->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1"
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
            </div> --}}
        {{-- @endforeach --}}

        {{-- MODAL DELETE USER --}}
        <div class="modal fade" id="deleteDataModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="deleteDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteDataLabel">Create User</h5>
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
                <h1>Announcement</h1>
            </div>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Announcement Table</h4>
                            <div class="">
                                <button type="button" class="btn btn-danger" id="deleteButton" disabled>Delete <i class="ion ion-trash-a"
                                    style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#createDataModal">Create <i class="ion ion-plus"
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
                                            <th data-orderable="false">Title</th>
                                            <th data-orderable="false">Description</th>
                                            <th data-orderable="false">Send At</th>
                                            <th data-orderable="false">Image</th>
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

    @include('pages.announcement.scripts.main-script')

@endpush

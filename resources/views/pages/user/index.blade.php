@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; User</title>
@endsection

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('pages.user.styles.main-style')
@endpush

@section('content')
    <div class="main-content">

        {{-- MODAL CREATE AND UPDATE DATA --}}
        <div class="modal fade" id="dataModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="dataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="form-data">
                            <input type="hidden" name="dataId" id="dataId" value=""
                                class="form-control @error('dataId') is-invalid @enderror" placeholder="Data ID"
                                maxlength="50" required>
                            @error('dataId')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

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
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveData"></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DETAIL DATA --}}
        <div class="modal fade" id="detailModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="detailLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailLabel"></h5>
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
                                        <p id="detailName">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="username">Username :</label>
                                        <p id="detailUsername">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email :</label>
                                        <p id="detailEmail">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Active :</label>
                                        <div id="detailActive"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Email Verified :</label>
                                        <div id="detailEmailVerified"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Role :</label>
                                        <p id="detailRole">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>IP Address :</label>
                                        <p id="detailIpAddress">-</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Verified At :</label>
                                        <p id="detailEmailVerifiedAt">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>FCM Token :</label>
                                        <p id="detailFcmToken">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Active At :</label>
                                        <p id="detailActiveAt">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>First Access :</label>
                                        <p id="detailFirstAccess">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Last Login :</label>
                                        <p id="detailLastLogin">-</p>
                                    </div>

                                    <div class="form-group">
                                        <label>Last Access :</label>
                                        <p id="detailLastAccess">-</p>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL DELETE DATA --}}
        <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="deleteLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteLabel">Delete Data</h5>
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

        {{-- MODAL EXPORT DATA --}}
        <div class="modal fade" id="exportModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="exportLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exportLabel">Export Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin export data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm-export">Ya, Export</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>User</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User</li>
                </ol>
            </nav>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">User Table</h4>
                            <div class="">
                                <a href="{{ route('user.trash') }}" class="btn btn-secondary" id="btnTrash">Trans <i
                                        class="ion ion-trash-a" style="font-size: 12px"></i></a>
                                <button type="button" class="btn btn-primary" id="exportBtn" style="display: none">Export <i
                                        class="ion ion-archive" style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete <i
                                        class="ion ion-close-circled" style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-success" id="createBtn">Create <i
                                        class="ion ion-plus" style="font-size: 12px"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="delete"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-delete">
                                                    <label for="checkbox-delete"
                                                        class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="export"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-export">
                                                    <label for="checkbox-export"
                                                        class="custom-control-label">&nbsp;</label>
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
                                            <th data-orderable="false" class="align-middle text-center">Action</th>
                                        </tr>
                                    </thead>
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

    @include('pages.user.scripts.main-script')
@endpush

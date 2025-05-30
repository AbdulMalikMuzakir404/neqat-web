@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Student</title>
@endsection

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('pages.student.styles.main-style')
@endpush

@section('content')
    <div class="main-content">

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
                                        <label>NIS :</label>
                                        <div id="detailNIS"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>NISN :</label>
                                        <div id="detailNISN"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Class Room :</label>
                                        <div id="detailClassRoom"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Gender :</label>
                                        <div id="detailGender"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>IP Address :</label>
                                        <p id="detailIpAddress">-</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone :</label>
                                        <div id="detailPhone"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Birth Place :</label>
                                        <div id="detailBirthPlace"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Birth Date :</label>
                                        <div id="detailBirthDate"></div>
                                    </div>

                                    <div class="form-group">
                                        <label>Address :</label>
                                        <div id="detailAddress"></div>
                                    </div>

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

        {{-- MODAL DELETE PERMANEN DATA --}}
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
                        <p>Apakah anda yakin ingin menghapus data ini secara permanen?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm-delete">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL RECOVERY DATA --}}
        <div class="modal fade" id="recoveryModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="recoveryLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="recoveryLabel">Recovery Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin ingin memulihkan data ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="confirm-recovery">Ya, Pulihkan</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>Student</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Student</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Student Trash</li>
                </ol>
            </nav>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Student Trash Table</h4>
                            <div class="">
                                <button type="button" class="btn btn-success" id="recoveryBtn" disabled>Recovery <i class="ion ion-loop"
                                    style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete <i class="ion ion-close-circled"
                                    style="font-size: 12px"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-orderable="true">No</th>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="delete"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-delete">
                                                    <label for="checkbox-delete" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="recovery"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-recovery">
                                                    <label for="checkbox-recovery" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="false">ID</th>
                                            <th data-orderable="true">Name</th>
                                            <th data-orderable="false">Username</th>
                                            <th data-orderable="false">Email</th>
                                            <th data-orderable="false">Verified</th>
                                            <th data-orderable="false">Active</th>
                                            <th data-orderable="false">NIS</th>
                                            <th data-orderable="false">NISN</th>
                                            <th data-orderable="false">Gender</th>
                                            <th data-orderable="false">Class Room</th>
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

    @include('pages.student.scripts.trash-script')
@endpush

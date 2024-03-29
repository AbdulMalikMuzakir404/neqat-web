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

    @include('pages.announcement.styles.main-style')
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
                            <div class="form-group">
                                <label for="title">Title :</label>
                                <p id="detailTitle">-</p>
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <p id="detailDescription">-</p>
                            </div>

                            <div class="form-group">
                                <label for="sendAt">Send At :</label>
                                <p id="detailSendAt">-</p>
                            </div>

                            <div class="form-group">
                                <label for="image">Image :</label>
                                <div class="gallery gallery-fw" data-item-height="100" id="detailImage">
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
                <h1>User</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('announcement.index') }}">Announcement</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Announcement Trash</li>
                </ol>
            </nav>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Announcement Trash Table</h4>
                            <div class="">
                                <button type="button" class="btn btn-success" id="recoveryBtn" disabled>Recovery <i class="ion ion-loop"
                                    style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete <i class="ion ion-close-circled"
                                    style="font-size: 12px"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="table-2" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-orderable="true">No</th>
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
                                                    <input type="checkbox" data-checkboxes="recovery"
                                                        data-checkbox-role="dad" class="custom-control-input"
                                                        id="checkbox-recovery">
                                                    <label for="checkbox-recovery" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="false">ID</th>
                                            <th data-orderable="false">Title</th>
                                            <th data-orderable="false">Description</th>
                                            <th data-orderable="true">Send At</th>
                                            <th data-orderable="false">Created By</th>
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

    @include('pages.announcement.scripts.trash-script')
@endpush

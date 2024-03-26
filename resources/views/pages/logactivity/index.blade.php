@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Log Activity</title>
@endsection

@push('styles')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('template/assets/modules/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css') }}">

    <!-- CSS CDN -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @include('pages.logactivity.styles.main-style')
@endpush

@section('content')
    <div class="main-content">
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
                        <button type="button" class="btn btn-success" id="confirm-export-and-delete">Ya, Export dan Hapus</button>
                        <button type="button" class="btn btn-primary" id="confirm-delete">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>Log Activity</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Log Activity</li>
                </ol>
            </nav>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">User Table</h4>
                            <div class="">
                                <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete <i
                                        class="ion ion-close-circled" style="font-size: 12px"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-2" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th data-orderable="false">No</th>
                                            <th data-orderable="false" class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" data-checkboxes="delete" data-checkbox-role="dad"
                                                        class="custom-control-input" id="checkbox-delete">
                                                    <label for="checkbox-delete" class="custom-control-label">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th data-orderable="false">ID</th>
                                            <th data-orderable="false">User</th>
                                            <th data-orderable="false">Description</th>
                                            <th data-orderable="false">Created At</th>
                                            <th data-orderable="false">Updated At</th>
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

    <!-- Page Specific JS File -->
    <script src="{{ asset('template/assets/js/page/modules-datatables.js') }}"></script>

    <!-- JS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    @include('pages.logactivity.scripts.main-script')
@endpush

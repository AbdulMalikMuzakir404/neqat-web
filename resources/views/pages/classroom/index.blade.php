@extends('layouts.app')

@section('title')
    <title>Neqat &mdash; Class Room</title>
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

@include('pages.classroom.styles.main-style')
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
                            <div class="form-group">
                                <input type="hidden" name="dataId" id="dataId" value=""
                                    class="form-control @error('dataId') is-invalid @enderror" placeholder="Data ID"
                                    maxlength="50" required>
                                @error('dataId')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                                <label for="name">*Nama Jurusan</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Nama Jurusan"
                                    maxlength="50" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
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
                                <label for="name">Name :</label>
                                <p id="detailName">-</p>
                            </div>

                            <div class="form-group">
                                <label for="create_at">Created At :</label>
                                <p id="detailCreatedAt">-</p>
                            </div>

                            <div class="form-group">
                                <label for="updated_at">Updated At :</label>
                                <p id="detailUpdatedAt">-</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="section-header">
                <h1>Class Room</h1>
            </div>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Class Room</li>
                </ol>
            </nav>

            {{-- TABLE --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="m-0">Class Room Table</h4>
                            <div class="">
                                <a href="{{ route('classroom.trash') }}" class="btn btn-secondary" id="btnTrash">Trans <i
                                    class="ion ion-trash-a" style="font-size: 12px"></i></a>
                                <button type="button" class="btn btn-danger" id="deleteBtn" disabled>Delete <i
                                        class="ion ion-trash-a" style="font-size: 12px"></i></button>
                                <button type="button" class="btn btn-success" id="createBtn">Create <i
                                        class="ion ion-plus" style="font-size: 12px"></i></button>
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
                                            <th data-orderable="false">ID</th>
                                            <th data-orderable="false">Name</th>
                                            <th data-orderable="false">Created At</th>
                                            <th data-orderable="false">Updated At</th>
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

<!-- Page Specific JS File -->
<script src="{{ asset('template/assets/js/page/modules-datatables.js') }}"></script>

<!-- JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@include('pages.classroom.scripts.main-script')
@endpush

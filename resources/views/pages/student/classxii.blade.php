{{-- TABLE STUDENT XII --}}
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="m-0">Student Table</h4>
                <div class="">
                    <a href="{{ route('student.trash') }}" class="btn btn-secondary" id="btnTrash">Trans <i
                            class="ion ion-trash-a" style="font-size: 12px"></i></a>
                    <button type="button" class="btn btn-info" id="importBtn">Import <i class="ion ion-upload"
                            style="font-size: 12px"></i></button>
                    <button type="button" class="btn btn-primary" id="exportBtn" style="display: none">Export <i
                            class="ion ion-archive" style="font-size: 12px"></i></button>
                    <button type="button" class="btn btn-danger" id="deleteBtn" style="display: none">Delete <i
                            class="ion ion-close-circled" style="font-size: 12px"></i></button>
                    <button type="button" class="btn btn-success" id="createBtn">Create <i class="ion ion-plus"
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
                                        <input type="checkbox" data-checkboxes="delete" data-checkbox-role="dad"
                                            class="custom-control-input" id="checkbox-delete">
                                        <label for="checkbox-delete" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th>
                                <th data-orderable="false" class="text-center">
                                    <div class="custom-checkbox custom-control">
                                        <input type="checkbox" data-checkboxes="export" data-checkbox-role="dad"
                                            class="custom-control-input" id="checkbox-export">
                                        <label for="checkbox-export" class="custom-control-label">&nbsp;</label>
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

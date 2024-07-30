
<div class="modal fade p-4 py-md-5" tabindex="-1" role="dialog" id="uploadModal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-4 pb-4 border-bottom-1">
                <h1 class="fw-bold mb-0 fs-2">Import</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeUploadModal"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                    <!-- Nav tabs -->
                    <nav class="p-3">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-list" type="button" role="tab" aria-controls="nav-home" aria-selected="true">From List</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-file" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">From File</button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-list" role="tabpanel" aria-labelledby="nav-list-tab" tabindex="0">
                            <form id="importList">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-success text-center" data-bs-toggle="modal" data-bs-target="#addListModal" id="addListBtn"><i class="bi bi-plus-square"></i>
                                        Add new list</a>
                                </div>
                                <div id="listData" class="mt-3 mb-3"></div>
                                <div class="invalid-feedback" id="listCheckbox">Please choose one or more list(s)</div>

                                <input type="hidden" name="importfrom" value="list">
                                <div class="form-floating mt-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" id="checkFiles">Check</button>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="nav-file" role="tabpanel" aria-labelledby="nav-file-tab" tabindex="0">
                            <form id="importFormFile">
                            <!-- Step 1: CSV -->
                            <div class="step active">
                                <div>
                                    <label for="formFileLg" class="form-label">Choose CSV file</label>
                                    <input class="form-control form-control-lg" id="csvFile" type="file" name="file" accept=".csv" required>
                                    <div class="invalid-feedback" id="fileErrorMsg">The file is required</div>
                                </div>
                                <div class="form-floating mt-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mt-3 align-content-end" id="nextToDate">Check</button>
                                </div>
                            </div>

                            <!-- Step 2: Date -->
                            <div class="step">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control rounded-3" id="date" name="date"  required>
                                    <label for="date">Date</label>
                                    <div class="invalid-feedback" id="dateErrorMsg">The date is required</div>
                                </div>
                                <div class="form-floating mt-3 d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mx-3" id="backToFile">Previous</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade p-4 py-md-5" tabindex="-1" role="dialog" id="addListModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header p-4 pb-4 border-bottom-1">
                <h1 class="fw-bold mb-0 fs-2">Add list</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeUploadModal"></button>
            </div>

            <div class="modal-body p-5 pt-0">
                <form id="addList" class="p-3">
                    <div class="form-floating mb-3">
                        <input type="text" name="title" class="form-control rounded-3" id="title" placeholder="Title" required>
                        <label for="title">Title *</label>
                        <div id="title" class="invalid-feedback">
                            Title is required
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="msisdn" name="msisdn" required></textarea>
                        <label for="floatingTextarea">Msisdn *</label>
                        <div id="msisdn" class="invalid-feedback">
                            Msisdn is required
                        </div>
                        <div id="msdnHelp" class="form-text">Please use ',' or ';'. Example: 1, 2024-05-07 12:00:00, Emily Davis, +374 00 000000, 50, emily@example.com
                        </div>
                    </div>
                    <div class="form-floating mt-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade p-4 py-md-5" tabindex="-1" role="dialog" id="deleteListModal">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete list</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete <b class="text-danger-emphasis text-sm-center" id="listTitle"></b>.</p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="listId">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="deleteListBtn">Delete</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/assets/js/script.js"></script>
<script src="/assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
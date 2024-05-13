<?php $this->load->view('templates/header.php'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Book</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('Dashboard')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Book</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Book List</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-sm btn-primary btn-new-book" title="New Book">New Book</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tableBook" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">UUID</th>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">Book Code</th>
                                            <th style="text-align: center">Cover</th>
                                            <th style="text-align: center">Book Title</th>
                                            <th style="text-align: center">Book Categories</th>
                                            <th style="text-align: center">Book Stock</th>
                                            <th style="text-align: center">Book Year</th>
                                            <th style="text-align: center">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="card-footer with-border"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Add -->
        <div class="modal fade modal-add-book" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Book/create'); ?>" id="addBookForm" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title</label><small style="color: red"><i> *</i></small>
                                <input type="text" class="form-control" name="title" placeholder="Enter Book Title" required>
                            </div>
                            <div class="form-group">
                                <label>Categories</label><small style="color: red"><i> *</i></small>
                                <input type="text" class="form-control" name="categories" placeholder="Enter Book Categories" required>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Stock</label><small style="color: red"><i> *</i></small>
                                        <input type="number" class="form-control" name="stock" placeholder="Enter Book Stock" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Year</label><small style="color: red"><i> *</i></small>
                                        <input type="text" class="form-control year-edit" name="year" placeholder="Enter Book Year" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Cover</label>
                                <input type="file" name="file" class="form-control">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Add -->

        <!-- Modal Edit -->
        <div class="modal fade modal-edit-book" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('Book/update'); ?>" id="editBookForm" enctype="multipart/form-data" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="uuid" class="book-uuid">
                            <div class="form-group">
                                <label>Title</label><small style="color: red"><i> *</i></small>
                                <input type="text" class="form-control title-edit" name="title" placeholder="Enter Book Title" required>
                            </div>
                            <div class="form-group">
                                <label>Categories</label><small style="color: red"><i> *</i></small>
                                <input type="text" class="form-control categories-edit" name="categories" placeholder="Enter Book Categories" required>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Stock</label><small style="color: red"><i> *</i></small>
                                        <input type="number" class="form-control stock-edit" name="stock" placeholder="Enter Book Stock" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Year</label><small style="color: red"><i> *</i></small>
                                        <input type="text" class="form-control year-edit" name="year" placeholder="Enter Book Year" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Cover</label>
                                <input type="file" name="file" class="form-control" accept="image/png, image/jpg, image/jpeg">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Edit -->
    </div>

<?php $this->load->view('templates/footer.php'); ?>

<script>
    $(document).ready(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var tableBook = $('#tableBook').DataTable({
            processing      : true,
            serverSide      : true,
            scrollX         : true,
            scrollCollapse  : true,
            paging          : true,
            info            : true,
            "ordering"      : false,
            "ajax"          : {
                "url": "<?= base_url('Book/get'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data" : 'uuid', "visible": false },
                { "data" : "number", "sClass": "text-center" },
                { "data" : "code", "sClass": "text-center" },
                { "data" : "cover", "sClass": "text-center" },
                { "data" : "title", "sClass": "text-center" },
                { "data" : "categories", "sClass": "text-center" },
                { "data" : "stock", "sClass": "text-center" },
                { "data" : "year", "sClass": "text-center" },
                {
                    "data"    : null,
                    "sClass": "text-center",
                    render : function (data, type, row) {
                        return "<a href='#' class='action-edit-book' title='Edit Book'><i class='fas fa-pen'></i></a>&nbsp;<a href='#' class='action-delete-book' title='Delete Book'><i class='fas fa-trash'></i></a>";
                    }
                }
            ]
        });

        $('.btn-new-book').on('click', function() {
            $('.modal-add-book').modal('show');
        });

        $('.year-add').datepicker({
            minViewMode: 2,
            format: 'yyyy',
            autoclose: true
        });

        $('#addBookForm').submit(function(e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: form,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 201) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('.modal-add-book').modal('hide');
                        tableBook.ajax.reload(null, false);
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: response.message
                        });
                        $('.modal-add-book').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                }          
            });
        });

        tableBook.on('click', '.action-edit-book', function(e) {
            e.preventDefault();
            var data = tableBook.rows($(this).parents('tr')).data();
            $('.modal-edit-book').modal('show');
            $('.book-uuid').val(data[0].uuid);
            $('.title-edit').val(data[0].title);
            $('.categories-edit').val(data[0].categories);
            $('.stock-edit').val(data[0].stock);
            $('.year-edit').val(data[0].year);
        });

        $('.year-edit').datepicker({
            minViewMode: 2,
            format: 'yyyy',
            autoclose: true
        });

        $('#editBookForm').submit(function (e) {
            e.preventDefault();
            var form = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: form,
                dataType: 'JSON',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        $('.modal-edit-book').modal('hide');
                        tableBook.ajax.reload(null, false);
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: response.message
                        });
                        $('.modal-edit-book').modal('hide');
                    }
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                }          
            });
        });

        tableBook.on('click', '.action-delete-book', function(e) {
            e.preventDefault();
            var data = tableBook.rows($(this).parents('tr')).data();
            var uuid = data[0].uuid;
            $.ajax({
                url: "<?= base_url('Book/delete') ?>",
                type: 'POST',
                data: {'uuid' : uuid},
                dataType: 'JSON',
                success: function(response) {
                    if (response.code == 200) {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        });
                        tableBook.ajax.reload(null, false);
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: response.message
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                }          
            });
        });
    });
</script>
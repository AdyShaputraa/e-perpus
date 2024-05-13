<?php $this->load->view('templates/header.php'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Transaction</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('Dashboard')?>">Dashboard</a></li>
                            <li class="breadcrumb-item">Transaction</li>
                            <li class="breadcrumb-item active">Form</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <form action="<?= base_url('Transaction/create'); ?>" id="addTransactionForm" method="post">
                    <div class="row">
                        <div class="col-7">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Form</h3>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" class="header_uuid">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Name</label><small style="color: red"><i> *</i></small>
                                                <input type="text" name="name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Contact Person</label><small style="color: red"><i> *</i></small>
                                                <input type="number" name="contact" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label><small style="color: red"><i> *</i></small>
                                        <textarea name="address" class="form-control"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Start Date</label><small style="color: red"><i> *</i></small>
                                                <input type="text" name="start_date" class="form-control start_date">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Exp Date</label><small style="color: red"><i> *</i></small>
                                                <input type="text" name="exp_date" class="form-control exp_date" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer with-border">
                                    <div class="form-group">
                                        <label>Book Code</label><small style="color: red"><i> *</i></small>
                                        <select name="book" class="form-control select2bs4 book-id" style="width:100%" required>
                                            <option value="" selected disabled>Select Once</option>
                                            <?php foreach ($book as $value) { ?>
                                                <option value="<?= $value->uuid ?>"><?= $value->code . ' - ' . $value->title ?></option>    
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Book Title</label>
                                                <input type="text" class="form-control line-book-title" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Book Categories</label>
                                                <input type="text" class="form-control line-book-categories" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Stock Book</label>
                                                <input type="number" class="form-control line-stock-book" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Qty</label><small style="color: red"><i> *</i></small>
                                        <input type="number" name="qty" class="form-control book-qty" required>
                                    </div>
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-sm btn-primary">Add to list</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-5">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Book List</h3>
                                </div>
                                <div class="card-body">
                                    <table id="tableBookList" class="table table-bordered table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center">UUID</th>
                                                <th style="text-align: center">No</th>
                                                <th style="text-align: center">Book Title</th>
                                                <th style="text-align: center">Qty</th>
                                                <th style="text-align: center">Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="card-footer with-border">
                                    <!-- <button type="submit" class="btn btn-success btn-save-transaction form-control">Save Transaction</button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
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
        
        var tableBookList = $('#tableBookList').DataTable({
            processing      : true,
            serverSide      : true,
            scrollX         : true,
            scrollCollapse  : true,
            paging          : true,
            info            : true,
            "ordering"      : false,
            "ajax"          : {
                "url": "<?= base_url('Transaction/getBookList'); ?>",
                "type": "POST",
                'data'  : function(data) {
                    var header_uuid = $('.header-uuid').val();
                    data.header_uuid = header_uuid;
                }
            },
            "columns": [
                { "data" : 'transaction_line_uuid', "visible": false },
                { "data" : "number", "sClass": "text-center" },
                { "data" : "book_name", "sClass": "text-center" },
                { "data" : "transaction_line_qty", "sClass": "text-center" },
                {
                    "data"    : null,
                    "sClass": "text-center",
                    render : function (data, type, row) {
                        return "<a href='#' class='action-edit-book-list' title='Edit Book List'><i class='fas fa-pen'></i></a>&nbsp;<a href='#' class='action-delete-book-list' title='Delete Book List'><i class='fas fa-trash'></i></a>";
                    }
                }
            ]
        });

        $('#addTransactionForm').submit(function(e) {
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
                        tableBookList.ajax.reload(null, false);
                        $('.header_uuid').val(response.uuid);
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

        $('.start_date').datepicker({
            dateFormat: "yy-mm-dd",
            startDate: new Date("<?= date('Y-m-d') ?>"),
            todayHighlight: true,
            autoclose: true
        }).on('changeDate', function() {
            var extendsDate = 0;
            var endDate = new Date((new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getMonth() < 10 ? '0' + (new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getMonth() + 1) : (new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getMonth()) + 1) + '/' + (new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getDate() < 10 ? '0' + new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getDate() : new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getDate()) + '/' + new Date(new Date($(this).val()).getTime() + (2 * 24 * 60 * 60 * 1000)).getFullYear());
            if (new Date($(this).val()) <= endDate) {
                var loop = new Date($(this).val());
                while(loop <= endDate) {
                    if (loop.getDay() === 6 || loop.getDay() === 0) {
                        extendsDate += 1;
                    }
                    var newDate = loop.setDate(loop.getDate() + 1);
                    loop = new Date(newDate);
                }
            }
            endDate = new Date((new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getMonth() < 10 ? '0' + (new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getMonth() + 1) : (new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getMonth()) + 1) + '/' + (new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getDate() < 10 ? '0' + new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getDate() : new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getDate()) + '/' + new Date(new Date(endDate).getTime() + (extendsDate * 24 * 60 * 60 * 1000)).getFullYear());
            $('.exp_date').datepicker('update', endDate);
        });

        $('.book-id').on('change', function(e) {
            e.preventDefault();
            var uuid = $(this).val();
            $.ajax({
                url: "<?= base_url('Transaction/getBookID'); ?>",
                type: "POST",
                data: { 'uuid' : uuid },
                dataType: 'JSON',
                success: function(response) {
                    $.each(response, function(key, value) {
                        $('.line-book-title').val(value.title);
                        $('.line-book-categories').val(value.categories);
                        $('.line-stock-book').val(value.stock);
                    });
                },
                error: function(xhr, status, error) {
                    Toast.fire({
                        icon: 'error',
                        title: error
                    });
                }          
            });
        });

        $('.book-qty').on('change', function(e) {
            if ($(this).val() > $('.line-stock-book').val()) {
                $('.book-qty').val('');
                Toast.fire({
                    icon: 'error',
                    title: 'Insufficient Stock'
                });
                $('.book-qty').focus();
            }
        });
    });
</script>
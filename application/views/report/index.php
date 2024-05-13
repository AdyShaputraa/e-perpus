<?php $this->load->view('templates/header.php'); ?>

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Report</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('Dashboard')?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Report</li>
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
                                <h3 class="card-title">Report</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Report Type</label>
                                            <select name="report-type" class="form-control select2bs4 report-type" style="width:100%" required>
                                                <option value="" selected disabled>Select Once</option>
                                                <option value="Daily">Daily</option>
                                                <option value="Monthly">Monthly</option>
                                                <option value="Custom">Custom Range Date</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Start Date</label>
                                            <input type="date" name="startDate" class="form-control startDate">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Until Date</label>
                                            <input type="date" name="endDate" class="form-control endDate">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Export To</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <button class="btn btn-sm btn-success btn-export-docx form-control" disabled>.docx</button>
                                                </div>
                                                <div class="col-4">
                                                    <button class="btn btn-sm btn-primary btn-export-doc form-control" disabled>.doc</button>
                                                </div>
                                                <div class="col-4">
                                                    <button class="btn btn-sm btn-info btn-export-odt form-control" disabled>.odt</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer with-border">
                                <table id="tableReport" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center">UUID</th>
                                            <th style="text-align: center">No</th>
                                            <th style="text-align: center">Name</th>
                                            <th style="text-align: center">Address</th>
                                            <th style="text-align: center">Contact Person</th>
                                            <th style="text-align: center">Start Date</th>
                                            <th style="text-align: center">Expire Date</th>
                                            <th style="text-align: center">Action</th>
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

<?php $this->load->view('templates/footer.php'); ?>

<script>
    $(document).ready(function() {
        $('.startDate').attr('disabled', true);
        $('.endDate').attr('disabled', true);
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var tableReport = $('#tableReport').DataTable({
            // processing      : true,
            // serverSide      : true,
            scrollX         : true,
            scrollCollapse  : true,
            paging          : true,
            info            : true,
            "ordering"      : false,
            // "ajax"          : {
            //     "url": "<?= base_url('Transaction/get'); ?>",
            //     "type": "POST"
            // },
            // "columns": [
            //     { "data" : 'uuid', "visible": false },
            //     { "data" : "number", "sClass": "text-center" },
            //     { "data" : "name", "sClass": "text-center" },
            //     { "data" : "address", "sClass": "text-center" },
            //     { "data" : "contact", "sClass": "text-center" },
            //     { "data" : "start_date", "sClass": "text-center" },
            //     { "data" : "exp_date", "sClass": "text-center" },
            //     {
            //         "data"    : null,
            //         "sClass": "text-center",
            //         render : function (data, type, row) {
            //             return "<a href='#' class='action-edit-transaction' title='Edit Transaction'><i class='fas fa-pen'></i></a>&nbsp;<a href='#' class='action-views-transaction' title='Views Transaction'><i class='fas fa-eye'></i></a>";
            //         }
            //     }
            // ]
        });

        $('.report-type').on('change', function(e) {
            e.preventDefault();
            if ($(this).val() == 'Custom') {
                $('.startDate').attr('disabled', false);
                $('.endDate').attr('disabled', false);
            } else {
                $('.startDate').attr('disabled', true);
                $('.endDate').attr('disabled', true);
            }
        })
    });
</script>
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
                            <li class="breadcrumb-item active">Transaction</li>
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
                                <h3 class="card-title">Transaction List</h3>
                                <div class="card-tools">
                                    <a href="<?= base_url('Transaction/form');?>">
                                        <button type="button" class="btn btn-sm btn-primary" title="New Transaction">New Transaction</button>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="tableTransaction" class="table table-bordered table-striped" style="width:100%">
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
                            <div class="card-footer with-border"></div>
                        </div>
                    </div>
                </div>
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

        var tableTransaction = $('#tableTransaction').DataTable({
            processing      : true,
            serverSide      : true,
            scrollX         : true,
            scrollCollapse  : true,
            paging          : true,
            info            : true,
            "ordering"      : false,
            "ajax"          : {
                "url": "<?= base_url('Transaction/get'); ?>",
                "type": "POST"
            },
            "columns": [
                { "data" : 'uuid', "visible": false },
                { "data" : "number", "sClass": "text-center" },
                { "data" : "name", "sClass": "text-center" },
                { "data" : "address", "sClass": "text-center" },
                { "data" : "contact", "sClass": "text-center" },
                { "data" : "start_date", "sClass": "text-center" },
                { "data" : "exp_date", "sClass": "text-center" },
                {
                    "data"    : null,
                    "sClass": "text-center",
                    render : function (data, type, row) {
                        return "<a href='#' class='action-edit-transaction' title='Edit Transaction'><i class='fas fa-pen'></i></a>&nbsp;<a href='#' class='action-views-transaction' title='Views Transaction'><i class='fas fa-eye'></i></a>";
                    }
                }
            ]
        });
    });
</script>
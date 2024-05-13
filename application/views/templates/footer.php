        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <script src="<?= base_url('./assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/datatables/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/datatables-responsive/js/dataTables.responsive.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/sweetalert2/sweetalert2.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/toastr/toastr.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') ?>"></script>
    <script src="<?= base_url('./assets/plugins/select2/js/select2.full.min.js'); ?>"></script>
    <script src="<?= base_url('./assets/dist/js/adminlte.min.js');?>"></script>
    <script>
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            var url = window.location;
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');
        });
    </script>
</body>
</html>
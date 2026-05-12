<!-- jQuery must be loaded first for DataTables and other jQuery plugins -->
<script src="assets/datatable/js/jquery.min.js"></script>

<!-- Conditional Editor Loading -->
<?php if (isset($load_editor) && $load_editor): ?>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
<?php endif; ?>

<!-- Conditional Charts Loading -->
<?php if (isset($load_charts) && $load_charts): ?>
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
<?php endif; ?>

<!-- Conditional DataTables Loading (now that jQuery is loaded) -->
<?php if (isset($load_datatable) && $load_datatable): ?>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/datatable/js/jquery.dataTables.min.js"></script>
  <script src="assets/datatable/js/dataTables.responsive.min.js"></script>
  <script src="assets/datatable/js/dataTables.buttons.min.js"></script>
  <script src="assets/datatable/js/jszip.min.js"></script>
  <script src="assets/datatable/js/pdfmake.min.js"></script>
  <script src="assets/datatable/js/vfs_fonts.js"></script>
  <script src="assets/datatable/js/buttons.print.min.js"></script>
  <script src="assets/datatable/js/buttons.html5.min.js"></script>
  <script src="assets/datatable/js/buttons.colVis.min.js"></script>
<?php endif; ?>

<!-- Core Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/sweetalert/sweetalert2.all.min.js"></script>

<!-- Utils -->
<script src="assets/js/moment.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File (depends on all libraries above) -->
<script src="assets/js/main.js"></script>
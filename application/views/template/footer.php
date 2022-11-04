       <!-- Main content -->

       <!-- /.content -->
       </div>
       <!-- /.content-wrapper -->

       <footer class="main-footer fixed">
           <div class="float-right d-none d-sm-block">
               <b>Version</b> 1.0.0
           </div>
           <strong>Copyright &copy; 2022 <a href="#">Security Guard Tour</a></strong>
       </footer>

       </div>
       <!-- ./wrapper -->


       <!-- Bootstrap 4 -->
       <script src="<?= base_url('assets') ?>/dist/js/bootstrap.min.js"></script>
       <!--<script src="<?= base_url('assets') ?>/dist/js/bootstrap.bundle.min.js"></script>-->
       <!-- AdminLTE App -->
       <script src="<?= base_url('assets') ?>/dist/js/adminlte.min.js?<?= date('Y-m-d H:i:s') ?>"></script>
       <!-- AdminLTE for demo purposes -->
       <script src="<?= base_url('assets') ?>/dist/js/demo.js"></script>
       <!-- DataTables  & Plugins -->
	   <script src="<?= base_url('assets') ?>/dist/js/vendor/jszip/jszip.min.js"></script>
	   <script src="<?= base_url('assets') ?>/dist/js/jquery.dataTables.min.js"></script>
       <script src="<?= base_url('assets') ?>/dist/js/dataTables.bootstrap4.min.js"></script>
       <script src="<?= base_url('assets') ?>/dist/js/dataTables.responsive.min.js"></script>
       <script src="<?= base_url('assets') ?>/dist/js/responsive.bootstrap4.min.js"></script>
       <script src="<?= base_url('assets') ?>/dist/js/dataTables.buttons.min.js"></script>
	   <script src="<?= base_url('assets') ?>/dist/js/buttons.bootstrap4.min.js"></script>
	   <script src="<?= base_url('assets') ?>/dist/js/buttons.print.js"></script>
	   <script src="<?= base_url('assets') ?>/dist/js/buttons.html5.js"></script>
       <!-- Select2 -->
       <script src="<?= base_url('assets') ?>/dist/select2/js/select2.full.min.js"></script>
       <!-- date-range-picker -->
       <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
	   </body>
       <script>
           //Initialize Select2 Elements
           $('.select2').select2()
           $("#example2").DataTable({
               "paging": true,
               "lengthChange": false,
               "searching": true,
               "ordering": false,
               "info": true,
               "autoWidth": false,
               "responsive": true,
           })

           $('#tgl1,#tgl2').datepicker({
               dateFormat: 'yy-mm-dd',
               autoclose: true
           });
           $('#tgl13').datepicker({
               dateFormat: 'yy-mm-dd',
               autoclose: true
           });
           $('#tgl23').datepicker({
               dateFormat: 'yy-mm-dd',
               autoclose: true
           });

           $(document).ready(function() {
               // Setup - add a text input to each footer cell
               $('#example thead tr')
                   .clone(true)
                   .addClass('filters')
                   .appendTo('#example thead');

               var table = $('#example').DataTable({
                   orderCellsTop: true,
                   fixedHeader: true,
                   "paging": true,
                   "lengthChange": false,
                   "searching": true,
                   "ordering": false,
                   "info": true,
                   "autoWidth": false,
                   "responsive": true,
                   initComplete: function() {
                       var api = this.api();

                       // For each column
                       api
                           .columns()
                           .eq(0)
                           .each(function(colIdx) {
                               // Set the header cell to contain the input element
                               var cell = $('.filters th').eq(
                                   $(api.column(colIdx).header()).index()
                               );
                               var title = $(cell).text();
                               $(cell).html('<input type="text" class="form-control form-control-sm" placeholder="' + title + '" />');

                               // On every keypress in this input
                               $(
                                       'input',
                                       $('.filters th').eq($(api.column(colIdx).header()).index())
                                   )
                                   .off('keyup change')
                                   .on('change', function(e) {
                                       // Get the search value
                                       $(this).attr('title', $(this).val());
                                       var regexr = '({search})'; //$(this).parents('th').find('select').val();

                                       var cursorPosition = this.selectionStart;
                                       // Search the column for that value
                                       api
                                           .column(colIdx)
                                           .search(
                                               this.value != '' ?
                                               regexr.replace('{search}', '(((' + this.value + ')))') :
                                               '',
                                               this.value != '',
                                               this.value == ''
                                           )
                                           .draw();
                                   })
                                   .on('keyup', function(e) {
                                       e.stopPropagation();

                                       $(this).trigger('change');
                                       $(this)
                                           .focus()[0]
                                           .setSelectionRange(cursorPosition, cursorPosition);
                                   });
                           });
                   },
               });

			   $.ajax({
				   url: "<?=base_url('Laporan_Abnormal/total_temuan')?>",
				   type: 'GET',
				   dataType: 'json', // added data type
				   success: function(res) {
					   $('#badge_total_temuan').text(res['total_temuan'])
				   }
			   });
           });
       </script>

       </html>

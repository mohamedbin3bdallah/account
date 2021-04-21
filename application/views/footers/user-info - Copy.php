<!-- footer content -->
        <footer>
          <div class="pull-right">
            <!--Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>-->
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/nprogress/nprogress.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/iCheck/icheck.min.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/jszip/dist/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/pdfmake/build/vfs_fonts.js"></script>

	<!-- jQuery Smart Wizard -->
    <script src="<?php echo base_url(); ?>gentelella-master/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>gentelella-master/build/js/custom.min.js"></script>
	<script src="<?php echo base_url(); ?>js/users.js"></script>

	<script>
		function mytotal(mcount)
		{
			var salary = $('#usalary'+mcount).val();
			//var submit_form = document.forms.submit_form;
			var submit_form = $('#usalary'+mcount).closest('form');
			var price = submit_form.elements['values['+mcount+'][]'];
			var total = 0;
alert(price);
			if(price.length == null) { if(price.value != 0) total = total + parseFloat(price.value); }
			else
			{
				for (var index = 0; index < price.length; index++) {
					if(price[index].value == '' || isNaN(price[index].value) || Math.sign(price[index].value) === -1) price[index].value = '00.00';
					total = total + parseFloat(price[index].value);
				}
			}
			document.getElementById('total'+mcount).innerHTML = total.toFixed(2);
			document.getElementById('total'+mcount).value = total.toFixed(2);
			if(total != salary)
			{
				$('#total'+mcount).css("background-color", "#F5A9A9");
				document.getElementById('totalMessage'+mcount).innerHTML = 'يجب ان يكون مجموع مفردات المرتب تساوي المرتب';
				$('#submit'+mcount).attr('disabled', 'true');
			}
			else
			{
				$('#total'+mcount).css("background-color", "#eeeeee");
				document.getElementById('totalMessage'+mcount).innerHTML = '';
				$('#submit'+mcount).removeAttr("disabled");
			}
		}

		$(document).ready(function(){
			$('.add').click(function () {
				var mcount = $(this).attr('id');
				$('#mytable'+mcount).append('<tr><td><input type="text" name="salaryitems['+mcount+'][]" class="form-control" required="required"></td><td><input type="text" name="values['+mcount+'][]" class="form-control" placeholder="00.00" maxlength="10" oninput="mytotal('+mcount+')" required="required"/><?php echo ' '.$system->currency; ?></td><td style="text-align:center;"><i class="delete glyphicon glyphicon-remove"></i></td></tr>');
			});
		});

		$(document).ready(function(){
			$('.mytable').on('click', '.delete', function () {
				$(this).closest('tr').remove();
				mytotal();
			});
		});
	</script>

	 <!-- jQuery Smart Wizard -->
    <script>
      $(document).ready(function() {
        $('#wizard').smartWizard();

        $('#wizard_verticle').smartWizard({
          transitionEffect: 'slide'
        });

        $('.buttonNext').addClass('btn btn-success');
        $('.buttonPrevious').addClass('btn btn-primary');
        $('.buttonFinish').addClass('btn btn-default');
      });
    </script>
    <!-- /jQuery Smart Wizard -->

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                /*{
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },*/
              ],
			  'order': [[ 9, 'desc' ]],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->
  </body>
</html>
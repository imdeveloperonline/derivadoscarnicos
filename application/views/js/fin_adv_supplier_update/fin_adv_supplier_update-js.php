		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script>
			
			$(function(){
				$('input[name="quantity"]').change(function(){
					var amount = $('input[name="amount"]').val();
					var quantiy = $('input[name="quantity"]').val();
					var unit_price = amount/quantiy;


					$('input[name="unit_price"]').val(unit_price.toFixed(2));

				});

				$('input[name="amount"]').change(function(){
					var amount = $('input[name="amount"]').val();
					var quantiy = $('input[name="quantity"]').val();
					var unit_price = amount/quantiy;


					$('input[name="unit_price"]').val(unit_price.toFixed(2));

				});
			});
		</script>


		<script>
      		
	      function update_adv_supplier() {

	          var params = {
	          		"id" : $('input[name="id"]').val(),
	                "supplier_id" : $('select[name="supplier"]').val(),
	                "amount" : $('input[name="amount"]').val(),
	                "product_id" : $('select[name="product"]').val(),
	                "quantity" : $('input[name="quantity"]').val(),
	                "date" : $('input[name="date"]').val(),
	                "unit_price" : $('input[name="unit_price"]').val(),
	                "detail" : $('textarea[name="details"]').val()
	            
	          };
	          

	         $.ajax({
	                data:  {data:params},
	                url:   '<?= base_url(); ?>finanzas/update_adv_supplier',
	                type:  'post',
	                beforeSend: function () {
	                        $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
	                },
	                success:  function (response) {
	                        $("#message").remove();
	                        $(response).appendTo('#resultado');
	                        $("#message").hide().fadeIn('slow');
	                        $("#button").html("Registrar");
	                        $("#close").click();

	                },
	                error:function(error){
	                  $("#message").remove();

	                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p>'+JSON.stringify(error)+'</div>').appendTo('#resultado').hide().fadeIn('slow');

	                  $("#button").html("Registrar");
	                  $("#close").click();
	                }
	        });


	      }


	    </script>


	 
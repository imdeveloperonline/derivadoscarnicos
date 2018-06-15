		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
		
		<script>
			
			function set_modal_note(id) {
				var note = $("#note_"+id).data('note');
				$('textarea[name="note_message"]').html(note);
			}

		</script>

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

			$(function(){
				$("select[name='supplier']").change(function(){

					var supplier_id = $("select[name='supplier']").val();

					$.ajax({
		                data:  {supplier_id:supplier_id},
		                url:   '<?= base_url(); ?>finanzas/get_credit_active_by_supplier',
		                type:  'post',
		                success:  function (response) {
		                    $("#message-form").remove();
		                    if(response != 0) {
		                    	$(response).appendTo("#alert-form").hide().fadeIn('fast');
		                    }

		                },
		                error:function(error){
		                  	alert(JSON.stringify(error));
		                }
		        	});

		        	$.ajax({
								url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
								type: 'post',
								data: {supplier_id: supplier_id},
								success : function(response) {
									$('input[name="unit_price"]').val(response);
								},
								error : function (error) {
									alert(JSON.stringify(error));
								}
							});
				})
			})
		</script>

		<script>
			
			function tableReload() {
				
				/* BASIC ;*/
				var responsiveHelper_dt_basic = undefined;
				var responsiveHelper_datatable_fixed_column = undefined;
				var responsiveHelper_datatable_col_reorder = undefined;
				var responsiveHelper_datatable_tabletools = undefined;
				
				var breakpointDefinition = {
					tablet : 1024,
					phone : 480
				};
	
				$('#dt_basic').dataTable({
					"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
					"autoWidth" : true,
			        "oLanguage": {
					    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
					},
					"preDrawCallback" : function() {
						// Initialize the responsive datatables helper once.
						if (!responsiveHelper_dt_basic) {
							responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
						}
					},
					"rowCallback" : function(nRow) {
						responsiveHelper_dt_basic.createExpandIcon(nRow);
					},
					"drawCallback" : function(oSettings) {
						responsiveHelper_dt_basic.respond();
					}
				});
	
			/* END BASIC */
	
			/* TABLETOOLS */
			$('#datatable_tabletools').dataTable({
				
				// Tabletools options: 
				//   https://datatables.net/extensions/tabletools/button_options
				"order": [ 0, "desc" ],
				"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
						"t"+
						"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
				"oLanguage": {
					"sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>',
					"sProcessing":     "Procesando...",
				    "sLengthMenu":     "Mostrar _MENU_ registros",
				    "sZeroRecords":    "No se encontraron resultados",
				    "sEmptyTable":     "Ningún dato disponible en esta tabla",
				    "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
				    "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
				    "sInfoFiltered":   "( filtrado de un total de _MAX_ registros)",
				    "sInfoPostFix":    "",
				    "sUrl":            "",
				    "sInfoThousands":  ",",
				    "sLoadingRecords": "Cargando...",
				    "oPaginate": {
				        "sFirst":    "Primero",
				        "sLast":     "Último",
				        "sNext":     "Siguiente",
				        "sPrevious": "Anterior"
				    },
				    "oAria": {
				        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
				    }
				},		
		        "oTableTools": {
		        	 "aButtons": [
		             "copy",
		             "csv",
		             "xls",
		                {
		                    "sExtends": "pdf",
		                    "sTitle": "Derivados_Carnicos_PDF",
		                    "sPdfMessage": "Exportar PDF",
		                    "sPdfSize": "letter"
		                },
		             	{
	                    	"sExtends": "print",
	                    	"sMessage": "Generado por Derivados Cárnicos <i>(presione Esc para cerrar)</i>"
	                	}
		             ],
		            "sSwfPath": "<?= base_url() ?>assets/js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
		        },
				"autoWidth" : true,
				"preDrawCallback" : function() {
					// Initialize the responsive datatables helper once.
					if (!responsiveHelper_datatable_tabletools) {
						responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
					}
				},
				"rowCallback" : function(nRow) {
					responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
				},
				"drawCallback" : function(oSettings) {
					responsiveHelper_datatable_tabletools.respond();
				}
			});
			
			/* END TABLETOOLS */
			
			}
		</script>

		<script>
			function fillTable() {

				$.ajax({
					url: "<?= base_url() ?>finanzas/get_last_adv_supplier",
					success: function (response) {
						$('#dt_basic').dataTable().fnDestroy();
						$('#datatable_tabletools').dataTable().fnDestroy();
						$(response).appendTo("#tbody");
						tableReload();
						
					}
				});

			}
		</script>

		<script>
      		
	      function new_adv_supplier() { 

	          var params = {

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
	                url:   '<?= base_url(); ?>finanzas/new_adv_supplier',
	                type:  'post',
	                beforeSend: function () {
	                        $("#buttonNewAdv").html("<i class='fa fa-spinner fa-spin'></i>");
	                },
	                success:  function (response) {
	                        $("#message").remove();
	                        $(".dataTables_empty").parent().fadeOut('slow');
	                        $(response).appendTo('#resultado');
	                        $("#message").hide().fadeIn('slow');
	                        $("#buttonNewAdv").html("Registrar");
	                        $("#close").click();

	                },
	                error:function(error){
	                  $("#message").remove();

	                  $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p>'+JSON.stringify(error)+'</div>').appendTo('#resultado').hide().fadeIn('slow');

	                  $("#buttonNewAdv").html("Registrar");
	                  $("#close").click();
	                }
	        });


	      }


	    </script>

	    <script>
	    	
	    	function set_modal(id) {
	    		$("input[name='archived_id']").val(id);
	    	}
	    </script>

	    <script>
	    	function archived() {
	    		var params = {
	    			"id" : $("input[name='archived_id']").val()
	    		};
	    		var id = $("input[name='archived_id']").val();
	    		
	    		$.ajax({
	    			data: {data:params},
	    			url : "<?= base_url() ?>finanzas/archivar",
	    			type: "post",
	    			success : function(response) {
	    				$("#message").remove();
                        $(response).appendTo('#resultado');
                        $("#message").hide().fadeIn('slow');
                        $("#close-archived-modal").click();
                        $("#tr_"+id).fadeOut('slow');
                      	$("#tr_"+id+"+ tr.row-detail").fadeOut('slow');
	    			},
	    			error : function(error) {
	    				$("#message").remove();

	                  	$('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

	                  	$("#close-archived-modal").click();

	    			}
	    		});
	    	}
	    </script>
			<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

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
					url: "<?= base_url() ?>regionales/get_last_regional",
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
			
			function new_regional() {

				var params = {

		                "name" : $('input[name="name"]').val(),
		                "city_id" : $('select[name="city"]').val()
		        };

				$.ajax({
                      data:  {data:params},
                      url:   '<?= base_url(); ?>regionales/set_new_regional',
                      type:  'post',
                      beforeSend: function () {
                      	$("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
                      success:  function (response) {
              			$("#close").click();
                      	$("#message").remove();
	                    $(".dataTables_empty").parent().fadeOut('slow');
                      	$(response).appendTo('#resultado');
                      	$("#message").hide().fadeIn('slow');
                      	$("#button").html("Registrar");

                      },
                      error:function(error){
                		$("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');
                        $("#close").click();
                        $("#button").html("Registrar");
                      }
				});
			}
		</script>

		<script>
			
			function set_modal (id) {
				$('input[name="regional_delete"]').val(id);
				
			}
		</script>

		<script>
			
			function delete_regional() {        
				
		        var params = {
		          "id" : $('input[name="regional_delete"]').val()
		        }

		        var n = $('input[name="regional_delete"]').val();

		        $.ajax({
		              data:  params,
		              url:   '<?= base_url(); ?>regionales/delete_regional',
		              type:  'post',
		              success:  function (response) {
		                      $("#message").remove();
		                      $(response).appendTo('#resultado');
		                      $("#message").hide().fadeIn('slow');
		                      $("#close-delete").click();
		                      $("#tr_"+n).fadeOut('slow');
		                      $("#tr_"+n+"+ tr.row-detail").fadeOut('slow');
		              },
		              error:function(error){
		                $("#message").remove();

		                $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');

		                $("#close-delete").click();
		              }
		        });

		      }
		</script>
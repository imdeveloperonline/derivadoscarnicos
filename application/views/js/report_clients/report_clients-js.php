	<!-- DATATABLES -->
	<script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	<script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

	<!-- FORMS -->
	<script src="<?= base_url() ?>assets/js/plugin/jquery-form/jquery-form.min.js"></script>

	<script>
			
		function send_form() {

			var params = {

	                "startdate" : $('input[name="startdate"]').val(),
	                "finishdate" : $('input[name="finishdate"]').val(),
	                "client_id" : $('select[name="client"]').val()
	        };

			$.ajax({
                  data:  {data:params},
                  url:   '<?= base_url(); ?>reportes/get_client_report',
                  type:  'post',
                  beforeSend: function () {
                  	$("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                  	$("#loading").html("<i class='fa fa-spinner fa-spin fa-4x'></i>");
                  },
                  success:  function (response) {
                  	$("#loading").html(" ");
                  	$("#report").html(response).hide().fadeIn('slow');
                  	$("#button").html("Generar reporte");

                  },
                  error:function(error){

                    $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p>'+JSON.stringify(error)+'</div>').appendTo('#resultado').hide().fadeIn('slow');
                    $("#button").html("Generar reporte");
                  }
			});
		}
	</script>

	<script>
		
		function tableReload(id) {
			$('#datatable_tabletools_'+id).dataTable().fnDestroy();
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
		$('#datatable_tabletools_'+id).dataTable({
			
			// Tabletools options: 
			//   https://datatables.net/extensions/tabletools/button_options
			"order": [ 0, "asc" ],
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
					responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools_'+id), breakpointDefinition);
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
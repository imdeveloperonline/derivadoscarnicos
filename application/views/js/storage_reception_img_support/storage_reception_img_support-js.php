		<!-- PAGE RELATED PLUGIN(S) -->
		<script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

		<script>

			function fillImg(file_name) {

				var url = "<?= base_url() ?>assets/supports/receptions/"+file_name;

				$("#fullimg").html('<i class="fa fa-spinner fa-spin fa-3x" style="display: block; margin-left: auto; margin-right: auto;"></i>');
				setTimeout(function(){
					$("#fullimg").html('<img src="'+url+'" style="max-width: 100%; max-height: 360px; display: block; margin-left: auto; margin-right: auto;">').hide().fadeIn(400);
				},1500)
			}

		</script>



		<script>
			 $(function() {
			  $('#file').change(function(e) {
			      addImage(e); 
			     });

			     function addImage(e){
			      var file = e.target.files[0],
			      imageType = /image.*/;
			    
			      if (!file.type.match(imageType))
			       return;
			  
			      var reader = new FileReader();
			      reader.onload = fileOnload;
			      reader.readAsDataURL(file);
			     }
			  
			     function fileOnload(e) {
			      var result=e.target.result;
			      $('#imgSalida').attr("src",result);
			     }
			    });
			
		</script>

		<script>

      		
	      function new_support() { 

	      		var formData = new FormData();
				formData.append('file', $('#file')[0].files[0]);
				formData.append('title', $('#title').val());
				formData.append('description', $('#description').val());
				
				$.ajax({
					url  :'<?= base_url() ?>bodega/set_reception_support', 
					type : 'POST',
			       data : formData,
			       processData: false,  
			       contentType: false,
			       beforeSend: function () {
                              $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
                      },
					success	: function (response)
					{
						$("#close").click();
                      	$("#message").remove();
	                    $(".dataTables_empty").parent().fadeOut('slow');
                      	$(response).appendTo('#resultado');
                      	$("#message").hide().fadeIn('slow');
                      	$("#button").html("Registrar");
					},
					error : function (error){
						$("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p></div>').appendTo('#resultado').hide().fadeIn('slow');
                        $("#close").click();
                        $("#button").html("Registrar");
					}
				});

	      }


	    </script>
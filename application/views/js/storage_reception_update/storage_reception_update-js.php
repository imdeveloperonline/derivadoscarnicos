    <!-- PAGE RELATED PLUGIN(S) -->
    <script src="<?= base_url() ?>assets/js/plugin/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.colVis.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.tableTools.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>


    <script> 
      
      function set_modal(id) {
        var note = $("#note_"+id).data('note');
        $('textarea[name="note_message"]').html(note);
      }

    </script>
    <script>
      
      $(function(){
        var ini_rest = parseFloat($('input[name="rest"]').val());
        var ini_quantity = parseFloat($('input[name="quantity"]').val());
        rest = ini_rest + ini_quantity;

        $('select[name="advance_supplier_id"]').change(function(){
          
          var params = {
            "advance_id" : $('select[name="advance_supplier_id"]').val(),
            "reception_id" : $('input[name="reception_id"]').val()

          }
          /*var id = $('select[name="advance_supplier_id"]').val();*/
          $.ajax({
            data: params,
            url: "<?= base_url() ?>finanzas/get_rest_advance_exclude_this",
            type: "post",
            success: function(response) {
              
              rest = response;

              if($('input[name="quantity"]').val() != ""){

                var quantity = $('input[name="quantity"]').val();
                var reception_rest = rest-quantity;

                if(reception_rest < 0) {
                  $('input[name="rest"]').css("color","red");
                } else {
                  $('input[name="rest"]').removeAttr("style");
                }

                $('input[name="rest"]').val(reception_rest.toFixed(2));

              } else {
                $('input[name="rest"]').val(response);
              }
              
            },
            error: function(error) {
              $("#message").remove();

                        $('<div class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>No pudimos obtener la CANTIDAD FALTANTE del servidor. Recargaremos la página para intentar corregirlo</p></div>').appendTo('#resultado').hide().fadeIn('slow');

                        $("#close").click();
            }

          });
        });

/*        $('input[name="quantity"]').change(function(){
          
          if(rest == null || rest == ""){
            rest = 0;
          }
          var quantity = $('input[name="quantity"]').val();
          var reception_rest = rest-quantity;

          if(reception_rest < 0) {
            $('input[name="rest"]').css("color","red");
          } else {
            $('input[name="rest"]').removeAttr("style");
          }


          $('input[name="rest"]').val(reception_rest.toFixed(2));

        });*/
      });
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

   <!--  <script>
      $('select[name="method"]').change(function() {

        var method = $('select[name="method"]').val();

        if(method == 3) {
          
          var supplier = $('select[name="supplier"]').valid();
          
          if(supplier != false) {

            var supplier_id = $('select[name="supplier"]').val();
            
            $.ajax({
              url: '<?= base_url() ?>finanzas/get_adv_by_supplier',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {
                $('select[name="advance_supplier_id"]').html(response);
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });
            
            if($('.advance').css("display") == "none") {
              $('select[name="advance_supplier_id"]').prop("disabled",false);
              $('input[name="quantity"]').prop("disabled",false);
              $('input[name="rest"]').prop("disabled",false);
              $('input[name="date"]').prop("disabled",false);
              $('.advance').toggle(250);
            }

          } 

          if($('.credit').css("display") != "none") {
            $('select[name="product"]').prop("disabled",true);
            $('input[name="quantity_credit"]').prop("disabled",true);
            $('input[name="amount_credit"]').prop("disabled",true);
            $('input[name="date_credit"]').prop("disabled",true);
            $('.credit').toggle(250);
          }
        } else {
          if($('.credit').css("display") == "none"){
            $('select[name="product"]').prop("disabled",false);
            $('input[name="quantity_credit"]').prop("disabled",false);
            $('input[name="amount_credit"]').prop("disabled",false);
            $('input[name="date_credit"]').prop("disabled",false);
            $('.credit').toggle(250);
          }

          if($('.advance').css("display") != "none") {
            $('select[name="advance_supplier_id"]').prop("disabled",true);
            $('input[name="quantity"]').prop("disabled",true);
            $('input[name="rest"]').prop("disabled",true);
            $('input[name="date"]').prop("disabled",true);
            $('.advance').toggle(250);
          }
        }
      });

      $('select[name="supplier"]').change(function(){

        var supplier_id = $('select[name="supplier"]').val();

        if($('select[name="method"]').val() == 3) {
            
          $.ajax({
            url: '<?= base_url() ?>finanzas/get_adv_by_supplier',
            type: 'post',
            data: {supplier_id: supplier_id},
            success : function(response) {
              $('select[name="advance_supplier_id"]').html(response);
            },
            error : function (error) {
              alert(JSON.stringify(error));
            }
          });
          
          if($('.advance').css("display") == "none") {
            $('.advance').toggle(250);
          }
        }
            
        $.ajax({
          url: '<?= base_url() ?>proveedores/get_supplier_shambles_by_regional',
          type: 'post',
          data: {supplier_id: supplier_id},
          success : function(response) {
            
            $('select[name="shamble"]').html(response);
          },
          error : function (error) {
            alert(JSON.stringify(error));
          }
        });
        if($('.shamble').css("display") == "none") {
          $('.shamble').toggle(250);
        }
      });
    </script> -->

    <script>
      function fillTable() {

        $.ajax({
          url: "<?= base_url() ?>bodega/get_last_reception",
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

          
        function update_reception() {
           
          var method = $('select[name="method"]').val();
          var reception_amount = stringToNumber($("input[name='unit_price']").val()) * stringToNumber($("input[name='quantity']").val());
         
          var shamble_amount = stringToNumber($('input[name="shamble_amount"]').val());
          if(shamble_amount == "") {
            shamble_amount = 0;
          } 
          
          if(method == 3) {
            var params = {
              "reception_id" : $('input[name="reception_id"]').val(),
              "supplier_id" : $('select[name="supplier"]').val(),
              "method_id" : method,
              "quantity" : stringToNumber($('input[name="quantity"]').val()),
              "date" : $('input[name="date"]').val(),
              "brand" : $('textarea[name="brand"]').val(),
              "note" : $('textarea[name="note"]').val(),
              "shamble_id" : $('select[name="shamble"]').val(),
              "shamble_amount" : shamble_amount,
              "unit_price" : stringToNumber($("input[name='unit_price']").val()),
              "adv_balance_ini" : adv_balance_ini,
              "reception_amount" : reception_amount,
              "product_id" : $("select[name='product']").val()
            }
          } else {
            var params = {
              "reception_id" : $('input[name="reception_id"]').val(),
              "supplier_id" : $('select[name="supplier"]').val(),
              "method_id" : method,
              "product_id" : $('select[name="product_credit"]').val(),
              "reception_amount" : stringToNumber($('input[name="amount_credit"]').val()),
              "unit_price" : stringToNumber($("input[name='unit_price']").val()),
              "quantity" : stringToNumber($('input[name="quantity_credit"]').val()),
              "date" : $('input[name="date_credit"]').val(),
              "brand" : $('textarea[name="brand"]').val(),
              "note" : $('textarea[name="note"]').val(),
              "shamble_id" : $('select[name="shamble"]').val(),
              "shamble_amount" : shamble_amount,
              "advance_supplier_id" : $('input[name="advance_supplier_id"]').val()
            }
          }
          
          $.ajax({
              data:  {data:params},
              url:   '<?= base_url(); ?>bodega/update_reception',
              type:  'post',
              beforeSend: function () {
                      $("#button").html("<i class='fa fa-spinner fa-spin'></i>");
              },
              success:  function (response) {
                      $("#message").remove();
                      $(response).appendTo('#resultado');
                      $("#message").hide().fadeIn('slow');
                      $("#button").html("Guardar Cambios");
              },
              error:function(error){
                $("#message").remove();

                $('<div id="message" class="alert alert-block alert-danger"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-times-circle"></i> ¡Error: 500!</h4><p>Ocurrió un error al comunicarse con el servidor.</p>'+JSON.stringify(error)+'</div>').appendTo('#resultado').hide().fadeIn('slow');

                $("#button").html("Guardar Cambios");
                $("#close").click();
              }
          });


        }


      </script>

     <script type="text/javascript">
          $(function(){
            $.ajax({
                url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
                type: 'post',
                data: {supplier_id: supplier_id_ini},
                success : function(response) {
                  $('input[name="unit_price"]').val(numberToString(response));
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });

              $.ajax({
                url: '<?= base_url() ?>finanzas/get_supplier_balance',
                type: 'post',
                data: {supplier_id: supplier_id_ini},
                success : function(response) {
                  var unit_price = stringToNumber($('input[name="unit_price"]').val());
                  if(method_id == 3){
                    quantity_ini = stringToNumber($('input[name="quantity"]').val());
                    adv_balance_ini = parseFloat(response) + parseFloat((unit_price*quantity_ini));
                    if(adv_balance_ini < 0) {
                      $("input[name='adv_balance']").css("color","red");
                    }
                  } else {
                    quantity_ini = stringToNumber($('input[name="quantity_credit"]').val());
                    adv_balance_ini = parseFloat(response);
                  }
                  
                  $("input[name='adv_balance']").val(numberToString(response));
                  
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });

          })
     </script>


  <!--=========================================
  =            Start New Functions            =
  ==========================================-->
  
  <script type="text/javascript">
       
      $('select[name="method"]').change(function() {

        $("#message-form").fadeOut(250).remove();

        var method = $('select[name="method"]').val();

        if(method == 3) {
          
          var supplier = $('select[name="supplier"]').valid();
          
          if(supplier != false) {

            var supplier_id = $('select[name="supplier"]').val();
            
            $.ajax({
              url: '<?= base_url() ?>finanzas/get_supplier_balance',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {
                adv_balance = response;
                $("input[name='adv_balance']").val(numberToString(response));
                if(adv_balance < 0) {
                   $("input[name='adv_balance']").css("color","red");
                }
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });

            $.ajax({
              url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {
                $('input[name="unit_price"]').val(numberToString(response));
                $("select[name='product']").select2();
                $("select[name='product']").val(1);
                $("select[name='product']").find('option[value="1"]').prop('selected', true).change();
                $("select[name='product_advance']").select2();
                $("select[name='product_advance']").val(1);
                $("select[name='product_advance']").find('option[value="1"]').prop('selected', true).change();
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });
            
            if($('.advance').css("display") == "none") {
              $('select[name="advance_supplier_id"]').prop("disabled",false);
              $('input[name="quantity"]').prop("disabled",false);
              $('input[name="adv_balance"]').prop("disabled",false);
              $('input[name="date"]').prop("disabled",false);
              $('.advance').toggle(250);
            }

          } 

          if($('.unit_price').css("display") == "none") {
            $('.unit_price').toggle(250);
          }

          if($('.credit').css("display") != "none") {
            $('select[name="product"]').prop("disabled",true);
            $('input[name="quantity_credit"]').prop("disabled",true);
            $('input[name="amount_credit"]').prop("disabled",true);
            $('input[name="date_credit"]').prop("disabled",true);
            $('.credit').toggle(250);
          }
        } 
        else {

          var supplier = $('select[name="supplier"]').valid();
          
          if(supplier != false) {

            var supplier_id = $('select[name="supplier"]').val();

            if(method == 2) {
            
              $.ajax({
                url: '<?= base_url() ?>finanzas/get_supplier_balance',
                type: 'post',
                data: {supplier_id: supplier_id},
                success : function(response) {
                  $("#message-form").remove();
                  if(response > 0) {
                     $('<div id="message-form" class="alert alert-block alert-warning"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Alerta</h4><p>Este proveedor tiene saldo de '+response+' COP en anticipos.</p></div>').appendTo('#form-alert').hide().fadeIn('slow');
                  } 
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });
            }
            
            $.ajax({
              url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {
                $('input[name="unit_price"]').val(numberToString(response));
                $("select[name='product']").select2();
                $("select[name='product']").val(1);
                $("select[name='product']").find('option[value="1"]').prop('selected', true).change();
                $("select[name='product_advance']").select2();
                $("select[name='product_advance']").val(1);
                $("select[name='product_advance']").find('option[value="1"]').prop('selected', true).change();
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });

            if($('.unit_price').css("display") == "none") {
              $('.unit_price').toggle(250);
            }
            
            if($('.advance').css("display") != "none") {
              $('select[name="advance_supplier_id"]').prop("disabled",true);
              $('input[name="quantity"]').prop("disabled",true);
              $('input[name="adv_balance"]').prop("disabled",true);
              $('input[name="date"]').prop("disabled",true);
              $('.advance').toggle(250);
            }

            if($('.credit').css("display") == "none") {
              $('select[name="product"]').prop("disabled",false);
              $('input[name="quantity_credit"]').prop("disabled",false);
              $('input[name="amount_credit"]').prop("disabled",false);
              $('input[name="date_credit"]').prop("disabled",false);
              $('.credit').toggle(250);
            }

          } 

          
        }



      });




      $('select[name="supplier"]').change(function(){

        var supplier_id = $('select[name="supplier"]').val();

        if($('select[name="method"]').val() == 3) {
            
          $.ajax({
            url: '<?= base_url() ?>finanzas/get_supplier_balance',
            type: 'post',
            data: {supplier_id: supplier_id},
            success : function(response) {
              adv_balance = response;
              $("input[name='adv_balance']").val(numberToString(response));
              if(adv_balance < 0) {
                 $("input[name='adv_balance']").css("color","red");
              }
            },
            error : function (error) {
              alert(JSON.stringify(error));
            }
          });

          $.ajax({
            url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
            type: 'post',
            data: {supplier_id: supplier_id},
            success : function(response) {
              $('input[name="unit_price"]').val(numberToString(response));
              $("select[name='product']").select2();
              $("select[name='product']").val(1);
              $("select[name='product']").find('option[value="1"]').prop('selected', true).change();
              $("select[name='product_advance']").select2();
              $("select[name='product_advance']").val(1);
              $("select[name='product_advance']").find('option[value="1"]').prop('selected', true).change();
            },
            error : function (error) {
              alert(JSON.stringify(error));
            }
          });
          
          if($('.advance').css("display") == "none") {
            $('select[name="advance_supplier_id"]').prop("disabled",false);
            $('input[name="quantity"]').prop("disabled",false);
            $('input[name="adv_balance"]').prop("disabled",false);
            $('input[name="date"]').prop("disabled",false);
            $('.advance').toggle(250);
          }
        }
            
        $.ajax({
          url: '<?= base_url() ?>proveedores/get_supplier_shambles_by_regional',
          type: 'post',
          data: {supplier_id: supplier_id},
          success : function(response) {
            
            $('select[name="shamble"]').html(response);
          },
          error : function (error) {
            alert(JSON.stringify(error));
          }
        });
        if($('.shamble').css("display") == "none") {
          $('.shamble').toggle(250);
        }


        /*
        Funciones relacionadas al método seleccionado
         */
        
        var method = $('select[name="method"]').val();
        if(method != null && method != "") {
          
          $("select[name='supplier']").valid();
          if(method == 3) {   
            $("#message-form").fadeOut(250).remove();     

            var supplier_id = $('select[name="supplier"]').val();
            
            $.ajax({
              url: '<?= base_url() ?>finanzas/get_adv_by_supplier',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {
                $('select[name="advance_supplier_id"]').html(response);
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });
            
            if($('.advance').css("display") == "none") {
              $('select[name="advance_supplier_id"]').prop("disabled",false);
              $('input[name="quantity"]').prop("disabled",false);
              $('input[name="adv_balance"]').prop("disabled",false);
              $('input[name="date"]').prop("disabled",false);
              $('.advance').toggle(250);
            }           

            if($('.credit').css("display") != "none") {
              $('select[name="product"]').prop("disabled",true);
              $('input[name="quantity_credit"]').prop("disabled",true);
              $('input[name="amount_credit"]').prop("disabled",true);
              $('input[name="date_credit"]').prop("disabled",true);
              $('.credit').toggle(250);
            }
          } 
          else {
            

            var supplier_id = $('select[name="supplier"]').val();

            if(method == 2) {
            
              $.ajax({
                url: '<?= base_url() ?>finanzas/get_supplier_balance',
                type: 'post',
                data: {supplier_id: supplier_id},
                success : function(response) {
                  $("#message-form").remove();
                  if(response > 0) {
                     $('<div id="message-form" class="alert alert-block alert-warning"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Alerta</h4><p>Este proveedor tiene saldo de '+numberToString(response)+' COP en anticipos.</p></div>').appendTo('#form-alert').hide().fadeIn('slow');
                  } 
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });
            }
            
            $.ajax({
              url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
              type: 'post',
              data: {supplier_id: supplier_id},
              success : function(response) {                
                $('input[name="unit_price"]').val(numberToString(response));
                $("select[name='product']").select2();
                $("select[name='product']").val(1);
                $("select[name='product']").find('option[value="1"]').prop('selected', true).change();
                $("select[name='product_advance']").select2();
                $("select[name='product_advance']").val(1);
                $("select[name='product_advance']").find('option[value="1"]').prop('selected', true).change();
              },
              error : function (error) {
                alert(JSON.stringify(error));
              }
            });

            if($('.unit_price').css("display") == "none") {
              $('.unit_price').toggle(250);
            }
            
            if($('.advance').css("display") != "none") {
              $('select[name="advance_supplier_id"]').prop("disabled",true);
              $('input[name="quantity"]').prop("disabled",true);
              $('input[name="adv_balance"]').prop("disabled",true);
              $('input[name="date"]').prop("disabled",true);
              $('.advance').toggle(250);
            }

            if($('.credit').css("display") == "none") {
              $('select[name="product"]').prop("disabled",false);
              $('input[name="quantity_credit"]').prop("disabled",false);
              $('input[name="amount_credit"]').prop("disabled",false);
              $('input[name="date_credit"]').prop("disabled",false);
              $('.credit').toggle(250);
            }

          } 
        }
      });

     $('input[name="quantity_credit"]').change(function(){
            var quantity_credit = stringToNumber($('input[name="quantity_credit"]').val());
            var unit_price = stringToNumber($('input[name="unit_price"]').val());

            var amount_credit = quantity_credit*unit_price;
             $("input[name='amount_credit']").val(numberToString(amount_credit));
     });

    $('input[name="quantity"]').change(function(){
      
          
          if(typeof adv_balance_ini != "undefined") {

            var quantity = stringToNumber($('input[name="quantity"]').val());
            var unit_price = stringToNumber($('input[name="unit_price"]').val());
            var new_balance = adv_balance_ini - (quantity*unit_price);

            if(new_balance < 0) {
              $('input[name="adv_balance"]').css("color","red");
            } else {
              $('input[name="adv_balance"]').removeAttr("style");
            }

            if(new_balance == 100000 || new_balance < 100000) {
              $("#form-alert").html('<div id="message-form" class="alert alert-block alert-info"><a class="close" data-dismiss="alert" href="#">×</a><h4 class="alert-heading"><i class="fa fa-exclamation-triangle"></i> Alerta</h4><p>El saldo del proveedor es igual o menos a 100.000 COP. Debe ser informado al administrador.</p></div>').hide().fadeIn('slow');
            } else {
              $("#message-form").fadeOut(250).remove();
            }


            $('input[name="adv_balance"]').val(numberToString(new_balance.toFixed(2)));
          } else {
            var valid = $('select[name="supplier"]').valid();

            if(valid != false) {

              var supplier_id = $('select[name="supplier"]').val();

              $.ajax({
                url: '<?= base_url() ?>finanzas/get_supplier_balance',
                type: 'post',
                data: {supplier_id: supplier_id},
                success : function(response) {
                  var unit_price = stringToNumber($('input[name="unit_price"]').val());
                  if(method_id == 3){
                    quantity_ini = stringToNumber($('input[name="quantity"]').val());
                    adv_balance_ini = parseFloat(response) + parseFloat((unit_price*quantity_ini));
                  } 
                  
                  $("input[name='adv_balance']").val(numberToString(response));
                  
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });

              $.ajax({
                url: '<?= base_url() ?>finanzas/get_precio_unitario_supplier',
                type: 'post',
                data: {supplier_id: supplier_id},
                success : function(response) {
                  $('input[name="unit_price"]').val(numberToString(response));
                },
                error : function (error) {
                  alert(JSON.stringify(error));
                }
              });
            } 
          }
          

        
      });

  </script>
  
  <!--====  End of Section comment  ====-->
  
  
     

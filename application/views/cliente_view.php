<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Clientes</title>
    <link href="<?php echo base_url('public/bootstrap/css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/datatables/css/dataTables.bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?php echo base_url('public/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')?>" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

    <div class="container">
        <h1 style="font-size:20pt">CRUD Clientes</h1>

        <h3>Client Data</h3>
        <br />
        <button class="btn btn-success" onclick="add_cliente()"><i class="glyphicon glyphicon-plus"></i> Añadir Cliente</button>
        <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Recargar</button>
        <br />
        <br />
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Identificaci&oacute;n</th>
                    <th>Nombre</th>
                    <th>Tel&eacute;fono</th>
                    <th>Celular</th>
                    <th>Direcci&oacute;n</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th style="width:125px;">Acci&oacute;n</th>
                </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>Identificaci&oacute;n</th>
                <th>Nombre</th>
                <th>Tel&eacute;fono</th>
                <th>Celular</th>
                <th>Direcci&oacute;n</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Acci&oacute;n</th>
            </tr>
            </tfoot>
        </table>
    </div>

    <script src="<?php echo base_url('public/jquery/jquery-3.2.1.min.js')?>"></script>
    <script src="<?php echo base_url('public/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('public/datatables/js/jquery.dataTables.min.js')?>"></script>
    <script src="<?php echo base_url('public/datatables/js/dataTables.bootstrap.min.js')?>"></script>
    <script src="<?php echo base_url('public/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>"></script>

    <script type="text/javascript">
        var save_method; //for save method string
        var table;

        $(document).ready(function() {

            //datatables
            table = $('#table').DataTable({ 

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('cliente/ajax_list')?>",
                    "type": "POST"
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ -1 ], //last column
                    "orderable": false, //set not orderable
                },
                ],

            });

            //set input/textarea/select event when change value, remove class error and remove text help block 
            $("input").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("textarea").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });
            $("select").change(function(){
                $(this).parent().parent().removeClass('has-error');
                $(this).next().empty();
            });

        });

        function reload_table()
        {
            table.ajax.reload(null,false); //reload datatable ajax 
        }

        function add_cliente()
        {
            save_method = 'add';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            $('#modal_form').modal('show'); // show bootstrap modal
            $('.modal-title').text('Añadir Cliente'); // Set Title to Bootstrap modal title
        }

        function edit_cliente(id)
        {
            save_method = 'update';
            $('#form')[0].reset(); // reset form on modals
            $('.form-group').removeClass('has-error'); // clear error class
            $('.help-block').empty(); // clear error string
            
            //Ajax Load data from ajax
            $.ajax({
                url : "<?php echo site_url('cliente/ajax_edit/')?>/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {

                    $('[name="id"]').val(data.id);
                    $('[name="identificacion"]').val(data.identificacion);
                    $('[name="nombre"]').val(data.nombre);
                    $('[name="telefono"]').val(data.telefono);
                    $('[name="celular"]').val(data.celular);
                    $('[name="direccion"]').val(data.direccion);
                    $('[name="email"]').val(data.email);
                    $('[name="tipo"]').val(data.tipo);
                    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                    $('.modal-title').text('Editar Cliente'); // Set title to Bootstrap modal title

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error get data from ajax');
                }
            });
        }


        function save()
        {
            $('#btnSave').text('saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            var url;

            if(save_method == 'add') {
                url = "<?php echo site_url('cliente/ajax_add')?>";
            } else {
                url = "<?php echo site_url('cliente/ajax_update')?>";
            }

            // ajax adding data to database
            $.ajax({
                url : url,
                type: "POST",
                data: $('#form').serialize(),
                dataType: "JSON",
                success: function(data)
                {

                    if(data.status) //if success close modal and reload ajax table
                    {
                        $('#modal_form').modal('hide');
                        reload_table();
                    }
                    else
                    {
                        for (var i = 0; i < data.inputerror.length; i++) 
                        {
                            $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                            $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                        }
                    }
                    $('#btnSave').text('Guardar'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 


                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Error adding / update data');
                    $('#btnSave').text('Guardar'); //change button text
                    $('#btnSave').attr('disabled',false); //set button enable 

                }
            });
        }

        function delete_cliente(id)
        {
            if(confirm('¿Estás seguro de borrar estos datos?'))
            {
                // ajax delete data to database
                $.ajax({
                    url : "<?php echo site_url('cliente/ajax_delete')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data)
                    {
                        //if success reload ajax table
                        $('#modal_form').modal('hide');
                        reload_table();
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });

            }
        }

    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title">Formulario de Cliente</h3>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id"/> 
                        <div class="form-body">
                            
                            <div class="form-group">
                                <label class="control-label col-md-3">Identificaci&oacute;n</label>
                                <div class="col-md-9">
                                    <input name="identificacion" placeholder="Identificaci&oacute;n" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Nombre</label>
                                <div class="col-md-9">
                                    <input name="nombre" placeholder="Nombre" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Celular</label>
                                <div class="col-md-9">
                                    <input name="celular" placeholder="Celular" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tel&eacute;fono</label>
                                <div class="col-md-9">
                                    <input name="telefono" placeholder="Tel&eacute;fono" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Direcci&oacute;n</label>
                                <div class="col-md-9">
                                    <textarea name="direccion" placeholder="Direcci&oacute;n" class="form-control"></textarea>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-9">
                                    <input name="email" placeholder="Email" class="form-control" type="text">
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Tipo</label>
                                <div class="col-md-9">
                                    <select name="tipo" class="form-control">
                                        <option value="">--Seleccionar Tipo--</option>
                                        <option value="Natural">Natural</option>
                                        <option value="Juridico">Juridico</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>  
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->
</body>
</html>
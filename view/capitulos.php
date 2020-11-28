<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('./layout/head.php'); ?>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- start header -->
        <?php include('./layout/header.php') ?>
        <!-- end header -->
        <!-- start menu -->
        <?php include('./layout/menu.php') ?>
        <!-- end menu -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content">

                <!-- modal nuevo ingeniero  -->
                <div class="row">
                    <div class="modal fade" id="confirmar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-indent">
                                        </i> Registrar Capitulo y/o Especialidad
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="Capitulo">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Capitulo" class="form-control">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="Condición">Nuevo </label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="cbTramite" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="txtCapitulo">Capitulo: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtCapitulo" type="text" name="txtCapitulo" class="form-control" placeholder="Dijite el nuevo Capitulo" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="txtEspecialidad">Especialidad: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="txtEspecialidad" type="text" name="txtEspecialidad" class="form-control" placeholder="Dijite la nueva Especialidad" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="chx_Especialidad">Nuevo </label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" id="chx_Especialidad" checked>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="cbxEspecialidad">Especialidad: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="cbxEspecialidad" class="form-control">
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-warning" name="btnaceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end modal new enginner -->

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-warning" style="margin-right: 10px;" data-toggle="modal" data-target="#confirmar" id="btnNuevo" >
                            <i class="fa fa-plus"></i> Nuevo Capitulo y/o Especialidad
                        </button>
                        <button class="btn btn-link" id="btnactualizar">
                            <i class="fa fa-refresh"></i> Actualizar..
                        </button>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-right: -10px;">
                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="search" id="buscar" class="form-control" placeholder="Buscar por Capitulo o Especialidad" aria-describedby="search" value="" style="border-radius: 5px;">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <button class="btn btn-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>

                </div>
                <hr style="margin-top: 5px;">
                <div class="row" style="margin-top: -5px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <th style="text-align: center;">#</th>
                                <th>Capitulo</th>
                                <th>Especialidad</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody id="tbTable">

                            </tbody>

                        </table>
                        <div class="col-md-12" style="text-align:center;">
                            <ul class="pagination">
                                <li>
                                    <button class="btn btn-primary" id="btnIzquierda">
                                        <i class="fa fa-toggle-left"></i>
                                    </button>
                                </li>
                                <li>
                                    <span id="lblPaginaActual" class="font-weight-bold">0</span>
                                </li>
                                <li><span>a</span></li>
                                <li>
                                    <span id="lblPaginaSiguiente" class="font-weight-bold">0</span>
                                </li>
                                <li>
                                    <button class="btn btn-primary" id="btnDerecha">
                                        <i class="fa fa-toggle-right"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- start footer -->

        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
    <script>
        let state = false;
        let opcion = 0;
        let totalPaginacion = 0;
        let paginacion = 0;
        let filasPorPagina = 10;
        let tbTable = $("#tbTable");
        let cbxCapitulos = $("#Capitulo");
        let cbxEspecialidad = $("#cbxEspecialidad")

        $(document).ready(function() {

            loadInitCapitulos();

            $("#btnIzquierda").click(function() {
                if (!state) {
                    if (paginacion > 1) {
                        paginacion--;
                        onEventPaginacion();
                    }
                }
            });

            $("#btnDerecha").click(function() {
                if (!state) {
                    if (paginacion < totalPaginacion) {
                        paginacion++;
                        onEventPaginacion();
                    }
                }
            });

            // $("#cbTramite").on("change", function() {
            //     $("#Codigo").prop("disabled", this.checked);
            // });

            $("#btnactualizar").click(function() {
                loadInitCapitulos()
            });

            $("#buscar").on("keyup", function(event) {
                if (event.keyCode === 13) {
                    paginacion = 1;
                    loadTableCapitulos($("#buscar").val());
                    opcion = 1;
                }
            });

            $("#btnNuevo").click(function(){
                loadCapitulos()
                loadEspecialidades()
            })

            $("#btnaceptar").click(function() {
                if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                    AlertWarning("Advertencia", "Ingrese un número de dni o ruc correcto por favor.");
                } else if ($("#Nombres").val() == '' || $("#Nombres").val().length < 2) {
                    AlertWarning("Advertencia", "Ingrese un nombre de 3 o mas letras por favor.");
                } else if ($("#Apellidos").val() == '' || $("#Apellidos").val().length < 2) {
                    AlertWarning("Advertencia", "Ingrese un apellido de 3 o mas letras por favor.");
                } else if ($("#Nacimiento").val() == '') {
                    AlertWarning("Advertencia", "Ingrese un fecha de nacimiento por favor.");
                } else if (!$('#cbTramite').is(":checked") && $("#Codigo").val() == '' || !$('#cbTramite').is(":checked") && $("#Codigo").val().length < 4) {
                    AlertWarning("Advertencia", "Ingrese el número cip por favor.");
                } else {
                    insertPersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $("#Genero").val(),
                        $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(), $("#Razon_social").val(),
                        $("#Codigo").val(), $("#Condicion").val());
                }
            });

        });

        function onEventPaginacion() {
            switch (opcion) {
                case 0:
                    loadTableCapitulos("");
                    break;
                case 1:
                    loadTableCapitulos($("#buscar").val());
                    break;
            }
        }

        function loadInitCapitulos() {
            if (!state) {
                paginacion = 1;
                loadTableCapitulos("");
                opcion = 0;
            }
        }



        function loadTableCapitulos(nombres) {
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "alldata",
                    "nombres": nombres,
                    "posicionPagina": ((paginacion - 1) * filasPorPagina),
                    "filasPorPagina": filasPorPagina
                },
                beforeSend: function() {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="10"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                    );
                    state = true;
                },
                success: function(result) {
                    
                    if (result.estado === 1) {
                        tbTable.empty();
                        for (let especialidad of result.especialidades) {

                            let btnUpdate =
                                '<button class="btn btn-success btn-sm" onclick="loadUpdateIngenieros(\'' +
                                especialidad.idEspecialidad + '\')">' +
                                '<i class="fa fa-wrench"></i> Editar' +
                                '</button>';

                            tbTable.append('<tr>' +
                                '<td style="text-align: center;color: #2270D1;">' +
                                '' + especialidad.Id + '' +
                                '</td>' +
                                '<td>' + especialidad.Capitulo + '</td>' +
                                '<td>' + especialidad.Especialidad + '</td>' +
                                '<td>' +
                                '' + btnUpdate + '' +
                                '</td>' +
                                '</tr>');
                        }
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } else {
                        tbTable.empty();
                        tbTable.append(
                            '<tr class="text-center"><td colspan="10"><p>No se pudo cargar la información.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(0);
                        $("#lblPaginaSiguiente").html(0);
                        state = false;
                    }
                },
                error: function(error) {
                    tbTable.empty();
                    tbTable.append(
                        '<tr class="text-center"><td colspan="10"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            });
        }

        function loadCapitulos(){
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "allCapitulos"
                },
                beforeSend: function() {
                    state = true;
                },
                success: function(result) {
                    if (result.estado === 1) {
                        for(let capitulo of result.capitulos){
                            cbxCapitulos.append('<option value='+capitulo.Capitulo+'> '+capitulo.Capitulo+'</option>')
                        }
                        
                        state = false;

                    } else {

                        state = false;
                    }
                },
                error: function(error) {
                    state = false;
                }
            });
        }

        function loadEspecialidades(){
            $.ajax({
                url: "../app/controller/CapituloController.php",
                method: "GET",
                data: {
                    "type": "allEspecialidades"
                },
                beforeSend: function() {
                    state = true
                },
                success: function(result) {
                    console.log(result)
                    if (result.estado === 1) {
                        for(let especialidad of result.especialidades){
                            cbxEspecialidad.append('<option value='+especialidad.Especialidad+'> '+especialidad.Especialidad+'</option>')
                        }
                        
                        state = false;

                    } else {

                        state = false;
                    }
                },
                error: function(error) {
                    state = false;
                }
            });
        }

        function showHistorialIngenieros(idPersona) {
            location.href = "update_ingenieros.php?idPersona=" + idPersona;
        }

        function loadUpdateIngenieros(idPersona) {
            location.href = "update_ingenieros.php?idPersona=" + idPersona;
        }

        function insertPersona(idPersona, nombres, apellidos, sexo, nacimiento, estado_civil, ruc, rason_social, cip,
            condicion) {
            $.ajax({
                url: "../app/controller/PersonaController.php",
                method: "POST",
                data: {
                    "type": "create",
                    "dni": idPersona,
                    "nombres": nombres.toUpperCase(),
                    "apellidos": apellidos.toUpperCase(),
                    "sexo": sexo,
                    "nacimiento": nacimiento,
                    "estado_civil": estado_civil,
                    "ruc": ruc,
                    "rason_social": rason_social,
                    "cip": cip,
                    "condicion": condicion,
                },
                beforeSend: function() {
                    $("#btnaceptar").empty();
                    $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
                },
                success: function(result) {
                    if (result.estado == 1) {
                        AlertSuccess("Mensaje", result.message)
                        setTimeout(function() {
                            location.href = "ingenieros.php"
                        }, 1000);
                    } else {
                        AlertWarning("Mensaje", result.message)
                        setTimeout(function() {
                            $("#btnaceptar").empty();
                            $("#btnaceptar").append('<i class="fa fa-check"></i> Aceptar');
                        }, 1000);
                    }
                },
                error: function(error) {
                    AlertError("Error", error.responseText);
                    $("#btnaceptar").empty();
                    $("#btnaceptar").append('<i class="fa fa-check"></i> Aceptar');
                }
            });
        }

        function AlertSuccess(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["success"](message, title);
        }

        function AlertWarning(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["warning"](message, title);
        }

        function AlertError(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["error"](message, title)
        }

        function AlertInfo(title, message) {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr["info"](message, title)
        }
    </script>
</body>

</html>
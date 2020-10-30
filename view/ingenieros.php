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

                <div class="row">
                    <div class="modal fade" id="confirmar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-user-plus">
                                        </i> Registrar Ingeniero
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">
                                        <!--<input type="hidden" name="Usuario" value="{{ Auth::user()->id }}"> -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="dni">DNI: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="dni" type="number" name="Dni" class="form-control"
                                                        placeholder="DNI" required="" maxlength="8" minlength="8">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Nombres">Nombres: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Nombres" type="text" name="Nombres" class="form-control"
                                                        placeholder="Nombres" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Apellidos">Apellidos: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Apellidos" type="text" name="Apellidos"
                                                        class="form-control" placeholder="Apellidos" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Genero">Genero: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Genero" class="form-control">
                                                        <option>Maculino</option>
                                                        <option>Femenino</option>
                                                        <option>Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Nacimiento">Nacimiento: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Nacimiento" type="date" name="Nacimiento"
                                                        class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="Estado_civil">Estado civil: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Estado_civil" class="form-control">
                                                        <option>Soltero/a</option>
                                                        <option>Casado/a</option>
                                                        <option>Viudo/a</option>
                                                        <option>Divorciado/a</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Ruc">RUC (opcional):</label>
                                                    <input id="Ruc" type="text" name="Ruc" class="form-control"
                                                        placeholder="número de RUC" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Apellidos">Razon social:</label>
                                                    <input id="Apellidos" type="text" name="Apellidos"
                                                        class="form-control" placeholder="Apellidos" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="Codigo">Codigo CIP: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="Codigo" type="number" name="Codigo" class="form-control"
                                                        placeholder="Codigo" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="Condición">Condición: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="Condición" class="form-control">
                                                        <option>Vitalicio</option>
                                                        <option>Otros</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="Condición">Nuevo </label>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox"> Tramite
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i
                                            class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-warning" style="margin-right: 10px;" data-toggle="modal"
                            data-target="#confirmar">
                            <i class="fa fa-plus"></i> Nuevo Ingeniero
                        </button>
                        <a href="#" class="btn btn-link">
                            <i class="fa fa-refresh"></i> Actualizar..
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-right: -10px;">
                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="buscar" class="form-control" placeholder="Buscar Ingeniero..."
                                aria-describedby="search" value="{{ $valbuscar }}" style="border-radius: 5px;">
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
                        <table class="table table-striped"
                            style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <th style="text-align: center;">#</th>
                                <th>DNI</th>
                                <th>Nombres y Apellidos</th>
                                <th>Estado Civil</th>
                                <th>RUC</th>
                                <th>CIP</th>
                                <th>Condicion</th>
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
        <?php include('./layout/footer.php'); ?>;
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

    $(document).ready(function() {

        loadInitVentas();

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

    });

    function onEventPaginacion() {
        switch (opcion) {
            case 0:
                loadTablePersonas();
                break;
        }
    }

    function loadInitVentas() {
        if (!state) {
            paginacion = 1;
            loadTablePersonas();
            opcion = 0;
        }
    }

    function loadTablePersonas() {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                "type":"alldata",
                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                "filasPorPagina": filasPorPagina
            },
            beforeSend: function() {
                tbTable.empty();
                tbTable.append('<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
                state = true;
            },
            success: function(result) {
                if (result.estado === 1) {
                    tbTable.empty();
                    for (let persona of result.personas) {

                        let image = '<img src="images/masculino.png" width="30">';
                        let btnUpdate = '<button class="btn btn-success btn-sm" onclick="loadUpdateIngenieros(\''+persona.idDNI+'\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';

                        tbTable.append('<tr>' +
                            '<td style="text-align: center;color: #2270D1;">' +
                            '' + persona.Id + '' +
                            '</td>' +
                            '<td>' + persona.idDNI + '</td>' +
                            '<td>' + persona.Nombres + ' ' + persona.Apellidos + '</td>' +
                            '<td>' + persona.EstadoCivil + '</td>' +
                            '<td>' + persona.Ruc + '</td>' +
                            '<td>' + persona.Cip+ '</td>' +
                            '<td>' + persona.Condicion+ '</td>' +
                            '<td>' +
                            '' + btnUpdate + '' +
                            '</td>' +
                            '</tr>');

                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    }
                } else {
                    tbTable.empty();
                    tbTable.append('<tr class="text-center"><td colspan="8"><p>No se pudo cargar la información.</p></td></tr>');
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            },
            error: function(error) {
                console.log(error);
                tbTable.empty();
                tbTable.append('<tr class="text-center"><td colspan="8"><p>Se produjo un error, intente nuevamente.</p></td></tr>');
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        });
    }

    function loadUpdateIngenieros(idPersona){
        location.href = "update_ingenieros.php?idPersona="+idPersona;
    }
    </script>
</body>

</html>
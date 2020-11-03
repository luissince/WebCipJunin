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
            <section class="content-header">
                <h3 class="no-margin"> Conceptos de cobros <small> Lista </small> </h3>
            </section>

            <section class="content">

                <!-- Modal -->
                <div class="row">
                    <div class="modal fade" id="confirmar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">
                                        <i class="fa fa-close"></i>
                                    </button>
                                    <h4 class="modal-title">
                                        <i class="fa fa-list-alt">
                                        </i> Registrar Concepto
                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <form role="form">

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label for="categoria">Categoria: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <select id="categoria" class="form-control">
                                                        <option value="1">Cuota ordinaria</option>
                                                        <option value="2">Admistia</option>
                                                        <option value="3">Categoria tres</option>
                                                        <option value="4">Colegiatura</option>
                                                        <option value="5">Certificado de habilidad</option>
                                                        <option value="6">Certificado de residencia de obra</option>
                                                        <option value="7">Certificado de Proyecto</option>
                                                        <option value="8">Peritaje</option>
                                                        <option value="100">Otros conceptos</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="codigo">Codigo: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="codigo" type="text" name="codigo" class="form-control"
                                                        placeholder="Codigo del concepto" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="concepto">Concepto: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="concepto" type="text" name="concepto"
                                                        class="form-control" placeholder="Nombre del concepto"
                                                        required="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="precio">Precio: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="precio" type="number" name="precio" class="form-control"
                                                        placeholder="Monto del concepto" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha_inicio">Fecha Inicio: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="fecha_inicio" type="date" name="fecha_inicio"
                                                        class="form-control" required="">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="fecha_fin">Fecha Fin: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                    <input id="fecha_fin" type="date" name="fecha_fin"
                                                        class="form-control" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    <p>Agrege especificaciones: <i
                                                            class="fa fa-fw fa-asterisk text-danger"></i></p>
                                                    <div class="col-md-5">
                                                        <input type="radio" id="precio_variable" name="espesifico"
                                                            value="1">
                                                        <label for="precio_variable">Precio es variable</label><br>

                                                        <input type="radio" id="deriva" name="espesifico" value="2">
                                                        <label for="deriva">Se deriva al CIP nacional</label>
                                                    </div>

                                                    <div class="col-md-7">
                                                        <input type="radio" id="solo_transeunte" name="espesifico"
                                                            value="3">
                                                        <label for="solo_transeunte">Precio solo para
                                                            transeunte</label><br>
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input type="radio" id="opcional" name="espesifico"
                                                                    value="4">
                                                                <label for="opcional">Opcional en la categoria</label>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <select id="opcional_2" class="form-control">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                    <option value="6">5</option>
                                                                    <option value="7">7</option>
                                                                    <option value="8">8</option>
                                                                    <option value="100">100</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i
                                            class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
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


                <div class="row">

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-warning" style="margin-right: 10px;" data-toggle="modal"
                            data-target="#confirmar">
                            <i class="fa fa-plus"></i> Nuevo Concepto
                        </button>
                        <a href="#" class="btn btn-link" id="btnactualizar">
                            <i class="fa fa-refresh"></i> Actualizar..
                        </a>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-right: -10px;">
                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="search" id="buscar" class="form-control"
                                placeholder="Buscar por nombres del concepto" aria-describedby="search" value=""
                                style="border-radius: 5px;">
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
                                <th>Codigo</th>
                                <th>Categoria</th>
                                <th>Concepto</th>
                                <th>Precio</th>
                                <th>Inicio</th>
                                <th>Fin</th>
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

        loadInitConceptos();

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

        $("#btnactualizar").click(function() {
            loadInitConceptos()
        });

        $("#buscar").on("keyup", function(event) {
            if (event.keyCode === 13) {
                paginacion = 1;
                loadTableConceptos($("#buscar").val());
                opcion = 1;
            }
        });

        // $("#btnaceptar").click(function() {
        //     if ($("#dni").val() == '' || $("#dni").val().length < 8) {
        //         AlertWarning("Advertencia", "Ingrese un número de dni correcto por favor.");
        //     } else if ($("#Nombres").val() == '' || $("#Nombres").val().length < 2) {
        //         AlertWarning("Advertencia", "Ingrese un nombre de 3 o mas letras por favor");
        //     } else if ($("#Apellidos").val() == '' || $("#Apellidos").val().length < 2) {
        //         AlertWarning("Advertencia", "Ingrese un apellido de 3 o mas letras por favor");
        //     } else if ($("#Nacimiento").val() == '') {
        //         AlertWarning("Advertencia", "Ingrese un fecha por favor");
        //     } else if ($("#Codigo").val() == '' || $("#Codigo").val().length < 4) {
        //         AlertWarning("Advertencia", "Ingrese un codigo de 4 caracteres por favor");
        //     } else {
        //         insertPersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $("#Genero")
        //             .val(),
        //             $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(), $(
        //                 "#Razon_social").val(),
        //             $("#Codigo").val(), $("#Condicion").val());

        //     }
        // })

    });

    function onEventPaginacion() {
        switch (opcion) {
            case 0:
                loadTableConceptos("");
                break;
            case 1:
                loadTableConceptos($("#buscar").val());
                break;
        }
    }

    function loadInitConceptos() {
        if (!state) {
            paginacion = 1;
            loadTableConceptos("");
            opcion = 0;
        }
    }

    function loadTableConceptos(nombres) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
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
                    '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                );
                state = true;

            },
            success: function(result) {
                tbTable.empty();
                if (result.estado === 1) {

                    for (let concepto of result.conceptos) {

                        let btnUpdate =
                            '<button class="btn btn-success btn-sm" onclick="loadUpdateConceptos(\'' +
                            concepto.idConcepto + '\')">' +
                            '<i class="fa fa-wrench"></i> Editar' +
                            '</button>';

                        let categoria = (concepto.Categoria == '1') ? 'Cuota ordinaria' :
                            (concepto.Categoria == '2') ? 'Admistia' :
                            (concepto.Categoria == '3') ? 'Categoria tres' :
                            (concepto.Categoria == '4') ? 'Colegiatura' :
                            (concepto.Categoria == '5') ? 'Certificado de habilidad' :
                            (concepto.Categoria == '6') ? 'Certificado de residencia de obra' :
                            (concepto.Categoria == '7') ? 'Certificado de proyecto' :
                            (concepto.Categoria == '8') ? 'Peritaje' : 'Otros conceptos'

                        tbTable.append('<tr>' +
                            '<td style="text-align: center;color: #2270D1;">' +
                            '' + concepto.Id + '' +
                            '</td>' +
                            '<td>' + concepto.Codigo + '</td>' +
                            '<td>' + categoria + '</td>' +
                            '<td>' + concepto.Concepto + '</td>' +
                            '<td>' + concepto.Precio + '</td>' +
                            '<td>' + concepto.Inicio.split(' ')[0] + '</td>' +
                            '<td>' + concepto.Fin.split(' ')[0] + '</td>' +
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
                    tbTable.append(
                        '<tr class="text-center"><td colspan="8"><p>No se pudo cargar la información.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html(0);
                    $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            },
            error: function(error) {
                console.log(error);
                tbTable.empty();
                tbTable.append(
                    '<tr class="text-center"><td colspan="8"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                );
                $("#lblPaginaActual").html(0);
                $("#lblPaginaSiguiente").html(0);
                state = false;
            }
        });
    }

    function loadUpdateConceptos(idConcepto) {
        location.href = "update_conceptos.php?idConcepto=" + idConcepto
    }

    // function insertPersona(idPersona, nombres, apellidos, sexo, nacimiento, estado_civil, ruc, rason_social, cip,
    //     condicion) {
    //     $.ajax({
    //         url: "../app/controller/PersonaController.php",
    //         method: "POST",
    //         data: {
    //             "type": "create",
    //             "dni": idPersona,
    //             "nombres": nombres,
    //             "apellidos": apellidos,
    //             "sexo": sexo,
    //             "nacimiento": nacimiento,
    //             "estado_civil": estado_civil,
    //             "ruc": ruc,
    //             "rason_social": rason_social,
    //             "cip": cip,
    //             "condicion": condicion,
    //         },
    //         beforeSend: function() {
    //             $("#btnaceptar").text('')
    //             $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
    //         },
    //         success: function(result) {
    //             console.log(result)
    //             if (result.estado == 1) {
    //                 AlertSuccess("Mensaje", result.message)
    //                 setTimeout(function() {
    //                     location.href = "ingenieros.php"
    //                 }, 1000);
    //             } else {

    //                 AlertWarning("Mensaje", result.message)
    //                 setTimeout(() => {
    //                     $("#btnaceptar").text("Aceptar")
    //                     $("#btnaceptar").append('<i class="fa fa-check"></i>')
    //                 }, 1000);

    //             }


    //         },
    //         error: function(error) {
    //             console.log(error)
    //         }
    //     });
    // }

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
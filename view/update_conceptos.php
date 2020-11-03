<?php

if (!isset($_GET["idConcepto"])) {
    echo '<script>location.href = "conceptos.php";</script>';
} else {

}
    
?>

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

                    <h4 style="padding-left:1em;"><i class="fa fa-list-alt"></i> Actualizar Datos del Concepto <span
                            id="Load_date"></span></h4>
                    <div>
                        <form action="">
                            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"
                                style="text-align: center; padding-top:1em;">
                                <img width="70" src="images/ayuda.png">
                                <!-- <label for="Foto">Subir foto</label>
                                <input type="file" id="Foto" name="Foto"> -->
                            </div>
                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12" style="padding-top:1em;">

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
                                            <input id="concepto" type="text" name="concepto" class="form-control"
                                                placeholder="Nombre del concepto" required="">
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
                                            <input id="fecha_fin" type="date" name="fecha_fin" class="form-control"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">

                                            <p>Agrege especificaciones: <i class="fa fa-fw fa-asterisk text-danger"></i>
                                            </p>
                                            <div class="col-md-5">
                                                <input type="radio" id="precio_variable" name="espesifico" value="1">
                                                <label for="precio_variable">Precio es variable</label><br>

                                                <input type="radio" id="deriva" name="espesifico" value="2">
                                                <label for="deriva">Se deriva al CIP nacional</label>
                                            </div>

                                            <div class="col-md-7">
                                                <input type="radio" id="solo_transeunte" name="espesifico" value="3">
                                                <label for="solo_transeunte">Precio solo para
                                                    transeunte</label><br>
                                                <div class="row">
                                                    <div class="col-md-9">
                                                        <input type="radio" id="opcional" name="espesifico" value="4">
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

                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i
                                            class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="button" class="btn btn-danger" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Editar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal"
                                        name="btncancelar" id="btncancelar">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                        </form>
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
    <script src="js/tools.js"></script>
    <script>
    let tools = new Tools();
    let spiner = $("#Load_date");
    let state = false;

    $(document).ready(function() {

        loadDataConcepto("<?php echo  $_GET["idConcepto"]; ?>")

        $("#btnaceptar").click(function() {
            if (state) {
                if ($("#dni").val() == '' || $("#dni").val().length < 8) {
                    AlertWarning("Advertencia", "Ingrese un número de dni correcto por favor.");
                } else if ($("#Nombres").val() == '' || $("#Nombres").val().length < 3) {
                    AlertWarning("Advertencia", "Ingrese un nombre de 3 o mas letras por favor");
                } else if ($("#Apellidos").val() == '' || $("#Apellidos").val().length < 3) {
                    AlertWarning("Advertencia", "Ingrese un apellido de 3 o mas letras por favor");
                } else if ($("#Codigo").val() == '' || $("#Codigo").val().length < 4) {
                    AlertWarning("Advertencia", "Ingrese un codigo de 4 caracteres por favor");
                } else {
                    // updatePersona($("#dni").val(), $("#Nombres").val(), $("#Apellidos").val(), $(
                    //         "#Genero")
                    //     .val(), $("#Nacimiento").val(), $("#Estado_civil").val(), $("#Ruc").val(),
                    //     $(
                    //         "#Razon_social").val(), $("#Codigo").val(), $("#Condicion").val());
                }

            } else {
                AlertWarning("Advertencia",
                    "Nose pudo cargar los datos correctamente, recargue la pantalla.");
            }
        });

        $("#btncancelar").click(function() {
            location.href = "conceptos.php"
        });

        $("#btncancelar").on("keyup", function(event) {
            if (event.keyCode === 13) {
                location.href = "conceptos.php"
            }
        });

    });

    // function onCheked() {
    //     $("#checkkBoxId").attr("checked") ? alert("Checked") : alert("Unchecked");
    // }

    function loadDataConcepto(idConcepto) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "data",
                "idConcepto": idConcepto
            },
            beforeSend: function() {
                spiner.append(
                    '<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>'
                )
            },
            success: function(result) {
                spiner.remove()

                if (result.estado === 1) {
                    console.log(result.object)

                    let concepto = result.object;
                    
                    switch (concepto.Categoria) {
                        case "1":
                            $("#categoria").val("1")
                            break
                        case "2":
                            $("#categoria").val("2")
                            break
                        case "3":
                            $("#categoria").val("3")
                            break
                        case "4":
                            $("#categoria").val("4")
                            break
                        case "5":
                            $("#categoria").val("5")
                            break
                        case "6":
                            $("#categoria").val("6")
                            break
                        case "7":
                            $("#categoria").val("7")
                            break
                        case "8":
                            $("#categoria").val("8")
                            break
                        case "100":
                            $("#categoria").val("100")
                            break
                        default:
                    }

                    $("#codigo").val(concepto.Codigo)
                    $("#concepto").val(concepto.Concepto)
                    $("#precio").val(concepto.Precio)
                    document.getElementById("fecha_inicio").value = tools.getDateForma(concepto
                        .Inicio, 'yyyy-mm-dd');
                    
                    document.getElementById("fecha_fin").value = tools.getDateForma(concepto
                        .Fin, 'yyyy-mm-dd');


                    AlertInfo("Información", "Se cargo correctamente los datos.");
                    state = true;
                } else {
                    AlertWarning("Advertencia", result.message);
                    state = false;
                }
            },
            error: function(error) {
                AlertError("Error", error);
                state = false;
            }
        });
    }

    // function updatePersona(idPersona, nombres, apellidos, sexo, nacimiento, estado_civil, ruc, rason_social, cip,
    //     condicion) {
    //     $.ajax({
    //         url: "../app/controller/PersonaController.php",
    //         method: "POST",
    //         data: {
    //             "type": "update",
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
    //             $("#btnaceptar").empty();
    //             $("#btnaceptar").append('<img src="./images/spiner.gif" width="25" height="25" />')
    //         },
    //         success: function(result) {
    //             if (result.estado == 1) {
    //                 AlertSuccess("Mensaje", "Se actualizaron correctamente los datos")
    //                 setTimeout(function() {
    //                     location.href = "ingenieros.php"
    //                 }, 1000);
    //             } else {
    //                 AlertWarning("Mensaje", result.message);
    //                 setTimeout(() => {
    //                     $("#btnaceptar").empty();
    //                     $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
    //                 }, 1000);

    //             }
    //         },
    //         error: function(error) {
    //             AlertError("Error", error.responseText);
    //             $("#btnaceptar").empty();
    //             $("#btnaceptar").append('<i class="fa fa-check"></i> Editar');
    //             console.log(error);
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

<?php
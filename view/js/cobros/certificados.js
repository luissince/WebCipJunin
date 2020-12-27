function Certificado() {
<<<<<<< HEAD
    this.componentesCertificado = function() {
        //********************************************* */
        $("#btnCertificado").click(function() {
=======
    this.componentesCertificado = function () {
        $("#btnCertificado").click(function () {
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            if (idDNI == 0) {
                tools.AlertWarning("Certificado", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $("#btnCertificado").attr('data-toggle', 'dropdown');
                $("#btnCertificado").attr('aria-expanded', 'true');
            }
        });

<<<<<<< HEAD
        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD
        $("#btnCertHabilidad").click(function() {
=======
        $("#btnCertHabilidad").click(function () {
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            $('#mdCertHabilidad').modal('show');
            loadCertificadoHabilidad(idDNI, Ingeniero);
        });

        $("#btnCertHabilidad").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
                loadCertificadoHabilidad(idDNI);
            }
            event.preventDefault();
        });

<<<<<<< HEAD
        $("#txtCorrelativoCertificado").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#btnAceptarCertificado").click(function() {
            validateIngresosCertificadoHabilidad();
        });

        $("#btnAceptarCertificado").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoHabilidad();
=======
        $("#btnCertProyecto").click(function () {
            $('#mdCertProyecto').modal('show');
            loadCertificadoProyecto(idDNI, Ingeniero);
            loadUbigeoProyecto();
        });

        $("#btnCertProyecto").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertProyecto').modal('show');
                loadCertificadoProyecto(idDNI, Ingeniero);
                loadUbigeoProyecto();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            }
            event.preventDefault();
        });

<<<<<<< HEAD
        $("#btnCancelarCertificado").click(function() {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        $("#btnCloseCertificado").click(function() {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD OBRA PUBLICA O RESIDENCIA
        $("#btnCertResidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('show');
            loadCertificadoObra(idDNI);
=======
        $("#btnCertResidenciaObra").click(function () {
            $('#mdCertResidenciaObra').modal('show');
            loadCertificadoObra(idDNI,Ingeniero);
            loadUbigeoObras();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
        });

        $("#btnCertResidenciaObra").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertResidenciaObra').modal('show');
<<<<<<< HEAD
                loadCertificadoObra(idDNI);
=======
                loadCertificadoObra(idDNI, Ingeniero);
                loadUbigeoObras();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            }
            event.preventDefault();
        });

<<<<<<< HEAD
        $("#txtCertificadoNumeroObra").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#txtMontoContratoObra").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoContratoObra").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#txtMontoCobrarObra").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoCobrarObra").val().includes(".")) {
                event.preventDefault();
            }
        });


        $("#btnAceptarCertResidenciaObra").click(function() {
            validateIngresosCertificadoResidenciaObra();
        });

        $("#btnAceptarCertResidenciaObra").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoResidenciaObra();
=======
        $("#btnAceptarCertificado").click(function () {
            InsertCertHabilidad();
        });

        $("#btnAceptarCertificado").keypress(function (event) {
            if (event.keyCode === 13) {
                InsertCertHabilidad();
            }
            event.preventDefault();
        });

        $("#btnAceptarProyecto").click(function () {
            InsertCertProyecto();
        });

        $("#btnAceptarProyecto").keypress(function (event) {
            if (event.keyCode === 13) {
                InsertCertProyecto();
            }
            event.preventDefault();
        });

        $("#btnAceptarObra").click(function () {
            InsertCertObra();
        });

        $("#btnAceptarObra").keypress(function (event) {
            if (event.keyCode === 13) {
                InsertCertObra();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            }
            event.preventDefault();
        });

        $("#btnCloseCertResidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObra();
        });

        $("#btnCloseCertRecidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObra();
        });

        /****************************************************/
        //-----CERTIFICADO DE PROYECTO
        $("#btnCertProyecto").click(function() {
            $('#mdCertProyecto').modal('show');
            loadCertificadoProyecto(idDNI);
        });

        $("#btnCertProyecto").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertProyecto').modal('show');
                loadCertificadoProyecto(idDNI);
            }
            event.preventDefault();
        });

        $("#txtNumeroCertificadoProyecto").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b')) {
                event.preventDefault();
            }
        });

        $("#txtMontoContratoProyecto").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoContratoProyecto").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#txtMontoCobrarProyecto").keypress(function(event) {
            var key = window.Event ? event.which : event.keyCode;
            var c = String.fromCharCode(key);
            if ((c < '0' || c > '9') && (c != '\b') && (c != '.')) {
                event.preventDefault();
            }
            if (c == '.' && $("#txtMontoCobrarProyecto").val().includes(".")) {
                event.preventDefault();
            }
        });

        $("#btnAceptarCertProyecto").click(function() {
            validateIngresosCertificadoProyecto()
        });

        $("#btnAceptarCertProyecto").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresosCertificadoProyecto()
            }
            event.preventDefault();
        });

        $("#btnCloseCertProyecto").click(function() {
            $('#mdCertProyecto').modal('hide');
            clearIngresoCertificadoProyecto();
        });

        $("#btnCancelCertProyecto").click(function() {
            $('#mdCertProyecto').modal('hide');
            clearIngresoCertificadoProyecto();
        });
        /****************************************************/

    }

    function loadCertificadoHabilidad($dni, $ingeniero) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            dataType: "json",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadCertificado").empty();
<<<<<<< HEAD
                $("#modal-title-certificado-habilidad").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoHabilidadEstado").removeClass();
                $("#lblCertificadoHabilidadEstado").empty();
                certificadoHabilidad = {}
            },
            success: function(result) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"> </i> Certificado de Habilidad');
                if (result.estado == 1) {
                    certificadoHabilidad = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };
=======
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#txtIngenieroCertificado").val($ingeniero);


>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                    $("#txtFechaCertificado").val(result.ultimopago);

                    $("#lblCertificadoHabilidadEstado").addClass("text-success");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');
                } else {
                    $("#lblCertificadoHabilidadEstado").addClass("text-warning");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                }
            },
<<<<<<< HEAD
            error: function(error) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"></i> Certificado de Habilidad');
                $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoHabilidadEstado").addClass("text-danger");
                $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> ' + error.responseText);
=======
            error: function (error) {
                console.log(error);
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            }
        });
    }

<<<<<<< HEAD
    function loadCertificadoObra($dni) {
=======
    function loadCertificadoProyecto($dni, $ingeniero) {
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 6,
                "Dni": $dni,
            },
<<<<<<< HEAD
            beforeSend: function() {
                $("#cbEspecialidadObra").empty();
                $("#cbDepartamentoObra").empty();
                $("#modal-title-residencia-obra").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoResidenciaObraEstado").removeClass();
                $("#lblCertificadoResidenciaObraEstado").empty();
                certificadoResidenciaObra = {}
            },
            success: function(result) {
                console.log(result);
                $("#modal-title-residencia-obra").empty();
                $("#modal-title-residencia-obra").append('<i class="fa fa-plus"> </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');

                if (result.estado == 1) {
                    certificadoResidenciaObra = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };
                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
=======
            beforeSend: function () {
                $("#cbEspecialidadProyecto").empty();
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#txtIngenieroProyecto").val($ingeniero);

                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadObra").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                    $("#txtFechaObra").val(result.ultimopago);

                    $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let ubigeo of result.ubigeo) {
                        $("#cbDepartamentoObra").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoObra').select2();

                    $("#lblCertificadoResidenciaObraEstado").addClass("text-success");
                    $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');
                } else {
                    $("#lblCertificadoResidenciaObraEstado").addClass("text-warning");
                    $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i>' + result.message);
                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                }
            },
<<<<<<< HEAD
            error: function(error) {
                $("#modal-title-residencia-obra").empty();
                $("#modal-title-residencia-obra").append('<i class="fa fa-plus"> </i> Certificado de Habilidad para Firmar de Contrato de Obra Pública o Residencia');
                $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoResidenciaObraEstado").addClass("text-danger");
                $("#lblCertificadoResidenciaObraEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);
=======
            error: function (error) {
                console.log(error);
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            }
        });
    }

<<<<<<< HEAD
    function loadCertificadoProyecto($dni) {
=======
    function loadCertificadoObra($dni, $ingeniero) {
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 7,
                "Dni": $dni,
            },
<<<<<<< HEAD
            beforeSend: function() {
                $("#cbEspecialidadProyecto").empty();
                $("#cbDepartamentoProyecto").empty();
                $("#modal-title-certificado-proyecto").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoProyectoEstado").removeClass();
                $("#lblCertificadoProyectoEstado").empty();
                certificadoProyecto = {};
=======
            beforeSend: function () {
                $("#cbEspecialidadObra").empty();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
            },
            success: function (result) {
                console.log(result);
                $("#modal-title-certificado-proyecto").empty();
                $("#modal-title-certificado-proyecto").append('<i class="fa fa-plus"> </i> Certificado de Proyecto');
                if (result.estado == 1) {
<<<<<<< HEAD
                    certificadoProyecto = {
                        "idConcepto": parseInt(result.data.idConcepto),
                        "categoria": parseInt(result.data.Categoria),
                        "cantidad": 1,
                        "concepto": result.data.Concepto,
                        "precio": parseFloat(result.data.Precio),
                        "monto": parseFloat(result.data.Precio),
                        "ultimoPago": result.ultimopago
                    };
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
=======
                    $("#txtIngenieroObra").val($ingeniero);

                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
<<<<<<< HEAD
                    $("#txtFechaProyecto").val(result.ultimopago);
=======
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function loadUbigeoProyecto() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "getubigeo",
            },
            beforeSend: function () {

            },
            success: function (result) {
                if (result.estado == 1) {
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4

                    $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let ubigeo of result.ubigeo) {
                        $("#cbDepartamentoProyecto").append('<option value="' + ubigeo.IdUbicacion + '">' + ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoProyecto').select2();

                    $("#lblCertificadoProyectoEstado").addClass("text-success");
                    $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');

                } else {
                    $("#lblCertificadoProyectoEstado").addClass("text-warning");
                    $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> ' + result.message);
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                }
            },
            error: function(error) {
                $("#modal-title-certificado-proyecto").empty();
                $("#modal-title-certificado-proyecto").append('<i class="fa fa-plus"> </i> Certificado de Proyecto');
                $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoProyectoEstado").addClass("text-danger");
                $("#lblCertificadoProyectoEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);

            }
        });
    }

<<<<<<< HEAD
    function validateIngresosCertificadoHabilidad() {
        if ($("#cbEspecialidadCertificado").val() == '') {
            $("#cbEspecialidadCertificado").focus();
        } else if (!tools.validateDate($("#txtFechaCertificado").val())) {
            $("#txtFechaCertificado").focus();
        } else if ($("#txtCorrelativoCertificado").val() == "") {
            $("#txtCorrelativoCertificado").focus();
        } else if ($("#txtAsuntoCertificado").val() == '') {
            $("#txtAsuntoCertificado").focus();
        } else if ($("#txtEntidadCertificado").val() == '') {
            $("#txtEntidadCertificado").focus();
        } else if ($("#txtLugarCertificado").val() == '') {
            $("#txtLugarCertificado").focus();
        } else if ($.isEmptyObject(certificadoHabilidad)) {
            tools.AlertWarning("Certificado de Habilidad", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoHabilidad.fechaPago = tools.getCurrentDate();
            certificadoHabilidad.idEspecialidad = $("#cbEspecialidadCertificado").val();
            certificadoHabilidad.numero = $("#txtCorrelativoCertificado").val();
            certificadoHabilidad.asunto = $("#txtAsuntoCertificado").val().toUpperCase();
            certificadoHabilidad.entidad = $("#txtEntidadCertificado").val().toUpperCase();
            certificadoHabilidad.lugar = $("#txtLugarCertificado").val().toUpperCase();
            certificadoHabilidad.anulado = 0;
            if (!validateDuplicate(certificadoHabilidad.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": certificadoHabilidad.idConcepto,
                    "categoria": certificadoHabilidad.categoria,
                    "cantidad": certificadoHabilidad.cantidad,
                    "concepto": certificadoHabilidad.concepto,
                    "precio": certificadoHabilidad.precio,
                    "monto": certificadoHabilidad.precio * certificadoHabilidad.cantidad
                });
                addIngresos();
                $('#mdCertHabilidad').modal('hide')
                certificadoHabilidadEstado = true;
                clearIngresosCertificadoHabilidad()
            } else {
                tools.AlertWarning("Certificado de Habilidad", "Ya existe un concepto con los mismo datos.");
            }
        }
    }
=======
    function loadUbigeoObras() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "getubigeo",
            },
            beforeSend: function () {

            },
            success: function (result) {
                if (result.estado == 1) {

                    $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoObra").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoObra').select2();
>>>>>>> c8010c2e76c45e25b15a63cf71ff23204529b2d4

    function validateIngresosCertificadoResidenciaObra() {
        if ($("#cbEspecialidadObra").val() == '') {
            $("#cbEspecialidadObra").focus();
        } else if ($("#txtFechaObra").val() == '') {
            $("#txtFechaObra").focus();
        } else if ($("#txtCertificadoNumeroObra").val() == '') {
            $("#txtCertificadoNumeroObra").focus();
        } else if ($("#txtModalidadObra").val() == '') {
            $("#txtModalidadObra").focus();
        } else if ($("#txtProyectoObra").val() == '') {
            $("#txtProyectoObra").focus();
        } else if ($("#txtPropietarioObra").val() == '') {
            $("#txtPropietarioObra").focus();
        } else if (!tools.isNumeric($("#txtMontoContratoObra").val())) {
            $("#txtMontoContratoObra").focus();
        } else if ($("#cbDepartamentoObra").val() == '') {
            $("#cbDepartamentoObra").focus();
        } else if (!tools.isNumeric($("#txtMontoCobrarObra").val())) {
            $("#txtMontoCobrarObra").focus();
        } else if ($.isEmptyObject(certificadoResidenciaObra)) {
            tools.AlertWarning("Certificado de Residencia de Obra", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoResidenciaObra.fechaPago = tools.getCurrentDate();
            certificadoResidenciaObra.idEspecialidad = $("#cbEspecialidadObra").val();
            certificadoResidenciaObra.numero = $("#txtCertificadoNumeroObra").val();
            certificadoResidenciaObra.modalidad = $("#txtModalidadObra").val().toUpperCase();
            certificadoResidenciaObra.proyecto = $("#txtProyectoObra").val().toUpperCase();
            certificadoResidenciaObra.propietario = $("#txtPropietarioObra").val().toUpperCase();
            certificadoResidenciaObra.montocontrato = parseFloat($("#txtMontoContratoObra").val());
            certificadoResidenciaObra.ubigeo = $("#cbDepartamentoObra").val();
            certificadoResidenciaObra.precio = parseFloat($("#txtMontoCobrarObra").val());
            certificadoResidenciaObra.monto = parseFloat($("#txtMontoCobrarObra").val());
            certificadoResidenciaObra.anulado = 0;

            if (!validateDuplicate(certificadoResidenciaObra.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": certificadoResidenciaObra.idConcepto,
                    "categoria": certificadoResidenciaObra.categoria,
                    "cantidad": certificadoResidenciaObra.cantidad,
                    "concepto": certificadoResidenciaObra.concepto,
                    "precio": certificadoResidenciaObra.precio,
                    "monto": certificadoResidenciaObra.precio * certificadoResidenciaObra.cantidad
                });
                addIngresos();
                $('#mdCertResidenciaObra').modal('hide');
                certificadoResidenciaObraEstado = true;
                clearIngresosCertificadoResidenciaObra();
            } else {
                tools.AlertWarning("Certificado de Residencia de Obra", "Ya existe un concepto con los mismo datos.");
            }
        }
    }

    function validateIngresosCertificadoProyecto() {
        if ($("#cbEspecialidadProyecto").val() == '') {
            $("#cbEspecialidadProyecto").focus();
        } else if (!tools.validateDate($("#txtFechaProyecto").val())) {
            $("#txtFechaProyecto").focus();
        } else if ($("#txtNumeroCertificadoProyecto").val() == '') {
            $("#txtNumeroCertificadoProyecto").focus();
        } else if ($("#txtModalidadProyecto").val() == '') {
            $("#txtModalidadProyecto").focus();
        } else if ($("#txtPropietarioProyecto").val() == '') {
            $("#txtPropietarioProyecto").focus();
        } else if ($("#txtProyectoProyecto").val() == '') {
            $("#txtProyectoProyecto").focus();
        } else if (!tools.isNumeric($("#txtMontoContratoProyecto").val())) {
            $("#txtMontoContratoProyecto").focus();
        } else if ($("#cbDepartamentoProyecto").val() == '') {
            $("#cbDepartamentoProyecto").focus();
        } else if ($("#txtUrbProyecto").val() == '') {
            $("#txtUrbProyecto").focus();
        } else if ($("#txtCalleProyecto").val() == '') {
            $("#txtCalleProyecto").focus();
        } else if (!tools.isNumeric($("#txtMontoCobrarProyecto").val())) {
            $("#txtMontoCobrarProyecto").focus();
        } else if ($.isEmptyObject(certificadoProyecto)) {
            tools.AlertWarning("Certificado de Proyecto", "No se pudo crear el objeto por error en cargar los datos.")
        } else {
            certificadoProyecto.fechaPago = tools.getCurrentDate();
            certificadoProyecto.idEspecialidad = $("#cbEspecialidadProyecto").val();
            certificadoProyecto.numero = $("#txtNumeroCertificadoProyecto").val();
            certificadoProyecto.modalidad = $("#txtModalidadProyecto").val().toUpperCase();
            certificadoProyecto.proyecto = $("#txtProyectoProyecto").val().toUpperCase();
            certificadoProyecto.propietario = $("#txtPropietarioProyecto").val().toUpperCase();
            certificadoProyecto.montocontrato = parseFloat($("#txtMontoContratoProyecto").val());
            certificadoProyecto.ubigeo = $("#cbDepartamentoProyecto").val();
            certificadoProyecto.asociacion = $("#txtUrbProyecto").val().toUpperCase();
            certificadoProyecto.pasaje = $("#txtCalleProyecto").val().toUpperCase();
            certificadoProyecto.precio = parseFloat($("#txtMontoCobrarProyecto").val());
            certificadoProyecto.monto = parseFloat($("#txtMontoCobrarProyecto").val());
            certificadoProyecto.anulado = 0;

            if (!validateDuplicate(certificadoProyecto.idConcepto)) {
                arrayIngresos.push({
                    "idConcepto": certificadoProyecto.idConcepto,
                    "categoria": certificadoProyecto.categoria,
                    "cantidad": certificadoProyecto.cantidad,
                    "concepto": certificadoProyecto.concepto,
                    "precio": certificadoProyecto.precio,
                    "monto": certificadoProyecto.precio * certificadoProyecto.cantidad
                });
                addIngresos();
                $('#mdCertProyecto').modal('hide');
                certificadoProyectoEstado = true;
                clearIngresoCertificadoProyecto();
            } else {
                tools.AlertWarning("Certificado de Proyecto", "Ya existe un concepto con los mismo datos.");
            }

        }
    }

    function clearIngresosCertificadoHabilidad() {
        $("#cbEspecialidadCertificado").val("")
        $("#txtCorrelativoCertificado").val("")
        $("#txtAsuntoCertificado").val("")
        $("#txtEntidadCertificado").val("")
        $("#txtLugarCertificado").val("")
    }

    function clearIngresosCertificadoResidenciaObra() {
        $("#cbEspecialidadObra").val("")
        $("#txtFechaObra").val("")
        $("#txtCertificadoNumeroObra").val("")
        $("#txtModalidadObra").val("")
        $("#txtProyectoObra").val("")
        $("#txtPropietarioObra").val("")
        $("#txtMontoContratoObra").val("")
        $("#cbDepartamentoObra").empty()
        $("#txtMontoCobrarObra").val("")
    }

    function clearIngresoCertificadoProyecto() {
        $("#cbEspecialidadProyecto").val("")
        $("#txtFechaProyecto").val("")
        $("#txtNumeroCertificadoProyecto").val("")
        $("#txtModalidadProyecto").val("")
        $("#txtPropietarioProyecto").val("")
        $("#txtProyectoProyecto").val("")
        $("#txtMontoContratoProyecto").val("")
        $("#cbDepartamentoProyecto").val("")
        $("#txtUrbProyecto").val("")
        $("#txtCalleProyecto").val("")
        $("#txtMontoCobrarProyecto").val("")
    }

    function InsertCertHabilidad() {
        if ($("#cbEspecialidadCertificado").val() == '') {
            tools.AlertWarning('Habilidad', "Seleccione una especialidad");
            $("#cbEspecialidadCertificado").focus();
        } else if (!tools.validateDate($("#txtFechaCertificado").val())) {
            tools.AlertWarning('Habilidad', "Ingrese una fecha");
            $("#txtFechaCertificado").focus();
        } else if ($("#txtCorrelativoCertificado").val() == '') {
            tools.AlertWarning('Habilidad', "Ingrese un correlativo");
            $("#txtCorrelativoCertificado").focus();
        } else if ($("#txtAsuntoCertificado").val() == '') {
            tools.AlertWarning('Habilidad', "Ingrese un asunto");
            $("#txtAsuntoCertificado").focus();
        } else if ($("#txtEntidadCertificado").val() == '') {
            tools.AlertWarning('Habilidad', "Ingrese una entidad");
            $("#txtEntidadCertificado").focus();
        } else if ($("#txtLugarCertificado").val() == '') {
            tools.AlertWarning('Habilidad', "Ingrese un lugar");
            $("#txtLugarCertificado").focus();
        } else{
            $('#mdCertHabilidad').modal('hide');
            console.log('entro');
        }
    }

    function InsertCertProyecto() {
        if ($("#cbEspecialidadProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Seleccione una especialidad");
            $("#cbEspecialidadProyecto").focus();
        } else if (!tools.validateDate($("#txtFechaProyecto").val())) {
            tools.AlertWarning('Proyecto', "Ingrese una fecha");
            $("#txtFechaProyecto").focus();
        } else if ($("#txtNumeroCertificadoProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese un numero de certificado");
            $("#txtNumeroCertificadoProyecto").focus();
        } else if ($("#txtModalidadProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese una modalidad");
            $("#txtModalidadProyecto").focus();
        } else if ($("#txtPropietarioProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese un propietario");
            $("#txtPropietarioProyecto").focus();
        } else if ($("#txtProyectoProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese un proyecto");
            $("#txtProyectoProyecto").focus();
        } else if ($("#txtMontoContratoProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese un monto mayor que cero");
            $("#txtMontoContratoProyecto").focus();
        } else if ($("#cbDepartamentoProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Seleccione un Ubigeo");
            $("#cbDepartamentoProyecto").focus();
        } else if ($("#txtUrbProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese urbanizacion");
            $("#txtUrbProyecto").focus();
        } else if ($("#txtCalleProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese dirección valida");
            $("#txtCalleProyecto").focus();
        } else if ($("#txtMontoCobrarProyecto").val() == '') {
            tools.AlertWarning('Proyecto', "Ingrese Monto a Cobrar");
            $("#txtMontoCobrarProyecto").focus();
        } else{
            $('#mdCertProyecto').modal('hide');
            console.log('entro');
            
        }
    }

    function InsertCertObra() {
        if ($("#cbEspecialidadObra").val() == '') {
            tools.AlertWarning('Obra', "Seleccione una especialidad");
            $("#cbEspecialidadObra").focus();
        } else if (!tools.validateDate($("#txtFechaObra").val())) {
            tools.AlertWarning('Obra', "Ingrese una fecha");
            $("#txtFechaObra").focus();
        } else if ($("#txtCertificadoNumeroObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese un numero de certificado");
            $("#txtCertificadoNumeroObra").focus();
        } else if ($("#txtModalidadObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese una modalidad");
            $("#txtModalidadObra").focus();
        } else if ($("#txtProyectoObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese un proyecto");
            $("#txtProyectoObra").focus();
        } else if ($("#txtPropietarioObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese Propietario");
            $("#txtPropietarioObra").focus();
        } else if ($("#txtMontoContratoObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese Monto");
            $("#txtMontoContratoObra").focus();
        } else if ($("#cbDepartamentoObra").val() == '') {
            tools.AlertWarning('Obra', "Seleccione un Ubigeo");
            $("#cbDepartamentoObra").focus();
        } else if ($("#txtMontoCobrarObra").val() == '') {
            tools.AlertWarning('Obra', "Ingrese Monto a Cobrar");
            $("#txtMontoCobrarObra").focus();
        } else{
            $('#mdCertResidenciaObra').modal('hide');
            console.log('entro');
        }
    }
}
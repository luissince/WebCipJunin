function Certificado() {
    this.componentesCertificado = function() {
        //********************************************* */
        $("#btnCertificado").click(function() {
            if (idDNI == 0) {
                tools.AlertWarning("Certificado", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $("#btnCertificado").attr('data-toggle', 'dropdown');
                $("#btnCertificado").attr('aria-expanded', 'true');
            }
        });

        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD
        $("#btnCertHabilidad").click(function() {
            $('#mdCertHabilidad').modal('show');
            loadCertificadoHabilidad(idDNI);
        });

        $("#btnCertHabilidad").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
                loadCertificadoHabilidad(idDNI);
            }
            event.preventDefault();
        });

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
            }
            event.preventDefault();
        });

        $("#btnCancelarCertificado").click(function() {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        $("#btnCloseCertificado").click(function() {
            $('#mdCertHabilidad').modal('hide');
            clearIngresosCertificadoHabilidad()
        });

        /****************************************************/
        $("#btnCertProyecto").click(function() {
            $('#mdCertProyecto').modal('show');
            loadCertificadoProyecto(idDNI);
            loadUbigeoProyecto();
        });

        $("#btnCertProyecto").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertProyecto').modal('show');
                loadCertificadoProyecto(idDNI);
                loadUbigeoProyecto();
            }
            event.preventDefault();
        });
        /****************************************************/
        //-----CERTIFICADO DE HABILIDAD OBRA PUBLICA O RESIDENCIA
        $("#btnCertResidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('show');
            loadCertificadoObra(idDNI);
            loadUbigeoObras();
        });

        $("#btnCertResidenciaObra").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdCertResidenciaObra').modal('show');
                loadCertificadoObra(idDNI);
                loadUbigeoObras();
            }
            event.preventDefault();
        });

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

        });

        $("#btnCloseCertResidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObrea();
        });

        $("#btnCloseCertRecidenciaObra").click(function() {
            $('#mdCertResidenciaObra').modal('hide');
            clearIngresosCertificadoResidenciaObrea();
        });

    }

    function loadCertificadoHabilidad($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            dataType: "json",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
                "Dni": $dni,
            },
            beforeSend: function() {
                $("#cbEspecialidadCertificado").empty();
                $("#modal-title-certificado-habilidad").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoHabilidadEstado").removeClass();
                $("#lblCertificadoHabilidadEstado").empty();
                certificadoHabilidad = {}
            },
            success: function(result) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"></i> Certificado de Proyecto');
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
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                    $("#txtFechaCertificado").val(result.ultimopago);

                    $("#lblCertificadoHabilidadEstado").addClass("text-success");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> Se cargo correctamente lo datos.');
                } else {
                    $("#lblCertificadoHabilidadEstado").addClass("text-warning");
                    $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> Un problema en: ' + result.message);
                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                }
            },
            error: function(error) {
                $("#modal-title-certificado-habilidad").empty();
                $("#modal-title-certificado-habilidad").append('<i class="fa fa-plus"></i> Certificado de Proyecto');
                $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                $("#lblCertificadoHabilidadEstado").addClass("text-danger");
                $("#lblCertificadoHabilidadEstado").append('<i class="fa fa-check"> </i> Error en: ' + error.responseText);
            }
        });
    }

    function loadCertificadoProyecto($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 7,
                "Dni": $dni,
            },
            beforeSend: function() {
                $("#cbEspecialidadProyecto").empty();
            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function loadCertificadoObra($dni) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 6,
                "Dni": $dni,
            },
            beforeSend: function() {
                $("#cbEspecialidadObra").empty();
                $("#modal-title-residencia-obra").append('<img src="./images/spiner.gif" width="25" height="25" style="margin-left: 10px;"/>');

                $("#lblCertificadoResidenciaObraEstado").removeClass();
                $("#lblCertificadoResidenciaObraEstado").empty();
                certificadoResidenciaObra = {}
            },
            success: function(result) {
                console.log(result);
                $("#modal-title-residencia-obra").empty();
                $("#modal-title-residencia-obra").append('<i class="fa fa-plus"></i> Certificado de Proyecto');

                // if (result.estado == 1) {
                //     $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                //     for (let especialidades of result.especialidades) {
                //         $("#cbEspecialidadObra").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                //     }
                // } else {
                //     tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                // }
            },
            error: function(error) {
                console.log(error.responseText);
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
            beforeSend: function() {

            },
            success: function(result) {
                if (result.estado == 1) {

                    $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoProyecto").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoProyecto').select2();

                } else {
                    tools.AlertWarning("ubigeo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("ubigeo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

    function loadUbigeoObras() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                type: "getubigeo",
            },
            beforeSend: function() {
                $("#cbDepartamentoObra").empty();
            },
            success: function(result) {
                if (result.estado == 1) {

                    $("#cbDepartamentoObra").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoObra").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoObra').select2();

                } else {
                    tools.AlertWarning("ubigeo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function(error) {
                tools.AlertError("ubigeo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
    }

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
            tools.AlertWarning("Certificado de Habilidad", "No se pudo creear el objeto por error en cargar los datos.")
        } else {
            certificadoHabilidad.fechaPago = tools.getCurrentDate();
            certificadoHabilidad.idEspecialidad = $("#cbEspecialidadCertificado").val();
            certificadoHabilidad.numero = $("#txtCorrelativoCertificado").val();
            certificadoHabilidad.asunto = $("#txtAsuntoCertificado").val();
            certificadoHabilidad.entidad = $("#txtEntidadCertificado").val();
            certificadoHabilidad.lugar = $("#txtLugarCertificado").val();
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
                tools.AlertWarning("Ingresos Diversos", "Ya existe un concepto con los mismo datos.");
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

    function clearIngresosCertificadoResidenciaObrea() {
        $("#cbEspecialidadObra").val("")
        $("#txtFechaObra").val("")
        $("#txtCertificadoNumeroObra").val("")
        $("#txtModalidadObra").val("")
        $("#txtProyectoObra").val("")
        $("#txtPropietarioObra").val("")
        $("#txtMontoContratoObra").val("")
        $("#cbDepartamentoObra").empty();
    }
}
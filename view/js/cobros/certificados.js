function Certificado() {
    this.componentesCertificado = function () {
        $("#btnCertificado").click(function () {
            if (idDNI == 0) {
                tools.AlertWarning("Certificado", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $("#btnCertificado").attr('data-toggle', 'dropdown');
                $("#btnCertificado").attr('aria-expanded', 'true');
            }
        });

        $("#btnCertHabilidad").click(function () {
            $('#mdCertHabilidad').modal('show');
            loadCertificadoHabilidad(idDNI, Ingeniero);
        });

        $("#btnCertHabilidad").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertHabilidad').modal('show');
                // loadCertificadoHabilidad(idDNI);
            }
            event.preventDefault();
        });

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
            }
            event.preventDefault();
        });

        $("#btnCertResidenciaObra").click(function () {
            $('#mdCertResidenciaObra').modal('show');
            loadCertificadoObra(idDNI,Ingeniero);
            loadUbigeoObras();
        });

        $("#btnCertResidenciaObra").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdCertResidenciaObra').modal('show');
                loadCertificadoObra(idDNI, Ingeniero);
                loadUbigeoObras();
            }
            event.preventDefault();
        });

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
            }
            event.preventDefault();
        });

    }

    function loadCertificadoHabilidad($dni, $ingeniero) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 5,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadCertificado").empty();
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#txtIngenieroCertificado").val($ingeniero);


                    $("#cbEspecialidadCertificado").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadCertificado").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function loadCertificadoProyecto($dni, $ingeniero) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 7,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadProyecto").empty();
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#txtIngenieroProyecto").val($ingeniero);

                    $("#cbEspecialidadProyecto").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadProyecto").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
                } else {
                    tools.AlertWarning("Especialidad", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function loadCertificadoObra($dni, $ingeniero) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 6,
                "Dni": $dni,
            },
            beforeSend: function () {
                $("#cbEspecialidadObra").empty();
            },
            success: function (result) {
                console.log(result);
                if (result.estado == 1) {
                    $("#txtIngenieroObra").val($ingeniero);

                    $("#cbEspecialidadObra").append('<option value="">- Seleccione -</option>');
                    for (let especialidades of result.especialidades) {
                        $("#cbEspecialidadObra").append('<option value="' + especialidades.idEspecialidad + '">' + especialidades.Especialidad + '</option>');
                    }
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

                    $("#cbDepartamentoProyecto").append('<option value="">- Seleccione un Ubigeo -</option>');
                    for (let Ubigeo of result.ubicacion) {
                        $("#cbDepartamentoProyecto").append('<option value="' + Ubigeo.IdUbicacion + '">' + Ubigeo.Ubicacion + '</option>');
                    }
                    $('#cbDepartamentoProyecto').select2();

                } else {
                    tools.AlertWarning("ubigeo", "Se produjo un error al cargar los datos en el modal");
                }
            },
            error: function (error) {
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
            beforeSend: function () {

            },
            success: function (result) {
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
            error: function (error) {
                tools.AlertError("ubigeo", "Error Fatal, Comuniquese con el administrador del sistema");
            }
        });
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
function CobroIngenieros() {


    this.componentesIngenieros = function () {
        $("#btnIngenieros").click(function (event) {
            $('#mdIngenieros').modal('show');        
        });

        $('#mdIngenieros').on('shown.bs.modal', function () {
            $('#txtBuscarIngeniero').focus();
            loadInitIngenieros();
        });

        $("#btnIngenieros").keypress(function (event) {
            if (event.keyCode === 13) {
                $('#mdIngenieros').modal('show');
                loadInitIngenieros();
            }
            event.preventDefault();
        });

        $("#txtBuscarIngeniero").on("keyup", function (event) {
            if (event.keyCode === 13) {
                if (!state) {
                    paginacion = 1;
                    loadIngenieros($("#txtBuscarIngeniero").val());
                    opcion = 1;
                }
            }
        });

        $("#btnIzquierda").click(function () {
            if (!state) {
                if (paginacion > 1) {
                    paginacion--;
                    onEventPaginacion();
                }
            }
        });

        $("#btnDerecha").click(function () {
            if (!state) {
                if (paginacion < totalPaginacion) {
                    paginacion++;
                    onEventPaginacion();
                }
            }
        });

    }

    function onEventPaginacion() {
        switch (opcion) {
            case 0:
                loadIngenieros("");
                break;
            case 1:
                loadIngenieros($("#txtBuscarIngeniero").val());
                break;
        }
    }

    function loadInitIngenieros() {
        if (!state) {
            paginacion = 1;
            loadIngenieros("");
            opcion = 0;
        }
    }

    function loadIngenieros(search) {
        let tbIngenieros = $("#tbIngenieros");
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                "type": "listdata",
                "search": search,
                "posicionPagina": ((paginacion - 1) * filasPorPagina),
                "filasPorPagina": filasPorPagina
            },
            beforeSend: function () {
                totalPaginacion = 0;
                tbIngenieros.empty();
                tbIngenieros.append(
                    '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                );
                state = true;
            },
            success: function (result) {
                if (result.estado === 1) {
                    tbIngenieros.empty();
                    if (result.personas.length == 0) {
                        tbIngenieros.append(
                            '<tr class="text-center"><td colspan="8"><p>No hay datos para mostrar.</p></td></tr>'
                        );
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    } else {
                        for (let value of result.personas) {
                            tbIngenieros.append('<tr ondblclick="onSelectedIngeniero(\'' + value.Dni + '\')">' +
                                '<td>' + value.Id + '</td>' +
                                '<td>' + value.Cip + '</td>' +
                                '<td>' + value.Dni + '</td>' +
                                '<td>' + value.Ingeniero + '</td>' +
                                '<td>' + value.Condicion + '</td>' +
                                '<td>' + value.FechaUltimaCuota + '</td>' +
                                '<td>' + (value.Deuda <= 0 ? '0 Cuotas' : value.Deuda + ' Cuota(s)') + '</td>' +
                                '</tr>');
                        }
                        totalPaginacion = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPagina))));
                        $("#lblPaginaActual").html(paginacion);
                        $("#lblPaginaSiguiente").html(totalPaginacion);
                        state = false;
                    }

                } else {
                    tbIngenieros.empty();
                    tbIngenieros.append(
                        '<tr class="text-center"><td colspan="8"><p>No se pudo cargar la información.</p></td></tr>'
                    );
                    $("#lblPaginaActual").html("0");
                    $("#lblPaginaSiguiente").html("0");
                    state = false;
                }
            },
            error: function (error) {
                tbIngenieros.empty();
                tbIngenieros.append(
                    '<tr class="text-center"><td colspan="8"><p>Se produjo un error, intente nuevamente.</p></td></tr>'
                );
                $("#lblPaginaActual").html("0");
                $("#lblPaginaSiguiente").html("0");
                state = false;
            }
        });
    }

    onSelectedIngeniero = function (idIngeniero) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                "type": "data",
                "dni": idIngeniero
            },
            beforeSend: function () {
                $('#mdIngenieros').modal('hide');
                $("#tbHistorial").empty();
                idDNI = 0;
                tools.AlertInfo("Ingeniero", "En proceso de busqueda.", "toast-bottom-right");
                $("#tbHistorial").append('<tr class="text-center"><td colspan="6"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function (data) {
                console.log(data)
                if (data.estado === 1) {
                    $("#tbHistorial").empty();
                    idDNI = data.persona.idDNI;
                    Ingeniero = data.persona.Nombres+', '+data.persona.Apellidos
                    condiccion = data.persona.Condicion;
                    let Condicion = data.persona.Condicion ==
                        'T' ? 'Transeunte' :
                        data.persona.Condicion == 'F' ? 'Fallecido' :
                            data.persona.Condicion == 'R' ? 'Retirado' :
                                data.persona.Condicion == 'V' ? 'Vitalicio' : 'Ordinario';
                    $("#lblCipSeleccionado").html(data.persona.CIP);
                    $("#lblTipoIngenieroSeleccionado").html(Condicion);
                    $("#lblDocumentSeleccionado").html(data.persona.idDNI);
                    $("#lblDatosSeleccionado").html(data.persona.Apellidos + " " + data.persona.Nombres);
                    $("#lblDireccionSeleccionado").html("");


                    for (let Historial of data.historial) {
                        let Concepto = Historial.Concepto == 1 ? 'Cuota Ordinaria' :
                            Historial.Concepto == 2 ? 'Cuota Ordinaria (Amnistia)' :
                                Historial.Concepto == 3 ? 'Cuota Ordinaria (Vitalicio)' :
                                    Historial.Concepto == 4 ? 'Colegiatura' :
                                        Historial.Concepto == 5 ? 'Certificado de habilidad' :
                                            Historial.Concepto == 6 ? 'Cuota de residencia de obra' :
                                                Historial.Concepto == 7 ? 'Certificado de proyecto' :
                                                    Historial.Concepto == 8 ? 'Peritaje' : 'Ingresos Diversos';

                        $("#tbHistorial").append('<tr>' +
                            '<td>' + Historial.Id + '</td>' +
                            '<td>' + Historial.Recibo + '</td>' +
                            '<td>' + Historial.Fecha + '</td>' +
                            '<td>' + Concepto + '</td>' +
                            '<td>' +"S/ " +Historial.Monto + '</td>' +
                            '<td>' + Historial.Observacion + '</td>' +
                            '</tr>');
                    }

                    tools.AlertSuccess("Ingeniero", "Los obtuvo los datos correctamente.", "toast-bottom-right");

                } else {
                    $("#tbHistorial").empty();
                    idDNI = 0;
                    $("#lblCipSeleccionado").html("--");
                    $("#lblTipoIngenieroSeleccionado").html("--");
                    $("#lblDocumentSeleccionado").html("--");
                    $("#lblDatosSeleccionado").html("--");
                    $("#lblDireccionSeleccionado").html("--");
                    tools.AlertWarning("Ingeniero", "Se produjo un problema en obtener los datos, intente nuevamente.", "toast-bottom-right");
                }
            },
            error: function (error) {
                $("#tbHistorial").empty();
                tools.AlertError("Ingeniero", "Error en obtener los datos, comuníquese con su proveedor o intente nuevamente.", "toast-bottom-right");
            }
        });
    }
}
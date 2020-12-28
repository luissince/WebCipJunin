function CobroIngenieros() {

    let stateHistorial = false;
    let opcionHistorial = 0;
    let totalPaginacionHistorial = 0;
    let paginacionHistorial = 0;
    let filasPorPaginacionHistorial = 10;
    let tbHistorial = $("#tbHistorial");

    this.componentesIngenieros = function() {
        $("#btnIngenieros").click(function(event) {
            $('#mdIngenieros').modal('show');
            loadInitIngenieros();
        });

        $("#btnIngenieros").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdIngenieros').modal('show');
                loadInitIngenieros();
            }
            event.preventDefault();
        });

        $('#mdIngenieros').on('shown.bs.modal', function() {
            $('#txtBuscarIngeniero').focus();
        });

        $("#txtBuscarIngeniero").on("keyup", function(event) {
            if (event.keyCode === 13) {
                if (!state) {
                    paginacion = 1;
                    loadIngenieros($("#txtBuscarIngeniero").val());
                    opcion = 1;
                }
            }
        });

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

        //-------------------------------------------------------------------------

        $("#btnIzquierdaHistorial").click(function() {
            if (!stateHistorial) {
                if (paginacionHistorial > 1) {
                    paginacionHistorial--;
                    onEventPaginacionHistorial();
                }
            }
        });

        $("#btnDerechaHistorial").click(function() {
            if (!stateHistorial) {
                if (paginacionHistorial < totalPaginacionHistorial) {
                    paginacionHistorial++;
                    onEventPaginacionHistorial();
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
            beforeSend: function() {
                totalPaginacion = 0;
                tbIngenieros.empty();
                tbIngenieros.append(
                    '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                );
                state = true;
            },
            success: function(result) {
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
            error: function(error) {
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

    onSelectedIngeniero = function(idIngeniero) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                "type": "data",
                "dni": idIngeniero
            },
            beforeSend: function() {
                $('#mdIngenieros').modal('hide');
                $("#tbHistorial").empty();
                idDNI = 0;
                tools.AlertInfo("Ingeniero", "En proceso de busqueda.", "toast-bottom-right");
                $("#tbHistorial").append('<tr class="text-center"><td colspan="7"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
            },
            success: function(data) {
                if (data.estado === 1) {
                    $("#tbHistorial").empty();
                    idDNI = data.persona.idDNI;
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
                    $("#txtIngenieroCertificado").val(data.persona.Apellidos + " " + data.persona.Nombres);
                    $("#txtIngenieroObra").val(data.persona.Apellidos + " " + data.persona.Nombres);
                    $("#txtIngenieroProyecto").val(data.persona.Apellidos + " " + data.persona.Nombres);

                    onSelectedHistorial(idDNI);
                    tools.AlertSuccess("Ingeniero", "Los obtuvo los datos correctamente.", "toast-bottom-right");

                } else {
                    $("#tbHistorial").empty();
                    idDNI = 0;
                    $("#lblCipSeleccionado").html("--");
                    $("#lblTipoIngenieroSeleccionado").html("--");
                    $("#lblDocumentSeleccionado").html("--");
                    $("#lblDatosSeleccionado").html("--");
                    $("#lblDireccionSeleccionado").html("--");
                    $("#txtIngenieroCertificado").val("");
                    $("#txtIngenieroObra").val("");
                    $("#txtIngenieroProyecto").val("");

                    tools.AlertWarning("Ingeniero", "Se produjo un problema: " + data.message, "toast-bottom-right");
                }
            },
            error: function(error) {
                $("#tbHistorial").empty();
                tools.AlertError("Ingeniero", "Error en obtener los datos: " + error.responseText, "toast-bottom-right");
            }
        });
    }

    function onSelectedHistorial(dni) {
        if (!stateHistorial) {
            paginacionHistorial = 1;
            loadTableHistorial(dni);
            opcionHistorial = 0;
        }
    }

    function onEventPaginacionHistorial() {
        switch (opcionHistorial) {
            case 0:
                loadTableHistorial(idDNI);
                break;
        }
    }

    function loadTableHistorial(dni) {
        $.ajax({
            url: "../app/controller/PersonaController.php",
            method: "GET",
            data: {
                "type": "historialpago",
                "dni": dni,
                "posicionPagina": ((paginacionHistorial - 1) * filasPorPaginacionHistorial),
                "filasPorPagina": filasPorPaginacionHistorial
            },
            beforeSend: function() {
                tbHistorial.empty()
                tbHistorial.append('<tr class="text-center"><td colspan="7"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');
                stateHistorial = true;
            },
            success: function(result) {
                if (result.estado == 1) {
                    tbHistorial.empty()
                    if (result.historial.length == 0) {
                        tbHistorial.append('<tr class="text-center"><td colspan="7"><p>No hay datos para mostrar.</p></td></tr>');
                        totalPaginacionHistorial = 0;
                        $("#lblPaginaActual").html(paginacionHistorial);
                        $("#lblPaginaSiguiente").html(totalPaginacionHistorial);
                        stateHistorial = false;
                    } else {
                        for (let historial of result.historial) {

                            let Concepto;
                            if (historial.Concepto == 1) {
                                Concepto = "Cuota Ordinaria";
                            } else if (historial.Concepto == 2) {
                                Concepto = "Cuota Ordinaria (Amnistia)";
                            } else if (historial.Concepto == 3) {
                                Concepto = "Cuota Ordinaria (Vitalicio)";
                            } else if (historial.Concepto == 4) {
                                Concepto = "Colegiatura";
                            } else if (historial.Concepto == 5) {
                                Concepto = "Certificado de habilidad";
                            } else if (historial.Concepto == 6) {
                                Concepto = "Cuota de residencia de obra";
                            } else if (historial.Concepto == 7) {
                                Concepto = "Certificado de proyecto";
                            } else if (historial.Concepto == 8) {
                                Concepto = "Peritaje";
                            } else if (historial.Concepto == 100) {
                                Concepto = "Ingresos Diversos";
                            }

                            tbHistorial.append('<tr>' +
                                '<td>' + historial.Id + '</td>' +
                                '<td>' + historial.Recibo + '</td>' +
                                '<td>' + tools.getDateForma(historial.Fecha) + '<br>' + tools.getTimeForma(historial.Hora, true) + '</td>' +
                                '<td>' + Concepto + '</td>' +
                                '<td>' + tools.formatMoney(historial.Monto) + '</td>' +
                                '<td>' + historial.Observacion + '</td>' +
                                '<td><button class="btn btn-warning btn-md" onclick="detalleIngresoIdIngreso(\'' + historial.IdIngreso + '\')"><i class="fa fa-eye"></i></button></td>' +
                                '</tr>');
                        }

                        totalPaginacionHistorial = parseInt(Math.ceil((parseFloat(result.total) / parseInt(
                            filasPorPaginacionHistorial))));
                        $("#lblPaginaActualHistorial").html(paginacionHistorial);
                        $("#lblPaginSiguienteHistorial").html(totalPaginacionHistorial);
                        stateHistorial = false;
                    }
                } else {
                    tbHistorial.empty()
                    tbHistorial.append('<tr class="text-center"><td colspan="7"><p>' + result.message + '</p></td></tr>');
                    stateHistorial = false;
                }
            },
            error: function(error) {
                tbHistorial.empty()
                tbHistorial.append('<tr class="text-center"><td colspan="7"><p>' + error.responseText + '</p></td></tr>');
                stateHistorial = false;
            }
        });
    }

    detalleIngresoIdIngreso = function(idIngreso) {
        $("#mostrarDetalleIngreso").modal("show");
        $.ajax({
            url: "../app/controller/IngresoController.php",
            method: "GET",
            data: {
                "type": "detalleingreso",
                "idIngreso": idIngreso,
            },
            beforeSend: function() {
                $("#tbDetalleIngreso").empty();
                $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');

            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#tbDetalleIngreso").empty();
                    if (result.detalles.length == 0) {
                        $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>No hay datos para Mostrar</p></td></tr>');
                    } else {
                        for (let detalle of result.detalles) {
                            $("#tbDetalleIngreso").append('<tr>' +
                                '<td>' + detalle.Id + '</td>' +
                                '<td>' + detalle.Concepto + '</td>' +
                                '<td>' + tools.formatMoney(detalle.Precio) + '</td>' +
                                '<td>' + tools.formatMoney(detalle.Cantidad) + '</td>' +
                                '<td>' + tools.formatMoney(detalle.Total) + '</td>' +
                                '</tr>');
                        }

                    }
                } else {
                    $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + result.message + '</p></td></tr>');
                }
            },
            error: function(error) {
                $("#tbDetalleIngreso").append('<tr class="text-center"><td colspan="5"><p>' + error.responseText + '</p></td></tr>');

            }
        });
    }
}
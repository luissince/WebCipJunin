function CobroIngenieros() {
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
                tbIngenieros.empty();
                tbIngenieros.append(
                    '<tr class="text-center"><td colspan="8"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>'
                );
                state = true;
            },
            success: function(result) {
                if (result.estado === 1) {
                    tbIngenieros.empty();
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
                idDNI = 0;
                tools.AlertInfo("Ingeniero", "En proceso de busqueda.");
            },
            success: function(data) {
                if (data.estado === 1) {
                    idDNI = data.object.idDNI;
                    let Condicion = data.object.Condicion ==
                        'T' ? 'Transeunte' :
                        data.object.Condicion == 'F' ? 'Fallecido' :
                        data.object.Condicion == 'R' ? 'Retirado' :
                        data.object.Condicion == 'V' ? 'Vitalicio' : 'Ordinario';
                    $("#lblCipSeleccionado").html(data.object.CIP);
                    $("#lblTipoIngenieroSeleccionado").html(Condicion);
                    $("#lblDocumentSeleccionado").html(data.object.idDNI);
                    $("#lblDatosSeleccionado").html(data.object.Apellidos + " " + data.object.Nombres);
                    $("#lblDireccionSeleccionado").html("");
                    tools.AlertSuccess("Ingeniero", "Los obtuvo los datos correctamente.");
                } else {
                    idDNI = 0;
                    $("#lblCipSeleccionado").html("--");
                    $("#lblTipoIngenieroSeleccionado").html("--");
                    $("#lblDocumentSeleccionado").html("--");
                    $("#lblDatosSeleccionado").html("--");
                    $("#lblDireccionSeleccionado").html("--");
                    tools.AlertWarning("Ingeniero", "Se produjo un problema en obtener los datos, intente nuevamente.");
                }
            },
            error: function(error) {
                idDNI = 0;
                tools.AlertError("Ingeniero", "Error en obtener los datos, comuníquese con su proveedor o intente nuevamente.");
            }
        });
    }
}
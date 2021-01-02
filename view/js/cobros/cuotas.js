function Cuotas() {

    this.componentesCuotas = function () {

        $("#btnCuotas").click(function () {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $('#mdCuotas').modal('show');
                loadCuotas(1);
            }

        });

        $("#btnCuotas").keypress(function (event) {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $('#mdCuotas').modal('show');
                loadCuotas(1);
            }
            event.preventDefault();
        });

        $("#btnCuotaNormal").click(function () {
            $("#lblCuotasMensaje").html("Cuotas Ordinarias");
            loadCuotas(1);
        });

        $("#btnCuotaNormal").keypress(function (event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas Ordinarias");
                loadCuotas(1);
            }
            event.preventDefault();
        });

        $("#btnCuotaAmnistia").click(function () {
            $("#lblCuotasMensaje").html("Cuotas de Amnistia");
            loadCuotas(2);
        });

        $("#btnCuotaAmnistia").keypress(function (event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas de Amnistia");
                loadCuotas(2);
            }
            event.preventDefault();
        });

        $("#btnCuotaVitalicio").click(function () {
            $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
            loadCuotas(3);
        });

        $("#btnCuotaVitalicio").keypress(function (event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
                loadCuotas(3);
            }
            event.preventDefault();
        });

        $("#btnAddCuota").click(function () {
            addCuotas();
        });

        $("#btnAddCuota").keypress(function (event) {
            if (event.keyCode === 13) {
                addCuotas();
            }
            event.preventDefault();
        });

        $("#btnDeleteCuota").click(function () {
            removeCuota();
        });

        $("#btnCloseCuotas").click(function () {
            $('#mdCuotas').modal('hide');
            countCurrentDate = 0;
        });

        $("#btnCancelarCuotas").click(function () {
            $('#mdCuotas').modal('hide');
            countCurrentDate = 0;
        });

        $("#btnAceptarCuotas").click(function () {
            validateIngresoCuotas();
        });

        $("#btnAceptarCuotas").keypress(function (event) {
            if (event.keyCode === 13) {
                validateIngresoCuotas();
            }
            event.preventDefault();
        });
    }

     function loadConcepto() {
                $.ajax({
                    url: "../app/controller/ComprobanteController.php",
                    method: "GET",
                    data: {},
                    beforeSend: function() {
                        $("#cbComprobante").empty();
                    },
                    success: function(result) {
                        if (result.estado === 1) {
                            $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                            for (let value of result.data) {
                                $("#cbComprobante").append('<option value="' + value.IdTipoComprobante + '">' + value.Nombre + '</option>')
                            }
                        } else {
                            $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                        }
                    },
                    error: function(error) {
                        $("#cbComprobante").append('<option value="">- Seleccione -</option>');
                    }
                });
            }

    function addCuotas() {
        countCurrentDate++;
        loadCuotas(1);
    }

    function loadCuotas(categoria) {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": categoria,
                "dni": idDNI,
                "mes": countCurrentDate
            },
            beforeSend: function () {
                $("#tbCuotas").empty();
                $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><img src="./images/spiner.gif"/><p>Cargando información.</p></td></tr>');
                cuotas.splice(0, cuotas.length);
            },
            success: function (result) {
                if (result.estado == 1) {
                    $("#tbCuotas").empty();
                    cuotas = result.data;
                    if (cuotas.length > 0) {
                        let totalCuotas = 0;
                        console.log(cuotas)
                        for (let value of cuotas) {
                            let monto = 0;
                            for (let c of value.concepto) {
                                monto += parseFloat(c.Precio);
                            }
                            $("#tbCuotas").append('<tr id="' + (value.mes + '-' + value.year) + '">' +
                                '<td class="no-padding"> ' + tools.nombreMes(value.mes) + ' - ' + value.year + '</td>' +
                                '<td class="no-padding text-center">' + tools.formatMoney(monto) + '</td>' +
                                +'</tr>');
                            totalCuotas += parseFloat(monto);
                        }
                        $("#lblTotalCuotas").html("TOTAL DE " + (cuotas.length) + " CUOTAS: " + tools.formatMoney(totalCuotas));
                        if (cuotas.length > 0) {
                            $("#lblNumeroCuotas").html("CUOTAS DEL: " + cuotas[0].mes + "/" + cuotas[0].year + " al " + cuotas[cuotas.length - 1].mes + "/" + cuotas[cuotas.length - 1].year);
                        }
                    } else {
                        $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+Agregar) para más cuotas.</p></td></tr>');
                        $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                        $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                    }
                } else {
                    $("#tbCuotas").empty();
                    $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><p>' + result.message + '</p></td></tr>');
                    $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                    $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                }
            },
            error: function (error) {
                $("#tbCuotas").empty();
                $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><p>' + error.responseText + '</p></td></tr>');
            }
        });
    }

    function removeCuota() {
        if (cuotas.length != 0) {
            cuotas.pop();
            countCurrentDate--;
            $("#tbCuotas").empty();
            if (cuotas.length > 0) {
                let totalCuotas = 0;
                console.log(cuotas)
                for (let value of cuotas) {
                    let monto = 0;
                    for (let c of value.concepto) {
                        monto += parseFloat(c.Precio);
                    }
                    $("#tbCuotas").append('<tr id="' + (value.mes + '-' + value.year) + '">' +
                        '<td class="no-padding"> ' + tools.nombreMes(value.mes) + ' - ' + value.year + '</td>' +
                        '<td class="no-padding text-center">' + tools.formatMoney(monto) + '</td>' +
                        // '<td class="no-padding text-center"><button class="btn btn-danger btn-sm" onclick="removeCuota(\'' + (value.mes + '-' + value.year) + '\')"><i class="fa fa-trash"></i></button></td>' +
                        +'</tr>');
                    totalCuotas += parseFloat(monto);
                }
                $("#lblTotalCuotas").html("TOTAL DE " + (cuotas.length) + " CUOTAS: " + tools.formatMoney(totalCuotas));
                if (cuotas.length > 0) {
                    $("#lblNumeroCuotas").html("CUOTAS DEL: " + cuotas[0].mes + "/" + cuotas[0].year + " al " + cuotas[cuotas.length - 1].mes + "/" + cuotas[cuotas.length - 1].year);
                }
            } else {
                $("#tbCuotas").append('<tr class="text-center"><td colspan="3"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+Agregar) para más cuotas.</p></td></tr>');
                $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
            }
        }
    }

    function validateIngresoCuotas() {
        if (cuotas.length > 0) {
            removeIngresos(0, 1);
            removeIngresos(0, 2);
            removeIngresos(0, 3);
        }
        for (let value of cuotas) {
            for (let c of value.concepto) {
                if (!validateDuplicate(c.IdConcepto)) {
                    arrayIngresos.push({
                        "idConcepto": parseInt(c.IdConcepto),
                        "categoria": parseInt(c.Categoria),
                        "cantidad": 1,
                        "concepto": c.Concepto,
                        "precio": parseFloat(c.Precio),
                        "monto": parseFloat(c.Precio)
                    });
                } else {
                    for (let i = 0; i < arrayIngresos.length; i++) {
                        if (arrayIngresos[i].idConcepto == c.IdConcepto) {
                            let newConcepto = arrayIngresos[i];
                            newConcepto.categoria = parseInt(c.Categoria);
                            newConcepto.cantidad = newConcepto.cantidad + 1;
                            newConcepto.precio = c.Precio;
                            newConcepto.monto = parseFloat(newConcepto.precio) * parseFloat(newConcepto.cantidad)
                            arrayIngresos[i] = newConcepto;
                            break;
                        }
                    }
                }
            }
        }
        if (cuotas.length > 0) {
            cuotasEstate = true;
            cuotasInicio = cuotas[0].day + "/" + cuotas[0].mes + "/" + cuotas[0].year;
            cuotasFin = cuotas[cuotas.length - 1].day + "/" + cuotas[cuotas.length - 1].mes + "/" + cuotas[cuotas.length - 1].year;
        }
        addIngresos();
        $('#mdCuotas').modal('hide');
        countCurrentDate = 0;
    }

}
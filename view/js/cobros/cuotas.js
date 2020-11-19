function Cuotas() {

    this.componentesCuotas = function() {
        $("#btnCuotas").click(function() {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $('#mdCuotas').modal('show');
                loadCuotas(1);
            }

        });

        $("#btnCuotas").keypress(function(event) {
            if (idDNI == 0) {
                tools.AlertWarning("Cuotas", "No selecciono ningún ingeniero para obtener sus cuotas.")
            } else {
                $('#mdCuotas').modal('show');
                loadCuotas(1);
            }
            event.preventDefault();
        });
        $("#btnCuotaNormal").click(function() {
            $("#lblCuotasMensaje").html("Cuotas Ordinarias");
            loadCuotas(1);
        });

        $("#btnCuotaNormal").keypress(function(event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas Ordinarias");
                loadCuotas(1);
            }
            event.preventDefault();
        });

        $("#btnCuotaAmnistia").click(function() {
            $("#lblCuotasMensaje").html("Cuotas de Amnistia");
            loadCuotas(2);
        });

        $("#btnCuotaAmnistia").keypress(function(event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas de Amnistia");
                loadCuotas(2);
            }
            event.preventDefault();
        });

        $("#btnCuotaVitalicio").click(function() {
            $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
            loadCuotas(3);
        });

        $("#btnCuotaVitalicio").keypress(function(event) {
            if (event.keyCode === 13) {
                $("#lblCuotasMensaje").html("Cuotas de Vitalicio");
                loadCuotas(3);
            }
            event.preventDefault();
        });

        $("#selectall").on("click", function() {
            $(".cuotasid").attr("checked", this.checked);
        });

        $("#btnAddCuota").click(function() {
            addCuotas();
        });

        $("#btnAddCuota").keypress(function(event) {
            if (event.keyCode === 13) {
                addCuotas();
            }
            event.preventDefault();
        });

        $("#btnCloseCuotas").click(function() {
            $('#mdCuotas').modal('hide');
            countCurrentDate = 0;
        });

        $("#btnCancelarCuotas").click(function() {
            $('#mdCuotas').modal('hide');
            countCurrentDate = 0;
        });

        $("#btnAceptarCuotas").click(function() {
            validateIngresoCuotas();
        });

        $("#btnAceptarCuotas").keypress(function(event) {
            if (event.keyCode === 13) {
                validateIngresoCuotas();
            }
            event.preventDefault();
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
            beforeSend: function() {
                $("#tbCuotas").empty();
                $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><img src="./images/spiner.gif"/><p>cargando información.</p></td></tr>');
                cuotas.splice(0, cuotas.length);
            },
            success: function(result) {
                //console.log(result)
                if (result.estado === 1) {
                    $("#tbCuotas").empty();
                    cuotas = result.data;
                    if (cuotas.length > 0) {
                        let totalCuotas = 0;
                        for (let value of cuotas) {
                            let monto = 0;
                            for (let c of value.concepto) {
                                monto += parseFloat(c.Precio);
                            }
                            $("#tbCuotas").append('<tr >' +
                                '<td class="no-padding"><div><label><input type="checkbox" class="cuotasid" checked> ' + nombreMes(value.mes) + ' - ' + value.year + '</label></div></td>' +
                                '<td class="no-padding">' + tools.formatMoney(monto) + '</td>' +
                                +'</tr>');
                            totalCuotas += parseFloat(monto);
                        }
                        $("#lblTotalCuotas").html("TOTAL DE " + (cuotas.length) + " CUOTAS: " + tools.formatMoney(totalCuotas));
                        if (cuotas.length > 0) {
                            $("#lblNumeroCuotas").html("CUOTAS DEL: " + cuotas[0].mes + "/" + cuotas[0].year + " al " + cuotas[cuotas.length - 1].mes + "/" + cuotas[cuotas.length - 1].year);
                        }
                    } else {
                        $("#tbCuotas").append('<tr class="text-center"><td colspan="2"><img src="./images/ayuda.png" width="80"/><p>Cuotas al Día has click en boton (+add) para más cuotas.</p></td></tr>');
                        $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                        $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                    }
                } else {
                    $("#tbCuotas").empty();
                    $("#tbCuotas").append('<tr class="text-center"><p>No se pudo cargar la información, intente nuevamente.</p></td></tr>');
                    $("#lblTotalCuotas").html("TOTAL DE 0 CUOTAS: 0.00");
                    $("#lblNumeroCuotas").html("CUOTAS DEL: 00/0000 al 00/0000");
                }
            },
            error: function(error) {
                //  console.log(error);
                $("#tbCuotas").empty();
                $("#tbCuotas").append('<tr class="text-center"><p>Se produjo un error intente nuevamente o comuníquese con su proveedor.</p></td></tr>');
            }
        });
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
        console.log(cuotasInicio)
        console.log(cuotasFin)
        addIngresos();
        $('#mdCuotas').modal('hide');
        countCurrentDate = 0;
    }

}
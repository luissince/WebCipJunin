function Colegiatura() {
    this.componentesColegiatura = function() {
        $("#btnColegitura").click(function() {
            $('#mdColegiatura').modal('show');
            loadColegiatura();
        });

        $("#btnColegitura").keypress(function(event) {
            if (event.keyCode === 13) {
                $('#mdColegiatura').modal('show');
                loadColegiatura();
            }
            event.preventDefault();
        });

        $("#btnAceptarColegiatura").click(function() {
            validateIngresoColegiatura();
        });

        $("#btnAceptarColegiatura").keypress(function(event) {
            var keycode = event.keyCode || event.which;
            if (keycode == '13') {
                validateIngresoColegiatura();
            }
            event.preventDefault();
        });
    }

    function loadColegiatura() {
        $.ajax({
            url: "../app/controller/ConceptoController.php",
            method: "GET",
            data: {
                "type": "typecolegiatura",
                "categoria": 4
            },
            beforeSend: function() {
                $("#ctnConceptos").empty();
                colegiaturas.splice(0, colegiaturas.length);
            },
            success: function(result) {
                if (result.estado === 1) {
                    let totalColegiatura = 0;
                    colegiaturas = result.data;
                    for (let value of colegiaturas) {
                        $("#ctnConceptos").append('<div id="' + value.idConcepto + '" class="row">' +
                            '<div class="col-md-8 text-left">' +
                            '<p>' + value.Concepto + '</p>' +
                            '</div>' +
                            '<div class="col-md-4 text-right">' +
                            '<p>' + tools.formatMoney(value.Precio) + '</panel>' +
                            '</div>');
                        totalColegiatura += parseFloat(value.Precio);
                    }
                    $("#lblTotalColegiatura").html(tools.formatMoney(totalColegiatura));
                } else {

                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    function validateIngresoColegiatura() {
        for (let value of colegiaturas) {
            if (!validateDuplicate(value.IdConcepto)) {
                arrayIngresos.push({
                    "idConcepto": parseInt(value.IdConcepto),
                    "categoria": parseInt(value.Categoria),
                    "cantidad": 1,
                    "concepto": value.Concepto,
                    "precio": parseFloat(value.Precio),
                    "monto": parseFloat(value.Precio)
                });
            } else {
                for (let i = 0; i < arrayIngresos.length; i++) {
                    if (arrayIngresos[i].idConcepto == value.IdConcepto) {
                        let newConcepto = arrayIngresos[i];
                        newConcepto.cantidad = newConcepto.cantidad + 1;
                        newConcepto.precio = value.Precio;
                        newConcepto.monto = parseFloat(newConcepto.precio) * parseFloat(newConcepto.cantidad)
                        arrayIngresos[i] = newConcepto;
                        break;
                    }
                }
            }
        }
        if (colegiaturas.length > 0) {
            colegiaturaEstado = true;
        }
        addIngresos();
        $('#mdColegiatura').modal('hide');
    }
}
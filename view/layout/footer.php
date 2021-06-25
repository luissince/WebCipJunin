<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Versión</b> 1.0.0
    </div>
    <strong>Copyright © 2020. <a class="text-primary" href="http://www.cip-junin.org.pe/" target="_blank">Colegio de Ingenieros del Perú - CD Junín.</a> </strong> Todos los derechos reservados.
</footer>
<script>
    $(document).ready(function() {
        $.ajax({
            url: "../app/controller/IngresoController.php",
            method: "GET",
            data: {
                "type": "notificaciones"
            },
            beforeSend: function() {

            },
            success: function(result) {
                if (result.estado == 1) {
                    $("#lblNumeroNotificaciones").html(result.data.length);
                    $("#lblTituloNotificaciones").html("Tiene " + result.data.length + " notificaciones")
                    for (let value of result.data) {
                        $("#ulListaNotificaciones").append('<li>' +
                            '<a href="notificaciones.php"><i class="fa fa-hand-paper-o text-aqua"></i> ' + value.Cantidad + ' ' + value.Nombre + ' - ' + value.Estado +  '</a>' +
                            '</li>');
                    }
                } else {
                    $("#lblNumeroNotificaciones").html(0);
                    $("#lblTituloNotificaciones").html("Tiene 0 notificaciones")
                }

            },
            error: function(error) {
                $("#lblNumeroNotificaciones").html(0);
                $("#lblTituloNotificaciones").html("Tiene 0 notificaciones")
            }
        });
    });
</script>
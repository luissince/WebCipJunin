<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('./layout/head.php'); ?>

</head>

<body
    style='background-image: url("images/inicio.jpg"); height: auto;background-repeat: no-repeat;min-height: 100vh;background-position: center center;background-size: cover;'>
    <section class="content">
        <style type="text/css">
        #caja {
            min-height: 410px;
            background-color: #FFFFFF;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.15), 0 0 1px 1px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        </style>
        <br>
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="caja">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-md-2 col-sm-4 col-xs-12" style="display:flex;justify-content:center;">
                        <img src="images/logologin.png" class="img-responsive" width="120">
                    </div>
                    <div class="col-md-10 col-sm-8 col-xs-12"
                        style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
                        <h3 style="color:#b72928;">COLEGIO DE INGENIEROS DEL PERÚ</h3>
                        <h4 style="color:#222a35;">JUNÍN</h4>
                    </div>
                </div>
                <div class="row" style="padding: 15px;">
                    <div class="col-lg-12"
                        style="background-color: #2A2A28;color: #D8B66D;padding: 10px;text-align: center;font-size: 12pt;">
                        I N G R E S A R <span style="margin-left: 7px;margin-right: 7px;"> A L</span> S I S T E M A
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="text-align: center;padding: 10px;">
                        <img src="images/login.gif" width="90%" style="border-radius: 5px;">
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <br>
                        <div method="POST" action="./home.php" class="form-horizontal">

                            <div class="form-group" style="padding: 5px;">
                                <label class="col-lg-3 control-label" style="color:#51504E;">Usuario :</label>
                                <div class="col-lg-8">
                                    <input id="txtUsuario" type="login" class="form-control is-invalid"
                                        name="txtUsuario" value="" required autocomplete="login" autofocus
                                        placeholder="Usuario">
                                    <span class="invalid-feedback">
                                        <small style="color: #DC3545;font-size: 11pt;font-style: italic;">
                                        </small>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" style="padding: 5px;">
                                <label class="col-lg-3 control-label" style="color:#51504E;">Contraseña :</label>
                                <div class="col-lg-8">
                                    <input id="txtClave" type="password" class="form-control is-invalid" name="txtClave"
                                        required autocomplete="current-password" placeholder="Contraseña">
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group" style="padding: 2px;">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8">
                                    <button class="btn btn-default" id="btnIngresar" style="color: #E31E25;"> I N G R E
                                        S A R </button>
                                </div>
                            </div>

                            </form>
                        </div>
                    </div>

                    <hr>
                    <p style="text-align: center;font-size: 11pt;color: #46433C;">
                        <i class="fa fa-map-marker" style="color: #E31E25;"></i> <small style="margin-right: 10px;"> Av.
                            Centenario 604 – Urb. San Carlos Huancayo</small>
                        <i class="fa fa-phone" style="color: #E31E25;"></i> <small>(064) - 203033</small>
                    </p>

                </div>
            </div>

    </section>
    <script src="js/tools.js"></script>
    <script>
    let tools = new Tools();
    let state = false;

    $(document).ready(function() {

        $("#btnIngresar").click(function() {
            login()
        })
    })

    function login() {
        if ($("#txtUsuario").val() == '') {
            tools.AlertWarning('Mensaje', "Ingrese un usuario por favor");
            $("#txtUsuario").focus();
        } else if ($("#txtClave").val() == '') {
            tools.AlertWarning('Mensaje', "Ingrese una contraseña por favor");
            $("#txtClave").focus();
        } else {
            
            $.ajax({
                url: "../app/controller/UsuarioController.php",
                method: "GET",
                data: {
                    "type": "login",
                    "usuario": $("#txtUsuario").val(),
                    "clave": $("#txtClave").val() 
                },
                beforeSend: function() {
                    state = true;
                },
                success: function(result) {
                    // console.log(result)
                    if (result.estado === 1) {
                        let dato = result.datos

                         // window.open("../view/home.php")
                        tools.AlertSuccess('Mensaje', 'Bienvenido al Sistema '+dato.Apellidos+' '+dato.Nombres)
                        state = false;                        
                        setTimeout(function() {
                            location.href = "../view/home.php"
                        }, 1000);             
                    } else {
                        tools.AlertInfo('Mensaje', 'Usuario o contraseña incorrecto(s)')
                        $("#txtUsuario").val('')
                        $("#txtClave").val('')
                        $("#txtUsuario").focus();
                        state = false;
                    }
                },
                error: function(error) {
                    
                    // $("#lblPaginaActual").html(0);
                    // $("#lblPaginaSiguiente").html(0);
                    state = false;
                }
            });
        }
    }
    </script>
</body>

</html>
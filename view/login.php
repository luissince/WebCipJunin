<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/insignia.png">
    <title>CIPJUNIN LOGIN </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="adminlte/bower_components/bootstrap/dist/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="adminlte/bower_components/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="recursoselect/dist/css/bootstrap-select.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="adminlte/dist/css/skins/_all-skins.min.css">

    <!-- jQuery 3 -->
    <script src="adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="recursoselect/dist/js/bootstrap-select.js" defer></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="adminlte/bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <!-- FastClick -->
    <script src="adminlte/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="adminlte/dist/js/adminlte.min.js"></script>
    <!-- Sparkline -->
    <script src="adminlte/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap  -->
    <script src="adminlte/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="adminlte/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- SlimScroll -->
    <script src="adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- ChartJS -->
    <script src="adminlte/bower_components/chart.js/Chart.js"></script>

    <!-- AdminLTE for demo purposes -->
    <script src="adminlte/dist/js/demo.js"></script>
    <script src="js/moment.min.js"></script>
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        input[type="text"],
        input[type="email"],
        input[type="number"],
        input[type="date"],
        input[type="login"],
        input[type="password"] {
            border-radius: 5px;
        }
    </style>

</head>

<body style='background-image: url("images/inicio.jpg"); height: auto;background-repeat: no-repeat;min-height: 100vh;background-position: center center;background-size: cover;'>
    <section class="content">
        <style type="text/css">
            #caja {
                min-height: 410px;
                background-color: #FFFFFF;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.15), 0 0 1px 1px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
                padding: 10px 0;
            }
        </style>
        <br>
        <div class="row" style="padding: 30px;">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12"></div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="caja">
                <div class="row" style="text-align: center;">

                    <img src="images/logologin.png" width="80%" style="border-radius: 5px;">
                </div>
                <div class="row" style="padding: 15px;">
                    <div class="col-lg-12" style="background-color: #2A2A28;color: #D8B66D;padding: 10px;text-align: center;font-size: 12pt;">
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
                                    <input id="login" type="login" class="form-control is-invalid" name="login" value="" required autocomplete="login" autofocus placeholder="Usuario">
                                    <span class="invalid-feedback">
                                        <small style="color: #DC3545;font-size: 11pt;font-style: italic;">
                                        </small>
                                    </span>                              
                                </div>
                            </div>

                            <div class="form-group" style="padding: 5px;">
                                <label class="col-lg-3 control-label" style="color:#51504E;">Contraseña :</label>
                                <div class="col-lg-8">
                                    <input id="password" type="password" class="form-control is-invalid" name="password" required autocomplete="current-password" placeholder="Contraseña">
                                    <span class="invalid-feedback" role="alert">
                                        <strong></strong>
                                    </span>                                  
                                </div>
                            </div>

                            <div class="form-group" style="padding: 2px;">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-8">
                                    <button class="btn btn-default" id="btningresar" style="color: #E31E25;"> I N G R E S A R </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

                <hr>
                <p style="text-align: center;font-size: 11pt;color: #46433C;">
                    <i class="fa fa-map-marker" style="color: #E31E25;"></i> <small style="margin-right: 10px;"> Av. Centenario 604 – Urb. San Carlos Huancayo</small>
                    <i class="fa fa-phone" style="color: #E31E25;"></i> <small>(064) - 203033</small>
                </p>

            </div>
        </div>

    </section>
</body>

</html>
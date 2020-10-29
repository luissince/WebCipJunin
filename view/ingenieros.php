<!DOCTYPE html>
<html lang="es">

<head>
    <?php include('./layout/head.php'); ?>

</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <!-- start header -->
        <?php include('./layout/header.php') ?>
        <!-- end header -->
        <!-- start menu -->
        <?php include('./layout/menu.php') ?>
        <!-- end menu -->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: #FFFFFF;">
            <!-- Main content -->
            <section class="content">

                <div class="row">
                    <div class="modal fade" id="confirmar">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Registrar Ingeniero</h4>
                                </div>
                                {!! Form::open(['route'=>'ingenieros.store','method'=>'POST']) !!}
                                <!--<input type="hidden" name="Usuario" value="{{ Auth::user()->id }}"> -->
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12" style="text-align: center;">
                                            <img width="70" src="images/ayuda.png">
                                            <!-- <label for="Foto">Subir foto</label>
                                            <input type="file" id="Foto" name="Foto"> -->
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="dni">DNI: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="dni" type="number" name="Dni" class="form-control" placeholder="DNI" required="" maxlength="8" minlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="Nombres">Nombres: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="Nombres" type="text" name="Nombres" class="form-control" placeholder="Nombres" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="Apellidos">Apellidos: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="Genero">Genero: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <select id="Genero" class="form-control" >
                                                            <option>Maculino</option>
                                                            <option>Femenino</option>
                                                            <option>Otros</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="Nacimiento">Nacimiento: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="Nacimiento" type="date" name="Nacimiento" class="form-control" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                                    <div class="form-group">
                                                        <label for="Estado_civil">Estado civil: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <select id="Estado_civil" class="form-control" >
                                                            <option>Soltero/a</option>
                                                            <option>Casado/a</option>
                                                            <option>Viudo/a</option>
                                                            <option>Divorciado/a</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="Ruc">RUC (opcional):</label>
                                                        <input id="Ruc" type="text" name="Ruc" class="form-control" placeholder="número de RUC" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <label for="Apellidos">Razon social:</label>
                                                        <input id="Apellidos" type="text" name="Apellidos" class="form-control" placeholder="Apellidos" required="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="form-group">
                                                        <label for="Codigo">Codigo CIP: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <input id="Codigo" type="number" name="Codigo" class="form-control" placeholder="Codigo" required="">
                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                                                    <div class="form-group">
                                                        <label for="Condición">Condición: <i class="fa fa-fw fa-asterisk text-danger"></i></label>
                                                        <select id="Condición" class="form-control" >
                                                            <option>Vitalicio</option>
                                                            <option>Otros</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                                    <div class="form-group">
                                                        <label for="Tramite">Tramite:</label>
                                                        <div class="text-center">
                                                            <input id="Tramite" type="checkbox" name="tramite" value="true" required="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-left text-danger">Todos los campos marcados con <i class="fa fa-fw fa-asterisk text-danger"></i> son obligatorios</p>
                                    <button type="submit" class="btn btn-warning" name="btnAceptar" id="btnaceptar">
                                        <i class="fa fa-check"></i> Aceptar</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">
                                        <i class="fa fa-remove"></i> Cancelar</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <button type="button" class="btn btn-warning" style="margin-right: 10px;" data-toggle="modal" data-target="#confirmar">
                            <i class="fa fa-plus"></i> Nuevo Ingeniero
                        </button>
                        <a href="{{route('ingenieros.index')}}" class="btn btn-link">
                            <i class="fa fa-refresh"></i> Actualizar..
                        </a>
                    </div>
                  
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="margin-right: -10px;">
                        <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <input type="text" name="buscar" class="form-control" placeholder="Buscar Ingeniero..." aria-describedby="search" value="{{ $valbuscar }}" style="border-radius: 5px;">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
                        <button class="btn btn-default col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <i class="fa fa-search"></i> Buscar
                        </button>
                    </div>
                   
                </div>
                <hr style="margin-top: 5px;">
                <div class="row" style="margin-top: -5px;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table class="table table-striped" style="border-width: 1px;border-style: dashed;border-color: #E31E25;">
                            <thead style="background-color: #FDB2B1;color: #B72928;">
                                <th style="text-align: center;">#</th>
                                <th>DNI</th>
                                <th>Nombres y Apellidos</th>
                                <th>Estado Civil</th>
                                <th>RUC</th>
                                <th>CIP</th>
                                <th>Condicion</th>
                                <th>Opciones</th>
                            </thead>
                            <tbody>
                              
                                <tr>
                                    <td style="text-align: center;color: #2270D1;">
                                       
                                    
                                        <img src="{{ asset('images/masculino.png') }}" width="30">
                                        
                                        
                                    </td>
                                    <td>{{ $dato->idDNI }}</td>
                                    <td>{{ $dato->Nombres}} {{ $dato->Apellidos}} </td>
                                    <td>
                                        
                                    SOLTERO
                                        
                                    </td>
                                    <td>{{ $dato->RUC }}</td>
                                    <td>{{ $dato->CIP }}</td>
                                    <td>
                                       
                                    Ordinario
                                        
                                    </td>
                                    <td>
                                        <a href="{{route('ingenieros.edit',$dato->id)}}" class="btn btn-primary btn-sm">
                                            <i class="fa fa-wrench"></i> Editar
                                        </a>
                                        <form style="display: inline;" method="POST" action="{{route('ingenieros.destroy',$dato->id)}}">
                                            
                                        
                                            <button type="submit" onclick="return confirm('¿Seguro que desea ELIMINAR. ?')" class="btn btn-success btn-sm">
                                                <i class="fa fa-remove"></i> Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $viewDatos->render()!!}
                        </div>

                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- start footer -->
        <?php include('./layout/footer.php'); ?>;
        <!-- end footer -->
    </div>
    <!-- ./wrapper -->
</body>

</html>
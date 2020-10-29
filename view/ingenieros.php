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
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">DNI</label>
                                                        <input type="text" name="Dni" class="form-control" placeholder="DNI" required="" maxlength="8" minlength="8">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nombres y Apellidos</label>
                                                        <input type="text" name="Nombres" class="form-control" placeholder="Nombres y Apellidos" required="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Correo Electrónico</label>
                                                        <input type="email" name="Email" class="form-control" placeholder="Correo Electrónico" required="">
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
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
<div class="row">
    <div class="modal fade" id="mdIngenieros">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-close"></i>
                    </button>
                    <h4 class="modal-title">
                        <i class="fa fa-group">
                        </i> Lista de Ingenieros
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <button class="btn btn-danger" id="btnIzquierda">
                                <i class="fa fa-toggle-left"></i>
                            </button>
                            <span id="lblPaginaActual" class="font-weight-bold margin">0</span>
                            <span class="margin">a</span>
                            <span id="lblPaginaSiguiente" class="font-weight-bold margin">0</span>
                            <button class="btn btn-danger" id="btnDerecha">
                                <i class="fa fa-toggle-right"></i>
                            </button>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input type="search" id="txtBuscarIngeniero" class="form-control" placeholder="Buscar por información, n° cip o dni" aria-describedby="search">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12">
                            <button id="btnBuscarIngeniero" class="btn btn-default">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                    <div class="row" style="overflow-x: auto; height:280px">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-bordered table-sm">
                                <thead style="background: #337ab7;color: white;">
                                    <tr>
                                        <th style="text-align: center; vertical-align: middle;">#</th>
                                        <th style="text-align: center; vertical-align: middle;">Cip</th>
                                        <th style="text-align: center; vertical-align: middle;">Dni</th>
                                        <!-- <th style="text-align: center; vertical-align: middle;">Capitulo</th> -->
                                        <th style="text-align: center; vertical-align: middle;">Ingeniero</th>
                                        <th style="text-align: center; vertical-align: middle;">Condición</th>
                                        <th style="text-align: center; vertical-align: middle; ">Colegiatura/Incorpor.</th>
                                        <th style="text-align: center; vertical-align: middle;">Ultima Cuota</th>
                                        <th style="text-align: center; vertical-align: middle;">Debe</th>
                                    </tr>
                                </thead>
                                <tbody id="tbIngenieros">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 text-left">
                            <h5>
                                <i class="fa fa-info text-danger"></i> <b class="text-success">Para seleccionar un ingeniero has doble click sobre la fila</b>
                            </h5>
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <i class="fa fa-remove"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
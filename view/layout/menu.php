 <!-- Left side column. contains the logo and sidebar -->
 <aside class="main-sidebar">
     <!-- sidebar: style can be found in sidebar.less -->
     <section class="sidebar">
         <!-- Sidebar user panel -->
         <div class="user-panel">
             <div class="pull-left image">
                 <img src="images/usuario.png" class="img-circle" alt="Usuario">
             </div>

             <div class="pull-left info">
                 <p><?= $_SESSION["Nombre"]  ?></p>
                 <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
             </div>
         </div>
         <!-- search form -->
         <form action="#" method="get" class="sidebar-form">
             <div class="input-group">
                 <input type="text" name="q" class="form-control" placeholder="Buscar...">
                 <span class="input-group-btn">
                     <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                         <i class="fa fa-search"></i>
                     </button>
                 </span>
             </div>
         </form>
         <!-- /.search form -->
         <!-- sidebar menu: : style can be found in sidebar.less -->
         <ul class="sidebar-menu" data-widget="tree">
             <li class="header">Opciones</li>
             <?php
                if ($_SESSION["Permisos"][0]["ver"] == 1) {
                    print '<li>
                    <a href="./"><i class="fa fa-home"></i> <span>Inicio</span></a>
                </li>';
                }

                if ($_SESSION["Permisos"][1]["ver"] == 1) {
                    print ' <li>
                    <a href="./usuario.php"><i class="fa fa-laptop"></i> <span>Usuarios</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][2]["ver"] == 1) {
                    print '<li>
                    <a href="./roles.php"><i class="fa fa-table"></i> <span>Roles</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][3]["ver"] == 1) {
                    print '<li>
                    <a href="./ingresos.php"><i class="fa fa-sitemap"></i><span>Ingresos</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][4]["ver"] == 1) {
                    print '<li>
                    <a href="./capitulos.php"><i class="fa fa-clone"></i><span>Capítulos</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][5]["ver"] == 1) {
                    print '  <li>
                    <a href="./universidad.php"><i class="fa fa-bank"></i><span>Universidades</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][6]["ver"] == 1) {
                    print ' <li>
                    <a href="./conceptos.php"><i class="fa fa fa-list-alt"></i><span>Conceptos</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][7]["ver"] == 1) {
                    print '<li>
                    <a href="./ingenieros.php"><i class="fa fa-user"></i> <span>Ingenieros</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][8]["ver"] == 1) {
                    print '<li>
                    <a href="./cobros.php"><i class="fa fa-money"></i><span>Cobros</span></a>
                </li>';
                }
                if ($_SESSION["Permisos"][9]["ver"] == 1) {
                    print '  <li>
                    <a href="./reportes.php"><i class="fa fa-bar-chart"></i><span>Reportes</span></a>
                </li>';
                }
                ?>
              
     </section>
     <!-- /.sidebar -->
 </aside>
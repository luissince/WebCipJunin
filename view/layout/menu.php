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
                 <p>{{ Auth::user()->Usuario }}</p>
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
             <li>
                 <a href="#"><i class="fa fa-home"></i> <span>Inicio</span></a>
             </li>

             <li>
                 <a href="#"><i class="fa fa-laptop"></i> <span>Usuarios</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-sitemap"></i><span>Datos</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-clone"></i><span>Capítulos</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-bank"></i><span>Universidades</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-sort-amount-asc"></i><span>Conceptos</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-user"></i> <span>Ingenieros</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-money"></i><span>Cobros</span></a>
             </li>
             <li>
                 <a href="#"><i class="fa fa-bar-chart"></i><span>Reportes</span></a>
             </li>


     </section>
     <!-- /.sidebar -->
 </aside>
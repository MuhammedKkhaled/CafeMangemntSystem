 <!-- Sidebar -->
 <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
     <!-- Sidebar - Brand -->
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
         <div class="sidebar-brand-icon rotate-n-15">
             <i class="fas fa-laugh-wink"></i>
         </div>
         <div class="sidebar-brand-text mx-3"> AREA 51 CAFE</div>
     </a>

     <!-- Divider -->
     <hr class="sidebar-divider my-0" />

     <!-- Nav Item - Dashboard -->
     <?php
        if ($_SESSION['is_admin']) :
        ?>
         <li class="nav-item active">
             <a class="nav-link" href="UserDashboard.php">
                 <i class="fas fa-fw fa-bars"></i>
                 <span>الاصناف</span></a>
         </li>

     <?php
        else :
        ?>
         <li class="nav-item active">
             <a class="nav-link" href="UserDashboard.php">
                 <i class="fas fa-fw fa-bars"></i>
                 <span>الاصناف</span></a>
         </li>
     <?php
        endif;
        ?>
     <!-- Divider -->
     <!-- <hr class="sidebar-divider" /> -->

     <!-- Heading -->
     <!-- <div class="sidebar-heading">الصفحات</div> -->

     <!-- Nav Item - Pages Collapse Menu -->
     <!-- <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
             <i class="fas fa-fw fa-cog"></i>
             <span>اعدادات</span>
         </a>
         <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Custom Components:</h6>
                 <a class="collapse-item" href="buttons.html">Buttons</a>
                 <a class="collapse-item" href="cards.html">Cards</a>
             </div>
         </div>
     </li> -->

     <!-- Nav Item - Utilities Collapse Menu -->
     <!-- <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
             <i class="fas fa-fw fa-wrench"></i>
             <span>تغييرات </span>
         </a>
         <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Utilities:</h6>
                 <a class="collapse-item" href="utilities-color.html">Colors</a>
                 <a class="collapse-item" href="utilities-border.html">Borders</a>
                 <a class="collapse-item" href="utilities-animation.html">Animations</a>
                 <a class="collapse-item" href="utilities-other.html">Other</a>
             </div>
         </div>
     </li> -->

     <?php

        if (!$_SESSION['is_admin']) {


        ?>
         <!-- Divider -->
         <hr class="sidebar-divider" />

         <!-- Heading -->
         <div class="sidebar-heading">الصفحات</div>

         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>صفحات</span>
             </a>
             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <!-- <h6 class="collapse-header">اخري</h6> -->
                     <a class="collapse-item" href="cafe.php">تيك اوي </a>
                     <a class="collapse-item" href="foodcar.php"> في المحل </a>
                     <a class="collapse-item" href="playstaion.php">بلاستيشن </a>
                     <!-- <div class="collapse-divider"></div>
                     <h6 class="collapse-header">صفحات اخري</h6>
                     <a class="collapse-item" href="404.html">404 Page</a>
                     <a class="collapse-item" href="blank.html">Blank Page</a> -->
                 </div>
             </div>
         </li>
     <?php } else {
        ?>
         <!-- Divider -->
         <hr class="sidebar-divider" />

         <!-- Heading -->
         <div class="sidebar-heading">الصفحات</div>

         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
             <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                 <i class="fas fa-fw fa-folder"></i>
                 <span>صفحات</span>
             </a>
             <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                 <div class="bg-white py-2 collapse-inner rounded">
                     <!-- <h6 class="collapse-header">اخري</h6> -->
                     <a class="collapse-item" href="cafe.php">تيك اوي </a>
                     <a class="collapse-item" href="foodcar.php"> في المحل</a>
                     <a class="collapse-item" href="playstaion.php">بلاستيشن </a>
                     <div class="collapse-divider"></div>
                     <h6 class="collapse-header">صفحات اخري</h6>
                     <a class="collapse-item" href="users.php">مستخدمين </a>
                     <a class="collapse-item" href="cafeMenu.php">منيو الكافيه</a>
                     <a class="collapse-item" href="playstationMenu.php">منيو البلاستيشن</a>
                     <a class="collapse-item" href="carFoodMenu.php">منيو العربية </a>
                 </div>
             </div>
         </li>
     <?php } ?>
     <!-- Nav Item - Charts -->
     <li class="nav-item">
         <a class="nav-link" href="#">
             <i class="fas fa-fw fa-chart-area"></i>
             <span>البيانات والتقارير</span></a>
     </li>

     <!-- Nav Item - Tables -->
     <li class="nav-item">
         <a class="nav-link" href="stock.php">
             <i class="fas fa-fw fa-table"></i>
             <span>المخازن</span></a>
     </li>

     <!-- Divider -->
     <hr class="sidebar-divider d-none d-md-block" />

     <!-- Sidebar Toggler (Sidebar) -->
     <div class="text-center d-none d-md-inline">
         <button class="rounded-circle border-0" id="sidebarToggle"></button>
     </div>
 </ul>
 <!-- End of Sidebar -->
 <div id="content-wrapper" class="d-flex flex-column">
     <!-- Main Content -->
     <div id="content">
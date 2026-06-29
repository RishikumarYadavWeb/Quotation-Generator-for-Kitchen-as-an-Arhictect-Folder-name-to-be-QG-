<?php
    $current_page = basename($_SERVER['PHP_SELF']);
    $current_uri = $_SERVER['REQUEST_URI'];
    function isActive(string $needle,string $current_uri): string{
        return strpos($current_uri, $needle) !== false ? 'active-link' : '';
    }
    function menuItem(string $href, string $icon, string $label, string $activeClass): void{
        echo '
        <li>
            <a href="'.$href.'" class="'.$activeClass.'">
                <i class="'.$icon.'" style="margin-right:10px;"></i>
                <span>'.$label.'</span>
            </a>
        </li>
        ';
    }
?>
<button class="mobile-menu-btn" onclick="openSidebar()">
    <i class="fa-solid fa-bars"></i>
</button>
<div class="sidebar-overlay" onclick="closeSidebar()"></div>
<div class="sidebar-fixed">
    <button class="close-sidebar-btn" onclick="closeSidebar()">
        <i class="fa-solid fa-xmark"></i>
    </button>
    <!-- <div class="logo-section"> <img src="/QG/assets/images/crafted-logo.png" class="logo-img" alt="Company Logo" loading="lazy" style="filter:brightness(0) invert(1);"></div> -->
    <ul class="sidebar-menu">
        <!-- Dashboard -->
        <?php
            if(
                can('dashboard_view') || can('crdashboard_view') || can('frdashboard_view')
            ){
                echo '<li class="menu-title">Main</li>';
            }
            if(can('dashboard_view')){
                menuItem(
                    '/QG/dashboard.php',
                    'fa-solid fa-house',
                    'Dashboard',
                    $current_page == 'dashboard.php' ? 'active-link' : ''
                );
            }
            if(can('crdashboard_view')){
                menuItem(
                    '/QG/crdashboard.php',
                    'fa-solid fa-house',
                    'craftreD Dashboard',
                    $current_page == 'crdashboard.php' ? 'active-link' : ''
                );
            }
            if(can('frdashboard_view')){
                menuItem(
                    '/QG/frdashboard.php',
                    'fa-solid fa-house',
                    'F&R Dashboard',
                    $current_page == 'frdashboard.php' ? 'active-link' : ''
                );
            }
            /* COMPANY */
            if(can('company_view')){
                echo '<li class="menu-title">craftRed Details</li>';
                menuItem(
                    '/QG/company/view.php',
                    'fa-solid fa-building',
                    'Company Details',
                    isActive('/company/', $current_uri)
                );
            }
            /* REPORTS */
            if(can('pr_view')){
                echo '<li class="menu-title">Reports</li>';
                menuItem(
                    '/QG/financial-reports/manage.php',
                    'fa-solid fa-house',
                    'Orders',
                    isActive('/financial-reports/', $current_uri)
                );
            }
            /* PROJECTS */
            if(
                can('quotation_create') || can('quotation_view')
            ){
                echo '<li class="menu-title">Projects</li>';
            }
            if(can('quotation_create')){
                menuItem(
                    '/QG/quotations/create.php',
                    'fa-solid fa-plus',
                    'New Project',
                    isActive('/quotations/create.php', $current_uri)
                );
            }
            if(can('quotation_view')){
                menuItem(
                    '/QG/quotations/manage.php',
                    'fa-solid fa-folder-open',
                    'Manage Projects',
                    isActive('/quotations/manage.php', $current_uri)
                );
            }
            /* USER MANAGEMENT */
            if(
                can('users_view') || can('roles_view') || can('permissions_manage')
            ){
                echo '<li class="menu-title">User Management</li>';
            }
            if(can('users_view')){
                menuItem(
                    '/QG/users/manage.php',
                    'fa-solid fa-users',
                    'Users',
                    isActive('/users/', $current_uri)
                );
            }
            if(can('roles_view')){
                menuItem(
                    '/QG/roles/manage.php',
                    'fa-solid fa-user-shield',
                    'Roles',
                    isActive('/roles/', $current_uri)
                );
            }
            if(can('permissions_manage')){
                menuItem(
                    '/QG/permissions/manage.php',
                    'fa-solid fa-lock',
                    'Permissions',
                    isActive('/permissions/', $current_uri)
                );
            }
            /* MASTERS */
            if( 
                can('drawers_view') || can('shelves_view') || can('materials_view')
            ){
                echo '<li class="menu-title">Masters</li>';
            }
            /* CARCASS CATEGORIES */
            if(can('carcass_view')){
                menuItem(
                    '/QG/materials/carcass/categories/manage.php',
                    'fa-solid fa-border-all',
                    'Carcass Categories',
                    isActive('/carcass-categories/', $current_uri)
                );
            }
            /* CARCASS MATERIALS */
            if(can('carcass_view')){
                menuItem(
                    '/QG/materials/carcass/manage.php',
                    'fa-solid fa-cube',
                    'Carcass Materials',
                    isActive('/carcass-materials/', $current_uri)
                );
            }
            /* SHUTTER CATEGORIES */
            if(can('shutter_view')){
                menuItem(
                    '/QG/materials/shutter/categories/manage.php',
                    'fa-solid fa-list',
                    'Shutter Categories',
                    isActive('/shutter-categories/', $current_uri)
                );
            }
            /* SHUTTER MATERIALS */
            if(can('shutter_view')){
                menuItem(
                    '/QG/materials/shutter/materials/manage.php',
                    'fa-solid fa-table-columns',
                    'Shutter Materials',
                    isActive('/shutter-materials/', $current_uri)
                );
            }
            /* DRAWER CATEGORIES */
            if(can('drawers_view')){
                menuItem(
                    '/QG/drawer-categories/manage.php',
                    'fa-solid fa-table-cells-large',
                    'Drawer Categories',
                    isActive('/drawer-categories/', $current_uri)
                );
            }
            /* DRAWER MATERIALS */
            if(can('drawers_view')){
                menuItem(
                    '/QG/drawer-materials/manage.php',
                    'fa-solid fa-box-open',
                    'Drawer Materials',
                    isActive('/drawer-materials/', $current_uri)
                );
            }
            /* SHELF CATEGORIES */
            if(can('shelves_view')){
                menuItem(
                    '/QG/shelf-categories/manage.php',
                    'fa-solid fa-layer-group',
                    'Shelf Categories',
                    isActive('/shelf-categories/', $current_uri)
                );
            }
            /* SHELF MATERIALS */
            if(can('shelves_view')){
                menuItem(
                    '/QG/shelf-materials/manage.php',
                    'fa-solid fa-cubes',
                    'Shelf Materials',
                    isActive('/shelf-materials/', $current_uri)
                );
            }
            /* ACCESSORIES */
            if(can('accessories_view')){
                menuItem(
                    '/QG/accessories/manage.php',
                    'fa-solid fa-layer-group',
                    'Accessories',
                    isActive('/accessories/', $current_uri)
                );
            }
        ?>
        <!-- LOGOUT -->
        <li class="">
            <a href="/QG/standard-accessories/materials/index.php">
                <i class="fa-solid fa-right-from-bracket" style="margin-right:10px;"></i>
                <span>Standard Accessories</span>
            </a>
        </li>
        <!-- LOGOUT -->
        <li class="logout-item">
            <a href="/QG/auth/logout.php" onclick="return confirm('Logout from ERP?')">
                <i class="fa-solid fa-right-from-bracket" style="margin-right:10px;"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</div>
<!-- MAIN CONTENT -->
<main>
    <div class="main-content">
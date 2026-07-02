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
    <i class="fa-solid fa-bars" style="position: absolute;left: 15px;top: 12px;"></i>
</button>
<div class="sidebar-overlay" onclick="closeSidebar()"></div>
<div class="sidebar-fixed">
    <button class="close-sidebar-btn" onclick="closeSidebar()">
        <i class="fa-solid fa-xmark" style="position: absolute;left: 15px;top: 12px;"></i>
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
        ?>
        <?php
        if( 
            can('drawers_view') || can('shelves_view') || can('materials_view')
        ){
            echo '<li class="menu-title">Masters</li>';
        }
        if(can('carcass_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-cube" style="margin-right:10px;"></i>Carcass</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="/QG/materials/carcass/categories/manage.php" class="<?= isActive('/materials/carcass/categories/', $current_uri) ?>">Categories</a></li>
                <li><a href="/QG/materials/carcass/manage.php" class="<?= isActive('/materials/carcass/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(can('shutter_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-table-columns" style="margin-right:10px;"></i>Shutter</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li> <a href="/QG/materials/shutter/categories/manage.php" class="<?= isActive('/materials/shutter/categories/', $current_uri) ?>">Categories</a></li>
                <li> <a href="/QG/materials/shutter/materials/manage.php" class="<?= isActive('/materials/shutter/materials/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(can('drawers_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-box-open" style="margin-right:10px;"></i>Drawers</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="/QG/drawer-categories/manage.php" class="<?= isActive('/drawer-categories/', $current_uri) ?>">Categories</a></li>
                <li><a href="/QG/drawer-materials/manage.php" class="<?= isActive('/drawer-materials/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(can('shelves_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-layer-group" style="margin-right:10px;"></i>Shelves</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="/QG/shelf-categories/manage.php" class="<?= isActive('/shelf-categories/', $current_uri) ?>">Categories</a></li>
                <li><a href="/QG/shelf-materials/manage.php" class="<?= isActive('/shelf-materials/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(can('accessories_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-toolbox" style="margin-right:10px;"></i>Standard Accessories</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="/QG/standard-accessories/index.php" class="<?= isActive('/standard-accessories/', $current_uri) ?>">Categories</a></li>
                <li><a href="/QG/standard-accessories/materials/index.php" class="<?= isActive('/standard-accessories/materials/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
        <?php if(can('accessories_view')){ ?>
        <li class="sidebar-dropdown">
            <a href="#">
                <span><i class="fa-solid fa-screwdriver-wrench" style="margin-right:10px;"></i>Accessories</span>
                <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="submenu">
                <li><a href="/QG/accessory-categories/manage.php" class="<?= isActive('/accessory-categories/', $current_uri) ?>">Categories</a></li>
                <li><a href="/QG/accessories/manage.php" class="<?= isActive('/accessories/', $current_uri) ?>">Materials</a></li>
            </ul>
        </li>
        <?php } ?>
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
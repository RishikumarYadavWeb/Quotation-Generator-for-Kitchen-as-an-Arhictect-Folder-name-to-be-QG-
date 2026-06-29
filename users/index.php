
<?php

include '../includes/auth.php';

include '../includes/header.php';

include '../includes/sidebar.php';

?>

<div class="user-module-wrapper">

    <!-- =========================================
        HEADER
    ========================================== -->

    <div class="user-module-header">

        <div>

            <h1>

                User Management

            </h1>

            <p>

                Manage users, roles and permissions

            </p>

        </div>

    </div>

    <!-- =========================================
        GRID
    ========================================== -->

    <div class="user-module-grid">

        <!-- MANAGE USERS -->

        <a
            href="manage.php"
            class="user-module-card"
        >

            <div class="user-module-icon">

                <i class="fa-solid fa-users"></i>

            </div>

            <div>

                <div class="user-module-title">

                    Manage Users

                </div>

                <div class="user-module-desc">

                    Create, edit and manage users

                </div>

            </div>

        </a>


        <!-- ROLES -->

        <a
            href="../roles/manage.php"
            class="user-module-card"
        >

            <div class="user-module-icon">

                <i class="fa-solid fa-user-shield"></i>

            </div>

            <div>

                <div class="user-module-title">

                    Roles & Permissions

                </div>

                <div class="user-module-desc">

                    Manage access control system

                </div>

            </div>

        </a>

        <!-- VIEW ROLES -->

        <a
            href="../roles/manage.php"
            class="user-module-card"
        >

            <div class="user-module-icon">

                <i class="fa-solid fa-shield-halved"></i>

            </div>

            <div>

                <div class="user-module-title">

                    View Roles

                </div>

                <div class="user-module-desc">

                    View all system roles

                </div>

            </div>

        </a>

        <a
            href="../permissions/manage.php"
            class="user-module-card"
        >

            <div class="user-module-icon">

                <i class="fa-solid fa-shield-halved"></i>

            </div>

            <div>

                <div class="user-module-title">

                    Manage Permissions

                </div>

                <div class="user-module-desc">

                    View all system roles

                </div>

            </div>

        </a>

    </div>

</div>

<?php
include '../includes/footer.php';
?>
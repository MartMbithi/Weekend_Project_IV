<?php
if ($_SESSION['user_access_level'] == "admin") { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="dashboard" class="brand-link">
            <img src="../assets/upload/logo.png" alt="" class="brand-image img-circle elevation-4 border-success">
            <span class="brand-text font-weight-bold">House Rental MIS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="dashboard" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="users_landlords" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Landlords</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="users_caretakers" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="users_tenants" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Tenants</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="users_staffs" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Staffs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="property_categories" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Properties Categories
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Properties
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="properties_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Property</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="properties_assign_caretakers" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Assign Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="properties_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Properties</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Property Leases
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="leases_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Lease</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="leases_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Leases</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Rent Collections
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="rent_collections" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Payments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="rent_collections_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Payments</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="expenses" class="nav-link">
                            <i class="nav-icon fas fa-money-bill-alt"></i>
                            <p>
                                Expenses
                            </p>
                        </a>
                    </li>
                    <li class="nav-header text-warning">Reports</li>
                    <li class="nav-item">
                        <a href="reports_revenue" class="nav-link">
                            <i class="nav-icon fas fa-funnel-dollar"></i>
                            <p>
                                Revenue Reports
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports_expenditures" class="nav-link">
                            <i class="nav-icon fas fa-money-check"></i>
                            <p>
                                Expenditure Reports
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports_properties" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                Properties
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports_leases" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Leases
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>
                                Users Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="user_reports?user=landlord" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Landlords</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_reports?user=caretaker" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_reports?user=tenant" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Tenants</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_reports?user=staff" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Staffs</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php } elseif ($_SESSION['user_access_level'] == "staff") { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="dashboard" class="brand-link">
            <img src="../assets/upload/logo.png" alt="" class="brand-image img-circle elevation-4 border-success">
            <span class="brand-text font-weight-bold">House Rental MIS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="dashboard" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="users_landlords" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Landlords</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="users_caretakers" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="users_tenants" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Tenants</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="property_categories" class="nav-link">
                            <i class="nav-icon fas fa-sitemap"></i>
                            <p>
                                Properties Categories
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Properties
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="properties_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Property</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="properties_assign_caretakers" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Assign Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="properties_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Properties</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Property Leases
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="leases_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Lease</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="leases_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Leases</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header text-warning">Reports</li>
                    <li class="nav-item">
                        <a href="reports_properties" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                Properties
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="reports_leases" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Leases
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-tag"></i>
                            <p>
                                Users Reports
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="user_reports?user=landlord" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Landlords</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_reports?user=caretaker" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="user_reports?user=tenant" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Tenants</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php } elseif ($_SESSION['user_access_level'] == "landlord") { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="landlord_dashboard" class="brand-link">
            <img src="../assets/upload/logo.png" alt="" class="brand-image img-circle elevation-4 border-success">
            <span class="brand-text font-weight-bold">House Rental MIS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="landlord_dashboard" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tree"></i>
                            <p>
                                Properties
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="landlord_properties_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Property</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="landlord_assign_caretakers" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Assign Caretakers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="landlord_manage_properties" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Properties</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Property Leases
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="landlord_leases_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Lease</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="landlord_leases_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Leases</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-hand-holding-usd"></i>
                            <p>
                                Rent Collections
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="landlord_rent_collections" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Payments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="landlord_rent_collections_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Payments</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-header text-warning">Reports</li>
                    <li class="nav-item">
                        <a href="landlord_reports_revenue" class="nav-link">
                            <i class="nav-icon fas fa-funnel-dollar"></i>
                            <p>
                                Revenue Reports
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="landlord_reports_properties" class="nav-link">
                            <i class="nav-icon fas fa-hotel"></i>
                            <p>
                                Properties
                            </p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="landlord_reports_leases" class="nav-link">
                            <i class="nav-icon fas fa-handshake"></i>
                            <p>
                                Leases
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php } elseif ($_SESSION['user_access_level'] == "tenant") { ?>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="my_dashboard" class="brand-link">
            <img src="../assets/upload/logo.png" alt="" class="brand-image img-circle elevation-4 border-success">
            <span class="brand-text font-weight-bold">House Rental MIS</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item">
                        <a href="my_dashboard" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-edit"></i>
                            <p>
                                Property Leases
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="tenant_leases_add" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add Lease</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="tenant_leases_manage" class="nav-link">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Manage Leases</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="tenant_reports_revenue" class="nav-link">
                            <i class="nav-icon fas fa-funnel-dollar"></i>
                            <p>
                                Rent Payments
                            </p>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
<?php } ?>
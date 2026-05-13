<aside class="app-sidebar bg-primary-subtle shadow" data-bs-theme="dark">
            <div class="sidebar-brand"><a href="dashboard.php" class="brand-link"><img src="img/alumni_plp_header_3.png" alt="AASICT Logo" class="brand-image shadow"> </a></div>
            <?php
            $activePage = basename($_SERVER['PHP_SELF'], ".php");
            ?>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item"> <a href="dashboard.php" class="nav-link <?= ($activePage == 'dashboard') ? 'active':''; ?>"> <i class="nav-icon bi bi-speedometer"></i><p>Dashboard</p></a></li>
                        <li class="nav-item"> <a href="#" class="nav-link <?= ($activePage == 'add_alumnus') || ($activePage == 'all_alumni') ? 'active':''; ?>"> <i class="nav-icon bi bi-people"></i><p>Manage Alumni<i class="nav-arrow bi bi-chevron-right"></i></p></a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="add_alumnus.php" class="nav-link <?= ($activePage == 'add_alumnus') ? 'active':''; ?>"> <i class="nav-icon bi bi-circle"></i><p>Add Alumnus</p></a> </li>
                                <li class="nav-item"> <a href="all_alumni.php" class="nav-link <?= ($activePage == 'all_alumni') ? 'active':''; ?>"> <i class="nav-icon bi bi-circle"></i><p>All Alumni</p></a> </li>
                                <li class="nav-item"> <a href="archived_alumni.php" class="nav-link <?= ($activePage == 'archived_alumni') ? 'active':''; ?>"> <i class="nav-icon bi bi-circle"></i><p>Archived Alumni</p></a> </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="recovery_requests.php" class="nav-link <?= ($activePage == 'recovery_requests') ? 'active':''; ?>"> <i class="nav-icon bi bi-key"></i><p>View Recovery Requests</p></a></li>
                        <li class="nav-item"> <a href="audit_logs.php" class="nav-link <?= ($activePage == 'audit_logs') ? 'active':''; ?>"> <i class="nav-icon bi bi-file-earmark-text"></i><p>Audit logs</p></a></li>
                        <li class="nav-item"> <a href="import_alumni.php" class="nav-link <?= ($activePage == 'import_alumni') ? 'active':''; ?>"> <i class="bi bi-box-arrow-in-down"></i><p>Import Alumni</p></a></li>
                        <li class="nav-item"> <a href="tickets.php" class="nav-link <?= ($activePage == 'tickets') ? 'active':''; ?>"> <i class="bi bi-ticket-perforated"></i><p>Support</p></a></li>
                        <li class="nav-item"> <a href="profile.php" class="nav-link <?= ($activePage == 'profile') ? 'active':''; ?>"> <i class="nav-icon bi bi-person"></i><p>Profile</p></a></li>
                        <li class="nav-header">OPTIONS</li>
                        <li class="nav-item"> <a href="#" class="nav-link" onclick="logout(event)"> <i class="nav-icon bi bi-box-arrow-in-right"></i><p>Sign out</p></a></li>
                </nav>
            </div> 
        </aside>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SECRETARIAT DASHBOARD - GAD Monitoring System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --sidebar-active: #3498db;
            --sidebar-text: #fff;
            --sidebar-muted: rgba(255, 255, 255, 0.8);

        }

        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(90deg, #4B0082, #8A2BE2);
            color: var(--sidebar-text);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 1.1rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-align: left;
        }

        .sidebar-header h4 {
            font-size: 1.2rem;
            font-weight: 500;
            margin: 0;
        }

        .sidebar-content {
            flex: 1;
            padding: 0.6rem;
            overflow-y: auto;
        }

        .sidebar-content::-webkit-scrollbar {
            display: none;
        }

        .sidebar-footer {
            padding: 0.8rem 1rem 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.09);
        }

        /* User Info Styles */
        .user-info {
            padding: 0.6rem 0.8rem;
            background: rgba(255, 255, 255, 0.09);
            border-radius: 0.3rem;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            font-size: 0.97rem;
        }

        .user-info i {
            font-size: 1.2rem;
            margin-right: 0.6rem;
            color: var(--sidebar-text);
        }

        .user-info .fw-bold {
            font-size: 1rem;
            font-weight: 500;
        }

        /* Navigation Menu Styles */
        .nav-links {
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .nav-links .nav-item {
            margin-bottom: 2px;
            position: relative;
        }

        .nav-link {
            color: var(--sidebar-muted);
            padding: 0.6rem 0.8rem;
            border-radius: 0.3rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-size: 1rem;
            font-weight: 500;
            font-style: normal;
        }

        .nav-link.active {
            background-color: var(--sidebar-active); /* Highlight entire row */
            color: var(--sidebar-text); /* Ensure text is visible against the highlighted background */
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            width: 100%; 
        }

        .nav-links .iocn-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            cursor: pointer;
            border-radius: 0.3rem;
            transition: background-color 0.2s ease;
        }

        .nav-links .iocn-link:hover {
            background-color: var(--sidebar-hover);
        }

        .nav-links .arrow {
            font-size: 1rem;
            color: var(--sidebar-muted);
            margin-left: 0.1rem;
            transition: transform 0.3s ease, color 0.2s ease;
            cursor: pointer;
            padding: 0.2rem;
        }

        .nav-links .showMenu .arrow {
            transform: rotate(180deg);
            color: var(--sidebar-text);
        }

        .nav-links .showMenu .iocn-link {
            background-color: var(--sidebar-hover);
        }

        .nav-links .link_name {
            font-size: 1rem;
            font-weight: 400;
            display: flex;
            align-items: center;
        }

        .nav-links .link_name i {
            font-size: 1.16rem;
            margin-right: 0.5rem;
            vertical-align: middle;
        }

        .nav-links .sub-menu {
            display: none;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.5rem 0;
            margin: 0.5rem 0 0.5rem 1rem;
            list-style: none;
            border-radius: 0.5rem;
            border-left: 3px solid var(--bs-primary);
        }

        .nav-links .showMenu .sub-menu {
            display: block;
            animation: fadeInSubMenu 0.4s cubic-bezier(0.37, 0.18, 0.57, 1.13);
        }

        @keyframes fadeInSubMenu {
            from {
                opacity: 0;
                transform: translateY(-10px);
                max-height: 0;
            }

            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 400px;
            }
        }

        .nav-links .sub-menu a {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
            white-space: nowrap;
            text-decoration: none;
            display: flex;
            align-items: center;
            border-radius: 0.3rem;
            margin: 0.1rem 0.5rem;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links .sub-menu a:hover {
            color: var(--sidebar-text);
            background: var(--sidebar-hover);
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .nav-links .sub-menu a:active {
            background-color: var(--bs-primary);
            color: white;
        }

        .nav-links .sub-menu a i {
            opacity: 0.7;
            transition: opacity 0.2s ease;
        }

        .nav-links .sub-menu a:hover i {
            opacity: 1;
        }

        .nav-links .sub-menu .link_name {
            display: none;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2rem;
            background-color: #fafbfe;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card-header {
            padding: 1rem 1.5rem;
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"> </i> GAD Monitoring System
            </h4>
        </div>

        <!-- Sidebar Content -->
        <div class="sidebar-content">
            <!-- User Info -->
            <div class="user-info mb-4">
                <i class="bi bi-person-circle"></i>
                <span class="fw-bold">
                    <?php echo esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?>
                </span>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column nav-links">
                
                <li class="nav-item">
                    <div class="iocn-link">
                        <a class="nav-link active" href="<?= site_url('/SecretariatDashboard') ?>">
                            <span class="link_name">
                                <i class="bi bi-house-door"></i> Dashboard
                            </span>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="iocn-link" id="toggle-gad-maintenance">
                        <a class="nav-link" href="#" role="button">
                            <span class="link_name">
                                <i class="bi bi-gear"></i> GAD Maintenance
                            </span>
                        </a>
                        <i class="bi bi-chevron-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="<?= base_url('Secretariat/UserManagement') ?>"><i class="bi bi-person-gear me-2"></i>User Information</a></li>
                        <li><a href="<?= base_url('Secretariat/DivisionManagement') ?>"><i class="bi bi-building me-2"></i>Division / Office</a></li>
                        <li><a href="<?= base_url('Secretariat/PositionsManagement') ?>"><i class="bi bi-briefcase me-2"></i>Positions</a></li>
                        <li><a href="<?= base_url('Secretariat/MfoPap') ?>"><i class="bi bi-list-task me-2"></i>MFO / PAP</a></li>
                        <li><a href="<?= base_url('Secretariat/SourceOfFunds') ?>"><i class="bi bi-cash-stack me-2"></i>Source of Funds</a></li>
                        <li><a href="<?= base_url('Secretariat/ObjectOfExpense') ?>"><i class="bi bi-receipt me-2"></i>Object of Expense</a></li>
                        <li><a href="<?= base_url('Secretariat/GadMandateManagement') ?>"><i class="bi bi-people me-2"></i>Gender Issue / Mandate</a></li>
                    </ul>
                </li>
            </ul>
        </div>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <a href="<?= site_url('login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Page Header -->
            <div
                class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2" id="pageTitle">
                    <i class="bi bi-house-door text-primary"></i> Dashboard
                </h1>
            </div>

            <!-- Dashboard Overview -->
            <div id="dashboard-overview" class="module-content">
                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3 mb-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($totalPlans ?? 0); ?></h4>
                                        <p class="card-text">Total GAD Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-file-text fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($pendingPlans ?? 0); ?></h4>
                                        <p class="card-text">Pending Review</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-clock fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($approvedPlans ?? 0); ?></h4>
                                        <p class="card-text">Approved Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-check-circle fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($finalizedPlans ?? 0); ?></h4>
                                        <p class="card-text">Finalized Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-bookmark-check fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-secondary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($totalDivisions ?? 0); ?></h4>
                                        <p class="card-text">Total Divisions</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-building fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-dark">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($totalEmployees ?? 0); ?></h4>
                                        <p class="card-text">Total Employees</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-people fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-danger">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4><?php echo esc($returnedPlans ?? 0); ?></h4>
                                        <p class="card-text">Returned Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-arrow-return-left fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="bi bi-activity text-primary"></i> Recent System Activities
                                </h5>
                            </div>
                            <div class="card-body">
                                <?php if (!empty($recentActivities)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Date/Time</th>
                                                <th>User</th>
                                                <th>Action</th>
                                                <th>Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recentActivities as $activity): ?>
                                            <tr>
                                                <td>
                                                    <small class="text-muted">
                                                        <?php echo date('M d, Y H:i', strtotime($activity['created_at'])); ?>
                                                    </small>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($activity['first_name'] && $activity['last_name']) {
                                                        echo esc($activity['first_name'] . ' ' . $activity['last_name']);
                                                    } else {
                                                        echo '<span class="text-muted">System</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $actionClass = match(strtoupper($activity['action'])) {
                                                        'CREATE' => 'success',
                                                        'UPDATE' => 'primary',
                                                        'DELETE' => 'danger',
                                                        default => 'secondary'
                                                    };
                                                    ?>
                                                    <span class="badge bg-<?php echo $actionClass; ?>">
                                                        <?php echo esc($activity['action']); ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small><?php echo esc($activity['details']); ?></small>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No recent activities found.</p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enhanced dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById("toggle-gad-maintenance");
            const parentItem = toggleButton.parentElement;
            const arrow = toggleButton.querySelector('.arrow');

            // Toggle submenu on click
            toggleButton.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open dropdowns
                document.querySelectorAll('.nav-item.showMenu').forEach(item => {
                    if (item !== parentItem) {
                        item.classList.remove('showMenu');
                    }
                });

                // Toggle current dropdown
                parentItem.classList.toggle("showMenu");

                // Add visual feedback
                if (parentItem.classList.contains("showMenu")) {
                    toggleButton.style.backgroundColor = 'var(--sidebar-hover)';
                } else {
                    toggleButton.style.backgroundColor = 'transparent';
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!parentItem.contains(e.target)) {
                    parentItem.classList.remove('showMenu');
                    toggleButton.style.backgroundColor = 'transparent';
                }
            });

            // Highlight active submenu item
            const currentPath = window.location.pathname;
            const subMenuLinks = parentItem.querySelectorAll('.sub-menu a');

            subMenuLinks.forEach(link => {
                if (link.getAttribute('href') && currentPath.includes(link.getAttribute('href').split('/').pop())) {
                    link.style.backgroundColor = 'var(--bs-primary)';
                    link.style.color = 'white';
                    parentItem.classList.add('showMenu'); // Keep parent open if child is active
                }

                // Add click feedback
                link.addEventListener('click', function() {
                    // Remove active state from other links
                    subMenuLinks.forEach(otherLink => {
                        otherLink.style.backgroundColor = '';
                        otherLink.style.color = '';
                    });

                    // Add active state to clicked link
                    this.style.backgroundColor = 'var(--bs-primary)';
                    this.style.color = 'white';
                });
            });
        });
    </script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOCAL DASHBOARD - GAD Monitoring System</title>
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
            background: var(--sidebar-bg);
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
        }

        .nav-links .arrow {
            font-size: 1rem;
            color: var(--sidebar-muted);
            margin-left: 0.1rem;
            transition: transform 0.3s;
            cursor: pointer;
        }

        .nav-links .showMenu .arrow {
            transform: rotate(-180deg);
            color: var(--sidebar-text);
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
            background: var(--sidebar-bg);
            padding: 0 0 0 2.6rem;
            margin-bottom: 2px;
            list-style: none;
        }

        .nav-links .showMenu .sub-menu {
            display: block;
            animation: fadeInSubMenu 0.32s cubic-bezier(0.37, 0.18, 0.57, 1.13);
        }

        @keyframes fadeInSubMenu {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-links .sub-menu a {
            color: rgba(255, 255, 255, 0.66);
            font-size: 0.97rem;
            padding: 0.33rem 0;
            white-space: nowrap;
            text-decoration: none;
            display: block;
            border-radius: 0.3rem;
            transition: color 0.2s;
        }

        .nav-links .sub-menu a:hover {
            color: var(--sidebar-text);
            background: var(--sidebar-hover);
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
                <i class="bi bi-clipboard-data"></i> GAD System
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
                        <a class="nav-link" href="#">
                            <span class="link_name">
                                <i class="bi bi-house-door"></i> GAD Maintenance
                            </span>
                        </a>
                        <i class="bi bi-chevron-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="#">User Information</a></li>
                        <li><a href="<?= base_url('Secretariat/DivisionManagement') ?>">Division / Office</a></li>
                        <li><a href="#">Positions</a></li>
                        <li><a href="<?= base_url('Secretariat/MfoPap') ?>">MFO / PAP</a></li>
                        <li><a href="#">Source of Funds</a></li>
                        <li><a href="#">Object of Expense</a></li>
                        <li><a href="#">Gender Issue / Mandate</a></li>
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
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white bg-primary">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="totalPlans">0</h4>
                                        <p class="card-text">Total GAD Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-file-text fs-2"></i>
                                    </div>
                                </div>
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
        // Toggle submenu on click
        document.getElementById("toggle-gad-maintenance").addEventListener("click", function () {
            const parentItem = this.parentElement;
            parentItem.classList.toggle("showMenu");
        });
    </script>
</body>

</html>
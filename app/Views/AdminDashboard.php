<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Dashboard') ?> - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
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
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a252f 100%);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            transform: translateX(0) !important;
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(33, 22, 22, 0.1);
            text-align: center;
        }
        .sidebar-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .user-info {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: white;
        }
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
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .table-responsive {
                font-size: 0.85rem;
            }
            .table th, .table td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"> </i> GAD Monitoring System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc((session()->get('first_name') ?? 'Admin') . ' ' . (session()->get('last_name') ?? 'User')); ?></div>
                        <small class="text-light">Administrator</small>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/AdminDashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Admin/EmployeesManagement') ?>">
                        <i class="bi bi-people me-2"></i>Employee Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/AuditTrail') ?>">
                        <i class="bi bi-clock-history me-2"></i>Audit Trail
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="<?= base_url('/login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <dv class="card-header">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-house-door text-primary"></i> Admin Dashboard
                        </h1>
    </dv>
                    </div>
                </div>
            </div>

         
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
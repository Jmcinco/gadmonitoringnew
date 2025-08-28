<?php
// Check if user is logged in and has the correct role
if (!session()->get('isLoggedIn') || session()->get('role_id') != 2) {
    session()->setFlashdata('error', 'Unauthorized access.');
    header('Location: ' . base_url('/login'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member DASHBOARD - GAD Monitoring System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-primary-rgb: 36, 20, 68;
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
            background: linear-gradient(90deg, #4B0082, #8A2BE2);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
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
            padding: 1rem 1.5rem;
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
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
            <!-- User Info -->
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold">
                            <?php echo esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?></div>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('MemberDashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/PlanPreparation') ?>">
                        <i class="bi bi-clipboard-plus me-2"></i>Preparation of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/BudgetCrafting') ?>">
                        <i class="bi bi-calculator me-2"></i>Budget Crafting
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/PlanReview') ?>">
                        <i class="bi bi-check-circle me-2"></i>Review & Approval of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/ConsolidatedPlan') ?>">
                        <i class="bi bi-file-earmark-text me-2"></i>Consolidated Plan & Budget
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/AccomplishmentSubmission') ?>">
                        <i class="bi bi-send me-2"></i>Submission of GAD Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/ReviewApproval') ?>">
                        <i class="bi bi-clipboard-check me-2"></i>Review & Approval of Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Member/ConsolidatedAccomplishment') ?>">
                        <i class="bi bi-collection me-2"></i>Consolidated GAD Accomplishment
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout Button -->
        <div class="sidebar-footer">
            <a href="<?= site_url('login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
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
                                        <h4 id="totalPlans"><?php echo esc($totalPlans ?? 0); ?></h4>
                                        <p class="card-text">Total GAD Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-file-text fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-success">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="approvedPlans"><?php echo esc($approvedPlans ?? 0); ?></h4>
                                        <p class="card-text">Approved Plans</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-check-circle fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-warning">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="pendingPlans"><?php echo esc($pendingPlans ?? 0); ?></h4>
                                        <p class="card-text">Pending Review</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-clock fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white bg-info">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="totalBudget">₱0</h4>
                                        <p class="card-text">Total Budget</p>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-currency-dollar fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-graph-up me-2"></i>Recent Activities</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush" id="recentActivities">
                                    <?php if (!empty($recentPlans)): ?>
                                        <?php foreach (array_slice($recentPlans, 0, 5) as $plan): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1">GAD Plan: <?php echo esc($plan['activity']); ?></h6>
                                                <p class="mb-1 text-muted">Division: <?php echo esc($plan['division'] ?? 'Unknown'); ?></p>
                                                <small class="text-muted">Status:
                                                    <span class="badge bg-<?php echo match(strtolower($plan['status'] ?? 'pending')) {
                                                        'approved' => 'success',
                                                        'returned' => 'danger',
                                                        'pending' => 'warning',
                                                        default => 'secondary'
                                                    }; ?>">
                                                        <?php echo esc(ucfirst($plan['status'] ?? 'Pending')); ?>
                                                    </span>
                                                </small>
                                            </div>
                                            <small class="text-muted"><?php echo date('M d', strtotime($plan['created_at'])); ?></small>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">No recent activities</h6>
                                            <p class="mb-1 text-muted">System is ready for GAD plan submissions</p>
                                        </div>
                                        <small class="text-muted">Today</small>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-calendar-event me-2"></i>Upcoming Deadlines</h5>
                            </div>
                            <div class="card-body">
                                <div id="upcomingDeadlines">
                                    <p class="text-muted">No upcoming deadlines</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
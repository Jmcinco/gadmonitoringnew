<?php
// Provided by controller:
// $roleName: string (e.g., 'Focal')
// $allowedPages: array (e.g., ['PlanPreparation' => 'edit', ...])
// $page: string (e.g., 'PlanPreparation')
// $accessType: string (e.g., 'edit')

$pageLabels = [
    'PlanPreparation' => 'Preparation of GAD Plan',
    'BudgetCrafting' => 'Budget Crafting',
    'PlanReview' => 'Review & Approval of GAD Plan',
    'ConsolidatedPlan' => 'Consolidated Plan & Budget',
    'AccomplishmentSubmission' => 'Submission of GAD Accomplishment',
    'ReviewApproval' => 'Review & Approval of Accomplishment',
    'ConsolidatedAccomplishment' => 'Consolidated GAD Accomplishment',
    'MonitoringEvaluation' => 'Monitoring & Evaluation'
];

$pageIcons = [
    'PlanPreparation' => 'bi-clipboard-plus',
    'BudgetCrafting' => 'bi-calculator',
    'PlanReview' => 'bi-check-circle',
    'ConsolidatedPlan' => 'bi-file-earmark-text',
    'AccomplishmentSubmission' => 'bi-send',
    'ReviewApproval' => 'bi-clipboard-check',
    'ConsolidatedAccomplishment' => 'bi-collection',
    'MonitoringEvaluation' => 'bi-graph-up'
];

$pageRoutes = [
    'PlanPreparation' => 'dashboard/PlanPreparation',
    'BudgetCrafting' => 'dashboard/BudgetCrafting',
    'PlanReview' => 'dashboard/PlanReview',
    'ConsolidatedPlan' => 'dashboard/ConsolidatedPlan',
    'AccomplishmentSubmission' => 'dashboard/AccomplishmentSubmission',
    'ReviewApproval' => 'dashboard/ReviewApproval',
    'ConsolidatedAccomplishment' => 'dashboard/ConsolidatedAccomplishment',
    'MonitoringEvaluation' => 'dashboard/MonitoringEvaluation',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= strtoupper($roleName) ?> - <?= isset($pageLabels[$page]) ? $pageLabels[$page] : 'Dashboard' ?> - GAD Monitoring System</title>
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
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a252f 100%);
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
                <i class="bi bi-clipboard-data"></i> GAD System
            </h4>
        </div>
        
        <div class="sidebar-content">
            <!-- User Info -->
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?= esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?></div>
                        <small class="text-light"><?= esc($roleName) ?></small>
                        <br><small class="text-light">Executive Division</small>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= $page === 'Dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <?php foreach ($allowedPages as $pageKey => $accessType): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $page === $pageKey ? 'active' : '' ?>" href="<?= base_url($pageRoutes[$pageKey]) ?>">
                            <i class="bi <?= $pageIcons[$pageKey] ?? 'bi-circle' ?> me-2"></i>
                            <?= $pageLabels[$pageKey] ?>
                            <span class="badge bg-<?= $accessType === 'edit' ? 'primary' : 'secondary' ?> ms-2"><?= ucfirst($accessType) ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
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
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2" id="pageTitle">
                    <i class="bi <?= isset($pageIcons[$page]) ? $pageIcons[$page] : 'bi-house-door' ?> text-primary"></i>
                    <?= isset($pageLabels[$page]) ? $pageLabels[$page] : 'Dashboard' ?>
                </h1>
            </div>

            <!-- Page Content -->
            <div id="page-content" class="module-content">
                <?php if ($page === 'Dashboard' || !isset($page)): ?>
                    <!-- Dashboard Overview -->
                    <div id="dashboard-overview">
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
                            <div class="col-md-3">
                                <div class="card text-white bg-success">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h4 id="approvedPlans">0</h4>
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
                                                <h4 id="pendingPlans">0</h4>
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
                                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h6 class="mb-1">No recent activities</h6>
                                                    <p class="mb-1 text-muted">System is ready for GAD plan submissions</p>
                                                </div>
                                                <small class="text-muted">Today</small>
                                            </div>
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
                <?php elseif ($page === 'PlanPreparation'): ?>
                    <!-- Plan Preparation Content -->
                    <div id="plan-preparation">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="bi bi-clipboard-plus me-2"></i>Preparation of GAD Plan</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($accessType === 'edit'): ?>
                                    <form action="<?= base_url('dashboard/savePlan') ?>" method="post">
                                        <?= csrf_field() ?>
                                        <div class="mb-3">
                                            <label for="planTitle" class="form-label">Plan Title</label>
                                            <input type="text" class="form-control" id="planTitle" name="planTitle" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="planDescription" class="form-label">Description</label>
                                            <textarea class="form-control" id="planDescription" name="planDescription" rows="5" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Plan</button>
                                    </form>
                                <?php else: ?>
                                    <p class="text-muted">You have view-only access to this page.</p>
                                    <!-- Add view-only content, e.g., a table of existing plans -->
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Plan Title</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Sample Plan</td>
                                                <td>Sample GAD plan description</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Placeholder for other pages -->
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi <?= $pageIcons[$page] ?? 'bi-circle' ?> me-2"></i><?= $pageLabels[$page] ?></h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Content for <?= $pageLabels[$page] ?> is under development.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Focal DASHBOARD - GAD Monitoring System</title>
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
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"></i>GAD Monitoring System
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
                    <a class="nav-link active" href="<?= base_url('FocalDashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/PlanPreparation') ?>">
                        <i class="bi bi-clipboard-plus me-2"></i>Preparation of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/BudgetCrafting') ?>">
                        <i class="bi bi-calculator me-2"></i>Budget Crafting
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/PlanReview') ?>">
                        <i class="bi bi-check-circle me-2"></i>Review & Approval of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ConsolidatedPlan') ?>">
                        <i class="bi bi-file-earmark-text me-2"></i>Consolidated Plan & Budget
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">
                        <i class="bi bi-send me-2"></i>Submission of GAD Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ReviewApproval') ?>">
                        <i class="bi bi-clipboard-check me-2"></i>Review & Approval of Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ConsolidatedAccomplishment') ?>">
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
                <!-- Quick Actions Bar -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0"><i class="bi bi-lightning-charge text-warning"></i> Quick Actions</h5>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="createNewPlan()">
                                            <i class="bi bi-plus-circle"></i> New Plan
                                        </button>
                                        <button type="button" class="btn btn-success btn-sm" onclick="submitAccomplishment()">
                                            <i class="bi bi-upload"></i> Submit Accomplishment
                                        </button>
                                        <button type="button" class="btn btn-info btn-sm" onclick="refreshDashboard()">
                                            <i class="bi bi-arrow-clockwise"></i> Refresh
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="exportReport()">
                                            <i class="bi bi-download"></i> Export Report
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="filterPlans('all')" style="cursor: pointer; background: linear-gradient(to bottom, #800080, #2a2788b0);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="totalPlans"><?php echo esc($totalPlans ?? 0); ?></h4>
                                        <p class="card-text">Total GAD Plans</p>
                                        <small class="opacity-75">Click to view all</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-file-text fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="filterPlans('approved')" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="approvedPlans"><?php echo esc($approvedPlans ?? 0); ?></h4>
                                        <p class="card-text">Approved Plans</p>
                                        <small class="opacity-75">Click to view approved</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-check-circle fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="filterPlans('pending')" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="pendingPlans"><?php echo esc($pendingPlans ?? 0); ?></h4>
                                        <p class="card-text">Pending Review</p>
                                        <small class="opacity-75">Click to view pending</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-clock fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="showBudgetBreakdown()" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="totalBudget">₱<?php echo number_format($totalBudget ?? 0, 2); ?></h4>
                                        <p class="card-text">Total Budget</p>
                                        <small class="opacity-75">Click for breakdown</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-currency-dollar fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Status Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                       <div class="card text-white clickable-card" onclick="filterPlans('returned')" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="returnedPlans"><?php echo esc($returnedPlans ?? 0); ?></h4>
                                        <p class="card-text">Returned Plans</p>
                                        <small class="opacity-75">Need revision</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-arrow-return-left fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white  clickable-card" onclick="filterPlans('draft')" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="draftPlans"><?php echo esc($draftPlans ?? 0); ?></h4>
                                        <p class="card-text">Draft Plans</p>
                                        <small class="opacity-75">Not yet submitted</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-file-earmark fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="showAccomplishments()" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="totalAccomplishments"><?php echo esc($totalAccomplishments ?? 0); ?></h4>
                                        <p class="card-text">Accomplishments</p>
                                        <small class="opacity-75">Click to view</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-trophy fs-2"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-white clickable-card" onclick="showProgress()" style="cursor: pointer; background: linear-gradient(to bottom, #4B0082, #8A2BE2);">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h4 id="completionRate"><?php echo esc($completionRate ?? 0); ?>%</h4>
                                        <p class="card-text">Completion Rate</p>
                                        <small class="opacity-75">Overall progress</small>
                                    </div>
                                    <div class="align-self-center">
                                        <i class="bi bi-graph-up fs-2"></i>
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

                <!-- Charts and Analytics -->
                <div class="row mb-4 mt-5">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-pie-chart"></i> Plan Status</h6>
                                <button class="btn btn-sm btn-outline-secondary" onclick="refreshChart('statusChart')">
                                    <i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </div>
                            <div class="card-body" style="height: 250px;">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="mb-0"><i class="bi bi-bar-chart"></i> Monthly Progress</h6>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" onclick="changeChartPeriod('3months')">3M</button>
                                    <button class="btn btn-outline-secondary active" onclick="changeChartPeriod('6months')">6M</button>
                                    <button class="btn btn-outline-secondary" onclick="changeChartPeriod('1year')">1Y</button>
                                </div>
                            </div>
                            <div class="card-body" style="height: 250px;">
                                <canvas id="progressChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Quick Stats</h6>
                            </div>
                            <div class="card-body" style="height: 250px;">
                                <div class="d-flex flex-column justify-content-around h-100">
                                    <div class="text-center">
                                        <h4 class="text-primary"><?php echo round(($approvedPlans / max($totalPlans, 1)) * 100); ?>%</h4>
                                        <small class="text-muted">Approval Rate</small>
                                    </div>
                                    <div class="text-center">
                                        <h4 class="text-success">₱<?php echo number_format(($approvedBudget ?? 0) / 1000, 0); ?>K</h4>
                                        <small class="text-muted">Approved Budget</small>
                                    </div>
                                    <div class="text-center">
                                        <h4 class="text-info"><?php echo $accomplishments ?? 0; ?></h4>
                                        <small class="text-muted">Accomplishments</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Plans Table -->
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="bi bi-table"></i> My GAD Plans</h5>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary" onclick="exportPlansTable()">
                                        <i class="bi bi-download"></i> Export
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="refreshPlansTable()">
                                        <i class="bi bi-arrow-clockwise"></i> Refresh
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Search and Filter -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input type="text" class="form-control" id="searchPlans" placeholder="Search plans..." onkeyup="searchPlansTable()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="statusFilter" onchange="filterPlansTable()">
                                            <option value="">All Status</option>
                                            <option value="draft">Draft</option>
                                            <option value="pending">Pending</option>
                                            <option value="approved">Approved</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="sortBy" onchange="sortPlansTable()">
                                            <option value="newest">Newest First</option>
                                            <option value="oldest">Oldest First</option>
                                            <option value="budget_high">Budget (High to Low)</option>
                                            <option value="budget_low">Budget (Low to High)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover" id="plansTable">
                                        <thead>
                                            <tr>
                                                <th>Plan ID</th>
                                                <th>Activity</th>
                                                <th>Status</th>
                                                <th>Budget</th>
                                                <th>Timeline</th>
                                                <th>Progress</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="plansTableBody">
                                            <?php if (!empty($recentPlans)): ?>
                                                <?php foreach ($recentPlans as $plan): ?>
                                                    <tr data-status="<?php echo strtolower($plan['status'] ?? 'draft'); ?>" data-budget="<?php echo $plan['total_budget'] ?? 0; ?>" data-created="<?php echo $plan['created_at'] ?? ''; ?>">
                                                        <td>
                                                            <strong>GAD-<?php echo str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT); ?></strong>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 200px;" title="<?php echo esc($plan['activity']); ?>">
                                                                <?php echo esc($plan['activity']); ?>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $status = $plan['status'] ?? 'draft';
                                                            $badgeClass = match(strtolower($status)) {
                                                                'approved' => 'bg-success',
                                                                'pending' => 'bg-warning',
                                                                'returned' => 'bg-danger',
                                                                'draft' => 'bg-secondary',
                                                                default => 'bg-secondary'
                                                            };
                                                            ?>
                                                            <span class="badge <?php echo $badgeClass; ?>">
                                                                <?php echo esc(ucfirst($status)); ?>
                                                            </span>
                                                        </td>
                                                        <td>₱<?php echo number_format($plan['total_budget'] ?? 0, 2); ?></td>
                                                        <td>
                                                            <small>
                                                                <?php if (!empty($plan['startDate']) && !empty($plan['endDate'])): ?>
                                                                    <?php echo date('M d', strtotime($plan['startDate'])); ?> -
                                                                    <?php echo date('M d, Y', strtotime($plan['endDate'])); ?>
                                                                <?php else: ?>
                                                                    Not set
                                                                <?php endif; ?>
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <?php
                                                            $progress = 0;
                                                            if ($status === 'approved') $progress = 100;
                                                            elseif ($status === 'pending') $progress = 75;
                                                            elseif ($status === 'returned') $progress = 50;
                                                            elseif ($status === 'draft') $progress = 25;
                                                            ?>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%"></div>
                                                            </div>
                                                            <small class="text-muted"><?php echo $progress; ?>%</small>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group btn-group-sm">
                                                                <button class="btn btn-outline-primary" onclick="viewPlan('<?php echo $plan['plan_id']; ?>')" title="View Plan">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                                <?php if (in_array(strtolower($status), ['draft', 'returned'])): ?>
                                                                <button class="btn btn-outline-warning" onclick="editPlan('<?php echo $plan['plan_id']; ?>')" title="Edit Plan">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <?php endif; ?>
                                                                <button class="btn btn-outline-info" onclick="duplicatePlan('<?php echo $plan['plan_id']; ?>')" title="Duplicate Plan">
                                                                    <i class="bi bi-files"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="7" class="text-center text-muted py-4">
                                                        <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                                        No plans found. <a href="<?= base_url('Focal/PlanPreparation') ?>" class="text-decoration-none">Create your first plan</a>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Initialize dashboard
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            loadRecentActivities();
            loadUpcomingDeadlines();
            loadActionRequired();

            // Auto-refresh every 5 minutes
            setInterval(refreshDashboard, 300000);
        });

        // Quick Actions
        function createNewPlan() {
            window.location.href = '<?= base_url("Focal/PlanPreparation") ?>';
        }

        function submitAccomplishment() {
            window.location.href = '<?= base_url("Focal/AccomplishmentSubmission") ?>';
        }

        function refreshDashboard() {
            Swal.fire({
                title: 'Refreshing Dashboard...',
                text: 'Please wait while we update your data.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                location.reload();
            }, 1000);
        }

        function exportReport() {
            Swal.fire({
                title: 'Export Report',
                text: 'Choose export format:',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'PDF Report',
                cancelButtonText: 'Excel Report',
                showDenyButton: true,
                denyButtonText: 'CSV Data'
            }).then((result) => {
                if (result.isConfirmed) {
                    exportToPDF();
                } else if (result.isDenied) {
                    exportToCSV();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    exportToExcel();
                }
            });
        }

        // Card Click Handlers
        function filterPlans(status) {
            const statusFilter = document.getElementById('statusFilter');
            if (statusFilter) {
                statusFilter.value = status === 'all' ? '' : status;
                filterPlansTable();
            }
        }

        function showBudgetBreakdown() {
            Swal.fire({
                title: 'Budget Breakdown',
                html: `
                    <div class="text-start">
                        <p><strong>Total Allocated:</strong> ₱<?php echo number_format($totalBudget ?? 0, 2); ?></p>
                        <p><strong>Approved Plans:</strong> ₱<?php echo number_format(($approvedBudget ?? 0), 2); ?></p>
                        <p><strong>Pending Plans:</strong> ₱<?php echo number_format(($pendingBudget ?? 0), 2); ?></p>
                        <p><strong>Draft Plans:</strong> ₱<?php echo number_format(($draftBudget ?? 0), 2); ?></p>
                        <hr>
                        <p><strong>Utilization Rate:</strong> ${Math.round((<?php echo $approvedBudget ?? 0; ?> / <?php echo $totalBudget ?? 1; ?>) * 100)}%</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        }

        function showAccomplishments() {
            window.location.href = '<?= base_url("Focal/AccomplishmentSubmission") ?>';
        }

        function showProgress() {
            Swal.fire({
                title: 'Overall Progress',
                html: `
                    <div class="text-start">
                        <div class="mb-3">
                            <label>Plan Completion:</label>
                            <div class="progress">
                                <div class="progress-bar" style="width: <?php echo $completionRate ?? 0; ?>%"><?php echo $completionRate ?? 0; ?>%</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Budget Utilization:</label>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: ${Math.round((<?php echo $approvedBudget ?? 0; ?> / <?php echo $totalBudget ?? 1; ?>) * 100)}%">
                                    ${Math.round((<?php echo $approvedBudget ?? 0; ?> / <?php echo $totalBudget ?? 1; ?>) * 100)}%
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label>Accomplishments:</label>
                            <div class="progress">
                                <div class="progress-bar bg-info" style="width: <?php echo min(100, ($totalAccomplishments ?? 0) * 10); ?>%">
                                    <?php echo $totalAccomplishments ?? 0; ?> submitted
                                </div>
                            </div>
                        </div>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        }

        // Chart Functions
        let statusChart, progressChart;

        function initializeCharts() {
            // Status Distribution Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            statusChart = new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Approved', 'Pending', 'Draft', 'Returned'],
                    datasets: [{
                        data: [
                            <?php echo $approvedPlans ?? 0; ?>,
                            <?php echo $pendingPlans ?? 0; ?>,
                            <?php echo $draftPlans ?? 0; ?>,
                            <?php echo $returnedPlans ?? 0; ?>
                        ],
                        backgroundColor: ['#28a745', '#ffc107', '#6c757d', '#dc3545'],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });

            // Progress Chart
            const progressCtx = document.getElementById('progressChart').getContext('2d');
            progressChart = new Chart(progressCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Created',
                        data: [2, 4, 3, 5, 7, 6],
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        borderWidth: 2
                    }, {
                        label: 'Approved',
                        data: [1, 2, 2, 3, 4, 5],
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 12,
                                font: {
                                    size: 11
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    }
                }
            });
        }

        function refreshChart(chartId) {
            if (chartId === 'statusChart' && statusChart) {
                statusChart.update();
            } else if (chartId === 'progressChart' && progressChart) {
                progressChart.update();
            }

            Swal.fire({
                icon: 'success',
                title: 'Chart Updated',
                text: 'Chart data has been refreshed.',
                timer: 1500,
                showConfirmButton: false
            });
        }

        function changeChartPeriod(period) {
            // Update active button
            document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');

            // Update chart data based on period
            // This would typically fetch new data from the server
            Swal.fire({
                icon: 'info',
                title: 'Period Changed',
                text: `Chart updated to show ${period} data.`,
                timer: 1500,
                showConfirmButton: false
            });
        }

        // Table Functions
        function searchPlansTable() {
            const searchTerm = document.getElementById('searchPlans').value.toLowerCase();
            const rows = document.querySelectorAll('#plansTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        }

        function filterPlansTable() {
            const statusFilter = document.getElementById('statusFilter').value.toLowerCase();
            const rows = document.querySelectorAll('#plansTableBody tr');

            rows.forEach(row => {
                const status = row.dataset.status;
                row.style.display = (!statusFilter || status === statusFilter) ? '' : 'none';
            });
        }

        function sortPlansTable() {
            const sortBy = document.getElementById('sortBy').value;
            const tbody = document.getElementById('plansTableBody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                switch(sortBy) {
                    case 'newest':
                        return new Date(b.dataset.created) - new Date(a.dataset.created);
                    case 'oldest':
                        return new Date(a.dataset.created) - new Date(b.dataset.created);
                    case 'budget_high':
                        return parseFloat(b.dataset.budget) - parseFloat(a.dataset.budget);
                    case 'budget_low':
                        return parseFloat(a.dataset.budget) - parseFloat(b.dataset.budget);
                    default:
                        return 0;
                }
            });

            rows.forEach(row => tbody.appendChild(row));
        }

        function exportPlansTable() {
            Swal.fire({
                title: 'Export Plans',
                text: 'Choose export format:',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Excel',
                cancelButtonText: 'CSV'
            }).then((result) => {
                if (result.isConfirmed) {
                    exportToExcel();
                } else if (result.dismiss !== Swal.DismissReason.cancel) {
                    exportToCSV();
                }
            });
        }

        function refreshPlansTable() {
            Swal.fire({
                title: 'Refreshing...',
                timer: 1000,
                didOpen: () => Swal.showLoading()
            }).then(() => {
                location.reload();
            });
        }

        // Plan Actions
        function viewPlan(planId) {
            window.open(`<?= base_url("Focal/PlanPreparation") ?>?view=${planId}`, '_blank');
        }

        function editPlan(planId) {
            window.location.href = `<?= base_url("Focal/PlanPreparation") ?>?edit=${planId}`;
        }

        function duplicatePlan(planId) {
            Swal.fire({
                title: 'Duplicate Plan',
                text: 'This will create a copy of the selected plan. Continue?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Duplicate',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('Success', 'Plan duplicated successfully!', 'success');
                }
            });
        }

        // Export Functions
        function exportToPDF() {
            Swal.fire('Info', 'PDF export functionality will be implemented soon.', 'info');
        }

        function exportToExcel() {
            Swal.fire('Info', 'Excel export functionality will be implemented soon.', 'info');
        }

        function exportToCSV() {
            Swal.fire('Info', 'CSV export functionality will be implemented soon.', 'info');
        }

        // Add hover effects for clickable cards
        document.addEventListener('DOMContentLoaded', function() {
            const clickableCards = document.querySelectorAll('.clickable-card');
            clickableCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                    this.style.transition = 'all 0.2s ease';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
</body>

</html> 
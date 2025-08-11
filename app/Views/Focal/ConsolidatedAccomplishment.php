<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidated GAD Accomplishment Report - GAD Management System</title>
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
                <i class="bi bi-shield-check"></i> GAD Management System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc($first_name . ' ' . $last_name); ?></div>
                        <small class="text-light">Administrator</small>
                    </div>
                </div>
            </div>
            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('FocalDashboard') ?>">
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
                    <a class="nav-link active" href="<?= base_url('Focal/ConsolidatedAccomplishment') ?>">
                        <i class="bi bi-collection me-2"></i>Consolidated GAD Accomplishment
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="<?php echo base_url('logout'); ?>" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Focal/dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consolidated GAD Accomplishment Report</li>
                    </ol>
                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-file-earmark-bar-graph text-primary"></i> Consolidated GAD Accomplishment Report
                        </h1>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" disabled><i class="bi bi-file-earmark-text"></i> Generate Report</button>
                            <button type="button" class="btn btn-success" disabled><i class="bi bi-file-earmark-excel"></i> Export to Excel</button>
                            <button type="button" class="btn btn-info" disabled><i class="bi bi-printer"></i> Print Report</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Period Selection -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <label for="reportYear" class="form-label">Report Year</label>
                                    <select class="form-select" id="reportYear" disabled>
                                        <option value="2024" selected>2024</option>
                                        <option value="2023">2023</option>
                                        <option value="2022">2022</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="reportQuarter" class="form-label">Quarter</label>
                                    <select class="form-select" id="reportQuarter" disabled>
                                        <option value="">All Quarters</option>
                                        <option value="Q1">Q1 (Jan-Mar)</option>
                                        <option value="Q2" selected>Q2 (Apr-Jun)</option>
                                        <option value="Q3">Q3 (Jul-Sep)</option>
                                        <option value="Q4">Q4 (Oct-Dec)</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="reportOffice" class="form-label">Office</label>
                                    <select class="form-select" id="reportOffice" disabled>
                                        <option value="">All Offices</option>
                                        <option value="Human Resources Division">Human Resources Division</option>
                                        <option value="Training Division">Training Division</option>
                                        <option value="Legal Affairs Division">Legal Affairs Division</option>
                                        <option value="Policy Development Unit">Policy Development Unit</option>
                                        <option value="IT Division">IT Division</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-outline-primary" disabled><i class="bi bi-funnel"></i> Apply Filter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3 class="card-title">15</h3>
                            <p class="card-text">Total Activities</p>
                            <i class="bi bi-clipboard-data fs-1"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3 class="card-title">12</h3>
                            <p class="card-text">Completed</p>
                            <i class="bi bi-check-circle fs-1"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3 class="card-title">2</h3>
                            <p class="card-text">In Progress</p>
                            <i class="bi bi-clock fs-1"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h3 class="card-title">80%</h3>
                            <p class="card-text">Success Rate</p>
                            <i class="bi bi-bar-chart fs-1"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance by Office -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">Performance Summary by Office</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Office</th>
                                            <th>Planned Activities</th>
                                            <th>Completed</th>
                                            <th>Success Rate</th>
                                            <th>Budget Utilization</th>
                                            <th>Beneficiaries Reached</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Human Resources Division</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td><span class="badge bg-success">100%</span></td>
                                            <td>₱450,000 (95%)</td>
                                            <td>320 employees</td>
                                        </tr>
                                        <tr>
                                            <td>Training Division</td>
                                            <td>3</td>
                                            <td>3</td>
                                            <td><span class="badge bg-success">100%</span></td>
                                            <td>₱280,000 (88%)</td>
                                            <td>150 participants</td>
                                        </tr>
                                        <tr>
                                            <td>Legal Affairs Division</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning">67%</span></td>
                                            <td>₱180,000 (72%)</td>
                                            <td>All employees</td>
                                        </tr>
                                        <tr>
                                            <td>Policy Development Unit</td>
                                            <td>2</td>
                                            <td>1</td>
                                            <td><span class="badge bg-warning">50%</span></td>
                                            <td>₱120,000</td>
                                            <td>52 participants</td>
                                        </tr>
                                        <tr>
                                            <td>IT Division</td>
                                            <td>3</td>
                                            <td>2</td>
                                            <td><span class="badge bg-warning">67%</span></td>
                                            <td>₱200,000 (80%)</td>
                                            <td>Digital platform users</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Accomplishments -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="mb-0">Detailed GAD Accomplishments</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>GAD Activity ID</th>
                                            <th>Activity Title</th>
                                            <th>Office</th>
                                            <th>Target vs Actual</th>
                                            <th>Budget vs Actual</th>
                                            <th>Completion Date</th>
                                            <th>Scope</th>
                                            <th>Impact</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GAD001</td>
                                            <td>Gender Sensitivity Training</td>
                                            <td>HR Division</td>
                                            <td>100 → 120 (<span class="text-success">+20%</span>)</td>
                                            <td>₱250k → ₱238k (<span class="text-green"> -5% </span>)</td>
                                            <td>2024-03-25</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD002</td>
                                            <td>Women's Leadership Workshop</td>
                                            <td>Training Division</td>
                                            <td>50 → 45 (<span class="text-warning"> -10% </span>)</td>
                                            <td>₱180k → ₱165k (<span class="text-green"> -8% </span>)</td>
                                            <td>2024-04-15</td>
                                            <td><span class="badge bg-success">Success</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD003</td>
                                            <td>Anti-Sexual Harassment Campaign</td>
                                            <td>Legal Affairs</td>
                                            <td>All → All (<span class="text-success">100%</span>)</td>
                                            <td>₱150k → ₱145k (<span class="text-green"> -3% </span>)</td>
                                            <td>2024-05-25</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-success">Very High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD004</td>
                                            <td>Work-Life Balance</td>
                                            <td>Policy Unit</td>
                                            <td>45 → 45 (<span class="text-success">0</span>)</td>
                                            <td>₱120k → ₱80k (<span class="text-warning"> -33% </span>)</td>
                                            <td>Pending</td>
                                            <td><span class="badge bg-warning">In Progress</span></td>
                                            <td><span class="badge bg-warning">Medium</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD005</td>
                                            <td>Digital Gender Platform</td>
                                            <td>LIT Division</td>
                                            <td>Beta → Beta (<span class="text-success">100%</span>)</td>
                                            <td>₱200k → ₱185k (<span class="text-green"> -8% </span>)</td>
                                            <td>2024-07-25</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Footer -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Data Summary</h6>
                                    <p class="text-muted mb-0">
                                        Generated on: <strong>July 27, 2025</strong><br>
                                        Report Period: <strong>Q2 2024 (April - June)</strong><br>
                                        Generated by: <strong><?php echo esc($first_name . ' ' . $last_name); ?></strong>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Key Insights</h6>
                                    <ul class="text-muted mb-0">
                                        <li>Overall completion rate: 84%</li>
                                        <li>Budget efficiency: 85% average utilization</li>
                                        <li>High-impact activities: 3 out of 5 completed</li>
                                        <li>Total beneficiaries reached: 470+ individuals</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
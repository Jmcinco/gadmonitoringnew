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
            background: linear-gradient(90deg, #4B0082, #8A2BE2);
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
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"></i> GAD Monitoring System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc(($first_name ?? 'Admin') . ' ' . ($last_name ?? 'User')); ?></div>
                        <small class="text-light d-block"><?php echo esc($role_name ?? 'Focal Person'); ?></small>
                        <small class="text-light opacity-75"><?php echo esc($division_name ?? 'GAD Office'); ?></small>
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
            <a href="<?= site_url('login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Print Styles -->
    <style>
        @media print {
            @page {
                margin: 0.3cm 0.5cm;
                size: A4 landscape;
            }

            /* Hide non-print elements */
            .no-print, .btn-group, .breadcrumb, nav {
                display: none !important;
            }

            /* Ensure full width usage */
            .container-fluid {
                max-width: 100% !important;
                padding: 0 !important;
            }

            .row {
                margin: 0 !important;
            }

            .col-12 {
                padding: 0 !important;
            }

            /* Table styling for print */
            .table {
                font-size: 9px !important;
                width: 100% !important;
                table-layout: fixed !important;
                margin: 0 !important;
                page-break-inside: auto !important;
                border-collapse: collapse !important;
            }

            .table th {
                background-color: #343a40 !important;
                color: white !important;
                border: 1px solid #000 !important;
                padding: 4px 2px !important;
                word-wrap: break-word !important;
                page-break-inside: avoid !important;
                font-weight: bold !important;
                text-align: center !important;
            }

            .table td {
                border: 1px solid #000 !important;
                padding: 3px 2px !important;
                word-wrap: break-word !important;
                vertical-align: top !important;
                line-height: 1.1 !important;
            }

            /* Column width adjustments */
            .table th:nth-child(1), .table td:nth-child(1) {
                width: 8% !important;
                text-align: center !important;
            } /* GAD Activity ID */

            .table th:nth-child(2), .table td:nth-child(2) {
                width: 15% !important;
            } /* Division/Office */

            .table th:nth-child(3), .table td:nth-child(3) {
                width: 25% !important;
            } /* GAD Activity */

            .table th:nth-child(4), .table td:nth-child(4) {
                width: 12% !important;
            } /* Responsible Unit/Offices */

            .table th:nth-child(5), .table td:nth-child(5) {
                width: 10% !important;
                text-align: right !important;
            } /* Budget Allocation */

            .table th:nth-child(6), .table td:nth-child(6) {
                width: 8% !important;
                text-align: center !important;
            } /* Source of Fund */

            .table th:nth-child(7), .table td:nth-child(7) {
                width: 10% !important;
                text-align: center !important;
            } /* Date Accomplished */

            .table th:nth-child(8), .table td:nth-child(8) {
                width: 12% !important;
                text-align: center !important;
            } /* Status */

            /* Print header styling */
            .print-header {
                display: block !important;
                text-align: center !important;
                margin-bottom: 20px !important;
                page-break-after: avoid !important;
            }

            .print-date {
                display: block !important;
                text-align: right !important;
                font-size: 10px !important;
                margin-bottom: 10px !important;
            }

            /* Hide the regular title when printing */
            .main-title {
                display: none !important;
            }

            /* Show print table header */
            .print-table-header {
                display: block !important;
                page-break-after: avoid !important;
            }

            /* Summary cards for print */
            .summary-section {
                display: flex !important;
                flex-direction: row !important;
                justify-content: space-around !important;
                margin-bottom: 20px !important;
                border: 1px solid #000 !important;
                padding: 10px !important;
                background-color: #f8f9fa !important;
            }

            .summary-section .col-md-3 {
                flex: 1 !important;
                margin: 0 5px !important;
                max-width: none !important;
            }

            .summary-section .card {
                border: none !important;
                background-color: transparent !important;
                color: #000 !important;
                margin-bottom: 0 !important;
                text-align: center !important;
            }

            .summary-section .card-body {
                padding: 5px !important;
                color: #000 !important;
            }

            .summary-section .card-title {
                color: #000 !important;
                font-weight: bold !important;
                font-size: 16px !important;
                margin-bottom: 2px !important;
            }

            .summary-section .card-text {
                color: #000 !important;
                font-size: 10px !important;
                margin-bottom: 0 !important;
            }

            /* Override any background colors for print */
            .bg-primary, .bg-success, .bg-info, .bg-warning {
                background-color: transparent !important;
                color: #000 !important;
            }

            .text-white {
                color: #000 !important;
            }

            /* Hide the flex icons in summary cards */
            .summary-section .bi {
                display: none !important;
            }

            /* Ensure table doesn't break awkwardly */
            .table-responsive {
                overflow: visible !important;
            }

            /* Force table to use full width */
            #accomplishmentTable {
                width: 100% !important;
                max-width: 100% !important;
            }
        }
    </style>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light no-print">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Focal/dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Table of Accepted GAD Accomplishments</li>
                    </ol>
                </div>
            </nav>

            <!-- Print Header (only visible when printing) -->
            <div class="print-header" style="display: none;">
                <h1 style="font-size: 18px; margin-bottom: 5px; font-weight: bold;">Table of Accepted GAD Accomplishments</h1>
                <p style="font-size: 12px; margin-bottom: 20px; color: #666;">Fiscal Year 2025 | Generated on <span id="printDate"></span></p>
                <hr style="border: 1px solid #000; margin-bottom: 20px;">
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0 main-title">
                            <i class="bi bi-file-earmark-check text-primary"></i> Table of Accepted GAD Accomplishments
                        </h1>
                        <div class="btn-group no-print">
                            <button type="button" class="btn btn-success" onclick="printAccomplishments()">
                                <i class="bi bi-printer"></i> Print
                            </button>
                            <button type="button" class="btn btn-info" onclick="saveToPDF()">
                                <i class="bi bi-file-earmark-pdf"></i> Save as PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4 summary-section">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="totalAccomplishments"><?php echo $totalAccomplishments ?? 0; ?></h4>
                                    <p class="card-text">Total Accomplishments</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-check-circle fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="totalBudgetUtilized">₱<?php echo number_format($totalBudget ?? 0, 2); ?></h4>
                                    <p class="card-text">Total Budget Utilized</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-currency-dollar fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="totalDivisions"><?php echo $divisionsCount ?? 0; ?></h4>
                                    <p class="card-text">Participating Divisions</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-building fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title">2025</h4>
                                    <p class="card-text">Target Year</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar-event fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-table text-primary"></i> Table of Accepted GAD Accomplishments
                                    </h5>
                                    <small class="text-muted">Fiscal Year <?= date('Y') ?> | Generated on: <?= date('F d, Y') ?></small>
                                </div>
                                <div class="col-auto no-print">
                                    <div class="d-flex gap-2 align-items-center">
                                        <!-- Search -->
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search accomplishments...">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="searchAccomplishments()">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>

                                        <!-- Filter by Division -->
                                        <select class="form-select form-select-sm" id="divisionFilter" onchange="filterByDivision()" style="width: 200px;">
                                            <option value="">All Divisions</option>
                                            <?php if (isset($divisions) && !empty($divisions)): ?>
                                                <?php foreach ($divisions as $division): ?>
                                                    <option value="<?php echo esc($division['division']); ?>"><?php echo esc($division['division']); ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>

                                        <!-- Filter by Status -->
                                        <select class="form-select form-select-sm" id="statusFilter" onchange="filterByStatus()" style="width: 150px;">
                                            <option value="">All Status</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Pending">Pending</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Print-only table header -->
                            <div class="print-table-header" style="display: none;">
                                <h3 style="font-size: 14px; margin-bottom: 10px; font-weight: bold; text-align: center;">Detailed Accomplishment Information</h3>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="accomplishmentTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>GAD Activity ID</th>
                                            <th>Division/Office</th>
                                            <th>GAD Activity</th>
                                            <th>Responsible Unit/Offices</th>
                                            <th>Budget Allocation</th>
                                            <th>Source of Fund</th>
                                            <th>Date Accomplished</th>
                                            <th>Status</th>
                                            <th class="no-print">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($accomplishments) && !empty($accomplishments)): ?>
                                            <?php foreach ($accomplishments as $accomplishment): ?>
                                                <tr>
                                                    <td>GAD-<?php echo str_pad($accomplishment['plan_id'] ?? '000', 3, '0', STR_PAD_LEFT); ?></td>
                                                    <td><?php echo esc($accomplishment['office_name'] ?? 'Unknown Division'); ?></td>
                                                    <td><?php echo esc($accomplishment['gad_activity'] ?? 'N/A'); ?></td>
                                                    <td>
                                                        <?php
                                                        $responsibleUnits = $accomplishment['responsible_units'] ?? 'N/A';
                                                        if ($responsibleUnits !== 'N/A' && !empty($responsibleUnits)) {
                                                            // Try to decode JSON if it's a JSON string
                                                            $decoded = json_decode($responsibleUnits, true);
                                                            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                                                echo esc(implode(', ', $decoded));
                                                            } else {
                                                                echo esc($responsibleUnits);
                                                            }
                                                        } else {
                                                            echo 'N/A';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>₱<?php echo number_format($accomplishment['budget_allocation'] ?? 0, 2); ?></td>
                                                    <td><?php echo esc($accomplishment['source_of_fund'] ?? 'N/A'); ?></td>
                                                    <td><?php echo date('M d, Y', strtotime($accomplishment['date_accomplished'] ?? 'now')); ?></td>
                                                    <td>
                                                        <?php
                                                        $status = strtolower($accomplishment['status'] ?? 'pending');
                                                        $badgeClass = 'bg-secondary';
                                                        $statusText = ucfirst($status);

                                                        switch($status) {
                                                            case 'approved':
                                                                $badgeClass = 'bg-success';
                                                                $statusText = 'Approved';
                                                                break;
                                                            case 'completed':
                                                                $badgeClass = 'bg-primary';
                                                                $statusText = 'Completed';
                                                                break;
                                                            case 'under review':
                                                                $badgeClass = 'bg-warning';
                                                                $statusText = 'Under Review';
                                                                break;
                                                            case 'returned':
                                                                $badgeClass = 'bg-danger';
                                                                $statusText = 'Returned';
                                                                break;
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                                                    </td>
                                                    <td class="no-print">
                                                        <button class="btn btn-sm btn-outline-primary" onclick="viewAccomplishmentDetails('GAD-<?php echo str_pad($accomplishment['plan_id'] ?? '000', 3, '0', STR_PAD_LEFT); ?>')">
                                                            <i class="bi bi-eye"></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center py-4">
                                                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                                    <p class="text-muted mt-2 mb-0">No approved GAD accomplishments available.</p>
                                                    <small class="text-muted">Accomplishments will appear here once they are submitted and approved.</small>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr class="fw-bold">
                                            <th colspan="4" class="text-end">TOTAL BUDGET UTILIZED:</th>
                                            <th class="text-end">₱<?php echo number_format($totalBudget ?? 0, 2); ?></th>
                                            <th colspan="4"></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Accomplishment Details Modal -->
    <div class="modal fade" id="accomplishmentDetailsModal" tabindex="-1" aria-labelledby="accomplishmentDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accomplishmentDetailsModalLabel">GAD Accomplishment Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>GAD Activity ID:</strong>
                            <p id="detailAccomplishmentId"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Division/Office:</strong>
                            <p id="detailDivision"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>GAD Activity:</strong>
                            <p id="detailActivity"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>Responsible Unit/Offices:</strong>
                            <p id="detailResponsibleUnits"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Budget Allocation:</strong>
                            <p id="detailBudget"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Source of Fund:</strong>
                            <p id="detailSourceOfFund"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Date Accomplished:</strong>
                            <p id="detailDateAccomplished"></p>
                        </div>
                        <div class="col-md-6">
                            <strong>Status:</strong>
                            <p id="detailStatus"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Print functionality
        function printAccomplishments() {
            // Set print date
            document.getElementById('printDate').textContent = new Date().toLocaleString();

            // Hide non-print elements
            const noPrintElements = document.querySelectorAll('.no-print');
            noPrintElements.forEach(el => el.style.display = 'none');

            // Show print header and table header
            const printHeader = document.querySelector('.print-header');
            const printTableHeader = document.querySelector('.print-table-header');
            if (printHeader) {
                printHeader.style.display = 'block';
            }
            if (printTableHeader) {
                printTableHeader.style.display = 'block';
            }

            // Print the page
            window.print();

            // Restore hidden elements after printing
            setTimeout(() => {
                noPrintElements.forEach(el => el.style.display = '');
                if (printHeader) {
                    printHeader.style.display = 'none';
                }
                if (printTableHeader) {
                    printTableHeader.style.display = 'none';
                }
            }, 1000);
        }

        // Save to PDF functionality
        function saveToPDF() {
            // Set print date
            document.getElementById('printDate').textContent = new Date().toLocaleString();

            // Hide non-print elements
            const noPrintElements = document.querySelectorAll('.no-print');
            noPrintElements.forEach(el => el.style.display = 'none');

            // Show print header and table header
            const printHeader = document.querySelector('.print-header');
            const printTableHeader = document.querySelector('.print-table-header');
            if (printHeader) {
                printHeader.style.display = 'block';
            }
            if (printTableHeader) {
                printTableHeader.style.display = 'block';
            }

            // Trigger print dialog (user can save as PDF)
            window.print();

            // Restore hidden elements after printing
            setTimeout(() => {
                noPrintElements.forEach(el => el.style.display = '');
                if (printHeader) {
                    printHeader.style.display = 'none';
                }
                if (printTableHeader) {
                    printTableHeader.style.display = 'none';
                }
            }, 1000);
        }

        // Search functionality
        function searchAccomplishments() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const table = document.getElementById('accomplishmentTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;

                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].textContent.toLowerCase().includes(searchTerm)) {
                        found = true;
                        break;
                    }
                }

                row.style.display = found ? '' : 'none';
            }
        }

        // Filter by division
        function filterByDivision() {
            const selectedDivision = document.getElementById('divisionFilter').value;
            const table = document.getElementById('accomplishmentTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const divisionCell = row.getElementsByTagName('td')[1]; // Division is in the 2nd column

                if (selectedDivision === '' || divisionCell.textContent.includes(selectedDivision)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // Filter by status
        function filterByStatus() {
            const selectedStatus = document.getElementById('statusFilter').value;
            const table = document.getElementById('accomplishmentTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            for (let i = 0; i < rows.length; i++) {
                const row = rows[i];
                const statusCell = row.getElementsByTagName('td')[7]; // Status is in the 8th column

                if (selectedStatus === '' || statusCell.textContent.includes(selectedStatus)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        }

        // View accomplishment details
        function viewAccomplishmentDetails(accomplishmentId) {
            // Get accomplishment data from PHP
            const accomplishments = <?php echo json_encode($accomplishments ?? []); ?>;

            // Find the accomplishment by ID
            let selectedAccomplishment = null;
            for (let acc of accomplishments) {
                const accId = 'GAD-' + String(acc.plan_id || '000').padStart(3, '0');
                if (accId === accomplishmentId) {
                    selectedAccomplishment = acc;
                    break;
                }
            }

            if (selectedAccomplishment) {
                document.getElementById('detailAccomplishmentId').textContent = accomplishmentId;
                document.getElementById('detailDivision').textContent = selectedAccomplishment.office_name || 'Unknown Division';
                document.getElementById('detailActivity').textContent = selectedAccomplishment.gad_activity || 'N/A';
                // Format responsible units
                let responsibleUnits = selectedAccomplishment.responsible_units || 'N/A';
                if (responsibleUnits !== 'N/A' && responsibleUnits) {
                    try {
                        const parsed = JSON.parse(responsibleUnits);
                        if (Array.isArray(parsed)) {
                            responsibleUnits = parsed.join(', ');
                        }
                    } catch (e) {
                        // If not JSON, use as is
                    }
                }
                document.getElementById('detailResponsibleUnits').textContent = responsibleUnits;
                document.getElementById('detailBudget').textContent = '₱' + parseFloat(selectedAccomplishment.budget_allocation || 0).toLocaleString();
                document.getElementById('detailSourceOfFund').textContent = selectedAccomplishment.source_of_fund || 'N/A';

                // Format date
                const dateAccomplished = selectedAccomplishment.date_accomplished;
                if (dateAccomplished) {
                    const date = new Date(dateAccomplished);
                    document.getElementById('detailDateAccomplished').textContent = date.toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    });
                } else {
                    document.getElementById('detailDateAccomplished').textContent = 'N/A';
                }

                // Format status
                const status = selectedAccomplishment.status || 'pending';
                document.getElementById('detailStatus').textContent = status.charAt(0).toUpperCase() + status.slice(1);

                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('accomplishmentDetailsModal'));
                modal.show();
            } else {
                alert('Accomplishment details not found.');
            }
        }

        // Search on Enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                searchAccomplishments();
            }
        });
    </script>
</body>
</html>
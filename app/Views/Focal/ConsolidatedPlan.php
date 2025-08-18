<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidated GAD Plan & Budget - GAD Management System</title>
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
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }

        /* Print Styles */
        @media print {
            .sidebar, .no-print {
                display: none !important;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .card {
                border: none !important;
                box-shadow: none !important;
            }

            .card-header {
                background-color: #f8f9fc !important;
                border-bottom: 2px solid #000 !important;
                padding: 1rem !important;
            }

            .table {
                font-size: 12px !important;
            }

            .table th {
                background-color: #343a40 !important;
                color: white !important;
                border: 1px solid #000 !important;
            }

            .table td {
                border: 1px solid #000 !important;
            }

            .table tfoot th {
                background-color: #f8f9fc !important;
                color: #000 !important;
                border: 2px solid #000 !important;
            }

            .breadcrumb {
                display: none !important;
            }

            .btn-group {
                display: none !important;
            }

            h1, h5 {
                color: #000 !important;
            }

            .text-muted {
                color: #666 !important;
            }

            @page {
                margin: 1cm;
                size: A4 landscape;
            }
        }
        .badge {
            font-size: 0.9rem;
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
            <!-- User Info -->
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc(($first_name ?? 'Focal') . ' ' . ($last_name ?? 'User')); ?></div>
                        <small class="text-light">Focal Person</small>
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
                    <a class="nav-link active" href="<?= base_url('Focal/ConsolidatedPlan') ?>">
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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('FocalDashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Consolidated GAD Plan & Budget</li>
                    </ol>
                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-file-earmark-ruled text-primary"></i> Table of Approved GAD Plan and Budget
                        </h1>
                        <div class="btn-group">
                            <button type="button" class="btn btn-success" onclick="printConsolidatedPlan()">
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
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="card-title" id="approvedPlansCount"><?php echo esc($approvedPlansCount ?? 0); ?></h4>
                                    <p class="card-text">Approved Plans</p>
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
                                    <h4 class="card-title" id="totalBudget">₱<?php echo number_format($totalBudget ?? 0, 2); ?></h4>
                                    <p class="card-text">Total Budget</p>
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
                                    <h4 class="card-title" id="divisionsCount"><?php echo esc($divisionsCount ?? 0); ?></h4>
                                    <p class="card-text">Divisions</p>
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
                                    <h4 class="card-title"><?php echo date('Y'); ?></h4>
                                    <p class="card-text">Target Year</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="bi bi-calendar fs-1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table of Approved GAD Plan and Budget -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow" id="printableArea">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Table of Approved GAD Plan and Budget</h5>
                                    <small class="text-muted">Fiscal Year <?= date('Y') ?> | Generated on: <?= date('F d, Y') ?></small>
                                </div>
                                <div class="col-auto no-print">
                                    <div class="d-flex gap-2 align-items-center">
                                        <!-- Search -->
                                        <div class="input-group" style="width: 250px;">
                                            <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="Search plans...">
                                            <button class="btn btn-outline-secondary btn-sm" type="button" onclick="searchPlans()">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped" id="consolidatedPlanTable">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>GAD Activity ID</th>
                                            <th>Division/Office</th>
                                            <th>GAD Activity</th>
                                            <th>Target Beneficiaries</th>
                                            <th>Budget Allocation</th>
                                            <th>Source of Fund</th>
                                            <th>Date Approved</th>
                                            <th class="no-print">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="consolidatedTableBody">
                                        <?php if (isset($gadPlans) && !empty($gadPlans)): ?>
                                            <?php
                                            $approvedPlans = array_filter($gadPlans, fn($p) => strtolower($p['status']) === 'approved');
                                            if (!empty($approvedPlans)): ?>
                                                <?php foreach ($approvedPlans as $plan): ?>
                                                    <tr data-division="<?php echo esc($plan['office_name'] ?? ''); ?>">
                                                        <td><?php echo esc('GAD-' . str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT)); ?></td>
                                                        <td><?php echo esc($plan['office_name'] ?? 'Unknown Office'); ?></td>
                                                        <td class="text-content"><?php echo esc($plan['activity'] ?? 'N/A'); ?></td>
                                                        <td><?php echo esc($plan['target_beneficiaries'] ?? 'Not specified'); ?></td>
                                                        <td class="text-end">₱<?php echo number_format($plan['budget_allocation'] ?? 0, 2); ?></td>
                                                        <td><?php echo esc($plan['source_of_fund'] ?? 'Not specified'); ?></td>
                                                        <td><?php echo isset($plan['approved_at']) ? date('M d, Y', strtotime($plan['approved_at'])) : 'N/A'; ?></td>
                                                        <td class="no-print">
                                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPlanDetails(<?php echo esc($plan['plan_id']); ?>)">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted py-4">
                                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                        No approved GAD plans found.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No GAD plans available.
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr class="fw-bold">
                                            <th colspan="4" class="text-end">TOTAL APPROVED BUDGET:</th>
                                            <th class="text-end">
                                                ₱<?php
                                                if (isset($gadPlans) && !empty($gadPlans)) {
                                                    $approvedPlans = array_filter($gadPlans, fn($p) => strtolower($p['status']) === 'approved');
                                                    echo number_format(array_sum(array_map(fn($p) => $p['budget_allocation'] ?? 0, $approvedPlans)), 2);
                                                } else {
                                                    echo '0.00';
                                                }
                                                ?>
                                            </th>
                                            <th colspan="3"></th>
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

    <!-- Approve Consolidated Plan Modal -->
    <div class="modal fade" id="approveConsolidatedModal" tabindex="-1" aria-labelledby="approveConsolidatedModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveConsolidatedModalLabel">
                        <i class="bi bi-check-circle"></i> Approve Consolidated GAD Plan & Budget
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="approveConsolidatedForm" class="needs-validation" novalidate>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i>
                            <strong>Review Summary:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Total Plans: 12</li>
                                <li>Total Budget: ₱2,500,000</li>
                                <li>Participating Divisions: 8</li>
                                <li>Target Year: 2024</li>
                            </ul>
                        </div>
                        
                        <div class="mb-3">
                            <label for="approvalDate" class="form-label">Approval Date *</label>
                            <input type="date" class="form-control" id="approvalDate" name="approvalDate" required>
                            <div class="invalid-feedback">
                                Please provide an approval date.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="approvalRemarks" class="form-label">Approval Remarks *</label>
                            <textarea class="form-control" id="approvalRemarks" name="approvalRemarks" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide approval remarks.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="approvedBy" class="form-label">Approved By</label>
                            <input type="text" class="form-control" id="approvedBy" name="approvedBy" value="Admin User" readonly>
                        </div>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="confirmApproval" required>
                            <label class="form-check-label" for="confirmApproval">
                                I confirm that all plans and budgets have been reviewed and are approved for implementation.
                            </label>
                            <div class="invalid-feedback">
                                Please confirm your approval.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="approveConsolidatedForm" class="btn btn-success">Approve Plan & Budget</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Details Modal -->
    <div class="modal fade" id="planDetailsModal" tabindex="-1" aria-labelledby="planDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="planDetailsModalLabel">
                        <i class="bi bi-eye"></i> Plan Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>GAD Activity ID:</strong> <span id="detailPlanId"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Division:</strong> <span id="detailDivision"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Budget:</strong> <span id="detailBudget"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Timeline:</strong> <span id="detailTimeline"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Plan Title:</strong>
                            <p id="detailPlanTitle"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>Target Beneficiaries:</strong>
                            <p id="detailBeneficiaries"></p>
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
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Set current date
        document.getElementById('approvalDate').value = new Date().toISOString().split('T')[0];

        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            event.preventDefault();
                            handleFormSubmit(form);
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Handle form submission
        function handleFormSubmit(form) {
            if (form.id === 'approveConsolidatedForm') {
                alert('Consolidated GAD Plan & Budget approved successfully!');
                bootstrap.Modal.getInstance(document.getElementById('approveConsolidatedModal')).hide();
            }
        }

        // Toggle select all
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.plan-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        // Search functionality
        function searchPlans() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const tableRows = document.querySelectorAll('#consolidatedTableBody tr[data-division]');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Filter by division
        function filterByDivision() {
            const selectedDivision = document.getElementById('divisionFilter').value;
            const tableRows = document.querySelectorAll('#consolidatedTableBody tr[data-division]');

            tableRows.forEach(row => {
                const rowDivision = row.getAttribute('data-division');
                if (selectedDivision === '' || rowDivision === selectedDivision) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Real-time search
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', searchPlans);
            }
        });

        // View plan details with AJAX
        function viewPlanDetails(planId) {
            fetch(`<?= base_url("GadPlanController/getGadPlan/") ?>${planId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showPlanDetailsModal(data.plan);
                } else {
                    Swal.fire('Error', 'Could not load plan details: ' + data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Could not load plan details: ' + error.message, 'error');
            });
        }

        function showPlanDetailsModal(plan) {
            document.getElementById('detailPlanId').textContent = `GAD-${String(plan.plan_id).padStart(3, '0')}`;
            document.getElementById('detailPlanTitle').textContent = plan.activity || 'N/A';
            document.getElementById('detailDivision').textContent = plan.division || 'Unknown Division';
            document.getElementById('detailBudget').textContent = `₱${parseFloat(plan.total_budget || plan.budget || 0).toLocaleString()}`;

            const responsibleUnits = JSON.parse(plan.responsible_units || '[]');
            document.getElementById('detailBeneficiaries').textContent = Array.isArray(responsibleUnits) ? responsibleUnits.join(', ') : 'N/A';

            const startDate = plan.startDate ? new Date(plan.startDate).toLocaleDateString() : 'N/A';
            const endDate = plan.endDate ? new Date(plan.endDate).toLocaleDateString() : 'N/A';
            document.getElementById('detailTimeline').textContent = `${startDate} - ${endDate}`;

            const modal = new bootstrap.Modal(document.getElementById('planDetailsModal'));
            modal.show();
        }

        // Print consolidated plan
        function printConsolidatedPlan() {
            // Hide elements that shouldn't be printed
            const noPrintElements = document.querySelectorAll('.no-print');
            noPrintElements.forEach(el => el.style.display = 'none');

            // Print the page
            window.print();

            // Restore hidden elements after printing
            setTimeout(() => {
                noPrintElements.forEach(el => el.style.display = '');
            }, 1000);
        }

        // Save to PDF using browser's print to PDF
        function saveToPDF() {
            Swal.fire({
                title: 'Save as PDF',
                text: 'Use your browser\'s print function and select "Save as PDF" as the destination.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Open Print Dialog',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    printConsolidatedPlan();
                }
            });
        }
    </script>
</body>
</html>
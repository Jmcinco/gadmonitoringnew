<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Plan Review & Approval - GAD Management System</title>
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
            transform: translateX(0) !important; /* Force visibility */
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
                    <a class="nav-link active" href="<?= base_url('Focal/ReviewApproval') ?>">
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

        <div class="sidebar-footer">
            <a href="<?php echo base_url('logout'); ?>" class="btn btn-outline-light w-100"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </nav>
    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Focal/dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Plan Review & Approval</li>
                    </ol>
                </div>
            </nav>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-clipboard-check text-primary"></i> GAD Plan Review & Approval
                        </h1>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary"><i class="bi bi-funnel"></i> All</button>
                            <button class="btn btn-outline-warning"><i class="bi bi-clock"></i> Pending</button>
                            <button class="btn btn-outline-success"><i class="bi bi-check-circle"></i> Approved</button>
                            <button class="btn btn-outline-danger"><i class="bi bi-arrow-left-circle"></i> Returned</button>
                        </div>
                    </div>
                </div>
            </div>
    <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Submitted GAD Plans</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search plans..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>GAD Activity ID</th>
                                        <th>Plan Title</th>
                                        <th>Submitted By</th>
                                        <th>Submission Date</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewTableBody">
                                    <tr data-status="pending">
                                        <td>GAD001</td>
                                        <td>Gender Sensitivity Training Program</td>
                                        <td>Human Resources Division</td>
                                        <td>2024-01-15</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewPlan('GAD001')">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('GAD001', 'approved')">
                                                <i class="bi bi-check"></i> Approve
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('GAD001', 'returned')">
                                                <i class="bi bi-x"></i> Return
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="approved">
                                        <td>GAD002</td>
                                        <td>Women's Leadership Development Workshop</td>
                                        <td>Training Division</td>
                                        <td>2024-01-20</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>Well-structured program with clear objectives</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewPlan('GAD002')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="updateStatus('GAD002', 'pending')">
                                                <i class="bi bi-arrow-clockwise"></i> Reopen
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="returned">
                                        <td>GAD003</td>
                                        <td>Anti-Sexual Harassment Campaign</td>
                                        <td>Legal Affairs Division</td>
                                        <td>2024-01-25</td>
                                        <td><span class="badge bg-danger">Returned</span></td>
                                        <td>Need more detailed budget breakdown</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewPlan('GAD003')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('GAD003', 'approved')">
                                                <i class="bi bi-check"></i> Approve
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="pending">
                                        <td>GAD004</td>
                                        <td>Work-Life Balance Policy Development</td>
                                        <td>Policy Development Unit</td>
                                        <td>2024-01-30</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewPlan('GAD004')">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('GAD004', 'approved')">
                                                <i class="bi bi-check"></i> Approve
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('GAD004', 'returned')">
                                                <i class="bi bi-x"></i> Return
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Plan Modal -->
    <div class="modal fade" id="reviewPlanModal" tabindex="-1" aria-labelledby="reviewPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewPlanModalLabel">
                        <i class="bi bi-eye"></i> Review GAD Plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewPlanForm" class="needs-validation" novalidate>
                        <input type="hidden" id="reviewPlanId" name="reviewPlanId">
                        
                        <!-- Plan Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Plan Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>GAD Activity ID:</strong> <span id="displayPlanId"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Plan Title:</strong> <span id="displayPlanTitle"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Submitted By:</strong> <span id="displaySubmittedBy"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Submission Date:</strong> <span id="displaySubmissionDate"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Form -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewStatus" class="form-label">Status *</label>
                                    <select class="form-select" id="reviewStatus" name="reviewStatus" required>
                                        <option value="">Select Status</option>
                                        <option value="approved">Approved</option>
                                        <option value="returned">Returned</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewDate" class="form-label">Review Date</label>
                                    <input type="date" class="form-control" id="reviewDate" name="reviewDate" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reviewRemarks" class="form-label">Remarks *</label>
                            <textarea class="form-control" id="reviewRemarks" name="reviewRemarks" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide review remarks.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reviewedBy" class="form-label">Reviewed By</label>
                            <input type="text" class="form-control" id="reviewedBy" name="reviewedBy" value="Admin User" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="reviewPlanForm" class="btn btn-primary">Save Review</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
            const formData = new FormData(form);
            const planId = formData.get('reviewPlanId');
            const status = formData.get('reviewStatus');
            const remarks = formData.get('reviewRemarks');
            
            updatePlanStatus(planId, status, remarks);
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Review plan
        function reviewPlan(planId) {
            const modal = new bootstrap.Modal(document.getElementById('reviewPlanModal'));
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === planId) {
                    document.getElementById('reviewPlanId').value = planId;
                    document.getElementById('displayPlanId').textContent = row.cells[0].textContent;
                    document.getElementById('displayPlanTitle').textContent = row.cells[1].textContent;
                    document.getElementById('displaySubmittedBy').textContent = row.cells[2].textContent;
                    document.getElementById('displaySubmissionDate').textContent = row.cells[3].textContent;
                    
                    // Set current status
                    const statusText = row.cells[4].textContent.trim().toLowerCase();
                    document.getElementById('reviewStatus').value = statusText;
                    
                    // Set current remarks
                    document.getElementById('reviewRemarks').value = row.cells[5].textContent === '-' ? '' : row.cells[5].textContent;
                    
                    // Set review date to today
                    document.getElementById('reviewDate').value = new Date().toISOString().split('T')[0];
                }
            });
            
            modal.show();
        }

        // Update status directly
        function updateStatus(planId, newStatus) {
            let remarks = '';
            
            if (newStatus === 'returned') {
                remarks = prompt('Please provide reason for returning the plan:');
                if (!remarks) return;
            } else if (newStatus === 'approved') {
                remarks = 'Plan approved for implementation';
            }
            
            updatePlanStatus(planId, newStatus, remarks);
        }

        // Update plan status in table
        function updatePlanStatus(planId, status, remarks) {
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === planId) {
                    // Update status badge
                    let statusBadge = '';
                    if (status === 'pending') {
                        statusBadge = '<span class="badge bg-warning">Pending</span>';
                        row.dataset.status = 'pending';
                    } else if (status === 'approved') {
                        statusBadge = '<span class="badge bg-success">Approved</span>';
                        row.dataset.status = 'approved';
                    } else if (status === 'returned') {
                        statusBadge = '<span class="badge bg-danger">Returned</span>';
                        row.dataset.status = 'returned';
                    }
                    
                    row.cells[4].innerHTML = statusBadge;
                    row.cells[5].textContent = remarks || '-';
                    
                    // Update action buttons based on status
                    let actionButtons = `
                        <button class="btn btn-sm btn-outline-primary" onclick="reviewPlan('${planId}')">
                            <i class="bi bi-eye"></i> ${status === 'pending' ? 'Review' : 'View'}
                        </button>
                    `;
                    
                    if (status === 'pending') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('${planId}', 'approved')">
                                <i class="bi bi-check"></i> Approve
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('${planId}', 'returned')">
                                <i class="bi bi-x"></i> Return
                            </button>
                        `;
                    } else if (status === 'approved') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-warning" onclick="updateStatus('${planId}', 'pending')">
                                <i class="bi bi-arrow-clockwise"></i> Reopen
                            </button>
                        `;
                    } else if (status === 'returned') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('${planId}', 'approved')">
                                <i class="bi bi-check"></i> Approve
                            </button>
                        `;
                    }
                    
                    row.cells[6].innerHTML = actionButtons;
                }
            });
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update button states
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
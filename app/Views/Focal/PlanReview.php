<?php
// Check if user is logged in and has the correct role
if (!session()->get('isLoggedIn') || session()->get('role_id') != 1) {
    session()->setFlashdata('error', 'Unauthorized access.');
    header('Location: ' . base_url('/login'));
    exit;
}

// Get GAD plans data (this will be passed from controller)
$gadPlans = $gadPlans ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Submitted GAD Plans - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <div class="fw-bold"><?php echo esc(($first_name ?? 'Admin') . ' ' . ($last_name ?? 'User')); ?></div>
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
                    <a class="nav-link active" href="<?= base_url('Focal/PlanReview') ?>">
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Focal/dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Plan Review & Approval</li>
                    </ol>
                </div>
            </nav>

            <div class="container-fluid-py-4"></div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-eye text-primary"></i> View Submitted GAD Plans
                        </h1>
                        <div class="btn-group">
                            <button class="btn btn-outline-primary" onclick="filterByStatus('all')">
                            <i class="bi bi-funnel"></i> All
                        </button>
                        <button class="btn btn-outline-warning" onclick="filterByStatus('pending')">
                            <i class="bi bi-clock"></i> Pending
                        </button>
                        <button class="btn btn-outline-success" onclick="filterByStatus('approved')">
                            <i class="bi bi-check-circle"></i> Approved
                        </button>
                        <button class="btn btn-outline-danger" onclick="filterByStatus('returned')">
                            <i class="bi bi-arrow-left-circle"></i> Returned
                        </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Table -->
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
                                        <th>Division</th>
                                        <th>Status</th>
                                        <th>Review Date</th>
                                        <th>Reviewed By</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewTableBody">
                                    <?php if (!isset($gadPlans) || empty($gadPlans)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No GAD plans found.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($gadPlans as $plan): ?>
                                    <tr data-status="<?php echo strtolower($plan['status'] ?? 'pending'); ?>" data-plan-id="<?php echo esc($plan['plan_id']); ?>">
                                        <td><?php echo esc('GAD-' . str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT)); ?></td>
                                        <td><?php echo esc($plan['activity'] ?? 'N/A'); ?></td>
                                        <td>
                                            <?php echo esc($plan['division'] ?? 'Unknown Division'); ?>
                                        </td>
                                        <td>
                                            <?php
                                            $status = $plan['status'] ?? 'pending';
                                            $badgeClass = match(strtolower($status)) {
                                                'approved' => 'bg-success',
                                                'returned' => 'bg-danger',
                                                'finalized' => 'bg-info',
                                                'draft' => 'bg-secondary',
                                                'in review' => 'bg-primary',
                                                default => 'bg-warning'
                                            };
                                            ?>
                                            <span class="badge <?php echo $badgeClass; ?>"><?php echo esc(ucfirst($status)); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            // Show the most recent review date
                                            $reviewDate = null;
                                            if (!empty($plan['returned_at'])) {
                                                $reviewDate = $plan['returned_at'];
                                            } elseif (!empty($plan['approved_at'])) {
                                                $reviewDate = $plan['approved_at'];
                                            } elseif (!empty($plan['reviewed_at'])) {
                                                $reviewDate = $plan['reviewed_at'];
                                            }
                                            echo $reviewDate ? date('Y-m-d', strtotime($reviewDate)) : '-';
                                            ?>
                                        </td>
                                        <td class="text-center">
                                            <?php
                                            // Show the division of who performed the most recent action
                                            $reviewerDivision = '';
                                            if (!empty($plan['returned_by_division'])) {
                                                $reviewerDivision = $plan['returned_by_division'];
                                            } elseif (!empty($plan['approved_by_division'])) {
                                                $reviewerDivision = $plan['approved_by_division'];
                                            } elseif (!empty($plan['reviewed_by_division'])) {
                                                $reviewerDivision = $plan['reviewed_by_division'];
                                            }
                                            echo $reviewerDivision ?: '-';
                                            ?>
                                        </td>
                                        <td class="text-truncate" style="max-width: 200px;" title="<?php echo esc($plan['remarks'] ?? ''); ?>">
                                            <?php echo esc($plan['remarks'] ?? '-'); ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPlan('<?php echo esc($plan['plan_id']); ?>')">
                                                <i class="bi bi-eye"></i> View Details
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
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
                        <i class="bi bi-eye"></i> View GAD Plan Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="planDetailsContainer">
                        <input type="hidden" id="reviewPlanId" name="reviewPlanId">
                        
                        <!-- Plan Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><i class="bi bi-info-circle"></i> Plan Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">GAD Activity ID</label>
                                            <div class="border rounded p-2 bg-light" id="displayPlanId">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Division</label>
                                            <div class="border rounded p-2 bg-light" id="displayDivision">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-primary">Plan Title/Activity</label>
                                    <div class="border rounded p-2 bg-light" id="displayPlanTitle">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">Budget</label>
                                            <div class="border rounded p-2 bg-light" id="displayBudget">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-primary">HGDG Score</label>
                                            <div class="border rounded p-2 bg-light" id="displayHGDG">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Information -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="bi bi-clipboard-check"></i> Review Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">Current Status</label>
                                            <div class="border rounded p-2 bg-light" id="displayCurrentStatus">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">Review Date</label>
                                            <div class="border rounded p-2 bg-light" id="displayReviewDate">-</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold text-success">Reviewed By</label>
                                            <div class="border rounded p-2 bg-light" id="displayReviewedBy">-</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-success">Review Remarks/Comments</label>
                                    <div class="border rounded p-3 bg-light" id="displayRemarks" style="min-height: 120px; white-space: pre-wrap;">No remarks available</div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0"><i class="bi bi-list-ul"></i> Additional Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-info">Gender Issue/GAD Mandate</label>
                                    <div class="border rounded p-2 bg-light" id="displayIssueMandate">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-info">Cause of Gender Issue</label>
                                    <div class="border rounded p-2 bg-light" id="displayCause">-</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-info">GAD Objective</label>
                                    <div class="border rounded p-2 bg-light" id="displayObjective">-</div>
                                </div>
                            </div>
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

            // Show loading state
            Swal.fire({
                title: 'Updating Plan...',
                text: 'Please wait while we save your review.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send AJAX request to update plan
            fetch('<?= base_url('Focal/updateStatus') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    planId: planId,
                    status: status,
                    remarks: remarks
                })
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success) {
                    // Update the table row with new data
                    updatePlanStatusInTable(planId, status, remarks);

                    // Close modal
                    const modal = form.closest('.modal');
                    bootstrap.Modal.getInstance(modal).hide();

                    // Reset form
                    form.reset();
                    form.classList.remove('was-validated');

                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update plan.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while updating the plan.'
                });
            });
        }

        // View plan details
        function viewPlan(planId) {
            // Show loading state
            Swal.fire({
                title: 'Loading Plan Details...',
                text: 'Please wait while we fetch the plan information.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch plan details from database
            fetch(`<?= base_url('Focal/getPlanDetails') ?>/${planId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close();

                if (data.success) {
                    const plan = data.plan;

                    // Populate modal with plan details
                    document.getElementById('reviewPlanId').value = planId;
                    document.getElementById('displayPlanId').textContent = `GAD-${String(planId).padStart(3, '0')}`;
                    document.getElementById('displayPlanTitle').textContent = plan.activity || 'N/A';
                    document.getElementById('displayDivision').textContent = plan.division_name || 'Unknown Division';

                    // Budget and HGDG information
                    const budgetElement = document.getElementById('displayBudget');
                    if (budgetElement) {
                        const budget = plan.budget ? parseFloat(plan.budget) : 0;
                        budgetElement.textContent = budget > 0 ? `₱${budget.toLocaleString()}` : 'N/A';
                    }

                    const hgdgElement = document.getElementById('displayHGDG');
                    if (hgdgElement) {
                        const hgdg = plan.hgdg_score ? parseFloat(plan.hgdg_score) : 0;
                        hgdgElement.textContent = hgdg > 0 ? `${hgdg}%` : 'N/A';
                    }

                    // Review information
                    document.getElementById('displayCurrentStatus').innerHTML = `<span class="badge bg-${getStatusBadgeClass(plan.status)}">${plan.status || 'Pending'}</span>`;

                    // Review date - show the most recent action date
                    let reviewDate = 'Not reviewed yet';
                    let reviewAction = '';

                    if (plan.returned_at) {
                        reviewDate = new Date(plan.returned_at).toLocaleDateString();
                        reviewAction = ' (Returned)';
                    } else if (plan.approved_at) {
                        reviewDate = new Date(plan.approved_at).toLocaleDateString();
                        reviewAction = ' (Approved)';
                    } else if (plan.reviewed_at) {
                        reviewDate = new Date(plan.reviewed_at).toLocaleDateString();
                        reviewAction = ' (Reviewed)';
                    }

                    document.getElementById('displayReviewDate').textContent = reviewDate + reviewAction;

                    // Reviewed by - show the division of who performed the most recent action
                    let reviewedBy = 'Not reviewed yet';

                    if (plan.returned_by_division) {
                        reviewedBy = `${plan.returned_by_division} (Returned)`;
                    } else if (plan.approved_by_division) {
                        reviewedBy = `${plan.approved_by_division} (Approved)`;
                    } else if (plan.reviewed_by_division) {
                        reviewedBy = `${plan.reviewed_by_division} (Reviewed)`;
                    }

                    document.getElementById('displayReviewedBy').textContent = reviewedBy;

                    // Remarks
                    document.getElementById('displayRemarks').textContent = plan.remarks || 'No remarks available';

                    // Additional details
                    const issueElement = document.getElementById('displayIssueMandate');
                    if (issueElement) issueElement.textContent = plan.issue_mandate || 'N/A';

                    const causeElement = document.getElementById('displayCause');
                    if (causeElement) causeElement.textContent = plan.cause || 'N/A';

                    const objectiveElement = document.getElementById('displayObjective');
                    if (objectiveElement) {
                        if (Array.isArray(plan.gad_objective)) {
                            objectiveElement.textContent = plan.gad_objective.join(', ');
                        } else {
                            objectiveElement.textContent = plan.gad_objective || 'N/A';
                        }
                    }

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('reviewPlanModal'));
                    modal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to load plan details.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while loading plan details.'
                });
            });
        }





        // Helper function to get status badge class
        function getStatusBadgeClass(status) {
            const statusLower = (status || '').toLowerCase();
            switch(statusLower) {
                case 'approved': return 'success';
                case 'returned': return 'danger';
                case 'finalized': return 'info';
                case 'draft': return 'secondary';
                case 'in review': return 'primary';
                default: return 'warning';
            }
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
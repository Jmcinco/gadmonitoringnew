

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
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"> </i> GAD Monitoring System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc(($first_name ?? 'GAD') . ' ' . ($last_name ?? 'Member')); ?></div>
                        <small class="text-light">GAD Member</small>
                    </div>
                </div>
            </div>
           <!-- Navigation Menu -->
      <!-- Navigation Menu -->
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link" href="<?= base_url('MemberDashboard') ?>">
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
          <a class="nav-link active" href="<?= base_url('Member/PlanReview') ?>">
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
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('Member/dashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Plan Review & Approval</li>
                    </ol>
                </div>
            </nav>

            <div class="container-fluid py-4"></div>
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-clipboard-check text-primary"></i> GAD Plan Review & Approval
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
                                    <h5 class="mb-0">GAD Plans for Review & Approval</h5>
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
                                        <th style="width: 12%;">GAD Activity ID</th>
                                        <th style="width: 20%;">Division</th>
                                        <th style="width: 10%;" class="text-center">Status</th>
                                        <th style="width: 12%;" class="text-center">Review Date</th>
                                        <th style="width: 15%;" class="text-center">Reviewed By</th>
                                        <th style="width: 20%;">Remarks</th>
                                        <th style="width: 11%;" class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewTableBody">
                                    <?php if (!isset($gadPlans) || empty($gadPlans)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No GAD plans found.</td>
                                    </tr>
                                    <?php else: ?>
                                    <?php foreach ($gadPlans as $plan): ?>
                                    <tr data-status="<?php echo strtolower($plan['status'] ?? 'pending'); ?>" data-plan-id="<?php echo esc($plan['plan_id']); ?>">
                                        <td style="width: 12%;"><?php echo esc('GAD-' . str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT)); ?></td>
                                        <td style="width: 20%;">
                                            <?php echo esc($plan['division'] ?? 'Unknown Division'); ?>
                                        </td>
                                        <td style="width: 10%;" class="text-center">
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
                                        <td style="width: 12%;" class="text-center">
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
                                        <td style="width: 15%;" class="text-center">
                                            <?php
                                            // Show who performed the most recent action
                                            $reviewerName = '';
                                            if (!empty($plan['returned_by_name'])) {
                                                $reviewerName = $plan['returned_by_name'] . ' ' . $plan['returned_by_lastname'];
                                            } elseif (!empty($plan['approved_by_name'])) {
                                                $reviewerName = $plan['approved_by_name'] . ' ' . $plan['approved_by_lastname'];
                                            } elseif (!empty($plan['reviewed_by_name'])) {
                                                $reviewerName = $plan['reviewed_by_name'] . ' ' . $plan['reviewed_by_lastname'];
                                            }
                                            echo $reviewerName ?: '-';
                                            ?>
                                        </td>
                                        <td style="width: 20%;" class="text-truncate" title="<?php echo esc($plan['remarks'] ?? ''); ?>">
                                            <?php echo esc($plan['remarks'] ?? '-'); ?>
                                        </td>
                                        <td style="width: 11%;" class="text-center">
                                            <div class="btn-group-vertical" role="group">
                                                <button class="btn btn-sm btn-outline-primary mb-1" onclick="reviewPlan('<?php echo esc($plan['plan_id']); ?>')">
                                                    <i class="bi bi-clipboard-check"></i> Review
                                                </button>
                                                <?php
                                                $status = strtolower($plan['status'] ?? 'pending');
                                                if (in_array($status, ['pending', 'draft', 'returned', 'submitted'])):
                                                ?>
                                                <button class="btn btn-sm btn-outline-success mb-1" onclick="updateStatus('<?php echo esc($plan['plan_id']); ?>', 'approved')">
                                                    <i class="bi bi-check"></i> Approve
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('<?php echo esc($plan['plan_id']); ?>', 'returned')">
                                                    <i class="bi bi-x"></i> Return
                                                </button>
                                                <?php elseif ($status === 'approved'): ?>
                                                <button class="btn btn-sm btn-outline-warning" onclick="updateStatus('<?php echo esc($plan['plan_id']); ?>', 'pending')">
                                                    <i class="bi bi-arrow-clockwise"></i> Reopen
                                                </button>
                                                <?php endif; ?>
                                            </div>
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

    <!--    Review Plan Modal -->
    <div class="modal fade" id="reviewPlanModal" tabindex="-1" aria-labelledby="reviewPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewPlanModalLabel">
                        <i class="bi bi-clipboard-check"></i> Review & Approve GAD Plan
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
                        <div class="card mb-4">
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

                        <!-- Review Form -->
                        <form id="reviewPlanForm" class="needs-validation" novalidate>
                            <input type="hidden" id="reviewPlanIdForm" name="reviewPlanId">
                            <div class="card">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0"><i class="bi bi-pencil-square"></i> Submit Your Review</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="reviewStatus" class="form-label fw-bold">Review Decision *</label>
                                                <select class="form-select" id="reviewStatus" name="reviewStatus" required>
                                                    <option value="">Select Decision</option>
                                                    <option value="approved">Approve Plan</option>
                                                    <option value="returned">Return for Revision</option>
                                                    <option value="pending">Mark as Pending</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a review decision.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="reviewDate" class="form-label fw-bold">Review Date</label>
                                                <input type="date" class="form-control" id="reviewDate" name="reviewDate" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reviewRemarks" class="form-label fw-bold">Review Comments/Remarks *</label>
                                        <textarea class="form-control" id="reviewRemarks" name="reviewRemarks" rows="4" required placeholder="Please provide detailed comments about your review decision..."></textarea>
                                        <div class="invalid-feedback">
                                            Please provide review comments.
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="reviewedBy" class="form-label fw-bold">Reviewed By</label>
                                        <input type="text" class="form-control" id="reviewedBy" name="reviewedBy" value="<?php echo esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="submitReview()">
                        <i class="bi bi-check-circle"></i> Submit Review
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Global function declarations first
        var reviewPlan, updateStatus, handleFormSubmit, submitReview, updatePlanStatusInTable, getStatusBadgeClass, filterByStatus;

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
        handleFormSubmit = function(form) {
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
            fetch('<?= base_url('Member/updateStatus') ?>', {
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

        // Review plan function for Members
        reviewPlan = function(planId) {
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
            fetch(`<?= base_url('Member/getPlanDetails') ?>/${planId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                Swal.close();

                if (data.success) {
                    const plan = data.plan;

                    // Populate modal with plan details
                    const reviewPlanIdElement = document.getElementById('reviewPlanId');
                    if (reviewPlanIdElement) reviewPlanIdElement.value = planId;

                    const reviewPlanIdFormElement = document.getElementById('reviewPlanIdForm');
                    if (reviewPlanIdFormElement) reviewPlanIdFormElement.value = planId;

                    const displayPlanIdElement = document.getElementById('displayPlanId');
                    if (displayPlanIdElement) displayPlanIdElement.textContent = `GAD-${String(planId).padStart(3, '0')}`;

                    const displayPlanTitleElement = document.getElementById('displayPlanTitle');
                    if (displayPlanTitleElement) displayPlanTitleElement.textContent = plan.activity || 'No activity description';

                    const displayDivisionElement = document.getElementById('displayDivision');
                    if (displayDivisionElement) displayDivisionElement.textContent = plan.division_name || 'Unknown Division';

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
                    const statusElement = document.getElementById('displayCurrentStatus');
                    if (statusElement) {
                        statusElement.innerHTML = `<span class="badge bg-${getStatusBadgeClass(plan.status)}">${plan.status || 'Pending'}</span>`;
                    }

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

                    const reviewDateElement = document.getElementById('displayReviewDate');
                    if (reviewDateElement) {
                        reviewDateElement.textContent = reviewDate + reviewAction;
                    }

                    // Reviewed by - show the person who performed the most recent action
                    let reviewedBy = 'Not reviewed yet';

                    if (plan.returned_by_name) {
                        reviewedBy = `${plan.returned_by_name} ${plan.returned_by_lastname} (Returned)`;
                    } else if (plan.approved_by_name) {
                        reviewedBy = `${plan.approved_by_name} ${plan.approved_by_lastname} (Approved)`;
                    } else if (plan.reviewed_by_name) {
                        reviewedBy = `${plan.reviewed_by_name} ${plan.reviewed_by_lastname} (Reviewed)`;
                    }

                    const reviewedByElement = document.getElementById('displayReviewedBy');
                    if (reviewedByElement) {
                        reviewedByElement.textContent = reviewedBy;
                    }

                    // Remarks
                    const remarksElement = document.getElementById('displayRemarks');
                    if (remarksElement) {
                        remarksElement.textContent = plan.remarks || 'No remarks available';
                    }

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

                    // Set today's date in the review form
                    const reviewFormDateElement = document.getElementById('reviewDate');
                    if (reviewFormDateElement) {
                        reviewFormDateElement.value = new Date().toISOString().split('T')[0];
                    }

                    // Clear the review form
                    const reviewStatusElement = document.getElementById('reviewStatus');
                    if (reviewStatusElement) reviewStatusElement.value = '';

                    const reviewRemarksElement = document.getElementById('reviewRemarks');
                    if (reviewRemarksElement) reviewRemarksElement.value = '';

                    const reviewPlanFormElement = document.getElementById('reviewPlanForm');
                    if (reviewPlanFormElement) reviewPlanFormElement.classList.remove('was-validated');

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('reviewPlanModal'));
                    modal.show();

                    // Ensure modal is fully rendered before populating additional details
                    setTimeout(() => {
                        // Additional details that might need the modal to be fully rendered
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
                    }, 100);
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
                console.error('Error loading plan details:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while loading plan details.'
                });
            });
        }





        // Submit review function for Members
        submitReview = function() {
            const form = document.getElementById('reviewPlanForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            const planId = formData.get('reviewPlanId');
            const status = formData.get('reviewStatus');
            const remarks = formData.get('reviewRemarks');

            // Debug logging
            console.log('Form data:', { planId, status, remarks });

            // Validate required fields
            if (!planId || !status) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error!',
                    text: 'Please fill in all required fields.'
                });
                return;
            }

            // Show loading state
            Swal.fire({
                title: 'Submitting Review...',
                text: 'Please wait while we save your review.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send AJAX request to update plan
            fetch('<?= base_url('Member/updateStatus') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    reviewPlanId: planId,
                    reviewStatus: status,
                    reviewRemarks: remarks
                })
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                Swal.close();
                console.log('Response data:', data);

                if (data.success) {
                    // Update the table row with new data
                    updatePlanStatusInTable(planId, status, remarks);

                    // Close modal
                    bootstrap.Modal.getInstance(document.getElementById('reviewPlanModal')).hide();

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
                console.error('Fetch error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: `An error occurred while updating the plan: ${error.message}`
                });
            });
        }

        // Update status directly (for quick approve/return buttons)
        updateStatus = function(planId, newStatus) {
            let remarks = '';

            if (newStatus === 'returned') {
                remarks = prompt('Please provide reason for returning the plan:');
                if (!remarks) return;
            } else if (newStatus === 'approved') {
                remarks = 'Plan approved for implementation by Member';
            } else if (newStatus === 'pending') {
                remarks = 'Plan reopened for review by Member';
            }

            // Show loading state
            Swal.fire({
                title: 'Updating Status...',
                text: 'Please wait while we update the plan status.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send AJAX request to update status in database
            fetch('<?= base_url('Member/updateStatus') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    planId: planId,
                    status: newStatus,
                    remarks: remarks
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                Swal.close();

                if (data.success) {
                    // Update the table row with new data
                    updatePlanStatusInTable(planId, newStatus, remarks);

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
                        text: data.message || 'Failed to update plan status.'
                    });
                }
            })
            .catch(error => {
                Swal.close();
                console.error('Error updating plan status:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while updating the plan status.'
                });
            });
        }

        // Update plan status in table
        updatePlanStatusInTable = function(planId, status, remarks) {
            const rows = document.querySelectorAll('#reviewTableBody tr');

            rows.forEach(row => {
                const planIdCell = row.cells[0];
                if (planIdCell && planIdCell.textContent.includes(planId)) {
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

                    // Update status cell (column 2) if it exists
                    if (row.cells[2]) {
                        row.cells[2].innerHTML = statusBadge;
                    }

                    // Update remarks cell (column 5) if it exists
                    if (row.cells[5]) {
                        row.cells[5].textContent = remarks || '-';
                    }

                    // Update action buttons based on status
                    let actionButtons = `
                        <div class="btn-group-vertical" role="group">
                            <button class="btn btn-sm btn-outline-primary mb-1" onclick="reviewPlan('${planId}')">
                                <i class="bi bi-clipboard-check"></i> Review
                            </button>
                    `;

                    if (status === 'pending' || status === 'returned') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-success mb-1" onclick="updateStatus('${planId}', 'approved')">
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
                    }

                    actionButtons += '</div>';

                    // Update action buttons cell (column 6) if it exists
                    if (row.cells[6]) {
                        row.cells[6].innerHTML = actionButtons;
                    }
                }
            });
        }
        // Helper function to get status badge class
        getStatusBadgeClass = function(status) {
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
        filterByStatus = function(status) {
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

        // Ensure functions are available globally
        window.reviewPlan = reviewPlan;
        window.updateStatus = updateStatus;
        window.handleFormSubmit = handleFormSubmit;
        window.submitReview = submitReview;
        window.updatePlanStatusInTable = updatePlanStatusInTable;
        window.getStatusBadgeClass = getStatusBadgeClass;
        window.filterByStatus = filterByStatus;

        // Alternative event delegation approach for buttons
        document.addEventListener('click', function(e) {
            // Handle Review button clicks
            if (e.target.closest('button[onclick*="reviewPlan"]')) {
                e.preventDefault();
                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const planIdMatch = onclickAttr.match(/reviewPlan\('([^']+)'\)/);
                if (planIdMatch) {
                    reviewPlan(planIdMatch[1]);
                }
            }

            // Handle Update Status button clicks (Approve/Return/Reopen)
            if (e.target.closest('button[onclick*="updateStatus"]')) {
                e.preventDefault();
                const button = e.target.closest('button');
                const onclickAttr = button.getAttribute('onclick');
                const statusMatch = onclickAttr.match(/updateStatus\('([^']+)',\s*'([^']+)'\)/);
                if (statusMatch) {
                    updateStatus(statusMatch[1], statusMatch[2]);
                }
            }
        });

    </script>
</body>
</html>
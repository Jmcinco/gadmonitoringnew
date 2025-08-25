<?php
// Check if user is logged in and has the correct role (Member = role_id 2)
if (!session()->get('isLoggedIn') || session()->get('role_id') != 2) {
    session()->setFlashdata('error', 'Unauthorized access.');
    header('Location: ' . base_url('/login'));
    exit;
}

// Get accomplishments data (this will be passed from controller)
$accomplishments = $accomplishments ?? [];
$gadPlans = $gadPlans ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Review & Approval - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css" rel="stylesheet">
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
                        <small class="text-light">GAD Member</small>
                    </div>
                </div>
            </div>
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
          <a class="nav-link active" href="<?= base_url('Member/ReviewApproval') ?>">
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
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="<?php echo base_url('MemberDashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Accomplishment Review & Approval</li>
                    </ol>
                </div>
            </nav>
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clipboard-data fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-secondary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Draft</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="draftCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Submitted</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="submittedCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-send fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Reviewed</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="reviewedCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-eye fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Approved</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="approvedCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-danger shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Returned</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="returnedCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-arrow-left-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Header -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-clipboard-check text-primary"></i> GAD Accomplishment Review & Approval
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Accomplishment Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Submitted GAD Accomplishments</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <select class="form-select" id="statusFilter" onchange="filterByStatus(this.value)">
                                            <option value="">All Status</option>
                                            <option value="pending">Draft</option>
                                            <option value="completed">Submitted</option>
                                            <option value="under review">Under Review</option>
                                            <option value="approved">Approved</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                        <input type="text" class="form-control" placeholder="Search accomplishments..." id="searchInput">
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
                                            <th>Office</th>
                                            <th>Accomplishment</th>
                                            <th>Date Accomplished</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Reviewed By</th>
                                            <th>Remarks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accomplishmentTableBody">
                                        <?php if (!empty($accomplishments)): ?>
                                            <?php foreach ($accomplishments as $accomplishment): ?>
                                                <tr data-status="<?php echo strtolower($accomplishment['status']); ?>">
                                                    <td><?php echo esc('GAD-' . str_pad($accomplishment['output_id'], 3, '0', STR_PAD_LEFT)); ?></td>
                                                    <td><?php echo esc($accomplishment['office_name'] ?? 'Unknown Office'); ?></td>
                                                    <td class="text-truncate" style="max-width: 250px;" title="<?php echo esc($accomplishment['accomplishment']); ?>">
                                                        <?php echo esc($accomplishment['accomplishment']); ?>
                                                    </td>
                                                    <td><?php echo esc($accomplishment['date_accomplished']); ?></td>
                                                    <td>
                                                        <?php
                                                        $status = strtolower($accomplishment['status']);
                                                        $badgeClass = match($status) {
                                                            'pending' => 'bg-secondary',
                                                            'completed' => 'bg-success',
                                                            'under review' => 'bg-info',
                                                            'approved' => 'bg-success',
                                                            'returned' => 'bg-danger',
                                                            'failed' => 'bg-danger',
                                                            default => 'bg-secondary'
                                                        };
                                                        $statusText = match($status) {
                                                            'pending' => 'Draft',
                                                            'completed' => 'Completed',
                                                            'under review' => 'Under Review',
                                                            'approved' => 'Approved',
                                                            'returned' => 'Returned',
                                                            'failed' => 'Failed',
                                                            default => ucfirst($status)
                                                        };
                                                        ?>
                                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($accomplishment['file'])): ?>
                                                            <a href="<?= base_url('uploads/' . $accomplishment['file']) ?>" class="btn btn-sm btn-outline-info" target="_blank">
                                                                <i class="bi bi-file-earmark-pdf"></i> View
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                        // Show who reviewed the accomplishment
                                                        $reviewerName = '';
                                                        if (!empty($accomplishment['reviewed_by_name'])) {
                                                            $reviewerName = trim($accomplishment['reviewed_by_name'] . ' ' . ($accomplishment['reviewed_by_lastname'] ?? ''));
                                                            if (!empty($accomplishment['reviewed_by_division'])) {
                                                                $reviewerName .= '<br><small class="text-muted">(' . $accomplishment['reviewed_by_division'] . ')</small>';
                                                            }
                                                        }
                                                        echo $reviewerName ?: '<span class="text-muted">Not reviewed</span>';
                                                        ?>
                                                    </td>
                                                    <td class="text-truncate" style="max-width: 200px;" title="<?php echo esc($accomplishment['remarks'] ?? ''); ?>">
                                                        <?php echo esc($accomplishment['remarks'] ?? '-'); ?>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group-vertical" role="group">
                                                            <?php
                                                            $status = strtolower($accomplishment['status'] ?? 'pending');
                                                            if (in_array($status, ['completed', 'returned'])):
                                                            ?>
                                                            <!-- For completed/returned items: Show View and Reopen -->
                                                            <button class="btn btn-sm btn-outline-info mb-1" onclick="reviewAccomplishment('<?php echo esc($accomplishment['output_id']); ?>')">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-warning" onclick="updateStatus('<?php echo esc($accomplishment['output_id']); ?>', 'under review')">
                                                                <i class="bi bi-arrow-clockwise"></i> Reopen
                                                            </button>
                                                            <?php elseif (in_array($status, ['pending', 'under review'])): ?>
                                                            <!-- For pending/under review items: Show Review, Complete, Return -->
                                                            <button class="btn btn-sm btn-outline-primary mb-1" onclick="reviewAccomplishment('<?php echo esc($accomplishment['output_id']); ?>')">
                                                                <i class="bi bi-eye"></i> Review
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-success mb-1" onclick="updateStatus('<?php echo esc($accomplishment['output_id']); ?>', 'completed')">
                                                                <i class="bi bi-check"></i> Complete
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger" onclick="updateStatus('<?php echo esc($accomplishment['output_id']); ?>', 'returned')">
                                                                <i class="bi bi-x"></i> Return
                                                            </button>
                                                            <?php elseif ($status === 'approved'): ?>
                                                            <!-- For approved items: Show View only -->
                                                            <button class="btn btn-sm btn-outline-info" onclick="reviewAccomplishment('<?php echo esc($accomplishment['output_id']); ?>')">
                                                                <i class="bi bi-eye"></i> View
                                                            </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                                    No accomplishments available for review.
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



    <!-- Review Accomplishment Modal -->
    <div class="modal fade" id="reviewAccomplishmentModal" tabindex="-1" aria-labelledby="reviewAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewAccomplishmentModalLabel">
                        <i class="bi bi-eye"></i> Review GAD Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewAccomplishmentForm" class="needs-validation" novalidate>
                        <input type="hidden" id="reviewAccomplishmentId" name="reviewAccomplishmentId">

                        <!-- Accomplishment Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Accomplishment Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>GAD Activity ID:</strong> <span id="displayAccomplishmentId"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Office:</strong> <span id="displaySubmittedBy"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Date Accomplished:</strong> <span id="displaySubmissionDate"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Current Status:</strong> <span id="displayCurrentStatus"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <strong>Accomplishment Description:</strong>
                                        <p id="displayAccomplishmentText" class="mt-1 p-3 bg-light rounded"></p>
                                    </div>
                                </div>
                                <div class="row mt-2" id="fileSection" style="display: none;">
                                    <div class="col-12">
                                        <strong>Attached File:</strong>
                                        <a id="displayFile" href="#" target="_blank" class="btn btn-sm btn-outline-info ms-2">
                                            <i class="bi bi-file-earmark-pdf"></i> View File
                                        </a>
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
                                        <option value="completed">Complete</option>
                                        <option value="returned">Returned</option>
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
                            <input type="text" class="form-control" id="reviewedBy" name="reviewedBy" value="<?php echo esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?>" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="reviewAccomplishmentForm" class="btn btn-primary">Save Review</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
    <script>
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            updateStatistics();

            // Set max date to today
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('dateAccomplished').setAttribute('max', today);
        });

        // Update statistics cards
        function updateStatistics() {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr[data-status]');
            let total = 0, draft = 0, submitted = 0, reviewed = 0, approved = 0, returned = 0;

            rows.forEach(row => {
                const status = row.dataset.status;
                total++;
                switch(status) {
                    case 'pending': draft++; break;
                    case 'completed': submitted++; break;
                    case 'under review': reviewed++; break;
                    case 'approved': approved++; break;
                    case 'returned': returned++; break;
                }
            });

            document.getElementById('totalCount').textContent = total;
            document.getElementById('draftCount').textContent = draft;
            document.getElementById('submittedCount').textContent = submitted;
            document.getElementById('reviewedCount').textContent = reviewed;
            document.getElementById('approvedCount').textContent = approved;
            document.getElementById('returnedCount').textContent = returned;
        }

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
            if (form.id === 'reviewAccomplishmentForm') {
                const formData = new FormData(form);
                const status = formData.get('reviewStatus');
                const outputId = formData.get('reviewAccomplishmentId');
                const remarks = formData.get('reviewRemarks');

                // Show loading state
                Swal.fire({
                    title: 'Saving Review...',
                    text: 'Please wait while we save your review.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Use the correct parameter names for the existing method
                fetch('<?= base_url("Member/reviewAccomplishment") ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                    },
                    body: new URLSearchParams({
                        outputId: outputId,
                        status: status,
                        remarks: remarks
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An error occurred: ' + error.message, 'error');
                });
            }
        }

        // Review accomplishment
        function reviewAccomplishment(outputId) {
            const modal = new bootstrap.Modal(document.getElementById('reviewAccomplishmentModal'));
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');

            rows.forEach(row => {
                const reviewButton = row.querySelector('button[onclick*="reviewAccomplishment(\'' + outputId + '\')"]');
                if (reviewButton) {
                    // Get current status from the row
                    const currentStatus = row.dataset.status;
                    const isReadOnly = ['completed', 'returned', 'approved'].includes(currentStatus);

                    document.getElementById('reviewAccomplishmentId').value = outputId;
                    document.getElementById('displayAccomplishmentId').textContent = row.cells[0].textContent;
                    document.getElementById('displaySubmittedBy').textContent = row.cells[1].textContent;
                    document.getElementById('displaySubmissionDate').textContent = row.cells[3].textContent;
                    document.getElementById('displayCurrentStatus').innerHTML = row.cells[4].innerHTML;
                    document.getElementById('displayAccomplishmentText').textContent = row.cells[2].textContent;

                    // Handle file display
                    const fileCell = row.cells[5];
                    const fileLink = fileCell.querySelector('a');
                    if (fileLink) {
                        document.getElementById('displayFile').href = fileLink.href;
                        document.getElementById('fileSection').style.display = 'block';
                    } else {
                        document.getElementById('fileSection').style.display = 'none';
                    }

                    // Configure modal based on status
                    const modalTitle = document.getElementById('reviewAccomplishmentModalLabel');
                    const reviewForm = document.querySelector('#reviewAccomplishmentModal .row:has(#reviewStatus)');
                    const remarksSection = document.querySelector('#reviewAccomplishmentModal .mb-3:has(#reviewRemarks)');
                    const reviewedBySection = document.querySelector('#reviewAccomplishmentModal .mb-3:has(#reviewedBy)');
                    const saveButton = document.querySelector('#reviewAccomplishmentModal .btn-primary');

                    if (isReadOnly) {
                        // View-only mode
                        modalTitle.innerHTML = '<i class="bi bi-eye"></i> View GAD Accomplishment';

                        // Hide form fields
                        reviewForm.style.display = 'none';
                        saveButton.style.display = 'none';

                        // Show existing remarks and reviewer info
                        const remarksText = row.cells[7].textContent.trim();
                        const reviewerText = row.cells[6].innerHTML;

                        document.getElementById('reviewRemarks').value = remarksText !== '-' ? remarksText : 'No remarks provided';
                        document.getElementById('reviewRemarks').readOnly = true;
                        document.getElementById('reviewedBy').value = reviewerText.replace(/<[^>]*>/g, '').trim() || 'Not reviewed';

                        // Show remarks and reviewer sections as read-only
                        remarksSection.style.display = 'block';
                        reviewedBySection.style.display = 'block';

                    } else {
                        // Edit mode
                        modalTitle.innerHTML = '<i class="bi bi-eye"></i> Review GAD Accomplishment';

                        // Show form fields
                        reviewForm.style.display = 'block';
                        saveButton.style.display = 'inline-block';

                        // Set review date to today
                        document.getElementById('reviewDate').value = new Date().toISOString().split('T')[0];

                        // Clear form
                        document.getElementById('reviewStatus').value = '';
                        document.getElementById('reviewRemarks').value = '';
                        document.getElementById('reviewRemarks').readOnly = false;

                        // Show remarks and reviewer sections for editing
                        remarksSection.style.display = 'block';
                        reviewedBySection.style.display = 'block';
                    }
                }
            });

            modal.show();
        }

        // Update status directly (for quick approve/return buttons)
        function updateStatus(outputId, newStatus) {
            let title = '';
            let text = '';
            let confirmButtonText = '';

            switch(newStatus) {
                case 'completed':
                    title = 'Complete Accomplishment';
                    text = 'Are you sure you want to mark this accomplishment as completed?';
                    confirmButtonText = 'Yes, Complete';
                    break;
                case 'returned':
                    title = 'Return Accomplishment';
                    text = 'Are you sure you want to return this accomplishment for revision?';
                    confirmButtonText = 'Yes, Return';
                    break;
                case 'under review':
                    title = 'Mark Under Review';
                    text = 'Are you sure you want to mark this accomplishment as under review?';
                    confirmButtonText = 'Yes, Mark Under Review';
                    break;
            }

            Swal.fire({
                title: title,
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: confirmButtonText,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (newStatus === 'returned') {
                        // Ask for remarks when returning
                        Swal.fire({
                            title: 'Return Reason',
                            input: 'textarea',
                            inputLabel: 'Please provide reason for returning:',
                            inputPlaceholder: 'Enter your reason here...',
                            inputAttributes: {
                                'aria-label': 'Return reason'
                            },
                            showCancelButton: true,
                            confirmButtonText: 'Return',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed && result.value) {
                                updateAccomplishmentStatus(outputId, newStatus, result.value);
                            }
                        });
                    } else {
                        const defaultRemarks = newStatus === 'completed' ?
                            'Accomplishment completed by GAD Member' :
                            'Accomplishment marked under review';
                        updateAccomplishmentStatus(outputId, newStatus, defaultRemarks);
                    }
                }
            });
        }

        // Update accomplishment status in database
        function updateAccomplishmentStatus(outputId, status, remarks) {
            // Show loading state
            Swal.fire({
                title: 'Updating Status...',
                text: 'Please wait while we update the accomplishment status.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Send AJAX request to update accomplishment
            fetch('<?= base_url('Member/updateAccomplishmentStatus') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                },
                body: new URLSearchParams({
                    outputId: outputId,
                    status: status,
                    remarks: remarks
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'An error occurred: ' + error.message, 'error');
            });
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr[data-status]');

            rows.forEach(row => {
                if (status === '' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#accomplishmentTableBody tr[data-status]');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Helper function to get status badge
        function getStatusBadge(status) {
            const statusLower = status.toLowerCase();
            let badgeClass = 'bg-secondary';
            let statusText = status;

            switch(statusLower) {
                case 'pending':
                    badgeClass = 'bg-secondary';
                    statusText = 'Draft';
                    break;
                case 'completed':
                    badgeClass = 'bg-success';
                    statusText = 'Completed';
                    break;
                case 'under review':
                    badgeClass = 'bg-info';
                    statusText = 'Under Review';
                    break;
                case 'approved':
                    badgeClass = 'bg-success';
                    statusText = 'Approved';
                    break;
                case 'returned':
                    badgeClass = 'bg-danger';
                    statusText = 'Returned';
                    break;
            }

            return `<span class="badge ${badgeClass}">${statusText}</span>`;
        }
    </script>
</body>
</html>

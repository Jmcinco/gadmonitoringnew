<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Submission - GAD Management System</title>
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
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .form-label {
            font-weight: 600;
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
            <!-- User Info -->
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
                    <a class="nav-link active" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">
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
                        <li class="breadcrumb-item"><a href="dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Accomplishment Submission</li>
                    </ol>
                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-cloud-upload text-primary"></i> GAD Accomplishment Submission
                        </h1>
                        <button type="button" class="btn btn-primary" onclick="openAccomplishmentModal()">
                            <i class="bi bi-plus-circle"></i> Submit New Accomplishment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Total'] ?? 0); ?></h4>
                            <p class="card-text">Total</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-secondary text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Draft'] ?? 0); ?></h4>
                            <p class="card-text">Draft</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Submitted'] ?? 0); ?></h4>
                            <p class="card-text">Submitted</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Under Review'] ?? 0); ?></h4>
                            <p class="card-text">Under Review</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Accepted'] ?? 0); ?></h4>
                            <p class="card-text">Accepted</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="card bg-danger text-white">
                        <div class="card-body text-center">
                            <h4 class="card-title"><?php echo esc($statistics['Returned'] ?? 0); ?></h4>
                            <p class="card-text">Returned</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accomplishment Submission Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">GAD Accomplishments by Office</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <select class="form-select" onchange="filterByStatus(this.value)">
                                            <option value="">All Status</option>
                                            <option value="Draft">Draft</option>
                                            <option value="Submitted">Submitted</option>
                                            <option value="Under Review">Under Review</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Returned">Returned</option>
                                        </select>
                                        <input type="text" class="form-control" placeholder="Search..." id="searchInput">
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
                                            <th>Actual Accomplishment</th>
                                            <th>Date Accomplished</th>
                                            <th>File Upload</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accomplishmentTableBody">
                                        <?php if (isset($accomplishments) && !empty($accomplishments)): ?>
                                            <?php foreach ($accomplishments as $accomplishment): ?>
                                                <tr data-status="<?php echo strtolower($accomplishment['status']); ?>">
                                                    <td><?php echo esc('GAD-' . str_pad($accomplishment['plan_id'], 3, '0', STR_PAD_LEFT)); ?></td>
                                                    <td><?php echo esc($accomplishment['office_name'] ?? 'Unknown Division'); ?></td>
                                                    <td class="text-content"><?php echo esc(substr($accomplishment['accomplishment'], 0, 100)) . (strlen($accomplishment['accomplishment']) > 100 ? '...' : ''); ?></td>
                                                    <td><?php echo esc(date('Y-m-d', strtotime($accomplishment['date_accomplished']))); ?></td>
                                                    <td>
                                                        <?php if ($accomplishment['file']): ?>
                                                            <a href="<?php echo base_url('uploads/' . $accomplishment['file']); ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                                <i class="bi bi-file-earmark-pdf"></i> View
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No file</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        $status = strtolower($accomplishment['status']);
                                                        $badgeClass = match($status) {
                                                            'pending' => 'bg-warning',
                                                            'completed' => 'bg-success',
                                                            'under review' => 'bg-primary',
                                                            'approved' => 'bg-success',
                                                            'returned' => 'bg-danger',
                                                            'failed' => 'bg-danger',
                                                            default => 'bg-secondary'
                                                        };
                                                        $statusText = match($status) {
                                                            'pending' => 'Draft',
                                                            'completed' => 'Completed',
                                                            'under review' => 'Submitted',
                                                            'approved' => 'Approved',
                                                            'returned' => 'Returned',
                                                            'failed' => 'Failed',
                                                            default => ucfirst($status)
                                                        };
                                                        ?>
                                                        <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <?php
                                                            $statusLower = strtolower($accomplishment['status']);
                                                            if (in_array($statusLower, ['pending'])): ?>
                                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishmentById(<?php echo $accomplishment['output_id']; ?>)" title="Edit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-success" onclick="submitAccomplishment(<?php echo $accomplishment['output_id']; ?>)" title="Submit for Review">
                                                                    <i class="bi bi-send"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment(<?php echo $accomplishment['output_id']; ?>)" title="Delete">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            <?php elseif ($statusLower === 'returned'): ?>
                                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishmentById(<?php echo $accomplishment['output_id']; ?>)" title="Edit and Resubmit">
                                                                    <i class="bi bi-pencil"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-outline-info" onclick="viewAccomplishment(<?php echo $accomplishment['output_id']; ?>)" title="View Details">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            <?php elseif ($statusLower === 'completed'): ?>
                                                                <span class="badge bg-info">
                                                                    <i class="bi bi-clock"></i> Awaiting Review
                                                                </span>
                                                            <?php elseif ($statusLower === 'under review'): ?>
                                                                <span class="badge bg-info">
                                                                    <i class="bi bi-eye"></i> Under Review
                                                                </span>
                                                            <?php elseif ($statusLower === 'approved'): ?>
                                                                <span class="badge bg-success">
                                                                    <i class="bi bi-check-circle"></i> Approved
                                                                </span>
                                                            <?php else: ?>
                                                                <button class="btn btn-sm btn-outline-info" onclick="viewAccomplishment(<?php echo $accomplishment['output_id']; ?>)" title="View Details">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="7" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No accomplishments found. Click "Submit New Accomplishment" to get started.
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

    <!-- Add Accomplishment Modal -->
    <div class="modal fade" id="addAccomplishmentModal" tabindex="-1" aria-labelledby="addAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccomplishmentModalLabel">
                        <i class="bi bi-plus-circle"></i> Submit New Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccomplishmentForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gadActivityId" class="form-label">GAD Activity ID *</label>
                                    <select class="form-select" id="gadActivityId" name="gadActivityId" required>
                                        <option value="">Select GAD Activity</option>
                                        <?php if (isset($gadPlans) && !empty($gadPlans)): ?>
                                            <?php foreach ($gadPlans as $plan): ?>
                                                <option value="<?php echo esc($plan['plan_id']); ?>">
                                                    <?php echo esc($plan['gad_activity_id']); ?> - <?php echo esc($plan['activity']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No GAD Plans available (<?php echo isset($gadPlans) ? count($gadPlans) : 'not set'; ?> plans)</option>
                                        <?php endif; ?>
                                    </select>
                                    <!-- Debug info -->
                                    <?php if (ENVIRONMENT === 'development'): ?>
                                        <small class="text-muted">Debug: <?php echo isset($gadPlans) ? count($gadPlans) . ' GAD plans loaded' : 'gadPlans variable not set'; ?></small>
                                    <?php endif; ?>
                                    <div class="invalid-feedback">
                                        Please select a GAD Activity.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="office" class="form-label">Office *</label>
                                    <select class="form-select" id="office" name="office" required>
                                        <option value="">Select Office</option>
                                        <?php if (isset($divisions) && !empty($divisions)): ?>
                                            <?php foreach ($divisions as $division): ?>
                                                <option value="<?php echo esc($division['division']); ?>"><?php echo esc($division['division']); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an office.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="actualAccomplishment" class="form-label">Actual Accomplishment *</label>
                            <textarea class="form-control" id="actualAccomplishment" name="actualAccomplishment" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="dateAccomplished" name="dateAccomplished" required>
                                    <div class="invalid-feedback">
                                        Please provide the date accomplished.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Draft">Save as Draft</option>
                                        <option value="Submitted">Submit for Review</option>
                                    </select>
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i>
                                            Draft: Save for later editing | Submit: Send to GAD Members for review
                                        </small>
                                    </div>
                                    <div class="alert alert-info mt-2" style="font-size: 0.9em;">
                                        <i class="bi bi-lightbulb"></i>
                                        <strong>Tip:</strong> Select "Submit for Review" to send this accomplishment to GAD Members for approval.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">File Upload</label>
                            <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="additionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="additionalRemarks" name="additionalRemarks" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary" onclick="saveAsDraft()">Save as Draft</button>
                    <button type="submit" form="addAccomplishmentForm" class="btn btn-primary">Submit Accomplishment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Accomplishment Modal -->
    <div class="modal fade" id="editAccomplishmentModal" tabindex="-1" aria-labelledby="editAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccomplishmentModalLabel">
                        <i class="bi bi-pencil"></i> Edit Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAccomplishmentForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editAccomplishmentId" name="editAccomplishmentId">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editGadActivityId" class="form-label">GAD Activity ID *</label>
                                    <select class="form-select" id="editGadActivityId" name="editGadActivityId" required>
                                        <option value="">Select GAD Activity</option>
                                        <?php if (isset($gadPlans) && !empty($gadPlans)): ?>
                                            <?php foreach ($gadPlans as $plan): ?>
                                                <option value="<?php echo esc($plan['plan_id']); ?>">
                                                    <?php echo esc($plan['gad_activity_id']); ?> - <?php echo esc($plan['activity']); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="" disabled>No GAD Plans available</option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a GAD Activity.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editOffice" class="form-label">Office *</label>
                                    <select class="form-select" id="editOffice" name="editOffice" required>
                                        <option value="">Select Office</option>
                                        <?php if (isset($divisions) && !empty($divisions)): ?>
                                            <?php foreach ($divisions as $division): ?>
                                                <option value="<?php echo esc($division['division']); ?>"><?php echo esc($division['division']); ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an office.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editActualAccomplishment" class="form-label">Actual Accomplishment *</label>
                            <textarea class="form-control" id="editActualAccomplishment" name="editActualAccomplishment" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="editDateAccomplished" name="editDateAccomplished" required>
                                    <div class="invalid-feedback">
                                        Please provide the date accomplished.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status *</label>
                                    <select class="form-select" id="editStatus" name="editStatus" required>
                                        <option value="">Select Status</option>
                                        <option value="Draft">Save as Draft</option>
                                        <option value="Submitted">Submit for Review</option>
                                    </select>
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle"></i>
                                            Draft: Save for later editing | Submit: Send to GAD Members for review
                                        </small>
                                    </div>
                                    <div class="alert alert-warning mt-2" style="font-size: 0.9em;">
                                        <i class="bi bi-exclamation-triangle"></i>
                                        <strong>Important:</strong> To submit this accomplishment for review, select "Submit for Review" from the status dropdown above.
                                    </div>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editFileUpload" class="form-label">File Upload</label>
                            <input type="file" class="form-control" id="editFileUpload" name="editFileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editAdditionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="editAdditionalRemarks" name="editAdditionalRemarks" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editAccomplishmentForm" class="btn btn-primary">Update Accomplishment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let currentEditingId = null;

        // Open accomplishment modal
        function openAccomplishmentModal(outputId = null) {
            currentEditingId = outputId;
            const modal = new bootstrap.Modal(document.getElementById('addAccomplishmentModal'));
            const form = document.getElementById('addAccomplishmentForm');

            if (outputId) {
                // Edit mode
                document.getElementById('addAccomplishmentModalLabel').innerHTML = '<i class="bi bi-pencil"></i> Edit Accomplishment';
                loadAccomplishmentData(outputId);
            } else {
                // Add mode
                document.getElementById('addAccomplishmentModalLabel').innerHTML = '<i class="bi bi-plus-circle"></i> Submit New Accomplishment';
                form.reset();
                form.classList.remove('was-validated');
            }

            modal.show();
        }

        // Load accomplishment data for editing
        function loadAccomplishmentData(outputId) {
            fetch(`<?= base_url("Focal/getAccomplishment/") ?>${outputId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const accomplishment = data.accomplishment;
                    document.getElementById('gadActivityId').value = accomplishment.plan_id;
                    document.getElementById('actualAccomplishment').value = accomplishment.accomplishment;
                    document.getElementById('dateAccomplished').value = accomplishment.date_accomplished;
                    document.getElementById('additionalRemarks').value = accomplishment.remarks || '';

                    // Set status - map database status to form values
                    let formStatusValue = 'Draft'; // default
                    const dbStatus = accomplishment.status ? accomplishment.status.toLowerCase() : 'pending';

                    switch (dbStatus) {
                        case 'pending':
                            formStatusValue = 'Draft';
                            break;
                        case 'completed':
                            formStatusValue = 'Submitted';
                            break;
                        case 'under review':
                        case 'approved':
                        case 'returned':
                            formStatusValue = 'Submitted'; // These can only be changed by GAD Members
                            break;
                        default:
                            formStatusValue = 'Draft';
                    }

                    document.getElementById('status').value = formStatusValue;
                } else {
                    Swal.fire('Error', 'Could not load accomplishment data: ' + data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Could not load accomplishment data: ' + error.message, 'error');
            });
        }

        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault();
                        event.stopPropagation();

                        if (form.checkValidity() === true) {
                            handleFormSubmit(form);
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Handle form submission
        function handleFormSubmit(form) {
            if (form.id === 'addAccomplishmentForm') {
                const formData = new FormData(form);
                const status = formData.get('status');

                // Add output ID if editing
                if (currentEditingId) {
                    formData.append('outputId', currentEditingId);
                }

                // Show loading state
                Swal.fire({
                    title: status === 'Submitted' ? 'Submitting Accomplishment...' : 'Saving Accomplishment...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const url = currentEditingId ?
                    '<?= base_url("Focal/updateAccomplishment") ?>' :
                    '<?= base_url("Focal/saveAccomplishment") ?>';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const successMessage = status === 'Submitted' ?
                            'Accomplishment submitted successfully! It will now be reviewed by GAD Members.' :
                            data.message;

                        Swal.fire('Success', successMessage, 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error', 'An error occurred: ' + error.message, 'error');
                });
            } else if (form.id === 'editAccomplishmentForm') {
                // Handle edit form submission
                const formData = new FormData(form);
                const status = formData.get('editStatus');
                const outputId = formData.get('editAccomplishmentId');

                // Debug: Log form data
                console.log('Edit form submission:');
                console.log('Status:', status);
                console.log('Output ID:', outputId);
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                // Add the outputId for the update
                formData.append('outputId', outputId);

                // Show loading state
                Swal.fire({
                    title: status === 'Submitted' ? 'Submitting Accomplishment...' : 'Updating Accomplishment...',
                    text: 'Please wait while we process your request.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch('<?= base_url("Focal/updateAccomplishment") ?>', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const successMessage = status === 'Submitted' ?
                            'Accomplishment submitted successfully! It will now be reviewed by GAD Members.' :
                            data.message;

                        Swal.fire('Success', successMessage, 'success').then(() => {
                            // Close the modal and reload the page
                            bootstrap.Modal.getInstance(document.getElementById('editAccomplishmentModal')).hide();
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

        // Add accomplishment to table
        function addAccomplishmentToTable(formData) {
            const tableBody = document.getElementById('accomplishmentTableBody');
            const newRow = document.createElement('tr');
            const gadActivityId = formData.get('gadActivityId');
            const office = formData.get('office');
            const actualAccomplishment = formData.get('actualAccomplishment');
            const dateAccomplished = formData.get('dateAccomplished');
            const status = formData.get('status');
            
            let statusBadge = '';
            if (status === 'Draft') statusBadge = '<span class="badge bg-warning">Draft</span>';
            else if (status === 'Submitted') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Completed') statusBadge = '<span class="badge bg-success">Completed</span>';
            else if (status === 'Under Review') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Approved') statusBadge = '<span class="badge bg-success">Approved</span>';
            else if (status === 'Returned') statusBadge = '<span class="badge bg-danger">Returned</span>';
            
            newRow.dataset.status = status.toLowerCase();
            newRow.innerHTML = `
                <td>${gadActivityId}</td>
                <td>${office}</td>
                <td>${actualAccomplishment}</td>
                <td>${dateAccomplished}</td>
                <td><span class="text-muted">No file</span></td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('${gadActivityId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('${gadActivityId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit accomplishment by output ID (proper way)
        function editAccomplishmentById(outputId) {
            // Show loading state
            Swal.fire({
                title: 'Loading...',
                text: 'Please wait while we load the accomplishment data.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch accomplishment data from server
            fetch(`<?= base_url("Focal/getAccomplishment/") ?>${outputId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.close(); // Close loading dialog

                console.log('API Response:', data); // Debug log

                if (data.success) {
                    const accomplishment = data.accomplishment;
                    console.log('Accomplishment data:', accomplishment); // Debug log

                    // Set the output ID for updating
                    document.getElementById('editAccomplishmentId').value = outputId;
                    console.log('Set editAccomplishmentId to:', outputId);

                    // Set GAD Activity ID
                    document.getElementById('editGadActivityId').value = accomplishment.plan_id;
                    console.log('Set editGadActivityId to:', accomplishment.plan_id);

                    // Set office/division
                    const officeValue = accomplishment.office_name || 'Unknown Division';
                    document.getElementById('editOffice').value = officeValue;
                    console.log('Set editOffice to:', officeValue);

                    // Set accomplishment details
                    document.getElementById('editActualAccomplishment').value = accomplishment.accomplishment;
                    console.log('Set editActualAccomplishment to:', accomplishment.accomplishment);

                    document.getElementById('editDateAccomplished').value = accomplishment.date_accomplished;
                    console.log('Set editDateAccomplished to:', accomplishment.date_accomplished);

                    document.getElementById('editAdditionalRemarks').value = accomplishment.remarks || '';
                    console.log('Set editAdditionalRemarks to:', accomplishment.remarks);

                    // Set status - map database status to form values
                    let formStatusValue = 'Draft'; // default
                    const dbStatus = accomplishment.status ? accomplishment.status.toLowerCase() : 'pending';

                    switch (dbStatus) {
                        case 'pending':
                            formStatusValue = 'Draft';
                            break;
                        case 'completed':
                        case 'under review':
                        case 'approved':
                            formStatusValue = 'Submitted'; // These are all submitted states
                            break;
                        case 'returned':
                            formStatusValue = 'Draft'; // Returned items can be edited as draft
                            break;
                        default:
                            formStatusValue = 'Draft';
                    }

                    document.getElementById('editStatus').value = formStatusValue;
                    console.log('Set editStatus to:', formStatusValue);

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('editAccomplishmentModal'));

                    // Wait for modal to be fully shown before ensuring data is populated
                    document.getElementById('editAccomplishmentModal').addEventListener('shown.bs.modal', function() {
                        // Double-check that all fields are populated after modal is shown
                        console.log('Modal shown, re-checking field values...');

                        // Re-populate fields to ensure they're set
                        document.getElementById('editAccomplishmentId').value = outputId;
                        document.getElementById('editGadActivityId').value = accomplishment.plan_id;
                        document.getElementById('editOffice').value = accomplishment.office_name || 'Unknown Division';
                        document.getElementById('editActualAccomplishment').value = accomplishment.accomplishment;
                        document.getElementById('editDateAccomplished').value = accomplishment.date_accomplished;
                        document.getElementById('editAdditionalRemarks').value = accomplishment.remarks || '';
                        document.getElementById('editStatus').value = formStatusValue;

                        console.log('Fields re-populated after modal shown');
                    }, { once: true }); // Only run once

                    modal.show();
                } else {
                    console.error('API Error:', data);
                    Swal.close(); // Close loading dialog

                    // Try fallback method using table data
                    console.log('Trying fallback method...');
                    if (populateEditFormFromTable(outputId)) {
                        // Show the modal with fallback data
                        const modal = new bootstrap.Modal(document.getElementById('editAccomplishmentModal'));
                        modal.show();
                    } else {
                        Swal.fire('Error', 'Could not load accomplishment data: ' + (data.message || 'Unknown error'), 'error');
                    }
                }
            })
            .catch(error => {
                Swal.close(); // Close loading dialog
                console.error('Network Error:', error);

                // Try fallback method using table data
                console.log('Network error, trying fallback method...');
                if (populateEditFormFromTable(outputId)) {
                    // Show the modal with fallback data
                    const modal = new bootstrap.Modal(document.getElementById('editAccomplishmentModal'));
                    modal.show();
                } else {
                    Swal.fire('Error', 'Could not load accomplishment data: ' + error.message, 'error');
                }
            });
        }

        // Fallback method to populate edit form from table data
        function populateEditFormFromTable(outputId) {
            console.log('Using fallback method to populate form from table data');

            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            let found = false;

            rows.forEach(row => {
                // Check if this row contains the output_id we're looking for
                const editButton = row.querySelector('button[onclick*="editAccomplishmentById(' + outputId + ')"]');
                if (editButton) {
                    found = true;
                    console.log('Found row for output_id:', outputId);

                    // Extract data from table cells
                    const gadActivityId = row.cells[0].textContent.trim();
                    const office = row.cells[1].textContent.trim();
                    const accomplishment = row.cells[2].textContent.trim();
                    const dateAccomplished = row.cells[3].textContent.trim();
                    const statusText = row.cells[5].textContent.trim();

                    // Populate form fields
                    document.getElementById('editAccomplishmentId').value = outputId;
                    document.getElementById('editOffice').value = office;
                    document.getElementById('editActualAccomplishment').value = accomplishment;
                    document.getElementById('editDateAccomplished').value = dateAccomplished;

                    // Map status
                    let formStatusValue = 'Draft';
                    if (statusText === 'Submitted' || statusText === 'Awaiting Review') {
                        formStatusValue = 'Submitted';
                    }
                    document.getElementById('editStatus').value = formStatusValue;

                    console.log('Populated form with table data');
                }
            });

            if (!found) {
                console.error('Could not find table row for output_id:', outputId);
            }

            return found;
        }

        // Edit accomplishment (old method - kept for compatibility)
        function editAccomplishment(gadActivityId) {
            // This function is kept for backward compatibility but should not be used
            console.warn('editAccomplishment is deprecated, use editAccomplishmentById instead');
        }

        // Update accomplishment in table
        function updateAccomplishmentInTable(formData) {
            const gadActivityId = formData.get('editAccomplishmentId');
            const newGadActivityId = formData.get('editGadActivityId');
            const office = formData.get('editOffice');
            const actualAccomplishment = formData.get('editActualAccomplishment');
            const dateAccomplished = formData.get('editDateAccomplished');
            const status = formData.get('editStatus');
            
            let statusBadge = '';
            if (status === 'Draft') statusBadge = '<span class="badge bg-warning">Draft</span>';
            else if (status === 'Submitted') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Completed') statusBadge = '<span class="badge bg-success">Completed</span>';
            else if (status === 'Under Review') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Approved') statusBadge = '<span class="badge bg-success">Approved</span>';
            else if (status === 'Returned') statusBadge = '<span class="badge bg-danger">Returned</span>';
            
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    row.dataset.status = status.toLowerCase();
                    row.cells[0].textContent = newGadActivityId;
                    row.cells[1].textContent = office;
                    row.cells[2].textContent = actualAccomplishment;
                    row.cells[3].textContent = dateAccomplished;
                    row.cells[5].innerHTML = statusBadge;
                    
                    // Update action buttons
                    row.cells[6].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('${newGadActivityId}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('${newGadActivityId}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            });
        }

        // Delete accomplishment
        function deleteAccomplishment(outputId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`<?= base_url("Focal/deleteAccomplishment/") ?>${outputId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Deleted!', data.message, 'success').then(() => {
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
            });
        }

        // Submit accomplishment
        function submitAccomplishment(outputId) {
            Swal.fire({
                title: 'Submit Accomplishment',
                text: "Are you sure you want to submit this accomplishment?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('outputId', outputId);
                    formData.append('status', 'Submitted');

                    fetch('<?= base_url("Focal/updateAccomplishmentStatus") ?>', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Submitted!', data.message, 'success').then(() => {
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
            });
        }

        // Save as draft
        function saveAsDraft() {
            const form = document.getElementById('addAccomplishmentForm');
            const statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status';
            statusInput.value = 'Draft';
            form.appendChild(statusInput);

            handleFormSubmit(form);
        }

        // View accomplishment
        function viewAccomplishment(outputId) {
            fetch(`<?= base_url("Focal/getAccomplishment/") ?>${outputId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const accomplishment = data.accomplishment;
                    console.log('Accomplishment data for view:', accomplishment); // Debug log

                    // Use the correct property names from OutputModel getAccomplishmentWithDetails
                    const planId = accomplishment.plan_id || 'N/A';
                    const planActivity = accomplishment.gad_activity || 'No activity description';
                    const division = accomplishment.office_name || 'Unknown Division';
                    const dateAccomplished = accomplishment.date_accomplished || 'Not specified';
                    const status = accomplishment.status || 'Unknown';
                    const accomplishmentText = accomplishment.accomplishment || 'No accomplishment details';
                    const remarks = accomplishment.remarks || '';

                    Swal.fire({
                        title: 'Accomplishment Details',
                        html: `
                            <div class="text-start">
                                <p><strong>GAD Activity:</strong> GAD-${String(planId).padStart(3, '0')} - ${planActivity}</p>
                                <p><strong>Division:</strong> ${division}</p>
                                <p><strong>Date Accomplished:</strong> ${dateAccomplished}</p>
                                <p><strong>Status:</strong> ${status}</p>
                                <p><strong>Accomplishment:</strong></p>
                                <p class="text-muted">${accomplishmentText}</p>
                                ${remarks ? `<p><strong>Remarks:</strong> ${remarks}</p>` : ''}
                            </div>
                        `,
                        width: '600px',
                        confirmButtonText: 'Close'
                    });
                } else {
                    Swal.fire('Error', 'Could not load accomplishment details: ' + data.message, 'error');
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Could not load accomplishment details: ' + error.message, 'error');
            });
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            
            rows.forEach(row => {
                if (status === '' || row.dataset.status === status.toLowerCase()) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Add status change highlighting for main form
        document.getElementById('status').addEventListener('change', function() {
            const alertDiv = document.querySelector('.alert-info');
            if (this.value === 'Submitted') {
                alertDiv.className = 'alert alert-success mt-2';
                alertDiv.innerHTML = '<i class="bi bi-check-circle"></i> <strong>Ready to Submit:</strong> This accomplishment will be sent to GAD Members for review.';
            } else {
                alertDiv.className = 'alert alert-info mt-2';
                alertDiv.innerHTML = '<i class="bi bi-lightbulb"></i> <strong>Tip:</strong> Select "Submit for Review" to send this accomplishment to GAD Members for approval.';
            }
        });

        // Add status change highlighting for edit form
        document.getElementById('editStatus').addEventListener('change', function() {
            const alertDiv = document.querySelector('.alert-warning');
            if (this.value === 'Submitted') {
                alertDiv.className = 'alert alert-success mt-2';
                alertDiv.innerHTML = '<i class="bi bi-check-circle"></i> <strong>Ready to Submit:</strong> This accomplishment will be sent to GAD Members for review.';
            } else {
                alertDiv.className = 'alert alert-warning mt-2';
                alertDiv.innerHTML = '<i class="bi bi-exclamation-triangle"></i> <strong>Important:</strong> To submit this accomplishment for review, select "Submit for Review" from the status dropdown above.';
            }
        });
    </script>
</body>
</html>
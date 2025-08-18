<?php
// Check if user is logged in and has the correct role (Focal = role_id 1)
if (!session()->get('isLoggedIn') || session()->get('role_id') != 1) {
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
    <title>GAD Accomplishment Review - GAD Management System</title>
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

        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            border-radius: 0.75rem 0.75rem 0 0 !important;
            padding: 1.25rem 1.5rem;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: ">";
            color: #6c757d;
        }

        .breadcrumb-item a {
            color: var(--bs-primary);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: #6c757d;
        }

        .border-left-primary {
            border-left: 0.25rem solid var(--bs-primary) !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid #e74a3b !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .text-xs {
            font-size: 0.7rem;
        }

        .font-weight-bold {
            font-weight: 700 !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        .view-only-notice {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            border: 1px solid #2196f3;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            color: #1565c0;
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
                        <li class="breadcrumb-item"><a href="<?php echo base_url('FocalDashboard'); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Accomplishment Review</li>
                    </ol>
                </div>
            </nav>

            <!-- View Only Notice -->
            <div class="view-only-notice">
                <div class="d-flex align-items-center">
                    <i class="bi bi-info-circle me-2 fs-4"></i>
                    <div>
                        <strong>View Only Access</strong>
                        <p class="mb-0">You have read-only access to accomplishment reviews. You can view details but cannot modify or approve accomplishments.</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCount">
                                        <?= count($accomplishments) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clipboard-data fa-2x text-gray-300"></i>
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
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Draft</div>
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
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Submitted</div>
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Under Review</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="underReviewCount">0</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x text-gray-300"></i>
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

            <!-- Accomplishment Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">Submitted GAD Accomplishments (View Only)</h5>
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
                                            <th>Submitted By</th>
                                            <th>Accomplishment</th>
                                            <th>Date Accomplished</th>
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Remarks</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accomplishmentTableBody">
                                        <?php if (!empty($accomplishments)): ?>
                                            <?php foreach ($accomplishments as $accomplishment): ?>
                                                <tr data-status="<?= esc($accomplishment['status']) ?>">
                                                    <td>GAD-<?= str_pad($accomplishment['plan_id'], 3, '0', STR_PAD_LEFT) ?></td>
                                                    <td><?= esc($accomplishment['office_name'] ?? 'Unknown Office') ?></td>
                                                    <td class="text-truncate" style="max-width: 200px;" title="<?= esc($accomplishment['accomplishment']) ?>">
                                                        <?= esc(substr($accomplishment['accomplishment'], 0, 50)) ?><?= strlen($accomplishment['accomplishment']) > 50 ? '...' : '' ?>
                                                    </td>
                                                    <td><?= esc($accomplishment['date_accomplished']) ?></td>
                                                    <td>
                                                        <?php
                                                        $status = strtolower($accomplishment['status']);
                                                        $badgeClass = match($status) {
                                                            'pending' => 'bg-warning',
                                                            'completed' => 'bg-info',
                                                            'under review' => 'bg-warning',
                                                            'approved' => 'bg-success',
                                                            'returned' => 'bg-danger',
                                                            default => 'bg-secondary'
                                                        };
                                                        $statusText = match($status) {
                                                            'pending' => 'Draft',
                                                            'completed' => 'Submitted',
                                                            'under review' => 'Under Review',
                                                            'approved' => 'Approved',
                                                            'returned' => 'Returned',
                                                            default => ucfirst($status)
                                                        };
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($accomplishment['file'])): ?>
                                                            <a href="<?= base_url('Uploads/' . $accomplishment['file']) ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                <i class="bi bi-file-earmark-pdf"></i> View
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted">No file</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-truncate" style="max-width: 150px;" title="<?= esc($accomplishment['remarks'] ?? '') ?>">
                                                        <?= esc($accomplishment['remarks'] ?? '-') ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-outline-primary" onclick="viewAccomplishment('<?= $accomplishment['output_id'] ?>')">
                                                            <i class="bi bi-eye"></i> View Details
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center text-muted py-4">
                                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                                    No accomplishments found.
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

    <!-- View Accomplishment Modal -->
    <div class="modal fade" id="viewAccomplishmentModal" tabindex="-1" aria-labelledby="viewAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewAccomplishmentModalLabel">
                        <i class="bi bi-eye"></i> View GAD Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                    <strong>Submitted By:</strong> <span id="displaySubmittedBy"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Date Accomplished:</strong> <span id="displayDateAccomplished"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Current Status:</strong> <span id="displayCurrentStatus"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <strong>Accomplishment:</strong>
                                    <p class="mt-2 p-3 bg-light rounded" id="displayAccomplishmentText"></p>
                                </div>
                            </div>
                            <div class="row mt-2" id="fileSection" style="display: none;">
                                <div class="col-12">
                                    <strong>Attached File:</strong>
                                    <a href="#" id="displayFile" target="_blank" class="btn btn-outline-primary btn-sm ms-2">
                                        <i class="bi bi-file-earmark-pdf"></i> View File
                                    </a>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <strong>Remarks:</strong>
                                    <p class="mt-2 p-3 bg-light rounded" id="displayRemarks">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Only Notice -->
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>View Only:</strong> You can view accomplishment details but cannot modify or approve them.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
        });

        // Update statistics
        function updateStatistics() {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr[data-status]');
            let counts = {
                total: rows.length,
                draft: 0,
                submitted: 0,
                underReview: 0,
                approved: 0,
                returned: 0
            };

            rows.forEach(row => {
                const status = row.dataset.status.toLowerCase();
                switch(status) {
                    case 'pending':
                        counts.draft++;
                        break;
                    case 'completed':
                        counts.submitted++;
                        break;
                    case 'under review':
                        counts.underReview++;
                        break;
                    case 'approved':
                        counts.approved++;
                        break;
                    case 'returned':
                        counts.returned++;
                        break;
                }
            });

            document.getElementById('totalCount').textContent = counts.total;
            document.getElementById('draftCount').textContent = counts.draft;
            document.getElementById('submittedCount').textContent = counts.submitted;
            document.getElementById('underReviewCount').textContent = counts.underReview;
            document.getElementById('approvedCount').textContent = counts.approved;
            document.getElementById('returnedCount').textContent = counts.returned;
        }

        // View accomplishment details
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

                    // Use the correct property names from OutputModel getAccomplishmentWithDetails
                    const planId = accomplishment.plan_id || 'N/A';
                    const planActivity = accomplishment.gad_activity || 'No activity description';
                    const division = accomplishment.office_name || 'Unknown Division';
                    const dateAccomplished = accomplishment.date_accomplished || 'Not specified';
                    const status = accomplishment.status || 'Unknown';
                    const accomplishmentText = accomplishment.accomplishment || 'No accomplishment details';
                    const remarks = accomplishment.remarks || '';

                    // Populate modal
                    document.getElementById('displayAccomplishmentId').textContent = `GAD-${String(planId).padStart(3, '0')}`;
                    document.getElementById('displaySubmittedBy').textContent = division;
                    document.getElementById('displayDateAccomplished').textContent = dateAccomplished;
                    document.getElementById('displayAccomplishmentText').textContent = accomplishmentText;
                    document.getElementById('displayRemarks').textContent = remarks || '-';

                    // Set status badge
                    const statusLower = status.toLowerCase();
                    let statusBadge = '';
                    switch(statusLower) {
                        case 'pending':
                            statusBadge = '<span class="badge bg-warning">Draft</span>';
                            break;
                        case 'completed':
                            statusBadge = '<span class="badge bg-info">Submitted</span>';
                            break;
                        case 'under review':
                            statusBadge = '<span class="badge bg-warning">Under Review</span>';
                            break;
                        case 'approved':
                            statusBadge = '<span class="badge bg-success">Approved</span>';
                            break;
                        case 'returned':
                            statusBadge = '<span class="badge bg-danger">Returned</span>';
                            break;
                        default:
                            statusBadge = `<span class="badge bg-secondary">${status}</span>`;
                    }
                    document.getElementById('displayCurrentStatus').innerHTML = statusBadge;

                    // Handle file display
                    if (accomplishment.file) {
                        document.getElementById('displayFile').href = `<?= base_url('Uploads/') ?>${accomplishment.file}`;
                        document.getElementById('fileSection').style.display = 'block';
                    } else {
                        document.getElementById('fileSection').style.display = 'none';
                    }

                    // Show modal
                    const modal = new bootstrap.Modal(document.getElementById('viewAccomplishmentModal'));
                    modal.show();
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
    </script>
</body>
</html>
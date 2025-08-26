<?php
// Check if user is logged in and has the correct role
if (!session()->get('isLoggedIn') || session()->get('role_id') != 1) {
    session()->setFlashdata('error', 'Unauthorized access.');
    header('Location: ' . base_url('/login'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GAD Plan Preparation - GAD Monitoring System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    .mandate-icon {
      cursor: pointer;
      margin-left: 0.5rem;
      color: #0d6efd;
      font-size: 1.2rem;
      vertical-align: middle;
    }

    .additional-row {
      margin-top: 1rem;
      position: relative;
    }

    .remove-row {
      color: #dc3545;
      cursor: pointer;
      font-size: 0.9rem;
      position: absolute;
      right: 0;
      top: -1.5rem;
    }

    .table-responsive {
      min-height: 0.01%;
      overflow-x: auto;
    }

    /* Custom table styling */
    .table-container {
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      overflow: hidden;
    }

    .table-responsive {
      border-radius: 8px;
      max-height: 70vh;
      overflow-x: auto;
      overflow-y: auto;
      scrollbar-width: thin;
    }

    .table {
      margin-bottom: 0;
      font-size: 1.1rem;
      min-width: 1900px;
    }

    .table th {
      background-color: #2c3e50 !important;
      color: white !important;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 12px 8px;
      border: none;
      text-align: center;
      vertical-align: middle;
      white-space: nowrap;
      position: sticky;
      top: 0;
      z-index: 10;
    }

    .table td {
      padding: 12px 8px;
      vertical-align: middle;
      border-color: #e9ecef;
      font-size: 1.1rem;
      line-height: 1.5;
      word-wrap: break-word;
      word-break: break-word;
    }

    .table tbody tr:hover {
      background-color: #f8f9fa;
    }

    /* Column specific styling */
    .activity-id {
      font-family: 'Courier New', monospace;
      font-weight: 600;
      color: #2c3e50;
      text-align: center;
      min-width: 100px;
    }

    .text-content {
      max-width: 200px;
      word-wrap: break-word;
      line-height: 1.5;
    }

    .performance-targets {
      max-width: 400px;
      word-wrap: break-word;
      line-height: 1.5;
      min-width: 350px;
    }

    .timeline-cell {
      text-align: center;
      font-size: 0.9rem;
      min-width: 120px;
    }

    .responsible-unit {
      text-align: center;
      font-weight: 500;
      min-width: 150px;
    }

    .budget-cell {
      text-align: center;
      min-width: 100px;
    }

    .score-cell {
      text-align: center;
      font-weight: 600;
      min-width: 80px;
    }

    .status-cell {
      text-align: center;
      min-width: 80px;
    }

    .actions-cell {
      text-align: center;
      min-width: 120px;
      white-space: nowrap;
    }

    .attachment-cell {
      font-size: 0.9rem;
      min-width: 100px;
    }

    .division-cell {
      font-size: 1rem;
      font-weight: 500;
      text-align: center;
      min-width: 150px;
    }

    /* Responsive table improvements */
    .table-responsive {
      border-radius: 0.5rem;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .table {
      margin-bottom: 0;
      border-collapse: separate;
      border-spacing: 0;
    }

    .table thead th:first-child {
      border-top-left-radius: 0.5rem;
    }

    .table thead th:last-child {
      border-top-right-radius: 0.5rem;
    }

    .table tbody tr:hover {
      background-color: #f8f9fa;
    }

    .table tbody tr:last-child td:first-child {
      border-bottom-left-radius: 0.5rem;
    }

    .table tbody tr:last-child td:last-child {
      border-bottom-right-radius: 0.5rem;
    }

    /* Badge styling */
    .badge {
      font-size: 0.9rem;
      padding: 0.45rem 0.85rem;
      border-radius: 4px;
    }

    .badge.bg-warning {
      background-color: #ffc107 !important;
      color: #000 !important;
    }

    .badge.bg-success {
      background-color: #198754 !important;
    }

    .badge.bg-info {
      background-color: #0dcaf0 !important;
      color: #000 !important;
    }

    /* Button styling */
    .btn-sm {
      font-size: 0.95rem;
      padding: 0.4rem 0.7rem;
    }

    .btn-outline-info {
      font-weight: 600;
    }

    /* Custom View button styling */
    .btn-view {
      background-color: #17a2b8;
      border-color: #17a2b8;
      color: white;
      font-size: 0.9rem;
      padding: 0.35rem 0.6rem;
      border-radius: 4px;
    }

    .btn-view:hover {
      background-color: #138496;
      border-color: #117a8b;
      color: white;
    }

    .btn-view:focus {
      box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.25);
    }

    .btn-group-vertical .btn {
      border-radius: 0.25rem !important;
      margin-bottom: 0.2rem;
    }

    .btn-group-vertical .btn:last-child {
      margin-bottom: 0;
    }

    /* Custom table scrollbar */
    .table-responsive::-webkit-scrollbar {
      height: 12px;
      width: 12px;
    }

    .table-responsive::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 6px;
      margin: 4px;
    }

    .table-responsive::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 6px;
      border: 2px solid #f1f1f1;
    }

    .table-responsive::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .table-responsive::-webkit-scrollbar-corner {
      background: #f1f1f1;
    }

    /* Scrollbar styling for content divs */
    div[style*="overflow-y: auto"]::-webkit-scrollbar {
      width: 4px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 2px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb {
      background: #888;
      border-radius: 2px;
    }

    div[style*="overflow-y: auto"]::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    .modal-body {
      padding: 1.5rem;
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }

    .input-group {
      align-items: center;
    }

    .btn-group .btn {
      padding: 0.375rem 0.75rem;
    }

    .card-header {
      padding: 1rem 1.5rem;
      background-color: #f8f9fc;
      border-bottom: 1px solid #e3e6f0;
    }

    .modal-xl {
      max-width: 90%;
    }

    .card {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
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

      .modal-xl {
        max-width: 95%;
      }

      .table-responsive {
        font-size: 0.9rem;
      }

      .table th,
      .table td {
        padding: 0.6rem 0.4rem;
        font-size: 0.85rem;
      }

      .table th {
        font-size: 0.85rem;
      }
    }

    /* Fast Modal Styles */
    .modal.fade .modal-dialog {
      transition: transform 0.1s ease-out;
    }

    .modal-backdrop.fade {
      transition: opacity 0.1s ease-out;
    }

    .modal-content {
      border: none;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      transition: all 0.1s ease-out;
    }

    .modal-header {
      border-radius: 15px 15px 0 0;
    }

    .modal-footer {
      border-radius: 0 0 15px 15px;
    }

    /* Faster modal opening */
    .modal.show .modal-dialog {
      transform: none;
    }

    /* Responsible Units Styling */
    .responsible-unit-row {
      margin-bottom: 0.5rem;
    }

    .responsible-unit-row .d-flex {
      align-items: flex-start;
    }

    .responsible-unit-row .form-select {
      flex: 1;
    }

    .responsible-unit-row .btn {
      flex-shrink: 0;
      min-width: 40px;
    }

    .responsible-unit-row .invalid-feedback {
      width: 100%;
      margin-top: 0.25rem;
    }

    /* Remove button styling */
    .responsible-unit-row .btn-outline-danger {
      border-color: #dc3545;
      color: #dc3545;
    }

    .responsible-unit-row .btn-outline-danger:hover {
      background-color: #dc3545;
      border-color: #dc3545;
      color: white;
    }

    /* Add Another button styling */
    #responsibleUnitsContainer .btn-secondary {
      margin-top: 0.5rem;
    }

    /* 2-Column Form Improvements */
    .modal-xl .modal-body {
      padding: 1.5rem;
    }

    .modal-xl .row {
      margin-bottom: 0;
    }

    .modal-xl .col-md-6 {
      padding-left: 0.75rem;
      padding-right: 0.75rem;
    }

    /* Ensure consistent height for form elements in rows */
    .modal-xl .row .form-control,
    .modal-xl .row .form-select {
      min-height: 38px;
    }

    /* Better spacing for textarea elements */
    .modal-xl textarea.form-control {
      resize: vertical;
      min-height: 80px;
    }

    /* Improve button spacing in input groups */
    .modal-xl .input-group .btn {
      white-space: nowrap;
    }

    /* Better alignment for form labels */
    .modal-xl .form-label {
      margin-bottom: 0.5rem;
      font-weight: 600;
    }

    .modal.show .modal-backdrop {
      opacity: 0.5;
    }


  </style>
</head>

<body>
  <!-- Success Modal -->
  <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="successModalLabel">
            <i class="bi bi-check-circle me-2"></i> Success
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="successModalBody">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
        </div>
      </div>
    </div>
  </div>

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
          <a class="nav-link active" href="<?= base_url('Focal/PlanPreparation') ?>">
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
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
              <i class="bi bi-clipboard-data text-primary"></i> GAD Plan Preparation
            </h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gadPlanModal"
              onclick="resetGadPlanModal()">
              <i class="bi bi-plus-circle"></i> Create GAD Plan
            </button>
          </div>
          <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i>
            <strong>Note:</strong> You can edit and resubmit plans that have been <span class="badge bg-danger">Returned</span> by reviewers.
            Draft plans can always be edited before submission.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="row">
            <div class="col-12">
              <div class="card shadow-lg">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h5 class="mb-0">GAD Plan Activities</h5>
                  <div class="input-group w-25">
                    <input type="text" class="form-control" placeholder="Search GAD plans..." id="searchInput"
                      aria-label="Search GAD plans">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                      <i class="bi bi-search"></i>
                    </button>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-container">
                    <div class="table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th style="width: 5%;">Activity ID</th>
                            <th style="width: 10%;">Gender Issue / GAD Mandate</th>
                            <th style="width: 8%;">Cause of Gender Issue</th>
                            <th style="width: 8%;">GAD Objective</th>
                            <th style="width: 12%;">GAD Activity</th>
                            <th style="width: 7%;">Relevant MFO/PAP</th>
                            <th style="width: 20%;">Performance Targets</th>
                            <th style="width: 6%;">Timeline</th>
                            <th style="width: 7%;">Responsible Units</th>
                            <th style="width: 5%;">Budget</th>
                            <th style="width: 4%;">HGDG Score</th>
                            <th style="width: 4%;">Attachments</th>
                            <th style="width: 5%;">Submitted by</th>
                            <th style="width: 3%;">Status</th>
                            <th style="width: 5%;">Actions</th>
                        </tr>
                      </thead>
                      <tbody id="gadPlanTableBody">
                        <?php if (!isset($gadPlans) || empty($gadPlans)): ?>
                        <tr>
                          <td colspan="15" class="text-center">No GAD plans found.</td>
                        </tr>
                        <?php else: ?>
                        <?php foreach ($gadPlans as $plan): ?>
                        <tr data-plan-id="<?php echo esc($plan['plan_id'] ?? ''); ?>">
                          <td class="activity-id"><?php echo esc('GAD-ACT-' . str_pad($plan['plan_id'] ?? '0', 3, '0', STR_PAD_LEFT)); ?>
                          </td>
                          <td class="text-content">
                            <?php echo esc($plan['issue_mandate'] ?? ''); ?>
                          </td>
                          <td class="text-content">
                            <?php
                            $causeData = !empty($plan['cause']) ? json_decode($plan['cause'], true) : [];
                            if (is_array($causeData) && !empty($causeData)) {
                                $causes = array_map(function($cause) {
                                    return is_string($cause) ? esc(strip_tags($cause)) : esc($cause);
                                }, $causeData);
                                echo implode('<br>', $causes);
                            } else {
                                echo esc($plan['cause'] ?? 'N/A');
                            }
                            ?>
                          </td>
                          <td class="text-content">
                            <?php
                            $objectiveData = !empty($plan['gad_objective']) ? json_decode($plan['gad_objective'], true) : [];
                            if (is_array($objectiveData) && !empty($objectiveData)) {
                                $objectives = array_map(function($objective) {
                                    return is_string($objective) ? esc(strip_tags($objective)) : esc($objective);
                                }, $objectiveData);
                                echo implode('<br>', $objectives);
                            } else {
                                echo esc($plan['gad_objective'] ?? 'N/A');
                            }
                            ?>
                          </td>
                          <td class="text-content">
                            <div style="max-width: 250px; word-wrap: break-word; line-height: 1.4;">
                              <?php echo esc($plan['activity'] ?? 'N/A'); ?>
                            </div>
                          </td>
                          <td class="text-content">
                            <?php
                            $mfoPapData = !empty($plan['mfoPapData']) ? json_decode($plan['mfoPapData'], true) : [];
                            if (!empty($mfoPapData)) {
                                $mfoPapStrings = array_map(function($item) {
                                    $display = '<strong>' . esc($item['type']) . ':</strong> ' . esc($item['statement']);
                                    if (!empty($item['additional'])) {
                                        $display .= '<br><small class="text-muted">Additional: ' . esc($item['additional']) . '</small>';
                                    }
                                    return $display;
                                }, $mfoPapData);
                                echo implode('<br><br>', $mfoPapStrings);
                            } else {
                                echo 'N/A';
                            }
                            ?>
                          </td>
                          <td class="performance-targets">
                            <?php
                            $indicators = json_decode($plan['indicator_text'] ?? '[]', true) ?: [];
                            $targets    = json_decode($plan['target_text']    ?? '[]', true) ?: [];

                            if (empty($indicators)) {
                                echo 'N/A';
                            } else {
                                foreach ($indicators as $i => $indicator) {
                                    echo '<strong>Indicator:</strong> ' . esc($indicator);

                                    if (isset($targets[$i]) && $targets[$i] !== '') {
                                        echo '<br><strong>Target:</strong> ' . esc($targets[$i]);
                                    }

                                    if ($i < count($indicators) - 1) echo '<hr style="margin: 0.5rem 0;">';
                                }
                            }
                            ?>
                          </td>
                          <td class="timeline-cell">
                            <?php
                            $startDate = !empty($plan['startDate']) ? date('M d, Y', strtotime($plan['startDate'])) : 'N/A';
                            $endDate = !empty($plan['endDate']) ? date('M d, Y', strtotime($plan['endDate'])) : 'N/A';
                            echo $startDate . ' - ' . $endDate;
                            ?>
                          </td>
                          <td class="responsible-unit">
                            <?php
                            $responsibleUnits = !empty($plan['responsible_units']) ? json_decode($plan['responsible_units'], true) : [];
                            if (is_array($responsibleUnits) && !empty($responsibleUnits)) {
                                echo implode('<br>', array_map('esc', $responsibleUnits));
                            } else {
                                echo esc($plan['responsible_units'] ?? 'N/A');
                            }
                            ?>
                          </td>

                          <td class="budget-cell">
                            <a href="<?= base_url('Focal/BudgetCrafting') ?>?plan=<?= esc($plan['plan_id']) ?>"
                              class="btn btn-sm btn-outline-info" style="font-size: 0.85rem;">
                              ₱<?= number_format($plan['amount'], 0, '.', ',') ?>
                            </a>
                          </td>
                          <td class="score-cell">
                            <span class="badge bg-info">
                              <?php echo isset($plan['hgdg_score']) ? number_format($plan['hgdg_score'], 1) : 'N/A'; ?>
                            </span>
                          </td>
                          <td class="attachment-cell">
                            <?php
                            $fileAttachments = !empty($plan['file_attachments']) ? json_decode($plan['file_attachments'], true) : [];
                            if (is_array($fileAttachments) && !empty($fileAttachments)) {
                                if (count($fileAttachments) == 1) {
                                    // Single file - open directly
                                    $fileName = basename($fileAttachments[0]);
                                    echo '<a href="' . base_url('Uploads/' . esc($fileName)) . '" target="_blank" class="btn btn-sm btn-view" title="View File">';
                                    echo '<i class="bi bi-eye"></i> View';
                                    echo '</a>';
                                } else {
                                    // Multiple files - show selection modal
                                    echo '<button class="btn btn-sm btn-view" onclick="viewMultipleAttachments(' . esc($plan['plan_id']) . ')" title="View Attachments">';
                                    echo '<i class="bi bi-eye"></i> View (' . count($fileAttachments) . ')';
                                    echo '</button>';
                                }
                            } else {
                                echo '<span class="text-muted">No files</span>';
                            }
                            ?>
                          </td>

                          <td class="division-cell">
                            <?php echo esc($plan['submitted_by_name'] ?? 'N/A'); ?>
                          </td>

                          <td class="status-cell">
                            <?php
                            $status = $plan['status'] ?? 'Pending';
                            $badgeClass = match(strtolower($status)) {
                                'draft' => 'bg-warning text-dark',
                                'pending' => 'bg-info',
                                'approved' => 'bg-success',
                                'returned' => 'bg-danger',
                                'finalized' => 'bg-primary',
                                default => 'bg-secondary'
                            };
                            $statusText = match(strtolower($status)) {
                                'draft' => 'Draft',
                                'pending' => 'Submitted',
                                'approved' => 'Approved',
                                'returned' => 'Returned',
                                'finalized' => 'Finalized',
                                default => ucfirst($status)
                            };
                            ?>
                            <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                            <?php if (strtolower($status) === 'returned'): ?>
                            <br><small class="text-muted">Can be edited</small>
                            <?php endif; ?>
                          </td>
                          <td class="actions-cell">
                            <?php
                            $canEdit = in_array(strtolower($status), ['draft', 'returned']);
                            if ($canEdit):
                            ?>
                            <button class="btn btn-sm btn-outline-primary me-1"
                              onclick="editGadPlan(this, '<?php echo esc($plan['plan_id'] ?? ''); ?>')"
                              title="Edit Plan">
                              <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger"
                              onclick="deleteGadPlan(this, '<?php echo esc($plan['plan_id'] ?? ''); ?>')"
                              title="Delete Plan">
                              <i class="bi bi-trash"></i>
                            </button>
                            <?php else: ?>
                            <button class="btn btn-sm btn-outline-secondary me-1"
                              onclick="viewGadPlan('<?php echo esc($plan['plan_id'] ?? ''); ?>')"
                              title="View <?php echo $statusText; ?> plan">
                              <i class="bi bi-eye"></i> View Only
                            </button>
                            <?php endif; ?>
                          </td>
                        </tr>
                        <?php endforeach; endif?>
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

      <!-- Creation of GAD Plan -->
      <div class="modal fade" id="gadPlanModal" tabindex="-1" aria-labelledby="gadPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="gadPlanModalLabel">
                <i class="bi bi-clipboard-data"></i> Create New GAD Plan
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <?php if (session()->getFlashdata('error')): ?>
              <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
              <?php endif; ?>
              <?php echo form_open_multipart('GadPlanController/save', ['id' => 'gadPlanForm', 'class' => 'needs-validation', 'novalidate' => 'novalidate']); ?>
              <input type="hidden" name="indicator_text" id="indicator_text">
              <input type="hidden" name="target_text" id="target_text">
              <input type="hidden" name="is_draft" id="is_draft" value="0">
              <input type="hidden" name="status" id="status" value="">

              <!-- Row 1: Plan ID and GAD Mandate -->
              <div class="row g-3 mb-4">
                <div class="col-md-6">
                  <label for="displayPlanId" class="form-label"><strong>PLAN ID</strong></label>
                  <input type="text" class="form-control" id="displayPlanId" readonly>
                  <div class="form-text">Plan ID is automatically assigned and cannot be edited.</div>
                </div>
                <div class="col-md-6 position-relative">
                  <label for="issue_mandate" class="form-label"><strong>GAD MANDATE / GENDER ISSUE</strong> <span class="text-danger">*</span></label>
                  <div class="input-group">
                    <textarea
                      class="form-control <?php echo (isset($validation) && $validation->hasError('issue_mandate')) ? 'is-invalid' : ''; ?>"
                      id="issue_mandate" name="issue_mandate" rows="3"
                      placeholder="Describe the gender issue or GAD mandate..."
                      required><?php echo set_value('issue_mandate'); ?></textarea>
                    <button type="button" class="btn btn-outline-primary mandate-icon" data-bs-toggle="modal"
                      data-bs-target="#mandateModal" onclick="loadMandates()">
                      <i class="bi bi-search"></i>
                    </button>
                  </div>
                  <div class="invalid-feedback">
                    <?php echo (isset($validation) && $validation->hasError('issue_mandate')) ? $validation->getError('issue_mandate') : 'Please provide a gender issue or GAD mandate (min 10 characters).'; ?>
                  </div>
                </div>
              </div>

              <!-- Row 2: Cause and GAD Objective -->
              <div class="row g-3 mb-4">
                <div class="col-md-6" id="causeContainer">
                  <label for="cause" class="form-label"><strong>CAUSE OF GENDER ISSUE</strong> <span class="text-danger">*</span></label>
                  <input type="text"
                    class="form-control <?php echo (isset($validation) && $validation->hasError('cause')) ? 'is-invalid' : ''; ?>"
                    id="cause" name="cause" placeholder="Identify the root cause..." required
                    value="<?php echo set_value('cause'); ?>">
                  <div class="invalid-feedback">
                    <?php echo (isset($validation) && $validation->hasError('cause')) ? $validation->getError('cause') : 'Please provide a cause of the gender issue.'; ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <label for="gad_objective" class="form-label"><strong>GAD RESULT/OBJECTIVE</strong> <span class="text-danger">*</span></label>
                  <textarea
                    class="form-control <?php echo (isset($validation) && $validation->hasError('gad_objective')) ? 'is-invalid' : ''; ?>"
                    id="gad_objective" name="gad_objective" rows="3" placeholder="Define the expected GAD result..."
                    required><?php echo set_value('gad_objective'); ?></textarea>
                  <div class="invalid-feedback">
                    <?php echo (isset($validation) && $validation->hasError('gad_objective')) ? $validation->getError('gad_objective') : ''; ?>
                  </div>
                </div>
              </div>

              <!-- Row 3: GAD Activity (Full Width) -->
              <div class="mb-4">
                <label for="activity" class="form-label"><strong>GAD ACTIVITY</strong> <span class="text-danger">*</span></label>
                <textarea
                  class="form-control <?php echo (isset($validation) && $validation->hasError('activity')) ? 'is-invalid' : ''; ?>"
                  id="activity" name="activity" rows="3" placeholder="Describe the specific GAD activity..."
                  required><?php echo set_value('activity'); ?></textarea>
                <div class="invalid-feedback">
                  <?php echo (isset($validation) && $validation->hasError('activity')) ? $validation->getError('activity') : ''; ?>
                </div>
              </div>

                <div class="mb-4">
                  <label><strong>RELEVANT ORGANIZATION/MFO/PAP</strong></label>
                  <div id="mfoPapTableContainer">
                    <table class="table table-bordered mb-2" id="mfoPapTable_0">
                      <thead>
                        <tr>
                          <th style="width: 25%;">Type</th>
                          <th style="width: 60%;">MFO / PAP Statement</th>
                          <th style="width: 15%;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <select
                              class="form-select <?php echo (isset($validation) && $validation->hasError('mfoPapType_0')) ? 'is-invalid' : ''; ?>"
                              name="mfoPapType_0" onchange="updateMfoPapOptions(this, 0)">
                              <option value="" <?php echo set_select('mfoPapType_0', '', true); ?>>Select Type</option>
                              <option value="MFO" <?php echo set_select('mfoPapType_0', 'MFO'); ?>>MFO</option>
                              <option value="PAP" <?php echo set_select('mfoPapType_0', 'PAP'); ?>>PAP</option>
                            </select>
                          </td>
                          <td>
                            <select
                              class="form-select <?php echo (isset($validation) && $validation->hasError('mfoPapStatement_0')) ? 'is-invalid' : ''; ?>"
                              name="mfoPapStatement_0" id="mfoPapStatement_0" onchange="toggleCustomInput(this, 0)" style="display: block;">
                              <option value="">Select MFO/PAP first</option>
                            </select>
                            <div id="customInputContainer_0" style="display: none;">
                              <input
                                type="text"
                                class="form-control <?php echo (isset($validation) && $validation->hasError('mfoPapStatement_0')) ? 'is-invalid' : ''; ?>"
                                name="mfoPapStatementText_0" id="mfoPapStatementText_0"
                                placeholder="Enter custom MFO/PAP statement..."
                                value="<?php echo set_value('mfoPapStatementText_0'); ?>">

                            </div>
                          </td>
                          <td><button type="button" class="btn btn-danger btn-sm"
                              onclick="removeMfoPapRow(this)">Delete</button></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addMfoPapRow()">Add Another</button>
                  <?php if (isset($validation) && $validation->hasError('mfoPap')): ?>
                  <div class="invalid-feedback d-block"><?php echo $validation->getError('mfoPap'); ?></div>
                  <?php endif; ?>
                </div>

                <!-- Hidden data for JavaScript -->
                <script type="text/javascript">
                  const mfoData = <?php echo json_encode($mfos ?? []); ?>;
                  const papData = <?php echo json_encode($paps ?? []); ?>;

                  // Initialize MFO/PAP index counter
                  window.mfoPapIndex = 1;
                </script>



                <div class="mb-4">
                  <label class="form-label"><strong>PERFORMANCE INDICATOR(S) / TARGET(S)</strong> <span
                      class="text-danger">*</span></label>
                  <div id="indicatorTableContainer">
                    <table class="table table-bordered mb-2">
                      <thead>
                        <tr>
                          <th style="width:45%">Performance Indicator</th>
                          <th style="width:45%">Target</th>
                          <th style="width:10%">Action</th>
                        </tr>
                      </thead>
                      <tbody id="indicatorTableBody">
                        <tr id="indicatorRow_0">
                          <td>
                            <textarea class="form-control" name="indicators[0][indicator]" rows="2"
                              placeholder="Enter performance indicator..." required></textarea>
                          </td>
                          <td>
                            <textarea class="form-control" name="indicators[0][target]" rows="2"
                              placeholder="Enter target..." required></textarea>
                          </td>
                          <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm" onclick="removeIndicatorRow(0)">
                              <i class="bi bi-trash"></i>
                            </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <button type="button" class="btn btn-secondary btn-sm" onclick="addIndicatorRow()">
                    <i class="bi bi-plus-circle"></i> Add Another
                  </button>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="startDate" class="form-label"><strong>START DATE</strong> <span
                        class="text-danger">*</span></label>
                    <input type="date"
                      class="form-control <?php echo (isset($validation) && $validation->hasError('startDate')) ? 'is-invalid' : ''; ?>"
                      id="startDate" name="startDate" value="<?php echo set_value('startDate'); ?>" required>
                    <div class="invalid-feedback">
                      <?php echo (isset($validation) && $validation->hasError('startDate')) ? $validation->getError('startDate') : ''; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="endDate" class="form-label"><strong>END DATE</strong> <span
                        class="text-danger">*</span></label>
                    <input type="date"
                      class="form-control <?php echo (isset($validation) && $validation->hasError('endDate')) ? 'is-invalid' : ''; ?>"
                      id="endDate" name="endDate" value="<?php echo set_value('endDate'); ?>" required>
                    <div class="invalid-feedback">
                      <?php echo (isset($validation) && $validation->hasError('endDate')) ? $validation->getError('endDate') : ''; ?>
                    </div>
                  </div>
                </div>

                <!-- Row 4: Responsible Units and Budget -->
                <div class="row g-3 mb-4">
                  <div class="col-md-6" id="responsibleUnitsContainer">
                    <label for="responsibleUnits" class="form-label"><strong>RESPONSIBLE UNIT(S)/OFFICE(S)</strong> <span class="text-danger">*</span></label>
                    <div class="responsible-unit-row mb-2">
                      <div class="d-flex gap-2 align-items-start">
                        <select
                          class="form-select <?php echo (isset($validation) && $validation->hasError('responsibleUnits')) ? 'is-invalid' : ''; ?>"
                          name="responsibleUnits[]" required>
                          <option value="">Select Responsible Unit</option>
                          <?php if (isset($divisions) && !empty($divisions)): ?>
                          <?php foreach ($divisions as $division): ?>
                          <option value="<?= esc($division->division) ?>"
                            <?= set_select('responsibleUnits[]', $division->division) ?>>
                            <?= esc($division->division) ?>
                          </option>
                          <?php endforeach; ?>
                          <?php else: ?>
                          <option value="">No divisions available</option>
                          <?php endif; ?>
                        </select>
                      </div>
                      <div class="invalid-feedback">
                        <?php echo (isset($validation) && $validation->hasError('responsibleUnits')) ? $validation->getError('responsibleUnits') : 'Please select a responsible unit.'; ?>
                      </div>
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm" onclick="addResponsibleUnitRow()">
                      <i class="bi bi-plus-circle"></i> Add Another
                    </button>
                  </div>
                  <div class="col-md-6">
                    <label for="budgetAmount" class="form-label"><strong>TOTAL BUDGET</strong> <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <span class="input-group-text">₱</span>
                      <input type="number"
                        class="form-control <?php echo (isset($validation) && $validation->hasError('budgetAmount')) ? 'is-invalid' : ''; ?>"
                        id="budgetAmount" name="budgetAmount" step="0.01" min="0"
                        value="<?php echo set_value('budgetAmount'); ?>" required>
                      <button class="btn btn-outline-secondary" type="button" onclick="linkToBudgetCrafting()">
                        <i class="bi bi-link-45deg"></i> Link
                      </button>
                    </div>
                    <div class="form-text">
                      <i class="bi bi-info-circle"></i> Budget will be linked to the GAD Budget Crafting module.
                    </div>
                    <div class="invalid-feedback">
                      <?php echo (isset($validation) && $validation->hasError('budgetAmount')) ? $validation->getError('budgetAmount') : ''; ?>
                    </div>
                  </div>
                </div>

                <!-- Row 5: HGDG Score and Additional Field -->
                <div class="row g-3 mb-4">
                  <div class="col-md-6">
                    <label for="hgdgScore" class="form-label"><strong>HGDG SCORE</strong> <span class="text-danger">*</span></label>
                    <input type="number"
                      class="form-control <?php echo (isset($validation) && $validation->hasError('hgdgScore')) ? 'is-invalid' : ''; ?>"
                      id="hgdgScore" name="hgdgScore" step="0.01" min="0" max="100"
                      value="<?php echo set_value('hgdgScore'); ?>" required>
                    <div class="form-text">Enter the HGDG score (0.00 to 100.00).</div>
                    <div class="invalid-feedback">
                      <?php echo (isset($validation) && $validation->hasError('hgdgScore')) ? $validation->getError('hgdgScore') : 'Please enter a valid HGDG score between 0 and 100.'; ?>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label for="fileAttachments" class="form-label">
                      <strong>FILE ATTACHMENT(S)</strong>
                    </label>
                    <input type="file"
                      class="form-control <?= (isset($validation) && $validation->hasError('fileAttachments')) ? 'is-invalid' : ''; ?>"
                      id="fileAttachments" name="fileAttachments[]" multiple accept=".pdf,.doc,.docx,.jpg,.png">
                    <div class="form-text">
                      Upload approved project/program documents (PDF, DOC, DOCX, JPG, PNG).
                    </div>
                    <div class="invalid-feedback">
                      <?= (isset($validation) && $validation->hasError('fileAttachments'))
              ? $validation->getError('fileAttachments')
              : '' ?>
                    </div>
                  </div>
                </div>


                <input type="hidden" name="planId" id="planId">
                <?php echo form_close(); ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="bi bi-x-circle"></i> Cancel
                </button>
                <button type="button" class="btn btn-outline-secondary" onclick="submitGadPlan(true)">
                  <i class="bi bi-save"></i> Save as Draft
                </button>

                <button type="button" class="btn btn-primary" onclick="submitGadPlan(false)">
                  <i class="bi bi-check-circle"></i> Save GAD Plan
                </button>
              </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Mandate Selection Modal -->
      <div class="modal fade" id="mandateModal" tabindex="-1" aria-labelledby="mandateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mandateModalLabel">
                <i class="bi bi-search"></i> Select GAD Mandate
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="row mb-3">
                <div class="col-md-4">
                  <label for="filterYear" class="form-label">Filter by Year</label>
                  <select class="form-select" id="filterYear" onchange="loadMandates()">
                    <option value="">All Years</option>
                  </select>
                </div>
              </div>
              <button type="button" class="btn btn-success mb-3" onclick="showAddMandateForm()">
                <i class="bi bi-plus-circle"></i> Add New GAD Mandate
              </button>
              <div class="table-responsive">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 10%;"></th>
                      <th style="width: 15%;">Year</th>
                      <th style="width: 60%;">Description</th>
                      <th style="width: 15%;">Action</th>
                    </tr>
                  </thead>
                  <tbody id="mandateTableBody">
                    <tr>
                      <td colspan="4" class="text-center">Loading mandates...</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle"></i> Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Create Mandate Modal -->
      <div class="modal fade" id="createMandateModal" tabindex="-1" aria-labelledby="createMandateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="createMandateModalLabel">
                <i class="bi bi-plus-circle"></i> Add New GAD Mandate
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="createMandateForm" class="needs-validation" novalidate>
                <div class="mb-3">
                  <label for="newMandateDescription" class="form-label">Description <span
                      class="text-danger">*</span></label>
                  <textarea class="form-control" id="newMandateDescription" name="newMandateDescription" rows="3"
                    required></textarea>
                  <div class="invalid-feedback">Please provide a description.</div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle"></i> Cancel
              </button>
              <button type="button" class="btn btn-primary" onclick="saveNewMandate()">
                <i class="bi bi-check-circle"></i> Save
              </button>

            </div>
          </div>
        </div>
      </div>

      <!-- View Plan Modal -->
      <div class="modal fade" id="viewPlanModal" tabindex="-1" aria-labelledby="viewPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="viewPlanModalLabel">
                <i class="bi bi-eye"></i> View GAD Plan
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div id="viewPlanContent">
                <!-- Plan details will be populated here -->
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle"></i> Close
              </button>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
      <script>
        function esc(s) {
          return String(s).replace(/[&<>"']/g, m => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": "&#39;"
          } [m]));
        }

        function formatPlanId(planId) {
          return `GAD-ACT-${String(planId).padStart(3,'0')}`;
        }

        function resetGadPlanModal() {
          // Initialize modal if not already done
          if (!window.gadPlanModal) {
            window.gadPlanModal = new bootstrap.Modal(document.getElementById('gadPlanModal'));
          }

          const form = document.getElementById('gadPlanForm');
          form.reset();
          form.action = '<?= base_url("GadPlanController/save") ?>';
          form.classList.remove('was-validated');
          document.getElementById('planId').value = '';
          document.getElementById('displayPlanId').value = '';
          document.getElementById('is_draft').value = '0';
          document.getElementById('status').value = 'Pending';

          const units = document.getElementById('responsibleUnitsContainer');
          units.innerHTML =
            '<label class="form-label"><strong>RESPONSIBLE UNIT(S)/OFFICE(S)</strong> <span class="text-danger">*</span></label>' +
            '<div class="responsible-unit-row">' +
            '<select class="form-select" name="responsibleUnits[]" required>' +
            '<option value="">Select Responsible Unit</option>' +
            '<?php foreach($divisions as $d): ?>' +
            '<option value="<?= esc($d->division) ?>"><?= esc($d->division) ?></option>' +
            '<?php endforeach; ?>' +
            '</select>' +
            '<div class="invalid-feedback">Please select a responsible unit.</div>' +
            '</div>' +
            '<button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addResponsibleUnitRow()">Add Another</button>';
        }

        function addResponsibleUnitRow() {
          try {
            console.log('addResponsibleUnitRow called'); // Debug log

            const container = document.getElementById('responsibleUnitsContainer');
            if (!container) {
              console.error('Container not found');
              return;
            }

            // Check if we already have too many rows (optional limit)
            const existingRows = container.querySelectorAll('.responsible-unit-row');
            console.log('Existing rows:', existingRows.length); // Debug log

            if (existingRows.length >= 10) { // Set a reasonable limit
              alert('Maximum of 10 responsible units allowed.');
              return;
            }

            const row = document.createElement('div');
            row.className = 'responsible-unit-row mb-2';

            // Create the flex container
            const flexDiv = document.createElement('div');
            flexDiv.className = 'd-flex gap-2 align-items-start';

            // Create the select element
            const select = document.createElement('select');
            select.className = 'form-select';
            select.name = 'responsibleUnits[]';
            select.required = true;

            // Add default option
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Responsible Unit';
            select.appendChild(defaultOption);

            // Add division options from the existing select
            const existingSelect = container.querySelector('select[name="responsibleUnits[]"]');
            if (existingSelect) {
              console.log('Found existing select with', existingSelect.options.length, 'options'); // Debug log
              for (let i = 1; i < existingSelect.options.length; i++) {
                const option = document.createElement('option');
                option.value = existingSelect.options[i].value;
                option.textContent = existingSelect.options[i].textContent;
                select.appendChild(option);
              }
            } else {
              console.error('No existing select found');
            }

            // Create remove button
            const removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'btn btn-outline-danger btn-sm';
            removeBtn.title = 'Remove this unit';
            removeBtn.setAttribute('aria-label', 'Remove this unit');
            removeBtn.style.minWidth = '40px'; // Ensure button is visible

            // Create the icon element
            const icon = document.createElement('i');
            icon.className = 'bi bi-trash';
            removeBtn.appendChild(icon);

            removeBtn.onclick = function() {
              console.log('Remove button clicked'); // Debug log
              row.remove();
            };

            // Create invalid feedback div
            const invalidFeedback = document.createElement('div');
            invalidFeedback.className = 'invalid-feedback';
            invalidFeedback.textContent = 'Please select a responsible unit.';

            // Assemble the row
            flexDiv.appendChild(select);
            flexDiv.appendChild(removeBtn);
            row.appendChild(flexDiv);
            row.appendChild(invalidFeedback);

            // Insert before the "Add Another" button
            const addButton = container.querySelector('button[onclick="addResponsibleUnitRow()"]');
            if (addButton && addButton.parentNode === container) {
              container.insertBefore(row, addButton);
              console.log('Successfully added new row before button'); // Debug log
            } else {
              // Alternative: append to container and move button to end
              container.appendChild(row);
              if (addButton) {
                container.appendChild(addButton); // Move button to end
              }
              console.log('Successfully added new row at end'); // Debug log
            }

          } catch (error) {
            console.error('Error in addResponsibleUnitRow:', error);
          }
        }

        function removeResponsibleUnitRow(button) {
          try {
            const row = button.closest('.responsible-unit-row');
            if (row) {
              row.remove();
            }
          } catch (error) {
            console.error('Error in removeResponsibleUnitRow:', error);
          }
        }
        // Update MFO/PAP options based on type selection
        function updateMfoPapOptions(selectElement, index, preserveCustomDisplay = false) {
          const type = selectElement.value;
          const statementSelect = document.getElementById(`mfoPapStatement_${index}`);
          const textInput = document.getElementById(`mfoPapStatementText_${index}`);
          const customContainer = document.getElementById(`customInputContainer_${index}`);

          // Clear existing options
          statementSelect.innerHTML = '<option value="">Select ' + (type || 'MFO/PAP') + '</option>';

          // Only reset display if we're not preserving custom display
          if (!preserveCustomDisplay) {
            statementSelect.style.display = 'block';
            if (customContainer) {
              customContainer.style.display = 'none';
            }
            if (textInput) {
              textInput.value = '';
            }
          }

          if (type === 'MFO') {
            mfoData.forEach(mfo => {
              const option = document.createElement('option');
              option.value = mfo.mfo;
              option.textContent = `${mfo.mfo_code} - ${mfo.mfo}`;
              statementSelect.appendChild(option);
            });
            // Add Others option
            const othersOption = document.createElement('option');
            othersOption.value = 'Others';
            othersOption.textContent = 'Others (Custom Entry)';
            statementSelect.appendChild(othersOption);
          } else if (type === 'PAP') {
            papData.forEach(pap => {
              const option = document.createElement('option');
              option.value = pap.pap;
              option.textContent = `${pap.mfo_code || 'N/A'} - ${pap.pap}`;
              statementSelect.appendChild(option);
            });
            // Add Others option
            const othersOption = document.createElement('option');
            othersOption.value = 'Others';
            othersOption.textContent = 'Others (Custom Entry)';
            statementSelect.appendChild(othersOption);
          }
        }

        // Toggle custom input when "Others" is selected in statement dropdown
        function toggleCustomInput(selectElement, index) {
          const customContainer = document.getElementById(`customInputContainer_${index}`);
          const textInput = document.getElementById(`mfoPapStatementText_${index}`);

          if (selectElement.value === 'Others') {
            // Show custom input container, hide dropdown
            selectElement.style.display = 'none';
            customContainer.style.display = 'block';
            textInput.required = true;
            selectElement.required = false;
            textInput.focus();

            // Add a button to go back to dropdown
            if (!customContainer.querySelector('.back-to-dropdown')) {
              const backBtn = document.createElement('button');
              backBtn.type = 'button';
              backBtn.className = 'btn btn-sm btn-outline-secondary mt-2 back-to-dropdown';
              backBtn.textContent = 'Back to dropdown';
              backBtn.onclick = () => {
                selectElement.style.display = 'block';
                customContainer.style.display = 'none';
                textInput.value = '';
                additionalInput.value = '';
                textInput.required = false;
                selectElement.required = true;
                selectElement.value = '';
              };
              customContainer.appendChild(backBtn);
            }
          } else {
            // Hide custom input container when other options are selected
            selectElement.style.display = 'block';
            customContainer.style.display = 'none';
            textInput.required = false;
            selectElement.required = true;
          }
        }

        function addMfoPapRow() {
          const idx = window.mfoPapIndex++;
          const container = document.getElementById('mfoPapTableContainer');
          const tbl = document.createElement('table');
          tbl.className = 'table table-bordered mb-2';
          tbl.id = `mfoPapTable_${idx}`;
          tbl.innerHTML = `
    <thead><tr>
      <th style="width:25%">Type</th>
      <th style="width:60%">MFO / PAP Statement</th>
      <th style="width:15%">Action</th>
    </tr></thead>
    <tbody>
      <tr>
        <td>
          <select class="form-select" name="mfoPapType_${idx}" onchange="updateMfoPapOptions(this, ${idx})">
            <option value="">Select Type</option>
            <option value="MFO">MFO</option>
            <option value="PAP">PAP</option>
          </select>
        </td>
        <td>
          <select class="form-select" name="mfoPapStatement_${idx}" id="mfoPapStatement_${idx}" onchange="toggleCustomInput(this, ${idx})" style="display: block;">
            <option value="">Select MFO/PAP first</option>
          </select>
          <div id="customInputContainer_${idx}" style="display: none;">
            <input type="text" class="form-control" name="mfoPapStatementText_${idx}" id="mfoPapStatementText_${idx}"
                   placeholder="Enter custom MFO/PAP statement...">

          </div>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeMfoPapRow(this)">Delete</button>
        </td>
      </tr>
    </tbody>`;
          container.appendChild(tbl);
        }



        function removeMfoPapRow(element) {
          // Handle both button element and direct index parameter
          let idx;
          if (typeof element === 'object' && element.closest) {
            // If element is a button, find the table and extract index
            const tbl = element.closest('table[id^="mfoPapTable_"]');
            if (tbl) {
              idx = tbl.id.split('_')[1];
            }
          } else {
            // If element is already an index
            idx = element;
          }

          const tbl = document.getElementById(`mfoPapTable_${idx}`);
          if (tbl) tbl.remove();
        }

        function backToDropdown(index) {
          const selectElement = document.getElementById(`mfoPapStatement_${index}`);
          const customContainer = document.getElementById(`customInputContainer_${index}`);
          const textInput = document.getElementById(`mfoPapStatementText_${index}`);

          if (selectElement && customContainer) {
            selectElement.style.display = 'block';
            customContainer.style.display = 'none';
            textInput.value = '';
            textInput.required = false;
            selectElement.required = true;
            selectElement.value = '';
          }
        }





        document.getElementById('startDate').addEventListener('change', e =>
          document.getElementById('endDate').min = e.target.value
        );
        document.getElementById('endDate').addEventListener('change', e =>
          document.getElementById('startDate').max = e.target.value
        );

        (function () {
          'use strict';
          window.addEventListener('load', function () {
            Array.from(document.getElementsByClassName('needs-validation')).forEach(form => {
              form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Check if form is valid before proceeding
                let isValid = true;

                // Custom validation for MFO/PAP entries
                document.querySelectorAll('[id^="mfoPapTable_"]').forEach(tbl => {
                  const idx = tbl.id.split('_')[1];
                  const typeSelect = tbl.querySelector(`[name="mfoPapType_${idx}"]`);
                  const customContainer = tbl.querySelector(`#customInputContainer_${idx}`);
                  const textInput = tbl.querySelector(`[name="mfoPapStatementText_${idx}"]`);
                  const selectInput = tbl.querySelector(`[name="mfoPapStatement_${idx}"]`);

                  if (typeSelect && typeSelect.value) {
                    const isCustomMode = customContainer && customContainer.style.display === 'block';

                    if (isCustomMode) {
                      // In custom mode, text input should have value
                      if (!textInput || !textInput.value.trim()) {
                        isValid = false;
                        if (textInput) {
                          textInput.classList.add('is-invalid');
                        }
                      } else {
                        if (textInput) {
                          textInput.classList.remove('is-invalid');
                        }
                      }
                    } else {
                      // In dropdown mode, select should have value
                      if (!selectInput || !selectInput.value || selectInput.value === 'Others') {
                        isValid = false;
                        if (selectInput) {
                          selectInput.classList.add('is-invalid');
                        }
                      } else {
                        if (selectInput) {
                          selectInput.classList.remove('is-invalid');
                        }
                      }
                    }
                  }
                });

                form.classList.add('was-validated');

                if (isValid) {
                  console.log('Form validation passed, proceeding with save...');
                  saveGadPlan();
                } else {
                  console.log('Form validation failed, please check MFO/PAP entries');
                  Swal.fire('Validation Error', 'Please complete all MFO/PAP entries properly.', 'error');
                }
              }, false);
            });
          }, false);
        })();

        document.addEventListener('DOMContentLoaded', function () {
          // Pre-initialize all modals for faster opening
          window.modalsInitialized = false;
          window.gadPlanModal = null;
          window.mandateModal = null;
          window.createMandateModal = null;
          window.successModal = null;

          // Pre-initialize modals after a short delay to avoid blocking page load
          setTimeout(() => {
            if (document.getElementById('gadPlanModal') &&
                document.getElementById('mandateModal') &&
                document.getElementById('createMandateModal') &&
                document.getElementById('successModal')) {

              window.gadPlanModal = new bootstrap.Modal(document.getElementById('gadPlanModal'), {
                backdrop: 'static',
                keyboard: false
              });
              window.mandateModal = new bootstrap.Modal(document.getElementById('mandateModal'), {
                backdrop: 'static',
                keyboard: false
              });
              window.createMandateModal = new bootstrap.Modal(document.getElementById('createMandateModal'), {
                backdrop: 'static',
                keyboard: false
              });
              window.successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                backdrop: 'static',
                keyboard: false
              });
              window.modalsInitialized = true;
              console.log('Modals pre-initialized for faster opening');
            }
          }, 100);

          // Load mandates data
          loadMandates();
        });

        // Ultra-fast modal helper functions - Pre-initialized
        function showModal(modalId) {
          // Use pre-initialized modal instances for instant opening
          let modalInstance;

          if (window.modalsInitialized) {
            // Use pre-initialized modals - fastest path
            switch(modalId) {
              case 'gadPlanModal':
                modalInstance = window.gadPlanModal;
                break;
              case 'mandateModal':
                modalInstance = window.mandateModal;
                break;
              case 'createMandateModal':
                modalInstance = window.createMandateModal;
                break;
              case 'successModal':
                modalInstance = window.successModal;
                break;
            }
          }

          // Fallback if not pre-initialized
          if (!modalInstance) {
            const modalElement = document.getElementById(modalId);
            if (!modalElement) {
              console.error(`Modal with ID ${modalId} not found`);
              return;
            }
            modalInstance = new bootstrap.Modal(modalElement, {
              backdrop: 'static',
              keyboard: false
            });
          }

          // Show modal immediately - no delays
          modalInstance.show();
        }

        function hideModal(modalId) {
          // Use pre-initialized modal instances for faster hiding
          let modalInstance;
          switch(modalId) {
            case 'gadPlanModal':
              modalInstance = window.gadPlanModal;
              break;
            case 'mandateModal':
              modalInstance = window.mandateModal;
              break;
            case 'createMandateModal':
              modalInstance = window.createMandateModal;
              break;
            case 'successModal':
              modalInstance = window.successModal;
              break;
            default:
              const modalElement = document.getElementById(modalId);
              if (modalElement) {
                modalInstance = bootstrap.Modal.getInstance(modalElement);
              }
          }

          if (modalInstance) {
            modalInstance.hide();
          }
        }

        function loadMandates() {
          // Initialize mandate modal if not already done
          if (!window.mandateModal) {
            window.mandateModal = new bootstrap.Modal(document.getElementById('mandateModal'));
          }

          const year = document.getElementById('filterYear').value;
          const tb = document.getElementById('mandateTableBody');
          tb.innerHTML = `<tr><td colspan="4" class="text-center">Loading mandates...</td></tr>`;
          fetch('<?= base_url("GadPlanController/getMandates") ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
              },
              body: new URLSearchParams({
                year
              })
            })
            .then(r => {
              if (!r.ok) {
                throw new Error(`HTTP ${r.status}: ${r.statusText}`);
              }
              return r.json();
            })
            .then(d => {
              console.log('Mandates response:', d);
              tb.innerHTML = '';
              if (d.success) {
                if (d.mandates && d.mandates.length > 0) {
                d.mandates.forEach(m => {
                  const desc = m.description.replace(/'/g, "\\'");
                  const tr = document.createElement('tr');
                  tr.innerHTML = `
          <td><input type="radio" name="mandateSelect" onclick="selectMandate('${m.year}','${desc}',${m.id})"></td>
          <td>${m.year}</td>
          <td>${m.description}</td>
          <td>
            <div class="btn-group">
              <button class="btn btn-sm btn-outline-primary me-2" onclick="editMandate(${m.id},'${m.year}','${desc}')">
                <i class="bi bi-pencil"></i>
              </button>
              <button class="btn btn-sm btn-outline-danger" onclick="deleteMandate(${m.id})">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </td>`;
                  tb.appendChild(tr);
                });
                const years = [...new Set(d.mandates.map(m => m.year))].sort((a, b) => b - a);
                const sel = document.getElementById('filterYear');
                sel.innerHTML = '<option value="">All Years</option>';
                years.forEach(y => {
                  const o = document.createElement('option');
                  o.value = o.textContent = y;
                  if (o.value === year) o.selected = true;
                  sel.appendChild(o);
                });
                } else {
                  tb.innerHTML = `<tr><td colspan="4" class="text-center text-muted">No GAD mandates found for the selected year.</td></tr>`;
                }
              } else {
                console.error('API Error:', d);
                tb.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Error: ${d.message || 'Failed to load mandates'}</td></tr>`;
              }
            })
            .catch(error => {
              console.error('Error loading mandates:', error);
              tb.innerHTML = `<tr><td colspan="4" class="text-center text-danger">Failed to load mandates. Error: ${error.message}</td></tr>`;
            });
        }

        function selectMandate(year, desc, id) {
          document.getElementById('issue_mandate').value = desc;
          hideModal('mandateModal');
          showModal('gadPlanModal');
        }

        function showAddMandateForm() {
          hideModal('mandateModal');

          // Clean up any remaining backdrops - faster
          setTimeout(() => {
            document.querySelectorAll('.modal-backdrop').forEach(n => n.remove());
            document.body.classList.remove('modal-open');
            showModal('createMandateModal');
          }, 150);
        }

        let indicatorIndex = 1;

        function addIndicatorRow() {
          const tbody = document.getElementById('indicatorTableBody');
          const idx = indicatorIndex++;
          const tr = document.createElement('tr');
          tr.id = `indicatorRow_${idx}`;
          tr.innerHTML = `
    <td>
      <textarea class="form-control" 
                name="indicators[${idx}][indicator]" 
                rows="2" 
                placeholder="Enter performance indicator..." 
                required></textarea>
    </td>
    <td>
      <textarea class="form-control" 
                name="indicators[${idx}][target]" 
                rows="2" 
                placeholder="Enter target..." 
                required></textarea>
    </td>
    <td class="text-center">
      <button type="button" 
              class="btn btn-danger btn-sm" 
              onclick="removeIndicatorRow(${idx})">
        <i class="bi bi-trash"></i>
      </button>
    </td>`;
          tbody.appendChild(tr);
        }

        function removeIndicatorRow(idx) {
          const row = document.getElementById(`indicatorRow_${idx}`);
          if (row) row.remove();
        }

        function saveNewMandate() {
          const f = document.getElementById('createMandateForm');
          if (!f.checkValidity()) {
            f.classList.add('was-validated');
            return
          }
          const desc = document.getElementById('newMandateDescription').value;
          const id = document.getElementById('newMandateDescription').dataset.id || '';
          const yr = new Date().getFullYear().toString();
          fetch('<?= base_url("GadMandateController/save") ?>', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
                '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
              },
              body: new URLSearchParams({
                id,
                year: yr,
                description: desc
              })
            })
            .then(r => r.json())
            .then(d => {
              console.log('Server response:', d);
              if (d.success) {
                Swal.fire({
                  icon: 'success',
                  title: id ? 'Updated!' : 'Added!',
                  text: d.message,
                  timer: 1500,
                  showConfirmButton: false
                });
                // Reset modal textarea and id
                document.getElementById('newMandateDescription').value = '';
                document.getElementById('newMandateDescription').dataset.id = '';
                const cm = document.getElementById('createMandateModal');
                bootstrap.Modal.getInstance(cm).hide();
                cm.addEventListener('hidden.bs.modal', async function h() {
                  // Clean up any remaining backdrops
                  document.querySelectorAll('.modal-backdrop').forEach(n => n.remove());
                  document.body.classList.remove('modal-open');

                  // Show mandate modal
                  showModal('mandateModal');
                  loadMandates();
                  cm.removeEventListener('hidden.bs.modal', h);
                }, {
                  once: true
                });
              } else {
                Swal.fire('Error', d.message + (d.errors ? ': ' + Object.values(d.errors).join(', ') : ''), 'error');
              }
            })
            .catch(e => Swal.fire('Error', 'Unexpected: ' + e.message, 'error'));
        }

        function submitGadPlan(isDraft) {
          const indicatorRows = document.querySelectorAll('#indicatorTableBody tr');
          const indicators = [];
          const targets = [];
          indicatorRows.forEach(row => {
            const indEl = row.querySelector('textarea[name*="[indicator]"]');
            const tgtEl = row.querySelector('textarea[name*="[target]"]');
            if (indEl && tgtEl) {
              indicators.push(indEl.value.trim());
              targets.push(tgtEl.value.trim());
            }
          });
          document.getElementById('indicator_text').value = JSON.stringify(indicators);
          document.getElementById('target_text').value = JSON.stringify(targets);

          const form = document.getElementById('gadPlanForm');
          const fd = new FormData(form);
          fd.set('is_draft', isDraft ? '1' : '0');
          fd.set('status', isDraft ? 'Draft' : 'Pending');

          const start = new Date(fd.get('startDate')),
            end = new Date(fd.get('endDate'));
          if (!isDraft && end <= start) {
            return Swal.fire('Invalid Date', 'End date must be after start date.', 'error');
          }
          const budget = parseFloat(fd.get('budgetAmount') || 0);
          if (!isDraft && budget <= 0) {
            return Swal.fire('Validation', 'Total budget must be greater than 0.', 'error');
          }

          const mfoArr = [];
          document.querySelectorAll('[id^="mfoPapTable_"]').forEach(tbl => {
            const idx = tbl.id.split('_')[1];
            const t = tbl.querySelector(`[name="mfoPapType_${idx}"]`).value;
            let s = '';

            // Check if custom input container is visible (Others selected)
            const customContainer = tbl.querySelector(`#customInputContainer_${idx}`);
            const textInput = tbl.querySelector(`[name="mfoPapStatementText_${idx}"]`);
            const selectInput = tbl.querySelector(`[name="mfoPapStatement_${idx}"]`);

            // Check if we're in custom entry mode (custom container is visible)
            // Also check if the select has "Others" selected as an alternative indicator
            const isCustomMode = (customContainer && customContainer.style.display === 'block') ||
                                (selectInput && selectInput.value === 'Others');

            console.log(`Processing table ${idx}: type=${t}, isCustomMode=${isCustomMode}`);
            console.log(`Custom container display: ${customContainer ? customContainer.style.display : 'not found'}`);
            console.log(`Text input element:`, textInput);
            console.log(`Text input value: "${textInput ? textInput.value : 'no element'}"`);
            console.log(`Select input value: "${selectInput ? selectInput.value : 'no element'}"`);

            // Debug all input elements in this table
            const allInputs = tbl.querySelectorAll('input[type="text"]');
            console.log(`All text inputs in table ${idx}:`, allInputs);
            allInputs.forEach((input, i) => {
              console.log(`  Input ${i}: name="${input.name}", value="${input.value}", placeholder="${input.placeholder}"`);
            });

            // Try alternative ways to get the input value
            if (textInput) {
              console.log(`Text input getAttribute value: "${textInput.getAttribute('value') || ''}"`);
              console.log(`Text input innerHTML: "${textInput.innerHTML}"`);
              console.log(`Text input focused: ${document.activeElement === textInput}`);
              console.log(`Text input name: "${textInput.name}"`);
              console.log(`Text input id: "${textInput.id}"`);

              // Force focus and blur to ensure value is captured
              textInput.focus();
              textInput.blur();
              console.log(`After focus/blur - Text input value: "${textInput.value}"`);
            }

            console.log(`About to check condition: isCustomMode=${isCustomMode}, textInput=${!!textInput}`);
            if (isCustomMode && textInput) {
              // Custom entry mode - get values from text inputs
              // Try multiple ways to get the value for better reliability
              let textValue = textInput.value.trim();

              // If value is empty, try getting it from the form data directly
              if (!textValue) {
                const formData = new FormData(document.querySelector('form'));
                textValue = formData.get(textInput.name) || '';
              }

              // Also try jQuery if available as a fallback
              if (!textValue && typeof $ !== 'undefined') {
                textValue = $(textInput).val() || '';
              }

              console.log(`Custom mode - final textValue: "${textValue}"`);

              if (textValue) {
                s = textValue;
                console.log(`Using custom text: statement="${s}"`);
              } else {
                console.log(`Custom text field is empty - textValue="${textValue}"`);
              }
              console.log(`Final values for table ${idx}: type="${t}", statement="${s}"`);
            } else if (selectInput && selectInput.value && selectInput.value !== 'Others') {
              // Dropdown selection mode - get value from select
              s = selectInput.value.trim();
              console.log(`Dropdown mode - statement: "${s}"`);
            } else {
              console.log(`No valid input found for table ${idx}`);
            }

            // Only add to array if we have type and statement content
            const hasValidContent = s && s !== 'Others' && s !== '';

            if (t && hasValidContent) {
              const mfoItem = {
                type: t,
                statement: s
              };

              console.log(`Adding MFO/PAP item:`, mfoItem);
              mfoArr.push(mfoItem);
            } else {
              console.log(`Skipping table ${idx} - missing data: type="${t}", statement="${s}"`);
            }
          });

          console.log('Final MFO/PAP array:', mfoArr);
          console.log('MFO/PAP JSON string:', JSON.stringify(mfoArr));
          fd.set('mfoPapData', JSON.stringify(mfoArr));

          // Debug: Log all form data being sent
          console.log('All form data being sent:');
          for (let [key, value] of fd.entries()) {
            console.log(key + ':', value);
          }

          fetch(form.action, {
              method: 'POST',
              headers: {
                'X-Requested-With': 'XMLHttpRequest',
                '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
              },
              body: fd
            })
            .then(r => r.json())
            .then(d => {
              if (!d.success) {
                return Swal.fire('Error', d.message + (d.errors ? ': ' + Object.values(d.errors).join(', ') : ''),
                  'error');
              }
              const planId = d.planId;
              const trSel = `tr[data-plan-id="${planId}"]`;
              const tbody = document.getElementById('gadPlanTableBody');
              const isUpdate = !!document.getElementById('planId').value;
              const formatted = formatPlanId(planId);
              const cause = esc(fd.get('cause') || 'N/A');
              const objs = Array.from(form.querySelectorAll(
                  'textarea[name="gad_objective"],textarea[name^="objectives"]'))
                .map(el => esc(el.value)).filter(v => v).join('<br>') || 'N/A';
              const mfoDisp = mfoArr.length ? mfoArr.map(o => `${esc(o.type)}: ${esc(o.statement)}`).join('<br>') :
                'N/A';
              const startFmt = new Date(fd.get('startDate')).toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
              });
              const endFmt = new Date(fd.get('endDate')).toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
              });
              const units = Array.from(form.querySelectorAll('select[name="responsibleUnits[]"]'))
                .map(s => esc(s.value)).filter(v => v).join(', ');
              const budgetFmt = budget.toLocaleString('en-US', {
                minimumFractionDigits: 0
              });
              const score = parseFloat(fd.get('hgdgScore') || 0).toFixed(2);
              const attachLinks = (d.fileAttachments || []).map(f => {
                const fn = f.split('/').pop();
                return `<a href="<?= base_url() ?>${f}" target="_blank">${esc(fn)}</a>`;
              }).join('<br>') || 'No attachments';
              const status = esc(fd.get('status'));
              const cells = `
      <td>${formatted}</td>
      <td>${esc(fd.get('issue_mandate'))}</td>
      <td>${cause}</td>
      <td>${objs}</td>
      <td>${mfoDisp}</td>
      <td>${indicators.map(esc).join('<br>')}</td>
      <td>${startFmt} - ${endFmt}</td>
      <td>${units}</td>
      <td>
        <a href="<?= base_url('Focal/BudgetCrafting') ?>?plan=${planId}" class="btn btn-sm btn-outline-info">
          ₱${budgetFmt}
        </a>
      </td>
      <td>${score}</td>
      <td>${attachLinks}</td>
      <td>${status}</td>
      <td>
        <div class="btn-group">
          <button class="btn btn-sm btn-outline-primary" onclick="editGadPlan(this,'${planId}')">
            <i class="bi bi-pencil"></i>
          </button>
          <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan(this,'${planId}')">
            <i class="bi bi-trash"></i>
          </button>
        </div>
      </td>`;

              if (isUpdate) {
                const row = tbody.querySelector(trSel);
                if (row) row.innerHTML = cells;
              } else {
                // Clear "No GAD plans found" message if it exists
                const noDataRow = tbody.querySelector('td[colspan]');
                if (noDataRow) {
                  console.log('Clearing "No GAD plans found" message');
                  tbody.innerHTML = '';
                }

                const tr = document.createElement('tr');
                tr.setAttribute('data-plan-id', planId);
                tr.innerHTML = cells;
                tbody.appendChild(tr);
                console.log('New GAD plan row added to table with ID:', planId);
              }
              document.getElementById('successModalBody').textContent = d.message;

              // Hide GAD plan modal and show success modal with smooth transition
              const gadPlanModalInstance = bootstrap.Modal.getInstance(document.getElementById('gadPlanModal'));
              if (gadPlanModalInstance) {
                gadPlanModalInstance.hide();

                // Wait for GAD plan modal to hide, then show success modal
                document.getElementById('gadPlanModal').addEventListener('hidden.bs.modal', function h() {
                  // Small delay to ensure DOM is updated
                  setTimeout(() => {
                    showModal('successModal');
                    resetGadPlanModal();
                    // Optionally refresh the page to ensure data is current
                    // window.location.reload();
                  }, 100);
                  document.getElementById('gadPlanModal').removeEventListener('hidden.bs.modal', h);
                }, { once: true });
              } else {
                setTimeout(() => {
                  showModal('successModal');
                  resetGadPlanModal();
                  // Optionally refresh the page to ensure data is current
                  // window.location.reload();
                }, 100);
              }
            })
            .catch(e => Swal.fire('Error', 'Unexpected: ' + e.message, 'error'));
        }

        function saveAsDraft() {
          submitGadPlan(true)
        }

        function saveGadPlan() {
          submitGadPlan(false)
        }

function editGadPlan(button, planId) {
    fetch(`<?= base_url("GadPlanController/getGadPlan/") ?>${planId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(r => r.json())
    .then(resp => {
        if (!resp.success) {
            return Swal.fire('Error', resp.message, 'error');
        }

        const plan = resp.plan;
        resetGadPlanModal();

        // ---- Basic fields ----
        document.getElementById('gadPlanModalLabel').innerText = 'Edit GAD Plan';
        document.getElementById('planId').value = planId;
        document.getElementById('displayPlanId').value = formatPlanId(planId);
        document.getElementById('issue_mandate').value = plan.issue_mandate || '';
        document.getElementById('cause').value = plan.cause || '';
        document.getElementById('gad_objective').value = (plan.gad_objective[0] || '');
        document.getElementById('activity').value = plan.activity || '';
        document.getElementById('startDate').value = plan.startDate || '';
        document.getElementById('endDate').value = plan.endDate || '';
        document.getElementById('status').value = plan.status || 'Pending';
        document.getElementById('budgetAmount').value = plan.total_budget || '';
        document.getElementById('hgdgScore').value = plan.hgdg_score || '';

        // ---- Populate hidden JSON fields ----
        document.getElementById('indicator_text').value = plan.indicator_text || '[]';
        document.getElementById('target_text').value = plan.target_text || '[]';

        // ---- Rebuild Performance Indicator / Target rows ----
        const indicatorBody = document.getElementById('indicatorTableBody');
        if (indicatorBody) {
            indicatorBody.innerHTML = '';
            const indicators = JSON.parse(plan.indicator_text || '[]');
            const targets = JSON.parse(plan.target_text || '[]');
            for (let i = 0; i < Math.max(indicators.length, targets.length, 1); i++) {
                const ind = indicators[i] || '';
                const tgt = targets[i] || '';
                const row = document.createElement('tr');
                row.id = `indicatorRow_${i}`;
                row.innerHTML = `
                    <td>
                        <textarea class="form-control"
                                  name="indicators[${i}][indicator]"
                                  rows="2"
                                  placeholder="Enter performance indicator..."
                                  required>${ind}</textarea>
                    </td>
                    <td>
                        <textarea class="form-control"
                                  name="indicators[${i}][target]"
                                  rows="2"
                                  placeholder="Enter target..."
                                  required>${tgt}</textarea>
                    </td>
                    <td class="text-center">
                        <button type="button"
                                class="btn btn-danger btn-sm"
                                onclick="removeIndicatorRow(${i})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>`;
                indicatorBody.appendChild(row);
            }
            indicatorIndex = indicators.length + 1;
        }

        // Helper function to check if statement exists in database
        function isInDatabase(type, statement) {
            console.log(`[DEBUG] isInDatabase called: type="${type}", statement="${statement}"`);
            console.log(`[DEBUG] Call stack:`, new Error().stack);

            if (!statement || statement.trim() === '') {
                console.log(`[DEBUG] Empty statement, returning false`);
                return false;
            }

            if (type === 'MFO') {
                console.log(`[DEBUG] Checking MFO data:`, mfoData);
                const found = mfoData.some(mfo => {
                    const match = mfo.mfo === statement;
                    console.log(`[DEBUG] Comparing "${mfo.mfo}" === "${statement}": ${match}`);
                    if (match) {
                        console.log(`[DEBUG] Found MFO match: "${mfo.mfo}" === "${statement}"`);
                    }
                    return match;
                });
                console.log(`[DEBUG] MFO check final result: ${found} for statement: "${statement}"`);
                return found;
            } else if (type === 'PAP') {
                console.log(`[DEBUG] Checking PAP data:`, papData);
                const found = papData.some(pap => {
                    const match = pap.pap === statement;
                    console.log(`[DEBUG] Comparing "${pap.pap}" === "${statement}": ${match}`);
                    if (match) {
                        console.log(`[DEBUG] Found PAP match: "${pap.pap}" === "${statement}"`);
                    }
                    return match;
                });
                console.log(`[DEBUG] PAP check final result: ${found} for statement: "${statement}"`);
                return found;
            }
            console.log(`[DEBUG] Unknown type, returning false`);
            return false;
        }

        // ---- Parse MFO/PAP data ----
        let mfoPapDataArray = [];
        if (plan.mfoPapData) {
            try {
                console.log('[DEBUG] Raw plan.mfoPapData:', plan.mfoPapData);
                mfoPapDataArray = typeof plan.mfoPapData === 'string' ? JSON.parse(plan.mfoPapData) : plan.mfoPapData;
                console.log('[DEBUG] Parsed mfoPapDataArray:', mfoPapDataArray);
                console.log('[DEBUG] Array length:', mfoPapDataArray.length);
                mfoPapDataArray.forEach((item, idx) => {
                    console.log(`[DEBUG] Item ${idx}:`, item);
                });
                if (!Array.isArray(mfoPapDataArray)) {
                    mfoPapDataArray = [];
                }
            } catch (e) {
                console.error('Error parsing MFO/PAP data:', e);
                mfoPapDataArray = [];
            }
        } else {
            console.log('[DEBUG] No plan.mfoPapData found');
        }

        // ---- Rebuild MFO/PAP rows ----
        const mfoContainer = document.getElementById('mfoPapTableContainer');
        if (mfoContainer) {
            mfoContainer.innerHTML = '';
            console.log('Rebuilding MFO/PAP rows from saved data:', mfoPapDataArray);
            console.log('Available MFO data:', mfoData);
            console.log('Available PAP data:', papData);
            mfoPapDataArray.forEach((item, idx) => {
                console.log(`Processing item ${idx}:`, item);
                console.log(`Item ${idx} raw data:`, JSON.stringify(item));

                const tbl = document.createElement('table');
                tbl.className = 'table table-bordered mb-2';
                tbl.id = `mfoPapTable_${idx}`;

                // Check if this is a custom entry (not in database)
                const isInDatabaseResult = isInDatabase(item.type, item.statement);
                const isCustomEntry = !isInDatabaseResult;
                console.log(`FIXED CODE: Item ${idx} - isInDatabase: ${isInDatabaseResult}, isCustomEntry: ${isCustomEntry}`, {
                    type: item.type,
                    statement: item.statement,
                    additional: item.additional
                });

                // Create the table structure step by step to avoid template literal issues
                const thead = document.createElement('thead');
                thead.innerHTML = '<tr><th>Type</th><th>MFO / PAP Statement</th><th>Action</th></tr>';

                const tbody = document.createElement('tbody');
                const row = document.createElement('tr');

                // Type column
                const typeCell = document.createElement('td');
                const typeSelect = document.createElement('select');
                typeSelect.className = 'form-select';
                typeSelect.name = `mfoPapType_${idx}`;
                typeSelect.onchange = function() { updateMfoPapOptions(this, idx); };
                typeSelect.innerHTML = `
                    <option value="">Select</option>
                    <option value="MFO" ${item.type === 'MFO' ? 'selected' : ''}>MFO</option>
                    <option value="PAP" ${item.type === 'PAP' ? 'selected' : ''}>PAP</option>
                `;
                typeCell.appendChild(typeSelect);

                // Statement column
                const statementCell = document.createElement('td');

                // Dropdown
                const statementSelect = document.createElement('select');
                statementSelect.className = 'form-select';
                statementSelect.name = `mfoPapStatement_${idx}`;
                statementSelect.id = `mfoPapStatement_${idx}`;
                statementSelect.onchange = function() { toggleCustomInput(this, idx); };
                statementSelect.style.display = isCustomEntry ? 'none' : 'block';
                statementSelect.innerHTML = '<option value="">Select MFO/PAP</option>';

                // Custom input container
                const customContainer = document.createElement('div');
                customContainer.id = `customInputContainer_${idx}`;
                customContainer.style.display = isCustomEntry ? 'block' : 'none';

                // Statement input
                const statementInput = document.createElement('input');
                statementInput.type = 'text';
                statementInput.className = 'form-control';
                statementInput.name = `mfoPapStatementText_${idx}`;
                statementInput.id = `mfoPapStatementText_${idx}`;
                statementInput.placeholder = 'Enter custom MFO/PAP statement...';

                // Set values after creating the inputs
                console.log(`Setting values for item ${idx}: statement="${item.statement}"`);
                if (isCustomEntry) {
                    statementInput.value = item.statement || '';
                    console.log(`Values set: statement="${statementInput.value}"`);
                }

                customContainer.appendChild(statementInput);

                // Back to dropdown button
                if (isCustomEntry) {
                    const backButton = document.createElement('button');
                    backButton.type = 'button';
                    backButton.className = 'btn btn-sm btn-outline-secondary mt-2 back-to-dropdown';
                    backButton.onclick = function() { backToDropdown(idx); };
                    backButton.textContent = 'Back to dropdown';
                    customContainer.appendChild(backButton);
                }

                statementCell.appendChild(statementSelect);
                statementCell.appendChild(customContainer);

                // Action column
                const actionCell = document.createElement('td');
                const deleteButton = document.createElement('button');
                deleteButton.type = 'button';
                deleteButton.className = 'btn btn-danger btn-sm';
                deleteButton.onclick = function() { removeMfoPapRow(this); };
                deleteButton.textContent = 'Delete';
                actionCell.appendChild(deleteButton);

                row.appendChild(typeCell);
                row.appendChild(statementCell);
                row.appendChild(actionCell);
                tbody.appendChild(row);

                tbl.appendChild(thead);
                tbl.appendChild(tbody);
                mfoContainer.appendChild(tbl);

                // Elements are already created above, just get references
                const typeSelectRef = tbl.querySelector(`[name="mfoPapType_${idx}"]`);
                const statementSelectRef = tbl.querySelector(`[name="mfoPapStatement_${idx}"]`);
                const textInputRef = tbl.querySelector(`[name="mfoPapStatementText_${idx}"]`);

                if (item.type) {
                    if (isCustomEntry) {
                        // For custom entries, populate the dropdown but preserve custom display
                        updateMfoPapOptions(typeSelectRef, idx, true);

                        // Values are already set above in lines 2520-2524, but ensure they're set
                        console.log(`Custom entry ${idx}: display preserved - statement="${item.statement}", additional="${item.additional}"`);
                    } else {
                        // For database entries, normal flow
                        updateMfoPapOptions(typeSelectRef, idx);
                        setTimeout(() => {
                            statementSelectRef.value = item.statement || '';
                            console.log(`Database entry ${idx}: set dropdown to "${item.statement}"`);
                        }, 50);
                    }
                }
            });
            window.mfoPapIndex = mfoPapDataArray.length;
        }

        // ---- Rebuild Responsible Units rows ----
        const unitContainer = document.getElementById('responsibleUnitsContainer');
        if (unitContainer) {
            unitContainer.innerHTML = '<label for="responsibleUnits" class="form-label"><strong>RESPONSIBLE UNIT(S)/OFFICE(S)</strong> <span class="text-danger">*</span></label>';
            let responsibleUnits = [];
            if (plan.responsible_units) {
                try {
                    responsibleUnits = JSON.parse(plan.responsible_units);
                } catch (e) {
                    responsibleUnits = [];
                }
            }
            if (!Array.isArray(responsibleUnits) || responsibleUnits.length === 0) responsibleUnits = [''];

            responsibleUnits.forEach((selectedValue, idx) => {
                let options = `<option value="">Select Responsible Unit</option>`;
                <?php foreach($divisions as $d): ?>
                    options += `<option value="<?= esc($d->division) ?>" ${selectedValue === "<?= esc($d->division) ?>" ? "selected" : ""}><?= esc($d->division) ?></option>`;
                <?php endforeach; ?>

                let row = document.createElement('div');
                row.className = 'responsible-unit-row mb-2';

                let flexDiv = document.createElement('div');
                flexDiv.className = 'd-flex gap-2 align-items-start';

                flexDiv.innerHTML = `
                    <select class="form-select" name="responsibleUnits[]" required>
                        ${options}
                    </select>
                    ${idx > 0 ? '<button type="button" class="btn btn-outline-danger" onclick="removeResponsibleUnitRow(this)"><i class="bi bi-trash"></i></button>' : ''}
                    <div class="invalid-feedback">Please select a responsible unit.</div>
                `;

                row.appendChild(flexDiv);
                unitContainer.appendChild(row);
            });

            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'btn btn-secondary';
            addBtn.onclick = addResponsibleUnitRow;
            addBtn.textContent = 'Add Another';
            unitContainer.appendChild(addBtn);
        }

        // Show GAD plan modal
        showModal('gadPlanModal');
    })
    .catch(e => Swal.fire('Error', 'Could not load plan: ' + e.message, 'error'));
}
        function editMandate(id, year, desc) {
          fetch('<?= base_url("GadMandateController/getMandate/") ?>' + id, {
              method: 'GET',
              headers: {
                'X-Requested-With': 'XMLHttpRequest'
              }
            })
            .then(r => r.json())
            .then(d => {
              if (d.success && d.mandate) {
                const mandate = d.mandate;
                const ta = document.getElementById('newMandateDescription');
                ta.value = mandate.description || '';
                ta.dataset.id = id;
                // Hide mandate modal and show create mandate modal - faster
                hideModal('mandateModal');
                setTimeout(() => {
                  showModal('createMandateModal');
                }, 150);
              } else {
                Swal.fire('Error', d.message || 'Failed to load mandate.', 'error');
              }
            })
            .catch(e => Swal.fire('Error', 'Unexpected: ' + e.message, 'error'));
        }

       function deleteGadPlan(button, planId) {
  Swal.fire({
    title: 'Are you sure?',
    text: 'This action cannot be undone!',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!'
  }).then(r => {
    if (r.isConfirmed) {
      console.log("Sending delete request for planId:", planId); // Debugging line
      fetch('<?= base_url("GadPlanController/deleteGadPlan/") ?>' + planId, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>' // Ensure CSRF token is sent
        }
      })
      .then(response => {
        return response.json();
      })
      .then(d => {
        if (d.success) {
          console.log("Plan deleted successfully:", d.message); // Debugging line
          button.closest('tr').remove(); // Remove the row from the table
          Swal.fire('Deleted!', 'GAD Plan deleted.', 'success');
        } else {
          console.error("Error deleting plan:", d.message); // Debugging line
          Swal.fire('Error', d.message || 'Failed to delete.', 'error');
        }
      })
      .catch(err => {
        console.error("Error during fetch:", err); // Debugging line
        Swal.fire('Error', 'An unexpected error occurred: ' + err.message, 'error');
      });
    }
  });
}
        function viewMultipleAttachments(planId) {
          // Fetch attachments for the specific plan
          fetch(`<?= base_url("Focal/getAttachments") ?>?plan=${planId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success && data.attachments && data.attachments.length > 0) {
              let attachmentsList = '';
              data.attachments.forEach((file, index) => {
                const fileName = file.split('/').pop();
                attachmentsList += `
                  <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                    <div class="d-flex align-items-center">
                      <i class="bi bi-file-earmark text-primary me-2"></i>
                      <span>${fileName}</span>
                    </div>
                    <div>
                      <button onclick="window.open('<?= base_url('Uploads/') ?>${fileName}', '_blank')" class="btn btn-sm btn-view me-1">
                        <i class="bi bi-eye"></i> View
                      </button>
                    </div>
                  </div>
                `;
              });

              Swal.fire({
                title: 'Select File to View',
                html: `
                  <div class="text-start">
                    <h6 class="mb-3">Plan ID: GAD-ACT-${String(planId).padStart(3, '0')}</h6>
                    <p class="mb-3 text-muted">Click "View" to open any file in a new tab:</p>
                    ${attachmentsList}
                  </div>
                `,
                width: '500px',
                showCloseButton: true,
                showConfirmButton: false,
                footer: '<button onclick="openAllAttachments(' + planId + ')" class="btn btn-outline-primary btn-sm">Open All Files</button>',
                customClass: {
                  popup: 'text-start'
                }
              });
            } else {
              Swal.fire({
                icon: 'info',
                title: 'No Attachments',
                text: 'No files are attached to this GAD plan.',
                confirmButtonText: 'OK'
              });
            }
          })
          .catch(error => {
            console.error('Error fetching attachments:', error);
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to load attachments. Please try again.',
              confirmButtonText: 'OK'
            });
          });
        }

        function openAllAttachments(planId) {
          // Fetch attachments and open all in new tabs
          fetch(`<?= base_url("Focal/getAttachments") ?>?plan=${planId}`, {
            method: 'GET',
            headers: {
              'X-Requested-With': 'XMLHttpRequest',
              '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success && data.attachments && data.attachments.length > 0) {
              data.attachments.forEach(file => {
                const fileName = file.split('/').pop();
                window.open(`<?= base_url('Uploads/') ?>${fileName}`, '_blank');
              });
              Swal.close();
            }
          })
          .catch(error => {
            console.error('Error opening attachments:', error);
          });
        }

        function linkToBudgetCrafting() {
          Swal.fire({
            icon: 'info',
            title: 'Budget Crafting',
            text: 'This will open Budget Crafting.',
            showCancelButton: true,
            confirmButtonText: 'Go'
          }).then(r => {
            if (r.isConfirmed) window.location.href = '<?= base_url("Focal/BudgetCrafting") ?>'
          });
        }

        document.getElementById('searchInput').addEventListener('input', function () {
          const t = this.value.toLowerCase();
          document.querySelectorAll('#gadPlanTableBody tr').forEach(r => {
            r.style.display = r.textContent.toLowerCase().includes(t) ? '' : 'none';
          });
        });

        let objectiveIndex = 1;

        function addGadObjectiveRow() {
          const c = document.querySelector('.mb-4:nth-child(4)');
          const nr = document.createElement('div');
          nr.className = 'mb-4 additional-row objective-row';
          nr.id = `objectiveRow_${objectiveIndex}`;
          nr.innerHTML = `
    <textarea class="form-control" name="objectives[${objectiveIndex}]" rows="3" placeholder="Define the expected GAD result..."></textarea>
    <div class="invalid-feedback">Please provide a GAD objective.</div>
    <span class="remove-row" onclick="removeGadObjectiveRow(this,${objectiveIndex})">Remove</span>`;
          c.parentNode.insertBefore(nr, c.nextSibling);
          objectiveIndex++;
        }

        function removeGadObjectiveRow(btn, idx) {
          const row = document.getElementById(`objectiveRow_${idx}`);
          if (row) row.remove();
          Array.from(document.querySelectorAll('.objective-row')).forEach((row, i) => {
            row.id = `objectiveRow_${i+1}`;
            const ta = row.querySelector('textarea');
            const sp = row.querySelector('.remove-row');
            if (ta) ta.name = `objectives[${i+1}]`;
            if (sp) sp.setAttribute('onclick', `removeGadObjectiveRow(this,${i+1})`);
          });
          objectiveIndex = document.querySelectorAll('.objective-row').length + 1;
        }

        // View GAD Plan function
        function viewGadPlan(planId) {
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

        // Show plan details in modal
        function showPlanDetailsModal(plan) {
          const content = document.getElementById('viewPlanContent');

          // Format MFO/PAP data
          let mfoPapDisplay = 'No MFO/PAP data';
          if (plan.mfoPapData) {
            try {
              const mfoPapData = typeof plan.mfoPapData === 'string' ? JSON.parse(plan.mfoPapData) : plan.mfoPapData;
              if (Array.isArray(mfoPapData) && mfoPapData.length > 0) {
                mfoPapDisplay = mfoPapData.map(item =>
                  `<div class="mb-2">
                    <strong>${item.type}:</strong> ${item.statement}
                    ${item.additional ? `<br><small class="text-muted">${item.additional}</small>` : ''}
                  </div>`
                ).join('');
              }
            } catch (e) {
              mfoPapDisplay = 'Invalid MFO/PAP data format';
            }
          }

          // Format responsible units
          let responsibleUnitsDisplay = 'No units specified';
          if (plan.responsible_units) {
            try {
              const units = typeof plan.responsible_units === 'string' ? JSON.parse(plan.responsible_units) : plan.responsible_units;
              if (Array.isArray(units) && units.length > 0) {
                responsibleUnitsDisplay = units.join(', ');
              }
            } catch (e) {
              responsibleUnitsDisplay = plan.responsible_units;
            }
          }

          // Format file attachments
          let attachmentsDisplay = 'No attachments';
          if (plan.file_attachments) {
            try {
              const attachments = typeof plan.file_attachments === 'string' ? JSON.parse(plan.file_attachments) : plan.file_attachments;
              if (Array.isArray(attachments) && attachments.length > 0) {
                attachmentsDisplay = attachments.map(file => {
                  const fileName = file.split('/').pop();
                  return `<a href="<?= base_url() ?>${file}" target="_blank" class="btn btn-sm btn-outline-primary me-1 mb-1">${fileName}</a>`;
                }).join('');
              }
            } catch (e) {
              attachmentsDisplay = 'Invalid attachment data';
            }
          }

          content.innerHTML = `
            <div class="row">
              <div class="col-md-6">
                <h6>Plan Information</h6>
                <dl class="row">
                  <dt class="col-sm-4">Plan ID:</dt>
                  <dd class="col-sm-8">GAD-ACT-${String(plan.plan_id).padStart(3, '0')}</dd>
                  <dt class="col-sm-4">Status:</dt>
                  <dd class="col-sm-8"><span class="badge bg-${plan.status === 'approved' ? 'success' : plan.status === 'submitted' ? 'info' : plan.status === 'returned' ? 'warning' : 'secondary'}">${plan.status ? plan.status.charAt(0).toUpperCase() + plan.status.slice(1) : 'Draft'}</span></dd>
                  <dt class="col-sm-4">Budget:</dt>
                  <dd class="col-sm-8">₱${plan.amount ? Number(plan.amount).toLocaleString() : '0'}</dd>
                  <dt class="col-sm-4">HGDG Score:</dt>
                  <dd class="col-sm-8">${plan.hgdg_score ? Number(plan.hgdg_score).toFixed(1) : 'N/A'}</dd>
                </dl>
              </div>
              <div class="col-md-6">
                <h6>Timeline</h6>
                <dl class="row">
                  <dt class="col-sm-4">Start Date:</dt>
                  <dd class="col-sm-8">${plan.startDate || 'Not specified'}</dd>
                  <dt class="col-sm-4">End Date:</dt>
                  <dd class="col-sm-8">${plan.endDate || 'Not specified'}</dd>
                  <dt class="col-sm-4">Created:</dt>
                  <dd class="col-sm-8">${plan.created_at ? new Date(plan.created_at).toLocaleDateString() : 'Unknown'}</dd>
                  <dt class="col-sm-4">Updated:</dt>
                  <dd class="col-sm-8">${plan.updated_at ? new Date(plan.updated_at).toLocaleDateString() : 'Unknown'}</dd>
                </dl>
              </div>
            </div>
            <hr>
            <div class="mb-3">
              <h6>Gender Issue/GAD Mandate</h6>
              <p>${plan.issue_mandate || 'Not specified'}</p>
            </div>
            <div class="mb-3">
              <h6>Cause of Gender Issue</h6>
              <p>${plan.cause || 'Not specified'}</p>
            </div>
            <div class="mb-3">
              <h6>GAD Result/Objective</h6>
              <p>${plan.gad_objective || 'Not specified'}</p>
            </div>
            <div class="mb-3">
              <h6>Relevant MFO/PAP</h6>
              <div>${mfoPapDisplay}</div>
            </div>
            <div class="mb-3">
              <h6>Performance Indicators/Targets</h6>
              <p>${plan.indicators || 'Not specified'}</p>
            </div>
            <div class="mb-3">
              <h6>Responsible Units</h6>
              <p>${responsibleUnitsDisplay}</p>
            </div>
            <div class="mb-3">
              <h6>File Attachments</h6>
              <div>${attachmentsDisplay}</div>
            </div>
          `;

          // Update modal title with plan ID
          document.getElementById('viewPlanModalLabel').innerHTML = `<i class="bi bi-eye"></i> View GAD Plan - GAD-ACT-${String(plan.plan_id).padStart(3, '0')}`;

          // Show modal
          showModal('viewPlanModal');
        }
      </script>
</body>

</html>
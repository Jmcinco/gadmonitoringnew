<?php
// Check if user is logged in and has the correct role
if (!session()->get('isLoggedIn') || session()->get('role_id') != 2) {
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
            <div class="fw-bold"><?php echo esc(($first_name ?? 'Member') . ' ' . ($last_name ?? 'User')); ?></div>
            <small class="text-light d-block"><?php echo esc($role_name ?? 'Member'); ?></small>
            <small class="text-light opacity-75"><?php echo esc($division_name ?? 'Division'); ?></small>
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
                    <a class="nav-link active" href="<?= base_url('Member/PlanPreparation') ?>">
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
      <div class="row">
        <div class="col-12">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
              <i class="bi bi-clipboard-data text-primary"></i> GAD Plan Activities
            </h1>
            <!-- No Create button for Members - View Only -->
          </div>
          <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle"></i>
            <strong>Note:</strong> This is a view-only interface. You can view all GAD plans but cannot create or edit them.
            Contact your GAD Focal Person for plan modifications.
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
                            <?php echo esc($plan['activity'] ?? 'N/A'); ?>
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
                            <span class="btn btn-sm btn-outline-info" style="font-size: 0.85rem; cursor: default;">
                              ₱<?= number_format($plan['amount'], 0, '.', ',') ?>
                            </span>
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
                          </td>
                          <td class="actions-cell">
                            <!-- View Only for Members -->
                            <button class="btn btn-sm btn-outline-secondary"
                              onclick="viewGadPlan('<?php echo esc($plan['plan_id'] ?? ''); ?>')"
                              title="View plan details">
                              <i class="bi bi-eye"></i> View
                            </button>
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
    </div>
  </div>

  <!-- View Plan Modal -->
  <div class="modal fade" id="viewPlanModal" tabindex="-1" aria-labelledby="viewPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewPlanModalLabel">
            <i class="bi bi-eye"></i> View GAD Plan Details
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="viewPlanModalBody">
          <!-- Plan details will be loaded here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Multiple Attachments Modal -->
  <div class="modal fade" id="attachmentsModal" tabindex="-1" aria-labelledby="attachmentsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="attachmentsModalLabel">
            <i class="bi bi-paperclip"></i> Plan Attachments
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="attachmentsModalBody">
          <!-- Attachment list will be loaded here -->
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
    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const tableRows = document.querySelectorAll('#gadPlanTableBody tr');

      tableRows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
      });
    });

    // View GAD Plan function
    function viewGadPlan(planId) {
      // Show loading state
      document.getElementById('viewPlanModalBody').innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Loading plan details...</div>';

      // Show modal
      const modal = new bootstrap.Modal(document.getElementById('viewPlanModal'));
      modal.show();

      // In a real implementation, you would fetch plan details via AJAX
      // For now, show a placeholder
      setTimeout(() => {
        document.getElementById('viewPlanModalBody').innerHTML = `
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Plan ID:</strong> ${planId}<br>
            <strong>Note:</strong> Detailed view functionality would be implemented here to show complete plan information.
          </div>
        `;
      }, 500);
    }

    // View multiple attachments function
    function viewMultipleAttachments(planId) {
      // Show loading state
      document.getElementById('attachmentsModalBody').innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Loading attachments...</div>';

      // Show modal
      const modal = new bootstrap.Modal(document.getElementById('attachmentsModal'));
      modal.show();

      // In a real implementation, you would fetch attachments via AJAX
      // For now, show a placeholder
      setTimeout(() => {
        document.getElementById('attachmentsModalBody').innerHTML = `
          <div class="alert alert-info">
            <i class="bi bi-info-circle"></i>
            <strong>Plan ID:</strong> ${planId}<br>
            <strong>Note:</strong> Attachment list would be displayed here with download links.
          </div>
        `;
      }, 500);
    }
  </script>

</body>
</html>
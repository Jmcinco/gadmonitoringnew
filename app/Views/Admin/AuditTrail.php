<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Audit Trail' ?> - PGMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
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
        .audit-card {
            transition: all 0.3s ease;
            border-left: 4px solid #dee2e6;
        }
        .audit-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .action-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
        .action-CREATE { border-left-color: #28a745; }
        .action-UPDATE { border-left-color: #ffc107; }
        .action-DELETE { border-left-color: #dc3545; }
        .action-LOGIN { border-left-color: #007bff; }
        .action-LOGOUT { border-left-color: #6c757d; }
        .action-REVIEW { border-left-color: #17a2b8; }
        .action-APPROVE { border-left-color: #28a745; }
        .action-REJECT { border-left-color: #dc3545; }
        .action-FINALIZE { border-left-color: #6f42c1; }
        .action-ARCHIVE { border-left-color: #6c757d; }
        .timestamp {
            font-size: 0.85rem;
            color: #6c757d;
        }
        .details-text {
            font-size: 0.9rem;
            line-height: 1.4;
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
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-shield-check"></i> GAD Monitoring System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc((session()->get('first_name') ?? 'User') . ' ' . (session()->get('last_name') ?? '')); ?></div>
                        <small class="text-light">
                            <?php
                            $roleNames = [1 => 'Focal', 2 => 'Member', 3 => 'Secretariat', 4 => 'Administrator'];
                            echo $roleNames[session()->get('role_id')] ?? 'User';
                            ?>
                        </small>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills flex-column">
                <?php $userRole = session()->get('role_id'); ?>

                <?php if ($userRole == 1): // Focal ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/FocalDashboard') ?>">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/Focal/PlanPreparation') ?>">
                            <i class="bi bi-file-earmark-text me-2"></i>Plan Preparation
                        </a>
                    </li>
                <?php elseif ($userRole == 2): // Member ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/MemberDashboard') ?>">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/Member/planReview') ?>">
                            <i class="bi bi-clipboard-check me-2"></i>Plan Review
                        </a>
                    </li>
                <?php elseif ($userRole == 3): // Secretariat ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/SecretariatDashboard') ?>">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/Secretariat/finalReview') ?>">
                            <i class="bi bi-check2-square me-2"></i>Final Review
                        </a>
                    </li>
                <?php elseif ($userRole == 4): // Administrator ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/AdminDashboard') ?>">
                            <i class="bi bi-house-door me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/Admin/EmployeesManagement') ?>">
                            <i class="bi bi-people me-2"></i>Employee Management
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/AuditTrail') ?>">
                        <i class="bi bi-clock-history me-2"></i>Audit Trail
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="<?= base_url('/login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="mb-1"><i class="bi bi-shield-check"></i> Audit Trail</h2>
                            <p class="text-muted mb-0">System activity monitoring and logging</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-success" onclick="exportCSV()">
                                <i class="bi bi-download"></i> Export CSV
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Filters and Stats -->
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Filter by Action:</label>
                                <select id="actionFilter" class="form-select" onchange="filterLogs()">
                                    <option value="All" <?= $current_action == 'All' ? 'selected' : '' ?>>All Actions</option>
                                    <optgroup label="Employee Management">
                                        <option value="CREATE" <?= $current_action == 'CREATE' ? 'selected' : '' ?>>Create</option>
                                        <option value="UPDATE" <?= $current_action == 'UPDATE' ? 'selected' : '' ?>>Update</option>
                                        <option value="DELETE" <?= $current_action == 'DELETE' ? 'selected' : '' ?>>Delete</option>
                                    </optgroup>
                                    <optgroup label="GAD Plan Activities">
                                        <option value="REVIEW" <?= $current_action == 'REVIEW' ? 'selected' : '' ?>>Review</option>
                                        <option value="APPROVE" <?= $current_action == 'APPROVE' ? 'selected' : '' ?>>Approve</option>
                                        <option value="REJECT" <?= $current_action == 'REJECT' ? 'selected' : '' ?>>Reject</option>
                                        <option value="FINALIZE" <?= $current_action == 'FINALIZE' ? 'selected' : '' ?>>Finalize</option>
                                        <option value="ARCHIVE" <?= $current_action == 'ARCHIVE' ? 'selected' : '' ?>>Archive</option>
                                    </optgroup>
                                    <optgroup label="User Sessions">
                                        <option value="LOGIN" <?= $current_action == 'LOGIN' ? 'selected' : '' ?>>Login</option>
                                        <option value="LOGOUT" <?= $current_action == 'LOGOUT' ? 'selected' : '' ?>>Logout</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Records per page:</label>
                                <select id="perPageSelect" class="form-select" onchange="changePerPage()">
                                    <option value="25">25 records</option>
                                    <option value="50" selected>50 records</option>
                                    <option value="100">100 records</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h4 class="mb-1"><?= $pagination['total_records'] ?></h4>
                        <p class="mb-0">Total Audit Logs</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audit Logs -->
        <div class="row">
            <div class="col-12">
                <div id="auditLogsContainer">
                    <?php if (empty($audit_logs)): ?>
                        <div class="card">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-inbox display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">No audit logs found</h4>
                                <p class="text-muted">No activities match the current filter criteria.</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($audit_logs as $log): ?>
                            <div class="card audit-card action-<?= $log['action'] ?> mb-3">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="d-flex align-items-center mb-2">
                                                <span class="badge bg-<?= getActionColor($log['action']) ?> action-badge me-2">
                                                    <?= $log['action'] ?>
                                                </span>
                                                <strong class="me-2"><?= esc($log['employee_name']) ?></strong>
                                                <?php if ($log['employee_email']): ?>
                                                    <small class="text-muted">(<?= esc($log['employee_email']) ?>)</small>
                                                <?php endif; ?>
                                            </div>
                                            <p class="details-text mb-1"><?= esc($log['details']) ?></p>
                                            <div class="d-flex align-items-center text-muted small">
                                                <i class="bi bi-person me-1"></i>
                                                <span class="me-3">
                                                    <?= $log['first_name'] ? esc($log['first_name'] . ' ' . $log['last_name']) : 'System' ?>
                                                </span>
                                                <i class="bi bi-geo-alt me-1"></i>
                                                <span><?= esc($log['ip_address']) ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-md-end">
                                            <div class="timestamp">
                                                <i class="bi bi-clock me-1"></i>
                                                <?= $log['timestamp'] ?>
                                            </div>
                                            <?php if ($log['old_data'] || $log['new_data']): ?>
                                                <button class="btn btn-sm btn-outline-info mt-2"
                                                        onclick="showDetails(<?= htmlspecialchars(json_encode($log)) ?>)">
                                                    <i class="bi bi-eye"></i> View Details
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Pagination -->
                        <?php if ($pagination['total_pages'] > 1): ?>
                            <div class="card">
                                <div class="card-body">
                                    <nav aria-label="Audit logs pagination">
                                        <ul class="pagination justify-content-center mb-0">
                                            <?php if ($pagination['current_page'] > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $pagination['current_page'] - 1 ?>&action=<?= $current_action ?>">
                                                        <i class="bi bi-chevron-left"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                                                <li class="page-item <?= $i == $pagination['current_page'] ? 'active' : '' ?>">
                                                    <a class="page-link" href="?page=<?= $i ?>&action=<?= $current_action ?>"><?= $i ?></a>
                                                </li>
                                            <?php endfor; ?>

                                            <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="?page=<?= $pagination['current_page'] + 1 ?>&action=<?= $current_action ?>">
                                                        <i class="bi bi-chevron-right"></i>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    </nav>
                                    <div class="text-center mt-2 text-muted small">
                                        Showing page <?= $pagination['current_page'] ?> of <?= $pagination['total_pages'] ?>
                                        (<?= $pagination['total_records'] ?> total records)
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Audit Log Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailsModalBody">
                    <!-- Details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function filterLogs() {
            const action = document.getElementById('actionFilter').value;
            window.location.href = `?action=${action}`;
        }

        function changePerPage() {
            const perPage = document.getElementById('perPageSelect').value;
            const action = document.getElementById('actionFilter').value;
            window.location.href = `?action=${action}&per_page=${perPage}`;
        }

        function exportCSV() {
            const action = document.getElementById('actionFilter').value;
            window.location.href = `<?= site_url('AuditTrail/exportCSV') ?>?action=${action}`;
        }

        function showDetails(log) {
            const modal = new bootstrap.Modal(document.getElementById('detailsModal'));
            const modalBody = document.getElementById('detailsModalBody');

            let content = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Basic Information</h6>
                        <table class="table table-sm">
                            <tr><td><strong>Action:</strong></td><td><span class="badge bg-${getActionColorJS(log.action)}">${log.action}</span></td></tr>
                            <tr><td><strong>User:</strong></td><td>${log.first_name || 'System'} ${log.last_name || ''}</td></tr>
                            <tr><td><strong>Employee:</strong></td><td>${log.employee_name}</td></tr>
                            <tr><td><strong>Email:</strong></td><td>${log.employee_email}</td></tr>
                            <tr><td><strong>IP Address:</strong></td><td>${log.ip_address}</td></tr>
                            <tr><td><strong>Timestamp:</strong></td><td>${log.timestamp}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Details</h6>
                        <p>${log.details}</p>
                    </div>
                </div>
            `;

            if (log.old_data || log.new_data) {
                content += '<hr>';
                if (log.old_data) {
                    content += `
                        <h6>Previous Data</h6>
                        <pre class="bg-light p-2 rounded"><code>${JSON.stringify(JSON.parse(log.old_data), null, 2)}</code></pre>
                    `;
                }
                if (log.new_data) {
                    content += `
                        <h6>New Data</h6>
                        <pre class="bg-light p-2 rounded"><code>${JSON.stringify(JSON.parse(log.new_data), null, 2)}</code></pre>
                    `;
                }
            }

            modalBody.innerHTML = content;
            modal.show();
        }

        function getActionColorJS(action) {
            const colors = {
                'CREATE': 'success',
                'UPDATE': 'warning',
                'DELETE': 'danger',
                'LOGIN': 'primary',
                'LOGOUT': 'secondary',
                'REVIEW': 'info',
                'APPROVE': 'success',
                'REJECT': 'danger',
                'FINALIZE': 'dark',
                'ARCHIVE': 'secondary'
            };
            return colors[action] || 'secondary';
        }
    </script>
</body>
</html>

<?php
function getActionColor($action) {
    $colors = [
        'CREATE' => 'success',
        'UPDATE' => 'warning',
        'DELETE' => 'danger',
        'LOGIN' => 'primary',
        'LOGOUT' => 'secondary',
        'REVIEW' => 'info',
        'APPROVE' => 'success',
        'REJECT' => 'danger',
        'FINALIZE' => 'dark',
        'ARCHIVE' => 'secondary'
    ];
    return $colors[$action] ?? 'secondary';
}
?>
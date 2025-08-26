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
    <title>GAD Budget Crafting - GAD Management System</title>

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
                    <a class="nav-link" href="<?= base_url('Member/PlanPreparation') ?>">
                        <i class="bi bi-clipboard-plus me-2"></i>Preparation of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('Member/BudgetCrafting') ?>">
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
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-tools text-primary"></i> GAD Budget Crafting
                    </h1>
                    <!-- No Add Budget Item button for Members - View Only -->
                </div>
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note:</strong> This is a view-only interface. You can view budget items from your division but cannot create or edit them.
                    Contact your GAD Focal Person for budget modifications.
                </div>
            </div>
        </div>

        <!-- Budget Crafting Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">GAD Budget Items</h5>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary" onclick="calculateTotal()">
                                        <i class="bi bi-calculator"></i> Calculate Total
                                    </button>
                                    <button class="btn btn-outline-success" onclick="exportBudget()">
                                        <i class="bi bi-download"></i> Export
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
                                        <th>GAD Activity</th>
                                        <th>Particulars/Items of Expense</th>
                                        <th>Object of Expenses</th>
                                        <th>Source of Budget</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="budgetTableBody">
                                    <?php if (empty($budgetItems)): ?>
                                        <tr><td colspan="7" class="text-center">No budget items found.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($budgetItems as $item): ?>
                                            <tr data-act-id="<?= esc($item['act_id']) ?>"
                                                data-plan-id="<?= esc($item['plan_id']) ?>"
                                                data-obj-id="<?= esc($item['obj_id']) ?>"
                                                data-src-id="<?= esc($item['src_id']) ?>">
                                                <td><?= esc($item['gad_activity_id'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['gad_activity'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['particulars']) ?></td>
                                                <td><?= esc($item['object_name'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['source_name'] ?? 'N/A') ?></td>
                                                <td>₱<?= number_format($item['amount'], 2) ?></td>
                                                <td>
                                                    <!-- View Only for Members -->
                                                    <button class="btn btn-sm btn-outline-secondary" onclick="viewBudgetItem('<?= esc($item['act_id']) ?>')" title="View budget item details">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="5" class="text-end">Total Budget:</th>
                                        <th id="totalBudget">₱0.00</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- View Budget Item Modal -->
    <div class="modal fade" id="viewBudgetItemModal" tabindex="-1" aria-labelledby="viewBudgetItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBudgetItemModalLabel">
                        <i class="bi bi-eye"></i> View Budget Item Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewBudgetItemModalBody">
                    <!-- Budget item details will be loaded here -->
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
        // Calculate total budget
        function calculateTotal() {
            const rows = document.querySelectorAll('#budgetTableBody tr');
            let total = 0;

            rows.forEach(row => {
                if (row.cells.length > 5) {
                    const amountText = row.cells[5].textContent.replace('₱', '').replace(/,/g, '');
                    total += parseFloat(amountText) || 0;
                }
            });

            document.getElementById('totalBudget').textContent = `₱${total.toLocaleString()}`;
        }

        // View budget item function (Member view-only)
        function viewBudgetItem(actId) {
            // Show loading state
            document.getElementById('viewBudgetItemModalBody').innerHTML = '<div class="text-center"><i class="bi bi-hourglass-split"></i> Loading budget item details...</div>';

            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('viewBudgetItemModal'));
            modal.show();

            // Fetch budget item details via AJAX
            fetch(`<?= base_url('Member/getBudgetItemDetails/') ?>${actId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data) {
                    const item = data.data;
                    document.getElementById('viewBudgetItemModalBody').innerHTML = `
                        <div class="row">
                            <div class="col-md-6">
                                <strong>GAD Activity ID:</strong><br>
                                <span class="text-muted">${item.gad_activity_id || 'N/A'}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>GAD Activity:</strong><br>
                                <span class="text-muted">${item.gad_activity || 'N/A'}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <strong>Particulars/Items of Expense:</strong><br>
                                <span class="text-muted">${item.particulars || 'N/A'}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Object of Expenses:</strong><br>
                                <span class="text-muted">${item.object_name || 'N/A'}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Source of Budget:</strong><br>
                                <span class="text-muted">${item.source_name || 'N/A'}</span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Amount:</strong><br>
                                <span class="text-success fw-bold">₱${parseFloat(item.amount || 0).toLocaleString()}</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Type of Expense:</strong><br>
                                <span class="text-muted">${item.type_of_expense || 'N/A'}</span>
                            </div>
                        </div>
                    `;
                } else {
                    document.getElementById('viewBudgetItemModalBody').innerHTML = `
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Error:</strong> ${data.message || 'Could not load budget item details.'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error fetching budget item details:', error);
                document.getElementById('viewBudgetItemModalBody').innerHTML = `
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle"></i>
                        <strong>Error:</strong> Failed to load budget item details. Please try again.
                    </div>
                `;
            });
        }

        // Export budget
        function exportBudget() {
            alert('Budget export functionality would be implemented here.');
        }

        // Calculate total on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateTotal();
        });
    </script>

</body>
</html>

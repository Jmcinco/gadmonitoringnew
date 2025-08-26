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
                        <div class="fw-bold"><?php echo esc(($first_name ?? 'Admin') . ' ' . ($last_name ?? 'User')); ?></div>
                        <small class="text-light d-block"><?php echo esc($role_name ?? 'Focal Person'); ?></small>
                        <small class="text-light opacity-75"><?php echo esc($division_name ?? 'GAD Office'); ?></small>
                    </div>
                </div>
            </div>
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
                    <a class="nav-link active" href="<?= base_url('Focal/BudgetCrafting') ?>">
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
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-tools text-primary"></i> GAD Budget Crafting
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBudgetItemModal">
                        <i class="bi bi-plus-circle"></i> Add Budget Item
                    </button>
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
                                        <th>Type of Expense</th>
                                        <th>Object of Expenses</th>
                                        <th>Source of Budget</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="budgetTableBody">
                                    <?php if (empty($budgetItems)): ?>
                                        <tr><td colspan="8" class="text-center">No budget items found.</td></tr>
                                    <?php else: ?>
                                        <?php foreach ($budgetItems as $item): ?>
                                            <tr data-act-id="<?= esc($item['act_id']) ?>"
                                                data-plan-id="<?= esc($item['plan_id']) ?>"
                                                data-obj-id="<?= esc($item['obj_id']) ?>"
                                                data-src-id="<?= esc($item['src_id']) ?>">
                                                <td><?= esc($item['gad_activity_id'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['gad_activity'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['particulars']) ?></td>
                                                <td><?= esc($item['type_of_expense']) ?></td>
                                                <td><?= esc($item['object_name'] ?? 'N/A') ?></td>
                                                <td><?= esc($item['source_name'] ?? 'N/A') ?></td>
                                                <td>₱<?= number_format($item['amount'], 2) ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary" onclick="editBudgetItem('<?= esc($item['act_id']) ?>')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBudgetItem('<?= esc($item['act_id']) ?>')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="6" class="text-end">Total Budget:</th>
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

    <!-- Add Budget Item Modal -->
    <div class="modal fade" id="addBudgetItemModal" tabindex="-1" aria-labelledby="addBudgetItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBudgetItemModalLabel">
                        <i class="bi bi-plus-circle"></i> Add Budget Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBudgetItemForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="planId" class="form-label">GAD Activity *</label>
                            <select class="form-select" id="planId" name="plan_id" required>
                                <option value="">Select GAD Activity</option>
                                <?php if (empty($plans)): ?>
                                    <option value="" disabled>No GAD activities available. Please create a GAD plan first.</option>
                                <?php else: ?>
                                    <?php foreach ($plans as $plan): ?>
                                        <option value="<?= esc($plan['plan_id']) ?>">
                                            GAD-<?= str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT) ?>: <?= esc($plan['activity']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid GAD Activity.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="particulars" class="form-label">Particulars/Items of Expense *</label>
                            <textarea class="form-control" id="particulars" name="particulars" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide valid particulars or items of expense.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="expenseType" class="form-label">Type of Expense *</label>
                            <select class="form-select" id="expenseType" name="expenseType" required>
                                <option value="">Select Type of Expense</option>
                                <option value="Direct Expense">Direct Expense</option>
                                <option value="Appropriation">Appropriation</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a type of expense.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="objectOfExpenses" class="form-label">Object of Expenses *</label>
                                    <select class="form-select" id="objectOfExpenses" name="obj_id" required>
                                        <option value="">Select Object of Expenses</option>
                                        <?php foreach ($objectsOfExpense as $obj): ?>
                                            <option value="<?= esc($obj['obj_id']) ?>"><?= esc($obj['object_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an object of expenses.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sourceOfBudget" class="form-label">Source of Budget *</label>
                                    <select class="form-select" id="sourceOfBudget" name="src_id" required>
                                        <option value="">Select Source of Budget</option>
                                        <?php foreach ($sourcesOfFund as $src): ?>
                                            <option value="<?= esc($src['src_id']) ?>"><?= esc($src['source_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a source of budget.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount *</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="amount" name="amount" required min="0" step="0.01">
                                <div class="invalid-feedback">
                                    Please provide a valid amount.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addBudgetItemForm" class="btn btn-primary">Save Budget Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Budget Item Modal -->
    <div class="modal fade" id="editBudgetItemModal" tabindex="-1" aria-labelledby="editBudgetItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBudgetItemModalLabel">
                        <i class="bi bi-pencil"></i> Edit Budget Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBudgetItemForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editBudgetItemId" name="act_id">
                        <div class="mb-3">
                            <label for="editPlanId" class="form-label">GAD Activity *</label>
                            <select class="form-select" id="editPlanId" name="plan_id" required>
                                <option value="">Select GAD Activity</option>
                                <?php foreach ($plans as $plan): ?>
                                    <option value="<?= esc($plan['plan_id']) ?>">
                                        GAD-<?= str_pad($plan['plan_id'], 3, '0', STR_PAD_LEFT) ?>: <?= esc($plan['activity']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid GAD Activity.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editParticulars" class="form-label">Particulars/Items of Expense *</label>
                            <textarea class="form-control" id="editParticulars" name="particulars" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide valid particulars or items of expense.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editExpenseType" class="form-label">Type of Expense *</label>
                            <select class="form-select" id="editExpenseType" name="expenseType" required>
                                <option value="">Select Type of Expense</option>
                                <option value="Direct Expense">Direct Expense</option>
                                <option value="Appropriation">Appropriation</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a type of expense.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editObjectOfExpenses" class="form-label">Object of Expenses *</label>
                                    <select class="form-select" id="editObjectOfExpenses" name="obj_id" required>
                                        <option value="">Select Object of Expenses</option>
                                        <?php foreach ($objectsOfExpense as $obj): ?>
                                            <option value="<?= esc($obj['obj_id']) ?>"><?= esc($obj['object_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an object of expenses.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editSourceOfBudget" class="form-label">Source of Budget *</label>
                                    <select class="form-select" id="editSourceOfBudget" name="src_id" required>
                                        <option value="">Select Source of Budget</option>
                                        <?php foreach ($sourcesOfFund as $src): ?>
                                            <option value="<?= esc($src['src_id']) ?>"><?= esc($src['source_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a source of budget.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editAmount" class="form-label">Amount *</label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="editAmount" name="amount" required min="0" step="0.01">
                                <div class="invalid-feedback">
                                    Please provide a valid amount.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editBudgetItemForm" class="btn btn-primary">Update Budget Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript and jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
                calculateTotal(); // Calculate total on page load
            }, false);
        })();

        // Handle form submission
        function handleFormSubmit(form) {
            const formData = new FormData(form);
            const formId = form.id;
            const url = formId === 'addBudgetItemForm' 
                ? '<?= base_url('FocalController/addBudgetItem') ?>'
                : '<?= base_url('FocalController/editBudgetItem') ?>';

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Reload to refresh table
                    } else {
                        let errorMessage = response.message;
                        if (response.errors) {
                            errorMessage += '\nErrors:\n' + Object.values(response.errors).join('\n');
                        } else if (response.error) {
                            errorMessage += '\nError: ' + response.error;
                        }
                        alert(errorMessage);
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred while processing the request: ' + error);
                }
            });

            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();

            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Edit budget item
        function editBudgetItem(actId) {
            const modal = new bootstrap.Modal(document.getElementById('editBudgetItemModal'));
            const row = document.querySelector(`#budgetTableBody tr[data-act-id="${actId}"]`);

            if (row) {
                document.getElementById('editBudgetItemId').value = actId;
                document.getElementById('editPlanId').value = row.dataset.planId;
                document.getElementById('editParticulars').value = row.cells[2].textContent; // Updated index: GAD Activity ID (0), GAD Activity (1), Particulars (2)
                document.getElementById('editExpenseType').value = row.cells[3].textContent; // Updated index: Type of Expense (3)
                document.getElementById('editObjectOfExpenses').value = row.dataset.objId;
                document.getElementById('editSourceOfBudget').value = row.dataset.srcId;
                const amountText = row.cells[6].textContent.replace('₱', '').replace(/,/g, ''); // Updated index: Amount (6)
                document.getElementById('editAmount').value = parseFloat(amountText);
                modal.show();
            } else {
                alert('Budget item not found.');
            }
        }

        // Delete budget item
        function deleteBudgetItem(actId) {
            if (confirm('Are you sure you want to delete this budget item?')) {
                $.ajax({
                    url: '<?= base_url('FocalController/deleteBudgetItem') ?>',
                    type: 'POST',
                    data: { act_id: actId },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            location.reload(); // Reload to refresh table
                        } else {
                            let errorMessage = response.message;
                            if (response.errors) {
                                errorMessage += '\nErrors:\n' + Object.values(response.errors).join('\n');
                            } else if (response.error) {
                                errorMessage += '\nError: ' + response.error;
                            }
                            alert(errorMessage);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred while deleting the budget item: ' + error);
                    }
                });
            }
        }

        // Calculate total budget
        function calculateTotal() {
            const rows = document.querySelectorAll('#budgetTableBody tr');
            let total = 0;

            rows.forEach(row => {
                const amountText = row.cells[6].textContent.replace('₱', '').replace(/,/g, '');
                total += parseFloat(amountText) || 0;
            });

            document.getElementById('totalBudget').textContent = `₱${total.toLocaleString('en-US', { minimumFractionDigits: 2 })}`;
        }

        // Export budget
        function exportBudget() {
            alert('Budget export functionality would be implemented here.');
        }
    </script>
</body>
</html>
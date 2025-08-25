<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Budget Crafting - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.html">
                <i class="bi bi-shield-check"></i> GAD Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.html">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> GAD Workflow
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="gad_budget_preparation.html">Budget Preparation</a></li>
                            <li><a class="dropdown-item active" href="gad_budget_crafting.html">Budget Crafting</a></li>
                            <li><a class="dropdown-item" href="gad_plan_review.html">Plan Review</a></li>
                            <li><a class="dropdown-item" href="consolidated_plan.html">Consolidated Plan</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Admin User
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.html"><i class="bi bi-box-arrow-right"></i>
                                    Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="bg-light">
        <div class="container-fluid">
            <ol class="breadcrumb py-2 mb-0">
                <li class="breadcrumb-item"><a href="dashboard.html">Dashboard</a></li>
                <li class="breadcrumb-item active">GAD Budget Crafting</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-tools text-primary"></i> GAD Budget Crafting
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addBudgetItemModal">
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
                                        <th>Object of Expenses</th>
                                        <th>Source of Budget</th>
                                        <th>Amount</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="budgetTableBody">
                                    <tr>
                                        <td>GAD001</td>
                                        <td>Training materials and supplies for gender sensitivity training</td>
                                        <td>Training and Seminar Expenses</td>
                                        <td>General Fund</td>
                                        <td>₱25,000.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editBudgetItem('GAD001')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteBudgetItem('GAD001')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GAD002</td>
                                        <td>Venue rental for women's leadership development workshop</td>
                                        <td>Travel and Transportation</td>
                                        <td>Special Education Fund</td>
                                        <td>₱15,000.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editBudgetItem('GAD002')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteBudgetItem('GAD002')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GAD003</td>
                                        <td>Professional speaker fees for anti-harassment seminar</td>
                                        <td>Professional Services</td>
                                        <td>General Fund</td>
                                        <td>₱30,000.00</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editBudgetItem('GAD003')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteBudgetItem('GAD003')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Total Budget:</th>
                                        <th id="totalBudget">₱70,000.00</th>
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
    <div class="modal fade" id="addBudgetItemModal" tabindex="-1" aria-labelledby="addBudgetItemModalLabel"
        aria-hidden="true">
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
                            <label for="gadActivityId" class="form-label">GAD Activity ID *</label>
                            <input type="text" class="form-control" id="gadActivityId" name="gadActivityId" required>
                            <div class="invalid-feedback">
                                Please provide a valid GAD Activity ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="particulars" class="form-label">Particulars/Items of Expense *</label>
                            <textarea class="form-control" id="particulars" name="particulars" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">
                                Please provide valid particulars or items of expense.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="objectOfExpenses" class="form-label">Object of Expenses *</label>
                                    <select class="form-select" id="objectOfExpenses" name="objectOfExpenses" required>
                                        <option value="">Select Object of Expenses</option>
                                        <option value="Training and Seminar Expenses">Training and Seminar Expenses
                                        </option>
                                        <option value="Office Supplies and Materials">Office Supplies and Materials
                                        </option>
                                        <option value="Professional Services">Professional Services</option>
                                        <option value="Travel and Transportation">Travel and Transportation</option>
                                        <option value="Communication and Utilities">Communication and Utilities</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an object of expenses.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sourceOfBudget" class="form-label">Source of Budget *</label>
                                    <select class="form-select" id="sourceOfBudget" name="sourceOfBudget" required>
                                        <option value="">Select Source of Budget</option>
                                        <option value="General Fund">General Fund</option>
                                        <option value="Special Education Fund">Special Education Fund</option>
                                        <option value="Trust Fund">Trust Fund</option>
                                        <option value="Development Fund">Development Fund</option>
                                        <option value="Foreign Assistance">Foreign Assistance</option>
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
                                <input type="number" class="form-control" id="amount" name="amount" required min="0"
                                    step="0.01">
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
    <div class="modal fade" id="editBudgetItemModal" tabindex="-1" aria-labelledby="editBudgetItemModalLabel"
        aria-hidden="true">
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
                        <input type="hidden" id="editBudgetItemId" name="editBudgetItemId">
                        <div class="mb-3">
                            <label for="editGadActivityId" class="form-label">GAD Activity ID *</label>
                            <input type="text" class="form-control" id="editGadActivityId" name="editGadActivityId"
                                required>
                            <div class="invalid-feedback">
                                Please provide a valid GAD Activity ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editParticulars" class="form-label">Particulars/Items of Expense *</label>
                            <textarea class="form-control" id="editParticulars" name="editParticulars" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">
                                Please provide valid particulars or items of expense.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editObjectOfExpenses" class="form-label">Object of Expenses *</label>
                                    <select class="form-select" id="editObjectOfExpenses" name="editObjectOfExpenses"
                                        required>
                                        <option value="">Select Object of Expenses</option>
                                        <option value="Training and Seminar Expenses">Training and Seminar Expenses
                                        </option>
                                        <option value="Office Supplies and Materials">Office Supplies and Materials
                                        </option>
                                        <option value="Professional Services">Professional Services</option>
                                        <option value="Travel and Transportation">Travel and Transportation</option>
                                        <option value="Communication and Utilities">Communication and Utilities</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an object of expenses.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editSourceOfBudget" class="form-label">Source of Budget *</label>
                                    <select class="form-select" id="editSourceOfBudget" name="editSourceOfBudget"
                                        required>
                                        <option value="">Select Source of Budget</option>
                                        <option value="General Fund">General Fund</option>
                                        <option value="Special Education Fund">Special Education Fund</option>
                                        <option value="Trust Fund">Trust Fund</option>
                                        <option value="Development Fund">Development Fund</option>
                                        <option value="Foreign Assistance">Foreign Assistance</option>
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
                                <input type="number" class="form-control" id="editAmount" name="editAmount" required
                                    min="0" step="0.01">
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

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Bootstrap form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
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
            const formId = form.id;

            if (formId === 'addBudgetItemForm') {
                addBudgetItemToTable(formData);
            } else if (formId === 'editBudgetItemForm') {
                updateBudgetItemInTable(formData);
            }

            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();

            // Reset form
            form.reset();
            form.classList.remove('was-validated');

            // Recalculate total
            calculateTotal();
        }

        // Add budget item to table
        function addBudgetItemToTable(formData) {
            const tableBody = document.getElementById('budgetTableBody');
            const newRow = document.createElement('tr');
            const gadActivityId = formData.get('gadActivityId');
            const particulars = formData.get('particulars');
            const objectOfExpenses = formData.get('objectOfExpenses');
            const sourceOfBudget = formData.get('sourceOfBudget');
            const amount = parseFloat(formData.get('amount'));

            newRow.innerHTML = `
                <td>${gadActivityId}</td>
                <td>${particulars}</td>
                <td>${objectOfExpenses}</td>
                <td>${sourceOfBudget}</td>
                <td>₱${amount.toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editBudgetItem('${gadActivityId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteBudgetItem('${gadActivityId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;

            tableBody.appendChild(newRow);
        }

        // Edit budget item
        function editBudgetItem(gadActivityId) {
            const modal = new bootstrap.Modal(document.getElementById('editBudgetItemModal'));
            const rows = document.querySelectorAll('#budgetTableBody tr');

            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    document.getElementById('editBudgetItemId').value = gadActivityId;
                    document.getElementById('editGadActivityId').value = row.cells[0].textContent;
                    document.getElementById('editParticulars').value = row.cells[1].textContent;
                    document.getElementById('editObjectOfExpenses').value = row.cells[2].textContent;
                    document.getElementById('editSourceOfBudget').value = row.cells[3].textContent;

                    // Extract amount from formatted text
                    const amountText = row.cells[4].textContent.replace('₱', '').replace(/,/g, '');
                    document.getElementById('editAmount').value = parseFloat(amountText);
                }
            });

            modal.show();
        }

        // Update budget item in table
        function updateBudgetItemInTable(formData) {
            const gadActivityId = formData.get('editBudgetItemId');
            const newGadActivityId = formData.get('editGadActivityId');
            const particulars = formData.get('editParticulars');
            const objectOfExpenses = formData.get('editObjectOfExpenses');
            const sourceOfBudget = formData.get('editSourceOfBudget');
            const amount = parseFloat(formData.get('editAmount'));

            const rows = document.querySelectorAll('#budgetTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    row.cells[0].textContent = newGadActivityId;
                    row.cells[1].textContent = particulars;
                    row.cells[2].textContent = objectOfExpenses;
                    row.cells[3].textContent = sourceOfBudget;
                    row.cells[4].textContent = `₱${amount.toLocaleString()}`;

                    // Update action buttons
                    row.cells[5].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editBudgetItem('${newGadActivityId}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteBudgetItem('${newGadActivityId}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            });
        }

        // Delete budget item
        function deleteBudgetItem(gadActivityId) {
            if (confirm('Are you sure you want to delete this budget item?')) {
                const rows = document.querySelectorAll('#budgetTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === gadActivityId) {
                        row.remove();
                    }
                });
                calculateTotal();
            }
        }

        // Calculate total budget
        function calculateTotal() {
            const rows = document.querySelectorAll('#budgetTableBody tr');
            let total = 0;

            rows.forEach(row => {
                const amountText = row.cells[4].textContent.replace('₱', '').replace(/,/g, '');
                total += parseFloat(amountText) || 0;
            });

            document.getElementById('totalBudget').textContent = `₱${total.toLocaleString()}`;
        }

        // Export budget
        function exportBudget() {
            alert('Budget export functionality would be implemented here.');
        }
    </script>
</body>

</html>
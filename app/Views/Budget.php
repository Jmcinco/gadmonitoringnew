<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Budget Management - GAD Management System</title>
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
                            <i class="bi bi-clipboard-check"></i> GAD Activities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="plan.html">Plan</a></li>
                            <li><a class="dropdown-item active" href="budget.html">Budget</a></li>
                            <li><a class="dropdown-item" href="pap.html">PAP</a></li>
                            <li><a class="dropdown-item" href="output.html">Output</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> Admin User
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.html"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
                <li class="breadcrumb-item active">Budget Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-calculator text-primary"></i> Budget Management
                    </h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
                            <i class="bi bi-plus-circle"></i> Add Budget Item
                        </button>
                        <button type="button" class="btn btn-outline-success" onclick="generateBudgetReport()">
                            <i class="bi bi-file-earmark-excel"></i> Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-primary border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-primary fw-bold small">Total Budget</div>
                                <div class="h4 mb-0">₱2,500,000</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-currency-dollar text-primary display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-success border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-success fw-bold small">Allocated</div>
                                <div class="h4 mb-0">₱1,875,000</div>
                                <div class="text-muted small">75% of total</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle text-success display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-warning border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-warning fw-bold small">Utilized</div>
                                <div class="h4 mb-0">₱1,200,000</div>
                                <div class="text-muted small">48% of total</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-graph-up text-warning display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-start border-info border-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-info fw-bold small">Remaining</div>
                                <div class="h4 mb-0">₱1,300,000</div>
                                <div class="text-muted small">52% available</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-piggy-bank text-info display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Utilization Chart -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-bar-chart"></i> Budget Utilization by Division
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold">Human Resources</span>
                                <span class="text-muted">₱800,000 / ₱1,000,000</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-success" style="width: 80%">80%</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold">Information Technology</span>
                                <span class="text-muted">₱300,000 / ₱600,000</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-info" style="width: 50%">50%</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold">Finance</span>
                                <span class="text-muted">₱100,000 / ₱500,000</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-warning" style="width: 20%">20%</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-bold">Administration</span>
                                <span class="text-muted">₱0 / ₱400,000</span>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar bg-danger" style="width: 0%">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="bi bi-pie-chart"></i> Budget by Category
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span><i class="bi bi-circle-fill text-primary"></i> Training & Development</span>
                            <span class="fw-bold">45%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span><i class="bi bi-circle-fill text-success"></i> Workshops & Seminars</span>
                            <span class="fw-bold">30%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span><i class="bi bi-circle-fill text-info"></i> Awareness Campaigns</span>
                            <span class="fw-bold">15%</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span><i class="bi bi-circle-fill text-warning"></i> Policy Development</span>
                            <span class="fw-bold">10%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Budget Items Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Budget Items</h5>
                            </div>
                            <div class="col-auto">
                                <div class="row g-2">
                                    <div class="col">
                                        <select class="form-select" id="filterDivision">
                                            <option value="">All Divisions</option>
                                            <option value="HR">Human Resources</option>
                                            <option value="IT">Information Technology</option>
                                            <option value="FIN">Finance</option>
                                            <option value="ADM">Administration</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search budget items..." id="searchInput">
                                            <button class="btn btn-outline-secondary" type="button">
                                                <i class="bi bi-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Activity ID</th>
                                        <th>Division</th>
                                        <th>Description</th>
                                        <th>Object of Expense</th>
                                        <th>Source of Fund</th>
                                        <th>Allocated Amount</th>
                                        <th>Utilized Amount</th>
                                        <th>Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="budgetTableBody">
                                    <tr>
                                        <td>ACT001</td>
                                        <td>HR</td>
                                        <td>Gender Sensitivity Training</td>
                                        <td>Training Services</td>
                                        <td>General Fund</td>
                                        <td>₱250,000</td>
                                        <td>₱200,000</td>
                                        <td class="text-success">₱50,000</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewBudget('ACT001')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editBudget('ACT001')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBudget('ACT001')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ACT002</td>
                                        <td>IT</td>
                                        <td>Women in Technology Workshop</td>
                                        <td>Workshop Materials</td>
                                        <td>Special Fund</td>
                                        <td>₱150,000</td>
                                        <td>₱100,000</td>
                                        <td class="text-success">₱50,000</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewBudget('ACT002')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editBudget('ACT002')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBudget('ACT002')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ACT003</td>
                                        <td>FIN</td>
                                        <td>Financial Literacy Program</td>
                                        <td>Training Materials</td>
                                        <td>General Fund</td>
                                        <td>₱120,000</td>
                                        <td>₱0</td>
                                        <td class="text-warning">₱120,000</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewBudget('ACT003')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editBudget('ACT003')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteBudget('ACT003')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Budget Modal -->
    <div class="modal fade" id="addBudgetModal" tabindex="-1" aria-labelledby="addBudgetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBudgetModalLabel">
                        <i class="bi bi-plus-circle"></i> Add Budget Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addBudgetForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="activityId" class="form-label">Activity ID *</label>
                                    <input type="text" class="form-control" id="activityId" name="activityId" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid activity ID.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="division" class="form-label">Division *</label>
                                    <select class="form-select" id="division" name="division" required>
                                        <option value="">Select Division</option>
                                        <option value="HR">Human Resources</option>
                                        <option value="IT">Information Technology</option>
                                        <option value="FIN">Finance</option>
                                        <option value="ADM">Administration</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a division.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide a description.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="objectOfExpense" class="form-label">Object of Expense *</label>
                                    <select class="form-select" id="objectOfExpense" name="objectOfExpense" required>
                                        <option value="">Select Object of Expense</option>
                                        <option value="Training Services">Training Services</option>
                                        <option value="Workshop Materials">Workshop Materials</option>
                                        <option value="Training Materials">Training Materials</option>
                                        <option value="Office Supplies">Office Supplies</option>
                                        <option value="Equipment">Equipment</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an object of expense.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sourceOfFund" class="form-label">Source of Fund *</label>
                                    <select class="form-select" id="sourceOfFund" name="sourceOfFund" required>
                                        <option value="">Select Source of Fund</option>
                                        <option value="General Fund">General Fund</option>
                                        <option value="Special Fund">Special Fund</option>
                                        <option value="Trust Fund">Trust Fund</option>
                                        <option value="Donation">Donation</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a source of fund.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="allocatedAmount" class="form-label">Allocated Amount *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="allocatedAmount" name="allocatedAmount" required min="0" step="0.01">
                                        <div class="invalid-feedback">
                                            Please provide a valid amount.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="utilizedAmount" class="form-label">Utilized Amount</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="utilizedAmount" name="utilizedAmount" min="0" step="0.01" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addBudgetForm" class="btn btn-primary">Save Budget Item</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
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
            const formData = new FormData(form);
            addBudgetToTable(formData);
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add budget item to table
        function addBudgetToTable(formData) {
            const tableBody = document.getElementById('budgetTableBody');
            const newRow = document.createElement('tr');
            
            const activityId = formData.get('activityId');
            const division = formData.get('division');
            const description = formData.get('description');
            const objectOfExpense = formData.get('objectOfExpense');
            const sourceOfFund = formData.get('sourceOfFund');
            const allocatedAmount = parseFloat(formData.get('allocatedAmount'));
            const utilizedAmount = parseFloat(formData.get('utilizedAmount') || 0);
            const balance = allocatedAmount - utilizedAmount;
            
            const balanceClass = balance > 0 ? 'text-success' : balance === 0 ? 'text-warning' : 'text-danger';
            
            newRow.innerHTML = `
                <td>${activityId}</td>
                <td>${division}</td>
                <td>${description}</td>
                <td>${objectOfExpense}</td>
                <td>${sourceOfFund}</td>
                <td>₱${allocatedAmount.toLocaleString()}</td>
                <td>₱${utilizedAmount.toLocaleString()}</td>
                <td class="${balanceClass}">₱${balance.toLocaleString()}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="viewBudget('${activityId}')" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="editBudget('${activityId}')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteBudget('${activityId}')" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // View budget details
        function viewBudget(activityId) {
            alert('View budget details for activity: ' + activityId);
        }

        // Edit budget
        function editBudget(activityId) {
            alert('Edit budget functionality would be implemented here for activity: ' + activityId);
        }

        // Delete budget
        function deleteBudget(activityId) {
            if (confirm('Are you sure you want to delete this budget item?')) {
                const rows = document.querySelectorAll('#budgetTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === activityId) {
                        row.remove();
                    }
                });
            }
        }

        // Generate budget report
        function generateBudgetReport() {
            alert('Budget report generation functionality would be implemented here.');
        }

        // Filter functionality
        function setupFilters() {
            const searchInput = document.getElementById('searchInput');
            const filterDivision = document.getElementById('filterDivision');
            
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const divisionFilter = filterDivision.value;
                
                const rows = document.querySelectorAll('#budgetTableBody tr');
                
                rows.forEach(row => {
                    const cells = row.cells;
                    const activityId = cells[0].textContent.toLowerCase();
                    const division = cells[1].textContent;
                    const description = cells[2].textContent.toLowerCase();
                    
                    const matchesSearch = activityId.includes(searchTerm) || description.includes(searchTerm);
                    const matchesDivision = !divisionFilter || division === divisionFilter;
                    
                    const shouldShow = matchesSearch && matchesDivision;
                    row.style.display = shouldShow ? '' : 'none';
                });
            }
            
            searchInput.addEventListener('input', filterTable);
            filterDivision.addEventListener('change', filterTable);
        }
        
        // Initialize filters
        setupFilters();
    </script>
</body>
</html>
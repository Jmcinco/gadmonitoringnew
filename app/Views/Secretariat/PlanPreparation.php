<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Plan Preparation - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-gear"></i> Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="division.html">Division</a></li>
                            <li><a class="dropdown-item" href="employee.html">Employee</a></li>
                            <li><a class="dropdown-item" href="position.html">Position</a></li>
                            <li><a class="dropdown-item" href="mfo.html">MFO/PAP</a></li>
                            <li><a class="dropdown-item" href="object_of_expense.html">Object of Expense</a></li>
                            <li><a class="dropdown-item" href="source_of_fund.html">Source of Fund</a></li>
                            <li><a class="dropdown-item" href="gad_mandate.html">GAD Mandate</a></li>
                            <li><a class="dropdown-item" href="output.html">Output</a></li>
                            <li><a class="dropdown-item" href="pap.html">PAP</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-clipboard-data"></i> GAD Planning
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="gad_plan_preparation.html">GAD Plan Preparation</a></li>
                            <li><a class="dropdown-item" href="gad_budget_preparation.html">GAD Budget Preparation</a></li>
                            <li><a class="dropdown-item" href="gad_budget_crafting.html">GAD Budget Crafting</a></li>
                            <li><a class="dropdown-item" href="gad_plan_review.html">GAD Plan Review</a></li>
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
                <li class="breadcrumb-item"><a href="gad_budget_preparation.html">GAD Planning</a></li>
                <li class="breadcrumb-item active">GAD Plan Preparation</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-clipboard-data text-primary"></i> GAD Plan Preparation
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gadPlanModal">
                        <i class="bi bi-plus-circle"></i> Create GAD Plan
                    </button>
                </div>
            </div>
        </div>

        <!-- GAD Plan Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">GAD Plan Activities</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search GAD plans..." id="searchInput">
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
                                        <th>Activity ID</th>
                                        <th>Gender Issue/GAD Mandate</th>
                                        <th>Cause of Gender Issue</th>
                                        <th>GAD Objective</th>
                                        <th>Relevant MFO/PAP</th>
                                        <th>Performance Targets</th>
                                        <th>Timeline</th>
                                        <th>Responsible Unit</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="gadPlanTableBody">
                                    <tr>
                                        <td>GAD-ACT-001</td>
                                        <td>Gender disparities in leadership positions</td>
                                        <td>Limited opportunities for women in senior roles</td>
                                        <td>Increase women's representation in leadership by 25%</td>
                                        <td>MFO001 - Human Resource Development</td>
                                        <td>Train 50 women leaders, promote 10 to senior positions</td>
                                        <td>Jan 2025 - Dec 2025</td>
                                        <td>Human Resources Division</td>
                                        <td>
                                            <a href="gad_budget_crafting.html" class="btn btn-sm btn-outline-info">
                                                ₱250,000
                                            </a>
                                        </td>
                                        <td><span class="badge bg-warning">Draft</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editGadPlan('GAD-ACT-001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan('GAD-ACT-001')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GAD-ACT-002</td>
                                        <td>Workplace harassment and discrimination</td>
                                        <td>Lack of awareness and reporting mechanisms</td>
                                        <td>Establish zero-tolerance policy and reporting system</td>
                                        <td>MFO002 - Policy Development</td>
                                        <td>Implement policy, train 100 employees, reduce incidents by 80%</td>
                                        <td>Mar 2025 - Sep 2025</td>
                                        <td>Administration Office</td>
                                        <td>
                                            <a href="gad_budget_crafting.html" class="btn btn-sm btn-outline-info">
                                               ₱180,000
                                            </a>
                                        </td>
                                        <td><span class="badge bg-success">Submitted</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editGadPlan('GAD-ACT-002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan('GAD-ACT-002')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>GAD-ACT-003</td>
                                        <td>Unequal access to professional development</td>
                                        <td>Gender bias in training selection and opportunities</td>
                                        <td>Ensure equal access to professional development programs</td>
                                        <td>MFO003 - Capacity Building</td>
                                        <td>Provide training to 200 employees (50% women), track participation</td>
                                        <td>Jun 2025 - Nov 2025</td>
                                        <td>Training and Development Unit</td>
                                        <td>
                                            <a href="gad_budget_crafting.html" class="btn btn-sm btn-outline-info">
                                               ₱320,000
                                            </a>
                                        </td>
                                        <td><span class="badge bg-warning">Draft</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editGadPlan('GAD-ACT-003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan('GAD-ACT-003')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
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

    <!-- GAD Plan Modal -->
    <div class="modal fade" id="gadPlanModal" tabindex="-1" aria-labelledby="gadPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gadPlanModalLabel">
                        <i class="bi bi-clipboard-data"></i> Create GAD Plan Activity
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="gadPlanForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="activityId" class="form-label">Activity ID</label>
                                    <input type="text" class="form-control" id="activityId" name="activityId" readonly>
                                    <div class="form-text">Auto-generated</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="Draft">Draft</option>
                                        <option value="Submitted">Submitted</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="genderIssue" class="form-label">Gender Issue/GAD Mandate <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="genderIssue" name="genderIssue" rows="3" placeholder="Describe the gender issue or GAD mandate to be addressed..." required></textarea>
                            <div class="invalid-feedback">
                                Please provide a gender issue or GAD mandate.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="causeOfIssue" class="form-label">Cause of Gender Issue <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="causeOfIssue" name="causeOfIssue" rows="3" placeholder="Identify the root causes of the gender issue..." required></textarea>
                            <div class="invalid-feedback">
                                Please provide the cause of the gender issue.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="gadObjective" class="form-label">GAD Result/Statement or GAD Objective <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="gadObjective" name="gadObjective" rows="3" placeholder="Define the expected GAD result or objective..." required></textarea>
                            <div class="invalid-feedback">
                                Please provide the GAD objective or result statement.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="relevantMfoPap" class="form-label">Relevant Organization/MFO/PAP or PPA <span class="text-danger">*</span></label>
                            <select class="form-select" id="relevantMfoPap" name="relevantMfoPap" required>
                                <option value="">Select MFO/PAP</option>
                                <option value="MFO001 - Human Resource Development">MFO001 - Human Resource Development</option>
                                <option value="MFO002 - Policy Development">MFO002 - Policy Development</option>
                                <option value="MFO003 - Capacity Building">MFO003 - Capacity Building</option>
                                <option value="MFO004 - Advocacy and Communication">MFO004 - Advocacy and Communication</option>
                                <option value="PAP001 - Gender Sensitivity Training">PAP001 - Gender Sensitivity Training</option>
                                <option value="PAP002 - Women's Leadership Program">PAP002 - Women's Leadership Program</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a relevant MFO/PAP.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="performanceTargets" class="form-label">Performance Targets/Indicators <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="performanceTargets" name="performanceTargets" rows="3" placeholder="Define specific, measurable performance targets and indicators..." required></textarea>
                            <div class="invalid-feedback">
                                Please provide performance targets and indicators.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="startDate" name="startDate" required>
                                    <div class="invalid-feedback">
                                        Please select a start date.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="endDate" name="endDate" required>
                                    <div class="invalid-feedback">
                                        Please select an end date.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="responsibleUnit" class="form-label">Responsible Unit/Office <span class="text-danger">*</span></label>
                            <select class="form-select" id="responsibleUnit" name="responsibleUnit" required>
                                <option value="">Select Responsible Unit</option>
                                <option value="Human Resources Division">Human Resources Division</option>
                                <option value="Administration Office">Administration Office</option>
                                <option value="Training and Development Unit">Training and Development Unit</option>
                                <option value="Finance Office">Finance Office</option>
                                <option value="Information Technology Division">Information Technology Division</option>
                                <option value="Legal Affairs Office">Legal Affairs Office</option>
                                <option value="Planning and Development Unit">Planning and Development Unit</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a responsible unit.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="budgetAmount" class="form-label">Budget Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input type="number" class="form-control" id="budgetAmount" name="budgetAmount" step="0.01" min="0" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="linkToBudgetCrafting()">
                                    <i class="bi bi-link-45deg"></i> Link to Budget Crafting
                                </button>
                                <div class="invalid-feedback">
                                    Please enter a budget amount.
                                </div>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Budget will be linked to the GAD Budget Crafting module for detailed breakdown.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveGadPlan()">
                        <i class="bi bi-check-circle"></i> Save GAD Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-generate Activity ID
        function generateActivityId() {
            const timestamp = Date.now().toString().slice(-6);
            return 'GAD-ACT-' + timestamp;
        }

        // Set Activity ID when modal opens
        document.getElementById('gadPlanModal').addEventListener('show.bs.modal', function() {
            document.getElementById('activityId').value = generateActivityId();
        });

        // Date validation
        document.getElementById('startDate').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('endDate');
            
            if (startDate) {
                endDateInput.min = startDate;
            }
        });

        document.getElementById('endDate').addEventListener('change', function() {
            const endDate = this.value;
            const startDateInput = document.getElementById('startDate');
            
            if (endDate) {
                startDateInput.max = endDate;
            }
        });

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
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        function saveGadPlan() {
            const form = document.getElementById('gadPlanForm');
            const formData = new FormData(form);
            
            // Validation
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            
            // Date validation
            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            
            if (startDate >= endDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    text: 'End date must be after start date.'
                });
                return;
            }
            
            // Get form values
            const activityId = formData.get('activityId');
            const genderIssue = formData.get('genderIssue');
            const causeOfIssue = formData.get('causeOfIssue');
            const gadObjective = formData.get('gadObjective');
            const relevantMfoPap = formData.get('relevantMfoPap');
            const performanceTargets = formData.get('performanceTargets');
            const responsibleUnit = formData.get('responsibleUnit');
            const budgetAmount = parseFloat(formData.get('budgetAmount'));
            const status = formData.get('status');
            
            // Format timeline
            const timeline = `${formatDate(startDate)} - ${formatDate(endDate)}`;
            
            // Add to table
            const tableBody = document.getElementById('gadPlanTableBody');
            const newRow = document.createElement('tr');
            
            newRow.innerHTML = `
                <td>${activityId}</td>
                <td>${genderIssue}</td>
                <td>${causeOfIssue}</td>
                <td>${gadObjective}</td>
                <td>${relevantMfoPap}</td>
                <td>${performanceTargets}</td>
                <td>${timeline}</td>
                <td>${responsibleUnit}</td>
                <td>
                    <a href="gad_budget_crafting.html" class="btn btn-sm btn-outline-info">
                       ₱${budgetAmount.toLocaleString('en-US', {minimumFractionDigits: 0})}
                    </a>
                </td>
                <td><span class="badge bg-${status === 'Submitted' ? 'success' : 'warning'}">${status}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editGadPlan('${activityId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan('${activityId}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'GAD Plan Saved!',
                text: 'The GAD plan activity has been successfully saved.',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('gadPlanModal'));
            modal.hide();
            form.reset();
            form.classList.remove('was-validated');
        }

        function editGadPlan(activityId) {
            Swal.fire({
                icon: 'info',
                title: 'Edit GAD Plan',
                text: 'Edit functionality for Activity ID: ' + activityId
            });
        }

        function deleteGadPlan(activityId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Remove row from table
                    const rows = document.querySelectorAll('#gadPlanTableBody tr');
                    rows.forEach(row => {
                        if (row.cells[0].textContent === activityId) {
                            row.remove();
                        }
                    });
                    
                    Swal.fire(
                        'Deleted!',
                        'The GAD plan activity has been deleted.',
                        'success'
                    );
                }
            });
        }

        function linkToBudgetCrafting() {
            Swal.fire({
                icon: 'info',
                title: 'Budget Crafting',
                text: 'This will link to the GAD Budget Crafting module for detailed budget breakdown.',
                showCancelButton: true,
                confirmButtonText: 'Go to Budget Crafting',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.open('gad_budget_crafting.html', '_blank');
                }
            });
        }

        function formatDate(date) {
            return date.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#gadPlanTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
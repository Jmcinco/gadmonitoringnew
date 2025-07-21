<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan Management - GAD Management System</title>
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
                            <li><a class="dropdown-item active" href="plan.html">Plan</a></li>
                            <li><a class="dropdown-item" href="budget.html">Budget</a></li>
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
                <li class="breadcrumb-item active">Plan Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-clipboard-check text-primary"></i> Plan Management
                    </h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                            <i class="bi bi-plus-circle"></i> Create New Plan
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="exportPlans()">
                            <i class="bi bi-download"></i> Export
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-start border-primary border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-primary fw-bold small">Total Plans</div>
                                <div class="h4 mb-0">25</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-clipboard-check text-primary display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-start border-success border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-success fw-bold small">Approved</div>
                                <div class="h4 mb-0">18</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-check-circle text-success display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-start border-warning border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-warning fw-bold small">Pending</div>
                                <div class="h4 mb-0">5</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-clock-history text-warning display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-start border-danger border-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="text-uppercase text-danger fw-bold small">Rejected</div>
                                <div class="h4 mb-0">2</div>
                            </div>
                            <div class="flex-shrink-0">
                                <i class="bi bi-x-circle text-danger display-6"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="filterDivision" class="form-label">Division</label>
                                <select class="form-select" id="filterDivision">
                                    <option value="">All Divisions</option>
                                    <option value="HR">Human Resources</option>
                                    <option value="IT">Information Technology</option>
                                    <option value="FIN">Finance</option>
                                    <option value="ADM">Administration</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterStatus" class="form-label">Status</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">All Status</option>
                                    <option value="Draft">Draft</option>
                                    <option value="Submitted">Submitted</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterMFO" class="form-label">MFO</label>
                                <select class="form-select" id="filterMFO">
                                    <option value="">All MFO</option>
                                    <option value="Training">Training Programs</option>
                                    <option value="Workshops">Workshops</option>
                                    <option value="Awareness">Awareness Campaigns</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="searchInput" class="form-label">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search plans..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plans Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">GAD Plans</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Plan ID</th>
                                        <th>Division</th>
                                        <th>MFO</th>
                                        <th>Issue/Mandate</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="planTableBody">
                                    <tr>
                                        <td>PLAN001</td>
                                        <td>HR</td>
                                        <td>Training Programs</td>
                                        <td>Gender Sensitivity Training for All Staff</td>
                                        <td>₱250,000</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewPlan('PLAN001')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editPlan('PLAN001')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deletePlan('PLAN001')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PLAN002</td>
                                        <td>IT</td>
                                        <td>Workshops</td>
                                        <td>Women in Technology Workshop</td>
                                        <td>₱150,000</td>
                                        <td><span class="badge bg-warning">Pending</span></td>
                                        <td>2024-01-20</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewPlan('PLAN002')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editPlan('PLAN002')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deletePlan('PLAN002')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PLAN003</td>
                                        <td>FIN</td>
                                        <td>Awareness Campaigns</td>
                                        <td>Financial Literacy for Women</td>
                                        <td>₱120,000</td>
                                        <td><span class="badge bg-info">Draft</span></td>
                                        <td>2024-01-25</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewPlan('PLAN003')" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary" onclick="editPlan('PLAN003')" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deletePlan('PLAN003')" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="Plan pagination">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Plan Modal -->
    <div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPlanModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New GAD Plan
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPlanForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="planId" class="form-label">Plan ID *</label>
                                    <input type="text" class="form-control" id="planId" name="planId" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid plan ID.
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
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mfo" class="form-label">MFO *</label>
                                    <select class="form-select" id="mfo" name="mfo" required>
                                        <option value="">Select MFO</option>
                                        <option value="Training Programs">Training Programs</option>
                                        <option value="Workshops">Workshops</option>
                                        <option value="Awareness Campaigns">Awareness Campaigns</option>
                                        <option value="Policy Development">Policy Development</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an MFO.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="budget" class="form-label">Budget *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="budget" name="budget" required min="0" step="0.01">
                                        <div class="invalid-feedback">
                                            Please provide a valid budget amount.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="issueMandate" class="form-label">Issue/Mandate *</label>
                            <textarea class="form-control" id="issueMandate" name="issueMandate" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the issue or mandate.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cause" class="form-label">Root Cause</label>
                            <textarea class="form-control" id="cause" name="cause" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="objectives" class="form-label">Objectives</label>
                            <textarea class="form-control" id="objectives" name="objectives" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate">
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="targetBeneficiaries" class="form-label">Target Beneficiaries</label>
                            <textarea class="form-control" id="targetBeneficiaries" name="targetBeneficiaries" rows="2"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="expectedOutputs" class="form-label">Expected Outputs</label>
                            <textarea class="form-control" id="expectedOutputs" name="expectedOutputs" rows="3"></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="successIndicators" class="form-label">Success Indicators</label>
                            <textarea class="form-control" id="successIndicators" name="successIndicators" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary" onclick="saveDraft()">Save as Draft</button>
                    <button type="submit" form="addPlanForm" class="btn btn-primary">Submit Plan</button>
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
                    <div id="planDetailsContent">
                        <!-- Plan details will be populated here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="printPlan()">
                        <i class="bi bi-printer"></i> Print
                    </button>
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
            addPlanToTable(formData);
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add plan to table
        function addPlanToTable(formData) {
            const tableBody = document.getElementById('planTableBody');
            const newRow = document.createElement('tr');
            
            const planId = formData.get('planId');
            const division = formData.get('division');
            const mfo = formData.get('mfo');
            const issueMandate = formData.get('issueMandate');
            const budget = parseFloat(formData.get('budget')).toLocaleString('en-PH', {
                style: 'currency',
                currency: 'PHP'
            });
            const currentDate = new Date().toISOString().split('T')[0];
            
            newRow.innerHTML = `
                <td>${planId}</td>
                <td>${division}</td>
                <td>${mfo}</td>
                <td>${issueMandate.substring(0, 50)}...</td>
                <td>${budget}</td>
                <td><span class="badge bg-info">Draft</span></td>
                <td>${currentDate}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary" onclick="viewPlan('${planId}')" title="View">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" onclick="editPlan('${planId}')" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deletePlan('${planId}')" title="Delete">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // View plan details
        function viewPlan(planId) {
            const modal = new bootstrap.Modal(document.getElementById('viewPlanModal'));
            const content = document.getElementById('planDetailsContent');
            
            // Mock plan data - in real app, this would come from a database
            content.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Plan Information</h6>
                        <dl class="row">
                            <dt class="col-sm-4">Plan ID:</dt>
                            <dd class="col-sm-8">${planId}</dd>
                            <dt class="col-sm-4">Division:</dt>
                            <dd class="col-sm-8">Human Resources</dd>
                            <dt class="col-sm-4">MFO:</dt>
                            <dd class="col-sm-8">Training Programs</dd>
                            <dt class="col-sm-4">Budget:</dt>
                            <dd class="col-sm-8">₱250,000</dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h6>Status Information</h6>
                        <dl class="row">
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8"><span class="badge bg-success">Approved</span></dd>
                            <dt class="col-sm-4">Created:</dt>
                            <dd class="col-sm-8">2024-01-15</dd>
                            <dt class="col-sm-4">Approved By:</dt>
                            <dd class="col-sm-8">Admin User</dd>
                            <dt class="col-sm-4">Last Modified:</dt>
                            <dd class="col-sm-8">2024-01-20</dd>
                        </dl>
                    </div>
                </div>
                <hr>
                <div class="mb-3">
                    <h6>Issue/Mandate</h6>
                    <p>Gender Sensitivity Training for All Staff to ensure compliance with GAD requirements and promote inclusive workplace practices.</p>
                </div>
                <div class="mb-3">
                    <h6>Objectives</h6>
                    <p>To enhance staff awareness on gender sensitivity issues and promote gender-inclusive practices in the workplace.</p>
                </div>
                <div class="mb-3">
                    <h6>Expected Outputs</h6>
                    <p>All staff members will complete gender sensitivity training with at least 80% pass rate. Training materials and resources will be developed and made available.</p>
                </div>
            `;
            
            modal.show();
        }

        // Edit plan
        function editPlan(planId) {
            alert('Edit plan functionality would be implemented here for plan: ' + planId);
        }

        // Delete plan
        function deletePlan(planId) {
            if (confirm('Are you sure you want to delete this plan?')) {
                const rows = document.querySelectorAll('#planTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === planId) {
                        row.remove();
                    }
                });
            }
        }

        // Save as draft
        function saveDraft() {
            alert('Plan saved as draft successfully!');
            bootstrap.Modal.getInstance(document.getElementById('addPlanModal')).hide();
        }

        // Export plans
        function exportPlans() {
            alert('Export functionality would be implemented here.');
        }

        // Print plan
        function printPlan() {
            window.print();
        }

        // Filter functionality
        function setupFilters() {
            const searchInput = document.getElementById('searchInput');
            const filterDivision = document.getElementById('filterDivision');
            const filterStatus = document.getElementById('filterStatus');
            const filterMFO = document.getElementById('filterMFO');
            
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const divisionFilter = filterDivision.value;
                const statusFilter = filterStatus.value;
                const mfoFilter = filterMFO.value;
                
                const rows = document.querySelectorAll('#planTableBody tr');
                
                rows.forEach(row => {
                    const cells = row.cells;
                    const planId = cells[0].textContent.toLowerCase();
                    const division = cells[1].textContent;
                    const mfo = cells[2].textContent;
                    const issueMandate = cells[3].textContent.toLowerCase();
                    const status = cells[5].textContent;
                    
                    const matchesSearch = planId.includes(searchTerm) || issueMandate.includes(searchTerm);
                    const matchesDivision = !divisionFilter || division === divisionFilter;
                    const matchesStatus = !statusFilter || status.includes(statusFilter);
                    const matchesMFO = !mfoFilter || mfo === mfoFilter;
                    
                    const shouldShow = matchesSearch && matchesDivision && matchesStatus && matchesMFO;
                    row.style.display = shouldShow ? '' : 'none';
                });
            }
            
            searchInput.addEventListener('input', filterTable);
            filterDivision.addEventListener('change', filterTable);
            filterStatus.addEventListener('change', filterTable);
            filterMFO.addEventListener('change', filterTable);
        }
        
        // Initialize filters
        setupFilters();
    </script>
</body>
</html>
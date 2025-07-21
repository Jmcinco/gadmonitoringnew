<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PAP Management - GAD Management System</title>
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
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
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
                            <li><a class="dropdown-item active" href="pap.html">PAP</a></li>
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
                <li class="breadcrumb-item active">PAP Management</li>
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
                        <i class="bi bi-diagram-3 text-primary"></i> Programs, Activities, and Projects (PAP)
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#papModal">
                        <i class="bi bi-plus-circle"></i> Add New PAP
                    </button>
                </div>
            </div>
        </div>

        <!-- Note about MFO/PAP relationship -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i>
                    <strong>Note:</strong> This page manages Programs, Activities, and Projects (PAP) that are linked to Major Final Outputs (MFO). 
                    For comprehensive MFO/PAP management, please visit the <a href="mfo.html" class="alert-link">MFO/PAP Management</a> page.
                </div>
            </div>
        </div>

        <!-- PAP Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">PAP List</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search PAPs..." id="searchInput">
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
                                        <th>PAP ID</th>
                                        <th>PAP Title</th>
                                        <th>Linked MFO</th>
                                        <th>Program Type</th>
                                        <th>Duration</th>
                                        <th>Budget</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="papTableBody">
                                    <tr>
                                        <td>PAP001</td>
                                        <td>Gender Sensitivity Training Workshop</td>
                                        <td>MFO001</td>
                                        <td>Core Program</td>
                                        <td>3 months</td>
                                        <td>₱150,000.00</td>
                                        <td><span class="badge bg-success">Active</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPapDetails('PAP001')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPap('PAP001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePap('PAP001')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAP002</td>
                                        <td>Women's Leadership Development Program</td>
                                        <td>MFO002</td>
                                        <td>Special Program</td>
                                        <td>6 months</td>
                                        <td>₱300,000.00</td>
                                        <td><span class="badge bg-warning">Planning</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPapDetails('PAP002')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPap('PAP002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePap('PAP002')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>PAP003</td>
                                        <td>Anti-Sexual Harassment Policy Implementation</td>
                                        <td>MFO003</td>
                                        <td>Project</td>
                                        <td>12 months</td>
                                        <td>₱75,000.00</td>
                                        <td><span class="badge bg-info">Ongoing</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewPapDetails('PAP003')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPap('PAP003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePap('PAP003')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="PAP pagination">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PAP Modal -->
    <div class="modal fade" id="papModal" tabindex="-1" aria-labelledby="papModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="papModalLabel">
                        <i class="bi bi-diagram-3"></i> Add New PAP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="papForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="papId" class="form-label">PAP ID</label>
                                    <input type="text" class="form-control" id="papId" name="papId" readonly>
                                    <div class="form-text">Auto-generated</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="linkedMfo" class="form-label">Linked MFO <span class="text-danger">*</span></label>
                                    <select class="form-select" id="linkedMfo" name="linkedMfo" required>
                                        <option value="">Select MFO</option>
                                        <option value="MFO001">MFO001 - Human Resource Development</option>
                                        <option value="MFO002">MFO002 - Policy Development</option>
                                        <option value="MFO003">MFO003 - Capacity Building</option>
                                        <option value="MFO004">MFO004 - Advocacy and Communication</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a linked MFO.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="papTitle" class="form-label">PAP Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="papTitle" name="papTitle" placeholder="Enter PAP title" required>
                            <div class="invalid-feedback">
                                Please provide a PAP title.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="papDescription" class="form-label">PAP Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="papDescription" name="papDescription" rows="4" placeholder="Enter detailed description of the PAP..." required></textarea>
                            <div class="invalid-feedback">
                                Please provide a PAP description.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="programType" class="form-label">Program Type <span class="text-danger">*</span></label>
                                    <select class="form-select" id="programType" name="programType" required>
                                        <option value="">Select Program Type</option>
                                        <option value="Core Program">Core Program</option>
                                        <option value="Support Program">Support Program</option>
                                        <option value="Special Program">Special Program</option>
                                        <option value="Project">Project</option>
                                        <option value="Activity">Activity</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a program type.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="implementingOffice" class="form-label">Implementing Office <span class="text-danger">*</span></label>
                                    <select class="form-select" id="implementingOffice" name="implementingOffice" required>
                                        <option value="">Select Office</option>
                                        <option value="HR">Human Resources</option>
                                        <option value="IT">Information Technology</option>
                                        <option value="FIN">Finance</option>
                                        <option value="ADM">Administration</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an implementing office.
                                    </div>
                                </div>
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
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="totalBudget" class="form-label">Total Budget <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">₱</span>
                                        <input type="number" class="form-control" id="totalBudget" name="totalBudget" step="0.01" min="0" required>
                                        <div class="invalid-feedback">
                                            Please enter a valid budget amount.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fundingSource" class="form-label">Funding Source</label>
                                    <select class="form-select" id="fundingSource" name="fundingSource">
                                        <option value="">Select Funding Source</option>
                                        <option value="National Government">National Government</option>
                                        <option value="Local Government">Local Government</option>
                                        <option value="Special Fund">Special Fund</option>
                                        <option value="External Grant">External Grant</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="objectives" class="form-label">Objectives</label>
                            <textarea class="form-control" id="objectives" name="objectives" rows="3" placeholder="Enter the main objectives of the PAP..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="expectedOutputs" class="form-label">Expected Outputs</label>
                            <textarea class="form-control" id="expectedOutputs" name="expectedOutputs" rows="3" placeholder="Enter the expected outputs..."></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="targetBeneficiaries" class="form-label">Target Beneficiaries</label>
                                    <input type="text" class="form-control" id="targetBeneficiaries" name="targetBeneficiaries" placeholder="Enter target beneficiaries">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="projectManager" class="form-label">Project Manager</label>
                                    <input type="text" class="form-control" id="projectManager" name="projectManager" placeholder="Enter project manager name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority Level</label>
                                    <select class="form-select" id="priority" name="priority">
                                        <option value="">Select Priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="riskLevel" class="form-label">Risk Level</label>
                                    <select class="form-select" id="riskLevel" name="riskLevel">
                                        <option value="">Select Risk Level</option>
                                        <option value="Low">Low</option>
                                        <option value="Medium">Medium</option>
                                        <option value="High">High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isActive" name="isActive" checked>
                                <label class="form-check-label" for="isActive">
                                    Active PAP
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="savePap()">
                        <i class="bi bi-check-circle"></i> Save PAP
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-generate PAP ID
        function generatePapId() {
            const timestamp = Date.now().toString().slice(-6);
            return 'PAP' + timestamp;
        }

        // Set PAP ID when modal opens
        document.getElementById('papModal').addEventListener('show.bs.modal', function() {
            document.getElementById('papId').value = generatePapId();
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

        function savePap() {
            const form = document.getElementById('papForm');
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
            const papId = formData.get('papId');
            const papTitle = formData.get('papTitle');
            const linkedMfo = formData.get('linkedMfo');
            const programType = formData.get('programType');
            const totalBudget = parseFloat(formData.get('totalBudget'));
            const isActive = formData.get('isActive') === 'on';
            
            // Calculate duration
            const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24 * 30)) + ' months';
            
            // Add to table
            const tableBody = document.getElementById('papTableBody');
            const newRow = document.createElement('tr');
            
            newRow.innerHTML = `
                <td>${papId}</td>
                <td>${papTitle}</td>
                <td>${linkedMfo}</td>
                <td>${programType}</td>
                <td>${duration}</td>
                <td>₱${totalBudget.toLocaleString('en-US', {minimumFractionDigits: 2})}</td>
                <td><span class="badge bg-${isActive ? 'success' : 'secondary'}">${isActive ? 'Active' : 'Inactive'}</span></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="viewPapDetails('${papId}')">
                        <i class="bi bi-eye"></i> View
                    </button>
                    <button class="btn btn-sm btn-outline-warning" onclick="editPap('${papId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deletePap('${papId}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'PAP Saved!',
                text: 'The PAP has been successfully saved.',
                timer: 2000,
                showConfirmButton: false
            });
            
            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('papModal'));
            modal.hide();
            form.reset();
            form.classList.remove('was-validated');
        }

        function editPap(id) {
            // Implementation for editing PAP
            Swal.fire({
                icon: 'info',
                title: 'Edit PAP',
                text: 'Edit functionality for PAP ID: ' + id
            });
        }

        function deletePap(id) {
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
                    const rows = document.querySelectorAll('#papTableBody tr');
                    rows.forEach(row => {
                        if (row.cells[0].textContent === id) {
                            row.remove();
                        }
                    });
                    
                    Swal.fire(
                        'Deleted!',
                        'The PAP has been deleted.',
                        'success'
                    );
                }
            });
        }

        function viewPapDetails(id) {
            // Implementation for viewing PAP details
            Swal.fire({
                icon: 'info',
                title: 'PAP Details',
                text: 'View details for PAP ID: ' + id
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#papTableBody tr');
            
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
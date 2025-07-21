<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Division Management - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    
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
                            <i class="bi bi-people"></i> Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="division.html">Division</a></li>
                            <li><a class="dropdown-item" href="employee.html">Employee</a></li>
                            <li><a class="dropdown-item" href="position.html">Position</a></li>
                            <li><a class="dropdown-item" href="mfo.html">MFO</a></li>
                            <li><a class="dropdown-item" href="object_of_expense.html">Object of Expense</a></li>
                            <li><a class="dropdown-item" href="source_of_fund.html">Source of Fund</a></li>
                            <li><a class="dropdown-item" href="gad_mandate.html">GAD Mandate</a></li>
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
                <li class="breadcrumb-item active">Division Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-building text-primary"></i> Division Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDivisionModal">
                        <i class="bi bi-plus-circle"></i> Add New Division
                    </button>
                </div>
            </div>
        </div>

        <!-- Division Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Division List</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search divisions..." id="searchInput">
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
                                        <th>Division Code</th>
                                        <th>Office Name</th>
                                        <th>Created Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="divisionTableBody">
                                    <tr>
                                        <td>HR</td>
                                        <td>Human Resources Division</td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editDivision('HR')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteDivision('HR')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>IT</td>
                                        <td>Information Technology Division</td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editDivision('IT')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteDivision('IT')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>FIN</td>
                                        <td>Finance Division</td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editDivision('FIN')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteDivision('FIN')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>ADM</td>
                                        <td>Administration Division</td>
                                        <td>2024-01-15</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editDivision('ADM')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteDivision('ADM')">
                                                <i class="bi bi-trash"></i>
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

    <!-- Add Division Modal -->
    <div class="modal fade" id="addDivisionModal" tabindex="-1" aria-labelledby="addDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDivisionModalLabel">
                        <i class="bi bi-plus-circle"></i> Add New Division
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addDivisionForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="divisionCode" class="form-label">Division Code *</label>
                            <input type="text" class="form-control" id="divisionCode" name="divisionCode" required maxlength="20">
                            <div class="invalid-feedback">
                                Please provide a valid division code.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="officeName" class="form-label">Office Name *</label>
                            <input type="text" class="form-control" id="officeName" name="officeName" required maxlength="200">
                            <div class="invalid-feedback">
                                Please provide a valid office name.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addDivisionForm" class="btn btn-primary">Save Division</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Division Modal -->
    <div class="modal fade" id="editDivisionModal" tabindex="-1" aria-labelledby="editDivisionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDivisionModalLabel">
                        <i class="bi bi-pencil"></i> Edit Division
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDivisionForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="editDivisionCode" class="form-label">Division Code *</label>
                            <input type="text" class="form-control" id="editDivisionCode" name="editDivisionCode" required maxlength="20">
                            <div class="invalid-feedback">
                                Please provide a valid division code.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editOfficeName" class="form-label">Office Name *</label>
                            <input type="text" class="form-control" id="editOfficeName" name="editOfficeName" required maxlength="200">
                            <div class="invalid-feedback">
                                Please provide a valid office name.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editDivisionForm" class="btn btn-primary">Update Division</button>
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
            const formId = form.id;
            
            if (formId === 'addDivisionForm') {
                addDivisionToTable(formData);
            } else if (formId === 'editDivisionForm') {
                updateDivisionInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add division to table
        function addDivisionToTable(formData) {
            const tableBody = document.getElementById('divisionTableBody');
            const newRow = document.createElement('tr');
            const divisionCode = formData.get('divisionCode');
            const officeName = formData.get('officeName');
            const currentDate = new Date().toISOString().split('T')[0];
            
            newRow.innerHTML = `
                <td>${divisionCode}</td>
                <td>${officeName}</td>
                <td>${currentDate}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editDivision('${divisionCode}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteDivision('${divisionCode}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit division
        function editDivision(code) {
            const modal = new bootstrap.Modal(document.getElementById('editDivisionModal'));
            document.getElementById('editDivisionCode').value = code;
            // In a real app, you'd fetch the data from a database
            document.getElementById('editOfficeName').value = getOfficeNameByCode(code);
            modal.show();
        }

        // Get office name by code (mock data)
        function getOfficeNameByCode(code) {
            const divisions = {
                'HR': 'Human Resources Division',
                'IT': 'Information Technology Division',
                'FIN': 'Finance Division',
                'ADM': 'Administration Division'
            };
            return divisions[code] || '';
        }

        // Update division in table
        function updateDivisionInTable(formData) {
            const code = formData.get('editDivisionCode');
            const officeName = formData.get('editOfficeName');
            
            const rows = document.querySelectorAll('#divisionTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === code) {
                    row.cells[1].textContent = officeName;
                }
            });
        }

        // Delete division
        function deleteDivision(code) {
            if (confirm('Are you sure you want to delete this division?')) {
                const rows = document.querySelectorAll('#divisionTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === code) {
                        row.remove();
                    }
                });
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#divisionTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
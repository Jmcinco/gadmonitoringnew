<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management - GAD Management System</title>
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
                            <i class="bi bi-people"></i> Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="division.html">Division</a></li>
                            <li><a class="dropdown-item active" href="employee.html">Employee</a></li>
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
                <li class="breadcrumb-item active">Employee Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-people text-primary"></i> Employee Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                        <i class="bi bi-plus-circle"></i> Add New Employee
                    </button>
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
                                <label for="filterPosition" class="form-label">Position</label>
                                <select class="form-select" id="filterPosition">
                                    <option value="">All Positions</option>
                                    <option value="Manager">Manager</option>
                                    <option value="Supervisor">Supervisor</option>
                                    <option value="Officer">Officer</option>
                                    <option value="Assistant">Assistant</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterRole" class="form-label">Role</label>
                                <select class="form-select" id="filterRole">
                                    <option value="">All Roles</option>
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                    <option value="Reviewer">Reviewer</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="searchInput" class="form-label">Search</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search employees..." id="searchInput">
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

        <!-- Employee Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Employee List</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Division</th>
                                        <th>Position</th>
                                        <th>Role</th>
                                        <th>Gender</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="employeeTableBody">
                                    <tr>
                                        <td>EMP001</td>
                                        <td>Maria Santos</td>
                                        <td>maria.santos@example.com</td>
                                        <td>HR</td>
                                        <td>Manager</td>
                                        <td><span class="badge bg-primary">Admin</span></td>
                                        <td>Female</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editEmployee('EMP001')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEmployee('EMP001')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>EMP002</td>
                                        <td>John Dela Cruz</td>
                                        <td>john.delacruz@example.com</td>
                                        <td>IT</td>
                                        <td>Supervisor</td>
                                        <td><span class="badge bg-secondary">User</span></td>
                                        <td>Male</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editEmployee('EMP002')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEmployee('EMP002')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>EMP003</td>
                                        <td>Ana Reyes</td>
                                        <td>ana.reyes@example.com</td>
                                        <td>FIN</td>
                                        <td>Officer</td>
                                        <td><span class="badge bg-info">Reviewer</span></td>
                                        <td>Female</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editEmployee('EMP003')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEmployee('EMP003')">
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

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEmployeeModalLabel">
                        <i class="bi bi-plus-circle"></i> Add New Employee
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addEmployeeForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employeeId" class="form-label">Employee ID *</label>
                                    <input type="text" class="form-control" id="employeeId" name="employeeId" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid employee ID.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email address.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="firstName" class="form-label">First Name *</label>
                                    <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid first name.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="lastName" class="form-label">Last Name *</label>
                                    <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid last name.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position *</label>
                                    <select class="form-select" id="position" name="position" required>
                                        <option value="">Select Position</option>
                                        <option value="Manager">Manager</option>
                                        <option value="Supervisor">Supervisor</option>
                                        <option value="Officer">Officer</option>
                                        <option value="Assistant">Assistant</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a position.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role *</label>
                                    <select class="form-select" id="role" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="Admin">Admin</option>
                                        <option value="User">User</option>
                                        <option value="Reviewer">Reviewer</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a role.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender *</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a gender.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control" id="password" name="password" required minlength="6">
                            <div class="invalid-feedback">
                                Password must be at least 6 characters long.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addEmployeeForm" class="btn btn-primary">Save Employee</button>
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
            addEmployeeToTable(formData);
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add employee to table
        function addEmployeeToTable(formData) {
            const tableBody = document.getElementById('employeeTableBody');
            const newRow = document.createElement('tr');
            
            const employeeId = formData.get('employeeId');
            const firstName = formData.get('firstName');
            const lastName = formData.get('lastName');
            const email = formData.get('email');
            const division = formData.get('division');
            const position = formData.get('position');
            const role = formData.get('role');
            const gender = formData.get('gender');
            
            const roleBadgeClass = role === 'Admin' ? 'bg-primary' : role === 'Reviewer' ? 'bg-info' : 'bg-secondary';
            
            newRow.innerHTML = `
                <td>${employeeId}</td>
                <td>${firstName} ${lastName}</td>
                <td>${email}</td>
                <td>${division}</td>
                <td>${position}</td>
                <td><span class="badge ${roleBadgeClass}">${role}</span></td>
                <td>${gender}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editEmployee('${employeeId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteEmployee('${employeeId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit employee
        function editEmployee(id) {
            alert('Edit employee functionality would be implemented here.');
        }

        // Delete employee
        function deleteEmployee(id) {
            if (confirm('Are you sure you want to delete this employee?')) {
                const rows = document.querySelectorAll('#employeeTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === id) {
                        row.remove();
                    }
                });
            }
        }

        // Search and filter functionality
        function setupFilters() {
            const searchInput = document.getElementById('searchInput');
            const filterDivision = document.getElementById('filterDivision');
            const filterPosition = document.getElementById('filterPosition');
            const filterRole = document.getElementById('filterRole');
            
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const divisionFilter = filterDivision.value;
                const positionFilter = filterPosition.value;
                const roleFilter = filterRole.value;
                
                const rows = document.querySelectorAll('#employeeTableBody tr');
                
                rows.forEach(row => {
                    const cells = row.cells;
                    const name = cells[1].textContent.toLowerCase();
                    const email = cells[2].textContent.toLowerCase();
                    const division = cells[3].textContent;
                    const position = cells[4].textContent;
                    const role = cells[5].textContent;
                    
                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesDivision = !divisionFilter || division === divisionFilter;
                    const matchesPosition = !positionFilter || position === positionFilter;
                    const matchesRole = !roleFilter || role.includes(roleFilter);
                    
                    const shouldShow = matchesSearch && matchesDivision && matchesPosition && matchesRole;
                    row.style.display = shouldShow ? '' : 'none';
                });
            }
            
            searchInput.addEventListener('input', filterTable);
            filterDivision.addEventListener('change', filterTable);
            filterPosition.addEventListener('change', filterTable);
            filterRole.addEventListener('change', filterTable);
        }
        
        // Initialize filters
        setupFilters();
    </script>
</body>
</html>
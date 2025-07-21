<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Position Management - GAD Management System</title>
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
                        <a class="nav-link" href="dashboard.php">
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
                            <li><a class="dropdown-item active" href="position.html">Position</a></li>
                            <li><a class="dropdown-item" href="mfo.html">MFO/PAP</a></li>
                            <li><a class="dropdown-item" href="object_of_expense.html">Object of Expense</a></li>
                            <li><a class="dropdown-item" href="source_of_fund.html">Source of Fund</a></li>
                            <li><a class="dropdown-item" href="gad_mandate.html">GAD Mandate</a></li>
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
                <li class="breadcrumb-item active">Position Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-person-badge text-primary"></i> Position Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPositionModal">
                        <i class="bi bi-plus-circle"></i> Add Position
                    </button>
                </div>
            </div>
        </div>

        <!-- Position Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Position Records</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search position..." id="searchInput">
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
                                        <th>Position ID</th>
                                        <th>Position Code</th>
                                        <th>Position Title</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="positionTableBody">
                                    <tr>
                                        <td>POS001</td>
                                        <td>DIV-HEAD</td>
                                        <td>Division Head</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPosition('POS001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('POS001')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>POS002</td>
                                        <td>ASST-HEAD</td>
                                        <td>Assistant Division Head</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPosition('POS002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('POS002')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>POS003</td>
                                        <td>HR-SPEC</td>
                                        <td>Human Resource Specialist</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPosition('POS003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('POS003')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>POS004</td>
                                        <td>GAD-COORD</td>
                                        <td>GAD Coordinator</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPosition('POS004')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('POS004')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>POS005</td>
                                        <td>ADMIN-OFF</td>
                                        <td>Administrative Officer</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editPosition('POS005')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('POS005')">
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

    <!-- Add Position Modal -->
    <div class="modal fade" id="addPositionModal" tabindex="-1" aria-labelledby="addPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPositionModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New Position
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPositionForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="positionId" class="form-label">Position ID *</label>
                            <input type="text" class="form-control" id="positionId" name="positionId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="positionCode" class="form-label">Position Code *</label>
                            <input type="text" class="form-control" id="positionCode" name="positionCode" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position Code.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="positionTitle" class="form-label">Position Title *</label>
                            <input type="text" class="form-control" id="positionTitle" name="positionTitle" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position Title.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addPositionForm" class="btn btn-primary">Create Position</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Position Modal -->
    <div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPositionModalLabel">
                        <i class="bi bi-pencil"></i> Edit Position
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPositionForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editPositionOriginalId" name="editPositionOriginalId">
                        <div class="mb-3">
                            <label for="editPositionId" class="form-label">Position ID *</label>
                            <input type="text" class="form-control" id="editPositionId" name="editPositionId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPositionCode" class="form-label">Position Code *</label>
                            <input type="text" class="form-control" id="editPositionCode" name="editPositionCode" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position Code.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPositionTitle" class="form-label">Position Title *</label>
                            <input type="text" class="form-control" id="editPositionTitle" name="editPositionTitle" required>
                            <div class="invalid-feedback">
                                Please provide a valid Position Title.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editPositionForm" class="btn btn-primary">Update Position</button>
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
            }, false);
        })();

        // Handle form submission
        function handleFormSubmit(form) {
            const formData = new FormData(form);
            const formId = form.id;
            
            if (formId === 'addPositionForm') {
                addPositionToTable(formData);
            } else if (formId === 'editPositionForm') {
                updatePositionInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add Position to table
        function addPositionToTable(formData) {
            const tableBody = document.getElementById('positionTableBody');
            const newRow = document.createElement('tr');
            const positionId = formData.get('positionId');
            const positionCode = formData.get('positionCode');
            const positionTitle = formData.get('positionTitle');
            
            newRow.innerHTML = `
                <td>${positionId}</td>
                <td>${positionCode}</td>
                <td>${positionTitle}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editPosition('${positionId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('${positionId}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit Position
        function editPosition(positionId) {
            const modal = new bootstrap.Modal(document.getElementById('editPositionModal'));
            const rows = document.querySelectorAll('#positionTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === positionId) {
                    document.getElementById('editPositionOriginalId').value = positionId;
                    document.getElementById('editPositionId').value = row.cells[0].textContent;
                    document.getElementById('editPositionCode').value = row.cells[1].textContent;
                    document.getElementById('editPositionTitle').value = row.cells[2].textContent;
                }
            });
            
            modal.show();
        }

        // Update Position in table
        function updatePositionInTable(formData) {
            const originalId = formData.get('editPositionOriginalId');
            const newPositionId = formData.get('editPositionId');
            const positionCode = formData.get('editPositionCode');
            const positionTitle = formData.get('editPositionTitle');
            
            const rows = document.querySelectorAll('#positionTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === originalId) {
                    row.cells[0].textContent = newPositionId;
                    row.cells[1].textContent = positionCode;
                    row.cells[2].textContent = positionTitle;
                    
                    // Update action buttons
                    row.cells[3].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editPosition('${newPositionId}')">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deletePosition('${newPositionId}')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    `;
                }
            });
        }

        // Delete Position
        function deletePosition(positionId) {
            if (confirm('Are you sure you want to delete this position?')) {
                const rows = document.querySelectorAll('#positionTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === positionId) {
                        row.remove();
                    }
                });
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#positionTableBody tr');
            
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
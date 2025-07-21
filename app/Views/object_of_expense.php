<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Object of Expense Management - GAD Management System</title>
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
                            <i class="bi bi-gear"></i> Master Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="division.html">Division</a></li>
                            <li><a class="dropdown-item" href="employee.html">Employee</a></li>
                            <li><a class="dropdown-item" href="position.html">Position</a></li>
                            <li><a class="dropdown-item" href="mfo.html">MFO/PAP</a></li>
                            <li><a class="dropdown-item active" href="object_of_expense.html">Object of Expense</a></li>
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
                <li class="breadcrumb-item active">Object of Expense Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-cash-stack text-primary"></i> Object of Expense Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addObjectModal">
                        <i class="bi bi-plus-circle"></i> Add Object of Expense
                    </button>
                </div>
            </div>
        </div>

        <!-- Object of Expense Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Object of Expense Records</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search object of expense..." id="searchInput">
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
                                        <th>Object of Expense ID</th>
                                        <th>Object of Expense Description</th>
                                        <th>UACS Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="objectTableBody">
                                    <tr>
                                        <td>OBJ001</td>
                                        <td>Personal Services - Regular</td>
                                        <td>5010101000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editObject('OBJ001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('OBJ001')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OBJ002</td>
                                        <td>Training and Scholarship Expenses</td>
                                        <td>5020201000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editObject('OBJ002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('OBJ002')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OBJ003</td>
                                        <td>Office Supplies and Materials</td>
                                        <td>5020301000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editObject('OBJ003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('OBJ003')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OBJ004</td>
                                        <td>Communication and Internet Services</td>
                                        <td>5020202000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editObject('OBJ004')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('OBJ004')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>OBJ005</td>
                                        <td>Consultancy Services</td>
                                        <td>5020203000</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editObject('OBJ005')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('OBJ005')">
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

    <!-- Add Object Modal -->
    <div class="modal fade" id="addObjectModal" tabindex="-1" aria-labelledby="addObjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addObjectModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New Object of Expense
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addObjectForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="objectId" class="form-label">Object of Expense ID *</label>
                            <input type="text" class="form-control" id="objectId" name="objectId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Object of Expense ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="objectDescription" class="form-label">Object of Expense Description *</label>
                            <textarea class="form-control" id="objectDescription" name="objectDescription" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide a valid Object of Expense Description.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="uacsCode" class="form-label">UACS Code *</label>
                            <input type="text" class="form-control" id="uacsCode" name="uacsCode" required>
                            <div class="invalid-feedback">
                                Please provide a valid UACS Code.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addObjectForm" class="btn btn-primary">Create Object of Expense</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Object Modal -->
    <div class="modal fade" id="editObjectModal" tabindex="-1" aria-labelledby="editObjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editObjectModalLabel">
                        <i class="bi bi-pencil"></i> Edit Object of Expense
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editObjectForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editObjectOriginalId" name="editObjectOriginalId">
                        <div class="mb-3">
                            <label for="editObjectId" class="form-label">Object of Expense ID *</label>
                            <input type="text" class="form-control" id="editObjectId" name="editObjectId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Object of Expense ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editObjectDescription" class="form-label">Object of Expense Description *</label>
                            <textarea class="form-control" id="editObjectDescription" name="editObjectDescription" rows="3" required></textarea>
                            <div class="invalid-feedback">
                                Please provide a valid Object of Expense Description.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editUacsCode" class="form-label">UACS Code *</label>
                            <input type="text" class="form-control" id="editUacsCode" name="editUacsCode" required>
                            <div class="invalid-feedback">
                                Please provide a valid UACS Code.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editObjectForm" class="btn btn-primary">Update Object of Expense</button>
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
            
            if (formId === 'addObjectForm') {
                addObjectToTable(formData);
            } else if (formId === 'editObjectForm') {
                updateObjectInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add Object to table
        function addObjectToTable(formData) {
            const tableBody = document.getElementById('objectTableBody');
            const newRow = document.createElement('tr');
            const objectId = formData.get('objectId');
            const objectDescription = formData.get('objectDescription');
            const uacsCode = formData.get('uacsCode');
            
            newRow.innerHTML = `
                <td>${objectId}</td>
                <td>${objectDescription}</td>
                <td>${uacsCode}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editObject('${objectId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('${objectId}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit Object
        function editObject(objectId) {
            const modal = new bootstrap.Modal(document.getElementById('editObjectModal'));
            const rows = document.querySelectorAll('#objectTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === objectId) {
                    document.getElementById('editObjectOriginalId').value = objectId;
                    document.getElementById('editObjectId').value = row.cells[0].textContent;
                    document.getElementById('editObjectDescription').value = row.cells[1].textContent;
                    document.getElementById('editUacsCode').value = row.cells[2].textContent;
                }
            });
            
            modal.show();
        }

        // Update Object in table
        function updateObjectInTable(formData) {
            const originalId = formData.get('editObjectOriginalId');
            const newObjectId = formData.get('editObjectId');
            const objectDescription = formData.get('editObjectDescription');
            const uacsCode = formData.get('editUacsCode');
            
            const rows = document.querySelectorAll('#objectTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === originalId) {
                    row.cells[0].textContent = newObjectId;
                    row.cells[1].textContent = objectDescription;
                    row.cells[2].textContent = uacsCode;
                    
                    // Update action buttons
                    row.cells[3].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editObject('${newObjectId}')">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteObject('${newObjectId}')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    `;
                }
            });
        }

        // Delete Object
        function deleteObject(objectId) {
            if (confirm('Are you sure you want to delete this object of expense?')) {
                const rows = document.querySelectorAll('#objectTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === objectId) {
                        row.remove();
                    }
                });
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#objectTableBody tr');
            
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
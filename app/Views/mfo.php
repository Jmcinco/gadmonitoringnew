<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MFO & PAP Management - GAD Management System</title>
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
                            <li><a class="dropdown-item active" href="mfo.html">MFO/PAP</a></li>
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
                <li class="breadcrumb-item active">MFO & PAP Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-bullseye text-primary"></i> MFO & PAP Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMfoModal">
                        <i class="bi bi-plus-circle"></i> Add MFO/PAP
                    </button>
                </div>
            </div>
        </div>

        <!-- MFO/PAP Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">MFO/PAP Records</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search MFO/PAP..." id="searchInput">
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
                                        <th>MFO ID</th>
                                        <th>Cost Structure</th>
                                        <th>MFO / PAP</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="mfoTableBody">
                                    <tr>
                                        <td>MFO001</td>
                                        <td>Human Resource Development</td>
                                        <td>Gender Sensitivity Training Program for all employees to enhance awareness and promote inclusive workplace practices</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editMfo('MFO001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('MFO001')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MFO002</td>
                                        <td>Policy Development</td>
                                        <td>Development and implementation of gender-responsive policies and guidelines</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editMfo('MFO002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('MFO002')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MFO003</td>
                                        <td>Capacity Building</td>
                                        <td>Women's leadership development and empowerment programs</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editMfo('MFO003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('MFO003')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>MFO004</td>
                                        <td>Advocacy and Communication</td>
                                        <td>Anti-sexual harassment awareness campaigns and prevention programs</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editMfo('MFO004')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('MFO004')">
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

    <!-- Add MFO Modal -->
    <div class="modal fade" id="addMfoModal" tabindex="-1" aria-labelledby="addMfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMfoModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New MFO/PAP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMfoForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="mfoId" class="form-label">MFO ID *</label>
                            <input type="text" class="form-control" id="mfoId" name="mfoId" required>
                            <div class="invalid-feedback">
                                Please provide a valid MFO ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="costStructure" class="form-label">Cost Structure *</label>
                            <input type="text" class="form-control" id="costStructure" name="costStructure" required>
                            <div class="invalid-feedback">
                                Please provide a valid cost structure.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="mfoPap" class="form-label">MFO / PAP *</label>
                            <textarea class="form-control" id="mfoPap" name="mfoPap" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide a valid MFO/PAP description.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addMfoForm" class="btn btn-primary">Create MFO/PAP</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit MFO Modal -->
    <div class="modal fade" id="editMfoModal" tabindex="-1" aria-labelledby="editMfoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMfoModalLabel">
                        <i class="bi bi-pencil"></i> Edit MFO/PAP
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editMfoForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editMfoOriginalId" name="editMfoOriginalId">
                        <div class="mb-3">
                            <label for="editMfoId" class="form-label">MFO ID *</label>
                            <input type="text" class="form-control" id="editMfoId" name="editMfoId" required>
                            <div class="invalid-feedback">
                                Please provide a valid MFO ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editCostStructure" class="form-label">Cost Structure *</label>
                            <input type="text" class="form-control" id="editCostStructure" name="editCostStructure" required>
                            <div class="invalid-feedback">
                                Please provide a valid cost structure.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editMfoPap" class="form-label">MFO / PAP *</label>
                            <textarea class="form-control" id="editMfoPap" name="editMfoPap" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide a valid MFO/PAP description.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editMfoForm" class="btn btn-primary">Update MFO/PAP</button>
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
            
            if (formId === 'addMfoForm') {
                addMfoToTable(formData);
            } else if (formId === 'editMfoForm') {
                updateMfoInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add MFO to table
        function addMfoToTable(formData) {
            const tableBody = document.getElementById('mfoTableBody');
            const newRow = document.createElement('tr');
            const mfoId = formData.get('mfoId');
            const costStructure = formData.get('costStructure');
            const mfoPap = formData.get('mfoPap');
            
            newRow.innerHTML = `
                <td>${mfoId}</td>
                <td>${costStructure}</td>
                <td>${mfoPap}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editMfo('${mfoId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('${mfoId}')">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit MFO
        function editMfo(mfoId) {
            const modal = new bootstrap.Modal(document.getElementById('editMfoModal'));
            const rows = document.querySelectorAll('#mfoTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === mfoId) {
                    document.getElementById('editMfoOriginalId').value = mfoId;
                    document.getElementById('editMfoId').value = row.cells[0].textContent;
                    document.getElementById('editCostStructure').value = row.cells[1].textContent;
                    document.getElementById('editMfoPap').value = row.cells[2].textContent;
                }
            });
            
            modal.show();
        }

        // Update MFO in table
        function updateMfoInTable(formData) {
            const originalId = formData.get('editMfoOriginalId');
            const newMfoId = formData.get('editMfoId');
            const costStructure = formData.get('editCostStructure');
            const mfoPap = formData.get('editMfoPap');
            
            const rows = document.querySelectorAll('#mfoTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === originalId) {
                    row.cells[0].textContent = newMfoId;
                    row.cells[1].textContent = costStructure;
                    row.cells[2].textContent = mfoPap;
                    
                    // Update action buttons
                    row.cells[3].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editMfo('${newMfoId}')">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteMfo('${newMfoId}')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    `;
                }
            });
        }

        // Delete MFO
        function deleteMfo(mfoId) {
            if (confirm('Are you sure you want to delete this MFO/PAP?')) {
                const rows = document.querySelectorAll('#mfoTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === mfoId) {
                        row.remove();
                    }
                });
            }
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#mfoTableBody tr');
            
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Source of Fund Management - GAD Management System</title>
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
                            <li><a class="dropdown-item" href="object_of_expense.html">Object of Expense</a></li>
                            <li><a class="dropdown-item active" href="source_of_fund.html">Source of Fund</a></li>
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
                <li class="breadcrumb-item active">Source of Fund Management</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-bank text-primary"></i> Source of Fund Management
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSourceModal">
                        <i class="bi bi-plus-circle"></i> Add Source of Fund
                    </button>
                </div>
            </div>
        </div>

        <!-- Source of Fund Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Source of Fund Records</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search source of fund..." id="searchInput">
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
                                        <th>Source ID</th>
                                        <th>Source Name</th>
                                        <th>Fund Cluster</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="sourceTableBody">
                                    <tr>
                                        <td>SRC001</td>
                                        <td>Regular Agency Fund</td>
                                        <td>01 - Regular Agency Fund</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editSource('SRC001')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SRC002</td>
                                        <td>Special Purpose Fund</td>
                                        <td>02 - Special Purpose Fund</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editSource('SRC002')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SRC003</td>
                                        <td>Trust Fund</td>
                                        <td>03 - Trust Fund</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editSource('SRC003')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SRC004</td>
                                        <td>Development Fund</td>
                                        <td>04 - Development Fund</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editSource('SRC004')">
                                                <i class="bi bi-pencil"></i> Edit
                                            </button>
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>SRC005</td>
                                        <td>GAD Budget</td>
                                        <td>05 - GAD Allocation</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="editSource('SRC005')">
                                                <i class="bi bi-pencil"></i> Edit
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

    <!-- Add Source Modal -->
    <div class="modal fade" id="addSourceModal" tabindex="-1" aria-labelledby="addSourceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSourceModalLabel">
                        <i class="bi bi-plus-circle"></i> Create New Source of Fund
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addSourceForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="sourceId" class="form-label">Source ID *</label>
                            <input type="text" class="form-control" id="sourceId" name="sourceId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Source ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="sourceName" class="form-label">Source Name *</label>
                            <input type="text" class="form-control" id="sourceName" name="sourceName" required>
                            <div class="invalid-feedback">
                                Please provide a valid Source Name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="fundCluster" class="form-label">Fund Cluster *</label>
                            <input type="text" class="form-control" id="fundCluster" name="fundCluster" required>
                            <div class="invalid-feedback">
                                Please provide a valid Fund Cluster.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addSourceForm" class="btn btn-primary">Create Source of Fund</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Source Modal -->
    <div class="modal fade" id="editSourceModal" tabindex="-1" aria-labelledby="editSourceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSourceModalLabel">
                        <i class="bi bi-pencil"></i> Edit Source of Fund
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSourceForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editSourceOriginalId" name="editSourceOriginalId">
                        <div class="mb-3">
                            <label for="editSourceId" class="form-label">Source ID *</label>
                            <input type="text" class="form-control" id="editSourceId" name="editSourceId" required>
                            <div class="invalid-feedback">
                                Please provide a valid Source ID.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editSourceName" class="form-label">Source Name *</label>
                            <input type="text" class="form-control" id="editSourceName" name="editSourceName" required>
                            <div class="invalid-feedback">
                                Please provide a valid Source Name.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editFundCluster" class="form-label">Fund Cluster *</label>
                            <input type="text" class="form-control" id="editFundCluster" name="editFundCluster" required>
                            <div class="invalid-feedback">
                                Please provide a valid Fund Cluster.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editSourceForm" class="btn btn-primary">Update Source of Fund</button>
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
            
            if (formId === 'addSourceForm') {
                addSourceToTable(formData);
            } else if (formId === 'editSourceForm') {
                updateSourceInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add Source to table
        function addSourceToTable(formData) {
            const tableBody = document.getElementById('sourceTableBody');
            const newRow = document.createElement('tr');
            const sourceId = formData.get('sourceId');
            const sourceName = formData.get('sourceName');
            const fundCluster = formData.get('fundCluster');
            
            newRow.innerHTML = `
                <td>${sourceId}</td>
                <td>${sourceName}</td>
                <td>${fundCluster}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editSource('${sourceId}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit Source
        function editSource(sourceId) {
            const modal = new bootstrap.Modal(document.getElementById('editSourceModal'));
            const rows = document.querySelectorAll('#sourceTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === sourceId) {
                    document.getElementById('editSourceOriginalId').value = sourceId;
                    document.getElementById('editSourceId').value = row.cells[0].textContent;
                    document.getElementById('editSourceName').value = row.cells[1].textContent;
                    document.getElementById('editFundCluster').value = row.cells[2].textContent;
                }
            });
            
            modal.show();
        }

        // Update Source in table
        function updateSourceInTable(formData) {
            const originalId = formData.get('editSourceOriginalId');
            const newSourceId = formData.get('editSourceId');
            const sourceName = formData.get('editSourceName');
            const fundCluster = formData.get('editFundCluster');
            
            const rows = document.querySelectorAll('#sourceTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === originalId) {
                    row.cells[0].textContent = newSourceId;
                    row.cells[1].textContent = sourceName;
                    row.cells[2].textContent = fundCluster;
                    
                    // Update action buttons
                    row.cells[3].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editSource('${newSourceId}')">
                            <i class="bi bi-pencil"></i> Edit
                        </button>
                    `;
                }
            });
        }

        

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#sourceTableBody tr');
            
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
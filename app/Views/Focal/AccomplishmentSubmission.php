<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Submission - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-primary-rgb: 36, 20, 68;
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
        }
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #1a252f 100%);
            color: white;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175);
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }
        .sidebar-content {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }
        .sidebar-footer {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .user-info {
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: white;
            transform: translateX(3px);
        }
        .sidebar .nav-link.active {
            background-color: #3498db;
            color: white;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 2rem;
            background-color: #fafbfe;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }
        .table th, .table td {
            vertical-align: middle;
            padding: 0.75rem;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .form-label {
            font-weight: 600;
        }
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            .table-responsive {
                font-size: 0.85rem;
            }
            .table th, .table td {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-shield-check"></i> GAD Management System
            </h4>
        </div>
        
        <div class="sidebar-content">
            <!-- User Info -->
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold">Admin User</div>
                        <small class="text-light">Administrator</small>
                    </div>
                </div>
            </div>
            
            <!-- Navigation Menu -->
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('FocalDashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/PlanPreparation') ?>">
                        <i class="bi bi-clipboard-plus me-2"></i>Preparation of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/BudgetCrafting') ?>">
                        <i class="bi bi-calculator me-2"></i>Budget Crafting
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/PlanReview') ?>">
                        <i class="bi bi-check-circle me-2"></i>Review & Approval of GAD Plan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ConsolidatedPlan') ?>">
                        <i class="bi bi-file-earmark-text me-2"></i>Consolidated Plan & Budget
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">
                        <i class="bi bi-send me-2"></i>Submission of GAD Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ReviewApproval') ?>">
                        <i class="bi bi-clipboard-check me-2"></i>Review & Approval of Accomplishment
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Focal/ConsolidatedAccomplishment') ?>">
                        <i class="bi bi-collection me-2"></i>Consolidated GAD Accomplishment
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Logout Button -->
        <div class="sidebar-footer">
            <a href="index.html" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="bg-light">
                <div class="container-fluid">
                    <ol class="breadcrumb py-2 mb-4">
                        <li class="breadcrumb-item"><a href="dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">GAD Accomplishment Submission</li>
                    </ol>
                </div>
            </nav>

            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-cloud-upload text-primary"></i> GAD Accomplishment Submission
                        </h1>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccomplishmentModal">
                            <i class="bi bi-plus-circle"></i> Submit New Accomplishment
                        </button>
                    </div>
                </div>
            </div>

            <!-- Accomplishment Submission Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="mb-0">GAD Accomplishments by Office</h5>
                                </div>
                                <div class="col-auto">
                                    <div class="input-group">
                                        <select class="form-select" onchange="filterByStatus(this.value)">
                                            <option value="">All Status</option>
                                            <option value="Draft">Draft</option>
                                            <option value="Submitted">Submitted</option>
                                            <option value="Under Review">Under Review</option>
                                            <option value="Accepted">Accepted</option>
                                            <option value="Returned">Returned</option>
                                        </select>
                                        <input type="text" class="form-control" placeholder="Search..." id="searchInput">
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
                                            <th>GAD Activity ID</th>
                                            <th>Office</th>
                                            <th>Actual Accomplishment</th>
                                            <th>Date Accomplished</th>
                                            <th>File Upload</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="accomplishmentTableBody">
                                        <tr data-status="submitted">
                                            <td>GAD001</td>
                                            <td>Human Resources Division</td>
                                            <td>Completed Gender Sensitivity Training for 120 employees (exceeded target of 100)</td>
                                            <td>2024-03-15</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i> View</a></td>
                                            <td><span class="badge bg-primary">Submitted</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('GAD001')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('GAD001')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-status="under review">
                                            <td>GAD002</td>
                                            <td>Training Division</td>
                                            <td>Conducted Women's Leadership Workshop with 45 participants</td>
                                            <td>2024-04-10</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i> View</a></td>
                                            <td><span class="badge bg-warning">Under Review</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('GAD002')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('GAD002')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-status="accepted">
                                            <td>GAD003</td>
                                            <td>Legal Affairs Division</td>
                                            <td>Launched Anti-Sexual Harassment Campaign agency-wide</td>
                                            <td>2024-05-20</td>
                                            <td><a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i> View</a></td>
                                            <td><span class="badge bg-success">Accepted</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('GAD003')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewAccomplishment('GAD003')">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr data-status="draft">
                                            <td>GAD004</td>
                                            <td>Policy Development Unit</td>
                                            <td>Drafted Work-Life Balance Policy Framework</td>
                                            <td>2024-06-15</td>
                                            <td><span class="text-muted">No file</span></td>
                                            <td><span class="badge bg-secondary">Draft</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('GAD004')">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" onclick="submitAccomplishment('GAD004')">
                                                    <i class="bi bi-send"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('GAD004')">
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
    </div>

    <!-- Add Accomplishment Modal -->
    <div class="modal fade" id="addAccomplishmentModal" tabindex="-1" aria-labelledby="addAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccomplishmentModalLabel">
                        <i class="bi bi-plus-circle"></i> Submit New Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccomplishmentForm" class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gadActivityId" class="form-label">GAD Activity ID *</label>
                                    <select class="form-select" id="gadActivityId" name="gadActivityId" required>
                                        <option value="">Select GAD Activity</option>
                                        <option value="GAD001">GAD001 - Gender Sensitivity Training</option>
                                        <option value="GAD002">GAD002 - Women's Leadership Workshop</option>
                                        <option value="GAD003">GAD003 - Anti-Sexual Harassment Campaign</option>
                                        <option value="GAD004">GAD004 - Work-Life Balance Policy</option>
                                        <option value="GAD005">GAD005 - Gender Mainstreaming Training</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a GAD Activity.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="office" class="form-label">Office *</label>
                                    <select class="form-select" id="office" name="office" required>
                                        <option value="">Select Office</option>
                                        <option value="Human Resources Division">Human Resources Division</option>
                                        <option value="Training Division">Training Division</option>
                                        <option value="Legal Affairs Division">Legal Affairs Division</option>
                                        <option value="Policy Development Unit">Policy Development Unit</option>
                                        <option value="Information Technology Division">Information Technology Division</option>
                                        <option value="Finance Division">Finance Division</option>
                                        <option value="Administration Division">Administration Division</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an office.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="actualAccomplishment" class="form-label">Actual Accomplishment *</label>
                            <textarea class="form-control" id="actualAccomplishment" name="actualAccomplishment" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="dateAccomplished" name="dateAccomplished" required>
                                    <div class="invalid-feedback">
                                        Please provide the date accomplished.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="Draft">Draft</option>
                                        <option value="Submitted">Submitted</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">File Upload</label>
                            <input type="file" class="form-control" id="fileUpload" name="fileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="additionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="additionalRemarks" name="additionalRemarks" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary" onclick="saveAsDraft()">Save as Draft</button>
                    <button type="submit" form="addAccomplishmentForm" class="btn btn-primary">Submit Accomplishment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Accomplishment Modal -->
    <div class="modal fade" id="editAccomplishmentModal" tabindex="-1" aria-labelledby="editAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccomplishmentModalLabel">
                        <i class="bi bi-pencil"></i> Edit Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAccomplishmentForm" class="needs-validation" novalidate>
                        <input type="hidden" id="editAccomplishmentId" name="editAccomplishmentId">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editGadActivityId" class="form-label">GAD Activity ID *</label>
                                    <select class="form-select" id="editGadActivityId" name="editGadActivityId" required>
                                        <option value="">Select GAD Activity</option>
                                        <option value="GAD001">GAD001 - Gender Sensitivity Training</option>
                                        <option value="GAD002">GAD002 - Women's Leadership Workshop</option>
                                        <option value="GAD003">GAD003 - Anti-Sexual Harassment Campaign</option>
                                        <option value="GAD004">GAD004 - Work-Life Balance Policy</option>
                                        <option value="GAD005">GAD005 - Gender Mainstreaming Training</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a GAD Activity.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editOffice" class="form-label">Office *</label>
                                    <select class="form-select" id="editOffice" name="editOffice" required>
                                        <option value="">Select Office</option>
                                        <option value="Human Resources Division">Human Resources Division</option>
                                        <option value="Training Division">Training Division</option>
                                        <option value="Legal Affairs Division">Legal Affairs Division</option>
                                        <option value="Policy Development Unit">Policy Development Unit</option>
                                        <option value="Information Technology Division">Information Technology Division</option>
                                        <option value="Finance Division">Finance Division</option>
                                        <option value="Administration Division">Administration Division</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an office.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editActualAccomplishment" class="form-label">Actual Accomplishment *</label>
                            <textarea class="form-control" id="editActualAccomplishment" name="editActualAccomplishment" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="editDateAccomplished" name="editDateAccomplished" required>
                                    <div class="invalid-feedback">
                                        Please provide the date accomplished.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editStatus" class="form-label">Status *</label>
                                    <select class="form-select" id="editStatus" name="editStatus" required>
                                        <option value="">Select Status</option>
                                        <option value="Draft">Draft</option>
                                        <option value="Submitted">Submitted</option>
                                        <option value="Under Review">Under Review</option>
                                        <option value="Accepted">Accepted</option>
                                        <option value="Returned">Returned</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a status.
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editFileUpload" class="form-label">File Upload</label>
                            <input type="file" class="form-control" id="editFileUpload" name="editFileUpload" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="editAdditionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="editAdditionalRemarks" name="editAdditionalRemarks" rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editAccomplishmentForm" class="btn btn-primary">Update Accomplishment</button>
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
            
            if (formId === 'addAccomplishmentForm') {
                addAccomplishmentToTable(formData);
            } else if (formId === 'editAccomplishmentForm') {
                updateAccomplishmentInTable(formData);
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Add accomplishment to table
        function addAccomplishmentToTable(formData) {
            const tableBody = document.getElementById('accomplishmentTableBody');
            const newRow = document.createElement('tr');
            const gadActivityId = formData.get('gadActivityId');
            const office = formData.get('office');
            const actualAccomplishment = formData.get('actualAccomplishment');
            const dateAccomplished = formData.get('dateAccomplished');
            const status = formData.get('status');
            
            let statusBadge = '';
            if (status === 'Draft') statusBadge = '<span class="badge bg-secondary">Draft</span>';
            else if (status === 'Submitted') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Under Review') statusBadge = '<span class="badge bg-warning">Under Review</span>';
            else if (status === 'Accepted') statusBadge = '<span class="badge bg-success">Accepted</span>';
            else if (status === 'Returned') statusBadge = '<span class="badge bg-danger">Returned</span>';
            
            newRow.dataset.status = status.toLowerCase();
            newRow.innerHTML = `
                <td>${gadActivityId}</td>
                <td>${office}</td>
                <td>${actualAccomplishment}</td>
                <td>${dateAccomplished}</td>
                <td><span class="text-muted">No file</span></td>
                <td>${statusBadge}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('${gadActivityId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('${gadActivityId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            `;
            
            tableBody.appendChild(newRow);
        }

        // Edit accomplishment
        function editAccomplishment(gadActivityId) {
            const modal = new bootstrap.Modal(document.getElementById('editAccomplishmentModal'));
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    document.getElementById('editAccomplishmentId').value = gadActivityId;
                    document.getElementById('editGadActivityId').value = row.cells[0].textContent;
                    document.getElementById('editOffice').value = row.cells[1].textContent;
                    document.getElementById('editActualAccomplishment').value = row.cells[2].textContent;
                    document.getElementById('editDateAccomplished').value = row.cells[3].textContent;
                    
                    // Set status
                    const statusText = row.cells[5].textContent.trim();
                    document.getElementById('editStatus').value = statusText;
                }
            });
            
            modal.show();
        }

        // Update accomplishment in table
        function updateAccomplishmentInTable(formData) {
            const gadActivityId = formData.get('editAccomplishmentId');
            const newGadActivityId = formData.get('editGadActivityId');
            const office = formData.get('editOffice');
            const actualAccomplishment = formData.get('editActualAccomplishment');
            const dateAccomplished = formData.get('editDateAccomplished');
            const status = formData.get('editStatus');
            
            let statusBadge = '';
            if (status === 'Draft') statusBadge = '<span class="badge bg-secondary">Draft</span>';
            else if (status === 'Submitted') statusBadge = '<span class="badge bg-primary">Submitted</span>';
            else if (status === 'Under Review') statusBadge = '<span class="badge bg-warning">Under Review</span>';
            else if (status === 'Accepted') statusBadge = '<span class="badge bg-success">Accepted</span>';
            else if (status === 'Returned') statusBadge = '<span class="badge bg-danger">Returned</span>';
            
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    row.dataset.status = status.toLowerCase();
                    row.cells[0].textContent = newGadActivityId;
                    row.cells[1].textContent = office;
                    row.cells[2].textContent = actualAccomplishment;
                    row.cells[3].textContent = dateAccomplished;
                    row.cells[5].innerHTML = statusBadge;
                    
                    // Update action buttons
                    row.cells[6].innerHTML = `
                        <button class="btn btn-sm btn-outline-primary" onclick="editAccomplishment('${newGadActivityId}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteAccomplishment('${newGadActivityId}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    `;
                }
            });
        }

        // Delete accomplishment
        function deleteAccomplishment(gadActivityId) {
            if (confirm('Are you sure you want to delete this accomplishment?')) {
                const rows = document.querySelectorAll('#accomplishmentTableBody tr');
                rows.forEach(row => {
                    if (row.cells[0].textContent === gadActivityId) {
                        row.remove();
                    }
                });
            }
        }

        // Submit accomplishment
        function submitAccomplishment(gadActivityId) {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            rows.forEach(row => {
                if (row.cells[0].textContent === gadActivityId) {
                    row.cells[5].innerHTML = '<span class="badge bg-primary">Submitted</span>';
                    row.dataset.status = 'submitted';
                }
            });
        }

        // Save as draft
        function saveAsDraft() {
            document.getElementById('status').value = 'Draft';
            document.getElementById('addAccomplishmentForm').dispatchEvent(new Event('submit'));
        }

        // View accomplishment
        function viewAccomplishment(gadActivityId) {
            alert(`View accomplishment details for ${gadActivityId}`);
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            
            rows.forEach(row => {
                if (status === '' || row.dataset.status === status.toLowerCase()) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#accomplishmentTableBody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    </script>
</body>
</html>
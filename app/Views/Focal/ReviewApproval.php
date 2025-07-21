<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Review & Approval - GAD Management System</title>
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
                            <i class="bi bi-clipboard-check"></i> Accomplishments
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="accomplishment_submission.html">Submission</a></li>
                            <li><a class="dropdown-item active" href="accomplishment_review.html">Review</a></li>
                            <li><a class="dropdown-item" href="consolidated_accomplishment.html">Consolidated</a></li>
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
                <li class="breadcrumb-item active">GAD Accomplishment Review & Approval</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-clipboard-check text-primary"></i> GAD Accomplishment Review & Approval
                    </h1>
                    <div class="btn-group">
                        <button class="btn btn-outline-primary" onclick="filterByStatus('all')">
                            <i class="bi bi-funnel"></i> All
                        </button>
                        <button class="btn btn-outline-info" onclick="filterByStatus('submitted')">
                            <i class="bi bi-inbox"></i> Submitted
                        </button>
                        <button class="btn btn-outline-success" onclick="filterByStatus('accepted')">
                            <i class="bi bi-check-circle"></i> Accepted
                        </button>
                        <button class="btn btn-outline-danger" onclick="filterByStatus('returned')">
                            <i class="bi bi-arrow-left-circle"></i> Returned
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">8</h4>
                                <p class="card-text">Total Submissions</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-inbox fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">3</h4>
                                <p class="card-text">Pending Review</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-clock fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">4</h4>
                                <p class="card-text">Accepted</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">1</h4>
                                <p class="card-text">Returned</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-arrow-left-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Review Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Submitted GAD Accomplishments</h5>
                            </div>
                            <div class="col-auto">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search accomplishments..." id="searchInput">
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
                                        <th>Accomplishment Summary</th>
                                        <th>Date Submitted</th>
                                        <th>Status</th>
                                        <th>Remarks</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="reviewTableBody">
                                    <tr data-status="submitted">
                                        <td>GAD001</td>
                                        <td>Human Resources Division</td>
                                        <td>Gender Sensitivity Training - 120 participants</td>
                                        <td>2024-03-20</td>
                                        <td><span class="badge bg-primary">Submitted</span></td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('GAD001')">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('GAD001', 'accepted')">
                                                <i class="bi bi-check"></i> Accept
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="quickUpdate('GAD001', 'returned')">
                                                <i class="bi bi-x"></i> Return
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="submitted">
                                        <td>GAD002</td>
                                        <td>Training Division</td>
                                        <td>Women's Leadership Workshop - 45 participants</td>
                                        <td>2024-04-15</td>
                                        <td><span class="badge bg-primary">Submitted</span></td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('GAD002')">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('GAD002', 'accepted')">
                                                <i class="bi bi-check"></i> Accept
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="quickUpdate('GAD002', 'returned')">
                                                <i class="bi bi-x"></i> Return
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="accepted">
                                        <td>GAD003</td>
                                        <td>Legal Affairs Division</td>
                                        <td>Anti-Sexual Harassment Campaign - Agency-wide</td>
                                        <td>2024-05-22</td>
                                        <td><span class="badge bg-success">Accepted</span></td>
                                        <td>Excellent implementation with comprehensive documentation</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('GAD003')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="quickUpdate('GAD003', 'submitted')">
                                                <i class="bi bi-arrow-clockwise"></i> Reopen
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="returned">
                                        <td>GAD004</td>
                                        <td>Policy Development Unit</td>
                                        <td>Work-Life Balance Policy - Draft completed</td>
                                        <td>2024-06-18</td>
                                        <td><span class="badge bg-danger">Returned</span></td>
                                        <td>Need stakeholder consultation evidence and implementation timeline</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('GAD004')">
                                                <i class="bi bi-eye"></i> View
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('GAD004', 'accepted')">
                                                <i class="bi bi-check"></i> Accept
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="submitted">
                                        <td>GAD005</td>
                                        <td>IT Division</td>
                                        <td>Digital Gender Awareness Platform - Beta launch</td>
                                        <td>2024-07-01</td>
                                        <td><span class="badge bg-primary">Submitted</span></td>
                                        <td>-</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('GAD005')">
                                                <i class="bi bi-eye"></i> Review
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('GAD005', 'accepted')">
                                                <i class="bi bi-check"></i> Accept
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="quickUpdate('GAD005', 'returned')">
                                                <i class="bi bi-x"></i> Return
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

    <!-- Review Accomplishment Modal -->
    <div class="modal fade" id="reviewAccomplishmentModal" tabindex="-1" aria-labelledby="reviewAccomplishmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewAccomplishmentModalLabel">
                        <i class="bi bi-eye"></i> Review GAD Accomplishment
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewAccomplishmentForm" class="needs-validation" novalidate>
                        <input type="hidden" id="reviewAccomplishmentId" name="reviewAccomplishmentId">
                        
                        <!-- Accomplishment Details -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Accomplishment Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>GAD Activity ID:</strong> <span id="displayAccomplishmentId"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Office:</strong> <span id="displayOffice"></span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <strong>Date Submitted:</strong> <span id="displaySubmissionDate"></span>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Current Status:</strong> <span id="displayCurrentStatus"></span>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <strong>Accomplishment Summary:</strong>
                                        <p id="displayAccomplishmentSummary"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Supporting Documents:</strong>
                                        <p><a href="#" class="btn btn-sm btn-outline-info"><i class="bi bi-file-earmark-pdf"></i> View Documents</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Review Form -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewStatus" class="form-label">Review Status *</label>
                                    <select class="form-select" id="reviewStatus" name="reviewStatus" required>
                                        <option value="">Select Status</option>
                                        <option value="accepted">Accepted</option>
                                        <option value="returned">Returned</option>
                                        <option value="submitted">Under Review</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a review status.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewDate" class="form-label">Review Date</label>
                                    <input type="date" class="form-control" id="reviewDate" name="reviewDate" readonly>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reviewRemarks" class="form-label">Review Remarks *</label>
                            <textarea class="form-control" id="reviewRemarks" name="reviewRemarks" rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide review remarks.
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewedBy" class="form-label">Reviewed By</label>
                                    <input type="text" class="form-control" id="reviewedBy" name="reviewedBy" value="Admin User" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="reviewScore" class="form-label">Quality Score (1-10)</label>
                                    <input type="number" class="form-control" id="reviewScore" name="reviewScore" min="1" max="10">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Assessment -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Assessment Criteria</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Completeness</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="completeness" value="excellent" id="completenessExcellent">
                                                <label class="form-check-label" for="completenessExcellent">Excellent</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="completeness" value="good" id="completenessGood">
                                                <label class="form-check-label" for="completenessGood">Good</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="completeness" value="needs_improvement" id="completenessNeeds">
                                                <label class="form-check-label" for="completenessNeeds">Needs Improvement</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Documentation Quality</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="documentation" value="excellent" id="documentationExcellent">
                                                <label class="form-check-label" for="documentationExcellent">Excellent</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="documentation" value="good" id="documentationGood">
                                                <label class="form-check-label" for="documentationGood">Good</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="documentation" value="needs_improvement" id="documentationNeeds">
                                                <label class="form-check-label" for="documentationNeeds">Needs Improvement</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="reviewAccomplishmentForm" class="btn btn-primary">Save Review</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Set current date
        document.getElementById('reviewDate').value = new Date().toISOString().split('T')[0];

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
            const accomplishmentId = formData.get('reviewAccomplishmentId');
            const status = formData.get('reviewStatus');
            const remarks = formData.get('reviewRemarks');
            
            updateAccomplishmentStatus(accomplishmentId, status, remarks);
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // Review accomplishment
        function reviewAccomplishment(accomplishmentId) {
            const modal = new bootstrap.Modal(document.getElementById('reviewAccomplishmentModal'));
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === accomplishmentId) {
                    document.getElementById('reviewAccomplishmentId').value = accomplishmentId;
                    document.getElementById('displayAccomplishmentId').textContent = row.cells[0].textContent;
                    document.getElementById('displayOffice').textContent = row.cells[1].textContent;
                    document.getElementById('displayAccomplishmentSummary').textContent = row.cells[2].textContent;
                    document.getElementById('displaySubmissionDate').textContent = row.cells[3].textContent;
                    document.getElementById('displayCurrentStatus').textContent = row.cells[4].textContent;
                    
                    // Set current status
                    const statusText = row.cells[4].textContent.trim().toLowerCase();
                    if (statusText.includes('submitted')) {
                        document.getElementById('reviewStatus').value = 'submitted';
                    } else if (statusText.includes('accepted')) {
                        document.getElementById('reviewStatus').value = 'accepted';
                    } else if (statusText.includes('returned')) {
                        document.getElementById('reviewStatus').value = 'returned';
                    }
                    
                    // Set current remarks
                    document.getElementById('reviewRemarks').value = row.cells[5].textContent === '-' ? '' : row.cells[5].textContent;
                    
                    // Set review date to today
                    document.getElementById('reviewDate').value = new Date().toISOString().split('T')[0];
                }
            });
            
            modal.show();
        }

        // Quick update status
        function quickUpdate(accomplishmentId, newStatus) {
            let remarks = '';
            
            if (newStatus === 'returned') {
                remarks = prompt('Please provide reason for returning the accomplishment:');
                if (!remarks) return;
            } else if (newStatus === 'accepted') {
                remarks = 'Accomplishment accepted and approved';
            }
            
            updateAccomplishmentStatus(accomplishmentId, newStatus, remarks);
        }

        // Update accomplishment status in table
        function updateAccomplishmentStatus(accomplishmentId, status, remarks) {
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (row.cells[0].textContent === accomplishmentId) {
                    // Update status badge
                    let statusBadge = '';
                    if (status === 'submitted') {
                        statusBadge = '<span class="badge bg-primary">Submitted</span>';
                        row.dataset.status = 'submitted';
                    } else if (status === 'accepted') {
                        statusBadge = '<span class="badge bg-success">Accepted</span>';
                        row.dataset.status = 'accepted';
                    } else if (status === 'returned') {
                        statusBadge = '<span class="badge bg-danger">Returned</span>';
                        row.dataset.status = 'returned';
                    }
                    
                    row.cells[4].innerHTML = statusBadge;
                    row.cells[5].textContent = remarks || '-';
                    
                    // Update action buttons based on status
                    let actionButtons = `
                        <button class="btn btn-sm btn-outline-primary" onclick="reviewAccomplishment('${accomplishmentId}')">
                            <i class="bi bi-eye"></i> ${status === 'submitted' ? 'Review' : 'View'}
                        </button>
                    `;
                    
                    if (status === 'submitted') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('${accomplishmentId}', 'accepted')">
                                <i class="bi bi-check"></i> Accept
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="quickUpdate('${accomplishmentId}', 'returned')">
                                <i class="bi bi-x"></i> Return
                            </button>
                        `;
                    } else if (status === 'accepted') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-warning" onclick="quickUpdate('${accomplishmentId}', 'submitted')">
                                <i class="bi bi-arrow-clockwise"></i> Reopen
                            </button>
                        `;
                    } else if (status === 'returned') {
                        actionButtons += `
                            <button class="btn btn-sm btn-outline-success" onclick="quickUpdate('${accomplishmentId}', 'accepted')">
                                <i class="bi bi-check"></i> Accept
                            </button>
                        `;
                    }
                    
                    row.cells[6].innerHTML = actionButtons;
                }
            });
        }

        // Filter by status
        function filterByStatus(status) {
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
            rows.forEach(row => {
                if (status === 'all' || row.dataset.status === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Update button states
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Search functionality
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#reviewTableBody tr');
            
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
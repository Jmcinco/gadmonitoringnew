<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Accomplishment Submission - GAD Management System</title>
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
                            <li><a class="dropdown-item active" href="accomplishment_submission.html">Submission</a>
                            </li>
                            <li><a class="dropdown-item" href="accomplishment_review.html">Review</a></li>
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
                            <li><a class="dropdown-item" href="index.html"><i class="bi bi-box-arrow-right"></i>
                                    Logout</a></li>
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
                <li class="breadcrumb-item active">GAD Accomplishment Submission</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-cloud-upload text-primary"></i> GAD Accomplishment Submission
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addAccomplishmentModal">
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
                                        <td>Completed Gender Sensitivity Training for 120 employees (exceeded target of
                                            100)</td>
                                        <td>2024-03-15</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-info"><i
                                                    class="bi bi-file-earmark-pdf"></i> View</a></td>
                                        <td><span class="badge bg-primary">Submitted</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editAccomplishment('GAD001')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteAccomplishment('GAD001')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="under review">
                                        <td>GAD002</td>
                                        <td>Training Division</td>
                                        <td>Conducted Women's Leadership Workshop with 45 participants</td>
                                        <td>2024-04-10</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-info"><i
                                                    class="bi bi-file-earmark-pdf"></i> View</a></td>
                                        <td><span class="badge bg-warning">Under Review</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editAccomplishment('GAD002')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteAccomplishment('GAD002')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr data-status="accepted">
                                        <td>GAD003</td>
                                        <td>Legal Affairs Division</td>
                                        <td>Launched Anti-Sexual Harassment Campaign agency-wide</td>
                                        <td>2024-05-20</td>
                                        <td><a href="#" class="btn btn-sm btn-outline-info"><i
                                                    class="bi bi-file-earmark-pdf"></i> View</a></td>
                                        <td><span class="badge bg-success">Accepted</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editAccomplishment('GAD003')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info"
                                                onclick="viewAccomplishment('GAD003')">
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
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editAccomplishment('GAD004')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success"
                                                onclick="submitAccomplishment('GAD004')">
                                                <i class="bi bi-send"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                onclick="deleteAccomplishment('GAD004')">
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

    <!-- Add Accomplishment Modal -->
    <div class="modal fade" id="addAccomplishmentModal" tabindex="-1" aria-labelledby="addAccomplishmentModalLabel"
        aria-hidden="true">
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
                                        <option value="Information Technology Division">Information Technology Division
                                        </option>
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
                            <textarea class="form-control" id="actualAccomplishment" name="actualAccomplishment"
                                rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="dateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="dateAccomplished"
                                        name="dateAccomplished" required>
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
                            <input type="file" class="form-control" id="fileUpload" name="fileUpload"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>

                        <div class="mb-3">
                            <label for="additionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="additionalRemarks" name="additionalRemarks"
                                rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-outline-primary" onclick="saveAsDraft()">Save as Draft</button>
                    <button type="submit" form="addAccomplishmentForm" class="btn btn-primary">Submit
                        Accomplishment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Accomplishment Modal -->
    <div class="modal fade" id="editAccomplishmentModal" tabindex="-1" aria-labelledby="editAccomplishmentModalLabel"
        aria-hidden="true">
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
                                    <select class="form-select" id="editGadActivityId" name="editGadActivityId"
                                        required>
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
                                        <option value="Information Technology Division">Information Technology Division
                                        </option>
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
                            <textarea class="form-control" id="editActualAccomplishment" name="editActualAccomplishment"
                                rows="4" required></textarea>
                            <div class="invalid-feedback">
                                Please provide the actual accomplishment details.
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editDateAccomplished" class="form-label">Date Accomplished *</label>
                                    <input type="date" class="form-control" id="editDateAccomplished"
                                        name="editDateAccomplished" required>
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
                            <input type="file" class="form-control" id="editFileUpload" name="editFileUpload"
                                accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png">
                            <div class="form-text">Supported formats: PDF, DOC, DOCX, XLS, XLSX, JPG, JPEG, PNG</div>
                        </div>

                        <div class="mb-3">
                            <label for="editAdditionalRemarks" class="form-label">Additional Remarks</label>
                            <textarea class="form-control" id="editAdditionalRemarks" name="editAdditionalRemarks"
                                rows="2"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="editAccomplishmentForm" class="btn btn-primary">Update
                        Accomplishment</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Bootstrap form validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
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
        document.getElementById('searchInput').addEventListener('input', function () {
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidated GAD Plan & Budget - GAD Management System</title>
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
                            <i class="bi bi-gear"></i> GAD Workflow
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="gad_budget_preparation.html">Budget Preparation</a></li>
                            <li><a class="dropdown-item" href="gad_budget_crafting.html">Budget Crafting</a></li>
                            <li><a class="dropdown-item" href="gad_plan_review.html">Plan Review</a></li>
                            <li><a class="dropdown-item active" href="consolidated_plan.html">Consolidated Plan</a></li>
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
                <li class="breadcrumb-item active">Consolidated GAD Plan & Budget</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-file-earmark-ruled text-primary"></i> Consolidated GAD Plan & Budget
                    </h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#approveConsolidatedModal">
                            <i class="bi bi-check-circle"></i> Approve Consolidated Plan
                        </button>
                        <button type="button" class="btn btn-success" onclick="printConsolidatedPlan()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                        <button type="button" class="btn btn-info" onclick="saveToPDF()">
                            <i class="bi bi-file-earmark-pdf"></i> Save as PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">12</h4>
                                <p class="card-text">Approved Plans</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-check-circle fs-1"></i>
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
                                <h4 class="card-title">₱2,500,000</h4>
                                <p class="card-text">Total Budget</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-currency-dollar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">8</h4>
                                <p class="card-text">Divisions</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-building fs-1"></i>
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
                                <h4 class="card-title">2024</h4>
                                <p class="card-text">Target Year</p>
                            </div>
                            <div class="align-self-center">
                                <i class="bi bi-calendar fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consolidated Plan Table -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Approved GAD Plans and Budget</h5>
                            </div>
                            <div class="col-auto">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="selectAll"
                                        onchange="toggleSelectAll()">
                                    <label class="form-check-label" for="selectAll">
                                        Select All
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>
                                            <input type="checkbox" class="form-check-input" onclick="toggleSelectAll()">
                                        </th>
                                        <th>GAD Activity ID</th>
                                        <th>Plan Title</th>
                                        <th>Division</th>
                                        <th>Budget Allocation</th>
                                        <th>Target Beneficiaries</th>
                                        <th>Timeline</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="consolidatedTableBody">
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input plan-checkbox"
                                                value="GAD001">
                                        </td>
                                        <td>GAD001</td>
                                        <td>Gender Sensitivity Training Program</td>
                                        <td>Human Resources</td>
                                        <td>₱250,000</td>
                                        <td>100 employees</td>
                                        <td>Jan - Mar 2024</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="viewPlanDetails('GAD001')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPlan('GAD001')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input plan-checkbox"
                                                value="GAD002">
                                        </td>
                                        <td>GAD002</td>
                                        <td>Women's Leadership Development Workshop</td>
                                        <td>Training Division</td>
                                        <td>₱180,000</td>
                                        <td>50 women employees</td>
                                        <td>Feb - Apr 2024</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="viewPlanDetails('GAD002')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPlan('GAD002')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input plan-checkbox"
                                                value="GAD003">
                                        </td>
                                        <td>GAD003</td>
                                        <td>Anti-Sexual Harassment Campaign</td>
                                        <td>Legal Affairs</td>
                                        <td>₱150,000</td>
                                        <td>All employees</td>
                                        <td>Mar - May 2024</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="viewPlanDetails('GAD003')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPlan('GAD003')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="form-check-input plan-checkbox"
                                                value="GAD004">
                                        </td>
                                        <td>GAD004</td>
                                        <td>Work-Life Balance Policy Development</td>
                                        <td>Policy Development</td>
                                        <td>₱120,000</td>
                                        <td>Policy framework</td>
                                        <td>Apr - Jun 2024</td>
                                        <td><span class="badge bg-success">Approved</span></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="viewPlanDetails('GAD004')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-warning" onclick="editPlan('GAD004')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-end">Total Approved Budget:</th>
                                        <th>₱700,000</th>
                                        <th colspan="4"></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Consolidated Plan Modal -->
    <div class="modal fade" id="approveConsolidatedModal" tabindex="-1" aria-labelledby="approveConsolidatedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveConsolidatedModalLabel">
                        <i class="bi bi-check-circle"></i> Approve Consolidated GAD Plan & Budget
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="approveConsolidatedForm" class="needs-validation" novalidate>
                        <div class="alert alert-info" role="alert">
                            <i class="bi bi-info-circle"></i>
                            <strong>Review Summary:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Total Plans: 12</li>
                                <li>Total Budget: ₱2,500,000</li>
                                <li>Participating Divisions: 8</li>
                                <li>Target Year: 2024</li>
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label for="approvalDate" class="form-label">Approval Date *</label>
                            <input type="date" class="form-control" id="approvalDate" name="approvalDate" required>
                            <div class="invalid-feedback">
                                Please provide an approval date.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="approvalRemarks" class="form-label">Approval Remarks *</label>
                            <textarea class="form-control" id="approvalRemarks" name="approvalRemarks" rows="3"
                                required></textarea>
                            <div class="invalid-feedback">
                                Please provide approval remarks.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="approvedBy" class="form-label">Approved By</label>
                            <input type="text" class="form-control" id="approvedBy" name="approvedBy" value="Admin User"
                                readonly>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="confirmApproval" required>
                            <label class="form-check-label" for="confirmApproval">
                                I confirm that all plans and budgets have been reviewed and are approved for
                                implementation.
                            </label>
                            <div class="invalid-feedback">
                                Please confirm your approval.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="approveConsolidatedForm" class="btn btn-success">Approve Plan &
                        Budget</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Plan Details Modal -->
    <div class="modal fade" id="planDetailsModal" tabindex="-1" aria-labelledby="planDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="planDetailsModalLabel">
                        <i class="bi bi-eye"></i> Plan Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>GAD Activity ID:</strong> <span id="detailPlanId"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Division:</strong> <span id="detailDivision"></span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <strong>Budget:</strong> <span id="detailBudget"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Timeline:</strong> <span id="detailTimeline"></span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Plan Title:</strong>
                            <p id="detailPlanTitle"></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <strong>Target Beneficiaries:</strong>
                            <p id="detailBeneficiaries"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Set current date
        document.getElementById('approvalDate').value = new Date().toISOString().split('T')[0];

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
            if (form.id === 'approveConsolidatedForm') {
                alert('Consolidated GAD Plan & Budget approved successfully!');
                bootstrap.Modal.getInstance(document.getElementById('approveConsolidatedModal')).hide();
            }
        }

        // Toggle select all
        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.plan-checkbox');

            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
        }

        // View plan details
        function viewPlanDetails(planId) {
            const modal = new bootstrap.Modal(document.getElementById('planDetailsModal'));
            const rows = document.querySelectorAll('#consolidatedTableBody tr');

            rows.forEach(row => {
                if (row.cells[1].textContent === planId) {
                    document.getElementById('detailPlanId').textContent = row.cells[1].textContent;
                    document.getElementById('detailPlanTitle').textContent = row.cells[2].textContent;
                    document.getElementById('detailDivision').textContent = row.cells[3].textContent;
                    document.getElementById('detailBudget').textContent = row.cells[4].textContent;
                    document.getElementById('detailBeneficiaries').textContent = row.cells[5].textContent;
                    document.getElementById('detailTimeline').textContent = row.cells[6].textContent;
                }
            });

            modal.show();
        }

        // Edit plan
        function editPlan(planId) {
            alert(`Edit functionality for plan ${planId} would be implemented here.`);
        }

        // Print consolidated plan
        function printConsolidatedPlan() {
            window.print();
        }

        // Save to PDF
        function saveToPDF() {
            alert('PDF generation functionality would be implemented here.');
        }
    </script>
</body>

</html>
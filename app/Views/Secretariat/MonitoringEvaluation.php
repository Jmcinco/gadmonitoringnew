<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Monitoring & Evaluation - GAD Management System</title>
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
                    <li class="nav-item">
                        <a class="nav-link active" href="monitoring_evaluation.html">
                            <i class="bi bi-graph-up"></i> Monitoring & Evaluation
                        </a>
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
                <li class="breadcrumb-item active">GAD Monitoring & Evaluation</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-graph-up text-primary"></i> GAD Monitoring & Evaluation Dashboard
                    </h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIndicatorModal">
                            <i class="bi bi-plus-circle"></i> Add KPI
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportDashboard()">
                            <i class="bi bi-download"></i> Export Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI Overview Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <h2 class="text-primary">85%</h2>
                        <h6 class="card-title">Overall Progress</h6>
                        <div class="progress">
                            <div class="progress-bar bg-primary" style="width: 85%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-success">
                    <div class="card-body text-center">
                        <h2 class="text-success">12/15</h2>
                        <h6 class="card-title">Activities Completed</h6>
                        <div class="progress">
                            <div class="progress-bar bg-success" style="width: 80%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-info">
                    <div class="card-body text-center">
                        <h2 class="text-info">₱2.1M</h2>
                        <h6 class="card-title">Budget Utilized</h6>
                        <div class="progress">
                            <div class="progress-bar bg-info" style="width: 84%"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-warning">
                    <div class="card-body text-center">
                        <h2 class="text-warning">920</h2>
                        <h6 class="card-title">Beneficiaries</h6>
                        <div class="progress">
                            <div class="progress-bar bg-warning" style="width: 92%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Matrix -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">GAD Performance Matrix</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Key Performance Indicator</th>
                                        <th>Target</th>
                                        <th>Actual</th>
                                        <th>Achievement Rate</th>
                                        <th>Status</th>
                                        <th>Trend</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Number of GAD Training Sessions</td>
                                        <td>20</td>
                                        <td>18</td>
                                        <td>90%</td>
                                        <td><span class="badge bg-success">On Track</span></td>
                                        <td><i class="bi bi-arrow-up text-success"></i></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('training-sessions')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Female Leadership Participation</td>
                                        <td>40%</td>
                                        <td>45%</td>
                                        <td>112%</td>
                                        <td><span class="badge bg-success">Exceeded</span></td>
                                        <td><i class="bi bi-arrow-up text-success"></i></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('female-leadership')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Gender-Responsive Policies</td>
                                        <td>5</td>
                                        <td>3</td>
                                        <td>60%</td>
                                        <td><span class="badge bg-warning">Behind</span></td>
                                        <td><i class="bi bi-arrow-down text-warning"></i></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('policies')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Budget Allocation to GAD</td>
                                        <td>5%</td>
                                        <td>5.2%</td>
                                        <td>104%</td>
                                        <td><span class="badge bg-success">Achieved</span></td>
                                        <td><i class="bi bi-arrow-up text-success"></i></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('budget')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Employee Satisfaction Score</td>
                                        <td>4.0</td>
                                        <td>4.3</td>
                                        <td>107%</td>
                                        <td><span class="badge bg-success">Exceeded</span></td>
                                        <td><i class="bi bi-arrow-up text-success"></i></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewDetails('satisfaction')">
                                                <i class="bi bi-eye"></i>
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

        <!-- Progress Tracking -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Monthly Progress Tracking</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="progressChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Budget Utilization by Quarter</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="budgetChart" width="400" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Risk Assessment -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Risk Assessment & Mitigation</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Risk Factor</th>
                                        <th>Impact Level</th>
                                        <th>Probability</th>
                                        <th>Risk Score</th>
                                        <th>Mitigation Strategy</th>
                                        <th>Owner</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Low participation in training programs</td>
                                        <td><span class="badge bg-warning">Medium</span></td>
                                        <td><span class="badge bg-info">Low</span></td>
                                        <td>3.2</td>
                                        <td>Mandatory attendance policy, incentives</td>
                                        <td>HR Division</td>
                                        <td><span class="badge bg-success">Managed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Delayed policy implementation</td>
                                        <td><span class="badge bg-danger">High</span></td>
                                        <td><span class="badge bg-warning">Medium</span></td>
                                        <td>7.5</td>
                                        <td>Fast-track approval process, stakeholder engagement</td>
                                        <td>Policy Unit</td>
                                        <td><span class="badge bg-warning">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td>Budget constraints</td>
                                        <td><span class="badge bg-danger">High</span></td>
                                        <td><span class="badge bg-info">Low</span></td>
                                        <td>6.0</td>
                                        <td>Alternative funding sources, cost optimization</td>
                                        <td>Finance Division</td>
                                        <td><span class="badge bg-success">Managed</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Items -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Action Items & Recommendations</h5>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addActionModal">
                                    <i class="bi bi-plus"></i> Add Action
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Action Item</th>
                                        <th>Priority</th>
                                        <th>Assigned To</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Develop additional gender-responsive policies</td>
                                        <td><span class="badge bg-danger">High</span></td>
                                        <td>Policy Development Unit</td>
                                        <td>2024-09-30</td>
                                        <td><span class="badge bg-info">In Progress</span></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" style="width: 40%">40%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateAction('action1')">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Increase training program frequency</td>
                                        <td><span class="badge bg-warning">Medium</span></td>
                                        <td>Training Division</td>
                                        <td>2024-08-15</td>
                                        <td><span class="badge bg-success">Completed</span></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-success" style="width: 100%">100%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewAction('action2')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Implement gender-responsive budgeting system</td>
                                        <td><span class="badge bg-danger">High</span></td>
                                        <td>Finance Division</td>
                                        <td>2024-12-31</td>
                                        <td><span class="badge bg-secondary">Planned</span></td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar bg-secondary" style="width: 10%">10%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateAction('action3')">
                                                <i class="bi bi-pencil"></i>
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

    <!-- Add KPI Modal -->
    <div class="modal fade" id="addIndicatorModal" tabindex="-1" aria-labelledby="addIndicatorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addIndicatorModalLabel">
                        <i class="bi bi-plus-circle"></i> Add Key Performance Indicator
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addIndicatorForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="indicatorName" class="form-label">KPI Name *</label>
                            <input type="text" class="form-control" id="indicatorName" name="indicatorName" required>
                            <div class="invalid-feedback">
                                Please provide a KPI name.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="targetValue" class="form-label">Target Value *</label>
                                    <input type="number" class="form-control" id="targetValue" name="targetValue" required>
                                    <div class="invalid-feedback">
                                        Please provide a target value.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="measurementUnit" class="form-label">Unit of Measurement</label>
                                    <input type="text" class="form-control" id="measurementUnit" name="measurementUnit">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="frequency" class="form-label">Measurement Frequency *</label>
                            <select class="form-select" id="frequency" name="frequency" required>
                                <option value="">Select Frequency</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quarterly">Quarterly</option>
                                <option value="Annually">Annually</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a measurement frequency.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="responsible" class="form-label">Responsible Office *</label>
                            <select class="form-select" id="responsible" name="responsible" required>
                                <option value="">Select Office</option>
                                <option value="Human Resources Division">Human Resources Division</option>
                                <option value="Training Division">Training Division</option>
                                <option value="Legal Affairs Division">Legal Affairs Division</option>
                                <option value="Policy Development Unit">Policy Development Unit</option>
                                <option value="Finance Division">Finance Division</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a responsible office.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addIndicatorForm" class="btn btn-primary">Add KPI</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Action Modal -->
    <div class="modal fade" id="addActionModal" tabindex="-1" aria-labelledby="addActionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addActionModalLabel">
                        <i class="bi bi-plus-circle"></i> Add Action Item
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addActionForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="actionItem" class="form-label">Action Item *</label>
                            <textarea class="form-control" id="actionItem" name="actionItem" rows="2" required></textarea>
                            <div class="invalid-feedback">
                                Please provide an action item description.
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority *</label>
                                    <select class="form-select" id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="High">High</option>
                                        <option value="Medium">Medium</option>
                                        <option value="Low">Low</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a priority level.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assignedTo" class="form-label">Assigned To *</label>
                                    <select class="form-select" id="assignedTo" name="assignedTo" required>
                                        <option value="">Select Office</option>
                                        <option value="Human Resources Division">Human Resources Division</option>
                                        <option value="Training Division">Training Division</option>
                                        <option value="Legal Affairs Division">Legal Affairs Division</option>
                                        <option value="Policy Development Unit">Policy Development Unit</option>
                                        <option value="Finance Division">Finance Division</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select an office.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="dueDate" class="form-label">Due Date *</label>
                            <input type="date" class="form-control" id="dueDate" name="dueDate" required>
                            <div class="invalid-feedback">
                                Please provide a due date.
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" form="addActionForm" class="btn btn-primary">Add Action</button>
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
            const formId = form.id;
            
            if (formId === 'addIndicatorForm') {
                alert('New KPI added successfully!');
            } else if (formId === 'addActionForm') {
                alert('New action item added successfully!');
            }
            
            // Close modal
            const modal = form.closest('.modal');
            bootstrap.Modal.getInstance(modal).hide();
            
            // Reset form
            form.reset();
            form.classList.remove('was-validated');
        }

        // View details
        function viewDetails(kpi) {
            alert(`Viewing detailed analytics for: ${kpi}`);
        }

        // Update action
        function updateAction(actionId) {
            alert(`Updating action item: ${actionId}`);
        }

        // View action
        function viewAction(actionId) {
            alert(`Viewing action details: ${actionId}`);
        }

        // Export dashboard
        function exportDashboard() {
            alert('Exporting monitoring & evaluation dashboard...');
        }

        // Note: In a real implementation, you would initialize charts here
        // using Chart.js or similar library for progressChart and budgetChart
    </script>
</body>
</html>
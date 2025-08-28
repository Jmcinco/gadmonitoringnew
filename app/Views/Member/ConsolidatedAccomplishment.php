<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consolidated GAD Accomplishment Report - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.html">
                <i class="bi bi-gender-ambiguous" style="font-size: 2rem; color: rgb(255, 255, 255);"> </i> GAD Monitoring System
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
                            <li><a class="dropdown-item" href="accomplishment_review.html">Review</a></li>
                            <li><a class="dropdown-item active" href="consolidated_accomplishment.html">Consolidated</a></li>
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
                <li class="breadcrumb-item active">Consolidated GAD Accomplishment Report</li>
            </ol>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-file-earmark-bar-graph text-primary"></i> Consolidated GAD Accomplishment Report
                    </h1>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" onclick="generateReport()">
                            <i class="bi bi-file-earmark-text"></i> Generate Report
                        </button>
                        <button type="button" class="btn btn-success" onclick="exportToExcel()">
                            <i class="bi bi-file-earmark-excel"></i> Export to Excel
                        </button>
                        <button type="button" class="btn btn-info" onclick="printReport()">
                            <i class="bi bi-printer"></i> Print Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Period Selection -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="reportYear" class="form-label">Report Year</label>
                                <select class="form-select" id="reportYear">
                                    <option value="2024" selected>2024</option>
                                    <option value="2023">2023</option>
                                    <option value="2022">2022</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="reportQuarter" class="form-label">Quarter</label>
                                <select class="form-select" id="reportQuarter">
                                    <option value="">All Quarters</option>
                                    <option value="Q1">Q1 (Jan-Mar)</option>
                                    <option value="Q2" selected>Q2 (Apr-Jun)</option>
                                    <option value="Q3">Q3 (Jul-Sep)</option>
                                    <option value="Q4">Q4 (Oct-Dec)</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="reportOffice" class="form-label">Office</label>
                                <select class="form-select" id="reportOffice">
                                    <option value="">All Offices</option>
                                    <option value="Human Resources Division">Human Resources Division</option>
                                    <option value="Training Division">Training Division</option>
                                    <option value="Legal Affairs Division">Legal Affairs Division</option>
                                    <option value="Policy Development Unit">Policy Development Unit</option>
                                    <option value="IT Division">IT Division</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="btn btn-outline-primary" onclick="filterReport()">
                                    <i class="bi bi-funnel"></i> Apply Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">15</h3>
                        <p class="card-text">Total Activities</p>
                        <i class="bi bi-clipboard-data fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">12</h3>
                        <p class="card-text">Completed</p>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">2</h3>
                        <p class="card-text">In Progress</p>
                        <i class="bi bi-clock fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="card-title">80%</h3>
                        <p class="card-text">Success Rate</p>
                        <i class="bi bi-bar-chart fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance by Office -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h5 class="mb-0">Performance Summary by Office</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Office</th>
                                        <th>Planned Activities</th>
                                        <th>Completed</th>
                                        <th>Success Rate</th>
                                        <th>Budget Utilization</th>
                                        <th>Beneficiaries Reached</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Human Resources Division</td>
                                        <td>4</td>
                                        <td>4</td>
                                        <td><span class="badge bg-success">100%</span></td>
                                        <td>₱450,000 (95%)</td>
                                        <td>320 employees</td>
                                    </tr>
                                    <tr>
                                        <td>Training Division</td>
                                        <td>3</td>
                                        <td>3</td>
                                        <td><span class="badge bg-success">100%</span></td>
                                        <td>₱280,000 (88%)</td>
                                        <td>150 participants</td>
                                    </tr>
                                    <tr>
                                        <td>Legal Affairs Division</td>
                                        <td>3</td>
                                        <td>2</td>
                                        <td><span class="badge bg-warning">67%</span></td>
                                        <td>₱180,000 (72%)</td>
                                        <td>All employees</td>
                                    </tr>
                                    <tr>
                                        <td>Policy Development Unit</td>
                                        <td>2</td>
                                        <td>1</td>
                                        <td><span class="badge bg-warning">50%</span></td>
                                        <td>₱120,000 (60%)</td>
                                        <td>Policy framework</td>
                                    </tr>
                                    <tr>
                                        <td>IT Division</td>
                                        <td>3</td>
                                        <td>2</td>
                                        <td><span class="badge bg-warning">67%</span></td>
                                        <td>₱200,000 (80%)</td>
                                        <td>Digital platform users</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Accomplishments -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Detailed GAD Accomplishments</h5>
                            </div>
                            <div class="col-auto">
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-outline-secondary active" onclick="toggleView('table')">
                                        <i class="bi bi-table"></i> Table View
                                    </button>
                                    <button class="btn btn-outline-secondary" onclick="toggleView('chart')">
                                        <i class="bi bi-bar-chart"></i> Chart View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tableView">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>GAD Activity ID</th>
                                            <th>Activity Title</th>
                                            <th>Office</th>
                                            <th>Target vs Actual</th>
                                            <th>Budget vs Actual</th>
                                            <th>Completion Date</th>
                                            <th>Status</th>
                                            <th>Impact</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>GAD001</td>
                                            <td>Gender Sensitivity Training</td>
                                            <td>HR Division</td>
                                            <td>100 → 120 <span class="text-success">(+20%)</span></td>
                                            <td>₱250k → ₱238k <span class="text-success">(-5%)</span></td>
                                            <td>2024-03-15</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD002</td>
                                            <td>Women's Leadership Workshop</td>
                                            <td>Training Division</td>
                                            <td>50 → 45 <span class="text-warning">(-10%)</span></td>
                                            <td>₱180k → ₱165k <span class="text-success">(-8%)</span></td>
                                            <td>2024-04-10</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD003</td>
                                            <td>Anti-Sexual Harassment Campaign</td>
                                            <td>Legal Affairs</td>
                                            <td>All → All <span class="text-success">(100%)</span></td>
                                            <td>₱150k → ₱145k <span class="text-success">(-3%)</span></td>
                                            <td>2024-05-20</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-success">Very High</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD004</td>
                                            <td>Work-Life Balance Policy</td>
                                            <td>Policy Unit</td>
                                            <td>1 → 0 <span class="text-danger">(0%)</span></td>
                                            <td>₱120k → ₱80k <span class="text-warning">(-33%)</span></td>
                                            <td>Pending</td>
                                            <td><span class="badge bg-warning">In Progress</span></td>
                                            <td><span class="badge bg-warning">Medium</span></td>
                                        </tr>
                                        <tr>
                                            <td>GAD005</td>
                                            <td>Digital Gender Platform</td>
                                            <td>IT Division</td>
                                            <td>Beta → Beta <span class="text-success">(100%)</span></td>
                                            <td>₱200k → ₱185k <span class="text-success">(-8%)</span></td>
                                            <td>2024-07-01</td>
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td><span class="badge bg-info">High</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div id="chartView" style="display: none;">
                            <div class="row">
                                <div class="col-md-6">
                                    <canvas id="completionChart" width="400" height="200"></canvas>
                                </div>
                                <div class="col-md-6">
                                    <canvas id="budgetChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Footer -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Report Generation Details</h6>
                                <p class="text-muted mb-0">
                                    Generated on: <strong id="reportDate"></strong><br>
                                    Report Period: <strong>Q2 2024 (April - June)</strong><br>
                                    Generated by: <strong>Admin User</strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Key Insights</h6>
                                <ul class="text-muted mb-0">
                                    <li>Overall completion rate: 80%</li>
                                    <li>Budget efficiency: 85% average utilization</li>
                                    <li>High impact activities: 4 out of 5 completed</li>
                                    <li>Total beneficiaries reached: 470+ individuals</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Set current date
        document.getElementById('reportDate').textContent = new Date().toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Toggle view between table and chart
        function toggleView(viewType) {
            const tableView = document.getElementById('tableView');
            const chartView = document.getElementById('chartView');
            const buttons = document.querySelectorAll('.btn-group .btn');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            
            if (viewType === 'table') {
                tableView.style.display = 'block';
                chartView.style.display = 'none';
                event.target.classList.add('active');
            } else {
                tableView.style.display = 'none';
                chartView.style.display = 'block';
                event.target.classList.add('active');
                // Note: In a real implementation, you would initialize charts here
                // using Chart.js or similar library
            }
        }

        // Filter report
        function filterReport() {
            const year = document.getElementById('reportYear').value;
            const quarter = document.getElementById('reportQuarter').value;
            const office = document.getElementById('reportOffice').value;
            
            // In a real implementation, this would filter the data
            alert(`Filtering report for:\nYear: ${year}\nQuarter: ${quarter || 'All'}\nOffice: ${office || 'All'}`);
        }

        // Generate report
        function generateReport() {
            alert('Comprehensive GAD accomplishment report generated successfully!');
        }

        // Export to Excel
        function exportToExcel() {
            alert('Exporting consolidated accomplishment report to Excel...');
        }

        // Print report
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
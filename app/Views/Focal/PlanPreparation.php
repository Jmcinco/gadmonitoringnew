<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAD Plan Preparation - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --bs-primary-rgb: 36, 20, 68; /* Custom primary color #241444 */
        }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: rgb(var(--bs-primary-rgb));
        }
        .mandate-icon {
            cursor: pointer;
            margin-left: 0.5rem;
            color: #0d6efd;
            font-size: 1.2rem;
            vertical-align: middle;
        }
        .additional-row {
            margin-top: 1rem;
            position: relative;
        }
        .remove-row {
            color: #dc3545;
            cursor: pointer;
            font-size: 0.9rem;
            position: absolute;
            right: 0;
            top: -1.5rem;
        }
        .table-responsive {
            min-height: 0.01%;
            overflow-x: auto;
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
            margin-bottom: 0.5rem;
        }
        .input-group {
            align-items: center;
        }
        .btn-group .btn {
            padding: 0.375rem 0.75rem;
        }
        .card-header {
            padding: 1rem 1.5rem;
        }
        .modal-xl {
            max-width: 90%;
        }
        @media (max-width: 768px) {
            .modal-xl {
                max-width: 95%;
            }
            .table-responsive {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= base_url('FocalDashboard') ?>">
                <i class="bi bi-shield-check"></i> GAD Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('FocalDashboard') ?>">
                            <i class="bi bi-house-door"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-clipboard-data"></i> GAD ACTIVITIES
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('Focal/PlanPreparation') ?>">GAD Plan Preparation</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/BudgetCrafting') ?>">Budget Crafting</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/PlanReview') ?>">Review & Approval of GAD Plan</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/ConsolidatedPlan') ?>">Generate Consolidated Plan & Budget</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">Submit GAD Accomplishment</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/ReviewApproval') ?>">Review & Approval</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/ConsolidatedAccomplishment') ?>">Generate Consolidated GAD Accomplishment</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i>
                            <?php echo esc(session()->get('first_name') . ' ' . session()->get('last_name')); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= site_url('login/logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 mb-0">
                        <i class="bi bi-clipboard-data text-primary"></i> GAD Plan Preparation
                    </h1>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gadPlanModal">
                        <i class="bi bi-plus-circle"></i> Create GAD Plan
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">GAD Plan Activities</h5>
                        <div class="input-group w-25">
                            <input type="text" class="form-control" placeholder="Search GAD plans..." id="searchInput" aria-label="Search GAD plans">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="width: 25%;">Gender Issue / GAD Mandate</th>
                                        <th style="width: 30%;">GAD Activity</th>
                                        <th style="width: 25%;">Performance Indicators</th>
                                        <th style="width: 10%;">Budget</th>
                                        <th style="width: 10%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="gadPlanTableBody">
                                    <?php if (empty($gadPlans)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center">No GAD plans found.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($gadPlans as $plan): ?>
                                            <tr data-plan-id="<?php echo esc($plan['plan_id'] ?? ''); ?>">
                                                <td><?php echo esc($plan['issue_mandate'] ?? ''); ?></td>
                                                <td><?php echo esc($plan['activity'] ?? ''); ?></td>
                                                <td><?php echo esc($plan['indicators'] ?? ''); ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('Focal/BudgetCrafting'); ?>" class="btn btn-sm btn-outline-info">
                                                        ₱<?php echo isset($plan['budget']) ? number_format($plan['budget'], 0, '.', ',') : '0'; ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button class="btn btn-sm btn-outline-primary me-2" onclick="editGadPlan(this, '<?php echo esc($plan['plan_id'] ?? ''); ?>')">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan(this, '<?php echo esc($plan['plan_id'] ?? ''); ?>')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- GAD Plan Modal -->
    <div class="modal fade" id="gadPlanModal" tabindex="-1" aria-labelledby="gadPlanModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="gadPlanModalLabel">
                        <i class="bi bi-clipboard-data"></i> Create GAD Plan Activity
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?php echo session()->getFlashdata('error'); ?></div>
                    <?php endif; ?>
                    <?php echo form_open('GadPlanController/save', ['id' => 'gadPlanForm', 'class' => 'needs-validation', 'novalidate' => 'novalidate']); ?>
                        <div class="mb-4 position-relative">
                            <label for="issue_mandate" class="form-label"><strong>INDICATE THE GAD MANDATE / GENDER ISSUE BEING ADDRESSED BY THE ACTIVITY</strong> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <textarea class="form-control <?php echo (isset($validation) && $validation->hasError('issue_mandate')) ? 'is-invalid' : ''; ?>" id="issue_mandate" name="issue_mandate" rows="3" placeholder="Describe the gender issue or GAD mandate to be addressed..." required><?php echo set_value('issue_mandate'); ?></textarea>
                                <button type="button" class="btn btn-outline-primary mandate-icon" data-bs-toggle="modal" data-bs-target="#mandateModal" onclick="loadMandates()">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('issue_mandate')) ? $validation->getError('issue_mandate') : 'Please provide a gender issue or GAD mandate (min 10 characters).'; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="cause" class="form-label"><strong>INDICATE THE CAUSE OF GENDER ISSUE</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php echo (isset($validation) && $validation->hasError('cause')) ? 'is-invalid' : ''; ?>" id="cause" name="cause" rows="3" placeholder="Identify the root causes of the gender issue..." required><?php echo set_value('cause'); ?></textarea>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addCauseOfIssueRow()">Add Another</button>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('cause')) ? $validation->getError('cause') : 'Please provide the cause of the gender issue (min 10 characters).'; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="gad_objective" class="form-label"><strong>GAD RESULT/STATEMENT OR GAD OBJECTIVE</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php echo (isset($validation) && $validation->hasError('gad_objective')) ? 'is-invalid' : ''; ?>" id="gad_objective" name="gad_objective" rows="3" placeholder="Define the expected GAD result or objective..." required><?php echo set_value('gad_objective'); ?></textarea>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addGadObjectiveRow()">Add Another</button>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('gad_objective')) ? $validation->getError('gad_objective') : 'Please provide the GAD objective or result statement (min 10 characters).'; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label><strong>RELEVANT ORGANIZATION/MFO/PAP OR PPA (OPTIONAL)</strong></label>
                            <div id="mfoPapTableContainer">
                                <table class="table table-bordered mb-2" id="mfoPapTable_0">
                                    <thead>
                                        <tr>
                                            <th style="width: 25%;">Type</th>
                                            <th style="width: 60%;">MFO / PAP Statement</th>
                                            <th style="width: 15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="form-select <?php echo (isset($validation) && $validation->hasError('mfoPapType_0')) ? 'is-invalid' : ''; ?>" name="mfoPapType_0">
                                                    <option value="" <?php echo set_select('mfoPapType_0', '', true); ?>>Select Type</option>
                                                    <option value="MFO" <?php echo set_select('mfoPapType_0', 'MFO'); ?>>MFO</option>
                                                    <option value="MFA" <?php echo set_select('mfoPapType_0', 'MFA'); ?>>MFA</option>
                                                </select>
                                            </td>
                                            <td><input type="text" class="form-control <?php echo (isset($validation) && $validation->hasError('mfoPapStatement_0')) ? 'is-invalid' : ''; ?>" name="mfoPapStatement_0" placeholder="Enter MFO / PAP statement..." value="<?php echo set_value('mfoPapStatement_0'); ?>"></td>
                                            <td><button type="button" class="btn btn-danger btn-sm" onclick="removeMfoPapRow(this, 0)">Delete</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="addMfoPapRow()">Add Another</button>
                            <?php if (isset($validation) && $validation->hasError('mfoPap')): ?>
                                <div class="invalid-feedback d-block"><?php echo $validation->getError('mfoPap'); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4">
                            <label for="activity" class="form-label"><strong>GAD ACTIVITY</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php echo (isset($validation) && $validation->hasError('activity')) ? 'is-invalid' : ''; ?>" id="activity" name="activity" rows="3" placeholder="Describe the specific GAD activity..." required><?php echo set_value('activity'); ?></textarea>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('activity')) ? $validation->getError('activity') : 'Please provide a GAD activity (min 10 characters).'; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="indicators" class="form-label"><strong>PERFORMANCE TARGETS/INDICATORS</strong> <span class="text-danger">*</span></label>
                            <textarea class="form-control <?php echo (isset($validation) && $validation->hasError('indicators')) ? 'is-invalid' : ''; ?>" id="indicators" name="indicators" rows="3" placeholder="Define specific, measurable performance targets and indicators..." required><?php echo set_value('indicators'); ?></textarea>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('indicators')) ? $validation->getError('indicators') : 'Please provide performance targets and indicators (min 10 characters).'; ?>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="startDate" class="form-label"><strong>START DATE</strong> <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?php echo (isset($validation) && $validation->hasError('startDate')) ? 'is-invalid' : ''; ?>" id="startDate" name="startDate" value="<?php echo set_value('startDate'); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo (isset($validation) && $validation->hasError('startDate')) ? $validation->getError('startDate') : 'Please select a start date.'; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="endDate" class="form-label"><strong>END DATE</strong> <span class="text-danger">*</span></label>
                                <input type="date" class="form-control <?php echo (isset($validation) && $validation->hasError('endDate')) ? 'is-invalid' : ''; ?>" id="endDate" name="endDate" value="<?php echo set_value('endDate'); ?>" required>
                                <div class="invalid-feedback">
                                    <?php echo (isset($validation) && $validation->hasError('endDate')) ? $validation->getError('endDate') : 'Please select an end date after the start date.'; ?>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="responsibleUnit" class="form-label"><strong>RESPONSIBLE UNIT/OFFICE</strong> <span class="text-danger">*</span></label>
                            <select class="form-select <?php echo (isset($validation) && $validation->hasError('responsibleUnit')) ? 'is-invalid' : ''; ?>" id="responsibleUnit" name="responsibleUnit" required>
                                <option value="" <?php echo set_select('responsibleUnit', '', true); ?>>Select Responsible Unit</option>
                                <?php foreach ($divisions as $division): ?>
                                    <option value="<?= esc($division->division) ?>" <?= set_select('responsibleUnit', $division->division) ?>>
                                        <?= esc($division->division) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= (isset($validation) && $validation->hasError('responsibleUnit')) ? $validation->getError('responsibleUnit') : 'Please select a responsible unit.'; ?>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="budgetAmount" class="form-label"><strong>BUDGET AMOUNT</strong> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">₱</span>
                                <input 
                                    type="number" 
                                    class="form-control <?php echo (isset($validation) && $validation->hasError('budgetAmount')) ? 'is-invalid' : ''; ?>" 
                                    id="budgetAmount" 
                                    name="budgetAmount" 
                                    step="0.01" 
                                    min="0" 
                                    value="<?php echo set_value('budgetAmount'); ?>" 
                                    required
                                >
                                <button class="btn btn-outline-secondary" type="button" onclick="linkToBudgetCrafting()">
                                    <i class="bi bi-link-45deg"></i> Link to Budget Crafting
                                </button>
                            </div>
                            <div class="form-text">
                                <i class="bi bi-info-circle"></i> Budget will be linked to the GAD Budget Crafting module for detailed breakdown.
                            </div>
                            <div class="invalid-feedback">
                                <?php echo (isset($validation) && $validation->hasError('budgetAmount')) ? $validation->getError('budgetAmount') : 'Please enter a budget amount greater than 0.'; ?>
                            </div>
                        </div>
                        <input type="hidden" name="mfoPapData" id="mfoPapData">
                        <input type="hidden" name="planId" id="planId">
                    <?php echo form_close(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="submit" form="gadPlanForm" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Save GAD Plan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mandate Selection Modal -->
    <div class="modal fade" id="mandateModal" tabindex="-1" aria-labelledby="mandateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mandateModalLabel">
                        <i class="bi bi-search"></i> Select GAD Mandate
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="filterYear" class="form-label">Filter by Year</label>
                            <select class="form-select" id="filterYear" onchange="loadMandates()">
                                <option value="">All Years</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success mb-3" onclick="showAddMandateForm()">
                        <i class="bi bi-plus-circle"></i> Add New GAD Mandate
                    </button>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 10%;"></th>
                                    <th style="width: 15%;">Year</th>
                                    <th style="width: 60%;">Description</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="mandateTableBody">
                                <?php if (empty($mandates)): ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No GAD mandates found.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($mandates as $mandate): ?>
                                        <tr>
                                            <td><input type="radio" name="mandateSelect" onclick="selectMandate('<?php echo esc($mandate->year); ?>', '<?php echo esc($mandate->description); ?>')"></td>
                                            <td><?php echo esc($mandate->year); ?></td>
                                            <td><?php echo esc($mandate->description); ?></td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="editMandate('<?php echo esc($mandate->year); ?>', '<?php echo esc($mandate->description); ?>')">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteMandate('<?php echo esc($mandate->year); ?>', '<?php echo esc($mandate->description); ?>')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Mandate Modal -->
    <div class="modal fade" id="createMandateModal" tabindex="-1" aria-labelledby="createMandateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createMandateModalLabel">
                        <i class="bi bi-plus-circle"></i> Add New GAD Mandate
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createMandateForm" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="newMandateDescription" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="newMandateDescription" name="newMandateDescription" rows="3" required></textarea>
                            <div class="invalid-feedback">Please provide a description.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" onclick="saveNewMandate()">
                        <i class="bi bi-check-circle"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Date validation
        document.getElementById('startDate').addEventListener('change', function() {
            const startDate = this.value;
            const endDateInput = document.getElementById('endDate');
            if (startDate) {
                endDateInput.min = startDate;
            }
        });

        document.getElementById('endDate').addEventListener('change', function() {
            const endDate = this.value;
            const startDateInput = document.getElementById('startDate');
            if (endDate) {
                startDateInput.max = endDate;
            }
        });

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
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        function saveGadPlan() {
            const form = document.getElementById('gadPlanForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            const mfoPapData = [];
            document.querySelectorAll('table[id^="mfoPapTable_"]').forEach(table => {
                const index = table.id.replace('mfoPapTable_', '');
                const type = table.querySelector(`select[name="mfoPapType_${index}"]`)?.value;
                const statement = table.querySelector(`input[name="mfoPapStatement_${index}"]`)?.value;
                if (type && statement) {
                    mfoPapData.push({ type, statement });
                }
            });
            formData.set('mfoPapData', JSON.stringify(mfoPapData));

            const startDate = new Date(document.getElementById('startDate').value);
            const endDate = new Date(document.getElementById('endDate').value);
            if (startDate >= endDate) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Date Range',
                    text: 'End date must be after start date.'
                });
                return;
            }

            fetch(form.action, {
                method: 'POST',
                body: new URLSearchParams(formData),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                }
            }).then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    const planId = data.planId;
                    const tableBody = document.getElementById('gadPlanTableBody');
                    const isUpdate = formData.get('planId');
                    if (isUpdate) {
                        const row = tableBody.querySelector(`tr[data-plan-id="${planId}"]`);
                        if (row) {
                            row.innerHTML = `
                                <td>${form.querySelector('#issue_mandate').value}</td>
                                <td>${form.querySelector('#activity').value}</td>
                                <td>${form.querySelector('#indicators').value}</td>
                                <td>
                                    <a href="<?php echo base_url('Focal/BudgetCrafting'); ?>" class="btn btn-sm btn-outline-info">
                                        ₱${parseFloat(form.querySelector('#budgetAmount').value).toLocaleString('en-US', { minimumFractionDigits: 0 })}
                                    </a>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary me-2" onclick="editGadPlan(this, '${planId}')">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan(this, '${planId}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            `;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'GAD Plan Updated!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        const newRow = document.createElement('tr');
                        newRow.setAttribute('data-plan-id', planId);
                        newRow.innerHTML = `
                            <td>${form.querySelector('#issue_mandate').value}</td>
                            <td>${form.querySelector('#activity').value}</td>
                            <td>${form.querySelector('#indicators').value}</td>
                            <td>
                                <a href="<?php echo base_url('Focal/BudgetCrafting'); ?>" class="btn btn-sm btn-outline-info">
                                    ₱${parseFloat(form.querySelector('#budgetAmount').value).toLocaleString('en-US', { minimumFractionDigits: 0 })}
                                </a>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="editGadPlan(this, '${planId}')">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" onclick="deleteGadPlan(this, '${planId}')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        tableBody.appendChild(newRow);
                        Swal.fire({
                            icon: 'success',
                            title: 'GAD Plan Saved!',
                            text: data.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                    const modal = bootstrap.Modal.getInstance(document.getElementById('gadPlanModal'));
                    modal.hide();
                    form.reset();
                    form.action = '<?php echo base_url('GadPlanController/save'); ?>';
                    form.classList.remove('was-validated');
                    document.querySelectorAll('.additional-row').forEach(row => row.remove());
                    setTimeout(() => {
                        window.location.href = '<?php echo base_url('Focal/PlanPreparation'); ?>';
                    }, 2000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: data.message + (data.errors ? ': ' + Object.values(data.errors).join(', ') : '')
                    });
                }
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred: ' + error.message
                });
                console.error('Error:', error);
            });
        }

        function editGadPlan(button, planId) {
            fetch('<?php echo base_url('GadPlanController/getGadPlan/'); ?>' + planId, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                }
            }).then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    const plan = data.plan;
                    const form = document.getElementById('gadPlanForm');
                    form.action = '<?php echo base_url('GadPlanController/save/'); ?>' + planId;
                    document.getElementById('issue_mandate').value = plan.genderIssue || '';
                    document.getElementById('cause').value = plan.causeOfIssue || '';
                    document.getElementById('gad_objective').value = plan.gadObjective || '';
                    document.getElementById('activity').value = plan.gadActivity || '';
                    document.getElementById('indicators').value = plan.performanceTargets || '';
                    document.getElementById('startDate').value = plan.startDate || '';
                    document.getElementById('endDate').value = plan.endDate || '';
                    document.getElementById('responsibleUnit').value = plan.responsibleUnit || '';
                    document.getElementById('budgetAmount').value = plan.budgetAmount || '';
                    document.getElementById('planId').value = planId;
                    const mfoPapContainer = document.getElementById('mfoPapTableContainer');
                    mfoPapContainer.innerHTML = '';
                    let mfoPapIndex = 0;
                    const mfoPapData = plan.mfoPapData || [];
                    mfoPapData.forEach((item, index) => {
                        const table = document.createElement('table');
                        table.className = 'table table-bordered mb-2';
                        table.id = `mfoPapTable_${index}`;
                        table.innerHTML = `
                            <thead>
                                <tr>
                                    <th style="width: 25%;">Type</th>
                                    <th style="width: 60%;">MFO / PAP Statement</th>
                                    <th style="width: 15%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select class="form-select" name="mfoPapType_${index}">
                                            <option value="">Select Type</option>
                                            <option value="MFO" ${item.type === 'MFO' ? 'selected' : ''}>MFO</option>
                                            <option value="MFA" ${item.type === 'MFA' ? 'selected' : ''}>MFA</option>
                                        </select>
                                    </td>
                                    <td><input type="text" class="form-control" name="mfoPapStatement_${index}" value="${item.statement || ''}"></td>
                                    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeMfoPapRow(this, ${index})">Delete</button></td>
                                </tr>
                            </tbody>
                        `;
                        mfoPapContainer.appendChild(table);
                        mfoPapIndex = index + 1;
                    });
                    window.mfoPapIndex = mfoPapIndex;
                    const gadPlanModal = new bootstrap.Modal(document.getElementById('gadPlanModal'));
                    gadPlanModal.show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Failed to load GAD plan.'
                    });
                }
            }).catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred: ' + error.message
                });
                console.error('Error:', error);
            });
        }

        function deleteGadPlan(button, planId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?php echo base_url('GadPlanController/deleteGadPlan/'); ?>' + planId, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            '<?php echo csrf_header(); ?>': '<?php echo csrf_token(); ?>'
                        }
                    }).then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.json();
                    }).then(data => {
                        if (data.success) {
                            const tableBody = document.getElementById('gadPlanTableBody');
                            button.closest('tr').remove();
                            // Check if table is empty after deletion
                            if (tableBody.children.length === 0) {
                                tableBody.innerHTML = `
                                    <tr>
                                        <td colspan="5" class="text-center">No GAD plans found.</td>
                                    </tr>
                                `;
                            }
                            Swal.fire('Deleted!', 'The GAD plan activity has been deleted.', 'success');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Failed to delete GAD plan.'
                            });
                        }
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An unexpected error occurred: ' + error.message
                        });
                        console.error('Error:', error);
                    });
                }
            });
        }

        function linkToBudgetCrafting() {
            Swal.fire({
                icon: 'info',
                title: 'Budget Crafting',
                text: 'This will link to the GAD Budget Crafting module for detailed budget breakdown.',
                showCancelButton: true,
                confirmButtonText: 'Go to Budget Crafting',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?php echo base_url('Focal/BudgetCrafting'); ?>';
                }
            });
        }

        document.getElementById('searchInput').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#gadPlanTableBody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        function selectMandate(year, description) {
            document.getElementById('issue_mandate').value = description;
            const mandateModal = bootstrap.Modal.getInstance(document.getElementById('mandateModal'));
            mandateModal.hide();
            const gadPlanModal = new bootstrap.Modal(document.getElementById('gadPlanModal'));
            if (!gadPlanModal._isShown) {
                gadPlanModal.show();
            }
        }

        function showAddMandateForm() {
            const mandateModalElement = document.getElementById('mandateModal');
            const createMandateModalElement = document.getElementById('createMandateModal');
            const mandateModal = bootstrap.Modal.getInstance(mandateModalElement) || new bootstrap.Modal(mandateModalElement);
            const createMandateModal = bootstrap.Modal.getInstance(createMandateModalElement) || new bootstrap.Modal(createMandateModalElement);
            mandateModal.hide();
            mandateModalElement.addEventListener('hidden.bs.modal', function handler() {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
                createMandateModal.show();
                mandateModalElement.removeEventListener('hidden.bs.modal', handler);
            }, { once: true });
        }

        function saveNewMandate() {
            const form = document.getElementById('createMandateForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const newMandateDescription = document.getElementById('newMandateDescription').value;
            const currentYear = new Date().getFullYear().toString();

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td><input type="radio" name="mandateSelect" onclick="selectMandate('${currentYear}', '${newMandateDescription}')"></td>
                <td>${currentYear}</td>
                <td>${newMandateDescription}</td>
                <td>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-outline-primary me-2" onclick="editMandate('${currentYear}', '${newMandateDescription}')">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteMandate('${currentYear}', '${newMandateDescription}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            `;
            document.getElementById('mandateTableBody').appendChild(newRow);

            Swal.fire({
                icon: 'success',
                title: 'GAD Mandate Added!',
                text: 'The new GAD mandate has been successfully added.',
                timer: 2000,
                showConfirmButton: false
            });

            const createMandateModalElement = document.getElementById('createMandateModal');
            const createMandateModal = bootstrap.Modal.getInstance(createMandateModalElement);
            createMandateModal.hide();

            createMandateModalElement.addEventListener('hidden.bs.modal', function handler() {
                document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                document.body.classList.remove('modal-open');
                document.body.style = '';
                const mandateModal = new bootstrap.Modal(document.getElementById('mandateModal'));
                mandateModal.show();
                form.reset();
                form.classList.remove('was-validated');
                loadMandates();
                createMandateModalElement.removeEventListener('hidden.bs.modal', handler);
            }, { once: true });
        }

        function editMandate(year, description) {
            document.getElementById('newMandateDescription').value = description;
            const createMandateModal = new bootstrap.Modal(document.getElementById('createMandateModal'));
            createMandateModal.show();
        }

        function deleteMandate(year, description) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const row = Array.from(document.querySelectorAll('#mandateTableBody tr')).find(
                        r => r.cells[1].textContent === year && r.cells[2].textContent === description
                    );
                    if (row) {
                        row.remove();
                        Swal.fire('Deleted!', 'The GAD mandate has been deleted.', 'success');
                    }
                }
            });
        }

        function loadMandates() {
            const filterYear = document.getElementById('filterYear');
            const rows = document.querySelectorAll('#mandateTableBody tr');
            const years = new Set();
            rows.forEach(row => {
                const year = row.cells[1].textContent;
                years.add(year);
            });

            filterYear.innerHTML = '<option value="">All Years</option>';
            years.forEach(year => {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                filterYear.appendChild(option);
            });

            const selectedYear = filterYear.value;
            rows.forEach(row => {
                const year = row.cells[1].textContent;
                row.style.display = selectedYear === '' || year === selectedYear ? '' : 'none';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            new bootstrap.Modal(document.getElementById('gadPlanModal'));
            new bootstrap.Modal(document.getElementById('mandateModal'));
            new bootstrap.Modal(document.getElementById('createMandateModal'));
            loadMandates();
        });

        function addCauseOfIssueRow() {
            const container = document.querySelector('.mb-4:nth-child(2)');
            const newRow = document.createElement('div');
            newRow.className = 'mb-4 additional-row';
            newRow.innerHTML = `
                <textarea class="form-control" name="cause[]" rows="3" placeholder="Identify the root causes of the gender issue..." required></textarea>
                <span class="remove-row" onclick="this.parentElement.remove()">Remove</span>
            `;
            container.parentNode.insertBefore(newRow, container.nextSibling);
        }

        function addGadObjectiveRow() {
            const container = document.querySelector('.mb-4:nth-child(3)');
            const newRow = document.createElement('div');
            newRow.className = 'mb-4 additional-row';
            newRow.innerHTML = `
                <textarea class="form-control" name="gad_objective[]" rows="3" placeholder="Define the expected GAD result or objective..." required></textarea>
                <span class="remove-row" onclick="this.parentElement.remove()">Remove</span>
            `;
            container.parentNode.insertBefore(newRow, container.nextSibling);
        }

        let mfoPapIndex = 1;
        function addMfoPapRow() {
            const container = document.getElementById('mfoPapTableContainer');
            const newTable = document.createElement('table');
            newTable.className = 'table table-bordered mb-2';
            newTable.id = `mfoPapTable_${mfoPapIndex}`;
            newTable.innerHTML = `
                <thead>
                    <tr>
                        <th style="width: 25%;">Type</th>
                        <th style="width: 60%;">MFO / PAP Statement</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-select" name="mfoPapType_${mfoPapIndex}">
                                <option value="">Select Type</option>
                                <option value="MFO">MFO</option>
                                <option value="MFA">MFA</option>
                            </select>
                        </td>
                        <td><input type="text" class="form-control" name="mfoPapStatement_${mfoPapIndex}" placeholder="Enter MFO / PAP statement..."></td>
                        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeMfoPapRow(this, ${mfoPapIndex})">Delete</button></td>
                    </tr>
                </tbody>
            `;
            container.appendChild(newTable);
            mfoPapIndex++;
        }

        function removeMfoPapRow(button, index) {
            const table = document.getElementById(`mfoPapTable_${index}`);
            if (table) {
                table.remove();
            }
        }
    </script>
</body>
</html> 
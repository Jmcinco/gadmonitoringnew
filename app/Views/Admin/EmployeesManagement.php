<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Employees Management') ?> - GAD Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
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
            transform: translateX(0) !important;
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(33, 22, 22, 0.1);
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
        /* Modal form field layout fix */
        .modal-dialog {
            max-width: 700px;
        }
        .modal-content .form-control,
        .modal-content .form-select {
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
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
            .modal-dialog {
                max-width: 95vw;
            }
            .modal-content .form-control,
            .modal-content .form-select {
                max-width: 100%;
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
            <div class="user-info mb-4">
                <div class="text-white d-flex align-items-center">
                    <i class="bi bi-person-circle fs-4 me-2"></i>
                    <div>
                        <div class="fw-bold"><?php echo esc((session()->get('first_name') ?? 'Admin') . ' ' . (session()->get('last_name') ?? 'User')); ?></div>
                        <small class="text-light">Administrator</small>
                    </div>
                </div>
            </div>
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/AdminDashboard') ?>">
                        <i class="bi bi-house-door me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('/Admin/EmployeesManagement') ?>">
                        <i class="bi bi-people me-2"></i>Employee Management
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/AuditTrail') ?>">
                        <i class="bi bi-clock-history me-2"></i>Audit Trail
                    </a>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="<?= base_url('/login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-people text-primary"></i> Employees Management
                        </h1>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">
                            <i class="bi bi-person-plus"></i> Add New Employee
                        </button>
                    </div>

                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle"></i> <strong>Validation Errors:</strong>
                            <ul class="mb-0 mt-2">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Employees Records</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Division</th>
                                            <th>Position</th>
                                            <th>Role</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($employees)): ?>
                                            <?php $i = 1; foreach ($employees as $emp): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= esc($emp['first_name']) ?></td>
                                                    <td><?= esc($emp['last_name']) ?></td>
                                                    <td><?= esc($emp['division']) ?></td>
                                                    <td><?= esc($emp['position']) ?></td>
                                                    <td><?= esc($emp['role']) ?></td>
                                                    <td><?= esc($emp['gender']) ?></td>
                                                    <td><?= esc($emp['email']) ?></td>
                                                    <td>
                                                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployeeModal<?= $emp['emp_id'] ?>">
                                                            Edit
                                                        </button>
                                                        <form action="<?= site_url('Admin/Employees/delete/'.$emp['emp_id']) ?>" method="post" style="display:inline;">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this employee?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr><td colspan="9" class="text-center">No employees found.</td></tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content border-0 shadow-lg" action="<?= site_url('Admin/Employees/store') ?>" method="post">
            <?= csrf_field(); ?>
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addEmployeeModalLabel">
                    <i class="bi bi-person-plus"></i> Add New Employee
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bg-light">
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-person"></i> First Name</label>
                    <input type="text" class="form-control rounded-pill <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['first_name']) ? 'is-invalid' : '' ?>"
                           name="first_name" value="<?= old('first_name') ?>" required>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['first_name'])): ?>
                        <div class="invalid-feedback"><?= session()->getFlashdata('errors')['first_name'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-person"></i> Last Name</label>
                    <input type="text" class="form-control rounded-pill <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['last_name']) ? 'is-invalid' : '' ?>"
                           name="last_name" value="<?= old('last_name') ?>" required>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['last_name'])): ?>
                        <div class="invalid-feedback"><?= session()->getFlashdata('errors')['last_name'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-diagram-3"></i> Division</label>
                    <select name="div_id" class="form-select rounded-pill" required>
                        <option value="">-- Select Division --</option>
                        <?php foreach($divisions as $div): ?>
                            <option value="<?= $div['div_id'] ?>"><?= esc($div['division']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-briefcase"></i> Position</label>
                    <select name="pos_id" class="form-select rounded-pill" required>
                        <option value="">-- Select Position --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['pos_id'] ?>"><?= esc($pos['position']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-award"></i> Role</label>
                    <select name="role_id" class="form-select rounded-pill" required>
                        <option value="">-- Select Role --</option>
                        <?php foreach($roles as $role): ?>
                            <option value="<?= $role['role_id'] ?>"><?= esc($role['role']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-gender-ambiguous"></i> Gender</label>
                    <select name="gender" class="form-select rounded-pill" required>
                        <option value="">-- Select Gender --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
                    <input type="email" class="form-control rounded-pill <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email']) ? 'is-invalid' : '' ?>"
                           name="email" value="<?= old('email') ?>" required>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['email'])): ?>
                        <div class="invalid-feedback"><?= session()->getFlashdata('errors')['email'] ?></div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold"><i class="bi bi-key"></i> Password</label>
                    <input type="password" class="form-control rounded-pill <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password']) ? 'is-invalid' : '' ?>"
                           name="password" required>
                    <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['password'])): ?>
                        <div class="invalid-feedback"><?= session()->getFlashdata('errors')['password'] ?></div>
                    <?php endif; ?>
                    <div class="form-text">Password must be at least 8 characters long.</div>
                </div>
            </div>
            <div class="modal-footer bg-light border-0">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="bi bi-person-plus"></i> Add Employee
                </button>
            </div>
        </form>
    </div>
</div>

      <!-- Edit Employee Modals -->
<?php if (!empty($employees)): ?>
    <?php foreach ($employees as $emp): ?>
        <div class="modal fade" id="editEmployeeModal<?= $emp['emp_id'] ?>" tabindex="-1" aria-labelledby="editEmployeeModalLabel<?= $emp['emp_id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <form class="modal-content border-0 shadow-lg" action="<?= site_url('Admin/Employees/update/'.$emp['emp_id']) ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="editEmployeeModalLabel<?= $emp['emp_id'] ?>">
                            <i class="bi bi-pencil-square"></i> Edit Employee
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body bg-light">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person"></i> First Name</label>
                            <input type="text" class="form-control rounded-pill" name="first_name" value="<?= esc($emp['first_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-person"></i> Last Name</label>
                            <input type="text" class="form-control rounded-pill" name="last_name" value="<?= esc($emp['last_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-diagram-3"></i> Division</label>
                            <select name="div_id" class="form-select rounded-pill" required>
                                <option value="">-- Select Division --</option>
                                <?php foreach($divisions as $div): ?>
                                    <option value="<?= $div['div_id'] ?>" <?= $emp['div_id'] == $div['div_id'] ? 'selected' : '' ?>><?= esc($div['division']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-briefcase"></i> Position</label>
                            <select name="pos_id" class="form-select rounded-pill" required>
                                <option value="">-- Select Position --</option>
                                <?php foreach($positions as $pos): ?>
                                    <option value="<?= $pos['pos_id'] ?>" <?= $emp['pos_id'] == $pos['pos_id'] ? 'selected' : '' ?>><?= esc($pos['position']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-award"></i> Role</label>
                            <select name="role_id" class="form-select rounded-pill" required>
                                <option value="">-- Select Role --</option>
                                <?php foreach($roles as $role): ?>
                                    <option value="<?= $role['role_id'] ?>" <?= $emp['role_id'] == $role['role_id'] ? 'selected' : '' ?>><?= esc($role['role']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-gender-ambiguous"></i> Gender</label>
                            <select name="gender" class="form-select rounded-pill" required>
                                <option value="">-- Select Gender --</option>
                                <option value="male" <?= strtolower($emp['gender'])=='male'?'selected':'' ?>>Male</option>
                                <option value="female" <?= strtolower($emp['gender'])=='female'?'selected':'' ?>>Female</option>
                                <option value="other" <?= strtolower($emp['gender'])=='other'?'selected':'' ?>>Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-envelope"></i> Email</label>
                            <input type="email" class="form-control rounded-pill" name="email" value="<?= esc($emp['email']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="bi bi-key"></i> Password <small>(leave blank to keep current)</small></label>
                            <input type="password" class="form-control rounded-pill" name="password">
                        </div>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-pencil-square"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
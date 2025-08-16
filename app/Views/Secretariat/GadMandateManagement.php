<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gender Issue / Mandate Management - GAD System</title>

    <!-- CSRF meta (handy for AJAX headers like delete) -->
    <meta name="csrf-header" content="<?= csrf_token() ?>">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 280px;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --sidebar-active: #3498db;
            --sidebar-text: #fff;
            --sidebar-muted: rgba(255, 255, 255, 0.8);
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
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.1);
        }
        .sidebar-header {
            padding: 1.1rem 1.2rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            text-align: left;
        }
        .sidebar-header h4 { font-size: 1.2rem; font-weight: 500; margin: 0; }
        .sidebar-content { flex: 1; padding: 0.6rem; overflow-y: auto; }
        .sidebar-footer { padding: 0.8rem 1rem 1rem; border-top: 1px solid rgba(255, 255, 255, 0.09); }
        .user-info {
            padding: 0.6rem 0.8rem;
            background: rgba(255, 255, 255, 0.09);
            border-radius: 0.3rem;
            margin-bottom: 0.8rem;
            display: flex; align-items: center; font-size: 0.97rem;
        }
        .user-info i { font-size: 1.2rem; margin-right: 0.6rem; color: var(--sidebar-text); }
        .user-info .fw-bold { font-size: 1rem; font-weight: 500; }
        .nav-links { padding-left: 0; margin-bottom: 0; list-style: none; }
        .nav-links .nav-item { margin-bottom: 2px; position: relative; }
        .nav-link {
            color: var(--sidebar-muted);
            padding: 0.6rem 0.8rem;
            border-radius: 0.3rem;
            text-decoration: none;
            display: flex; align-items: center;
            font-size: 1rem; font-weight: 500; font-style: normal;
        }
        .nav-link.active {
            background-color: var(--sidebar-active);
            color: var(--sidebar-text);
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex; align-items: center;
            width: 100%;
        }
        .nav-links .iocn-link {
            display: flex; align-items: center; justify-content: space-between; width: 100%;
            cursor: pointer; border-radius: 0.3rem; transition: background-color 0.2s ease;
        }
        .nav-links .iocn-link:hover { background-color: var(--sidebar-hover); }
        .nav-links .arrow {
            font-size: 1rem; color: var(--sidebar-muted);
            margin-left: 0.1rem; transition: transform 0.3s ease, color 0.2s ease; cursor: pointer; padding: 0.2rem;
        }
        .nav-links .showMenu .arrow { transform: rotate(180deg); color: var(--sidebar-text); }
        .nav-links .showMenu .iocn-link { background-color: var(--sidebar-hover); }
        .nav-links .link_name { font-size: 1rem; font-weight: 400; display: flex; align-items: center; }
        .nav-links .link_name i { font-size: 1.16rem; margin-right: 0.5rem; vertical-align: middle; }
        .nav-links .sub-menu {
            display: none; background: rgba(255, 255, 255, 0.08);
            padding: 0.5rem 0; margin: 0.5rem 0 0.5rem 1rem; list-style: none;
            border-radius: 0.5rem; border-left: 3px solid var(--bs-primary);
        }
        .nav-links .showMenu .sub-menu { display: block; animation: fadeInSubMenu 0.4s cubic-bezier(0.37, 0.18, 0.57, 1.13); }
        @keyframes fadeInSubMenu {
            from { opacity: 0; transform: translateY(-10px); max-height: 0;}
            to { opacity: 1; transform: translateY(0); max-height: 400px;}
        }
        .nav-links .sub-menu a {
            color: rgba(255, 255, 255, 0.8); font-size: 0.85rem; padding: 0.6rem 1rem; white-space: nowrap;
            text-decoration: none; display: flex; align-items: center; border-radius: 0.3rem;
            margin: 0.1rem 0.5rem; transition: all 0.3s ease; position: relative;
        }
        .nav-links .sub-menu a:hover {
            color: var(--sidebar-text); background: var(--sidebar-hover);
            transform: translateX(5px); box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .nav-links .sub-menu a:active { background-color: var(--bs-primary); color: white; }
        .nav-links .sub-menu a.active { background-color: var(--bs-primary); color: white; }
        .nav-links .sub-menu a i { opacity: 0.7; transition: opacity 0.2s ease; }
        .nav-links .sub-menu a:hover i { opacity: 1; }
        .nav-links .sub-menu .link_name { display: none; }
        .main-content { margin-left: var(--sidebar-width); min-height: 100vh; padding: 2rem; background-color: #fafbfe; }
        .card { border: none; border-radius: 0.5rem; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15); }
        .card-header { padding: 1rem 1.5rem; background-color: #f8f9fc; border-bottom: 1px solid #e3e6f0; }
        /* Let long descriptions wrap nicely */
        td.col-desc { white-space: pre-wrap; }
        /* Toast position */
        .toast-container { z-index: 2000; }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <nav id="sidebar" class="sidebar">
        <div class="sidebar-header">
            <h4 class="text-white mb-0">
                <i class="bi bi-clipboard-data"></i> GAD System
            </h4>
        </div>
        <div class="sidebar-content">
            <div class="user-info mb-4">
                <i class="bi bi-person-circle"></i>
                <span class="fw-bold">
                    <?= esc(session()->get('first_name') . ' ' . session()->get('last_name')) ?>
                </span>
            </div>
            <ul class="nav nav-pills flex-column nav-links">
                <li class="nav-item">
                    <div class="iocn-link">
                        <a class="nav-link" href="<?= site_url('/SecretariatDashboard') ?>">
                            <span class="link_name">
                                <i class="bi bi-house-door"></i> Dashboard
                            </span>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <div class="iocn-link" id="toggle-gad-maintenance">
                        <a class="nav-link" href="#" role="button">
                            <span class="link_name">
                                <i class="bi bi-gear"></i> GAD Maintenance
                            </span>
                        </a>
                        <i class="bi bi-chevron-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="<?= base_url('Secretariat/UserManagement') ?>"><i class="bi bi-person-gear me-2"></i>User Information</a></li>
                        <li><a href="<?= site_url('/Secretariat/DivisionManagement') ?>"><i class="bi bi-building me-2"></i>Division / Office</a></li>
                        <li><a href="<?= site_url('/Secretariat/PositionsManagement') ?>"><i class="bi bi-briefcase me-2"></i>Positions</a></li>
                        <li><a href="<?= site_url('/Secretariat/MfoPap') ?>"><i class="bi bi-list-task me-2"></i>MFO / PAP</a></li>
                        <li><a href="<?= base_url('Secretariat/SourceOfFunds') ?>"><i class="bi bi-cash-stack me-2"></i>Source of Funds</a></li>
                        <li><a href="<?= base_url('Secretariat/ObjectOfExpense') ?>"><i class="bi bi-receipt me-2"></i>Object of Expense</a></li>
                        <li><a href="<?= site_url('Secretariat/GadMandateManagement') ?>" class="active"><i class="bi bi-people me-2"></i>Gender Issue / Mandate</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="sidebar-footer">
            <a href="<?= site_url('login/logout') ?>" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Main -->
    <div class="main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2" id="pageTitle">
                    <i class="bi bi-clipboard-data text-primary"></i> Gender Issue / Mandate Management
                </h1>
            </div>

            <!-- Gad Mandate Table -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Gender Issue / Mandate Records</h5>
                    <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addMandateModal">
                        <i class="bi bi-plus-circle"></i> Add New Mandate
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped align-middle mb-0">
                        <thead>
                            <tr>
                                <th style="width:50px;">#</th>
                                <th>Year</th>
                                <th>Description</th>
                                <th style="width:160px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="mandateTableBody">
                            <?php if (!empty($mandates)): ?>
                                <?php $i=1; foreach($mandates as $mandate): ?>
                                    <tr id="mandateRow<?= $mandate['id'] ?>">
                                        <td><?= $i++ ?></td>
                                        <td><?= esc($mandate['year']) ?></td>
                                        <td class="col-desc"><?= esc($mandate['description']) ?></td>
                                        <td class="text-nowrap">
                                            <button
                                                type="button"
                                                class="btn btn-warning btn-sm me-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#editMandateModal"
                                                data-id="<?= $mandate['id'] ?>"
                                                data-year="<?= esc($mandate['year']) ?>"
                                                data-description="<?= esc($mandate['description']) ?>"
                                            >
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm"
                                                data-action="delete"
                                                data-id="<?= $mandate['id'] ?>"
                                            >
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-center text-muted">No mandate records found.</td></tr>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Mandate Modal -->
    <div class="modal fade" id="addMandateModal" tabindex="-1" aria-labelledby="addMandateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="addMandateForm">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="addMandateModalLabel">Add New Mandate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="number" class="form-control" name="year" id="addMandateYear" required min="1900" max="2100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" required minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="addSubmitBtn" type="submit" class="btn btn-success">
                        <span class="btn-text">Add Mandate</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Mandate Modal -->
    <div class="modal fade" id="editMandateModal" tabindex="-1" aria-labelledby="editMandateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="editMandateForm">
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="editMandateId">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMandateModalLabel">Edit Mandate</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                    <label class="form-label">Year</label>
                    <input type="number" class="form-control" name="year" id="editMandateYear" required min="1900" max="2100" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editMandateDescription" required minlength="10"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="editSubmitBtn" type="submit" class="btn btn-primary">
                        <span class="btn-text">Save changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toasts -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="appToast" class="toast align-items-center text-bg-success border-0" role="status" aria-live="polite" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">Action completed.</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Enhanced dropdown functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById("toggle-gad-maintenance");
            const parentItem = toggleButton.parentElement;

            // Toggle submenu on click
            toggleButton.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open dropdowns
                document.querySelectorAll('.nav-item.showMenu').forEach(item => {
                    if (item !== parentItem) {
                        item.classList.remove('showMenu');
                    }
                });

                // Toggle current dropdown
                parentItem.classList.toggle("showMenu");

                // Add visual feedback
                if (parentItem.classList.contains("showMenu")) {
                    toggleButton.style.backgroundColor = 'var(--sidebar-hover)';
                } else {
                    toggleButton.style.backgroundColor = 'transparent';
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!parentItem.contains(e.target)) {
                    parentItem.classList.remove('showMenu');
                    toggleButton.style.backgroundColor = 'transparent';
                }
            });

            // Keep dropdown open since we're on a submenu page
            parentItem.classList.add('showMenu');
        });

        // Base endpoints (keep consistent with routes)
        const BASE = '<?= site_url('Secretariat/GadMandateManagement') ?>';
        const CSRF_HEADER = document.querySelector('meta[name="csrf-header"]').getAttribute('content');
        let CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Helpers
        function showToast(message, type = 'success') {
            const toastEl = document.getElementById('appToast');
            toastEl.classList.remove('text-bg-success', 'text-bg-danger', 'text-bg-warning');
            toastEl.classList.add(type === 'success' ? 'text-bg-success' : (type === 'warning' ? 'text-bg-warning' : 'text-bg-danger'));
            toastEl.querySelector('.toast-body').textContent = message;
            bootstrap.Toast.getOrCreateInstance(toastEl).show();
        }

        function toggleButtonLoading(btn, isLoading) {
            const spinner = btn.querySelector('.spinner-border');
            const text = btn.querySelector('.btn-text');
            if (isLoading) {
                btn.setAttribute('disabled', 'disabled');
                spinner.classList.remove('d-none');
                text.classList.add('d-none');
            } else {
                btn.removeAttribute('disabled');
                spinner.classList.add('d-none');
                text.classList.remove('d-none');
            }
        }

        function refreshMandateTable() {
            // Simple approach: reload page after operations
            location.reload();
        }

        // Default year in Add modal
        (function primeAddYear() {
            const y = document.getElementById('addMandateYear');
            if (y && !y.value) y.value = new Date().getFullYear();
        })();

        // Add Mandate
        const addForm = document.getElementById('addMandateForm');
        const addModalEl = document.getElementById('addMandateModal');
        const addModal = bootstrap.Modal.getOrCreateInstance(addModalEl);
        addForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('addSubmitBtn');
            toggleButtonLoading(submitBtn, true);

            try {
                const formData = new FormData(addForm); // includes csrf
                const res = await fetch(`${BASE}/save`, { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    addModal.hide();
                    showToast('GAD Mandate saved successfully.', 'success');
                    refreshMandateTable();
                } else {
                    showToast(data.message || 'Validation failed.', 'danger');
                    if (data.errors) console.warn('Validation errors:', data.errors);
                }
            } catch (err) {
                console.error(err);
                showToast('Network error while saving mandate.', 'danger');
            } finally {
                toggleButtonLoading(submitBtn, false);
            }
        });
        addModalEl.addEventListener('hidden.bs.modal', () => addForm.reset());

        const editModalEl = document.getElementById('editMandateModal');
        const editModal = bootstrap.Modal.getOrCreateInstance(editModalEl);
        editModalEl.addEventListener('show.bs.modal', (event) => {
            const btn = event.relatedTarget;
            if (!btn) return;
            document.getElementById('editMandateId').value = btn.getAttribute('data-id') || '';
            document.getElementById('editMandateYear').value = btn.getAttribute('data-year') || '';
            document.getElementById('editMandateDescription').value = btn.getAttribute('data-description') || '';
        });

        // Update Mandate
        const editForm = document.getElementById('editMandateForm');
        editForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const submitBtn = document.getElementById('editSubmitBtn');
            toggleButtonLoading(submitBtn, true);

            try {
                const formData = new FormData(editForm); // includes csrf
                const res = await fetch(`${BASE}/save`, { method: 'POST', body: formData });
                const data = await res.json();
                if (data.success) {
                    editModal.hide();
                    showToast('GAD Mandate updated successfully.', 'success');
                    refreshMandateTable();
                } else {
                    showToast(data.message || 'Update failed.', 'danger');
                    if (data.errors) console.warn('Validation errors:', data.errors);
                }
            } catch (err) {
                console.error(err);
                showToast('Network error while updating mandate.', 'danger');
            } finally {
                toggleButtonLoading(submitBtn, false);
            }
        });

        // Delete Mandate (event delegation)
        document.getElementById('mandateTableBody').addEventListener('click', async (e) => {
            const btn = e.target.closest('button[data-action="delete"]');
            if (!btn) return;

            const id = btn.getAttribute('data-id');
            if (!id) return;

            if (!confirm('Are you sure you want to delete this mandate?')) return;

            try {
                const res = await fetch(`${BASE}/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        [CSRF_HEADER]: CSRF_TOKEN
                    }
                });
                const data = await res.json();
                if (data.success) {
                    showToast('GAD Mandate deleted successfully.', 'success');
                    refreshMandateTable();
                } else {
                    showToast(data.message || 'Delete failed.', 'danger');
                }
            } catch (err) {
                console.error(err);
                showToast('Network error while deleting mandate.', 'danger');
            }
        });
    </script>
</body>
</html>

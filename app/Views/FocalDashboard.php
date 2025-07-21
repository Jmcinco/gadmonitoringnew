<?php
// Check if user is logged in and has the correct role
if (!session()->get('isLoggedIn') || session()->get('role_id') != 1) {
    session()->setFlashdata('error', 'Unauthorized access.');
    header('Location: ' . base_url('/login'));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOCAL DASHBOARD</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .navbar {
            font-family: 'Poppins', sans-serif;

        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #241444;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-shield-check"></i> GAD Management System
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('FocalDashboard') ?>">
                            <i class="bi bi-house-door"></i> FOCAL DASHBOARD
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-clipboard-check"></i> GAD Activities
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?= base_url('Focal/PlanPreparation') ?>">GAD Plan
                                    Preparation</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/BudgetCrafting') ?>">Budget
                                    Crafting</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/PlanReview') ?>">Review &
                                    Approval of GAD Plan</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/ConsolidatedPlan') ?>">Generate
                                    Consolidated Plan &
                                    Budget</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">Submit
                                    GAD
                                    Accomplishment</a></li>
                            <li><a class="dropdown-item" href="<?= base_url('Focal/ReviewApproval') ?>">Review &
                                    Approval</a></li>
                            <li><a class="dropdown-item"
                                    href="<?= base_url('Focal/ConsolidatedAccomplishment') ?>">Generate
                                    Consolidated GAD Accomplishment</a></li>
                        </ul>
                    </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <?php echo session()->get('first_name') . ' ' . session()->get('last_name'); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?php echo site_url('login/logout'); ?>"><i
                                            class="bi bi-box-arrow-right"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
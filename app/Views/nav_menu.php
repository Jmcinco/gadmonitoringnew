<?php
// app/Views/nav_menu.php
?>
<ul class="nav nav-pills flex-column">
    <li class="nav-item">
        <a class="nav-link active" href="<?= base_url('FocalDashboard') ?>">
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
        <a class="nav-link" href="<?= base_url('Focal/AccomplishmentSubmission') ?>">
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
    <li class="nav-item">
        <a class="nav-link" href="<?= base_url('Focal/MonitoringEvaluation') ?>">
            <i class="bi bi-graph-up me-2"></i>Monitoring & Evaluation
        </a>
    </li>
</ul>
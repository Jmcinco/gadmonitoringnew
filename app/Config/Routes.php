<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Home and Authentication Routes
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate');
$routes->get('/login/logout', 'LoginController::logout');

// Admin Panel Routes
$routes->get('/AdminDashboard', 'AdminController::dashboard');
$routes->group('Admin', function($routes) {
    $routes->get('EmployeesManagement', 'AdminController::index');
    $routes->post('Employees/store', 'AdminController::store');
    $routes->post('Employees/update/(:num)', 'AdminController::update/$1');
    $routes->post('Employees/delete/(:num)', 'AdminController::delete/$1');
});

// Audit Trail Routes
$routes->group('AuditTrail', function($routes) {
    $routes->get('/', 'AuditTrailController::index');
    $routes->post('getAuditLogs', 'AuditTrailController::getAuditLogs');
    $routes->get('exportCSV', 'AuditTrailController::exportCSV');
    $routes->post('getStats', 'AuditTrailController::getStats');
    $routes->post('clearOldLogs', 'AuditTrailController::clearOldLogs');
});

// Member Routes (GAD Plan Review & Approval)
$routes->get('MemberDashboard', 'MemberController::dashboard');
$routes->group('Member', function($routes) {
    $routes->get('dashboard', 'MemberController::dashboard');
    $routes->get('planReview', 'MemberController::planReview');
    $routes->get('PlanReview', 'MemberController::planReview'); // Alternative route
    $routes->post('reviewPlan', 'MemberController::reviewPlan');
    $routes->post('updateStatus', 'MemberController::updateStatus');
    $routes->get('getGadPlan/(:num)', 'MemberController::getGadPlan/$1');
    $routes->get('getPlanDetails/(:num)', 'MemberController::getPlanDetails/$1');
    $routes->post('getPlanDetails/(:num)', 'MemberController::getPlanDetails/$1');
    $routes->get('reports', 'MemberController::reports');
    // Accomplishment Review Routes
    $routes->get('ReviewApproval', 'MemberController::reviewApproval');
    $routes->get('reviewApproval', 'MemberController::reviewApproval');
    $routes->post('reviewAccomplishment', 'MemberController::reviewAccomplishment');
    $routes->post('updateAccomplishmentStatus', 'MemberController::updateAccomplishmentStatus');
    $routes->get('getAccomplishmentDetails/(:num)', 'MemberController::getAccomplishmentDetails/$1');
    $routes->post('reviewAccomplishment', 'MemberController::reviewAccomplishment');
    $routes->post('updateAccomplishmentStatus', 'MemberController::updateAccomplishmentStatus');
    $routes->get('profile', 'MemberController::profile');
});

// Secretariat Routes (GAD Plan Final Review)
$routes->group('Secretariat', function($routes) {
    $routes->post('finalizePlan', 'SecretariatController::finalizePlan');
    $routes->post('archivePlan', 'SecretariatController::archivePlan');
    $routes->get('getGadPlan/(:num)', 'SecretariatController::getGadPlan/$1');
});


// Employee Group Routes
$routes->group('employees', function($routes) {
    $routes->get('/', 'AdminController::employees');
    $routes->get('create', 'AdminController::create');
    $routes->post('create', 'AdminController::create');
    $routes->get('edit/(:num)', 'AdminController::edit/$1');
    $routes->post('edit/(:num)', 'AdminController::edit/$1');
    $routes->get('delete/(:num)', 'AdminController::delete/$1');
});

// Update Passwords (Admin Only)
$routes->post('/update-passwords', 'HashPasswordsController::updateAllPasswords');

// Focal Controller Routes
$routes->get('/FocalDashboard', 'FocalController::dashboard');
$routes->get('/Focal/PlanPreparation', 'FocalController::planPreparation');
$routes->get('/Focal/PlanReview', 'FocalController::planReview');
$routes->get('/Focal/getPlanDetails/(:num)', 'FocalController::getPlanDetails/$1');
$routes->post('/Focal/updateStatus', 'FocalController::updateStatus');
$routes->get('/Focal/BudgetCrafting', 'FocalController::budgetCrafting');
$routes->get('/Focal/ConsolidatedPlan', 'FocalController::consolidatedPlan');
$routes->get('Focal/ReviewApproval', 'FocalController::reviewApproval');
$routes->get('/Focal/AccomplishmentSubmission', 'FocalController::accomplishmentSubmission');
$routes->post('/Focal/saveAccomplishment', 'FocalController::saveAccomplishment');
$routes->post('/Focal/updateAccomplishment', 'FocalController::updateAccomplishment');
$routes->delete('/Focal/deleteAccomplishment/(:num)', 'FocalController::deleteAccomplishment/$1');
$routes->get('/Focal/getAccomplishment/(:num)', 'FocalController::getAccomplishment/$1');
$routes->post('/Focal/updateAccomplishmentStatus', 'FocalController::updateAccomplishmentStatus');
$routes->get('/Focal/getAllGadPlans', 'FocalController::getAllGadPlans');
$routes->get('/Focal/getGadPlanById/(:num)', 'FocalController::getGadPlanById/$1');
$routes->get('/Focal/getAvailableGadPlans', 'FocalController::getAvailableGadPlans');
$routes->get('/Focal/ConsolidatedAccomplishment', 'FocalController::consolidatedAccomplishment');


//Secretariat Dashboard Routes
$routes->get('/SecretariatDashboard', 'SecretariatController::dashboard');
$routes->group('Secretariat', function($routes) {
    // PAP Routes
    $routes->get('MfoPap', 'PapController::index');
    $routes->post('MfoPap/store', 'PapController::store');
    $routes->post('MfoPap/update/(:num)', 'PapController::update/$1');
    $routes->post('MfoPap/delete/(:num)', 'PapController::delete/$1');

    // MFO Routes
    $routes->post('Mfo/store', 'MfoController::store');
    $routes->post('Mfo/update/(:num)', 'MfoController::update/$1');
    $routes->post('Mfo/delete/(:num)', 'MfoController::delete/$1');
});

$routes->group('Secretariat', function($routes) {
    $routes->get('DivisionManagement', 'DivisionController::index');
    $routes->post('Division/store', 'DivisionController::store');
    $routes->post('Division/update/(:num)', 'DivisionController::update/$1');
    $routes->post('Division/delete/(:num)', 'DivisionController::delete/$1');
});

$routes->group('Secretariat', function($routes) {
    $routes->get('PositionsManagement', 'PositionController::index');
    $routes->post('Positions/store', 'PositionController::store');
    $routes->post('Positions/update/(:num)', 'PositionController::update/$1');
    $routes->post('Positions/delete/(:num)', 'PositionController::delete/$1');
});

$routes->group('Secretariat', ['namespace' => 'App\Controllers'], static function ($routes) {
    // Use GadMandateManagement everywhere
    $routes->get('GadMandateManagement', 'GadMandateController::index');
    $routes->get('GadMandateManagement/get', 'GadMandateController::getMandates');
    $routes->post('GadMandateManagement/save', 'GadMandateController::save');
    $routes->post('GadMandateManagement/delete/(:num)', 'GadMandateController::delete/$1');
    $routes->delete('GadMandateManagement/delete/(:num)', 'GadMandateController::delete/$1');

    // (Optional) backward-compat: old paths redirect to the new one
    $routes->get('GadMandate', static fn() => redirect()->to(site_url('Secretariat/GadMandateManagement')));
});

// Gad Plan Routes
$routes->get('GadPlanController/getGadPlan/(:num)', 'GadPlanController::getGadPlan/$1');
$routes->post('GadPlanController/deleteGadPlan/(:num)', 'GadPlanController::deleteGadPlan/$1');
$routes->post('GadPlanController/save(/:num)?', 'GadPlanController::save/$1');
$routes->post('GadPlanController/save-draft', 'GadPlanController::saveDraft');
$routes->post('GadMandateController/getMandates', 'GadMandateController::getMandates');
$routes->post('GadMandateController/save', 'GadMandateController::save');
$routes->post('GadMandateController/delete/(:num)', 'GadMandateController::delete/$1');
$routes->get('GadMandateController/getMandate/(:num)', 'GadMandateController::getMandate/$1');
$routes->post('GadMandateController/deleteMandate/(:num)', 'GadMandateController::delete/$1');


// Focal Controller Budget Crafting Routes
$routes->get('FocalController/budgetCrafting', 'FocalController::budgetCrafting');
$routes->post('FocalController/addBudgetItem', 'FocalController::addBudgetItem');
$routes->post('FocalController/editBudgetItem', 'FocalController::editBudgetItem');
$routes->post('FocalController/deleteBudgetItem', 'FocalController::deleteBudgetItem');
$routes->get('Focal/getAttachments', 'FocalController::getAttachments');

// File Upload and Serving Routes
$routes->get('Uploads/(:any)', 'FileController::serve/$1');
$routes->get('Downloads/(:any)', 'FileController::download/$1');

// View Routes
$routes->get('/Views/FocalDashboard', function() {
    return view('FocalDashboard');
});

// Test Routes (Optional for debugging)
$routes->get('/test-database', 'TestController::testDatabase');

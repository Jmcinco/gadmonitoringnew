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
$routes->get('/Focal/BudgetCrafting', 'FocalController::budgetCrafting');
$routes->get('/Focal/ConsolidatedPlan', 'FocalController::consolidatedPlan');
$routes->get('Focal/ReviewApproval', 'FocalController::reviewApproval');
$routes->get('/Focal/AccomplishmentSubmission', 'FocalController::accomplishmentSubmission');
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

$routes->group('Secretariat', function($routes) {
    $routes->get('GadMandateManagement', 'GadMandateController::index');
    $routes->get('GadMandate/getMandates', 'GadMandateController::getMandates');
    $routes->post('GadMandate/save', 'GadMandateController::save');
    $routes->post('GadMandate/delete/(:num)', 'GadMandateController::delete/$1');
});


// Gad Plan Routes
$routes->get('GadPlanController/getGadPlan/(:num)', 'GadPlanController::getGadPlan/$1');
$routes->post('GadPlanController/deleteGadPlan/(:num)', 'GadPlanController::deleteGadPlan/$1');
$routes->post('GadPlanController/save(/:num)?', 'GadPlanController::save/$1');
$routes->post('GadPlanController/save-draft', 'GadPlanController::saveDraft');
$routes->post('GadMandateController/getMandates', 'GadMandateController::getMandates');
$routes->post('GadMandateController/save', 'GadMandateController::save');
$routes->post('GadMandateController/delete/(:num)', 'GadMandateController::delete/$1');

// Focal Controller Budget Crafting Routes
$routes->get('FocalController/budgetCrafting', 'FocalController::budgetCrafting');
$routes->post('FocalController/addBudgetItem', 'FocalController::addBudgetItem');
$routes->post('FocalController/editBudgetItem', 'FocalController::editBudgetItem');
$routes->post('FocalController/deleteBudgetItem', 'FocalController::deleteBudgetItem');

// File Upload and Serving Routes
$routes->get('Uploads/(:any)', 'FileController::serve/$1');

// View Routes
$routes->get('/Views/FocalDashboard', function() {
    return view('FocalDashboard');
});

// Test Routes (Optional for debugging)
$routes->get('/test-database', 'TestController::testDatabase');

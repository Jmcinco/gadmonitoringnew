<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/login', 'LoginController::index');
$routes->post('/login/authenticate', 'LoginController::authenticate'); 
$routes->post('GadPlanController/save', 'GadPlanController::save');
$routes->get('/login/logout', 'LoginController::logout');
$routes->get('/update-passwords', 'HashPasswordsController::updateAllPasswords');

$routes->get('/FocalDashboard', 'FocalController::dashboard');
$routes->get('/Focal/PlanPreparation', 'FocalController::planPreparation');
$routes->get('/Focal/PlanReview', 'FocalController::planReview');
$routes->get('/Focal/BudgetCrafting', 'FocalController::budgetCrafting');
$routes->get('/Focal/ConsolidatedPlan', 'FocalController::consolidatedPlan'); 
$routes->get('/Focal/ReviewApproval', 'FocalController::reviewApproval');
$routes->get('/Focal/AccomplishmentSubmission', 'FocalController::accomplishmentSubmission');
$routes->get('/Focal/ConsolidatedAccomplishment', 'FocalController::consolidatedAccomplishment');

$routes->get('/Views/FocalDashboard', function() { return view('FocalDashboard'); });
$routes->get('/Views/FocalDashboard', function() { return view('FocalDashboard'); });
$routes->get('/Views/FocalDashboard', function() { return view('FocalDashboard'); });

//GAD PLAN
$routes->get('GadPlanController/getGadPlan/(:num)', 'GadPlanController::getGadPlan/$1');
$routes->post('GadPlanController/deleteGadPlan/(:num)', 'GadPlanController::deleteGadPlan/$1');
$routes->post('GadPlanController/save(/:num)?', 'GadPlanController::save/$1');


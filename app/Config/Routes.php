<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;
use App\Controllers\ResearcherController;
use App\Controllers\SharedController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route to Home controller
// entry point of the application
// login routes
$routes->get('/', [AuthController::class, 'index']); 

// Authentication routes
$routes->post('/authenticate/login', [AuthController::class, 'login']);
$routes->get('/authenticate/logout', [AuthController::class, 'logout']);

// Register routes
$routes->get('/register', [AuthController::class, 'registerForm']);
$routes->post('/authenticate/register', [AuthController::class, 'register']);

// Define routes for other parts of the application
$routes->get('/admin-dashboard', [AdminController::class, 'index']);
$routes->post('/admin-dashboard/update-status', [AdminController::class, 'updateDocument']);
$routes->get('/admin-dashboard/download/(:segment)', [AdminController::class, 'downloadDocument/$1']);
$routes->post('/admin-dashboard/delete/(:segment)', [AdminController::class, 'deleteDocument/$1']);

$routes->get('/admin-dashboard/document-tracker', [SharedController::class, 'trackingDocument']);
$routes->post('/admin-dashboard/document-tracker/update-status', [SharedController::class, 'updateDocument']);
$routes->post('/admin-dashboard/document-tracker/delete/(:segment)', [SharedController::class, 'deleteDocument/$1']);
$routes->get('/admin-dashboard/document-tracker/download/(:segment)', [AdminController::class, 'downloadDocument/$1']);

// researcher routes
$routes->get('/researcher-dashboard', [ResearcherController::class, 'index']);
$routes->get('/researcher-tracking', [ResearcherController::class, 'tracking']);

$routes->get('/researcher-dashboard/download/(:segment)', [ResearcherController::class, 'downloadDocument/$1']);
$routes->post('/researcher-dashboard/delete/(:segment)', [ResearcherController::class, 'deleteDocument/$1']);

$routes->post('/upload-document', [ResearcherController::class, 'uploadDocument']);
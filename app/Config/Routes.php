<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'AuthController::login');

// Authentication routes
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::storeUser');

// Unauthorized access
$routes->get('/unauthorized', function () {
    echo "You are not authorized to access this page.";
});

// Protected routes (requires authentication)
$routes->group('', ['filter' => 'auth'], function ($routes) {
    // Dashboard
    $routes->get('/dashboard', 'DashboardController::index');
    
    // Public book routes (authenticated users)
    $routes->get('/books', 'BooksController::index');
    $routes->get('/books/track/(:num)', 'BooksController::trackBook/$1');
    
    // Admin only book routes
    $routes->group('', ['filter' => 'auth:admin'], function($routes) {
        $routes->get('/books/create', 'BooksController::create');
        $routes->post('/books/store', 'BooksController::store');
        $routes->get('/books/edit/(:num)', 'BooksController::edit/$1');
        $routes->post('/books/update/(:num)', 'BooksController::update/$1');
        $routes->delete('/books/(:num)', 'BooksController::delete/$1');
        $routes->get('/books/get/(:num)', 'BooksController::get/$1');
        $routes->get('/dashboard/statistics', 'DashboardAnalyticsController::getStatistics');
    });
    
    // Borrower routes
    $routes->group('borrowers', function($routes) {
        $routes->get('/', 'BorrowerController::listBorrowers');
        $routes->get('create', 'BorrowerController::create');
        $routes->post('/', 'BorrowerController::store');
        $routes->post('return/(:num)', 'BorrowerController::returnBook/$1');
    });
});

// API routes (if needed)
$routes->group('api', function($routes) {
    $routes->group('books', function($routes) {
        $routes->get('/', 'BooksController::getAll');
        $routes->get('(:num)', 'BooksController::getOne/$1');
        $routes->post('/', 'BooksController::create', ['filter' => 'auth:admin']);
        $routes->put('(:num)', 'BooksController::update/$1', ['filter' => 'auth:admin']);
        $routes->delete('(:num)', 'BooksController::delete/$1', ['filter' => 'auth:admin']);
    });
});

// Error pages
$routes->set404Override(function() {
    return view('errors/404');
});
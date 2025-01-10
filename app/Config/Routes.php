<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'AuthController::login');


// Routes
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate');
$routes->get('/logout', 'AuthController::logout');
$routes->get('/unauthorized', function () {
    echo "You are not authorized to access this page.";
});

$routes->group('', ['filter' => 'auth'], function ($routes) {
    $routes->get('/dashboard', 'DashboardController::index');
    $routes->get('/books', 'BooksController::index'); // View list of books
    $routes->get('/books/create', 'BooksController::create', ['filter' => 'auth:admin']); // Add book (admin only)
    $routes->post('/books/store', 'BooksController::store', ['filter' => 'auth:admin']); // Save book (admin only)
    $routes->get('/books/edit/(:num)', 'BooksController::edit/$1', ['filter' => 'auth:admin']); // Edit book
    $routes->post('/books/update/(:num)', 'BooksController::update/$1', ['filter' => 'auth:admin']); // Update book
    $routes->delete('/books/(:num)', 'BooksController::delete/$1', ['filter' => 'auth:admin']);

});
$routes->get('/books/get/(:num)', 'BooksController::get/$1', ['filter' => 'auth:admin']);
$routes->get('/register', 'AuthController::register');
$routes->post('/register', 'AuthController::storeUser');

$routes->get('/books/track/(:num)', 'BooksController::trackBook/$1');

$routes->get('/borrowers', 'BorrowerController::listBorrowers'); // List semua peminjaman
$routes->get('/borrowers/create', 'BorrowerController::create'); // Form untuk tambah peminjaman
$routes->post('/borrowers', 'BorrowerController::store'); // Simpan data peminjaman
$routes->post('/borrowers/return/(:num)', 'BorrowerController@returnBook/$1'); // Kembalikan buku



<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'HomeController::index');
$routes->get('/about-us', 'AboutUsController::index');
$routes->get('/commercial-network', 'CommercialNetworkController::index');
$routes->get('/contact-us', 'ContactUsController::index');
$routes->get('/documentations', 'DocumentationsController::index');
$routes->get('/exhibitions', 'ExhibitionsController::index');
$routes->get('/news', 'NewsController::index');
$routes->get('/privacy-policy', 'PrivacyPolicyController::index');
$routes->get('/products', 'ProductsController::index');
$routes->get('/quality-policy', 'QualityPolicyController::index');

//Administrator Routes
$routes->get('/admin/dashboard', 'Admin\DashboardController::index');
$routes->get('/admin/login', 'Admin\LoginController::index');
$routes->post('/admin/authenticate', 'Admin\LoginController::authenticate');
$routes->get('/admin/logout', 'Admin\LogoutController::index');
$routes->get('/admin/add-user', 'Admin\AddUserController::index');
$routes->post('/admin/adduser/insert', 'Admin\AddUserController::insert');
$routes->get('/admin/user-masterlist', 'Admin\UserMasterlistController::index');
$routes->post('/admin/usermasterlist/getData', 'Admin\UserMasterlistController::getData');
$routes->get('/admin/usermasterlist/downloadCSV', 'Admin\UserMasterlistController::downloadCSV');
$routes->delete('/admin/usermasterlist/delete/(:num)', 'Admin\UserMasterlistController::delete/$1');
$routes->get('/admin/edit-user/(:num)', 'Admin\EditUserController::index/$1');
$routes->post('/admin/edituser/update', 'Admin\EditUserController::update');
$routes->get('/admin/messages', 'Admin\MessagesController::index');
$routes->post('/admin/messages/getData', 'Admin\MessagesController::getData');
$routes->delete('/admin/messages/delete/(:num)', 'Admin\MessagesController::delete/$1');
$routes->get('/admin/send-newsletter', 'Admin\SendNewsLetterController::index');
$routes->post('/admin/sendnewsletter/sendMessage', 'Admin\SendNewsLetterController::sendMessage');
$routes->get('/admin/subscribers-masterlist', 'Admin\SubscribersController::index');
$routes->get('/admin/subscribers/getData', 'Admin\SubscribersController::getData');
$routes->delete('/admin/subscribers/delete/(:num)', 'Admin\SubscribersController::delete/$1');
$routes->get('/admin/add-product', 'Admin\AddProductController::index');
$routes->post('/admin/addproduct/insert', 'Admin\AddProductController::insert');
$routes->get('/admin/addproduct/getCategories', 'Admin\AddProductController::getCategories');
$routes->post('/admin/addproduct/addCategory', 'Admin\AddProductController::addCategory');
$routes->delete('/admin/addproduct/deleteCategory/(:num)', 'Admin\AddProductController::deleteCategory/$1');

require APPPATH . 'Config/ProductsRoutes.php';

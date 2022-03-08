<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;
use App\Middleware\UserAuthMiddleware;
use App\Middleware\AdminAuthMiddleware;

return function (App $app) {
    // Redirect to Swagger documentation

    $app->get('/home', \App\Action\HomeAction::class)->setName('home')->add(UserAuthMiddleware::class);
    $app->get('/standart_room', \App\Action\Web\StandartRoomAction::class)->setName('standart_room')->add(UserAuthMiddleware::class);
    $app->get('/superior_room', \App\Action\Web\SuperiorRoomAction::class)->setName('superior_room')->add(UserAuthMiddleware::class);
    $app->get('/delux_room', \App\Action\Web\DeluxRoomAction::class)->setName('delux_room')->add(UserAuthMiddleware::class);
    $app->get('/suite_room', \App\Action\Web\SuiteRoomAction::class)->setName('suite_room')->add(UserAuthMiddleware::class);
    
    $app->get('/login_user', \App\Action\Web\LoginUserAction::class)->setName('login_user');
    $app->post('/login_user', \App\Action\LoginUserSubmitAction::class);
    $app->get('/logout_user', \App\Action\LogoutUserAction::class)->setName('logout');
    $app->get('/sign_up_user', \App\Action\Web\SignUpUserAction::class)->setName('sign_up_user');

    $app->get('/login', \App\Action\LoginAction::class)->setName('login');
    $app->post('/login', \App\Action\LoginSubmitAction::class);
    $app->get('/logout', \App\Action\LogoutAction::class)->setName('logout');

    $app->get('/rooms', \App\Action\Web\RoomAction::class)->add(AdminAuthMiddleware::class);
    
    $app->get('/bookings', \App\Action\Web\BookingAction::class)->add(AdminAuthMiddleware::class);

    $app->get('/payment', \App\Action\Web\PaymentAction::class)->add(AdminAuthMiddleware::class);

    $app->get('/users', \App\Action\Web\UserAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/edit_user', \App\Action\Web\UserEditAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/add_user', \App\Action\Web\UserAddAction::class)->add(AdminAuthMiddleware::class);

};

<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;
use App\Middleware\UserAuthMiddleware;

return function (App $app) {
    // Redirect to Swagger documentation

    $app->get('/home', \App\Action\HomeAction::class)->setName('home');
    $app->get('/standart_room', \App\Action\Web\StandartRoomAction::class)->setName('standart_room');
    $app->get('/superior_room', \App\Action\Web\SuperiorRoomAction::class)->setName('superior_room');
    $app->get('/delux_room', \App\Action\Web\DeluxRoomAction::class)->setName('delux_room');
    $app->get('/suite_room', \App\Action\Web\SuiteRoomAction::class)->setName('suite_room');
    
    $app->get('/login_user', \App\Action\Web\LoginUserAction::class)->setName('login_user');
    $app->get('/sign_up_user', \App\Action\Web\SignUpUserAction::class)->setName('sign_up_user');

    $app->get('/login', \App\Action\LoginAction::class)->setName('login');
    $app->post('/login', \App\Action\LoginSubmitAction::class);
    $app->get('/logout', \App\Action\LogoutAction::class)->setName('logout');

    $app->get('/rooms', \App\Action\Web\RoomAction::class)->add(UserAuthMiddleware::class);
    
    $app->get('/bookings', \App\Action\Web\BookingAction::class)->add(UserAuthMiddleware::class);

    $app->get('/payment', \App\Action\Web\PaymentAction::class)->add(UserAuthMiddleware::class);

    // Swagger API documentation
    $app->get('/docs/v1', \App\Action\Documentation\SwaggerUiAction::class)->setName('docs');

    $app->get('/', \App\Action\Web\HomeAction::class)->setName('home')->add(UserAuthMiddleware::class);
    $app->get('/users', \App\Action\Web\UserAction::class)->add(UserAuthMiddleware::class);
    $app->post('/edit_user', \App\Action\Web\UserEditAction::class)->add(UserAuthMiddleware::class);
    $app->post('/add_user', \App\Action\Web\UserAddAction::class)->add(UserAuthMiddleware::class);

    
};

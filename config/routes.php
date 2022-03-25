<?php

// Define app routes

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Tuupola\Middleware\HttpBasicAuthentication;
use App\Middleware\UserAuthMiddleware;
use App\Middleware\AdminAuthMiddleware;

return function (App $app) {
    // main
    $app->get('/', \App\Action\HomeAction::class)->setName('home')->add(UserAuthMiddleware::class);
    // Redirect to Swagger documentation
    $app->get('/home', \App\Action\HomeAction::class)->setName('home')->add(UserAuthMiddleware::class);
    $app->get('/standart_room', \App\Action\Web\StandartRoomAction::class)->setName('standart_room')->add(UserAuthMiddleware::class);
    $app->get('/superior_room', \App\Action\Web\SuperiorRoomAction::class)->setName('superior_room')->add(UserAuthMiddleware::class);
    $app->get('/delux_room', \App\Action\Web\DeluxRoomAction::class)->setName('delux_room')->add(UserAuthMiddleware::class);
    $app->get('/suite_room', \App\Action\Web\SuiteRoomAction::class)->setName('suite_room')->add(UserAuthMiddleware::class);
    
    $app->get('/login_user', \App\Action\Web\LoginUserAction::class)->setName('login_user');
    $app->post('/login_user', \App\Action\LoginUserSubmitAction::class);
    $app->get('/logout_user', \App\Action\LogoutUserAction::class)->setName('logout');

    $app->get('/sign_up_user', \App\Action\Web\SignUpUserAction::class);
    $app->post('/sign_up_user_submit', \App\Action\Web\SignUpUserSubmitAction::class);

    $app->get('/user_booking', \App\Action\Web\BookingUserAction::class)->setName('user_booking')->add(UserAuthMiddleware::class);
    $app->post('/user_booking_submit', \App\Action\Web\BookingUserSubmitAction::class)->add(UserAuthMiddleware::class);
    $app->get('/user_booking_history', \App\Action\Web\BookingUserHistoryAction::class)->setName('user_booking_history')->add(UserAuthMiddleware::class);
    $app->post('/user_booking_cencel', \App\Action\Web\BookingUserCancelAction::class)->setName('user_booking_cencel')->add(UserAuthMiddleware::class);

    $app->get('/payment_user', \App\Action\Web\PaymentUserAction::class)->setName('payment_user')->add(UserAuthMiddleware::class);
    $app->post('/payment_user_submit', \App\Action\Web\PaymentUserDepositSubmitAction::class)->add(UserAuthMiddleware::class);

    $app->get('/login', \App\Action\LoginAction::class)->setName('login');
    $app->post('/login', \App\Action\LoginSubmitAction::class);
    $app->get('/logout', \App\Action\LogoutAction::class)->setName('logout');

    $app->get('/rooms', \App\Action\Web\RoomAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/add_rooms', \App\Action\Web\RoomAddAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/edit_rooms', \App\Action\Web\RoomEditAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/delete_rooms', \App\Action\Web\RoomDeleteAction::class)->add(AdminAuthMiddleware::class);
    
    $app->get('/bookings', \App\Action\Web\BookingAction::class)->add(AdminAuthMiddleware::class);
    $app->get('/bookings_check_in', \App\Action\Web\BookingCheckInAction::class)->add(AdminAuthMiddleware::class);
    $app->get('/bookings_check_out', \App\Action\Web\BookingCheckOutAction::class)->add(AdminAuthMiddleware::class);

    $app->get('/payment', \App\Action\Web\PaymentAction::class)->add(AdminAuthMiddleware::class);

    $app->get('/users', \App\Action\Web\UserAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/edit_user', \App\Action\Web\UserEditAction::class)->add(AdminAuthMiddleware::class);
    $app->post('/add_user', \App\Action\Web\UserAddAction::class)->add(AdminAuthMiddleware::class);

};

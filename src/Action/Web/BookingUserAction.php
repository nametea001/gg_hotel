<?php

namespace App\Action\Web;

use App\Domain\Room\Service\RoomFinder;
use App\Domain\Booking\Service\BookingFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class BookingUserAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $roomFinder;
    private $bookingFinder;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        RoomFinder $roomFinder,
        BookingFinder $bookingFinder
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->roomFinder = $roomFinder;
        $this->bookingFinder = $bookingFinder;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $params = (array)$request->getQueryParams();
        $error = "N";
        if (!isset($params['startDate'])) {
            $params['startDate'] = date('Y-m-d', strtotime('+1 days', strtotime(date('Y-m-d'))));
            $params['endDate'] = null;
            $checkRoom['room_type'] = "Select";
        } else if (
            ($params['endDate'] == "") ||
            (!isset($params['room_type'])) ||
            ($params['startDate'] >= $params['endDate']) ||
            ($params['startDate'] < date("Y-m-d"))
        ) {
            $error = "Y";
            $checkRoom = [];
        }
        $roomsReady = [];

        if ($error == "N" && $params['endDate'] != null) {
            $checkRoom['room_type'] = $params['room_type'];
            $roomType['room_type'] = $checkRoom['room_type'];
            $rooms = $this->roomFinder->findRooms($roomType);
            $checkRoom['startDate'] = $params['startDate'];
            $checkRoom['endDate'] = $params['endDate'];
            foreach ($rooms as $room) {
                $getBooking['room_id'] = $room['id'];
                $getBooking['startDate'] = $params['startDate'];
                $getBooking['endDate'] = $params['endDate'];
                $bookings = $this->bookingFinder->findBookingsForBooking($getBooking);

                if (!$bookings) {
                    array_push($roomsReady, $room);
                }
            }

            // ถ้ามีห้องว่าง จะเป็น Y
        if ($roomsReady) {
            $checkRoom['is_empty'] = "Y";
        } else {
            $checkRoom['is_empty'] = "N";
        }
        }
        
        $viewData = [
            'user_login' => $this->session->get('user'),
            'startDate' => $params['startDate'],
            'rooms' => $roomsReady,
            'endDate' => $params['endDate'],
            'checkRoom' => $checkRoom,
            'error' => $error,
        ];

        

        return $this->twig->render($response, 'web/bookingUser.twig', $viewData);
    }
}

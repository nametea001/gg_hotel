<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
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
        } else if ($params['endDate'] == "" || !isset($params['room_type'])) {
            $error = "Y";
        }
        $checkRoom['select'] = "N";
        // $checkRoom['room_type'] = $params['room_type'];
        $roomsReady = [];
        if ($error == "N" && $params['endDate'] != null) {
            $checkRoom['room_type'] = $params['room_type'];
            $checkRoom['select'] = "N";
            $roomType['room_type'] = $checkRoom['room_type'];
            $rooms = $this->roomFinder->findRooms($roomType);
            $bookings = $this->bookingFinder->findBookingsForBooking($params);

            if ($bookings) {
                // loop booking for check room is empty
                for ($i = 0; $i < sizeof($rooms); $i++) {
                    for ($j = 0; $j < sizeof($bookings); $j++) {
                        $dateIn = $bookings[$j]['date_in'];
                        $dateOut = $bookings[$j]['date_out'];

                        // if ( //Did not reserve the room on the desired date.
                        //     ($rooms[$i]['id'] == $bookings[$j]['room_id']) &&
                        //     (($params['startDate'] <= $dateIn) && ($params['endDate'] <= $dateIn)) ||
                        //     (($params['startDate'] >= $dateOut) && ($dateOut >= $params['endDate']))
                        // ) {
                        //     array_push($roomsReady, $rooms[$i]); //if is empty push to array
                        // }
                        if ( //Did not reserve the room on the desired date.
                            ($rooms[$i]['id'] != $bookings[$j]['room_id']) &&
                            (($params['startDate'] >= $dateIn) && ($params['endDate'] <= $dateOut)) 
                        ) {
                            array_push($roomsReady, $rooms[$i]); //if is empty push to array
                        }
                    }
                }
            } else {
                $roomsReady = $rooms;
            }
            // ถ้ามีห้องว่าง จะเป็น Y
            if ($roomsReady) {
                $checkRoom['is_empty'] = "Y";
            }else{
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

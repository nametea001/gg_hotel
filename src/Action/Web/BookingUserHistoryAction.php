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
final class BookingUserHistoryAction
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
        $user =  $this->session->get('user');
        $findBooking['user_id'] = $user['id'];
        $bookings = $this->bookingFinder->findBookingsForUser($params);
        $noHistory = "N";
        if(!$bookings){
            $noHistory = "Y";
        }
        $viewData = [
            'user_login' => $this->session->get('user'),
            'bookings' => $bookings,
            'noHistory' => $noHistory,
        ];

        return $this->twig->render($response, 'web/bookingUserHistory.twig', $viewData);
    }
}

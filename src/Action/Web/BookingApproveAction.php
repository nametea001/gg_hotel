<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Domain\Booking\Service\BookingFinder;
use App\Domain\Booking\Service\BookingUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;
use Cake\Chronos\Chronos;

/**
 * Action.
 */
final class BookingApproveAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $finder;
    private $updater;


    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        BookingFinder $finder,
        BookingUpdater $updater
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->finder = $finder;
        $this->updater = $updater;
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
        $data = (array)$request->getParsedBody();
        $booking_id = $data['booking_id'];
        $get['booking_id'] =$booking_id;
        $getBooking = $this->finder->findBookingsForUser($get);
        if($getBooking[0]['status'] == "WAIT_APPROVE"){
            if ($data['select'] == "approve") {
                $dataBooking['status'] = "RESERVED";
                $this->updater->updateBooking($booking_id, $dataBooking);
            }elseif($data['select'] == "not_approve"){
                $dataBooking['status'] = "WAIT_PAY";
                $this->updater->updateBooking($booking_id, $dataBooking);
            }
        }
        
        $viewData = [
            'bookings' => $this->finder->findBookings($params),
            'user_login' => $this->session->get('user'),
        ];

        return $this->responder->withRedirect($response, "bookings", $viewData);
    }
}

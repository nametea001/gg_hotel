<?php

namespace App\Action\Web;


use App\Domain\BookingDetail\Service\BookingDetailUpdater;
use App\Domain\Booking\Service\BookingUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class ChekOutConfirmAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $bookingUpdater;
    private $bookingDetailUpdater;


    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        BookingDetailUpdater $bookingDetailUpdater,
        BookingUpdater $bookingUpdater
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->bookingDetailUpdater = $bookingDetailUpdater;
        $this->bookingUpdater = $bookingUpdater;
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
        $data = (array)$request->getParsedBody();

        $bookingId = $data['booking_id'];
        $dataBooking['status'] = "CHECK_OUT";
        $this->bookingUpdater->updateBooking($bookingId, $dataBooking);

        $bookingDetaiId = $data['book_detail_id'];
        $dataBookingDetai['check_out'] =  date('Y-m-d H:i:s');
        $this->bookingDetailUpdater->updateBookingDetail($bookingDetaiId, $dataBookingDetai);

        return $this->responder->withRedirect($response, "bookings_check_out");
    }
}

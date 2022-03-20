<?php

namespace App\Action\Web;


use App\Domain\Room\Service\RoomFinder;
use App\Domain\Booking\Service\BookingFinder;
use App\Domain\Booking\Service\BookingUpdater;
use App\Domain\BookingDetail\Service\BookingDetailUpdater;
use App\Domain\Payment\Service\PaymentUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class BookingUserCancelAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $roomFinder;
    private $bookingUpdater;
    private $bookingFinder;
    private $bookingDetaiUpdater;
    private $paymentUpdater;

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
        BookingFinder $bookingFinder,
        BookingUpdater $bookingUpdater,
        BookingDetailUpdater $bookingDetaiUpdater,
        PaymentUpdater $paymentUpdater
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->roomFinder = $roomFinder;
        $this->bookingFinder = $bookingFinder;
        $this->bookingUpdater = $bookingUpdater;
        $this->bookingDetaiUpdater = $bookingDetaiUpdater;
        $this->paymentUpdater = $paymentUpdater;
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
        $booking = $this->bookingFinder->findBookingsSigleTabel($data);
        if ($booking[0]['status'] == "WAIT_PAY") {
            $bookingId = $data['booking_id'];
            $bookingData['status'] = "CANCEL";
            $this->bookingUpdater->updateBooking($bookingId, $bookingData);
        }

        return $this->responder->withRedirect($response, "user_booking_history");
    }
}

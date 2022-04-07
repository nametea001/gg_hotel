<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Domain\Payment\Service\PaymentUpdater;
use App\Domain\Booking\Service\BookingFinder;
use App\Domain\Booking\Service\BookingUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class PaymentUserDepositSubmitAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $updater;
    private $bookingFinder;
    private $bookingUpdater;


    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        PaymentUpdater $updater,
        BookingFinder $bookingFinder,
        BookingUpdater $bookingUpdater,
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->updater = $updater;
        $this->bookingFinder = $bookingFinder;
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
        $filse = $request->getUploadedFiles();
        $paymentId = $data['payment_id'];
        $dataPayment['deposit'] = $data['deposit'];
        $this->updater->updatePayment($paymentId, $dataPayment);

        $bookingId = $data['booking_id'];
        $dataBooking['status'] = "WAIT_RESERVED";
        // $this->bookingUpdater->updateBooking($bookingId, $dataBooking);
        $booking = $this->bookingFinder->findBookingsForUser($data);
        $viewData = [
            'booking_id' => $booking[0]['id'],
        ];
        return $this->responder->withRedirect($response, "payment_user", $viewData);
    }
}

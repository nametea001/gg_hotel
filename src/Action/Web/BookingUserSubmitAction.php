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
final class BookingUserSubmitAction
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
        $getBooking['startDate'] = $data['date_in'];
        $getBooking['endDate'] = $data['date_out'];
        $getBooking['room_id'] = $data['room_id'];
        $booking = $this->bookingFinder->findBookingsForBooking($getBooking);
        if (!$booking) {
            $user = $this->session->get('user');
            $dataBoking['room_id'] = $data['room_id'];
            $dataBoking['status'] = "WAIT_PAY";
            $dataBoking['user_id'] = $user['id'];
            $dataBoking['book_detail_id'] = 0;
            $dataBoking['payment_id'] = 0;
            $dataBoking['booking_no'] = "X" . str_pad(1, 11, "0", STR_PAD_LEFT);
            $bookingId = $this->bookingUpdater->insertBookingUser($dataBoking);

            $dataBokingDetail['date_in'] = $data['date_in'];
            $dataBokingDetail['date_out'] = $data['date_out'];
            $bookingDetailId = $this->bookingDetaiUpdater->insertBookingDetail($dataBokingDetail);

            $dataPayment['deposit'] = 0;
            $dataPayment['amount'] = 0;
            $dataPayment['image_deposit'] = "null.jpg";
            $paymentId = $this->paymentUpdater->insertPayment($dataPayment);
            $dataBoking2['booking_no'] = "B" . str_pad($bookingId, 11, "0", STR_PAD_LEFT);
            $dataBoking2['book_detail_id'] = $bookingDetailId;
            $dataBoking2['payment_id'] = $paymentId;
            $this->bookingUpdater->updateBooking($bookingId, $dataBoking2);

            $viewData = [
                'booking_id' => $bookingId,
            ];
            return $this->responder->withRedirect($response, "payment_user", $viewData);
        } else {
            $viewData = [
                'startDate' => $data['date_in'],
                'endDate' => $data['date_out'],
                'room_type' => $data['room_type'],
            ];

            return $this->responder->withRedirect($response, "user_booking", $viewData);
        }
    }
}

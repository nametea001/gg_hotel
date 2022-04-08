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


        $paymentId = $data['payment_id'];

        $bookingId = $data['booking_id'];

        if (($_FILES['my_file']['name'] != "")) {
            // Where the file is going to be stored
            $file = $_FILES['my_file']['name'];
            $path = pathinfo($file);
            $ext = $path['extension'];

            if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") {
                $target_dir = "../public/upload/";
                $filename = uniqid($data['payment_id']) . "." . $ext;
                $temp_name = $_FILES['my_file']['tmp_name'];
                $path_filename_ext = $target_dir . $filename;

                // Check if file already exists
                if (file_exists($path_filename_ext)) {
                    echo "Sorry, file already exists.";
                } else {
                    move_uploaded_file($temp_name, $path_filename_ext);
                    echo "Congratulations! File Uploaded Successfully.";
                }
                $dataBooking['status'] = "WAIT_APPROVE";
                $this->bookingUpdater->updateBooking($bookingId, $dataBooking);
                $dataPayment['deposit'] = $data['deposit'];
                $dataPayment['image_deposit'] = $filename;
                $this->updater->updatePayment($paymentId, $dataPayment);
            }
            $booking = $this->bookingFinder->findBookingsForUser($data);
        }

        $viewData = [
            'booking_id' => $booking[0]['id'],
        ];
        return $this->responder->withRedirect($response, "payment_user", $viewData);
    }
}

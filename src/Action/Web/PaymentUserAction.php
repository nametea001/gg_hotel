<?php

namespace App\Action\Web;

use App\Domain\Booking\Service\BookingFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class PaymentUserAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $bookingFidner;


    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        BookingFinder $bookingFidner
    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->bookingFidner = $bookingFidner;
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
        $getBooking['booking_id'] = $params['booking_id'];
        $booking = $this->bookingFidner->findBookingsForUser($getBooking);
        
        if($booking){
            if($booking['status'] == "WAIT_PAY"){
                $notPay = "Y";
            }else{
                $notPay = "N";
            }
    
            $viewData = [
                'user_login' => $this->session->get('user'),
                'login' => "layout/layout3.twig",
                'booking' => $booking[0],
                'startDate' => $booking[0]['date_in'],
                'endDate' => $booking[0]['date_out'],
                'notPay' => $notPay,
            ];
    
            return $this->twig->render($response, 'web/paymentUser.twig', $viewData);
        }else{
            return $this->responder->withRedirect($response, "user_booking");
        }
        
    }
}

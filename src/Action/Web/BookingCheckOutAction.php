<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Domain\Booking\Service\BookingFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;
use Cake\Chronos\Chronos;
/**
 * Action.
 */
final class BookingCheckOutAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $finder;


    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Twig $twig, Session $session,Responder $responder, BookingFinder $finder)
    {
        $this->twig = $twig;
        $this->session=$session;
        $this->responder = $responder;
        $this->finder = $finder;
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

        if(!isset($params['check_out'])){
            $params['check_out']= date('Y-m-d');
        }
        $viewData = [
            'bookings' => $this->finder->findBookings($params),
            'user_login' => $this->session->get('user'),
            'checkOut' => $params['check_out'],
        ];
        

        return $this->twig->render($response, 'web/bookingCheckOut.twig',$viewData);
    }
}

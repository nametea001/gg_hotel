<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Domain\Room\Service\RoomFinder;
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

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Twig $twig, Session $session, Responder $responder,RoomFinder $roomFinder)
    {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->roomFinder = $roomFinder;
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
        if(!isset($params['startDate'])){
            $params['startDate']= date('Y-m-d',strtotime('+1 days',strtotime(date('Y-m-d'))));
            $params['endDate']= "";
        }else if($params['endDate'] == ""){
            $error = "Y";
        }

        $checkRoom['room_type'] = "STANDARD";
        $operator = (int)($params['operator']);
        
        if ($operator == 0) {
            // $data = [];
            // $rooms = $this->roomFinder->findRooms($data);
            $checkRoom['operator'] = "0";
            $checkRoom['select'] = "N";
            
            if(isset($params['room_type'])){
                $checkRoom['room_type'] = $params['room_type'];
            }
            $viewData = [
                'user_login' => $this->session->get('user'),
                'startDate' => $params['startDate'],
                'endDate' => $params['endDate'],
                'checkRoom' => $checkRoom,
                'error' => $error,
            ];
        }
        return $this->twig->render($response, 'web/bookingUser.twig', $viewData);
    }
}

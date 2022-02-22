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
final class RoomAction
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
    public function __construct(Twig $twig, Session $session,Responder $responder, RoomFinder $finder)
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
        
        $viewData = [
            'rooms' => $this->finder->findRooms($params),
            'user_login' => $this->session->get('user'),
        ];
        

        return $this->twig->render($response, 'web/room.twig',$viewData);
    }
}

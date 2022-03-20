<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Domain\Room\Service\RoomFinder;
use App\Domain\Room\Service\RoomUpdater;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class RoomEditAction
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
        RoomFinder $finder,
        RoomUpdater $updater
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
        $data = (array)$request->getParsedBody();
        $roomId = $data['room_id'];
        $this->updater->updateRoom($roomId, $data);

        return $this->responder->withRedirect($response, "rooms");
    }
}

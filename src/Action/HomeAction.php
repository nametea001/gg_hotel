<?php

namespace App\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

final class HomeAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Responder $responder, Twig $twig, Session $session)
    {
        $this->responder = $responder;
        $this->twig = $twig;
        $this->session = $session;
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
        $user = $this->session->get('user');
        if ($user) {
            $viewData = [
                'user_login' => $user,
                'login' => "layout/layout3.twig",
            ];
        } else {
            $viewData = [
                'login' => "layout/layout2.twig",
            ];
        }

        return $this->twig->render($response, 'web/home.twig', $viewData);
    }
}

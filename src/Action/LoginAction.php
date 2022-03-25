<?php

namespace App\Action;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Slim\Views\Twig;
use Psr\Http\Message\ServerRequestInterface;

final class LoginAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(Responder $responder, Twig $twig)
    {
        $this->twig = $twig;
        $this->responder = $responder;
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
        return $this->twig->render($response, 'web/login_admin.twig');
    }
}

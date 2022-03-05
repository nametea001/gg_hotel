<?php

namespace App\Action;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;

final class HomeAction
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
    public function __construct(Responder $responder, Twig $twig,)
    {
        $this->responder = $responder;
        $this->twig = $twig;
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
<<<<<<< HEAD
        $viewData = [];
        return $this->responder->withTemplate($response, 'web/home.php',$viewData);
=======
        return $this->twig->render($response, 'web/home.twig');
>>>>>>> main
    }
}
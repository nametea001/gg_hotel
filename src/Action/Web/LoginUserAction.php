<?php

namespace App\Action\Web;

use App\Domain\User\Service\UserFinder;
use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Action.
 */
final class LoginUserAction
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
    public function __construct(Twig $twig, Session $session,Responder $responder)
    {
        $this->twig = $twig;
        $this->session=$session;
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
        $params = (array)$request->getQueryParams();
        
        $user = $this->session->get('user');
        if(isset($user[0])){
            $viewData = [
                'user_login' => $user ,
            ];
        }else{
            $viewData =[];
        }
        
        return $this->twig->render($response, 'web/loginUser.twig',$viewData);
    }
}

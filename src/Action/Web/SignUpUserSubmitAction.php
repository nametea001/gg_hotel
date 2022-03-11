<?php

namespace App\Action\Web;

use App\Responder\Responder;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Views\Twig;
use Symfony\Component\HttpFoundation\Session\Session;
use Slim\Routing\RouteContext;
use App\Domain\User\Service\UserFinder;
use App\Domain\User\Service\UserCreator;
use App\Domain\User\Service\UserLoginChecker;


/**
 * Action.
 */
final class SignUpUserSubmitAction
{
    /**
     * @var Responder
     */
    private $responder;
    private $twig;
    private $session;
    private $userCreator;
    private $finder;
    private $userLoginChecker;

    /**
     * The constructor.
     *
     * @param Responder $responder The responder
     */
    public function __construct(
        Twig $twig,
        Session $session,
        Responder $responder,
        UserCreator $userCreator,
        UserFinder $finder,
        UserLoginChecker $userLoginChecker

    ) {
        $this->twig = $twig;
        $this->session = $session;
        $this->responder = $responder;
        $this->userCreator = $userCreator;
        $this->finder = $finder;
        $this->userLoginChecker = $userLoginChecker;
    }

    /**
     * Action.
     *
     * @param ServerRequestInterface $request The request
     * @param ResponseInterface $response The response
     *
     * @return ResponseInterface The response
     */
    public function __invoke(
        ServerRequestInterface $request, ResponseInterface $response): ResponseInterface {
        $data = (array)$request->getParsedBody();
        $findUsername['username'] = $data['username'];
        $user = null;
        $error = [];
        if ($data['password'] == $data['confirm_password'] && $findUsername['username'] != null) {
            $checkUser = $this->finder->findUsers($findUsername);
            if (!$checkUser) {
                $userId = $this->userCreator->createUser($data);
                $user = $this->finder->getUserById($userId);
            } else {
                $error['username'] = "Y";
                $error['dusername'] = "User name error";
            }
        } else {
            $error['password'] = "Y";
            $error['dpassword'] =  "Password and confirm not match";
        }

        if ($user) {
            // $username = (string)($user['username'] ?? '');
            // $password = (string)($user['password'] ?? '');
            // $user = $this->userLoginChecker->checkLogin($username, $password);

            // $flash = $this->session->getFlashBag();
            // $flash->clear();

            // $this->session->invalidate();
            // $this->session->start();
            // $this->session->set('user', $user);
            // $flash->set('success', 'Login successfully');

            // $viewData = [];
            // $url = 'home';
            // return $response->withStatus(302)->withHeader('Location', $url);

            return $this->responder->withRedirect($response, "login_user");
        } else {
            $viewData = [
                'error' => $error,
            ];
            return $this->responder->withRedirect($response, "sign_up_user", $viewData);
        }
    }
}

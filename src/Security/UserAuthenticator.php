<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

//Connexion qui prend en compte la hiérarchie des roles 

class UserAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';


    //Appel du service security pour les rôles

    private Security $security;

    public function __construct(private UrlGeneratorInterface $urlGenerator, Security $security)
    {

        //INJECTION du service security et urlGenerator dans le constructeur 

        $this->security = $security;
        $this->urlGenerator = $urlGenerator;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // Vérifies directement avec la méthode isGranted() du composant Security

        /* ROLE_SUPER_ADMIN et ROLE_ADMIN sont rediriger respectivement avec leur controlleur 
        menant à la même vue back_admin/index.html.twig */
        
        if ($this->security->isGranted("ROLE_SUPER_ADMIN")) {
            return new RedirectResponse($this->urlGenerator->generate('app_back_admin'));
        }


        elseif ($this->security->isGranted("ROLE_ADMIN")) {
            return new RedirectResponse($this->urlGenerator->generate('app_admin'));
        }

        //Sinon redirige le ROLE_USER vers la page test app_register
        
        return new RedirectResponse($this->urlGenerator->generate('app_register'));
    }

        /* For example:
           return new RedirectResponse($this->urlGenerator->generate('app_login'));
           throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        }*/

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}

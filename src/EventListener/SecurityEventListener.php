<?php
namespace App\EventListener;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityEventListener
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $request = $event->getRequest();
        $langue = $request->request->get('langue'); // Récupérer la langue depuis la requête
        $this->session->set('_locale', $langue); // Stocker la langue dans la session
    }
}
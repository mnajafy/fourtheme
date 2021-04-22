<?php

namespace App\EventSubscriber\EasyAdmin;

use App\Entity\Category;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImageSubscriber implements EventSubscriberInterface
{
    private $token;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['newCategory'],
        ];
    }

    public function newCategory(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Category)) {
            return;
        }

        $entity->setAuthor($this->token->getUser());
    }
}

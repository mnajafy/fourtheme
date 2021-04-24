<?php

namespace App\EventSubscriber\EasyAdmin;

use App\Entity\Template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TemplateSubscriber implements EventSubscriberInterface
{
    private $token;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['newTemplate'],
            BeforeEntityUpdatedEvent::class => ['updateTemplate'],
        ];
    }

    public function newTemplate(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Template)) {
            return;
        }

        $entity->setAuthor($this->token->getUser());

        foreach ($entity->getImages() as $image) {
            $image->setAuthor($this->token->getUser());
            foreach ($entity->getCategories() as $category) {
                $image->addCategory($category);
            }
            $image->addTemplate($entity);
        }
    }

    public function updateTemplate(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Template)) {
            return;
        }

        $entity->setAuthor($this->token->getUser());

        foreach ($entity->getImages() as $image) {
            $image->setAuthor($this->token->getUser());
            foreach ($entity->getCategories() as $category) {
                $image->addCategory($category);
            }
            $image->addTemplate($entity);
        }
    }
}
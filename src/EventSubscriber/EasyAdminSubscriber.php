<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            // before: new
            BeforeEntityPersistedEvent::class => ['newUser'],
            // before: update
            BeforeEntityUpdatedEvent::class => ['updateUser'],
        ];
    }

    public function newUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }

        $entity->setRoles(['ROLE_USER']);

        $this->setUserPassword($entity);
    }

    public function updateUser(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof User)) {
            return;
        }
        
        $this->setUserPassword($entity);
    }

    public function setUserPassword(User $user)
    {
        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }
}
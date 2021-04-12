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
            BeforeEntityPersistedEvent::class => ['setPassword'],
            BeforeEntityUpdatedEvent::class => ['updatePassword'],
        ];
    }

    public function newPassword(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        $this->setPassword($entity);
    }

    public function updatePassword(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();
        $this->setPassword($entity);
    }

    public function setPassword(User $user)
    {
        $encoded = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($encoded);
    }
}
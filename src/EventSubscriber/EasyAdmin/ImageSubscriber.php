<?php

namespace App\EventSubscriber\EasyAdmin;

use App\Entity\Image;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Vich\UploaderBundle\Templating\Helper\UploaderHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ImageSubscriber implements EventSubscriberInterface
{
    private $token;
    private $cacheManager;
    private $uploaderHelper;

    public function __construct(TokenStorageInterface $tokenStorage, CacheManager $cacheManager, UploaderHelper $uploaderHelper)
    {
        $this->token = $tokenStorage->getToken();
        $this->cacheManager = $cacheManager;
        $this->uploaderHelper = $uploaderHelper;
    }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['newImage'],
            AfterEntityDeletedEvent::class => ['deleteImage'],
        ];
    }

    public function newImage(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Image)) {
            return;
        }

        $entity->setAuthor($this->token->getUser());
    }

    public function deleteImage(AfterEntityDeletedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!$entity instanceof Image) {
            return;
        }

        $this->cacheManager->remove($this->uploaderHelper->asset($entity, 'imageFile'));
    }
}
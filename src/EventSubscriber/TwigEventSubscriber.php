<?php

namespace App\EventSubscriber;

use Twig\Environment;
use App\Repository\CategoryRepository;
use App\Repository\TemplateRepository;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TwigEventSubscriber implements EventSubscriberInterface
{
    private $twig;
    private $templateRepository;
    private $categoryRepository;

    public function __construct(Environment $twig, TemplateRepository $templateRepository, CategoryRepository $categoryRepository)
    {
        $this->twig = $twig;
        $this->templateRepository = $templateRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function onKernelController(ControllerEvent $event)
    {
        $this->twig->addGlobal('global_templates_max', $this->templateRepository->findMaxResults(4));
        $this->twig->addGlobal('global_categories', $this->categoryRepository->findAll());
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onKernelController',
        ];
    }
}

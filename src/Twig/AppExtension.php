<?php

namespace App\Twig;

use App\Service\MarkdownHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ServiceSubscriberInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension implements ServiceSubscriberInterface
{
    /**
     * @var MarkdownHelper
     */
    private $container;

    public function __construct(ContainerInterface $container) {

        $this->container = $container;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('cached_markdown', [$this, 'processMarkdown'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public static function getSubscribedServices()
    {
        return [
            'foo' => MarkdownHelper::class,
        ];
    }


    public function processMarkdown($value)
    {
        return $this->container
                ->get(MarkdownHelper::class)
                ->parse($value);
    }
}

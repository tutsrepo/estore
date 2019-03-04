<?php
namespace App\EventSubscriber;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Exception\EmptyBodyException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Psr\Log\LoggerInterface;
class EmptyBodySubscriber implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;     
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => [
                'handleEmptyBody',
                EventPriorities::POST_DESERIALIZE,
            ],
        ];
    }
    public function handleEmptyBody(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $method = $request->getMethod();
        $route = $request->get('_route');
        if (!in_array($method, [Request::METHOD_POST, Request::METHOD_PUT]) ||
            in_array($request->getContentType(), ['html', 'form']) ||
            substr($route, 0, 3) !== 'api') {
            return;
        }
        $data = $event->getRequest()
            ->get('data');
        if (null === $data) {
            $this->logger->debug('Empty body request send');
            throw new EmptyBodyException();
        }
    }
}
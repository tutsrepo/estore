<?php
namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, LoggerInterface $logger)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->logger = $logger;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['hashPassword', EventPriorities::PRE_WRITE]

        ];
    }

    public function hashPassword(GetResponseForControllerResultEvent $event)
    {
        $user = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$user instanceof User || Request::METHOD_POST !== $method)
        {
            return;
        }
        
        $this->logger->debug('Encoding User Password Process Started' . $user->getPassword());

        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $user->getPassword())
        );
    }
}    


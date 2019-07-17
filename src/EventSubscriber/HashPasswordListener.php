<?php   
namespace App\EventSubscriber;

use AppBundle\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
class HashPasswordListener implements EventSubscriber
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function prePersist(GetResponseForControllerResultEvent $args)
    {
        $entity = $args->getControllerResult();
        if (!$entity instanceof User) {
            return;
        }
        $encoded = $this->passwordEncoder->encodePassword(
            $entity,
            $entity->getPassword()
        );
        $entity->setPassword($encoded);
    }
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }
}
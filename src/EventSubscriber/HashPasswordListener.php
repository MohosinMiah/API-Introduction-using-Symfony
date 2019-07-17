<?php   
namespace App\EventSubscriber;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
class HashPasswordListener implements EventSubscriber
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoder $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }
 
        public function prePersist(LifecycleEventArgs $args)
        {
            $entity = $args->getEntity();
            if (!$entity instanceof User) {
                return;
            }
            $encoded = $this->passwordEncoder->encodePassword(
                $entity,
                $entity->getPassword()
            );
            $entity->setPassword($encoded);
        }
   
}



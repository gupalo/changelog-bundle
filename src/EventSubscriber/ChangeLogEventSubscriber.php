<?php

namespace Gupalo\ChangeLogBundle\EventSubscriber;

use DateTimeInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Gupalo\ChangeLogBundle\Entity\AwareChangeLogInterface;
use Gupalo\ChangeLogBundle\Entity\ChangeLog;
use Symfony\Component\Security\Core\Security;

class ChangeLogEventSubscriber implements EventSubscriber
{
    public function __construct(protected Security $security)
    {
    }

    public function getSubscribedEvents(): array
    {
        return [
            Events::postUpdate
        ];
    }

    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getEntity();
        if ($entity instanceof AwareChangeLogInterface) {
            $uow = $args->getEntityManager()->getUnitOfWork();
            $changes = $uow->getEntityChangeSet($entity);

            foreach ($changes as $field => $change) {
                $this->setEntityLog(
                    $args->getEntityManager(),
                    $entity,
                    $field,
                    $this->resolveFieldValue($change[0]),
                    $this->resolveFieldValue($change[1]),
                );
            }

            $args->getEntityManager()->flush();
        }
    }

    private function setEntityLog(
        EntityManagerInterface $em,
        AwareChangeLogInterface $entity,
        ?string $field = null,
        ?string $before = null,
        ?string $after = null,
    ): void {
        $changeLog = new ChangeLog();
        $changeLog->setEntity($entity::class);
        $changeLog->setEntityId($entity->getId());
        $changeLog->setField($field);
        $changeLog->setOldValue($before);
        $changeLog->setValue($after);
        if ($this->security->getUser()) {
            $changeLog->setUser($this->security->getUser()->getUserIdentifier());
        }
        $em->persist($changeLog);
    }

    private function resolveFieldValue($value): string
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format('y-m-d H:i:s');
        }

        if (is_array($value)) {
            return json_encode($value, JSON_THROW_ON_ERROR, 512);
        }

        return (string)$value;
    }
}

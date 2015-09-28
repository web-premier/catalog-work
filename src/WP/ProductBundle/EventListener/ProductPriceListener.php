<?php

namespace WP\ProductBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use WP\ProductBundle\Entity\Product;


/**
 * Set active price on persist/update
 */
class ProductPriceListener
{
    /**
     * Set new active price on entity save
     *
     * @param LifecycleEventArgs $event
     */
    protected function onSave(LifecycleEventArgs $event)
    {
        $entity = $event->getEntity();

        if (!($entity instanceof Product)) {
            return;
        }

        if ($price = $entity->getSpecialPrice()) {
            $entity->setPrice($price);
        } else {
            $entity->setPrice($entity->getBasePrice());
        }
    }

    /**
     * Update price on persist
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event)
    {
        $this->onSave($event);
    }

    /**
     * Update price on update
     *
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event)
    {
        $this->onSave($event);
    }
}
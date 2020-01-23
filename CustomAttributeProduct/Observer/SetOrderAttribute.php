<?php
namespace Codilar\CustomAttributeProduct\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class SetOrderAttribute implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return $this
     * @throws \Exception
     */
    public function execute(Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();
        $order->setIsImportant("Yes");
        $order->save();
        return $this;
    }
}

<?php

namespace Codilar\CustomAttributeProduct\Setup\Patch\Data;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;

class CustomAttributesAddress implements DataPatchInterface
{
    protected $_moduleDataSetup;
    protected $_customerSetupFactory;
    protected $_attributeSetFactory;

    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->_moduleDataSetup = $moduleDataSetup;
        $this->_customerSetupFactory = $customerSetupFactory;
        $this->_attributeSetFactory = $attributeSetFactory;
    }

    public function apply()
    {
        $customerSetup = $this->_customerSetupFactory->create(['setup' => $this->_moduleDataSetup]);
        $customerSetup->removeAttribute(Customer::ENTITY, 'test');
        $customerSetup->addAttribute(Customer::ENTITY, 'test', [
            'type' => Table::TYPE_DECIMAL,
            'label' => 'Test',
            'input' => 'text',
            'required' => 0,
            'default' => 0,
            'visible' => 0,
            'system' => 0
        ]);
        $attribute = $customerSetup->getEavConfig()->getAttribute(Customer::ENTITY, 'test');
        $attribute->setData('used_in_forms', ['adminhtml_customer']);
        $attribute->save();
    }

    public function getAliases()
    {
        return [];
    }

    public static function getDependencies()
    {
        return [

        ];
    }
}

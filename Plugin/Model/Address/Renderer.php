<?php
/**
 * Copyright © Delgraf. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Delgraf\RegionCode\Plugin\Model\Address;

use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Filter\FilterManager;
use Magento\Directory\Model\RegionFactory;

/**
 * Class Renderer used for formatting a store address
 */
class Renderer
{
    // here I changed region to region_code and added span classes as I wanted to apply some css
    const DEFAULT_TEMPLATE = "<span class='name'>{{var name}}</span>\n" .
        "<span class='street1'>{{var street_line1}}</span>\n" .
        "{{depend street_line2}}<span class='street2'>{{var street_line2}}</span>\n{{/depend}}" .
        "{{depend postcode}}<span class='post'>{{var postcode}}</span> {{/depend}}<span class='city'>{{var city}}</span>{{depend region_code}} <span class='region'>({{var region_code}})</span>{{/depend}}\n" .
        "<span class='country'>{{var country}}</span>";
    /**
     * @var EventManager
     */
    protected $eventManager;

    /**
     * @var FilterManager
     */
    protected $filterManager;

    /**
     * @var string
     */
    private $template;

    /**
     * Constructor
     * @param RegionFactory $regionFactory
     * @param RegionFactory $eventManager
     * @param RegionFactory $filterManager
     * @param string $template
     */
    public function __construct(
        RegionFactory $regionFactory,
        EventManager $eventManager,
        FilterManager $filterManager,
        $template = self::DEFAULT_TEMPLATE
    ) {
        $this->regionFactory = $regionFactory;
        $this->eventManager = $eventManager;
        $this->filterManager = $filterManager;
        $this->template = $template;
    }

    /**
     * @param \Magento\Store\Model\Address\Renderer $result
     * @param callable $proceed
     * @return \Magento\Store\Model\Address\Renderer
     */
    public function aroundFormat(\Magento\Store\Model\Address\Renderer $result, callable $proceed, $storeInfo, $type = 'html')
    {
        
        $this->eventManager->dispatch('store_address_format', ['type' => $type, 'store_info' => $storeInfo]);
        $regionCode = $this->getRegionData($storeInfo->getRegionId());
        // here I am setting region_code in data.
        $storeInfo->setData('region_code', $regionCode);
        $address = $this->filterManager->template(
            $this->template,
            ['variables' => $storeInfo->getData()]
        );
        if ($type == 'html') {
            $address = nl2br($address);
        }
        return $address;
    }
    
    // here I added getRegionData
    /**
     * Get region code
     * @param int $regionId
     * @return string
     */
    public function getRegionData( $regionId ){
    $region = $this->regionFactory->create()->load($regionId);
    return $region->getData('code');
    }
}

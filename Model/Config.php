<?php
declare(strict_types=1);

namespace Pragmatic\SystemConfigurationToolkit\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

class Config
{
    const ENABLED_XML_PATH = 'system_configuration_toolkit/general/enabled';
    const SORT_ORDERS_ENABLED_XML_PATH = 'system_configuration_toolkit/general/sort_orders_enabled';
    const PATHS_ENABLED_XML_PATH = 'system_configuration_toolkit/general/paths_enabled';

    /** @var ScopeConfigInterface */
    private $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::ENABLED_XML_PATH);
    }

    /**
     * @return bool
     */
    public function isSortOrdersEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::SORT_ORDERS_ENABLED_XML_PATH);
    }

    /**
     * @return bool
     */
    public function isPathsEnabled() : bool
    {
        return $this->scopeConfig->isSetFlag(self::PATHS_ENABLED_XML_PATH);
    }
}

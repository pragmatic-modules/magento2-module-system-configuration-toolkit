<?php
declare(strict_types=1);

namespace Pragmatic\SystemConfigurationToolkit\Plugin;

use Magento\Framework\Acl\AclResource\Provider;
use Pragmatic\SystemConfigurationToolkit\Model\Config;

class AddSortOrdersToResourceLabelsPlugin
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Provider $subject
     * @param array $result
     * @return array
     */
    public function afterGetAclResources(Provider $subject, array $result): array
    {
        if(!$this->config->isResourcesEnabled()) {
            return $result;
        }

        return $this->processResources($result);
    }

    /**
     * @param array $resources
     * @return array
     */
    protected function processResources(array $resources) : array
    {
        foreach ($resources as $key => $resource) {
            if(isset($resource['sortOrder']) && isset($resource['title'])) {
                $resource['title'] = sprintf(
                    "%s | 🆔 %s | 🔀 %s",
                    $resource['title'] ?? '',
                    $resource['id'] ?? '',
                    $resource['sortOrder'] ?? '',
                );
            }

            if(isset($resource['children'])) {
                $resource['children'] = $this->processResources($resource['children']);
            }

            $resources[$key] = $resource;
        }

        return $resources;
    }
}

<?php
declare(strict_types=1);

namespace Pragmatic\SystemConfigurationToolkit\Plugin;

use Magento\Config\Model\Config\Structure\Converter;
use Pragmatic\SystemConfigurationToolkit\Model\Config;

class AddSortOrderToLabelsPlugin
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Converter $subject
     * @param array $result
     * @return array
     */
    public function afterConvert(Converter $subject, array $result): array
    {
        if (!$this->config->isEnabled() || !$this->config->isSortOrdersEnabled()) {
            return $result;
        }

        $result['config']['system']['tabs'] = $this->processFields(
            $result['config']['system']['tabs'] ?? []
        );
        $result['config']['system']['sections'] = $this->processFields(
            $result['config']['system']['sections'] ?? []
        );

        return $result;
    }

    /**
     * @param $components
     * @return array
     */
    protected function processFields($components): array
    {
        foreach ($components as $key => $element) {
            if (isset($element['sortOrder'])) {
                $element['label'] = sprintf(
                    '%s | 🔀 %s',
                    $element['label'] ?? '',
                    $element['sortOrder'],
                );
            }

            if (isset($element['children'])) {
                $element['children'] = $this->processFields($element['children']);
            }

            $components[$key] = $element;
        }

        return $components;
    }
}

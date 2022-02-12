<?php
declare(strict_types=1);

namespace Pragmatic\SystemConfigurationToolkit\Plugin;

use Magento\Config\Model\Config\Structure\Element\Field;
use Pragmatic\SystemConfigurationToolkit\Model\Config;

class AddConfigPathToCommentPlugin
{
    /** @var Config */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Field $subject
     * @param string $result
     * @return string
     */
    public function afterGetComment(Field $subject, string $result): string
    {
        if (!$this->config->isEnabled() || !$this->config->isPathsEnabled()) {
            return $result;
        }

        $data = $subject->getData();
        $prefix = strlen($result) > 0 ? "<br><br>" : "";

        $result .= $prefix . $subject->getPath();

        if (isset($data['comment']['model'])) {
            $result .= "<br>Comment model: {$data['comment']['model']}";
        }

        return $result;
    }
}

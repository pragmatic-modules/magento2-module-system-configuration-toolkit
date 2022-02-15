<?php
declare(strict_types=1);

namespace Pragmatic\SystemConfigurationToolkit\Plugin;

use Magento\Config\Model\Config\Structure\Element\Field;
use Magento\Framework\Phrase;
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
     * @param Phrase|string $result
     * @return Phrase|string
     */
    public function afterGetComment(Field $subject, $result)
    {
        if (!$this->config->isEnabled() || !$this->config->isPathsEnabled()) {
            return $result;
        }

        $data = $subject->getData();
        $result = (string)$result;
        $prefix = strlen($result) > 0 ? "<br><br>" : "";

        $result .= $prefix . $subject->getPath();

        if (isset($data['comment']['model'])) {
            $result .= "<br>Comment model: {$data['comment']['model']}";
        }

        return __($result);
    }
}

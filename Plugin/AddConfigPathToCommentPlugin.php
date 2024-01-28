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
        $path = <<<HTML
<span title="Click to copy to 📋" style="cursor:pointer" onclick="
navigator.clipboard.writeText(this.innerText).then(
    () => require(['jquery'], ($) => $(this).find('.copy-notice').fadeIn().fadeOut(500))
);">
    {$subject->getPath()}<span class="copy-notice" style="color: green; display: none">&nbsp;&nbsp;copied.</span>
</span>
HTML;
        $result .= $prefix . $path;

        if (isset($data['comment']) &&isset($data['comment']['model'])) {
            $result .= "<br>Comment model: {$data['comment']['model']}";
        }

        return __($result);
    }
}

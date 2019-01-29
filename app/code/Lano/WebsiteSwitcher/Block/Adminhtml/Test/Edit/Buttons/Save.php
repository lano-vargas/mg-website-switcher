<?php 
namespace Lano\WebsiteSwitcher\Block\Adminhtml\Test\Edit\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Save extends Generic implements ButtonProviderInterface
{
    /**
     * get button data
     *
     * @return arrays
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Test'),
            'on_click' => 'switcher/test/save',
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}
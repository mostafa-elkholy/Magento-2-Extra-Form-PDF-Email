<?php

namespace Sharpeningservices\MailAttachment\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
//use MSP\ReCaptcha\Model\Config as ReCaptchaConfig;

/**
 * Class Config
 * The class responsible for providing configuration
 */
class Config
{
    const XML_PATH_ENABLED_FRONTEND_QUOTE_FORM = 'msp_securitysuite_recaptcha/frontend/enabled_maxmize_sharpeningservices';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ReCaptchaConfig
     */
    //private $recaptchaConfig;

    /**
     * Config constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param ReCaptchaConfig $recaptchaConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig/*,
        ReCaptchaConfig $recaptchaConfig*/
    ) {
        $this->scopeConfig = $scopeConfig;
        //$this->recaptchaConfig = $recaptchaConfig;
    }

    /**
     * Return true if enabled on frontend Magently custom form page
     * @return boolean
     */
    public function isEnabledFrontendCustomForm()
    {
        /*if (!$this->recaptchaConfig->isEnabledFrontend()) {
            return false;
        }

        return (bool) $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED_FRONTEND_QUOTE_FORM,
            ScopeInterface::SCOPE_WEBSITE
        );*/
    }
}
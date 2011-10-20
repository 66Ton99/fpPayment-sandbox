<?php

require_once dirname(__FILE__).'/../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

/**
 * ProjectConfiguration
 *
 * @package    Payment
 * @subpackage Config
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class ProjectConfiguration extends sfProjectConfiguration
{
  
  /**
   * (non-PHPdoc)
   * @see sfProjectConfiguration::setup()
   */
  public function setup()
  {
    $this->enablePlugins('sfDoctrinePlugin');
    $this->enablePlugins('sfDoctrineGuardPlugin');
    $this->enablePlugins('sfPhpunitPlugin');
    $this->enablePlugins('sfJqueryReloadedPlugin');
    $this->enablePlugins('fpErrorNotifierPlugin');
    $this->enablePlugins('fpPaymentPlugin');
    $this->enablePlugins('fpPaymentTaxPlugin');
    $this->enablePlugins('fpPaymentCartPlugin');
    $this->enablePlugins('fpPaymentShippingPlugin');
    $this->enablePlugins('fpPaymentPayPalPlugin');
    $this->enablePlugins('fpPaymentAuthorizePlugin');
  }
}

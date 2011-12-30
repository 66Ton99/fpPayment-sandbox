<?php
require_once 'functionalBaseTestCase.php';

/**
 * Register tests
 *
 * @package    LeftCo
 * @subpackage Test
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class paypalTestCase extends functionalBaseTestCase
{
  
  protected $testEmail = 'tester@test.com';
  
  protected $testPass = '123';
  
  /**
   * @test
   */
  public function addItemsToCart()
  {
//     $this->getMink()->setDefaultSessionName('selenium');
//     $this->getMink()->setDefaultSessionName('sahi');
    $this->load(array('fixtures.yml'));
    $this->login($this->testEmail, $this->testPass);
    $session = $this->getSession();
    $session->visit($this->url . 'cart/new?id=2&object_id=2');
    $session->visit($this->url . 'cart');
    $page = $session->getPage();
    $this->assertNotNull($content = $page->find('css', '#content'));
    $this->assertNotNull($item = $content->find('css', '#fp_payment_cart_box #cart_row_1 td b'));
    $this->assertEquals('Product2 from seller2', $item->getText());
    $content->clickLink('Checkout');
    $this->wait("$(\"#content h1:contains('Billing Information')\").text() != ''");
    $page = $session->getPage();
    $this->assertNotNull($content = $page->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Billing Information', $title->getText());
    // TODO Add Billing address check
    $content->pressButton('Next');
    $this->wait("$(\"#content h1:contains('Shipping Information')\").text() != ''");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Shipping Information', $title->getText());
    // TODO Add Shipping address check
    $content->pressButton('Next');
    $this->wait("$(\"#content h1:contains('Shipping Method')\").text() != ''");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Shipping Method', $title->getText());
    // TODO Add shipping check
    $content->pressButton('Next');
    $this->wait("$(\"#content h1:contains('Payment Information')\").text() != ''");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($select = $content->find('css', '#fpPaymentMethodPluginForm_method'));
    $select->selectOption('PayPal');
    $content->pressButton('Next');
    $this->wait("$(\"#content h1:contains('Order Review')\").text() != ''");
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Order Review', $title->getText());
    // TODO something
    $content->pressButton('Pay');
    $this->wait("$('body.xptSandbox').children().length > 0");
    // TODO Finish
//     $this->assertNotNull($content = $session->getPage()->find('css', 'body.xptSandbox'));
//     $this->assertNotNull($login = $content->find('css', '#login_email'));
//     $login->setValue('reach_1317738850_per@66ton99.org.ua');
//     $this->assertNotNull($password = $content->find('css', '#login_password'));
//     $password->setValue('qwerty123');
//     $content->pressButton('submitLogin');
//     $this->wait("$('#parentSlider').children().length > 0");
//     $this->assertNotNull($content = $session->getPage()->find('css', 'body.xptSandbox'));
//     $this->assertNotNull($title = $content->find('css', '#parentSlider h2'));
//     $this->assertEquals('Review your information', $title->getText());
    
  }
}
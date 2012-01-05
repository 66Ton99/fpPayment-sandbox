<?php
require_once 'functionalBaseTestCase.php';

/** 068 750-33-20 Славик
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
    $this->getMink()->setDefaultSessionName('webdriver');
//     $this->getMink()->setDefaultSessionName('selenium');
//     $this->getMink()->setDefaultSessionName('sahi');

    // Login PayPal
    $session = $this->getSession();
    $session->visit('https://developer.paypal.com/');
//     $this->wait('$("#home-page").children().length > 0');
    $this->assertNotNull($content = $session->getPage()->find('css', '#home-page'));
    $this->assertNotNull($login = $content->find('css', '#login_email'));
    $login->setValue('test@66ton99.org.ua');
    $this->assertNotNull($password = $content->find('css', '#login_password'));
    $password->setValue('9pJe25fxY2');
    $content->pressButton('Log In');
    $this->wait("(el = document.body.getElementsByClassName('message')) && el.length > 0 && el[0].innerHTML == 'Now loading, please wait...'");
    if ('goutte' == $this->getMink()->getDefaultSessionName()) {
      $this->assertNotNull($message = $session->getPage()->find('css', '.message'));
      $this->assertEquals('Now loading, please wait...', $message->getText());
    }
//     sleep(5);
//     var_dump($session->getPage()->getHtml());die("OK\n");

//     var_dump($session->getDriver()->getClient()->getCookieJar()->all());
    
    $session->visit('https://developer.paypal.com/');
//     var_dump($session->getCookie('__login_track'));
    $this->assertNotNull($session->getPage()->find('css', '#home_container'));
//     sleep(5);
//     var_dump($session->getPage()->getHtml());
// die("OK\n");
    
    $this->load(array('fixtures.yml'));
    $this->login($this->testEmail, $this->testPass);
    
    $session->visit($this->url . 'cart/new?id=2&object_id=2');
    $session->visit($this->url . 'cart');
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($item = $content->find('css', '#fp_payment_cart_box #cart_row_1 td b'));
    $this->assertEquals('Product2 from seller2', $item->getText());
    $content->clickLink('Checkout');
    $this->wait("document.getElementsByTagName('h1')[0].innerHTML == 'Billing Information'");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Billing Information', $title->getText());
    // TODO Add Billing address check
    $content->pressButton('Next');
    $this->wait("document.getElementsByTagName('h1')[0].innerHTML == 'Shipping Information'");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Shipping Information', $title->getText());
    // TODO Add Shipping address check
    $content->pressButton('Next');
    $this->wait("document.getElementsByTagName('h1')[0].innerHTML == 'Shipping Method'");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Shipping Method', $title->getText());
    // TODO Add shipping check
    $content->pressButton('Next');
    $this->wait("document.getElementsByTagName('h1')[0].innerHTML == 'Payment Information'");
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($select = $content->find('css', '#fpPaymentMethodPluginForm_method'));
    $select->selectOption('PayPal');
    $content->pressButton('Next');
    $this->wait("document.getElementsByTagName('h1')[0].innerHTML == 'Order Review'");
    $this->assertNotNull($title = $content->find('css', 'h1'));
    $this->assertEquals('Order Review', $title->getText());
    // TODO something
    $content->pressButton('Pay');
    $this->wait("(el = document.getElementById('billingBox')) && el.children.length > 0");
    
    $session->getPage()->pressButton('loadLogin');
    $this->wait("(el = document.getElementById('loginContainer')) && el.children.length > 0");
    
    $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
    $this->assertNotNull($title = $content->find('css', '#method-paypal .subhead'));
    $this->assertEquals('Log in to your PayPal account', $title->getText());
    $this->assertNotNull($login = $content->find('css', '#login_email'));
    $login->setValue('reach_1325697823_per@66ton99.org.ua');
    $this->assertNotNull($password = $content->find('css', '#login_password'));
    $password->setValue('qwerty123');
    $this->assertNotNull($submit = $content->find('css', '#submitLogin'));
    $submit->click(); //pressButton('Log In');
    $this->wait("(el = document.getElementById('reviewModule')) && el.children.length > 0");
    
    $this->assertNotNull($content = $session->getPage()->find('css', '#sliderWrapper'));
    $this->assertNotNull($title = $content->find('css', '#parentSlider h2'));
    $this->assertEquals('Review your information', $title->getText());
    $content->pressButton('submit.x');
    
    $this->wait("(el = document.getElementById('panelMain')) && el.children.length > 0 && el.getElementsByTagName('h2')[0].innerHTML == 'Your payment has been sent'");
    
    $this->assertNotNull($content = $session->getPage()->find('css', '#panelMain'));
    $this->assertNotNull($title = $content->find('css', 'h2'));
    $this->assertEquals('Your payment has been sent', $title->getText());
    
    $title = '';
    for ($i = 0; $i < 10; $i++) {
      $session->visit($this->url . 'order/status/1');
      $this->wait("(el = document.getElementById('content')) && el.children.length > 0");
      
      $this->assertNotNull($content = $session->getPage()->find('css', '#content'));
      $this->assertNotNull($title = $content->find('css', 'h1 span'));
    
      if ('In process' != $title->getText()) {
        break;
      }
      sleep(1);
    }
    $this->assertEquals('Success', $title->getText(), 'IPN doesn\'t work');
  }
}
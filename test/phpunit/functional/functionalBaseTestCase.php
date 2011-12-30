<?php

abstract class functionalBaseTestCase extends sfBasePhpunitMinkTestCase
{
  
  protected $timeout = 5000;
  
  protected $url;
  
  protected static $isFixtruesLoaded = false;
  
  /**
   * (non-PHPdoc)
   * @see sfBasePhpunitTestCase::setUp()
   */
  public function setUp()
  {
    parent::setUp();
    $this->url = sfConfig::get('sf_url') . '/frontend_test.php/';
  }
  
  /**
   * Load finxtures
   *
   * @param array $list
   *
   * @return void
   */
  protected function load(array $list, $reload = true)
  {
    if (self::$isFixtruesLoaded && !$reload) return;
//     echo "\nfixtures\n";
    $requestArray = array();
    
    foreach ($list as $file) {
      $requestArray[] = 'list%5B%5D=' . $file;
    }
    $session = $this->getSession('goutte');
    $url = $this->url . 'sfPhpunit/load?' . implode('&', $requestArray);
    $session->visit($url);
    
    if ('Fixtures loaded successful.' != ($response = $session->getPage()->getText()))
    {
      $this->fail('Fixtures load fail: ' . $response);
    }
    $url = $this->url . 'sfPhpunit/cc';
    $session->visit($url);
    
    self::$isFixtruesLoaded = true;
  }
  
  /**
   * Universal login
   *
   * @param string $user
   * @param string $password
   *
   * @return void
   */
  protected function login($user, $password)
  {
    $session = $this->getSession();
    $session->visit($this->url . 'guard/login');
    $page = $session->getPage();
    $this->assertNotNull($mainEl = $page->find('css', '#content'));
    $this->assertNotNull($usernameEl = $page->find('css', '#signin_username'));
    $usernameEl->setValue($user);
    $this->assertNotNull($passwordEl = $page->find('css', '#signin_password'));
    $passwordEl->setValue($password);
    $mainEl->pressButton('Signin');
    $this->wait("$('h1').text() == 'Product List'");
    if (null !== ($h1 = $page->find('css', '#content h1')))
    {
      if ('Signin' == $h1->getText()) $this->fail("Login as '{$user}' fail");
    }
  }
  
  /**
   * Fixed wait for Selenium and other drivers run 
   *
   * @return void
   */
  public function wait()
  {
    if ('selenium' == $this->getMink()->getDefaultSessionName())
    {
      $this->getSession()->wait($this->timeout, $condition);
    }
  }
}
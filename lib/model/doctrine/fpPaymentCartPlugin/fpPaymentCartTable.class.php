<?php

/**
 * fpPaymentCartTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class fpPaymentCartTable extends PluginfpPaymentCartTable
{

  /**
   * Returns an instance of this class.
   *
   * @return fpPaymentCartTable
   */
  public static function getInstance()
  {
    return Doctrine_Core::getTable('fpPaymentCart');
  }
}
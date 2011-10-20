<?php /* @var $item Product */ ?>
<h1>Product List</h1>
<table>
  <tr>
    <th>Name</th>
    <th>Price</th>
    <th>actions</th>
  </tr>
  <?php foreach ($list as $item) { ?>
    <tr>
      <td><?php echo $item->getName() ?></td>
      <td><?php echo $item->getPrice() ?></td>
      <td>
        <?php include_component('fpPaymentCart',
        											  'editbox',
                                array('object_class_name' => strtolower($item->getTable()->getTableName()),
                                      'object_id' => $item->getId(),
                                      'actions' => array('new'))) ?>
      </td>
    </tr>
  <?php } ?>
</table>
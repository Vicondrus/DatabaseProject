<?php

/**
 * List all users with a link to edit
 */

try {
  require "config.php";
  require "common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM `pizzeriad'autore`.`order_aux` order by idOrder";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Update order</h2>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Status</th>
      <th>Customer</th>
      <th>Delivey Boy</th>
      <th>Delivey Address</th>
      <th>Delivey City</th>
      <th>Delivey Time</th>
    </tr>
  </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["idOrder"]); ?></td>
        <td><?php echo escape($row["idStatus"]); ?></td>
        <td><?php echo escape($row["idCustomer"]); ?></td>
        <td><?php echo escape($row["idDeliveryBoy"]); ?></td>
        <td><?php echo escape($row["deliveryAddress"]); ?></td>
        <td><?php echo escape($row["deliveryCity"]); ?></td>
        <td><?php echo escape($row["deliveryTime"]); ?></td>
        <td><a href="updateSingleOrder.php?idOrder=<?php echo escape($row["idOrder"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idOrder"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idOrder = $_GET["idOrder"];

    $sql = "DELETE FROM `pizzeriad'autore`.`order` WHERE idOrder = :idOrder";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idOrder', $idOrder);
    $statement->execute();

    $success = "Order successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM `pizzeriad'autore`.`order`";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete order</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Status ID</th>
      <th>Customer ID</th>
      <th>Delivey Boy ID</th>
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
      <td><a href="deleteOrder.php?idOrder=<?php echo escape($row["idOrder"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

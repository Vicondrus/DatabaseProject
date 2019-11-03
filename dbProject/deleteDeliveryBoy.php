<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idDelivery_Boy"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idDelivery_Boy = $_GET["idDelivery_Boy"];

    $sql = "DELETE FROM delivery_boy WHERE idDelivery_Boy = :idDelivery_Boy";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idDelivery_Boy', $idDelivery_Boy);
    $statement->execute();

    $success = "Delivery Boy successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM delivery_boy";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete delivery boy</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Has Car</th>
      <th>City</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idDelivery_Boy"]); ?></td>
      <td><?php echo escape($row["boyName"]); ?></td>
      <td><?php echo escape($row["hasCar"]); ?></td>
      <td><?php echo escape($row["city"]); ?></td>
      <td><a href="deleteDeliveryBoy.php?idDelivery_Boy=<?php echo escape($row["idDelivery_Boy"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

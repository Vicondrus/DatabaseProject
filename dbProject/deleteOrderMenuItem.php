<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idOrder"]) && isset($_GET["idMenu"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idOrder = $_GET["idOrder"];
    $idMenu = $_GET["idMenu"];

    $sql = "DELETE FROM `pizzeriad'autore`.menu_order WHERE idOrder = :idOrder AND idMenu=:idMenu";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idOrder', $idOrder);
    $statement->bindValue(':idMenu', $idMenu);
    $statement->execute();

    $success = "Relationship successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM `pizzeriad'autore`.menu_order";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete relationship</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Menu Item ID</th>
      <th>Quantity</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idOrder"]); ?></td>
      <td><?php echo escape($row["idMenu"]); ?></td>
      <td><?php echo escape($row["quantity"]); ?></td>
      <td><a href="deleteOrderMenuItem.php?idOrder=<?php echo escape($row["idOrder"]); ?>&idMenu=<?php echo escape($row["idMenu"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

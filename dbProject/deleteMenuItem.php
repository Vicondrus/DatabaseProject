<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idMenu_Item"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idMenu_Item = $_GET["idMenu_Item"];

    $sql = "DELETE FROM menu_item WHERE idMenu_Item = :idMenu_Item";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idMenu_Item', $idMenu_Item);
    $statement->execute();

    $success = "Menu Item successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM menu_item";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete menu item</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Category ID</th>
      <th>Description/th>
      <th>Ingredients</th>
      <th>Active</th>
      <th>Price</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idMenu_Item"]); ?></td>
      <td><?php echo escape($row["itemName"]); ?></td>
      <td><?php echo escape($row["categoryId"]); ?></td>
      <td><?php echo escape($row["description"]); ?></td>
      <td><?php echo escape($row["ingredients"]); ?></td>
      <td><?php echo escape($row["active"]); ?></td>
      <td><?php echo escape($row["price"]); ?></td>
      <td><a href="deleteMenuItem.php?idMenu_Item=<?php echo escape($row["idMenu_Item"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

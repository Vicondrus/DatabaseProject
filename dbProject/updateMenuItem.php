<?php

/**
 * List all users with a link to edit
 */

try {
  require "config.php";
  require "common.php";

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

<h2>Update Menu Items</h2>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Categoy ID</th>
      <th>Description</th>
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
        <td><a href="updateSingleMenuItem.php?idMenu_Item=<?php echo escape($row["idMenu_Item"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

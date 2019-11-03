<?php

/**
 * List all users with a link to edit
 */

try {
  require "config.php";
  require "common.php";

  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM `pizzeriad'autore`.order_view";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Update relationship</h2>

<table>
  <thead>
    <tr>
      <th>Order ID</th>
      <th>Menu Item</th>
      <th>Quantity</th>
    </tr>
  </thead>
    <tbody>
    <?php foreach ($result as $row) : ?>
      <tr>
        <td><?php echo escape($row["idOrder"]); ?></td>
        <td><?php echo escape($row["itemName"]); ?></td>
        <td><?php echo escape($row["quantity"]); ?></td>
        <td><a href="updateSingleOrderMenuItem.php?idOrder=<?php echo escape($row["idOrder"]); ?>&idMenu=<?php echo escape($row["idMenu"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

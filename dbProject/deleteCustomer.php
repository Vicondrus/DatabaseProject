<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idCustomer"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idCustomer = $_GET["idCustomer"];

    $sql = "DELETE FROM customer WHERE idCustomer = :idCustomer";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idCustomer', $idCustomer);
    $statement->execute();

    $success = "Customer successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM customer";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete customer</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>City</th>
      <th>Address</th>
      <th>Phone</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idCustomer"]); ?></td>
      <td><?php echo escape($row["customerName"]); ?></td>
      <td><?php echo escape($row["city"]); ?></td>
      <td><?php echo escape($row["address"]); ?></td>
      <td><?php echo escape($row["phone"]); ?></td>
      <td><?php echo escape($row["email"]); ?></td>
      <td><a href="deleteCustomer.php?idCustomer=<?php echo escape($row["idCustomer"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

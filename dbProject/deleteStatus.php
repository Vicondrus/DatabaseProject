<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idStatus"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idStatus = $_GET["idStatus"];

    $sql = "DELETE FROM status WHERE idStatus = :idStatus";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idStatus', $idStatus);
    $statement->execute();

    $success = "Status successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM status";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete status</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idStatus"]); ?></td>
      <td><?php echo escape($row["statusName"]); ?></td>
      <td><a href="deleteStatus.php?idStatus=<?php echo escape($row["idStatus"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

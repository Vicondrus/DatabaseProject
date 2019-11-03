<?php

/**
 * List all users with a link to edit
 */

try {
  require "config.php";
  require "common.php";

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

<h2>Update Status</h2>

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
        <td><a href="updateSingleStatus.php?idStatus=<?php echo escape($row["idStatus"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

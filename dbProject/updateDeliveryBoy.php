<?php

/**
 * List all users with a link to edit
 */

try {
  require "config.php";
  require "common.php";

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

<h2>Update customers</h2>

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
        <td><a href="updateSingleDeliveyBoy.php?idDelivery_Boy=<?php echo escape($row["idDelivery_Boy"]); ?>">Edit</a></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

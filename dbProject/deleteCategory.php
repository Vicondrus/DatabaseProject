<?php

/**
 * Delete a user
 */

require "config.php";
require "common.php";

if (isset($_GET["idCategory"])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $idCategory = $_GET["idCategory"];

    $sql = "DELETE FROM category WHERE idCategory = :idCategory";

    $statement = $connection->prepare($sql);
    $statement->bindValue(':idCategory', $idCategory);
    $statement->execute();

    $success = "Categoy successfully deleted";
  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT * FROM category";

  $statement = $connection->prepare($sql);
  $statement->execute();

  $result = $statement->fetchAll();
} catch(PDOException $error) {
  echo $sql . "<br>" . $error->getMessage();
}
?>
<?php require "templates/header.php"; ?>

<h2>Delete category</h2>

<?php if ($success) echo $success; ?>

<table>
  <thead>
    <tr>
      <th>#</th>
      <th>Category</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach ($result as $row) : ?>
    <tr>
      <td><?php echo escape($row["idCategory"]); ?></td>
      <td><?php echo escape($row["categoryName"]); ?></td>
      <td><a href="deleteCategory.php?idCategory=<?php echo escape($row["idCategory"]); ?>">Delete</a></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

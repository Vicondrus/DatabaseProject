<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
require "config.php";
require "common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "idCategory"        => $_POST['idCategory'],
      "categoryName" => $_POST['categoryName'],
    ];

    $sql = "UPDATE category
            SET  categoryName = :categoryName,
            WHERE idCategory = :idCategory";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['idCategory'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idCategory = $_GET['idCategory'];
    $sql = "SELECT * FROM category WHERE idCategory = :idCategory";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idCategory', $idCategory);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['categoryName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit category</h2>

<form method="post">
    <?php foreach ($user as $key => $value) :?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idCategory' ? 'readonly' : null); ?>><br>
    <?php
  endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

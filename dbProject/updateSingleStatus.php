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
      "idStatus"        => $_POST['idStatus'],
      "statusCategory" => $_POST['statusCategory'],
    ];

    $sql = "UPDATE status
            SET idStatus = :idStatus,
              statusCategory = :statusCategory,
            WHERE idStatus = :idStatus";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
}

if (isset($_GET['idStatus'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idStatus = $_GET['idStatus'];
    $sql = "SELECT * FROM status WHERE idStatus = :idStatus";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idStatus', $idStatus);
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
	<blockquote><?php echo escape($_POST['statusName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Status</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idStatus' ? 'readonly' : null); ?>><br>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

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
      "idMenu_Item"        => $_POST['idMenu_Item'],
      "itemName" => $_POST['itemName'],
      "categoryId"  => $_POST['categoryId'],
      "description"     => $_POST['description'],
      "ingredients"     => $_POST['ingredients'],
      "active"     => $_POST['active'],
      "price"     => $_POST['price']
    ];

    $sql = "UPDATE menu_item
            SET idMenu_Item = :idMenu_Item,
              itemName = :itemName,
              categoryId = :categoryId,
              description = :description,
              ingredients = :ingredients,
              active = :active,
              price = :price
            WHERE idMenu_Item = :idMenu_Item";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
}

if (isset($_GET['idMenu_Item'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idMenu_Item = $_GET['idMenu_Item'];
    $sql = "SELECT * FROM menu_item WHERE idMenu_Item = :idMenu_Item";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idMenu_Item', $idMenu_Item);
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
	<blockquote><?php echo escape($_POST['itemName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Delivery Boy</h2>

<form method="post">
    <?php foreach ($user as $key => $value) : ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idMenu_Item' ? 'readonly' : null); ?>><br>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

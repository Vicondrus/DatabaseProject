<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
require "config.php";
require "common.php";

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM menu_item where active=1";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$menu = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
}

if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "idOrder"        => $_POST['idOrder'],
      "idMenu" => $_POST['idMenu'],
      "quantity"  => $_POST['quantity']
    ];

    $sql = "UPDATE `pizzeriad'autore`.menu_order
            SET idOrder = :idOrder,
              idMenu = :idMenu,
              quantity = :quantity
            WHERE idOrder = :idOrder AND idMenu=:idMenu";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['idOrder']) && isset($_GET['idMenu'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idOrder = $_GET['idOrder'];
    $idMenu = $_GET['idMenu'];
    $sql = "SELECT * FROM `pizzeriad'autore`.menu_order WHERE idOrder = :idOrder AND idMenu=:idMenu";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idOrder', $idOrder);
    $statement->bindValue(':idMenu', $idMenu);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote>Relationship between order <?php echo escape($_POST['idOrder']); ?> and menu item <?php echo escape($_POST['idMenu']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Relationship</h2>

<form method="post">
    <?php foreach ($user as $key => $value) {
      switch ($key) {
        case "idOrder":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idOrder' ? 'readonly' : null); ?>><br>
      <?php break;
      case "idMenu":?>
			<label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idMenu' ? 'readonly' : null); ?>><br>
  <?php  break;
  case "quantity":?>
  <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
  <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idMenu_Item' ? 'readonly' : null); ?>><br>
  <?php break;
} } ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

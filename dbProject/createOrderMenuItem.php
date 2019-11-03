<?php
require "config.php";
require "common.php";

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM `pizzeriad'autore`.`order`";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$order = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
}

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM menu_item";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$menu = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
}

if (isset($_POST['submit'])) {

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"idOrder" => $_POST['idOrder'],
			"idMenu" => $_POST['idMenu'],
			"quantity" => $_POST['quantity']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`menu_order`",
				implode(",", array_keys($new_customer)),
				":" . implode(", :", array_keys($new_customer))
		);

		$statement = $connection->prepare($sql);
		$statement->execute($new_customer);
	} catch(Exception $error) {
		echo $sql . "<br>" . $error->getMessage();
	}

}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
	<blockquote>Link between order <?php echo escape($_POST['idOrder']); ?> and menu item <?php echo escape($_POST['idMenu']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add link</h2>

<form method="post">
	<label for="idOrder">Order ID</label><br>
	<select name="idOrder" id="idOrder">
		<?php foreach ($order as $key => $value){?>
		<option value="<?php echo escape($value["idOrder"]); ?>"><?php echo escape($value["idOrder"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="idMenu">Menu Item</label><br>
	<select name="idMenu" id="idMenu">
		<?php foreach ($menu as $key => $value){?>
		<option value="<?php echo escape($value["idMenu_Item"]); ?>"><?php echo escape($value["itemName"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="quantity">Quantity</label><br>
	<input type="text" name="quantity" id="quantity"><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

<?php
require "config.php";
require "common.php";

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM status";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$status = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
}

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM customer";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$customer = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
}

try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT * FROM delivery_boy";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$delivery = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessaage();
}

if (isset($_POST['submit'])) {

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"idStatus" => $_POST['idStatus'],
			"idCustomer"  	=> $_POST['idCustomer'],
			"idDeliveryBoy" => $_POST['idDeliveryBoy'],
			"deliveryAddress" => $_POST['deliveryAddress'],
			"deliveryCity" => $_POST['deliveryCity']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`order`",
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
	<blockquote>Order at address <?php echo escape($_POST['deliveryAddress']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add Order</h2>

<form method="post">
	<label for="idStatus">Status</label><br>
	<select name="idStatus" id="idStatus">
		<?php foreach ($status as $key => $value){?>
		<option value="<?php echo escape($value["idStatus"]); ?>"><?php echo escape($value["statusName"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="idCustomer">Customer</label><br>
	<select name="idCustomer" id="idCustomer">
		<?php foreach ($customer as $key => $value){?>
		<option value="<?php echo escape($value["idCustomer"]); ?>"><?php echo escape($value["customerName"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="idDeliveryBoy">Delivery Boy</label><br>
	<select name="idDeliveryBoy" id="idDeliveryBoy">
		<?php foreach ($delivery as $key => $value){?>
		<option value="<?php echo escape($value["idDelivery_Boy"]); ?>"><?php echo escape($value["boyName"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="deliveryAddress">Delivery Address</label><br>
	<input type="text" name="deliveryAddress" id="deliveryAddress"><br>
	<label for="deliveryCity">Delivery City</label><br>
	<select name="deliverycity" id="deliverycity">
		<option value="Cluj-Napoca">Cluj-Napoca</option>
		<option value="Turda">Turda</option>
		<option value="Floresti">Floresti</option>
	</select><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

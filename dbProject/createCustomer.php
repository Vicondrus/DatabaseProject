<?php



if (isset($_POST['submit'])) {
	require "config.php";
	require "common.php";

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"customerName" => $_POST['customerName'],
			"city"  	=> $_POST['city'],
			"address" => $_POST['address'],
			"phone"  	=> $_POST['phone'],
			"email"  	=> $_POST['email']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`customer`",
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
	<blockquote><?php echo escape($_POST['customerName']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add customer</h2>

<form method="post">
	<label for="customerName">Customer Name</label><br>
	<input type="text" name="customerName" id="customerName"><br>
	<label for="city">City</label><br>
	<select name="city" id="city">
		<option value="Cluj-Napoca">Cluj-Napoca</option>
		<option value="Turda">Turda</option>
		<option value="Floresti">Floresti</option>
	</select><br>
	<label for="address">Address</label><br>
	<input type="text" name="address" id="address"><br>
	<label for="phone">Phone</label><br>
	<input type="text" name="phone" id="phone"><br>
	<label for="email">Email</label><br>
	<input type="text" name="email" id="email"><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

<?php



if (isset($_POST['submit'])) {
	require "config.php";
	require "common.php";

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"boyName" => $_POST['boyName'],
			"hasCar"  	=> $_POST['hasCar'],
			"city" => $_POST['city']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`delivery_boy`",
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

<?php if (isset($_POST['submit']) && !$error) { ?>
	<blockquote><?php echo escape($_POST['boyName']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add delivery boy</h2>

<form method="post">
	<label for="boyName">Delivery Boy's Name</label><br>
	<input type="text" name="boyName" id="boyName"><br>
	<label for="city">City</label><br>
	<select name="city" id="city">
		<option value="Cluj-Napoca">Cluj-Napoca</option>
		<option value="Turda">Turda</option>
		<option value="Floresti">Floresti</option>
	</select><br>
	<label for="hasCar">Has a car?</label><br>
	<input type="radio" name="hasCar" id="hasCar" value="1" checked>Yes<br>
	<input type="radio" name="hasCar" id="hasCar" value="0">No<br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

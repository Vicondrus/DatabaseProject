<?php



if (isset($_POST['submit'])) {
	require "config.php";
	require "common.php";

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"statusName" => $_POST['statusName']
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`status`",
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
	<blockquote><?php echo escape($_POST['statusName']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add status</h2>

<form method="post">
	<label for="statusName">Status Name</label><br>
	<input type="text" name="statusName" id="statusName"><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

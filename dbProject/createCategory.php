<?php



if (isset($_POST['submit'])) {
	require "config.php";
	require "common.php";

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"categoryName" => $_POST['categoryName'],
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`category`",
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
	<blockquote><?php echo escape($_POST['categoryName']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Add category</h2>

<form method="post">
	<label for="categoryName">Category Name</label><br>
	<input type="text" name="categoryName" id="categoryName"><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

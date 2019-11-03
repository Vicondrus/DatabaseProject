<?php
require "config.php";
require "common.php";
try {
	$connection = new PDO($dsn, $username, $password, $options);
	$sql = "SELECT idCategory, categoryName FROM category";
	$statement = $connection->prepare($sql);
	$statement->execute();
	$user = $statement->fetchAll();
} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessaage();
}

if (isset($_POST['submit'])) {

	try {
		$connection = new PDO($dsn, $username, $password, $options);

		$new_customer = array(
			"itemName" => $_POST['itemName'],
			"categoryId"  	=> $_POST['categoryId'],
			"description" => $_POST['description'],
			"ingredients" => $_POST['ingredients'],
			"active" => $_POST['active'],
			"price" => $_POST['price'],
		);

		$sql = sprintf(
				"INSERT INTO %s (%s) values (%s)",
				"`pizzeriad'autore`.`menu_item`",
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
	<blockquote><?php echo escape($_POST['itemName']); ?> successfully added.</blockquote>
<?php } ?>

<h2>Create Menu Item</h2>


<form method="post">
	<label for="itemName">Menu Item Name</label><br>
	<input type="text" name="itemName" id="itemName"><br>
	<label for="categoryId">Category ID</label><br>
	<select name="categoryId" id="categoryId">
		<?php foreach ($user as $key => $value){?>
		<option value="<?php echo escape($value["idCategory"]); ?>"><?php echo escape($value["categoryName"]); ?></option>
	<?php } ?>
	</select><br>
	<label for="description">Description (weight)</label><br>
	<input type="text" name="description" id="description"><br>
	<label for="ingredients">Ingredients</label><br>
	<input type="text" size=50 name="ingredients" id="ingredients"><br>
	<label for="active">Is the item still active?</label><br>
	<input type="radio" name="active" id="active" value="1" checked>Yes<br>
	<input type="radio" name="active" id="active" value="0">No<br>
	<label for="price">Price</label><br>
	<input type="text" name="price" id="price"><br>
	<input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

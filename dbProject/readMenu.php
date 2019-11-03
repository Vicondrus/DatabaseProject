<?php

/**
 * Function to query information based on
 * a parameter: in this case, location.
 *
 */
	try {
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sql = "SELECT * FROM `pizzeriad'autore`.menu_view";

		$statement = $connection->prepare($sql);
		$statement->execute();

		$result = $statement->fetchAll();
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
?>
<?php require "templates/header.php"; ?>

<?php
	if ($result && $statement->rowCount() > 0) { ?>
		<h2>Menu</h2>
		<table>
			<thead>
				<tr>
					<th>Category</th>
					<th>Name</th>
					<th>description</th>
					<th>Ingredients</th>
					<th>Price (lei)</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["categoryName"]); ?></td>
				<td><?php echo escape($row["itemName"]); ?></td>
				<td><?php echo escape($row["description"]); ?></td>
				<td><?php echo escape($row["ingredients"]); ?></td>
				<td><?php echo escape($row["price (lei)"]); ?></td>
			</tr>
		<?php } ?>
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['categoryName']); ?>.</blockquote>
	<?php }
	?>

<h2>Categories</h2>
<ul>
	<li><a href="readTrad.php"><strong>Pizza Traditionali</strong></a></li>
	<li><a href="readSpec.php"><strong>Pizza Speciali</strong></a></li>
	<li><a href="readCalz.php"><strong>Pizza Calzoni e Dolci</strong></a></li>
	<li><a href="readDrinks.php"><strong>Toppings & Drinks</strong></a></li>
</ul>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

<?php

/**
 * Function to query information based on
 * a parameter: in this case, location.
 *
 */

if (isset($_POST['submit'])) {
	try {
		require "config.php";
		require "common.php";

		$connection = new PDO($dsn, $username, $password, $options);

		$sql1 = "SELECT *
						FROM `pizzeriad'autore`.order_view
						WHERE idOrder LIKE CONCAT('%',:idOrder,'%')";
		$sql1 = "SELECT *
						FROM `pizzeriad'autore`.price_view
						WHERE idOrder LIKE CONCAT('%',:idOrder,'%')";

		$location = $_POST['idOrder'];

		$statement1 = $connection->prepare($sql1);
		$statement1->bindParam(':idOrder', $location, PDO::PARAM_STR);
		$statement1->execute();
		$statement2 = $connection->prepare($sql2);
		$statement2->bindParam(':idOrder', $location, PDO::PARAM_STR);
		$statement2->execute();

		$result1 = $statement1->fetchAll();
		$result2 = $statement2->fetchAll();
	} catch(PDOException $error) {
		echo $sql1 . "<br>" . $error->getMessage();
		echo $sql2 . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
	if ($result1 && $statement1->rowCount() > 0) { ?>
		<h2>Order</h2>
		<table>
			<thead>
				<tr>
					<th>Product</th>
					<th>Price</th>
					<th>Quantity</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result1 as $row) { ?>
			<tr>
				<td><?php echo escape($row["itemName"]); ?></td>
				<td><?php echo escape($row["price"]); ?></td>
				<td><?php echo escape($row["quantity"]); ?></td>
			</tr>
		<?php } ?>
			</tbody>
	</table>
	<h3>Total: </hr>
		<?php foreach ($result2 as $row2) { ?>
			<?php echo escape($row2["total"]); ?>
			<?php echo escape($row2["customerName"]); ?>
		<?php } ?>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['idOrder']); ?>.</blockquote>
	<?php }
} ?>

<h2>Find an order by ID</h2>

<form method="post">
	<label for="idOrder">Order ID</label>
	<input type="text" id="idOrder" name="idOrder">
	<input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

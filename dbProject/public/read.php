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

		$sql = "SELECT *
						FROM customer
						WHERE customerName = :customerName";

		$location = $_POST['customerName'];

		$statement = $connection->prepare($sql);
		$statement->bindParam(':customerName', $location, PDO::PARAM_STR);
		$statement->execute();

		$result = $statement->fetchAll();
	} catch(PDOException $error) {
		echo $sql . "<br>" . $error->getMessage();
	}
}
?>
<?php require "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
	if ($result && $statement->rowCount() > 0) { ?>
		<h2>Results</h2>

		<table>
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>City</th>
					<th>Address</th>
					<th>Phone</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
	<?php foreach ($result as $row) { ?>
			<tr>
				<td><?php echo escape($row["idCustomer"]); ?></td>
				<td><?php echo escape($row["customerName"]); ?></td>
				<td><?php echo escape($row["city"]); ?></td>
				<td><?php echo escape($row["address"]); ?></td>
				<td><?php echo escape($row["phone"]); ?></td>
				<td><?php echo escape($row["email"]); ?></td>
			</tr>
		<?php } ?>
			</tbody>
	</table>
	<?php } else { ?>
		<blockquote>No results found for <?php echo escape($_POST['customerName']); ?>.</blockquote>
	<?php }
} ?>

<h2>Find customer by name</h2>

<form method="post">
	<label for="customerName">Name</label>
	<input type="text" id="customerName" name="customerName">
	<input type="submit" name="submit" value="View Results">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

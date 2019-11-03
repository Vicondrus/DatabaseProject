<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
require "config.php";
require "common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "idCustomer"        => $_POST['idCustomer'],
      "customerName" => $_POST['customerName'],
      "city"  => $_POST['city'],
      "address"     => $_POST['address'],
      "phone"       => $_POST['phone'],
      "email"  => $_POST['email']
    ];

    $sql = "UPDATE customer
            SET idCustomer = :idCustomer,
              customerName = :customerName,
              city = :city,
              address = :address,
              phone = :phone,
              email = :email
            WHERE idCustomer = :idCustomer";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
}

if (isset($_GET['idCustomer'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idCustomer = $_GET['idCustomer'];
    $sql = "SELECT * FROM customer WHERE idCustomer = :idCustomer";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idCustomer', $idCustomer);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) : ?>
	<blockquote><?php echo escape($_POST['customerName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit customer</h2>

<form method="post">
    <?php foreach ($user as $key => $value) :
      if ($key!="city"){
      ?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idCustomer' ? 'readonly' : null); ?>><br>
    <?php }
    else if ($key=="city"){?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
      <select name="city" id="city">
    		<option value="Cluj-Napoca" <?php if (escape($value) == "Cluj-Napoca"){ echo selected;} ?>>Cluj-Napoca</option>
    		<option value="Turda" <?php if (escape($value) == "Turda"){ echo selected;} ?>>Turda</option>
    		<option value="Floresti" <?php if (escape($value) == "Floresti"){ echo selected;} ?>>Floresti</option>
    	</select><br>
  <?php } ?>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

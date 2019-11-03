<?php
/**
 * Use an HTML form to edit an entry in the
 * users table.
 *
 */
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

if ($_POST['deliveryTime'] == NULL){
    $deliveryaux = NULL;
}else {
  $deliveryaux = $_POST['deliveryTime'];
}
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "idOrder"        => $_POST['idOrder'],
      "idStatus" => $_POST['idStatus'],
      "idCustomer"  => $_POST['idCustomer'],
      "idDeliveryBoy"     => $_POST['idDeliveryBoy'],
      "deliveryAddress"     => $_POST['deliveryAddress'],
      "deliveryCity"     => $_POST['deliveryCity'],
      "deliveryTime"     => $deliveryaux
    ];

    $sql = "UPDATE `pizzeriad'autore`.`order`
            SET idOrder = :idOrder,
              idStatus = :idStatus,
              idCustomer = :idCustomer,
              idDeliveryBoy = :idDeliveryBoy,
              deliveryAddress = :deliveryAddress,
              deliveryCity = :deliveryCity,
              deliveryTime = :deliveryTime
            WHERE idOrder = :idOrder";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['idOrder'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idOrder = $_GET['idOrder'];
    $sql = "SELECT * FROM `pizzeriad'autore`.`order` WHERE idOrder = :idOrder";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idOrder', $idOrder);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && !$error) : ?>
	<blockquote><?php echo escape($_POST['idOrder']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Order</h2>

<form method="post">
    <?php foreach ($user as $key => $value) {
      switch ($key) {
        case "idOrder":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idOrder' ? 'readonly' : null); ?>><br>
    <?php break;
    case "idStatus":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
      <select name="idStatus" id="idStatus">
      <?php foreach ($status as $key1 => $value1){?>
  		<option value="<?php echo escape($value1["idStatus"]); ?>" <?php if($value1["idStatus"] == escape($value)) { echo selected; }?>><?php echo escape($value1["statusName"]); ?></option>
  	<?php } ?>
  	</select><br>
    <?php break;
    case "idCustomer":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
      <select name="idCustomer" id="idCustomer">
      <?php foreach ($customer as $key1 => $value1){?>
  		<option value="<?php echo escape($value1["idCustomer"]); ?>" <?php if($value1["idCustomer"] == escape($value)) { echo selected; }?>><?php echo escape($value1["customerName"]); ?></option>
  	<?php } ?>
  </select><br>
    <?php break;
    case "idDeliveryBoy":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
      <select name="idDeliveryBoy" id="idDeliveryBoy">
      <?php foreach ($delivery as $key1 => $value1){?>
  		<option value="<?php echo escape($value1["idDelivery_Boy"]); ?>" <?php if($value1["idDelivery_Boy"] == escape($value)) { echo selected; }?>><?php echo escape($value1["boyName"]); ?></option>
  	<?php } ?>
  	</select><br>
    <?php break;
    case "deliveryAddress":?>
  <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
  <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idOrder' ? 'readonly' : null); ?>><br>
  <?php break;
  case "deliveryCity":?>
  <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
  <select name="deliveryCity" id="deliveryCity">
    <option value="Cluj-Napoca" <?php if (escape($value) == "Cluj-Napoca"){ echo selected;} ?>>Cluj-Napoca</option>
    <option value="Turda" <?php if (escape($value) == "Turda"){ echo selected;} ?>>Turda</option>
    <option value="Floresti" <?php if (escape($value) == "Floresti"){ echo selected;} ?>>Floresti</option>
  </select><br>
  <?php break;
  case "deliveryTime":?>
<label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
<input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idOrder' ? 'readonly' : null); ?>><br>
    <?php
    break;
  }
} ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

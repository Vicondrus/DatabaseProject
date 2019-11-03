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
      "idDelivery_Boy"        => $_POST['idDelivery_Boy'],
      "boyName" => $_POST['boyName'],
      "hasCar"  => $_POST['hasCar'],
      "city"     => $_POST['city']
    ];

    $sql = "UPDATE delivery_boy
            SET idDelivery_Boy = :idDelivery_Boy,
              boyName = :boyName,
              hasCar = :hasCar,
              city = :city
            WHERE idDelivery_Boy = :idDelivery_Boy";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessphone();
  }
}

if (isset($_GET['idDelivery_Boy'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $idDelivery_Boy = $_GET['idDelivery_Boy'];
    $sql = "SELECT * FROM delivery_boy WHERE idDelivery_Boy = :idDelivery_Boy";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':idDelivery_Boy', $idDelivery_Boy);
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
	<blockquote><?php echo escape($_POST['boyName']); ?> successfully updated.</blockquote>
<?php endif; ?>

<h2>Edit Delivery Boy</h2>

<form method="post">
    <?php foreach ($user as $key => $value) :
      switch ($key) {
        case "idDelivery_Boy":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idDelivery_Boy' ? 'readonly' : null); ?>><br>
      <?php break;
      case "boyName":?>
      <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
	    <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'idDelivery_Boy' ? 'readonly' : null); ?>><br>
      <?php break;
      case "hasCar":?>
    <label for="hasCar">Has a car?</label><br>
    <input type="radio" name="hasCar" id="hasCar" value="1" <?php if (escape($value) == 1) { echo checked; }?>>Yes<br>
    <input type="radio" name="hasCar" id="hasCar" value="0" <?php if (escape($value) == 0) { echo checked; }?>>No<br>
    <?php break;
    case "city":?>
    <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label><br>
    <select name="city" id="city">
      <option value="Cluj-Napoca" <?php if (escape($value) == "Cluj-Napoca"){ echo selected;} ?>>Cluj-Napoca</option>
      <option value="Turda" <?php if (escape($value) == "Turda"){ echo selected;} ?>>Turda</option>
      <option value="Floresti" <?php if (escape($value) == "Floresti"){ echo selected;} ?>>Floresti</option>
    </select><br>
    <?php break;
  } endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form><br>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>

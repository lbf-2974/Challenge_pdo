<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

$query = "SELECT * FROM friend";
$statment = $pdo->query($query);
$friends = $statment->fetchAll();

?>

<?php 

$errors = [];
if($_SERVER['REQUEST_METHOD'] === "POST") {

    $data = array_map("trim", $_POST);

    if(!isset($data['firstname']) || empty($data['firstname'])) {
        $errors[] = "Le prénom est obligatoire";
    }

    if(!isset($data['lastname']) || empty($data['lastname'])) {
        $errors[] = "Le prénom est obligatoire";
    }

    if(empty($errors)) {

        $query = "INSERT INTO friend (firstname,lastname)
        VALUES (:firstname, :lastname);";

        $statement = $pdo->prepare($query);
        $statement->bindValue(':firstname', $data['firstname'], PDO::PARAM_STR);
        $statement->bindValue(':lastname', $data['lastname'], PDO::PARAM_STR);

        $statement->execute();

        header("Location: index.php");
        die();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quête Pdo Challenge</title>
</head>

<body>

    <ul>
        <?php foreach ($friends as $friend) { ?>

            <li>Prénom : <?= $friend['firstname'] ?></li>
            <li>Nom : <?= $friend['lastname'] ?></li><br>


        <?php } ?>
    </ul>


    <form method="post">

        <div>
            <label for="firstname">Prénom</label>
            <input type="text" id="firstname" name="firstname" required>
        </div>

        <div>
            <label for="lastname"> Nom </label>
            <input type="text" id="lastname" name="lastname">
        </div>

        <div class="button">
            <button type="submit">Envoyer</button>
        </div>

    </form>


</body>

</html>
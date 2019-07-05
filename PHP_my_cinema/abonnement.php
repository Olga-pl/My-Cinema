<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" type="text/css" href="my_cinema.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>My Cinema</title>
</head>
<body>
<header>
    <div class="row">
        <h1 class="col-md-4">My Cinema &copy;</h1>
        <nav class="col-md-8 text-right">
            <a href="index.php">
                <figure>
                    <img class="logos" src="img/popcorn.png" alt="popcorn">
                    <figcaption>
                        <strong>Home</strong>
                    </figcaption>
                </figure>
            </a>
            <a href="movies_html.php">
                <figure>
                    <img class="logos" src="img/movie.png" alt="film">
                    <figcaption>
                        <strong>Movies</strong>
                    </figcaption>
                </figure>
            </a>
            <a href="seances_html.php">
                <figure>
                    <img class="logos" src="img/calendar.png" alt="calendrier">
                    <figcaption>
                        <strong>Sessions</strong>
                    </figcaption>
                </figure>
            </a>
            <a href="login_html.php">
                <figure>
                    <img class="logos" src="img/login.png" alt="camera">
                    <figcaption class="active">
                        <strong>Members</strong>
                    </figcaption>
                </figure>
            </a>
        </nav>
    </div>
</header>
<div class="header-middle">
    <figure class="header_picture">
        <img src="img/cinema.png" alt="movie">
    </figure>
</div>

<h3>Your Subscription</h3><br>
<?php
$membre = $_GET['id_membre'];

echo "<form class='members' action='abonnement.php?id_membre=$membre' method='post'>";

    $conn = new PDO('mysql:host=127.0.0.1;dbname=epitech_tp', 'root', 'root');

    $find = $conn->prepare('SELECT id_abo, nom FROM abonnement');
    $find->execute();
echo '<select name="select_abo">';
    foreach ($find as $abo) {
        $id = $abo['id_abo'];
        $nom = $abo['nom'];
        echo "<option value='$id'>$nom</option>";
    }
    echo '</select>';

    echo '<input type="submit" name="submit" value="Submit">
   
</form>';
    ?>
<?php
$membre = $_GET['id_membre'];
    echo "<form class='members' action='abonnement.php?id_membre=$membre' method='post'>
<input type='hidden' name='delete_abo' value='NULL'>";

echo '<input type="submit" name="delete_abo" value="Delete">
</form>';
?>
<?php include 'my_cinema.php' ?>

</body>

</html>

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
                    <figcaption class="active">
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
                    <figcaption>
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

<div class="checkbox_container">
    <h3>Find a movie</h3>
    <form class="check_form" method="post">
        <label for="film">
            Title<input id="film"type="text" name="titre"><br>
            Distributor<input id="film" type="text" name="distributor"><br>
        </label>

        <table class="table">
            <?php
            $conn = new PDO('mysql:host=127.0.0.1;dbname=epitech_tp', 'root', 'root');

            $find = $conn->prepare('SELECT nom, id_genre FROM genre ORDER BY nom ASC');
            $find->execute();

            while ($film_genre = $find->fetch()) {
                $select = $film_genre['nom'];

                echo " <label for='$select'>
              <input type='checkbox' id='$select' value='$select' name='genre[]'>$select</br></label>";
            }
            ?>
        </table>
        <input type="submit" name="submit" value="See the movies">
    </form>
</div>
<?php include 'my_cinema.php' ?>
</body>

</html>

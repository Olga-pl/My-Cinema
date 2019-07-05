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
                    <img class="logos" src="img/movie.png" alt="movie">
                    <figcaption>
                        <strong>Movies</strong>
                    </figcaption>
                </figure>
            </a>
            <a href="seances_html.php">
                <figure>
                    <img class="logos" src="img/calendar.png" alt="calendrier">
                    <figcaption class="active">
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

<h3>Choose your session</h3><br>
<form class="session" action="seances_html.php" method="post">
    <label for="date"><input id="date" name="date" type='date'></label><br>
    <input value="Get showtime" type="submit">
</form>
<?php include 'my_cinema.php' ?>
</body>

</html>

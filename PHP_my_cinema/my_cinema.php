<?php include 'connexion_php.php' ?>

<?php

class test
{
    public function connexion()
    {
        $conn = new PDO('mysql:host=127.0.0.1;dbname=epitech_tp', 'root', 'root');
        return $conn;
    }
}

function nom()
{
    $conn = new test;
    $connexion = $conn->connexion();

    $result = $connexion->prepare('SELECT fiche_personne.nom AS "name", prenom, id_perso, 
abonnement.nom, abonnement.id_abo, membre.id_membre
FROM fiche_personne 
INNER JOIN membre ON membre.id_fiche_perso=fiche_personne.id_perso 
INNER JOIN abonnement ON abonnement.id_abo=membre.id_abo
WHERE fiche_personne.nom LIKE :nom AND fiche_personne.prenom LIKE :prenom ORDER BY fiche_personne.nom ASC');

    $nom = $_POST['nom'] . "%";
    $prenom = $_POST['prenom'] . "%";

    $result->execute([':nom' => $nom, ':prenom' => $prenom]);

    echo "<table class='table'>
                <thead  class='table-dark'>
                    <tr>
                        <th scope='col'> Name</th>
                        <th scope='col'> Firstname</th>
                        <th scope='col'> Historic</th>
                        <th scope='col'> Abonnement</th>
                        <th scope='col'>Edit</th>
                        </tr>
                    </thead>";

    while ($name = $result->fetch()) {
        $findnom = $name['name'];
        $findprenom = $name['prenom'];
        $id = $name['id_perso'];
        $find_abo = $name['nom'];
        $membre = $name['id_membre'];
        $abo = $name['id_abo'];

        echo " <tbody>
                    <td>$findnom</td>
                    <td>$findprenom</td>
                    <td><a href='login_html.php?id_perso=$id'>See historic</a></td>
                    <td>$find_abo</td>
                    <td><a href='abonnement.php?id_membre=$membre&id_abo=$abo'>Edit your subscription</a></td>
                    <br>";
    }

    echo "</table>";

}

if (isset($_POST['prenom']) || isset($_POST['nom'])) {
    nom();
}

function get_film()
{
    $conn = new test;
    $connexion = $conn->connexion();

    if (isset($_POST['genre']) || isset($_POST['genre']) && isset($_POST['distributor'])) {
        echo "<table class='table'>
                <thead  class='table-danger'>
                    <tr>
                        <th scope='col'> Movies</th>
                        <th scope='col'> Genre</th>
                        <th scope='col'> Distrib</th>
                    </tr>
                    </thead>";

        foreach ($_POST['genre'] as $values) {
            $find = $connexion->prepare('SELECT film.titre, genre.nom, distrib.nom AS "name" FROM film 
INNER JOIN genre ON genre.id_genre=film.id_genre
INNER JOIN distrib ON film.id_distrib=distrib.id_distrib 
WHERE genre.nom LIKE "' . $values . '" 
AND film.titre LIKE :titre AND distrib.nom LIKE :nom ORDER BY titre ASC');

            $titre = $_POST['titre'] . "%";
            $nom = $_POST['distributor'] . "%";

            $find->execute([':titre' => $titre, ':nom' => $nom]);

            while ($genre = $find->fetch()) {
                $findgenre = $genre['nom'];
                $findfilm = $genre['titre'];
                $find_distrib = $genre['name'];

                echo " <tbody>
                    <td>$findfilm</td>
                    <td>$findgenre</td>
                    <td>$find_distrib</td>
               </tbody>";
            }
        }
    }

    elseif (isset($_POST['titre']) && !isset($_POST['genre'])) {
            echo "<table class='table'>
                <thead  class='table-danger'>
                    <tr>
                        <th scope='col'> Movies</th>
                        <th scope='col'> Summary</th>
                        <th scope='col'> Year</th>
                    </tr>
                    </thead>";


        $find = $connexion->prepare('SELECT * FROM film WHERE titre LIKE :titre ORDER BY titre ASC');

        $titre = $_POST['titre'] . "%";

        $find->execute([':titre' => $titre]);

        while ($genre = $find->fetch()) {
            $findfilm = $genre['titre'];
            $findresum = $genre['resum'];
            $findprod = $genre['annee_prod'];

            echo " <tbody>
                    <td>$findfilm</td>
                    <td>$findresum</td>
                    <td>$findprod</td>
               </tbody>";
        }
    }
}

if (isset($_POST['genre']) && !$_POST['distributor'] || isset($_POST['titre']) && !$_POST['distributor'] ||
    isset($_POST['genre']) && isset($_POST['distributor']) ||
    isset($_POST['distributor']) && isset($_POST['genre']) && isset($_POST['titre'])) {
    get_film();
}

function get_unique_distrib()
{
    $conn = new test;
    $connexion = $conn->connexion();

    echo "<table class='table'>
                <thead  class='table-danger'>
                    <tr>
                        <th scope='col'> Movies</th>
                        <th scope='col'> Distrib</th>
                    </tr>
                    </thead>";

    $find = $connexion->prepare('SELECT distrib.*, film.titre FROM distrib 
  INNER JOIN film ON distrib.id_distrib=film.id_distrib 
WHERE distrib.nom LIKE :nom AND titre LIKE :titre ORDER BY titre ASC');

    $distrib = $_POST['distributor'] . "%";
    $titre = $_POST['titre'] . "%";

    $find->execute([':nom' => $distrib, ':titre' => $titre]);

    while ($genre = $find->fetch()) {
        $findfilm = $genre['titre'];
        $find_distrib = $genre['nom'];

        echo " <tbody>
                    <td>$findfilm</td>
                    <td>$find_distrib</td>
               </tbody>";
    }
}

if (isset($_POST['distributor']) && !$_POST['genre'] || isset($_POST['distributor']) && isset($_POST['titre']) &&
    !$_POST['genre']) {
    get_unique_distrib();
}



function get_historic()
{
    $conn = new test;
    $connexion = $conn->connexion();

    $page = (!empty($_GET['page']) ? $_GET['page'] : 1);
    $limit = 10;

    $debut = ($page - 1) * $limit;

    $find = $connexion->prepare('SELECT historique_membre.date, film.*, fiche_personne.*, membre.id_membre, 
historique_membre.avis 
FROM fiche_personne
INNER JOIN membre ON fiche_personne.id_perso=membre.id_fiche_perso 
INNER JOIN historique_membre ON membre.id_membre=historique_membre.id_membre 
INNER JOIN film ON film.id_film=historique_membre.id_film 
WHERE id_perso=:perso ORDER BY date DESC LIMIT :debut, :limit');

    $perso = $_GET['id_perso'];

    $next_page = $page + 1;
    $previous_page = $page - 1;


    $find->bindParam(':perso', $perso, PDO::PARAM_INT);
    $find->bindParam(':limit', $limit, PDO::PARAM_INT);
    $find->bindParam(':debut', $debut, PDO::PARAM_INT);
    $find->execute();

    echo "<table class='table'>
                <thead  class='table-danger'>
                    <tr>
                    
                        <th scope='col'> Title</th>
                        <th scope='col'> Date</th>
                        <th scope='col'>My review</th>
                        <th scope='col'> Add a review</th>
                        </tr>
                    </thead>";

    while ($historic = $find->fetch()) {

        $get_date = $historic['date'];
        $get_title = $historic['titre'];
        $membre = $historic['id_membre'];
        $film = $historic['id_film'];
        $avis = $historic['avis'];

        echo " <tr>
                <td>$get_title</td>
                <td>$get_date</td>
                <td>$avis</td>
                <td><a href='avis.php?id_membre=$membre&id_film=$film'>Add a review</td>
               </tr>";
    }

    echo "<a href='login_html.php?id_perso=$perso&page=$previous_page'>Previous page </a>
           <a href='login_html.php?id_perso=$perso&page=$next_page'> Next page</a>";
}

if (isset($_GET['id_perso'])) {
    get_historic();
}


function get_date()
{

    $conn = new test;
    $connexion = $conn->connexion();

    $find = $connexion->prepare('SELECT date_debut_affiche, date_fin_affiche, film.titre FROM film 
WHERE date_debut_affiche<:date_film AND date_fin_affiche>:date_film');

    $date = $_POST['date'];

    $find->execute([':date_film' => $date]);

    echo "<table class='table'>
                <thead  class='table-danger'>
                    <tr>
                        <th scope='col'>Title</th>
                        <th scope='col'>Begin</th>
                        <th scope='col'>End</th> 
                    </tr>
                 </thead>";

    while ($affiche = $find->fetch()) {
        $debut = $affiche['date_debut_affiche'];
        $fin = $affiche['date_fin_affiche'];
        $title = $affiche['titre'];

        echo " <tbody>
                <td>$title</td> 
                <td>$debut</td>
                <td>$fin</td>
                </tbody>";
    }
}

if (isset($_POST['date'])) {
    get_date();
}

function get_abo ()
{
    $conn = new test;
    $connexion = $conn->connexion();

    $membre = $_GET['id_membre'];
    $abo = $_POST['select_abo'];

       $find = $connexion->prepare('UPDATE membre SET id_abo=:abo WHERE id_membre=:id_membre AND id_abo!=:abo');

       $find->execute([':id_membre' => $membre, ':abo' => $abo]);
}

if (isset($_POST['select_abo'])) {
    get_abo();
}

function avis()
{
    $conn = new test;
    $connexion = $conn->connexion();

    $find = $connexion->prepare('UPDATE historique_membre SET avis=:avis_membre 
WHERE id_membre=:id_membre AND id_film=:id_film');

    $avis=$_POST['review'];
    $id_membre=$_POST['membre'];
    $id_film=$_POST['film'];

    $find->bindParam(':id_film', $id_film, PDO::PARAM_INT);
    $find->bindParam(':id_membre', $id_membre, PDO::PARAM_INT);
    $find->bindParam(':avis_membre', $avis, PDO::PARAM_STR);

    $find->execute();
}

if(isset($_POST['review'])) {
    avis();
}

function avis_delete() {
    $conn = new test;
    $connexion = $conn->connexion();

    $find_null = $connexion->prepare('UPDATE historique_membre SET avis=:avis  
WHERE id_membre=:id_membre AND id_film=:id_film');

    $avis_null = $_POST['delete_avis'];
    $id_membre=$_POST['membre'];
    $id_film=$_POST['film'];

    $find_null->bindParam(':avis', $avis_null, PDO::PARAM_NULL);
    $find_null->bindParam(':id_film', $id_film, PDO::PARAM_INT);
    $find_null->bindParam(':id_membre', $id_membre, PDO::PARAM_INT);

    $find_null->execute();
}

if (isset($_POST['delete_avis'])) {
    avis_delete();
}

function delete_abo ()
{
    $conn = new test;
    $connexion = $conn->connexion();

    $membre = $_GET['id_membre'];
    $abo = $_POST['delete_abo'];

    $find = $connexion->prepare('UPDATE membre SET id_abo=:abo WHERE id_membre=:id_membre');

    $find->bindParam(':abo', $abo, PDO::PARAM_NULL);
    $find->bindParam(':id_membre', $membre, PDO::PARAM_INT);

    $find->execute();
}

if (isset($_POST['delete_abo'])) {
    get_abo();
}
?>
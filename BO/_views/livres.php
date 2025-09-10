<?php
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/sidebar.php');

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/header.php');

$domaine = "Dashboard";
$sousDomaine = "Livres / Liste";

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/ariane.php');


if (isset($_GET['action']) && $_GET['action'] == "modifLivre") {

  // I take the id from Get that corresponds to the book
  $id = $_GET['id'];

  $selectLivre = $db->prepare('SELECT * FROM livres
  NATURAL JOIN types
  WHERE id_livre = ?
  ');
  $selectLivre->execute([$id]);
  $livre = $selectLivre->fetch(PDO::FETCH_OBJ);

  // je recupere l'id du type du livre qui est dans le resultat de la requete $livre
  $id_type = $livre->$id_type;

  // Je selectionne les types qui ne sont pas celui du livre
  $select_types = $db->prepare('SELECT * FROM types
    WHERE id_type != ?
  ');
  $select_types->execute([$id_type]);

  $select_auteurs = $db->prepare('SELECT * FROM auteurs');
  $select_auteurs->execute();

  $selectAuteursLivre = $db->prepare('SELECT * FROM livres_auteurs WHERE id_livre = ?');
  $selectAuteursLivre->execute([$id]);

  if(isset($_POST['addAuteur'])){
    $id_auteur = $_POST['id_auteur'];

    $insertAuteur = $db->prepare('INSERT INTO livres_auteurs SET
    id_auteur = ?,
    id_livre = ?
    ');
    $insertAuteur->execute([$id_auteur, $id]);

    echo "<script language='javascript'>
        document.location.replace('livres.php?zone=livres&action=modifLivre&id=".$id."')
        </script>";

  }

?>
  <form method="POST">

  <p>Les auteurs sont:</p>
  <?php
     while ($sAL = $selectAuteursLivre->fetch(PDO::FETCH_OBJ)) {
      ?>
       <p>- <?php echo $sAL->auteur_prenom;?> <?php echo $sAL->auteur_nom;?></p>
      <?php
     }
    ?>

      <label for="">Selectionner le type</label>
      <select name="id_type">
        <option value="<?php echo $livre->id_type;?>"><?php echo $livre->type_nom;?></option>
          <?php
          while ($sT = $selectTypes->fetch(PDO::FETCH_OBJ)) {
          ?>
              <option value="<?php echo $sT->id_type; ?>"><?php echo $sT->type_nom; ?></option>
          <?php
          }
          ?>
      </select>
      <div>
          <label for="">Nom du livre</label>
          <input type="text" name="livre_titre" value="<?php echo $livre->livre_titre;?>">
      </div>
      <div>
          <label for="">Synopsis du livre</label>
          <textarea name="livre_synopsis" placeholder="Ecrire le synopsis ici"><?php echo $livre->livre_synopsis;?></textarea>
      </div>
      <div>
          <label for="">Date d'écriture du livre</label>
          <input type="date" name="livre_date_create" value="<?php echo $livre->livre_date_create;?>">
      </div>
      <div>
          <input type="submit" value="Enregistrer" name="updateLivre">
      </div>
  </form>

  <form method="post">

    <label for="">Sélectionner un auteur</label>
    <select name="id_auteur" id="">
      <?php
          while ($sA = $select_auteurs->fetch(PDO::FETCH_OBJ)) {
          ?>
            <option value="><?php echo $sA->id_auteur;?>"><?php echo ucwords($sA->auteur_prenom);?> <?php echo ucwords($sA->auteur_nom);?></option>
          <?php

           }
           ?>
    </select>

    <div>
      <input type="submit" value="Enr" name="addAuteur">
    </div>
  </form>

<?php


}else if(isset($_GET['action']) && $_GET['action'] == "addType"){

    //AJOUTER UN TYPE

    $selectTypes = $db->prepare('SELECT * FROM types');
    $selectTypes->execute();

    if (isset($_POST['addType'])){
        $nom = htmlspecialchars($_POST['type_nom']);
        $description = htmlspecialchars($_POST['type_description']);

        $insert_type = $db->prepare('INSERT INTO types SET
            type_nom = ?,
            type_description = ?
        ');

        $insert_type->execute([$nom, $description]);

        //header('Location: /BO/_views/livres.php');
        echo "<script language='javascript'>
        document.location.replace('livres.php?zone=livres&action=addType')
        </script>";
    }

    ?>

    <form method="POST">
        <div>
            <label for="">Nom du Type :</label>
            <input type="text" name="type_nom">
        </div>
        <div>
            <label for="">Description du Type :</label>
            <textarea type="text" name="type_description" placeholder="Décrire le type"></textarea>
        </div>
        <div><input class="btn" type="submit" value="Enregistrer" name="addType"></div>
    </form>

    <div class="records table_responsive">
        <div class="record_header spaceBetween alignCenter">
            <div class="add alignCenter">
                <span>Entries</span>
                <select name="#" id="#">
                    <option value="#">ID</option>
                </select>
                <a class="alignCenter" href="livres.php?zone=livres&action=addType">Gérer les types</a>
                <a class="alignCenter" href="livres.php?zone=livres&action=addGenre">Gérer les genres</a>
            </div>
            <div class="browse alignCenter">
                <input type="search" placeholder="Search" class="record_search">
                <select name="#" id="#">
                    <option value="#">Status</option>
                </select>
            </div>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><span class="las la-sort uppercase"></span> TYPES</th>
                        <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($sT = $selectTypes->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>#<?php echo $sT->id_type; ?></td>
                            <td>
                                <div class="client alignCenter">
                                    <div class="profile_img_he bg_img"></div>
                                    <div class="client-info">
                                        <h4 class="capitalize"><?php echo $sT->type_nom; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <span class="lab la-telegram-plane"></span>
                                    <a href="livres.php?zone=livres&action=modifType&id=<?php echo $sT->id_type; ?>"><span class="las la-eye"></span></a>
                                    <span class="las la-ellipsis-v"></span>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php

}else if(isset($_GET['action']) && $_GET['action'] == "modifType"){

    echo "Modifier le type";

}else if(isset($_GET['action']) && $_GET['action'] == "addGenre"){

    //AJOUTER UN GENRE

    $selectGenres = $db->prepare('SELECT * FROM genres');
    $selectGenres->execute();

    if (isset($_POST['addGenre'])){
        $nom = htmlspecialchars($_POST['genre_nom']);
        $description = htmlspecialchars($_POST['genre_description']);

        $insert_genre = $db->prepare('INSERT INTO genres SET
            genre_nom = ?,
            genre_description = ?
        ');

        $insert_genre->execute([$nom, $description]);

        //header('Location: /BO/_views/livres.php');
        echo "<script language='javascript'>
        document.location.replace('livres.php?zone=livres&action=addGenre')
        </script>";
    }

    ?>

    <form method="POST">
        <div>
            <label for="">Nom du Type :</label>
            <input type="text" name="genre_nom">
        </div>
        <div>
            <label for="">Description du Type :</label>
            <textarea type="text" name="genre_description" placeholder="Décrire le genre"></textarea>
        </div>
        <div><input class="btn" type="submit" value="Enregistrer" name="addGenre"></div>
    </form>

    <div class="records table_responsive">
        <div class="record_header spaceBetween alignCenter">
            <div class="add alignCenter">
                <span>Entries</span>
                <select name="#" id="#">
                    <option value="#">ID</option>
                </select>
                <a class="alignCenter" href="livres.php?zone=livres&action=addType">Gérer les types</a>
                <a class="alignCenter" href="livres.php?zone=livres&action=addGenre">Gérer les genres</a>
            </div>
            <div class="browse alignCenter">
                <input type="search" placeholder="Search" class="record_search">
                <select name="#" id="#">
                    <option value="#">Status</option>
                </select>
            </div>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><span class="las la-sort uppercase"></span> GENRES</th>
                        <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($sT = $selectGenres->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>#<?php echo $sT->id_genre; ?></td>
                            <td>
                                <div class="client alignCenter">
                                    <div class="profile_img_he bg_img"></div>
                                    <div class="client-info">
                                        <h4 class="capitalize"><?php echo $sT->genre_nom; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="actions">
                                    <span class="lab la-telegram-plane"></span>
                                    <a href="livres.php?zone=livres&action=modifGenre&id=<?php echo $sT->id_genre; ?>"><span class="las la-eye"></span></a>
                                    <span class="las la-ellipsis-v"></span>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php

}else if(isset($_GET['action']) && $_GET['action'] == "modifGenre"){

    echo "Modifier le genre";


}else {
    $selectTypes = $db->prepare('SELECT * FROM types');
    $selectTypes->execute();

    $selectLivres = $db->prepare('SELECT * FROM livres');
    $selectLivres->execute();

    if(isset($_POST['addLivre'])){
      $titre = htmlspecialchars($_POST['livre_titre']);
      $synopsys = htmlspecialchars($_POST['livre_synopsys']);
      $date = $_POST['livre_date_create'];
      $type = $_POST['id_type'];

    $insertLivre = $db->prepare('INSERT INTO livres SET
      livre_titre = ?,
      livre_synopsys = ?,
      livre_date_create = ?,
      id_type = ?
    ');
    $insert_livre->execute([$titre, $synopsys, $date, $type]);
  }

    ?>

    <form method="POST">
        <label for="">Type :</label>
        <select name="id_type">
            <?php
            while ($sT = $selectTypes->fetch(PDO::FETCH_OBJ)) {
            ?>
                <option value="<?php echo $sT->id_type; ?>"><?php echo $sT->type_nom; ?></option>
            <?php
            }
            ?>
        </select>
        <div>
            <label for="">Nom :</label>
            <input type="text" name="livre_titre">
        </div>
        <div>
            <label for="">Synopsis :</label>
            <textarea name="livre_synopsis" placeholder="Ecrire le synopsis"></textarea>
        </div>
        <div>
            <label for="">Date :</label>
            <input type="date" name="livre_date_create">
        </div>
        <div>
            <input type="submit" value="Enregistrer" name="addLivre">
        </div>
    </form>

    <div class="records table_responsive">
        <div class="record_header spaceBetween alignCenter">
            <div class="add alignCenter">
                <span>Entries</span>
                <select name="#" id="#">
                    <option value="#">ID</option>
                </select>
                <a class="alignCenter" href="livres.php?zone=livres&action=addType">Gérer les types</a>
                <a class="alignCenter" href="livres.php?zone=livres&action=addGenre">Gérer les genres</a>
            </div>
            <div class="browse alignCenter">
                <input type="search" placeholder="Search" class="record_search">
                <select name="#" id="#">
                    <option value="#">Status</option>
                </select>
            </div>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><span class="las la-sort uppercase"></span> TITRES</th>
                        <th><span class="las la-sort uppercase"></span> AUTEURS</th>
                        <th><span class="las la-sort uppercase"></span> TYPE</th>
                        <th><span class="las la-sort uppercase"></span> GENRES</th>
                        <th><span class="las la-sort uppercase"></span> DATE D'ECRITURE</th>
                        <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($sL = $selectLivres->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>#<?php echo $sL->id_livre; ?></td>
                            <td>
                                <div class="client">
                                    <div class="profile_img_he bg_img"></div>
                                    <div class="client-info">
                                        <h4><?php echo $sL->livre_titre; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td>auteur</td>

                            <td>Type</td>

                            <td>genre</td>

                            <td><?php echo $sL->livre_date_create; ?></td>

                            <td>
                                <div class="actions">
                                    <span class="lab la-telegram-plane"></span>
                                    <a href="livres.php?zone=livres&action=modifLivre&id=<?php echo $sA->id_livre; ?>"><span class="las la-eye"></span></a>
                                    <span class="las la-ellipsis-v"></span>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
}

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/footer.php');
?>
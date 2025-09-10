<?php
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/sidebar.php');

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/header.php');

$domaine = "Dashboard";
$sousDomaine = "Auteurs / Liste";

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/ariane.php');

if (isset($_GET['action']) && $_GET['action'] == "modifAuteur") {
    $id = $_GET['id'];

    //Je sélectionne les éléments de la table auteurs qui correspondent à mon id
    $selectAuteur = $db->prepare('SELECT * FROM auteurs WHERE id_auteur = ? ');

    $selectAuteur->execute([$id]);
    $auteur = $selectAuteur->fetch(PDO::FETCH_OBJ);

    if (isset($_POST['update_auteur'])) {
        $prenom = htmlspecialchars($_POST['auteur_prenom']);
        $nom = htmlspecialchars($_POST['auteur_nom']);
        $date = $_POST['auteur_date_naissance'];
        $bio = htmlspecialchars($_POST['auteur_bio']);
        $nombre = $_POST['auteur_nbre_ouvrage'];

        $update_auteur = $db->prepare('UPDATE auteurs SET 
            auteur_prenom = ?,
            auteur_nom = ?,
            auteur_date_naissance = ?,
            auteur_bio = ?,
            auteur_nbre_ouvrage = ? 
            WHERE id_auteur = ? ');

        $update_auteur->execute([$prenom, $nom, $date, $bio, $nombre, $id]);

        //header('Location: /BO/_views/auteurs.php');
        echo "<script language='javascript'>
        document.location.replace('auteurs.php')
        </script>";
    }

    ?>
        <form method="POST">
            <div>
                <label for="">Nom de l'auteur :</label>
                <input type="text" name="auteur_nom" value="<?php echo $auteur->auteur_nom; ?>">
            </div>
            <div>
                <label for="">Prénom de l'auteur :</label>
                <input type="text" name="auteur_prenom" value="<?php echo $auteur->auteur_prenom; ?>">
            </div>
            <div>
                <label for="">Date de naîssance de l'auteur :</label>
                <input type="date" name="auteur_date_naissance" value="<?php echo $auteur->auteur_date_naissance; ?>">
            </div>
            <div>
                <label for="">Nombre d'ouvrage de l'auteur :</label>
                <input type="number" name="auteur_nbre_ouvrage" value="<?php echo $auteur->auteur_nbre_ouvrage; ?>">
            </div>
             <div>
                <label for="">Bio de l'auteur :</label>
                <textarea name="auteur_bio" value="<?php echo $auteur->auteur_bio; ?>"></textarea>
            </div>
            <div>
                <input type="submit" value="Enr" name="update_auteur">
            </div>
        </form>

    <div class="records table_responsive">
        <div class="record_header spaceBetween alignCenter">
            <div class="add alignCenter">
                <span>Entries</span>
                <select name="#" id="#">
                    <option value="#">ID</option>
                </select>
                <button>Add record</button>
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
                        <th><span class="las la-sort uppercase"></span> ABONNES</th>
                        <th><span class="las la-sort uppercase"></span> DATE DE NAISSANCE</th>
                        <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($sA = $selectAbonnes->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>#<?php echo $sA->id_abonne; ?></td>
                            <td>
                                <div class="client alignCenter">
                                    <div class="profile_img_he bg_img"></div>
                                    <div class="client-info">
                                        <h4 class="capitalize"><?php echo $sA->abonne_prenom; ?> <?php echo $sA->abonne_nom; ?></h4>
                                    </div>
                                </div>
                            </td>
                            <td><?php echo $sA->abonne_date_naissance; ?></td>
                            <td>
                                <div class="actions">
                                    <span class="lab la-telegram-plane"></span>
                                    <a href="abonnes.php?zone=abonnes&action=modifAbonne&id=<?php echo $sA->id_abonne; ?>"><span class="las la-eye"></span></a>
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
    

} else {
    $selectAuteurs = $db->prepare('SELECT * FROM auteurs');
    $selectAuteurs->execute();

    //Fonctionnalité d'ajout d'un abonnée
    if (isset($_POST['add_auteur'])) {
        $prenom = htmlspecialchars($_POST['auteur_prenom']);
        $nom = htmlspecialchars($_POST['auteur_nom']);
        $date = $_POST['auteur_date_naissance'];
        $bio = htmlspecialchars($_POST['auteur_bio']);
        $num = $_POST['auteur_nbre_ouvrage'];


        $add_auteur = $db->prepare('INSERT INTO auteurs SET
            auteur_prenom = ?,
            auteur_nom = ?,
            auteur_date_naissance = ?,
            auteur_bio = ?,
            auteur_nbre_ouvrage = ?
        ');

        $add_auteur->execute([$prenom, $nom, $date, $bio, $num]);

        //header('Location: /BO/_views/auteurs.php');
        echo "<script language='javascript'>
        document.location.replace('auteurs.php')
        </script>";
    }

?>

    <form method="POST">
        <div>
            <label for="">Nom de l'auteur :</label>
            <input type="text" name="auteur_nom">
        </div>
        <div>
            <label for="">Prénom de l'auteur :</label>
            <input type="text" name="auteur_prenom">
        </div>
        <div>
            <label for="">Date de naîssance de l'auteur :</label>
            <input type="date" name="auteur_date_naissance">
        </div>
        <div>
            <label for="">Nombre d'ouvrage de l'auteur :</label>
            <input type="numerique" name="auteur_nbre_ouvrage">
        </div>
        <div>
            <label for="">Bio de l'auteur :</label>
            <textarea name="auteur_bio"></textarea>
        </div>
        <div>
            <input type="submit" value="Enregistrer" name="add_auteur">
        </div>
    </form>

    <div class="records table_responsive">
        <div class="record_header spaceBetween alignCenter">
            <div class="add alignCenter">
                <span>Entries</span>
                <select name="#" id="#">
                    <option value="#">ID</option>
                </select>
                <button>Add record</button>
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
                        <th><span class="las la-sort uppercase"></span> AUTEURS</th>
                        <th><span class="las la-sort uppercase"></span> DATE DE NAISSANCE</th>
                        <th><span class="las la-sort uppercase"></span> BIOGRAPHIE</th>
                        <th><span class="las la-sort uppercase"></span> NOMBRE D'OUVRAGE</th>
                        <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($sA = $selectAuteurs->fetch(PDO::FETCH_OBJ)) {
                    ?>
                        <tr>
                            <td>#<?php echo $sA->id_auteur; ?></td>
                            <td>
                                <div class="client alignCenter">
                                    <div class="profile_img_he bg_img"></div>
                                    <div class="client-info">
                                        <h4 ><?php echo $sA->auteur_prenom; ?> <?php echo $sA->auteur_nom; ?></h4>
                                    </div>
                                </div>
                            </td>

                            <td><?php echo $sA->auteur_date_naissance; ?></td>

                            <td>
                                <div class="actions">
                                    <span class="lab la-telegram-plane"></span>
                                    <a href="auteurs.php?zone=auteurs&action=modifAuteur&id=<?php echo $sA->id_auteur; ?>"><span class="las la-eye"></span></a>
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
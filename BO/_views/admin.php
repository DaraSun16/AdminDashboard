<?php
include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if(isset($_SESSION['auth']) && $_SESSION['auth']['role_level'] > 99){

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/sidebar.php');

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/header.php');

$domaine = "Dashboard";
$sousDomaine = "Admin / Liste des utilisateurs";

include($_SERVER['DOCUMENT_ROOT'] . '/BO/_blocks/ariane.php');

if (isset($_GET['action']) && $_GET['action'] == "addUser") {

    $selectCivilites = $db->prepare('SELECT * FROM civilites');
    $selectCivilites->execute();

    $selectRoles = $db->prepare('SELECT * FROM roles');
    $selectRoles->execute();

    if(isset($_POST['addUser'])){
        $errors = array();

        if(empty($_POST['id_civilite'])){
            $errors['civilite'] = "Vous devez sélectionner une civilité";
        }

        if(empty($_POST['user_name']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_name'])){
            $errors['user_name'] = 'Le champs "Nom" n\'est pas valide';
        }

        if(empty($_POST['user_firstname']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_firstname'])){
            $errors['user_firstname'] = 'Le champs "Prénom" n\'est pas valide';
        }

        if(empty($_POST['user_firstname']) || !preg_match('/^[a-zA-Z -]+$/', $_POST['user_firstname'])){
            $errors['user_firstname'] = 'Le champs "Prénom" n\'est pas valide';
        }

        if(empty($_POST['user_mail']) || !filter_var($_POST['user_mail'], FILTER_VALIDATE_EMAIL)){
    $errors['user_mail'] = 'L\'"Email" n\'est pas valide';
        } else {
          $req = $db->prepare('SELECT * FROM users WHERE user_mail = ?');
          $req->execute([$_POST['user_mail']]);
          $email = $req->fetch();
          if($email){
              $errors['user_mail'] = "l'email est déjà présent dans la base de données.";
          }
        }

        if(empty($_POST['user_pwd']) || $_POST['user_pwd'] != $_POST['conf_pwd']){
            $errors['user_pwd'] = 'Les mots de passe" ne sont pas identiques.';
        }

        if(empty($_POST['id_role'])){
            $errors['role'] = "Vous devez sélectionner une rôle";
        }

        if(empty($errors)){
        $id_civilite = $_POST['id_civilite'];
        $name = $_POST['user_name'];
        $firstname = $_POST['user_firstname'];
        $mail = $_POST['user_mail'];
        $id_role = $_POST['id_role'];
        $pwd = $_POST['user_pwd'];
    
        $password = password_hash($pwd, PASSWORD_ARGON2I);
        
        $insert_user = $db->prepare('INSERT INTO users 
            (id_civilite, user_name, user_firstname, user_mail, id_role, user_pwd) 
            VALUES (?, ?, ?, ?, ?, ?)');

        $insert_user->execute([$id_civilite, $name, $firstname, $mail, $id_role, $password]);

        echo "<script language='javascript'>
        document.location.replace('admin.php?zone=admin')
        </script>";

    }
  }

    ?>

    <div class="flexrow">
      <?php
      if(!empty($errors)){
      foreach($errors as $error){
        ?>
        <li><?php echo $error;?></li>
        <?php
        }
      }
      ?>

        <div class="container">
            <div class="form-box register">
                <form method="POST">
                    <h1>Ajouter un utilisateur</h1>
                    <div class="input-box">
                        <select name="id_civilite">
                            <?php while($sC = $selectCivilites->fetch(PDO::FETCH_OBJ)){
                                ?>
                                    <option value="<?php echo $sC->id_civilite;?>"><?php echo $sC->civilite_titre;?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Nom" name="user_name" required />
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="Prénom" name="user_firstname" required />
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="Email" name="user_mail" required />
                        <i class="bx bxs-envelope"></i>
                    </div>
                    <div class="input-box">
                        <select name="id_role">
                            <?php while($sR = $selectRoles->fetch(PDO::FETCH_OBJ)){
                                ?>
                                    <option value="<?php echo $sR->id_role;?>"><?php echo $sR->role_name;?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Mot de Passe" name="user_pwd" id="pswrd" onkeyup="checkPassword(this.value)" required/>
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="Confirmer votre mot de Passe" name="conf_pwd" required />
                        <i class="bx bxs-lock-alt"></i>
                    </div>
                    <div class="validation">
                        <ul class="flexCol">
                            <li id="lower">Au moins une minuscule</li>
                            <li id="upper">Au moins une majuscule</li>
                            <li id="number">Au moins un chiffre</li>
                            <li id="special">Au moins un caractére spécial</li>
                            <li id="length">Au moins 8 caractéres</li>
                        </ul>
                    </div>
                    <input type="submit" class="btn" name="addUser" value="Enregistrer">
                    <p>or register with social platforms</p>
                    <div class="social-icons">
                        <a href="#"><i class="bx bxl-google"></i></a>
                        <a href="#"><i class="bx bxl-facebook"></i></a>
                        <a href="#"><i class="bx bxl-github"></i></a>
                        <a href="#"><i class="bx bxl-linkedin"></i></a>
                    </div>
                </form>
            </div>
        </div>
    </div>

                            

<?php

} else if (isset($_GET['action']) && $_GET['action'] == "user") {

    $id = $_GET['id'];

    var_dump($_FILES['image']);

    if(isset($_POST['add'])) {
        $img = $_FILES['image']['name'];
        $tmp_img = $_FILES['image']['tmp_name'];
        $error = $_FILES['image']['error'];
        $size = $_FILES['image']['size'];
        $type = $_FILES['image']['type'];

        $ext = explode('/', $type);
        $img_ext = end($ext);

        if($error == 0) {
            if($size < 5000000){
                if($img_ext === "jpg" || $img_ext === "jpeg" || $img_ext === "png"){

                    $insertImg = $db->prepare('UPDATE users SET
                    user_img = ?
                    WHERE id_user = ?
                    ');
                    $insertImg->execute([$img, $id]);

                    move_uploaded_file($tmp_img, $_SERVER['DOCUMENT_ROOT'].'/bo/_imgs/admin/'.$img);

                    echo "<script language='javascript'>
                    document.location.replace('admin.php.zone=admin')
                    <?script>";
                }
            }
        }
    }

    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image" accept=".jpeg, .png, .jpg">
        <input type="submit" value="Ajouter" name="add">
    </form>

    <?php

} else {

$selectAllUsers = $db->prepare('SELECT * FROM users
NATURAL JOIN roles
NATURAL JOIN civilites
');

$selectAllUsers->execute();

?>


<div class="records table_responsive">
    <div class="record_header spaceBetween alignCenter">
        <div class="add alignCenter">
            <span>Entries</span>
            <select name="#" id="#">
                <option value="#">ID</option>
            </select>
            <a class="alignCenter" href="admin.php?zone=admin&action=addUser">Ajouter un utilisateurs</a>
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
                    <th><span class="las la-sort uppercase"></span> UTILISATEURS</th>
                    <th><span class="las la-sort uppercase"></span> ROLE</th>
                    <th><span class="las la-sort uppercase"></span> CIVILITE</th>
                    <th><span class="las la-sort uppercase"></span> ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($sAu = $selectAllUsers->fetch(PDO::FETCH_OBJ)){
                    ?>

                <tr>
                    <td>#<?php echo $sAu->id_user;?></td>
                    <td>
                        <div class="client alignCenter">
                            <div class="profile_img_he bg_img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT']?>/BO/_imgs_admin/<?php echo $sAu->user_img;?>)"></div>
                            <div class="client-info">
                                <h4><?php echo ucwords($sAu->user_firstname);?> <?php echo $sAu->user_name;?></h4>
                                <small><?php echo $sAu->user_mail;?></small>
                            </div>
                        </div>
                    </td>
                    <td class="uppercase"><?php echo strtoupper($sAu->role_name);?></td>
                    <td ckass="capitalize"><?php echo $sAu->civilite_nom;?></td>
                    <td>
                        <div class="actions">
                            <a href="admin.php?zone=admin&action=user&id=<?php echo $sAu->id_user;?>"><span class="las la-telegram-plane"></span></a>
                            <span class="las la-eye"></span>
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

} else {
  header('Location: /BO/_views/login.php');
exit();
}
?>
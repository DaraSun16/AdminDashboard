<?php

include($_SERVER['DOCUMENT_ROOT'] . '/host.php');

if(isset($_POST['login'])){
  if(!empty($_POST['user_mail']) && !empty($_POST['user_pwd'])) {
    $mail = $_POST['user_mail'];
    $pwd = $_POST['user_pwd'];

    $req = $db->prepare('SELECT * FROM users
    NATURAL JOIN civilites
    NATURAL JOIN roles
    WHERE user_mail = ?');
    $req->execute([$mail]);
    $user = $req->fetch();

    if(password_verify($pwd, $user['user_pwd'])){
      $_SESSION['auth'] = $user;

    echo "<script language='javascript'>
        document.location.replace('../index.php?zone=dashboard')
        </script>";
    }
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/style/form.css">
  <title>Connectez vous</title>
</head>
<body>

<div class="log flexrow justifyCenter alignCenter">
  <div class="container login">
    <div class="form-box flexCol">

  <h1 class="textCenter">Connectez-vous</h1>

  <form method="post">

    <div class="input-box">
      <input type="email" placeholder="Email" name="user_mail" required />
      <i class="bx bxs-envelope"></i>
    </div>

    <div class="input-box">
      <input type="password" placeholder="Mot de Passe" name="user_pwd" id="pswrd" required/>
      <i class="bx bxs-lock-alt"></i>
    </div>

    <input type="submit" class="btn" name="login" value="Me connecter">
  </form>

    </div>
  </div>
</div>
  
</body>
</html>
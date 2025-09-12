<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php $_SERVER['DOCUMENT_ROOT']?>/style/style.css">
  <link rel="stylesheet" href="/style/form.css">
  <link rel= "stylesheet" href= "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" >
  <title>Admin Dashboard</title>
  <link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
</head>
<body>

  <input type="checkbox" id="menu-toggle">
  <div class="sidebar">
    <div class="side-header">
      <h3>M<span>odern</span></h3>
    </div>

    <div class="side-content">
      <div class="profile">
          <div class="profile-img bg-img" style="background-image: url(<?php $_SERVER['DOCUMENT_ROOT']?>/imgs/img_3.jpeg);"></div>
          <h4>David Green</h4>
          <small>Art Director</small>
      </div>

      <div class="side-menu">
        <ul>
          <li>
              <a href="" class="active">
                <span class="las la-home"></span>
                <small>Dashboard</small>
              </a>
          </li>
          <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/BO/_views/abonnes.php?zone=abonnes" class="<?php if(isset($_GET["zone"]) && $_GET["zone"] == "abonnes"){ echo "active";}?>">
                <span class="las la-user-alt"></span>
                <small>Abonnés</small>
              </a>
          </li>
          <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/BO/_views/auteurs.php?zone=auteurs" class="<?php if(isset($_GET["zone"]) && $_GET["zone"] == "auteurs"){ echo "active";}?>">
                <span class="las la-envelope"></span>
                <small>Auteurs</small>
              </a>
          </li>
          <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/BO/_views/livres.php?zone=livres" class="<?php if(isset($_GET["zone"]) && $_GET["zone"] == "livres"){ echo "active";}?>">
                <span class="las la-clipboard-list"></span>
                <small>Livres</small>
              </a>
          </li>
          <li>
              <a href="">
                <span class="las la-shopping-cart"></span>
                <small>Orders</small>
              </a>
          </li>
          <?php
          if(isset($_SESSION['auth']) && $_SESSION['auth']['role_level'] > 99){
          ?>
          <li>
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/BO/_views/admin.php?zone=admin" class="<?php if(isset($_GET["zone"]) && $_GET["zone"] == "admin"){ echo "active";}?>">
                <span class="las la-tasks"></span>
                <small>Admin</small>
              </a>
          </li>
          <?php
          }
          ?>

        </ul>
      </div>
    </div>
  </div> 
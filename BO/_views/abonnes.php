<?php
include($_SERVER['DOCUMENT_ROOT'].'/host.php');

$selectCivilities = $db->prepare('SELECT * FROM civilites');
$selectCivilities->execute();

$selectAbonnes = $db->prepare('SELECT * FROM abonnes');
$selectAbonnes->execute();

if(isset($_POST["add_abonne"])) {
  $id_civilite = $_POST['id_civilite'];
  $firstname = htmlspecialchars($_POST['abonne_prenom']);
  $lastname = htmlspecialchars($_POST['abonne_nom']);
  $date = $_POST ['abonne_date_naissance'];

  $insert_abonne = $db->prepare('INSERT INTO abonnes SET
  id_civilite = ?,
  abonne_prenom = ?,
  abonne_nom = ?,
  abonne_date_naissance = ?
  ');
  $insert_abonne->execute([$id_civilite, $firstname, $lastname, $date]);
}

include($_SERVER['DOCUMENT_ROOT'].'/BO/_blocks/sidebar.php');


include($_SERVER['DOCUMENT_ROOT'].'/BO/_blocks/header.php');

$domaine = "Dashboard";
$sousDomaine = "Abonnés / Liste";

include($_SERVER['DOCUMENT_ROOT'].'/BO/_blocks/ariane.php');

?>

<form action="" method="post">
  <select name="id_civilite">
    <?php
     while($sC = $selectCivilities->fetch(PDO::FETCH_OBJ)) {
    ?>
    <option value="<?php echo $sC->id_civilite;?>"><?php echo $sC->civilite_titre;?></option>
     <?php 
    }
    ?>
  </select>
  <div>
    <input type="text" name="abonne_prenom">
  </div>
  <div>
    <input type="text" name="abonne_nom">
  </div>
  <div>
    <input type="date" name="abonne_date_naissance">
  </div>
  <div>
    <input type="submit" name="add_abonne" value="Enr">
  </div>

</form>

<div class="records table-responsive">
  <div class="record-header">
    <div class="add">
      <span>Entries</span>
      <select name="" id="">
        <option value="">ID</option>
      </select>
      <button>Add record</button>
    </div>

    <div class="browse">
      <input type="search" placeholder="Search" class="record-search">
      <select name="" id="">
        <option value="">Status</option>
      </select>
    </div>
  </div>

  <div>
    <table width="100%">
      <thead>
        <tr>
          <th>#</th>
          <th><span class="las la-sort"></span> ABONNES</th>
          <th><span class="las la-sort"></span> DATE DE NAISSANCE</th>
          <th><span class="las la-sort"></span> ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php
          while($sA = $selectAbonnes->fetch(PDO::FETCH_OBJ)) {
        ?>
        <tr>
          <td>#<?php echo $sA->id_abonne;?></td>
          <td>
            <div class="client">
              <div class="client-img bg-img" style="background-image: url(imgs/img_3.jpeg)"></div>
              <div class="client-info">
                <h4><?php echo $sA->abonne_prenom;?> <?php echo $sA->abonne_nom;?></h4>
              </div>
            </div>
          </td>

          <td>
            <?php echo $sA->abonne_date_naissance;?>
          </td>

          <td>
            <div class="actions">
              <span class="lab la-telegram-plane"></span>
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

include($_SERVER['DOCUMENT_ROOT'].'/BO/_blocks/footer.php');

?>
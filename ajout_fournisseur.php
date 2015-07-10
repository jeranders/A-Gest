<?php include 'bdd.php';
session_start(); 
include 'function.php';

if (isset($_POST['send'])) {

  /* VARIABLE AJOUT FOURNISSEUR DEBUT ******************************/
  $nom_fournisseur = htmlentities($_POST['nom_fournisseur']);
  $ref = htmlentities($_POST['ref']);
  $rue = htmlentities($_POST['rue']); 
  $code_postal = (int)$_POST['code_postal']; 
  $ville = htmlentities($_POST['ville']); 
  $pays = (int)$_POST['pays']; 
  $telephone = htmlentities($_POST['telephone']); 
  $fax = htmlentities($_POST['fax']); 
  $email = htmlentities($_POST['email']); 
  $site = htmlentities($_POST['site']);
  $logo = $_FILES['logo'];
  $commentaire = htmlentities($_POST['commentaire']);
  $livraison = (int)$_POST['livraison'];
  $id_membre = (int)$_SESSION['id_membre'];

  /* VARIABLE AJOUT FOURNISSEUR FIN ********************************/

  /*Requete qui recherche dans la BDD si un fournisseur est déjà utilisé*/

  if ($nom_fournisseur != "") {



    if(filter_var($email, FILTER_VALIDATE_EMAIL)){

      $count = $bdd->prepare('SELECT COUNT(*) FROM fournisseurs,membres WHERE f_nom = :nom_fournisseur AND fournisseurs.id_membre = membres.id_membre AND fournisseurs.id_membre = :id_membre');
      $count->bindValue('nom_fournisseur', $nom_fournisseur, PDO::PARAM_STR);
      $count->bindValue('id_membre', $id_membre, PDO::PARAM_INT);
      $count->execute();

      if ($count->fetchColumn()) {
        /*Si le nom du fournisseur entré est déjà utilisé*/
        setFlash('Attention le nom du fournisseur est déjà utilisé. Si vous avez plusieurs fournisseurs avec le même nom, ajouter un numéro par exemple.', 'danger');
        $erreur_nom_fournisseur = '<p class="text-red"><i class="fa fa-fw fa-warning"></i> Erreur, le nom du fournisseur est déjà utilisé.</p>';
      } else {

       if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0){

        // Testons si le fichier n'est pas trop gros
        if ($_FILES['logo']['size'] <= 1000000){
                // Testons si l'extension est autorisée
          $infosfichier = pathinfo($_FILES['logo']['name']);
          $extension_upload = $infosfichier['extension'];
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
          if (in_array($extension_upload, $extensions_autorisees)) {



            $name_file = 'dist/img/fournisseurs/' . str_shuffle('Jesuilelogodesfournisseurs') . rand(5,999) . cleanCaracteresSpeciaux($_FILES['logo']['name']); 
            $name_logo = str_replace(' ', '', $name_file);
            move_uploaded_file($_FILES['logo']['tmp_name'], 'dist/img/fournisseurs/' . basename($name_logo));

            $req = $bdd->prepare('INSERT INTO fournisseurs(f_nom, f_ref, f_rue, f_code_postal, f_ville, f_pays, f_tel , f_fax, f_email, f_site, f_commentaire, f_logo, id_membre, f_date_ajout, f_livraison) 
              VALUES(:nom_fournisseur, :ref, :rue, :code_postal, :ville, :pays, :telephone, :fax, :email, :site, :commentaire, :logo, :id_membre, NOW(), :livraison)');
            $req->execute(array(
              'nom_fournisseur' => $nom_fournisseur,
              'ref'             => $ref,
              'rue'             => $rue,
              'code_postal'     => $code_postal,
              'ville'           => $ville,
              'pays'            => $pays,
              'telephone'       => $telephone,
              'fax'             => $fax,
              'email'           => $email,
              'site'            => $site,
              'commentaire'     => $commentaire,
              'logo'            => $name_logo,
              'livraison'       => $livraison,
              'id_membre'       => $id_membre
              ));

            setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été enregistré', 'success');
            header('Location:ajout_fournisseur.php');
            die();

          }else{
            setFlash('Mauvais format de fichier. Le fichier doit être en .jpg, .jpeg, .png, .gif', 'danger');      
          }
        }
      }else{
       $req = $bdd->prepare('INSERT INTO fournisseurs(f_nom, f_ref, f_rue, f_code_postal, f_ville, f_pays, f_tel , f_fax, f_email, f_site, f_commentaire, id_membre, f_date_ajout, f_livraison) 
        VALUES(:nom_fournisseur, :ref, :rue, :code_postal, :ville, :pays, :telephone, :fax, :email, :site, :commentaire, :id_membre,NOW(), :livraison)');
       $req->execute(array(
        'nom_fournisseur' => $nom_fournisseur,
        'ref'             => $ref,
        'rue'             => $rue,
        'code_postal'     => $code_postal,
        'ville'           => $ville,
        'pays'            => $pays,
        'telephone'       => $telephone,
        'fax'             => $fax,
        'email'           => $email,
        'site'            => $site,
        'commentaire'     => $commentaire,
        'livraison'       => $livraison,
        'id_membre'       => $id_membre
        ));

       setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été enregistré', 'success');
       header('Location:ajout_fournisseur.php');
       die();
     }
   }
 }else{
  setFlash('Attention format email invalide ou vide. Mettre null@null.fr par exemple si vous n\'avez aucun email à entrer.', 'danger');
}
}else{
  setFlash('Attention le nom du fournisseur est vide', 'danger');
}
}
?>

<?php include 'header_top.php'; ?>

<script type="text/javascript">

function generatePassword() {
  var length = 8,
  charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
  retVal = "";
  for (var i = 0, n = charset.length; i < length; ++i) {
    retVal += charset.charAt(Math.floor(Math.random() * n));
  }
    //return retVal;

    document.getElementById("NUM_DECHARGE").value = retVal;
  }

  </script>

  <title>Ajout d'un fournisseur | Easy Gestion</title>
  <meta content='' name='viewport'>
  <?php $page = 'Ajout d\'un fournisseur'; ?>
  <?php include 'header_bottom.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Ajout d'un fournisseur
     </h1>
     <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li class="active">Ajout d'un fournisseur</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <?php //include 'debug.php'; debug($_FILES); ?>
    <?php echo flash(); ?>

    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-toggle-up"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Nombre(s) de fournisseurs</span>
            <span class="info-box-number">
              <?php 
              $id_membre = (int)$_SESSION['id_membre'];
              $nb = $bdd->prepare('SELECT COUNT(*) AS nb_f FROM fournisseurs WHERE id_membre = :id_membre');
              $nb->execute(array('id_membre' => $id_membre));
              $nb_f = $nb->fetch();
              echo (int)$nb_f['nb_f'];
              ?>            
            </span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->
      <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
          <span class="info-box-icon bg-green"><i class="fa fa-info"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Dernier fournisseur</span>
            <span class="info-box-number">
              <?php 
              $id_membre = (int)$_SESSION['id_membre'];
              $nom = $bdd->prepare('SELECT * FROM fournisseurs WHERE id_membre = :id_membre ORDER BY f_date_ajout DESC LIMIT 0, 1');
              $nom->execute(array('id_membre' => $id_membre));
              $f_nom = $nom->fetch();
              if ($f_nom == "") {
                echo "Aucun";
              }else{
                ?>
                <a href="fournisseur.php?p=<?php echo (int)$f_nom['id_fournisseur']; ?>"><?php echo html_entity_decode($f_nom['f_nom']); ?></a></td>
                <?php
              }

              ?>     
            </span>
          </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
      </div><!-- /.col -->    
    </div>

    <!-- Small boxes (Stat box) -->
    <div class="row">
      <!-- left column -->
      <div class="col-md-6 col-md-offset-3">
        <!-- general form elements -->
        <div class="box box-primary box-solid">
          <div class="box-header">
            <h3 class="box-title">Informations du fournisseur</h3>
          </div><!-- /.box-header -->
          <!-- form start -->
          <form role="form" action="" method="post" enctype="multipart/form-data">

            <div class="box-body">
              <div class="form-group">
                <label for="nom_fournisseur">Nom du fournisseur</label>

                <?php if (isset($_POST['nom_fournisseur'])) {
                  ?>
                  <input type="text" class="form-control" id="nom_fournisseur" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php if (isset($_POST['nom_fournisseur'])) { echo $_POST['nom_fournisseur']; } ?>">
                  <?php
                }else {
                  ?>
                  <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php if (isset($_POST['nom_fournisseur'])) { echo $_POST['nom_fournisseur']; } ?>" required>
                  <?php
                } ?>
              </div>      


              <!-- REF -->
              <div class="form-group">
                <label for="nom_fournisseur">Référence</label>
                <div class="input-group margin">
                  <div class="input-group-btn">
                    <button type="button" class="btn btn-danger" value="Ajouter" onclick="generatePassword()">Aléatoire</button>
                  </div><!-- /btn-group -->
                  <input type="text" class="form-control" id="NUM_DECHARGE" name="ref" value="<?php if (isset($_POST['ref'])) { echo $_POST['ref']; } ?>">
                </div>
              </div>
            

            <div class="form-group">
              <label for="adresse_fournisseur">Adresse</label>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-5">
                    <input type="text" class="form-control" name="rue" placeholder="Rue" value="<?php if (isset($_POST['rue'])) { echo $_POST['rue']; } ?>">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" class="form-control" name="code_postal" placeholder="Code Postal" value="<?php if (isset($_POST['code_postal'])) { echo $_POST['code_postal']; } ?>">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" class="form-control" name="ville" placeholder="Ville" value="<?php if (isset($_POST['ville'])) { echo $_POST['ville']; } ?>">
                  </div>
                </div>
              </div><!-- /.box-body -->
            </div>

            <div class="form-group">
              <label for="pays">Pays</label>
              <div class="box-body">
                <div class="row">  
                  <select class="form-control" name="pays">
                    <option select="selected" value="75">France</option>
                    <?php $pays = $bdd->query('SELECT * FROM pays ORDER BY nom_fr_fr');
                    while ($donnees = $pays->fetch()) {
                      ?>
                      <option value="<?php echo $donnees['id']; ?>"><?php echo $donnees['nom_fr_fr']; ?></option>
                      <?php
                    }
                    $pays->closeCursor();
                    ?>
                  </select>
                </div>                  
              </div>
            </div>

            <!-- phone -->
            <div class="form-group">
              <label>Téléphone</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </div>
                <input type="text" class="form-control" name="telephone" placeholder="0102030405" value="<?php if (isset($_POST['telephone'])) { echo $_POST['telephone']; } ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Fax</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-fax"></i>
                </div>
                <input type="text" class="form-control" name="fax" placeholder="0102030406" value="<?php if (isset($_POST['fax'])) { echo $_POST['fax']; } ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </div>
                <input type="email" class="form-control" name="email" placeholder="email@email.com" value="<?php if (isset($_POST['email'])) { echo $_POST['email']; } ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Site</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-wifi"></i>
                </div>
                <input type="text" class="form-control" name="site" placeholder="http://site.com" value="<?php if (isset($_POST['site'])) { echo $_POST['site']; } ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Commentaire</label>
              <textarea class="form-control" rows="3" placeholder="Entrer ..." name="commentaire"></textarea>
            </div>
            <div class="form-group">
              <label for="file">Ajouter un logo</label>
              <input type="file" id="file" name="logo" class="btn-default">
              <p class="help-block">La taille du fichier ne dois pas dépasser 500ko</p>
            </div> 

            <div class="form-group">
              <label for="adresse_fournisseur">Délai moyen de livraison en jours</label>
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-3">
                    <input type="text" class="form-control" name="livraison" placeholder="Délai" value="<?php if (isset($_POST['livraison'])) { echo $_POST['livraison']; } ?>">
                  </div>                  
                </div>
              </div><!-- /.box-body -->
            </div>

          </div><!-- /.box-body -->

          <div class="box-footer">
            <button type="submit" name="send" class="btn btn-primary">Ajouter</button>
          </div>
        </form>
      </div><!-- /.box -->

    </div><!--/.col -->
    <!-- right column -->

  </div>   <!-- /.row -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php echo include 'footer.php'; ?>
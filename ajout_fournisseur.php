<?php include 'header_top.php'; ?>

<?php 

if (isset($_POST['send'])) {

  /* VARIABLE AJOUT FOURNISSEUR DEBUT ******************************/
  $nom_fournisseur= htmlentities($_POST['nom_fournisseur']); 
  $rue= htmlentities($_POST['rue']); 
  $code_postal= (int)$_POST['code_postal']; 
  $ville= htmlentities($_POST['ville']); 
  $telephone= htmlentities($_POST['telephone']); 
  $fax= htmlentities($_POST['fax']); 
  $email= htmlentities($_POST['email']); 
  $site= htmlentities($_POST['site']);
  $commentaire= htmlentities($_POST['commentaire']);
  $id_membre = (int)$_SESSION['id_membre'];
  /* VARIABLE AJOUT FOURNISSEUR FIN ********************************/

  /*Requete qui recherche dans la BDD si un fournisseur est déjà utilisé*/

  $count = $bdd->prepare('SELECT COUNT(*) FROM fournisseurs,membres WHERE f_nom = :nom_fournisseur AND fournisseurs.id_membre = membres.id_membre AND fournisseurs.id_membre = :id_membre');
  $count->bindValue('nom_fournisseur', $nom_fournisseur, PDO::PARAM_STR);
  $count->bindValue('id_membre', $id_membre, PDO::PARAM_INT);
  $count->execute();

  if ($count->fetchColumn()) {
    /*Si le nom du fournisseur entré est déjà utilisé*/
    setFlash('Attention le nom du fournisseur est déjà utilisé. Si vous avez plusieurs fournisseurs avec le même nom, ajouter un numéro par exemple.', 'danger');
    $erreur_nom_fournisseur = '<p class="text-red"><i class="fa fa-fw fa-warning"></i> Erreur, le nom du fournisseur est déjà utilisé.</p>';
  } else {
    /*Si tout est bon, insertion du fournisseur*/
    $req = $bdd->prepare('INSERT INTO fournisseurs(f_nom, f_rue, f_code_postal, f_ville, f_tel , f_fax, f_email, f_site, f_commentaire, id_membre) 
      VALUES(:nom_fournisseur, :rue, :code_postal, :ville, :telephone, :fax, :email, :site, :commentaire, :id_membre)');
    $req->execute(array(
      'nom_fournisseur' => $nom_fournisseur,
      'rue'             => $rue,
      'code_postal'     => $code_postal,
      'ville'           => $ville,
      'telephone'       => $telephone,
      'fax'             => $fax,
      'email'           => $email,
      'site'            => $site,
      'commentaire'     => $commentaire,
      'id_membre'       => $id_membre
      ));

    setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été enregistré', 'success');
    header('Location:ajout_fournisseur.php');
    die();
  }
}
?>

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

  <?php //include 'debug.php'; ?>
  <?php echo flash(); ?>

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
        <form role="form" action="" method="post">

          <div class="box-body">
            <div class="form-group">
              <label for="nom_fournisseur">Nom du fournisseur</label>

              <?php if (isset($_POST['nom_fournisseur'])) {
                ?>
                <input type="text" class="form-control errorInput" id="nom_fournisseur" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php if (isset($_POST['nom_fournisseur'])) { echo $_POST['nom_fournisseur']; } ?>"> <?php if (isset($erreur_nom_fournisseur)) { echo $erreur_nom_fournisseur; } ?>
                <?php
              }else {
                ?>
                <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php if (isset($_POST['nom_fournisseur'])) { echo $_POST['nom_fournisseur']; } ?>">
                <?php
              } ?>
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
              <label for="exampleInputFile">Ajouter un logo</label>
              <input type="file" id="exampleInputFile">
              <p class="help-block">Example block-level help text here.</p>
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="active"> Désactiver le fournisseur
              </label>
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
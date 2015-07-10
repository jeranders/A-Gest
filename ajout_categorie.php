<?php include 'bdd.php';
session_start(); 
include 'function.php';

?>

<?php include 'header_top.php'; ?>

<title>Ajout d'une catégorie | Easy Gestion</title>
<meta content='' name='viewport'>
<?php $page = 'Ajout d\'une catégorie'; ?>
<?php include 'header_bottom.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
     Ajout d'une catégorie
   </h1>
   <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
    <li class="active">Ajout d'une catégorie</li>
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
          <span class="info-box-text">Nombre(s) de catégorie</span>
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
          <span class="info-box-text">Derniere catégorie</span>
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
          <h3 class="box-title">Informations de la catégorie</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="" method="post" enctype="multipart/form-data">

          <div class="box-body">
            <div class="form-group">
              <label for="nom_fournisseur">Nom de la catégorie</label>

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


            
            <!-- phone -->
            

            <div class="form-group">
              <label>Description</label>
              <textarea class="form-control" rows="3" placeholder="Entrer ..." name="commentaire"></textarea>
            </div>
            <div class="form-group">
              <label for="file">Ajouter un logo</label>
              <input type="file" id="file" name="logo" class="btn-default">
              <p class="help-block">La taille du fichier ne dois pas dépasser 500ko</p>
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
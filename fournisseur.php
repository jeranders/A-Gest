<?php include 'header_top.php'; ?>
<?php // Récupération des commentaires

$req = $bdd->prepare('SELECT * FROM fournisseurs, pays WHERE fournisseurs.f_pays = pays.id AND id_membre = :id_membre AND id_fournisseur = :get');
$req->bindValue(':id_membre', $_SESSION['id_membre'], PDO::PARAM_INT);
$req->bindValue(':get', (int)$_GET['p'], PDO::PARAM_INT);
$req->execute();
$donnees = $req->fetch();
if (isset($SESSION['id_membre']) != $donnees['id_membre'] AND isset($_GET['p']) == $_GET['p']) {
}else{
  header('Location:index.php');
  die();
}
?>
<title><?php echo htmlspecialchars($donnees['f_nom']); ?> | Easy Gestion</title>
<meta content='' name='viewport'>
<?php include 'header_bottom.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profil de <?php echo htmlspecialchars($donnees['f_nom']); ?>
      <small>Accueil</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li class="active">Liste des fournisseurs</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">

      <div class="col-md-2">
        <!-- general form elements -->
        <div class="box box-primary box-solid i-center">
          <div class="box-header">
            <h3 class="box-title"><?php echo htmlspecialchars($donnees['f_nom']); ?></h3>
          </div><!-- /.box-header -->
          <img src="dist/img/Gollum.jpg" class="img-circle" alt="User Image" width="128px" height="128px"/>
          <div class="m-10">
            <button type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Voir" "><i class="fa fa-align-left"></i></button>
            <button type="button" class="btn btn-warning btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Modifier" "><i class="fa fa-align-left"></i></button>
            <button type="button" class="btn btn-danger btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Supprimer" "><i class="fa fa-align-left"></i></button>
            <button type="button" class="btn btn-success btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Activer" "><i class="fa fa-align-left"></i></button>
          </div>

          <div>
            <div class="box-body">
              <dl>
                <dt>Adresse</dt>
                <dd><?php echo htmlspecialchars($donnees['f_rue']) . ' ' . htmlspecialchars($donnees['f_code_postal']) . ' ' . htmlspecialchars($donnees['f_ville']); ?></dd>
                <dt>Pays</dt>
                
                <dd><img data-placement="top" data-toggle="tooltip" href="#" data-original-title="<?php echo htmlspecialchars($donnees['nom_fr_fr']); ?>" src="dist/img/pays/<?php echo htmlspecialchars($donnees['alpha2']); ?>.png"></dd>
                
                <dt>Email</dt>
                <dd><?php
                if ($donnees['f_email'] == "") {
                  echo "Aucun";
                }else{
                  echo $donnees['f_email']; 
                }?></dd>
                <dt>Téléphone</dt>
                <dd>0102030405</dd> 
                <dt>Fax</dt>
                <dd>0102030405</dd>
                <dt>Site</dt>
                <dd>http://site.fr</dd>
              </dl>
            </div>

          </div>
        </div><!-- /.box -->
      </div><!--/.col -->



      <div class="col-xs-10">        

        <div class="box">
          <div class="box-header bg-green">
            <h3 class="box-title">Commandes</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table  class="table table-bordered table-striped example2">
              <thead>
                <tr>
                  <th>nCom</th>
                  <th>Nom</th>
                  <th>Fax</th>
                  <th>Email</th>
                  <th>Site</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                
              </tbody>

            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->





    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->


<?php echo include 'footer.php'; ?>
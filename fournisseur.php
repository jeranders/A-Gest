<?php include 'header_top.php'; ?>
<?php // Récupération des commentaires

$req = $bdd->prepare('SELECT *, DATE_FORMAT(f_date_ajout, \'%d/%m/%Y\') AS f_date_ajout FROM fournisseurs, pays WHERE fournisseurs.f_pays = pays.id AND id_membre = :id_membre AND id_fournisseur = :get');
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




<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="edition" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edition de <?php echo html_entity_decode($donnees['f_nom']); ?></h4>
      </div>
      <div class="modal-body">

        <form action="" method="post">
          <div class="box-body">
            <div class="form-group">
              <label for="nom_fournisseur">Nom du fournisseur</label>
              <input type="text" class="form-control" id="nom_fournisseur" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php echo $donnees['f_nom']; ?>">
            </div> 

            <div class="form-group">
              <label for="adresse_fournisseur">Adresse</label>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-5">
                    <input type="text" class="form-control" name="rue" placeholder="Rue" value="<?php echo $donnees['f_rue']; ?>">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" class="form-control" name="code_postal" placeholder="Code Postal" value="<?php echo $donnees['f_code_postal']; ?>">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" class="form-control" name="ville" placeholder="Ville" value="<?php echo $donnees['f_ville']; ?>">
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
                <input type="text" class="form-control" name="telephone" placeholder="0102030405" value="<?php echo $donnees['f_tel']; ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Fax</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-fax"></i>
                </div>
                <input type="text" class="form-control" name="fax" placeholder="0102030406" value="<?php echo $donnees['f_fax']; ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </div>
                <input type="email" class="form-control" name="email" placeholder="email@email.com" value="<?php echo $donnees['f_email']; ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Site</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-wifi"></i>
                </div>
                <input type="text" class="form-control" name="site" placeholder="http://site.com" value="<?php echo $donnees['f_site']; ?>"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Commentaire</label>
              <textarea class="form-control" rows="3" placeholder="Entrer ..." name="commentaire"><?php echo $donnees['f_commentaire']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="file">Logo</label>
              <input type="file" id="file" name="logo" class="btn-default">
              <p class="help-block">La taille du fichier ne dois pas dépasser 500ko</p>
            </div> 

            <div class="form-group">
              <label for="adresse_fournisseur">Délai moyen de livraison en jours</label>
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-3">
                    <input type="text" class="form-control" name="livraison" placeholder="Délai" value="<?php echo $donnees['f_livraison']; ?>">
                  </div>                  
                </div>
              </div><!-- /.box-body -->
            </div>
          </div>        

        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
        <button type="button" class="btn btn-primary">Modifier</button>
      </div>
    </div>
  </div>
</div>
<!-- Modal END -->


<title><?php echo html_entity_decode($donnees['f_nom']); ?> | Easy Gestion</title>
<meta content='' name='viewport'>
<?php include 'header_bottom.php'; ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Profil de <?php echo html_entity_decode($donnees['f_nom']); ?>
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
          <div class="box-header mb-10">
            <h3 class="box-title"><?php echo html_entity_decode($donnees['f_nom']); ?></h3>
          </div><!-- /.box-header -->
          <img src="<?php echo $donnees['f_logo']; ?>" class="img-circle" alt="User Image" width="128px" height="128px"/>
          <div class="m-10">
            <button type="button" class="btn btn-flat bg-maroon btn-sm mb-10" data-toggle="modal" data-target="#edition">
              Edition
            </button> <br>
            <button type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Ajouter le <?php echo $donnees['f_date_ajout']; ?>" "><i class="fa fa-calendar"></i></button>
            <button type="button" class="btn btn-warning btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Taux de retard : 2%" "><i class="fa fa-star"></i></button>
            <button type="button" class="btn bg-purple btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Jours de livraison : <?php echo $donnees['f_livraison']; ?>" "><i class="fa fa-truck"></i></button>
            <button type="button" class="btn btn-danger btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Désactiver le fournisseur" "><i class="fa fa-ban"></i></button>
            
          </div>

          <div>
            <div class="box-body">
              <dl>
                <dt>Adresse</dt>
                <dd>
                  <?php
                  if ($donnees['f_ville'] == "") {
                    echo "Aucune";
                  }else{
                    echo html_entity_decode($donnees['f_rue']) . ' ' . htmlspecialchars($donnees['f_code_postal']) . ' ' . html_entity_decode($donnees['f_ville']);
                  }?>
                </dd>
                <dt>Pays</dt>
                
                <dd><img data-placement="top" data-toggle="tooltip" href="#" data-original-title="<?php echo html_entity_decode($donnees['nom_fr_fr']); ?>" src="dist/img/pays/<?php echo htmlspecialchars($donnees['alpha2']); ?>.png"></dd>
                
                <dt>Email</dt>
                <dd><?php
                if ($donnees['f_email'] == "") {
                  echo "Aucun";
                }else{
                  echo $donnees['f_email']; 
                }?></dd>
                <dt>Téléphone</dt>
                <dd><?php
                if ($donnees['f_tel'] == "") {
                  echo "Aucun";
                }else{
                  echo $donnees['f_tel']; 
                }?></dd> 
                <dt>Fax</dt>
                <dd><?php
                if ($donnees['f_fax'] == "") {
                  echo "Aucun";
                }else{
                  echo $donnees['f_fax']; 
                }?></dd>
                <dt>Site</dt>
                <dd><?php
                if ($donnees['f_site'] == "") {
                  echo "Aucun";
                }else{
                  echo  '<a href="' . htmlentities($donnees['f_site']) . ' data-placement="top" data-toggle="tooltip" data-original-title="' . htmlentities($donnees['f_site']) . '" ">Visiter</a>'; 
                }?></dd>
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
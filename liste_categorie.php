<?php include 'bdd.php';
session_start();
include 'function.php';

if (isset($_POST['modif'])) {
  /* VARIABLE MODIF FOURNISSEUR DEBUT ******************************/
  $nom_categorie  = htmlentities($_POST['nom_categorie']);
  $description    = htmlentities($_POST['description']);
  $ref            = htmlentities($_POST['ref']); 
  $active         = (int)1;
  $id_membre      = (int)$_SESSION['id_membre'];

  /* VARIABLE MODIF FOURNISSEUR FIN ********************************/
  if ($nom_categorie != "") {
   $count = $bdd->prepare('SELECT COUNT(*) FROM categories, membres WHERE c_nom = :nom_categorie AND categories.id_membre = membres.id_membre AND categories.id_membre = :id_membre');
   $count->bindValue('nom_categorie', $nom_categorie, PDO::PARAM_STR);
   $count->bindValue('id_membre', $id_membre, PDO::PARAM_INT);
   $count->execute();

   if ($count->fetchColumn()) {
    /*Si le nom du fournisseur entré est déjà utilisé*/
    setFlash('Attention le nom de la catégorie est déjà utilisé. Si vous avez plusieurs catégorie avec le même nom, ajouter un numéro par exemple.', 'danger');
  } else {

   $req = $bdd->prepare('UPDATE categories SET c_nom = :nom_categorie, c_description = :description WHERE id_categorie = :id_categorie');
   $req->execute(array(
    'nom_categorie' => $nom_categorie,

    'description'   => $description,
    'id_membre'     => $id_membre,
    'id_categorie'  => $id_categorie
    ));

   setFlash('La categorie' . $nom_categorie .' a bien été modifié', 'success');
   header('Location:liste_categorie.php');
   die();

 }
}else{
  setFlash('Attention le nom de la categorie est vide', 'danger');
}

}

  /*
DESACTIVATION DU FOURNISSEUR
*/

if(isset($_GET['desactiver'])){
  checkCsrf();
  $c_active = (int)0;
  $id_categorie = (int)$_GET['desactiver'];;
  $req = $bdd->prepare('UPDATE categories SET c_active = :c_active WHERE id_categorie = :get');
  $req->execute(array(
    'c_active'   => $c_active,
    'get'        => $id_categorie
    ));
  setFlash('La categorie ' . $nom_categorie .' a bien été désactiver.', 'success');
  header('Location:liste_categorie.php');
  die();
}

/*
FIN DESACTIVATION DU FOURNISSEUR
*/

/*
ACTIVATION DU FOURNISSEUR
*/

if(isset($_GET['active'])){
  checkCsrf();
  $c_active = (int)1;
  $id_categorie = (int)$_GET['active'];;
  $req = $bdd->prepare('UPDATE categories SET c_active = :c_active WHERE id_categorie = :get');
  $req->execute(array(
    'c_active'   => $c_active,
    'get'        => $id_categorie
    ));
  setFlash('La categorie ' . $nom_categorie .' a bien été activé.', 'success');
  header('Location:liste_categorie.php');
  die();
}


include 'header_top.php'; ?>

<title>Liste des categories | Easy Gestion</title>
<meta content='' name='viewport'>
<?php include 'header_bottom.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Liste des categories
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li class="active">Liste des categories</li>
    </ol>
  </section>

  <section class="content"> 

    <?php echo flash(); ?>
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header bg-green">
            <h3 class="box-title">Categories</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
            <table  class="table table-bordered table-striped example1">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Référence</th>
                  <th>Description</th>                  
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php
                $id_membre = (int)$_SESSION['id_membre'];
                $req = $bdd->prepare('SELECT * FROM categories WHERE id_membre = :id_membre');
                $req->execute(array('id_membre' => $id_membre));
                while ($donnees = $req->fetch()) {
                  ?>

                  <!--   DEBUT MODAL   -------------------------------------                    -->

                  <div class="modal fade" id="<?php echo $donnees['id_categorie']; ?>">

                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h3 class="modal-title">Edition rapide de <?php echo $donnees['c_nom']; ?></h3>
                        </div>

                        <div class="modal-body">

                          <form role="form" action="" method="post">
                            <input type="hidden" name="id_categorie" value="<?php echo $donnees['id_categorie']; ?>">
                            <div class="box-body">

                              <div class="form-group">
                                <label for="nom_categorie">Nom de la catégorie</label>

                                <?php if (isset($_POST['nom_categorie'])) {
                                  ?>
                                  <input type="text" class="form-control" id="nom_categorie" placeholder="Entrer un nom" name="nom_categorie" value="<?php if (isset($_POST['nom_categorie'])) { echo $_POST['nom_categorie']; } ?>">
                                  <?php
                                }else {
                                  ?>
                                  <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_categorie" value="<?php echo $donnees['c_nom']; ?>" required>
                                  <?php
                                } ?>
                              </div>


                              <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description"><?php echo $donnees['c_description']; ?></textarea>
                              </div>


                            </div><!-- /.box-body -->

                            <div class="modal-footer">
                              <a href="" class="btn btn-default" data-dismiss="modal">Fermer</a>
                              <button type="submit" name="modif" class="btn btn-primary">Modifier</button>
                            </div>
                          </form>

                        </div>

                      </div>
                    </div>
                  </div>


                  <!--   FIN MODAL   -------------------------------------                    -->
                  <tr>
                    <td><a href="categorie.php?p=<?php echo $donnees['id_categorie']; ?>"><?php echo html_entity_decode($donnees['c_nom']); ?></a></td>
                    <td>
                      <?php
                      if ($donnees['c_ref'] == "") {
                        echo "Aucune";
                      }else{
                        echo 'C-' . $donnees['c_ref'];
                      }?>
                    </td>

                    <td>
                      <?php
                      if ($donnees['c_description'] == "") {
                        echo "Aucune";
                      }else{
                        echo $donnees['c_description'];
                      }?>
                    </td>

                    <td>
                      <a href="categorie.php?p=<?php echo $donnees['id_categorie']; ?>" type="button" class="btn btn-info btn-flat ">Voir</a>
                      <button type="button" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#<?php echo $donnees['id_categorie']; ?>">Modifier</button>

                      <?php if ($donnees['c_active'] == 1) {
                        ?>
                        <a href="?desactiver=<?php echo $donnees['id_categorie']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour désactiver');" type="button" class="btn btn-danger btn-flat ">Désactiver</a>
                        <?php
                      }else{
                        ?>
                        <a href="?active=<?php echo $donnees['id_categorie']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour activer');" type="button" class="btn btn-success btn-flat">Activer</a>
                        <?php
                      }

                      ?>
                    </td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->
    </div><!-- /.row -->
  </section><!-- /.content -->

</div><!-- /.content-wrapper -->

<?php echo include 'footer.php'; ?>
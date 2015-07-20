<?php include 'bdd.php';
session_start();
include 'function.php';

/*
DESACTIVATION DU FOURNISSEUR
*/

if(isset($_GET['desactiver'])){
  checkCsrf();

  $f_active = (int)0;
  $id_fournisseur = (int)$_GET['desactiver'];;

  $req = $bdd->prepare('UPDATE fournisseurs SET f_active = :f_active WHERE id_fournisseur = :get');

  $req->execute(array(
    'f_active'   => $f_active,
    'get'        => $id_fournisseur
  ));
  setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été désactiver. Cliquez sur <i class="fa fa-check"></i> pour le réactiver.', 'success');
  header('Location:list_fournisseur.php');
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

  $f_active = (int)1;
  $id_fournisseur = (int)$_GET['active'];;

  $req = $bdd->prepare('UPDATE fournisseurs SET f_active = :f_active WHERE id_fournisseur = :get');

  $req->execute(array(
    'f_active'   => $f_active,
    'get'        => $id_fournisseur
  ));
  setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été activé.  Cliquez sur <i class="fa fa-ban"></i> pour le désactiver.', 'success');
  header('Location:list_fournisseur.php');
  die();
}


if (isset($_POST['modif'])) {
  /* VARIABLE MODIF FOURNISSEUR DEBUT ******************************/
  $nom_fournisseur = htmlentities($_POST['nom_fournisseur']);

  $rue = htmlentities($_POST['rue']);
  $code_postal = (int)$_POST['code_postal'];
  $ville = htmlentities($_POST['ville']);
  $telephone = htmlentities($_POST['telephone']);
  $fax = htmlentities($_POST['fax']);
  $email = htmlentities($_POST['email']);
  $site = htmlentities($_POST['site']);
  $commentaire = htmlentities($_POST['commentaire']);
  $livraison = (int)$_POST['livraison'];
  $id_membre = (int)$_SESSION['id_membre'];
  $id_fournisseur = $_POST['id_fournisseur'];

  /* VARIABLE MODIF FOURNISSEUR FIN ********************************/


  if ($nom_fournisseur != "") {

    if(filter_var($email, FILTER_VALIDATE_EMAIL)){

      $req = $bdd->prepare('UPDATE fournisseurs SET f_nom = :nom_fournisseur,
        f_rue = :rue,
        f_code_postal = :code_postal,
        f_ville = :ville,
        f_tel = :telephone,
        f_fax = :fax,
        f_email = :email,
        f_site = :site,
        f_commentaire = :commentaire,
        id_membre = :id_membre,
        f_livraison = :livraison WHERE id_fournisseur = :id_fournisseur');

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
          'livraison'       => $livraison,
          'id_membre'       => $id_membre,
          'id_fournisseur'  => $id_fournisseur
        ));

        setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été modifié', 'success');
        header('Location:list_fournisseur.php');
        die();

      }else{
        setFlash('Attention le format de l\'email est invalide ou vide', 'danger');
      }
    }else{
      setFlash('Attention le nom du fournisseur est vide', 'danger');
    }

  }



  include 'header_top.php'; ?>

  <title>Liste des fournisseurs | Easy Gestion</title>
  <meta content='' name='viewport'>
  <?php include 'header_bottom.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Liste des fournisseurs
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Liste des fournisseurs</li>
      </ol>
    </section>

    <?php echo flash(); ?>

    <section class="content">
      <div class="row">
        <div class="col-xs-12">

          <div class="box">
            <div class="box-header bg-green">
              <h3 class="box-title">Fournisseurs</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table  class="table table-bordered table-striped example1">
                <thead>
                  <tr>
                    <th>Nom</th>
                    <th>Référence</th>
                    <th>Pays</th>
                    <th>Tel</th>
                    <th>Fax</th>
                    <th>Email</th>
                    <th>Site</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $id_membre = (int)$_SESSION['id_membre'];
                  $req = $bdd->prepare('SELECT * FROM fournisseurs, pays WHERE fournisseurs.f_pays = pays.id AND id_membre = :id_membre');
                  $req->execute(array('id_membre' => $id_membre));
                  while ($donnees = $req->fetch()) {
                    ?>

                        <!--   DEBUT MODAL   -------------------------------------                    -->

                        <div class="modal fade" id="<?php echo $donnees['id_fournisseur']; ?>">

                          <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title">Edition rapide de <?php echo $donnees['f_nom']; ?></h3>
                              </div>

                              <div class="modal-body">

                                <form role="form" action="" method="post">
                                  <input type="hidden" name="id_fournisseur" value="<?php echo $donnees['id_fournisseur']; ?>">
                                  <div class="box-body">

                                    <div class="form-group">
                                      <label for="nom_fournisseur">Nom du fournisseur</label>

                                      <?php if (isset($_POST['nom_fournisseur'])) {
                                        ?>
                                        <input type="text" class="form-control" id="nom_fournisseur" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php if (isset($_POST['nom_fournisseur'])) { echo $_POST['nom_fournisseur']; } ?>">
                                        <?php
                                      }else {
                                        ?>
                                        <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_fournisseur" value="<?php echo $donnees['f_nom']; ?>" required>
                                        <?php
                                      } ?>
                                    </div>

                                    <div class="form-group">
                                      <label for="adresse_fournisseur">Adresse</label>
                                      <div class="box-body">
                                        <div class="row">
                                          <div class="col-xs-5">
                                            <input type="text" class="form-control" name="rue" placeholder="Rue" value="<?php echo $donnees['f_rue']; ?>">
                                          </div>
                                          <div class="col-xs-3">
                                            <?php if ($donnees['f_code_postal'] == 0 ) {
                                              ?>
                                              <input type="text" class="form-control" name="code_postal" placeholder="Code Postal">
                                              <?php
                                            }else{
                                              ?>
                                              <input type="text" class="form-control" name="code_postal" placeholder="Code Postal" value="<?php echo $donnees['f_code_postal']; ?>">
                                              <?php
                                            } ?>

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
                                        <input type="text" class="form-control" name="telephone" placeholder="0102030405" value="<?php echo $donnees['f_tel']; ?>">
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <div class="form-group">
                                      <label>Fax</label>
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-fax"></i>
                                        </div>
                                        <input type="text" class="form-control" name="fax" placeholder="0102030406" value="<?php echo $donnees['f_fax']; ?>">
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <div class="form-group">
                                      <label>Email</label>
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-envelope"></i>
                                        </div>
                                        <input type="email" class="form-control" name="email" placeholder="email@email.com" value="<?php echo $donnees['f_email']; ?>">
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <div class="form-group">
                                      <label>Site</label>
                                      <div class="input-group">
                                        <div class="input-group-addon">
                                          <i class="fa fa-wifi"></i>
                                        </div>
                                        <input type="text" class="form-control" name="site" placeholder="http://site.com" value="<?php echo $donnees['f_site']; ?>">
                                      </div><!-- /.input group -->
                                    </div><!-- /.form group -->

                                    <div class="form-group">
                                      <label>Commentaire</label>
                                      <textarea class="form-control" rows="3" placeholder="Entrer ..." name="commentaire"><?php echo $donnees['f_commentaire']; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                      <label for="adresse_fournisseur">Délai moyen de livraison en jours</label>

                                      <div class="row">
                                        <div class="col-xs-3">
                                          <input type="text" class="form-control" name="livraison" placeholder="Délai" value="<?php echo $donnees['f_livraison']; ?>">
                                        </div>
                                      </div>

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
                      <td><a href="fournisseur.php?p=<?php echo $donnees['id_fournisseur']; ?>"><?php echo html_entity_decode($donnees['f_nom']); ?></a></td>
                      <td>
                        <?php
                        if ($donnees['f_ref'] == "") {
                          echo "Aucune";
                        }else{
                          echo 'F-' . $donnees['f_ref'];
                        }?>
                      </td>
                      <td>
                        <?php
                        if ($donnees['nom_fr_fr'] == "") {
                          echo "Aucune";
                        }else{
                          echo $donnees['nom_fr_fr'];
                        }?>
                      </td>
                      <td>
                        <?php
                        if ($donnees['f_tel'] == "") {
                          echo "Aucun";
                        }else{
                          echo $donnees['f_tel'];
                        }?>
                      </td>
                      <td>
                        <?php
                        if ($donnees['f_fax'] == "") {
                          echo "Aucun";
                        }else{
                          echo $donnees['f_fax'];
                        }?>
                      </td>
                      <td>
                        <?php
                        if ($donnees['f_email'] == "") {
                          echo "Aucun";
                        }else{
                          echo $donnees['f_email'];
                        }?>
                      </td>
                      <td>
                        <?php
                        if ($donnees['f_site'] == "") {
                          echo "Aucun";
                        }else{
                          echo  '<a href="' . htmlentities($donnees['f_site']) . '" ">' . htmlentities($donnees['f_site']) . '</a>';
                        }?>
                      </td>
                      <td>
                        <a href="fournisseur.php?p=<?php echo $donnees['id_fournisseur']; ?>" type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" data-original-title="Voir" "><i class="fa fa-search"></i></a>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#<?php echo $donnees['id_fournisseur']; ?>"><i class="fa fa-edit"></i></button>

                        <?php if ($donnees['f_active'] == 1) {
                          ?>
                          <a href="?desactiver=<?php echo $donnees['id_fournisseur']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour désactiver');" type="button" class="btn btn-danger btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Désactiver le fournisseur" "><i class="fa fa-ban"></i></a>
                          <?php
                        }else{
                          ?>
                          <a href="?active=<?php echo $donnees['id_fournisseur']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour activer');" type="button" class="btn btn-success btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Activer le fournisseur" "><i class="fa fa-check"></i></a>
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
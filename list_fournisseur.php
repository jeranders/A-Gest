<?php include 'bdd.php';
session_start(); 
include 'function.php';


/*
    DESACTIVATION DU FOURNISSEUR
*/

    if(isset($_GET['desactiver'])){
      checkCsrf();

      $f_active = 0;
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

      $f_active = 1;
      $id_fournisseur = (int)$_GET['desactiver'];;

      $req = $bdd->prepare('UPDATE fournisseurs SET f_active = :f_active WHERE id_fournisseur = :get');

      $req->execute(array(
        'f_active'   => $f_active,
        'get'        => $id_fournisseur
        ));
      setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été activé.  Cliquez sur <i class="fa fa-ban"></i> pour le désactiver.', 'success');
      header('Location:list_fournisseur.php');
      die();
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
          <small>Accueil</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
          <li class="active">Liste des fournisseurs</li>
        </ol>
      </section>

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
                    $req = $bdd->prepare('SELECT * FROM fournisseurs WHERE id_membre = :id_membre');
                    $req->execute(array('id_membre' => $id_membre));
                    while ($donnees = $req->fetch()) {
                     ?>     
                     <tr>                             
                      <td><a href="fournisseur.php?p=<?php echo $donnees['id_fournisseur']; ?>"><?php echo html_entity_decode($donnees['f_nom']); ?></a></td>
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
                        <a  <a href="fournisseur.php?p=<?php echo $donnees['id_fournisseur']; ?>" type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" data-original-title="Voir" "><i class="fa fa-search"></i></a>
                        <button type="button" class="btn btn-warning btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Modifier" "><i class="fa fa-edit"></i></button>
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
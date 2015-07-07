<?php include 'bdd.php';
session_start(); 
include 'function.php';


/*
    INFORMATION DU FOURNISSEUR
*/

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

/*
    FIN INFORMATION DU FOURNISSEUR
*/

/*
    DESACTIVATION DU FOURNISSEUR
*/

    if(isset($_GET['desactiver'])){

      checkCsrf();

      $f_active = 0;
      $id_fournisseur = (int)$_GET['p'];

      $req = $bdd->prepare('UPDATE fournisseurs SET f_active = :f_active WHERE id_fournisseur = :get');

      $req->execute(array(
        'f_active'   => $f_active,
        'get'        => $id_fournisseur
        ));
      setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été désactiver. Cliquez sur <i class="fa fa-check"></i> pour le réactiver.', 'success');
      header('Location:fournisseur.php?p='. $id_fournisseur);
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
      $id_fournisseur = (int)$_GET['p'];

      $req = $bdd->prepare('UPDATE fournisseurs SET f_active = :f_active WHERE id_fournisseur = :get');

      $req->execute(array(
        'f_active'   => $f_active,
        'get'        => $id_fournisseur
        ));
      setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été activé.  Cliquez sur <i class="fa fa-ban"></i> pour le désactiver.', 'success');
      header('Location:fournisseur.php?p='. $id_fournisseur);
      die();
    }

/*
   FIN ACTIVATION DU FOURNISSEUR
*/

/*
    MODIFICATION DU FOURNISSEUR
*/

    if (isset($_POST['modif'])) {

      /* VARIABLE AJOUT FOURNISSEUR DEBUT ******************************/
      $nom_fournisseur = htmlentities($_POST['nom_fournisseur']); 
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
      $id_fournisseur = (int)$_GET['p'];

      /* VARIABLE AJOUT FOURNISSEUR FIN ********************************/

      if ($nom_fournisseur != "") {

        if(filter_var($email, FILTER_VALIDATE_EMAIL)){

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

                $req = $bdd->prepare('UPDATE fournisseurs SET f_nom = :nom_fournisseur,
                 f_rue = :rue,
                 f_code_postal = :code_postal,
                 f_ville = :ville,
                 f_pays = :pays,
                 f_tel = :telephone,
                 f_fax = :fax,
                 f_email = :email,
                 f_site = :site,
                 f_commentaire = :commentaire,
                 f_logo = :logo,
                 id_membre = :id_membre,
                 f_livraison = :livraison WHERE id_fournisseur = :get');

                $req->execute(array(
                  'nom_fournisseur' => $nom_fournisseur,
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
                  'id_membre'       => $id_membre,
                  'get'             => $id_fournisseur
                  ));

                setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été modifié', 'success');
                header('Location:fournisseur.php?p='. $id_fournisseur);
                die();

              }else{
                setFlash('Mauvais format de fichier. Le fichier doit être en .jpg, .jpeg, .png, .gif', 'danger');      
              }
            }
          }else{
            $req = $bdd->prepare('UPDATE fournisseurs SET f_nom = :nom_fournisseur,
             f_rue = :rue,
             f_code_postal = :code_postal,
             f_ville = :ville,
             f_pays = :pays,
             f_tel = :telephone,
             f_fax = :fax,
             f_email = :email,
             f_site = :site,
             f_commentaire = :commentaire,
             id_membre = :id_membre,
             f_livraison = :livraison WHERE id_fournisseur = :get');

            $req->execute(array(
              'nom_fournisseur' => $nom_fournisseur,
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
              'id_membre'       => $id_membre,
              'get'             => $id_fournisseur
              ));

            setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été modifié', 'success');
            header('Location:fournisseur.php?p='. $id_fournisseur);
            die();
          }


        }else{
          setFlash('Attention format email invalide ou vide', 'danger');
        }
      }else{
        setFlash('Attention le nom du fournisseur est vide', 'danger');
      }
    }

/*
    FIN MODIFICATION DU FOURNISSEUR
*/

    ?>

    <?php include 'header_top.php'; ?>
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
      <br>
      <?php echo flash(); ?>

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
               <br>
               <button type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Ajouter le <?php echo $donnees['f_date_ajout']; ?>" "><i class="fa fa-calendar"></i></button>
               <button type="button" class="btn btn-warning btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Taux de retard : 5%" "><i class="fa fa-star"></i></button>
               <button type="button" class="btn bg-purple btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Jours de livraison : <?php echo $donnees['f_livraison']; ?>" "><i class="fa fa-truck"></i></button>
               


               <?php if ($donnees['f_active'] == 1) {
                ?> 
                <a href="?p=<?php echo $donnees['id_fournisseur']; ?>&desactiver=<?php echo $donnees['id_fournisseur']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour désactiver');" type="button" class="btn btn-danger btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Désactiver le fournisseur" "><i class="fa fa-ban"></i></a>

                <?php
              }else{
                ?> 
                <a href="?p=<?php echo $donnees['id_fournisseur']; ?>&active=<?php echo $donnees['id_fournisseur']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour activer');" type="button" class="btn btn-success btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Activer le fournisseur" "><i class="fa fa-check"></i></a>
                <?php
              } 

              ?>


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

                  <dd><img data-placement="top" data-toggle="tooltip" href="#" data-original-title="<?php echo html_entity_decode($donnees['nom_fr_fr']); ?>" src="dist/img/pays/<?php echo strtolower(htmlspecialchars($donnees['alpha2'])); ?>.png"></dd>

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
          <!-- Custom Tabs (Pulled to the right) -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
              <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">Commentaire & statistiques</a></li>
              <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Modifier</a></li>
              <li class=""><a href="#tab_3-2" data-toggle="tab" aria-expanded="true">Commande terminé</a></li>
              <li class="active"><a href="#tab_4-2" data-toggle="tab" aria-expanded="true">Commande en cours</a></li>
              
              <li class="pull-left header"><i class="fa fa-th"></i> Menu</li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane" id="tab_1-1">
                <b>Commentaire</b>
                <p>
                  <?php if ($donnees['f_commentaire'] == "") {
                    echo "Aucun commentaire";
                  }else{
                    echo nl2br($donnees['f_commentaire']);
                  } ?>
                </p>
                <b>Statistiques</b>
                <p>Il n'y a x commandes</p> 
                <p>Il y a un taux de retard de 5% (3 retard sur 58 commandes)</p>
                <p>La plus grosse commande et le numéro <a href="#">544s5d4f6sd</a> avec 1258 &euro;</p>
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2-2">


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

                    <div class="form-group">
                      <label for="pays">Pays</label>
                      <div class="box-body">
                        <div class="row">  
                          <select class="form-control" name="pays">
                            <option select="selected" value="<?php echo html_entity_decode($donnees['f_pays']); ?>"><?php echo html_entity_decode($donnees['nom_fr_fr']); ?></option>
                            <?php $pays = $bdd->query('SELECT * FROM pays ORDER BY nom_fr_fr');
                            while ($drap = $pays->fetch()) {
                              ?>
                              <option value="<?php echo $drap['id']; ?>"><?php echo $drap['nom_fr_fr']; ?></option>
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
                      <label for="file">Ajouter un logo</label>
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

                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" name="modif" class="btn btn-primary">Modifier</button>
                  </div>
                </form>
              </div><!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3-2">
                <table  class="table table-bordered table-striped example2">
                  <thead>
                    <tr>
                      <th>nCom</th>
                      <th>Nom</th>
                      <th>Fax</th>
                      <th>Email</th>
                      <th>Divers</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div><!-- /.tab-pane -->
              <div class="tab-pane active" id="tab_4-2">
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
              </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
          </div><!-- nav-tabs-custom -->
        </div>




      </div><!-- /.row -->
    </section><!-- /.content -->

  </div><!-- /.content-wrapper -->


  <?php echo include 'footer.php'; ?>
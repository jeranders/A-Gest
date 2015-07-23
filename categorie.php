<?php include 'bdd.php';
session_start(); 
include 'function.php';


/*
    INFORMATION DU categorie
*/

    $req = $bdd->prepare('SELECT *, DATE_FORMAT(c_date_ajout, \'%d/%m/%Y\') AS c_date_ajout FROM categories WHERE id_membre = :id_membre AND id_categorie = :get');
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
    FIN INFORMATION DU categorie
*/


/*
    MODIFICATION DU categorie
*/

    if (isset($_POST['modif'])) {

      /* VARIABLE MODIF categorie DEBUT ******************************/
      $nom_categorie = htmlentities($_POST['nom_categorie']); 
      $ref = htmlentities($_POST['ref']);       
      $logo = $_FILES['logo'];
      $description = htmlentities($_POST['description']);     
      $id_membre = (int)$_SESSION['id_membre'];
      $id_categorie = (int)$_GET['p'];

      /* VARIABLE MODIF categorie FIN ********************************/

      if ($nom_categorie != "") {

        if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0){

        // Testons si le fichier n'est pas trop gros
          if ($_FILES['logo']['size'] <= 10000000){
                // Testons si l'extension est autorisée
            $infosfichier = pathinfo($_FILES['logo']['name']);
            $extension_upload = $infosfichier['extension'];
            $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
            if (in_array($extension_upload, $extensions_autorisees)) {

              $name_file = 'dist/img/categories/' . str_shuffle('Jesuilelogodescategories') . rand(5,999) . cleanCaracteresSpeciaux($_FILES['logo']['name']); 
              $name_logo = str_replace(' ', '', $name_file);
              move_uploaded_file($_FILES['logo']['tmp_name'], 'dist/img/categories/' . basename($name_logo));

              $req = $bdd->prepare('UPDATE categories SET 
               c_nom          = :nom_categorie,
               c_ref          = :ref,
               c_description  = :description,
               c_logo         = :logo,
               id_membre      = :id_membre 
               WHERE id_categorie = :get');

              $req->execute(array(
                'nom_categorie'   => $nom_categorie,
                'ref'             => $ref,                  
                'description'     => $description,
                'logo'            => $name_logo,                  
                'id_membre'       => $id_membre,
                'get'             => $id_categorie
                ));



              setFlash('La catégorie ' . $nom_categorie .' a bien été modifié', 'success');
              header('Location:categorie.php?p='. $id_categorie);
              die();

            }else{
              setFlash('Mauvais format de fichier. Le fichier doit être en .jpg, .jpeg, .png, .gif', 'danger');      
            }
          }
        }else{
         $req = $bdd->prepare('UPDATE categories SET 
           c_nom          = :nom_categorie,
           c_ref          = :ref,
           c_description  = :description,                
           id_membre      = :id_membre 
           WHERE id_categorie = :get');

         $req->execute(array(
          'nom_categorie' => $nom_categorie,
          'ref'             => $ref,                  
          'description'     => $description,                               
          'id_membre'       => $id_membre,
          'get'             => $id_categorie
          ));

         setFlash('La catégorie ' . $nom_categorie .' a bien été modifié', 'success');
         header('Location:categorie.php?p='. $id_categorie);
         die();
       }

     }else{
      setFlash('Attention le nom du categorie est vide', 'danger');
    }
  }

/*
    FIN MODIFICATION DU categorie
*/



    /*
    DESACTIVATION DU categorie
*/

    if(isset($_GET['desactiver'])){
      checkCsrf();
      $c_active = (int)0;
      $id_categorie = (int)$_GET['p'];
      $req = $bdd->prepare('UPDATE categories SET c_active = :c_active WHERE id_categorie = :get');
      $req->execute(array(
        'c_active'   => $c_active,
        'get'        => $id_categorie
        ));
      setFlash('La catégorie ' . $nom_categorie .' a bien été désactiver. Cliquez sur <i class="fa fa-check"></i> pour le réactiver.', 'success');
      header('Location:categorie.php?p='. $id_categorie);
      die();
    }

/*
    FIN DESACTIVATION DU categorie
*/

/*
    ACTIVATION DU categorie
*/

    if(isset($_GET['active'])){
      checkCsrf();
      $c_active = (int)1;
      $id_categorie = (int)$_GET['p'];
      $req = $bdd->prepare('UPDATE categories SET c_active = :c_active WHERE id_categorie = :get');
      $req->execute(array(
        'c_active'   => $c_active,
        'get'        => $id_categorie
        ));
      setFlash('La catégorie ' . $nom_categorie .' a bien été activé.  Cliquez sur <i class="fa fa-ban"></i> pour le désactiver.', 'success');
      header('Location:categorie.php?p='. $id_categorie);
      die();
    }

/*
   FIN ACTIVATION DU categorie
*/


   ?>

   <?php include 'header_top.php'; ?>
   <title><?php echo html_entity_decode($donnees['c_nom']); ?> | Easy Gestion</title>
   <meta content='' name='viewport'>
   <?php include 'header_bottom.php'; ?>

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


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Fiche de <?php echo html_entity_decode($donnees['c_nom']); ?>         
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active"><a href="liste_categorie.php">Liste des categories</a></li>
        <li class="active"><?php echo html_entity_decode($donnees['c_nom']); ?></li>
      </ol>
    </section>
    <br>
    
    <section class="content">  
     <?php echo flash(); ?>

     <div class="row">

      <div class="col-md-2">
        <!-- general form elements -->
        <div class="box box-primary box-solid i-center">
          <div class="box-header mb-10">
            <h3 class="box-title"><?php echo html_entity_decode($donnees['c_nom']); ?></h3>
          </div><!-- /.box-header -->
          <img src="<?php echo $donnees['c_logo']; ?>" class="img-circle" alt="User Image" width="228px" height="228px"/>
          <div class="m-10">
           <br>
           <button type="button" class="btn btn-info btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Ajouter le <?php echo $donnees['c_date_ajout']; ?>" "><i class="fa fa-calendar"></i></button>
           <?php if ($donnees['c_active'] == 1) {
            ?> 
            <a href="?p=<?php echo $donnees['id_categorie']; ?>&desactiver=<?php echo $donnees['id_categorie']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour désactiver');" type="button" class="btn btn-danger btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Désactiver La catégorie" "><i class="fa fa-ban"></i></a>
            <?php
          }else{
            ?> 
            <a href="?p=<?php echo $donnees['id_categorie']; ?>&active=<?php echo $donnees['id_categorie']; ?>&<?php echo csrf(); ?>" onclick="return confirm('Valider pour activer');" type="button" class="btn btn-success btn-flat data-placement="top" data-toggle="tooltip" href="#" data-original-title="Activer La catégorie" "><i class="fa fa-check"></i></a>
            <?php
          } 

          ?>
        </div>

        <div>
          <div class="box-body">
            <dl>

              <dt>Référence</dt>
              <dd>
                <?php
                if ($donnees['c_ref'] == "") {
                  echo "Aucune";
                }else{
                  echo 'C-' . html_entity_decode($donnees['c_ref']);
                }?>
              </dd>

            </dl>
          </div>
        </div>
      </div><!-- /.box -->
    </div><!--/.col -->

    <div class="col-xs-10">
      <!-- Custom Tabs (Pulled to the right) -->
      <div class="nav-tabs-custom" id="myTabs">
        <ul class="nav nav-tabs pull-right">
          <li class=""><a href="#tab_1-1" data-toggle="tab" aria-expanded="false">description & statistiques</a></li>
          <li class=""><a href="#tab_2-2" data-toggle="tab" aria-expanded="false">Modifier</a></li>
          <li class="active"><a href="#tab_3-2" data-toggle="tab" aria-expanded="true">Liste des produits</a></li>          <li 

          <li class="pull-left header"><i class="fa fa-th"></i> Menu</li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane" id="tab_1-1">
            <b>description</b>
            <p>
              <?php if ($donnees['c_description'] == "") {
                echo "Aucun description";
              }else{
                echo nl2br($donnees['c_description']);
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
                  <label for="nom_categorie">Nom de la catégorie</label>

                  <?php if (isset($_POST['nom_categorie'])) {
                    ?>
                    <input type="text" class="form-control" id="nom_categorie" placeholder="Entrer un nom" name="nom_categorie" value="<?php echo $donnees['c_nom']; ?>">
                    <?php
                  }else {
                    ?>
                    <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_categorie" value="<?php echo $donnees['c_nom']; ?>" required>
                    <?php
                  } ?>
                </div>            

                <!-- REF -->
                <div class="form-group">
                  <label for="reference">Référence</label>
                  <div class="input-group margin">
                    <div class="input-group-btn">
                      <button type="button" class="btn btn-danger" value="Ajouter" onclick="generatePassword()">Aléatoire</button>
                    </div><!-- /btn-group -->
                    <input type="text" class="form-control" id="NUM_DECHARGE" name="ref" value="<?php if (isset($_POST['ref'])) { echo $_POST['ref']; } ?>">
                  </div>
                </div>

                <div class="form-group">
                  <label>Description</label>
                  <textarea class="form-control" rows="3" placeholder="Entrer ..." name="description" value="<?php if (isset($_POST['description'])) { echo $_POST['description']; } ?>"></textarea>
                </div>


                <div class="form-group">
                  <label for="file">Ajouter un logo</label>
                  <input type="file" id="file" name="logo" class="btn-default">
                  <p class="help-block">La taille du fichier ne dois pas dépasser 500ko</p>
                </div> 

              </div><!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" name="modif" class="btn btn-primary">Modifier</button>
              </div>
            </form>

          </div><!-- /.tab-pane -->
          <div class="tab-pane active" id="tab_3-2">
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

        </div><!-- /.tab-content -->
      </div><!-- nav-tabs-custom -->
    </div>


  </div><!-- /.row -->
</section><!-- /.content -->

</div><!-- /.content-wrapper -->


<?php echo include 'footer.php'; ?>
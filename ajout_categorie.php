<?php include 'bdd.php';
session_start(); 
include 'function.php';

if (isset($_POST['send'])) {  
  $nom_categorie  = htmlentities($_POST['nom_categorie']);
  $ref            = htmlentities($_POST['ref']);
  $description    = htmlentities($_POST['description']);
  $active         = (int)1;
  $logo           = $_FILES['logo'];
  $id_membre      = (int)$_SESSION['id_membre'];

  if ($nom_categorie != '') {

    $count = $bdd->prepare('SELECT COUNT(*) FROM categories, membres WHERE c_nom = :nom_categorie AND categories.id_membre = membres.id_membre AND categories.id_membre = :id_membre');
    $count->bindValue('nom_categorie', $nom_categorie, PDO::PARAM_STR);
    $count->bindValue('id_membre', $id_membre, PDO::PARAM_INT);
    $count->execute();

    if ($count->fetchColumn()) {
      /*Si le nom du fournisseur entré est déjà utilisé*/
      setFlash('Attention le nom de la catégorie est déjà utilisé. Si vous avez plusieurs catégories avec le même nom, ajouter un numéro par exemple.', 'danger');
    } else {     

      if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0){

        // Testons si le fichier n'est pas trop gros
        if ($_FILES['logo']['size'] <= 1000000){
                // Testons si l'extension est autorisée
          $infosfichier = pathinfo($_FILES['logo']['name']);
          $extension_upload = $infosfichier['extension'];
          $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
          if (in_array($extension_upload, $extensions_autorisees)) {

            $name_file = 'dist/img/categories/' . str_shuffle('Jesuilelogodescategories') . rand(5,999) . cleanCaracteresSpeciaux($_FILES['logo']['name']); 
            $name_logo = str_replace(' ', '', $name_file);
            move_uploaded_file($_FILES['logo']['tmp_name'], 'dist/img/categories/' . basename($name_logo));

            $req = $bdd->prepare('INSERT INTO categories(c_nom, c_description, c_logo, c_ref, c_date_ajout, c_active, id_membre) 
              VALUES(:c_nom, :c_description, :c_logo, :c_ref, NOW(), :c_active, :id_membre)');
            $req->execute(array(
              'c_nom'         => $nom_categorie,
              'c_description' => $description,
              'c_logo'        => $logo,
              'c_ref'         => $ref,
              'c_active'      => $active,
              'id_membre'     => $id_membre
              ));

            /*setFlash('La catégorie ' . $nom_categorie .' a bien été enregistré', 'success');
            header('Location:ajout_categorie.php');
            die();*/

          }else{
            setFlash('Mauvais format de fichier. Le fichier doit être en .jpg, .jpeg, .png, .gif', 'danger');      
          }
        }
      }else{
        $req = $bdd->prepare('INSERT INTO categories(c_nom, c_description, c_ref, c_date_ajout, c_active, id_membre) 
          VALUES(:c_nom, :c_description, :c_ref, NOW(), :c_active, :id_membre)');
        $req->execute(array(
          'c_nom'         => $nom_categorie,
          'c_description' => $description,             
          'c_ref'         => $ref,
          'c_active'      => $active,
          'id_membre'     => $id_membre
          ));
/*
        setFlash('La catégorie ' . $nom_categorie .' a bien été enregistré', 'success');
        header('Location:ajout_categorie.php');
        die();*/
      }

    }






  }else{
    setFlash('Attention le nom de la catégorie est vide', 'danger');
  }

}



include 'header_top.php'; ?>

<title>Ajout d'une catégorie | Easy Gestion</title>
<meta content='' name='viewport'>
<?php 
$page = 'Ajout d\'une catégorie'; 
include 'header_bottom.php';
?>

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
       Ajout d'une catégorie
     </h1>
     <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li class="active">Ajout d'une catégorie</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

    <?php include 'debug.php'; debug($_FILES); var_dump($_FILES); ?>
    <?php echo flash();?>

    <div class="row">
      <div class="col-md-3 col-sm-6 col-xs-12 col-md-offset-3">
        <div class="info-box">
          <span class="info-box-icon bg-aqua"><i class="fa fa-toggle-up"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Nombre(s) de catégorie</span>
            <span class="info-box-number">
              <?php 
              $id_membre = (int)$_SESSION['id_membre'];
              $nb = $bdd->prepare('SELECT COUNT(*) AS nb_f FROM categories WHERE id_membre = :id_membre');
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
              $nom = $bdd->prepare('SELECT * FROM categories WHERE id_membre = :id_membre ORDER BY c_date_ajout DESC LIMIT 0, 1');
              $nom->execute(array('id_membre' => $id_membre));
              $c_nom = $nom->fetch();
              if ($c_nom == "") {
                echo "Aucune";
              }else{
                ?>
                <a href="categorie.php?p=<?php echo (int)$c_nom['id_categorie']; ?>"><?php echo html_entity_decode($c_nom['c_nom']); ?></a></td>
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
                <label for="nom_categorie">Nom de la catégorie</label>

                <?php if (isset($_POST['nom_categorie'])) {
                  ?>
                  <input type="text" class="form-control" id="nom_categorie" placeholder="Entrer un nom" name="nom_categorie" value="<?php if (isset($_POST['nom_categorie'])) { echo $_POST['nom_categorie']; } ?>">
                  <?php
                }else {
                  ?>
                  <input type="text" class="form-control" placeholder="Entrer un nom" name="nom_categorie" value="<?php if (isset($_POST['nom_categorie'])) { echo $_POST['nom_categorie']; } ?>" required>
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
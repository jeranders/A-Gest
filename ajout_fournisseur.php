<?php include 'header_top.php'; ?>

<?php 

if (isset($_POST['send'])) {
  # code...
}
?>


<title>Ajout d'un fournisseur | Easy Gestion</title>
<meta content='' name='viewport'>
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


  <?php include 'debug.php'; ?>

  <!-- Small boxes (Stat box) -->
  <div class="row">
    <!-- left column -->
    <div class="col-md-6 col-md-offset-3">
      <!-- general form elements -->
      <div class="box box-primary">
        <div class="box-header">
          <h3 class="box-title">Informations du fournisseur</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form role="form" action="" method="post">

          <div class="box-body">
            <div class="form-group">
              <label for="nom_fournisseur">Nom du fournisseur</label>
              <input type="text" class="form-control" id="nom_fournisseur" placeholder="Entrer un nom" name="nom_fournisseur">
            </div>

            <div class="form-group">
              <label for="adresse_fournisseur">Adresse</label>
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-5">
                    <input type="text" class="form-control" name="rue" placeholder="Rue">
                  </div>
                  <div class="col-xs-3">
                    <input type="text" class="form-control" name="code_postal" placeholder="Code Postal">
                  </div>
                  <div class="col-xs-4">
                    <input type="text" class="form-control" name="ville" placeholder="Ville">
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
                <input type="text" class="form-control" name="telephone"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Fax</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </div>
                <input type="text" class="form-control" name="fax"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Email</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-envelope"></i>
                </div>
                <input type="text" class="form-control" name="email"/>
              </div><!-- /.input group -->
            </div><!-- /.form group -->

            <div class="form-group">
              <label>Site</label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-wifi"></i>
                </div>
                <input type="text" class="form-control" name="site"/>
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
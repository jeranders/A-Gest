<?php include 'header_top.php'; ?>
<title>Accueil | Easy Gestion</title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php include 'header_bottom.php'; ?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Panneaux de contrôle
      <small>Accueil</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li class="active">Panneaux de contrôle</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php var_dump($_SESSION); ?>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>11</h3>
            <p>Vente du mois</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
          <div class="inner">
            <h3>85<sup style="font-size: 20px">%</sup></h3>
            <p>Bénéfice</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
          <div class="inner">
            <h3>44</h3>
            <p>Nouveaux clients</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
          <div class="inner">
            <h3>655<sup style="font-size: 20px">&euro;</sup></h3>
            <p>Chiffre d'affaire</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">Plus d'informations <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div><!-- ./col -->
    </div><!-- /.row -->


    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Commande en cours</h3>

          </div><!-- /.box-header -->
          <div class="box-body no-padding">

            <table class="table table-striped">
              <tr>
                <th style="width: 10px">N°Com</th>
                <th>Fournisseurs</th>
                <th>Nom</th>
                <th>Date</th>
                <th>Quantité</th>
                <th>Prix U</th>
                <th style="width: 40px">Prix T</th>
              </tr>
              <tr>
                <td>184545895</td>
                <td>Alex Jewlry</td>
                <td>Cabochon 18 mm</td>
                <td>28/02/2015</td>
                <td>2</td>
                <td>12 &euro;</td>
                <td><span class="badge bg-red">24 &euro;</span></td>
              </tr>
              <tr>
                <td>189775895</td>
                <td>Alex Jewlry</td>
                <td>Cabochon 12 mm</td>
                <td>28/02/2015</td>
                <td>1</td>
                <td>35 &euro;</td>
                <td><span class="badge bg-green">35 &euro;</span></td>
              </tr>                  
            </table>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- /.col -->

      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">5 derniers produit enregistré</h3>
          </div><!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th style="width: 10px">Ref</th>
                <th>Nom</th>
                <th>Catégorie</th>                
              </tr>
              <tr>
                <td>DFERFF</td>
                <td>Cabochon</td>
                <td>
                 Cabochon 18 mm
               </td>
             </tr>              
           </table>
         </div><!-- /.box-body -->
       </div><!-- /.box -->
     </div><!-- /.col -->
   </div><!-- /.row -->

   <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">Commande à payer</h3>

        </div><!-- /.box-header -->
        <div class="box-body no-padding">

          <table class="table table-striped">
            <tr>
              <th style="width: 10px">N°Com</th>
              <th>Fournisseurs</th>
              <th>Nom</th>
              <th>Date commande</th>
              <th>Date réception</th>
              <th style="width: 40px">Prix T</th>
            </tr>
            <tr>
              <td>184545895</td>
              <td>Alex Jewlry</td>
              <td>Cabochon 18 mm</td>
              <td>28/02/2015</td>
              <td><span class="badge bg-green">02/03/2015<span></td>              
              <td>24 &euro;</td>
            </tr>
            <tr>
              <td>189775895</td>
              <td>Alex Jewlry</td>
              <td>Cabochon 12 mm</td>
              <td>28/02/2015</td>
              <td><span class="badge bg-red">En cours</span></td>              
              <td>35 &euro;</td>
            </tr>                  
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div><!-- /.col -->

    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title">5 derniers produit enregistré</h3>
        </div><!-- /.box-header -->
        <div class="box-body no-padding">
          <table class="table table-striped">
            <tr>
              <th style="width: 10px">Ref</th>
              <th>Nom</th>
              <th>Catégorie</th>                
            </tr>
            <tr>
              <td>DFERFF</td>
              <td>Cabochon</td>
              <td>
               Cabochon 18 mm
             </td>
           </tr>              
         </table>
       </div><!-- /.box-body -->
     </div><!-- /.box -->
   </div><!-- /.col -->
 </div><!-- /.row -->

</section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php echo include 'footer.php'; ?>
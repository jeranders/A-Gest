<?php 
include 'bdd.php';
session_start();

if (isset($_POST['send'])) {
  $pseudo = $_POST['pseudo'];  
  $pass_hache = sha1($_POST['password']); 

  $req = $bdd->prepare('SELECT * FROM membres WHERE m_pseudo = :pseudo AND password = :pass');
  $req->execute(array('pseudo' => $pseudo, 'pass' => $pass_hache));
  $donnees = $req->fetch();
  if ($req->rowCount() > 0 ) {
    $_SESSION['id_membre'] = $donnees['id_membre'];
    $_SESSION['m_pseudo'] = $donnees['m_pseudo'];
    echo 'Salut';
    //setFlash('Bonjour ' . $donnees['m_pseudo'] . ' j\'espère que vous allez bien !');
    header('Location:index.php');
    die();
  }else{
    echo 'Nom d\'utilisateur ou mot de passe incorrect.';
  }
}

 ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Connexion | Easy Gestion</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="index.php">Easy Gestion</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Connectez-vous pour commencer votre session</p>
        <form action="#" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Pseudo" name="pseudo"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="password"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  <input type="checkbox"> Se souvenir de moi
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name="send" class="btn btn-primary btn-block btn-flat">Connexion</button>
            </div><!-- /.col -->
          </div>
        </form>


        <a href="#">J'ai oublié mon mot de passe</a><br>
        <a href="register.html" class="text-center">S'inscrire</a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
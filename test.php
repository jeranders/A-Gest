<?php 

if (isset($_POST['send'])) {

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

  /* VARIABLE AJOUT FOURNISSEUR FIN ********************************/

  /*Requete qui recherche dans la BDD si un fournisseur est déjà utilisé*/

  $count = $bdd->prepare('SELECT COUNT(*) FROM fournisseurs,membres WHERE f_nom = :nom_fournisseur AND fournisseurs.id_membre = membres.id_membre AND fournisseurs.id_membre = :id_membre');
  $count->bindValue('nom_fournisseur', $nom_fournisseur, PDO::PARAM_STR);
  $count->bindValue('id_membre', $id_membre, PDO::PARAM_INT);
  $count->execute();

  if ($count->fetchColumn()) {
    /*Si le nom du fournisseur entré est déjà utilisé*/
    setFlash('Attention le nom du fournisseur est déjà utilisé. Si vous avez plusieurs fournisseurs avec le même nom, ajouter un numéro par exemple.', 'danger');
    $erreur_nom_fournisseur = '<p class="text-red"><i class="fa fa-fw fa-warning"></i> Erreur, le nom du fournisseur est déjà utilisé.</p>';
  } else {

   if (isset($_FILES['logo']) AND $_FILES['logo']['error'] == 0){

        // Testons si le fichier n'est pas trop gros
    if ($_FILES['logo']['size'] <= 1000000){
                // Testons si l'extension est autorisée
      $infosfichier = pathinfo($_FILES['logo']['name']);
      $extension_upload = $infosfichier['extension'];
      $extensions_autorisees = array('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG');
      if (in_array($extension_upload, $extensions_autorisees)) {

        $name_file = 'dist/img/fournisseurs/' . $nom_fournisseur . rand(5,999) . $_FILES['logo']['name']; 

        move_uploaded_file($_FILES['logo']['tmp_name'], 'dist/img/fournisseurs/' . basename($name_file));

        $req = $bdd->prepare('INSERT INTO fournisseurs(f_nom, f_rue, f_code_postal, f_ville, f_pays, f_tel , f_fax, f_email, f_site, f_commentaire, f_logo, id_membre, f_date_ajout, f_livraison) 
          VALUES(:nom_fournisseur, :rue, :code_postal, :ville, :pays, :telephone, :fax, :email, :site, :commentaire, :logo, :id_membre, NOW(), :livraison)');
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
          'logo'            => $name_file,
          'livraison'       => $livraison,
          'id_membre'       => $id_membre
          ));

        setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été enregistré', 'success');
        header('Location:ajout_fournisseur.php');
        die();

      }else{
        setFlash('Mauvais format de fichier', 'danger');      
      }
    }
  }else{
               $req = $bdd->prepare('INSERT INTO fournisseurs(f_nom, f_rue, f_code_postal, f_ville, f_pays, f_tel , f_fax, f_email, f_site, f_commentaire, id_membre, f_date_ajout, f_livraison) 
                VALUES(:nom_fournisseur, :rue, :code_postal, :ville, :pays, :telephone, :fax, :email, :site, :commentaire, :id_membre,NOW(), :livraison)');
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
                'id_membre'       => $id_membre
                ));

               setFlash('Le fournisseur ' . $nom_fournisseur .' a bien été enregistré', 'success');
               header('Location:ajout_fournisseur.php');
               die();
 }
}
}
?>
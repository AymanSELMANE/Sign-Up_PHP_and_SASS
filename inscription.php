<?php

$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'root');
 
if(isset($_POST['forminscription'])) {

   $pseudo = htmlspecialchars($_POST['pseudo']);
   $mail = htmlspecialchars($_POST['mail']);
   $mail2 = htmlspecialchars($_POST['mail2']);
   $mdp = sha1($_POST['mdp']);
   $mdp2 = sha1($_POST['mdp2']);

   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
      $pseudolength = strlen($pseudo);
      if($pseudolength <= 255) {
         if($mail == $mail2) {
            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {

               $reqmail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
               $reqmail->execute(array($mail));
               $mailexist = $reqmail->rowCount();
               if($mailexist == 0) {

                  if($mdp == $mdp2) {

                     $insertmbr = $bdd->prepare("INSERT INTO membres(pseudo, mail, motdepasse) VALUES(?, ?, ?)");
                     $insertmbr->execute(array($pseudo, $mail, $mdp));
                     $erreur = "Votre compte a bien été créé !";
                     header("Location: connexion.php");

                  } else {
                     $erreur = "Vos mots de passes ne correspondent pas !";
                  }
               } else {
                  $erreur = "Adresse mail déjà utilisée !";
               }
            } else {
               $erreur = "Votre adresse mail n'est pas valide !";
            }
         } else {
            $erreur = "Vos adresses mail ne correspondent pas !";
         }
      } else {
         $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
      }
   } else {
      
   }
}
?>

<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" type="text/css" href="Style.css">
   <title>Inscription</title>
</head>
<body>

<div class="container">

   <div class="container__top">
         <div class="brand__logo"></div>
         <div class="brand__title"><a href="#">Home</a></div>
   </div>

   <div class="cointainer__bottom">
   <form method="POST" action="">
         <h2>Sign Up</h2>
      <input type="text" placeholder="Votre pseudo" id="pseudo" name="pseudo" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>" />  

      <input type="email" placeholder="Votre mail" id="mail" name="mail" value="<?php if(isset($mail)) { echo $mail; } ?>" />

      <input type="email" placeholder="Confirmez votre mail" id="mail2" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" />

      <input type="password" placeholder="Votre mot de passe" id="mdp" name="mdp" />

      <input type="password" placeholder="Confirmez votre mdp" id="mdp2" name="mdp2" />

      <input type="submit" name="forminscription" value="Sign up" class="Button"/>

   </form>
   </div>

</div>
<?php
if(isset($erreur)) 
{
   echo '<font color="#ff482b">'.$erreur."</font>";
}
?>

</body>
</html>
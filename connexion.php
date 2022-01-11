<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'root');
 
if(isset($_POST['formconnexion'])) {
   $mailconnect = htmlspecialchars($_POST['mailconnect']);
   $mdpconnect = sha1($_POST['mdpconnect']);
   if(!empty($mailconnect) AND !empty($mdpconnect)) {

      $requser = $bdd->prepare("SELECT * FROM membres WHERE mail = ? AND motdepasse = ?");
      $requser->execute(array($mailconnect, $mdpconnect));
      $userexist = $requser->rowCount();

      if($userexist == 1) {
         $userinfo = $requser->fetch();
         $_SESSION['id'] = $userinfo['id'];
         $_SESSION['pseudo'] = $userinfo['pseudo'];
         $_SESSION['mail'] = $userinfo['mail'];
         header("Location: profil.php?id=".$_SESSION['id']);
      } 
      else {
         $erreur = "Mauvais mail ou mot de passe !";
      }
   } else {
      
   }
}
?>

<!DOCTYPE html>
<html>
   <head>
      <title>Connexion</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="Style.css">
      <meta charset="utf-8">
   </head>
   <body>

   <div class="container">

      <div class="container__top">
            <div class="brand__logo"></div>
            <div class="brand__title"><a href="#">Home</a></div>
      </div>

      <div class="cointainer__bottom">
      <form method="POST" action="">
            <h2>Login</h2>
            <input type="email" name="mailconnect" placeholder="Email" /><br><br>
            <input type="password" name="mdpconnect" placeholder="Password" />
            <br /><br />
            <input type="submit" name="formconnexion" value="Login" class="Button"/>

      </form>
      </div>

      </div>
   <?php
      if(isset($erreur)) {
         echo '<font color="red">'.$erreur."</font>";
      }
   ?>
   </body>
</html>
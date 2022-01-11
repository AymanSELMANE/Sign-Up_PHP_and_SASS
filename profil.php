<?php
session_start();
 
$bdd = new PDO('mysql:host=127.0.0.1;dbname=espace_membre', 'root', 'root');
 
if(isset($_GET['id']) AND $_GET['id'] > 0) {
   $getid = intval($_GET['id']);
   $requser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
   $requser->execute(array($getid));
   $userinfo = $requser->fetch();
?>
<html>
   <head>
      <title>PROFILE</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="Style-Profil.css">
      <meta charset="utf-8">
   </head>
   <body>
      <div class="Container">

         <div class="cointainer__bottom">
            <h2>Profil de <?php echo $userinfo['pseudo']; ?></h2>

            Pseudo = <?php echo $userinfo['pseudo']; ?>

            Mail = <?php echo $userinfo['mail']; ?>

            <?php
            if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
            ?>
            <br />
            <a href="editionprofil.php" class="Btn__Edit" >Editer mon profil</a><br><br>
            <a href="deconnexion.php" class="Btn__Deconnexion">Se déconnecter</a>
            <?php
            }
            ?>
         </div>
         
      </div>
   </body>
</html>
<?php   
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../css/renduAuthentification.css" />
</head>
<body>
<?php
require_once __DIR__ . '../../vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('../src/conf/conf.ini');
if (isset($_REQUEST['username'], $_REQUEST['password'])){
       $usr = $_REQUEST['username'];
       $pwd = $_REQUEST['password'];
       $pwdv = $_REQUEST['passwordverif'];
       $verif = \mywishlist\models\Utilisateurs::where('username', '=', $usr)->first();
       if(!isset($verif)) {
           if ($pwd === $pwdv) {
               $register = new \mywishlist\models\Utilisateurs();
               $register->username = $usr;
               $register->password = hash('sha256', $pwd);
               $register->save();
               echo "<div class='sucess'>
                 <h3>Vous êtes inscrits avec succès.</h3>
           </div>";
               header("Location: http://localhost/wishlist/");
           } else {
               $message = "Le mot de passe est different dans le champ de confirmation";
           }
       }
       else{
           $message = "L'utilisateur existe deja.";
       }

}
    ?>
    <form class="box" action="" method="post">
        <h1 class="box-logo box-title"><a href="/wishlist/index.php">WishList</a></h1>
        <h1 class="box-title">S'inscrire</h1>
        <input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" class="box-input" name="password" placeholder="Mot de passe" required>
        <input type="password" class="box-input" name="passwordverif" placeholder="Confirmation de mot de passe" required >
        <input type="submit" name="submit" value="S'inscrire" class="box-button" />
        <?php if (! empty($message)) { ?>
            <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
    </form>
</body>
</html>



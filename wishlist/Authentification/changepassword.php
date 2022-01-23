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
session_start();
if (isset($_REQUEST['ancienpassword'], $_REQUEST['nouveaupassword'])){
        $apwd = $_REQUEST['ancienpassword'];
        $npwd = $_REQUEST['nouveaupassword'];
        $pwdv = $_REQUEST['passwordverif'];
        $usr = \mywishlist\models\Utilisateurs::where('username', '=', $_SESSION['username'])->first();
        if ($usr->password === hash('sha256',$apwd)) {
            if ($npwd === $pwdv) {
                \mywishlist\models\Utilisateurs::where('username', $_SESSION['username'])->update(['password' => hash('sha256',$npwd)]);
                header("Location: http://localhost/wishlist/utilisateurs/$usr->username");
            } else {
                $message = "Le mot de passe est different dans le champ de confirmation";
            }
        }
        else{
            $message = "Le mot de passe saisi ne correspond pas a l'ancien";
        }
}
?>
<form class="box" action="" method="post">
    <h1 class="box-logo box-title"><a href="/wishlist/index.php">WishList</a></h1>
    <h1 class="box-title">Changer le mot de passe</h1>
    <input type="password" class="box-input" name="ancienpassword" placeholder="Ancien mot de passe" required>
    <input type="password" class="box-input" name="nouveaupassword" placeholder="Nouveau mot de passe" required>
    <input type="password" class="box-input" name="passwordverif" placeholder="Confirmation de mot de passe" required >
    <input type="submit" name="submit" value="S'inscrire" class="box-button" />
    <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
    <?php } ?>
</form>
</body>
</html>




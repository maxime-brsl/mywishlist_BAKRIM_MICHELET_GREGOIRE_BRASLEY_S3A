
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
if (isset($_POST['username'])){
    $user = \mywishlist\models\Utilisateurs::where('username', '=', $_REQUEST['username'])->first();
    $password =  \mywishlist\models\Utilisateurs::where('password', '=', hash('sha256',$_REQUEST['password']))->first();
    if(isset($user) && isset($password)){
        $_SESSION['username'] = $user->username;
        header("Location: http://localhost/wishlist/utilisateurs/$user->username");
    }
    else{
        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
    }
}
?>
<form class="box" action="" method="post" name="login">
    <h1 class="box-logo box-title"><a href="/wishlist/index.php">WishList</a></h1>
    <h1 class="box-title">Connexion</h1>
    <input type="text" class="box-input" name="username" placeholder="Nom d'utilisateur" required />
    <input type="password" class="box-input" name="password" placeholder="Mot de passe" required />
    <input type="submit" value="Connexion " name="submit" class="box-button">
    <p class="box-register">Pas encore inscrit(e) ? <a href="register.php">Cliquez ici</a></p>
    <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
    <?php } ?>
</form>
</body>
</html>
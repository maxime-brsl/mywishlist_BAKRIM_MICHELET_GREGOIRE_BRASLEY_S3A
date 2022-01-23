<?PHP

require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');


$titre = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
$exp = filter_var($_POST['exp'], FILTER_SANITIZE_STRING);

$user = \mywishlist\models\Utilisateurs::where('username', '=', $_SESSION['username'])->first();
$insertion = new \mywishlist\models\Liste();
$insertion->no = \mywishlist\models\Liste::max('no') + 1;
$insertion->user_id = $user->id;
$insertion->titre = $titre;
$insertion->description = $desc;
$insertion->expiration = $exp;
$insertion->token = "nosecure".$insertion->no;

$insertion->save();
echo "<script type='text/javascript'>alert('Liste Ajoutée');</script>";
header("Location: http://localhost/wishlist/");


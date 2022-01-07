<?PHP

require_once __DIR__ . '/vendor/autoload.php';
use mywishlist\bd\Eloquent;
Eloquent::start('src/conf/conf.ini');


$titre = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
$desc = filter_var($_POST['desc'], FILTER_SANITIZE_STRING);
$exp = filter_var($_POST['exp'], FILTER_SANITIZE_STRING);


$insertion = new \mywishlist\models\Liste();
$insertion->no = \mywishlist\models\Liste::max('no') + 1;
$insertion->titre = $titre;
$insertion->description = $desc;
$insertion->expiration = $exp;
$insertion->token = "nosecure".$insertion->no;

$insertion->save();
echo "<script type='text/javascript'>alert('Liste Ajoutée');</script>";
header("Location: http://localhost/wishlist/");


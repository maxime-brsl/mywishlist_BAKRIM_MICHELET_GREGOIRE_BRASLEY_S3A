<?php
namespace mywishlist\view;


class VueAuthentification{

    /**
     * fonction qui permet de generer une page html liee a une session d'un utilisateur
     */
    public function pageHTMLAuthentification(){

        $html = <<<END
                <!DOCTYPE html>
                <head>
                    <meta charset="UTF-8">
                    <title>Wishlist de phpMyAdmin</title>
                    <link rel="stylesheet" href="../css/renduMain.css">
                </head>
                <body>
   
                    <h1>Bondour $_SESSION[username] </h1>
                    <button><a href="/wishlist/Authentification/logout.php">Se Deconnecter</a></button>
                    <button><a href="/wishlist/Authentification/changepassword.php">Changer le mot de passe</a></button>
    
                    <article>
                        <h3>Que voulez vous faire ?</h3>
                        <div id="choix">
                            <button id="blist">Consulter une liste</button>
                            <button id="bitem">Consulter un item</button>
                            <button id="baddlist">Ajouter une liste</button>
                            <button id="bcreercagnotte">Créer une cagnotte</button>
                            <button id="bjoindrelist">Joindre une liste</button>
                            <button><a href="/wishlist/Authentification/Listecreateurs.php">Voir la liste des createurs</a></button>
                        </div>
                    </article>
    
                    <form id="fitem" method="POST" action="/wishlist/redirect.php">
                        <label>Numero de l'item</label>
                        <input ="text" name="iditem">
                        <button type="submit" class="action">Chercher l'item</button>
                    </form>
    
                    <form id="flist" method="POST" action="/wishlist/redirect.php">
                        <label>Token de la liste</label>
                        <input ="text" name="token">
                        <button type="submit" class="action">Chercher la liste</button>
                    </form>
                    
                    <form id="flistjoin" method="POST" action="/wishlist/Authentification/JoindreListe.php">
                        <label>Token de la liste</label>
                        <input ="text" name="token">
                        <button type="submit" class="action">Joindre la liste</button>
                    </form>
                    
                    <form id="faddlist" method="POST" action="/wishlist/AjouterListe.php">
                        <label>Titre :</label>
                        <input ="text" name="title">
                        <label>Description :</label>
                        <input ="text" name="desc">
                        <label>Date d'expiration (YYYY-MM-DD) :</label>
                        <input ="text" name="exp">
                        <button type="submit" class="action">Ajouter la liste</button>
                    </form>
                    
                    <form id="fcreercagnotte" method="POST">
                        <label>ID de l'item :</label>
                        <input ="text" name="id_item">
                        <label>Montant :</label>
                        <input ="text" name="prix">
                        <button type="submit" class="action">Créer la cagnotte</button>
                    </form>
                        
                    <script src="../js/listener.js"></script>
                </body>
    
            END;

        return($html);
    }


}
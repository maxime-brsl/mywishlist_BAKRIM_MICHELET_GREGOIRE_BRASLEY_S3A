<?php

namespace mywishlist\view;

class VueParticipant{

    public function pageHTML($contenu){

        $contenuHTML = $this->unItemHTML($contenu);

        $html = <<<END

        <!DOCTYPE html>
        <head>
            <link rel="stylesheet" href="./../rendu.css">
        </head>
        <body>

            $contenuHTML

        </body>

        END;

        return($html);
    }

    /**
     * fonction qui permet de generer une pafe HTML
     * @param string $contenu = le contenu de la page html
     * @return mixed page HTML avec le contenu
     */
    public function unItemHTML($infoItem){
        $contenu = "";

        $infos = explode(",", $infoItem);

        // on ajoute le contenu petit a petit
        foreach($infos as $v){

            // on separe les cles des infos pour savoir si c le nom le prix etc
            $cle = explode(":", $v);

            $information = explode("\"", $cle[1]);
    
            // si on trouve l image alors il faut sauver l image pour l afficher apres
            if($cle[0] === "\"img\""){
                $image = "<img src='../img/$information[1]'>";
            }
            else if($cle[0] === "\"nom\""){
                $contenu = $contenu . "<h1> $information[1] </h1>";
            }
            else if($cle[0] === "\"tarif\""){
                $contenu = $contenu . "<p> tarif : $information[1] € </p>";
            }
            else{
                // sinon on met l information directement 
                $contenu = $contenu . "<p> $information[1] </p>";
            }
        }
        
        // on n oublie pas de mettre l image si on en a trouve une
        $contenu = $contenu . $image;

        return($contenu);
    }

}
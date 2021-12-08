<?php

namespace mywishlist\view;

class VueParticipant{

    /**
     * fonction qui permet de generer une pafe HTML
     * @param string $contenu = le contenu de la page html
     * @return mixed page HTML avec le contenu
     */
    public function PageHTML($contenu){
        $html = <<<END

        <!DOCTYPE html>
        <head>
        </head>
        <body>

            $contenu

        </body>

        END;

        return($html);
    }

}
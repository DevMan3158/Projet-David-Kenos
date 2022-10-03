<?php

namespace App\Service;

class Pagination {

    public function pagination($elements, $perPage){

        // On détermine sur quelle page on se trouve

        if(!empty($_GET['pg'])){
            $currentPage = (int) strip_tags($_GET['pg']);
        } else {
            $currentPage = 1;
        }

        // On compte le nombre de pages

        $page = ceil((count($elements)) / $perPage);

        // Calcul du premier article de la page

        $firstObj = ($currentPage * $perPage) - $perPage;

    }

}
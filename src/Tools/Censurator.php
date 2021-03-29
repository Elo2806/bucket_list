<?php


namespace App\Tools;


class Censurator
{

    public function purify(string $string):string{

        $listInjures = ['putain', 'enfoire', 'pute', 'encule'];
        foreach ($listInjures as $cle=>$mot){
           $position = stripos($string, $mot);
           if ($position) {
               $taille = strlen($mot);
               for ($i = 1; $i < $taille-1; $i++) {
                   $string[$position + $i] = '*';
               }
           }
        }

        return $string;
    }

}
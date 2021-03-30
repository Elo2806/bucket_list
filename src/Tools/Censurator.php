<?php


namespace App\Tools;


use App\Repository\InjureRepository;

class Censurator
{

    private $injureRepository;

    public function __construct(InjureRepository $injureRepository){

        $this->injureRepository = $injureRepository;
    }

    public function purify(string $string): string{

        //$listInjures = ['putain', 'enfoiré', 'pute', 'enculé'];
        $listInjures = $this->injureRepository->findAll();
/*
        //On aurait pû faire
        return str_ireplace($listInjures, '****', $string);  Où listInjures serait un tableau simple, pas d'objets

        //Ou aussi
        foreach ($listInjures as $mot){   Où $listInjures est un tab simple, pas d'objets
            $motPurifie = mb_substr(($mot, 0, 1). str_repeat("*", mb_strlen($mot)-1);
            $string = str_ireplace($mot, $motPurifie, $string);
        }

  */
        foreach ($listInjures as $injure) {
            $libelle = $injure->getLibelle();

            do {
                $position = stripos($string, $libelle); // /!\ Si mot en 1er, position sera = à 0 donc false (il faut comparer le type)
                if ($position !== false) {      //On compare le type booléen
                    $taille = mb_strlen($libelle);
                    for ($i = 1; $i < $taille - 1; $i++) {
                        $string[$position + $i] = '*';
                    }
                }
            } while ($position !== false);

        }
        return $string;
    }

}
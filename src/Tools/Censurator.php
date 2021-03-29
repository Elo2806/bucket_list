<?php


namespace App\Tools;


use App\Repository\InjureRepository;

class Censurator
{

    private InjureRepository $injureRepository;

    public function __constrct(InjureRepository $injureRepository){

        $this->injureRepository = $injureRepository;
    }

    public function purify(string $string, InjureRepository $injureRepository):string{

        //$listInjures = ['putain', 'enfoiré', 'pute', 'enculé'];
        $listInjures = $injureRepository->findAll();

        foreach ($listInjures as $injure){
            $libelle = $injure->getLibelle();
            $position = stripos($string, $libelle);
            if ($position) {
                $taille = strlen($libelle);
                for ($i = 1; $i < $taille-1; $i++) {
                   $string[$position + $i] = '*';
                }
            }
        }

        return $string;
    }

}
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

        //On aurait pû faire
        // return str_ireplace($listInjures, '****', $string);
            foreach ($listInjures as $injure) {
                $libelle = $injure->getLibelle();

                do {
                    $position = stripos($string, $libelle);
                    if ($position !== false) {
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
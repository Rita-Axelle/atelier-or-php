<?php

class Validator {
    public static function isEmpty(array $data, array $champs): array {
        $erreurs = [];
        foreach ($champs as $champ) {
            if (!isset($data[$champ]) || trim($data[$champ]) === '') {
                $erreurs[$champ] = "Le champ '$champ' est requis.";
            }
        }
        return $erreurs;
    }
}

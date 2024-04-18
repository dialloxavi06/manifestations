<?php

namespace App\Enum;

enum StatutProjet : string{
    case en_attente = 'En attente';
    case en_cour_eval = 'En cours d’évaluation';
    case en_cour_saisie = 'En cours de saisie ';
    case termine = 'Terminé';
    case annule = 'Annulé';
    case soutenu = 'Soutenu';
    case refuse = 'Non soutenu';

  public function toString(): string
  {
    return match ($this) {
      self::en_attente => 'En attente',
      self::en_cour_eval => 'En cours d’évaluation',
      self::en_cour_saisie => 'En cours de saisie',
      self::termine => 'Terminé',
      self::annule => 'Annulé',
      self::soutenu => 'Soutenu',
      self::refuse => 'Non soutenu',
    };
  }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class CompteModel extends Model
{
    protected $table = 'Compte';
    protected $primaryKey = 'id_compte';
    protected $allowedFields = ['id_client', 'id_operateur', 'numero_telephone', 'solde'];
    protected $useTimestamps = false;

    /**
     * Get all accounts for a client, joined with the operator name.
     *
     * @param int $clientId
     * @return array
     */
    public function getComptesWithOperateurByClient(int $clientId): array
    {
        return $this->select('Compte.*, Operateur.nom')
            ->join('Operateur', 'Compte.id_operateur = Operateur.id_operateur')
            ->where('Compte.id_client', $clientId)
            ->findAll();
    }
}
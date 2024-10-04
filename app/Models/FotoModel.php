<?php
namespace App\Models;

use CodeIgniter\Model;

class FotoModel extends Model
{
    protected $table      = 'foto';
    protected $primaryKey = 'foto_FotoID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'foto_FotoID',
        'foto_ContadorID',
        'foto_UnicoID',
        'foto_Foto',
        'foto_Completo',
        'foto_Status',
        'foto_DataHora'
    ];
}

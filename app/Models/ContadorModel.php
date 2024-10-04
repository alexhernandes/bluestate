<?php
namespace App\Models;

use CodeIgniter\Model;

class ContadorModel extends Model
{
    protected $table      = 'contador';
    protected $primaryKey = 'contador_ContadorID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'contador_ContadorID',
        'contador_UnicoID',
        'contador_UsuarioID',
        'contador_PagamentoID',
        'contador_Slug',
        'contador_DataObjetivo',
        'contador_HoraObjetivo',
        'contador_Titulo',
        'contador_Descricao',
        'contador_Itinerario',
        'contador_Plano',
        'contador_QRCode',
        'contador_Status',
        'contador_DataHora'
    ];
}

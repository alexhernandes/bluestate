<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuario';
    protected $primaryKey = 'usuario_UsuarioID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'usuario_UsuarioID',
        'usuario_NomeCompleto',
        'usuario_Email',
        'usuario_Telefone',
        'usuario_Code',
        'usuario_Status',
        'usuario_DataHora'
    ];
}

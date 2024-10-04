<?php
namespace App\Models;

use CodeIgniter\Model;

class EmailModel extends Model
{
    protected $table      = 'email';
    protected $primaryKey = 'email_EmailID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'email_EmailID',
        'email_UsuarioID',
        'email_Para',
        'email_Assunto',
        'email_Email',
        'email_Status',
        'email_DataHora'
    ];
}

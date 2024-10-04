<?php
namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table      = 'pagina';
    protected $primaryKey = 'pagina_PaginaID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'pagina_PaginaID',
        'pagina_Slug',
        'pagina_Titulo',
        'pagina_Conteudo',
        'pagina_Status',
        'pagina_DataHora'
    ];
}

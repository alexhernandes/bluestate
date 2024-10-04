<?php
namespace App\Models;

use CodeIgniter\Model;

class PagamentoModel extends Model
{
    protected $table      = 'pagamento';
    protected $primaryKey = 'pagamento_PagamentoID';
    protected $returnType = 'object';

    protected $allowedFields = [
        'pagamento_PagamentoID',
        'pagamento_UsuarioID',
        'pagamento_UnicoID',
        'pagamento_Identificador',
        'pagamento_Tipo',
        'pagamento_Valor',
        'pagamento_Moeda',
        'pagamento_Plataforma',
        'pagamento_Plataforma_OrderID',
        'pagamento_Plataforma_IntentID',
        'pagamento_Plataforma_PaymentID',
        'pagamento_Plataforma_Valor',
        'pagamento_Plataforma_Moeda',
        'pagamento_Plataforma_TipoPagamento',
        'pagamento_Plataforma_Status',
        'pagamento_Plataforma_Country',
        'pagamento_Plataforma_JsonIntent',
        'pagamento_Plataforma_JsonMethod',
        'pagamento_Plataforma_JsonSession',
        'pagamento_Status',
        'pagamento_UltimaAtualizacao',
        'pagamento_DataHora'
    ];
}

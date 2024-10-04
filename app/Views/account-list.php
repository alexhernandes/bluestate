<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>
<?php
$session = \Config\Services::session();
?>

<div class="conteudo__chamada" style="min-height: 100vh; padding-top: 120px">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="conteudo__chamada-texto conteudo__chamada-email">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Account.list.title'); ?></h1>
                    <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo lang('Account.list.subtitle'); ?></h2>

                    <div class="conteudo__account-list">

                        <?php
                        foreach ($contador as $item) {
                        ?>
                            <div class="conteudo__account-item">
                                <div class="conteudo__account-item-titulo" style="max-width: 400px;">
                                    <a href="<?php echo base_url("view/" . $item->contador_Slug); ?>" target="_blank">
                                        <?php echo $item->contador_Titulo; ?>
                                    </a>
                                </div>
                                <div class="conteudo__account-item-valor">
                                    <?php
                                    $moedas = [
                                        'BRL' => 'R$',
                                        'USD' => '$',
                                        'EUR' => '€'
                                    ];

                                    echo $moedas[$item->pagamento_Moeda] ?? $item->pagamento_Moeda;
                                    ?>
                                    <?php echo $item->pagamento_Valor; ?>
                                </div>
                                <div class="conteudo__account-item-link">
                                    <a href="<?php echo base_url("view/" . $item->contador_Slug); ?>" data-url="<?php echo base_url("view/" . $item->contador_Slug); ?>" class="item-url">
                                        <?php echo lang('Account.list.copy'); ?>
                                    </a>
                                </div>
                                <div class="conteudo__account-item-qrcode">
                                    <a href="<?php echo base_url("account/code/" . $item->contador_Slug); ?>" target="_blank">
                                        <img src="<?php echo "data:image/png;base64," . $item->contador_QRCode; ?>">
                                        <?php echo lang('Account.list.qrcode'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Seleciona todos os elementos com a classe .item-url
        const items = document.querySelectorAll('.item-url');

        // Adiciona o evento de clique em cada item
        items.forEach(function(item) {
            item.addEventListener('click', function(event) {
                // Previne o comportamento padrão do link (evita redirecionamento)
                event.preventDefault();

                // Obtém o valor do atributo data-url
                const url = item.getAttribute('data-url');

                // Cria um elemento temporário para copiar o texto
                const tempInput = document.createElement('input');
                document.body.appendChild(tempInput);
                tempInput.value = url;

                // Seleciona o texto e executa o comando de copiar
                tempInput.select();
                document.execCommand('copy');

                // Remove o elemento temporário
                document.body.removeChild(tempInput);

                // Alerta ou notifica que a URL foi copiada
                const checkIcon = document.createElement('span');
                checkIcon.innerHTML = ' ✔️'; // Emoji ou você pode usar um ícone de sua escolha
                item.appendChild(checkIcon);

                // Remove o ícone de checado após 5 segundos
                setTimeout(function() {
                    checkIcon.remove();
                }, 5000);
            });
        });
    });
</script>

<?php echo view("_baixo"); ?>
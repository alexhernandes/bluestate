<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>
<?php
$session = \Config\Services::session();
?>

<div class="conteudo__chamada">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <form action="<?php echo base_url(); ?>account/verify" method="POST">
                    <div class="conteudo__chamada-texto conteudo__chamada-email">
                        <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Account.email.title'); ?></h1>
                        <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo lang('Account.email.subtitle'); ?></h2>

                        <div class="conteudo__chamada-form animate__animated animate__fadeIn animate__slower">
                            <input type="email" id="email" name="email">
                            <button class="botao__enviar"><?php echo lang('Account.email.button'); ?></button>
                        </div>
                    </div>

                    <div class="conteudo__chamada-texto conteudo__chamada-code">
                        <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Account.code.title'); ?></h1>
                        <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo lang('Account.code.subtitle'); ?></h2>

                        <div class="conteudo__chamada-form animate__animated animate__fadeIn animate__slower">
                            <input type="number" id="code" name="code">
                            <button type="submit" class="botao__entrar"><?php echo lang('Account.code.button'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.botao__enviar').click(function(e) {
            e.preventDefault();

            var email = $('#email').val();

            if (email) {
                $.ajax({
                    url: '<?php echo base_url(); ?>account/send',
                    method: 'POST',
                    data: {
                        email: email
                    },
                    success: function(response) {
                        console.log('Email enviado com sucesso');
                        $('.conteudo__chamada-email').hide();
                        $('.conteudo__chamada-code').removeClass('conteudo__chamada-code'); // Exibe o código
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao enviar email:', error);
                    }
                });
            } else {
                alert('Por favor, insira um email válido.' + email);
            }
        });
    });
</script>

<?php echo view("_baixo"); ?>
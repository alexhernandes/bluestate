<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>

<div class="conteudo__chamada">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo__chamada-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Page.title'); ?></h1>
                    <p><a href="<?php echo base_url(); ?>page">paginasssssssss</a></p>


                    <div class="page__links">
                        <?php
                        echo '<h2>Informações do Servidor</h2>';
                        echo '<ul>';
                        echo '<li>Versão do PHP: ' . phpversion() . '</li>';
                        echo '<li>Software do Servidor: ' . $_SERVER['SERVER_SOFTWARE'] . '</li>';
                        echo '<li>Endereço IP: ' . $_SERVER['SERVER_ADDR'] . '</li>';
                        echo '<li>Nome do Host: ' . gethostname() . '</li>';
                        echo '</ul>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view("_baixo"); ?>
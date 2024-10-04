<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>

<div class="conteudo_view">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo__chamada-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo $page->pagina_Titulo; ?></h1>

                    <p class="page__links-view">
                        <?php echo $page->pagina_Conteudo; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view("_baixo"); ?>
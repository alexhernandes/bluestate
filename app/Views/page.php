<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>

<div class="conteudo__chamada">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo__chamada-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Page.title'); ?></h1>

                    <div class="page__links">
                        <?php foreach ($page as $item) { ?>
                            <a href="<?php echo base_url(); ?>page/view/<?php echo $item->pagina_Slug; ?>">
                                <i class="fa-solid fa-chevron-right"></i> <?php echo $item->pagina_Titulo; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view("_baixo"); ?>
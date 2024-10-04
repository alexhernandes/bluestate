<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>

<div class="conteudo__chamada">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo__chamada-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo $page_title; ?></h1>
                    <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo $page_subtitle; ?></h2>

                    <?php if ($page_url) { ?>
                        <p class="payment__link animate__animated animate__fadeIn animate__slow"><i class="fa-solid fa-arrow-right-from-bracket"></i> <?php echo $page_link; ?></p>
                        <p class="payment__linkurl animate__animated animate__fadeIn animate__slow conteudo__chamada-degrade">
                            <a href="<?php echo $page_url; ?>" target="_blank"><?php echo $page_url; ?></a>
                        </p>
                    <?php } ?>

                    <div class="conteudo__chamada-form animate__animated animate__fadeIn animate__slower">
                        <?php if ($page_button) { ?>
                            <a href="<?php echo $page_url; ?>"><?php echo $page_button; ?></a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="payment__qrcode">
                    <?php if ($page_qrcode) { ?>
                        <img src="<?php echo $page_qrcode; ?>" style="width: 300px;">
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view("_baixo"); ?>
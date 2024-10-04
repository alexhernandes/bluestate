<?php echo view("_topo"); ?>
<?php echo view("_menu"); ?>
<?php echo view("_modal"); ?>
<?php
$session = \Config\Services::session();

$backgrounds = [
    "https://toloov.com/assets/img/background.webp",
    "https://toloov.com/assets/img/background2.webp",
    "https://toloov.com/assets/img/background3.webp",
    "https://toloov.com/assets/img/background4.webp",
    "https://toloov.com/assets/img/background5.webp",
];

$random_background = $backgrounds[array_rand($backgrounds)];
?>

<div class="conteudo__chamada" style="--background-banner: url('<?php echo $random_background; ?>');">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="conteudo__chamada-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('Home.header.title'); ?></h1>
                    <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo lang('Home.header.subtitle'); ?></h2>

                    <div class="conteudo__chamada-img d-md-none">
                        <img src="<?php echo base_url(); ?>assets/img/iphone-<?php echo $session->get('lang'); ?>.webp">
                    </div>

                    <div class="conteudo__chamada-form animate__animated animate__fadeIn animate__slower">
                        <p><?php echo lang('Home.header.dateobj'); ?></p>
                        <input id="begin-date" type="date" max="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>">
                        <button class="botao__iniciar"><?php echo lang('Home.header.button'); ?></button>
                    </div>
                    <p class="link__exemplo"><?php echo lang('Modal.example'); ?> <a href="<?php echo lang('Modal.example_link'); ?>" target="_blank"><?php echo lang('Modal.example_link'); ?></a></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="conteudo__chamada-img">
                    <div class="d-none d-md-block">
                        <img src="<?php echo base_url(); ?>assets/img/iphone-<?php echo $session->get('lang'); ?>.webp">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="conteudo__depoimentos">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="conteudo__depoimentos-aleatorio">
                    <h3>~ <?php echo lang('Home.testimonials.last'); ?> ~</h3>
                    <p><?php echo lang('Home.testimonials.name'); ?></p>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="conteudo__depoimentos-confiados">
                    <div class="conteudo__depoimentos-confiados__fotos">
                        <ul>
                            <li><img src="https://i.pravatar.cc/300?u=54"></li>
                            <li><img src="https://i.pravatar.cc/300?u=55"></li>
                            <li><img src="https://i.pravatar.cc/300?u=15"></li>
                        </ul>
                    </div>
                    <div class="conteudo__depoimentos-confiados__texto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.84em" height="0.84em" viewBox="0 0 20 19">
                            <path
                                d="M11.333,16.6l6.18,3.73-1.64-7.03,5.46-4.73-7.19-.61-2.81-6.63-2.81,6.63-7.19.61,5.46,4.73-1.64,7.03Z"
                                transform="translate(-1.333 -1.333)" fill="currentColor" stroke="currentColor"
                                stroke-width="1"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.84em" height="0.84em" viewBox="0 0 20 19">
                            <path
                                d="M11.333,16.6l6.18,3.73-1.64-7.03,5.46-4.73-7.19-.61-2.81-6.63-2.81,6.63-7.19.61,5.46,4.73-1.64,7.03Z"
                                transform="translate(-1.333 -1.333)" fill="currentColor" stroke="currentColor"
                                stroke-width="1"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.84em" height="0.84em" viewBox="0 0 20 19">
                            <path
                                d="M11.333,16.6l6.18,3.73-1.64-7.03,5.46-4.73-7.19-.61-2.81-6.63-2.81,6.63-7.19.61,5.46,4.73-1.64,7.03Z"
                                transform="translate(-1.333 -1.333)" fill="currentColor" stroke="currentColor"
                                stroke-width="1"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.84em" height="0.84em" viewBox="0 0 20 19">
                            <path
                                d="M11.333,16.6l6.18,3.73-1.64-7.03,5.46-4.73-7.19-.61-2.81-6.63-2.81,6.63-7.19.61,5.46,4.73-1.64,7.03Z"
                                transform="translate(-1.333 -1.333)" fill="currentColor" stroke="currentColor"
                                stroke-width="1"></path>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="0.84em" height="0.84em" viewBox="0 0 20 19">
                            <path
                                d="M11.333,16.6l6.18,3.73-1.64-7.03,5.46-4.73-7.19-.61-2.81-6.63-2.81,6.63-7.19.61,5.46,4.73-1.64,7.03Z"
                                transform="translate(-1.333 -1.333)" fill="currentColor" stroke="currentColor"
                                stroke-width="1"></path>
                        </svg>
                        <p><?php echo lang('Home.testimonials.trusted'); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="conteudo__ads">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5333547331470568"
                    crossorigin="anonymous"></script>
                <!-- Depoimentos ads -->
                <ins class="adsbygoogle"
                    style="display:inline-block;width:728px;height:90px"
                    data-ad-client="ca-pub-5333547331470568"
                    data-ad-slot="3672787827"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>
</div>

<div class="conteudo__passos">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="conteudo__passos-titulo">
                    <h3><?php echo lang('Home.howitworks.title'); ?></h3>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="conteudo__passos-texto">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4><i class="fa-solid fa-plane"></i> <?php echo lang('Home.howitworks.travel.title'); ?></h4>
                            <p><?php echo lang('Home.howitworks.travel.description'); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4><i class="fa-solid fa-cart-shopping"></i> <?php echo lang('Home.howitworks.payment.title'); ?></h4>
                            <p><?php echo lang('Home.howitworks.payment.description'); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4><i class="fa-solid fa-qrcode"></i> <?php echo lang('Home.howitworks.send.title'); ?></h4>
                            <p><?php echo lang('Home.howitworks.send.description'); ?></p>
                        </div>
                        <div class="col-sm-6">
                            <h4><i class="fa-solid fa-lines-leaning"></i> <?php echo lang('Home.howitworks.tip.title'); ?></h4>
                            <p><?php echo lang('Home.howitworks.tip.description'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <iframe width="100%" height="315"
                    src="https://www.youtube.com/embed/1W2xT19lrcU?si=xxALQHgBhM7WqDlq" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<div class="conteudo__perguntas">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="conteudo__perguntas-titulo">
                    <h3><?php echo lang('Home.questions.title'); ?></h3>
                </div>
            </div>
            <div class="col-12">
                <div class="conteudo__perguntas-bloco">

                    <?php
                    $items = lang('Faq.faq');

                    if (is_array($items)) {
                        foreach ($items as $item) {
                    ?>
                            <div class="conteudo__perguntas-bloco__pergunta">
                                <h4><?php echo $item['title']; ?></h4>
                                <p><?php echo $item['answer']; ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "Não há itens disponíveis.";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php echo view("_baixo"); ?>
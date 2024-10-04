<?php echo view("_topo"); ?>
<div class="view__menu">
    <?php echo view("_menu"); ?>
</div>

<div class="conteudo_view">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo_view-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo $titulo; ?></h1>

                    <div class="d-none d-lg-block">
                        <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo $contador->contador_Titulo; ?></h2>
                        <p class="view__desktop-description animate__animated animate__fadeIn animate__slow"><?php echo nl2br($contador->contador_Descricao); ?> 🚀✈️🎰🌆🍀</p>

                        <?php
                        if (!$passed) {
                        ?>
                            <div class="view__precisionclock">
                                <h3><?php echo lang("View.precisely"); ?></h3>
                                <p id="tempoRestante">0 anos, 1 meses, 17 dias, 1 horas, 10 minutos e 26 segundos</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="view__image animate__animated animate__fadeIn" style="animation-delay: 0.8s;">
                    <?php
                    if ($foto) {
                        foreach ($foto as $item) {
                            echo '<img src="' . base_url($item->foto_Completo) . '" style="max-width: 416px;">';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="d-lg-none">
                    <h2 class="animate__animated animate__fadeIn animate__slow"><?php echo $contador->contador_Titulo; ?></h2>
                    <p class="view__desktop-description animate__animated animate__fadeIn animate__slow"><?php echo nl2br($contador->contador_Descricao); ?> 🚀✈️🎰🌆🍀</p>

                    <?php
                    if (!$passed) {
                    ?>
                        <div class="view__precisionclock">
                            <h3><?php echo lang("View.precisely"); ?></h3>
                            <p id="tempoRestante">0 anos, 1 meses, 17 dias, 1 horas, 10 minutos e 26 segundos</p>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="conteudo_view-itinerary">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="conteudo_view-texto">
                    <h1 class="animate__animated animate__fadeIn animate__fast"><?php echo lang('View.itinerary'); ?></h1>

                    <p>
                        <?php echo nl2br($contador->contador_Itinerario); ?>
                    </p>
                </div>
            </div>
            <div class="col-lg-4">
                <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5333547331470568"
                    crossorigin="anonymous"></script>
                <!-- View interna -->
                <ins class="adsbygoogle"
                    style="display:block"
                    data-ad-client="ca-pub-5333547331470568"
                    data-ad-slot="8338156684"
                    data-ad-format="auto"
                    data-full-width-responsive="true"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            </div>
        </div>
    </div>
</div>

<div class="conteudo__chamada"></div>

<script>
    const images = document.querySelectorAll('.view__image img');
    let currentIndex = 0;

    // Função para esconder todas as imagens
    function hideAllImages() {
        images.forEach(img => {
            img.style.opacity = '0'; // Deixa todas invisíveis
            img.style.transition = 'opacity 1s ease-in-out'; // Define a transição suave
        });
    }

    // Função para mostrar a próxima imagem
    function showNextImage() {
        hideAllImages(); // Primeiro, esconde todas
        currentIndex = (currentIndex + 1) % images.length; // Vai para a próxima imagem
        images[currentIndex].style.opacity = '1'; // Mostra a próxima imagem
    }

    // Inicia a rotação, trocando as imagens a cada 3 segundos
    setInterval(showNextImage, 3000);

    // Mostra a primeira imagem ao carregar a página
    images[currentIndex].style.opacity = '1';

    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var viewMenu = document.querySelector('.view__menu');
            if (viewMenu) {
                viewMenu.style.display = 'block'; // Mostra a div
            }
        }, 2500); // 2.5 segundos
    });
</script>

<script>
    // Recebe a data e hora alvo (vinda do PHP)

    var dataHoraAlvo = new Date("<?php echo $contador->contador_DataObjetivo . 'T' . $contador->contador_HoraObjetivo; ?>");

    function calcularTempoRestante() {
        // Data e hora atual
        var agora = new Date();

        // Cálculo da diferença de tempo
        var diff = dataHoraAlvo - agora;

        if (diff <= 0) {
            document.getElementById("tempoRestante").innerHTML = `<?php echo lang('View.passed'); ?>`;
            return;
        }

        // Calcular os componentes do tempo restante
        var segundos = Math.floor(diff / 1000);
        var minutos = Math.floor(segundos / 60);
        var horas = Math.floor(minutos / 60);
        var dias = Math.floor(horas / 24);
        var meses = Math.floor(dias / 30); // Aproximado
        var anos = Math.floor(meses / 12);

        // Ajustar os valores após dividir
        meses = meses % 12;
        dias = dias % 30;
        horas = horas % 24;
        minutos = minutos % 60;
        segundos = segundos % 60;

        // Construir a string com a lógica de pluralização e traduções
        var tempoRestante = "";

        if (anos > 0) {
            tempoRestante += anos + " <?php echo lang('View.year'); ?>" + (anos !== 1 ? 's' : '') + ", ";
        }
        if (meses > 0) {
            tempoRestante += meses + " <?php echo lang('View.month'); ?>" + (meses !== 1 ? 'es' : '') + ", ";
        }
        if (dias > 0) {
            tempoRestante += dias + " <?php echo lang('View.day'); ?>" + (dias !== 1 ? 's' : '') + ", ";
        }
        if (horas > 0) {
            tempoRestante += horas + " <?php echo lang('View.hour'); ?>" + (horas !== 1 ? 's' : '') + ", ";
        }
        if (minutos > 0) {
            tempoRestante += minutos + " <?php echo lang('View.minute'); ?>" + (minutos !== 1 ? 's' : '') + " e ";
        }
        if (segundos > 0) {
            tempoRestante += segundos + " <?php echo lang('View.second'); ?>" + (segundos !== 1 ? 's' : '');
        }

        // Remover a última vírgula e espaço, se existir
        tempoRestante = tempoRestante.replace(/, $/, '');

        // Exibir o tempo restante no elemento com id "tempoRestante"
        document.getElementById("tempoRestante").innerHTML = tempoRestante;
    }

    // Atualizar o tempo restante a cada segundo
    setInterval(calcularTempoRestante, 1000);
</script>



<?php echo view("_baixo"); ?>
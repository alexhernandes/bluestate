<form id="form" action="<?php echo base_url(); ?>checkout" method="POST" enctype="multipart/form-data">
    <div class=" modal__formulario">
        <div class="modal__formulario-conteudo">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <h1><?php echo lang('Modal.title'); ?></h1>
                    </div>

                    <div class="col-lg-4">
                        <div class="modal__formulario-upload__container">
                            <div class="modal__formulario-upload animate__animated animate__fadeIn animate__slower"
                                id="upload-area" onclick="document.getElementById('file-input').click()">
                                <div><?php echo lang('Modal.photo'); ?></div>
                                <input type="file" id="file-input" name="photo[]" multiple accept="image/*" required style="display: none;"
                                    onchange="previewImages()">
                                <div id="image-preview" class="modal__formulario-preview"><!-- Previews will appear here --></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="modal__formulario-form animate__animated animate__fadeIn animate__slower">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: 0.5s;">
                                        <div class="modal__formulario-form__field">
                                            <label><?php echo lang('Modal.form.travel'); ?></label>
                                            <input id="begin-time" name="time" type="time" value="00:01" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: 0.7s;">
                                        <div class="modal__formulario-form__field">
                                            <label><?php echo lang('Modal.form.mail'); ?></label>
                                            <input id="email" name="email" type="email" autocomplete="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: 0.9s;">
                                        <div class="modal__formulario-form__field">
                                            <label><?php echo lang('Modal.form.title'); ?></label>
                                            <input id="titulo" name="titulo" type="text" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: 1.1s;">
                                        <div class="modal__formulario-form__field">
                                            <label><?php echo lang('Modal.form.plan.title'); ?></label>
                                            <select name="plan" required>
                                                <?php
                                                $options = lang('Modal.form.plan.option');

                                                foreach ($options as $option) {
                                                    echo '<option value="' . $option["value"] . '">' . $option["title"] . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="animate__animated animate__fadeIn" style="animation-delay: 1.3s;">
                                        <div class="modal__formulario-form__field">
                                            <label><?php echo lang('Modal.form.description'); ?></label>
                                            <textarea id="descricao" name="description" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div
                            class="modal__formulario-form modal__formulario-formSubmit animate__animated animate__fadeIn animate__slower">
                            <div class="row">
                                <div class="col-lg-4">
                                    <p class="link__exemplo"><?php echo lang('Modal.example'); ?> <a href="<?php echo lang('Modal.example_link'); ?>" target="_blank"><?php echo lang('Modal.example_link'); ?></a></p>
                                </div>
                                <div class="col-lg-8">
                                    <div class="formulario__aviso">
                                        <div class="formulario__submeter-aviso">
                                            <p class="formulario__campos-aviso">
                                                <?php echo lang('Modal.warning'); ?>
                                            </p>
                                            <div
                                                class="conteudo__chamada-pagamentos conteudo__chamada-pagamentosI animate__animated animate__fadeIn">
                                                <i class="fa-brands fa-cc-mastercard"></i>
                                                <i class="fa-brands fa-cc-visa"></i>
                                                <i class="fa-brands fa-cc-diners-club"></i>
                                                <i class="fa-brands fa-cc-amex"></i>
                                                <i class="fa-brands fa-pix"></i>
                                                <i class="fa-brands fa-cc-stripe"></i>
                                            </div>
                                        </div>

                                        <div class="formulario__submeter-botao">
                                            <input type="hidden" id="date" name="date">
                                            <button type="submit"><?php echo lang('Modal.button'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal__formulario-close"><i class="fa-solid fa-xmark"></i></div>
    </div>
</form>

<style>

</style>
<script>
    $(document).ready(function() {
        $.extend($.validator.messages, {
            required: "<?php echo lang('Validation.required'); ?>",
            email: "<?php echo lang('Validation.email'); ?>",
            url: "<?php echo lang('Validation.url'); ?>",
            number: "<?php echo lang('Validation.number'); ?>",
            digits: "<?php echo lang('Validation.digits'); ?>",
            equalTo: "<?php echo lang('Validation.equalTo'); ?>",
            maxlength: $.validator.format("<?php echo lang('Validation.maxlength'); ?>"),
            minlength: $.validator.format("<?php echo lang('Validation.minlength'); ?>"),
            rangelength: $.validator.format("<?php echo lang('Validation.rangelength'); ?>"),
            range: $.validator.format("<?php echo lang('Validation.range'); ?>"),
            max: $.validator.format("<?php echo lang('Validation.max'); ?>"),
            min: $.validator.format("<?php echo lang('Validation.min'); ?>")
        });

        $("#form").validate();


        // Verificação de imagens antes de submeter o formulário
        $("#form").on('submit', function(e) {
            var fileInput = $('#file-input')[0];
            if (fileInput.files.length === 0) {
                e.preventDefault(); // Impede o envio do formulário
                alert("<?php echo lang('Validation.selectImage'); ?>"); // Exibe o alerta
                return false;
            } else {
                $(".formulario__submeter-botao button").prop("disabled", true);
                $(".formulario__submeter-botao button").css({
                    backgroundColor: '#CCCCCC'
                });
                $(".formulario__submeter-botao button").html("Aguarde...");
            }
        });
    });
</script>
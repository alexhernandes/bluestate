<div class="rodape">
    <div class="container">
        <div class="row">
            <div class="col-md-6">toloov</div>
            <div class="col-md-6">©2024 toloov - Todos os direitos reservados</div>
        </div>
    </div>
</div>

<script>
    function previewImages() {
        const fileInput = document.getElementById('file-input');
        const imagePreview = document.getElementById('image-preview');

        imagePreview.innerHTML = '';

        const files = fileInput.files;
        if (files.length > 10) {
            alert('Você só pode selecionar até 10 imagens.');
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    const imgElement = document.createElement('img');
                    imgElement.src = e.target.result;
                    imagePreview.appendChild(imgElement);
                }

                reader.readAsDataURL(file);
            } else {
                alert('Por favor, selecione apenas arquivos de imagem.');
            }
        }
    }

    document.querySelector('.botao__iniciar').addEventListener('click', function() {
        document.querySelector('.modal__formulario').style.display = 'flex';
        document.body.style.overflow = 'hidden';

        let dateValue = document.querySelector('#begin-date').value;
        let formattedDate = formatDate(dateValue);

        document.querySelector('.modal__formulario-data').textContent = formattedDate;
        document.querySelector('#date').value = dateValue;
    });

    document.querySelector('.modal__formulario-close').addEventListener('click', function() {
        document.querySelector('.modal__formulario').style.display = 'none';
        document.body.style.overflow = '';
    });

    document.querySelector('#begin-date').addEventListener('change', function() {
        let dateValue = this.value;
        let formattedDate = formatDate(dateValue);

        document.querySelector('.modal__formulario-data').textContent = formattedDate;
    });

    document.querySelector('#begin-date').addEventListener('blur', function() {
        let dateValue = this.value;
        let formattedDate = formatDate(dateValue);

        document.querySelector('.modal__formulario-data').textContent = formattedDate;
    });

    function formatDate(dateValue) {
        if (dateValue) {
            let [year, month, day] = dateValue.split('-');
            let date = new Date(year, month - 1, day);
            return date.toLocaleDateString(navigator.language, {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        return '';
    }

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
    });
</script>

</body>

</html>
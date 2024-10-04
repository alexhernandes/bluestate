<?php
return [
    "title" => 'Más <span class="modal__formulario-degrade">detalles</span> sobre el día <span class="modal__formulario-degrade modal__formulario-data">14 de agosto de 2024</span>',
    "photo" => 'Elige fotos de ustedes juntos',
    "warning" => 'Podrás editar todos estos datos más tarde. Al hacer clic en el botón, aceptas todos los <a href="' . base_url("/page") . '" target="_blank">términos de uso</a>, la <a href="' . base_url("/page") . '" target="_blank">política de privacidad</a>, y la <a href="' . base_url("/page") . '" target="_blank">política de reembolso</a>.',
    "button" => 'Continuar',
    'form' => [
        "travel" => '¿A qué hora empezaron ustedes?',
        "mail" => '¿Cuál es tu correo electrónico?',
        "title" => 'Denle un título a su relación',
        "plan" => [
            "title" => 'Elige un plan',
            "option" => [
                [
                    "title" => 'Hasta la fecha del viaje (R$ 19.90 - 3 fotos)',
                    "value" => 'plan1',
                    "money" => '19.90',
                    "currency" => 'BRL',
                ],
                [
                    "title" => 'Por 1 año, con mini álbum de fotos (R$ 34.90 - 6 fotos)',
                    "value" => 'plan2',
                    "money" => '34.90',
                    "currency" => 'BRL',
                ],
                [
                    "title" => 'Para siempre, con álbum completo (R$ 54.90 - 10 fotos)',
                    "value" => 'plan3',
                    "money" => '54.90',
                    "currency" => 'BRL',
                ],
            ],
        ],
        "description" => 'Escribe una descripción sobre ustedes',
    ],
    'example' => 'Mira un ejemplo aquí:',
    'example_link' => 'https://toloov.com/view/ZSAJBQ',
];
<?php
return [
    "title" => 'Mais <span class="modal__formulario-degrade">detalhes</span> sobre o dia <span class="modal__formulario-degrade modal__formulario-data">August 14, 2024</span>',
    "photo" => 'Escolha fotos de vocês',
    "warning" => 'Você pode editar novamente todos esses dados depois. Ao clicar no botão você concorda com todos os <a href="' . base_url("/page") . '" target="_blank">termos de uso</a>, <a href="' . base_url("/page") . '" target="_blank">politica de privacidade</a>, <a href="' . base_url("/page") . '" target="_blank">politica de devolução</a>.',
    "button" => 'Continuar',
    'form' => [
        "travel" => 'Que horas vocês começaram?',
        "mail" => 'Qual o seu e-mail?',
        "title" => 'De um titulo para vocês',
        "plan" => [
            "title" => 'Escolha um plano',
            "option" => [
                [
                    "title" => 'Até a data da viagem (R$ 19,90 - 3 fotos)',
                    "value" => 'plan1',
                    "money" => '19.90',
                    "currency" => 'BRL',
                ],
                [
                    "title" => 'Durante 1 ano, com mini album de fotos (R$ 34,90 - 6 fotos)',
                    "value" => 'plan2',
                    "money" => '34.90',
                    "currency" => 'BRL',
                ],
                [
                    "title" => 'Para sempre, com album de fotos (R$ 54,90 - 10 fotos)',
                    "value" => 'plan3',
                    "money" => '54.90',
                    "currency" => 'BRL',
                ],
            ],
        ],
        "description" => 'Escreva uma descrição sobre vocês',
    ],
    'example' => 'Veja aqui um exemplo:',
    'example_link' => 'https://toloov.com/view/ZSAJBQ',
];
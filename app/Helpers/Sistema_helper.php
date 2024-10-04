
<?php
function enviar_email($dados)
{
    if($dados){
        $email = \Config\Services::email();

        $config['protocol']   = 'smtp';
        $config['SMTPHost']   = "smtp.daru.com.br";
        $config['SMTPUser']   = "sos@daru.com.br";
        $config['SMTPPass']   = "P@5e5n9a2";
        $config['SMTPPort']   = 465;
        $config['SMTPCrypto'] = "ssl";
        $config['mailType']   = 'html';
        $config['charset']    = 'utf-8';
        $config['newline']    = "\r\n";
        $email->initialize($config);

        $email->setFrom('contato@rank2gg.com', 'Rank2GG');
        $email->setTo($dados["to"]);
        $email->setSubject($dados["titulo"]);
        $email->setMessage($dados["msg"]);
        $email->send();
    }
}

function unicoId()
{
    $id = mt_rand(1000000, 9999999);
    return $id;
}

function gerarId($length = 6)
{
    $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Letras maiúsculas e números
    $id = '';

    for ($i = 0; $i < $length; $i++) {
        $id .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $id;
}
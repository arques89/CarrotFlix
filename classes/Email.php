<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{
    protected $email;
    protected $name;
    protected $surname;
    protected $token;

    public function __construct($email, $name, $surname, $token)
    {
        $this->email = $email;
        $this->name = $name;
        $this->surname = $surname;
        $this->token = $token;
    }

    public function sendConfirmation()
    {
        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@carrotflix.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Confirma tu Cuenta';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= '<p><strong>Hola ' . $this->name . ' ' . $this->surname . ',';
        $content .= '</strong> has registrado correctamente tu cuenta pero es necesario confirmarla.</p>';
        $content .= "<p>Presiona en <a href='" . $_ENV['HOST'] . '/confirm-account?token=' . $this->token . "'>Confirmar Cuenta</a></p>";
        $content .= '<p>Si no has creado esta cuenta, puedes ignorar el mensaje.</p>';
        $content .= '<p>Detalles de la cuenta:</p>';
        $content .= '<ul>';
        $content .= '<li>Nombre: ' . $this->name . ' ' . $this->surname . '</li>';
        $content .= '<li>Correo electrónico: ' . $this->email . '</li>';
        $content .= '</ul>';
        $content .= '<p>Estamos emocionados de tenerte con nosotros. Para comenzar a disfrutar de todos nuestros servicios, simplemente inicia sesión con tu nombre de usuario y la contraseña que elegiste durante el registro.</p>';
        $content .= '<p>Si tienes alguna pregunta o necesitas ayuda, no dudes en ponerte en contacto con nuestro equipo de soporte a través de <a href="mailto:help@carrotflix.com">help@carrotflix.com</a>.</p>';
        $content .= '<p>Atentamente,</p>';
        $content .= '<p>Equipo de CarrotFlix S.L.</p>';
        $content .= '</html>';

        $mail->Body = $content;

        // Enviar el mail
        $mail->send();
    }

    public function sendInstructions()
    {
        // create a new object
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASS'];

        $mail->setFrom('cuentas@carrotflix.com');
        $mail->addAddress($this->email, $this->name);
        $mail->Subject = 'Reestablece tu password';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $content = '<html>';
        $content .= '<p><strong>Hola ' . $this->name . '</strong> has solicitado restablecer tu password, sigue el siguiente enlace para hacerlo.</p>';
        $content .= "<p>Presiona aquí: <a href='" . $_ENV['HOST'] . '/restablecer?token=' . $this->token . "'>Restablecer Password</a>";
        $content .= '<p>Si tu no solicitaste este cambio, puedes ignorar el mensaje</p>';
        $content .= '</html>';
        $mail->Body = $content;

        // Enviar el mail
        $mail->send();
    }
}

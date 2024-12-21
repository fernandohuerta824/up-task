<?php

namespace Class;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public string $nombre;
    public string $email;
    public string $token;

    public function __construct($args = []) {
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->token = $args['token'] ?? '';
    }

    private function enviarEmail(string $asunto, string $contenido) {
        $phpmailer = new PHPMailer();
        $phpmailer->isSMTP();
        $phpmailer->Host = $_ENV['EMAIL_HOST'];
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = $_ENV['EMAIL_PORT'];
        $phpmailer->Username = $_ENV['EMAIL_USER'];
        $phpmailer->Password = $_ENV['EMAIL_PASSWORD']; 

        $phpmailer->setFrom('uptaks@gmail.com');
        $phpmailer->addAddress($this->email, $this->nombre);

        $phpmailer->Subject = $asunto;
        $phpmailer->isHTML(true);
        $phpmailer->CharSet = 'UTF-8';
        $contenido = $contenido;

        $phpmailer->Body = $contenido;
        $phpmailer->send();
    }

    public function enviarConfirmacion() {
        $this->enviarEmail('Confirma cuenta', "
            <html>
            
            <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;'>

                <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
                    <h1 style='background: linear-gradient(to right, #F59E0B 0%, #ffbf47 100%); color: transparent; background-clip: text; -webkit-background-clip: text; font-size: 3rem; text-align: center; margin-top: 20px;'>
                        UpTask
                    </h1>
                    <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                        Hola <strong> " . s($this->nombre) .  "</strong>
                    </p>
                    <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                        Para confirmar tu cuenta, presiona el siguiente enlace:
                    </p>
                    <a href='" . $_ENV['SERVER_HOST'] .  "/confirmar?token=" . s($this->token) . "' 
                    style='display: inline-block; background-color: #F59E0B; color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 1.5rem; border-radius: 5px; text-align: center; margin: 20px 0;'>
                        Confirmar cuenta
                    </a>
                    <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                        Si no solicitaste esta cuenta, ignora este correo.
                    </p>
                </div>

            </div>
            </html>

        ");
    }

    public function enviarRestablecerPassword() {
        $this->enviarEmail('Restablecer contraseña', "
        <html>
        <div style='font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;'>

            <div style='max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
                <h1 style='background: linear-gradient(to right, #DB2777 0%, #f05aab 100%); color: transparent; background-clip: text; -webkit-background-clip: text; font-size: 3rem; text-align: center; margin-top: 20px;'>
                    UpTask
                </h1>
                <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                    Hola <strong>" . s($this->nombre) . "</strong>
                </p>
                <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                    Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para proceder:
                </p>
                <a href='" . $_ENV['SERVER_HOST'] .  "/restablecer-password?token=" . s($this->token) . "' 
                style='display: inline-block; background-color: #DB2777; color: #ffffff; text-decoration: none; padding: 10px 20px; font-size: 1.5rem; border-radius: 5px; text-align: center; margin: 20px 0;'>
                    Restablecer Contraseña
                </a>
                <p style='font-size: 1.5rem; color: #6b7280; line-height: 1.8;'>
                    Si no solicitaste restablecer tu contraseña, ignora este correo.
                </p>
            </div>

        </div>
        </html>
        ");
    }
}
<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token){
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    /**** Enviar Confirmacion al E-mail para Crear una Cuenta ****/

    public function Enviar_Confirmacion(){

        //Crear una nueva instancia de PHP Mailer 
        $mail = new PHPMailer();
        //Configurar SMTP //Protocolo para Envio de Mails 
        $mail->isSMTP(); //Le indicamos que vamos a utilizar el protocolo SMTP
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true; //Le concedemos permisos para utilizar SMTP
        $mail->Username = 'd96fd42679533b';
        $mail->Password = '3c9fe1a15d9c55';
        $mail->SMTPSecure = 'tls'; //Se envia los mails a traves de un tunel seguro
        $mail->Port = 465;

        //Configurar el Contenido del Mail
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu Cuenta';

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //Definir el Contenido del Mail
        $contenido = '<html>';
        $contenido .= '<p>Confirma Tu Cuenta Ahora</p>';
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has creado tu Cuenta en Nuestra App, Solo debes Confirmarla Presionando el Siguiente Enlace</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste Crear esta Cuenta Ignora este Mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        //Enviar el Email
        $mail->send();
    }

    /**** Enviar Confirmacion al E-mail para Reestablecer Password ****/

    public function Enviar_Instrucciones(){
        
        //Crear una nueva instancia de PHP Mailer 
        $mail = new PHPMailer();
        //Configurar SMTP //Protocolo para Envio de Mails 
        $mail->isSMTP(); //Le indicamos que vamos a utilizar el protocolo SMTP
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true; //Le concedemos permisos para utilizar SMTP
        $mail->Username = 'd96fd42679533b';
        $mail->Password = '3c9fe1a15d9c55';
        $mail->SMTPSecure = 'tls'; //Se envia los mails a traves de un tunel seguro
        $mail->Port = 465;

        //Configurar el Contenido del Mail
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Reestablece Tu Contraseña';

        //Habilitar HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        //Definir el Contenido del Mail
        $contenido = '<html>';
        $contenido .= '<p>Confirma Tu Cuenta Ahora</p>';
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has Solicitado Reestablecer Tu Contraseña usa el siguiente Enlace para Reestablecerla</p>";
        $contenido .= "<p>Presiona aquí: <a href='http://127.0.0.1:3000/recuperar?token=" . $this->token . "'>Reestablecer Contraseña</a></p>";
        $contenido .= "<p>Si tu no solicitaste Reestablecer tu Constraseña Ignora este Mensaje</p>";
        $contenido .= "</html>";
     
        $mail->Body = $contenido;
     
        //Enviar el Email
        $mail->send();

    }
}

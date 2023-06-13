<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{ //Controlador

    //Autenticacion
    public static function login(Router $router){

        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $usuario_auth = new Usuario($_POST);

            $alertas = $usuario_auth->validar_login(); //Validamos que Ingrese los Datos de Login

            if(empty($alertas)){ //Significa que agrego tanto e-mail como password

                //Comprobar que exista el Usuario
                $email_busqueda = $usuario_auth->email;

                $usuario = Usuario::find_specific('email',$email_busqueda);

                if($usuario){ //Si el Usuario Existe en Nuestra BD 

                    //Verificar el Password
                    if($usuario->Comprobar_Password_Verificacion_Email($usuario_auth->password)){ //Darle acceso al Usuario todo es Correcto

                        //Autenticar al Usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                       

                        //Redireccionamiento
                        if($usuario->admin == '1'){ //Usuario Admin

                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                            
                        }else{ //Usuario Normal

                            header('Location: /cita');
                        }

 
                    }else{
                        $usuario_auth->setAlerta('error','Su Password es Incorrecto o no ha sido Confirmado');
                    }

                }else{
                    $usuario_auth->setAlerta('error','No existe el Usuario');
                }

            }
        }

        $alertas = Usuario::getAlertas();


        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }


    //Crear Nuevo Usuario
    public static function crear(Router $router){

        $usuario = new Usuario();
        
        //Alertas Vacias
        $alertas = [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){

           $usuario->sincronizar($_POST);
           $alertas = $usuario->Validar_Nueva_Cuenta(); //Alertas Llenas
           
            //Revisar que alertas este Vacio
            if(empty($alertas)){
                //Verificar que el usuario no este registrado
                $resultado = $usuario->Existe_Usuario();
               
                if($resultado->num_rows){ //Si existe el usuario entonces Mostramos Un Mensaje de Existencia

                    $alertas = $usuario->getAlertas();

                }else{
                //No esta Registrado - Permitir la creacion de la Cuenta 
                
                    //Hashear la Contraseña
                    $usuario->Hash_Password();

                    //Generar un Token Unico (Seguridad Email)
                    $usuario->Generar_Token();
                    
                    //E-mail de Confirmacion
                    $email = new Email($usuario->email,$usuario->nombre,$usuario->token); //Enviamos del Objeto los datos Necesarios para la Confirmacion de E-mail
                    $email->Enviar_Confirmacion();

                    //Crear el Usuario
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }

                }
            }

        }

        $router->render('auth/crear-cuenta',[
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);

    }

    //Mensaje de Creacion de Cuenta 
    public static function mensaje(Router $router){

        $router->render('auth/mensaje',[

        ]);
    }

    //Confirmacion de la Cuenta por medio de un Token
    public static function confirmar(Router $router){

        $alertas = [];

        $token = s($_GET['token']); //Retorna un String del Token deseado a Buscar

        $usuario = Usuario::find_specific('token', $token); //Retorna el Objeto Encontrado

        if(empty($usuario) || $usuario->token === ''){ //Si no Existe el Usuario // Significa que no encontro al Usuario

           //Mostrar Mensaje de Error 
            Usuario::setAlerta('error','Token NO Valido');

        }else{ //Si el token es Correcto / Es decir ingreso a la confirmacion del email

            //Modificar a usuario confirmado
            $usuario->confirmado = "1";

            //Eliminamos el Token Existente ya el usuario ha sido Confirmado
            $usuario->token = '';

            //Actualizar los datos del usuario
            $usuario->guardar();
            Usuario::setAlerta('exito','Cuenta Comprobada Correctamente');
        }

        $alertas = Usuario::getAlertas();

        //Renderizar la Vista
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }

    //Olvide mi Contraseña
    public static function olvide(Router $router){

        $alertas =  [];

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            $usuario_auth = new Usuario($_POST);
            $alertas = $usuario_auth->validar_email();

            if(empty($alertas)){ //Si no Existe Errores Ingreso su Email

                //Buscamos al Usuario dentro de nuestra BD
                $email_busqueda = $usuario_auth->email;
      
                $usuario = Usuario::find_specific('email',$email_busqueda);

                if($usuario && $usuario->confirmado == '1'){ //Debe pasar por las siguientes reglas = Si el usuario existe en la BD y que se Encuentre Confirmado Su token
                    
                    //Generar un Nuevo Token de un Solo Uso
                    $usuario->Generar_Token();
                    $usuario->guardar();

                    //Enviar el E-mail
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->Enviar_Instrucciones();

                    //Enviar el E-mail
                    Usuario::setAlerta('exito','Revisa tu E-mail con el Codigo de Confirmacion');

                }else{
                    Usuario::setAlerta('error','El usuario No existe o No esta Confirmado su E-mail');
                }
            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password',[
            'alertas' => $alertas
        ]);

    }

    public static function recuperar(Router $router){

        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        //Buscar Usuario por su Token
 
        $usuario = Usuario::find_specific('token',$token);
 
        if(empty($usuario)){ //Si no existe un Usuario con el Token Valido Entonces
            Usuario::setAlerta('error','Token NO Valido');
            $error = true;
        }

        if($_SERVER["REQUEST_METHOD"] == "POST"){

            //Leer el Nuevo password y guardarlo
            $usuario_pass_new = new Usuario($_POST);
            $alertas = $usuario_pass_new -> validar_password();

            if(empty($alertas)){ //Si no existe Ninguna Alerta
                //Vaciamos la Antigua Contraseña
                $usuario->password = null;

                //Asignamos la Nueva Contraseña
                $usuario->password = $usuario_pass_new->password;

                //Hashear el Password Nuevo
                $usuario->Hash_Password(); //Coge la Nueva Contra Actualizada y la Hashea

                //Vaciamos el Token es de un solo uso
                $usuario->token = null;

                //Guardamos el Nuevo Usuario con su Nueva Contraseña 
                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location: /');
                }

            }

        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/recuperar-password',[
            'alertas' => $alertas,
            'error' => $error
        ]);
    }



    public static function logout(){
        // session_start();

        $_SESSION = [];

        header('Location: /');
    }




}
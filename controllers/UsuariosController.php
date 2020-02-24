<?php

namespace app\controllers;

use app\models\Usuarios;
use Yii;
use yii\bootstrap4\Alert;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\models\RecuperarPassForm;
use app\models\ResetearPassForm;

class UsuariosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['registrar'],
                'rules' => [
                    // allow authenticated Usuarios
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    // everything else is denied by default
                ],
            ],
        ];
    }


    public function actionRegistrar()
    {
        $model = new Usuarios(['scenario' => Usuarios::SCENARIO_CREAR]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $url = Url::to([
                'usuarios/activar',
                'id' => $model->id,
                'token' => $model->token,
            ], true);

            $body = "<h2>Haz clic en el enlace para validar su email:</h2>
            <a href=\"$url\">Validar usuario</a>";

            if (Usuarios::enviarMail($body, $model->email, 'Activar usuario')) {
                Yii::$app->session->setFlash('success', 'Por favor verifique su email.');
            }else{
                Yii::$app->session->setFlash('error', 'Ha ocurrido un error, contacte con el admin del sitio web.');
            }
            return $this->redirect(['site/login']);
        }

        return $this->render('registrar', [
            'model' => $model,
        ]);
    }

    public function actionRecuperarpass()
    {
     //Instancia para validar el formulario
     $model = new RecuperarPassForm;
     
     //Mensaje que será mostrado al usuario en la vista
     $msg = null;
     
     if ($model->load(Yii::$app->request->post()))
     {
      if ($model->validate())
      {
       //Buscar al usuario a través del email
       $table = Usuarios::find()->where("email=:email", [":email" => $model->email]);
       
       //Si el usuario existe
       if ($table->count() == 1)
       {
        //Crear variables de sesión para limitar el tiempo de restablecido del password
        //hasta que el navegador se cierre
        $session = new Session;
        $session->open();
        
        //Esta clave aleatoria se cargará en un campo oculto del formulario de reseteado
        $session["recover"] = $this->randKey("abcdef0123456789", 200);
        $recover = $session["recover"];
        
        //También almacenaremos el id del usuario en una variable de sesión
        //El id del usuario es requerido para generar la consulta a la tabla Usuarios y 
        //restablecer el password del usuario
        $table = Usuarios::find()->where("email=:email", [":email" => $model->email])->one();
        $session["id_recover"] = $table->id;
        
        //Esta variable contiene un número hexadecimal que será enviado en el correo al usuario 
        //para que lo introduzca en un campo del formulario de reseteado
        //Es guardada en el registro correspondiente de la tabla Usuarios
        $verification_code = $this->randKey("abcdef0123456789", 8);
        //Columna verification_code
        $table->codigo_verificacion = $verification_code;
        //Guardamos los cambios en la tabla Usuarios
        $table->save();
        
        //Creamos el mensaje que será enviado a la cuenta de correo del usuario
        $url = Url::to([
            'usuarios/resetearpass',
        ], true);
        $body = "<h2>Copie el siguiente código de verificación: <strong>".$verification_code."</strong></p></h2>
            <a href=\"$url\">Validar usuario</a>";

        if (Usuarios::enviarMail($body, $model->email, 'Recuperar contraseña')) {
            Yii::$app->session->setFlash('success', 'Le hemos enviado un mensaje a email para resetear su password.');
        }else{
            Yii::$app->session->setFlash('error', 'Ha ocurrido un error, contacte con el admin del sitio web.');
        }
        
        //Vaciar el campo del formulario
        $model->email = null;
       }
       else //El usuario no existe
       {
        Yii::$app->session->setFlash('error', 'El correo no esta en nuestra BD.');
    }
      }
      else
      {
       $model->getErrors();
      }
     }
     return $this->render("recuperarpass", ["model" => $model, "msg" => $msg]);
    }
    
    public function actionResetearpass() //Borrar $smg si no es necesario.
    {
     //Instancia para validar el formulario
     $model = new ResetearPassForm;
     
     //Mensaje que será mostrado al usuario
     $msg = null;
     
     //Abrimos la sesión
     $session = new Session;
     $session->open();
     
     //Si no existen las variables de sesión requeridas lo expulsamos a la página de inicio
     if (empty($session["recover"]) || empty($session["id_recover"]))
     {
      return $this->redirect(["site/index"]);
     }
     else
     {
      
      $recover = $session["recover"];
      //El valor de esta variable de sesión la cargamos en el campo recover del formulario
      $model->recover = $recover;
      
      //Esta variable contiene el id del usuario que solicitó restablecer el password
      //La utilizaremos para realizar la consulta a la tabla Usuarios
      $id_recover = $session["id_recover"];
      
     }
     
     //Si el formulario es enviado para resetear el password
     if ($model->load(Yii::$app->request->post()))
     {
      if ($model->validate())
      {
       //Si el valor de la variable de sesión recover es correcta
       if ($recover == $model->recover)
       {
        //Preparamos la consulta para resetear el password, requerimos el email, el id 
        //del usuario que fue guardado en una variable de session y el código de verificación
        //que fue enviado en el correo al usuario y que fue guardado en el registro
        $table = Usuarios::findOne(["email" => $model->email, "id" => $id_recover, "codigo_verificacion" => $model->codigo_verificacion]);

        //Encriptar el password
        $security = Yii::$app->security;

        $table->password = $security->generatePasswordHash($model->password);
        
        //Si la actualización se lleva a cabo correctamente
        if ($table->save())
        {
         
         //Destruir las variables de sesión
         $session->destroy();
         
         //Vaciar los campos del formulario
         $model->email = null;
         $model->password = null;
         $model->password_repeat = null;
         $model->recover = null;
         $model->codigo_verificacion = null;
         
        Yii::$app->session->setFlash('success', 'La contraseña se ha cambiado correctamente.');
        return $this->redirect(['site/login']);
        
        }
        else
        {
            Yii::$app->session->setFlash('error', 'La contraseña NO se ha cambiado correctamente.');
        }
        
       }
       else
       {
        $model->getErrors();
       }
      }
     }

     return $this->render("resetearpass", ["model" => $model, "msg" => $msg]);
     
    }

    public function actionActivar($id, $token)
    {
        $usuario = $this->findModel($id);
        if ($usuario->token === $token) {
            $usuario->token = null;
            $usuario->save();
            Yii::$app->session->setFlash('success', 'Usuario validado. Inicie sesión.');
            return $this->redirect(['site/login']);
        }
        Yii::$app->session->setFlash('error', 'La validación no es correcta.');
        return $this->redirect(['site/index']);
    }


    public function actionUpdate($id = null)
    {
        if ($id === null) {
            if (Yii::$app->user->isGuest) {
                Yii::$app->session->setFlash('error', 'Debe estar logueado.');
                return $this->goHome();
            } else {
                $model = Yii::$app->user->identity;
            }
        } else {
            $model = Usuarios::findOne($id);
        }

        $model->scenario = Usuarios::SCENARIO_UPDATE;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Se ha modificado correctamente.');
            return $this->goHome();
        }

        $model->password = '';
        $model->password_repeat = '';
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    private function randKey($str = '', $long = 0)
    {
        $key = null;
        $str = str_split($str);
        $start = 0;
        $limit = count($str) - 1;
        for ($x = 0; $x < $long; $x++) {
            $key .= $str[rand($start, $limit)];
        }
        return $key;
    }

}

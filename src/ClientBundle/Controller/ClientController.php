<?php

namespace ClientBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use ClientBundle\Entity\Client;
use ClientBundle\Form\ClientType;
use Endroid\Twitter\Twitter;

/**
 * Client controller.
 *
 * @Route("/cliente")
 */
class ClientController extends Controller
{
    /**
     * @Route("/{id}/show", name="cliente_show")
     * @Method("GET")
     */
    public function showAction($id) 
    {
         $sql = " 
            SELECT  *
            FROM client
            WHERE id = ?
            ";
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $res = $stmt->fetchAll();

        $cliente = $res[0];
        $entity = [];
        $id = $cliente["id"];
        $membresia_id = $cliente["tipo_membresia_id"];
       
        $sqlCorreo = " 
            SELECT  correo_electronico 
            FROM correo
            WHERE cliente_id = ?
            ";

        $sqlTelefono = " 
            SELECT numero_telefono 
            FROM telefono t
            WHERE cliente_id = ?
            ";

        $sqlDireccion = " 
            SELECT  direccion 
            FROM direccion
            WHERE cliente_id = ?
            ";

        $sqlMembresia = " 
            SELECT  tipo_membresia 
            FROM tipo_membresia
            WHERE id = ?
            ";

         $sqlUsuario = " 
            SELECT username 
            FROM usuario u
            INNER JOIN client c on u.id = c.usuario_id
            WHERE c.id = ?
            ";
            //obtener correos
            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sqlCorreo);
            $stmt->bindValue(1, $id );
            $stmt->execute();
            $correos = $stmt->fetchAll();
            //obtener direcciones
            $stmt = $em->getConnection()->prepare($sqlDireccion);
            $stmt->bindValue(1, $id );
            $stmt->execute();
            $direcciones = $stmt->fetchAll();
            //obtener telefonos
            $stmt = $em->getConnection()->prepare($sqlTelefono);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $telefonos = $stmt->fetchAll();
            //obtener membresia
            $stmt = $em->getConnection()->prepare($sqlMembresia);
            $stmt->bindValue(1, $membresia_id );
            $stmt->execute();
            $membresia = $stmt->fetchAll();
            //obtener usuario
            $stmt = $em->getConnection()->prepare($sqlUsuario);
            $stmt->bindValue(1, $id );
            $stmt->execute();
            $usuario = $stmt->fetchAll();

            $entity[] = $id;
            $entity[] = $cliente["nit"];
            $entity[] = $cliente["frecuente"];
            $entity[] = $cliente["nombres"];
            $entity[] = $cliente["apellidos"];
            $entity[] = $cliente["estado_civil"];
            $entity[] = $cliente["foto_cliente"];
            $entity[] = $cliente["sexo"];
            $entity[] = $cliente["nacionalidad"];
            $entity[] = $cliente["twitter_username"];
            $entity[] = $cliente["fecha_nacimiento"];
            if ($correos) {
                $corr = [];
                foreach($correos as $mail) {
                    $corr[] = $mail["correo_electronico"];
                }
                $entity[] = $corr;
            }
            else{
                $entity[] = [];
            }
            if ($direcciones) {
                $dirs = [];
                foreach($direcciones as $adress) {
                    $dirs[] = $adress["direccion"];
                }
                $entity[] = $dirs;
            }
             else{
                $entity[] = [];
            }

            if ($telefonos) {
                $tels = [];
                foreach($telefonos as $telefono) {
                    $tels[] = $telefono["numero_telefono"];
                }
                $entity[] = $tels;
            }
            else{
                $entity[] = [];
            }
            if ($membresia) {
                $entity[] = $membresia[0]["tipo_membresia"];
            }
            else{
                $entity[] = null;
            }
            if ($usuario) {
                $entity[] = $usuario[0]["username"];
            }
            else{
                $entity[] = null;
            }
       
        
        return $this->render('ClientBundle:Client:showClient.html.twig', [
            'entity' => $entity,
        ]);
        
    }

    /**
     * @Route("/", name="cliente")
     */
    public function indexAction(Request $request)
    {
        $sql = " 
            SELECT * 
            FROM client
            ";
        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetchAll();

        
        $returnArray = [];
        foreach($resultado as $cliente ){
            $entity = [];
            $id = $cliente["id"];
            $membresia_id = $cliente["tipo_membresia_id"];
          
            $sqlCorreo = " 
                SELECT  correo_electronico 
                FROM correo
                WHERE cliente_id = ?
                ";

            $sqlTelefono = " 
                SELECT numero_telefono 
                FROM telefono t
                WHERE cliente_id = ?
                ";

            $sqlDireccion = " 
                SELECT  direccion 
                FROM direccion
                WHERE cliente_id = ?
                ";

            $sqlMembresia = " 
                SELECT  tipo_membresia 
                FROM tipo_membresia
                WHERE id = ?
                ";

             $sqlUsuario = " 
                SELECT username 
                FROM usuario u
                INNER JOIN client c on u.id = c.usuario_id
                WHERE c.id = ?
                ";
                //obtener correos
                $em = $this->getDoctrine()->getManager();
                $stmt = $em->getConnection()->prepare($sqlCorreo);
                $stmt->bindValue(1, $id );
                $stmt->execute();
                $correos = $stmt->fetchAll();
                //obtener direcciones
                $stmt = $em->getConnection()->prepare($sqlDireccion);
                $stmt->bindValue(1, $id );
                $stmt->execute();
                $direcciones = $stmt->fetchAll();
                //obtener telefonos
                $stmt = $em->getConnection()->prepare($sqlTelefono);
                $stmt->bindValue(1, $id);
                $stmt->execute();
                $telefonos = $stmt->fetchAll();
                //obtener membresia
                $stmt = $em->getConnection()->prepare($sqlMembresia);
                $stmt->bindValue(1, $membresia_id );
                $stmt->execute();
                $membresia = $stmt->fetchAll();
                //obtener usuario
                $stmt = $em->getConnection()->prepare($sqlUsuario);
                $stmt->bindValue(1, $id );
                $stmt->execute();
                $usuario = $stmt->fetchAll();

                $entity[] = $id;
                $entity[] = $cliente["nit"];
                $entity[] = $cliente["frecuente"];
                $entity[] = $cliente["nombres"];
                $entity[] = $cliente["apellidos"];
                $entity[] = $cliente["estado_civil"];
                $entity[] = $cliente["foto_cliente"];
                $entity[] = $cliente["sexo"];
                $entity[] = $cliente["nacionalidad"];
                $entity[] = $cliente["twitter_username"];
                $entity[] = $cliente["fecha_nacimiento"];
                if ($correos) {
                    $corr = [];
                    foreach($correos as $mail) {
                        $corr[] = $mail["correo_electronico"];
                    }
                    $entity[] = $corr;
                }
                else{
                    $entity[] = [];
                }
                if ($direcciones) {
                    $dirs = [];
                    foreach($direcciones as $adress) {
                        $dirs[] = $adress["direccion"];
                    }
                    $entity[] = $dirs;
                }
                else{
                    $entity[] = [];
                }

                if ($telefonos) {
                    $tels = [];
                    foreach($telefonos as $telefono) {
                        $tels[] = $telefono["numero_telefono"];
                    }
                    $entity[] = $tels;
                }
                else{
                    $entity[] = [];
                }
                if ($membresia) {
                    $entity[] = $membresia[0]["tipo_membresia"];
                }
                else{
                    $entity[] = null;
                }
                if ($usuario) {
                    $entity[] = $usuario[0]["username"];
                }
                 else{
                    $entity[] = null;
                }
            $returnArray[] = $entity;
                
        }
        
        return $this->render('ClientBundle:Client:indexClient.html.twig',[
            'clientes' => $returnArray,
        ]);

    }


     /**
     * Displays a form to create a new Client entity.
     *
     * @Route("/new", name="cliente_new")
     */

    public function newAction(Request $request)
    {
        $entity = new Client();

        $camposDinamicos = $this->getNombreTipoColumnas();

        $form   = $this->createForm(
            new ClientType($this->getDoctrine()->getManager(), $camposDinamicos)
        );

        $form->handleRequest($request);
        if (!$form->isValid()){
            return $this->render('ClientBundle:Client:newClient.html.twig',
                 [
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ]
            );
        }

        $data = $form->getData();

        $fechaNacimiento = $data['fechaNacimiento'];
        $nit = $data['nit'];
        $frecuente = $data['frecuente'];
        $nombres = $data['nombres'];
        $apellidos = $data['apellidos'];
        $estadoCivil = $data['estadoCivil'];
        $tipoMembresia = $data['tipoMembresia'];
        $correo = $data['correo'];
        $sexo = $data['sexo'];
        $profesion = $data['profesion'];
        $dpi = $data['dpi'];
        $telefonos = $data['telefono'];
        $direccion = $data['direccion'];
        $imagen = $data['imageFile'];
        $nacionalidad = $data['nacionalidad'];
        $twitterUsername = $data['twitterUsername'];
        $updateTweets = $data['updateTweets'];
        $usuario = $this->getUser();
        $client = new Client();
        $client->setImageFile($imagen);
        $client->uploadImage();
       

         $sql = " 
            INSERT INTO client
            VALUES (
            nextval('client_id_seq'), 
            :nit,
            :frecuente,
            :nombres,
            :apellidos,
            :estado,
            :foto,
            :sexo,
            :profesion,
            :dpi,
            :nacion,
            :twit,
            :tipo,
            :fecha,
            :usuario
           
            
            )
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
      
        $stmt->bindValue("nit", $nit );
        $stmt->bindValue("frecuente", $frecuente, \PDO::PARAM_BOOL );
        $stmt->bindValue("nombres", $nombres );
        $stmt->bindValue("apellidos", $apellidos );
        $stmt->bindValue("estado", $estadoCivil );
        $stmt->bindValue("foto", $client->getFotoCliente() );
        $stmt->bindValue("sexo", $sexo );
        $stmt->bindValue("profesion", $profesion );
        $stmt->bindValue("dpi", $dpi );
        $stmt->bindValue("nacion", $nacionalidad );
        $stmt->bindValue("twit", $twitterUsername );
        $stmt->bindValue("tipo", $tipoMembresia);
        $stmt->bindValue("fecha", $fechaNacimiento, 'datetime');
        $stmt->bindValue("usuario", $usuario->getId());

        try {
            $stmt->execute();
        } catch (\Doctrine\DBAL\DBALException $e) {
           $error = substr($e->getMessage(), strrpos($e->getMessage(), "ERROR"));
           $this->addFlash(
            'error',
            $error
            );
             return $this->render('ClientBundle:Client:newClient.html.twig',
                 [
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ]
            );
        }

        $sql = " 
            Select currval('client_id_seq')
            FROM client
            LIMIT 1;
            ";
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

       $sql = " 
            INSERT INTO direccion
            VALUES (
            nextval('direccion_id_seq'), 
            :direccion,
            :cliente
            )
            ";

        foreach($direccion as $dir) {
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue("direccion", $dir["d"]);
            $stmt->bindValue("cliente", $res[0]["currval"]);
            try {
                $stmt->execute();
            } catch (\Doctrine\DBAL\DBALException $e) {
               $error = substr($e->getMessage(), strrpos($e->getMessage(), "ERROR"));
               $this->addFlash(
                    'error',
                    $error
                );
                 return $this->render('ClientBundle:Client:newClient.html.twig',
                 [
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ]
            );
            }
        }

        $sql = " 
            INSERT INTO correo
            VALUES (
            nextval('correo_id_seq'), 
            :correo,
            :cliente
            )
            ";
        foreach($correo as $mail) {
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue("correo", $mail["correoElectronico"]);
            $stmt->bindValue("cliente", $res[0]["currval"]);
            try {
                $stmt->execute();
            }catch (\Doctrine\DBAL\DBALException $e) {
               $error = substr($e->getMessage(), strrpos($e->getMessage(), "ERROR"));
               $this->addFlash(
                    'error',
                    $error
                );
                 return $this->render('ClientBundle:Client:newClient.html.twig',
                 [
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ]
            );
            }
        }

        $sql = " 
            INSERT INTO telefono
            VALUES (
            nextval('telefono_id_seq'), 
            :telefono,
            :cliente
            )
            ";
        foreach($telefonos as $phone) {
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue("telefono", $phone["numeroTelefono"]);
            $stmt->bindValue("cliente", $res[0]["currval"]);

            try {

                $stmt->execute();

            }catch (\Doctrine\DBAL\DBALException $e) {
               $error = substr($e->getMessage(), strrpos($e->getMessage(), "ERROR"));
               $this->addFlash(
                    'error',
                    $error
                );
                 return $this->render('ClientBundle:Client:newClient.html.twig',
                 [
                    'entity' => $entity,
                    'form'   => $form->createView(),
                ]
            );
            }
        }

        $formData = $form->getData();
        foreach ($camposDinamicos as $campo) {
            $value = $formData[$campo['nombre']];
            $campo_dinamico_id = $campo['campo_id'];
            $cliente_id = $this->getLastClienteIdInserted();

            $insertValue = "";
            switch ($campo['tipo']) {
                case 'number':
                    $insertValue = (string) $value;
                    break;
                case 'checkbox':
                    if ($value === true) {
                        $insertValue = "true";
                        break;
                    }
                    $insertValue = "false";
                    break;
                case 'text':
                    $insertValue = $value;
                    break;
                case 'date':
                    $insertValue = $value->format('Y-m-d H:m:s');
                    break;
            }

            $this->insertCampoDinamico($insertValue, $campo_dinamico_id, $cliente_id);
        }

        //guardar tweets del cliente
        if ($updateTweets  == 1 && $twitterUsername != null){
            $this->saveTweets($twitterUsername);
        }

       return $this->redirectToRoute('cliente');
    }

    private function getNombreTipoColumnas()
    {
        $conexionDB = $this->get('database_connection'); // Conexión con la BD
        $sql = "SELECT * FROM campo_dinamico";
        $stmt = $conexionDB->prepare($sql);
        $stmt->execute();

        $camposDinamicos = $stmt->fetchAll();

        $returnArray = [];

        foreach ($camposDinamicos as $campo) {
            // processTipoColumna

            $tipo = $this->getTipoColumnaById($campo['tipo_columna_id']);

            $returnArray[] = [
                'nombre' => $campo['nombre'],
                'tipo' => $this->processTipoColumna($tipo),
                'campo_id' => $campo['id']
            ];
        }

        return $returnArray;
    }

    private function getTipoColumnaById($id)
    {
        $conexionDB = $this->get('database_connection');
        $sql = "SELECT tipo FROM tipo_columna  WHERE id = ?";
        $stmt = $conexionDB->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();

        return $stmt->fetchAll()[0]['tipo'];
    }

    private function processTipoColumna($tipo)
    {
        $returnTipo = "";

        switch ($tipo) {
            case 'INTEGER':
                $returnTipo = 'number';
                break;
            case 'VARCHAR(50)':
                $returnTipo = 'text';
                break;
            case 'DOUBLE PRECISION':
                $returnTipo = 'number';
                break;
            case 'DATE':
                $returnTipo = 'date';
                break;
            case 'BOOLEAN':
                $returnTipo = 'checkbox';
                break;
            default:
                throw new \LogicException('Tipo de columna no reconocido');
                break;
        }

        return $returnTipo;
    }

    private function insertCampoDinamico($valor, $campo_dinamico_id, $cliente_id)
    {
        $conexionDB = $this->get('database_connection');
        $sql = "INSERT INTO valor_dinamico VALUES (nextval('valor_dinamico_id'), ?, ?, ?)";

        $stmt = $conexionDB->prepare($sql);
        $stmt->bindValue(1, $valor);
        $stmt->bindValue(2, $campo_dinamico_id);
        $stmt->bindValue(3, $cliente_id);

        $stmt->execute();
    }

    private function getLastClienteIdInserted()
    {
        $conexionDB = $this->get('database_connection');
        $sql = "SELECT id FROM client ORDER BY id DESC LIMIT 1;";

        $stmt = $conexionDB->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll()[0]['id'];
    }

    /**
     * Displays a form to edit an existing client entity.
     *
     * @Route("/{id}/edit", name="client_edit")
     * @Method("GET")
     *
     */
    public function editAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $sql = " 
            SELECT  *
            FROM client
            Where id = ?
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $entities = [];
        foreach($res as $entity){
            $client = new Client();
            $client->setId($entity["id"]);

            $client->setFechaNacimiento(
                new \DateTime($entity["fecha_nacimiento"]));

            $client->setNit($entity["nit"]);
            $client->setFrecuente($entity["frecuente"]);
            $client->setNombres($entity["nombres"]);
            $client->setApellidos($entity["apellidos"]);
            $client->setEstadoCivil($entity["estado_civil"]);
            $client->setSexo($entity["sexo"]);
            $client->setProfesion($entity["profesion"]);
            $client->setDpi($entity["dpi"]);
            $client->setNacionalidad($entity["nacionalidad"]);
            $client->setTwitterUsername($entity["twitter_username"]);
            $client->setFotoCliente($entity["foto_cliente"]);
            $client->setTipoMembresia($entity["tipo_membresia_id"]);
            $entities[] = $client;

        }
        $entity = $entities[0];
      

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ClientBundle:Client:editClient.html.twig', 
            [
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),

            ]);
       
    }

    /**
     * Edits an existing client entity.
     *
     * @Route("/{id}/update", name="client_update")
     * @Method("PUT")
     * @Template("ClientBundle:Client:editClient.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        try {
        $sql = " 
            SELECT  *
            FROM client
            Where id = ?
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $entities = [];
        foreach($res as $entity){
            $client = new Client();
            $client->setId($entity["id"]);
            $client->setFechaNacimiento( new \DateTime($entity["fecha_nacimiento"]));
            $client->setNit($entity["nit"]);
            $client->setFrecuente($entity["frecuente"]);
            $client->setNombres($entity["nombres"]);
            $client->setApellidos($entity["apellidos"]);
            $client->setEstadoCivil($entity["estado_civil"]);
            $client->setSexo($entity["sexo"]);
            $client->setProfesion($entity["profesion"]);
            $client->setDpi($entity["dpi"]);
            $client->setNacionalidad($entity["nacionalidad"]);
            $client->setTwitterUsername($entity["twitter_username"]);
            $client->setFotoCliente($entity["foto_cliente"]);
            $entities[] = $client;

        }
        $entity = $entities[0];
       

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Correo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
      
        if ($editForm->isValid()) {

            $data = $editForm->getData();

            $fechaNacimiento = $data->getFechaNacimiento();
            $nit = $data->getNit();
            $frecuente = $data->getFrecuente();
            $nombres = $data->getNombres();
            $apellidos = $data->getApellidos();
            $estadoCivil = $data->getEstadoCivil();
            $sexo = $data->getSexo();
            $profesion = $data->getProfesion();
            $dpi = $data->getDpi();
            $nacionalidad = $data->getNacionalidad();
            $twitterUsername = $data->getTwitterUserName();
            $imagen = $data->getFotoCliente();

            $em = $this->getDoctrine()->getManager();
            $sql = " 
                UPDATE  client
                SET fecha_nacimiento = ?,
                nit = ?,
                frecuente = ?,
                nombres = ?,
                apellidos = ?,
                estado_civil = ?,
                foto_cliente = ?,
                sexo = ?,
                profesion = ?,
                dpi = ?,
                nacionalidad = ?,
                twitter_username = ?
                WHERE id = ?
                ";

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue(1, $fechaNacimiento, 'datetime');
            $stmt->bindValue(2, $nit);
            $stmt->bindValue(3, $frecuente, 'boolean');
            $stmt->bindValue(4, $nombres);
            $stmt->bindValue(5, $apellidos);
            $stmt->bindValue(6, $estadoCivil);
            $stmt->bindValue(7, $imagen);
            $stmt->bindValue(8, $sexo);
            $stmt->bindValue(9, $profesion);
            $stmt->bindValue(10, $dpi);
            $stmt->bindValue(11, $nacionalidad);
            $stmt->bindValue(12, $twitterUsername);
            $stmt->bindValue(13, $id);
            $stmt->execute();

            $this->get('session')->getFlashBag()->add('notice', 'Your message!');
            return $this->redirect($this->generateUrl('client_edit', array('id' => $id)));
        }
        }
        catch (\Doctrine\DBAL\DBALException $e) {
           $error = substr($e->getMessage(), strrpos($e->getMessage(), "ERROR"));
           $this->addFlash(
            'error',
            $error
        );
        }

         return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

     /**
    * Creates a form to edit a Direccion entity.
    *
    * @param Client $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Client $entity)
    {
        $form = $this->createForm(new ClientType($this->getDoctrine()->getManager(),
           $this->getNombreTipoColumnas()

            ), $entity, array(
        
            'action' => $this->generateUrl('client_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar', 'attr' => ['class' => 'btn btn-primary']));

        return $form;
    }

     /**
     * Deletes a Correo entity.
     *
     * @Route("/{id}/delete", name="client_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);
;
        if ($form->isValid()) {

           $sql = " 
                DELETE FROM valor_dinamico
                WHERE cliente_id = ?
                ";

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();

            $sql = " 
                DELETE FROM client
                WHERE id = ?
                ";

            $em = $this->getDoctrine()->getManager();
            $stmt = $em->getConnection()->prepare($sql);
            $stmt->bindValue(1, $id);
            $stmt->execute();


        }

        return $this->redirect($this->generateUrl('cliente'));
    }


      /**
     * Creates a form to delete a Correo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar','attr' => ['class' => 'btn btn-danger']))
            ->getForm()
        ;
    }

    private function saveTweets($cliente){
          $usuario = $this->getUser();
        
        $twitter = new Twitter(
            "ADcfgE61LTgs6YU524t9yrU29", 
            "Z7oggnEwWq4mdOj0oapaH9rteMzURlZFb61IkxEe024tjQrMFU", 
            $this->getTwitterToken($usuario), 
            $this->getTitterSecretToken($usuario));
        // obtener tweets del usuario
        // Twitter api retorna máximo 199 por request
        // 3200 max en total
        $cantidadMax = 1500;
        $cantidadActual = 0;
        $max_id = '';
        $tweetsAcum = [];
        while ($cantidadActual < $cantidadMax) {
            if ($cantidadActual !=0 ){
                $tweets = $twitter->getTimeline(array(
                    'count' => 500,
                    'max_id' => $max_id,
                    'screen_name' => $cliente
                ));
            }else{
                 $tweets = $twitter->getTimeline(array(
                'count' => 500,
                'screen_name' => $cliente
            ));

            }
           
            $cont = 0;
            foreach ($tweets as $tweet) {
                if ($cantidadActual != 0){
                    if ($cont != 0){
                        $tweetsAcum[] = $tweet;
                    }
                }else{
                     $tweetsAcum[] = $tweet;
                }

                $cont = $cont + 1;
            }
            $cantidadActual = $cantidadActual + count($tweets);
           
            if (count($tweetsAcum) != 0) {
                
                $max_id = $tweetsAcum[count($tweetsAcum)-1]->id_str;
            }
            else {
               // break;
            }

            

        } 

       $tweets = $tweetsAcum;
        //conectar con mongo
        $client = new \MongoDB\Client("mongodb://localhost:27017");

        $collection = $client->crm->tweets;
        foreach($tweets as &$tweet) {
            $date = new \DateTime($tweet->created_at);
            //$date = $date->format(\DateTime::ISO8601);
           
            $time = $date->getTimestamp();
            //$time = strval($time) + "000";
            $time = $time."000";
             
            $utcdatetime = new \MongoDB\BSON\UTCDateTime($time);
           
           
            $tweet->created_at = $utcdatetime;
           
        }
        
        //guardar los tweets
        $result = $collection->insertMany($tweets);
        $this->addFlash(
            'success',
            'Se han guardado 1500 tweets de '.$cliente
            );
    }

    private function getTwitterId($usuario) {
        $sql = " 
            SELECT u.twitter_id
            FROM usuario u
            WHERE u.id = ?
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $usuario->getId());
        $stmt->execute();
        $res = $stmt->fetchAll();
         return $res[0]["twitter_id"];
    }
    private function getTwitterToken($usuario) {
        $sql = " 
            SELECT u.twitter_token
            FROM usuario u
            WHERE u.id = ?
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $usuario->getId());
        $stmt->execute();
        $res = $stmt->fetchAll();
       
         return $res[0]["twitter_token"];
    }
    private function getTitterSecretToken($usuario) {
        $sql = " 
            SELECT u.twitter_secret_token
            FROM usuario u
            WHERE u.id = ?
            ";

        $em = $this->getDoctrine()->getManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->bindValue(1, $usuario->getId());
        $stmt->execute();
        $res = $stmt->fetchAll();
       
         return $res[0]["twitter_secret_token"];
    }
    
}
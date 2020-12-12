<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController
{
    protected $modelName = 'App\Models\Modeloanimales';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function  insertar()
    {
        //1. Recibir los datos desde el cliente
		$nombre=$this->request->getPost("nombre");
		$edad=$this->request->getPost("edad");
		$tipoanimal=$this->request->getPost("tipoanimal");
		$descripcion=$this->request->getPost("descripcion");
		$comida=$this->request->getPost("comida");
        $foto=$this->request->getPost("foto");
        
        //2. Organizar los datos que llegan de las vistas en un arreglo asociativo (las claves deben ser iguales a los campos o atributos de la tabla en BD)

		$datosEnvio=array(
			"nombre"=>$nombre,
			"edad"=>$edad,
			"tipoanimal"=>$tipoanimal,
			"descripcion"=>$descripcion,
			"comida"=>$comida,
			"foto"=>$foto
        );
        
        //3. Utilizar el atributo this->validate del controlador para validar datos

        if ($this->validate('animalesPOST')) {
            
            $id=$this->model->insert($datosEnvio);
            return $this->respond($this->model->find($id));

        } else {

            $validation = \Config\Services::validation();
            return $this->respond($validation->getErrors());

        }
        

    }

    public function eliminar($id)
    {
        $consulta=$this->model->where('id',$id)->delete();
        $filasAfectadas=$consulta->connID->affected_rows;
        if ($filasAfectadas==1) 
        {
            $mensaje=array("mensaje"=>"Registro eliminado");    
            return $this->respond(json_encode($mensaje));
        } else
        {
            $mensaje=array("mensaje"=>"Revisar el id a eliminar");    
            return $this->respond(json_encode($mensaje));
        }

      

    }

    public function editar($id)
    {
        //1. Recibir los datos desde el cliente
        $datosPeticion=$this->request->getRawInput();
        
        //2. Depurar arreglo del paso 1 para segmentar la información por variables
        $nombre=$datosPeticion["nombre"];
        $edad=$datosPeticion["edad"];
        $tipoanimal=$datosPeticion["tipoanimal"];
        $descripcion=$datosPeticion["descripcion"];
        $comida=$datosPeticion["comida"];
        $foto=$datosPeticion["foto"];

        //3. organizar los datos para envío hacia BD
        $datosEnvio=array(
			"nombre"=>$nombre,
			"edad"=>$edad,
			"tipoanimal"=>$tipoanimal,
			"descripcion"=>$descripcion,
			"comida"=>$comida,
			"foto"=>$foto
        );

        //4. Ejecutar la consulta si se validaron los datos

        if ($this->validate('animalesPOST')) {
            
            
            $this->model->update($id,$datosEnvio);
            return $this->respond($this->model->find($id)); 

        } else {

            $validation = \Config\Services::validation();
            return $this->respond($validation->getErrors());

        }

    }

    // ...
}
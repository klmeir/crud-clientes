<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('cliente_model','cliente');
	}

	public function index()
	{
        $this->load->helper('url');
		$this->load->view('cliente_view');
    }
    
    public function ajax_list()
	{
		$list = $this->cliente->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cliente) {
			$no++;
			$row = array();
			$row[] = $cliente->identificacion;
			$row[] = $cliente->nombre;
			$row[] = $cliente->telefono;
			$row[] = $cliente->celular;
            $row[] = $cliente->direccion;
            $row[] = $cliente->email;
			$row[] = $cliente->tipo;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Editar" onclick="edit_cliente('."'".$cliente->id."'".')"><i class="glyphicon glyphicon-pencil"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Eliminar" onclick="delete_cliente('."'".$cliente->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->cliente->count_all(),
						"recordsFiltered" => $this->cliente->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
    }
    
    public function ajax_edit($id)
	{
		$data = $this->cliente->get_by_id($id);
		//$data->dob = 
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'identificacion' => $this->input->post('identificacion'),
				'nombre' => $this->input->post('nombre'),
				'telefono' => $this->input->post('telefono'),
				'celular' => $this->input->post('celular'),
                'direccion' => $this->input->post('direccion'),
                'email' => $this->input->post('email'),
                'tipo' => $this->input->post('tipo'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
			);
		$insert = $this->cliente->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
            'identificacion' => $this->input->post('identificacion'),
            'nombre' => $this->input->post('nombre'),
            'telefono' => $this->input->post('telefono'),
            'celular' => $this->input->post('celular'),
            'direccion' => $this->input->post('direccion'),
            'email' => $this->input->post('email'),
            'tipo' => $this->input->post('tipo'),
            'updated_at' => date('Y-m-d H:i:s'),
			);
		$this->cliente->update(array('id' => $this->input->post('id')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->cliente->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
    }

    private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;
        
		if($this->input->post('identificacion') == '')
		{
			$data['inputerror'][] = 'identificacion';
			$data['error_string'][] = 'Identificación es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('nombre') == '')
		{
			$data['inputerror'][] = 'nombre';
			$data['error_string'][] = 'Nombre es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('telefono') == '')
		{
			$data['inputerror'][] = 'telefono';
			$data['error_string'][] = 'Teléfono es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('celular') == '')
		{
			$data['inputerror'][] = 'celular';
			$data['error_string'][] = 'Celular es requerido.';
			$data['status'] = FALSE;
		}

		if($this->input->post('direccion') == '')
		{
			$data['inputerror'][] = 'direccion';
			$data['error_string'][] = 'Dirección es requerido.';
			$data['status'] = FALSE;
        }
        
        if($this->input->post('email') == '')
		{
			$data['inputerror'][] = 'email';
			$data['error_string'][] = 'Email es requerido.';
			$data['status'] = FALSE;
        }
        
        if($this->input->post('tipo') == '')
		{
			$data['inputerror'][] = 'tipo';
			$data['error_string'][] = 'Debe seleccionar Un Tipo de Cliente.';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}
    
}

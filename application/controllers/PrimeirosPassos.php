<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PrimeirosPassos extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/PrimeirosPassos
	 *	- or -
	 * 		http://example.com/index.php/PrimeirosPassos/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/PrimeirosPassos/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if(!$this->session->userdata('user_id')){
			$this->load->view('primeiros_passos/passo1');
		}else{
			redirect('welcome');
		}
	}

	public function save_passo1()
	{

		if(count($this->input->post()) <= 0){
			redirect('welcome');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('nome', 'Nome', 'required');
		$this->form_validation->set_rules('data_nasc', 'Nascimento', 'required');
		$this->form_validation->set_rules('tipo_usuario', 'Tipo de usuario', 'required');
		$this->form_validation->set_rules('login', 'Usuario', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		
		$this->form_validation->set_message('required', 'O Campo %s e obrigatorio');
		$this->form_validation->set_message('valid_email', 'E-mail invalido');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('primeiros_passos/passo1');
		}
		else
		{
			$this->load->model('usuarios');

			$insert_id = $this->usuarios->insert_usuario();

			$this->session->set_userdata('user_id', $insert_id[0]);
			$this->session->set_userdata('nome', $insert_id[1]);

			redirect('welcome');
		}
	}

	public function passo2(){
		if(!$this->session->userdata('user_id')){
			redirect('welcome');
		}

		$this->load->view('primeiros_passos/passo2');
	}

	public function save_passo2(){
		if(count($this->input->post()) <= 0){
			redirect('welcome');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('salario_bruto', 'Salario', 'required');
		$this->form_validation->set_rules('tipo_recebimento', 'Tipo de Recebimento', 'required');
		$this->form_validation->set_rules('data_salario', 'Data Salario', 'required');
		
		if($this->input->post('tipo_recebimento') == 2)
			$this->form_validation->set_rules('data_vale', 'Data Vale', 'required');
		
		$this->form_validation->set_message('required', 'O Campo %s e obrigatorio');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('primeiros_passos/passo2');
		}
		else
		{
			$this->load->model('salarios');

			$insert_id = $this->salarios->insert_salario();

			redirect('welcome');
		}
	}
}

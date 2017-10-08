<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		if($this->session->userdata('user_id')){

			$this->load->model('usuarios');
			$user = $this->usuarios->get_user($this->session->userdata('user_id'));

			if($user){
				$this->load->model('salarios');
				$salario = $this->salarios->get_salario_user($this->session->userdata('user_id'));

				if($salario){
					$this->session->set_userdata('logged',true);
					redirect('dashboard');
				}else{
					redirect('PrimeirosPassos/passo2');
				}

			}else{
				$this->logout();
				$this->load->view('login');
			}
		}else
			$this->load->view('login');
	}

	public function novo()
	{
		redirect('PrimeirosPassos');
	}

	public function login(){

		if(count($this->input->post()) <= 0){
			redirect('welcome');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('login', 'Login', 'required');
		$this->form_validation->set_rules('senha', 'Senha', 'required|callback_cb_valid_user['.$this->input->post('login').']');

		$this->form_validation->set_message('required', 'O Campo %s e obrigatorio');
		$this->form_validation->set_message('cb_valid_user', 'Usuario ou Senha invalidos');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('login');
		}
		else
		{
			redirect('welcome');
		}
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect('welcome');
	}

	public function cb_valid_user($pass, $user){
		if(isset($user) && isset($pass)){
			$this->load->model('usuarios');
			$user_id = $this->usuarios->valid_user($user, $pass);

			if($user_id){
				$this->session->set_userdata('user_id', $user_id['id_usuario']);
				$this->session->set_userdata('nome', $user_id['nome']);
				return true;
			}else{
				return false;
			}
		}
	}
}

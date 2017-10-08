<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
		if(!$this->session->userdata('logged')){
			redirect('welcome');
		}else{
			$this->carrega_dashboard();
		}
	}

	protected function carrega_dashboard(){
		//Modulos
		$this->load->model('salarios');
		$this->load->model('transacoes');

		$data = $this->input->post();
		if(!isset($data['Tdata']))
			$data['Tdata'] = date('m-Y');

		$data['entrada'] = array();
		$data['saida'] = array();

		//Salario
		$salario = $this->salarios->get_salario_user($this->session->userdata('user_id'));
		$dia_salario = strtotime(date('d-',strtotime($salario['data_salario'])).$data['Tdata']);
		$dia_vale = strtotime(date('d-',strtotime($salario['data_vale'])).$data['Tdata']);
		$sal[$dia_salario][0]['valor'] = $salario['salario_bruto'];
		$sal[$dia_salario][0]['desc'] = 'Salario';
		if($salario['tipo_recebimento'] == 2){
			$sal[$dia_salario][0]['valor'] = ($salario['salario_bruto']*0.6);
			$sal[$dia_vale][0]['valor'] = ($salario['salario_bruto']*0.4);
			$sal[$dia_vale][0]['desc'] = 'Vale';
			$data['dias'][] = $dia_vale;
		}
		$data['dias'][] = $dia_salario;
		$data['entrada'] = $sal;

		$data_ini = date('Y-m-d', strtotime('1-'.$data['Tdata']));
		$data_fim = date('Y-m-t', strtotime('1-'.$data['Tdata']));

		//Entrada
		$entrada = $this->transacoes->get_entrada_user($this->session->userdata('user_id'), $data_ini, $data_fim);
		$entrada_p = $this->transacoes->get_entrada_user_parcela($this->session->userdata('user_id'), $data_fim);
		$entrada = array_merge($entrada, $entrada_p);
		$trs = array(); 
		foreach ($entrada as $trans) {
			$dia_trans = strtotime($trans['data']);
			if($trans['flparcela'] == 1)
				$dia_trans = strtotime(date('d', $dia_trans)."-".$data['Tdata']);

			if(isset($trs[$dia_trans]))
				$i++;
			else
				$i = 0;

			$trs[$dia_trans][$i]['valor'] = $trans['valor'];
			if($trans['flsalario'] == 1)
				if($salario['tipo_recebimento'] == 2)
					$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto'] * 0.6) * ($trans['porcentagem'] / 100);
				else
					$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto']) * ($trans['porcentagem'] / 100);

			if($trans['flvale'] == 1)
				$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto'] * 0.4) * ($trans['porcentagem'] / 100);

			$trs[$dia_trans][$i]['desc'] =  $trans['desc'];
			$data['dias'][] = $dia_trans;
		}
		$data['entrada'] = ($trs + $data['entrada']);

		//Saida
		$saida = $this->transacoes->get_saida_user($this->session->userdata('user_id'), $data_ini, $data_fim);
		$saida_p = $this->transacoes->get_saida_user_parcela($this->session->userdata('user_id'), $data_fim);
		$saida = array_merge($saida, $saida_p);
		$trs = array();
		foreach ($saida as $trans) {
			$dia_trans = strtotime($trans['data']);
			if($trans['flparcela'] == 1)
				$dia_trans = strtotime(date('d', $dia_trans)."-".$data['Tdata']);

			if(isset($trs[$dia_trans]))
				$i++;
			else
				$i = 0;

			$trs[$dia_trans][$i]['valor'] = $trans['valor'];
			if($trans['flsalario'] == 1)
				if($salario['tipo_recebimento'] == 2)
					$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto'] * 0.6) * ($trans['porcentagem'] / 100);
				else
					$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto']) * ($trans['porcentagem'] / 100);

			if($trans['flvale'] == 1)
				$trs[$dia_trans][$i]['valor'] = ($salario['salario_bruto'] * 0.4) * ($trans['porcentagem'] / 100);

			$trs[$dia_trans][$i]['desc'] =  $trans['desc'];
			$data['dias'][] = $dia_trans;
		}
		$data['saida'] = ($trs + $data['saida']);

		//Poupança
		$poupanca = 0;

		$data['total'] = 0;

		$data['dias'] = array_unique($data['dias']);

		sort($data['dias']);

		$this->load->view('dashboard', $data);
	}

	function salvar_valor(){
		if(count($this->input->post()) <= 0){
			redirect('welcome');
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('tipo_valor', 'Tipo Valor', 'required');
		
		if(!$this->input->post('flsalario') && !$this->input->post('flvale'))
			$this->form_validation->set_rules('valor', 'Valor', 'required');
		else
			$this->form_validation->set_rules('porcentagem', 'Porcentagem', 'required');

		if(!$this->input->post('flparcela'))
			$this->form_validation->set_rules('parcelas', 'Parcela', 'required');

		$this->form_validation->set_rules('data', 'Vencimento', 'required');
		$this->form_validation->set_rules('desc', 'Descrição', 'required');
		
		$this->form_validation->set_message('required', 'Campo %s Obrigatorio');
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>');

		if ($this->form_validation->run() == FALSE)
		{
			$this->carrega_dashboard();
		}
		else
		{
			$this->load->model('transacoes');

			extract($this->input->post());

			$data = strtotime($data);
			if($parcelas > 1){
				while ($parcelas > 0) {
					$parcelas--;
					$prcl = array(
						'id_usuario_fk' => $this->session->userdata('user_id'),
						'tipo_valor' => $tipo_valor,
						'desc' => $desc,
						'valor' => $valor,
						'porcentagem' => $porcentagem,
						'data' => date('Y-m-d', $data),
						'flvale' => ((isset($flvale))?1:0),
						'flsalario' => ((isset($flsalario))?1:0),
						'flparcela' => ((isset($flparcelas))?1:0)
					);
					$data = strtotime('+1 Month', $data);

					$this->transacoes->insert_transacao($prcl);
				}
			}else{
				$prcl = array(
					'id_usuario_fk' => $this->session->userdata('user_id'),
					'tipo_valor' => $tipo_valor,
					'desc' => $desc,
					'valor' => $valor,
					'porcentagem' => $porcentagem,
					'data' => date('Y-m-d', $data),
					'flvale' => ((isset($flvale))?1:0),
					'flsalario' => ((isset($flsalario))?1:0),
					'flparcela' => ((isset($flparcela))?1:0)
				);
				$this->transacoes->insert_transacao($prcl);
			}

			redirect('dashboard');
		}
	}
}

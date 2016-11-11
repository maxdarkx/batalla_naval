<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->session->jugador=2;
	}
	public function posiciones()
	{
		$this->load->view('posiciones.phtml');
	}

	public function iniciar()
	{
		$idp=$this->juego->iniciarPartida($this->session->jugador,1);

		$this->session->idp=$idp;
		$posuser=$this->input->post('posiciones');
		$this->juego->guardarPosiciones($idp,$this->session->jugador,$posuser);
		$data['user2']=$posuser;
		
		$posmachine=$this->juego->iniciarJuegoMaquina($idp);
		$data['user1']=$posmachine;
		$this->load->view('juego.phtml',$data);
	}

	public function jugar()
	{
		$posicion=$this->input->get('posicion');
		$datos=$this->juego->jugar($posicion,2,$this->session->idp);
		echo json_encode(['resultado'=>'ok','estado'=>$datos['estado'],'posicion'=>$posicion]);


	}


	public function obtenerPosiciones(){}
	public function actualizarJuego(){}


}

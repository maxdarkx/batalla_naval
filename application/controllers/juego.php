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
		//$idp= id de la partida en curso
		$idp=$this->juego->iniciarPartida(1,$this->session->jugador);
		$this->session->idp=$idp;
		echo "partida=".$idp."<br>";

		//posiciones es un arreglo que viene de posiciones
		$posuser=$this->input->post('posiciones');
		$data['user2']=$posuser;
		$this->juego->guardarPosiciones($idp,$this->session->jugador,$posuser);
		
		
		$posmachine=$this->juego->iniciarJuegoMaquina($idp);
		$data['user1']=$posmachine;

		//var_dump($data);

		$this->load->view('juego.phtml',$data);
	}

	public function jugar()
	{
		$posicion=$this->input->get('posicion');
		$datos=$this->juego->jugar($posicion,1,$this->session->idp);
		echo json_encode(['resultado'=>'ok','estado'=>$datos['estado'],'posicion'=>$posicion]);


	}


	public function obtenerPosiciones(){}
	public function actualizarJuego(){}


}

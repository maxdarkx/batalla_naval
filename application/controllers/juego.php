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
		//$ses=(isset($this->session->winU))?"true":"false";
		//echo ("Session:"+$ses);
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

		$attack=range(0,35);
		shuffle($attack);
		$this->session->attack=$attack;
		$this->session->nattack=0;
		$this->load->view('juego.phtml',$data);
		$this->session->winM=0;
		$this->session->winU=0;
		$this->session->mov=0;
	}

	public function jugar()
	{
		$i=$this->session->nattack;
		$this->session->nattack++;
		$posMac=$this->session->attack[$i];

		
		$posicion=$this->input->get('posicion');
		$datos=$this->juego->jugar($posicion,1,$this->session->idp);
		$datos2=$this->juego->jugar($posMac,2,$this->session->idp);
		$this->session->mov++;

		echo json_encode(['resultado'=>'ok',
						'estado'=>$datos['estado'],
						'miestado'=>$datos2['estado'],
						'posicion'=>$posicion,
						'ataque'=>$posMac,
						'wmac'=>$this->session->winM,
						'wus' =>$this->session->winU,
						'mov' =>$this->session->mov]);
	}

	public function destroy()
	{
		session_destroy();
	}
	public function guardarPartida()
	{
		$winner=$this->input->get('ganador');
		$this->juego->guardar($winner);
	}
}
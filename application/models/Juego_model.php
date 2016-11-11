<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego_model extends CI_Model {


        const VACIO=0;
        const CONBARCO=1;

        public function __construct()
        {
                parent::__construct();
        }

        public function iniciarPartida($user1,$user2)
        {
          $this->db->insert('partidas',['id'=>0,'usuario1'=>$user1,'usuario2'=>$user2]);
          return $this->db->insert_id();
        }

        public function iniciarJuegoMaquina($partida)
        {
        	$posiciones=array_fill(0,36,0);

        	shuffle($posiciones);
        	$posmachine=array_slice($posiciones,0,6);
          $this->guardarPosiciones($partida,1,$posmachine);
          return $posmachine;
        }
        public function guardarPosiciones($partida,$user,$posiciones)
        {
            $inipos=range(0,35);
            foreach($inipos as $i=>$v)
            {
                    $registers[]=['usuario'=>$user,'partida'=>$partida,'posicion'=>$i,'estado'=>'0'];//VACIO
            }
            foreach($posiciones as $i=>$pos){

                $registers[]=['usuario'=>$user,'partida'=>$partida,'posicion'=>$pos,'estado'=>'1'];
            }
            $this->db->insert_batch('juegos',$registers);
        }

        public function jugar($pos,$idu,$idp)
        {
           $this->db->select('estado, id');
           $this->db->from('juegos');
           $this->db->where('usuario',$idu);
           $this->db->where('partida',$idp);
           $this->db->where('posicion',$pos);
           $query=$this->db->get();
           $registro=$query->row();
           $datos['estado']=$registro->estado;
           switch ($registro->estado) {
               case 0:
                    $registro->estado=3;
                    break;
               case 1:
                    $registro->estado=2;
                    break;
                }
           $this->db->where('id',$registro->id);
           $this->db->update('juegos',['estado'=>$registro->estado]);
           return $datos;
        }
}


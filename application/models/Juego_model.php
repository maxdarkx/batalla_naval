<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juego_model extends CI_Model 
{


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
  	$posiciones=range(0,35);
  	shuffle($posiciones);
    $posmachine=array_slice($posiciones,0,6);
    var_dump($posmachine);
    $this->session->pc=$posmachine;
    var_dump($this->session->pc);

    $this->guardarPosiciones($partida,1,$posmachine);
    return $posmachine;
  }

  public function guardarPosiciones($partida,$user,$posiciones)
  {
      $inipos=range(0,35);
      
      foreach($inipos as $i=>$v)
      {
        $check=true;
        for($j=0;$j<count($posiciones);$j++)
        {
          if($i==$posiciones[$j])
          {
            $registers[]=['usuario'=>$user,'partida'=>$partida,'posicion'=>$i,'estado'=>'1'];
            $check=false;
            break;
          }
        }
        if($check)
        {
          $registers[]=['usuario'=>$user,'partida'=>$partida,'posicion'=>$i,'estado'=>'0'];//VACIO
        }
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
     

     switch ($registro->estado) {
         case 0:
              $registro->estado=3;
              break;
         case 1:
              $registro->estado=2;
              break;
          }
     $datos['estado']=$registro->estado;
     $this->db->where('id',$registro->id);
     $this->db->update('juegos',['estado'=>$registro->estado]);
     
     return $datos;
  }
}


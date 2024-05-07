<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlinemodel extends CI_Model {
	public function insert($dat) {
		$result=$this->db->insert('signup',$dat);
		if ($result) {
			return true;
		}
		else
		{
			return false;
		}


	}
	public function login($data){
		$result=$this->db->get_where('signup',$data);
		if ($result->num_rows()>0) {return true;
		}
		else
		{
			return false;
		}
			
		
	}
	 public function table(){

	 	$result=$this->db->get('signup');
	 	return $result;
	 }
	 public function getbyid($id){
      $result=$this->db->query("SELECT * from signup where userid='$id'");
      return $result;

	 }
	 public function update($id,$data){

	 	$this->db->where('userid',$id);
	 	$this->db->update('signup',$data);
	 	$result=$this->db->get('signup');
	 	if($this->db->affected_rows()>0){
      return $result;
           }}
           public function delete($id){
           	$result=$this->db->query("DELETE from signup where userid='$id'");
      if($this->db->affected_rows()>0){
      return $result;
           }

           }



}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockmodel extends CI_Model {

  public function stockmaster($a)
            {
              $result=$this->db->insert("stockmaster",$a);
              // $result=$this->db->query("UPDATE stock SET qty=qty-$q WHERE productid='$c' AND branch='$f'");
              return $result;
            }
            public function stockdetails($data)
            {

              $result=$this->db->insert("stockdetails",$data);
              return $result;
            }

            public function getdamagestock()
            {
              $result=$this->db->query("SELECT * from damagestock");
              return $result;
            }
            
            public function insert_damagestock($data)
            {
              $result=$this->db->insert("damagestock",$data);
              return $result;
            }

            public function deletdamagestock($referenceno)
            { 
              $result=$this->db->query("UPDATE damagestock SET deleted =1 WHERE referenceno='$referenceno'");
              return $result;
            }

            public function update_damagestock($referenceno,$data)
            {
              $this->db->where('referenceno',$referenceno);
              $this->db->update('damagestock',$data);
              if($this->db->affected_rows()>0)
              {
                return true;
              }
              else
              {
                return false;
              }
            }

            // public function damageaccount($damagestockamount)
            // {
            //   //damage stock
            //   $dam=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$damagestockamount WHERE ledgerid='73'");
              
            //   //stock a/c
            //   $stock=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$damagestockamount WHERE ledgerid='4'");
            //   return true; 
            // }
		}
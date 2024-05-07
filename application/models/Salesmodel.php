<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesmodel extends CI_Model {

        public function insert_salesinvoicemaster($data)
        {
          $this->db->trans_start();
          $this->db->insert('salesinvoicemaster',$data);
          $result = $this->db->insert_id();
          $this->db->trans_complete();
          return $result;
        }

        public function insert_salesinvoicemasterFB($data)
        {
          $this->db->trans_start();
          $this->db->insert('fbase_salesinvoicemaster',$data);
          $result = $this->db->insert_id();
          $this->db->trans_complete();
          return $result;
        }
        
        
        public function insert_salesinvoicedetails($data)
        {
          $result=$this->db->insert('salesinvoicedetails',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function insert_salesinvoicedetailsFB($data)
        {
          $result=$this->db->insert('fbase_salesinvoicedetails',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
        
        public function api_checkexistence_invoiceno($invoiceno,$branchid,$finyear)
        {
          $result=$this->db->query("SELECT * FROM salesinvoicemaster WHERE invoiceno='$invoiceno' AND branchid='$branchid' AND finyear= $finyear");
          return $result;
        }

        public function api_checkexistence_invoicenoFB($invoiceno,$branchid,$finyear)
        {
          $result=$this->db->query("SELECT * FROM fbase_salesinvoicemaster WHERE invoiceno='$invoiceno' AND branchid='$branchid' AND finyear= $finyear");
          return $result;
        }

        public function api_checkexistence_retinvoiceno($invoiceno,$branchid)
        {
          $result=$this->db->query("SELECT * FROM salesreturnmaster WHERE invoiceno='$invoiceno' AND branchid='$branchid'");
          return $result;
        }

        public function api_checkexistence_retinvoiceno4($invoiceno,$branchid,$finyear)
        {
          $result=$this->db->query("SELECT * FROM salesreturnmaster WHERE invoiceno='$invoiceno' AND branchid='$branchid' AND finyear= '$finyear'");
          return $result;
        }

        public function api_checkexistence_ecomno($ecomno,$branchid)
        {
          $result=$this->db->query("SELECT * FROM ecommerce_ordermaster WHERE eCommerce_no='$invoiceno' AND branchid='$branchid'");
          return $result;
        }


        public function insert_salesreturnmaster($data)
        {
          $this->db->trans_start();
          $this->db->insert('salesreturnmaster',$data);
          $result = $this->db->insert_id();
          $this->db->trans_complete();     
          return $result;
        }

        public function insert_salesreturndetails($data)
        {
          $result=$this->db->insert('salesreturndetails',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
          
         public function edit_salesinvoicemaster($data,$id)
         {
          $this->db->where('invoiceno',$id);
          $this->db->update('salesinvoicemaster',$data);
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
         }
         public function update_Returnsalesinvoicemaster($insertdata,$id)
         {
          $this->db->where('salesmasterid',$id);
          $this->db->update('salesinvoicemaster',$insertdata);
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
         }

         public function update_salesinvoicedetails($id,$data)
         {
           $this->db->where('invoiceno',$id);
           $this->db->update('salesinvoicedetails',$data);
           if($this->db->affected_rows()>0)
           {
             return true;
           }
           else
           {
             return false;
           }
         }
        
        public function sales_stock($product,$size,$qty,$branch,$batch)
        {
          $stock=$this->db->query("UPDATE stock SET currentstock=currentstock-$qty WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size='$size'");
          return $stock;
        }

         public function delete_salesinvoicemaster($invoiceno)
         {
          $result=$this->db->query("DELETE FROM salesinvoicemaster WHERE salesmasterid='$invoiceno'");
          return $result;
         }
        
         public function api_returndelete_salesinvoicemaster($masterid)
         {
          $result=$this->db->query("DELETE FROM salesinvoicemaster WHERE salesmasterid='$masterid'");
          return $result;
         }

         public function deltesalesgrid($voucherno,$product,$batch,$size)
         {
          $result=$this->db->query("DELETE FROM salesinvoicedetails WHERE invoiceno='$voucherno' AND productcode='$product' AND batchid='$batch' AND size ='$size'");
          return $result;
         }
         public function redeempoints($masterid,$customerid,$points,$DATE)
         {
         $query=$this->db->query("UPDATE customer SET points=points-$points WHERE customerid='$customerid'");
         if($query){ 
          $npoints=$points*-1;
           $s=$this->db->query("INSERT INTO redeem (`redeem_type`, `coupon_code`, `promotion_code`, `redeem_points`, `customerid`, `salesmasterid`, `date`) VALUES ('POS_REDEEM','','','$npoints','$customerid','$masterid','$DATE') ");
         }
         return $s;
        }
        public function addpoints($masterid,$customerid,$points,$DATE)
        {
          
          $s=$this->db->query("UPDATE customer SET points=points+$points WHERE customerid='$customerid'");
          if($s){ 
          // $npoints=$points*-1;
            $s=$this->db->query("INSERT INTO redeem (`redeem_type`, `coupon_code`, `promotion_code`, `redeem_points`, `customerid`, `salesmasterid`, `date`) VALUES ('POS_ADD','','','$points','$customerid','$masterid','$DATE')");
          }
          return $s;
        }
       
        public function checkproduct($product,$branch,$batch,$size)
        {
          $result=$this->db->query("SELECT * FROM stock WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size ='$size'");
          return $result->num_rows();
          // return $result;
        }

       public function salesaccount($sales,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance)
       {
              // sales ac 
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$sales WHERE ledgerid='21'");
              //discount
              if($discount !=0 ){
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$discount WHERE ledgerid='28'");
                }
                //tax
                if($tax!=0)
                {
                $t=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$tax WHERE ledgerid='23'");
              }
              //costof sales

              $c=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$stock WHERE ledgerid='22'");

              //stock a/c
              $Stock=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$stock WHERE ledgerid='4'");

              $cashresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$paidcash WHERE ledgerid='$cash'");
              $bankresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$paidbank WHERE ledgerid='$bank'");
              if($balance!=0)
              {
              $custblnce=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$balance WHERE ledgerid='$customer'");
              }
              return true; 
       }
       public function salesreturnaccount($sales,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance)
       {
              // sales ac 
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$sales WHERE ledgerid='21'");
              //discount
              if($discount !=0 ){
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$discount WHERE ledgerid='28'");
                }
                //tax
                if($tax!=0)
                {
                $t=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$tax WHERE ledgerid='23'");
              }
              //costof sales

              $c=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$stock WHERE ledgerid='22'");

              //stock a/c
              $Stock=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$stock WHERE ledgerid='4'");

              $cashresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$paidcash WHERE ledgerid='$cash'");
              $bankresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$paidbank WHERE ledgerid='$bank'");
              if($balance!=0)
              {
              $custblnce=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$balance WHERE ledgerid='$customer'");
              }
              return true; 
       }
       public function api_salesaccount($stockamount,$total,$customer,$discount,$balance)
       {
         
         if($stockamount !=0)
         {
           //cost of sales
           $cost=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$stockamount WHERE ledgerid='22'");
           //stock
           $stock=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$stockamount WHERE ledgerid='4'");
         }
         if($total !=0)
         {
           //sales acc
           $ssales=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$total WHERE ledgerid='21'");
         }
         if($balance !=0)
         {
           //customer
           $cash=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$balance WHERE ledgerid='$customer'");
         }
         if($discount !=0)
         {
          $dis=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$discount WHERE ledgerid='28'");

         }
         return true;
       }

            public function getsalesestimate()
            {
              $q=$this->db->query("SELECT * from salesestimatemaster");
              return $q;
            }

  public function Autogenerate_InvoiceNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(id+1),1) as NO from salesestimatemaster");
            return $query;
          }  

    public function Autogenerate_ShopOrderNo($branchid)
          {
            $query=$this->db->query("SELECT IFNULL(max(Orderno+1),1) as NO from shoporder WHERE branchid='$branchid'");
            return $query;
          }
          
          public function Autogenerate_ShopOrder($branchid)
          {
            $query=$this->db->query("SELECT branchcode from branch WHERE branchid='$branchid'");
            return $query;
          }

          public function Autogenerate_OnlineOrderNo($branchid)
          {
            $query=$this->db->query("SELECT IFNULL(max(Orderno+1),1) as NO from onlineorder WHERE branchid='$branchid'");
            return $query;
          }
    
    public function Autogenerate_OnlineOrder($branchid)
          {
            $query=$this->db->query("SELECT branchonlinecode from branch WHERE branchid='$branchid'");
            return $query;
          }

         public function insert_salesestimatemaster($data)
         {
          $this->db->insert('salesestimatemaster',$data);
         }

         public function insert_salesestimatedetails($data)
         {
           $result=$this->db->insert('salesestimatedetailes',$data);
                  if($result)
                  {
                    return true;
                  }
                  else
                  {
                    return false;
                  }
         }
         public function getestimatemaster($a)
         {
          $result=$this->db->query("SELECT * FROM salesestimatemaster WHERE invoiceno=$a");
          return $result;
         }
         public function getestimatedetailes($a)
         {
          $result=$this->db->query("SELECT * FROM salesestimatedetailes WHERE invoiceno=$a");
          return $result;
         }
          public function delete_salesinvoicedetails($inv)
         {
          $result=$this->db->query("DELETE FROM salesinvoicedetails WHERE salesmasterid='$inv'");
          return $result;
         }
         public function deleteestimate($inv)
         {
          $result=$this->db->query("DELETE FROM salesestimatedetailes WHERE invoiceno=$inv");
          $result1=$this->db->query("DELETE FROM salesestimatemaster WHERE invoiceno=$inv");
          return $result;
         }

         public function insert_ecommerce_ordermaster($data)
         {
           $this->db->trans_start();
          $this->db->insert('ecommerce_ordermaster',$data);
          $result = $this->db->insert_id();
           $this->db->trans_complete();
           return $result;
         }

         public function insert_ecommerce_orderdetails($data)
         {
           $result=$this->db->insert('ecommerce_orderdetails',$data);

          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
         }
}
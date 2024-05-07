<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasemodel extends CI_Model {
  
	public function insertdetailes($data)
   {
    $this->db->insert('purchaseinvoicemaster',$data);
    $id=$this->db->insert_id();
    return $id;
   }

    public function insertpurchasegrid($data)
    {
      $result=$this->db->insert('purchaseinvoicedetials',$data);
      if($result)
      {
        return true;
      }
      else
      {
        return false;
      }
    }


   public function insertreturndetailes($data)
   {
     $this->db->insert('purchasereturnmaster',$data);
     $id=$this->db->insert_id();
     return $id;
   }


   public function insertreturntable($data)
    {
      $result=$this->db->insert('purchasereturndetials',$data);
      if($result)
      {
        return true;
      }
      else
      {
        return false;
      }
    }
            public function checkproduct($name,$size,$branch,$batch)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$name' AND branch='$branch' AND batchid='$batch' AND size ='$size'");
              return $result->num_rows() ;
              // return $result;
            }
          public function Autogenerate_PurchaseVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchaseinvoicemaster");
            return $query->result();
          }

          public function Autogenerate_PurchaseRetVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchasereturnmaster");
            return $query->result();
          }
          public function PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,
          $TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$Bankaccount,$Cashaccount)
        {    
          if($PurchaseDiscount!=0)
           {
             $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance+$PurchaseDiscount
             WHERE ledgername='Purchase Discount A/C'");
           }
          if($TotalTaxAmt!=0)
           {
             $query1= $this->db->query("UPDATE accountledger 
             set currentbalance=currentbalance+$TotalTaxAmt
             WHERE ledgername='Purchase Tax A/C'");
           }
          if($TotalPurchasedStockAmount!=0)
           {
             $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance+$TotalPurchasedStockAmount
             WHERE ledgername='Stock A/C'");
           }
          if($balance<0)
           {
             $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance-$balance
             WHERE ledgerid='$Supplieraccount'");
           }
         if($CashAccountAmt!=0)
           {
             $query2= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance-$CashAccountAmt
             WHERE ledgerid='$Cashaccount'");
           }
        if($BankAccountAmt!=0)
           {
             $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance-$BankAccountAmt
             WHERE ledgerid='$Bankaccount'");
           }
     return $CashAccountAmt;
        }
           public function PurchaseInvoicedelete_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,
            $TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$Bankaccount,$Cashaccount)
          {    
            if($PurchaseDiscount!=0)
             {
               $query1= $this->db->query("UPDATE accountledger
               set currentbalance=currentbalance+$PurchaseDiscount
               WHERE ledgername='Purchase Discount A/C'");
             }
            if($TotalTaxAmt!=0)
             {
               $query1= $this->db->query("UPDATE accountledger 
               set currentbalance=currentbalance+$TotalTaxAmt
               WHERE ledgername='Purchase Tax A/C'");
             }
            if($TotalPurchasedStockAmount!=0)
             {
               $query1= $this->db->query("UPDATE accountledger
               set currentbalance=currentbalance+$TotalPurchasedStockAmount
               WHERE ledgername='Stock A/C'");
             }
            if($balance!=0)
             {
               $query1= $this->db->query("UPDATE accountledger
               set currentbalance=currentbalance-$balance
               WHERE ledgerid='$Supplieraccount'");
             }
           if($CashAccountAmt!=0)
             {
               $query2= $this->db->query("UPDATE accountledger
               set currentbalance=currentbalance-$CashAccountAmt
               WHERE ledgerid='$Cashaccount'");
             }
          if($BankAccountAmt!=0)
             {
               $query1= $this->db->query("UPDATE accountledger
               set currentbalance=currentbalance-$BankAccountAmt
               WHERE ledgerid='$Bankaccount'");
             }
       return $CashAccountAmt;
          }

        public function updatepurchase($vouch,$code,$data)
        {
            $this->db->where('voucherno',$vouch);
            $this->db->where('productcode',$code);
           $result=  $this->db->update('purchaseinvoicedetials',$data);

          // $result=$this->db->query("UPDATE purchaseinvoicedetials SET qty='$qty' WHERE voucherno='$vouch' AND productcode='$code'");
             if($result)
            {
              return true;
            }
            else
            {
              return false;
            }

        }
          public function editdetailes($a,$data)
            {
             $this->db->where('voucherno',$a);
                $q2=$this->db->update('purchaseinvoicemaster',$data);
            }

    public function deletedetailes($vouch,$code)
    {
      $result=$this->db->query("DELETE from purchaseinvoicedetials WHERE productcode='$code' AND voucherno=$vouch");
      return $result;
    }
 public function deletemaster($a)
 {
  $data=$this->db->query("DELETE  a, b 
FROM    purchaseinvoicedetials a
        INNER JOIN purchaseinvoicemaster b
            ON a.voucherno = b.voucherno
WHERE  a.voucherno = $a");
return $data;
 }
 public function getmaster($a)
 {
    return $this->db->
            select('*')->
            from('purchaseinvoicemaster')->
            where('voucherno', $a)->
            get()->row_array();
 }

 // delete purchasemaster 
 public function delete_purchasemaster($voucherno)
 {
  $result=$this->db->query("DELETE FROM purchaseinvoicemaster WHERE voucherno='$voucherno'");
  return $result;
 }

 public function delete_purchaseretmaster($voucherno)
 {
  $result=$this->db->query("DELETE FROM purchasereturnmaster WHERE voucherno='$voucherno'");
  return $result;
 }
 //delete purchasedetailes
public function deltepurchasegrid($voucherno,$name,$batch)
 {
$result=$this->db->query("DELETE FROM purchaseinvoicedetials WHERE voucherno='$voucherno' AND productcode='$name' ");
return $result;
 }

 public function delteretpurchasegrid($voucherno,$name,$batch)
 {
$result=$this->db->query("DELETE FROM purchasereturndetials WHERE voucherno='$voucherno' AND productcode='$name' ");
return $result;
 }

 public function deltepurchasegridbyvoucherno($voucherno)
 {
$result=$this->db->query("DELETE FROM purchaseinvoicedetials WHERE voucherno='$voucherno'");
return $result;
 }
}
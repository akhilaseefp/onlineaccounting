<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlinemodel extends CI_Model {
	public function insert($dat) {
		$result=$this->db->insert('signup',$dat);
		if ($result) 
    {
			return true;
		}
		else
		{
			return false;
		}
  }
//notification
    public function getminstock()
    {
      // $result=$this->db->query("SELECT * FROM product WHERE minimumstock < ")
    }

    public function getbranchreport($fdate,$tdate,$branch)
    {
      $result=array();
      $result['res1']=$this->db->query("SELECT daybook.date,daybook.credit,daybook.debit,daybook.balance,branch.branchname,accountledger.ledgername,(SELECT ledgername FROM accountledger WHERE ledgerid=daybook.ledgername) AS ledgernames, (SELECT ledgername FROM accountledger WHERE ledgerid=daybook.opposite) AS oppositename FROM daybook INNER JOIN accountledger on daybook.ledgername=accountledger.ledgerid INNER JOIN branch ON accountledger.branchid=branch.branchid WHERE accountledger.branchid='$branch' AND accountledger.rootid='4' AND daybook.date BETWEEN '$fdate' AND '$tdate' ORDER BY daybook.date ASC")->result();

     log_message('error', $this->db->last_query());

      $result['res2']=$this->db->query("SELECT SUM(paidcash) AS totalCash,SUM(paidbank) AS totalBank,SUM(balance) AS totalAdvance,SUM(stockamount) AS totalCost FROM salesinvoicemaster WHERE salesdate BETWEEN '$fdate' AND '$tdate' AND branchid='$branch'")->result();

      $result['res4']=$this->db->query("SELECT SUM(stockamount) AS returnTotalCost,SUM(grandtotal) AS netReturn FROM salesreturnmaster WHERE salesdate BETWEEN '$fdate' AND '$tdate' AND branchid='$branch'")->result();

      $result['res3']=$this->db->query("SELECT (SUM(debit)-SUM(credit)) AS newBalance FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE accountledger.rootid='4' AND accountledger.branchid='$branch' AND daybook.date BETWEEN '$fdate' AND '$tdate'")->result();

      return $result;
    }


    public function getstokregreport($fdate,$tdate,$branch)
    {
      $result=array();
      $result=$this->db->query("SELECT * FROM stockregister WHERE stockregister.branch='$branch' AND  stockregister.date BETWEEN '$fdate' AND '$tdate' ORDER BY stockregister.date ASC")->result();

      return $result;
    }

    public function getstokPDTregreport($pdt_id,$branch)
    {
      $result=array();
      $result=$this->db->query("SELECT * FROM stockregister WHERE stockregister.branch='$branch' AND  stockregister.productid = '$pdt_id'  ORDER BY stockregister.date DESC")->result();

      return $result;
    }


          // public function getreportdata($fdate,$todate,$branch)
          // {
          //   $result=array();
          //   $result=$this->db->query("SELECT SUM(paidcash) AS totalCash,SUM(paidbank) AS totalBank,SUM(balance) totalAdvance,SUM(stockamount) AS totalCost FROM salesinvoicemaster WHERE salesdate BETWEEN '$fromdate' AND '$todate' AND branchid='$branch'");
          //   return $result->result();
          // }

          // public function getreportdata2($branch)
          // {
          //   $result=array();
          //   $result=$this->db->query("SELECT (SUM(debit)-SUM(credit)) AS newBalance FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE accountledger.rootid='4' AND accountledger.branchid='$branch'");
          //   return $result->result();
          // }


public function update_shippingcharge($id,$data)
     {
           $this->db->where('shippingid',$id);

            $this->db->update('shippingcharge',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
     }

      public function getshippingcharge()
     {
      $q=$this->db->query("SELECT shippingcharge.shippingid, shippingcharge.country,shippingcharge.charge,shippingcharge.currency,country.country_name,currency.currencyname from shippingcharge INNER JOIN country ON shippingcharge.country=country.country_id INNER JOIN currency ON shippingcharge.currency=currency.currencyid  ORDER BY shippingcharge.shippingid");
      return $q;
     }

	public function login($data){
		$result=$this->db->get_where('login',$data);
     ?> <script type="text/javascript"> alert ('hi'); </script><?php 
		if ($result->num_rows()>0) 
		{
      return true;
		}
		else
		{
      return false;
		}
			
		
	}
   public function api_getadminchat($userid)
          {
            $result=$this->db->query("SELECT customer.customername,customer.profilepicture,chatmessage.message,chatmessage.date FROM `chatroom` INNER join chatmessage on chatroom.roomid=chatmessage.roomid INNER JOIN customer on chatroom.customerid=customer.customerid where chatroom.staffid='$userid'");
            return $result;
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
   public function delete($id)   {
                                         	$result=$this->db->query("DELETE from signup where userid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return $result;
                                      }

           }
            public function api_FillpettyLedgers($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE branchid='$branchid' AND accountgroup=25");
            return $query;
          }
            public function insert_productgroup($data,$under)
           {                      
             $groupid=$data['groupunder'];
          $balance1= $this->db->query("select rootid,groupcode,children from product_group where groupid='$groupid'");
           $balance1=$balance1->result_array();
          $groupcode =$balance1[0]['groupcode'];
          $data['rootid']=$balance1[0]['rootid'];
          $child=$balance1[0]['children'];
           $pad_length = 2;
          $pad_char = 0;
          $str_type = 'd'; // treats input as integer, and outputs as a (signed) decimal number

            $format = "%{$pad_char}{$pad_length}{$str_type}"; // or "%04d"

$formatted_str = sprintf($format,$child);
$data['groupcode']=$groupcode."-".$formatted_str;
$data['children']=1;
 $upd= $this->db->query("UPDATE product_group SET children=children+1 WHERE groupid='$groupid'");
                                  $result=$this->db->insert('product_group',$data);
                                  $id=$this->db->insert_id();
                                  
                                           if ($result) {
                                            
                                            return true;
                                           }
                                          else
                                           {
                                              return false;
                                           }

           }
           public function getproductname($a) 
           {
            $result=$this->db->query("SELECT pdt_name FROM product WHERE pdt_name LIKE '%".$a."%'");
            return $result->result();
           }

           public function api_getproductname($name) 
           {
            $result=$this->db->query("SELECT * FROM product WHERE pdt_name LIKE '%".$name."%'");
            return $result;
           }

           public function get_purmaster1($a)
           {
            $query=$this->db->query("SELECT * FROM purchaseinvoicemaster WHERE voucherno=$a");
            return $query->result();
          }

    public function get_purdetailes1($a)
    {
      $query=$this->db->query("SELECT purchaseinvoicedetials.*,product.*,purchaseinvoicedetials.batchid as expirydate,purchaseinvoicedetials.tax as taxpercent FROM purchaseinvoicedetials INNER JOIN product ON purchaseinvoicedetials.productcode = product.pdt_code WHERE purchaseinvoicedetials.voucherno='$a'");
      return $query->result_array();
    }

  public function get_purretmaster1($a)
  {
    $query=$this->db->query("SELECT * FROM purchasereturnmaster WHERE voucherno=$a");
    return $query->result();
  }

    public function get_purretdetailes1($a)
    {
      $query=$this->db->query("SELECT purchasereturndetials.*,product.*,purchasereturndetials.batchid as expirydate,purchasereturndetials.tax as taxpercent FROM purchasereturndetials INNER JOIN product ON purchasereturndetials.productcode = product.pdt_code WHERE purchasereturndetials.voucherno='$a'");
      return $query->result_array();
    }

     public function get_productgroup()
     {
       $result=$this->db->get('product_group');
          return $result;                 	
     }

      public function Api_customerOnlineLogin($user,$pass)
      {
        $result=$this->db->query("SELECT * FROM customer WHERE 	phonenumber='$user' OR email='$user' ");
        if ($result->num_rows()>0) 
            {
            return $result;
            }
        else
        {
          return false;
        }
      }
           
          public function checkexistence_productgroup($value)
          {
           
          	$result=$this->db->query("SELECT * FROM product_group where groupname = '$value'");

          	return $result->num_rows() ;

          }

          public function insert_unit($data)
          {
           $result=$this->db->insert('unit',$data);

           if($result){
            return true;
          }	
          else
          {
            return false;
          }
        }

        public function delete_unit($id)
        {
          $result=$this->db->query("DELETE from unit where unitid='$id'");
          if($this->db->affected_rows()>0){
            return true;
          }
          else {
            return false;
          }
        }
        public function update_unit($id,$data)
        {
          $this->db->where('unitid',$id);
          $this->db->update('unit',$data);
          if($this->db->affected_rows()>0){
            return true;
          }
          else {
            return false;
          }
        }

        public function checkexistence_unit($value)
        {

         $result=$this->db->query("SELECT * FROM unit where unitname = '$value'");
         return $result->num_rows() ;

       }
          public function getunit()
          {
          	$query = $this->db->get('unit');
          	return $query;
          }

          public function insert_brand($data)
          {
           $result=$this->db->insert('brand',$data);

           if($result){
            return true;
          }	
          else
          {
            return false;
          }
        }
        public function delete_brand($id)
        {
          $result=$this->db->query("DELETE from brand where brandid='$id'");
          if($this->db->affected_rows()>0){
            return true;
          }
          else {
            return false;
          }
        }
        public function update_brand($id,$data)
        {
          $this->db->where('brandid',$id);
          $this->db->update('brand',$data);
          if($this->db->affected_rows()>0){
            return true;
          }
          else {
            return false;
          }
        }
           public function checkexistence_brand($value)
          {
           
          	$result=$this->db->query("SELECT * FROM brand where brandname = '$value'");
          	return $result->num_rows() ;

          }
                public function getbrand()
          {
          	$query = $this->db->get('brand');
          	return $query;
          }


      public function insert_batch($data)
         {
               $result=$this->db->insert('batch',$data);
                     
                     if($result){
                      return true;
                     }  
                     else
                     {
                      return false;
                     }
         }
          public function delete_batch($id)
          {
            $result=$this->db->query("DELETE from batch where batchid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
           public function update_batch($id,$data)
          {
            $this->db->where('batchid',$id);
            $this->db->update('batch',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
           public function checkexistence_batch($value)
          {
           
            $result=$this->db->query("SELECT * FROM batch where batchname = '$value'");
            return $result->num_rows() ;

          }
                public function getbatch()
          {
            $query = $this->db->get('batch');
            return $query;
          }
          
                public function insert_supplier($data)
         {
               $result=$this->db->insert('supplier',$data);
                     
                     if($result){
                     	return true;
                     }	
                     else
                     {
                     	return false;
                     }
         }
          public function update_supplier($id,$data)
          {try {
            $this->db->where('supplierid',$id);
            $this->db->update('supplier',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
                                      }
catch (Exception $e) {
    echo $e->getMessage();
}
          }
          public function delete_supplier($id)
          {
            $result=$this->db->query("DELETE from supplier where supplierid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }

          public function deleteShoporder($orderid)
          {
            $result=$this->db->query("UPDATE shoporder SET deleted='1' WHERE shoporderid='$orderid'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else 
            {
              return false;
            }
          }

          public function updateVoucher($var)
          {
            $result=$this->db->query("UPDATE vouchercode SET expired='1' WHERE barcode='$var'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else 
            {
              return false;
            }
          }

          public function getsupplier()
           {
                $result=$this->db->query("SELECT *,supplier.address AS supaddress FROM supplier INNER JOIN accountledger ON supplier.supplieraccount=accountledger.ledgerid INNER JOIN branch on supplier.branch = branch.branchid");
                return $result;                   

           }

           public function getsupplierbranch($branchid)
           {
                $result=$this->db->query("SELECT * FROM supplier INNER JOIN accountledger ON supplier.supplieraccount=accountledger.ledgerid INNER JOIN branch on supplier.branch = branch.branchid WHERE supplier.branch='$branchid'");
                return $result;                   

           }
           public function getsupplierbybranch1($branchid)
           {
                $result=$this->db->query(" SELECT * FROM supplier INNER JOIN accountledger ON supplier.supplieraccount=accountledger.ledgerid INNER JOIN branch on supplier.branch = branch.branchid where branch.branchid ='$branchid'");
    return $result;                   

           }
          public function checkexistence_supplier($value)
          {
           
          	$result=$this->db->query("SELECT * FROM supplier where suppliername = '$value'");
          	return $result->num_rows() ;

          }
                 public function insert_product($data)
         {
           $groupid=$data['groupid'];
          $balance1= $this->db->query("select groupcode,children from product_group where groupid='$groupid'");
           $balance1=$balance1->result_array();
          $groupcode =$balance1[0]['groupcode'];
          $child=$balance1[0]['children'];
           $pad_length = 4;
          $pad_char = 0;
          $str_type = 'd'; // treats input as integer, and outputs as a (signed) decimal number

            $format = "%{$pad_char}{$pad_length}{$str_type}"; // or "%04d"

$formatted_str = sprintf($format,$child);
$data['searchcode']=$groupcode."-".$formatted_str;
// $data['children']=1;
 $upd= $this->db->query("UPDATE product_group SET children=children+1 WHERE groupid='$groupid'");
           $result=$this->db->insert('product',$data);
           if($result)
           {
             return true;
           }
           else
                     {
                       return false;
                     }
         }
          public function delete_multiunitbyproduct($code)
     {
      $result=$this->db->query("DELETE from multiunit where product_id='$code'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      } 
     }
          public function Loadstockbycode($code)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock ,t9.sizevalue,t7.branchname,t8.batchname ,t6.size,t6.batch_date
            from product_group AS t1
            INNER JOIN product AS t2 ON t1.groupid=t2.groupid
            INNER JOIN brand AS t3 ON t3.brandid=t2.brandid
            INNER JOIN unit AS t4 ON t4.unitid=t2.unitid
            INNER join stock AS t6 on t2.pdt_code=t6.productid
              INNER JOIN branch AS t7 on t6.branch =t7.branchid
              INNER join batch AS t8 on t6.batchid = t8.batchid
               INNER join size AS t9 on t6.size = t9.sizeid where t6.productid='$code'
            ORDER by t2.pdt_id ASC ");
            return $result->result_array();
          }

         
         public function getproduct()
         {
           $query=$this->db->query("SELECT product.*,SUM(stock.currentstock),unit.unitid,unit.unitname,product_group.groupid,product_group.groupname,brand.brandid,brand.brandname,product_group.taxlow,product_group.slab,product_group.taxhigh FROM product LEFT JOIN unit on product.unitid=unit.unitid LEFT JOIN product_group on product.groupid=product_group.groupid LEFT JOIN brand on product.brandid=brand.brandid LEFT JOIN stock on product.pdt_code=stock.productid GROUP BY product.pdt_code");
           return $query;
         }
          public function getproduct1()
         {
           $query=$this->db->query("SELECT product.*,(SELECT SUM(stock.currentstock) FROM stock WHERE stock.productid=product.pdt_code GROUP BY stock.productid) AS stock,unit.unitid,unit.unitname,product_group.groupid,product_group.groupname,brand.brandid,brand.brandname,product_group.taxlow,product_group.slab,product_group.taxhigh FROM product LEFT JOIN unit on product.unitid=unit.unitid LEFT JOIN product_group on product.groupid=product_group.groupid LEFT JOIN brand on product.brandid=brand.brandid GROUP BY product.pdt_code");
           return $query;
         }

          
          public function checkexistence_product($value)
          {
           
          	$result=$this->db->query("SELECT * FROM product where pdt_name = '$value'");
          	return $result->num_rows() ;
          }
           public function checkexistence_product1($name,$code)
          {
           
            $result=$this->db->query("SELECT * FROM product where pdt_name = '$value' OR pdt_code='$code'");
            return $result->num_rows() ;

          }
          public function delete_productgroup($id)
          {
            $result=$this->db->query("DELETE from product_group where groupid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
          public function update_productgroup($id,$data)
          {  $groupid=$data['groupunder'];
          $balance1= $this->db->query("select groupcode,children from product_group where groupid='$groupid'");
           $balance1=$balance1->result_array();
          $groupcode =$balance1[0]['groupcode'];
          $child=$balance1[0]['children'];
          $balance2= $this->db->query("select groupcode,children from product_group where groupid='$id'");
           $balance2=$balance2->result_array();
          $groupcode2 =$balance2[0]['groupcode'];
           $pad_length = 2;
          $pad_char = 0;
          $str_type = 'd'; // treats input as integer, and outputs as a (signed) decimal number

            $format = "%{$pad_char}{$pad_length}{$str_type}"; // or "%04d"

$formatted_str = sprintf($format,$child);
$data['groupcode']=$groupcode."-".$formatted_str;
$gpcd=$data['groupcode'];
 // $data['children']=1;

 $upd= $this->db->query("UPDATE product SET searchcode = REPLACE(searchcode,'$groupcode2','$gpcd') WHERE LOCATE('$groupcode2',searchcode)=1");
 $upd= $this->db->query(" UPDATE product_group  SET groupcode= REPLACE(groupcode,'$groupcode2','$gpcd') WHERE LOCATE('$groupcode2',groupcode)=1");
  
 $upd= $this->db->query("UPDATE product_group SET children=children+1 WHERE groupid='$groupid'");
            $this->db->where('groupid',$id);
            $this->db->update('product_group',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }


          public function update_product($id,$data)
          {
           $groupid=$data['groupid'];
           $balance1= $this->db->query("select groupcode,children from product_group where groupid='$groupid'");
           $balance1=$balance1->result_array();
           $groupcode =$balance1[0]['groupcode'];
           $child=$balance1[0]['children'];
           $pad_length = 4;
           $pad_char = 0;
        $str_type = 'd'; // treats input as integer, and outputs as a (signed) decimal number

          $format = "%{$pad_char}{$pad_length}{$str_type}"; // or "%04d"

          $formatted_str = sprintf($format,$child);
          $data['searchcode']=$groupcode."-".$formatted_str;
// $data['children']=1;
          $upd= $this->db->query("UPDATE product_group SET children=children+1 WHERE groupid='$groupid'");
          $this->db->where('pdt_id',$id);
          $this->db->update('product',$data);
          if($this->db->affected_rows()>0){
            return true;
          }
          else {
            return false;
          }
        }
           public function delete_product($id)
          {
            $result=$this->db->query("DELETE from product where pdt_id='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
          public function insert_munit($data)
          {
            $q=$this->db->insert('multiunit',$data);
            $id = $this->db->insert_id();
            if($q){
              return $id;
            }  
            else
            {
              return false;
            }
          }


          public function Fineyear()
          {
            $this->db->select("*");
            $this->db->from('finyear');
            $this->db->where('fin_status',1);
            $query = $this->db->get();
            // print_r($this->db->last_query());
            $row  = $query->row();
            return $row->finyear_id;
          }

          public function checkcurrency($branchid)
          {
            $this->db->select('*');
            $this->db->from('branch');
            $this->db->where('branchid',$branchid);
            $query = $this->db->get();
            // print_r($this->db->last_query());
            $row  = $query->row();
            return $row->currencyid;
          }
     
     
     public function getmunit()
     {
     	$q=$this->db->query("SELECT multiunit.multi_id,multiunit.unit,multiunit.rate,multiunit.product_id,product.pdt_name,unit.unitname,unit.unitid,multiunit.count from multiunit INNER JOIN product ON product.pdt_id=multiunit.product_id INNER JOIN unit ON multiunit.bunit=unit.unitid  ORDER BY multiunit.multi_id");
     	return $q;
     }
     public function update_multiunit($id,$data)
     {
     	     $this->db->where('multi_id',$id);

            $this->db->update('multiunit',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
     }
      public function update_productunit($id,$data)
     {    $bunit=$data["bunit"];
     $unitname=$data["unit"];
         $result=  $this->db->query("UPDATE multiunit set bunit='$bunit' where product_id ='$id'");
           
            
                                    if($this->db->affected_rows()>0){
                                       $result=  $this->db->query("UPDATE multiunit set unit='$unitname' where product_id ='$id' and count='1'");
                                       
                                    return true;
                                  
                                      }
                                      else {
                                        return false;
                                      }
     }

     public function delete_multiunit($id)
     {
      $result=$this->db->query("DELETE from multiunit where multi_id='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }	
     }
       public function Autogenerate_pdt()
          {
            $query=$this->db->query("SELECT IFNULL(max(pdt_id+1),1) as NO from product");
            return $query;
          }

          public function Autogenerate_ReturnNo($branchid)
          {
            $query=$this->db->query("SELECT IFNULL(max(invoiceno+1),1) as NO from salesreturnmaster WHERE branchid='$branchid'");
            return $query;
          }


          public function Autogenerate_VoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchaseinvoicemaster");
            return $query;
          }

          public function Autogenerate_PurRetNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchasereturnmaster");
            return $query;
          }

          public function insert_purchaseinvoiceMaster($data)
         {
               $result=$this->db->insert('purchaseinvoicemaster',$data);
                     
                     if($result){
                      return true;
                     }  
                     else
                     {
                      return false;
                     }
         }
         
         public function insert_purchaseinvoicedetails($data)
         {
          $result=$this->db->insert('purchaseinvoicedetials',$data);

          if($result){
            return true;
          }  
          else
          {
            return false;
          }
        }

        public function update_purchaseinvoiceMaster($id,$data)
          {
            $this->db->where('pur__inv_masterid',$id);
            $this->db->update('purchaseinvoicemaster',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }

          public function checkexistence_Voucherno($value)
          {
           
            $result=$this->db->query("SELECT * FROM purchaseinvoicemaster where voucherno = '$value'");
            return $result->num_rows() ;

          }


          



          public function getaccountgroup()
         {
          $result=$this->db->query("SELECT * FROM accountgroup where accountgroupid != '1'");
          return $result;
         }

         public function insert_accountgroup($data)
         {
            $result=$this->db->insert('accountgroup',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
         }
         public function delete_accountgroup($id)
          {
            $result=$this->db->query("DELETE from accountgroup where accountgroupid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
           public function update_accountgroup($id,$data)
          {
            $this->db->where('accountgroupid',$id);
            $this->db->update('accountgroup',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
           public function checkexistence_accountgroup($value)
          {
           
            $result=$this->db->query("SELECT * FROM accountgroup where accountgroup = '$value'");
            return $result->num_rows() ;

          }

         public function FiilTableAccountgroup()
          {
            $result=$this->db->query(" SELECT a.accountgroupid,a.accountgroup,a.narration,a.rootid,b.accountgroup as undername,a.under as underid FROM accountgroup a, accountgroup b
              WHERE a.under = b.accountgroupid;");
            return $result;
          }

//account group end

          public function insert_purchaseinvoicedetailes($data)
          {
            $query=$this->db->insert('purchaseinvoicedetials',$data);
            return $query;
          }

 //ACCOUNTLEDGER_START
           public function getaccountledger()
           {
                $result=$this->db->get('accountledger');
                 return $result;                  
           }

           public function getaccountledgerbranch($branchid)
           {
                $result=$this->db->query("SELECT * FROM accountledger WHERE branchid ='$branchid'");
                return $result;                  

           }

            public function getpaymentledger()
           {    
                $result= $query=$this->db->query("SELECT accountledger.* from accountledger INNER JOIN accountgroup ON accountledger.accountgroup=accountgroup.accountgroupid WHERE accountgroup.rootid ='2' or accountgroup.rootid ='4'");
                 return $result;                  

           }
            public function getpaymentledgerbybranch($branchid)
           {    
                $result= $query=$this->db->query("SELECT accountledger.* from accountledger INNER JOIN accountgroup ON accountledger.accountgroup=accountgroup.accountgroupid WHERE  accountgroup.rootid ='4' AND accountledger.branchid='$branchid' ");
                 return $result;                  

           }

           public function insert_accountledger($data)
         {
            $result=$this->db->insert('accountledger',$data);

            if($result)
            { $result =$this->db->insert_id();
              return $result;
            }
            else
            {
              return false;
            }
         }

         public function getrootid($getrootid)
         {
          $query=$this->db->query("SELECT * from accountgroup WHERE accountgroupid ='$getrootid'");
          foreach ($query->result_array() as $row)
          {
            return $row['rootid'];
          }
          
         }

        

         public function delete_accountledger($id)
          {
            $result=$this->db->query("DELETE from accountledger where ledgerid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }

          public function delete_ledgercustomer($pho)
          {
            $result=$this->db->query("DELETE from accountledger where ledgername='$pho'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

           public function update_accountledger($id,$ledgername,$branchid)
          {
            $result=$this->db->query("UPDATE accountledger SET ledgername='$ledgername',branchid ='$branchid' WHERE ledgerid='$id'");
                                    
                                    return $result;

          }

          public function api_update_accountledger($account,$insertdata2)
          {
            $this->db->where('ledgerid',$account);
            $this->db->update('accountledger',$insertdata2);
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }
           public function checkexistence_accountledger($value)
          {
           
            $result=$this->db->query("SELECT * FROM accountledger where ledgername = '$value'");
            return $result->num_rows() ;

          }

          public function FiilTableAccountledger()
          {
            // $result=$this->db->query("SELECT  t1.accountgroup as accountgroupname,ledgerid,ledgername,t2.accountgroup,interestcalculation,openingbalance,creditordebit,t2.narration,currentbalance FROM accountgroup as t1 INNER JOIN accountledger as t2 ON t1.accountgroupid = t2.accountgroup");
            // $result=$this->db->query("SELECT  t1.accountgroup as accountgroupname,ledgerid,ledgername,t2.accountgroup,interestcalculation,openingbalance,creditordebit,t2.narration,currentbalance FROM accountgroup as t1 INNER JOIN accountledger as t2 ON t1.accountgroupid = t2.accountgroup");
            $result=$this->db->query("SELECT * FROM accountledger INNER JOIN accountgroup ON accountledger.accountgroup=accountgroup.accountgroupid ");
            return $result;
          }
          //Accountledger_End
          public function getpurchase()
          {
                $query=$this->db->query("SELECT purchaseinvoicemaster.purchasemasterid,purchaseinvoicemaster.voucherno,purchaseinvoicemaster.vendorinvoiceno,purchaseinvoicemaster.paymentmode,purchaseinvoicemaster.suppliername,purchaseinvoicemaster.invoicedate,purchaseinvoicemaster.orderno,purchaseinvoicemaster.totalqty,purchaseinvoicemaster.totalamount,purchaseinvoicemaster.additionalcost,purchaseinvoicemaster.taxamount,purchaseinvoicemaster.billdiscount,purchaseinvoicemaster.grandtotal,purchaseinvoicemaster.oldbalance,purchaseinvoicemaster.cash,purchaseinvoicemaster.bank,purchaseinvoicemaster.paidcash,purchaseinvoicemaster.paidbank,purchaseinvoicemaster.balance,purchaseinvoicemaster.narration,purchaseinvoicemaster.transportcompany,purchaseinvoicedetials.purchasedetailsid,purchaseinvoicedetials.voucherno,purchaseinvoicedetials.productname,purchaseinvoicedetials.productcode,purchaseinvoicedetials.qty,purchaseinvoicedetials.unitprice,purchaseinvoicedetials.netamount,purchaseinvoicedetials.tax,purchaseinvoicedetials.taxamount,purchaseinvoicedetials.amount from purchaseinvoicemaster INNER JOIN purchaseinvoicedetials on purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno");
                
          
          }

    public function save_product($data){
      // {: , :, :group,unitid:unit,brandid:brand,tax:tax,mrp:price,openingstock:qty
     
        $result=$this->db->insert('product',$data);
        return $result;
    }
   
    
  
             //Branch_start

          public function getBranch()
          {
            $result=$this->db->get('branch');
            return $result;
          }
          public function getUserBranch($branchid)
          {
            $this->db->where('branchid',$branchid);
            $result=$this->db->get('branch');
            return $result;
          }

          public function insert_branch($data)
          {
            $result=$this->db->insert('branch',$data);
            if($result)
            { $result =$this->db->insert_id();
              return $result;
            }
            else
            {
              return false;
            }
          }

          public function update_branch($id,$data)
          {
            $this->db->where('branchid',$id);
            $this->db->update('branch',$data);
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }



         
          public function delete_branch($id)
          {
            $this->db->where('branchid',$id);
            $this->db->delete('branch');
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }

          }

          public function checkexistence_branch($value)
          {
           
            $result=$this->db->query("SELECT * FROM branch where branchname = '$value'");
            return $result->num_rows() ;

          }

          public function checkexistence_customer($code,$pho)
          {
           
            $result=$this->db->query("SELECT * FROM customer WHERE phonenumber='$pho' OR customercode='$code'");
            return $result->num_rows();
          }
           public function api_checkexistence_customer($code,$pho)
          {
           
            $result=$this->db->query("SELECT * FROM customer WHERE phonenumber='$pho' OR customercode='$code'");
            return $result;
          }


          //Branch_End

          //AddUser_Start

          public function getadduser()
          {
            $result=$this->db->get('adduser');
            return $result;
          }

          public function insert_adduser($data)
          {
            $result=$this->db->insert('adduser',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function insertcostpayment($data)
          {
            $this->db->insert('costpayment',$data);
            $result = $this->db->insert_id();
            return $result;
          }

          public function costaccount($paidamount,$bankledger,$supaccnt)
          {
            if($paidamount>0)
            {
              $query1= $this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$paidamount WHERE ledgerid='$supaccnt'");
              $query1= $this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$paidamount WHERE ledgerid='$bankledger'");
             }
            return $query1;
          }

          public function update_adduser($data,$id)
          {
            $this->db->where('userid',$id);
            $result=$this->db->update('adduser',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function delete_adduser($id)
          {
            $id=$this->db->where('userid',$id);
            $result=$this->db->delete('adduser');
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function checkexistence_adduser($value)
          {
            $result=$this->db->query("SELECT * from adduser where username='$value'");
            return $result->num_rows();
          }
          


          //AddUser_End

          //ChangePassword_Start

          public function CheckUser($username)
          {
            $result=$this->db->query("SELECT *,branch.phonenumber AS branchpho from adduser JOIN branch ON adduser.branch=branch.branchid WHERE adduser.username='$username'");
            if ($result->num_rows()>0) 
                {
                return $result;
                }
            else
            {
              return false;
            }
          }
        // public function converttohash($id,$password)
        // {
        //   $result=$this->db->query("UPDATE adduser SET password='$password' where userid ='$id'");
        //   if($result)
        //   {
        //     return true;
        //   }
        //   else
        //   {
        //     return false;
        //   }

        // }

          public function update_user($username,$columns)
          {
            $this->db->where('username',$username);
            $result=$this->db->update('adduser',$columns);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }


          //ChangePassword_End

          //PurchaseReport_Start

         

          //PurchaseReport_End
           //PurchaseReport_Start
           public function FillProduct()
         {
           $query=$this->db->query("SELECT * FROM product INNER JOIN unit on product.unitid=unit.unitid
            ORDER BY product.pdt_id ASC");
           return $query;
         }
         public function getalluser()
         {
           $query=$this->db->query("SELECT * FROM adduser");
           return $query;
         }

        public function getuserid($userid)
        {
          $query=$this->db->query("SELECT * FROM adduser WHERE userid='$userid'");
          return $query;
        }

          public function LoadPurchaseDetails_All($fromdate,$todate)
          {
            $result=$this->db->query("SELECT * from purchaseinvoicedetials where invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

           public function LoadPurchaseDetails_All_branch($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicemaster WHERE branchid='$branchid' AND invoicedate BETWEEN '$fromdate' AND '$todate'");
            // print_r($this->db->last_query());

           return $result;
          }

          public function LoadPurchaseReturnDetails_All_branch($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM purchasereturnmaster WHERE branchid='$branchid' AND invoicedate BETWEEN '$fromdate' AND '$todate'");
            // print_r($this->db->last_query());

           return $result;
          }

          public function LoadPurchaseDetails_AllBranch($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT purchaseinvoicedetials.* from purchaseinvoicedetials INNER JOIN purchaseinvoicemaster ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno where purchaseinvoicedetials.invoicedate between '$fromdate' and '$todate' AND purchaseinvoicemaster.branchid='$branchid'");

            print_r($this->db->last_query());
            return $result;
          }

          public function Loadpurchasedetails_Supplierwise($fromdate,$todate,$supplier)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicemaster inner join purchaseinvoicedetials
            ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno
            WHERE purchaseinvoicemaster.suppliername='$supplier' and purchaseinvoicedetials.invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

          public function Loadpurchasedetails_SupplierwiseBranch($fromdate,$todate,$supplier,$branchid)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicemaster inner join purchaseinvoicedetials
            ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno
            WHERE purchaseinvoicemaster.suppliername='$supplier' and purchaseinvoicedetials.invoicedate between '$fromdate' and '$todate' AND purchaseinvoicemaster.branchid='$branchid'");
            return $result;
          }

          public function Loadpurchasedetails_ProductNamewise($fromdate,$todate,$productname)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicedetials where productname='$productname' and invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

          public function Loadpurchasedetails_ProductNamewiseBranch($fromdate,$todate,$productname,$branchid)
          {
            $result=$this->db->query("SELECT purchaseinvoicedetials.* FROM purchaseinvoicedetials INNER JOIN purchaseinvoicemaster ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno where purchaseinvoicedetials.productname='$productname' and purchaseinvoicedetials.invoicedate between '$fromdate' and '$todate' AND purchaseinvoicemaster.branchid='$branchid'");
            return $result;
          }

          //PurchaseReport_End

          //StockReport_Start
          
          
          public function LoadAllstock()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t2.pdt_code,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadAllstock2()
          {
            $result=$this->db->query("SELECT t2.pdt_id, t2.pdt_code,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock_old_new AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            ORDER by t2.pdt_id ASC");
            return $result;
          }
  
          public function LoadAllstock_branch($a,$fromdate,$todate)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t2.pdt_code,t2.purchaserate,t2.mrp,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t6.stockid,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid

LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
from salesinvoicedetails
GROUP BY productname) AS t22
ON t2.pdt_name=t22.productname

            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.branch='$a' AND t22.salesdate between '$fromdate' and '$todate'
            ORDER by t2.pdt_id ASC");
            return $result;

          }
  
          public function LoadAllstock_branch_only($a)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t2.pdt_code,t2.purchaserate,t2.mrp,t1.groupid,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
              from product_group AS t1
              LEFT JOIN product AS t2 ON t1.groupid=t2.groupid

              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t22
              ON t2.pdt_name=t22.productname

              LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
              LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
              LEFT join stock AS t6 on t2.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              WHERE t6.branch='$a'
              ORDER by t2.pdt_id ASC");

            // print_r($this->db->last_query());
            return $result;

          }

          public function LoadAllstock_branch_only_group($a,$groupid)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t2.pdt_code,t2.purchaserate,t2.mrp,t1.groupid,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
              from product_group AS t1
              LEFT JOIN product AS t2 ON t1.groupid=t2.groupid

              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t22
              ON t2.pdt_name=t22.productname

              LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
              LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
              LEFT join stock AS t6 on t2.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              WHERE t6.branch='$a' AND t2.groupid = $groupid AND t6.currentstock > 0 
              ORDER by t2.pdt_id ASC");

            // print_r($this->db->last_query());
            return $result;

          }

          // SELECT t2.pdt_id,t2.pdt_name,t2.pdt_code,t2.purchaserate,t2.mrp,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue from product_group AS t1 LEFT JOIN product AS t2 ON t1.groupid=t2.groupid LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate from salesinvoicedetails GROUP BY productname) AS t22 ON t2.pdt_name=t22.productname LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid LEFT join stock AS t6 on t2.pdt_code=t6.productid LEFT JOIN branch AS t7 on t6.branch =t7.branchid LEFT join batch AS t8 on t6.batchid = t8.batchid LEFT join size AS t9 on t6.size = t9.sizeid WHERE t6.branch='30' ORDER by t2.pdt_id ASC


          public function LoadAllstock_branch_only_group_below2t($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp <= 2000 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            // print_r($this->db->last_query());

            return $result;

          }


          public function LoadAllstock_branch_only_group_2t2_5($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 2000 AND 2500 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            return $result;

          }

          public function LoadAllstock_branch_only_group_2_5t3($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 2500 AND 3000 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            return $result;

          }


          public function LoadAllstock_branch_only_group_3t3_5($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 3000 AND 3500 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC ");

            // print_r($this->db->last_query());

            return $result;

          }

          public function LoadAllstock_branch_only_group_3_5t4($a,$groupid)
          {

          $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',  t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 3500 AND 4000 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            return $result;

          }

          public function LoadAllstock_branch_only_group_4t4_5($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 4000 AND 4500 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            return $result;

          }

          public function LoadAllstock_branch_only_group_4_5t5($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp BETWEEN 4500 AND 5000 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            // print_r($this->db->last_query());

            return $result;

          }

          public function LoadAllstock_branch_only_group_above5t($a,$groupid)
          {
            $result=$this->db->query("SELECT t1.*, SUM(t1.currentstock) AS currntStock, COUNT(t1.size) AS sizeCount, GROUP_CONCAT(distinct t3.sizevalue,'.',t1.currentstock separator ', ') AS site_list, t2.pdt_name  FROM stock AS t1 INNER JOIN product AS t2 ON t1.productid=t2.pdt_code INNER JOIN size As t3 ON t1.size = t3.sizeid WHERE t1.branch='$a' AND t2.groupid = '$groupid' AND t2.mrp >= 5000 AND t1.currentstock > 0 GROUP BY `productid` ORDER BY currntStock DESC");

            return $result;

          }

          public function LoadAllstock_branch_only2($a)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_code,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
              from product_group AS t1
              LEFT JOIN product AS t2 ON t1.groupid=t2.groupid

              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t22
              ON t2.pdt_name=t22.productname

              LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
              LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
              LEFT join stock_old_new AS t6 on t2.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              WHERE t6.branch='$a'
              ORDER by t2.pdt_id ASC");

            // print_r($this->db->last_query());
            return $result;

          }

          public function LoadAllstockbranch($branchid)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.branch='$branchid'
            ORDER by t2.pdt_id ASC");
            return $result;
          }


          public function LoadNegativeStock()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.currentstock<'0'
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadNegativeStockbranch($branchid)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.currentstock<'0' 
            AND t6.branch='$branchid'
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadReorderLevel()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.currentstock<t2.minimumstock
            ORDER by t2.pdt_id ASC");
            return $result;
          }


          public function LoadReorderLevelbranch($branchid)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t6.currentstock<t2.minimumstock
            AND t6.branch='$branchid'
            ORDER by t2.pdt_id ASC");
            return $result;
          }
          

           public function LoadUnused()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT JOIN salesinvoicedetails AS t5
            on t2.pdt_name=t5.productname
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t5.productname is null
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadUnusedbranch($branchid)
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue 
            from product_group AS t1
            LEFT JOIN product AS t2 ON t1.groupid=t2.groupid
            LEFT JOIN brand AS t3 ON t3.brandid=t2.brandid
            LEFT JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT JOIN salesinvoicedetails AS t5
            on t2.pdt_name=t5.productname
            LEFT join stock AS t6 on t2.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t5.productname is null
            AND t6.branch='$branchid'
            ORDER by t2.pdt_id ASC");
            return $result;
          }

        

          public function LoadFastMoving()
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2 ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              order by QTY DESC");
            return $result;
          }


          public function LoadFastMovingbranch($branchid)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2 ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              WHERE t6.branch='$branchid'
              order by QTY DESC");
            return $result;
          }

          public function LoadSlowMoving()
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              order by QTY ASC");
            return $result;
          }


          public function LoadSlowMovingbranch($branchid)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
              WHERE t6.branch='$branchid'
              order by QTY ASC");
            return $result;
          }

       
          public function LoadFastMovingBtwDates($fromdate,$todate)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
             WHERE t2.salesdate between '$fromdate' and '$todate'
              order by QTY DESC");
            return $result;
          }


          public function LoadFastMovingBtwDatesbranch($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
            LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
            from salesinvoicedetails
            GROUP BY productname) AS t2
            ON t1.pdt_name=t2.productname
            LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
            LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
            LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
            LEFT join stock AS t6 on t1.pdt_code=t6.productid
            LEFT JOIN branch AS t7 on t6.branch =t7.branchid
            LEFT join batch AS t8 on t6.batchid = t8.batchid
            LEFT join size AS t9 on t6.size = t9.sizeid
            WHERE t2.salesdate between '$fromdate' and '$todate'
            AND t6.branch='$branchid'
            order by QTY DESC");
            return $result;
          }

          public function LoadSlowMovingBtwDates($fromdate,$todate)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
             WHERE t2.salesdate between '$fromdate' and '$todate'
              order by QTY ASC");
            return $result;
          }

          public function LoadSlowMovingBtwDatesbranch($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t6.currentstock,t7.branchname,t8.batchname,t9.sizevalue  FROM product AS t1
              LEFT JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              LEFT JOIN product_group AS t3 ON t3.groupid=t1.groupid
              LEFT JOIN brand AS t4 ON t4.brandid=t1.brandid
              LEFT JOIN unit AS t5 ON t5.unitid=t1.unitid
              LEFT join stock AS t6 on t1.pdt_code=t6.productid
              LEFT JOIN branch AS t7 on t6.branch =t7.branchid
              LEFT join batch AS t8 on t6.batchid = t8.batchid
              LEFT join size AS t9 on t6.size = t9.sizeid
             WHERE t2.salesdate between '$fromdate' and '$todate'
             AND t6.branch='$branchid'
              order by QTY ASC");
            return $result;
          }


          // created at 02-10-2020
        //  To get all unpaid orders of a customer
        public function api_customerUnpaidOrders($customerid)
        {
          $query=$this->db->query("SELECT * FROM `ecommerce_ordermaster` WHERE balance !=0 AND customerid='$customerid'");
          return $query->result_array();
        }

         // created at 02-10-2020
        //  To get all processing orders of a customer
        public function api_customerProcessingOrders($customerid)
        {
          $query=$this->db->query("SELECT ecommerce_ordermaster.eCommerce_id,ecommerce_ordermaster.eCommerce_no,ecommerce_ordermaster.payment_mode,ecommerce_ordermaster.rzp_orderId,ecommerce_ordermaster.salesman,ecommerce_ordermaster.customerid,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.date_current,ecommerce_ordermaster.narration,ecommerce_ordermaster.totalqty,ecommerce_ordermaster.totalamount,ecommerce_ordermaster.taxamount,ecommerce_ordermaster.additionalcost,ecommerce_ordermaster.billdiscount,ecommerce_ordermaster.grandtotal,ecommerce_ordermaster.oldbalance,ecommerce_ordermaster.cash,ecommerce_ordermaster.bank,ecommerce_ordermaster.pdt_desc,ecommerce_ordermaster.image_path,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_ordermaster.shipping_address,ecommerce_ordermaster.balance,ecommerce_ordermaster.userid,ecommerce_ordermaster.branchid,ecommerce_ordermaster.stockamount,ecommerce_ordermaster.status,ecommerce_ordermaster.stitch,ecommerce_ordermaster.dispatch,ecommerce_ordermaster.received,ecommerce_ordermaster.delivery FROM `ecommerce_ordermaster` LEFT JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid WHERE ecommerce_orderdetails.status!='Shipped' AND ecommerce_orderdetails.status!='Delivered' AND ecommerce_orderdetails.status!='Refunded' AND ecommerce_ordermaster.customerid='$customerid'");
          return $query->result_array();
        }

         // created at 02-10-2020
        //  To get all processing orders of a customer
        public function api_customerShippedOrders($customerid)
        {
          $result=$this->db->query("SELECT ecommerce_ordermaster.eCommerce_id,ecommerce_ordermaster.eCommerce_no,ecommerce_ordermaster.payment_mode,ecommerce_ordermaster.rzp_orderId,ecommerce_ordermaster.salesman,ecommerce_ordermaster.customerid,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.date_current,ecommerce_ordermaster.narration,ecommerce_ordermaster.totalqty,ecommerce_ordermaster.totalamount,ecommerce_ordermaster.taxamount,ecommerce_ordermaster.additionalcost,ecommerce_ordermaster.billdiscount,ecommerce_ordermaster.grandtotal,ecommerce_ordermaster.oldbalance,ecommerce_ordermaster.cash,ecommerce_ordermaster.bank,ecommerce_ordermaster.pdt_desc,ecommerce_ordermaster.image_path,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_ordermaster.shipping_address,ecommerce_ordermaster.balance,ecommerce_ordermaster.userid,ecommerce_ordermaster.branchid,ecommerce_ordermaster.stockamount,ecommerce_ordermaster.status,ecommerce_ordermaster.stitch,ecommerce_ordermaster.dispatch,ecommerce_ordermaster.received,ecommerce_ordermaster.delivery FROM `ecommerce_ordermaster` LEFT JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid WHERE ecommerce_orderdetails.status='Shipped' AND ecommerce_ordermaster.customerid='$customerid'");
          return $result->result_array();
        }

        // created at 02-10-2020
        // to get products details of a order by master id
        public function api_customerOrderDetails($eordermasterid)
        {
          $data=$this->db->query("SELECT ecommerce_orderdetails.eorderdetailsid AS detailsId,ecommerce_orderdetails.eordermasterid AS masterId,ecommerce_orderdetails.eCommerce_no AS eCommerceNo,ecommerce_orderdetails.vouchercode AS voucherCode,ecommerce_orderdetails.rewardspoint AS rewardsPoint,ecommerce_orderdetails.shippingaddress AS shippingAddress,ecommerce_orderdetails.orderdate AS orderDate,ecommerce_orderdetails.productname AS productName,
          ecommerce_orderdetails.productcode AS productCode,ecommerce_orderdetails.hsncode AS hsnCode,ecommerce_orderdetails.qty,ecommerce_orderdetails.unitprice AS unitPrice,ecommerce_orderdetails.netamount AS netAmount,ecommerce_orderdetails.tax,ecommerce_orderdetails.taxamount AS taxAmount,ecommerce_orderdetails.amount,ecommerce_orderdetails.branchid AS branchId,ecommerce_orderdetails.batchid AS batchId,ecommerce_orderdetails.description,ecommerce_orderdetails.status,ecommerce_orderdetails.productcost AS productCost,product.imagpath AS productImage,ecommerce_orderdetails.size AS sizeId,size.sizevalue AS sizeValue FROM `ecommerce_orderdetails` INNER JOIN size ON ecommerce_orderdetails.size=size.sizeid INNER JOIN product ON ecommerce_orderdetails.productcode=product.pdt_code WHERE ecommerce_orderdetails.eordermasterid='$eordermasterid'");
          return $data->result_array();
        }

        // created at 10-10-2020
        //  To get all orders of a customer
        public function api_customerAllOrders($customerid)
        {
          $query=$this->db->query("SELECT * FROM `ecommerce_ordermaster` WHERE customerid='$customerid' ORDER BY date_current DESC");
          return $query->result_array();
        }

          // created at 10-10-2020
        //  To get all Delivered orders of a customer
        public function api_customerDeliveredOrders($customerid)
        {
          $result=$this->db->query("SELECT ecommerce_ordermaster.eCommerce_id,ecommerce_ordermaster.eCommerce_no,ecommerce_ordermaster.payment_mode,ecommerce_ordermaster.rzp_orderId,ecommerce_ordermaster.salesman,ecommerce_ordermaster.customerid,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.date_current,ecommerce_ordermaster.narration,ecommerce_ordermaster.totalqty,ecommerce_ordermaster.totalamount,ecommerce_ordermaster.taxamount,ecommerce_ordermaster.additionalcost,ecommerce_ordermaster.billdiscount,ecommerce_ordermaster.grandtotal,ecommerce_ordermaster.oldbalance,ecommerce_ordermaster.cash,ecommerce_ordermaster.bank,ecommerce_ordermaster.pdt_desc,ecommerce_ordermaster.image_path,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_ordermaster.shipping_address,ecommerce_ordermaster.balance,ecommerce_ordermaster.userid,ecommerce_ordermaster.branchid,ecommerce_ordermaster.stockamount,ecommerce_ordermaster.status,ecommerce_ordermaster.stitch,ecommerce_ordermaster.dispatch,ecommerce_ordermaster.received,ecommerce_ordermaster.delivery FROM `ecommerce_ordermaster` LEFT JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid WHERE ecommerce_orderdetails.status='Delivered' AND ecommerce_ordermaster.customerid='$customerid'");
          return $result->result_array();
        }



public function get_pdt_id($a)
{
  $query=$this->db->query("SELECT pdt_code FROM product WHERE pdt_name ='$a'");

  foreach ($query->result_array() as $row)
  {
  log_message('error', "===".$row['pdt_code']);

    return $row['pdt_code'];
  }

}

public function getn()
{
  $a=$this->db->query("SELECT pdt_name FROM product");
  return $a;
}

function getsearchresult($name)
{   
    $select = $this->db->query("SELECT * FROM product WHERE pdt_name LIKE '%".$name."%'");
    return $select;
}
public function getvoucher()
{
  $vou=$this->db->query("SELECT * FROM purchaseinvoicemaster order by invoicedate desc");
  return $vou;
}

public function all_accountledger()
          {
           
            $result=$this->db->query("SELECT * FROM accountledger");
            return $result;

          }

          public function Select_ledger($ledgername)
          {
             return $this->db->
            select('*')->
            from('accountledger')->
            where('ledgerid', $ledgername)->
            get()->row_array();
          }

          public function delete_cheque($id)
        {
          $result=$this->db->query("DELETE from cheque where id='$id'");
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }


        public function update_chequestatus($status,$id)
          {
            $result=$this->db->query("UPDATE cheque SET status='$status' WHERE id='$id'");
            return $result;
          }

          public function getpaymentvoucher()
        {
          $result=$this->db->query("SELECT paymentvoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=paymentvoucher.cashorbank) as cash  from paymentvoucher inner join accountledger on paymentvoucher.ledger=accountledger.ledgerid where paymentvoucher.deleted!=1");
          return $result;
        }

          public function getpaymentvoucherbyvoucherno($voucherno)
        {
    $result=$this->db->query("SELECT paymentvoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=paymentvoucher.cashorbank) as cash  from paymentvoucher inner join accountledger on paymentvoucher.ledger=accountledger.ledgerid where voucherno ='$voucherno' AND paymentvoucher.deleted!=1");
    return $result->result_array();
  }
public function getvoucherbydate($fromdate,$todate)
{
  $vou=$this->db->query("SELECT * FROM purchaseinvoicemaster INNER join branch on purchaseinvoicemaster.branchid=branch.branchid where invoicedate BETWEEN '$fromdate' AND '$todate' order by invoicedate desc");
  return $vou;
}
public function get_purmaster($a)
{
  $query=$this->db->query("SELECT * FROM purchaseinvoicemaster WHERE voucherno=$a");
  return $query;
}
public function get_purdetailes($a)
{
  $query=$this->db->query("SELECT * FROM purchaseinvoicedetials WHERE voucherno=$a");
  return $query;
}

//SalesInvoice_Start

public function Autogenerate_InvoiceNo($branchid,$finyear)
{
  $query=$this->db->query("SELECT IFNULL(max(invoiceno+1),1) as NO from salesinvoicemaster WHERE branchid='$branchid' AND  finyear = $finyear ");
  // print_r($this->db->last_query());
  return $query;
} 

public function Autogenerate_InvoiceNoNew($branchid)
{
  $query=array();
  $query=$this->db->query("SELECT IFNULL(max(invoiceno+1),1) as NO from salesinvoicemaster WHERE branchid='$branchid' GROUP BY branchid")->result();
  return $query;
} 

public function Autogenerate_ReturnNoNew($branchid)
{
  $query=array();
  $query=$this->db->query("SELECT IFNULL(max(invoiceno+1),1) as NO from salesreturnmaster WHERE branchid='$branchid' GROUP BY branchid")->result();
  return $query;
} 

          public function supplierdetails()
          {
            $result=$this->db->query("SELECT * FROM supplier");
            return $result;
          }
          
        public function supplierdetailsbranch($branchid)
        {
          $result=$this->db->query("SELECT * FROM supplier WHERE branch='$branchid'");
          return $result;
        }

        public function gethsncode()
        {
          $result=$this->db->query("SELECT hsncode FROM supplier");
          return $result;
        }
          
          
        public function customerdetails()
        {
          $result=$this->db->query("SELECT * FROM customer");
          return $result;
        }

        public function btwncustomer($customerid,$fdate,$tdate)
        {
           $result=$this->db->query("SELECT * from receiptvoucher JOIN customer ON receiptvoucher.ledger = customer.customerid JOIN accountledger ON accountledger.ledgerid=customer.customeraccount WHERE customer.customerid='$customerid' AND receiptvoucher.receiptdate BETWEEN '$fdate' AND '$tdate'");
            return $result;
        }

        public function btwnsupplier($supplierid,$fdate,$tdate)
        {
          $result=$this->db->query("SELECT * from paymentvoucher JOIN supplier ON paymentvoucher.ledger = supplier.supplierid JOIN accountledger ON accountledger.ledgerid=supplier.supplieraccount WHERE supplier.supplierid='$supplierid' AND paymentvoucher.date BETWEEN '$fdate' AND '$tdate'");
           return $result;
       }

        public function  getcustomer()
          {
            $result=$this->db->query("SELECT * FROM customer INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid");
            return $result;
          }    

          public function getdirectStock()
          {
            $result=$this->db->query("SELECT * FROM stock_ulike");
            return $result;
          }  

          public function getdirectStockregister()
          {

            $result=$this->db->query("SELECT stockregister.*,salesinvoicedetails.size AS sizz FROM `stockregister` INNER JOIN salesinvoicedetails ON salesinvoicedetails.invoiceno = stockregister.voucherno WHERE `branch` = 30 AND salesinvoicedetails.productcode=stockregister.`productid` AND stockregister.`transactiontype` = 'Sales Invoice' AND stockregister.qty > 0");
            return $result;
          } 

          public function get_stockSize($branch)
          {
           $result=$this->db->query("SELECT * FROM stock INNER JOIN size ON stock.size=size.sizevalue WHERE stock.branch='$branch'");
           // print_r($this->db->last_query());
           return $result;
         }

           public function delete_customer($id)
          {
            $result=$this->db->query("DELETE from customer where customerid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }

          
          public function api_getcustomerbycode($code,$pho)
          {
            $result=$this->db->query("SELECT * FROM customer WHERE phonenumber='$pho' OR customercode='$code'");
            return $result;
          }

          public function checkexistence_ecomusser($pho,$mail)
          {
            $result=$this->db->query("SELECT * FROM customer WHERE phonenumber='$pho' OR email='$mail'");
            return $result;
          }

          public function update_shprder($a,$data)
          {
            $this->db->where('shoporderno',$a);
            $result = $this->db->update('shoporder',$data);    
           return $result;

          }
           public function update_ecomfromproduction($a,$data)
          {
            $this->db->where('referenceno',$a);
            $result = $this->db->update('ecommerce_orderdetails',$data);    
           return $result;

          }

          public function viewshoporder($cdate)
          {
            $result=$this->db->query("SELECT * FROM shoporder WHERE date_current='$cdate'");
            return $result;
          }

          public function viewshoporderbranch($cdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM shoporder WHERE date_current='$cdate' AND branchid='$branchid'");
            return $result;
          }

          public function ltdshoporder($fdate,$tdate)
          {
            $result=$this->db->query("SELECT * FROM shoporder WHERE date_current BETWEEN '$fdate' and '$tdate'");
            return $result;
          }

          public function ltdshoporderbranch($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM shoporder WHERE date_current BETWEEN '$fdate' AND '$tdate' AND branchid='$branchid'");
            return $result;
          }

          // public function api_getledger($account)
          // {
          //   $result=$this->db->query("SELECT * FROM accountledger WHERE ledgerid='$account'");
          //   return $result;
          // }


          public function api_insertError($data) 
          {
            $result=$this->db->insert('error',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function api_getlogin($user,$pass)
          {
            $result=$this->db->query("SELECT userid,branch,'role',firstname from adduser WHERE username='$user' AND password='$pass'");
            return $result;
          }
          public function api_getproduct()
	        {
            $result=$this->db->query("SELECT * FROM product");
            return $result;
          }

          public function api_getallstock()
	        {
            $result=$this->db->query("SELECT * FROM stock");
            return $result;
          }

          public function api_stockbybranch($branchid)
	        {
            $result=$this->db->query("SELECT * FROM stock WHERE branch='$branchid'");
            return $result;
          }

          public function api_updorderstatus($orderno)
          {
            $result=$this->db->query("UPDATE shoporder SET delivery='1' WHERE shoporderno='$orderno'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }
				
          public function api_updateonlineorderstatus($orderno)
          {
            $result=$this->db->query("UPDATE onlineorder SET delivery='1' WHERE onlineorderno='$orderno'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }      

          public function api_getExpenseLedger($branchid)
	        {
            $result=$this->db->query("SELECT * FROM accountledger WHERE rootid='4' AND branchid='$branchid'");
            return $result;
          }

          public function api_getsalesbybranch($fdate,$tdate,$branchid)
	        {
            $result=$this->db->query("SELECT salesinvoicemaster.salesmasterid,salesinvoicemaster.invoiceno,salesinvoicemaster.salesmode,salesinvoicemaster.salesman,customer.customername AS customerName,customer.phonenumber,salesinvoicemaster.salesdate,salesinvoicemaster.totalqty,salesinvoicemaster.totalamount,salesinvoicemaster.billdiscount,salesinvoicemaster.grandtotal,salesinvoicemaster.oldbalance,salesinvoicemaster.paidcash,salesinvoicemaster.paidbank,salesinvoicemaster.balance,salesinvoicemaster.userid,salesinvoicemaster.branchid,salesman.salesmanname,customer.points AS customerPoint FROM salesinvoicemaster INNER JOIN customer ON salesinvoicemaster.customerid=customer.customerid INNER JOIN salesman ON salesinvoicemaster.salesman=salesman.salesmanid WHERE salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' AND salesinvoicemaster.branchid='$branchid' ORDER BY salesmasterid DESC");
            return $result;
          }

          public function api_getsalesbetweendate($fdate,$tdate,$branchid)
	        {
            $result=$this->db->query("SELECT salesinvoicemaster.salesmasterid,salesinvoicemaster.invoiceno,salesinvoicemaster.salesmode,salesinvoicemaster.salesman,customer.customername,customer.phonenumber AS phoneNumber,salesinvoicemaster.salesdate,salesinvoicemaster.totalqty,salesinvoicemaster.grandtotal,salesinvoicemaster.oldbalance,salesinvoicemaster.billdiscount,salesinvoicemaster.totalamount,salesinvoicemaster.paidcash,salesinvoicemaster.paidbank,salesinvoicemaster.balance,salesinvoicemaster.userid,salesinvoicemaster.branchid,salesman.salesmanname,customer.points AS customerPoint FROM salesinvoicemaster INNER JOIN customer ON salesinvoicemaster.customerid=customer.customerid INNER JOIN salesman ON salesinvoicemaster.salesman=salesman.salesmanid WHERE salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' AND salesinvoicemaster.branchid='$branchid' ORDER BY salesmasterid DESC");
            return $result;
          }

          public function api_getsaleswithcustomer($customerid,$branchid)
	        {
            $result=$this->db->query("SELECT salesinvoicemaster.salesmasterid,salesinvoicemaster.invoiceno,salesinvoicemaster.salesmode,salesinvoicemaster.salesman,customer.customername,customer.phonenumber AS phoneNumber,salesinvoicemaster.salesdate,salesinvoicemaster.totalqty,salesinvoicemaster.grandtotal,salesinvoicemaster.oldbalance,salesinvoicemaster.billdiscount,salesinvoicemaster.totalamount,salesinvoicemaster.paidcash,salesinvoicemaster.paidbank,salesinvoicemaster.balance,salesinvoicemaster.userid,salesinvoicemaster.branchid,salesman.salesmanname,customer.points AS customerPoint FROM salesinvoicemaster INNER JOIN customer ON salesinvoicemaster.customerid=customer.customerid INNER JOIN salesman ON salesinvoicemaster.salesman=salesman.salesmanid WHERE salesinvoicemaster.customerid='$customerid' AND salesinvoicemaster.branchid='$branchid' ORDER BY salesmasterid DESC");
            return $result;
          }

          public function api_salesdetailsbymaster($masterid)
	        {
            $result=$this->db->query("SELECT salesinvoicedetails.productcode AS productCode, salesinvoicedetails.productname AS productName, salesinvoicedetails.qty,salesinvoicedetails.size,salesinvoicedetails.unitprice AS mrp,salesinvoicedetails.amount AS totalAmount,size.sizevalue AS sizeValue FROM `salesinvoicedetails` JOIN size ON salesinvoicedetails.size=size.sizeid WHERE salesmasterid='$masterid'");
            return $result;
          }

          // public function api_getcustomerbyid($customerid)
	        // {
          //   $result=$this->db->query("SELECT customername AS customerName FROM `customer` WHERE customerid='$customerid'");
          //   return $result;
          // }

          
          public function api_getsizeid($id)
	        {
            $result=$this->db->query("SELECT sizeid FROM size WHERE sizevalue='$id'");
            return $result;
            // if($result)
            // {
            //     return $result;
            // }
            // else
            // {
            //     return false;
            // }
          }

          // At 27-11-2020
          //get user log
          public function Api_userLogin($username)
          {
            $result=$this->db->query("SELECT * FROM `adduser` WHERE username='$username'");
            if ($result->num_rows()>0) 
            {
              return $result;
            }
            else
            {
              return false;
            }
          }

          public function api_getproductsize($code,$branchid)
	        {
            $result=$this->db->query("SELECT * FROM stock LEFT JOIN size ON stock.size = size.sizeid JOIN branch ON stock.branch=branch.branchname WHERE stock.productid='$code' AND branch.branchid='$branchid'");
            return $result;
          }

          public function Autogenerate_EInvoiceNo($branchid)
          {
            $query=$this->db->query("SELECT IFNULL(max(eCommerce_no+1),1) as NO from ecommerce_ordermaster");
            return $query;
          } 

          public function api_getvouchercode()
	        {
            $result=$this->db->query("SELECT * FROM vouchercode");
            return $result;
          }

          public function geteorder($cdate)
          {
            $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current ='$cdate' ORDER BY eCommerce_no DESC");
            return $q;
          }

          public function geteorder1($fdate,$tdate)
          {
            $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current between '$fdate' and '$tdate' ORDER BY eCommerce_no DESC");
            return $q;
          }

          public function update_eorder($data,$id)
          {
            $this->db->where('eorderdetailsid',$id);
            $result=$this->db->update('ecommerce_orderdetails',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function getorder($a)
          {
            $q=$this->db->query("SELECT * from ecommerce_ordermaster INNER JOIN ecommerce_orderdetails on ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid WHERE eCommerce_id='$a'");
            return $q;
          }

          public function getstatus()
          {
            $q=$this->db->query("SELECT * from status ");
            return $q;
          }


        public function getorder1()
        {
          $q=$this->db->query("SELECT * from ecommerce_ordermaster INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN shipping_address on ecommerce_ordermaster.customerid=shipping_address.customer_id");
          return $q;
        }
        
        
        public function getcurrency()
          {
            $query = $this->db->get('currency');
            return $query;
          }
          public function getmulticurrency()
          {
           $q=$this->db->query("SELECT product.pdt_code,product.mrp,product.aed,product.usd,product.pdt_name from  product  WHERE searchcode LIKE '*0-16-12%' ORDER BY pdt_id");
           return $q;
          }
      public function insert_multicurrency($data)
         {
          $q=$this->db->insert('multicurrency',$data);
           $id = $this->db->insert_id();log_message('error',$id);
                if($q){
                      return $id;
                     }  
                     else
                     {
                      return false;
                     }
         }
         public function update_multicurrency($id,$data)
     {
           $this->db->where('pdt_code',$id);

            $this->db->update('product',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
     }
     public function delete_multicurrency($id)
     {
      $result=$this->db->query("DELETE from multicurrency where multicurrency_id='$id'");
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      } 
     }
        public function insertshippingaddress($data)
        {
          $result=$this->db->insert("shipping_address",$data);
          $id = $this->db->insert_id();
          if ($result)
          {
            return $id;
          }
          else
          {
            return false;
          }
        }

        public function insertEorderMaster($data,$id)
        {
          $this->db->where('eCommerce_id',$id);
          $this->db->update('ecommerce_ordermaster',$data);
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
          
        public function insertEcomMaster($data)
        {
          $this->db->insert('ecommerce_ordermaster',$data);
          $id=$this->db->insert_id();
          return $id;
        }
        
        public function api_insertEcomDetails($data)
        {
          $result=$this->db->insert("ecommerce_orderdetails",$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function api_unPaidOrders($customer)
        {
          $result=$this->db->query("SELECT ecommerce_orderdetails.productname,ecommerce_orderdetails.qty,ecommerce_orderdetails.size,size.sizevalue,ecommerce_orderdetails.amount,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_ordermaster.balance FROM ecommerce_ordermaster INNER JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN size ON ecommerce_orderdetails.size=size.sizeid WHERE ecommerce_ordermaster.balance!=0 AND ecommerce_ordermaster.customerid='$customer'");
          return $result;
        }

        public function api_processingOrders($customer)
        {
          $result=$this->db->query("SELECT ecommerce_orderdetails.productname,ecommerce_orderdetails.qty,ecommerce_orderdetails.size,size.sizevalue,ecommerce_orderdetails.amount,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_orderdetails.status,ecommerce_ordermaster.balance FROM ecommerce_ordermaster INNER JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN size ON ecommerce_orderdetails.size=size.sizeid WHERE ecommerce_orderdetails.status!='Shipped' AND ecommerce_orderdetails.status!='Delivered' AND ecommerce_orderdetails.status!='Refunded' AND ecommerce_ordermaster.customerid='$customer'");
          return $result;
        }

        public function api_shippedOrders($customer)
        {
          $result=$this->db->query("SELECT ecommerce_orderdetails.productname,ecommerce_orderdetails.qty,ecommerce_orderdetails.size,size.sizevalue,ecommerce_orderdetails.amount,ecommerce_ordermaster.date_delivery,ecommerce_ordermaster.cash_payment,ecommerce_ordermaster.bank_payment,ecommerce_ordermaster.balance FROM ecommerce_ordermaster INNER JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN size ON ecommerce_orderdetails.size=size.sizeid WHERE ecommerce_orderdetails.status='Shipped' AND ecommerce_ordermaster.customerid='$customer'");
          return $result;
        }
        
        public function api_singleproduct($data)
        {
          $result = array();
          $result=$this->db->query("SELECT * from product WHERE pdt_id='$data'")->result();
          return $result;
        }
        
        public function getsupplierbybranch($branchid)
        {
          $result=$this->db->query("SELECT * FROM branch INNER JOIN supplier ON branch.branchid=supplier.branch WHERE branch.branchid='$branchid'");
          return $result->row_array();
        }
        
        public function getbankbybranch($branchid)
        {
          $result=$this->db->query("SELECT accountledger.ledgerid FROM branch INNER JOIN accountledger ON branch.branchid=accountledger.branchid WHERE branch.branchid='$branchid' AND accountledger.accountgroup='19'");
          return $result->row_array();
        }
        
        public function api_getproductgrp()
        {
          $result=$this->db->query("SELECT * from product_group");
          return $result;
        }
        
        public function api_getProductBySortAsc($cat)
        {
          $result=$this->db->query("SELECT * FROM product JOIN product_group ON product.groupid=product_group.groupid WHERE product.groupid='$cat' ORDER BY product.mrp ASC");
          return $result;
        }
        
        public function api_getProductBySortDesc($cat)
        {
          $result=$this->db->query("SELECT * FROM product JOIN product_group ON product.groupid=product_group.groupid WHERE product.groupid='$cat' ORDER BY product.mrp DESC");
          return $result;
        }
        
        public function api_getProductByFilter($min,$max,$cat)
        {
          $result=$this->db->query("SELECT * FROM product JOIN product_group ON product.groupid=product_group.groupid WHERE product.mrp BETWEEN '$min' AND '$max' AND product.groupid='$cat' ORDER BY product.mrp ASC");
          return $result;
        }
        
        
        public function api_getprobygrp($data)
        {
          $result=$this->db->query("SELECT * from product WHERE groupid='$data'");
          return $result;
        }
          

          public function api_getcustomer($code)
          {
            $result=$this->db->query("SELECT * from customer INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid WHERE customercode='$code' OR customername='$code' OR phonenumber='$code' OR customerid='$code'");
            return $result;
          }
          public function api_getcustomerall()
          {
            $result=$this->db->query("SELECT * from customer ");
            return $result;
          }

          public function api_getsalesman($sales)
          {
            $result=$this->db->query("SELECT * from salesman WHERE salesmancode='$sales'");
            return $result;
          }

          public function getsalesman1()
          {
            $result=$this->db->query("SELECT * from salesman where salesmancode='2 ur'");
            return $result;
          }

          public function api_getshoporder($order,$branchid)
          {
            $result=$this->db->query("SELECT * from shoporder LEFT JOIN salesman ON shoporder.salesmanid=salesman.salesmanid LEFT JOIN customer ON shoporder.customerid=customer.customerid INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid WHERE shoporder.shoporderid='$order' AND shoporder.branchid='$branchid' AND shoporder.deleted='0'");
            return $result;
          }

          public function api_getshoporderbranch($branchid)
          {
            $result=$this->db->query("SELECT * from shoporder LEFT JOIN salesman ON shoporder.salesmanid=salesman.salesmanid LEFT JOIN customer ON shoporder.customerid=customer.customerid WHERE shoporder.branchid='$branchid' AND shoporder.deleted='0'");
            return $result;
          }

          public function api_getonlineorderbranch($branchid)
          {
            $result=$this->db->query("SELECT * from onlineorder LEFT JOIN salesman ON onlineorder.salesmanid=salesman.salesmanid LEFT JOIN customer ON onlineorder.customerid=customer.customerid WHERE onlineorder.branchid='$branchid'");
            return $result;
          }

          public function api_referencebranch($branchid)
          {
            $result=$this->db->query("SELECT ref_product.* FROM ref_product INNER JOIN shoporder on ref_product.fk_shoporderid = shoporder.shoporderid WHERE shoporder.branchid ='$branchid'");
            return $result;
          }

          public function api_onlinereferencebranch($branchid)
          {
            $result=$this->db->query("SELECT ref_onlineproduct.* FROM ref_onlineproduct INNER JOIN onlineorder on ref_onlineproduct.fk_onlineorderid = onlineorder.onlineorderid WHERE onlineorder.branchid ='$branchid'");
            return $result;
          }
          

          public function api_noOfShopOrder($fOnlyDate,$tOnlyDate,$branchid)
          {
            $result=$this->db->query("SELECT COUNT(shoporderid) AS sCount FROM `shoporder` WHERE branchid='$branchid' AND date_current BETWEEN '$fOnlyDate' AND '$tOnlyDate' AND deleted='0'");
            return $result;
          }

          public function api_shopOrderAdvance($fOnlyDate,$tOnlyDate,$branchid)
          {
            $result=$this->db->query("SELECT SUM(paid_cash + paid_bank) AS advance FROM shoporder WHERE branchid='$branchid' AND date_current BETWEEN '$fOnlyDate' AND '$tOnlyDate' AND deleted='0'");
            return $result;
          }

          public function api_shopOrderAdvance2($fOnlyDate,$tOnlyDate)
          {
            $result=$this->db->query("SELECT SUM(paid_cash + paid_bank) AS advance FROM shoporder WHERE date_current BETWEEN '$fOnlyDate' AND '$tOnlyDate' AND deleted='0'");
            return $result;
          }

          public function api_getallshoporder($branchid)
          {
            $result=$this->db->query("SELECT * from shoporder JOIN customer ON shoporder.customerid=customer.customerid WHERE shoporder.branchid='$branchid' AND shoporder.deleted='0'");
            return $result;
          }

          public function api_getreference($order)
          {
            $result=$this->db->query("SELECT * from ref_product WHERE fk_shoporderid='$order'");
            return $result;
          }

            public function api_getimage($type)
            {
              $result=$this->db->query("SELECT * from images WHERE type='$type'");
              return $result;
            }

            public function api_getbannerimage()
            {
              $result=$this->db->query("SELECT * from images WHERE type='and_banner'");
              return $result;
            }
            public function api_getsliderimage()
            {
              $result=$this->db->query("SELECT * from images WHERE type='and_slider'");
              return $result;
            }

          
          public function api_getimagegrp($id)
          {
            $result=$this->db->query("SELECT product.imagpath,images.name FROM product JOIN images ON product.pdt_code=images.productcode WHERE product.pdt_code='$id'");
            return $result;
          }
          
          public function api_imageupload($insertData)
          {
            $result=$this->db->insert('shoporder',$insertData);
                     
                     if($result)
                     {
                      return $this->db->insert_id();
                     }	
                     else
                     {
                     	return false;
                     }
            }

            public function api_updateimageupload($insertData,$id)
            {
              $this->db->where('shoporderno',$id);
              $this->db->update('shoporder',$insertData);
            
              return $this->db->get('shoporder')->row()->shoporderid;
            }
          

            public function api_onlineimageupload($insertData)
          {
            $result=$this->db->insert('onlineorder',$insertData);
                     
                     if($result)
                     {
                      return $this->db->insert_id();
                     }	
                     else
                     {
                     	return false;
                     }
            }

            public function api_updateonlineimageupload($insertData,$id)
            {
              $this->db->where('onlineorderno',$id);
              $this->db->update('onlineorder',$insertData);
            
              return $this->db->get('onlineorder')->row()->onlineorderid;
            }

            public function api_geterror($insertData)
            {
              $result=$this->db->insert('error',$data);
              if($result)
              {
                return true;
              }
              else
              {
                return false;
              }
            }

            

          public function api_checkshoporder($data)
          {
            $result=$this->db->query("SELECT * FROM shoporder WHERE shoporderno='$data'");
            return $result->num_rows();
          }

          public function api_checkonlineorder($data)
          {
            $result=$this->db->query("SELECT * FROM onlineorder WHERE onlineorderno='$data'");
            return $result->num_rows();
          }

          public function getshoporderbyorderno($shoporderno)
          {
            return $this->db->
            select('*')->
            from('shoporder')->
            where('shoporderno', $shoporderno)->
            get()->row_array();
          }

          public function getonlineorderbyorderno($onlineorderno)
          {
            return $this->db->
            select('*')->
            from('onlineorder')->
            where('onlineorderno', $onlineorderno)->
            get()->row_array();
          }

          public function api_checkrefshoporder($data)
          {
            $result=$this->db->query("SELECT * FROM ref_product WHERE fk_shoporderid='$data'");
            return $result->num_rows();
          }
          public function api_checkrefonlineorder($data)
          {
            $result=$this->db->query("SELECT * FROM ref_onlineproduct WHERE fk_onlineorderid='$data'");
            return $result->num_rows();
          }


          public function api_audioupload($insertData)
          {
            $result=$this->db->insert('ref_product',$insertData);
                     
                     if($result)
                     {
                      return true;
                     }	
                     else
                     {
                     	return false;
                     }
          }
          public function api_updateaudioupload($insertData,$id)
          {
            $this->db->where('fk_shoporderid',$id);
            $result=$this->db->update('ref_product',$insertData);
              if($result)
               {
                  return true;
               }	
               else
               {
                	return false;
               }
          }

          public function api_onlineaudioupload($insertData)
          {
            $result=$this->db->insert('ref_onlineproduct',$insertData);
                     
                     if($result)
                     {
                      return true;
                     }	
                     else
                     {
                     	return false;
                     }
          }

          public function api_updateonlineaudioupload($insertData,$id)
          {
            $this->db->where('fk_onlineorderid',$id);
            $result=$this->db->update('ref_onlineproduct',$insertData);
              if($result)
               {
                  return true;
               }	
               else
               {
                	return false;
               }
          }

          public function api_getbranchbyid($branchid)
          {
            $result=$this->db->query("SELECT * FROM branch WHERE branchid='$branchid'");
            return $result->result();
          }


         public function api_salesmansum($fdate,$tdate,$branchid)
         {
          $result=$this->db->query("SELECT salesman.salesmancode AS salesman_code ,salesman.salesmanname AS salesman_name ,SUM(grandtotal) AS sum_total FROM salesinvoicemaster INNER JOIN salesman ON salesinvoicemaster.salesman = salesman.salesmanid WHERE salesinvoicemaster.branchid = '$branchid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY salesinvoicemaster.salesman");
          return $result;
         }

         public function api_pdtqty($fdate,$tdate,$branchid)
         {
          $result=$this->db->query("SELECT product.pdt_name , SUM(qty) AS pdt_qty , SUM(salesinvoicedetails.netamount) AS pdt_grandtotal FROM salesinvoicemaster INNER JOIN salesinvoicedetails ON salesinvoicemaster.salesmasterid = salesinvoicedetails.salesmasterid INNER JOIN product ON salesinvoicedetails.productcode = product.pdt_code WHERE salesinvoicemaster.branchid = '$branchid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY salesinvoicedetails.productcode");
          return $result;
         }

         public function api_pdtqtycustomer($fdate,$tdate,$customerid)
         {
          $result=$this->db->query("SELECT product.pdt_name , SUM(qty) AS pdt_qty , SUM(salesinvoicedetails.netamount) AS pdt_grandtotal FROM salesinvoicemaster INNER JOIN salesinvoicedetails ON salesinvoicemaster.salesmasterid = salesinvoicedetails.salesmasterid INNER JOIN product ON salesinvoicedetails.productcode = product.pdt_code WHERE salesinvoicemaster.customerid = '$customerid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY salesinvoicedetails.productcode");
          return $result;
         }

         public function api_pdtqtysupplier($fdate,$tdate,$supplierid)
         {
          $result=$this->db->query("SELECT product.pdt_name , SUM(qty) AS pdt_qty , SUM(purchaseinvoicedetials.netamount) AS pdt_grandtotal FROM purchaseinvoicemaster INNER JOIN purchaseinvoicedetials ON purchaseinvoicemaster.voucherno = purchaseinvoicedetials.voucherno INNER JOIN product ON purchaseinvoicedetials.productcode = product.pdt_code WHERE purchaseinvoicemaster.suppliername ='$supplierid' AND purchaseinvoicemaster.invoicedate BETWEEN '$fdate' AND '$tdate' GROUP BY purchaseinvoicedetials.productcode");
          return $result;
         }

         public function api_supplierproduct($fdate,$tdate,$supplierid)
         {
          $result=$this->db->query("SELECT product.pdt_name , SUM(qty) AS pdt_qty , SUM(purchaseinvoicedetials.netamount) AS pdt_grandtotal FROM purchaseinvoicemaster INNER JOIN purchaseinvoicedetials ON purchaseinvoicemaster.voucherno = purchaseinvoicedetials.voucherno INNER JOIN product ON purchaseinvoicedetials.productcode = product.pdt_code WHERE purchaseinvoicemaster.suppliername ='$supplierid' AND purchaseinvoicemaster.invoicedate BETWEEN '$fdate' AND '$tdate' GROUP BY purchaseinvoicedetials.productcode");
          return $result;
         }

         public function api_pdtcategory($fdate,$tdate,$branchid)
         {
          $result=$this->db->query("SELECT product_group.groupname ,SUM(qty) AS cat_qty, SUM(salesinvoicedetails.netamount) AS cat_grandtotal FROM salesinvoicemaster INNER JOIN salesinvoicedetails ON salesinvoicemaster.salesmasterid = salesinvoicedetails.salesmasterid INNER JOIN product ON salesinvoicedetails.productcode = product.pdt_code INNER JOIN product_group ON product.groupid = product_group.groupid WHERE salesinvoicemaster.branchid = '$branchid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY product.groupid");
          return $result;
         }

         public function api_btwnsum($fdate,$tdate,$branchid)
         {
          $result=$this->db->query("SELECT COUNT(salesinvoicemaster.invoiceno) AS noofreceipt , SUM(salesinvoicemaster.grandtotal) AS grand_total, SUM(salesinvoicemaster.taxamount) AS taxamount FROM salesinvoicemaster WHERE salesinvoicemaster.branchid = '$branchid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate'");
          return $result;
         }



         
         public function api_noofinvoice($fdate,$tdate,$customerid)
         {
           $result=$this->db->query("SELECT COUNT(invoiceno) AS noofinvoice FROM salesinvoicemaster WHERE customerid='$customerid' AND salesdate BETWEEN '$fdate' AND '$tdate'");
           return $result;
         }

         public function api_noofvoucher($fdate,$tdate,$supplierid)
         {
           $result=$this->db->query("SELECT COUNT(voucherno) AS noofvoucher FROM purchaseinvoicemaster WHERE suppliername='$supplierid' AND invoicedate BETWEEN '$fdate' AND '$tdate'");
           return $result;
         }
         public function api_noofreceipt($fdate,$tdate,$customerid)
         {
           $result=$this->db->query("SELECT COUNT(voucherno) AS noofreceipt FROM receiptvoucher WHERE ledger='$customerid' AND receiptdate BETWEEN '$fdate' AND '$tdate'");
           return $result;
         }

         public function api_noofpayment($fdate,$tdate,$supplierid)
         {
           $result=$this->db->query("SELECT COUNT(voucherno) AS noofpayment FROM paymentvoucher WHERE ledger='$supplierid' AND date BETWEEN '$fdate' AND '$tdate'");
           return $result;
         }

         // updated at 29-12-2020
         public function api_supplierBalance($fdate,$tdate,$supplierid)
         {
           $result=$this->db->query("SELECT * FROM (SELECT * FROM (SELECT sum(debit)as debit ,SUM(credit) as credit , 'Purchase Invoice' AS accountType ,CAST(invoiceno AS UNSIGNED) AS invoiceno ,balance  FROM `daybook` INNER JOIN supplier on supplier.supplieraccount=daybook.ledgername WHERE supplier.supplierid='$supplierid' AND daybook.date between '$fdate' and '$tdate' AND (accountType='Purchase delete' OR accountType='Purchase Update' OR accountType='Purchase Invoice') GROUP BY invoiceno) AS t1 where t1.debit!=t1.credit
           UNION
           SELECT debit, credit,accountType,CAST(invoiceno AS UNSIGNED)AS invoiceno,balance FROM daybook INNER JOIN supplier on supplier.supplieraccount=daybook.ledgername WHERE supplier.supplierid='$supplierid' AND daybook.date between '$fdate' and '$tdate' AND (accountType!='Purchase delete' AND accountType!= 'Purchase Update' AND accountType!= 'Purchase Invoice') ) AS NEW ORDER BY invoiceno");
           return $result;
          }

          // updated at 26-12-2020
         public function api_supplierCurrentBalance($supplierid)
         {
           $result=$this->db->query("SELECT currentbalance FROM `accountledger` INNER JOIN supplier ON supplier.supplieraccount=accountledger.ledgerid WHERE 
           supplier.supplierid='$supplierid'");
           return $result;
          }


         public function api_customerwithledger()
         {
           $result=$this->db->query("SELECT * FROM `customer` JOIN accountledger ON customer.customeraccount=accountledger.ledgerid");
           return $result;
         }


         public function api_customercategory($fdate,$tdate,$customerid)
         {
          $result=$this->db->query("SELECT product_group.groupname ,SUM(qty) AS cat_qty, SUM(salesinvoicedetails.netamount) AS cat_grandtotal FROM salesinvoicemaster INNER JOIN salesinvoicedetails ON salesinvoicemaster.salesmasterid = salesinvoicedetails.salesmasterid INNER JOIN product ON salesinvoicedetails.productcode = product.pdt_code INNER JOIN product_group ON product.groupid = product_group.groupid WHERE salesinvoicemaster.customerid ='$customerid' AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY product.groupid");
          return $result;
         }

         public function api_suppliercategory($fdate,$tdate,$supplierid)
         {
          $result=$this->db->query("SELECT product_group.groupname ,SUM(qty) AS cat_qty, SUM(purchaseinvoicedetials.netamount) AS cat_grandtotal FROM purchaseinvoicemaster INNER JOIN purchaseinvoicedetials ON purchaseinvoicemaster.voucherno = purchaseinvoicedetials.voucherno INNER JOIN product ON purchaseinvoicedetials.productcode = product.pdt_code INNER JOIN product_group ON product.groupid = product_group.groupid WHERE purchaseinvoicemaster.suppliername ='$supplierid' AND purchaseinvoicemaster.invoicedate BETWEEN '$fdate' AND '$tdate' GROUP BY product.groupid");
          return $result;
         }

         public function api_supplierproductcategory($fdate,$tdate,$supplierid)
         {
          $result=$this->db->query("SELECT product_group.groupname ,SUM(qty) AS cat_qty, SUM(purchaseinvoicemaster.grandtotal) AS cat_grandtotal FROM purchaseinvoicemaster INNER JOIN purchaseinvoicedetials ON purchaseinvoicemaster.voucherno = purchaseinvoicedetials.voucherno INNER JOIN product ON purchaseinvoicedetials.productcode = product.pdt_code INNER JOIN product_group ON product.groupid = product_group.groupid WHERE purchaseinvoicemaster.suppliername ='$supplierid' AND purchaseinvoicemaster.invoicedate BETWEEN '$fdate' AND '$tdate' GROUP BY product.groupid");
          return $result;
         }


         public function api_getqtysum($fdate,$tdate,$pdt)
         {
          $result=$this->db->query("SELECT SUM(salesinvoicedetails.qty) AS pdtqty FROM salesinvoicemaster JOIN salesinvoicedetails ON salesinvoicemaster.invoiceno = salesinvoicedetails.invoiceno WHERE salesinvoicedetails.productcode='$pdt' AND salesinvoicedetails.salesdate BETWEEN '$fdate' AND '$tdate'");
          return $result;
         }
         
         public function api_getpurchasesum($fdate,$tdate,$pdt)
         {
          $result=$this->db->query("SELECT SUM(purchaseinvoicedetials.qty) AS pdtqty FROM purchaseinvoicemaster JOIN purchaseinvoicedetials ON purchaseinvoicemaster.voucherno = purchaseinvoicedetials.voucherno WHERE purchaseinvoicedetials.productcode='$pdt' AND purchaseinvoicedetials.invoicedate BETWEEN '$fdate' AND '$tdate'");
          return $result;
         }

        //  updated at 26-12-2020
        public function api_getpdtstock($pdt,$sizeId)
        {
         $result=$this->db->query("SELECT * FROM stock INNER JOIN branch ON stock.branch=branch.branchid INNER JOIN size ON stock.size=size.sizeid WHERE stock.productid='$pdt'AND size.sizeid='$sizeId'");
         return $result;
        }

        // updated at 28-12-2020
        public function api_productStockByCode($productCode)
        {
          $result=$this->db->query("SELECT branch.branchname as branchName, size.sizevalue AS sizeValue , product.pdt_name AS productName ,stock.currentstock AS currentStock FROM stock INNER JOIN branch ON stock.branch=branch.branchid INNER JOIN size ON stock.size=size.sizeid INNER JOIN product ON stock.productid=product.pdt_code WHERE product.pdt_code='$productCode'");
          return $result;
         }

           // updated at 28-12-2020
        public function api_productStockBySize($sizeId)
        {
          $result=$this->db->query("SELECT branch.branchname as branchName, size.sizevalue AS sizeValue , product.pdt_name AS productName ,stock.currentstock AS currentStock FROM stock INNER JOIN branch ON stock.branch=branch.branchid INNER JOIN size ON stock.size=size.sizeid INNER JOIN product ON stock.productid=product.pdt_code WHERE size.sizeid='$sizeId'");
          return $result;
         }

         public function api_ledgerbydesc($tdate,$fdate,$cash)
         {
           $result=$this->db->query("SELECT balance,credit,debit FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE daybook.date BETWEEN '$fdate' AND '$tdate' AND accountledger.ledgerid='$cash' ORDER BY daybook.date DESC");
           return $result;
          }

         public function api_ledgerfromdesc($fdate,$cash)
         {
           $result=$this->db->query("SELECT balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE daybook.date < '$fdate' AND accountledger.ledgerid='$cash' ORDER BY daybook.date DESC LIMIT 1");
           return $result;
          }

          public function api_ledgertodesc($tdate,$cash)
         {
           $result=$this->db->query("SELECT balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE daybook.date < '$tdate' AND accountledger.ledgerid='$cash' ORDER BY daybook.date DESC LIMIT 1");
           return $result;
          }
          
          
          public function api_getBankTransfer($tdate,$fdate,$cash,$bank)
          {
            $result=$this->db->query("SELECT SUM(credit) AS depositAmount FROM daybook WHERE (accountType!='Contra Voucher delete' AND accountType!='Contra Voucher' ) AND ledgername='$cash' AND opposite='$bank' AND date BETWEEN '$fdate' AND '$tdate'" );
            return $result;
          }

          public function api_getCashExpense($tdate,$fdate,$cash)
          {
            $result=$this->db->query("SELECT SUM(credit) AS expense,SUM(debit) AS receipt FROM daybook WHERE ledgername='$cash' AND accountType!='Sales Invoice' AND accountType!='Sales Update' AND accountType!='Mobile Payment Voucher' AND accountType!='Contra Voucher delete' AND accountType!='Contra Voucher' AND accountType!='Sales Delete' AND date BETWEEN '$fdate' AND '$tdate'");
            return $result;
          }

         public function api_branchSaleProfit($fdate,$tdate,$branchid)
          {
            $query=$this->db->query("SELECT SUM(stockamount) AS costOfGood,SUM(billdiscount) AS discount,SUM(grandtotal) AS netSale, SUM(paidcash) AS paidCash, SUM(paidbank) AS paidBank,SUM(balance)*-1 AS paidAdvance FROM `salesinvoicemaster` WHERE salesdate BETWEEN '$fdate' AND '$tdate' AND branchid='$branchid'");
            return $query;
          }

          public function api_branchSaleProfit2($fdate,$tdate)
          {
            $query=$this->db->query("SELECT SUM(stockamount) AS costOfGood,SUM(billdiscount) AS discount,SUM(grandtotal) AS netSale, SUM(paidcash) AS paidCash, SUM(paidbank) AS paidBank,SUM(balance)*-1 AS paidAdvance FROM `salesinvoicemaster` WHERE salesdate BETWEEN '$fdate' AND '$tdate'");
            return $query;
          }

          public function api_branchReturnTotal($fdate,$tdate,$branchid)
          {
            $query=$this->db->query("SELECT SUM(grandtotal) AS refunds, SUM(stockamount) AS purchaseAmount FROM `salesreturnmaster` WHERE salesdate BETWEEN '$fdate' AND '$tdate' AND branchid='$branchid'");
            return $query;
          }

          public function api_branchReturnTotal2($fdate,$tdate)
          {
            $query=$this->db->query("SELECT SUM(grandtotal) AS refunds, SUM(stockamount) AS purchaseAmount FROM `salesreturnmaster` WHERE salesdate BETWEEN '$fdate' AND '$tdate'");
            return $query;
          }

          public function api_customerOutAmount($customerid)
          {
            $query=$this->db->query("SELECT accountledger.currentbalance AS OutAmount FROM customer INNER JOIN accountledger ON customer.customeraccount = accountledger.ledgerid WHERE customer.customerid='$customerid'");
            return $query;
          }

          public function getopenigstock()
          {
            $query=$this->db->query("SELECT openingbalance FROM accountledger WHERE ledgerid='6854'");
            return $query;
          }

          public function api_shopOrderDetailsById($shoporderid)
          {
            $query=$this->db->query("SELECT * FROM `shoporder` WHERE shoporderid='$shoporderid' AND deleted='0'");
            return $query;
          }

          public function api_branchShopOrder($fOnlyDate,$tOnlyDate,$branchid)
          {
            $query=$this->db->query("SELECT shoporder.shoporderid AS shopOrderId ,shoporder.shoporderno AS shopOrderNo, shoporder.date_delivery AS deliveryDate, shoporder.date_current AS currentDate, shoporder.amount, customer.customername AS customerName, branch.branchname AS branchName  FROM `shoporder` INNER JOIN customer ON shoporder.customerid=customer.customerid INNER JOIN branch ON shoporder.branchid=branch.branchid INNER JOIN salesman ON shoporder.salesmanid=salesman.salesmanid WHERE shoporder.branchid='$branchid' AND shoporder.date_current BETWEEN '$fOnlyDate' and '$tOnlyDate' AND shoporder.deleted='0'");
            return $query;
          }


         public function api_getcurrentstock($pdt)
         {
          $result=$this->db->query("SELECT SUM(currentstock) as currentstock FROM stock WHERE productid='$pdt' GROUP BY productid");
          return $result;
         }
         
         // created at 15-10-2020
        // to update ecommerce master of a order paid by razor pay
        public function updateEcommerceOrderMaster($masterid,$balance,$bank_payment,$payment_mode,$rzp_orderId,$status,$date_current)
        {
          $result=$this->db->query("UPDATE `ecommerce_ordermaster` SET balance=balance+'$balance',bank_payment=bank_payment+'$bank_payment',payment_mode='$payment_mode',rzp_orderId='$rzp_orderId',status='$status' WHERE eCommerce_id='$masterid'");
          return $result;
        }
        
        // created at 16-10-2020
        // to get Customer ledgeraccount by customer id
        public function getCustomerLedgerAccount($customerid)
        {
          $result=$this->db->query("SELECT customeraccount FROM `customer` INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid WHERE customer.customerid='$customerid'");
          return $result->result_array();
        }
	
         

        public function getsalesman()
        {
          $result=$this->db->query("SELECT * from salesman");
          return $result;
        }

        public function checkexistence_salesman($value1,$value2)
        {
          $result=$this->db->query("SELECT * from salesman where salesmancode='$value1' OR phoneno='$value2'");
          return $result->num_rows();
        }

        public function insert_salesman($data)
        {
          $result=$this->db->insert('salesman',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function delete_salesman($id)
          {
            $result=$this->db->query("DELETE from salesman where salesmanid='$id'");
            if($this->db->affected_rows()>0)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

        public function update_salesman($data,$id)
        {
          $this->db->where('salesmanid',$id);
          $result=$this->db->update('salesman',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function insert_customer($data)
        {
          $result=$this->db->insert('customer',$data);
          if($result)
          {
            return true;
          }  
          else
          {
            return false;
          }
        }


        public function api_insert_customer($data)
        {
          $result=$this->db->insert('customer',$data);
          $result = $this->db->insert_id();     
          return $result;
        }

        public function api_update_customer($data,$oldcode)
        {
          $this->db->where('customercode',$oldcode);
          $this->db->update('customer',$data);
          $result=$this->db->get('customer');
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function api_customerUpdatePass($customerid,$hashpassword)
        {
          $result= $this->db->query("UPDATE customer SET pass='$hashpassword' WHERE customerid='$customerid'");
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }



        public function update_customer($data,$id)
        {
          $this->db->where('customerid',$id);
          $this->db->update('customer',$data);
          $result=$this->db->get('customer');
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function updatecomusser($data,$pho)
        {
          $this->db->where('phonenumber',$pho);
          $this->db->update('customer',$data);
          $result=$this->db->get('customer');
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function api_ecomUserLogin($user,$pass)
        {
          $query=$this->db->query("SELECT * FROM `customer` WHERE user='$user' AND pass='$pass'");
          return $query;
        }

        

        public function insert_salesinvoicemaster1($data)
        {
          $result=$this->db->insert('salesinvoicemaster',$data);
          if($result)
          {
            return true;
          }  
          else
          {
            return false;
          }
        }
        
        public function Autofill_Productdetails($CODE)
        {
          $Productcode=$this->db->where('pdt_code',$CODE);
          $result=$this->db->get('product');
          return $result;
        }

        public function Autofill_Productdetails_TEST($CODE)
        {
          $result=array();
          $result=$this->db->query("SELECT * FROM product INNER JOIN unit on product.unitid=unit.unitid where product.pdt_code='$CODE'");
          return $result->result();
        }

        public function test($state)
        {
          $result=$this->db->query("SELECT pdt_name from product where pdt_code='$state'");
          if(count($result)>0)
          {
            return $result[0]['da_hq'];
          }
          else
          {
            return '';
          }
        }
          //SalesInvoice_End

        public function checkexistence_payment($value)
        {
          $result=$this->db->query("SELECT * FROM paymentvoucher where voucherno = '$value'");
          return $result->num_rows() ;
        }
         public function checkexistence_branchexpense($value)
        {
          $result=$this->db->query("SELECT * FROM branchexpense where voucherno = '$value'");
          return $result->num_rows() ;
        }
    
        public function insert_paymentvoucher($data)
        {
          $result=$this->db->insert('paymentvoucher',$data);
          return $result;
        }
         public function insert_branchexpense($data)
        {
          $result=$this->db->insert('branchexpense',$data);
          return $result;
        }

        public function Autogenerate_payVoucherNo()
        {
          $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from paymentvoucher");
          return $query;
        }
          public function Autogenerate_EcomorderNo()
        { $a=array();
          $query=$this->db->query("SELECT IFNULL(max(eCommerce_no+1),1) as NO from ecommerce_ordermaster");
          $ecomno= $query->result()[0]->NO;
          $a['orderno']=$ecomno;
          $data['eCommerce_no']=$ecomno;
           $this->db->insert('ecommerce_ordermaster',$data);
          $a['masterid'] = $this->db->insert_id();
           
          
          
          return $a;
        }

        public function getproductonline()
        {
          $query=$this->db->query("SELECT product.*,SUM(stock.currentstock),unit.unitid,unit.unitname,product_group.groupid,product_group.groupname,brand.brandid,brand.brandname,product_group.taxlow,product_group.slab,product_group.taxhigh FROM product LEFT JOIN unit on product.unitid=unit.unitid LEFT JOIN product_group on product.groupid=product_group.groupid LEFT JOIN brand on product.brandid=brand.brandid LEFT JOIN stock on product.pdt_code=stock.productid WHERE product.searchcode LIKE' *0-16-12%' GROUP BY product.pdt_code");
          return $query;
        }

        public function Autogenerate_branchexpense()
        {
          $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from branchexpense");
          return $query;
        }

        public function update_paymentvoucher($id,$data)
        {
          $this->db->where('id',$id);
          $this->db->update('paymentvoucher',$data);
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        public function delete_paymentvoucher($id)
        {
          $result=$this->db->query("UPDATE paymentvoucher SET deleted=1 where voucherno='$id'");
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
         public function delete_ecomorder($id)
        {
          $result=$this->db->query("DELETE FROM ecommerce_ordermaster  where eCommerce_id='$id'");
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }

        
   public function getbranchexpense()
        {
    $result=$this->db->query("SELECT * from branchexpense inner join accountledger on branchexpense.supplier=accountledger.ledgerid");
    return $result;
  }
  public function getbranchexpensebybranch($branchid)
        {
    $result=$this->db->query("SELECT * from branchexpense inner join accountledger on branchexpense.supplier=accountledger.ledgerid where accountledger.branchid ='$branchid'");
    return $result;
  }

   //SalesReport_Start

  public function LoadSalesDetails_All($fromdate,$todate,$finyear)
  {
    $result=$this->db->query("SELECT * FROM salesinvoicedetails WHERE salesdate BETWEEN '$fromdate' and '$todate' AND finyear=$finyear");
    return $result;
  }

          public function LoadSalesReturnDetails_All($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM salesreturndetails WHERE salesdate BETWEEN '$fromdate' AND '$todate' AND branchid='$branchid' ORDER BY salesdate DESC");
            return $result;
          }

          public function LoadSalesReturnMaster_All($fromdate,$todate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM salesreturnmaster WHERE salesdate BETWEEN '$fromdate' AND '$todate' AND branchid='$branchid' ORDER BY salesdate DESC");
            return $result;
          }

          public function LoadSalesDetails_AllBranch($fromdate,$todate,$branchid,$finyear)
          {
            $result=$this->db->query("SELECT * from salesinvoicedetails where salesdate between '$fromdate' and '$todate' AND branchid='$branchid' AND finyear=$finyear");
            return $result;
          }

          public function LoadSalesdetails_ProductNamewise($fromdate,$todate,$productname, $finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails where productname='$productname' and salesdate between '$fromdate' and '$todate' AND finyear = $finyear");
            return $result;
          }

        public function LoadSalesdetails_ProductNamewiseBranch($fromdate,$todate,$productname,$branchid,$finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails where productname='$productname' and salesdate between '$fromdate' and '$todate' AND branchid='$branchid' AND finyear=$finyear");
            return $result;
          }

          public function Loadsalesdetails_Supplierwise($fromdate,$todate,$supplier,$finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join purchaseinvoicedetials ON salesinvoicedetails.productname=purchaseinvoicedetials.productname inner join purchaseinvoicemaster ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno WHERE purchaseinvoicemaster.suppliername='$supplier' and salesinvoicedetails.salesdate between '$fromdate' and '$todate' AND salesinvoicedetails.finyear=$finyear");
            return $result;
          }

          public function Loadsalesdetails_SupplierwiseBranch($fromdate,$todate,$supplier,$branchid,$finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join purchaseinvoicedetials ON salesinvoicedetails.productname=purchaseinvoicedetials.productname inner join purchaseinvoicemaster ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno WHERE purchaseinvoicemaster.suppliername='$supplier' and salesinvoicedetails.salesdate between '$fromdate' and '$todate' AND salesinvoicedetails.finyear=$finyear and purchaseinvoicemaster.branchid='$branchid'");
            return $result;
          }

          public function Loadsalesdetails_Brandwise($fromdate,$todate,$brand,$finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join product
            ON salesinvoicedetails.productname=product.pdt_name
            WHERE product.brandid='$brand' and salesinvoicedetails.salesdate between '$fromdate' and '$todate' AND salesinvoicedetails.finyear=$finyear");
            return $result;
          }

          public function Loadsalesdetails_BrandwiseBranch($fromdate,$todate,$brand,$branchid,$finyear)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join product
            ON salesinvoicedetails.productname=product.pdt_name
            WHERE product.brandid='$brand' and salesinvoicedetails.salesdate between '$fromdate' and '$todate' AND salesinvoicedetails.finyear=$finyear AND salesinvoicedetails.branchid='$branchid'");
            return $result;
          }

          //SalesReport_End

          public function CashDaybook($fdate,$tdate)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='18' AND daybook.date BETWEEN '$fdate' and '$tdate'");
            return $result;  
          }

          public function CashDaybookbranch($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='18' AND daybook.date BETWEEN '$fdate' and '$tdate' AND accountledger.branchid='$branchid'");
            return $result;  
          }

          public function CashDaybookCurrent($cdate)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='18' AND daybook.date='$cdate'");
            return $result;  
          }

          public function CashDaybookCurrentbranch($cdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='18' AND daybook.date='$cdate' AND accountledger.branchid='$branchid'");
            return $result;  
          }


          public function BankDaybook($fdate,$tdate)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='19' AND daybook.date BETWEEN '$fdate' and '$tdate'");
            return $result;
          }


          public function BankDaybookbranch($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='19' AND daybook.date BETWEEN '$fdate' and '$tdate' AND accountledger.branchid='$branchid'");
            return $result;
          }

          public function BankDaybookCurrent($cdate)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='19' AND daybook.date='$cdate'");
            return $result;
          }

          public function BankDaybookCurrentbranch($cdate,$branchid)
          {
            $result=$this->db->query("SELECT * FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE accountgroup='19' AND daybook.date='$cdate' AND accountledger.branchid='$branchid'");
            return $result;
          }

          



          //ReceiptVoucher_Start

          public function Autogenerate_ReceiptVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from receiptvoucher");
            return $query;
          }

          public function insert_ReceiptVoucher($data)
          {
            $result=$this->db->insert("receiptvoucher",$data);
            return $result;
          }

           public function checkexistence_receiptvoucherno($value)
          {
            $result=$this->db->query("SELECT * from receiptvoucher where voucherno='$value'");
            return $result->num_rows();
          }

           public function update_receiptvoucher($data,$id)
          {
            $this->db->where('receiptvoucherid',$id);
            $result=$this->db->update('receiptvoucher',$data);
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function delete_receiptvoucher($id)
          {
            $result=$this->db->query("UPDATE receiptvoucher SET deleted =1 where voucherno='$id'");
            if($result)
            {
              return true;
            }
            else
            {
              return false;
            }
          }

          public function  getreceiptvoucher()
          {
            $result=$this->db->query("SELECT receiptvoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=receiptvoucher.cashorbank) as cash FROM `receiptvoucher` inner JOIN accountledger
            on receiptvoucher.ledger=accountledger.ledgerid where  receiptvoucher.deleted!=1");
            return $result;
          } 

          public function  getreceiptvoucherbyvoucherno($voucherno)
          {
            $result=$this->db->query("SELECT receiptvoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=receiptvoucher.cashorbank) as cash FROM `receiptvoucher` inner JOIN accountledger
            on receiptvoucher.ledger=accountledger.ledgerid where voucherno ='$voucherno' AND receiptvoucher.deleted!=1");
            return $result->result_array();
          } 
          
          public function getsize()
          {
            $result=$this->db->query("SELECT * FROM size");
            return $result;
          }  

          public function getfnyear($id)
          {
            $result=$this->db->query("SELECT * FROM finyear WHERE finyear_id = $id");
            return $result;
          }    

          public function Autofill_customerbalance($ledgername)
         {
          $result=array();
           $result=$this->db->query("SELECT * FROM accountledger where ledgername='$ledgername'");
          return $result->result();
        }

       
        public function update_customerledgerbalance($ledgername,$amount)
          {
            $result=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$amount WHERE ledgerid='$ledgername'");
            return $result;
          }

          public function Select_customerledger($id)
          {  return $this->db->
            select('*')->
            from('customer')->
            where('customerid', $id)->
            get()->row_array();
          }
          public function FillBankAndCashLedgers()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=18 OR accountgroup=19");
            return $query;
          }
          
           public function FillBankAndCashLedgersbybranch($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE (accountgroup=18 OR accountgroup=19 ) and branchid ='$branchid'");
            return $query;
          }
          public function FillCashLedgers()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=18");
            return $query;
          }

          public function api_FillCashLedgers($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE branchid='$branchid' AND accountgroup=18");
            return $query;
          }

          public function api_FillCashLedgers2($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE branchid='$branchid' AND accountgroup=18 ORDER BY ledgerid ASC");
            return $query;
          }
  
 			 public function FillCashLedgersss($a)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE  accountgroup=18 AND branchid = $a");

            // echo $this->db->last_query();
            // die();
            return $query->result();
          }

          public function FillBankLedgersbb($a)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=19 AND branchid = $a");
            return $query->result();
          }

          public function FillBranchCurrency($a)
          {
            $query=$this->db->query("SELECT currencyid FROM `branch` WHERE branchid = $a");
            return $query->result();
          }


          public function FillBankLedgers()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE  accountgroup=19");
            return $query;
          }

          public function api_FillBankLedgers($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE branchid='$branchid' AND accountgroup=19");
            return $query;
          }

          public function api_FillBankLedgers2($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE branchid='$branchid' AND accountgroup=19 ORDER BY ledgerid ASC");
            return $query;
          }

          // public function Daybook_SelectPreviousCashBalance()
          // {
           
          //   return $this->db->
          //   select('cashbalance')->
          //   from('daybook')->
          //   where('cashbalance !=','0')->
          //   order_by('daybookid desc')->
          //   get()->row_array();
          // }

          // public function Daybook_SelectPreviousBankBalance()
          // {
          //   return $this->db->
          //   select('bankbalance')->
          //   from('daybook')->
          //   where('bankbalance !=','0')->
          //   order_by('daybookid desc')->
          //   get()->row_array();
          // }

           public function selectAccountGroup($ledgername)
          {
            // $result= $this->db->query("select * from accountledger where ledgername='$ledgername'");
            // return $result->result();
            return $this->db->
            select('accountgroup')->
            from('accountledger')->
            where('ledgername',$ledgername)->
            get()->row_array();
          }

          //  public function insert_daybook($data)
          // {
          //   $result=$this->db->insert("daybook",$data);
          //   return $result;
          // }

          public function getaccountledgerwithbalance()
          {  
                // $result=$this->db->query("SELECT * from accountledger WHERE currentbalance >0");
                //  return $result;  
           $result=$this->db->query("SELECT accountledger.ledgername,accountledger.rootid,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid  GROUP BY accountledger.ledgername,accountledger.rootid,daybook.ledgername");
           return $result;                           

         }


           public function getwalletbalance($branchid,$fromdate,$todate)
           {  

            // $led_branch= $this->db->query("SELECT branchid FROM accountledger INNER JOIN journaldetails ON journaldetails.ledgerid = accountledger.ledgerid WHERE accountledger.ledgerid=6854");

            // print_r($this->db->last_query());

            // $LBranch=30;


     
             $result=$this->db->query("SELECT * FROM (SELECT invoicedate AS date, 'Purchase' AS type, vendorinvoiceno AS reference, grandtotal AS credit, 0 AS debit FROM purchaseinvoicemaster WHERE invoicedate BETWEEN '$fromdate' AND '$todate'  AND branchid = $branchid

              UNION

              SELECT paiddate AS date, 'Cost Payment' AS type, salesdate AS reference, 0 AS credit, paidamount AS debit FROM costpayment WHERE paiddate BETWEEN '$fromdate' AND '$todate' AND branchid = $branchid

              UNION

              SELECT invoicedate AS date, 'Purchase Return' AS type, vendorinvoiceno AS reference, 0 AS credit, grandtotal AS debit FROM purchasereturnmaster WHERE invoicedate BETWEEN '$fromdate' AND '$todate'  AND branchid = $branchid

              UNION

              SELECT date AS date, 'Stock Transfer' AS type, date AS reference, totalcost AS credit, 0 AS debit FROM stockmaster WHERE date BETWEEN '$fromdate' AND '$todate'  AND tbranch = $branchid

              UNION

              SELECT date AS date, 'Stock Transfer' AS type, date AS reference, 0 AS credit, totalcost AS debit FROM stockmaster WHERE date BETWEEN '$fromdate' AND '$todate' AND fbranch = $branchid

              UNION

              SELECT '2020-03-01 00:00:00' AS date, 'Opening Stock' AS type, ledgername AS reference, currentbalance AS credit, 0 AS debit FROM accountledger WHERE ledgerid = 6854

              ) AS rslt ORDER BY date ");

            // print_r($this->db->last_query());



             return $result;   


           }

           public function getaccountledgerwithbalancebydate($fdate,$tdate)
           {  
                   // $result=$this->db->query("SELECT * from accountledger WHERE currentbalance >0");
                //  return $result;    
                 $result=$this->db->query("SELECT accountledger.ledgername,accountledger.rootid,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE (daybook.date BETWEEN '$fdate' AND '$tdate') GROUP BY accountledger.ledgername,accountledger.rootid,daybook.ledgername");
            return $result;           

           }
            public function Autogenerate_contraVoucherNo()
        {
          $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from contravoucher");
          return $query;
        }
         public function getcontravoucher()
        {
    $result=$this->db->query("SELECT contravoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=contravoucher.cashorbank) as cash  from contravoucher inner join accountledger on contravoucher.ledger=accountledger.ledgerid where contravoucher.deleted!=1");
    return $result;
  }
   public function checkexistence_contra($value)
        {
          $result=$this->db->query("SELECT * FROM contravoucher where voucherno = '$value' and deleted !=1");
          return $result->num_rows() ;
        }
         public function insert_contravoucher($data)
        {
          $result=$this->db->insert('contravoucher',$data);
          return $result;
        }
         public function delete_contravoucher($id)
        {
          $result=$this->db->query("UPDATE contravoucher SET deleted=1 where voucherno='$id'");
          if($this->db->affected_rows()>0)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
         public function update_salesbalancebyvouchernoincash($voucherno,$amount,$cashid,$bankid)
          {
           
            $result=$this->db->query("UPDATE salesinvoicemaster SET paidcash=paidcash+$amount,paidbank =paidbank-$amount WHERE invoiceno='$voucherno' AND cash=$cashid AND bank=$bankid ");
           if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }

          }
           public function update_salesbalancebyvouchernoinbank($voucherno,$amount,$cashid,$bankid)
          {
           
            $result=$this->db->query("UPDATE salesinvoicemaster SET paidcash=paidcash-$amount,paidbank =paidbank+$amount WHERE invoiceno='$voucherno' AND cash=$cashid AND bank=$bankid ");
           if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }

          }
           public function getcontravoucherbyvoucherno($voucherno)
        {
    $result=$this->db->query("SELECT contravoucher.*,accountledger.ledgername,(select ledgername FROM accountledger WHERE accountledger.ledgerid=contravoucher.cashorbank) as cash  from contravoucher inner join accountledger on contravoucher.ledger=accountledger.ledgerid where voucherno ='$voucherno' AND contravoucher.deleted!=1");
    return $result->result_array();
  }
          public function insert_newdaybook($data)
          {  
         $invoiceno= $data['invoiceno'];
         $accountType= $data['accountType']; 
         $date = $data['date'];
         $ledgername =  $data['ledgername'];
         $debit  =  $data['debit'];
         $credit = $data['credit'];
         $userid = $data['userid'];
          $opposite = $data['opposite'];
           $balance1= $this->db->query("select rootid,currentbalance from accountledger where ledgerid='$ledgername'");
           $balance1=$balance1->result_array();
          $rootid =$balance1[0]['rootid'];
          $balance=$balance1[0]['currentbalance'];
          $result11=$this->db->query("SELECT daybook.balance  FROM (SELECT ledgerid,ledgername,currentbalance,(SELECT MAX(date)  FROM daybook WHERE ledgername=accountledger.ledgerid AND date<'$date') as lastdate  FROM accountledger where ledgerid ='$ledgername') AS t1 INNER JOIN daybook on t1.ledgerid=daybook.ledgername WHERE t1.lastdate=daybook.date ");
           $result11=$result11->result_array();
           $rowcount=sizeof($result11);
           if($rowcount!=0){
             $balance =$result11[0]['balance'];

           }
          $amount=0;
          if($rootid==1 or $rootid==4){
            $balance=$balance+$debit-$credit;
            $amount=$debit-$credit;
          }
          else{
                   $balance=$balance-$debit+$credit;
                   $amount=$credit-$debit;
          }
          $result =$this->db->query("UPDATE accountledger SET currentbalance =currentbalance+$amount where ledgerid='$ledgername'");
           $result= $this->db->query(" INSERT INTO `daybook`( `invoiceno`, `accountType`, `date`, `debit`, `credit`, `userid`, `ledgername`, `opposite`, `balance`) VALUES ('$invoiceno','$accountType','$date','$debit','$credit','$userid','$ledgername','$opposite','$balance')");
             $result11=$this->db->query("UPDATE daybook SET balance =balance +$amount WHERE date>'$date' AND ledgername='$ledgername' ");
            return $result;
          }
          public function getsupplieraccount($a)
          {
            return $this->db->
            select('supplieraccount')->
            from('supplier')->
            where('supplierid',$a)->
            get()->row_array();
          }
          //ReceiptVoucher_End


          public function Select_supplierledger($supplierid)
          {
             return $this->db->
            select('*')->
            from('supplier')->
            where('supplierid', $supplierid)->
            get()->row_array();
          }
    
          //PurchaseInvoice_AccountConnection_End
          

          //CustomerBalance Update in customer from ReceiptVoucher_start(13-02-2019)

          // public function update_customerbalancefromReceiptVoucher($customerid,$amount)
          // {
          //   $result=$this->db->query("UPDATE customer SET customerbalance=customerbalance-$amount WHERE customerid='$customerid'");
          //   return $result;
          // }
                 
          
          	public function Autofill_Productdetails_byName($name)
        	{  
        		 $result=array();
               $result=$this->db->query("SELECT * FROM product INNER JOIN unit ON product.unitid=unit.unitid
              INNER JOIN brand ON product.brandid=brand.brandid
              INNER JOIN product_group ON product.groupid=product_group.groupid where product.pdt_name='$name'");
              return $result->result();
        	}
        	
        	 public function Autofill_Productdetails_TEST_new($CODE)
             {
               $result=array();
               $result=$this->db->query("SELECT * FROM product INNER JOIN unit ON product.unitid=unit.unitid INNER JOIN brand ON product.brandid=brand.brandid INNER JOIN product_group ON product.groupid=product_group.groupid WHERE product.pdt_code='$CODE'");
               return $result->result();
            }


//sales account
          

            public function checkexistence_product2($name,$code)
            {
              $result=$this->db->query("SELECT * from product WHERE pdt_name='$name' OR pdt_code='$code'");
              return $result->num_rows() ;
            }

            public function Autofill_Hsn($code)
            {
              $result=$this->db->query("SELECT * from product_group WHERE groupid='$code'");
              return $result->result();
            }

          public function singleproduct($data)
	        {
            
            $result=$this->db->query("SELECT * from product WHERE pdt_code='$data'");
            return $result->result();
          }

          public function getcostofsales($fdate,$tdate,$branch)
	        {
            $result=array();
            $result['res1']=$this->db->query("SELECT DATE(salesinvoicemaster.salesdate) Dateonly, SUM(salesinvoicemaster.stockamount) AS stocksum ,(SELECT IFNULL(SUM(stockamount),0)  FROM salesreturnmaster WHERE salesreturnmaster.branchid=salesinvoicemaster.branchid AND  salesdate  BETWEEN CONCAT(DATE_FORMAT(Dateonly, '%Y-%m-%d'),' 00:00:00') AND CONCAT(DATE_FORMAT(Dateonly, '%Y-%m-%d'), ' 23:59:59'))  AS returnTotalCost,(SELECT IFNULL(SUM(costpayment.paidamount),0)  from costpayment where branchid =salesinvoicemaster.branchid AND salesdate =Dateonly ) AS paidamount,branch.branchname FROM `salesinvoicemaster`JOIN branch ON salesinvoicemaster.branchid=branch.branchid  WHERE salesinvoicemaster.branchid='$branch'  AND salesinvoicemaster.salesdate BETWEEN '$fdate' AND '$tdate' GROUP BY Dateonly")->result();

           // print_r($this->db->last_query());

          

            return $result;
          }

            public function insertsize($size)
            {
              $result=$this->db->insert('size',$size);
              if($result)
              {
              return true;
              }
             else
              {
              return false;
              }
            }

            
            public function getsalesmaster()
            {
              $q=$this->db->query("SELECT * from salesinvoicemaster");
              return $q;
            }
            public function getsalesmasterbybranch()
            {
              $q=$this->db->query("SELECT salesinvoicemaster.*,branch.branchname FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid ORDER BY invoiceno DESC");
              return $q;
            }
            public function getsalesmasterbybranchbetweendate($fromdate,$todate)
            {
              $q=$this->db->query("SELECT salesinvoicemaster.*,branch.branchname,customer.customername FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid INNER JOIN customer on salesinvoicemaster.customerid=customer.customerid where salesinvoicemaster.salesdate between '$fromdate' and '$todate' ORDER BY invoiceno DESC");
              return $q;
            }

            public function getdailysalesbybranchbetweendate($fromdate,$todate)
            {
              $q=$this->db->query("SELECT DATE(salesdate) Dateonly,COUNT(invoiceno) AS no,ROUND(SUM(totalamount),2)AS total ,ROUND(SUM(billdiscount),2) AS discount,ROUND(SUM(grandtotal),2) AS netsales,ROUND(SUM(paidcash),2) AS cash,ROUND(SUM(paidbank),2)AS bank,ROUND(SUM(balance)*-1,2)AS paidadvance,ROUND(SUM(stockamount),2) AS cost ,ROUND(SUM(grandtotal)-SUM(stockamount),2) AS profit,SUM(totalqty) AS qty,branch.branchname,(SELECT SUM(grandtotal)  FROM salesreturnmaster WHERE salesreturnmaster.branchid=branch.branchid AND DATE(salesdate)=Dateonly GROUP BY DATE(salesdate),branchid ) AS netReturn,(SELECT SUM(stockamount)  FROM salesreturnmaster WHERE salesreturnmaster.branchid=branch.branchid AND DATE(salesdate)=Dateonly GROUP BY DATE(salesdate),branchid) AS stockReturn FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid where salesinvoicemaster.salesdate between '$fromdate' and '$todate' GROUP BY Dateonly,branch.branchname ORDER BY Dateonly ASC");
              return $q;
            }

            public function getadvanceinhand($branchid)
            {
              $q=$this->db->query("SELECT SUM(paid_cash+paid_bank) AS advanceinhand FROM `shoporder` WHERE branchid='$branchid' AND delivery!='1'");
              return $q;
            }

            public function getsalescost($branchid,$fromdate,$todate)
            {
              $q=$this->db->query("SELECT SUM(stockamount) AS costamont FROM salesreturnmaster WHERE salesdate BETWEEN '$fromdate' AND '$todate' AND  branchid='$branchid'");

              // print_r($this->db->last_query());
              return $q;
            }

            public function getsalescost1($branchid)
            {
              $q=$this->db->query("SELECT SUM(stockamount) AS costamont FROM salesreturnmaster WHERE  branchid='$branchid'");

              // print_r($this->db->last_query());
              return $q;
            }

             public function getdailysalesbybranchidbetweendate($branchid,$fromdate,$todate)
            {
              $q=$this->db->query("SELECT DATE(salesdate) Dateonly,COUNT(invoiceno) AS no,ROUND(SUM(totalamount),2)AS total ,ROUND(SUM(billdiscount),2) AS discount,ROUND(SUM(grandtotal),2) AS netsales,ROUND(SUM(paidcash),2) AS cash,ROUND(SUM(paidbank),2)AS bank,ROUND(SUM(balance)*-1,2)AS paidadvance,ROUND(SUM(stockamount),2) AS cost ,ROUND(SUM(grandtotal)-SUM(stockamount),2) AS profit,SUM(totalqty) AS qty,branch.branchname,(SELECT SUM(grandtotal)  FROM salesreturnmaster WHERE salesreturnmaster.branchid=branch.branchid AND DATE(salesdate)=Dateonly GROUP BY DATE(salesdate),branchid ) AS netReturn,(SELECT SUM(stockamount)  FROM salesreturnmaster WHERE salesreturnmaster.branchid=branch.branchid AND DATE(salesdate)=Dateonly GROUP BY DATE(salesdate),branchid) AS stockReturn FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid where salesinvoicemaster.salesdate between '$fromdate' and '$todate' AND salesinvoicemaster.branchid='$branchid' GROUP BY Dateonly,branch.branchname ORDER BY Dateonly ASC");
              return $q;
            }
            public function getsalesmasterbybranchid($branchid)
            {
              $q=$this->db->query("SELECT salesinvoicemaster.*,branch.branchname,customer.customername FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid INNER JOIN customer on salesinvoicemaster.customerid=customer.customerid WHERE salesinvoicemaster.branchid='$branchid'  ORDER BY invoiceno DESC");
              return $q;
            }
            public function getsalesmasterbybranchidbetweendate($branchid,$fromdate,$todate)
            {
              $q=$this->db->query("SELECT salesinvoicemaster.*,branch.branchname FROM salesinvoicemaster INNER JOIN branch ON salesinvoicemaster.branchid=branch.branchid WHERE salesinvoicemaster.branchid='$branchid' and salesinvoicemaster.salesdate between '$fromdate' and '$todate'  ORDER BY invoiceno DESC");
              return $q;
            }
            public function getsalesmaster1($a)
            {
              $q=$this->db->query("SELECT * from salesinvoicemaster WHERE salesmasterid='$a' ");
              return $q->row_array();
            } 

            public function getsalesmasterforreturn($a,$branch)
            {
              $q=$this->db->query("SELECT * from salesinvoicemaster WHERE invoiceno='$a' AND branchid='$branch'");
              return $q;
            } 

            public function getsalesdetailes($a,$branch)
            {
              $q=$this->db->query("SELECT * from salesinvoicedetails JOIN size ON salesinvoicedetails.size = size.sizeid WHERE salesinvoicedetails.salesmasterid='$a' ");
              return $q;
            }

            public function getsalesdetailesforreturn($a,$branch)
            {
              $q=$this->db->query("SELECT * from salesinvoicedetails JOIN size ON salesinvoicedetails.size = size.sizeid WHERE salesinvoicedetails.invoiceno='$a' AND salesinvoicedetails.branchid='$branch'");
              return $q;
            }

            public function getjoumaster($a)
            {
              $q=$this->db->query("SELECT * from journalmaster WHERE voucherno='$a'");
              return $q->result_array();
            } 
            
            public function getjoudetailes($a)
            {
              $q=$this->db->query("SELECT * from journaldetails WHERE voucherno='$a'");
              return $q->result_array();
            }
            
            public function checkproduct($code,$branch,$ba)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$code' AND branch='$branch' AND batchid='$ba'");
              return $result->num_rows();
            }

            public function checkproduct2($name,$size,$branch,$batch)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$name' AND branch='$branch' AND batchid='$batch' AND size ='$size'");
              return $result->num_rows() ;
              // return $result;
            }

            public function did_update_row($id){
              $update_rows = array('branch' => '300',);
              $this->db->where('stockid', $id );
              $this->db->update('stock', $update_rows);  
            }

            public function checksize($size)
            {
              $result=$this->db->query("SELECT * FROM size WHERE sizevalue='$size'");
             
              return $result->row_array();
            }

            public function checkstock($size,$branch,$productid)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$productid'  AND size='$size'  AND branch='$branch'");

              // print_r($this->db->last_query());
             
              return $result->row_array();
            }


            public function insertstock($a,$voucherno,$transactiontype,$date,$userid)
            {     $productid=$a['productid'];
            $branch=$a['branch'];
            $batch=$a['batchid'];
            $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid='$batch'");
            $balance1=$balance1->result_array();
            $currentstock =$balance1[0]['currentstock'];
            $result=$this->db->insert("stock",$a);
            $result11=$this->db->query("SELECT stockregister.currentstock  FROM (SELECT pdt_code,(SELECT MAX(date)  FROM stockregister WHERE productid=product.pdt_code AND date<'$date' AND batchid='$batch') as lastdate  FROM product where pdt_code ='$productid') AS t1 INNER JOIN stockregister on t1.pdt_code=stockregister.productid WHERE t1.lastdate=stockregister.date ");
            $result11=$result11->result_array();
            $rowcount=sizeof($result11);
            if($rowcount!=0){
             $currentstock =$result11[0]['currentstock'];

           }
           $a['voucherno']=$voucherno;
           $a['transactiontype']=$transactiontype;
           $a['date']=$date;
           $a['qty']=$a['currentstock'];
           $qty= $a['qty'];
           $a['userid']=$userid;
           $a['currentstock']=$currentstock+$a['currentstock'];
           $result=$this->db->insert("stockregister",$a);
           $result11=$this->db->query("UPDATE stockregister SET currentstock =currentstock + $qty WHERE date>'$date' AND productid='$productid' ");
           return $result;
         }

         public function updatestock_register($size12,$branch,$productid,$qty)
         {

          $result11=$this->db->query("UPDATE stock SET currentstock =(currentstock -(2 * '$qty'))  WHERE productid='$productid' AND branch = '$branch' AND size = '$size12'");
           return $result11;

         }

            public function updatestock($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid)
            {   $productid=$product;
                  $branch=$branch;
                  $a=array();
                 
                  $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid=$batch");
                 $balance1=$balance1->result_array();
                 $currentstock =$balance1[0]['currentstock'];

              $result=$this->db->query("UPDATE stock SET currentstock=currentstock+$qty WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size='$size'");

              $result11=$this->db->query("SELECT stockregister.currentstock  FROM (SELECT pdt_code,(SELECT MAX(date)  FROM stockregister WHERE productid=product.pdt_code AND date<'$date' AND batchid='$batch') as lastdate  FROM product where pdt_code ='$productid') AS t1 INNER JOIN stockregister on t1.pdt_code=stockregister.productid WHERE t1.lastdate=stockregister.date ");
           $result11=$result11->result_array();
           $rowcount=sizeof($result11);
           if($rowcount!=0)
           {
             $currentstock =$result11[0]['currentstock'];

           }
               $a['voucherno']=$voucherno;
               $a['transactiontype']=$transactiontype;
                $a['date']=$date;
                 $a['qty']=$qty;
                  $a['userid']=$userid;
                   $a['currentstock']=$currentstock+$qty;
                   $a['productid']=$product;
                    $a['size']=$size;
                     $a['branch']=$branch;
                      $a['batchid']=$batch;
                       $result=$this->db->insert("stockregister",$a);
                        $result11=$this->db->query("UPDATE stockregister SET currentstock =currentstock + $qty WHERE date>'$date' AND productid='$productid' ");
              return $result;
            }

    public function update_ledger(int $id,string $data_old,string $data_new)
    {   

      $result=$this->db->query("UPDATE accountledger SET ledgername='$data_new' WHERE ledgername = '$data_old' AND branchid='$id'");

      return $result;

    }

    public function updatestock2($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid)
    { $productid=$product;
      $branch=$branch;
      $a=array();

      $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid=$batch");
      $balance1=$balance1->result_array();
      $currentstock =$balance1[0]['currentstock'];

      $result=$this->db->query("UPDATE stock SET currentstock=currentstock+$qty WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size='$size'");

      $result11=$this->db->query("SELECT stockregister.currentstock  FROM (SELECT pdt_code,(SELECT MAX(date)  FROM stockregister WHERE productid=product.pdt_code AND date<'$date' AND batchid='$batch') as lastdate  FROM product where pdt_code ='$productid') AS t1 INNER JOIN stockregister on t1.pdt_code=stockregister.productid WHERE t1.lastdate=stockregister.date ");
      $result11=$result11->result_array();
      $rowcount=sizeof($result11);
      if($rowcount!=0)
      {
       $currentstock =$result11[0]['currentstock'];

     }
     $a['voucherno']=$voucherno;
     $a['transactiontype']=$transactiontype;
     $a['date']=$date;
     $a['qty']=$qty;
     $a['userid']=$userid;
     $a['currentstock']=$currentstock+$qty;
     $a['productid']=$product;
     $a['size']=$branch;
     $a['branch']=$branch;
     $a['batchid']=$batch;
     $result=$this->db->insert("stockregister",$a);
     $result11=$this->db->query("UPDATE stockregister SET currentstock =currentstock + $qty WHERE date>'$date' AND productid='$productid' ");
     return $result;
   }


   public function updatestock_db($product,$size,$qty,$branch,$batch)
   {   
    $productid=$product;
    $branch=$branch;
    $a=array();

    $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid=$batch");
    $balance1=$balance1->result_array();
    $currentstock =$balance1[0]['currentstock'];

    $result=$this->db->query("UPDATE stock SET currentstock=currentstock+$qty WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size='$size'");

   return $result;
 }


   public function insertstock2($a,$voucherno,$transactiontype,$date,$userid)
   {     
    $productid=$a['productid'];
    $branch=$a['branch'];
    $batch=$a['batchid'];
    $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid='$batch'");
    $balance1=$balance1->result_array();
    $currentstock =$balance1[0]['currentstock'];
    $result=$this->db->insert("stock",$a);
    $result11=$this->db->query("SELECT stockregister.currentstock  FROM (SELECT pdt_code,(SELECT MAX(date)  FROM stockregister WHERE productid=product.pdt_code AND date<'$date' AND batchid='$batch') as lastdate  FROM product where pdt_code ='$productid') AS t1 INNER JOIN stockregister on t1.pdt_code=stockregister.productid WHERE t1.lastdate=stockregister.date ");
    $result11=$result11->result_array();
    $rowcount=sizeof($result11);
    if($rowcount!=0){
      $currentstock =$result11[0]['currentstock'];

    }
    $a['voucherno']=$voucherno;
    $a['transactiontype']=$transactiontype;
    $a['date']=$date;
    $a['qty']=$a['currentstock'];
    $qty= $a['qty'];
    $a['userid']=$userid;
    $a['currentstock']=$currentstock+$a['currentstock'];
    $result=$this->db->insert("stockregister",$a);
    $result11=$this->db->query("UPDATE stockregister SET currentstock =currentstock + $qty WHERE date>'$date' AND productid='$productid' ");
    return $result;
  }


  public function insertstock_db($a)
  {     
    $productid=$a['productid'];
    $branch=$a['branch'];
    $batch=$a['batchid'];
    $balance1= $this->db->query("SELECT SUM(currentstock) as currentstock FROM `stock` WHERE productid='$productid' and branch='$branch' and batchid='$batch'");

    $result=$this->db->insert("stock",$a);
    return $result;
  }

            public function api_getstockbysize($code)
            {
              $result=$this->db->query("SELECT * FROM stock JOIN size ON stock.size = size.sizeid WHERE stock.productid='$code'");
              return $result;

            }

          
            public function transferstock($f,$t,$q,$p,$b)
            {
              $from=$this->db->query("UPDATE stock SET currentstock=currentstock-$q WHERE productid='$p' AND branch='$f' AND batchid='$b'");
              if($from)
             {
                  $a=$this->db->query("SELECT * FROM stock WHERE branch='$t' AND productid='$p' AND batchid='$b'");
                      if ($a->num_rows()>0) 
                          {              
                            $to=$this->db->query("UPDATE stock SET currentstock=currentstock+$q WHERE productid='$p' AND branch='$t' AND batchid='$b'");
                            return $to;
                            // return $a->num_rows();
                          }
                        else
                        {
                          $ba=$this->db->query("INSERT INTO stock values('','$p','$t','$q','','$b')");
                           return $ba;
                        }   
              
             }
             else{
              return false;
             }
              // return $from;
            
            }
            public function getstocktransfer()
            {
              $result=$this->db->query("SELECT * FROM stockmaster");
              return $result;
            }
              public function deletetransfer($a)
            {
              if($result1=$this->db->query("DELETE FROM stockmaster WHERE voucherno=$a"))
              {
              $result=$this->db->query("DELETE FROM stockdetails WHERE voucherno=$a");
              return $result;
            }
            else
            {
              return false;
            }
          }
            public function getstockmasterid($a)
            {
              $result=$this->db->query("SELECT * FROM stockmaster WHERE voucherno='$a'");
              return $result;
            } public function getstockdetailsid($a)
            {
              $result=$this->db->query("SELECT * FROM stockdetails WHERE voucherno='$a'");
              return $result;
            }

            public function Autogenerate_StockVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from stockmaster");
            return $query;
     
          }

          public function Autogenerate_chequeVoucherNo($type)
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from cheque where type ='$type'");
            return $query;
          }

          public function getcheque()
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier) as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank) as bankname FROM `cheque` where status='Pending' order by date1 ASC");
            return $query;
          }

          public function getchequebranch($branchid)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier AND accountledger.branchid='$branchid') as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank AND accountledger.branchid='$branchid') as bankname FROM `cheque` where status='Pending' order by date1 ASC");
            return $query;
          }

          public function getchequebetweendates($fromdate,$todate)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier) as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank) as bankname FROM `cheque` where date1 between '$fromdate' AND '$todate' order by date1 ASC");
            return $query;
          }

          public function getchequebetweendatesbranch($fromdate,$todate,$branchid)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier AND accountledger.branchid='$branchid') as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank AND accountledger.branchid='$branchid') as bankname FROM `cheque` where date1 between '$fromdate' AND '$todate' order by date1 ASC");
            return $query;
          }

          public function getchequefromdate($fromdate)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier) as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank) as bankname FROM `cheque` where date1 > '$fromdate' order by date1 ASC ");
            return $query;
          }

          public function getchequefromdatebranch($fromdate,$branchid)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier AND accountledger.branchid='$branchid') as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank AND accountledger.branchid='$branchid') as bankname FROM `cheque` where date1 > '$fromdate' order by date1 ASC ");
            return $query;
          }

          public function getchequetodate($todate)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier) as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank) as bankname FROM `cheque` where date1<'$todate' order by date1 ASC");
            return $query;
          }

          public function getchequetodatebranch($todate,$branchid)
          {
            $query=$this->db->query("SELECT cheque.*,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.supplier AND accountledger.branchid='$branchid') as suppliername,(select ledgername FROM accountledger where accountledger.ledgerid =cheque.bank AND accountledger.branchid='$branchid') as bankname FROM `cheque` where date1<'$todate' order by date1 ASC");
            return $query;
          }

          public function insert_chequepayment($data)
         {
           $this->db->trans_start();
          $this->db->insert('cheque',$data);
          $result = $this->db->insert_id();
           $this->db->trans_complete();
           return $result;
         }

          public function editstockmaster($a,$b)
          {
            $this->db->query("DELETE FROM stockdetails WHERE voucherno='$b'");
             $this->db->where('voucherno',$b);
            $this->db->update('stockmaster',$a);
             if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
          public function getcustmeraccount($customer)
          {
            $result=$this->db->query("SELECT customeraccount FROM customer WHERE customerid='$customer'");
            return $result;
          }
          // public function viewdaybook($date)
          // {
          //   $result=$this->db->query("SELECT * FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE daybook.date='$date'");
          //   return $result;
          // }

          public function viewdaybook($cdate)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid  WHERE date='$cdate'");
            return $result;
          }

          public function viewdaybookbranch($cdate,$branchid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid  WHERE date='$cdate' AND accountledger.branchid='$branchid'");
            return $result;
          }

          

          public function viewdaybookbyledger($cdate,$ledgerid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid  WHERE daybook.ledgername='$ledgerid'AND date='$cdate'");
            return $result;
          }

          public function viewdaybookbyledgerbranch($cdate,$ledgerid,$branchid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite AND branchid='$branchid') as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid  WHERE daybook.ledgername='$ledgerid'AND date='$cdate' AND accountledger.branchid='$branchid'");
            return $result;
          }

          public function ltddaybook($fdate,$tdate)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE date BETWEEN '$fdate' and '$tdate'");
            return $result;
          }

          public function ltddaybookbranch($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE date BETWEEN '$fdate' and '$tdate' AND accountledger.branchid='$branchid'");
            return $result;
          }

          public function ltddaybookbyledger($fdate,$tdate,$ledgerid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite) as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE daybook.ledgername='$ledgerid' AND date BETWEEN  '$fdate' and '$tdate' ");
            return $result;
          }

          public function ltddaybookbyledgerbranch($fdate,$tdate,$ledgerid,$branchid)
          {
            $result=$this->db->query("SELECT daybook.invoiceno,daybook.date,daybook.accountType,daybook.debit,daybook.credit,accountledger.ledgername,(SELECT ledgername FROM accountledger where ledgerid =daybook.opposite AND branchid='$branchid') as Particulars,daybook.balance FROM daybook inner join accountledger on daybook.ledgername = accountledger.ledgerid WHERE daybook.ledgername='$ledgerid' AND date BETWEEN  '$fdate' and '$tdate' AND accountledger.branchid='$branchid'");
            return $result;
          }


          public function profloss1($fdate,$tdate)
          {
            $result=$this->db->query("SELECT accountledger.ledgername,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE (daybook.date BETWEEN '$fdate' AND '$tdate') AND(accountledger.rootid ='3' )GROUP BY accountledger.ledgername,rootid,daybook.ledgername;");
            return $result;
          }


          public function proflossbranch1($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT accountledger.ledgername,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE (daybook.date BETWEEN '$fdate' AND '$tdate') AND(accountledger.rootid ='3' ) AND accountledger.branchid='$branchid' GROUP BY accountledger.ledgername,rootid,daybook.ledgername;");
            return $result;
          }


          public function profloss2($fdate,$tdate)
          {
            $result=$this->db->query("SELECT accountledger.ledgername,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE (daybook.date BETWEEN '$fdate' AND '$tdate') AND( accountledger.rootid='4')GROUP BY accountledger.ledgername,rootid,daybook.ledgername;");
            return $result;
          }
          

          public function proflossbranch2($fdate,$tdate,$branchid)
          {
            $result=$this->db->query("SELECT accountledger.ledgername,SUM(daybook.debit) AS debit , SUM(daybook.credit) AS credit FROM daybook INNER JOIN accountledger ON daybook.ledgername=accountledger.ledgerid WHERE (daybook.date BETWEEN '$fdate' AND '$tdate') AND( accountledger.rootid='4') AND accountledger.branchid='$branchid' GROUP BY accountledger.ledgername,rootid,daybook.ledgername;");
            return $result;
          }


          public function GetAsset()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE rootid='1'");
            return $query;
          }

          public function GetAssetbranch($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE rootid='1' AND branchid='$branchid'");
            return $query;
          }

          public function GetLiabilities()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE rootid='2'");
            return $query;
          }

          public function GetLiabilitiesbranch($branchid)
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE rootid='2' AND branchid='$branchid'");
            return $query;
          }


// journalvoucher
           public function Autogenerate_Journal_VoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from journalmaster");
            return $query;
          }
          public function Autogenerate_Journal_VoucherNo1()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from journalmaster");
            return $query->result();
          }

            public function checkexistence_journalvoucher($value)
          {
           
            $result=$this->db->query("SELECT * FROM journalmaster where voucherno = '$value'");
            return $result->num_rows() ;

          }
          public function checkexistence_size($size)
          {
           
            $result=$this->db->query("SELECT * FROM size where sizevalue = '$size'");
            return $result->num_rows() ;

          }
           public function insert_journalmaster($data)
         {
            $result=$this->db->insert('journalmaster',$data);

            if($result)
            { $result =$this->db->insert_id();
              return $result;
            }
            else
            {
              return false;
            }
         }
          public function insert_journaldetails($data)
         {
            $result=$this->db->insert('journaldetails',$data);

            if($result)
            { $result =$this->db->insert_id();
              return $result;
            }
            else
            {
              return false;
            }
         }
      public function insert_image($data)
      {
       $result=$this->db->insert('images',$data);
       return $result;
      }
      
      public function getimagehandler()
      {
        $query = $this->db->query("SELECT * FROM images");
        return $query;
      }

      public function insertimagehandler($data)
      {
        $result=$this->db->insert('images',$data);
        return $result;
      }

      public function deleteimagehandler($imgcode)
      {
        $result=$this->db->query("DELETE from images where productcode='$imgcode'");
      }
      
      public function updateimagehandler($id,$data)
      {
        $this->db->where('productcode',$id);
        $this->db->update('images',$data);
        return true;
      }

      public function gettypehandler()
      {
        $query = $this->db->query("SELECT DISTINCT type FROM images");
        return $query;
      }

      public function checkexistence_image($data)
          {
          	$result=$this->db->query("SELECT * FROM images where productcode ='$data'");
          	return $result->num_rows() ;
          }

      public function getimg($pdt)
      {
        $result=$this->db->query("SELECT * FROM images WHERE productcode='$pdt'");
        return $result->result();
      }


      public function shoporderaccount($cash,$bank,$paidcash,$paidbank,$customer)
      {
        $cashresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$paidcash WHERE ledgerid='$cash'");
        $bankresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$paidbank WHERE ledgerid='$bank'");
        $custblnce=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-($paidcash+$paidbank) WHERE ledgerid='$customer'");
        return true; 
      }

      public function shoporderdelaccount($cash,$bank,$oldpaidcash,$oldpaidbank,$customer)
      {
        $cashresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$oldpaidcash WHERE ledgerid='$cash'");
        $bankresult=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$oldpaidbank WHERE ledgerid='$bank'");
        $custblnce=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+($oldpaidcash+$oldpaidbank) WHERE ledgerid='$customer'");
        return true; 
      }

      public function geteorderreportbydate($fdate,$tdate,$currencyid)
      {
        $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current BETWEEN '$fdate' AND '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status != 'Cancel' ORDER BY eCommerce_no DESC ");
        // print_r($this->db->last_query());

        return $q->result_array();
      }

      public function geteorderdetails($fdate,$tdate,$currencyid)
      {
        $q=$this->db->query("SELECT ecommerce_orderdetails.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue,ecommerce_ordermaster.rzp_orderId FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_current BETWEEN '$fdate' AND '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY eCommerce_no DESC ");

        // print_r($this->db->last_query());
        return $q->result_array();
      }

}
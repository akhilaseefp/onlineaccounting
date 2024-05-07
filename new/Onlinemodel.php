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
		$result=$this->db->get_where('login',$data);
     ?> <script type="text/javascript"> alert ('hi');   </script>  <?php 
		if ($result->num_rows()>0) 
			{
				return true;
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
   public function delete($id)   {
                                         	$result=$this->db->query("DELETE from signup where userid='$id'");
                                    if($this->db->affected_rows()>0){
                                    return $result;
                                      }

           }
           public function insert_productgroup($data)
           {
                                 	$result=$this->db->insert('product_group',$data);
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
           public function get_productgroup()
           {
                $result=$this->db->get('product_group');
	 	return $result;                 	

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
          {
            $this->db->where('supplierid',$id);
            $this->db->update('supplier',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
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

          public function getsupplier()
           {
                $result=$this->db->query(" SELECT * FROM supplier INNER JOIN accountledger ON supplier.supplieraccount=accountledger.ledgerid");
    return $result;                   

           }
          public function checkexistence_supplier($value)
          {
           
          	$result=$this->db->query("SELECT * FROM supplier where suppliername = '$value'");
          	return $result->num_rows() ;

          }
                 public function insert_product($data)
         {
               $result=$this->db->insert('product',$data);
                     
                     if($result){
                     	return true;
                     }	
                     else
                     {
                     	return false;
                     }
         }
         
         public function getproduct()
         {
           $query=$this->db->query("SELECT *,SUM(stock.currentstock) FROM product INNER JOIN unit on product.unitid=unit.unitid INNER JOIN product_group on product.groupid=product_group.groupid INNER JOIN brand on product.brandid=brand.brandid INNER JOIN stock on product.pdt_code=stock.productid GROUP BY product.pdt_code
");
           return $query;
         }
          public function checkexistence_product($value)
          {
           
          	$result=$this->db->query("SELECT * FROM product where pdt_name = '$value'");
          	return $result->num_rows() ;

          }
           public function checkexistence_product1($name,$code)
          {
           
            $result=$this->db->query("SELECT * FROM product where pdt_name = '$name' OR pdt_code='$code'");
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
          {
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


  public function Autogenerate_VoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchaseinvoicemaster");
            return $query;
          }
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
          $result=$this->db->get('accountgroup');
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
           public function update_accountledger($id,$data)
          {
            $this->db->where('ledgerid',$id);
            $this->db->update('accountledger',$data);
                                    if($this->db->affected_rows()>0){
                                    return true;
                                      }
                                      else {
                                        return false;
                                      }
          }
           public function checkexistence_accountledger($value)
          {
           
            $result=$this->db->query("SELECT * FROM accountledger where ledgername = '$value'");
            return $result->num_rows() ;

          }
           public function checkexistence_journalvoucher($value)
          {
           
            $result=$this->db->query("SELECT * FROM journalmaster where voucherno = '$value'");
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
                $query=$this->db->query("SELECT purchaseinvoicemaster.purchasemasterid,purchaseinvoicemaster.voucherno,purchaseinvoicemaster.vendorinvoiceno,purchaseinvoicemaster.paymentmode,purchaseinvoicemaster.suppliername,purchaseinvoicemaster.invoicedate,purchaseinvoicemaster.orderno,purchaseinvoicemaster.totalqty,purchaseinvoicemaster.totalamount,purchaseinvoicemaster.additionalcost,purchaseinvoicemaster.taxamount,purchaseinvoicemaster.billdiscount,purchaseinvoicemaster.grandtotal,purchaseinvoicemaster.oldbalance,purchaseinvoicemaster.cashorbank,purchaseinvoicemaster.paidamount,purchaseinvoicemaster.balance,purchaseinvoicemaster.narration,purchaseinvoicemaster.transportcompany,purchaseinvoicedetials.purchasedetailsid,purchaseinvoicedetials.voucherno,purchaseinvoicedetials.productname,purchaseinvoicedetials.productcode,purchaseinvoicedetials.qty,purchaseinvoicedetials.unitprice,purchaseinvoicedetials.netamount,purchaseinvoicedetials.tax,purchaseinvoicedetials.taxamount,purchaseinvoicedetials.amount from purchaseinvoicemaster INNER JOIN purchaseinvoicedetials on purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno");
                
          
          }

    public function save_product($data){
      // {: , :, :group,unitid:unit,brandid:brand,tax:tax,mrp:price,openingstock:qty
     
        $result=$this->db->insert('product',$data);
        return $result;
    }
   public function insertdetailes($data)
   {
    $this->db->insert('purchaseinvoicemaster',$data);
   }
      public function editdetailes($a,$data)
   {
    $this->db->where('voucherno',$a);
   $q2=$this->db->update('purchaseinvoicemaster',$data);
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
             //Branch_start

          public function getBranch()
          {
            $result=$this->db->get('branch');
            return $result;
          }

          public function insert_branch($data)
          {
            $result=$this->db->insert('branch',$data);
            if ($result)
            {
              return true;
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

          public function CheckUser($data)
          {
            $result=$this->db->get_where('adduser',$data);
            if ($result->num_rows()>0) 
              {
                return $result;
                }
            else
            {
              return false;
            }
          }

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

          public function LoadPurchaseDetails_All($fromdate,$todate)
          {
            $result=$this->db->query("SELECT * from purchaseinvoicedetials where invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

          public function Loadpurchasedetails_Supplierwise($fromdate,$todate,$supplier)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicemaster inner join purchaseinvoicedetials
            ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno
            WHERE purchaseinvoicemaster.suppliername='$supplier' and purchaseinvoicedetials.invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

          public function Loadpurchasedetails_ProductNamewise($fromdate,$todate,$productname)
          {
            $result=$this->db->query("SELECT * FROM purchaseinvoicedetials where productname='$productname' and invoicedate between '$fromdate' and '$todate'");
            return $result;
          }

          //PurchaseReport_End

          //StockReport_Start
          public function LoadAllstock()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t2.currentstock 
            from product_group AS t1
            INNER JOIN product AS t2 ON t1.groupid=t2.groupid
            INNER JOIN brand AS t3 ON t3.brandid=t2.brandid
            INNER JOIN unit AS t4 ON t4.unitid=t2.unitid
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadNegativeStock()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t2.currentstock 
            from product_group AS t1
            INNER JOIN product AS t2 ON t1.groupid=t2.groupid
            INNER JOIN brand AS t3 ON t3.brandid=t2.brandid
            INNER JOIN unit AS t4 ON t4.unitid=t2.unitid
            WHERE currentstock<'0'
            ORDER by t2.pdt_id ASC");
            return $result;
          }

          public function LoadReorderLevel()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t2.currentstock 
            from product_group AS t1
            INNER JOIN product AS t2 ON t1.groupid=t2.groupid
            INNER JOIN brand AS t3 ON t3.brandid=t2.brandid
            INNER JOIN unit AS t4 ON t4.unitid=t2.unitid
            WHERE currentstock<minimumstock
            ORDER by t2.pdt_id ASC");
            return $result;
          }

           public function LoadUnused()
          {
            $result=$this->db->query("SELECT t2.pdt_id,t2.pdt_name,t1.groupname,t3.brandname,t4.unitname,t2.minimumstock,t2.currentstock 
            from product_group AS t1
            INNER JOIN product AS t2 ON t1.groupid=t2.groupid
            INNER JOIN brand AS t3 ON t3.brandid=t2.brandid
            INNER JOIN unit AS t4 ON t4.unitid=t2.unitid
            LEFT JOIN salesinvoicedetails AS t5
            on t2.pdt_name=t5.productname
            WHERE t5.productname is null
            ORDER by t2.pdt_id ASC");
            return $result;
          }

        

          public function LoadFastMoving()
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t1.currentstock FROM product AS t1
              INNER JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2 ON t1.pdt_name=t2.productname
              INNER JOIN product_group AS t3 ON t3.groupid=t1.groupid
              INNER JOIN brand AS t4 ON t4.brandid=t1.brandid
              INNER JOIN unit AS t5 ON t5.unitid=t1.unitid
              order by QTY DESC");
            return $result;
          }

          public function LoadSlowMoving()
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t1.currentstock FROM product AS t1
              INNER JOIN(SELECT SUM(qty) AS QTY,productname
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              INNER JOIN product_group AS t3 ON t3.groupid=t1.groupid
              INNER JOIN brand AS t4 ON t4.brandid=t1.brandid
              INNER JOIN unit AS t5 ON t5.unitid=t1.unitid
              order by QTY ASC");
            return $result;
          }

       
          public function LoadFastMovingBtwDates($fromdate,$todate)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t1.currentstock FROM product AS t1
              INNER JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              INNER JOIN product_group AS t3 ON t3.groupid=t1.groupid
              INNER JOIN brand AS t4 ON t4.brandid=t1.brandid
              INNER JOIN unit AS t5 ON t5.unitid=t1.unitid
             WHERE t2.salesdate between '$fromdate' and 'todate'
              order by QTY DESC");
            return $result;
          }

          public function LoadSlowMovingBtwDates($fromdate,$todate)
          {
            $result=$this->db->query("SELECT t1.pdt_id,t1.pdt_name,t3.groupname,t4.brandname,t5.unitname,t1.minimumstock,t1.currentstock FROM product AS t1
              INNER JOIN(SELECT SUM(qty) AS QTY,productname,salesdate
              from salesinvoicedetails
              GROUP BY productname) AS t2
              ON t1.pdt_name=t2.productname
              INNER JOIN product_group AS t3 ON t3.groupid=t1.groupid
              INNER JOIN brand AS t4 ON t4.brandid=t1.brandid
              INNER JOIN unit AS t5 ON t5.unitid=t1.unitid
             WHERE t2.salesdate between '$fromdate' and '$todate'
              order by QTY ASC");
            return $result;
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
  $vou=$this->db->query("SELECT * FROM purchaseinvoicemaster");
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

          public function Autogenerate_InvoiceNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(salesmasterid+1),1) as NO from salesinvoicemaster");
            return $query;
          }  

          public function  getcustomer()
          {
            $result=$this->db->query("SELECT * FROM customer INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid");
            return $result;
          }      
            public function checkexistence_customer($name)
            {
                   $result=$this->db->query("SELECT * from customer WHERE customername='$name'");
                   return $result->num_rows() ;
            }

           public function insert_customer($data)
         {
               $result=$this->db->insert('customer',$data);
                     
                     if($result){
                      return true;
                     }  
                     else
                     {
                      return false;
                     }
         }
         public function update_customer($data,$id){

                               $this->db->where('customerid',$id);
                               $this->db->update('customer',$data);
                                $result=$this->db->get('customer');
                                if($this->db->affected_rows()>0){
                                 return $result;
                            }}

           public function insert_salesinvoicemaster1($data)
         {
               $result=$this->db->insert('salesinvoicemaster',$data);
                     
                     if($result){
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
         {$result=array();
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
 public function insert_salesinvoicemaster($data)
         {
          $this->db->insert('salesinvoicemaster',$data);
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


         public function sales_stock($p,$q,$b)
         {
          $stock=$this->db->query("UPDATE stock SET currentstock=currentstock-$q WHERE productid=$p AND branch='$b'");
          return $stock;
         }
          //SalesInvoice_End

public function checkexistence_payment($value)
          {
           
            $result=$this->db->query("SELECT * FROM paymentvoucher where voucherno = '$value'");
            return $result->num_rows() ;

          }
    
     public function insert_paymentvoucher($data)
        {
           $result=$this->db->insert('paymentvoucher',$data);
           return $result;
        }   


  public function Autogenerate_payVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from paymentvoucher");
            return $query;
          }

 public function update_paymentvoucher($id,$data)
          {
            $this->db->where('voucherno',$id);
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
    $result=$this->db->query("DELETE from paymentvoucher where voucherno='$id'");
    if($this->db->affected_rows()>0)
    {
      return true;
    }
    else
    {
      return false;
    }
  }

    public function getpaymentvoucher()
  {
    $result=$this->db->query("SELECT * from paymentvoucher inner join supplier on paymentvoucher.supplier=supplier.supplierid");
    return $result;
  }

   //SalesReport_Start

          public function LoadSalesDetails_All($fromdate,$todate)
          {
            $result=$this->db->query("SELECT * from salesinvoicedetails where salesdate between '$fromdate' and '$todate'");
            return $result;
          }

          public function LoadSalesdetails_ProductNamewise($fromdate,$todate,$productname)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails where productname='$productname' and salesdate between '$fromdate' and '$todate'");
            return $result;
          }

          public function Loadsalesdetails_Supplierwise($fromdate,$todate,$supplier)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join purchaseinvoicedetials
            ON salesinvoicedetails.productname=purchaseinvoicedetials.productname inner join purchaseinvoicemaster ON purchaseinvoicemaster.voucherno=purchaseinvoicedetials.voucherno
            WHERE purchaseinvoicemaster.suppliername='$supplier' and salesinvoicedetails.salesdate between '$fromdate' and '$todate'");

            return $result;
          }

          public function Loadsalesdetails_Brandwise($fromdate,$todate,$brand)
          {
            $result=$this->db->query("SELECT * FROM salesinvoicedetails inner join product
            ON salesinvoicedetails.productname=product.pdt_name
            WHERE product.brandid='$brand' and salesinvoicedetails.salesdate between '$fromdate' and '$todate'");

            return $result;
          }

          //SalesReport_End
          //ReceiptVoucher_Start

         public function Autogenerate_ReceiptVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(receiptvoucherid+1),1) as NO from receiptvoucher");
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
            $id=$this->db->where('receiptvoucherid',$id);
            $result=$this->db->delete('receiptvoucher');
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
            $result=$this->db->query("SELECT * FROM `receiptvoucher` inner JOIN customer
            on receiptvoucher.customerid=customer.customerid");
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

          public function Select_customerledger($customerid)
          {  return $this->db->
            select('*')->
            from('customer')->
            where('customerid', $customerid)->
            get()->row_array();
          }

          public function FillBankAndCashLedgers()
          {
            $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=18 OR accountgroup=19");
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

           public function insert_daybook($data)
          {
            $result=$this->db->insert("daybook",$data);
            return $result;
          }
          //ReceiptVoucher_End

public function PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,
            $TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$Bankaccount)
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
           $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance-$CashAccountAmt
              WHERE ledgername='$Bankaccount'");
          }
          if($BankAccountAmt!=0)
          {
           $query1= $this->db->query("UPDATE accountledger
             set currentbalance=currentbalance-$BankAccountAmt
              WHERE ledgername='$Bankaccount'");
          }
           
          return $query1;
          }


          public function Select_supplierledger($supplierid)
          {
             return $this->db->
            select('*')->
            from('supplier')->
            where('supplierid', $supplierid)->
            get()->row_array();
          }
    
          //PurchaseInvoice_AccountConnection_End
          

          // CustomerBalance Update in customer from ReceiptVoucher_start(13-02-2019)

          // public function update_customerbalancefromReceiptVoucher($customerid,$amount)
          // {
          //   $result=$this->db->query("UPDATE customer SET customerbalance=customerbalance-$amount WHERE customerid='$customerid'");
          //   return $result;
          // }
                  public function Autogenerate_PurchaseVoucherNo()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from purchaseinvoicemaster");
            return $query->result();
          }
          
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
               $result=$this->db->query("SELECT * FROM product INNER JOIN unit ON product.unitid=unit.unitid
              INNER JOIN brand ON product.brandid=brand.brandid
              INNER JOIN product_group ON product.groupid=product_group.groupid
              where product.pdt_code='$CODE'");
              return $result->result();
            }
//sales account
            public function salesaccount($sales,$taxamount,$cost,$cashid,$cashamount,$balance,$customerid,$Discount)
            {
              //total sales 
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$sales WHERE ledgername='sales A/C'");
              $s=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$Discount WHERE ledgername='Sales  Discount A/C'");
              $t=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$taxamount WHERE ledgername='sales tax'");
              $c=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$cost WHERE ledgername='cost of sales A/C'");
              $Stock=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance-$sales WHERE ledgername='Stock A/C'");
              $cash=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$cashamount WHERE ledgerid=$cashid");
              $cash=$this->db->query("UPDATE accountledger SET currentbalance=currentbalance+$balance WHERE ledgerid=$customerid");
              return true;
              
              
              
            }

            public function checkexistence_product2($name,$code)
            {
                   $result=$this->db->query("SELECT * from product WHERE pdt_name='$name' OR pdt_code='$code'");
                   return $result->num_rows() ;
            }

            public function updatestock($name,$stock,$branch,$ba)
            {
              $result=$this->db->query("UPDATE stock SET currentstock=currentstock+$stock WHERE productid='$name' AND branch='$branch' batchid='$ba' ");
              return $result;
            }
            public function getsalesmaster()
            {
              $q=$this->db->query("SELECT * from salesinvoicemaster");
              return $q;
            }
            public function checkproduct($code,$branch,$ba)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$code' AND branch='$branch' AND batchid='$ba");
                   return $result->num_rows() ;


            }
            public function insertstock($a)
            {
              $result=$this->db->insert("stock",$a);
              return $result;
            }

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
            public function transferstock($f,$t,$q,$p)
            {
             if( $from=$this->db->query("UPDATE stock SET currentstock=currentstock-$q WHERE productid='$p' AND branch='$f'"))
             {
                  $a=$this->db->query("SELECT * FROM stock WHERE branch='$t' AND productid='$p'");
                      if ($a->num_rows()>0) 
                          {              
                            $to=$this->db->query("UPDATE stock SET currentstock=currentstock+$q WHERE productid='$p' AND branch='$t'");
                            return true;
                          }
                        else
                        {
                          $b=$this->db->query("INSERT INTO stock values('','$p','$t','$q','')");
                           return $b;
                        }   
              
             }
             else{
              return false;
             }
            
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
}



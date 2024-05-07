<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Esalesmodel extends CI_Model {
  
  
  public function getproduct()
  {
    $query=$this->db->query("SELECT product.*,SUM(stock.currentstock),unit.unitid,unit.unitname,product_group.groupid,product_group.groupname,brand.brandid,brand.brandname,product_group.taxlow,product_group.slab,product_group.taxhigh FROM product LEFT JOIN unit on product.unitid=unit.unitid LEFT JOIN product_group on product.groupid=product_group.groupid LEFT JOIN brand on product.brandid=brand.brandid LEFT JOIN stock on product.pdt_code=stock.productid GROUP BY product.pdt_code");
    return $query;
  }
  
  public function getOnlineBranch()
  {
    $this->db->where('branchid','18');
    $result=$this->db->get('branch');
    return $result;
  }
  
  public function getbatch()
  {
    $query = $this->db->get('batch');
    return $query;
  }
  
  public function getsize()
  {
    $result=$this->db->query("SELECT * FROM size");
    return $result;
  }
  
  public function Autogenerate_EInvoiceNo($branchid)
  {
    $query=$this->db->query("SELECT IFNULL(max(eCommerce_no+1),1) as NO from ecommerce_ordermaster");
    return $query;
  }
  
  public function Autogenerate_orderid($branchid)
  {
    $query=$this->db->query("SELECT IFNULL(max(eCommerce_id+1),1) as NO from ecommerce_ordermaster");
    return $query;
  } 
  
  public function  getcustomer()
  {
    $result=$this->db->query("SELECT * FROM customer INNER JOIN accountledger ON customer.customeraccount=accountledger.ledgerid");
    return $result;
  }
  
  public function getsalesman1()
  {
    $result=$this->db->query("SELECT * from salesman where branchid='18'");
    return $result;
  }

  public function getcurrency()
  {
    $result=$this->db->query("SELECT * from currency");
    return $result;
  }

  public function getconversionrate($currencyid)
  {
    $query=$this->db->query("SELECT conversionrate from currency WHERE currencyid='$currencyid'");
    return $query;
  } 
  
  public function FillCashLedgers()
  {
    $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=18");
    return $query;
  }

  public function FillCashLedgersmoaonline()
  {
    $query=$this->db->query("SELECT * FROM `accountledger` WHERE accountgroup=18 and ledgerid = 1399");
    return $query;
  }
  
  public function FillBankLedgers()
  {
    $query=$this->db->query("SELECT * FROM `accountledger` WHERE  accountgroup=19");
    return $query;
  }

  public function FillBankLedgersmoaonline()
  {
    $query=$this->db->query("SELECT * FROM `accountledger` WHERE  accountgroup=19 and ledgerid = 1400");
    return $query;
  }

	                  	 public function Autofill_Productdetails_TEST_new($CODE)
             {
               $result=array();
               $result=$this->db->query("SELECT * FROM product INNER JOIN unit ON product.unitid=unit.unitid INNER JOIN brand ON product.brandid=brand.brandid INNER JOIN product_group ON product.groupid=product_group.groupid WHERE product.pdt_code='$CODE'");
               return $result->result();
            }

            public function Autogenerate_eInvoiceNoNew($branchid)
				{
				  $query=array();
				  $query=$this->db->query("SELECT IFNULL(max(eCommerce_no+1),1) as NO from ecommerce_ordermaster");
				        return $query;
				  return $query;
				}

			public function insertshipping($data)
			{
              $this->db->trans_start();
              log_message('error', "ship model");
              $this->db->insert("shipping_address",$data);
              $result = $this->db->insert_id();
              $this->db->trans_complete();
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

             public function redeempoints($masterid,$customerid,$points,$DATE)
             {
               $query=$this->db->query("UPDATE customer SET points=points-$points WHERE customerid='$customerid'");
               if($query){ 
                $npoints=$points*-1;
                $s=$this->db->query("INSERT INTO redeem (`redeem_type`, `coupon_code`, `promotion_code`, `redeem_points`, `customerid`, `salesmasterid`, `date`) VALUES ('POS_REDEEM','','','$npoints','$customerid','$masterid','$DATE') ");
              }
              return $s;
            }

      public function updShipcustomer($customerid,$data1)
       {

        $this->db->where('customerid',$customerid);
        $this->db->update('customer',$data1);
        if($this->db->affected_rows()>0){
          return true;
        }
        else {
          return false;
        }



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

		    public function checkproduct($code,$branch,$ba)
            {
              $result=$this->db->query("SELECT * FROM stock WHERE productid='$code' AND branch='$branch' AND batchid='$ba'");
              return $result->num_rows();
            }

            public function insertstock($a)
            {
              $result=$this->db->insert("stock",$a);
              return $result;
            }

            public function updatestock($product,$size,$qty,$branch,$batch)
            {
              $result=$this->db->query("UPDATE stock SET currentstock=currentstock+$qty WHERE productid='$product' AND branch='$branch' AND batchid='$batch' AND size='$size'");
              return $result;
            }

            public function insert_daybook($data)
            {
              $result=$this->db->insert("daybook",$data);
              return $result;
            }

          public function Select_customerledger($id)
          {  return $this->db->
            select('*')->
            from('customer')->
            where('customerid', $id)->
            get()->row_array();
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

        public function Allgeteorder($cdate)
        {
          $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current ='$cdate' AND ecommerce_ordermaster.status != 'Cancel' ORDER BY eCommerce_no DESC");
          return $q;
        }


        public function geteorder($cdate,$currencyid)
        {
          $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current ='$cdate' AND ecommerce_ordermaster.ship='$currencyid' AND ecommerce_ordermaster.status != 'Cancel' ORDER BY eCommerce_no DESC");
          return $q;
        }

          public function geteorder1($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current between '$fdate' and '$tdate' AND ecommerce_ordermaster.ship='$currencyid' AND ecommerce_ordermaster.status != 'Cancel' ORDER BY eCommerce_no DESC");
            return $q;
          }

          public function Allgeteorder1($fdate,$tdate)
          {
            $q=$this->db->query("SELECT ecommerce_ordermaster.*,branch.branchname,customer.customername FROM ecommerce_ordermaster INNER JOIN branch ON ecommerce_ordermaster.branchid=branch.branchid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid where ecommerce_ordermaster.date_current between '$fdate' and '$tdate' AND ecommerce_ordermaster.status != 'Cancel' ORDER BY eCommerce_no DESC");
            return $q;
          }

          public function geteorderdetails($cdate,$currencyid,$status)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue,ecommerce_ordermaster.rzp_orderId FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_current ='$cdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_orderdetails.status='$status' ORDER BY eCommerce_no DESC");
            return $q;
          }

          public function geteorderdetails1($fdate,$tdate,$currencyid,$status)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue,ecommerce_ordermaster.rzp_orderId FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_current between '$fdate' and '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_orderdetails.status='$status' ORDER BY eCommerce_no DESC");
            return $q;
          }




          public function ecomreportbypaydate($cdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment ='$cdate' AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbypaydate1($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment between '$fdate' and '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }
          public function ecomproductionreport($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,product.imagpath AS image,ecommerce_ordermaster.*,shipping_address.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid
            LEFT JOIN shipping_address ON ecommerce_ordermaster.customerid=shipping_address.customerid INNER JOIN product ON product.pdt_code =ecommerce_orderdetails.productcode INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_current between '$fdate' and '$tdate'AND shipping_address.ecommerce_orderid=ecommerce_ordermaster.eCommerce_id AND ecommerce_ordermaster.ship='$currencyid' ORDER BY ecommerce_orderdetails.status,ecommerce_ordermaster.eCommerce_no");
            return $q;
          }
           public function ecomproductionreporttoday($cdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,product.imagpath AS image,ecommerce_ordermaster.*,branch.branchname,shipping_address.*,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN product ON product.pdt_code =ecommerce_orderdetails.productcode 
            LEFT JOIN shipping_address ON ecommerce_ordermaster.customerid=shipping_address.customerid  INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_current ='$cdate'AND shipping_address.ecommerce_orderid=ecommerce_ordermaster.eCommerce_id AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY ecommerce_orderdetails.status,ecommerce_ordermaster.date_current,ecommerce_orderdetails.eorderdetailsid");
            return $q;
          }
           public function ecomproductionpendingreport($currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,product.imagpath AS image,ecommerce_ordermaster.*,branch.branchname,shipping_address.*,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN product ON product.pdt_code =ecommerce_orderdetails.productcode
            LEFT JOIN shipping_address ON ecommerce_ordermaster.customerid=shipping_address.customerid  INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_orderdetails.status<2 AND shipping_address.ecommerce_orderid=ecommerce_ordermaster.eCommerce_id AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY ecommerce_ordermaster.date_current,ecommerce_orderdetails.eorderdetailsid ASC");
            return $q;
          }
           public function ecomproductionpendingreportbystatus($currencyid,$status)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,product.imagpath AS image,ecommerce_ordermaster.*,branch.branchname,shipping_address.*,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN product ON product.pdt_code =ecommerce_orderdetails.productcode
            LEFT JOIN shipping_address ON ecommerce_ordermaster.customerid=shipping_address.customerid  INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_orderdetails.status='$status' AND shipping_address.ecommerce_orderid=ecommerce_ordermaster.eCommerce_id AND ecommerce_ordermaster.currencyid='$currencyid' ORDER BY ecommerce_ordermaster.date_current,ecommerce_orderdetails.eorderdetailsid ASC");
            return $q;
          }

          public function ecomreportbyPaidNotDelivered($cdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment ='$cdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Bank Payment' AND ecommerce_orderdetails.status!='5' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbyPaidNotDelivered1($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,ecommerce_ordermaster.status AS masterstatus,ecommerce_orderdetails.status AS detailstatus,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment between '$fdate' and '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Cash On Delivery' OR ecommerce_ordermaster.status='Bank Payment' AND ecommerce_orderdetails.status!='5' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbynotpaid($cdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment ='$cdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Not Paid' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbynotpaid1($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment between '$fdate' and '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Not Paid' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbycancelled($cdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment ='$cdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Cancel' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          public function ecomreportbycancelled1($fdate,$tdate,$currencyid)
          {
            $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_ordermaster.*,branch.branchname,customer.customername,customer.customerid,size.sizevalue FROM ecommerce_orderdetails INNER JOIN branch ON ecommerce_orderdetails.branchid=branch.branchid INNER JOIN ecommerce_ordermaster ON ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN customer on ecommerce_ordermaster.customerid=customer.customerid INNER JOIN size on size.sizeid=ecommerce_orderdetails.size where ecommerce_ordermaster.date_payment between '$fdate' and '$tdate' AND ecommerce_ordermaster.currencyid='$currencyid' AND ecommerce_ordermaster.status='Cancel/Refund' ORDER BY ecommerce_ordermaster.eCommerce_no DESC");
            return $q;
          }

          

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
          
          public function getecust($c)
          {
            $q=$this->db->query("SELECT * from customer WHERE customer.customerid='$c'");
            return $q;
          }

           public function getorder($a)
            {
              $q=$this->db->query("SELECT ecommerce_orderdetails.*,ecommerce_orderdetails.status AS rowstatus,ecommerce_ordermaster.*,ecommerce_orderdetails.taxamount AS rowtaxamount, size.*,product.imagpath, ecommerce_orderdetails.status AS masterstatus,ecommerce_ordermaster.eCommerce_no AS no,ecommerce_ordermaster.taxamount AS totaltax from ecommerce_ordermaster INNER JOIN ecommerce_orderdetails on ecommerce_ordermaster.eCommerce_id=ecommerce_orderdetails.eordermasterid INNER JOIN product ON product.pdt_code =ecommerce_orderdetails.productcode  INNER JOIN size on ecommerce_orderdetails.size =size.sizeid WHERE eCommerce_id='$a'");
              return $q;
            }
            public function nowstatus($a)
            {
              $q=$this->db->query("SELECT ecommerce_ordermaster.status from ecommerce_ordermaster WHERE eCommerce_id='$a'");
              return $q;
            }
        public function getship($c,$a)
            {
              $q=$this->db->query("SELECT * from shipping_address INNER JOIN country ON shipping_address.country=country.country_id  WHERE customerid='$c' AND ecommerce_orderid ='$a'");
              return $q;
            }

            public function getstatus()
            {
              $q=$this->db->query("SELECT * from status");
              return $q;
            }

            public function getpaymentstatus()
            {
              $q=$this->db->query("SELECT * from status WHERE payment='1'");
              return $q;
            }

            public function getdeliverystatus()
            {
              $q=$this->db->query("SELECT * from status WHERE delivery='1'");
              return $q;
            }

            public function getcountry()
            {
              $q=$this->db->query("SELECT * from country INNER JOIN shippingcharge ON country.country_id=shippingcharge.country INNER JOIN currency ON shippingcharge.currency=currency.currencyid");
              return $q;
            }

         public function Autofill_currentbalance($custid)
          {
            $query=$this->db->query("SELECT accountledger.currentbalance,accountledger.ledgerid, customer.openingbalance FROM accountledger inner join  customer on accountledger.ledgerid =  customer.customeraccount WHERE customer.customerid='$custid'");
            return $query->result_array();
          }

                    public function geteorderstatus($id,$branch)
          {
            $query=array();
            $query=$this->db->query("SELECT SUM(cash_payment + bank_payment) AS paidamount,ecommerce_ordermaster.status FROM `ecommerce_ordermaster`WHERE eCommerce_id = '$id'");
            return $query->result_array();
          }

                    public function getbranchledger($invoiceno)
          {
            $query=$this->db->query("SELECT accountledger.ledgername,daybook.accountType,daybook.date,daybook.balance,(daybook.debit+daybook.credit) AS paidamount FROM daybook INNER JOIN`accountledger` on daybook.ledgername=accountledger.ledgerid WHERE daybook.invoiceno='$invoiceno' AND (accountledger.accountgroup=19 OR accountledger.accountgroup=18) AND (accountType='Ecommerce Sales' OR accountType='Ecommerce Receipt') ");
            return $query->result_array();
          }

        public function update_eorder($description,$id)
        // {
        //   $this->db->where('eorderdetailsid',$id);
        //   $this->db->update('ecommerce_orderdetails',$data);
        //   return true;
        // }
        {
            $result=$this->db->query("UPDATE ecommerce_orderdetails SET description='$description' WHERE eorderdetailsid='$id'");
            return $result;
        }


        public function update_eorderstatus($data,$id)
        {
          $this->db->where('eCommerce_id',$id);
          $result=$this->db->update('ecommerce_ordermaster',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
        }
         public function return_eorderitem($data,$id)
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
        public function update_eorderstock($difference,$orderno)
        { log_message('error',$difference."-".$orderno);
            $result=$this->db->query("UPDATE ecommerce_ordermaster SET stockamount=stockamount+$difference WHERE eCommerce_no=$orderno");
            return $result;
        }
        public function update_edetailstatus($data,$id)
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
        
        public function update_esalesordermaster($paidcash,$paidbank,$id,$status,$date_payment,$discount,$balance)
          {
            $result=$this->db->query("UPDATE ecommerce_ordermaster SET bank=1400,cash=1399,bank_payment=bank_payment+ $paidbank,cash_payment=cash_payment+$paidcash,balance=$balance,billdiscount=billdiscount+$discount,status='$status',date_payment='$date_payment' WHERE eCommerce_id='$id'");

    log_message('error',$status);
    log_message('error',$id);
            return $result;
          }
          
          
          public function Autogenerate_ReceiptVoucherNoe()
          {
            $query=$this->db->query("SELECT IFNULL(max(voucherno+1),1) as NO from receiptvoucher");
            return $query->result_array();
          }
          
          public function Select_ledger($ledgername)
          {
             return $this->db->
            select('*')->
            from('accountledger')->
            where('ledgerid', $ledgername)->
            get()->row_array();
          }

                     public function checkexistence_receiptvoucherno($value)
          {
            $result=$this->db->query("SELECT * from receiptvoucher where voucherno='$value'");
            return $result->num_rows();
          }

          public function insert_ReceiptVoucher($data)
          {
            $result=$this->db->insert("receiptvoucher",$data);
            return $result;
          }
          
          
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

            return $result;
          }


                public function Autofill_custdetails($custid,$masterid)
            {
              $query=$this->db->query("SELECT * from shipping_address WHERE customerid='$custid' AND ecommerce_orderid='$masterid' ");
              return $query->result_array();
            }

         public function update_ecustmer($cusid,$masterid,$data)
          {
            // $result=$this->db->query("UPDATE shipping_address SET name='$name' WHERE ecommerce_orderid ='$masterid'");
            // return $result;
          $this->db->where('id',$masterid);
          $result=$this->db->update('shipping_address',$data);
          if($result)
          {
            return true;
          }
          else
          {
            return false;
          }
          }
public function getprevorders($c){
  $query=$this->db->query("SELECT * FROM `ecommerce_orderdetails`INNER JOIN `ecommerce_ordermaster` ON `ecommerce_orderdetails`.`eordermasterid` = `ecommerce_ordermaster`.`eCommerce_id` WHERE `customerid`= $c");
  return $query->result_array();
}
public function add_customer($data){
  $customer_name = $data['customer_name'];
  $customer_mobile = $data['customer_mobile'];

  $this->db->query("INSERT INTO customer (`customername`, `customercode`, `phonenumber`) VALUES ('$customer_name','$customer_mobile','$customer_mobile') ");
             }
             
// *********************** DELETE ESALES ***********************************************

public function get_product_details($invoiceno){
    $this->db->select('productcode,size,qty,branchid,batchid');
    $this->db->where('eordermasterid',$invoiceno);

    $query = $this->db->get('ecommerce_orderdetails');
          if($query->num_rows() > 0){
      return $query->result_array();
    }else{
      return array();
    }
          
}
public function get_order_master($invoiceno){
    $this->db->select('*');
    $this->db->where('eCommerce_id',$invoiceno);

    $query = $this->db->get('ecommerce_ordermaster');
          if($query->num_rows() > 0){
      return $query->result_array();
    }else{
      return array();
    }
          
}
         public function delete_salesinvoicemaster($invoiceno)
         {
          $result=$this->db->query("DELETE ecommerce_ordermaster,ecommerce_orderdetails FROM ecommerce_ordermaster INNER JOIN ecommerce_orderdetails ON ecommerce_ordermaster.eCommerce_id = ecommerce_orderdetails.eordermasterid WHERE eCommerce_id='$invoiceno'");
          return $result;
         }
public function delete_shipping_address($invoiceno){
  $this->db->query("DELETE from shipping_address WHERE ecommerce_orderid = '$invoiceno' ");
}

// ************************** **********************************************************
}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Webcontroller extends CI_Controller {

    public function __cunstruct()
    {
        parent::__cunstruct();
        $this->load->helper('form');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->helper("file");
        $data['min']=$this->Onlinemodel->getminstock();
    }


    public function ecomsales()
    {

            $fdate=$this->input->get_post('frdate');
            $tdate=$this->input->get_post('todate');

            $cdate=date('Y-m-d');
            $data=array();
            $data['fdate'] =$fdate;
            $data['tdate'] =$tdate;
            // if(!empty($fdate) && !empty($tdate))
            // {
                $data['mastr']=$this->Onlinemodel->geteorderreportbydate($fdate,$tdate,1);
                $data['detls']=$this->Onlinemodel->geteorderdetails($fdate,$tdate,1);

            // }
            // else
            // {

            //     $data['voch']=$this->Onlinemodel->getsalesreportbydate(date('Y-m-d 00:00:00'),date('Y-m-d 23:59:59'));
            // }

        echo json_encode($data);

    }

    public function api_getimage()
    {
        $type = $_GET['type'];
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getimage($type)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_branchSaleDetails()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("branchSaleProducts" => $this->Onlinemodel->api_pdtqty($fdate,$tdate,$branchid)->result(),"branchSaleProductCategory" => $this->Onlinemodel->api_pdtcategory($fdate,$tdate,$branchid)->result(),"branchSaleSalesman" => $this->Onlinemodel->api_salesmansum($fdate,$tdate,$branchid)->result(),"branchSaleSummary" => $this->Onlinemodel->api_btwnsum($fdate,$tdate,$branchid)->result(),"orderCount" => $this->Onlinemodel->api_getordercount()->result()),JSON_NUMERIC_CHECK);
    }



    public function api_customerSaleDetails()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $customerid = $this->input->get_post('customerid');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("customerSaleSummary" => $this->Onlinemodel->btwncustomer($customerid,$fOnlyDate,$tOnlyDate)->result(),"customerSaleNoOfReceipt"=>$this->Onlinemodel->api_noofreceipt($fOnlyDate,$tOnlyDate,$customerid)->result(),"customerSaleNoOfInvoice"=>$this->Onlinemodel->api_noofinvoice($fdate,$tdate,$customerid)->result(),"customerSaleProductCategory"=>$this->Onlinemodel->api_customercategory($fdate,$tdate,$customerid,$branchid)->result(),"customerSaleProducts" => $this->Onlinemodel->api_pdtqtycustomer($fdate,$tdate,$customerid,$branchid)->result(),"customerOutAmount" => $this->Onlinemodel->api_customerOutAmount($customerid)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_supplierPurchaseDetails()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("supplierPurchaseProducts" => $this->Onlinemodel->api_supplierproduct($fdate,$tdate,$supplierid)->result(),"supplierPurchaseProductCategory"=>$this->Onlinemodel->api_supplierproductcategory($fdate,$tdate,$supplierid)->result(),"supplierPurchaseNoOfVoucher"=>$this->Onlinemodel->api_noofvoucher($fdate,$tdate,$supplierid)->result(),"supplierPurchaseNoOfPayment"=>$this->Onlinemodel->api_noofpayment($fOnlyDate,$tOnlyDate,$supplierid)->result(),"SupplierPurchaseDetails" => $this->Onlinemodel->btwnsupplier($supplierid,$fOnlyDate,$tOnlyDate)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_getProductSummary()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $pdt = $this->input->get_post('pdt');
        $this->load->model('Onlinemodel');
        echo json_encode(array("productSold"=>$this->Onlinemodel->api_getqtysum($fdate,$tdate,$pdt)->result(),"productPurchased"=>$this->Onlinemodel->api_getpurchasesum($fdate,$tdate,$pdt)->result(),"currentProductStock"=>$this->Onlinemodel->api_getcurrentstock($pdt)->result(),"productStockDetails"=>$this->Onlinemodel->api_getpdtstock($pdt)->result()),JSON_NUMERIC_CHECK); 
    }


    public function api_getimageandproduct()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getproduct()->result(),"banner" => $this->Onlinemodel->api_getbannerimage()->result(),"slider"=> $this->Onlinemodel->api_getsliderimage()->result()),JSON_NUMERIC_CHECK); 
    }


    public function api_customerNotification()
    { 
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("customerNotification" => $this->Onlinemodel->api_customerNotification($customerid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_updCustomerNotification()
    { 
        $this->load->model('Onlinemodel');
        $notificationid=$this->input->get_post('notificationid');
        $not = explode(",", $notificationid);
        foreach ($not as $key => $value)
        {
            $ans=$this->Onlinemodel->api_updCustomerNotification($value);
        }
        echo json_encode(array("updCustomerNotification" =>$ans),JSON_NUMERIC_CHECK); 
        
    }
    

    public function api_getallstock()
    {
       $this->load->model('Onlinemodel');
       echo json_encode(array("products" => $this->Onlinemodel->api_getallstock()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_geterror()
    {
        $insertdata['deviceid'] = $this->input->get_post('deviceid');
        $insertdata['userid'] = $this->input->get_post('userid');
        $insertdata['date']= $this->input->get_post('date');
        $insertdata['message']= $this->input->get_post('message');
       $this->load->model('Onlinemodel');
       echo json_encode(array("errormessage" => $this->Onlinemodel->api_geterror($insertdata)->result()),JSON_NUMERIC_CHECK);
    }

    

    public function api_getproductsize()
    {
        $code = $this->input->get_post('code');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getproductsize($code,$branchid)->result()),JSON_NUMERIC_CHECK);
    }
    
     public function api_getsizeid()
    {
        $id = $this->input->get_post('id');
        $this->load->model('Onlinemodel');
        echo json_encode(array("size" => $this->Onlinemodel->api_getsizeid($id)->result()),JSON_NUMERIC_CHECK);
    }


    public function api_getbranchbyid()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("branchbyid" => $this->Onlinemodel->api_getbranchbyid($branchid)->result()),JSON_NUMERIC_CHECK);
    }


    public function api_noOfShopOrder()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noOfShopOrder" => $this->Onlinemodel->api_noOfShopOrder($branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getledger()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $data = $this->Onlinemodel->api_FillCashLedgers($branchid)->result();
        $datas = $this->Onlinemodel->api_FillBankLedgers($branchid)->result();
        echo json_encode(array("cash" =>$data,"bank"=>$datas),JSON_NUMERIC_CHECK);
        
    }

    
    
    public function api_branchSaleProfit()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        echo json_encode(array("branchSaleProfit"=> $this->Onlinemodel->api_branchSaleProfit($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_branchReturnTotal()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        echo json_encode(array("branchReturnTotal"=> $this->Onlinemodel->api_branchReturnTotal($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_branchSaleAnalysis()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        echo json_encode(array("branchReturnTotal"=> $this->Onlinemodel->api_branchReturnTotal($fdate,$tdate,$branchid)->result(),"branchSaleProfit"=> $this->Onlinemodel->api_branchSaleProfit($fdate,$tdate,$branchid)->result(),"shopOrderAdvance" => $this->Onlinemodel->api_shopOrderAdvance($fOnlyDate,$tOnlyDate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_InvoiceNo()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $data=$this->Onlinemodel->Autogenerate_InvoiceNo($branchid)->result()[0]->NO;
        echo json_encode(array("data"=> $data),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_ShopOrder()
    {
        $this->load->model('Salesmodel');
        $branchid = $this->input->get_post('branchid');
        $data=$this->Salesmodel->Autogenerate_ShopOrder($branchid)->result()[0]->NO;
        echo json_encode(array("data"=> $data),JSON_NUMERIC_CHECK);
    }
    
    public function api_singleproduct()
    {
        $data = $this->input->get_post('productid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("product" => $this->Onlinemodel->api_singleproduct($data)),JSON_NUMERIC_CHECK);
    }

    public function api_getprobygrp()
    {
        $data = $this->input->get_post('groupid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getprobygrp($data)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getproductname()
    {
        $name = $this->input->get_post('name');
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getproductname($name)->result()),JSON_NUMERIC_CHECK);
    }


    public function api_customerdetails()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("customer" => $this->Onlinemodel->customerdetails()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_supplierdetails()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("supplier" => $this->Onlinemodel->supplierdetails()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_supplierdetailsbranch()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("supplier" => $this->Onlinemodel->supplierdetailsbranch($branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getcustomer()
    {
        $code = $this->input->get_post('code');
        $this->load->model('Onlinemodel');
        $data = $this->Onlinemodel->api_getcustomer($code)->result();
        // if($data)
        // {
             echo json_encode(array("customer" => $data),JSON_NUMERIC_CHECK);
        // }
        // else
        // {
        //     echo json_encode(array("message" => "Customer does not exists"),JSON_NUMERIC_CHECK);
        // }
        
    }
    public function api_getcustomerall()
    {
        $code = $this->input->get_post('code');
        $this->load->model('Onlinemodel');
        $data = $this->Onlinemodel->api_getcustomerall()->result();
        // if($data)
        // {
             echo json_encode(array("customer" => $data),JSON_NUMERIC_CHECK);
        // }
        // else
        // {
        //     echo json_encode(array("message" => "Customer does not exists"),JSON_NUMERIC_CHECK);
        // }
        
    }

    public function Api_ecomCustomerLogin()
    {   

        $username= $this->input->get_post('user');
        $password= $this->input->get_post('pass');
        $this->load->model('Onlinemodel');
        $login['log']=$this->Onlinemodel->CheckCust($username);
        if($login['log'])
        {
            foreach ($login['log']->result() as $key)
            {
                if(password_verify($password,$key->pass))
                {
                    $data=$key;
                }
                else
                {
                    $data = array();
                    // $data['status']='False';
                }
            }
        }
        else
        {
            $data=array();
            // $data['status']='False';
        }
        // echo json_encode($data,JSON_NUMERIC_CHECK);
        echo json_encode(array("CustomerLogin"=>$data),JSON_NUMERIC_CHECK);
    }

    public function api_getpdtbycode()
    {
        $code = $this->input->get_post('code');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtbycode" => $this->Onlinemodel->Autofill_Productdetails($code)->result()),JSON_NUMERIC_CHECK);

    }

    public function insert_customer()
    {
        // $action=$this->input->get_post('btnsave');
        $this->load->model('Salesmodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        $code=$data->customercode;
        $pho=$data->phonenumber;
        $branchid=$data->branchid;
        $insertdata['customername']=$data->customername;
        $insertdata['customercode']=$code;
        $insertdata['address']=$data->address;
        $insertdata['email']=$data->email;
        $insertdata['branchid']=$branchid;
        $insertdata['phonenumber']=$pho;
        $insertdata['vatno']=$data->vatno;
        $insertdata['openingbalance']=$data->openingbalance;
        $insertdata['points']=$data->points;
        $openingbalance=$data->openingbalance;
        $existence=$this->Onlinemodel->checkexistence_customer($code,$pho);
        if($existence==0)
        {
            //Ledger Insertion_start
            $insertdata2['ledgername']=$pho;
            $insertdata2['accountgroup']='17';
            $insertdata2['interestcalculation']=0;
            $insertdata2['openingbalance']=$openingbalance;
            $insertdata2['creditordebit']='Dr';
            $insertdata2['narration']='Autogenerated for Customer';
            $insertdata2['branchid']=$branchid;
            $insertdata2['currentbalance']=$openingbalance;
            $result=$this->Onlinemodel->insert_accountledger($insertdata2);
            $insertdata['customeraccount']=$result;
            if($result=true)
            {
                $ledgervalues=$this->Onlinemodel->api_insert_customer($insertdata);
                //echo 'ledgersuccess';
                echo json_encode (array("message"=>$ledgervalues),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            echo json_encode (array("message"=>"Customer name already exists!!!"),JSON_NUMERIC_CHECK);
        }
    }


    public function update_customer()
    {
        //$action=$this->input->get_post('btnsave');
        $this->load->model('Salesmodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        $oldphone=$data->oldphone;
        $oldcode=$data->oldcode;
        $code=$data->customercode;
        $pho=$data->phonenumber;
        $account=$data->account;
        $branchid=$data->branchid;
        $insertdata['customername']=$data->customername;
        $insertdata['customercode']=$code;
        $insertdata['address']=$data->address;
        $insertdata['email']=$data->email;
        $insertdata['branchid']=$branchid;
        $insertdata['customeraccount']=$account;
        $insertdata['phonenumber']=$pho;
        $insertdata['vatno']=$data->vatno;
        $insertdata['openingbalance']=$data->openingbalance;
        $insertdata['points']=$data->points;
        $openingbalance=$data->openingbalance;
        $existence=$this->Onlinemodel->checkexistence_customer($oldcode,$oldphone);
        if($existence!=0)
        {
            //Ledger Updation_start
            // $ans=array();
            // $ans=$this->Onlinemodel->api_getledger($account)->result();
            $insertdata2['ledgername']=$pho;
            $insertdata2['accountgroup']='17';
            $insertdata2['interestcalculation']=0;
            $insertdata2['openingbalance']=$openingbalance;
            $insertdata2['creditordebit']='Dr';
            $insertdata2['narration']='Autogenerated for Customer';
            $insertdata2['branchid']=$branchid;
            $insertdata2['currentbalance']=$openingbalance;
            $result=$this->Onlinemodel->update_accountledger($account,$insertdata2);
            if($result=true)
            {
                $ledgervalues=$this->Onlinemodel->api_update_customer($insertdata,$oldcode);
                //echo 'ledgersuccess';
                echo json_encode (array("message"=>$ledgervalues),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            echo json_encode (array("message"=>"Customer name already exists!!!"),JSON_NUMERIC_CHECK);
        }
    }

     public function api_getBranchReceipt()
     {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("BranchReceipt" => $this->Onlinemodel->api_getsalesbybranch($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getProductsByReceipt()
     {
        $masterid = $this->input->get_post('masterid');
        // $customerid = $this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("ProductsByReceipt" => $this->Onlinemodel->api_salesdetailsbymaster($masterid)->result()),JSON_NUMERIC_CHECK);
        // "CustomerById"=>$this->Onlinemodel->api_getcustomerbyid($customerid)->result()
    }

    

    public function insert_salesinvoicemaster()
        {
            $this->load->model('Salesmodel');
            // $ans = file_get_contents('php://input');
            // $data = json_decode($ans);
            $points= $this->input->get_post('redeemedpoints');
            $customerid = $this->input->get_post('customerid');
            $DATE=$this->input->get_post('salesdate');
            $sales = $this->input->get_post('totalamount');
            $invoiceno =$this->input->get_post('invoiceno');
            $branchid= $this->input->get_post('branchid');  

            $insertdata['invoiceno'] = $invoiceno;
            $insertdata['customerid'] = $customerid;
            $insertdata['salesorderno'] = $this->input->get_post('salesorderno');
            $insertdata['salesmode'] =$this->input->get_post('salesmode');
            $insertdata['salesdate'] = $DATE;
            $insertdata['totalqty'] = $this->input->get_post('totalqty');
            $insertdata['totalamount'] = $sales;
            $insertdata['additionalcost'] = $this->input->get_post('additionalcost');
            $insertdata['taxamount'] = $this->input->get_post('taxamount');
            $insertdata['billdiscount'] = $this->input->get_post('billdiscount');
            $insertdata['grandtotal'] = $this->input->get_post('grandtotal');
            $insertdata['oldbalance'] = $this->input->get_post('oldbalance');
            $insertdata['cash'] = $this->input->get_post('cash');
            $insertdata['bank'] = $this->input->get_post('bank');
            $insertdata['paidcash'] = $this->input->get_post('paidcash');
            $insertdata['paidbank'] = $this->input->get_post('paidbank');
            $insertdata['balance'] = $this->input->get_post('balance');
            $insertdata['narration'] = $this->input->get_post('narration');
            $insertdata['branchid'] = $branchid;    
            $insertdata['salesman'] = $this->input->get_post('salesmancode');   
            $insertdata['stockamount'] = $this->input->get_post('stockamount'); 
            $insertdata['userid'] =$this->input->get_post('userid');
            // $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid);
            // if($existence == null)
            // {
                $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
                // $stat = $dat1;
                if($points!=0)
                {
                    $a=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
                }
                $addpoints =($sales*1/100);
                if($sales!=0)
                {
                    $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
                }
                $this->api_SalesInvoice_DayBookInsertion(false);
                $this->api_SalesInvoice_AccountInsertion(false);
                echo json_encode(array("message"=>$dat1),JSON_NUMERIC_CHECK);
            // }else 
            // echo json_encode(array("message"=>$existence-result()),JSON_NUMERIC_CHECK);
        }



    public function insert_salesinvoicedetails()
    {
        // $ans=false;
        $id=$this->input->get_post('id');
         $this->load->model('Salesmodel');
         $this->load->model('Onlinemodel');
         $new = file_get_contents('php://input');
         $product = json_decode($new);
        // $prs = $product->salesdetails;
        foreach($product as $data)
        {
         $insertdata['salesmasterid'] = $id;
         $insertdata['invoiceno'] = $data->invoiceno;
         $insertdata['salesdate'] = $data->salesdate;
         $insertdata['productname'] = $data->productname;
         $insertdata['productcode'] = $data->productcode;
         $insertdata['qty'] = $data->qty;
         $insertdata['size'] = $data->size;
         $insertdata['unitprice'] = $data->mrp;

         $insertdata['netamount'] = $data->netamount;
         $insertdata['tax'] = $data->tax;
         $insertdata['taxamount'] = $data->taxamount;
         $insertdata['amount'] = $data->amount;
         $insertdata['branchid'] = $data->branchid;
         $insertdata['batchid'] = $data->batchid;
        //  $insertdata['invoiceno']=$this->input->get_post('invoiceno');
        //  $insertdata['salesdate']=$this->input->get_post('salesdate');
        //  $insertdata['productname']=$this->input->get_post('productname');
        //  $insertdata['productcode']=$this->input->get_post('productcode');
        //  $insertdata['qty']=$this->input->get_post('qty');
        //  $insertdata['hsncode']=$this->input->post('hsn');
        //  $insertdata['size']=$this->input->get_post('size');
        //  $insertdata['unitprice']=$this->input->get_post('unitprice');
        //  $insertdata['netamount']=$this->input->get_post('netamount');
        //  $insertdata['tax']=$this->input->get_post('tax');
        //  $insertdata['taxamount']=$this->input->get_post('taxamount');
        //  $insertdata['amount']=$this->input->get_post('amount');
        //  $insertdata['branchid']=$this->input->get_post('branchid');
        //  $insertdata['batchid']=$this->input->get_post('batchid');
         $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata);
         $branch=$data->branchid;
         $batch=$data->batchid;
         $product=$data->productcode;
         $qty=$data->qty;
         $size=$data->size;
        //  $branch =$this->input->get_post('branchid');
        //  $product=$this->input->get_post('productcode');
        //  $qty=$this->input->get_post('qty')*-1;
        //  $size=$this->input->get_post('size');
        //  $batch=$this->input->get_post('batchid');
          $stck=array();
                        $stck['productid']=$product;
                        $stck['currentstock']=$qty*-1;
                        $stck['branch']=$branch;
                        $stck['batchid']=$batch;
                        $stck['size']=$size;
         
         $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
         if($check==0)
         {
             $stock1=$this->Onlinemodel->insertstock($stck);
         }
         else
         {
             $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch);
         }
        }
        
        
        if($ans)
        {
        echo json_encode (array(array("message"=>"true")),JSON_NUMERIC_CHECK);
        }
        else 
        {
        echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
        }    
    }


    //api_SalesInvoice_AccountInsertion
    public function api_SalesInvoice_AccountInsertion($status = true)
    {
        $this->load->model('Salesmodel');
        // $ans = file_get_contents('php://input');
        // $data = json_decode($ans);
        // $insertdata['taxamount'] = $data->taxamount;
        // $insertdata['paidcash'] = $data->paidcash;
        // $insertdata['paidbank'] = $data->paidbank;
        // $insertdata['billdiscount'] = $data->billdiscount;
        // $insertdata['customerid'] = $data->customerid;
        // $insertdata['grandtotal'] = $data->grandtotal;
        // $insertdata['stockamount'] = $data->stockamount;
        // $insertdata['cash'] = $data->cash;
        // $insertdata['bank'] = $data->bank;
        // $insertdata['balance'] = $data->balance;
            $tax = $this->input->get_post('taxamount');
            $paidcash=$this->input->get_post('paidcash');
            $paidbank= $this->input->get_post('paidbank');
            $discount= $this->input->get_post('billdiscount');
            $customerid = $this->input->get_post('customerid');
            $grandtotal= $this->input->get_post('grandtotal');
            $stock =$this->input->get_post('stockamount');
            $cash= $this->input->get_post('cash');
            $bank= $this->input->get_post('bank');
            $balance= $this->input->get_post('balance');
            if($balance>0){
                $balance =0;
            }
            $sales=$grandtotal-$tax;
            $data['records']=$this->Onlinemodel->Select_customerledger($customerid);
            $customer=$data['records']['customeraccount'];
            $dat2=$this->Salesmodel->salesaccount($sales,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance);
            echo $status ? json_encode(array("message"=>$dat2),JSON_NUMERIC_CHECK):'';
     }




    
        //api_SalesInvoice_DayBookInsertion

    public function api_SalesInvoice_DayBookInsertion($status = true)
    {
        $this->load->model('Salesmodel');
        // $ans = file_get_contents('php://input');
        // $data = json_decode($ans);
        // $insertdata['paidcash'] = $data->paidcash;
        // $insertdata['paidbank'] = $data->paidbank;
        // $insertdata['invoiceno'] = $data->invoiceno;
        // $insertdata['totalamount'] = $data->totalamount;
        // $insertdata['billdiscount'] = $data->billdiscount;
        // $insertdata['customerid'] = $data->customerid;
        // $insertdata['salesdate'] = $data->salesdate;
        // $insertdata['cash'] = $data->cash;
        // $insertdata['bank'] = $data->bank;
        // $insertdata['grandtotal'] = $data->grandtotal;
        $paidcash=$this->input->get_post('paidcash');
        $paidbank=$this->input->get_post('paidbank');
        $invoiceno = $this->input->get_post('invoiceno');
        $total= $this->input->get_post('totalamount');
        $discount = $this->input->get_post('billdiscount');
        $customer = $this->input->get_post('customerid');
        $balance = $this->input->get_post('balance');
        $DATE=$this->input->get_post('salesdate');
        $cash = $this->input->get_post('cash');
        $bank = $this->input->get_post('bank');
        $stock=$this->input->get_post('stockamount');
        // $grandtotal=$this->input->get_post('grandtotal');
        $data2=array(); 
        //sales account
        $data2['invoiceno']=$invoiceno;
        $data2['accountType']='Sales Invoice';
        $data2['date']=$DATE;
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=0;
        $data2['credit']=$stock;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //cash account
        $data2['ledgername']=$cash;
        $data2['debit']=$paidcash;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //bank account
        $data2['ledgername']=$bank;
        $data2['debit']=$paidbank;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=$stock;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //discount of sales
        if($discount>0)
        {
            $data2['ledgername']=28;
            $data2['debit']=$discount;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_daybook($data2);
        }
        //customer
        if($balance<0)
        {
            $data2['ledgername']=$customer;
            $abs=abs($balance);
            $data2['debit']=$abs;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_daybook($data2);
        }
        //tax
        // if($tax>0)
        // {
        //     $data2['ledgername']=23;
        //     $data2['debit']=$tax;
        //     $data2['credit']=0;
        //     $data22=$this->Onlinemodel->insert_daybook($data2);
        // }
        if($data22==false)
        {
            ?><script type="text/javascript">
            alert('Failed Daybook insertion........');
            </script>
            <?php
                      
        }

        echo $status ? json_encode(array("message"=>$data22),JSON_NUMERIC_CHECK):"";
        //Inserting into daybook_End
        
    }


    public function insert_salesreturnmaster()
    {
        $this->load->model('Salesmodel');
        $insertdata['invoiceno'] = $this->input->get_post('invoiceno');
        $insertdata['customerid'] = $this->input->get_post('customerid');
        $insertdata['salesmasterid'] = $this->input->get_post('masterid');
        $insertdata['salesdate'] = $this->input->get_post('salesdate');
        $insertdata['totalqty'] = $this->input->get_post('totalqty');
        $insertdata['totalamount'] = $this->input->get_post('totalamount');
        $insertdata['additionalcost'] = $this->input->get_post('additionalcost');
        $insertdata['taxamount'] = $this->input->get_post('taxamount');
        $insertdata['billdiscount'] = $this->input->get_post('billdiscount');
        $insertdata['grandtotal'] = $this->input->get_post('grandtotal');
        $insertdata['oldbalance'] =$this->input->get_post('oldbalance');
        $insertdata['cash'] = $this->input->get_post('cash');
        $insertdata['bank'] = $this->input->get_post('bank');
        $insertdata['paidcash'] = $this->input->get_post('paidcash');
        $insertdata['paidbank'] = $this->input->get_post('paidbank');
        $insertdata['balance'] = $this->input->get_post('balance');
        $insertdata['narration'] = $this->input->get_post('narration');
        $insertdata['branchid'] = $this->input->get_post('branchid');   
        $insertdata['salesman'] = $this->input->get_post('salesmancode');   
        $insertdata['stockamount'] = $this->input->get_post('stockamount'); 
        $insertdata['userid'] = $this->input->get_post('userid');
        $customerid=$this->input->get_post('customerid');
        $DATE=$this->input->get_post('salesdate');
        $dat=$this->Salesmodel->insert_salesreturnmaster($insertdata);
         $sales=$this->input->get_post('grandtotal');
         $cost=$this->input->get_post('stockamount');
         $addpoints=($sales*-1/100);
            if($addpoints!=0){
                $r=$this->Salesmodel->addpoints($dat,$customerid,$addpoints,$DATE);
            }
            $this->api_SalesReturn_AccountInsertion(false);
            $this->SalesReturn_DayBookInsertion(false);
        echo json_encode(array("message"=>$dat),JSON_NUMERIC_CHECK);
    }

    public function insert_salesreturndetails()
    {
        $ans=false;
         $this->load->model('Salesmodel');
        //  $new = file_get_contents('php://input');
        //  $product = json_decode($new);
        //  $prs = $product->salesdetails;
        // foreach($prs as $key => $data)
        // {
         $insertdata['salesreturnid'] = $this->input->get_post('salesreturnid');
         $insertdata['invoiceno'] = $this->input->get_post('invoiceno');
         $insertdata['salesdate'] = $this->input->get_post('salesdate');
         $insertdata['productname'] = $this->input->get_post('productname');
         $insertdata['productcode'] = $this->input->get_post('productcode');
         $insertdata['qty'] = $this->input->get_post('qty');
         $insertdata['size'] = $this->input->get_post('size');
         $insertdata['unitprice'] = $this->input->get_post('unitprice');
         $insertdata['netamount'] = $this->input->get_post('netamount');
         $insertdata['tax'] = $this->input->get_post('tax');
         $insertdata['taxamount'] = $this->input->get_post('taxamount');
         $insertdata['amount'] = $this->input->get_post('amount');
         $insertdata['branchid'] = $this->input->get_post('branchid');
         $insertdata['batchid'] = $this->input->get_post('batchid');
         $branch=$this->input->get_post('branchid');
         $batch=$this->input->get_post('batchid');
         $product=$this->input->get_post('productcode');
         $qty=$this->input->get_post('qty');
         $size=$this->input->get_post('size');
         $ans=$this->Salesmodel->insert_salesreturndetails($insertdata);
         if($ans)
         {
            $branch=$this->input->get_post('branchid');
            $batch=$this->input->get_post('batchid');
            $product=$this->input->get_post('productcode');
            $batch=$this->input->get_post('productcode');
            $qty=$this->input->get_post('qty');
            $size=$this->input->get_post('size');
            $stck['productid']=$product;
            $stck['currentstock']=$qty;
            $stck['branch']=$branch;
            $stck['batchid']=$batch;
            $stck['size']=$size;
            $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
            if($check==0)
            {
                $stock1=$this->Onlinemodel->insertstock($stck);
            }
            else
            {
                $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch);
            }
         echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
         }
         else 
         {
             echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
         }
    }


    public function api_updatesalesinvoicemaster()
        {
            $this->load->model('Salesmodel');
            // $ans = file_get_contents('php://input');
            // $data = json_decode($ans);
             $id=$this->input->get_post('id');
            $insertdata['invoiceno'] = $this->input->get_post('invoiceno');
            $insertdata['customerid'] = $this->input->get_post('customerid');
            $insertdata['salesorderno'] = $this->input->get_post('salesorderno');
            $insertdata['salesmode'] =$this->input->get_post('salesmode');
            $insertdata['salesdate'] = $this->input->get_post('salesdate');
            $insertdata['totalqty'] = $this->input->get_post('totalqty');
            $insertdata['totalamount'] = $this->input->get_post('totalamount');
            $insertdata['additionalcost'] = $this->input->get_post('additionalcost');
            $insertdata['taxamount'] = $this->input->get_post('taxamount');
            $insertdata['billdiscount'] = $this->input->get_post('billdiscount');
            $insertdata['grandtotal'] = $this->input->get_post('grandtotal');
            $insertdata['oldbalance'] = $this->input->get_post('oldbalance');
            $insertdata['cash'] = $this->input->get_post('cash');
            $insertdata['bank'] = $this->input->get_post('bank');
            $insertdata['paidcash'] = $this->input->get_post('paidcash');
            $insertdata['paidbank'] = $this->input->get_post('paidbank');
            $insertdata['balance'] = $this->input->get_post('balance');
            $insertdata['narration'] = $this->input->get_post('narration');
            $insertdata['branchid'] = $this->input->get_post('branchid');   
            $insertdata['salesman'] = $this->input->get_post('salesmancode');   
            $insertdata['stockamount'] = $this->input->get_post('stockamount'); 
            $insertdata['userid'] =$this->input->get_post('userid');
            $points= $this->input->get_post('redeemedpoints');
            $customerid = $this->input->get_post('customerid');
            $DATE=$this->input->get_post('salesdate');
            $sales = $this->input->get_post('totalamount');
            $dat1=$this->Salesmodel->update_Returnsalesinvoicemaster($insertdata,$id);
             $new=$this->Salesmodel->delete_salesinvoicedetails($id);
             
            if($points!=0)
            {
                $r=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
            }
            $addpoints =($sales*1/100);
            if($sales!=0)
            {
                $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
            }
            
            echo json_encode(array("message"=>$dat1),JSON_NUMERIC_CHECK);
        }


    public function returnInsert_salesinvoicedetails()
    {
        // $ans=false;
         $this->load->model('Salesmodel');
         $this->load->model('Onlinemodel');
        $id=$this->input->get_post('id');
        $insertdata['salesmasterid']=$id;
         $insertdata['invoiceno']=$this->input->get_post('invoiceno');
         $insertdata['salesdate']=$this->input->get_post('salesdate');
         $insertdata['productname']=$this->input->get_post('productname');
         $insertdata['productcode']=$this->input->get_post('productcode');
         $insertdata['qty']=$this->input->get_post('qty');
        //  $insertdata['hsncode']=$this->input->get_post('hsn');
         $insertdata['size']=$this->input->get_post('size');
         $insertdata['unitprice']=$this->input->get_post('mrp');
         $insertdata['netamount']=$this->input->get_post('netamount');
         $insertdata['tax']=$this->input->get_post('tax');
         $insertdata['taxamount']=$this->input->get_post('taxamount');
         $insertdata['amount']=$this->input->get_post('amount');
         $insertdata['branchid']=$this->input->get_post('branchid');
         $insertdata['batchid']=$this->input->get_post('batchid');
        
        
            $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata);
            if($ans)
            {
                // $branch=$this->input->get_post('branchid');
                // $batch=$this->input->get_post('batchid');
                // $product=$this->input->get_post('productcode');
                // $batch=$this->input->get_post('productcode');
                // $qty=$this->input->get_post('qty');
                // $size=$this->input->get_post('size');
                // $stck['productid']=$product;
                // $stck['currentstock']=$qty*-1;
                // $stck['branch']=$branch;
                // $stck['batchid']=$batch;
                // $stck['size']=$size;
                // $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
                // if($check==0)
                // {
                //     $stock1=$this->Onlinemodel->insertstock($stck);
                // }
                // else
                // {
                //     $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch);
                // }
                echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
            }
            else 
            {
                echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
            }
         
         
        //  $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
        // if($ans)
        // echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
        // else 
        // echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
        //  $branch=$this->input->post('branchid');
        //  $batch=$this->input->post('batchid');
        //  $product=$this->input->post('productcode');
        //  $qty=$this->input->post('qty');
        //  $stock=$this->Salesmodel->sales_stock($product,$qty,$branch,$batch);
        //  }
    }


    public function api_SalesReturn_AccountInsertion($status = true)
    {
        $this->load->model('Salesmodel');
        // $ans = file_get_contents('php://input');
        // $data = json_decode($ans);
        // $totalpur=$this->input->get_post('totalpurchaserate');
        $total = $this->input->get_post('totalamount');
        $stockamount=$this->input->get_post('stockamount');
        // $mrp = $this->input->get_post('totalmrp');
        $customer = $this->input->get_post('customerid');
        $balance = $this->input->get_post('balance');
        $discount = $this->input->get_post('billdiscount');
        $data['records']=$this->Onlinemodel->Select_customerledger($customer);
        $customer=$data['records']['customeraccount'];
        $data=array();
        $dat=$this->Salesmodel->api_salesaccount($stockamount,$total,$customer,$discount,$balance);
        // echo json_encode($data);
        // echo json_encode(array("message"=>$dat),JSON_NUMERIC_CHECK);
        echo $status ? json_encode(array("message"=>$dat),JSON_NUMERIC_CHECK):'';

        //sales account
    }



    public function SalesReturn_DayBookInsertion($status = true)
    {
        // $this->load->model('Salesmodel');
        // $ans = file_get_contents('php://input');
        // $data = json_decode($ans);
        $invoiceno = $this->input->get_post('invoiceno');
        $salesdate = $this->input->get_post('salesdate');
        // $tax=$this->input->get_post('tax');
        $total = $this->input->get_post('totalamount');
        // $paidcash = $this->input->get_post('paidcash');
        // $paidbank = $this->input->get_post('paidbank');
        $balance = $this->input->get_post('balance');
        $discount = $this->input->get_post('billdiscount');
        $customer = $this->input->get_post('customerid');
        // $cash = $this->input->get_post('cash');
        // $bank = $this->input->get_post('bank');
        // $stock = $this->input->get_post('stock');
        $grandtotal=$this->input->get_post('grandtotal');
        $stockamount=$this->input->get_post('stockamount');
        // $mrp = $this->input->get_post('totalmrp');
        $data2=array(); 
        // sales account
        $data2['invoiceno']=$invoiceno;
        $data2['accountType']='Sales Return';
        $data2['date']=$salesdate;
        $data2['ledgername']=21;
        $data2['debit']=$total;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=$stockamount;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=0;
        $data2['credit']=$stockamount;
        $data22=$this->Onlinemodel->insert_daybook($data2);

        //discount
        $data2['ledgername']=28;
        $data2['debit']=0;
        $data2['credit']=$discount;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        //customer
        $data['records']=$this->Onlinemodel->Select_customerledger($customer);
        $ledgername=$data['records']['customeraccount'];
        $data2['ledgername']=$ledgername;
        $data2['debit']=0;
        $data2['credit']=$balance;
        $data22=$this->Onlinemodel->insert_daybook($data2);
        
        if($data22==false)
        {
            ?><script type="text/javascript">
            alert('Failed Daybook insertion........');
            </script>
            <?php 
        }
        // echo json_encode($data22);
        // echo json_encode(array("message"=>$dat22),JSON_NUMERIC_CHECK);
        echo $status ? json_encode(array("message"=>$dat22),JSON_NUMERIC_CHECK):'';


        //Inserting into daybook_End
    }
    

    public function api_getsalesbyinvoiceno()
    { 
        $a=$this->input->get_post('voucher');
        $branch=$this->input->get_post('branch');
        $this->load->model('Onlinemodel');
        echo json_encode(array("master" => $this->Onlinemodel->getsalesmaster1($a,$branch)->result(),"detailes" => $this->Onlinemodel->getsalesdetailes($a,$branch)->result()),JSON_NUMERIC_CHECK);
    }
        

    public function api_getimagegrp()
    {
        $id = $this->input->get_post('id');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtimage" => $this->Onlinemodel->api_getimagegrp($id)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getsalesman()
    {
        $sales = $this->input->get_post('sales');
        $this->load->model('Onlinemodel');
        echo json_encode(array("salesman" => $this->Onlinemodel->api_getsalesman($sales)->result()),JSON_NUMERIC_CHECK);
    }

    public function getallsalesman()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("salesman" => $this->Onlinemodel->getsalesman()->result()),JSON_NUMERIC_CHECK);
    }

    public function getallshoporder()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        echo json_encode(array("allshoporder" => $this->Onlinemodel->api_getallshoporder($branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_shopOrderAdvance()
    {
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("shopOrderAdvance" => $this->Onlinemodel->api_shopOrderAdvance($fOnlyDate,$tOnlyDate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getshoporder()
    {
        $order = $this->input->get_post('order');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $ref = $this->Onlinemodel->api_getreference($order)->result();
        $ref2 = $this->Onlinemodel->api_getshoporder($order,$branchid)->result();
        echo json_encode(array("shoporder" =>$ref2, "reference" => $ref),JSON_NUMERIC_CHECK);
    }


    public function api_customerOutAmount()
    {
        $customerid = $this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("customerOutAmount" => $this->Onlinemodel->api_customerOutAmount($customerid)->result()),JSON_NUMERIC_CHECK);
    }
    
    public function api_shopOrderDetailsById()
    {
        $shoporderid = $this->input->get_post('shoporderid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("shopOrderDetailsById" => $this->Onlinemodel->api_shopOrderDetailsById($shoporderid)->result()),JSON_NUMERIC_CHECK); 
    }
    
    public function api_branchShopOrder()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("branchShopOrder" => $this->Onlinemodel->api_branchShopOrder($branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_btwncustomer()
    {
        $customerid = $this->input->get_post('customerid');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("btwncustomer" => $this->Onlinemodel->btwncustomer($customerid,$fOnlyDate,$tOnlyDate)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_btwnsupplier()
    {
        $supplierid = $this->input->get_post('supplierid');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("btwnsupplier" => $this->Onlinemodel->btwnsupplier($supplierid,$fOnlyDate,$tOnlyDate)->result()),JSON_NUMERIC_CHECK);
    }

    public function pos_receiptvoucher()
    {       
        $data=array();
        $data["voucherno"]=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();
        $data['customer']=$this->Onlinemodel->getcustomer();
        $data['getreceiptvoucher']=$this->Onlinemodel->getreceiptvoucher();
        $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
        $this->load->view('posheader');
        $this->load->view('ReceiptVoucher',$data);
        $this->load->view('footer');        
    }

    public function api_getlogin()
    {   
        // $ans = file_get_contents('php://input');
        // $data = json_decode($ans);
        // $username= $data->user;
        // $password = $data->pass;
        $username= $this->input->get_post('user');
        $password= $this->input->get_post('pass');
        $this->load->model('Onlinemodel');
        $login['log']=$this->Onlinemodel->CheckUser($username);
        if($login['log'])
        {
            foreach ($login['log']->result() as $key)
            {
                if(password_verify($password,$key->password))
                {
                    $data=$key;
                }
                else
                {
                    $data = array();
                    $data['status']='False';
                }
            }
        }
        else
        {
            $data=array();
            $data['status']='False';
        }
        echo json_encode($data,JSON_NUMERIC_CHECK);
    }

    public function api_getBranch()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("branch" => $this->Onlinemodel->getBranch()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getstockbysize()
    {
        $this->load->model('Onlinemodel');
        $code = $this->input->get_post('productcode');
        echo json_encode(array("stockbysize" => $this->Onlinemodel->api_getstockbysize($code)->result()),JSON_NUMERIC_CHECK);
    }
    
    public function api_salesmansum()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("salesmansum" => $this->Onlinemodel->api_salesmansum($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_pdtqty()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("productqty" => $this->Onlinemodel->api_pdtqty($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_pdtcategory()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("productcategory" => $this->Onlinemodel->api_pdtcategory($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_btwnsum()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("btwnsum" => $this->Onlinemodel->api_btwnsum($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_pdtqtycustomer()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $customerid = $this->input->get_post('customerid');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtqtycustomer" => $this->Onlinemodel->api_pdtqtycustomer($fdate,$tdate,$customerid,$branchid)->result()),JSON_NUMERIC_CHECK);
    }
    public function api_pdtqtysupplier()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtqtysupplier" => $this->Onlinemodel->api_pdtqtysupplier($fdate,$tdate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_supplierproduct()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtqtysupplier" => $this->Onlinemodel->api_supplierproduct($fdate,$tdate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_customercategory()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $customerid = $this->input->get_post('customerid');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("customercategory"=>$this->Onlinemodel->api_customercategory($fdate,$tdate,$customerid,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_suppliercategory()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("suppliercategory"=>$this->Onlinemodel->api_suppliercategory($fdate,$tdate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_supplierproductcategory()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("suppliercategory"=>$this->Onlinemodel->api_supplierproductcategory($fdate,$tdate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

   


    public function api_noofinvoice()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $customerid = $this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noofinvoice"=>$this->Onlinemodel->api_noofinvoice($fdate,$tdate,$customerid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_noofvoucher()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noofvoucher"=>$this->Onlinemodel->api_noofvoucher($fdate,$tdate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_noofreceipt()
    {
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $customerid = $this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noofreceipt"=>$this->Onlinemodel->api_noofreceipt($fOnlyDate,$tOnlyDate,$customerid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_noofpayment()
    {
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noofpayment"=>$this->Onlinemodel->api_noofpayment($fOnlyDate,$tOnlyDate,$supplierid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getqtysum()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $pdt = $this->input->get_post('pdt');
        $this->load->model('Onlinemodel');
        echo json_encode(array("getqtysum"=>$this->Onlinemodel->api_getqtysum($fdate,$tdate,$pdt)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getpurchasesum()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $pdt = $this->input->get_post('pdt');
        $this->load->model('Onlinemodel');
        echo json_encode(array("getpurchasesum"=>$this->Onlinemodel->api_getpurchasesum($fdate,$tdate,$pdt)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getpdtstock()
    {
        $pdt = $this->input->get_post('pdt');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtstock"=>$this->Onlinemodel->api_getpdtstock($pdt)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getcurrentstock()
    {
        $pdt = $this->input->get_post('pdt');
        $this->load->model('Onlinemodel');
        echo json_encode(array("currentstock"=>$this->Onlinemodel->api_getcurrentstock($pdt)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_imageupload()
    {
        ini_set('max_execution_time',0);
        $config['upload_path'] ='./shoporder/images/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = (1024*1024)*25;
        $imageName="";
        $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        //print_r($_FILES);
        //  $ans = file_get_contents('php://input');
        $get_data = $this->input->post('data');
        $data = json_decode($get_data);
        $stat = $this->Onlinemodel->api_checkshoporder($data->shoporderno);
        if($stat==0)
        {
            //  echo json_encode($data);
            if(isset($_FILES['image']))
            {
                if (!$this->upload->do_upload('image'))
                {
                    echo json_encode(array('message'=> $this->upload->display_errors('',''),"success"=>false));
                    // return;
                }
                else
                {
                    $uploadData = $this->upload->data();
                    $imageName .= $uploadData['file_name'];
                }
            }
            $insertData['shoporderno'] = $data->shoporderno;
            $insertData['date_delivery'] = $data->date_delivery ;
            $insertData['date_current']= $data->date_current;
            $insertData['salesmanid']= $data->salesmanid;
            $insertData['customerid']= $data->customerid;
            $insertData['pdt_desc'] = $data->pdt_desc;
            $insertData['qty'] = $data->qty;
            $insertData['imagepath'] = $data->imagepath;
            $insertData['narration'] = $data->narration;
            $insertData['amount'] = $data->amount;
            $insertData['branchid'] = $data->branchid;
            $insertData['userid'] = $data->userid;
            $insertData['advance'] = $data->advance;
            $insertData['balance'] = $data->balance;
            $addimage = $this->Onlinemodel->api_imageupload($insertData);
            echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
        }
        else
        {
            if(isset($_FILES['image']))
            {
                if (!$this->upload->do_upload('image'))
                {
                    echo json_encode(array('message'=> $this->upload->display_errors('',''),"success"=>false));
                    // return;
                }
                else
                {
                    $uploadData = $this->upload->data();
                    $imageName .= $uploadData['file_name'];
                }
            }
            $insertData['shoporderno'] = $data->shoporderno;
            $insertData['date_delivery'] = $data->date_delivery ;
            $insertData['date_current']= $data->date_current;
            $insertData['pdt_desc'] = $data->pdt_desc;
            $insertData['qty'] = $data->qty;
            $insertData['imagepath'] = $data->imagepath;
            $insertData['narration'] = $data->narration;
            $insertData['amount'] = $data->amount;
            $insertData['branchid'] = $data->branchid;
            $insertData['userid'] = $data->userid;
            $insertData['advance'] = $data->advance;
            $insertData['balance'] = $data->balance;
            $id=$data->shoporderno;
            $addimage = $this->Onlinemodel->api_updateimageupload($insertData,$id);
            echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
        }
    }
    
    
    
    public function api_audioupload()
    {
        // ini_set('max_execution_time',0);
        // $config['upload_path'] ='./shoporder/audio/';
        // $config['allowed_types'] = 'mp3|m4r|ogg';
        // $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        // $get_data = $this->input->get_post('data');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        // echo json_encode($data);
        // if(isset($_FILES['audio']))
        // {
        //     if (!$this->upload->do_upload('audio'))
        //     {
        //         echo json_encode(array('message'=> $this->upload->display_errors('',''),"success"=>false));
        //         // return;
        //     }
        //     else
        //     {
        //         $uploadData = $this->upload->data();
        //     }
        // }
        //  $insertData = array();
        // $addaudio=0;
        $pdt = $data->pdt_code;
        $myArray = explode(',',$pdt);
        $shopid = $data->fk_shoporderid;
        $status = $this->Onlinemodel->api_checkrefshoporder($shopid);
        if($status==0)
        {
            for($i=0;$i<count($myArray);$i++)
            {
                // echo json_encode(array("array"=>$myArray),JSON_NUMERIC_CHECK);
                $insertData['pdt_code'] = $myArray[$i];
                $insertData['fk_shoporderid'] = $shopid;
                $addaudio = $this->Onlinemodel->api_audioupload($insertData);
                echo json_encode(array("message"=>$addaudio),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            for($i=0;$i<count($myArray);$i++)
            {
                // echo json_encode(array("array"=>$myArray),JSON_NUMERIC_CHECK);
                $insertData['pdt_code'] = $myArray[$i];
                $insertData['fk_shoporderid'] = $shopid;
                $addaudio = $this->Onlinemodel->api_updateaudioupload($insertData,$shopid);
                echo json_encode(array("message"=>$addaudio),JSON_NUMERIC_CHECK);
            }
        }
    }

    //Actizo E commerce

    public function api_getproductgrp()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("group" => $this->Onlinemodel->api_getproductgrp()->result()),JSON_NUMERIC_CHECK);
    }

    public function insertOrderMaster()
    {
        $data=array();
        $data['customerid']=$this->input->get_post('customerid');
        $data['date']=$this->input->get_post('datetime');
        $data['readdata']=$this->input->get_post('readdata');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->insertOrderMaster($data);
        echo json_encode(array("OrderMaster" =>$ans),JSON_NUMERIC_CHECK);
    }

    public function insertOrderDetails()
    {
        $data=array();
        $data['masterid']=$this->input->get_post('masterid');
        $data['date']=$this->input->get_post('datetime');
        $data['productname']=$this->input->get_post('productname');
        $data['qty']=$this->input->get_post('qty');
        $data['size']=$this->input->get_post('size');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->insertOrderDetails($data);
        echo json_encode(array("OrderDetails" =>$ans),JSON_NUMERIC_CHECK);
    }

    // public function api_ecomCustomerLogin()
    // {
    //     $data=array();
    //     $user=$this->input->get_post('user');
    //     $pass=$this->input->get_post('pass');
    //     $this->load->model('Onlinemodel');
    //     echo json_encode(array("CustomerLogin"=>$this->Onlinemodel->api_ecomCustomerLogin($user,$pass)->result()),JSON_NUMERIC_CHECK);
    // }

    public function api_getProGrpBrand()
    {
        $grpid=$this->input->get_post('grpid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("proGrpBrand" => $this->Onlinemodel->api_getprogrpbrand($grpid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getProBrand()
    {
        $brandid=$this->input->get_post('brandid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getprobrand($brandid)->result()),JSON_NUMERIC_CHECK);
    }
    
    public function api_getProduct()
    {
       $this->load->model('Onlinemodel');
       echo json_encode(array("products" => $this->Onlinemodel->api_getproduct()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getsize()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("size" => $this->Onlinemodel->getsize()->result()),JSON_NUMERIC_CHECK);
        
    }

    public function api_getPendingOrder()
    {
        // $fdate = $this->input->get_post('fdate');
        // $tdate = $this->input->get_post('tdate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pendingOrders" => $this->Onlinemodel->api_getpendingorder()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getAllOrder()
    {
        $masterid = $this->input->get_post('masterid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("getAllOrder" => $this->Onlinemodel->api_getallorder($masterid)->result()),JSON_NUMERIC_CHECK);
    }


    public function api_updatePendingOrder()
    {
        $orderid = $this->input->get_post('orderid');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->api_updatependingorder($orderid);
        echo json_encode(array("updatedOrder" =>$ans),JSON_NUMERIC_CHECK);
    }
    public function api_getOrderCount()
    {
        // $fdate = $this->input->get_post('fdate');
        // $tdate = $this->input->get_post('tdate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("orderCount" => $this->Onlinemodel->api_getordercount()->result()),JSON_NUMERIC_CHECK);
    }

}
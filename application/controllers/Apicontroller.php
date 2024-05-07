<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Apicontroller extends CI_Controller {

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
    public function api_updateecomcost()
    {
        $this->load->model('Esalesmodel');
        $data=array();
      
        $data['productcost']=$this->input->get_post('productcost');
        $id=$this->input->get_post('detailsid');
        $orderno=$this->input->get_post('orderno');
        $oldstock=$this->input->get_post('oldstock');
        $newstock=$this->input->get_post('newstock');
        $update =$this->Esalesmodel->update_edetailstatus($data,$id);
        if($update)
        {
            $difference=$newstock-$oldstock;
            if($difference!=0)
            {
                $update =$this->Esalesmodel->update_eorderstock($difference,$orderno);
                $data2=array();
                $data2['invoiceno']=$orderno;
                $data2['accountType']='Ecommerce Sales Update';
                $data2['date']=date('Y-m-d H:i:s');
                $data2['userid']=$this->session->userdata('user');
                $data2['ledgername']=4;
                $data2['debit']=0;
                $data2['credit']=$difference;
                $data2['opposite']=22;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=22;
                $data2['debit']=$difference;
                $data2['credit']=0;
                $data2['opposite']=4;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
            }
        }
        echo json_encode($update);
    }
    
        public function api_updateproduction()
    {
    $data=array(

        'item_stitch'=>$this->input->get_post('stitch'),
        'item_dispatch'=>$this->input->get_post('dispatch'),
        'item_received'=>$this->input->get_post('received'),
        'item_delivery'=>$this->input->get_post('delivery'),
        'item_shipped'=>$this->input->get_post('shipped'),
        'status'=>$this->input->get_post('status'),

    );
    $a=$this->input->get_post('referenceno');
   
    $dat=$this->Onlinemodel->update_ecomfromproduction($a,$data);
    echo json_encode($dat);
    }
    public function api_ecomproductionreport()
    {  
        $this->load->model('Esalesmodel');
        $data=array();
        $cdate = date('Y-m-d');
         $currency=$this->input->get_post('currency');
       $result=$this->Esalesmodel->ecomproductionreporttoday($cdate, $currency);
        $fdate=$this->input->get_post('fdate');

        if($fdate==null)
        {
            $fdate=date('Y-m-01');
        }
        $tdate=$this->input->get_post('tdate');
        if($tdate==null)
        {
            $tdate=date('Y-m-t');
            $todate=$tdate;
        }
        else
        {
            $todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
            $todate=date_format($todate,"Y-m-d");
        }
        if(!empty($fdate) && !empty($tdate))
        {
            $result=$this->Esalesmodel->ecomproductionreport($fdate,$todate, $currency);
            $data['fdate'] =  $fdate;
            $data['tdate'] =  $tdate;
        }
        else
        {
            $result=$this->Esalesmodel->ecomproductionreporttoday($cdate, $currency);
        }
         echo json_encode(array("productionreport" =>$result->result()),JSON_NUMERIC_CHECK); 
       
     }
      public function api_ecomproductionpendingreport()
    {  
        $this->load->model('Esalesmodel');
        $data=array();
       
         $currency=$this->input->get_post('currency');
       $result=$this->Esalesmodel->ecomproductionpendingreport($currency);
        

      
                echo json_encode(array("productionpendingreport" =>$result->result()),JSON_NUMERIC_CHECK); 
       
     }
  public function api_ecomproductionpendingreportbystatus()
    {  
        $this->load->model('Esalesmodel');
        $data=array();
       
         $currency=$this->input->get_post('currency');
         $status=$this->input->get_post('status');
       $result=$this->Esalesmodel->ecomproductionpendingreportbystatus($currency,$status);
        

      
                echo json_encode(array("productionpendingreport" =>$result->result()),JSON_NUMERIC_CHECK); 
       
     }  
    
    // public function api_ecomproductionreportaed()
    // {
   
    //     $this->load->model('Esalesmodel');
    //     $data=array();
    //     $cdate = date('Y-m-d');
    //     $data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
    //     $fdate=$this->input->get_post('fdate');
    //     if($fdate==null)
    //     {
    //         $fdate=date('Y-m-01');
    //     }
    //     $tdate=$this->input->get_post('tdate');
    //     if($tdate==null)
    //     {
    //         $tdate=date('Y-m-t');
    //         $todate=$tdate;
    //     }
    //     else
    //     {
    //         $todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
    //         $todate=date_format($todate,"Y-m-d");
    //     }
    //     if(!empty($fdate) && !empty($tdate))
    //     {
    //         $data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,3);
    //         $data['fdate'] =  $fdate;
    //         $data['tdate'] =  $tdate;
    //     }
    //     else
    //     {
    //         $data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
    //     }
    //      echo json_encode(array("productionreportaed" =>$data),JSON_NUMERIC_CHECK); 
        
    // }
    // public function api_ecomproductionreportusd()
    // {

    //     $this->load->model('Esalesmodel');
    //     $data=array();
    //     $cdate = date('Y-m-d');
    //     $data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
    //     $fdate=$this->input->get_post('fdate');
    //     if($fdate==null)
    //     {
    //         $fdate=date('Y-m-01');
    //     }
    //     $tdate=$this->input->get_post('tdate');
    //     if($tdate==null)
    //     {
    //         $tdate=date('Y-m-t');
    //         $todate=$tdate;
    //     }
    //     else
    //     {
    //         $todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
    //         $todate=date_format($todate,"Y-m-d");
    //     }
    //     if(!empty($fdate) && !empty($tdate))
    //     {
    //         $data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,2);
    //         $data['fdate'] =  $fdate;
    //         $data['tdate'] =  $tdate;
    //     }
    //     else
    //     {
    //         $data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
    //     }
    //     echo json_encode(array("productionreportusd" =>$data),JSON_NUMERIC_CHECK); 
        
    // }
   public function sendmail(){
      $to = "danishktabbas@gmail.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: service@google.com" . "\r\n" .
"CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);
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
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("branchSaleProducts" => $this->Onlinemodel->api_pdtqty($fdate,$tdate,$branchid)->result(),"branchSaleProductCategory" => $this->Onlinemodel->api_pdtcategory($fdate,$tdate,$branchid)->result(),"branchSaleSalesman" => $this->Onlinemodel->api_salesmansum($fdate,$tdate,$branchid)->result(),"branchSaleSummary" => $this->Onlinemodel->api_btwnsum($fdate,$tdate,$branchid)->result(),"noOfShopOrder" => $this->Onlinemodel->api_noOfShopOrder($fOnlyDate,$tOnlyDate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }


    public function api_getAccountBalance()
    {
        $this->load->model('Onlinemodel');
        $tdate=$this->input->get_post('tdate');
        $fdate=$this->input->get_post('fdate');
        $branchid=$this->input->get_post('branchid');
        $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        $cash=$ans[0]->ledgerid;
        echo json_encode(array("accountBalance" => $this->Onlinemodel->api_ledgerbydesc($tdate,$fdate,$cash)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_getAccountBalance2()
    {
        $this->load->model('Onlinemodel');
        $tdate=$this->input->get_post('tdate');
        $fdate=$this->input->get_post('fdate');
        $branchid=$this->input->get_post('branchid');
        $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        $cash=$ans[0]->ledgerid;
        echo json_encode(array("accountBalanceFrom" => $this->Onlinemodel->api_ledgerfromdesc($fdate,$cash)->result(),"accountBalanceTo" => $this->Onlinemodel->api_ledgertodesc($tdate,$cash)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_insertPettyexpense()
    {
        $this->load->model('Onlinemodel');
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
       $narration=$this->input->get_post('narration');
        $amount=$this->input->get_post('amount');
        $branchid=$this->input->get_post('branchid');
        $userid=$this->input->get_post('userid');
        $ans=$this->Onlinemodel->api_FillCashLedgers($branchid)->result();
        $cash=$ans[0]->ledgerid;
        $ans2=$this->Onlinemodel->api_FillpettyLedgers($branchid)->result();
        $bank=$ans2[0]->ledgerid;
        $no=$this->Onlinemodel->Autogenerate_payVoucherNo()->result();
        $voucher=$no[0]->NO;
        $data=array();
        $data['date']=$date;
        $data['ledger']=$bank;
        $data['cashorbank']=$cash;
        $data['currentbalance']=$ans2[0]->currentbalance;
        $data['totalamount']=$amount;
        $data['voucherno']=$voucher;
        $data['userid']=$userid;
        $data['narration']=$narration;
        $existence=$this->Onlinemodel->checkexistence_payment($voucher);
        if($existence==0)
        {
            $result=$this->Onlinemodel->insert_paymentvoucher($data);
            if($result)
            {
				$data['records']=$this->Onlinemodel->Select_ledger($bank);
                $rootid=$data['records']['rootid'];
                $data2=array();
                $data2['invoiceno']=$voucher;
                $data2['accountType']='Payment Voucher';
                $data2['date']=date('Y-m-d H:i:s');
                $data2['userid']=$userid;
                $data2['ledgername']=$bank;
                $data2['debit']=$amount;
                $data2['credit']=0;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$bank;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
            }
            else
            {
                echo json_encode(array("insertPaymentVoucher" =>false),JSON_NUMERIC_CHECK); 
            }
        }
        else
        {
            echo json_encode(array("insertPaymentVoucher" =>false),JSON_NUMERIC_CHECK); 
        }
        echo json_encode(array("insertPaymentVoucher" =>true),JSON_NUMERIC_CHECK); 
    }
    

    public function api_insertPaymentVoucher()
    {
        $this->load->model('Onlinemodel');
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $amount=$this->input->get_post('amount');
        $branchid=$this->input->get_post('branchid');
        $userid=$this->input->get_post('userid');
        $ans=$this->Onlinemodel->api_FillCashLedgers($branchid)->result();
        $cash=$ans[0]->ledgerid;
        $ans2=$this->Onlinemodel->api_FillBankLedgers($branchid)->result();
        $bank=$ans2[0]->ledgerid;
        $no=$this->Onlinemodel->Autogenerate_payVoucherNo()->result();
        $voucher=$no[0]->NO;
        $data=array();
        $data['date']=$date;
        $data['ledger']=$bank;
        $data['cashorbank']=$cash;
        $data['currentbalance']=$ans2[0]->currentbalance;
        $data['totalamount']=$amount;
        $data['voucherno']=$voucher;
        $data['userid']=$userid;
        $data['narration']='Bank Transfer';
        $existence=$this->Onlinemodel->checkexistence_payment($voucher);
        if($existence==0)
        {
            $result=$this->Onlinemodel->insert_paymentvoucher($data);
            if($result)
            {
				$data['records']=$this->Onlinemodel->Select_ledger($bank);
                $rootid=$data['records']['rootid'];
                $data2=array();
                $data2['invoiceno']=$voucher;
                $data2['accountType']='Mobile Payment Voucher';
                $data2['date']=date('Y-m-d H:i:s');
                $data2['userid']=$userid;
                $data2['ledgername']=$bank;
                $data2['debit']=$amount;
                $data2['credit']=0;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$bank;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
            }
            else
            {
                echo json_encode(array("insertPaymentVoucher" =>false),JSON_NUMERIC_CHECK); 
            }
        }
        else
        {
            echo json_encode(array("insertPaymentVoucher" =>false),JSON_NUMERIC_CHECK); 
        }
        echo json_encode(array("insertPaymentVoucher" =>true),JSON_NUMERIC_CHECK); 
    }

    public function api_customerSaleDetails()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $customerid = $this->input->get_post('customerid');
        // $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("customerSaleSummary"=> $this->Onlinemodel->btwncustomer($customerid,$fOnlyDate,$tOnlyDate)->result(),"customerSaleNoOfReceipt"=>$this->Onlinemodel->api_noofreceipt($fOnlyDate,$tOnlyDate,$customerid)->result(),"customerSaleNoOfInvoice"=>$this->Onlinemodel->api_noofinvoice($fdate,$tdate,$customerid)->result(),"customerSaleProductCategory"=>$this->Onlinemodel->api_customercategory($fdate,$tdate,$customerid)->result(),"customerSaleProducts" => $this->Onlinemodel->api_pdtqtycustomer($fdate,$tdate,$customerid)->result(),"customerOutAmount" => $this->Onlinemodel->api_customerOutAmount($customerid)->result()),JSON_NUMERIC_CHECK);
        
    }
    
    public function api_getadminchat()
    {
        $userid =3;
        $this->load->model('Onlinemodel');
        echo json_encode(array("chats" => $this->Onlinemodel->api_getadminchat($userid)->result(),"error" =>false),JSON_NUMERIC_CHECK);
    }

    // updated 26-12-2020
    public function api_supplierPurchaseDetails()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $supplierid = $this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("supplierPurchaseProducts" => $this->Onlinemodel->api_supplierproduct($fdate,$tdate,$supplierid)->result(),"supplierPurchaseProductCategory"=>$this->Onlinemodel->api_supplierproductcategory($fdate,$tdate,$supplierid)->result(),"supplierPurchaseNoOfVoucher"=>$this->Onlinemodel->api_noofvoucher($fdate,$tdate,$supplierid)->result(),"supplierPurchaseNoOfPayment"=>$this->Onlinemodel->api_noofpayment($fOnlyDate,$tOnlyDate,$supplierid)->result(),"SupplierPurchaseDetails" => $this->Onlinemodel->btwnsupplier($supplierid,$fOnlyDate,$tOnlyDate)->result(),"supplierBalance" => $this->Onlinemodel->api_supplierBalance($fdate,$tdate,$supplierid)->result(),
        "supplierCurrentBalance" => $this->Onlinemodel->api_supplierCurrentBalance($supplierid)->result()),JSON_NUMERIC_CHECK); 
    }
    
    // updated 26-12-2020
    public function api_getProductSummary()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $pdt = $this->input->get_post('pdt');
        $sizeId = $this->input->get_post('sizeId');
        $this->load->model('Onlinemodel');
        echo json_encode(array("productSold"=>$this->Onlinemodel->api_getqtysum($fdate,$tdate,$pdt)->result(),"productPurchased"=>$this->Onlinemodel->api_getpurchasesum($fdate,$tdate,$pdt)->result(),"currentProductStock"=>$this->Onlinemodel->api_getcurrentstock($pdt)->result(),"productStockDetails"=>$this->Onlinemodel->api_getpdtstock($pdt,$sizeId)->result()),JSON_NUMERIC_CHECK); 
    }


    public function api_getimageandproduct()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" => $this->Onlinemodel->api_getproduct()->result(),"banner" => $this->Onlinemodel->api_getbannerimage()->result(),"slider"=> $this->Onlinemodel->api_getsliderimage()->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_getproduct()
    {
       $this->load->model('Onlinemodel');
       echo json_encode(array("products" => $this->Onlinemodel->api_getproduct()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getproductsbypageno()
    {
        $no=$this->input->get_post('pageNo');
        $count =$this->input->get_post('pageSize');
        $start=($no-1)*$count;
        $this->load->model('Onlinemodel');
        echo json_encode(array("products" =>array_slice( $this->Onlinemodel->api_getproduct()->result(),$start,$count)),JSON_NUMERIC_CHECK);
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
    

    public function api_getsize()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("size" => $this->Onlinemodel->getsize()->result()),JSON_NUMERIC_CHECK); 
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
        echo json_encode(array("branchbyid"=>$this->Onlinemodel->api_getbranchbyid($branchid)),JSON_NUMERIC_CHECK);
    }


    public function api_noOfShopOrder()
    {
        $branchid = $this->input->get_post('branchid');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("noOfShopOrder" => $this->Onlinemodel->api_noOfShopOrder($fOnlyDate,$tOnlyDate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getledger()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $data = $this->Onlinemodel->api_FillCashLedgers($branchid)->result();
        $datas = $this->Onlinemodel->api_FillBankLedgers($branchid)->result();
        echo json_encode(array("cash" =>$data,"bank"=>$datas),JSON_NUMERIC_CHECK);
        
    }

    public function api_getproductgrp()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("group" => $this->Onlinemodel->api_getproductgrp()->result()),JSON_NUMERIC_CHECK);
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
    public function api_getBankTransfer()
    {
        $this->load->model('Onlinemodel');
        $branchid=$this->input->get_post('branchid');
        $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        $cash=$ans[0]->ledgerid;
        $ans2=$this->Onlinemodel->api_FillBankLedgers2($branchid)->result();
        $bank=$ans2[0]->ledgerid;
        echo json_encode(array("getBankTransfer" => $this->Onlinemodel->api_getBankTransfer($tdate,$fdate,$cash,$bank)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_getCashExpense()
    {
        $this->load->model('Onlinemodel');
        $branchid=$this->input->get_post('branchid');
        $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        $cash=$ans[0]->ledgerid;
        echo json_encode(array("getCashExpense"=>$this->Onlinemodel->api_getCashExpense($tdate,$fdate,$cash)->result()),JSON_NUMERIC_CHECK); 
    }

    public function api_branchSaleAnalysis()
    {
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        $cash=$ans[0]->ledgerid;
        $ans2=$this->Onlinemodel->api_FillBankLedgers2($branchid)->result();
        $bank=$ans2[0]->ledgerid;
        echo json_encode(array("branchReturnTotal"=> $this->Onlinemodel->api_branchReturnTotal($fdate,$tdate,$branchid)->result(),"branchSaleProfit"=>$this->Onlinemodel->api_branchSaleProfit($fdate,$tdate,$branchid)->result(),"shopOrderAdvance" => $this->Onlinemodel->api_shopOrderAdvance($fOnlyDate,$tOnlyDate,$branchid)->result(),"accountBalance"=>$this->Onlinemodel->api_ledgerbydesc($tdate,$fdate,$cash)->result(),"accountBalanceFrom" => $this->Onlinemodel->api_ledgerfromdesc($fdate,$cash)->result(),"accountBalanceTo" => $this->Onlinemodel->api_ledgertodesc($tdate,$cash)->result(),"getBankTransfer"=>$this->Onlinemodel->api_getBankTransfer($tdate,$fdate,$cash,$bank)->result(),"getCashExpense"=>$this->Onlinemodel->api_getCashExpense($tdate,$fdate,$cash)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_SaleAnalysis()
    {
        $this->load->model('Onlinemodel');
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        // $ans=$this->Onlinemodel->api_FillCashLedgers2($branchid)->result();
        // $cash=$ans[0]->ledgerid;
        // $ans2=$this->Onlinemodel->api_FillBankLedgers2($branchid)->result();
        // $bank=$ans2[0]->ledgerid;
        echo json_encode(array("branchReturnTotal2"=> $this->Onlinemodel->api_branchReturnTotal2($fdate,$tdate)->result(),"branchSaleProfit2"=>$this->Onlinemodel->api_branchSaleProfit2($fdate,$tdate)->result(),"shopOrderAdvance2" => $this->Onlinemodel->api_shopOrderAdvance2($fOnlyDate,$tOnlyDate)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getProductBySort()
    {
        $this->load->model('Onlinemodel');
        $mode = $this->input->get_post('mode');
        $cat = $this->input->get_post('cat');
        if($mode=="LTH")
        {
            echo json_encode(array("products" => $this->Onlinemodel->api_getProductBySortAsc($cat)->result()),JSON_NUMERIC_CHECK);
        }
        else if($mode=="HTL")
        {
            echo json_encode(array("products"=> $this->Onlinemodel->api_getProductBySortDesc($cat)->result()),JSON_NUMERIC_CHECK);
        }
    }

    public function api_getProductByFilter()
    {
        $this->load->model('Onlinemodel');
        $min = $this->input->get_post('min');
        $max = $this->input->get_post('max');
        $cat = $this->input->get_post('cat');
        echo json_encode(array("products"=> $this->Onlinemodel->api_getProductByFilter($min,$max,$cat)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_InvoiceNo()
	{
        $this->load->model('Onlinemodel');
        $branchid = $this->input->get_post('branchid');
        $dataresult=$this->Onlinemodel->Autogenerate_InvoiceNo($branchid);
		if($dataresult->num_rows()>0){
          $data=  $dataresult->result()[0]->NO;
        }
        else{
            $data =1;
        }
		echo json_encode(array("data"=> $data),JSON_NUMERIC_CHECK);
    }
    

    public function Autogenerate_EcomorderNo()
	{
        include APPPATH.'third_party/razorpay/Razorpay.php';
        $this->load->model('Onlinemodel');
        $dataresult=$this->Onlinemodel->Autogenerate_EcomorderNo();
        $data=  $dataresult['orderno'];
        $masterid=  $dataresult['masterid'];
        $receiptno =$data;
        $amount =$this->input->get_post('amount');
        $currency =$this->input->get_post('currency');
        $api_secret ='yLbl8VfUFVtbE5SPrRv6XBPG';
        $api_key ='rzp_live_ulO8rWofM5cSZS';
        $api = new Razorpay\Api\Api($api_key, $api_secret);
        // Orders
        $order  = $api->order->create(array('receipt' =>$receiptno, 'amount' => $amount, 'currency' => $currency)); // Creates order
        $orderId = $order['id']; // Get the created Order ID
        $order  = $api->order->fetch($orderId);
        echo json_encode(array("ecomorderno"=> $data,"masterid"=>$masterid,"rzr_orderId"=>$order['id']),JSON_NUMERIC_CHECK);
    }

    public function Autogenerate_PromOrderNo()
	{
        // include APPPATH.'third_party/razorpay/Razorpay.php';
        $this->load->model('Onlinemodel');
        $dataresult=$this->Onlinemodel->Autogenerate_EcomorderNo();
        $data=  $dataresult['orderno'];
        $masterid=  $dataresult['masterid'];
        $receiptno =$data;
        $amount =$this->input->get_post('amount');
        $currency =$this->input->get_post('currency');
        // $api_secret ='yLbl8VfUFVtbE5SPrRv6XBPG';
        // $api_key ='rzp_live_ulO8rWofM5cSZS';
        // $api = new Razorpay\Api\Api($api_key, $api_secret);
        // Orders
        // $order  = $api->order->create(array('receipt' =>$receiptno, 'amount' => $amount, 'currency' => $currency)); // Creates order
        // $orderId = $order['id']; // Get the created Order ID
        // $order  = $api->order->fetch($orderId);
        echo json_encode(array("ecomorderno"=> $data,"masterid"=>$masterid),JSON_NUMERIC_CHECK);
    }
    
 public function delete_ecomorder()
	{
        $this->load->model('Salesmodel');
        $id = $this->input->get_post('masterid');
		$data=$this->Onlinemodel->delete_ecomorder($id);
		echo json_encode(array("status"=> $data),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_ShopOrder()
	{
        $this->load->model('Salesmodel');
        $branchid = $this->input->get_post('branchid');
		$data=$this->Salesmodel->Autogenerate_ShopOrderNo($branchid)->result()[0]->NO;
		$branchcode=$this->Salesmodel->Autogenerate_ShopOrder($branchid)->result()[0]->branchcode;
		echo json_encode(array("data"=> $data,"branchcode"=>$branchcode),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_OnlineOrder()
	{
        $this->load->model('Salesmodel');
        $branchid = $this->input->get_post('branchid');
		$data=$this->Salesmodel->Autogenerate_OnlineOrderNo($branchid)->result()[0]->NO;
		$branchonlinecode=$this->Salesmodel->Autogenerate_OnlineOrder($branchid)->result()[0]->branchonlinecode;
		echo json_encode(array("data"=> $data,"branchonlinecode"=>$branchonlinecode),JSON_NUMERIC_CHECK);
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

    public function api_getpdtbycode()
    {
        $code = $this->input->get_post('code');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtbycode" => $this->Onlinemodel->Autofill_Productdetails($code)->result()),JSON_NUMERIC_CHECK);

    }

    public function Api_customer_check()
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
            $insertdata2['rootid']='1';
            $insertdata2['branchid']=$branchid;
            $insertdata2['currentbalance']=$openingbalance;
            $result=$this->Onlinemodel->insert_accountledger($insertdata2);
            $insertdata['customeraccount']=$result;
            if($result=true)
            {
                $ledgervalues=$this->Onlinemodel->api_insert_customer($insertdata);
                //echo 'ledgersuccess';
                // echo json_encode (array("message"=>$ledgervalues),JSON_NUMERIC_CHECK);

                echo json_encode (array("cust_id"=>$ledgervalues,"cust_accnt"=>$result,"status"=>'insert'),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            $res=$this->Onlinemodel->api_getcustomerbycode($code,$pho)->result();
            $custid=$res[0]->customerid;
            $custacct=$res[0]->customeraccount;
            echo json_encode (array("cust_id"=>$custid,"cust_accnt"=>$custacct,"status"=>'already'),JSON_NUMERIC_CHECK);

        }
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
            $insertdata2['rootid']='1';
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
            $res=$this->Onlinemodel->api_getcustomerbycode($code,$pho)->result();
            $custid=$res[0]->customerid;
            echo json_encode (array("message"=>$custid),JSON_NUMERIC_CHECK);
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
        // $insertdata['openingbalance']=$data->openingbalance;
        $insertdata['points']=$data->points;
        // $openingbalance=$data->openingbalance;
        $existence=$this->Onlinemodel->checkexistence_customer($oldcode,$oldphone);
        if($existence!=0)
        {
            $account=$data->account;
            //Ledger Updation_start
            // $ans=array();
            // $ans=$this->Onlinemodel->api_getledger($account)->result();
            $insertdata2['ledgername']=$pho;
            $insertdata2['accountgroup']='17';
            $insertdata2['interestcalculation']=0;
            // $insertdata2['openingbalance']=$openingbalance;
            $insertdata2['creditordebit']='Dr';
            $insertdata2['narration']='Autogenerated for Customer';
            $insertdata2['branchid']=$branchid;
            // $insertdata2['currentbalance']=$openingbalance;
            $result=$this->Onlinemodel->api_update_accountledger($account,$insertdata2);
            if($result=true)
            {
                $ledgervalues=$this->Onlinemodel->api_update_customer($insertdata,$oldcode);
                if($ledgervalues)
                {
                	$res=$this->Onlinemodel->api_getcustomerbycode($oldcode,$oldphone)->result();
            		$custid=$res[0]->customerid;
            		echo json_encode (array("message"=>$custid),JSON_NUMERIC_CHECK);
                }
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

    public function api_getsalesbetweendate()
    {
        $fdate = $this->input->get_post('fdate');
        $tdate = $this->input->get_post('tdate');
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("SalesBetweenDate" => $this->Onlinemodel->api_getsalesbetweendate($fdate,$tdate,$branchid)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getsaleswithcustomer()
    {
        $customerid=$this->input->get_post('customerid');
        $branchid=$this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("salesWithCustomer" => $this->Onlinemodel->api_getsaleswithcustomer($customerid,$branchid)->result()),JSON_NUMERIC_CHECK);
    }


    public function Api_insertEcommerceOrderMaster()
    {
        $ship=array(); 
        $data=array();
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $id=$this->input->get_post('masterid');
        $balance=$this->input->post('balance')*-1;
		$grandtotal=$this->input->post('grandtotal')*1;
		if($balance==0)
		{
			$status='Bank Payment';
		}	
		else if($balance==$grandtotal)
		{
			$status='Not Paid';
		}
		else if ($balance<$grandtotal) 
		{
			$status='Partially Paid';
		}
        $data['payment_mode']=$this->input->get_post('payment_mode');
        $data['eCommerce_no']=$this->input->get_post('eCommerce_no');
        $data['rzp_orderId']=$this->input->get_post('rzp_orderId');
        $data['salesman']=$this->input->get_post('salesman');
        $data['customerid']=$this->input->get_post('customerid');
        $data['date_delivery']=$this->input->get_post('date_delivery');
        $data['date_current']=$date;
        $data['narration']=$this->input->get_post('narration');
        $data['totalqty']=$this->input->get_post('totalqty');
        $data['totalamount']=$this->input->get_post('totalamount');
        $data['taxamount']=$this->input->get_post('taxamount');
        $data['additionalcost']=$this->input->get_post('additionalcost');
        $data['billdiscount']=$this->input->get_post('billdiscount');
        $data['grandtotal']=$grandtotal;
        $data['oldbalance']=$this->input->get_post('oldbalance');
        $data['cash']='1399';
        $data['bank']='1400';
        $branchid='18';
        // $data['pdt_desc']=$this->input->get_post('pdt_desc');
        // $data['image_path']=$this->input->get_post('image_path');
        $data['cash_payment']=$this->input->get_post('cash_payment');
        $data['bank_payment']=$this->input->get_post('bank_payment');
        $data['balance']=$balance;
        $data['userid']='51';
        $data['branchid']=$branchid;
        $data['stockamount']=$this->input->get_post('stockamount');
        $data['status']='Not Paid';
        $ship['fullname']=$this->input->get_post('fullname');
        $ship['mobileNo']=$this->input->get_post('mobileNo');
        $ship['postalCode']=$this->input->get_post('postalCode');
        $ship['floor']=$this->input->get_post('floor');
        $ship['street']=$this->input->get_post('street');
        $ship['landmark']=$this->input->get_post('landmark');
        $ship['city']=$this->input->get_post('city');
        $ship['state']=$this->input->get_post('state');
        $ship['country']=$this->input->get_post('country');
        $ship['customerid']=$this->input->get_post('customerid');
        $ship['ecommerce_orderid']=$id;
        $data['shipping_address']=$this->Onlinemodel->insertshippingaddress($ship);
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->insertEorderMaster($data,$id);
        $this->api_ecomOrder_DayBookInsertion(false);
        echo json_encode(array("eOrderMaster" =>$ans),JSON_NUMERIC_CHECK);
    }

    


    public function Api_insertEcommerceOrderDetails()
    {
        $data=array();
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $productcode=$this->input->get_post('productcode');
        $batchid=$this->input->get_post('batchid');
        $branchid='18';
        $qty=$this->input->get_post('qty');
        $size=$this->input->get_post('size');
        $data['eordermasterid']=$this->input->get_post('eordermasterid');
        $data['eCommerce_no']=$this->input->get_post('eCommerce_no');
        $data['referenceno']=$this->input->get_post('referenceno');
        $data['vouchercode']=$this->input->get_post('vouchercode');
        $data['rewardspoint']=$this->input->get_post('rewardspoint');
        $data['shippingaddress']=$this->input->get_post('shippingaddress');
        $data['orderdate']=$this->input->get_post('orderdate');
        $data['productname']=$this->input->get_post('productname');
        $data['productcode']=$productcode;
        $data['hsncode']=$this->input->get_post('hsncode');
        $data['qty']=$qty;
        $data['size']=$size;
        $data['status']='Processing';
        $data['unitprice']=$this->input->get_post('unitprice');
        $data['netamount']=$this->input->get_post('netamount');
        $data['tax']=$this->input->get_post('tax');
        $data['taxamount']=$this->input->get_post('taxamount');
        $data['amount']=$this->input->get_post('amount');
        $data['productcost']=$this->input->get_post('productcost');
        $data['branchid']=$branchid;
        $data['batchid']=$batchid;
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->api_insertEcomDetails($data);
        $voucherno=$data['eCommerce_no'];
   	 	$transactiontype='Ecommerce Order';
    	$userid='51'; 
        $stck=array();
        $stck['productid']=$productcode;
        $stck['currentstock']=$qty*-1;
        $stck['branch']=$branchid;
        $stck['batchid']=$batchid;
        $stck['size']=$size;
        $check=$this->Salesmodel->checkproduct($productcode,$branchid,$batchid,$size);
        if($check==0)
        {
            $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
        }
        else
        {
            $stock=$this->Onlinemodel->updatestock($productcode,$size,$qty,$branchid,$batchid,$voucherno,$transactiontype,$date,$userid);
        }
        echo json_encode(array("eOrderDetails" =>$ans),JSON_NUMERIC_CHECK);
    }

    

    public function api_ecomOrder_DayBookInsertion($status = true)
	{
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $this->load->model('Salesmodel');
        $cash_payment=$this->input->get_post('cash_payment');
        $bank_payment=$this->input->get_post('bank_payment');
        $eCommerce_no=$this->input->get_post('eCommerce_no');
        $total=$this->input->get_post('totalamount');
        $discount=$this->input->get_post('billdiscount');
        $grand=$this->input->post('grandtotal')*1;
		$tax=$this->input->get_post('tax');
        $customer = $this->input->get_post('customerid');
        $balance = $this->input->get_post('balance');
        // $DATE=strtotime("now");$e=strtotime("-7 hours +6 minutes",$d);
        $cash = '1399';
        $bank = '1400';
        $stock=$this->input->get_post('stockamount');
        $sales=$grand-$tax+$discount;
         $balance=($this->input->get_post('cash_payment')+$this->input->get_post('bank_payment'))-$this->input->get_post('grandtotal');
                if($balance>0){
                   $cash_payment = $this->input->get_post('cash_payment')-$balance;
                     $balance=0;
                }
                
        // log_message('error',$grand."-".$tax."-".$discount);
        $data2=array();	
        //sales account
        $data2['invoiceno']=$eCommerce_no;
        $data2['accountType']='Ecom Sales';
        $data2['date']=$date;
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data2['opposite']=$customer;
        $data2['userid']='51';
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=0;
        $data2['credit']=$stock;
        $data2['opposite']=21;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cash account
        $data2['ledgername']=$cash;
        $data2['debit']=$cash_payment;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //bank account
        $data2['ledgername']=$bank;
        $data2['debit']=$bank_payment;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=$stock;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //discount of sales
        if($discount>0)
        {
            $data2['ledgername']=28;
            $data2['debit']=$discount;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //customer
        if($balance<0)
        {
            $data['records']=$this->Onlinemodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=$abs;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //tax
        if($tax>0)
        {
            $data2['ledgername']=23;
            $data2['debit']=$tax;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
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

    ///////////////// ECOMMERCE ORDER FOR POS ////////////////////////////////

    public function Api_posInsertEcommerceOrderMaster()
    {
        $ship=array(); 
        $data=array();
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $id=$this->input->get_post('masterid');
        $data['payment_mode']=$this->input->get_post('payment_mode');
        $data['eCommerce_no']=$this->input->get_post('eCommerce_no');
        $data['rzp_orderId']=$this->input->get_post('rzp_orderId');
        $data['salesman']=$this->input->get_post('salesman');
        $data['customerid']=$this->input->get_post('customerid');
        $data['date_delivery']=$this->input->get_post('date_delivery');
        $data['date_current']=$date;
        $data['narration']=$this->input->get_post('narration');
        $data['totalqty']=$this->input->get_post('totalqty');
        $data['totalamount']=$this->input->get_post('totalamount');
        $data['taxamount']=$this->input->get_post('taxamount');
        $data['additionalcost']=$this->input->get_post('additionalcost');
        $data['billdiscount']=$this->input->get_post('billdiscount');
        $data['grandtotal']=$this->input->get_post('grandtotal');
        $data['oldbalance']=$this->input->get_post('oldbalance');
        $data['cash']=$this->input->get_post('cash');
        $data['bank']=$this->input->get_post('bank');
        $data['cash_payment']=$this->input->get_post('cash_payment');
        $data['bank_payment']=$this->input->get_post('bank_payment');
        $data['balance']=$this->input->get_post('balance');
        $data['userid']=$this->input->get_post('userid');
        $data['branchid']=$this->input->get_post('branchid');
        $data['stockamount']=$this->input->get_post('stockamount');
        $data['status']=$this->input->get_post('status');
        $ship['fullname']=$this->input->get_post('fullname');
        $ship['mobileNo']=$this->input->get_post('mobileNo');
        $ship['postalCode']=$this->input->get_post('postalCode');
        $ship['floor']=$this->input->get_post('floor');
        $ship['street']=$this->input->get_post('street');
        $ship['landmark']=$this->input->get_post('landmark');
        $ship['city']=$this->input->get_post('city');
        $ship['state']=$this->input->get_post('state');
        $ship['country']=$this->input->get_post('country');
        $ship['customerid']=$this->input->get_post('customerid');
        $ship['ecommerce_orderid']=$id;
        $data['shipping_address']=$this->Onlinemodel->insertshippingaddress($ship);
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->insertEorderMaster($data,$id);
        $this->api_posEcomOrder_DayBookInsertion(false);
        echo json_encode(array("eOrderMaster" =>$ans),JSON_NUMERIC_CHECK);
    }

    


    public function Api_posInsertEcommerceOrderDetails()
    {
        $data=array();
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $productcode=$this->input->get_post('productcode');
        $batchid=$this->input->get_post('batchid');
        $branchid='18';
        $qty=$this->input->get_post('qty');
        $size=$this->input->get_post('size');
        $data['eordermasterid']=$this->input->get_post('eordermasterid');
        $data['eCommerce_no']=$this->input->get_post('eCommerce_no');
        $data['vouchercode']=$this->input->get_post('vouchercode');
        $data['rewardspoint']=$this->input->get_post('rewardspoint');
        $data['shippingaddress']=$this->input->get_post('shippingaddress');
        $data['orderdate']=$this->input->get_post('orderdate');
        $data['productname']=$this->input->get_post('productname');
        $data['productcode']=$productcode;
        $data['hsncode']=$this->input->get_post('hsncode');
        $data['qty']=$qty;
        $data['size']=$size;
        $data['unitprice']=$this->input->get_post('unitprice');
        $data['netamount']=$this->input->get_post('netamount');
        $data['tax']=$this->input->get_post('tax');
        $data['taxamount']=$this->input->get_post('taxamount');
        $data['amount']=$this->input->get_post('amount');
        $data['productcost']=$this->input->get_post('productcost');
        $data['branchid']=$branchid;
        $data['batchid']=$batchid;
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->api_insertEcomDetails($data);
        $voucherno=$data['eCommerce_no'];
   	 	$transactiontype='Ecommerce Order';
    	$userid='51'; 
        $stck=array();
        $stck['productid']=$productcode;
        $stck['currentstock']=$qty*-1;
        $stck['branch']=$branchid;
        $stck['batchid']=$batchid;
        $stck['size']=$size;
        $check=$this->Salesmodel->checkproduct($productcode,$branchid,$batchid,$size);
        if($check==0)
        {
            $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
        }
        else
        {
            $stock=$this->Onlinemodel->updatestock($productcode,$size,$qty,$branchid,$batchid,$voucherno,$transactiontype,$date,$userid);
        }
        echo json_encode(array("eOrderDetails" =>$ans),JSON_NUMERIC_CHECK);
    }

    

    public function api_posEcomOrder_DayBookInsertion($status = true)
	{
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $this->load->model('Salesmodel');
        $cash_payment=($this->input->get_post('cash_payment'))*1;
        $bank_payment=($this->input->get_post('bank_payment'))*1;
        $eCommerce_no=$this->input->get_post('eCommerce_no');
        $total=$this->input->get_post('totalamount');
        $discount=$this->input->get_post('billdiscount')*1;
        $grand=$this->input->post('grandtotal')*1;
		$tax=$this->input->get_post('tax')*1;
        $customer = $this->input->get_post('customerid');
        $balance = $this->input->get_post('balance');
        // $DATE=strtotime("now");$e=strtotime("-7 hours +6 minutes",$d);
        $cash = '1399';
        $bank = '1400';
        $stock=$this->input->get_post('stockamount');
        $sales=$grand-$tax+$discount;
         $balance=($cash_payment+$bank_payment)-$grand;
                if($balance>0){
                   $cash_payment = $cash_payment-$balance;
                     $balance=0;
                }
                
        // log_message('error',$grand."-".$tax."-".$discount);
        $data2=array();	
        //sales account
        $data2['invoiceno']=$eCommerce_no;
        $data2['accountType']='Ecom Sales';
        $data2['date']=$date;
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data2['opposite']=$customer;
        $data2['userid']='51';
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=0;
        $data2['credit']=$stock;
        $data2['opposite']=21;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cash account
        $data2['ledgername']=$cash;
        $data2['debit']=$cash_payment;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //bank account
        $data2['ledgername']=$bank;
        $data2['debit']=$bank_payment;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=$stock;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //discount of sales
        if($discount>0)
        {
            $data2['ledgername']=28;
            $data2['debit']=$discount;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //customer
        if($balance<0)
        {
            $data['records']=$this->Onlinemodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=$abs;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //tax
        if($tax>0)
        {
            $data2['ledgername']=23;
            $data2['debit']=$tax;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
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


    ///////////////// ECOMMERCE ORDER FOR POS FINISH ////////////////////////////////
    
    //Created at 16-10-2020
    //To update ecommerce master of a order paid by razor pay
    public function Api_updateECommerceOrderMaster()
    {
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $this->load->model('Onlinemodel');
        $masterid=$this->input->get_post('masterid');
        $payment_mode=$this->input->get_post('payment_mode');
        $rzp_orderId=$this->input->get_post('rzp_orderId');
        $date_current=$date;
        $bank_payment=$this->input->get_post('bank_payment');
        $balance=$this->input->get_post('balance');
        $status=$this->input->get_post('status');
        $customerid=$this->input->get_post('customerid');
        // to get ledger of customer
        $customerAccount=$this->Onlinemodel->getCustomerLedgerAccount($customerid);
        $ledgerId=$customerAccount[0]['customeraccount'];
        $data=array();
        $data['invoiceno']=$this->input->get_post('eCommerce_no');
        $data['ledgername']=$ledgerId;
        $data['accountType']='e-Order Payment'; 
        $data['date']=$date;
        $data['debit']='0';
        $data['credit']=$bank_payment;
        $data['userid']='51';
        $data['opposite']='1400';
        // customer ledger
        $val=$this->Onlinemodel->insert_newdaybook($data);
        $data['debit']=$bank_payment;
        $data['credit']='0';
        $data['opposite']=$ledgerId;
        // Moa bank account ledger
        $val=$this->Onlinemodel->insert_newdaybook($data);
        $orderStatus=$this->Onlinemodel->updateEcommerceOrderMaster($masterid,$balance,$bank_payment,$payment_mode,$rzp_orderId,$status,$date_current);
        echo json_encode(array("updateOrderStatus" =>$orderStatus),JSON_NUMERIC_CHECK);
    }
    
    // Created at 14-10-2020
    // to generate rzp Order id
    public function Generate_rzpOrderId()
	{
        include APPPATH.'third_party/razorpay/Razorpay.php';
        $receiptno =$this->input->get_post('eCommerce_no');
        $amount =$this->input->get_post('amount');
        $currency =$this->input->get_post('currency');
        $api_secret ='yLbl8VfUFVtbE5SPrRv6XBPG';
        $api_key ='rzp_live_ulO8rWofM5cSZS';
        $api = new Razorpay\Api\Api($api_key, $api_secret);
        // Orders
        $order  = $api->order->create(array('receipt' =>$receiptno, 'amount' => $amount, 'currency' => $currency)); // Creates order
        $orderId = $order['id']; // Get the created Order ID
        $order  = $api->order->fetch($orderId);
        echo json_encode(array("rzr_orderId"=>$order['id']),JSON_NUMERIC_CHECK);
    }

    // created at 02-10-2020
    // to get customer un-paid orders by customer_id
    public function api_customerUnpaidOrders()
    {
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        $master=$this->Onlinemodel->api_customerUnpaidOrders($customerid);
        $no=count($master);
        for($x = 0; $x < $no; $x++) {
            $masterid=$master[$x]['eCommerce_id'];
            $detail=$this->Onlinemodel->api_customerOrderDetails($masterid);
            $master[$x]['OrderDetailsModel']=$detail;
        }
        echo json_encode(array("OrderMasterModel"=>$master),JSON_NUMERIC_CHECK);
    }

    // created at 02-10-2020
    // to get customer Proceessing orders by customer_id
    public function api_customerProceessingOrders()
    {
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        $master=$this->Onlinemodel->api_customerProcessingOrders($customerid);
        $no=count($master);
        for($x = 0; $x < $no; $x++) {
            $masterid=$master[$x]['eCommerce_id'];
            $detail=$this->Onlinemodel->api_customerOrderDetails($masterid);
            $master[$x]['OrderDetailsModel']=$detail;
        }
        echo json_encode(array("OrderMasterModel"=>$master),JSON_NUMERIC_CHECK);
    }

    // created at 02-10-2020
    // to get customer shipped orders by customer_id
    public function api_customerShippedOrders()
    {
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        $master=$this->Onlinemodel->api_customerShippedOrders($customerid);
        $no=count($master);
        for($x=0 ; $x<$no ;$x++){
            $masterid=$master[$x]['eCommerce_id'];
            $detail=$this->Onlinemodel->api_customerOrderDetails($masterid);
            $master[$x]['OrderDetailsModel']=$detail;
        }
        echo json_encode(array("OrderMasterModel"=>$master),JSON_NUMERIC_CHECK);
    }

    // created at 10-10-2020
    // to get customer All orders by customer_id
    public function api_customerAllOrders()
    {
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        $master=$this->Onlinemodel->api_customerAllOrders($customerid);
        $no=count($master);
        for($x = 0; $x < $no; $x++) {
            $masterid=$master[$x]['eCommerce_id'];
            $detail=$this->Onlinemodel->api_customerOrderDetails($masterid);
            $master[$x]['OrderDetailsModel']=$detail;
        }
        echo json_encode(array("OrderMasterModel"=>$master),JSON_NUMERIC_CHECK);
    }

    // created at 10-10-2020
    // to get customer Delivered orders by customer_id
    public function api_customerDeliveredOrders()
    {
        $customerid=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        $master=$this->Onlinemodel->api_customerDeliveredOrders($customerid);
        $no=count($master);
        for($x = 0; $x < $no; $x++) {
            $masterid=$master[$x]['eCommerce_id'];
            $detail=$this->Onlinemodel->api_customerOrderDetails($masterid);
            $master[$x]['OrderDetailsModel']=$detail;
        }
        echo json_encode(array("OrderMasterModel"=>$master),JSON_NUMERIC_CHECK);
    }
    
    // public function api_unPaidOrders()
    // {
    //     $customer=$this->input->get_post('customerid');
    //     $this->load->model('Onlinemodel');
    //     $data=$this->Onlinemodel->api_unPaidOrders($customer);
    //     foreach($data->result() as $key)
    //     {

    //     }
    //     echo json_encode(array("Orders" => ),JSON_NUMERIC_CHECK);
    // }      

    public function api_processingOrders()
    {
        $customer=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("Orders" => $this->Onlinemodel->api_processingOrders($customer)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_shippedOrders()
    {
        $customer=$this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("Orders" => $this->Onlinemodel->api_shippedOrders($customer)->result()),JSON_NUMERIC_CHECK);
    }


    public function deleteShoporder()
    {
        $orderid=$this->input->get_post('orderid');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->deleteShoporder($orderid);
        echo json_encode(array("Success" => $ans),JSON_NUMERIC_CHECK);
    }

    // updated at 29-12-2020
    public function Api_customerOnlineRegister()
    {
        $this->load->model('Onlinemodel');
        $data=array();
        $pho= $this->input->get_post('Phone');
        $name= $this->input->get_post('Name');
        // $data['user'] = $this->input->get_post('user');
        $data['customername'] = $name;
        $data['customercode'] = $pho;
        $pass = $this->input->get_post('Password');
        $data['pass']= password_hash($pass,PASSWORD_DEFAULT);
        $data['phonenumber'] = $pho;
        $data['email'] = $this->input->get_post('Mail');
        $data['branchid'] = '18';

        //Ledger Insertion_start
        $insertdata2['ledgername']=$pho;
        $insertdata2['accountgroup']='17';
        $insertdata2['interestcalculation']=0;
        $insertdata2['openingbalance']=0;
        $insertdata2['creditordebit']='Dr';
        $insertdata2['narration']='Autogenerated for Ecommerce Customer';
        $insertdata2['branchid']='18';
         $insertdata2['rootid']='1';
        $insertdata2['currentbalance']=0;
        $result=$this->Onlinemodel->insert_accountledger($insertdata2);
        $data['customeraccount']=$result;
        if($result=true)
        {
            $ledgervalues=$this->Onlinemodel->api_insert_customer($data);
            //echo 'ledgersuccess';
            echo json_encode (array("customerId"=>$ledgervalues),JSON_NUMERIC_CHECK);
        }
    }

    public function api_customerUpdatePass()
    {
        $this->load->model('Onlinemodel');
        $data=array();
        $customerid= $this->input->get_post('customerid');
        $password= $this->input->get_post('password');
        $hashpassword= password_hash($password,PASSWORD_DEFAULT);
        $result=$this->Onlinemodel->api_customerUpdatePass($customerid,$hashpassword);
        echo json_encode (array("customerUpdatePass"=>$result),JSON_NUMERIC_CHECK);
    }

    public function Api_isCustomerExist()
    {
        $customer=array();
        $this->load->model('Onlinemodel');
        $pho= $this->input->get_post('Phone');
        $mail= $this->input->get_post('Mail');
        $existence=$this->Onlinemodel->checkexistence_ecomusser($pho,$mail);
        if($existence->num_rows()==0)
        {
            $status=false;
            $customer=null;
        }
        else
        {
            $status=true;
            $customer=null;
            foreach ($existence->result() as $key)
            {
                $customer=$key;
            }
            
        }
        $json_array=array("status"=>$status,"customerDetails"=>$customer);
        echo json_encode($json_array);
    }

    public function Api_customerOnlineLogin()
    {
        $data=array();
        $user=$this->input->get_post('MailOrPhone');
        $pass=$this->input->get_post('Password');
        $this->load->model('Onlinemodel');
        $login=$this->Onlinemodel->Api_customerOnlineLogin($user,$pass);
		if($login)
		{
            foreach ($login->result() as $key)
            {
                if(password_verify($pass,$key->pass))
				{
                    $status=true;
                    $data=$key;
                }
                else
                {
                    $status=false;
                    $data = null;
                }
            }
        }
        else
        {
            $status=false;
            $data = null;
        }
        $json_array=array("status"=>$status,"customerDetails"=>$data);
        echo json_encode($json_array);
    }

    
    public function api_ecomUserLogin()
     {
        $user = $this->input->get_post('user');
        $pass = $this->input->get_post('pass');
        $this->load->model('Onlinemodel');
        echo json_encode(array("ecomUserAdd" => $this->Onlinemodel->api_ecomUserLogin($user,$pass)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_customerwithledger()
     {
        $this->load->model('Onlinemodel');
        echo json_encode(array("customerwithledger" => $this->Onlinemodel->api_customerwithledger()->result()),JSON_NUMERIC_CHECK);
     }

    public function api_getProductsByReceipt()
     {
        $masterid = $this->input->get_post('masterid');
        // $customerid = $this->input->get_post('customerid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("ProductsByReceipt" => $this->Onlinemodel->api_salesdetailsbymaster($masterid)->result()),JSON_NUMERIC_CHECK);
        // "CustomerById"=>$this->Onlinemodel->api_getcustomerbyid($customerid)->result()
    }

    public function updateVoucher()
    {
        $voucher= $this->input->get_post('voucher');
        $code = explode(',', $voucher);
        

        foreach ($code as $key => $value) 
        {
            $newstr=explode(':', $value);
            $result=$this->Onlinemodel->updateVoucher($newstr[0]);
            echo json_encode (array("voucherStatus"=>$result),JSON_NUMERIC_CHECK);
        }
        
    }

    public function newUpdateVoucher($voucher)
    {
        // $voucher= $this->input->get_post('voucher');
        $code = explode(',', $voucher);
        

        foreach ($code as $key => $value) 
        {
            $newstr=explode(':', $value);
            $result=$this->Onlinemodel->updateVoucher($newstr[0]);
            echo json_encode (array("voucherStatus"=>$result),JSON_NUMERIC_CHECK);
        }
        
    }


    public function insert_salesinvoicemaster()
		{
            // $d=strtotime("now");
            // $date=date("Y-m-d H:i:s",$d);
            $this->load->model('Salesmodel');
            $this->load->model('Onlinemodel');
            $points= $this->input->get_post('redeemedpoints');
            $customerid = $this->input->get_post('customerid');
            $DATE=$this->input->get_post('salesdate');
            $sales = $this->input->get_post('totalamount');
            $invoiceno =$this->input->get_post('invoiceno');
            $branchid= $this->input->get_post('branchid');
            $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid)->result();
            $result=sizeof($existence);
			if($result==0)
			{
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
                $balance=($this->input->get_post('paidcash')+$this->input->get_post('paidbank'))-$this->input->get_post('grandtotal');
                if($balance>0){
                     $insertdata['paidcash'] = $this->input->get_post('paidcash')-$balance;
                     $balance=0;
                }
                $insertdata['balance'] = $balance;
                $insertdata['narration'] = $this->input->get_post('narration');
                $insertdata['branchid'] = $branchid;	
                $insertdata['salesman'] = $this->input->get_post('salesmancode');	
                $insertdata['stockamount'] = $this->input->get_post('stockamount');	
                $insertdata['userid'] =$this->input->get_post('userid');
                $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
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
                echo json_encode(array("message"=>$dat1),JSON_NUMERIC_CHECK);
            }
            else
            {
                echo json_encode(array("message"=>$existence[0]->salesmasterid),JSON_NUMERIC_CHECK);
            }
        }

        public function insert_newsalesinvoicemaster()
		{
            // $d=strtotime("now");
            // $date=date("Y-m-d H:i:s",$d);
            $this->load->model('Salesmodel');
            $this->load->model('Onlinemodel');
            $points= $this->input->get_post('redeemedpoints');
            $customerid = $this->input->get_post('customerid');
            $DATE=$this->input->get_post('salesdate');
            $sales = $this->input->get_post('totalamount');
            $invoiceno =$this->input->get_post('invoiceno');
            $branchid= $this->input->get_post('branchid');
            $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid)->result();
            $result=sizeof($existence);
			if($result==0)
			{
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
                $insertdata['voucher'] = $this->input->get_post('voucher');
                $balance=($this->input->get_post('paidcash')+$this->input->get_post('paidbank'))-$this->input->get_post('grandtotal');
                if($balance>0){
                     $insertdata['paidcash'] = $this->input->get_post('paidcash')-$balance;
                     $balance=0;
                }
                $insertdata['balance'] = $balance;
                $insertdata['narration'] = $this->input->get_post('narration');
                $insertdata['branchid'] = $branchid;	
                $insertdata['salesman'] = $this->input->get_post('salesmancode');	
                $insertdata['stockamount'] = $this->input->get_post('stockamount');	
                $insertdata['userid'] =$this->input->get_post('userid');
                $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
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
                echo json_encode(array("message"=>$dat1),JSON_NUMERIC_CHECK);
            }
            else
            {
                echo json_encode(array("message"=>$existence[0]->salesmasterid),JSON_NUMERIC_CHECK);
            }
            $this->updateVoucher();
        }


    public function salesInsertAll()
    {
        $this->load->model('Salesmodel');
        $this->load->model('Onlinemodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        $details=json_decode($data->details);
            $points= $data->redeemedpoints;
            $customerid = $data->customerid;
            $DATE=$data->salesdate;
            $sales = $data->totalamount;
            $invoiceno =$data->invoiceno;
            $branchid= $data->branchid;
            $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid)->result();
            $result=sizeof($existence);
            if($result==0)
			{
                $insertdata['invoiceno'] = $invoiceno;
                $insertdata['customerid'] = $customerid;
                $insertdata['salesorderno'] = $data->salesorderno;
                $insertdata['salesmode'] =$data->salesmode;
                $insertdata['salesdate'] = $DATE;
                $insertdata['totalqty'] = $data->totalqty;
                $insertdata['totalamount'] = $sales;
                $insertdata['additionalcost'] = $data->additionalcost;
                $insertdata['taxamount'] = $data->taxamount;
                $insertdata['billdiscount'] = $data->billdiscount;
                $insertdata['grandtotal'] = $data->grandtotal;
                $insertdata['oldbalance'] = $data->oldbalance;
                $insertdata['cash'] = $data->cash;
                $insertdata['bank'] = $data->bank;
                $insertdata['paidcash'] = $data->paidcash;
                $insertdata['paidbank'] = $data->paidbank;
                $balance=($insertdata['paidcash']*1+$insertdata['paidbank']*1)-$insertdata['grandtotal']*1;
                if($balance>0)
                {
                    $insertdata['paidcash'] = $insertdata['paidcash']*1-$balance;
                    $balance=0;
                }
                $insertdata['balance'] = $balance;
                $insertdata['narration'] = $data->narration;
                $insertdata['branchid'] = $branchid;	
                $insertdata['salesman'] = $data->salesmancode;	
                $insertdata['stockamount'] = $data->stockamount;
                $insertdata['userid'] =$data->userid;
                $insertdata['voucher']=$data->voucher;
                $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
               
                if($points!=0)
                {
                    $a=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
                }
                $addpoints =($sales*1/100);
                if($sales!=0)
                {
                    $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
                }
                $this->api_newSalesInvoice_DayBookInsertion();
                $this->newUpdateVoucher($data->voucher);
                for($i=0;$i<count($details);$i++)
                {
                    $insertdata2['salesmasterid'] = $dat1;
                    $insertdata2['invoiceno'] = $invoiceno;
                    $insertdata2['salesdate'] = $DATE;
                    $insertdata2['productname'] = $details[$i]->productname;
                    $insertdata2['productcode'] = $details[$i]->productcode;
                    $insertdata2['qty'] = $details[$i]->qty;
                    $insertdata2['size'] = $details[$i]->size;
                    $insertdata2['unitprice'] = $details[$i]->mrp;
                    $insertdata2['netamount'] = $details[$i]->netamount;
                    $insertdata2['tax'] = $details[$i]->tax;
                    $insertdata2['taxamount'] = $details[$i]->taxamount;
                    $insertdata2['amount'] = $details[$i]->amount;
                    $insertdata2['branchid'] = $branchid;
                    $insertdata2['batchid'] = $details[$i]->batchid;
                    $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata2);  
                    $voucherno=$invoiceno;
                    $transactiontype='Sales Invoice';
                    $date=$DATE;
                    $branch=$branchid;
                    $batch=$details[$i]->batchid;
                    $product=$details[$i]->productcode;
                    $qty=$details[$i]->qty;
                    $qty=$qty*-1;
                    $size=$details[$i]->size;
                    $userid=$data->userid;
                    $stck=array();
                    $stck['productid']=$product;
                    $stck['currentstock']=$qty;
                    $stck['branch']=$branch;
                    $stck['batchid']=$batch;
                    $stck['size']=$size;
                    $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
                    if($check==0)
                    {
                        $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
                    }
                    else
                    {
                        $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);

                    }
                    
                }
            }
            else
            {
                echo json_encode(array("message"=>$existence[0]->salesmasterid),JSON_NUMERIC_CHECK);
            }
        
        echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK); 
    }



    public function insert_salesinvoicedetails()
	{
        // $ans=false;
        $id=$this->input->get_post('id');
        $userid=$this->input->get_post('userid');
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
            $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata);
            $voucherno=$data->invoiceno;
    	    $transactiontype='Sales Invoice';
    	    $date=$data->salesdate;
    	    // $userid=$data->userid;
            $branch=$data->branchid;
            $batch=$data->batchid;
            $product=$data->productcode;
            $qty=$data->qty;
            $qty=$qty*-1;
            $size=$data->size;
            $stck=array();
            $stck['productid']=$product;
            $stck['currentstock']=$qty;
            $stck['branch']=$branch;
            $stck['batchid']=$batch;
            $stck['size']=$size;
            $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
            if($check==0)
            {
                $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
            }
            else
            {
                $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
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

    public function api_newSalesInvoice_DayBookInsertion()
	{   
        $this->load->model('Onlinemodel');
        $this->load->model('Salesmodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        $paidcash=$data->paidcash;
        $paidbank=$data->paidbank;
        $invoiceno=$data->invoiceno;
        $date=$data->salesdate;
        $total=$data->totalamount;
        $discount=$data->billdiscount;
        $userid=$data->userid;
        $grand=($data->grandtotal)*1;
		$tax=0;
        $customerid=$data->customerid;
        $new['records']=$this->Onlinemodel->Select_customerledger($customerid);
        $customer=$new['records']['customeraccount'];
        $balance=$data->balance;
        $cash = $data->cash;
        $bank = $data->bank;
        $stock=$data->stockamount;
        $sales=$grand-$tax+$discount;
        $balance=($data->paidcash+$data->paidbank)-$data->grandtotal;
       
        if($balance>0)
        {
            $paidcash = $data->paidcash-$balance;
            $balance=0;
        }
        $data2=array();	
        //sales account
        $data2['invoiceno']=$invoiceno;
        $data2['accountType']='Sales Invoice';
        $data2['date']=$date;       
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data2['opposite']=$customer;
        $data2['userid']=$userid;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=0;
        $data2['credit']=$stock;
        $data2['opposite']=21;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cash account
        $data2['ledgername']=$cash;
        $data2['debit']=$paidcash;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //bank account
        $data2['ledgername']=$bank;
        $data2['debit']=$paidbank;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=$stock;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //discount of sales
        if($discount>0)
        {
            $data2['ledgername']=28;
            $data2['debit']=$discount;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //customer
        if($balance<0)
        {
			$data2['ledgername']=$customer;
			$abs=abs($balance);
			$data2['debit']=$abs;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //tax
        if($tax>0)
        {
            $data2['ledgername']=23;
            $data2['debit']=$tax;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        if($data22==false)
        {
            ?><script type="text/javascript">
            alert('Failed Daybook insertion........');
            </script>
            <?php
                      
        }

        echo json_encode(array("message"=>$data22),JSON_NUMERIC_CHECK);
        //Inserting into daybook_End
        
	}

    public function api_SalesInvoice_DayBookInsertion($status = true)
	{   
        // $d=strtotime("now");
        // $date=date("Y-m-d H:i:s",$d);
        $this->load->model('Salesmodel');
        $paidcash=$this->input->get_post('paidcash');
        $paidbank=$this->input->get_post('paidbank');
        $invoiceno=$this->input->get_post('invoiceno');
        $date=$this->input->get_post('salesdate');
        $total=$this->input->get_post('totalamount');
        $discount=$this->input->get_post('billdiscount');
        $grand=$this->input->post('grandtotal')*1;
		$tax=0;
        $customerid = $this->input->get_post('customerid');
        $data['records']=$this->Onlinemodel->Select_customerledger($customerid);
	 	$customer=$data['records']['customeraccount'];
        $balance = $this->input->get_post('balance');
        // $DATE=$this->input->get_post('salesdate');
        $cash = $this->input->get_post('cash');
        $bank = $this->input->get_post('bank');
        $stock=$this->input->get_post('stockamount');
        $sales=$grand-$tax+$discount;
         $balance=($this->input->get_post('paidcash')+$this->input->get_post('paidbank'))-$this->input->get_post('grandtotal');
                if($balance>0){
                   $paidcash = $this->input->get_post('paidcash')-$balance;
                     $balance=0;
                }
        log_message('error',$grand."-".$tax."-".$discount);
        $data2=array();	
        //sales account
        $data2['invoiceno']=$invoiceno;
        $data2['accountType']='Sales Invoice';
        $data2['date']=$date;       
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data2['opposite']=$customer;
        $data2['userid']=$this->session->userdata('user');
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
        $data2['ledgername']=4;
        $data2['debit']=0;
        $data2['credit']=$stock;
        $data2['opposite']=21;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cash account
        $data2['ledgername']=$cash;
        $data2['debit']=$paidcash;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //bank account
        $data2['ledgername']=$bank;
        $data2['debit']=$paidbank;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //cost of sales
        $data2['ledgername']=22;
        $data2['debit']=$stock;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //discount of sales
        if($discount>0)
        {
            $data2['ledgername']=28;
            $data2['debit']=$discount;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //customer
        if($balance<0)
        {
            $data['records']=$this->Onlinemodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=$abs;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
        //tax
        if($tax>0)
        {
            $data2['ledgername']=23;
            $data2['debit']=$tax;
            $data2['credit']=0;
            $data22=$this->Onlinemodel->insert_newdaybook($data2);
        }
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
        $this->load->model('Onlinemodel');
        $customerid = $this->input->get_post('customerid');
        $DATE=$this->input->get_post('salesdate');
        $sales = $this->input->get_post('totalamount');
        $invoiceno =$this->input->get_post('invoiceno');
        $branchid= $this->input->get_post('branchid');
        // $existence=$this->Salesmodel->api_checkexistence_retinvoiceno($invoiceno,$branchid)->result();
        // $result=sizeof($existence);
        $result=0;
        if($result==0)
        {
            $this->load->model('Salesmodel');
            $insertdata['invoiceno'] = $invoiceno;
            $insertdata['customerid'] = $customerid;
            $insertdata['salesmasterid'] = $this->input->get_post('masterid');
            $insertdata['salesdate'] = $DATE;
            $insertdata['totalqty'] = $this->input->get_post('totalqty');
            $insertdata['totalamount'] = $sales;
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
            $insertdata['branchid'] = $branchid;	
            $insertdata['salesman'] = $this->input->get_post('salesmancode');	
            $insertdata['stockamount'] = $this->input->get_post('stockamount');	
            $insertdata['userid'] = $this->input->get_post('userid');
            $dat=$this->Salesmodel->insert_salesreturnmaster($insertdata);
            $sales=$this->input->get_post('grandtotal');
            $cost=$this->input->get_post('stockamount');
            $addpoints=($sales*-1/100);
            if($addpoints!=0)
            {
                $r=$this->Salesmodel->addpoints($dat,$customerid,$addpoints,$DATE);
            }
            // $this->api_SalesReturn_AccountInsertion(false);
            $this->SalesReturn_DayBookInsertion(false);
            echo json_encode(array("message"=>$dat),JSON_NUMERIC_CHECK);
        }
        else
        {
            echo json_encode(array("message"=>$existence[0]->salesreturnid),JSON_NUMERIC_CHECK);
        }
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
        $userid=$this->input->get_post('userid');
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
         $voucherno=$this->input->get_post('invoiceno');
         $transactiontype='Sales Return';
         $date=$this->input->get_post('salesdate');
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
                $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
            }
            else
            {
                $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
            }
         echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
         }
         else 
         {
             echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
         }
    }


    // public function api_updatesalesinvoicemaster()
	// 	{
    //         $this->load->model('Salesmodel');
            
    //          $id=$this->input->get_post('id');
    //         $insertdata['invoiceno'] = $this->input->get_post('invoiceno');
    //         $insertdata['customerid'] = $this->input->get_post('customerid');
    //         $insertdata['salesorderno'] = $this->input->get_post('salesorderno');
    //         $insertdata['salesmode'] =$this->input->get_post('salesmode');
    //         $insertdata['salesdate'] = $this->input->get_post('salesdate');
    //         $insertdata['totalqty'] = $this->input->get_post('totalqty');
    //         $insertdata['totalamount'] = $this->input->get_post('totalamount');
    //         $insertdata['additionalcost'] = $this->input->get_post('additionalcost');
    //         $insertdata['taxamount'] = $this->input->get_post('taxamount');
    //         $insertdata['billdiscount'] = $this->input->get_post('billdiscount');
    //         $insertdata['grandtotal'] = $this->input->get_post('grandtotal');
    //         $insertdata['oldbalance'] = $this->input->get_post('oldbalance');
    //         $insertdata['cash'] = $this->input->get_post('cash');
    //         $insertdata['bank'] = $this->input->get_post('bank');
    //         $insertdata['paidcash'] = $this->input->get_post('paidcash');
    //         $insertdata['paidbank'] = $this->input->get_post('paidbank');
    //         $insertdata['balance'] = $this->input->get_post('balance');
    //         $insertdata['narration'] = $this->input->get_post('narration');
    //         $insertdata['branchid'] = $this->input->get_post('branchid');	
    //         $insertdata['salesman'] = $this->input->get_post('salesmancode');	
    //         $insertdata['stockamount'] = $this->input->get_post('stockamount');	
    //         $insertdata['userid'] =$this->input->get_post('userid');
    //         $points= $this->input->get_post('redeemedpoints');
    //         $customerid = $this->input->get_post('customerid');
    //         $DATE=$this->input->get_post('salesdate');
    //         $sales = $this->input->get_post('totalamount');
    //         $dat1=$this->Salesmodel->update_Returnsalesinvoicemaster($insertdata,$id);
    //          $new=$this->Salesmodel->delete_salesinvoicedetails($id);
             
    //         if($points!=0)
    //         {
    //             $r=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
    //         }
    //         $addpoints =($sales*1/100);
    //         if($sales!=0)
    //         {
    //             $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
    //         }
            
    //         echo json_encode(array("message"=>$dat1),JSON_NUMERIC_CHECK);
    //     }


    // public function returnInsert_salesinvoicedetails()
	// {
    //      $this->load->model('Salesmodel');
    //      $this->load->model('Onlinemodel');
    //     $id=$this->input->get_post('id');
    //     $insertdata['salesmasterid']=$id;
    //      $insertdata['invoiceno']=$this->input->get_post('invoiceno');
	// 	 $insertdata['salesdate']=$this->input->get_post('salesdate');
	// 	 $insertdata['productname']=$this->input->get_post('productname');
	//      $insertdata['productcode']=$this->input->get_post('productcode');
	// 	 $insertdata['qty']=$this->input->get_post('qty');
	// 	 $insertdata['size']=$this->input->get_post('size');
	// 	 $insertdata['unitprice']=$this->input->get_post('mrp');
	// 	 $insertdata['netamount']=$this->input->get_post('netamount');
	// 	 $insertdata['tax']=$this->input->get_post('tax');
	// 	 $insertdata['taxamount']=$this->input->get_post('taxamount');
	// 	 $insertdata['amount']=$this->input->get_post('amount');
    //      $insertdata['branchid']=$this->input->get_post('branchid');
    //      $insertdata['batchid']=$this->input->get_post('batchid');
        
        
    //         $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata);
    //         if($ans)
    //         {
    //             // $branch=$this->input->get_post('branchid');
    //             // $batch=$this->input->get_post('batchid');
    //             // $product=$this->input->get_post('productcode');
    //             // $batch=$this->input->get_post('productcode');
    //             // $qty=$this->input->get_post('qty');
    //             // $size=$this->input->get_post('size');
    //             // $stck['productid']=$product;
    //             // $stck['currentstock']=$qty*-1;
    //             // $stck['branch']=$branch;
    //             // $stck['batchid']=$batch;
    //             // $stck['size']=$size;
    //             // $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
    //             // if($check==0)
    //             // {
    //             //     $stock1=$this->Onlinemodel->insertstock($stck);
    //             // }
    //             // else
    //             // {
    //             //     $stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch);
    //             // }
    //             echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
    //         }
    //         else 
    //         {
    //             echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
    //         }
         
         
    //     //  $check=$this->Salesmodel->checkproduct($product,$branch,$batch,$size);
    //     // if($ans)
    //     // echo json_encode (array("message"=>"true"),JSON_NUMERIC_CHECK);
    //     // else 
    //     // echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
    //     //  $branch=$this->input->post('branchid');
    //     //  $batch=$this->input->post('batchid');
    //     //  $product=$this->input->post('productcode');
    //     //  $qty=$this->input->post('qty');
    //     //  $stock=$this->Salesmodel->sales_stock($product,$qty,$branch,$batch);
    //     //  }
    // }


    // public function api_SalesReturn_AccountInsertion($status = true)
    // {
    //     $this->load->model('Salesmodel');
    //     $total = $this->input->get_post('totalamount');
    //     $stockamount=$this->input->get_post('stockamount');
    //     $customer = $this->input->get_post('customerid');
    //     $balance = $this->input->get_post('balance');
    //     $discount = $this->input->get_post('billdiscount');
    //     $data['records']=$this->Onlinemodel->Select_customerledger($customer);
	// 	$customer=$data['records']['customeraccount'];
    //    	$data=array();
    //    	$dat=$this->Salesmodel->api_salesaccount($stockamount,$total,$customer,$discount,$balance);
    //     echo $status ? json_encode(array("message"=>$dat),JSON_NUMERIC_CHECK):'';

	// 	//sales account
    // }



    public function SalesReturn_DayBookInsertion($status = true)
	{    
        $invoiceno = $this->input->get_post('invoiceno');
        $date = $this->input->get_post('salesdate');
        $total = $this->input->get_post('totalamount');
        $balance = $this->input->get_post('balance');
        $discount = $this->input->get_post('billdiscount');
        $customer = $this->input->get_post('customerid');
        $grandtotal=$this->input->get_post('grandtotal');
        $stockamount=$this->input->get_post('stockamount');
		$data2=array();	
        // sales account
		$data2['invoiceno']=$invoiceno;
		$data2['accountType']='Sales Return';
		$data2['date']=$date;
		$data2['ledgername']=21;
		$data2['debit']=$total;
        $data2['credit']=0;
        $data2['opposite']=$customer;
        $data2['userid']=$this->session->userdata('user');
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
		$data2['ledgername']=4;
		$data2['debit']=$stockamount;
        $data2['credit']=0;
        $data2['opposite']=21;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
		//cost of sales
		$data2['ledgername']=22;
		$data2['debit']=0;
		$data2['credit']=$stockamount;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);

        //discount
        $data2['ledgername']=28;
        $data2['debit']=0;
        $data2['credit']=$discount;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        //customer
        $data['records']=$this->Onlinemodel->Select_customerledger($customer);
        $ledgername=$data['records']['customeraccount'];
        $data2['ledgername']=$ledgername;
        $data2['debit']=0;
        $data2['credit']=$balance;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
        
		if($data22==false)
		{
            ?><script type="text/javascript">
	        alert('Failed Daybook insertion........');
            </script>
            <?php 
		}
        echo $status ? json_encode(array("message"=>$dat22),JSON_NUMERIC_CHECK):'';
		//Inserting into daybook_End
    }
    

    public function api_insertError()
    {
        $data=array();
        $data['deviceid']=$this->input->get_post('deviceid');
        $data['userid']=$this->input->get_post('userid');
        $data['date']=$this->input->get_post('date');
        $data['error_function']=$this->input->get_post('error');
        $data['message']=$this->input->get_post('message');
        $a=$this->Onlinemodel->api_insertError($data);
        $this->load->model('Onlinemodel');
        echo json_encode(array("insertError" => $a),JSON_NUMERIC_CHECK);
    }

    public function api_getsalesbyinvoiceno()
    { 
        $a=$this->input->get_post('voucher');
        $branch=$this->input->get_post('branch');
        $this->load->model('Onlinemodel');
        echo json_encode(array("master" => $this->Onlinemodel->getsalesmasterforreturn($a,$branch)->result(),"detailes" => $this->Onlinemodel->getsalesdetailesforreturn($a,$branch)->result()),JSON_NUMERIC_CHECK);
    }

    // updated at 28-12-2020
    public function api_productStockByCode()
    {
        $productCode = $this->input->get_post('productCode');
        $this->load->model('Onlinemodel');
        echo json_encode(array("ProductStock" => $this->Onlinemodel->api_productStockByCode($productCode)->result()),JSON_NUMERIC_CHECK);
    }

    // updated at 28-12-2020
    public function api_productStockBySize()
    {
        $sizeId = $this->input->get_post('sizeId');
        $this->load->model('Onlinemodel');
        echo json_encode(array("ProductStock" => $this->Onlinemodel->api_productStockBySize($sizeId)->result()),JSON_NUMERIC_CHECK);
    }
        

    public function api_getimagegrp()
    {
        $id = $this->input->get_post('id');
        $this->load->model('Onlinemodel');
        echo json_encode(array("pdtimage" => $this->Onlinemodel->api_getimagegrp($id)->result()),JSON_NUMERIC_CHECK);
    }

    public function api_updorderstatus()
    {
        $orderno = $this->input->get_post('orderno');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->api_updorderstatus($orderno);
        echo json_encode(array("orderstatus" =>$ans),JSON_NUMERIC_CHECK);
    }

    public function api_updateonlineorderstatus()
    {
        $orderno = $this->input->get_post('orderno');
        $this->load->model('Onlinemodel');
        $ans=$this->Onlinemodel->api_updateonlineorderstatus($orderno);
        echo json_encode(array("orderstatus" =>$ans),JSON_NUMERIC_CHECK);
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

    public function api_getshoporderbranch()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $ref = $this->Onlinemodel->api_referencebranch($branchid)->result();
        $ref2 = $this->Onlinemodel->api_getshoporderbranch($branchid)->result();
        echo json_encode(array("shoporder" =>$ref2, "reference" =>$ref),JSON_NUMERIC_CHECK);
    }

    public function api_getonlineorderbranch()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $ref = $this->Onlinemodel->api_onlinereferencebranch($branchid)->result();
        $ref2 = $this->Onlinemodel->api_getonlineorderbranch($branchid)->result();
        echo json_encode(array("onlineorder" =>$ref2, "onlinereference" =>$ref),JSON_NUMERIC_CHECK);
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
        $fOnlyDate = $this->input->get_post('fOnlyDate');
        $tOnlyDate = $this->input->get_post('tOnlyDate');
        $this->load->model('Onlinemodel');
        echo json_encode(array("branchShopOrder" => $this->Onlinemodel->api_branchShopOrder($fOnlyDate,$tOnlyDate,$branchid)->result()),JSON_NUMERIC_CHECK);
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

    public function api_Autogenerate_ReceiptVoucherNo()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("voucherNo" => $this->Onlinemodel->Autogenerate_ReceiptVoucherNo()->result()),JSON_NUMERIC_CHECK);
    }

    
	
	

	public function api_insert_receiptvoucher()
	{
        $data=array();
        $data['voucherno']=$this->input->get_post('voucherno');
        $data['ledger']=$this->input->get_post('ledger');
        $data['amount']=$this->input->get_post('amount');
        $data['receiptdate']=$this->input->get_post('salesdate');
        $data['cashorbank']=$this->input->get_post('cashorbank');
        $data['narration']=$this->input->get_post('narration');
        $data['branchid']=$this->input->get_post('branchid');
        $data['userid']=$this->input->get_post('userid');
        $value=$data['voucherno'];
        $ledgername= $data['ledger'];
        $data1['records']=$this->Onlinemodel->Select_ledger($ledgername);
        $rootid=$data1['records']['rootid'];
        $currentbalance=$data1['records']['currentbalance'];
        if($rootid==1 || $rootid==4)
        {
            $data['currentbalance']=$currentbalance-$this->input->get_post('amount');
        }
        else
        {
            $data['currentbalance']=$currentbalance+$this->input->get_post('amount');
        }
        
        $existence=$this->Onlinemodel->checkexistence_receiptvoucherno($value);
        if($existence==0)
        {
            $result=$this->Onlinemodel->insert_ReceiptVoucher($data);
            if($result==true)
            {
                $cashorbank= $data['cashorbank'];
			    $data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
			    $data2=array();
			    $data2['invoiceno']=$data['voucherno'];
			    $data2['accountType']='Receipt Voucher';
			    $data2['date']=$this->input->get_post('salesdate');
			    $data2['ledgername']=$ledgername;
			    $data2['userid']=$this->input->get_post('userid');
			    $data2['debit']=0;
			    $data2['credit']=$data['amount'];
                $data2['opposite']=$cashorbank;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
			    $data2['ledgername']=$cashorbank;
			    $data2['debit']=$data['amount'];
			    $data2['credit']=0;
                $data2['opposite']=$ledgername;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
			    if($result3==false)
			    {
                }
            }
		    else
		    {
            }
        }
        else
        {
        }
        echo json_encode(array("receipt" => $existence),JSON_NUMERIC_CHECK);
    }

    public function api_Autogenerate_payVoucherNo()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("payVoucherNo" => $this->Onlinemodel->Autogenerate_payVoucherNo()->result()),JSON_NUMERIC_CHECK);
    }

    public function api_getExpenseLedger()
    {
        $this->load->model('Onlinemodel');
        $branchid=$this->input->get_post('branchid');
        echo json_encode(array("expenseLedger" => $this->Onlinemodel->api_getExpenseLedger($branchid)->result()),JSON_NUMERIC_CHECK);
    }
    
    public function api_insert_paymentvoucher()
    {
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->get_post('VendorInvoiceNo');
    	$data['ledger']=$this->input->get_post('ledger');
    	$data['date']=$this->input->get_post('date');
    	$data['currentbalance']=$this->input->get_post('currentbalance');
    	$data['narration']=$this->input->get_post('narration');
    	$data['totalamount']=$this->input->get_post('totalamount');
    	$data['cashorbank']=$this->input->get_post('cashorbank');
    	$data['voucherno']=$this->input->get_post('voucherno');
        $data['userid']=$this->input->get_post('userid');
        $value=$this->input->get_post('voucherno');
        $existence=$this->Onlinemodel->checkexistence_payment($value);
        if($existence==0)
        {
            $result=$this->Onlinemodel->insert_paymentvoucher($data);
            if($result)
            {
                $cashorbank= $data['cashorbank'];
				$ledgername=$data['ledger'];
				$amount=$data['totalamount'];
				$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
                $rootid=$data['records']['rootid'];
                $data2=array();
                $data2['invoiceno']=$data['voucherno'];
                $data2['accountType']='Payment Voucher';
		        $data2['date']=$this->input->get_post('date');
		        $data2['ledgername']=$ledgername;
		        $data2['userid']=$this->input->get_post('userid');
		        $data2['debit']=$data['totalamount'];
		        $data2['credit']=0;
		        $data2['opposite']=$cashorbank;
		        $result3=$this->Onlinemodel->insert_newdaybook($data2);
		        $data2['ledgername']=$cashorbank;
		        $data2['debit']=0;
		        $data2['credit']=$data['totalamount'];
		        $data2['opposite']=$ledgername;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
            }
        }
        echo json_encode(array("payment" => $existence),JSON_NUMERIC_CHECK);
    }
    

    // At 27-11-2020
    //get user log
    public function Api_userLogin()
    {
        $data=array();
        $user=$this->input->get_post('username');
        $pass=$this->input->get_post('password');
        $this->load->model('Onlinemodel');
        $login=$this->Onlinemodel->Api_userLogin($user);
		if($login)
		{
            foreach ($login->result() as $key)
            {
                if(password_verify($pass,$key->password))
				{
                    $status=true;
                    $data=$key;
                }
                else
                {
                    $status=false;
                    $data = null;
                }
            }
        }
        else
        {
            $status=false;
            $data = null;
        }
        $json_array=array("status"=>$status,"userDetails"=>$data);
        echo json_encode($json_array);
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

    public function api_stockbybranch()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        echo json_encode(array("stockByBranch" => $this->Onlinemodel->api_stockbybranch($branchid)->result()),JSON_NUMERIC_CHECK);
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
        // $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $res=$this->Onlinemodel->api_pdtqtycustomer($fdate,$tdate,$customerid)->result();
        log_message('error',$res);
        echo json_encode(array("pdtqtycustomer" => $res),JSON_NUMERIC_CHECK);
        
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
        echo json_encode(array("customercategory"=>$this->Onlinemodel->api_customercategory($fdate,$tdate,$customerid)->result()),JSON_NUMERIC_CHECK);
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
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        ini_set('max_execution_time',0);
        $config['upload_path'] ='./shoporder/images/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = (1024*1024)*25;
        $imageName="";
        $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        //print_r($_FILES);
        //  $ans = file_get_contents('php://input');
        $get_data = $this->input->get_post('data');
        $data = json_decode($get_data);
        $s= $data->shoporderno;
        $stat = $this->Onlinemodel->api_checkshoporder($s);
        if($stat==0)
        {
            //  echo json_encode($data);
            if(isset($_FILES['image']))
            {
                if(!$this->upload->do_upload('image'))
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
            $insertData['shoporderno'] = $s;
             $insertData['orderno'] = $data->orderno;
            $insertData['date_delivery'] = $data->date_delivery;
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
            $insertData['cash'] = $data->cash;
            $insertData['bank'] = $data->bank;
            $insertData['paid_cash'] = $data->paidcash;
            $insertData['paid_bank'] = $data->paidbank;
            $insertData['balance'] = $data->balance;
            $cash=$insertData['cash'];
            $shoporderno=$insertData['shoporderno'];
            $userid=$insertData['userid'];
            $bank=$insertData['bank'];
            $casham=$insertData['paid_cash'];
            $bankam=$insertData['paid_bank'];
            $paidcash=(int)$casham;
            $paidbank=(int)$bankam;
            $amount=$paidcash+$paidbank;
            $customerid=$insertData['customerid'];
            $ans['records']=$this->Onlinemodel->Select_customerledger($customerid);
            $custledger=$ans['records']['customeraccount'];
            $addimage = $this->Onlinemodel->api_imageupload($insertData);
            if($addimage)
            {
                $data2=array();
                $data2['invoiceno']=$shoporderno;
                $data2['accountType']='Shop Order Advance';
                $data2['date']=$date;
                $data2['ledgername']=$custledger;
                $data2['userid']=$userid;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=$paidcash;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$bank;
                $data2['debit']=$paidbank;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
            } 
        }
        else
        {
            if(isset($_FILES['image']))
            {
                if(!$this->upload->do_upload('image'))
                {
                    echo json_encode(array('message'=> $this->upload->display_errors('',''),"success"=>false));
                    //return;
                }
                else
                {
                    $uploadData = $this->upload->data();
                    $imageName .= $uploadData['file_name'];
                }
            }
            $insertData['orderno'] = $data->orderno;
            $insertData['shoporderno'] = $data->shoporderno;
            $insertData['date_delivery'] = $data->date_delivery	;
            $insertData['date_current']= $data->date_current;
            $insertData['pdt_desc'] = $data->pdt_desc;
            $insertData['salesmanid']= $data->salesmanid;
            $insertData['customerid']= $data->customerid;
            $insertData['qty'] = $data->qty;
            $insertData['imagepath'] = $data->imagepath;
            $insertData['narration'] = $data->narration;
            $insertData['amount'] = $data->amount;
            $insertData['branchid'] = $data->branchid;
            $insertData['userid'] = $data->userid;
            $insertData['cash'] = $data->cash;
            $insertData['bank'] = $data->bank;
            $insertData['paid_cash'] = $data->paidcash;
            $insertData['paid_bank'] = $data->paidbank;
            $insertData['balance'] = $data->balance;
            $id = $data->shoporderno;
            $cash=$insertData['cash'];
            $shoporderno=$insertData['shoporderno'];
            $userid=$insertData['userid'];
            $bank=$insertData['bank'];
            $newcasham=$insertData['paid_cash'];
            $newbankam=$insertData['paid_bank'];
            $newpaidcash=(int)$newcasham;
            $newpaidbank=(int)$newbankam;
            $newamount=$newpaidcash+$newpaidbank;
            $old['records']=$this->Onlinemodel->getshoporderbyorderno($shoporderno);
            $oldcasham=$old['records']['paid_cash'];
            $oldbankam=$old['records']['paid_bank'];
            $oldpaidcash=(int)$oldcasham;
            $oldpaidbank=(int)$oldbankam;
            $oldamount=$oldpaidcash+$oldpaidbank;
            $customerid=$insertData['customerid'];
            $ans['records']=$this->Onlinemodel->Select_customerledger($customerid);
            $custledger=$ans['records']['customeraccount'];
            $addimage= $this->Onlinemodel->api_updateimageupload($insertData,$id);
            $amount=$newamount-$oldamount;
            $paidbank=$newpaidbank-$oldpaidbank;
            $paidcash=$newpaidcash-$oldpaidcash;
            if($addimage)
            {
                $data2=array();
                $data2['invoiceno']=$shoporderno;
                $data2['accountType']='Shop Order Advance Update';
                $data2['date']=date('Y-m-d H:i:s');
                $data2['ledgername']=$custledger;
                $data2['userid']=$userid;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=$paidcash;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$bank;
                $data2['debit']=$paidbank;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
            }
        }
    }

   


    public function api_audioupload()
    {
        // ini_set('max_execution_time',0);
        // $config['upload_path'] ='./shoporder/audio/';
        // $config['allowed_types'] = 'mp3|m4r|ogg';
        // $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        // $get_data = $this->input->get_post('data');
        //  $get_data = $this->input->get_post('data');
        // $data = json_decode($get_data);
        
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
        if($status==0){
        for($i=0;$i<count($myArray);$i++)
        {
            // echo json_encode(array("array"=>$myArray),JSON_NUMERIC_CHECK);
            $insertData['pdt_code'] = $myArray[$i];
            $insertData['fk_shoporderid'] = $shopid;
            $addaudio = $this->Onlinemodel->api_audioupload($insertData);
            echo json_encode(array("message"=>$addaudio),JSON_NUMERIC_CHECK);
        }
    }else{
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



    //------------------ONLINE ORDER---------------//


    public function api_onlineimageupload()
    {
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        ini_set('max_execution_time',0);
        $config['upload_path'] ='./onlineorder/images/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = (1024*1024)*25;
        $imageName="";
        $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        //print_r($_FILES);
        //  $ans = file_get_contents('php://input');
        $get_data = $this->input->get_post('data');
        $data = json_decode($get_data);
        $s= $data->onlineorderno;
        $stat = $this->Onlinemodel->api_checkonlineorder($s);
        if($stat==0)
        {
            //  echo json_encode($data);
            if(isset($_FILES['image']))
            {
                if(!$this->upload->do_upload('image'))
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
            $insertData['onlineorderno'] = $s;
             $insertData['orderno'] = $data->orderno;
            $insertData['date_delivery'] = $data->date_delivery;
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
            $insertData['cash'] = $data->cash;
            $insertData['bank'] = $data->bank;
            $insertData['paid_cash'] = $data->paidcash;
            $insertData['paid_bank'] = $data->paidbank;
            $insertData['balance'] = $data->balance;
            $cash=$insertData['cash'];
            $onlineorderno=$insertData['onlineorderno'];
            $userid=$insertData['userid'];
            $bank=$insertData['bank'];
            $casham=$insertData['paid_cash'];
            $bankam=$insertData['paid_bank'];
            $paidcash=(int)$casham;
            $paidbank=(int)$bankam;
            $amount=$paidcash+$paidbank;
            $customerid=$insertData['customerid'];
            $ans['records']=$this->Onlinemodel->Select_customerledger($customerid);
            $custledger=$ans['records']['customeraccount'];
            $addimage = $this->Onlinemodel->api_onlineimageupload($insertData);
            if($addimage)
            {
                $data2=array();
                $data2['invoiceno']=$onlineorderno;
                $data2['accountType']='Online Order Advance';
                $data2['date']=$date;
                $data2['ledgername']=$custledger;
                $data2['userid']=$userid;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=$paidcash;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$bank;
                $data2['debit']=$paidbank;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
            } 
        }
        else
        {
            if(isset($_FILES['image']))
            {
                if(!$this->upload->do_upload('image'))
                {
                    echo json_encode(array('message'=> $this->upload->display_errors('',''),"success"=>false));
                    //return;
                }
                else
                {
                    $uploadData = $this->upload->data();
                    $imageName .= $uploadData['file_name'];
                }
            }
            $insertData['orderno'] = $data->orderno;
            $insertData['onlineorderno'] = $data->onlineorderno;
            $insertData['date_delivery'] = $data->date_delivery	;
            $insertData['date_current']= $data->date_current;
            $insertData['pdt_desc'] = $data->pdt_desc;
            $insertData['salesmanid']= $data->salesmanid;
            $insertData['customerid']= $data->customerid;
            $insertData['qty'] = $data->qty;
            $insertData['imagepath'] = $data->imagepath;
            $insertData['narration'] = $data->narration;
            $insertData['amount'] = $data->amount;
            $insertData['branchid'] = $data->branchid;
            $insertData['userid'] = $data->userid;
            $insertData['cash'] = $data->cash;
            $insertData['bank'] = $data->bank;
            $insertData['paid_cash'] = $data->paidcash;
            $insertData['paid_bank'] = $data->paidbank;
            $insertData['balance'] = $data->balance;
            $id = $data->onlineorderno;
            $cash=$insertData['cash'];
            $onlineorderno=$insertData['onlineorderno'];
            $userid=$insertData['userid'];
            $bank=$insertData['bank'];
            $newcasham=$insertData['paid_cash'];
            $newbankam=$insertData['paid_bank'];
            $newpaidcash=(int)$newcasham;
            $newpaidbank=(int)$newbankam;
            $newamount=$newpaidcash+$newpaidbank;
            $old['records']=$this->Onlinemodel->getonlineorderbyorderno($onlineorderno);
            $oldcasham=$old['records']['paid_cash'];
            $oldbankam=$old['records']['paid_bank'];
            $oldpaidcash=(int)$oldcasham;
            $oldpaidbank=(int)$oldbankam;
            $oldamount=$oldpaidcash+$oldpaidbank;
            $customerid=$insertData['customerid'];
            $ans['records']=$this->Onlinemodel->Select_customerledger($customerid);
            $custledger=$ans['records']['customeraccount'];
            $addimage= $this->Onlinemodel->api_updateimageupload($insertData,$id);
            $amount=$newamount-$oldamount;
            $paidbank=$newpaidbank-$oldpaidbank;
            $paidcash=$newpaidcash-$oldpaidcash;
            if($addimage)
            {
                $data2=array();
                $data2['invoiceno']=$onlineorderno;
                $data2['accountType']='Online Order Advance Update';
                $data2['date']=date('Y-m-d H:i:s');
                $data2['ledgername']=$custledger;
                $data2['userid']=$userid;
                $data2['debit']=0;
                $data2['credit']=$amount;
                $data2['opposite']=$cash;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$cash;
                $data2['debit']=$paidcash;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                $data2['ledgername']=$bank;
                $data2['debit']=$paidbank;
                $data2['credit']=0;
                $data2['opposite']=$custledger;
                $result3=$this->Onlinemodel->insert_newdaybook($data2);
                echo json_encode(array('message'=>$addimage),JSON_NUMERIC_CHECK);
            }
        }
    }
    
    public function api_onlineaudioupload()
    {
        // ini_set('max_execution_time',0);
        // $config['upload_path'] ='./shoporder/audio/';
        // $config['allowed_types'] = 'mp3|m4r|ogg';
        // $this->load->library('upload',$config);
        $this->load->model('Onlinemodel');
        $ans = file_get_contents('php://input');
        $data = json_decode($ans);
        // $get_data = $this->input->get_post('data');
        //  $get_data = $this->input->get_post('data');
        // $data = json_decode($get_data);
        
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
        $onlineid=$data->fk_onlineorderid;
        $status=$this->Onlinemodel->api_checkrefonlineorder($onlineid);
        if($status==0)
        {
            for($i=0;$i<count($myArray);$i++)
            {
                // echo json_encode(array("array"=>$myArray),JSON_NUMERIC_CHECK);
                $insertData['pdt_code']=$myArray[$i];
                $insertData['fk_onlineorderid']=$onlineid;
                $addaudio=$this->Onlinemodel->api_onlineaudioupload($insertData);
                echo json_encode(array("message"=>$addaudio),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            for($i=0;$i<count($myArray);$i++)
            {
                // echo json_encode(array("array"=>$myArray),JSON_NUMERIC_CHECK);
                $insertData['pdt_code']=$myArray[$i];
                $insertData['fk_onlineorderid']=$onlineid;
                $addaudio = $this->Onlinemodel->api_updateonlineaudioupload($insertData,$onlineid);
                echo json_encode(array("message"=>$addaudio),JSON_NUMERIC_CHECK);
            }
        }
    }
    
    public function api_returnDetailsUpdate()
    {
        $this->load->model('Onlinemodel');
        // $data=array();
        $data1=$this->Onlinemodel->api_testgetsalesreturndetails();
        $ans=null;
        $len=$data1->num_rows();
        $data=$data1->result_array();
        for($i=0;$i<$len;$i++)
        {
            $insertdata=array();
            $insertdata['salesmasterid'] = $data[$i]['salesmasterid'];
            $insertdata['invoiceno'] = $data[$i]['invoiceno'];
            $insertdata['salesdate'] = $data[$i]['salesdate'];
            $insertdata['productname'] = $data[$i]['productname'];
            $insertdata['productcode'] = $data[$i]['productcode'];
            $insertdata['qty'] = $data[$i]['qty'];
            $insertdata['size'] = $data[$i]['size'];
            $insertdata['netamount'] = $data[$i]['netamount'];
            $insertdata['tax'] = $data[$i]['tax'];
            $insertdata['taxamount'] = $data[$i]['taxamount'];
            $insertdata['amount'] = $data[$i]['amount'];
            $insertdata['branchid'] = $data[$i]['branchid'];
            $insertdata['batchid'] = $data[$i]['batchid'];
            $branchid=$data[$i]['branchid'];
            $invoiceno=$data[$i]['invoiceno'];
            $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata);
        }
        echo json_encode(array("returndetails" => $ans),JSON_NUMERIC_CHECK);
    }

    public function api_returnMasterUpdate()
    {
        $this->load->model('Onlinemodel');
        // $data=array();
        $data1=$this->Onlinemodel->api_testgetsalesmaster();
        $ans=null;
        $len=$data1->num_rows();
        $data=$data1->result_array();
        for($i=0;$i<$len;$i++)
        {
            $totalqty = $data[$i]['totalqty'];
            $totalamount = $data[$i]['totalamount'];
            $taxamount = $data[$i]['taxamount'];
            $additionalcost = $data[$i]['additionalcost'];
            $billdiscount = $data[$i]['billdiscount'];
            $grandtotal = $data[$i]['grandtotal'];
            $oldbalance = $data[$i]['oldbalance'];
            $paidcash = $data[$i]['paidcash'];
            $paidbank = $data[$i]['paidbank'];
            // $balance = $data[i]['balance'];
            $stockamount = $data[$i]['stockamount'];
            $salesmasterid = $data[$i]['salesmasterid'];
            $ans=$this->Onlinemodel->testupdatesaleinvoicemaster($totalqty,$totalamount,$taxamount,$additionalcost,$billdiscount,$grandtotal,$oldbalance,$paidcash,$paidbank,$stockamount,$salesmasterid);
        }
        echo json_encode(array("returnmaster" => $ans),JSON_NUMERIC_CHECK);
    }

    public function api_getvouchercode()
    {
        $this->load->model('Onlinemodel');
        echo json_encode(array("voucherCode"=>$this->Onlinemodel->api_getvouchercode()->result()),JSON_NUMERIC_CHECK);
    }

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');

header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");

header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Cloudcontroller extends CI_Controller {

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

        public function flutter_insert_sales()
        {
            $d=strtotime("now");
            $date=date("Y-m-d H:i:s",$d);
            $this->load->model('Salesmodel');
            $this->load->model('Onlinemodel');
             $new = file_get_contents('php://input');
             $product = json_decode($new);
    
             $points =0;

            $points= $product->redeemedpoints;
             $customerid = $product->customerid;
             if($customerid==0){
              
              $customerid = $this->flutter_insert_customer_fromsales(false);

             }
            $DATE=$product->salesdatestring;
            $sales = $product->totalamount;
            $invoiceno = $product->invoiceno;
            $branchid = $product->branchid;
            $userid = $product->userid;
            $finyear = 4;

            log_message('error', "Branch--".$branchid."----invoice--".$invoiceno);
            log_message('error', "__SALE__");


            $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid,$finyear)->result();
            $result=sizeof($existence);
            if($result==0)
            {

                $insertdata['invoiceno'] = $invoiceno;
                $insertdata['customerid'] = $customerid;
                $insertdata['salesorderno'] = $product->salesorderno;               
                $insertdata['salesmode'] =$product->salesmode;
                $insertdata['salesdate'] = $DATE;
                $insertdata['totalqty'] = $product->totalqty;
                $insertdata['totalamount'] = $sales;
                $insertdata['additionalcost'] = $product->additionalcost;
                $insertdata['taxamount'] = $product->taxamount;
                $insertdata['billdiscount'] = $product->billdiscount;
                $insertdata['grandtotal'] = $product->grandtotal;
                $insertdata['oldbalance'] = $product->oldbalance;
                $insertdata['cash'] = $product->cash;
                $insertdata['bank'] = $product->bank;
                $insertdata['paidcash'] = $product->paidcash;
                $insertdata['paidbank'] =$product->paidbank;
                $insertdata['finyear'] =4;
                $balance=$product->paidcash+$product->paidbank-$product->grandtotal;
                if($balance>0){
                     $insertdata['paidcash'] =$product->paidcash-$balance;
                     $balance=0;
                }
                $insertdata['balance'] = $balance;
                $insertdata['narration'] = $product->narration;
                $insertdata['branchid'] = $branchid;    
                $insertdata['salesman'] = $product->salesman;   
                $insertdata['stockamount'] = $product->stockamount; 
                $insertdata['userid'] =$product->userid; 
                $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
                $dybuk = $this->api_SalesInvoice_DayBookInsertion($invoiceno,false);

                if ($dat1 !== null) {

                $prs = $product->details;
                $i=1;
                foreach($prs as $data)
                { 
                    $taxx=5;
                    $taxxamount=0;
                    if($data->mrp>999){
                        $taxx=12;
                    }

                    if ($data->prdCode == null) {

                        $pdt_id = $this->Onlinemodel->get_pdt_id($data->productName);

                    // log_message('error', "---".$pdt_id);

                        $pdct_code = $pdt_id;

                    }else{

                        $pdct_code = $data->prdCode;

                    }

                    // log_message('error', "***".$pdct_code);

                    $taxxamount=($data->qty*$data->mrp)*$taxx/(100+$taxx);
                    $insertdata2=array();
                    $value=$invoiceno;
                    $insertdata2['salesmasterid'] = $dat1;
                    $insertdata2['invoiceno'] = $value;
                    $insertdata2['salesdate'] = $DATE;
                    $insertdata2['productname'] = $data->productName;
                    $insertdata2['productcode'] = $pdct_code;
                    $insertdata2['qty'] = $data->qty;
                    $insertdata2['size'] = $data->sizeId;
                    $insertdata2['unitprice'] = $data->mrp;
                    $insertdata2['netamount'] =($data->qty*$data->mrp)-$taxxamount;
                    $insertdata2['tax'] = $taxx;
                    $insertdata2['taxamount'] = $taxxamount;
                    $insertdata2['amount'] = ($data->qty*$data->mrp);
                    $insertdata2['branchid'] =$branchid;
                    $insertdata2['batchid'] = 0;
                    $insertdata2['finyear'] =4;

                    $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata2);

                    if ($ans == true) {
                        $voucherno=$invoiceno;
                        $transactiontype='Sales Invoice';
                        $date= $DATE;
                    // $userid=$product->userid;
                    // $branch=$product->branchid;
                        $batch=0;
                        $product=$pdct_code;
                        $qty=$data->qty;
                        $size= $data->sizeId;
                        $stck=array();
                        $stck['productid']=$product;
                        $stck['currentstock']=$qty*-1;
                        $stck['branch']=$branchid;
                        $stck['batchid']=$batch;
                        $stck['size']=$size;
                        $check=$this->Salesmodel->checkproduct($product,$branchid,$batch,$size);
                        if($check==0)
                        {
                            $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
                        }
                        else
                        {
                            $stock=$this->Onlinemodel->updatestock($product,$size,$qty*-1,$branchid,$batch,$voucherno,$transactiontype,$date,$userid);
                        }

                    }else{ echo json_encode(false);}

                    $i++;
                }

                log_message('error',$dat1);

            echo json_encode (array("masterid"=>$dat1,"customerid"=>$customerid),JSON_NUMERIC_CHECK);


                }else{ echo json_encode(false); }              


            // if($ans)
            // {
            //     echo json_encode (array("masterid"=>$dat1,"customerid"=>$customerid),JSON_NUMERIC_CHECK); 
            // }
            // else 
            // {
            //     echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
            // }
        // }
        // else
        // {
        //     echo json_encode (array("masterid"=>$dat1,"customerid"=>$customerid),JSON_NUMERIC_CHECK);
        // }

        }
    }

    public function flutter_insert_sales_status()
    {
            $d=strtotime("now");
            $date=date("Y-m-d H:i:s",$d);
            $this->load->model('Salesmodel');
            $this->load->model('Onlinemodel');
            $new = file_get_contents('php://input');
            $product = json_decode($new);

            $points =0;

            $points= $product->redeemedpoints;
            $customerid = $product->customerid;
            if($customerid==0){
            $customerid = $this->flutter_insert_customer_fromsales(false);
            }

          $DATE=$product->salesdatestring;
          $sales = $product->totalamount;
          $invoiceno = $product->invoiceno;
          $branchid = $product->branchid;
          $userid = $product->userid;
          $finyear = 4;

          log_message('error', "Branch--".$branchid."----invoice--".$invoiceno);
          log_message('error', "__STATUS__");

          $existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid,$finyear)->result();
          $result=sizeof($existence);
          if($result==0)
          {

            $insertdata['invoiceno'] = $invoiceno;
            $insertdata['customerid'] = $customerid;
            $insertdata['salesorderno'] = $product->salesorderno;               
            $insertdata['salesmode'] =$product->salesmode;
            $insertdata['salesdate'] = $DATE;
            $insertdata['totalqty'] = $product->totalqty;
            $insertdata['totalamount'] = $sales;
            $insertdata['additionalcost'] = $product->additionalcost;
            $insertdata['taxamount'] = $product->taxamount;
            $insertdata['billdiscount'] = $product->billdiscount;
            $insertdata['grandtotal'] = $product->grandtotal;
            $insertdata['oldbalance'] = $product->oldbalance;
            $insertdata['cash'] = $product->cash;
            $insertdata['bank'] = $product->bank;
            $insertdata['paidcash'] = $product->paidcash;
            $insertdata['paidbank'] =$product->paidbank;
            $insertdata['finyear'] =4;
            $balance=$product->paidcash+$product->paidbank-$product->grandtotal;
            if($balance>0){
             $insertdata['paidcash'] =$product->paidcash-$balance;
             $balance=0;
         }
         $insertdata['balance'] = $balance;
         $insertdata['narration'] = $product->narration;
         $insertdata['branchid'] = $branchid;    
         $insertdata['salesman'] = $product->salesman;   
         $insertdata['stockamount'] = $product->stockamount; 
         $insertdata['userid'] =$product->userid; 
         $dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);
         $dybuk = $this->api_SalesInvoice_DayBookInsertion($invoiceno,false);

         if ($dat1 !== null) {

            $prs = $product->details;
            $i=1;
            foreach($prs as $data)
            { 
                $taxx=5;
                $taxxamount=0;
                if($data->mrp>999){
                    $taxx=12;
                }

                if ($data->prdCode == null) {

                    $pdt_id = $this->Onlinemodel->get_pdt_id($data->productName);

                        // log_message('error', "---".$pdt_id);

                    $pdct_code = $pdt_id;

                }else{

                    $pdct_code = $data->prdCode;

                }

                        // log_message('error', "***".$pdct_code);

                $taxxamount=($data->qty*$data->mrp)*$taxx/(100+$taxx);
                $insertdata2=array();
                $value=$invoiceno;
                $insertdata2['salesmasterid'] = $dat1;
                $insertdata2['invoiceno'] = $value;
                $insertdata2['salesdate'] = $DATE;
                $insertdata2['productname'] = $data->productName;
                $insertdata2['productcode'] = $pdct_code;
                $insertdata2['qty'] = $data->qty;
                $insertdata2['size'] = $data->sizeId;
                $insertdata2['unitprice'] = $data->mrp;
                $insertdata2['netamount'] =($data->qty*$data->mrp)-$taxxamount;
                $insertdata2['tax'] = $taxx;
                $insertdata2['taxamount'] = $taxxamount;
                $insertdata2['amount'] = ($data->qty*$data->mrp);
                $insertdata2['branchid'] =$branchid;
                $insertdata2['batchid'] = 0;
                $insertdata2['finyear'] =4;

                $ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata2);

                if ($ans == true) {
                    $voucherno=$invoiceno;
                    $transactiontype='Sales Invoice';
                    $date= $DATE;
                        // $userid=$product->userid;
                        // $branch=$product->branchid;
                    $batch=0;
                    $product=$pdct_code;
                    $qty=$data->qty;
                    $size= $data->sizeId;
                    $stck=array();
                    $stck['productid']=$product;
                    $stck['currentstock']=$qty*-1;
                    $stck['branch']=$branchid;
                    $stck['batchid']=$batch;
                    $stck['size']=$size;
                    $check=$this->Salesmodel->checkproduct($product,$branchid,$batch,$size);
                    if($check==0)
                    {
                        $stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
                    }
                    else
                    {
                        $stock=$this->Onlinemodel->updatestock($product,$size,$qty*-1,$branchid,$batch,$voucherno,$transactiontype,$date,$userid);
                    }

                }else{ echo json_encode(false);}

                $i++;
            }

            log_message('error',"sale_true");

            echo json_encode (array("masterid"=>$dat1,"customerid"=>$customerid),JSON_NUMERIC_CHECK);


        }else{ echo json_encode(false); }              


    }else{ 

        echo json_encode (array("masterid"=>$existence->result_array()[0]['salesmasterid'],"customerid"=>$existence->result_array()[0]['customerid']),JSON_NUMERIC_CHECK);

    }
}


    public function api_SalesInvoice_DayBookInsertion($invoiceNo,$status = true)
    {   $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $this->load->model('Salesmodel');
          $new = file_get_contents('php://input');
             $product = json_decode($new);
        $paidcash=$product->paidcash;
        log_message('error',$paidcash);
        $paidbank=$product->paidbank;
       
        $invoiceno=$invoiceNo;
        $total=$product->totalamount;
        $discount=$product->billdiscount;
        $grand=$product->grandtotal*1;
        $tax=0;
        $customer =$product->customerid;
        $balance =$product->balance;
       $DATE=$product->salesdatestring;
        $cash = $product->cash;
        $bank = $product->bank;
        $stock=$product->stockamount;
        $sales=$grand-$tax+$discount;
         $balance=($paidcash+$paidbank-$grand);
         if($balance>0){
             $paidcash = $paidcash - $balance;
             $balance=0;
         }
        log_message('error',$grand."-".$tax."-".$discount);
        $data2=array(); 
        //sales account
        $data2['invoiceno']=$invoiceno;
        $data2['accountType']='Sales Invoice';
        $data2['date']=$DATE;       
        $data2['ledgername']=21;
        $data2['debit']=0;
        $data2['credit']=$total;
        $data2['opposite']=$customer;
        $data2['userid']='25';
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
        if($paidbank!=0){
        $data2['ledgername']=$bank;
        $data2['debit']=$paidbank;
        $data2['credit']=0;
        $data22=$this->Onlinemodel->insert_newdaybook($data2);
         }
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
            log_message('error',$ledgername);

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
    public function flutter_insert_customer()
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
        $existence=$this->Onlinemodel->api_checkexistence_customer($code,$pho);
        if($existence->num_rows()==0)
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
            if($result==true)
            {
                $ledgervalues=$this->Onlinemodel->api_insert_customer($insertdata);
                //echo 'ledgersuccess';
                echo json_encode (array("customerid"=>$ledgervalues),JSON_NUMERIC_CHECK);
            }
        }
        else
        {
            echo json_encode (array("customerid"=>$existence->result_array()[0]['customerid']),JSON_NUMERIC_CHECK);
        }
    }


    public function flutter_insert_customer_status()
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
        $existence=$this->Onlinemodel->api_checkexistence_customer($code,$pho);
        if($existence->num_rows()==0)
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
            if($result==true)
            {
                $ledgervalues=$this->Onlinemodel->api_insert_customer($insertdata);
                if ($ledgervalues == true) {

                    echo json_encode (array("customerid"=>$ledgervalues),JSON_NUMERIC_CHECK);
                    
                }else{ echo json_encode(false);}

            }else{ echo json_encode(false);}
        }
        else
        {
            echo json_encode (array("customerid"=>$existence->result_array()[0]['customerid']),JSON_NUMERIC_CHECK);
        }
    }


     public function flutter_insert_customer_fromsales($status = true)
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
        $existence=$this->Onlinemodel->api_checkexistence_customer($code,$pho);
        if($existence->num_rows()==0)
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
                return $ledgervalues;
            }
            return 1;
        }
        else
        {
           return $existence->result_array()[0]['customerid'];
        }
    }
     public function flutter_insert_salesreturn()
    {
        $this->load->model('Salesmodel');
        $this->load->model('Onlinemodel');
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $new = file_get_contents('php://input');
        $product = json_decode($new);
        $customerid = $product->customerid;
        $DATE=$product->salesdatestring;
        $sales = $product->totalamount;
        $invoiceno =$product->invoiceno;
        $branchid= $product->branchid;
       
        $result=0;
        if($result==0)
        {
            $this->load->model('Salesmodel');
            $insertdata['invoiceno'] = $invoiceno;
            $insertdata['customerid'] = $customerid;
            $insertdata['salesmasterid'] = $product->masterid;
            $insertdata['salesdate'] = $DATE;
            $insertdata['totalqty'] = $product->totalqty;
            $insertdata['totalamount'] = $sales;
            $insertdata['additionalcost'] = $product->additionalcost;
            $insertdata['taxamount'] = $product->taxamount;
            $insertdata['billdiscount'] = $product->billdiscount;
            $insertdata['grandtotal'] = $product->grandtotal;
            $insertdata['oldbalance'] =$product->oldbalance;
            $insertdata['cash'] = $product->cash;
            $insertdata['bank'] = $product->bank;
            $insertdata['paidcash'] = $product->paidcash;
            $insertdata['paidbank'] = $product->paidbank;
            $insertdata['balance'] = $product->balance;
            $insertdata['narration'] = $product->narration;
            $insertdata['branchid'] = $branchid;    
            $insertdata['salesman'] = $product->salesman;   
            $insertdata['stockamount'] = $product->stockamount; 
            $insertdata['finyear'] =4;
            $insertdata['userid'] = $product->userid;
            $dat=$this->Salesmodel->insert_salesreturnmaster($insertdata);
            $sales=$product->grandtotal;
            $cost=$product->stockamount;
            $addpoints=($sales*-1/100);
            if($addpoints!=0)
            {
                $r=$this->Salesmodel->addpoints($dat,$customerid,$addpoints,$DATE);
            }
           
            $this->flutter_salesReturn_DayBookInsertion(false);
            $prs = $product->items;
            $i=1;
            foreach($prs as $data)
            { 
                $taxx=5;
                $taxxamount=0;
                if($data->mrp>999){
                    $taxx=12;
                }
                $taxxamount=($data->qty*$data->mrp)*$taxx/100;
                $insertdata2=array();
                $value=$invoiceno;
                $insertdata2['salesreturnid'] = $dat;
                $insertdata2['invoiceno'] = $invoiceno;
                $insertdata2['salesdate'] = $DATE;
                $insertdata2['productname'] = $data->productName;
                $insertdata2['productcode'] = $data->prdCode;
                $insertdata2['qty'] = $data->qty;
                $insertdata2['size'] = $data->sizeId;
                $insertdata2['unitprice'] = $data->mrp;
                $insertdata2['netamount'] =$data->qty*$data->mrp;
                $insertdata2['tax'] = $taxx;
                $insertdata2['finyear'] =4;
                $insertdata2['taxamount'] = $taxxamount;
                $insertdata2['amount'] = ($data->qty*$data->mrp)+$taxxamount;
                $insertdata2['branchid'] =$product->branchid;
                $insertdata2['batchid'] = 0;
                $ans=$this->Salesmodel->insert_salesreturndetails($insertdata2);
                $voucherno=$invoiceno;
                $transactiontype='Sales Return';
                $date= $DATE;
                $userid=$product->userid; 
                $branch=$product->branchid;
                $batch=0;
                $product=$data->prdCode;
                $qty=$data->qty;
                $size= $data->sizeId;
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
                $i++;
            }
        if($ans)
        {
            echo json_encode (array(array("masterid"=>$dat)),JSON_NUMERIC_CHECK); 
        }
        else 
        {
            echo json_encode (array("message"=>"false"),JSON_NUMERIC_CHECK);
        }
        }
        
    }


    public function flutter_insert_salesreturn_status()
    {
        $this->load->model('Salesmodel');
        $this->load->model('Onlinemodel');
        $d=strtotime("now");
        $date=date("Y-m-d H:i:s",$d);
        $new = file_get_contents('php://input');
        $product = json_decode($new);
        $customerid = $product->customerid;
        $DATE=$product->salesdatestring;
        $sales = $product->totalamount;
        $invoiceno =$product->invoiceno;
        $branchid= $product->branchid;

        $result=0;
        if($result==0)
        {
            $this->load->model('Salesmodel');
            $insertdata['invoiceno'] = $invoiceno;
            $insertdata['customerid'] = $customerid;
            $insertdata['salesmasterid'] = $product->masterid;
            $insertdata['salesdate'] = $DATE;
            $insertdata['totalqty'] = $product->totalqty;
            $insertdata['totalamount'] = $sales;
            $insertdata['additionalcost'] = $product->additionalcost;
            $insertdata['taxamount'] = $product->taxamount;
            $insertdata['billdiscount'] = $product->billdiscount;
            $insertdata['grandtotal'] = $product->grandtotal;
            $insertdata['oldbalance'] =$product->oldbalance;
            $insertdata['cash'] = $product->cash;
            $insertdata['bank'] = $product->bank;
            $insertdata['paidcash'] = $product->paidcash;
            $insertdata['paidbank'] = $product->paidbank;
            $insertdata['balance'] = $product->balance;
            $insertdata['narration'] = $product->narration;
            $insertdata['branchid'] = $branchid;    
            $insertdata['salesman'] = $product->salesman;   
            $insertdata['stockamount'] = $product->stockamount; 
            $insertdata['finyear'] =4;
            $insertdata['userid'] = $product->userid;
            $dat=$this->Salesmodel->insert_salesreturnmaster($insertdata);

            $sales=$product->grandtotal;
            $cost=$product->stockamount;
            $addpoints=($sales*-1/100);
            if($addpoints!=0)
            {
                $r=$this->Salesmodel->addpoints($dat,$customerid,$addpoints,$DATE);
            }

            $this->flutter_salesReturn_DayBookInsertion(false);

            if ($dat1 !== null) { 

            $prs = $product->items;
            $i=1;
            foreach($prs as $data)
            { 
                $taxx=5;
                $taxxamount=0;
                if($data->mrp>999){
                    $taxx=12;
                }
                $taxxamount=($data->qty*$data->mrp)*$taxx/100;
                $insertdata2=array();
                $value=$invoiceno;
                $insertdata2['salesreturnid'] = $dat;
                $insertdata2['invoiceno'] = $invoiceno;
                $insertdata2['salesdate'] = $DATE;
                $insertdata2['productname'] = $data->productName;
                $insertdata2['productcode'] = $data->prdCode;
                $insertdata2['qty'] = $data->qty;
                $insertdata2['size'] = $data->sizeId;
                $insertdata2['unitprice'] = $data->mrp;
                $insertdata2['netamount'] =$data->qty*$data->mrp;
                $insertdata2['tax'] = $taxx;
                $insertdata2['finyear'] =4;
                $insertdata2['taxamount'] = $taxxamount;
                $insertdata2['amount'] = ($data->qty*$data->mrp)+$taxxamount;
                $insertdata2['branchid'] =$product->branchid;
                $insertdata2['batchid'] = 0;
                $ans=$this->Salesmodel->insert_salesreturndetails($insertdata2);

                if ($ans == true ) {
                $voucherno=$invoiceno;
                $transactiontype='Sales Return';
                $date= $DATE;
                $userid=$product->userid; 
                $branch=$product->branchid;
                $batch=0;
                $product=$data->prdCode;
                $qty=$data->qty;
                $size= $data->sizeId;
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

                }else{ echo json_encode(false);}

                $i++;
            }

            log_message('error',"sale_return_true");
            echo json_encode (array(array("masterid"=>$dat)),JSON_NUMERIC_CHECK);

        }else{ echo json_encode(false); } 

        // result !=0   
        }else{ echo json_encode(false); }
        
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



    public function flutter_salesReturn_DayBookInsertion($status = true)
    {     $new = file_get_contents('php://input');
        $product = json_decode($new); 
        $invoiceno = $product->invoiceno;
        $date = $product->salesdate;
        $total = $product->totalamount;
        $balance = $product->balance;
        $discount = $product->billdiscount;
        $customer = $product->customerid;
        $grandtotal=$product->grandtotal;
        $stockamount=$product->stockamount;
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
    

}
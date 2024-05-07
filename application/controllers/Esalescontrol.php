<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Esalescontrol extends CI_Controller {

	public function __cunstruct()
	{
		parent::__cunstruct();
		$this->load->helper('form');
	    $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('session'); 
        $this->load->helper("file");
	}
	public function index()
	{
		if( $this->session->userdata('name'))
		{ 
			$this->load->view('admin/header');
		    $this->load->view('admin/index.html');
		    $this->load->view('admin/footer');
		}
		else
		{
	      $this->load->view('login.html');
	  	}
	}

	public function esalesinvoice()
	{
		$this->load->model('Esalesmodel');
		if( $this->session->userdata('name'))
    	{
			$branchid = $this->session->userdata('branch');
			$branchh=$branchid;
			$data=array();
			$data['product']=$this->Esalesmodel->getproduct();
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();	
			}
			else
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();
			}
			$data['batch']=$this->Esalesmodel->getbatch();
			$data['size']=$this->Esalesmodel->getsize();
			$data['country']=$this->Esalesmodel->getcountry();
			$data['invoiceno']=$this->Esalesmodel->Autogenerate_EInvoiceNo($branchid);
			$data['orderid']=$this->Esalesmodel->Autogenerate_orderid($branchid);
			$data['conversionrate']=$this->Esalesmodel->getconversionrate(1);
			$data['customer']=$this->Esalesmodel->getcustomer();
			$data['salesman']=$this->Esalesmodel->getsalesman1();
			$data['CashLedgers']=$this->Esalesmodel->FillCashLedgersmoaonline();
			$data['BankLedgers']=$this->Esalesmodel->FillBankLedgersmoaonline();
			// $data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
			//print_r($data['country']->result()); die();
			$this->load->view('header');
			$this->load->view('esalesinvoice',$data);
			$this->load->view('footer');
		}
		else
		{
			?>
			<script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}

	public function esalesinvoiceaed()
	{
		$this->load->model('Esalesmodel');
		if( $this->session->userdata('name'))
    	{
			$branchid = $this->session->userdata('branch');
			$branchh=$branchid;
			$data=array();
			$data['product']=$this->Esalesmodel->getproduct();
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();	
			}
			else
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();
			}
			$data['batch']=$this->Esalesmodel->getbatch();
			$data['size']=$this->Esalesmodel->getsize();
			$data['country']=$this->Esalesmodel->getcountry();
			$data['invoiceno']=$this->Esalesmodel->Autogenerate_EInvoiceNo($branchid);
			$data['orderid']=$this->Esalesmodel->Autogenerate_orderid($branchid);
			$data['conversionrate']=$this->Esalesmodel->getconversionrate(3);
			$data['customer']=$this->Esalesmodel->getcustomer();
			$data['salesman']=$this->Esalesmodel->getsalesman1();
			$data['CashLedgers']=$this->Esalesmodel->FillCashLedgersmoaonline();
			$data['BankLedgers']=$this->Esalesmodel->FillBankLedgersmoaonline();
			// $data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
			$this->load->view('header');
			$this->load->view('esalesinvoiceaed',$data);
			$this->load->view('footer');
		}
		else
		{
			?>
			<script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}

	public function esalesinvoiceusd()
	{
		$this->load->model('Esalesmodel');
		if( $this->session->userdata('name'))
    	{
			$branchid = $this->session->userdata('branch');
			$branchh=$branchid;
			$data=array();
			$data['product']=$this->Esalesmodel->getproduct();
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();	
			}
			else
			{
				$data['branch']=$this->Esalesmodel->getOnlineBranch();
			}
			$data['batch']=$this->Esalesmodel->getbatch();
			$data['size']=$this->Esalesmodel->getsize();
			$data['country']=$this->Esalesmodel->getcountry();
			$data['invoiceno']=$this->Esalesmodel->Autogenerate_EInvoiceNo($branchid);
			$data['orderid']=$this->Esalesmodel->Autogenerate_orderid($branchid);
			$data['conversionrate']=$this->Esalesmodel->getconversionrate(2);
			$data['customer']=$this->Esalesmodel->getcustomer();
			$data['salesman']=$this->Esalesmodel->getsalesman1();
			$data['CashLedgers']=$this->Esalesmodel->FillCashLedgers();
			$data['BankLedgers']=$this->Esalesmodel->FillBankLedgers();
			// $data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
			$this->load->view('header');
			$this->load->view('esalesinvoiceusa',$data);
			$this->load->view('footer');
		}
		else
		{
			?>
			<script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}

	public function Autofill_New()
	{
		$this->load->model('Esalesmodel');
		$code  = $this->input->post('b');
		$data=$this->Esalesmodel->Autofill_Productdetails_TEST_new($code);
		echo json_encode($data);
	}

	public function autogenerate_einv()
	{
		$this->load->model('Esalesmodel');
		$branchid = $this->input->get_post('branchid');
		$data=$this->Esalesmodel->Autogenerate_eInvoiceNoNew($branchid);
		echo json_encode($data);
	}

	public function insertshipping()
	{
		$this->load->model('Esalesmodel');

		$prmnt_address=$this->input->post('prmnt_address');

		if ($prmnt_address == null) {

		$customerid=$this->input->post('cus_id');
		$data1['address']=$this->input->post('ship_address');
		$data1['state']=$this->input->post('state');
		$data1['country']=$this->input->post('country');

    $a=$this->Esalesmodel->updShipcustomer($customerid,$data1);

		}else{}

		$data =array();
		$data['fullname']=$this->input->post('cus_name');
		$data['customerid']=$this->input->post('cus_id');
		$data['ecommerce_orderid']=$this->input->post('order_id');
		$data['street']=$this->input->post('ship_address');
		$data['street2']=$this->input->post('ship_address2');
		$data['mobileNo']=$this->input->post('number1');
		$data['mobileNo2']=$this->input->post('number2');
		$data['postalCode']=$this->input->post('pin');
		$data['landmark']=$this->input->post('mark');
		$data['city']=$this->input->post('city');
		$data['state']=$this->input->post('state');
		$data['country']=$this->input->post('country');

		$data = array_flip($data);

		$data = array_change_key_case($data, CASE_UPPER);

		$data = array_flip($data);

		$this->load->model('Esalesmodel');
		$data1=$this->Esalesmodel->insertshipping($data);
		echo json_encode($data1);
	}

	public function insert_ecommerce_ordermaster()
	{
		$this->load->model('Esalesmodel');

		$balance=$this->input->post('balance')*1;
		$grandtotal=$this->input->post('grandtotal')*1;

		$cp=$this->input->post('paidcash')*1;
		$bp=$this->input->post('paidbank')*1;
		$aa=$cp+$bp;
		// if($balance==0)
		// {
		// 	$status='Bank Payment';
		// }	
		// else if($balance==$grandtotal)
		// {
		// 	$status='Not Paid';
		// }
		// else if ($balance<$grandtotal) 
		// {
		// 	$status='Partially Paid';
		// }

		if($aa>=$grandtotal OR $balance==0){
			$status='Bank Payment';
		}
		else if($aa<$grandtotal AND $balance<$grandtotal){
			$status='Partially Paid';
		}
		else if($aa==0){
			$status='Not Paid';
		}
		$data=array(
		'eCommerce_no'=>$this->input->post('invoiceno'),
		'customerid'=>$this->input->post('customer'),
		'rzp_orderId'=>$this->input->post('salesorderno'),
		'date_current'=>$this->input->post('salesdate'),
		'salesman'=>$this->input->post('salesman'),
		'totalqty'=>$this->input->post('totalqty'),
		'cash_payment'=>$this->input->post('paidcash'),
		'bank_payment'=>$this->input->post('paidbank'),
		'narration'=>$this->input->post('narration'),
		'branchid'=>$this->input->post('branchid'),
		'payment_mode'=>$this->input->post('Paymentmode'),
		'totalamount'=>$this->input->post('totalamount'),
		'additionalcost'=>$this->input->post('additionalcost'),
		'taxamount'=>$this->input->post('taxamount'),
		'billdiscount'=>$this->input->post('billdiscount'),
		'grandtotal'=>$this->input->post('grandtotal'),
		'oldbalance'=>$this->input->post('oldbalance'),
		'cash'=>$this->input->post('cash'),
		'bank'=>$this->input->post('bank'),
		'status'=>$status,
		'stockamount'=>$this->input->post('totalstockamount'),
		'balance'=>$this->input->post('balance'),
		'currencyid'=>$this->input->post('currencyid'),
		'ship'=>$this->input->post('ship'),
		'userid'=>$this->session->userdata('user'),
		// 'transportcompany'=>$this->input->post('transportcompany'),
		);	
		$customerid = $this->input->get_post('customer');
        $DATE=$this->input->get_post('salesdate');
		$sales = $this->input->get_post('totalamount');
		$points = $this->input->get_post('pointredeem');	 
		$dat1=$this->Esalesmodel->insert_ecommerce_ordermaster($data);
		if($dat1)
		{
			if($points!=0)
            {
                $a=$this->Esalesmodel->redeempoints($dat1,$customerid,$points,$DATE);
            }
            $addpoints =($sales*1/100);
            if($sales!=0)
            {
                $r=$this->Esalesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
            }
		}
		echo json_encode($dat1);
	}

	public function insert_ecommerce_orderdetails()
	{   
		$this->load->model('Esalesmodel');
		$no=$this->input->post('i');
		$data=array(
		'eCommerce_no'=>$this->input->post('invoiceno'),
		'referenceno'=>$this->input->post('invoiceno')."_".$no,
		'eordermasterid'=>$this->input->post('salesmasterid'),
		'orderdate'=>$this->input->post('salesdate'),
		'productname'=>$this->input->post('productname'),
	    'productcode'=>$this->input->post('productcode'),
	    'description'=>$this->input->post('descri'),
		'qty'=>$this->input->post('qty'),
		'hsncode'=>$this->input->post('hsn'),
		'size'=>$this->input->post('size'),
		'unitprice'=>$this->input->post('mrp'),
		'status'=>0,
		'netamount'=>$this->input->post('netamount'),
		'tax'=>$this->input->post('tax'),
		'taxamount'=>$this->input->post('taxamount'),
		'amount'=>$this->input->post('amount'),
		'branchid'=>$this->input->post('branchid'),	
		'productcost'=>$this->input->post('productcost'),	
		);		 
		$ans=$this->Esalesmodel->insert_ecommerce_orderdetails($data);
		if($ans)
		{
			$branch=$this->input->post('branchid');
			$batch=$this->input->post('batchid');
			$product=$this->input->post('productcode');
			$qty=$this->input->post('qty')*-1;
			$size=$this->input->post('size');
			$stck=array();
			$stck['productid']=$product;
			$stck['currentstock']=$qty;
			$stck['branch']=$branch;
			$stck['batchid']=$batch;
			$stck['size']=$size;
			$check=$this->Esalesmodel->checkproduct($product,$branch,$batch,$size);
			if($check==0)
			{
				$stock1=$this->Esalesmodel->insertstock($stck);
			}
			else
			{
				$stock=$this->Esalesmodel->updatestock($product,$size,$qty,$branch,$batch);
			}
		}
		// $branch=$this->input->post('branchid');
		// $check=$this->Salesmodel->checkproduct($name,$size,$branch,$batch);
		// $stock=$this->Salesmodel->sales_stock($product,$size,$qty,$branch,$batch);
        echo json_encode($ans);
	}
	
	
	public function SalesInvoice_DayBookInsertion()
	{
		$this->load->model('Esalesmodel');
		//2)Inserting into Daybook_Start
		$data=array();
		$voucherno=$this->input->post('voucherno');
		$date=$this->input->post('date');
		$grand=$this->input->post('grandtotal');
		$tax=0;
		$total=$this->input->post('totalamount');
		$paidcash=$this->input->post('paidcash');
		$paidbank=$this->input->post('paidbank');
		$balance=$this->input->post('balance');
		$discount=$this->input->post('billdiscount');
		$customer=$this->input->post('customer');
		$cash=$this->input->post('cash');
		$bank=$this->input->post('bank');
		$stock=$this->input->post('stock');
		$igst=$this->input->post('igst');
		$cgst=$this->input->post('cgst');
		$sgst=$this->input->post('sgst');
		$data['records']=$this->Esalesmodel->Select_customerledger($customer);
		$ledgername=$data['records']['customeraccount'];
		$data2=array();
        //sales account
		$data2['invoiceno']=$voucherno;
		$data2['accountType']='Ecommerce Sales';
		$data2['date']=$date;
		$data2['ledgername']=21;
		$data2['debit']=0;
		$data2['userid']=$this->session->userdata('user');
		$data2['credit']=$grand+$discount-$igst-$cgst-$sgst;
		$data2['opposite']=$ledgername;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
		$data2['ledgername']=4;
		$data2['debit']=0;
		$data2['credit']=$stock;
		$data2['opposite']=21;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
		//cash account
		if($paidcash>0)
		{
			$data2['ledgername']=$cash;
			$data2['debit']=$paidcash;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//bank account
		if($paidbank>0)
		{
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
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=$abs;
			$data2['credit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//tax
		if($igst>0)
		{
			$data2['ledgername']=8;
			$data2['credit']=$igst;
			$data2['debit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		if($sgst>0)
		{
			$data2['ledgername']=7;
			$data2['credit']=$sgst;
			$data2['debit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		if($cgst>0)
		{
			$data2['ledgername']=6;
			$data2['credit']=$cgst;
			$data2['debit']=0;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		if($data22==false)
		{
			?><script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php
		}
		echo json_encode($data22);
		//Inserting into daybook_End
	}

	public function SalesInvoice_AccountInsertion()
    {
		$this->load->model('Esalesmodel');
		// $totalamount=$this->input->get_post('totalamount');
		// $tax=$this->input->get_post('tax');
		$tax=0;
		$paidcash=$this->input->get_post('paidcash');
		$paidbank=$this->input->get_post('paidbank');
		// $paymentmode=$this->input->get_post('paymentmode');
		$discount=$this->input->get_post('billdiscount');
		$grandtotal=$this->input->get_post('grandtotal')*1;
		$totalamount=$this->input->get_post('totalamount')*1;
		$stock=$this->input->get_post('stock');
		$cash=$this->input->get_post('cash');
		$bank=$this->input->get_post('bank');
		$customerid=$this->input->get_post('customer');
		$balance=$this->input->get_post('balance');
		// $sales=$grandtotal-$tax;
		// select customer ledger
		$data['records']=$this->Esalesmodel->Select_customerledger($customerid);
		$customer=$data['records']['customeraccount'];
       	$data=array();
       	$data=$this->Esalesmodel->salesaccount($totalamount,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance);
       	echo json_encode($data);
		//sales account
    }


    public function eCommerce()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->geteorder($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->geteorder1($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorder($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_order',$data);
		$this->load->view('footer');
	}


	public function eCommerceAllreports()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->Allgeteorder($cdate);
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
			$data['eorder']=$this->Esalesmodel->Allgeteorder1($fdate,$todate);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->Allgeteorder($cdate);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_Allreport',$data);
		$this->load->view('footer');
	}

	public function eCommercedetails()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		     
		$status=$this->input->get_post('status');

		$data['status']= $status;

		if ($status=="Cancel") {
			$data['eorder']=$this->Esalesmodel->geteorderdetailsofcancelled($cdate,1,$status);
		}
		else{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,1,$status);
		}
		$data['deliverystatus']=$this->Esalesmodel->getdeliverystatus();
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
			if ($status=="Cancel") {
			$data['eorder']=$this->Esalesmodel->geteorderdetailsofcancelled1($fdate,$todate,1,$status);
			}
			else{
			$data['eorder']=$this->Esalesmodel->geteorderdetails1($fdate,$todate,1,$status);
			}
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			if ($status=="Cancel") {
			$data['eorder']=$this->Esalesmodel->geteorderdetailsofcancelled($cdate,1,$status);
			}
			else{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,1,$status);
			}
			// $data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,1,$status);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_orderdetails',$data);
		$this->load->view('footer');
	}

	public function eCommercePaydetails()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		     
		$status=$this->input->get_post('status');
		$data['status']= $status;

		// $data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,1);
		
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
			if ($status == 1) {
			// Paid Orders
				$data['eorder']=$this->Esalesmodel->ecomreportbypaydate1($fdate,$todate,1);

			}elseif ($status == 2) {
				// Paid - Not Delivered
				$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered1($fdate,$todate,1);

			}elseif ($status == 3) {
				// Not Paid
				$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid1($fdate,$todate,1);
				
			}elseif ($status == 4) {
				// Cancel/Refund
				$data['eorder']=$this->Esalesmodel->ecomreportbycancelled1($fdate,$todate,1);

			// }elseif ($status  == 5) {
				// Delivered

			// }elseif ($status == 6) {
				// Return
			}else{
					$data['eorder']=$this->Esalesmodel->geteorderdetails1($fdate,$todate,1,$status);
			}
			
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,1);
		}



		$data['fdate'] =  $fdate;
		$data['tdate'] =  $tdate;

		$this->load->view('header');
		$this->load->view('ecommerce_order_payment_details',$data);
		$this->load->view('footer');
	}

	public function ecomreportbypaydate()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbypaydate1($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaydate',$data);
		$this->load->view('footer');
	}

	public function eCommercedetailsbyPaidNotDelivered()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered1($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaidnotdelivered',$data);
		$this->load->view('footer');
	}

	public function ecomreportbynotpaid()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid1($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbynotpaid',$data);
		$this->load->view('footer');
	}

	public function ecomreportbycancelled()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled1($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbycancelled',$data);
		$this->load->view('footer');
	}


	/////////////////////         AED               //////////////////

	public function eCommerceaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->geteorder($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->geteorder1($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorder($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_orderaed',$data);
		$this->load->view('footer');
	}

	public function eCommercedetailsaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$status=$this->input->get_post('status');
		$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,3,$status);
		$data['deliverystatus']=$this->Esalesmodel->getdeliverystatus();
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
			$data['eorder']=$this->Esalesmodel->geteorderdetails1($fdate,$todate,3,$status);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,3,$status);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_orderdetailsaed',$data);
		$this->load->view('footer');
	}

	public function ecomreportbypaydateaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbypaydate1($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaydateaed',$data);
		$this->load->view('footer');
	}
public function ecomproductionreport()
	{  if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Production Admin" || $this->session->userdata('role')=="Ecommerce Admin" )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomproductionreport',$data);
		$this->load->view('footer');
	 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	 }
	
	public function ecomproductionreportaed()
	{
	if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Production Admin" || $this->session->userdata('role')=="Ecommerce Admin" )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomproductionreportaed',$data);
		$this->load->view('footer');
		 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	}
	public function ecomproductionreportusd()
	{

	if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Production Admin" || $this->session->userdata('role')=="Ecommerce Admin"  )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomproductionreportusd',$data);
		$this->load->view('footer');
		 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	}
	public function ecomshipping()
	{

	if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Shipping Admin" || $this->session->userdata('role')=="Ecommerce Admin" )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,1);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,1);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,1);
		}
		$this->load->view('header');
		$this->load->view('ecomshipping',$data);
		$this->load->view('footer');
		 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	}
	public function ecomshippingaed()
	{

	if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Shipping Admin"  || $this->session->userdata('role')=="Ecommerce Admin"  )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomshippingaed',$data);
		$this->load->view('footer');
		 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	}
	public function ecomshippingusd()
	{

	if($this->session->userdata('role')=="Super Admin" ||$this->session->userdata('role')=="Shipping Admin" || $this->session->userdata('role')=="Ecommerce Admin"  )
		{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomproductionreport($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomproductionreporttoday($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomshippingaed',$data);
		$this->load->view('footer');
		 }
	 else{
	 	    ?>
				<script type="text/javascript">
				alert('permission denied');
				</script>
				<?php 
            }
	}
	public function eCommercedetailsbyPaidNotDeliveredaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered1($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaidnotdeliveredaed',$data);
		$this->load->view('footer');
	}

	public function ecomreportbynotpaidaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid1($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbynotpaidaed',$data);
		$this->load->view('footer');
	}

	public function ecomreportbycancelledaed()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,3);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled1($fdate,$todate,3);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,3);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbycancelledaed',$data);
		$this->load->view('footer');
	}


	/////////////////////         USD               //////////////////


	public function eCommerceusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->geteorder($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->geteorder1($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorder($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_orderusd',$data);
		$this->load->view('footer');
	}

	public function eCommercedetailsusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$status=$this->input->get_post('status');
		$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,2,$status);
		$data['deliverystatus']=$this->Esalesmodel->getdeliverystatus();
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
			$data['eorder']=$this->Esalesmodel->geteorderdetails1($fdate,$todate,2,$status);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->geteorderdetails($cdate,2,$status);
		}
		$this->load->view('header');
		$this->load->view('ecommerce_orderdetailsusd',$data);
		$this->load->view('footer');
	}

	public function ecomreportbypaydateusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbypaydate1($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbypaydate($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaydateusd',$data);
		$this->load->view('footer');
	}


	public function eCommercedetailsbyPaidNotDeliveredusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered1($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbyPaidNotDelivered($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbypaidnotdeliveredusd',$data);
		$this->load->view('footer');
	}

	public function ecomreportbynotpaidusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid1($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbynotpaid($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbynotpaidusd',$data);
		$this->load->view('footer');
	}

	public function ecomreportbycancelledaedusd()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$cdate = date('Y-m-d');
		$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,2);
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
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled1($fdate,$todate,2);
			$data['fdate'] =  $fdate;
			$data['tdate'] =  $tdate;
		}
		else
		{
			$data['eorder']=$this->Esalesmodel->ecomreportbycancelled($cdate,2);
		}
		$this->load->view('header');
		$this->load->view('ecomreportbycancelledusd',$data);
		$this->load->view('footer');
	}


	//////////////////////////////////////////////////////////////////
	
	public function eorder()
    {
		$this->load->model('Esalesmodel');
		$branchid = $this->session->userdata('branch');
		$branchh=$branchid;

		$data=array();
		$data['product']=$this->Esalesmodel->getproduct();
		if($this->session->userdata('role')=="Super Admin")
		{
			$data['branch']=$this->Esalesmodel->getBranch();
		}
		else
		{
			$data['branch']=$this->Esalesmodel->getUserBranch($branchid);
		}
		$c=$this->input->get_post('custid');
		$a=$this->input->get_post('masterid');
		$data['cust']=$this->Esalesmodel->getecust($c);
		$data['country']=$this->Esalesmodel->getcountry();
		$data['order']=$this->Esalesmodel->getorder($a);
		$data['nstatus']=$this->Esalesmodel->nowstatus($a);
		$data['ship']=$this->Esalesmodel->getship($c,$a);
		//print_r($data['ship']->result()); die();
		$data['paymentstatus']=$this->Esalesmodel->getpaymentstatus();
		$data['deliverystatus']=$this->Esalesmodel->getdeliverystatus();
		$data['prev_orders']=$this->Esalesmodel->getprevorders($c);


      	$this->load->view('header');
		$this->load->view('details',$data);
		$this->load->view('footer');
	}

	public function update_eorder()
	{
		$this->load->model('Esalesmodel');
		$id=$this->input->get_post('details_id');
		$description=$this->input->get_post('descri');
		$update =$this->Esalesmodel->update_eorder($description,$id);
		if($update==true)
		{
			?><script type="text/javascript">
			alert('Updated Successfully...');
			</script>
			<?php
		}
		else
		{
			?><script type="text/javascript">
			alert('Updation failed. please check the inputs!!!');
			</script><?php
		}
		$this->eCommerce();
	}
		
		
	public function getesalespay()
    {
		$this->load->model('Esalesmodel');
		$branch = $this->input->get_post('branch');
		$id = $this->input->get_post('id');
		$custid = $this->input->get_post('customerid');
		$orderno = $this->input->get_post('orderno');
		// $data['balance']=$this->Esalesmodel->Autofill_currentbalance($custid);
		// $data['eorderstatus']=$this->Esalesmodel->geteorderstatus($id,$branch);
		$data['branchledger']=$this->Esalesmodel->getbranchledger($orderno);
		echo json_encode($data);
	}
	
	
	public function upd_esalespay()
    {
		$this->load->model('Esalesmodel');
    	$id = $this->input->get_post('masterid');
		$branchid=$this->input->get_post('branch');
		$paidcash=$this->input->get_post('paidcash')*1;
		$paidbank=$this->input->get_post('paidbank')*1;
		$balance=$this->input->get_post('balance')*1;
		$discount=$this->input->get_post('newdiscount')*1;
        $date_payment='';
		if($balance==0)
		{
			$date_payment=date('Y-m-d H:i:s');
		}
		$customerid=$this->input->get_post('customerid');
		$data['records']=$this->Esalesmodel->Select_customerledger($customerid);
		$ledgername=$data['records']['customeraccount'];
		$voucherno = $this->input->get_post('voucherno');
		$status = $this->input->get_post('status');	

		$result=$this->Esalesmodel->update_esalesordermaster($paidcash,$paidbank,$id,$status,$date_payment,$discount,$balance);

		if($result)
		{
			// $cashorbank=$data['cashorbank'];
			// $data['records2']=$this->Esalesmodel->selectAccountGroup($cashorbank);
			$data2=array();
			$data2['invoiceno']=$voucherno;
			$data2['accountType']='Ecommerce Receipt';
			$data2['date']=date('Y-m-d H:i:s');
			$data2['userid']=$this->session->userdata('user');
			if($paidcash!=0)
			{
				$data2['ledgername']=$ledgername;
				$data2['debit']=0;
				$data2['credit']=$paidcash;
				$data2['opposite']=1399;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
				$data2['ledgername']=1399;
				$data2['debit']=$paidcash;
				$data2['credit']=0;
				$data2['opposite']=$ledgername;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
			}
			if($paidbank!=0)
			{
				$data2['ledgername']=$ledgername;
				$data2['debit']=0;
				$data2['credit']=$paidbank;
				$data2['opposite']=1400;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
				$data2['ledgername']=1400;
				$data2['debit']=$paidbank;
				$data2['credit']=0;
				$data2['opposite']=$ledgername;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
			}
			if($discount!=0)
			{
				$data2['ledgername']=$ledgername;
				$data2['debit']=$discount;
				$data2['credit']=0;
				$data2['opposite']=3639;
				$data22=$this->Onlinemodel->insert_newdaybook($data2);
				$data2['ledgername']=3639;
				$data2['debit']=0;
				$data2['credit']=$discount;
				$data2['opposite']=$ledgername;
				$data22=$this->Onlinemodel->insert_newdaybook($data2);
			}
			
		}
		echo json_encode($result);
	}

	public function update_eorderstatus()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$data['status']=$this->input->get_post('status');
		$id=$this->input->get_post('id');
		echo $id;
		$update =$this->Esalesmodel->update_eorderstatus($data,$id);
		if($update==true)
		{
			?><script type="text/javascript">
			alert('Status Updated Successfully...');
			</script>
			<?php
		}
		else
		{
			?><script type="text/javascript">
			alert('Updation failed. please check the inputs!!!');
			</script><?php
		}
		$this->eCommerce();
	}
	public function return_eorderitem()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$data['status']=$this->input->get_post('status');
		$id=$this->input->get_post('detailsid');
		
		$update =$this->Esalesmodel->return_eorderitem($data,$id);
		if($update==true)
		{
			?><script type="text/javascript">
			alert('Return Updated Successfully...');
			</script>
			<?php
		}
		else
		{
			?><script type="text/javascript">
			alert('Return Updation failed.!!!');
			</script><?php
		}
		$this->eCommerce();
	}

    public function update_detailstatus()
	{
		$this->load->model('Esalesmodel');
		$data=array();
		$data['status']=$this->input->get_post('status');
		if($data['status']=="Delivered"){
			$data['date_delivery']=date("Y-m-d H:i:s");
		}
		$data['description']=$this->input->get_post('description');
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
	
	public function getecustmer()
    {
		$this->load->model('Esalesmodel');
    	$masterid = $this->input->get_post('masterid');
		$custid = $this->input->get_post('customerid');
		$data['balance']=$this->Esalesmodel->Autofill_currentbalance($custid);
		$data['custdetails']=$this->Esalesmodel->Autofill_custdetails($custid,$masterid);
		echo json_encode($data);
	}
	
	
	public function upd_ecustmer()
    {   
		$this->load->model('Esalesmodel');
    	$data['fullname'] = $this->input->get_post('name');
    	$data['street'] = $this->input->get_post('address');
    	$data['street2'] = $this->input->get_post('address2');
    	$data['mobileNo'] = $this->input->get_post('phone_number');
    	$data['mobileNo2'] = $this->input->get_post('phone_number2');
    	$data['postalCode'] = $this->input->get_post('pin_code');
    	$data['landmark'] = $this->input->get_post('land_mark');
    	$data['city'] = $this->input->get_post('city');
    	$data['state'] = $this->input->get_post('state');
    	$data['country'] = $this->input->get_post('country');

		$data = array_flip($data);
  
$data = array_change_key_case($data, CASE_UPPER);
  
$data = array_flip($data);

    	$masterid = $this->input->get_post('detailsid');
		$cusid=$this->input->get_post('customerid');
		$result=$this->Esalesmodel->update_ecustmer($cusid,$masterid,$data);
		if($result)
		{	
			?>
			<script>alert("Successfully");</script>
			<?php	
		}
		else
		{
			?>
			<script>alert("Please Try Again");</script>
			<?php
		}
		echo json_encode($result);
	}

	public function add_customer(){
		$this->load->model('Esalesmodel');
		$this->load->model('Onlinemodel');



		$data['customername']=$this->input->get_post('customer_name');
		$data['customercode']=$this->input->get_post('customer_mobile');
		$data['address']='';
		$data['email']='';
		$data['phonenumber']=$this->input->get_post('customer_mobile');
		$data['website']='';
		$data['state']='';
		$data['country']='';
		$data['vatno']='';
		$data['crlimit']=0;
		$data['openingbalance']=0;
		$data['customerbalance']=0;
		$data['branchid']='1';
		//$this->Esalesmodel->add_customer($data);


		$code = $data['phonenumber'];
		$pho = $data['phonenumber'];



		$existence=$this->Onlinemodel->checkexistence_customer($code,$pho);
			if($existence==0)
			{
				//Ledger Insertion_start
				$data2=array();
				$data2['ledgername']=$pho;
				$data2['accountgroup']='17';
				$data2['interestcalculation']=0;
				$data2['openingbalance']=0;
				$data2['creditordebit']='Dr';
				$data2['rootid']='1';
				$data2['narration']='Autogenerated for Customer';
				$data2['currentbalance']=0;
				$value2=$data2['ledgername'];
				$result=$this->Onlinemodel->insert_accountledger($data2);
				$data['customeraccount']=$result;
				if($result=true)
				{
					$ledgervalues=$this->Onlinemodel->insert_customer($data);
					// echo 'ledgersuccess';
					if($ledgervalues!=true)
					{
						?><script type="text/javascript">alert('Error in Ledger creation........');</script> <?php 
					}
					
					//Ledger Insertion_End
					
					?><script type="text/javascript">alert('Saved successfully........');</script> <?php 
				}
				else
				{
					?> <script type="text/javascript">alert('Insertion failed. please check the inputs!!!');</script> <?php 
				}
			}
			else 
			{
				?> <script type="text/javascript">alert('Customer already exists!!!. please use another Number');</script> <?php
			}

	}


	// ****************************Delete Order**********************************


	


	  public function eorder_delete()
    {
		$invoiceno=$this->input->get_post('name');
		$eorder_master = $this->Esalesmodel->get_order_master($invoiceno);
		$product_details = $this->Esalesmodel->get_product_details($invoiceno);



     	$this->Esalesmodel->delete_salesinvoicemaster($invoiceno);
     	$this->Esalesmodel->delete_shipping_address($invoiceno);
     	// $a="df";
     
     
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
     	
     	foreach ($product_details as $key => $value) {
     		$p_id = $value['productcode'];
     		$size = $value['size'];
     		$qty = $value['qty'];
     		$branch = $value['branchid'];
     		$batch = $value['batchid'];
		$stock=$this->Esalesmodel->updatestock($p_id,$size,$qty,$branch,$batch);

     	}

		foreach ($eorder_master as $key => $value) {
			$voucherno = $value['eCommerce_no'];
		$originalDate = $value['date_current'];
		$total=$value['totalamount'];
		$customer = $value['customerid'];
		$customer = $value['customerid'];
		$stock = $value['stockamount'];
		$cash = $value['cash'];
		$paidcash = $value['cash_payment'];
		$bank = $value['bank'];
		$paidbank = $value['bank_payment'];
		$discount = $value['billdiscount']*1;
		$tax = $value['taxamount'] *1;
$newDate = date("Y-m-d H:i:s",strtotime($originalDate."+1 minutes")); 
		$data=array();
		$grand=$value['grandtotal']*1;
		$balance=$value['balance'];
		$sales=$grand-$tax+$discount;
		$data2=array();
		//sales account
		$data2['invoiceno']=$voucherno;
		$data2['accountType']='Ecommerce Delete';
		$data2['date']=$newDate;
		$data2['ledgername']=21;
		$data2['debit']=$total;
		$data2['credit']=0;
		$data2['userid']=$this->session->userdata('user');
		$data2['opposite']=$customer;

		$data22=$this->Esalesmodel->insert_newdaybook($data2);

		//stock account
		$data2['ledgername']=4;
		$data2['debit']=$stock;
		$data2['credit']=0;
		$data2['opposite']=21;
		$data22=$this->Esalesmodel->insert_newdaybook($data2);

		//cash account
		$data2['ledgername']=$cash;
		$data2['debit']=0;
		$data2['credit']=$paidcash;
		$data22=$this->Esalesmodel->insert_newdaybook($data2);

		//bank account
		$data2['ledgername']=$bank;
		$data2['debit']=0;
		$data2['credit']=$paidbank;
		$data22=$this->Esalesmodel->insert_newdaybook($data2);

		//cost of sales
		$data2['ledgername']=22;
		$data2['debit']=0;
		$data2['credit']=$stock;
		$data22=$this->Esalesmodel->insert_newdaybook($data2);

		//discount of sales
		if($discount>0)
		{
			$data2['ledgername']=28;
			$data2['debit']=0;
			$data2['credit']=$discount;
			$data22=$this->Esalesmodel->insert_newdaybook($data2);
		}
		//customer
		if($balance<0)
		{
			$data['records']=$this->Esalesmodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=0;
			$data2['credit']=$abs;
			$data22=$this->Esalesmodel->insert_newdaybook($data2);
		}
		//tax
		if($tax>0)
		{
			$data2['ledgername']=23;
			$data2['debit']=0;
			$data2['credit']=$tax;
			$data22=$this->Esalesmodel->insert_newdaybook($data2);
		}
		if($data22==false)
		{
			?><script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php 
		}
		// echo json_encode($data22);
		//Inserting into daybook_End

		}
			redirect($this->config->item('base_url').'/Esalescontrol/eCommerce');


	 	
	}
     
      
    //account insertion


	// ****************************Delete Order**********************************

}
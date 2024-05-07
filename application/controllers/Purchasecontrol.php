<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchasecontrol extends CI_Controller {

	public function __cunstruct()
	{
		parent::__cunstruct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('session'); 
		$this->load->helper('form');
		$this->load->model('Purchasemodel');
	}

	/////////////////////////  Purchase Invoice  ///////////////////////////

	public function insertdetailes($currency)
	{

		date_default_timezone_set('Asia/Kolkata');
		$data=array(
			'voucherno'=>$this->input->post('voucherno'),
		 	'suppliername'=>$this->input->post('supplier'),
		 	'orderno'=>$this->input->post('order'),
		 	'vendorinvoiceno'=>$this->input->post('vendor'),
		 	'invoicedate'=>$this->input->post('date')." ".date("H:i:s"),
		 	'paymentmode'=>$this->input->post('payment'),
		 	'narration'=>$this->input->post('narration'),
		    'transportcompany'=>$this->input->post('company'),
		 	'totalqty'=>$this->input->post('totalqty'),
		 	'totalamount'=>$this->input->post('totalamount'),
		 	'additionalcost'=>$this->input->post('additionalcost'),
		 	'taxamount'=>$this->input->post('tax'),
		 	'billdiscount'=>$this->input->post('discount'),
		 	'branchid'=>$this->input->post('branch'),
		 	'grandtotal'=>$this->input->post('total'),
		 	'oldbalance'=>$this->input->post('oldbalance'),
			'cash'=>$this->input->post('cash'),
			'bank'=>$this->input->post('bank'),
			'paidcash'=>$this->input->post('paidcash'),
			'paidbank'=>$this->input->post('paidbank'),
		 	'balance'=>$this->input->post('balance'),
			'userid'=>$this->session->userdata('user'),
			'withtax'=>$this->input->post('withtax'),
			'igst'=>$this->input->post('igst'),
			'imagepath'=>$this->input->post('imagepath'),
			'currency_id'=>$currency
			 );	 		 
		$this->load->model('Purchasemodel');
		$data=$this->Purchasemodel->insertdetailes($data);
		// $data=$this->Onlinemodel->save_product($data);

		return $data;

        // echo $data ? json_encode(array("message"=>$data),JSON_NUMERIC_CHECK):'';

        // echo json_encode($data);
	}

	// public function purchasestock()
	// {
    // 	$branch=$this->input->post('branch');		
	// 	$name=$this->input->post('productcode');
	// 	$size =$this->input->post('size');
	// 	$qty=$this->input->post('qty');
	// 	$batch=$this->input->post('batch');
	// 	$check=$this->Purchasemodel->checkproduct($name,$size,$branch,$batch);
	// 	if($check>0)
	// 	{
	// 		$stock=$this->Onlinemodel->updatestock($name,$size,$qty,$branch,$batch);
	// 	}
	// 	else
	// 	{
	// 		$stck=array();
	// 		$stck['productid']=$name;
	// 		$stck['size']=$size;
	// 		$stck['currentstock']=$qty;
	// 		$stck['branch']=$branch;
	// 		$stck['batchid']=$batch;
	// 		$stock1=$this->Onlinemodel->insertstock($stck);
	// 	}

	// 	echo json_encode($check);
    // } 
	public function loadpurchaseinvoice()
	{
		$vouch=$this->input->get_post('voucherno');
		$data=array();
			      				// echo current_url();
		$data['master']=$this->Onlinemodel->get_purmaster1($vouch);
		$data['detailes']=$this->Onlinemodel->get_purdetailes1($vouch);
		echo json_encode($data);
	}
	
	public function loadpurchasereturninvoice()
	{
		$vouch=$this->input->get_post('voucherno');
		$data=array();
      				// echo current_url();
		$data['master']=$this->Onlinemodel->get_purretmaster1($vouch);
		$data['detailes']=$this->Onlinemodel->get_purretdetailes1($vouch);
		echo json_encode($data);
	}

	public function inserttable()
	{
		date_default_timezone_set('Asia/Kolkata');
		//$name=$this->input->post('productname');
		$code=$this->input->post('productcode');
		//$pdt=$this->Onlinemodel->checkexistence_product2($name,$code);
		$data['voucherno']=$this->input->post('voucherno');
		$data['invoicedate']=$this->input->post('invoicedate')." ".date("H:i:s");
		$data['productname']=$this->input->post('productname');
		$data['productcode']=$this->input->post('productcode');
		$data['hsncode']=$this->input->post('hsncode');
		$data['qty']=$this->input->post('qty');
		$data['size']=$this->input->post('size');
		$data['unitprice']=$this->input->post('unitprice');
		$data['netamount']=$this->input->post('netamount');
		$data['tax']=$this->input->post('tax');
		$data['taxamount']=$this->input->post('taxamount');
		$data['amount']=$this->input->post('amount');
		$data['batchid']=$this->input->post('batch');
		$data['purchasemasterid']=$this->input->post('purchasemasterid');
		$data1=$this->Purchasemodel->insertpurchasegrid($data);
		$branch=$this->input->post('branch');		
		$name=$this->input->post('productcode');
		$voucherno=$data['voucherno'];
    	$transactiontype='Purchase Invoice';
    	$date=$this->input->post('invoicedate')." ".date("H:i:s");
    	$userid=$this->session->userdata('user');
		$size =$this->input->post('size');
		$qty=$this->input->post('qty');
		$batch=$this->input->post('batch');
		$sizes =preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($sizes as $a) 
		{
			$qnty =0;
			$vars = explode('.', $a);
			$size1 = $vars[0];
			$size11=$this->Onlinemodel->checksize($size1);
			$size1=$size11['sizeid'];
			if(is_null($size1))
			{
				$size1 ='0';
			}
			if(count($vars) == 2 )
			{
				$qnty = $vars[1];
			}
			else
			{
				$qnty=1;
			}
			$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
			if($check>0)
			{
				$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
			}
			else
			{
				$stck=array();
		        $stck['productid']=$name;
		        $stck['size']=$size1;
		        $stck['currentstock']=$qnty;
		        $stck['branch']=$branch;
		        $stck['batchid']=$batch;
				$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
			}
		}
		echo json_encode($size1);
	}

	public function inserttable_push()
	{
		$this->db->trans_start();

		$d=strtotime("now");
		$date=date("Y-m-d H:i:s",$d);

		$currency=$this->Onlinemodel->checkcurrency($this->input->get_post('branch'));

		$purchasemasterid = $this->insertdetailes($currency);

		$prs = $this->input->get_post('orderItems');
		$i=1;
		foreach($prs as $data)
		{ 
			$insertdata2['voucherno'] = $data["voucherno"];
			$insertdata2['invoicedate'] = $date;
			$insertdata2['productname'] = $data["productname"];
			$insertdata2['productcode'] =  $data["productcode"];
			$insertdata2['hsncode'] =   $data["hsncode"];
			$insertdata2['qty'] =   $data["qty"];
			$insertdata2['size'] =   $data["size"];
			$insertdata2['unitprice'] =   $data["unitprice"];
			$insertdata2['netamount'] =   $data["netamount"];
			$insertdata2['tax'] =   $data["tax"];
			$insertdata2['taxamount'] =   $data["taxamount"];
			$insertdata2['amount'] =   $data["amount"];
			$insertdata2['batchid'] =   $data["batch"];
			$insertdata2['purchasemasterid'] =  $purchasemasterid;

			$data1=$this->Purchasemodel->insertpurchasegrid($insertdata2);

			$branch=$data["branch"];	
			$name=$data["productcode"];
			$voucherno=$data['voucherno'];
			$transactiontype='Purchase Invoice';
			$date=$date;
			$userid=$this->session->userdata('user');
			$size =$data["size"];

			$qty= $data["qty"];
			$batch=$data["batch"];

			$sizes =preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);

			foreach ($sizes as $a) 
			{
				$qnty =0;
				$vars = explode('.', $a);
				$size1 = $vars[0];
				$size11=$this->Onlinemodel->checksize($size1);
				$size1=$size11['sizeid'];

				// $size1 = isset($size11['sizeid']);
				if(is_null($size1))
				{
					$size1 ='0';
				}
				if(count($vars) == 2 )
				{
					$qnty = $vars[1];
				}
				else
				{
					$qnty=1;
				}
				$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
				if($check>0)
				{
					$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
				}
				else
				{
					$stck=array();
					$stck['productid']=$name;
					$stck['size']=$size1;
					$stck['currentstock']=$qnty;
					$stck['branch']=$branch;
					$stck['batchid']=$batch;
					$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
				}
			}
		}

		$dybuk = $this->PurchaseInvoice_DyaBookInsertion();

		$this->db->trans_complete();

		log_message("error",$this->db->trans_status() );

		if($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();

		}else{
			$this->db->trans_complete();
		}

		
		echo json_encode($dybuk);
	}

	public function auto_purchase_table()
	{

		$d=strtotime("now");
		$date=date("Y-m-d H:i:s",$d);

		$data=$this->Purchasemodel->Autogenerate_PurchaseVoucherNo();

		foreach ($data as $row) {
			$newvoucherno = $row->NO;
		}

		$invoice= 0;

      	$datamaster=$this->Onlinemodel->get_purmaster1($invoice);

      	foreach ($datamaster as $row) {
      		$insertdata['voucherno'] = $newvoucherno;
      		$insertdata['suppliername'] = $row->suppliername;
      		$insertdata['orderno'] = $row->orderno;
      		$insertdata['vendorinvoiceno'] = $row->vendorinvoiceno;
      		$insertdata['invoicedate'] = $date;
      		$insertdata['paymentmode'] = $row->paymentmode;
      		$insertdata['narration'] = $row->narration;
      		$insertdata['transportcompany'] = $row->transportcompany;
      		$insertdata['totalqty'] = $row->totalqty;
      		$insertdata['totalamount'] = $row->totalamount;
      		$insertdata['additionalcost'] = $row->additionalcost;
      		$insertdata['taxamount'] = $row->taxamount;
      		$insertdata['billdiscount'] = $row->billdiscount;
      		$insertdata['branchid'] = $row->branchid;
      		$insertdata['grandtotal'] = $row->grandtotal;
      		$insertdata['oldbalance'] = $row->oldbalance;
      		$insertdata['cash'] = $row->cash;
      		$insertdata['bank'] = $row->bank;
      		$insertdata['paidbank'] = $row->paidbank;
      		$insertdata['paidcash'] = $row->paidcash;
      		$insertdata['balance'] = $row->balance;
      		$insertdata['userid'] = $row->userid;
      		$insertdata['withtax'] = $row->withtax;
      		$insertdata['igst'] = $row->igst;
      		$insertdata['imagepath'] = $row->imagepath;

      		$this->load->model('Purchasemodel');
      		$masterid=$this->Purchasemodel->insertdetailes($insertdata);

         	$this->purchase_DayBookInsertion($datamaster,$newvoucherno,false);


      		$datadetails=$this->Onlinemodel->get_purdetailes($invoice);

      		foreach ($datadetails->result() as $key) {

      			$insertdtls['voucherno'] = $newvoucherno;
      			$insertdtls['invoicedate'] = $date;
      			$insertdtls['productname'] = $key->productname;
      			$insertdtls['productcode'] = $key->productcode;
      			$insertdtls['hsncode'] = $key->hsncode;
      			$insertdtls['qty'] = $key->qty;
      			$insertdtls['unitprice'] = $key->unitprice;
      			$insertdtls['netamount'] = $key->netamount;
      			$insertdtls['tax'] = $key->tax;
      			$insertdtls['taxamount'] = $key->taxamount;
      			$insertdtls['amount'] = $key->amount;
      			$insertdtls['batchid'] = $key->batchid;
      			$insertdtls['size'] = $key->size;
      			$insertdtls['purchasemasterid'] = $masterid;

      			$insert=$this->Purchasemodel->insertpurchasegrid($insertdtls);

      			$branch=$row->branchid;
      			$name=$key->productcode;
      			$voucherno=$newvoucherno;
      			$transactiontype='Purchase Invoice';
      			$date=$date;
      			$userid=$this->session->userdata('user');
      			$size = $key->size;

      			$qty= $key->qty;
      			$batch= $key->batchid;

      			$sizes =preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);

      			foreach ($sizes as $a) 
      			{
      				$qnty =0;
      				$vars = explode('.', $a);
      				$size1 = $vars[0];
      				$size11=$this->Onlinemodel->checksize($size1);
      				$size1=$size11['sizeid'];
      				if(is_null($size1))
      				{
      					$size1 ='0';
      				}
      				if(count($vars) == 2 )
      				{
      					$qnty = $vars[1];
      				}
      				else
      				{
      					$qnty=1;
      				}
      				$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
      				if($check>0)
      				{
      					$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
      				}
      				else
      				{
      					$stck=array();
      					$stck['productid']=$name;
      					$stck['size']=$size1;
      					$stck['currentstock']=$qnty;
      					$stck['branch']=$branch;
      					$stck['batchid']=$batch;
      					$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
      				}
      			}


      		}
      		//end details

      	}
		//end master




	}


	public function purchase_DayBookInsertion($datamaster,$newvoucherno,$status = true)
	{  
		$d=strtotime("now");
		$date=date("Y-m-d H:i:s",$d);

		foreach ($datamaster as $row) {

		$a=$row->suppliername;
		//2)Inserting into Daybook_Start
		$data=array();
		$total=$row->totalamount;
		$data2=array();	
		//cash	
        $data2['invoiceno']=$newvoucherno;
		$data2['accountType']='Purchase Invoice';
		$data2['date']=$date;
		$data2['userid']=$this->session->userdata('user');
		$data2['ledgername']=$row->cash;
		$data2['debit']=0;
		$data2['credit']=$row->paidcash;
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//bank
		// $data3['date']=$this->input->post('date');
		$data2['ledgername']=$row->bank;
		$data2['debit']=0;
		$data2['credit']=$row->paidbank;
		$data2['userid']=$this->session->userdata('user');
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//stock
		$data2['ledgername']=4;
		$data2['debit']=$total;
		$data2['credit']=0;
		$data2['opposite']=$a;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//tax
		$data2['ledgername']=5;
		$data2['debit']=$row->taxamount;
		$data2['credit']=0;
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//discount
		$discount=$row->billdiscount;
		if($discount>0)
		{
			$data2['ledgername']=1;
			$data2['debit']=0;
			$data2['credit']=$row->billdiscount; 
			//balancedya
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		$balance= $row->balance; 
		if($balance<0)
		{
			$data2['ledgername']=$a;
			$data2['debit']=0;
			$data2['credit']=($balance*-1);
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		// $a=$this->input->post('discount');
		if($data2==false)
		{
			?> <script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php 
		}

	}
        echo $status ? json_encode(array("message"=>$data2),JSON_NUMERIC_CHECK):"";
		//Inserting into daybook_End
	}


	public function Autogenerate_PurchaseVoucherNo()
	{
		$data=$this->Purchasemodel->Autogenerate_PurchaseVoucherNo();
		echo json_encode($data);
	}

	public function Autogenerate_PurchaseRetVoucherNo()
	{
		$data=$this->Purchasemodel->Autogenerate_PurchaseRetVoucherNo();
		echo json_encode($data);
	}
	
	//PurchaseInvoice_DyaBook_Insertion_Start

	public function PurchaseInvoice_DyaBookInsertion()
	{ 
		$a=$this->input->post('supplier');
		//2)Inserting into Daybook_Start
		$data=array();
		$total=$this->input->post('totalamount');
		$data2=array();	
		//cash	
        $data2['invoiceno']=$this->input->post('voucherno');
		$data2['accountType']='Purchase Invoice';
		$data2['date']=$this->input->post('date')." ".date("H:i:s");
		$data2['userid']=$this->session->userdata('user');
		$data2['ledgername']=$this->input->post('cash');
		$data2['debit']=0;
		$data2['credit']=$this->input->post('paidcash');
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//bank
		// $data3['date']=$this->input->post('date');
		$data2['ledgername']=$this->input->post('bank');
		$data2['debit']=0;
		$data2['credit']=$this->input->post('paidbank');
		$data2['userid']=$this->session->userdata('user');
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//stock
		$data2['ledgername']=4;
		$data2['debit']=$total;
		$data2['credit']=0;
		$data2['opposite']=$a;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//tax
		$data2['ledgername']=5;
		$data2['debit']=$this->input->post('tax');
		$data2['credit']=0;
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//discount
		$discount=$this->input->post('discount');
		if($discount>0)
		{
			$data2['ledgername']=1;
			$data2['debit']=0;
			$data2['credit']=$this->input->post('discount');
			//balancedya
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		$balance=$this->input->post('balance');
		if($balance<0)
		{
			$data2['ledgername']=$a;
			$data2['debit']=0;
			$data2['credit']=($balance*-1);
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		// $a=$this->input->post('discount');
		if($data2==false)
		{
			?> <script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php 
		}
		echo json_encode($data2);
		//Inserting into daybook_End
	}
	

	// public function PurchaseInvoice_AccountInsertion()
	// {
	// 	$this->load->model('Purchasemodel');
	// 	$PurchaseDiscount = $this->input->post('PurchaseDiscount');
	// 	$TotalTaxAmt = $this->input->post('TotalTaxAmt');
	// 	$qty = $this->input->post('qty');
	// 	$unitprice = $this->input->post('unitprice');
	// 	$mrp = $this->input->post('mrp');
	// 	$TotalPurchasedStockAmount = $this->input->post('TotalPurchasedStockAmount');
	// 	$balance = $this->input->post('balance');
	// 	//fetching supplieraccount using Supplierid.
	// 	$data=array();
	// 	$supplierid= $this->input->get_post('supplierid');
	// 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
	// 	// echo $data['records']['supplieraccount'];                       
	// 	$Supplieraccount=$data['records']['supplieraccount'];
	// 	$cash=$this->input->post('cash');
	// 	$data['records2']=$this->Onlinemodel->selectAccountGroup($cash);
	// 	$bank=$this->input->post('bank');
	// 	$data['records3']=$this->Onlinemodel->selectAccountGroup($bank);
	// 	// echo $data['records2']['accountgroup'],
	// 	$accountgroupid=18;
	// 	// $accountgroupid=$data['records2']['accountgroup'];
	// 	$CashAccountAmt=0;
	// 	$BankAccountAmt=0;
	// 	$paidcash=$this->input->post('paidcash');
	// 	$paidbank=$this->input->post('paidbank');
	// 	if($balance>0)
	// 	{
	// 		$CashAccountAmt=$paidcash-$balance;
	// 	}
	// 	elseif($balance<0)
	// 	{
	// 		$CashAccountAmt=$paidcash;
	// 	}
	// 	$BankAccountAmt =$paidbank;
	// 	// echo $PurchaseDiscount,0;
	// 	$data=$this->Purchasemodel->PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,$TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$bank,$cash);
	// 	echo json_encode($data);
	// }
	
	
	//////////////////////// Purchase Invoice ///////////////////////
	
	
	/////////////////////// Purchase Return /////////////////////////
	
	public function insertreturndetailes()
	{
		date_default_timezone_set('Asia/Kolkata');
		$data=array(
			'voucherno'=>$this->input->post('voucherno'),
		 	'suppliername'=>$this->input->post('supplier'),
		 	'orderno'=>$this->input->post('order'),
		 	'vendorinvoiceno'=>$this->input->post('vendor'),
		 	'invoicedate'=>$this->input->post('date')." ".date("H:i:s"),
		 	'paymentmode'=>$this->input->post('payment'),
		 	'narration'=>$this->input->post('narration'),
		    'transportcompany'=>$this->input->post('company'),
		 	'totalqty'=>$this->input->post('totalqty'),
		 	'totalamount'=>$this->input->post('totalamount'),
		 	'additionalcost'=>$this->input->post('additionalcost'),
		 	'taxamount'=>$this->input->post('tax'),
		 	'billdiscount'=>$this->input->post('discount'),
		 	'branchid'=>$this->input->post('branch'),
		 	'grandtotal'=>$this->input->post('total'),
		 	'oldbalance'=>$this->input->post('oldbalance'),
			'cash'=>$this->input->post('cash'),
			'bank'=>$this->input->post('bank'),
			'paidcash'=>$this->input->post('paidcash'),
			'paidbank'=>$this->input->post('paidbank'),
		 	'balance'=>$this->input->post('balance'),
			'userid'=>$this->session->userdata('user')
			 );	 		 
		$this->load->model('Purchasemodel');
		$data=$this->Purchasemodel->insertreturndetailes($data);
		// $data=$this->Onlinemodel->save_product($data);
        echo json_encode($data);
	}

	// public function purchaseretstock()
	// {
    // 	$branch=$this->input->post('branch');		
	// 	$name=$this->input->post('productcode');
	// 	$size =$this->input->post('size');
	// 	$qty=$this->input->post('qty')*-1;
	// 	$batch=$this->input->post('batch');
	// 	$check=$this->Purchasemodel->checkproduct($name,$size,$branch,$batch);
	// 	$voucherno=$data['voucherno'];
	// 	$transactiontype='Purchase Return';
	// 	$date=$this->input->post('date')." ".date("H:i:s");
	// 	$userid=$this->session->userdata('user');
	// 	if($check>0)
	// 	{
	// 		$stock=$this->Onlinemodel->updatestock($name,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
	// 	}
	// 	else
	// 	{
	// 		$stck=array();
	// 		$stck['productid']=$name;
	// 		$stck['size']=$size;
	// 		$stck['currentstock']=$qty;
	// 		$stck['branch']=$branch;
	// 		$stck['batchid']=$batch;
	// 		$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
	// 	}

	// 	echo json_encode($check);
    // } 

	public function insertreturntable()
	{
		date_default_timezone_set('Asia/Kolkata');
		//$name=$this->input->post('productname');
		$code=$this->input->post('productcode');
		//$pdt=$this->Onlinemodel->checkexistence_product2($name,$code);
		$data['voucherno']=$this->input->post('voucherno');
		$data['invoicedate']=$this->input->post('invoicedate')." ".date("H:i:s");
		$data['productname']=$this->input->post('productname');
		$data['productcode']=$this->input->post('productcode');
		$data['hsncode']=$this->input->post('hsncode');
		$data['qty']=$this->input->post('qty');
		$data['size']=$this->input->post('size');
		$data['unitprice']=$this->input->post('unitprice');
		$data['netamount']=$this->input->post('netamount');
		$data['tax']=$this->input->post('tax');
		$data['taxamount']=$this->input->post('taxamount');
		$data['amount']=$this->input->post('amount');
		$data['batchid']=$this->input->post('batch');
		$data['purchasereturnid']=$this->input->post('purchasereturnid');
		$data1=$this->Purchasemodel->insertreturntable($data);
		$branch=$this->input->post('branch');		
		$name=$this->input->post('productcode');
		$size =$this->input->post('size');
		$qty=$this->input->post('qty')*-1;
		$batch=$this->input->post('batch');
		$voucherno=$data['voucherno'];
		$transactiontype='Purchase Return';
		$date=$this->input->post('invoicedate')." ".date("H:i:s");
		$userid=$this->session->userdata('user');
		$sizes =preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($sizes as $a) 
		{
			$qnty =0;
			$vars = explode('.', $a);
			$size1 = $vars[0];
			$size11=$this->Onlinemodel->checksize($size1);
			$size1=$size11['sizeid'];
			if(is_null($size1))
			{
				$size1 ='0';
			}
			if(count($vars) == 2 )
			{
				$qnty = $vars[1];
			}
			else
			{
				$qnty=1;
			}
			$qnty=$qnty*-1;
			$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
			if($check>0)
			{
				$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
			}
			else
			{
				$stck=array();
		        $stck['productid']=$name;
		        $stck['size']=$size1;
		        $stck['currentstock']=$qnty;
		        $stck['branch']=$branch;
		        $stck['batchid']=$batch;
				$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
			}
		}
		echo json_encode($size1);
	}
	
	//PurchaseInvoice_DyaBook_Insertion_Start

	public function PurchaseReturn_DyaBookInsertion()
	{ 
		date_default_timezone_set('Asia/Kolkata');
		$a=$this->input->post('supplier');
		//2)Inserting into Daybook_Start
		$data=array();
		$total=$this->input->post('totalamount');
		$data2=array();	
		//cash	
        $data2['invoiceno']=$this->input->post('voucherno');
		$data2['accountType']='Purchase Return';
		$data2['date']=$this->input->post('date')." ".date("H:i:s");
		$data2['ledgername']=$this->input->post('cash');
		$data2['debit']=$this->input->post('paidcash');
		$data2['credit']=0;
		$data2['userid']=$this->session->userdata('user');
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//bank
		$data3['invoiceno']=$this->input->post('voucherno');
		$data3['accountType']='Purchase Return';
		$data3['date']=$this->input->post('date')." ".date("H:i:s");
		$data3['ledgername']=$this->input->post('bank');
		$data3['debit']=$this->input->post('paidbank');
		$data3['credit']=0;
		$data2['userid']=$this->session->userdata('user');
		$result=$this->Onlinemodel->insert_newdaybook($data3);
		//stock
		$data2['ledgername']=4;
		$data2['debit']=0;
		$data2['credit']=$total;
		$data2['opposite']=$a;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//tax
		$data2['ledgername']=5;
		$data2['debit']=0;
		$data2['credit']=$this->input->post('tax');
		$data2['opposite']=4;
		$result=$this->Onlinemodel->insert_newdaybook($data2);
		//discount
		$discount=$this->input->post('discount');
		if($discount>0)
		{
			$data2['ledgername']=1;
			$data2['debit']=$this->input->post('discount');
			$data2['credit']=0;
			//balancedya
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		$balance=$this->input->post('balance');
		if($balance<0)
		{
			$data2['ledgername']=$a;
			$data2['debit']=($balance*-1);
			$data2['credit']=0;
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		// $a=$this->input->post('discount');
		if($data2==false)
		{
			?> <script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php 
		}
		echo json_encode($data2);
		//Inserting into daybook_End
	}
	

	// public function PurchaseReturn_AccountInsertion()
	// {
	// 	$this->load->model('Purchasemodel');
	// 	$PurchaseDiscount = $this->input->post('PurchaseDiscount');
	// 	$TotalTaxAmt = $this->input->post('TotalTaxAmt');
	// 	$qty = $this->input->post('qty');
	// 	$unitprice = $this->input->post('unitprice');
	// 	$mrp = $this->input->post('mrp');
	// 	$TotalPurchasedStockAmount = $this->input->post('TotalPurchasedStockAmount');
	// 	$balance = $this->input->post('balance');
	// 	//fetching supplieraccount using Supplierid.
	// 	$data=array();
	// 	$supplierid= $this->input->get_post('supplierid');
	// 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
	// 	// echo $data['records']['supplieraccount'];                       
	// 	$Supplieraccount=$data['records']['supplieraccount'];
	// 	$cash=$this->input->post('cash');
	// 	$data['records2']=$this->Onlinemodel->selectAccountGroup($cash);
	// 	$bank=$this->input->post('bank');
	// 	$data['records3']=$this->Onlinemodel->selectAccountGroup($bank);
	// 	// echo $data['records2']['accountgroup'],
	// 	$accountgroupid=18;
	// 	// $accountgroupid=$data['records2']['accountgroup'];
	// 	$CashAccountAmt=0;
	// 	$BankAccountAmt=0;
	// 	$paidcash=$this->input->post('paidcash');
	// 	$paidbank=$this->input->post('paidbank');
	// 	if($balance>0)
	// 	{
	// 		$CashAccountAmt=$paidcash-$balance;
	// 	}
	// 	elseif($balance<0)
	// 	{
	// 		$CashAccountAmt=$paidcash;
	// 	}
	// 	$BankAccountAmt =$paidbank;
	// 	// echo $PurchaseDiscount,0;
	// 	$data=$this->Purchasemodel->PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,$TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$bank,$cash);
	// 	echo json_encode($data);
	// }
	
	
	/////////////////////// Purchase Return /////////////////////////

	public function edittable()
	{
		date_default_timezone_set('Asia/Kolkata');
		// $name=$this->input->post('productname');
		$code=$this->input->post('productcode');
		// $pdt=$this->Onlinemodel->checkexistence_product2($name,$code);
		$data['voucherno']=$this->input->post('voucherno');
		$data['invoicedate']=$this->input->post('invoicedate')." ".date("H:i:s");
		$data['productname']=$this->input->post('productname');
		$data['productcode']=$this->input->post('productcode');
		$data['qty']=$this->input->post('qty');
		$data['unitprice']=$this->input->post('unitprice');
		$data['netamount']=$this->input->post('netamount');
		$data['tax']=$this->input->post('tax');
		$data['taxamount']=$this->input->post('taxamount');
		$data['amount']=$this->input->post('amount');
		$data['batchid']=$this->input->post('batch');
		$data['size']=$this->input->post('size');
		$data['purchasemasterid']=$this->input->post('purchasemasterid');

		$this->db->trans_start();
		$insert=$this->Purchasemodel->insertpurchasegrid($data);
		$pre=$this->input->post('old');
		$oldsize=$this->input->post('oldsize');
		$qty=$data['qty'];
		$vouch=$data['voucherno'];
		$code=$data['productcode'];
		$transactiontype='Purchase Invoice Update';
		$date=$this->input->post('invoicedate')." ".date("H:i:s");
		$userid=$this->session->userdata('user');
		$batch=$this->input->post('batch');
		$new=$qty-$pre;
		$branch=$this->input->post('branch');		
		$name=$data['productcode'];
		$size =$this->input->post('size');
		$newsize =preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);
		$oldsize =preg_split('/,/', $oldsize, -1, PREG_SPLIT_NO_EMPTY);
		$result1=array_diff($newsize,$oldsize);
		$result2=array_diff($oldsize,$newsize);
                
 foreach ($result1 as $a) {         $exist =0;  
		                     	     $qnty =0;
		                     	     $vars = explode('.', $a);
		                     	     $size1 = $vars[0];

		                     	     if ( count($vars) == 2 ) {
                                                           
                                                        $qnty = $vars[1];
                                                                }
                                                                else
                                                                {
                                                                 $qnty=1;
                                                                }
        foreach ($result2 as $b) {   $oldqnty =0;                                  	
                                   $varsb = explode('.', $b);
		                     	     $size2 = $varsb[0];
		                     	     if($size1==$size2){
                                                       if ( count($varsb) == 2 ) {
                                                           
                                                                                     $oldqnty = $varsb[1];
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                     $oldqnty=1;
                                                                                    }
                                                          $size11=$this->Onlinemodel->checksize($size1);
		                     	                          $size1=$size11['sizeid'];
		                     	                          if (is_null($size1))
                                                                      {
                                                                      $size1 ='0';
                                                                      }
                                                            $check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
                                                            if($check>0)
		                                                    {  
		                                                                  	$stock=$this->Onlinemodel->updatestock($name,$size1,($qnty-$oldqnty),$branch,$batch,$vouch,$transactiontype,$date,$userid);
	                                                      	}
		                                                   else
		                                                     {		                                                     	$stck=array();
		                                                     	$stck['productid']=$name;
		                                                     	$stck['size']=$size1;
		                                                     	$stck['currentstock']=($qnty-$oldqnty);
		                                                     	$stck['branch']=$branch;
		                                                     	$stck['batchid']=$batch;
		                                                     	$stock1=$this->Onlinemodel->insertstock($stck,$vouch,$transactiontype,$date,$userid);
		                                                    }
		                                                    $exist =1;
		                                                    break;
		                     	                    }
		                     	                    else{
		                     	                    	$exist =0;
		                     	                    }
		                     	                }
                                  if($exist==0){  
			
                                                    $size11=$this->Onlinemodel->checksize($size1);
			                                          $size1=$size11['sizeid'];
			                                          if (is_null($size1))
                                                                 {
                                                                 $size1 ='0';
                                                                 }
			                                          if ( count($vars) == 2 ) {
                                                                           
                                                                        $qnty = $vars[1];
                                                                                }
                                                                                else
                                                                                {
                                                                                 $qnty=1;
                                                                                }
                                                       $check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
                                                       if($check>0)
		                                               {
		                                                             	$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$vouch,$transactiontype,$date,$userid);
	                                                 	}
		                                              else
		                                                { 
		                                                	$stck=array();
		                                                	$stck['productid']=$name;
		                                                	$stck['size']=$size1;
		                                                	$stck['currentstock']=$qnty;
		                                                	$stck['branch']=$branch;
		                                                	$stck['batchid']=$batch;
		                                                	$stock1=$this->Onlinemodel->insertstock($stck,$vouch,$transactiontype,$date,$userid);
		                                                }

                                               }	    
		                           
		               }
		               
 foreach ($result2 as $a) {         $exist =0;  
		                     	     $qnty =0;
		                     	     $vars = explode('.', $a);
		                     	     $size1 = $vars[0];

		                     	     if ( count($vars) == 2 ) {
                                                           
                                                        $qnty = $vars[1];
                                                                }
                                                                else
                                                                {
                                                                 $qnty=1;
                                                                }
        foreach ($result1 as $b) {                                     	
                                   $varsb = explode('.', $b);
		                     	     $size2 = $varsb[0];
		                     	     if($size1==$size2){
                                                       
															$exist =1;
															
		                     	                    }
		                     	                }
                                  if($exist==0){   
                                                    $size11=$this->Onlinemodel->checksize($size1);
			                                          $size1=$size11['sizeid'];
			                                          if (is_null($size1))
                                                                 {
                                                                 $size1 ='0';
                                                                 }
			                                          if ( count($vars) == 2 ) {
                                                                           
                                                                        $qnty = $vars[1];
                                                                                }
                                                                                else
                                                                                {
                                                                                 $qnty=1;
                                                                                }
                                                       $check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
                                                       if($check>0)
		                                               {  
		                                                             	$stock=$this->Onlinemodel->updatestock($name,$size1,(-1*$qnty),$branch,$batch,$vouch,$transactiontype,$date,$userid);
	                                                 	}
		                                              else
		                                                {
		                                                	$stck=array();
		                                                	$stck['productid']=$name;
		                                                	$stck['size']=$size1;
		                                                	$stck['currentstock']=(-1*$qnty);
		                                                	$stck['branch']=$branch;
		                                                	$stck['batchid']=$batch;
		                                                	$stock1=$this->Onlinemodel->insertstock($stck,$vouch,$transactiontype,$date,$userid);
		                                                }

                                               }    
		               }
    $this->db->trans_complete();
	
        echo json_encode($qty);
	}

	


	public function editpur()
	{  $fromdate=$this->input->get_post('fromdate');
		
		$todate=$this->input->get_post('todate');
		if( $this->session->userdata('name'))
    	{
		$data = array();
		$data['voch'] = $this->Onlinemodel->getvoucherbydate($fromdate,$todate);
		$this->load->view('header');
		$this->load->view('editpurchase', $data);
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
    
    	public function editdetailes()
	{
		$data=array(

		 'voucherno'=>$this->input->post('voucherno'),
		 'suppliername'=>$this->input->post('supplier'),
		 'orderno'=>$this->input->post('order'),
		 'vendorinvoiceno'=>$this->input->post('vendor'),
		 // 'invoicedate'=>$this->input->post('date'),
		 'paymentmode'=>$this->input->post('payment'),
		 'narration'=>'updated',
		 'transportcompany'=>$this->input->post('company'),
		 'totalqty'=>$this->input->post('totalqty'),
		 	'totalamount'=>$this->input->post('totalamount'),
		 	'additionalcost'=>$this->input->post('additionalcost'),
		 	'taxamount'=>$this->input->post('tax'),
		 	'billdiscount'=>$this->input->post('discount'),
		 	'grandtotal'=>$this->input->post('total'),
		 	'oldbalance'=>$this->input->post('oldbalance'),
			 'cash'=>$this->input->post('cash'),
			 'bank'=>$this->input->post('bank'),
			 'paidcash'=>$this->input->post('paidcash'),
			 'paidbank'=>$this->input->post('paidbank'),
		 	'balance'=>$this->input->post('balance'),
		 	);		 
		 $a=$this->input->post('voucherno');

		  $data=$this->Purchasemodel->editdetailes($a,$data);
		  $data=$this->Purchasemodel->deltepurchasegridbyvoucherno($a);
        echo json_encode($a);
		 	}



    
		 
           public function deletemaster()
             {
             	 $data=array();
				 $a=$this->input->get_post('a');
				 $data['master']=$this->Purchasemodel->getmaster($a);
				 print_r($data);
				 echo "<br>";
				 echo $data['master']['voucherno'];

				 // echo $a;
				 // $asb=$this->Purchasemodel->deletemaster($a);
				 // $this->editpur();
			 }
	

	public function updPurchaseInvoice_DyaBookInsertion()
	{$a=$this->input->post('supplier');
		date_default_timezone_set('Asia/Kolkata');
		//2)Inserting into Daybook_Start
		$data=array();
		$total=$this->input->post('totalamount');
		$data2=array();	
		//cash	
        $data2['invoiceno']=$this->input->post('voucherno');
		$data2['accountType']='Purchase Update';
		$data2['date']=$this->input->post('date')." ".date("H:i:s");
		$data2['userid']=$this->session->userdata('user');
		$data2['opposite']=4;
		if($this->input->post('paidcash')!=0)
		{
			$data2['ledgername']=$this->input->post('cash');
			$data2['debit']=0;
			$data2['credit']=$this->input->post('paidcash');
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		if($this->input->post('paidbank')!=0)
		{
			//bank
			$data2['ledgername']=$this->input->post('bank');
			$data2['debit']=0;
			$data2['credit']=$this->input->post('paidbank');
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		if($total!=0)
		{
			//stock
			$data2['ledgername']=4;
			$data2['debit']=$total;
			$data2['credit']=0;
			$data2['opposite']=$a;
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		$data2['opposite']=4;
		if($this->input->post('tax')!=0)
		{
			//tax
			$data2['ledgername']=5;
			$data2['debit']=$this->input->post('tax');
			$data2['credit']=0;
			$data2['opposite']=4;
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//discount
		$discount=$this->input->post('discount');
		if($discount>0)
		{
			$data2['ledgername']=1;
			$data2['debit']=0;
			$data2['credit']=$this->input->post('discount');
			//balancedya
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		else if($discount<0)
		{
			$data2['ledgername']=1;
			$data2['debit']=$this->input->post('discount');
			$data2['credit']=0;
			//balancedya
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		$balance=$this->input->post('balance');

		if($balance<0)
		{
			$data2['ledgername']=$a;
			$data2['debit']=0;
			$data2['credit']=($balance*-1);
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		else if($balance>0)
		{
            $data2['ledgername']=$a;
			$data2['debit']=$balance;
			$data2['credit']=0;
			$result=$this->Onlinemodel->insert_newdaybook($data2);
		}
		else
		{

		}
		// $a=$this->input->post('discount');
		if($data2==false)
		{
			?> <script type="text/javascript">
			alert('Failed Daybook insertion........');
			</script>
			<?php 
		}
		echo json_encode($data2);
		//Inserting into daybook_End
	}

	public function updPurchaseInvoice_AccountInsertion()
				{
           $this->load->model('Purchasemodel');
					                    $oldta=$this->input->get_post('oldta');
										// $oldac=$this->input->get_post('oldac');
										// $oldtx=$this->input->get_post('oldtx');
										// $oldbd=$this->input->get_post('oldbd');
										// $oldgt=$this->input->get_post('oldgt');
										// $oldpa=$this->input->get_post('oldpc');
										// $oldpb=$this->input->get_post('oldpb');
										// $oldbl=$this->input->get_post('oldbl');
					
					$PurchaseDiscount = $this->input->post('PurchaseDiscount');

					$TotalTaxAmt = $this->input->post('TotalTaxAmt');
					$qty = $this->input->post('qty');
					$unitprice = $this->input->post('unitprice');
					$mrp = $this->input->post('mrp');
					$TotalPurchasedStockAmount = $this->input->post('TotalPurchasedStockAmount');
					$balance = $this->input->post('balance');

					
		            //fetching supplieraccount using Supplierid.
		            $data=array();
		                         		 $supplierid= $this->input->get_post('supplierid');
		                         		 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
		                         		 	// echo $data['records']['supplieraccount'];

					                        

		            $Supplieraccount=$data['records']['supplieraccount'];
		            $cash=$this->input->post('cash');
					// $data['records2']=$this->Onlinemodel->selectAccountGroup($cash);
					$bank=$this->input->post('bank');
		            // $data['records3']=$this->Onlinemodel->selectAccountGroup($bank);
		            // echo $data['records2']['accountgroup'],
		            // $accountgroupid=$data['records2']['accountgroup'];
		            $CashAccountAmt=0;
		            $BankAccountAmt=0;
					$paidcash=$this->input->post('paidcash');
					$paidbank=$this->input->post('paidbank');

		           
		            if($balance>0)
		            	{
		            		$CashAccountAmt=$paidcash-$balance;
		            	}
		            	else  if($balance<0)
		            	{
		            		$CashAccountAmt=$paidcash;
		            	}	

		            	
		           $BankAccountAmt=$paidbank;
		            	
		            	
		           

		            // echo $PurchaseDiscount,0;
					 $data=$this->Purchasemodel->PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,
            		 $TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$bank,$cash);
			        echo json_encode($data);
				}
				public function deletedetailes()
				{
						$voucherno=$this->input->get_post('voucherno');
						$result=$this->Purchasemodel->delete_purchasemaster($voucherno);
						echo json_encode($voucherno);

				}

				public function deleteretdetailes()
				{
						$voucherno=$this->input->get_post('voucherno');
						$result=$this->Purchasemodel->delete_purchaseretmaster($voucherno);
						echo json_encode($voucherno);

				}

			public function delete_purchasedetailes()
			{
				
			 $data['voucherno']=$this->input->post('voucherno');
		     $data['invoicedate']=$this->input->post('invoicedate')." ".date("H:i:s");
		 	 $data['productcode']=$this->input->post('productcode');
		 	 $data['qty']=$this->input->post('qty');
		 	 $data['batchid']=$this->input->post('batch');
         $voucherno=$data['voucherno'];
		 $branch=$this->input->post('branch');		
		 $name=$data['productcode'];
    	$transactiontype='Purchase Invoice Delete';
    	$date=$this->input->post('invoicedate')." ".date("H:i:s");
    	$userid=$this->session->userdata('user');
		 $ans=$data['qty'];
		 $qty=($ans)*(-1); 
		 $batch=$data['batchid'];
		 $size=$this->input->post('size');
		 $sizes=preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($sizes as $a) 
		{
			$qnty =0;
			$vars = explode('.', $a);
			$size1 = $vars[0];
			$size11=$this->Onlinemodel->checksize($size1);
			$size1=$size11['sizeid'];
			if(is_null($size1))
			{
				$size1 ='0';
			}
			if(count($vars) == 2 )
			{
				$qnty = $vars[1]*-1;
			}
			else
			{
				$qnty=-1;
			}
			$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
			if($check>0)
			{
				$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
			}
			else
			{
				$stck=array();
		        $stck['productid']=$name;
		        $stck['size']=$size1;
		        $stck['currentstock']=$qnty;
		        $stck['branch']=$branch;
		        $stck['batchid']=$batch;
				$stock=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
			}
		}
		  $data1=$this->Purchasemodel->deltepurchasegrid($voucherno,$name,$batch);
		  				echo json_encode($size1);


			}

			public function delete_purchaseretdetailes()
			{
				
			 $data['voucherno']=$this->input->post('voucherno');
		     $data['invoicedate']=$this->input->post('invoicedate')." ".date("H:i:s");
		 	 $data['productcode']=$this->input->post('productcode');
		 	 $data['qty']=$this->input->post('qty');
		 	 $data['batchid']=$this->input->post('batch');
         $voucherno=$data['voucherno'];
		 $branch=$this->input->post('branch');		
		 $name=$data['productcode'];
    	$transactiontype='Purchase Return Delete';
    	$date=$this->input->post('invoicedate')." ".date("H:i:s");
    	$userid=$this->session->userdata('user');
		 $ans=$data['qty'];
		 $qty=($ans)*(-1); 
		 $batch=$data['batchid'];
		 $size=$this->input->post('size');
		 $sizes=preg_split('/,/', $size, -1, PREG_SPLIT_NO_EMPTY);
		foreach ($sizes as $a) 
		{
			$qnty =0;
			$vars = explode('.', $a);
			$size1 = $vars[0];
			$size11=$this->Onlinemodel->checksize($size1);
			$size1=$size11['sizeid'];
			if(is_null($size1))
			{
				$size1 ='0';
			}
			if(count($vars) == 2 )
			{
				$qnty = $vars[1];
			}
			else
			{
				$qnty=1;
			}
			$check=$this->Purchasemodel->checkproduct($name,$size1,$branch,$batch);
			if($check>0)
			{
				$stock=$this->Onlinemodel->updatestock($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
			}
			else
			{
				$stck=array();
		        $stck['productid']=$name;
		        $stck['size']=$size1;
		        $stck['currentstock']=$qnty;
		        $stck['branch']=$branch;
		        $stck['batchid']=$batch;
				$stock=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
			}
		}
		  $data1=$this->Purchasemodel->delteretpurchasegrid($voucherno,$name,$batch);
		  				echo json_encode($size1);


			}

//daybook of delete purchase
			public function Purchasedelete_DyaBookInsertion()
			{$a=$this->input->post('supplier');
				date_default_timezone_set('Asia/Kolkata');
			   $data=array();
		                         		 	$total=$this->input->post('totalamount');
		                         		 	
		                         		 	$data2=array();	
		                         		 //bank
                                             
		                         		 		$data2['invoiceno']=$this->input->post('voucherno');
			                         		 	$data2['accountType']='Purchase delete';
			                         		 	$data2['date']=$this->input->post('date')." ".date("H:i:s");
			                         		 	$data2['ledgername']=$this->input->post('bank');
			                         		 	$data2['debit']=$this->input->post('paidbank');;
												$data2['credit']=0;
												$data2['opposite']=4;
												$data2['userid']=$this->session->userdata('user');
		                         		 		$result=$this->Onlinemodel->insert_newdaybook($data2);
		                         		 		//cash
		                         		 		$data2['ledgername']=$this->input->post('cash');
			                         		 	$data2['debit']=$this->input->post('paidcash');;
			                         		 	$data2['credit']=0;
		                         		 		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         			//stock
			                         		 	$data2['ledgername']=4;
			                         		 	$data2['debit']=0;
												$data2['credit']=$total;
												$data2['opposite']=$a;
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		//tax
			                         		 	$data2['ledgername']=5;
			                         		 	$data2['debit']=0;
												$data2['credit']=$this->input->post('tax');
												$data2['opposite']=4;
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		//discount
			                         		 	if($discount=$this->input->post('discount'))
			                         		 	{
			                         		 		if($discount>0)
			                         		 		{
			                         		 	      $data2['ledgername']=1;
			                         		 	      $data2['debit']=$this->input->post('discount');
			                         		 	      $data2['credit']=0;
			                         		 	      //balancedya
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		        }
			                         		 	}	

			                         		 	if($balance=$this->input->post('balance'))
			                         		 	{

			                         		 	 if($balance!=0)
			                         		 	 {

													$data2['ledgername']=$a;
													$data2['debit']=$balance*-1;
													$data2['credit']=0;
			                         				$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		     }
			                         		 	}
			                         		 	// $a=$this->input->post('discount');
		                         		 	
		                         		 	if($data2==false)
		                         		 	{
 												?> <script type="text/javascript">
	alert('Failed Daybook insertion........');
</script>
<?php 
		                         		 	}

		                         		 	echo json_encode($data2);	
			}


			public function PurchaseRetdelete_DyaBookInsertion()
			{$a=$this->input->post('supplier');
				date_default_timezone_set('Asia/Kolkata');
			   $data=array();
		                         		 	$total=$this->input->post('totalamount');
		                         		 	
		                         		 	$data2=array();	
		                         		 //bank
                                             
		                         		 		$data2['invoiceno']=$this->input->post('voucherno');
			                         		 	$data2['accountType']='Purchase Return delete';
			                         		 	$data2['date']=$this->input->post('date')." ".date("H:i:s");
			                         		 	$data2['ledgername']=$this->input->post('bank');
			                         		 	$data2['debit']=0;
												$data2['credit']=$this->input->post('paidbank');
												$data2['opposite']=4;
												$data2['userid']=$this->session->userdata('user');
		                         		 		$result=$this->Onlinemodel->insert_newdaybook($data2);
		                         		 		//cash
		                         		 		$data2['ledgername']=$this->input->post('cash');
			                         		 	$data2['debit']=0;
			                         		 	$data2['credit']=$this->input->post('paidcash');
		                         		 		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         			//stock
			                         		 	$data2['ledgername']=4;
			                         		 	$data2['debit']=$total;
												$data2['credit']=0;
												$data2['opposite']=$a;
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		//tax
			                         		 	$data2['ledgername']=5;
			                         		 	$data2['debit']=$this->input->post('tax');
												$data2['credit']=0;
												$data2['opposite']=4;
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		//discount
			                         		 	if($discount=$this->input->post('discount'))
			                         		 	{
			                         		 		if($discount>0)
			                         		 		{
			                         		 	      $data2['ledgername']=1;
			                         		 	      $data2['debit']=0;
			                         		 	      $data2['credit']=$this->input->post('discount');
			                         		 	      //balancedya
			                         		$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		        }
			                         		 	}	

			                         		 	if($balance=$this->input->post('balance'))
			                         		 	{

			                         		 	 if($balance!=0)
			                         		 	 {

													$data2['ledgername']=$a;
													$data2['debit']=0;
													$data2['credit']=$balance*-1;
			                         				$result=$this->Onlinemodel->insert_newdaybook($data2);
			                         		     }
			                         		 	}
			                         		 	// $a=$this->input->post('discount');
		                         		 	
		                         		 	if($data2==false)
		                         		 	{
 												?> <script type="text/javascript">
	alert('Failed Daybook insertion........');
</script>
<?php 
		                         		 	}

		                         		 	echo json_encode($data2);	
			}

//  public function deletePurchaseInvoice_AccountInsertion()
//  {
        

//            $this->load->model('Purchasemodel');
					 
					
// 					$PurchaseDiscount = $this->input->post('PurchaseDiscount');
// 					$TotalTaxAmt = $this->input->post('TotalTaxAmt');
// 					$qty = $this->input->post('qty');
// 					$unitprice = $this->input->post('unitprice');
// 					$mrp = $this->input->post('mrp');
// 					$TotalPurchasedStockAmount = $this->input->post('TotalPurchasedStockAmount');
// 					$balance = $this->input->post('balance');

					
// 		            //fetching supplieraccount using Supplierid.
// 		            $data=array();
// 		                         		 $supplierid= $this->input->get_post('supplierid');
// 		                         		 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
// 		                         		 	// echo $data['records']['supplieraccount'];

					                        

// 		            $Supplieraccount=$data['records']['supplieraccount'];

// 		            $cash=$this->input->post('cash');
// 		            $bank =$this->input->post('bank');
		            
// 		            $CashAccountAmt=0;
// 		            $BankAccountAmt=0;
// 		            $paidcash=$this->input->post('paidcash');
// 		            $paidbank =$this->input->post('paidbank');
// 		            	if($balance>0)
// 		            	{
// 		            		$CashAccountAmt=($paidcash-$balance) ;
// 		            	}
// 		            	else  if($balance<0)
// 		            	{
// 		            		$CashAccountAmt=$paidcash;
// 		            	}

// 		            	$BankAccountAmt=$paidbank;
		            		
		           

// 		            // echo $PurchaseDiscount,0;
// 					 $data=$this->Purchasemodel->PurchaseInvoicedelete_AccountInsertion(-1*$PurchaseDiscount,-1*$TotalTaxAmt,
//             		-1* $TotalPurchasedStockAmount,-1*$balance,$Supplieraccount,-1*$CashAccountAmt,-1*$BankAccountAmt,$bank,$cash);

					  
// 					echo json_encode($data);
// 				}







}
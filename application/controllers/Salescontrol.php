<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salescontrol extends CI_Controller {

	public function __cunstruct()
	{
		parent::__cunstruct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->helper('form');
		$this->load->model('Salesmodel');
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

	////////////////////  Sales Invoice Start ///////////////////////
	
	public function insert_salesinvoicemaster()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
		'invoiceno'=>$this->input->post('invoiceno'),
		'customerid'=>$this->input->post('customer'),
		'salesorderno'=>$this->input->post('salesorderno'),
		'salesmode'=>$this->input->post('Paymentmode'),
		'salesdate'=>$newDate,
		'salesman'=>$this->input->post('salesman'),
		'totalqty'=>$this->input->post('totalqty'),
		'finyear'=>$this->input->post('finyear'),
		'totalamount'=>$this->input->post('totalamount'),
		'additionalcost'=>$this->input->post('additionalcost'),
		'taxamount'=>$this->input->post('taxamount'),
		'billdiscount'=>$this->input->post('billdiscount'),
		'grandtotal'=>$this->input->post('grandtotal'),
		'oldbalance'=>$this->input->post('oldbalance'),
		'stockamount'=>$this->input->post('totalstockamount'),
		'cash'=>$this->input->post('cash'),
		'bank'=>$this->input->post('bank'),
		'paidcash'=>$this->input->post('paidcash'),
		'paidbank'=>$this->input->post('paidbank'),
		'balance'=>$this->input->post('balance'),
		'narration'=>$this->input->post('narration'),
		'userid'=>$this->session->userdata('user'),
		'branchid'=>$this->input->post('branchid')
		);	
		$customerid = $this->input->get_post('customer');
        $DATE=$this->input->get_post('salesdate');
		$sales = $this->input->get_post('totalamount');
		$points = $this->input->get_post('pointredeem');	 
		$dat1=$this->Salesmodel->insert_salesinvoicemaster($data);
		if($dat1)
		{
			if($points!=0)
            {
                $a=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
            }
            $addpoints =($sales*1/100);
            if($sales!=0)
            {
                $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
            }
		}
		echo json_encode($dat1);
	}

	public function autogenerate_inv()
	{
		$this->load->model('Onlinemodel');
		$branchid = $this->input->get_post('branchid');
		$data=$this->Onlinemodel->Autogenerate_InvoiceNoNew($branchid);
		echo json_encode($data);
	}

	public function inserttable_push()
	{
		$prs = $this->input->get_post('orderItems');
		$i=1;
		foreach($prs as $data)
		{ 

			$originalDate = $data["salesdate"];
			$newDate = date("Y-m-d H:i:s", strtotime($originalDate));

			$insertdata2['invoiceno'] = $data["invoiceno"];
			$insertdata2['salesdate'] = $newDate;
			$insertdata2['salesmasterid'] = $data["salesmasterid"];
			$insertdata2['productname'] =  $data["productname"];
			$insertdata2['productcode'] =  $data["productcode"];

			$insertdata2['hsncode'] =   $data["hsn"];
			$insertdata2['qty'] =   $data["qty"];
			$insertdata2['size'] =   $data["size"];
			$insertdata2['unitprice'] =   $data["mrp"];
			$insertdata2['netamount'] =   $data["netamount"];
			$insertdata2['tax'] =   $data["tax"];
			$insertdata2['taxamount'] =   $data["taxamount"];
			$insertdata2['amount'] =   $data["amount"];
			$insertdata2['batchid'] =   $data["batchid"];
			$insertdata2['finyear'] =   $data["finyear"];
			$insertdata2['branchid'] =   $data["branchid"];

			$ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata2);



			$voucherno=$data['invoiceno'];
			$transactiontype='Sales Invoice';
			$date=$newDate;
			$userid=$this->session->userdata('user');
			if($ans)
			{
				$branch=$data["branchid"];
				$batch=$data["batchid"];
				$product=$data["productcode"];
				$qty=$data["qty"]*-1;
				$size=$data["size"];
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

		echo json_encode($size1);
	}
	
	public function insert_salesinvoicedetails()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
		'invoiceno'=>$this->input->post('invoiceno'),
		'salesmasterid'=>$this->input->post('salesmasterid'),
		'salesdate'=>$newDate,
		'productname'=>$this->input->post('productname'),
	    'productcode'=>$this->input->post('productcode'),
		'qty'=>$this->input->post('qty'),
		'hsncode'=>$this->input->post('hsn'),
		'size'=>$this->input->post('size'),
		'unitprice'=>$this->input->post('mrp'),
		'netamount'=>$this->input->post('netamount'),
		'tax'=>$this->input->post('tax'),
		'taxamount'=>$this->input->post('taxamount')*0,
		'amount'=>$this->input->post('amount'),
		'branchid'=>$this->input->post('branchid'),
		'batchid'=>$this->input->post('batchid'),	
		);		 
		$ans=$this->Salesmodel->insert_salesinvoicedetails($data);
		$voucherno=$data['invoiceno'];
    	$transactiontype='Sales Invoice';
    	$date=$newDate;
    	$userid=$this->session->userdata('user');
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
        echo json_encode($ans);
	}       


	// public function SalesInvoice_AccountInsertion()
    // {
	// 	$tax=0;
	// 	$paidcash=$this->input->get_post('paidcash');
	// 	$paidbank=$this->input->get_post('paidbank');
	// 	$discount=$this->input->get_post('billdiscount');
	// 	$grandtotal=$this->input->get_post('grandtotal')*1;
	// 	$totalamount=$this->input->get_post('totalamount')*1;
	// 	$stock=$this->input->get_post('stock');
	// 	$cash=$this->input->get_post('cash');
	// 	$bank=$this->input->get_post('bank');
	// 	$customerid=$this->input->get_post('customer');
	// 	$balance=$this->input->get_post('balance');
	// 	$data['records']=$this->Onlinemodel->Select_customerledger($customerid);
	// 	$customer=$data['records']['customeraccount'];
    //    	$data=array();
    //    	$data=$this->Salesmodel->salesaccount($totalamount,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance);
    //    	echo json_encode($data);
    // }


	public function SalesInvoice_DayBookInsertion()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array();
		$voucherno=$this->input->post('voucherno');
		$grand=$this->input->post('grandtotal')*1;
		$tax=0;
		$total=$this->input->post('totalamount');
		$paidcash=$this->input->post('paidcash');
		$paidbank=$this->input->post('paidbank');
		$balance=$this->input->post('balance');
		$discount=$this->input->post('billdiscount')*1;
		$customer=$this->input->post('customer');
		$cash=$this->input->post('cash');
		$bank=$this->input->post('bank');
		$stock=$this->input->post('stock');
		$sales=$grand-$tax+$discount;
		log_message('error',$grand."-".$tax."-".$discount);
		$data2=array();
        //sales account
		$data2['invoiceno']=$voucherno;
		$data2['accountType']='Sales Invoice';
		$data2['date']=$newDate;
		$data2['ledgername']=21;
		$data2['debit']=0;
		$data2['credit']=$sales;
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
		echo json_encode($data22);
	}
	////////////////////  Sales Invoice End ///////////////////////



	////////////////////  Sales Return Start ///////////////////////

	public function insert_salesreturnmaster()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
		'invoiceno'=>$this->input->post('returnno'),
		'customerid'=>$this->input->post('customer'),
		'salesdate'=>$newDate,
		'salesman'=>$this->input->post('salesman'),
		'totalqty'=>$this->input->post('totalqty'),
		'totalamount'=>$this->input->post('totalamount'),
		'additionalcost'=>$this->input->post('additionalcost'),
		'taxamount'=>$this->input->post('taxamount'),
		'billdiscount'=>$this->input->post('billdiscount'),
		'grandtotal'=>$this->input->post('grandtotal'),
		'oldbalance'=>$this->input->post('oldbalance'),
		'stockamount'=>$this->input->post('totalstockamount'),
		'cash'=>$this->input->post('cash'),
		'bank'=>$this->input->post('bank'),
		'paidcash'=>$this->input->post('paidcash'),
		'paidbank'=>$this->input->post('paidbank'),
		'balance'=>$this->input->post('balance'),
		'narration'=>$this->input->post('narration'),
		'branchid'=>$this->input->post('branchid')
		);	
		$customerid = $this->input->get_post('customer');
        $DATE=$this->input->get_post('salesdate');
		$sales = $this->input->get_post('totalamount');
		// $points = $this->input->get_post('pointredeem');	 
		$dat1=$this->Salesmodel->insert_salesreturnmaster($data);
		// if($dat1)
		// {
		// 	if($points!=0)
        //     {
        //         $a=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
        //     }
        //     $addpoints =($sales*1/100);
        //     if($sales!=0)
        //     {
        //         $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
        //     }
		// }
		echo json_encode($dat1);
	}

	public function autogenerate_ret()
	{
		$this->load->model('Onlinemodel');
		$branchid = $this->input->get_post('branchid');
		$data=$this->Onlinemodel->Autogenerate_ReturnNoNew($branchid);
		echo json_encode($data);
	}


	public function insert_salesreturndetails()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
		'invoiceno'=>$this->input->post('returnno'),
		'salesreturnid'=>$this->input->post('salesreturnid'),
		'salesdate'=>$newDate,
		'productname'=>$this->input->post('productname'),
	    'productcode'=>$this->input->post('productcode'),
		'qty'=>$this->input->post('qty'),
		'hsncode'=>$this->input->post('hsn'),
		'size'=>$this->input->post('size'),
		'unitprice'=>$this->input->post('mrp'),
		'netamount'=>$this->input->post('netamount'),
		'tax'=>$this->input->post('tax'),
		'taxamount'=>$this->input->post('taxamount')*0,
		'amount'=>$this->input->post('amount'),
		'branchid'=>$this->input->post('branchid'),
		'batchid'=>$this->input->post('batchid'),	
		);	
		$voucherno=$data['invoiceno'];
   	 	$transactiontype='Sales Return';
    	$date=$this->input->post('salesdate')." ".date("H:i:s");
    	$userid=$this->session->userdata('user'); 	 
		$ans=$this->Salesmodel->insert_salesreturndetails($data);
		if($ans)
		{
			$branch=$this->input->post('branchid');
			$batch=$this->input->post('batchid');
			$product=$this->input->post('productcode');
			$qty=$this->input->post('qty');
			$size=$this->input->post('size');
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
		
        echo json_encode($ans);
	}       
	
	// public function SalesReturn_AccountInsertion()
    // {
	// 	$tax=0;
	// 	$paidcash=$this->input->get_post('paidcash');
	// 	$paidbank=$this->input->get_post('paidbank');
	// 	$discount=$this->input->get_post('billdiscount');
	// 	$grandtotal=$this->input->get_post('grandtotal')*1;
	// 	$totalamount=$this->input->get_post('totalamount')*1;
	// 	$stock=$this->input->get_post('stock');
	// 	$cash=$this->input->get_post('cash');
	// 	$bank=$this->input->get_post('bank');
	// 	$customerid=$this->input->get_post('customer');
	// 	$balance=$this->input->get_post('balance');
	// 	$data['records']=$this->Onlinemodel->Select_customerledger($customerid);
	// 	$customer=$data['records']['customeraccount'];
    //    	$data=array();
    //    	$data=$this->Salesmodel->salesreturnaccount($totalamount,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance);
    //    	echo json_encode($data);
    // }


	public function SalesReturn_DayBookInsertion()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array();
		$returnno=$this->input->post('returnno');
		$grand=$this->input->post('grandtotal')*1;
		$tax=0;
		$total=$this->input->post('totalamount');
		$paidcash=$this->input->post('paidcash');
		$paidbank=$this->input->post('paidbank');
		$balance=$this->input->post('balance');
		$discount=$this->input->post('billdiscount')*1;
		$customer=$this->input->post('customer');
		$cash=$this->input->post('cash');
		$bank=$this->input->post('bank');
		$stock=$this->input->post('stock');
		$sales=$grand-$tax+$discount;
		log_message('error',$grand."-".$tax."-".$discount);
		$data2=array();
        //sales account
		$data2['invoiceno']=$returnno;
		$data2['accountType']='Sales Return';
		$data2['date']=$newDate;
		$data2['ledgername']=21;
		$data2['debit']=$sales;
		$data2['credit']=0;
		$data2['opposite']=$customer;
		$data2['userid']=$this->session->userdata('user');
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
        //stock account
		$data2['ledgername']=4;
		$data2['debit']=$stock;
		$data2['credit']=0;
		$data2['opposite']=21;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
		//cash account
		if($paidcash>0)
		{
			$data2['ledgername']=$cash;
			$data2['debit']=0;
			$data2['credit']=$paidcash;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//bank account
		if($paidbank>0)
		{
			$data2['ledgername']=$bank;
			$data2['debit']=0;
			$data2['credit']=$paidbank;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//cost of sales
		$data2['ledgername']=22;
		$data2['debit']=0;
		$data2['credit']=$stock;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);
		//discount of sales
		if($discount>0)
		{
			$data2['ledgername']=28;
			$data2['debit']=0;
			$data2['credit']=$discount;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//customer
		if($balance<0)
		{
			$data['records']=$this->Onlinemodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=0;
			$data2['credit']=$abs;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//tax
		if($tax>0)
		{
			$data2['ledgername']=23;
			$data2['debit']=0;
			$data2['credit']=$tax;
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
	}

	////////////////////  Sales Return End ///////////////////////


	public function excel()
	{
		$fromdate=$this->input->get_post('fromdate');
		$todate=$this->input->get_post('todate');
		$branchid = $this->session->userdata('branch');
		if($this->session->userdata('role')=="Super Admin")
		{
			$data=array();
			$data['master']=$this->Onlinemodel->getsalesmasterbybranchbetweendate($fromdate,$todate);
		}
		else
		{
			$data=array();
			$data['master']=$this->Onlinemodel->getsalesmasterbybranchidbetweendate($branchid,$fromdate,$todate);
		}
    
		require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
                    $objExcel->getActiveSheet()->setCellValue('A1',"Invoice No");
					$objExcel->getActiveSheet()->setCellValue('B1',"Branch Name");
					$objExcel->getActiveSheet()->setCellValue('C1',"Date");
					$objExcel->getActiveSheet()->setCellValue('D1',"Customer");
					$objExcel->getActiveSheet()->setCellValue('E1',"Cost of Sale");
					$objExcel->getActiveSheet()->setCellValue('F1',"Gross Total");
					$objExcel->getActiveSheet()->setCellValue('G1',"Discount");
					$objExcel->getActiveSheet()->setCellValue('H1',"Net Total");
					$objExcel->getActiveSheet()->setCellValue('I1',"paid Cash");
					$objExcel->getActiveSheet()->setCellValue('J1',"Paid Bank");
					$objExcel->getActiveSheet()->setCellValue('K1',"Balance");
         for ($i=0; $i <$data['master']->num_rows() ; $i++) { $n=$i+2;
					$objExcel->getActiveSheet()->setCellValue('A'.$n,$data['master']->result_array()[$i]['invoiceno']);
					$objExcel->getActiveSheet()->setCellValue('B'.$n,$data['master']->result_array()[$i]['branchname']);
					$objExcel->getActiveSheet()->setCellValue('C'.$n,$data['master']->result_array()[$i]['salesdate']);
					$objExcel->getActiveSheet()->setCellValue('D'.$n,$data['master']->result_array()[$i]['customername']);
					$objExcel->getActiveSheet()->setCellValue('E'.$n,$data['master']->result_array()[$i]['stockamount']);
					$objExcel->getActiveSheet()->setCellValue('F'.$n,$data['master']->result_array()[$i]['totalamount']);
					$objExcel->getActiveSheet()->setCellValue('G'.$n,$data['master']->result_array()[$i]['billdiscount']);
					$objExcel->getActiveSheet()->setCellValue('H'.$n,$data['master']->result_array()[$i]['grandtotal']);
					$objExcel->getActiveSheet()->setCellValue('I'.$n,$data['master']->result_array()[$i]['paidcash']);
					$objExcel->getActiveSheet()->setCellValue('J'.$n,$data['master']->result_array()[$i]['paidbank']);
					$objExcel->getActiveSheet()->setCellValue('K'.$n,$data['master']->result_array()[$i]['balance']);
				}
        $filename ="Sales Report.Xlsx";
        $objExcel->getActiveSheet()->SetTitle("Sales report");
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header('Cache-control:max-age=0');
        $Writer=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
        $Writer->save('php://output');
        exit;
        
        
	}
	public function exceldailysales()
	{   
	
			$fromdate=$this->input->get_post('fromdate');
		
		$todate=$this->input->get_post('todate');
        $todate=date_add(date_create($todate),date_interval_create_from_date_string("1 days"));
		$todate=date_format($todate,"Y-m-d");
		$branchid = $this->session->userdata('branch');
		if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['master']=$this->Onlinemodel->getdailysalesbybranchbetweendate($fromdate,$todate);
				
			}
			else
			{
				$data=array();
				$data['master']=$this->Onlinemodel->getdailysalesbybranchidbetweendate($branchid,$fromdate,$todate);
				
				 
			}
			
			
    
		require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
        require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
                    $objExcel->getActiveSheet()->setCellValue('A1',"Sl No");
					$objExcel->getActiveSheet()->setCellValue('B1',"Date");
					$objExcel->getActiveSheet()->setCellValue('C1',"Bills");
					$objExcel->getActiveSheet()->setCellValue('D1',"Gross Sales");
					$objExcel->getActiveSheet()->setCellValue('E1',"Discount");
					$objExcel->getActiveSheet()->setCellValue('F1',"Net Sales");
					$objExcel->getActiveSheet()->setCellValue('G1',"Total Cash");
					$objExcel->getActiveSheet()->setCellValue('H1',"Total Bank");
					$objExcel->getActiveSheet()->setCellValue('I1',"Cost of Sales");
					$objExcel->getActiveSheet()->setCellValue('J1',"Profit");
					$objExcel->getActiveSheet()->setCellValue('K1',"Total Qty");
					$objExcel->getActiveSheet()->setCellValue('L1',"Branch");
					
         for ($i=0; $i <$data['master']->num_rows() ; $i++) { $n=$i+2;
					$objExcel->getActiveSheet()->setCellValue('A'.$n,$i+1);
					$objExcel->getActiveSheet()->setCellValue('B'.$n,$data['master']->result_array()[$i]['Dateonly']);
					$objExcel->getActiveSheet()->setCellValue('C'.$n,$data['master']->result_array()[$i]['no']);
					$objExcel->getActiveSheet()->setCellValue('D'.$n,$data['master']->result_array()[$i]['total']);
					$objExcel->getActiveSheet()->setCellValue('E'.$n,$data['master']->result_array()[$i]['discount']);
					$objExcel->getActiveSheet()->setCellValue('F'.$n,$data['master']->result_array()[$i]['netsales']);
					$objExcel->getActiveSheet()->setCellValue('G'.$n,$data['master']->result_array()[$i]['cash']);
					$objExcel->getActiveSheet()->setCellValue('H'.$n,$data['master']->result_array()[$i]['bank']);
					$objExcel->getActiveSheet()->setCellValue('I'.$n,$data['master']->result_array()[$i]['cost']);
					$objExcel->getActiveSheet()->setCellValue('J'.$n,$data['master']->result_array()[$i]['profit']);
					$objExcel->getActiveSheet()->setCellValue('K'.$n,$data['master']->result_array()[$i]['qty']);
					$objExcel->getActiveSheet()->setCellValue('L'.$n,$data['master']->result_array()[$i]['branchname']);
					
				}
        $filename ="dailysalesreport.Xlsx";
        $objExcel->getActiveSheet()->SetTitle("Daily Sales");
        header('Content-Type:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition:attachment;filename="'.$filename.'"');
        header('Cache-control:max-age=0');
        $Writer=PHPExcel_IOFactory::createWriter($objExcel,'Excel2007');
        $Writer->save('php://output');
        exit;
	}

	public function editsales()
	{
		$fromdate=$this->input->get_post('fromdate');
		$todate=$this->input->get_post('todate');
		if( $this->session->userdata('name'))
    	{
			$branchid = $this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['master']=$this->Onlinemodel->getsalesmasterbybranchbetweendate($fromdate,$todate);
				$data['fromdate'] =  $fromdate;
				$data['todate'] =  $todate;
			}
			else
			{
				$data=array();
				$data['master']=$this->Onlinemodel->getsalesmasterbybranchidbetweendate($branchid,$fromdate,$todate);
				$data['fromdate'] =  $fromdate;
				$data['todate'] =  $todate;
			}
			// $data['detailes']=$this->Onlinemodel->getsalesdetailes();
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('editsales',$data);
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

	public function dailysalesreport()
	{
		$branchid=$this->input->get_post('branchid');
		if($branchid=="" or $branchid==null ){
			$branchid=$this->session->userdata('branch');
		}
		
		$fromdate=$this->input->get_post('fromdate');
		if($fromdate==null)
		{
			$fromdate=date('Y-m-01');
		}
		$todate=$this->input->get_post('todate');
		if($todate==null)
		{
			$todate=date('Y-m-t');
            $tdate=$todate;
		}
		else
		{
			 $tdate=date_add(date_create($todate),date_interval_create_from_date_string("1 days"));
			 $tdate=date_format($tdate,"Y-m-d");
		}
		if( $this->session->userdata('name'))
    	{
			// echo $branchid;
			if($this->session->userdata('role')=="Super Admin")
			{
				// $data=array();
				// $data['master']=$this->Onlinemodel->getdailysalesbybranchbetweendate($fromdate,$tdate);
				// $data['advanceinhand']=$this->Onlinemodel->getadvanceinhand();
                
				// $data['fromdate'] =  $fromdate;
				// $data['todate'] =  $todate;
				$data=array();
			$data['master']=$this->Onlinemodel->getdailysalesbybranchidbetweendate($branchid,$fromdate,$tdate);

			$sum_total = 0;
			$sum_discount = 0;
			$sum_netReturn = 0;
			$sum_netSales = 0;
			$sum_cash = 0;
			$sum_bank = 0;
			$sum_paidAdvance = 0;
			$sum_cost = 0;
			$sum_profit = 0;

			foreach ($data['master']->result() as $key) {

                    $sum_total+= $key->total;
                    $sum_discount+= $key->discount;
                    $sum_netReturn+= $key->netReturn;
                    $sum_netSales+= $key->netsales - $key->netReturn;
                    $sum_cash+= $key->cash;
                    $sum_bank+= $key->bank;
                    $sum_paidAdvance+= $key->paidadvance;
                    $sum_cost+= $key->cost - $key->stockReturn;
                    $sum_profit+= $key->profit - ($key->netReturn - $key->stockReturn);

                }

                $data['sum_total']=$sum_total;
                $data['sum_discount']=$sum_discount;
                $data['sum_netReturn']= $sum_netReturn;
                $data['sum_netSales']= $sum_netSales;
                $data['sum_cash']= $sum_cash;
                $data['sum_bank']= $sum_bank;
                $data['sum_paidAdvance']= $sum_paidAdvance;
                $data['sum_cost']= $sum_cost;
                $data['sum_profit']= $sum_profit;

				$data['branch']=$this->Onlinemodel->getBranch();
				$data['advanceinhand']=$this->Onlinemodel->getadvanceinhand($branchid);
				$data['fromdate'] =  $fromdate;
				$data['todate'] =  $todate;
				$data['branchid'] =  $branchid;

			}
			else if($this->session->userdata('role')=="Branch User")
			{
				$data=array();
			$data['master']=$this->Onlinemodel->getdailysalesbybranchidbetweendate($branchid,$fromdate,$tdate);

$sum_total = 0;
$sum_discount = 0;
$sum_netReturn = 0;
$sum_netSales = 0;
$sum_cash = 0;
$sum_bank = 0;
$sum_paidAdvance = 0;
$sum_cost = 0;
$sum_profit = 0;

foreach ($data['master']->result() as $key) {

$sum_total+= $key->total;
$sum_discount+= $key->discount;
$sum_netReturn+= $key->netReturn;
$sum_netSales+= $key->netsales - $key->netReturn;
$sum_cash+= $key->cash;
$sum_bank+= $key->bank;
$sum_paidAdvance+= $key->paidadvance;
$sum_cost+= $key->cost - $key->stockReturn;
$sum_profit+= $key->profit - ($key->netReturn - $key->stockReturn);

}

$data['sum_total']=$sum_total;
$data['sum_discount']=$sum_discount;
$data['sum_netReturn']= $sum_netReturn;
$data['sum_netSales']= $sum_netSales;
$data['sum_cash']= $sum_cash;
$data['sum_bank']= $sum_bank;
$data['sum_paidAdvance']= $sum_paidAdvance;
$data['sum_cost']= $sum_cost;
$data['sum_profit']= $sum_profit;
			
				$branchid=$this->session->userdata('branch');
				$data['branch']=$this->Onlinemodel->getUserBranch($branchid);
				$data['advanceinhand']=$this->Onlinemodel->getadvanceinhand($branchid);
				$data['fromdate'] =  $fromdate;
				$data['todate'] =  $todate;
				$data['branchid'] =  $branchid;
			}
			// $data['detailes']=$this->Onlinemodel->getsalesdetailes();
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('DailySalesReport',$data);
			$this->load->view('footer');
			if($this->session->userdata('role')=="Admin")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!!");
				</script>
				<?php
				$this->index();
			}
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

    public function viewsales()
    {
		$branchid = $this->session->userdata('branch');
		$finyear = $this->session->userdata('finyear');
		$branchh=$branchid;
		$data=array();
		$data['product']=$this->Onlinemodel->getproduct();
		if($this->session->userdata('role')=="Super Admin")
		{
			$data['branch']=$this->Onlinemodel->getBranch();
		}
		else
		{
			$data['branch']=$this->Onlinemodel->getUserBranch($branchid);
		}
		$a=$this->input->get_post('masterid');
      	// echo current_url();
      	$data['master']=$this->Onlinemodel->getsalesmaster1($a);
		$data['detailes']=$this->Onlinemodel->getsalesdetailes($a,$branchh);
		$data['product']=$this->Onlinemodel->getproduct();
		$data['batch']=$this->Onlinemodel->getbatch();
		$data['size']=$this->Onlinemodel->getsize();
		$data['invoiceno']=$this->Onlinemodel->Autogenerate_InvoiceNo($branchid,$finyear);
		$data['customer']=$this->Onlinemodel->getcustomer();
		$data['salesman']=$this->Onlinemodel->getsalesman();
		$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
		$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
		$data['branchid']=$branchh;
		//$data['master']=$this->Onlinemodel->getsalesmaster();
			if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
		$this->load->view('updsales',$data);
		$this->load->view('footer');
	}
	
   public function update_salesinvoicemaster()
   {
		$originalDate = $this->input->post('salesdate'); 
		$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
   	   'invoiceno'=>$this->input->post('invoiceno'),
	   'customerid'=>$this->input->post('customer'),
	   'salesorderno'=>$this->input->post('salesorderno'),
	   'salesmode'=>$this->input->post('Paymentmode'),
	   'salesdate'=>$newDate,
	   'totalqty'=>$this->input->post('totalqty'),
	   'totalamount'=>$this->input->post('totalamount'),
       'additionalcost'=>$this->input->post('additionalcost'),
		//'taxamount'=>$this->input->post('taxamount'),
	   'stockamount'=>$this->input->post('totalstockamount'),
	   'billdiscount'=>$this->input->post('billdiscount'),
	   'grandtotal'=>$this->input->post('grandtotal'),
       'oldbalance'=>$this->input->post('oldbalance'),
	   'cash'=>$this->input->post('cash'),
	   'bank'=>$this->input->post('bank'),
       'paidcash'=>$this->input->post('paidcash'),
       'paidbank'=>$this->input->post('paidbank'),
       'userid'=>$this->session->userdata('user'),
	   'balance'=>$this->input->post('balance'),
	   'narration'=>'updation',
	   //'transportcompany'=>$this->input->post('transportcompany'),
	   'branchid'=>$this->input->post('branchid')
		);		 
        $id=$this->input->post('invoiceno') ;
        $result=$this->Salesmodel->edit_salesinvoicemaster($data,$id);
		echo json_encode($id);
	}
	 
    public function updatesalesinvoicedetails()
    {
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$data=array(
		'invoiceno'=>$this->input->post('invoiceno'),
		'salesdate'=>$newDate,
		'productname'=>$this->input->post('productname'),
		'productcode'=>$this->input->post('productcode'),
		'qty'=>$this->input->post('qty'),
		'size'=>$this->input->post('size'),
		'unitprice'=>$this->input->post('mrp'),
		'netamount'=>$this->input->post('netamount'),
		// 'tax'=>$this->input->post('tax'),
		// 'taxamount'=>$this->input->post('taxamount'),
		'amount'=>$this->input->post('amount'),
		'branchid'=>$this->input->post('branchid'),
		'batchid'=>$this->input->post('batchid'),
		);		 
		$old=$this->input->post('old');
		$branch=$this->input->post('branchid');
		$size=$this->input->post('size');
		$batch=$this->input->post('batchid');
		$product=$this->input->post('productcode');
		$qty=$this->input->post('qty');
		$voucherno=$this->input->post('invoiceno');
    	$transactiontype='Sales Invoice Update';
    	$date=$newDate;
    	$userid=$this->session->userdata('user');
    	if($old==0)
		{
			$data=$this->Salesmodel->insert_salesinvoicedetails($data);
		  	$stock=$this->Onlinemodel->updatestock($product,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
		}
		else
		{
			$new=$qty-$old;
			$id=$this->input->post('invoiceno');
			$pdt=$this->input->post('productcode');
		    $qty=$this->input->post('qty');
		    $data=$this->Salesmodel->update_salesinvoicedetails($id,$data);	
		    $stock=$this->Onlinemodel->updatestock($product,$size,$new,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
		}
        echo json_encode($data);
	
	}
	
	public function SalesInvoice_DayBookUpdation()
	{
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		//2)Updating into Daybook_Start
		$data=array();
		$voucherno=$this->input->post('voucherno');
		$grandtotal=$this->input->post('grandtotal')*1;
		$oldgrandtotal=$this->input->get_post('oldgrandtotal');
		$tax=$this->input->post('tax');
		$total=$this->input->post('totalamount');
		$paidcash=$this->input->post('paidcash');
		$paidbank=$this->input->post('paidbank');
		$balance1=$this->input->post('balance');
		$oldbalance=$this->input->get_post('oldbalance');
		$discount1=$this->input->post('discount')*1;
		$olddiscount=$this->input->get_post('olddiscount');
		$customer=$this->input->post('customer');
		$cash=$this->input->post('cash');
		$bank=$this->input->post('bank');
		$stock1=$this->input->post('stock');
		$oldstock=$this->input->get_post('oldstock');
		$sales=$grandtotal-$tax+$discount;

		$data2=array();	
        //sales account
		$data2['invoiceno']=$voucherno;
		$data2['accountType']='Sales Update';
		$data2['date']=$newDate;
		$data2['ledgername']=21;
		$data2['debit']=0;
		$data2['credit']=$sales;
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
			if($balance<0){
           $data2['debit']=$abs;
			$data2['credit']=0;
			}
			else{
				$data2['debit']=$balance;
			$data2['credit']=0;
			}
			
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
		echo json_encode($data22);
		//Inserting into daybook_End
	}



  	// public function updateSalesInvoice_AccountInsertion()
    // {
	// 	$totalamount=$this->input->get_post('totalamount');
	// 	$tax1=$this->input->get_post('tax');
	// 	//$paidamount1=$this->input->get_post('paidamount');
	// 	$paidcash=$this->input->get_post('paidcash');
	// 	$paidbank=$this->input->get_post('paidbank');
	// 	//$oldpaidamount=$this->input->get_post('oldpaidamount');
	// 	$paymentmode=$this->input->get_post('paymentmode');
	// 	$discount1=$this->input->get_post('discount');
	// 	$olddiscount=$this->input->get_post('olddiscount');
	// 	$grandtotal1=$this->input->get_post('grandtotal');
	// 	$oldgrandtotal=$this->input->get_post('oldgrandtotal');
	// 	$stock1=$this->input->get_post('stock');
	// 	$oldstock=$this->input->get_post('oldstock');
	// 	$cash=$this->input->get_post('cash');
	// 	$bank=$this->input->get_post('bank');
	// 	$customer=$this->input->get_post('customer');
	// 	$balance1=$this->input->get_post('balance');
	// 	$oldbalance=$this->input->get_post('oldbalance');
	// 	//paid amount
	// 	// $paidamount=$paidamount1-$oldpaidamount;
	// 	$discount=$discount-$olddiscount;
    //     $grandtotal=$grandtotal1-$oldgrandtotal;
    //     $stock=$stock1-$oldstock;
    //     $balance=$oldbalance-$balance1;
	// 	//sales
	// 	$sales1=$grandtotal-$tax;
	// 	// $oldsales=$oldgrandtotal-$oldtax;
	// 	// $sales=$sales1-$oldsales;
	// 	// select customer ledger
	// 	$data['records']=$this->Onlinemodel->Select_customerledger($customer);
	// 	$customer=$data['records']['customeraccount'];
    //    	$data=array();
    //    	$data=$this->Salesmodel->salesaccount($sales,$discount,$tax,$stock,$cash,$bank,$paidcash,$paidbank,$customer,$balance);
    //    	echo json_encode($data);
	// 	//sales account
    // }

    public function delete_salesinvoicemaster()
    {
		$invoiceno=$this->input->get_post('masterid');
     	$delete=$this->Salesmodel->delete_salesinvoicemaster($invoiceno);
     	// $a="df";
     	echo json_encode($invoiceno);
     }
    public function deletesalesinvoicedetails()
    {
		$originalDate = $this->input->post('salesdate'); 
	 	$newDate = date("Y-m-d H:i:s", strtotime($originalDate));
		$invoiceno=$this->input->post('invoiceno');
    	$branch=$this->input->post('branchid');
		$batch=$this->input->post('batchid');
		$product=$this->input->post('productcode');
		$qty1=$this->input->post('qty');
		$size=$this->input->post('size');
		$data1=$this->Salesmodel->deltesalesgrid($invoiceno,$product,$batch,$size);
		$transactiontype='Sales Invoice Delete';
    	$date=$newDate;
    	$userid=$this->session->userdata('user');
      	// $qty=($qty1) * (-1);
		$stock=$this->Onlinemodel->updatestock($product,$size,$qty1,$branch,$batch,$invoiceno,$transactiontype,$date,$userid);
     	// $a="uuhg";
     	echo json_encode($data1);
    }

    public function deleteSalesInvoice_DayBookInsertion()
	{ 
		$originalDate = $this->input->post('date'); 
	 	$newDate = date("Y-m-d H:i:s",strtotime($originalDate."+1 minutes")); 
		$data=array();
		$voucherno=$this->input->post('voucherno');
		$grand=$this->input->post('grandtotal')*1;
		$tax=$this->input->post('tax')*1;
		$total=$this->input->post('totalamount');
		$paidcash=$this->input->post('paidcash');
		$paidbank=$this->input->post('paidbank');
		$balance=$this->input->post('balance');
		$discount=$this->input->post('discount')*1;
		$customer=$this->input->post('customer');
		$cash=$this->input->post('cashaccount');
		$bank=$this->input->post('bankaccount');
		$stock=$this->input->post('stock');
		$sales=$grand-$tax+$discount;
		$data2=array();
		//sales account
		$data2['invoiceno']=$voucherno;
		$data2['accountType']='Sales Delete';
		$data2['date']=$newDate;
		$data2['ledgername']=21;
		$data2['debit']=$total;
		$data2['credit']=0;
		$data2['userid']=$this->session->userdata('user');
		$data2['opposite']=$customer;

		$data22=$this->Onlinemodel->insert_newdaybook($data2);

		//stock account
		$data2['ledgername']=4;
		$data2['debit']=$stock;
		$data2['credit']=0;
		$data2['opposite']=21;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);

		//cash account
		$data2['ledgername']=$cash;
		$data2['debit']=0;
		$data2['credit']=$paidcash;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);

		//bank account
		$data2['ledgername']=$bank;
		$data2['debit']=0;
		$data2['credit']=$paidbank;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);

		//cost of sales
		$data2['ledgername']=22;
		$data2['debit']=0;
		$data2['credit']=$stock;
		$data22=$this->Onlinemodel->insert_newdaybook($data2);

		//discount of sales
		if($discount>0)
		{
			$data2['ledgername']=28;
			$data2['debit']=0;
			$data2['credit']=$discount;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//customer
		if($balance<0)
		{
			$data['records']=$this->Onlinemodel->Select_customerledger($customer);
			$ledgername=$data['records']['customeraccount'];
			$data2['ledgername']=$ledgername;
			$abs=abs($balance);
			$data2['debit']=0;
			$data2['credit']=$abs;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		//tax
		if($tax>0)
		{
			$data2['ledgername']=23;
			$data2['debit']=0;
			$data2['credit']=$tax;
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
     
      
    //account insertion


 	public function editestimate()
	{
		$data=array();
		$data['master']=$this->Salesmodel->getsalesestimate();
		// $data['detailes']=$this->Onlinemodel->getsalesdetailes();
				if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
		$this->load->view('viewestimate',$data);
		$this->load->view('footer');
	}

   	public function insert_salesestimatemaster()
	{
		$data=array(
		'invoiceno'=>$this->input->post('invoiceno'),
		'customerid'=>$this->input->post('customer'),
		'salesorderno'=>$this->input->post('salesorderno'),
		'salesmode'=>$this->input->post('Paymentmode'),
		'salesdate'=>$this->input->post('salesdate'),
		'totalqty'=>$this->input->post('totalqty'),
		'totalamount'=>$this->input->post('totalamount'),
		'additionalcost'=>$this->input->post('additionalcost'),
		'taxamount'=>$this->input->post('taxamount'),
		'billdiscount'=>$this->input->post('billdiscount'),
		'grandtotal'=>$this->input->post('grandtotal'),
		'oldbalance'=>$this->input->post('oldbalance'),
		'stockamount'=>$this->input->post('totalstockamount'),
		'cashorbank'=>$this->input->post('cashorbank'),
		'paidamount'=>$this->input->post('paidamount'),
		'balance'=>$this->input->post('balance'),
		'narration'=>$this->input->post('narration'),
		//'transportcompany'=>$this->input->post('transportcompany'),
		'branchid'=>$this->input->post('branchid')
		);		 
		$dat=$this->Salesmodel->insert_salesestimatemaster($data);
		$sales=$this->input->post('totalamount');
        $taxamount=$this->input->post('taxamount');
        $cost=$this->input->post('grandtotal');
        echo json_encode($sales);
	}


	public function insert_salesestimatedetails()
	{
		$data=array(
		'invoiceno'=>$this->input->post('invoiceno'),
		'salesdate'=>$this->input->post('salesdate'),
		'productname'=>$this->input->post('productname'),
		'productcode'=>$this->input->post('productcode'),
		'qty'=>$this->input->post('qty'),
		'unitprice'=>$this->input->post('mrp'),
		'netamount'=>$this->input->post('netamount'),
		'tax'=>$this->input->post('tax'),
		'taxamount'=>$this->input->post('taxamount'),
		'amount'=>$this->input->post('amount'),
	    //'branchid'=>$this->input->post('branchid'),
		'batchid'=>$this->input->post('batchid')
		);		 
		$data=$this->Salesmodel->insert_salesestimatedetails($data);
		// $branch=$this->input->post('branchid');
		// $batch=$this->input->post('batchid');
		// $product=$this->input->post('productcode');
		// $qty=$this->input->post('qty');
		// $stock=$this->Salesmodel->sales_stock($product,$qty,$branch,$batch);
        echo json_encode($qty);
	}

	public function savestimate()
	{
		$a=$this->input->get_post('voucher');
     	$data=array();
		$data['product']=$this->Onlinemodel->getproduct();
		$data['branch']=$this->Onlinemodel->getBranch();
		$data['batch']=$this->Onlinemodel->getbatch();
		$data['invoiceno']=$this->Onlinemodel->Autogenerate_InvoiceNo();
		$data['customer']=$this->Onlinemodel->getcustomer();
		$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
		// $data['master']=$this->Onlinemodel->getsalesmaster();
		$data['branch']=$this->Onlinemodel->getBranch();
		$data['master']=$this->Salesmodel->getestimatemaster($a);
		$data['detailes']=$this->Salesmodel->getestimatedetailes($a);
		$this->load->view('header');
		$this->load->view('savestimate',$data);
		$this->load->view('footer');
	}

	public function deleteestimate()
	{
		$inv=$this->input->get_post('invoiceno');
    	$data=$this->Salesmodel->deleteestimate($inv);
    	echo json_encode($data);
	}

	public function insert_ecommerce_ordermaster()
	{
		$data=array(
		'eCommerce_no'=>$this->input->post('invoiceno'),
		'customerid'=>$this->input->post('customer'),
		'salesorderno'=>$this->input->post('salesorderno'),
		'date_current'=>$this->input->post('salesdate'),
		'salesman'=>$this->input->post('salesman'),
		'qty'=>$this->input->post('totalqty'),
		'cash_payment'=>$this->input->post('paidcash'),
		'bank_payment'=>$this->input->post('paidbank'),
		'narration'=>$this->input->post('narration'),
		'branchid'=>$this->input->post('branchid')
		// 'transportcompany'=>$this->input->post('transportcompany'),
		);	
		$customerid = $this->input->get_post('customer');
        $DATE=$this->input->get_post('salesdate');
		$sales = $this->input->get_post('totalamount');
		$points = $this->input->get_post('pointredeem');	 
		$dat1=$this->Salesmodel->insert_ecommerce_ordermaster($data);
		if($dat1)
		{
			if($points!=0)
            {
                $a=$this->Salesmodel->redeempoints($dat1,$customerid,$points,$DATE);
            }
            $addpoints =($sales*1/100);
            if($sales!=0)
            {
                $r=$this->Salesmodel->addpoints($dat1,$customerid,$addpoints,$DATE);
            }
		}
		echo json_encode($dat1);
	}

	public function insert_ecommerce_orderdetails()
	{
		date_default_timezone_set('Asia/Kolkata');
   		$newDate = date("Y-m-d H:i:s");
		$data=array(
		'eCommerce_no'=>$this->input->post('invoiceno'),
		'eordermasterid'=>$this->input->post('salesmasterid'),
		'orderdate'=>$this->input->post('salesdate'),
		'productname'=>$this->input->post('productname'),
	    'productcode'=>$this->input->post('productcode'),
	    'description'=>$this->input->post('descri'),
		'qty'=>$this->input->post('qty'),
		'hsncode'=>$this->input->post('hsn'),
		'size'=>$this->input->post('size'),
		'unitprice'=>$this->input->post('mrp'),
		'netamount'=>$this->input->post('netamount'),
		'tax'=>$this->input->post('tax'),
		'taxamount'=>$this->input->post('taxamount')*0,
		'amount'=>$this->input->post('amount'),
		'branchid'=>$this->input->post('branchid')	
		);		 
		$ans=$this->Salesmodel->insert_ecommerce_orderdetails($data);
		if($ans)
		{
			$voucherno=$this->input->post('invoiceno');
    		$transactiontype='Ecommerce Order';
    		$date=$newDate;
    		$userid=$this->session->userdata('user');
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
		// $branch=$this->input->post('branchid');
		// $check=$this->Salesmodel->checkproduct($name,$size,$branch,$batch);
		// $stock=$this->Salesmodel->sales_stock($product,$size,$qty,$branch,$batch);
        echo json_encode($ans);
	}    
	
	public function autogenerate_einv()
	{
		$this->load->model('Onlinemodel');
		$branchid = $this->input->get_post('branchid');
		$data=$this->Onlinemodel->Autogenerate_eInvoiceNoNew($branchid);
		echo json_encode($data);
	}


}
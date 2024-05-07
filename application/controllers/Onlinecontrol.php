<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlinecontrol extends CI_Controller {

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

	public function index()
	{

		if( $this->session->userdata('name'))
		{ 
			if($this->session->userdata('role')=="Branch User"){

				$this->load->view('admin/header_2');
			}
				
				else{
				$this->load->view('admin/header');

				}
		    $this->load->view('admin/index.html');
		    $this->load->view('admin/footer');
		}
		else
		{
	      $this->load->view('login.html');
	  	}
	}

	public function Login()
	{ 
		echo "44444"; die();
	    $data['username'] = $this->input->get_post('username');
	    $data['password']=$this->input->get_post('password');
	    $this->load->model('Onlinemodel');
	    $login=$this->Onlinemodel->login($data);
		if($login==true)
	    {
	        // $this->load->view('header');
		    $this->load->view('admin/index.html');
		    // $this->load->view('footer');
		}
	    else
	    {
			?> <script type="text/javascript">
			alert('incorrect username or password');
			</script> <?php 
		    $this->load->view('admin/index.html');
            // $this->load->view('LoginForm');
	    }
    }
	public function multicurrency()
	{
 
		if($this->session->userdata('name'))
		{
			$data['product']=$this->Onlinemodel->getproductonline();
				  // $data['currency']=$this->Onlinemodel->getcurrency();
			$data['multicurrency']=$this->Onlinemodel->getmulticurrency();
			$this->load->view('header');
			$this->load->view('multicurrency',$data);
			$this->load->view('footer');
		}
		else{
			?>
			<script type="text/javascript">
				alert("please login again");
			</script>
			<?php 
			$this->index();
		} 
	}
	public function insert_multicurrency()
	{
		$action=$this->input->post('save');

		if($action=="Save"){
			$data=array();

			$data['productcode']=$this->input->post('product');
			$data['inr']=$this->input->post('inr');

			$data['aed']=$this->input->post('aed');
			$data['usd']=$this->input->post('usd');

			$result=$this->Onlinemodel->insert_multicurrency($data);

		}
		echo json_encode(true);

	}
	
	
public function update_multicurrency()
{
	$data=array();
	$data['mrp']=$this->input->post('inr');
	$data['aed']=$this->input->post('aed');
	$data['usd']=$this->input->post('usd');
	$id=$this->input->post('product');
	$this->load->model('Onlinemodel');
	$update =$this->Onlinemodel->update_multicurrency($id,$data);
	echo json_encode($update);
}

public function update_shippingcharge()
{
	$data=array();
	$data['country']=$this->input->post('country');
   	$data['currency']=$this->input->post('currency');
   	$data['charge']=$this->input->post('charge');
   	$id=$this->input->get_post('shippingid');
	$this->load->model('Onlinemodel');
    $update =$this->Onlinemodel->update_shippingcharge($id,$data);
	echo json_encode($update);
}

public function branchreport()
{
	$fromdate=$this->input->get_post('fromdate');
	$tdate=$this->input->get_post('tdate');
	$br=$this->input->get_post('branch');
	if($fromdate==null)
	{

		$fromdate=date('Y-m-01', strtotime(date('Y-m')." -1 month"));

		// $fromdate=date('Y-m-01');
	}
	if($tdate==null)
	{

		$tdate=date('Y-m-t', strtotime(date('Y-m')." -1 month"));

		// $tdate=date('Y-m-t');
		$todate=$tdate;
	}
	else
	{
		$todate=date_add($tdate,date_interval_create_from_date_string("1 days"));
		$todate=date_format($todate,"Y-m-d");
	}
	if($this->session->userdata('name'))
	{
		$this->load->model('Onlinemodel');
		$branchid = $this->session->userdata('branch');
		$branchh=$branchid;
		$data=array();
		$userid=$this->session->userdata('user');
		$data['users']=$this->Onlinemodel->getuserid($userid);
		if($this->session->userdata('role')=="Super Admin")
		{
			$data['branch']=$this->Onlinemodel->getBranch();
		}
		else
		{
			$data['branch']=$this->Onlinemodel->getUserBranch($branchid);
		}
		$data['branchid']=$branchh;
		$data['fromdate'] = $fromdate;
		$data['todate'] =  $todate;

		if($this->session->userdata('role')=="Branch User")
		{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
		$this->load->view('branchreport',$data);
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


public function walletreport_super()
{

	if($this->session->userdata('name'))
	{
		$this->load->model('Onlinemodel');

		$branchid=$this->input->get_post('branch');


		if($branchid==null)
		{

			$branchid = $this->session->userdata('branch');


		}else{

			$branchid=$this->input->get_post('branch');

		}

		$data=array();
		$userid=$this->session->userdata('user');
		$data['users']=$this->Onlinemodel->getuserid($userid);

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
		$data['fromdate'] =  $fromdate;
		$data['todate'] =  $todate;

		$data['ledger']=$this->Onlinemodel->getwalletbalance($branchid,$fromdate,$todate);
		$data['supplier']=$this->Onlinemodel->getsupplierbranch($branchid);



		// if ($branchid == 30) {

		// $data['openg_stock']=$this->Onlinemodel->getopenigstock();

//           }

		$data['branch']=$this->Onlinemodel->getBranch();
		$data['branchid']=$branchid;


		$this->load->view('header');
		$this->load->view('walletreport_super',$data);
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


public function walletreport()
{

	if($this->session->userdata('name'))
	{
		$this->load->model('Onlinemodel');
		$branchid = $this->session->userdata('branch');
		$branchh=$branchid;
		$data=array();
		$userid=$this->session->userdata('user');
		$data['users']=$this->Onlinemodel->getuserid($userid);

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
		$data['fromdate'] =  $fromdate;
		$data['todate'] =  $todate;

		$data['ledger']=$this->Onlinemodel->getwalletbalance($branchid,$fromdate,$todate);
		$data['supplier']=$this->Onlinemodel->getsupplierbranch($branchid);



		// if ($branchid == 30) {

		// $data['openg_stock']=$this->Onlinemodel->getopenigstock();

//           }


		$this->load->view('header_2');
		$this->load->view('walletreport',$data);
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

public function getStockRegReport()
{
	$data=array();
	$branch = $this->input->get_post('branch');
	$fdate = $this->input->get_post('fdate');
	$tdate = $this->input->get_post('tdate');
	$todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
	$todate=date_format($todate,"Y-m-d");
	$data=$this->Onlinemodel->getstokregreport($fdate,$todate,$branch);
	echo json_encode($data);
}

public function getStockRegPDTReport()
{
	$data=array();
	$branch = $this->input->get_post('branch');
	$pdt_id = $this->input->get_post('pdt_id');

	$data=$this->Onlinemodel->getstokPDTregreport($pdt_id,$branch);
	echo json_encode($data);
}

public function getbranchreport()
{
	$data=array();
	$branch = $this->input->get_post('branch');
	$fdate = $this->input->get_post('fdate');
	$tdate = $this->input->get_post('tdate');
	$todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
	$todate=date_format($todate,"Y-m-d");
	$data=$this->Onlinemodel->getbranchreport($fdate,$todate,$branch);
	//    $data['res2']=$this->Onlinemodel->getreportdata($fdate,$todate,$branch);
	//    $data['res3']=$this->Onlinemodel->getreportdata2($branch);
	echo json_encode($data);
}

//    public function getreportdata()
//    {
// 	   $data=array();
// 	   $branch = $this->input->get_post('branch');
// 	   $fdate = $this->input->get_post('fdate');
// 	   $tdate = $this->input->get_post('tdate');
// 	   $todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
// 	   $todate=date_format($todate,"Y-m-d");
// 	   $res=$this->Onlinemodel->getreportdata($fdate,$todate,$branch);
//     $data['expense']=$this->Onlinemodel->getreportdata2($branch);
// 	   echo json_encode($res);
//    }
	
public function shippingcharge()
{
	if($this->session->userdata('name'))
	{
		$data['currency']=$this->Onlinemodel->getcurrency();
		$data['shippingcharge']=$this->Onlinemodel->getshippingcharge();
 	    $this->load->view('header');
		$this->load->view('shippingcharge',$data);
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

//    public function update_multicurrency(){

// 		$data=array();
// 		$data['productcode']=$this->input->post('product');
//    	$data['currency']=$this->input->post('currency');
//    	$data['rate']=$this->input->post('rate');
//    	$id=$this->input->get_post('multicurrencyid');
// 	 	$this->load->model('Onlinemodel');
//      $update =$this->Onlinemodel->update_multicurrency($id,$data);
//      echo json_encode($update);

//    }
	public function delete_multicurrency()
	{
		$id=$this->input->get_post('multiid');
		$this->load->model('Onlinemodel');
		$delete=  $this->Onlinemodel->delete_multicurrency($id);


		echo json_encode($delete);


	}
	
	

	public function logout()
	{
		$this->session->unset_userdata('name');
        $this->index();
	}

	public function product_group()
	{                   
	  if( $this->session->userdata('name'))
	  { 
		if($this->session->userdata('role')=="Super Admin")
		{
			$this->load->model('Onlinemodel');
			$data['table']=$this->Onlinemodel->get_productgroup();
			$this->load->view('header');
			$this->load->view('Productgroup',$data);
			$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Branch User")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
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

	public function importInvo()
	{
		if( $this->session->userdata('name'))
		{ 
			// $data['query']=$this->Onlinemodel->get_eimpo_inv();
			// $data['branch']=$this->Onlinemodel->getBranch();
			$this->load->view('header');
			$this->load->view('ImportInvoice');
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


	public function import_fbase()
	{

		$path = './assets/uploads/';
		require_once APPPATH . "third_party/PHPExcel.php";
		$config['upload_path'] = $path;
		$config['allowed_types'] = 'xlsx|xls|csv';
		//$config['remove_spaces'] = TRUE;
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 

		if ($this->upload->do_upload('uploadFile')) {

			$data = array('upload_data' => $this->upload->data());
			$import_xls_file = $data['upload_data']['file_name'];      
			$inputFileName = $path . $import_xls_file;
			$object = PHPExcel_IOFactory::load($inputFileName);
			$newDate = date("Y-m-d H:i:s");


			foreach($object->getWorksheetIterator() as $worksheet)
			{

				$highestRow    = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();

				for($row = 2; $row <= $highestRow; $row++)
				{

					$invoiceno = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$customerid = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$salesorderno = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
					$salesmode = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
					$sales_date = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
					$totalqty = $worksheet->getCellByColumnAndRow(38, $row)->getValue();
					$sales = $worksheet->getCellByColumnAndRow(37, $row)->getValue();
					$additionalcost = $worksheet->getCellByColumnAndRow(42, $row)->getValue();
					$taxamount = $worksheet->getCellByColumnAndRow(36, $row)->getValue();
					$billdiscount = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$grandtotal = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
					$oldbalance = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
					$cash = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
					$bank = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
					$paidcash = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
					$paidbank = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
					$narration = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
					$salesman = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
					$stockamount = $worksheet->getCellByColumnAndRow(34, $row)->getValue();
					$userid = $worksheet->getCellByColumnAndRow(39, $row)->getValue();
					$branchid = $worksheet->getCellByColumnAndRow(43, $row)->getValue();
					$finyear = 4;


					$items = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

					// $deatls = array();
					$deatls = json_decode($items , true );
					$count =  count($deatls);

					
					$existence=$this->Salesmodel->api_checkexistence_invoiceno($invoiceno,$branchid,$finyear)->result();
					$result=sizeof($existence);

					if($result==0)
					{

						$insertdata['invoiceno'] = $invoiceno;
						$insertdata['customerid'] = $customerid;
						$insertdata['salesorderno'] = $salesorderno;               
						$insertdata['salesmode'] =$salesmode;
						$insertdata['salesdate'] = $sales_date;
						$insertdata['totalqty'] = $totalqty;
						$insertdata['totalamount'] = $sales;
						$insertdata['additionalcost'] = $additionalcost;
						$insertdata['taxamount'] = $taxamount;
						$insertdata['billdiscount'] = $billdiscount;
						$insertdata['grandtotal'] = $grandtotal;
						$insertdata['oldbalance'] = $oldbalance;
						$insertdata['cash'] = $cash;
						$insertdata['bank'] = $bank;
						$insertdata['paidcash'] = $paidcash;
						$insertdata['paidbank'] =$paidbank;
						$insertdata['finyear'] =4;
						$balance=$paidcash+$paidbank-$grandtotal;
						if($balance>0){
							$insertdata['paidcash'] =$paidcash-$balance;
							$balance=0;
						}
						$insertdata['balance'] = $balance;
						$insertdata['narration'] = $narration;
						$insertdata['branchid'] = $branchid;    
						$insertdata['salesman'] = $salesman;   
						$insertdata['stockamount'] = $stockamount; 
						$insertdata['userid'] =$userid; 
						$dat1=$this->Salesmodel->insert_salesinvoicemaster($insertdata);

$dybuk = $this->api_SalesInvoice_DayBookInsertion($invoiceno,$paidcash,$paidbank,$sales,$billdiscount,$grandtotal,$customerid,$balance, $sales_date,$cash,$bank,$stockamount, false);

log_message('error',$dybuk);

						if ($dat1 !== null) {


						for ($i=0; $i < $count; $i++) { 

							$mrp = $deatls[$i]['mrp'];
							$qtyy = $deatls[$i]['qty'];

							$taxx=5;
							$taxxamount=0;
							if($mrp>999){
								$taxx=12;
							}

								$taxxamount=($qtyy*$mrp)*$taxx/(100+$taxx);
								$insertdata2=array();
								$value=$invoiceno;
								$insertdata2['salesmasterid'] = $dat1;
								$insertdata2['invoiceno'] = $value;
								$insertdata2['salesdate'] = $sales_date;
								$insertdata2['productname'] = $deatls[$i]['productName'];
								$insertdata2['productcode'] = $deatls[$i]['prdCode'];
								$insertdata2['qty'] = $qtyy;
								$insertdata2['size'] = $deatls[$i]['sizeId'];
								$insertdata2['unitprice'] = $mrp;
								$insertdata2['netamount'] =($qtyy*$mrp)-$taxxamount;
								$insertdata2['tax'] = $taxx;
								$insertdata2['taxamount'] = $taxxamount;
								$insertdata2['amount'] = ($qtyy*$mrp);
								$insertdata2['branchid'] =$branchid;
								$insertdata2['batchid'] = 0;
								$insertdata2['finyear'] =4;

								$ans=$this->Salesmodel->insert_salesinvoicedetails($insertdata2);

								if ($ans == true) {
									$voucherno=$invoiceno;
									$transactiontype='Sales Invoice';
									$date= $sales_date;
                    // $userid=$product->userid;
                    // $branch=$product->branchid;
									$batch=0;
									$product=$deatls[$i]['prdCode'];
									$qty=$qtyy;
									$size= $deatls[$i]['sizeId'];
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
										$stock=$this->Onlinemodel->updatestock($product,$size,($qty*-1),$branchid,$batch,$voucherno,$transactiontype,$date,$userid);
									}

								}else{ echo json_encode(false);}

							// for count
							}

						}else{ echo json_encode(false); }


					}else{
						// already invoiceno
					}

// last highestRow
				}

// last worksheet excel forech
			}


		}else{
			echo "Not upload";

			$this->index();
		}


		if (1 == 1) {
			?><script type="text/javascript">
				alert('Succes Sales insertion........');
			</script>
			<?php

			$this->index();
		}

	}

	public function api_SalesInvoice_DayBookInsertion($invoiceno,$paidcash,$paidbank,$sales,$billdiscount,$grandtotal,$customerid,$balance, $sales_date,$cash,$bank,$stockamount,$status = true)
	{  

	$total=$sales;
	$discount=$billdiscount;
	$grand=$grandtotal*1;
	$tax=0;
	$customer =$customerid;
	$balance =$balance;
	$DATE=$sales_date;
	$cash = $cash;
	$bank = $bank;
	$stock=$stockamount;
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



public function import_fbase_return()
{

	$path = './assets/uploads/';
	require_once APPPATH . "third_party/PHPExcel.php";
	$config['upload_path'] = $path;
	$config['allowed_types'] = 'xlsx|xls|csv';
		//$config['remove_spaces'] = TRUE;
	$this->load->library('upload', $config);
	$this->upload->initialize($config); 

	if ($this->upload->do_upload('uploadFile')) {

		$data = array('upload_data' => $this->upload->data());
		$import_xls_file = $data['upload_data']['file_name'];      
		$inputFileName = $path . $import_xls_file;
		$object = PHPExcel_IOFactory::load($inputFileName);
		$newDate = date("Y-m-d H:i:s");


		foreach($object->getWorksheetIterator() as $worksheet)
		{

			$highestRow    = $worksheet->getHighestRow();

			$highestColumn = $worksheet->getHighestColumn();


			for($row = 2; $row <= $highestRow; $row++)
			{
				$invoiceno = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$customerid = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				$masterid = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
				$return_date = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

				$totalqty = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
				$sales = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
				$additionalcost = $worksheet->getCellByColumnAndRow(34, $row)->getValue();
				$taxamount = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
				$billdiscount = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				$grandtotal = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
				$oldbalance = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
				$cash = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				$bank = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				$paidcash = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
				$paidbank = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
				$balance = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				$narration = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
				$branchid = $worksheet->getCellByColumnAndRow(35, $row)->getValue();
				
				$salesman = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
				$stockamount = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
				$userid = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
				$finyear = 4;

				$items = $worksheet->getCellByColumnAndRow(4, $row)->getValue();

					// $deatls = array();
				$deatls = json_decode($items , true );
				// $count =  count($deatls);
				$count =  count(array($deatls));

				log_message('error',$invoiceno);


				$existence=$this->Salesmodel->api_checkexistence_retinvoiceno4($invoiceno,$branchid,$finyear)->result();
				$result=sizeof($existence);

				if($result==0)
				{

					$this->load->model('Salesmodel');
					$insertdata['invoiceno'] = $invoiceno;
					$insertdata['customerid'] = $customerid;
					$insertdata['salesmasterid'] = $masterid;
					$insertdata['salesdate'] = $return_date;
					$insertdata['totalqty'] = $totalqty;
					$insertdata['totalamount'] = $sales;
					$insertdata['additionalcost'] = $additionalcost;
					$insertdata['taxamount'] = $taxamount;
					$insertdata['billdiscount'] = $billdiscount;
					$insertdata['grandtotal'] = $grandtotal;
					$insertdata['oldbalance'] =$oldbalance;
					$insertdata['cash'] = $cash;
					$insertdata['bank'] = $bank;
					$insertdata['paidcash'] = $paidcash;
					$insertdata['paidbank'] = $paidbank;
					$insertdata['balance'] = $balance;
					$insertdata['narration'] = $narration;
					$insertdata['branchid'] = $branchid;    
					$insertdata['salesman'] = $salesman;   
					$insertdata['stockamount'] = $stockamount; 
					$insertdata['finyear'] =4;
					$insertdata['userid'] = $userid;
					$dat=$this->Salesmodel->insert_salesreturnmaster($insertdata);


					$sales=$grandtotal;
					$cost=$stockamount;
					$addpoints=($sales*-1/100);
					if($addpoints!=0)
					{
						$r=$this->Salesmodel->addpoints($dat,$customerid,$addpoints,$return_date);
					}

					$dybuk = $this->salesReturn_DayBookInsertion($invoiceno,$paidcash,$paidbank,$sales,$billdiscount,$grandtotal,$customerid,$balance, $return_date,$cash,$bank,$stockamount, false);

					// log_message('error',$dybuk);

					if ($dat !== null) {

						for ($i=0; $i < $count; $i++) { 

							$mrp = $deatls[$i]['mrp'];
							$qtyy = $deatls[$i]['qty'];

							$taxx=5;
							$taxxamount=0;
							if($mrp>999){
								$taxx=12;
							}

							$taxxamount=($qtyy*$mrp)*$taxx/100;
							$insertdata2=array();
							$value=$invoiceno;
							$insertdata2['salesreturnid'] = $dat;
							$insertdata2['invoiceno'] = $invoiceno;
							$insertdata2['salesdate'] = $return_date;
							$insertdata2['productname'] = $deatls[$i]['productName'];
							$insertdata2['productcode'] = $deatls[$i]['prdCode'];
							$insertdata2['qty'] = $qtyy;
							$insertdata2['size'] = $deatls[$i]['sizeId'];
							$insertdata2['unitprice'] = $mrp;
							$insertdata2['netamount'] =$qtyy*$mrp;
							$insertdata2['tax'] = $taxx;
							$insertdata2['finyear'] =4;
							$insertdata2['taxamount'] = $taxxamount;
							$insertdata2['amount'] = ($qtyy*$mrp)+$taxxamount;
							$insertdata2['branchid'] =$branchid;
							$insertdata2['batchid'] = 0;
							$ans=$this->Salesmodel->insert_salesreturndetails($insertdata2);
							if ($ans == true) {

							$voucherno=$invoiceno;
							$transactiontype='Sales Return';
							$date= $return_date;

							$branch=$branchid;
							$batch=0;
							$product=$deatls[$i]['prdCode']; 

							$size= $deatls[$i]['sizeId']; 
							$stck=array();
							$stck['productid']=$product;
							$stck['currentstock']=$qtyy;
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
								$stock=$this->Onlinemodel->updatestock($product,$size,$qtyy,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
							}

							}else{ echo json_encode(false);}

							// for count
						}

					}else{ echo json_encode(false); }


				}else{
				log_message('error',"already");

				// already invoiceno
				}

			// last highestRow
			}

		// last worksheet excel forech
		}


	}else{
		echo "Not upload";

		$this->index();
	}


	if (1 == 1) {
		?><script type="text/javascript">
			alert('Succes Sales Return insertion........');
		</script>
		<?php

		$this->index();
	}

}


		public function salesReturn_DayBookInsertion($invoiceno,$paidcash,$paidbank,$sales,$billdiscount,$grandtotal,$customerid,$balance, $return_date,$cash,$bank,$stockamount,$status = true)

		{    

			$total = $sales;
			$discount = $billdiscount;

			$data2=array(); 
		        // sales account
			$data2['invoiceno']=$invoiceno;
			$data2['accountType']='Sales Return';
			$data2['date']=$return_date;
			$data2['ledgername']=21;
			$data2['debit']=$total;
			$data2['credit']=0;
			$data2['opposite']=$customerid;
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
			$data['records']=$this->Onlinemodel->Select_customerledger($customerid);
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



		public function import_fbase_customer()
		{
			$path = './assets/uploads/';
			require_once APPPATH . "third_party/PHPExcel.php";
			$config['upload_path'] = $path;
			$config['allowed_types'] = 'xlsx|xls|csv';
			//$config['remove_spaces'] = TRUE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config); 

			if ($this->upload->do_upload('uploadFile')) {

				$data = array('upload_data' => $this->upload->data());
				$import_xls_file = $data['upload_data']['file_name'];      
				$inputFileName = $path . $import_xls_file;
				$object = PHPExcel_IOFactory::load($inputFileName);
				$newDate = date("Y-m-d H:i:s");


				foreach($object->getWorksheetIterator() as $worksheet)
				{

					$highestRow    = $worksheet->getHighestRow();
					$highestColumn = $worksheet->getHighestColumn();

					for($row = 2; $row <= $highestRow; $row++)
					{
						$invoiceno = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$customerid = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
						$salesorderno = $worksheet->getCellByColumnAndRow(33, $row)->getValue();
						$salesmode = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
						$return_date = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
						$totalqty = $worksheet->getCellByColumnAndRow(38, $row)->getValue();
						$sales = $worksheet->getCellByColumnAndRow(37, $row)->getValue();
						$additionalcost = $worksheet->getCellByColumnAndRow(42, $row)->getValue();


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
				}
			}else{
				echo "Not upload";

				$this->index();
			}


			if (1 == 1) {
				?><script type="text/javascript">
					alert('Succes Customer insertion........');
				</script>
				<?php

				$this->index();
			}
		}



	public function insert_productgroup()
	{
		$action=$this->input->get_post('save');
		if($action=="Save") 
		{
            $data['groupname']=$_POST['groupname'];
            $data['narration']=$_POST['narration'];
            $data['taxlow']=$_POST['taxlow'];
            $data['slab']=$_POST['taxslab'];
            $data['taxhigh']=$_POST['taxhigh'];
            $data['hsncode']=$_POST['hsncode'];
            $data['weight']=$_POST['weight'];
			$data['groupunder']=$this->input->get_post('groupunder');
            $under=$this->input->get_post('groupunder');
            $value=$data['groupname'];
            $this->load->model('Onlinemodel');               
            $existence=$this->Onlinemodel->checkexistence_productgroup($value);
			if ($existence==0 ) 
			{
				$insert_productgroup =  $this->Onlinemodel->insert_productgroup($data,$under);
				if($insert_productgroup==true)
				{           	                                     
				}
				else
				{
        			?>
					<script type="text/javascript">
					alert('insertion failed. please check the inputs');
					</script>
					<?php 
            	}
                           
            }
			else
			{
                ?>
				<script type="text/javascript">
				alert('product group name already exists!!!!. please use another name');
				</script>
				<?php 
            }
        }
		else
		{
            $id=$_POST['groupid'];  
		    $data['groupname']=$_POST['groupname'];
			$data['narration']=$_POST['narration'];
			$data['taxlow']=$_POST['taxlow'];
            $data['slab']=$_POST['taxslab'];
            $data['taxhigh']=$_POST['taxhigh'];
            $data['hsncode']=$_POST['hsncode'];
            $data['weight']=$_POST['weight'];
            $data['groupunder']=$this->input->get_post('groupunder');
            $this->load->model('Onlinemodel');
            $update=  $this->Onlinemodel->update_productgroup($id,$data);
			if($update!=true)
			{
            	?>
				<script type="text/javascript">
				alert('updation failed!!!!!');
				</script>
				<?php 
            }
        }               
        $tablename="product_group";
        $this->product_group();
	}

	public function delete_productgroup()
	{
    	$id=$_POST['groupid'];
        $this->load->model('Onlinemodel');
        $delete=  $this->Onlinemodel->delete_productgroup($id);
		if($delete)
		{
        	?>
			<script type="text/javascript">
			alert('product group deleted successfully');
			</script>
			<?php
        }
        $tablename="product_group";
        $this->product_group();
	}
	
	public function home()
	{
		echo "qqqq"; die();
       $this->load->view('header');
	   $this->load->view('AccountGroup');
	   $this->load->view('footer');
	}
	
	public function unit()
	{
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['query']=$this->Onlinemodel->getunit();
				$this->load->view('header');
				$this->load->view('unit',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function insert_unit()
	{ 
		$action=$this->input->get_post('save');
		if ($action=="Save") 
		{
	    	$data=array();
			$data['unitname']=$this->input->get_post('uname');
			$data['narration']=$this->input->get_post('narration');
         	$value=$data['unitname'];
		    $this->load->model('Onlinemodel');                
	        $existence=$this->Onlinemodel->checkexistence_unit($value);
			if($existence==0)
			{
	            $result=$this->Onlinemodel->insert_unit($data);
				if($result==true)
				{ 
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('insertion failed. please check the inputs');
					</script>
					<?php 
                }
	    	}                 
			else 
			{
            	?>
				<script type="text/javascript">
				alert('product group name already exists!!!!. please use another name');
				</script>
				<?php 
            }
		}
		else
	 	{
			$data=array();
			$data['unitname']=$this->input->get_post('uname');
			$data['narration']=$this->input->get_post('narration');
			$id=$this->input->get_post('unitId');
		 	$this->load->model('Onlinemodel');
         	$update =$this->Onlinemodel->update_unit($id,$data);
	    }
        $data['query']=$this->Onlinemodel->getunit();
        $this->load->view('header');                      
	    $this->load->view('unit',$data);
		$this->load->view('footer');              
	}
	/*  if(confirm("confirm delete???"))
		{
			<?php
            $id=$_POST['unitId'];
            $this->load->model('Onlinemodel');
            $delete=  $this->Onlinemodel->delete_unit($id);
            ?>
		}
		else
		{
		}
	*/
	public function delete_unit()
	{
		$id=$this->input->get_post('unitId');
		$this->load->model('Onlinemodel');
		$delete= $this->Onlinemodel->delete_unit($id);
		if($delete)
		{
			?>
			<script type="text/javascript">
			alert('unit deleted successfully');
			</script>
			<?php 
		}
		$data['query']=$this->Onlinemodel->getunit();
		$this->load->view('header');
		$this->load->view('unit',$data);
		$this->load->view('footer');                   
	}
	
	public function supplier()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$this->load->model('Onlinemodel');
				$data['query']=$this->Onlinemodel->getsupplier();
				$data['branch']=$this->Onlinemodel->getBranch();
		    	$this->load->view('header');                
				$this->load->view('supplier',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function insert_supplier()
	{
	try {
		$action=$this->input->get_post('save');
		$supplieraccount =$this->input->get_post('supplieraccount');
		$data=array();
		$data['suppliername']=$this->input->get_post('suppliername');
		$data['address']=$this->input->get_post('address');
		$data['email']=$this->input->get_post('email');
		$data['website']=$this->input->get_post('website');
		$data['creationdate']= date("d-m-y h:i:sa ");
		$data['mobile']=$this->input->get_post('phone');
		$data['code']=$this->input->get_post('code');
		$data['city']=$this->input->get_post('city');
		$data['country']=$this->input->get_post('country');
		$data['vatno']=$this->input->get_post('vatno');
		$data['openingbalance']=$this->input->get_post('openingbalance');
		$data['supplierbalance']=$this->input->get_post('openingbalance');
		
        $value=$data['suppliername'];
		if($action=="Save")
		{
			$existence=$this->Onlinemodel->checkexistence_supplier($value);
		    if($existence==0)
		    {
				//Ledger Insertion_start
				$data2=array();
				$data2['ledgername']=$this->input->get_post('suppliername');
				$data2['accountgroup']='16';
				$data2['interestcalculation']=0;
				$data2['openingbalance']=$this->input->get_post('openingbalance');
				$data2['creditordebit']='Cr';
				$data2['rootid']='2';
				$data2['narration']='Autogenerated for Supplier';
				$data2['currentbalance']=$this->input->get_post('openingbalance');
				$data2['branchid']=$this->input->get_post('branch');
				$value2=$data2['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data2);
				$data['supplieraccount']=$ledgervalues;
				$data['branch']=$this->input->get_post('branch');
				$result=$this->Onlinemodel->insert_supplier($data);
				if($result==true)
				{
					if($ledgervalues!=true)
			    	{
						?>
						<script type="text/javascript">
						alert('Error in Ledger creation........');
						</script>
						<?php 
			    	}
					//Ledger Insertion_End
					?>
					<script type="text/javascript">
					alert('supplier detailes saved successfully');
					</script>
					<?php 
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('insertion failed. please check the inputs');
					</script>
					<?php 
	        	}
			}
			else
			{
				?>
				<script type="text/javascript">
				alert('supplier name already exists!!!!. please use another name');
				</script>
				<?php 
	    	}
		}
		else
		{ 
			
			
			$data2=array();
				$ledgername=$this->input->get_post('suppliername');
				$branchid=$this->input->get_post('branch');
				
				
$data['branch']=$this->input->get_post('branch');
				$ledgervalues=$this->Onlinemodel->update_accountledger($supplieraccount,$ledgername,$branchid);
			$id=$this->input->get_post('supplierid');
	    	$this->load->model('Onlinemodel');
	    	$update =$this->Onlinemodel->update_supplier($id,$data);
	    	?>
	    	<script type="text/javascript">
				// alert('<?php echo $supplieraccount ?>');
				</script>
				<?php 
			if(!$update)
			{
				?>
				<script type="text/javascript">
				alert('updation failed');
				</script>
				<?php 
	    	}
		}
		$data['query']=$this->Onlinemodel->getsupplier();
		$data['branch']=$this->Onlinemodel->getBranch();
		$this->load->view('header');
		$this->load->view('supplier',$data);
		$this->load->view('footer');
	}
catch (Exception $e) {
    echo $e->getMessage();
}
	}

	public function getproductname()
	{
		$a=$this->input->get('b');
		$this->load->model('Onlinemodel');
		$name=$this->Onlinemodel->getproductname($a);
		echo json_encode($name);
		// echo json_encode($data);
	}

	public function delete_supplier()
	{
        $id=$this->input->get_post('supplierid');
        $this->load->model('Onlinemodel');
        $delete=  $this->Onlinemodel->delete_supplier($id);
		if(!$delete)
		{
			?>
			<script type="text/javascript">
			alert('deletion failed!!!!');
			</script> <?php
		}
		else
		{
			?><script type="text/javascript">
			alert('Deleted Successfully.....');
			</script><?php
		}
		$data['query']=$this->Onlinemodel->getsupplier();
		$data['branch']=$this->Onlinemodel->getBranch();
		$this->load->view('header');
		$this->load->view('supplier',$data);
		$this->load->view('footer');               
	}
	
	
	public function brand()
	{
	    if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['query']=$this->Onlinemodel->getbrand();
				$this->load->view('header');
				$this->load->view('brand',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
	
	

	public function insert_brand()
	{   $action=$this->input->get_post('save');
	
         if($action=="Save"){
         	 $data=array();

		       $data['brandname']=$this->input->get_post('brandname');
		       $data['narration']=$this->input->get_post('narration');
               $value=$data['brandname'];

                        $existence=$this->Onlinemodel->checkexistence_brand($value);
	                          if($existence==0)
	                          {
	                         	$result=$this->Onlinemodel->insert_brand($data);
	                         	if ($result==true) {
                           	                           ?> <script type="text/javascript">
	alert('brand saved successfully');
</script>
<?php 
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('brand name already exists!!!!. please use another name');
</script> <?php 
                           }
         }
         elseif($action=="Update"){

		      $data=array();
		$data['brandname']=$this->input->get_post('brandname');
		$data['narration']=$this->input->get_post('narration');
		$id=$this->input->get_post('brandid');
		 
         $update =$this->Onlinemodel->update_brand($id,$data);
          

                           	                          
         }
         else{echo $action;}
                 
         
          $data['query']=$this->Onlinemodel->getbrand();

                                                        $this->load->view('header');
	                                                	$this->load->view('brand',$data);
		                                                $this->load->view('footer');
                      


		       
	}
	public function delete_brand()
	{
                          $id=$this->input->get_post('brandid');
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_brand($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('brand deleted successfully');
</script> <?php 
                        }
                      
                           	                           $data['query']=$this->Onlinemodel->getbrand();

                                                        $this->load->view('header');
	                                                	$this->load->view('brand',$data);
		                                                $this->load->view('footer');
                      
                           

	}
	
	public function batch()
	{
		if($this->session->userdata('name'))
		{
			$data['query']=$this->Onlinemodel->getbatch();
			$this->load->view('header');
	        $this->load->view('batch',$data);
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
	
	public function insert_batch()
	{
		$action=$this->input->get_post('save');
		if($action=="Save")
		{
			$data=array();
			$data['batchname']=$this->input->get_post('batchname');
			$data['narration']=$this->input->get_post('narration');
			$value=$data['batchname'];
			$existence=$this->Onlinemodel->checkexistence_batch($value);
			if($existence==0)
			{
				$result=$this->Onlinemodel->insert_batch($data);
				if ($result==true) {
					?> <script type="text/javascript">
						alert('batch saved successfully');
					</script>
					<?php 
				} else {
					?> <script type="text/javascript">
						alert('insertion failed. please check the inputs');
						</script> <?php 
					}
				}

				else {
					?>
					<script type="text/javascript">
						alert('batch name already exists!!!!. please use another name');
						</script> <?php 
					}
				}
				elseif($action=="Update"){

					$data=array();
					$data['batchname']=$this->input->get_post('batchname');
					$data['narration']=$this->input->get_post('narration');
					$id=$this->input->get_post('batchid');

					$update =$this->Onlinemodel->update_batch($id,$data);



				}
				else{echo $action;}


				$data['query']=$this->Onlinemodel->getbatch();

				$this->load->view('header');
				$this->load->view('batch',$data);
				$this->load->view('footer');




			}
	public function delete_batch()
	{
                          $id=$this->input->get_post('batchid');
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_batch($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('batch deleted successfully');
</script> <?php 
                        }
                      
                           	                           $data['query']=$this->Onlinemodel->getbatch();

                                                        $this->load->view('header');
	                                                	$this->load->view('batch',$data);
		                                                $this->load->view('footer');
                      
                           

	}
	public function Loadstockbycode()
    {
		$a=$this->input->get_post('code');
		
      	$data=array();
      	// echo current_url();
      	
		$data['detailes']=$this->Onlinemodel->Loadstockbycode($a);
		
		echo json_encode($data);
	}
	
	public function product()
	{

		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin" OR "Ecommerce Admin")
			{
				$data=array();
				$data['product']=$this->Onlinemodel->getproduct1();
				$data['unit']=$this->Onlinemodel->getunit();
				$data['group']=$this->Onlinemodel->get_productgroup();
				$data['size']=$this->Onlinemodel->getsize();
				$data['brand']=$this->Onlinemodel->getbrand();
				$data['batch']=$this->Onlinemodel->getBatch();
				$data['code']=$this->Onlinemodel->Autogenerate_pdt();
				$this->load->view('header');
				$this->load->view('product',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function Productsub()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin" OR "Ecommerce Admin")
			{
				$data=array();
				$data['product']=$this->Onlinemodel->getproduct1();
				$data['unit']=$this->Onlinemodel->getunit();
				$data['group']=$this->Onlinemodel->get_productgroup();
				$data['size']=$this->Onlinemodel->getsize();
				$data['brand']=$this->Onlinemodel->getbrand();
				$data['batch']=$this->Onlinemodel->getBatch();
				$data['code']=$this->Onlinemodel->Autogenerate_pdt();
				$this->load->view('header');
				$this->load->view('product_sub',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
					alert("Access Denied...!");
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

	Public function check_pdt()
	{

		$pdt = $this->input->post('product');
		$existence=$this->Onlinemodel->checkexistence_product($pdt);

		echo json_encode($existence);


	}

    public function insert_product()
	{     

		log_message('error',"____");

		$action=$this->input->get_post('save');
		$unitname=$this->input->get_post('unitid');
		$data['pdt_name']=$this->input->get_post('product');

		// $encode = base64_encode($this->input->post("code")); 
		// $decode = base64_decode($encode); 

		$data['pdt_code']=$this->input->get_post('code');
		$data['hsncode']=$this->input->get_post('hsn');
		$data['groupid']=$this->input->get_post('group');
		$data['purchaserate']=$this->input->get_post('pur_rate');
		$data['discountprice']=$this->input->get_post('dis_price');
		$data['brandid']=$this->input->get_post('brand');
		$data['mrp']=$this->input->get_post('mrp');
		$data['aed']=$this->input->get_post('aed');
		$data['usd']=$this->input->get_post('usd');
		// $data['square']=$this->input->get_post('square');
		$data['forpos']=$this->input->get_post('pos');
		$data['forecommerce']=$this->input->get_post('ecommerce');
		$data['forreseller']=$this->input->get_post('reseller');
		//$data['unitid']=$this->input->get_post('unit');
		$data['unitid'] =$this->input->get_post('unitid');
		// $data['sqft']=$this->input->get_post('square');
		// $data['tax']=$this->input->get_post('tax');
		$data['minimumstock']=$this->input->get_post('minimumstock');
		$data['openingstock']=$this->input->get_post('openingstock');
		$data['currentstock']=$this->input->get_post('openingstock');
		$data['narration']=$this->input->get_post('narration');
		
		$value=$data['pdt_name'];
		$code=$data['pdt_code'];
		$id=$this->input->get_post('productid');

		if($action=="Save")
		{ 

			log_message('error',"save");
		    $data12=array();
			$existence=$this->Onlinemodel->checkexistence_product($value);
			
	        if($existence==0)
	        {
				//image upload

	        	$config['upload_path'] = './images';
	        	$config['allowed_types'] = 'gif|jpg|png|jpeg';
	        	$config['max_size']      = '200000';
	        	$config['min_width']     = '14';
	        	$config['min_height']    = '7';
	        	$this->load->library('upload', $config);
	        	$this->upload->do_upload('img');
	        	$data12= $this->upload->data();

	        	$n=$data12['file_name'];
	        	$data['imagpath']=$n;
	        	$result=$this->Onlinemodel->insert_product($data);
	        	if($result!=0)
	        	{
	        		$data1['product_id']=$data['pdt_code'];
	        		$data1['unit']=$unitname;
	        		$data1['count']="1";
	        		$data1['bunit']=$this->input->get_post('unitid');

	        		$data1['rate']=$this->input->get_post('mrp');
                    // $data['product_id']=$this->input->get_post('');
	        		date_default_timezone_set('Asia/Kolkata');
	        		$newDate = date("Y-m-d H:i:s");
	        		$voucherno='0';
	        		$transactiontype='Opening Stock';
	        		$date=$newDate;
	        		$userid=$this->session->userdata('user');

	        		date_default_timezone_set('Asia/Kolkata');
	        		$newDate = date("Y-m-d H:i:s");
	        		$result=$this->Onlinemodel->insert_munit($data1);
	        		$data2=array();
	        		$data2['productid']=$this->input->get_post('code');
	        		$data2['branch']="11";
	        		$data2['size']="1";
	        		$data2['currentstock']=$this->input->get_post('openingstock');
	        		if($data2['currentstock']!=0)
	        		{
						// $this->Onlinemodel->insertstock($data2,$voucherno,$transactiontype,$date,$userid);
	        		}
	        		if($result==true)
	        		{
	        			?>
	        			<script type="text/javascript">
	        				alert('Product Added Successfully....!');
	        			</script>
	        			<?php 
	        		}
	        		else
	        		{
	        			?>
	        			<script type="text/javascript">
	        				alert('insertion failed. please check the inputs');
	        			</script>
	        			<?php 
	        		}

	        	}
	        	else
	        	{
	        		?>
	        		<script type="text/javascript">
	        			alert('insertion failed. please check the inputs');
	        		</script>
	        		<?php 
	        	}


	    }		
		else
		{
			?>
			<script type="text/javascript">
			alert('Duplicate Product Name or code Exists....');
			</script>
			<?php 
		} 
	}
	else      
		{     
		if(empty($_FILES["img"]["name"])){
			
		}
		else{    
				$config['upload_path'] = './images';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$config['max_size']      = '200000';
				$config['min_width']     = '14';
				$config['min_height']    = '7';
				$this->load->library('upload', $config);
				$this->upload->do_upload('img');
				$data12= $this->upload->data();	
			$n=$data12['file_name'];
			$data['imagpath']=$n;
			 $imagepath = $this->input->get_post('imagepath');
							$file = "images/".$imagepath;
							
							if($imagepath != "")
							{    
								
								$file = "images/".$imagepath;


								if(is_readable($file) )
									{
										unlink($file);
									}
								else
									{
									?>
						<script type="javascript"> 

							alert('Old image not found or permission to delete not set');

						</script>

									<?php } }
			
		}

		log_message('error',"Update");

			  
		$update=$this->Onlinemodel->update_product($id,$data);
		if ($update==true) 
		{   $code=$this->input->get_post('code');
			$data=array();
			$data1['product_id']=$this->input->get_post('code');
 			$data1['unit']=$unitname;
 			$data1['count']="1";
 			$data1['bunit']=$this->input->get_post('unitid');
			$UNITID=$data1['bunit'];
			$data1['rate']=$this->input->get_post('mrp');
			// echo $id;
			$this->load->model('Onlinemodel');
			

			$update1 =$this->Onlinemodel->update_productunit($code,$data1);
			if($update1)
			{

				?>
				<script type="text/javascript">
				alert('product and units updated');
				</script>
				<?php
				// $this->product();
				redirect('/Onlinecontrol/product');
			}
		}
		else{

				?>
				<script type="text/javascript">
				alert('updation failed');
				</script>
				<?php
				// $this->index();
				redirect('/Onlinecontrol/product');
			
		}
	

}

									
		
        
		// $this->product();
				redirect('/Onlinecontrol/product');

	}

	public function delete_product()
	{      
		$code=$this->input->get_post('code');
		$imagepath = $this->input->get_post('imagepath');
		$file = "images/".$imagepath;

		if($imagepath != "")
		{    

			$file = "images/".$imagepath;


			if(is_readable($file) )
			{
				unlink($file);
			}
			else
			{
				?>
				<script type="javascript"> alert("Old image not found or permission to delete not set.") </script>
				<?php
			}
		}
		$id=$this->input->get_post('productid');
		$delete=  $this->Onlinemodel->delete_product($id);
		$delete=   $this->Onlinemodel->delete_multiunitbyproduct($code);
		if($delete)
		{
			?> <script type="text/javascript">
				alert('product deleted successfully');
				</script> <?php
			}
		// $this->product();
			redirect('/Onlinecontrol/product');


		}
	
public function product_image()
{
	if($this->session->userdata('role')=="Super Admin")
	{
		$data['pdt']=$this->Onlinemodel->getproduct();
		$this->load->view('header');
		$this->load->view('images',$data);
		$this->load->view('footer');
	}
	else if($this->session->userdata('role')=="Branch User")
	{
		?>
		<script type="text/javascript">
		alert("Access Denied...!");
		</script>
		<?php
		$this->index();
	}
}


		public function banktransfer()
		{ 
			$data=array();

			$branchid = $this->session->userdata('branch');
			$branchh=$branchid;

			$data['branchid']=$branchh;

			$data['branch']=$this->Onlinemodel->getBranch($branchid);
			
			$this->load->view('header');
			$this->load->view('banktransfer',$data);
			$this->load->view('footer');

		}

		public function insert_banktransfer()
		{     
			$this->load->model('Onlinemodel');

			$date=$this->input->get_post('depositdate');
			$amount=$this->input->get_post('amount');
			$branchid=$this->input->get_post('branchid');
			$userid=$this->session->userdata('user');

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
					$data2['date']=$date;
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
					?><script type="text/javascript">
						alert('Insertion failed. please check the inputs!!!');
						</script><?php
					}
				}
				else
				{
					?><script type="text/javascript">
						alert('voucherno name already exists!!!. please refresh');
						</script><?php
				}


		}



public function insert_contravoucher()
    {     date_default_timezone_set('Asia/Kolkata');
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->get_post('VendorInvoiceNo');
    	$data['ledger']=$this->input->get_post('ledger');
    	$data['date']=$this->input->post('date')." ".date("H:i:s");
    	$data['currentbalance']=$this->input->get_post('currentbalance');
    	$data['frombalance']=$this->input->get_post('frombalance');
    	$data['narration']=$this->input->get_post('narration');
    	$data['totalamount']=$this->input->get_post('totalamount');
    	$data['cashorbank']=$this->input->get_post('cashorbank');
    	$data['voucherno']=$this->input->get_post('voucherno');
    	$data['userid']=$this->session->userdata('user');

		// $this->Onlinemodel->insert_paymentvoucher($data);
		
			$value=$this->input->get_post('voucherno');
			$existence=$this->Onlinemodel->checkexistence_contra($value);
			if($existence==0)
			{
				$result=$this->Onlinemodel->insert_contravoucher($data);
				if($result)
				{
					$cashorbank= $data['cashorbank'];
					$set=true;

					$ledgername=$data['ledger'];
					$amount=$data['totalamount'];
					$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
					$rootid=$data['records']['rootid'];
					$cashorbank= $data['cashorbank'];
					$set=true;

			if($data['vendorinvoiceno']!=""&& $data['vendorinvoiceno']!=null){

				$data['recordss']=$this->Onlinemodel->Select_ledger($cashorbank);
				$group=$data['recordss']['accountgroup'];
				if($group=='18'){

					$set=$this->Onlinemodel->update_salesbalancebyvouchernoinbank($data['vendorinvoiceno'],$data['totalamount'],$cashorbank,$ledgername);

				}
				else{
					$set=$this->Onlinemodel->update_salesbalancebyvouchernoincash($data['vendorinvoiceno'],$data['totalamount'],$ledgername,$cashorbank);


				}
			}
			if($set==false)
			{
				?><script type="text/javascript">
					alert('No such invoice Exists');
					</script><?php
			}
					                      
					// if($rootid==1 || $rootid==4)
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
					// }
					// else
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
					// }
					// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
					// if($result2)
					// {
						$data2=array();
						$data2['invoiceno']=$data['voucherno'];
				     	$data2['accountType']='Contra Voucher';
		                $data2['date']=$this->input->get_post('date')." ".date("H:i:s");
		                $data2['ledgername']=$ledgername;
		                $data2['userid']=$this->session->userdata('user');
		                $data2['debit']=$data['totalamount'];
		                $data2['credit']=0;
		                $data2['opposite']=$cashorbank;
		                $result3=$this->Onlinemodel->insert_newdaybook($data2);
		                $data2['ledgername']=$cashorbank;
		                $data2['debit']=0;
		                $data2['credit']=$data['totalamount'];
		                $data2['opposite']=$ledgername;
                        $result3=$this->Onlinemodel->insert_newdaybook($data2);
						// if($result3==false)
						// {
						// 	?><script type="text/javascript">
						// 	alert('Failed Daybook insertion........');
						// 	<?php
						// }
						// ?><script type="text/javascript">
						// alert('Saved successfully........');
						// </script>
						// <?php
					}
					else
					{
						?><script type="text/javascript">
						alert('Insertion failed. please check the inputs!!!');
						</script><?php
					}
				}
				else
				{
					?><script type="text/javascript">
					alert('voucherno name already exists!!!. please refresh');
					</script><?php
				}
			}
		
	


    

 public function delete_contravoucher()
    {
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->post('VendorInvoiceNo');
    	$data['ledger']=$this->input->post('ledger');
    	$data['date']=$this->input->post('date')." ".date("H:i:s");
    	$data['currentbalance']=$this->input->post('currentbalance');
    	$data['frombalance']=$this->input->post('frombalance');
    	$data['narration']=$this->input->post('narration');
    	$data['totalamount']=$this->input->post('totalamount');
    	$data['cashorbank']=$this->input->post('cashorbank');
    	$data['voucherno']=$this->input->post('voucherno');
        $id=$this->input->post('voucherno');
        $this->load->model('Onlinemodel');
        $delete = $this->Onlinemodel->delete_contravoucher($id);
        if($delete)
        {                                    
			// $supplierid= $data['supplier'];
			// $data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
			$cashorbank= $data['cashorbank'];
			$ledgername=$data['ledger'];
			$set=true;

                                 if($data['vendorinvoiceno']!=""&& $data['vendorinvoiceno']!=null){

                                 	      $data['recordss']=$this->Onlinemodel->Select_ledger($cashorbank);
					                     $group=$data['recordss']['accountgroup'];
                            if($group=='18'){

    		                          $set=$this->Onlinemodel->update_salesbalancebyvouchernoincash($data['vendorinvoiceno'],$data['totalamount'],$cashorbank,$ledgername);
    		                              
                            }
                            else{
                            	 $set=$this->Onlinemodel->update_salesbalancebyvouchernoinbank($data['vendorinvoiceno'],$data['totalamount'],$ledgername,$cashorbank);
    		                              
                            }
    	                                 }
    	                                 if($set==false)
					{
						?><script type="text/javascript">
						alert('No such invoice Exists');
						</script><?php
					}
			
			$amount=$data['totalamount'];
			$data['records']=$this->Onlinemodel->Select_ledger($ledgername);	
			$rootid=$data['records']['rootid'];
			// if($rootid==1 || $rootid==4)
			// {
			// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
			// }
			// else
			// {
			// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
			// }
			// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
			// if($result2)
			// {
				$data2=array();
				$data2['invoiceno']=$data['voucherno'];
				$data2['accountType']='Contra Voucher delete';
				$data2['date']=$this->input->post('date')." ".date("H:i:s");
				$data2['ledgername']=$ledgername;
				$data2['debit']=0;
				$data2['credit']=$data['totalamount'];
				$data2['opposite']=$cashorbank;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
				$data2['ledgername']=$cashorbank;
				$data2['debit']=$data['totalamount'];
				$data2['credit']=0;
				$data2['opposite']=$ledgername;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
				?><script type="text/javascript">
				alert('Contra Voucher deleted successfully');
				</script><?php
			// }
			
		}
		echo json_encode($delete);
}
public function getcontravoucherbyvoucherno()
    {
    	
			
			$voucherno=$this->input->post('voucherno');
			$data=$this->Onlinemodel->getcontravoucherbyvoucherno($voucherno);
		echo json_encode($data);
    }

public function contravoucher()
{ $loadinvno=$this->input->get_post('a'); 
	      if($loadinvno==null){
		$loadinvno=0;
	       }


      if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
        		$this->load->model('Onlinemodel');
        		$data['loadinvno']=$loadinvno;
				$data['ledger']=$this->Onlinemodel->all_accountledger();
				$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
				// $data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				// $data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
        		$data['voucherno']=$this->Onlinemodel->Autogenerate_contraVoucherNo();
        		$data['pay']=$this->Onlinemodel->getcontravoucher();
				$this->load->view('header');
				$this->load->view('ContraVoucher',$data);
				$this->load->view('footer');
			}
			else
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}
public function trialbalance()
{
	if($this->session->userdata('name'))
	{
		$data=array();
		$branchid = $this->session->userdata('branch');
		if($this->session->userdata('role')=="Super Admin")
		{
			 $data=array();
	$fromdate=$this->input->get_post('fromdate');
					$todate=$this->input->get_post('todate');
					
					
					
					$data['branch']=$this->Onlinemodel->getBranch();
					
					$data['fromdate']=$fromdate;
					$data['todate']=$todate;
					if($fromdate==null||$fromdate==""){
						$data['ledger']=$this->Onlinemodel->getaccountledgerwithbalance();
						
					}
					else{
						$data['ledger']=$this->Onlinemodel->getaccountledgerwithbalancebydate($fromdate,$todate);
						
					}
	
	// $data['openingbalance']=$this->Onlinemodel->get_openingbalance();
			if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
	$this->load->view('trialbalance',$data);
	$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Admin")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
			</script>
			<?php
			$this->index();
		}
		else if($this->session->userdata('role')=="Branch User")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
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

public function cash_bank_book()
{
	if($this->session->userdata('name'))
	{
		$branchid = $this->session->userdata('branch');
		if($this->session->userdata('role')=="Super Admin")
		{
			$data=array();
			$cdate = date('Y-m-d');
			$data['daay']=$this->Onlinemodel->CashDaybookCurrent($cdate);
			$data['daay1']=$this->Onlinemodel->BankDaybookCurrent($cdate);
			$fdate = $this->input->get_post('fdate');
			$tdate= $this->input->get_post('tdate');
			if(!empty($fdate) && !empty($tdate))
			{
				$data['daay']=$this->Onlinemodel->CashDaybook($fdate,$tdate);
				$data['daay1']=$this->Onlinemodel->BankDaybook($fdate,$tdate);
			}
			else
			{
				$data['daay']=$this->Onlinemodel->CashDaybookCurrent($cdate);
				$data['daay1']=$this->Onlinemodel->BankDaybookCurrent($cdate);
			}
				if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('cashflow',$data);
			$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Admin")
		{
			$data=array();
			$cdate = date('Y-m-d');
			$data['daay']=$this->Onlinemodel->CashDaybookCurrentbranch($cdate,$branchid);
			$data['daay1']=$this->Onlinemodel->BankDaybookCurrentbranch($cdate,$branchid);
			$fdate = $this->input->get_post('fdate');
			$tdate= $this->input->get_post('tdate');
			if(!empty($fdate) && !empty($tdate))
			{
				$data['daay']=$this->Onlinemodel->CashDaybookbranch($fdate,$tdate,$branchid);
				$data['daay1']=$this->Onlinemodel->BankDaybookbranch($fdate,$tdate,$branchid);
			}
			else
			{
				$data['daay']=$this->Onlinemodel->CashDaybookCurrentbranch($cdate,$branchid);
				$data['daay1']=$this->Onlinemodel->BankDaybookCurrentbranch($cdate,$branchid);
			}
				if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('cashflow',$data);
			$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Branch User")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
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


public function insert_image()
	{
	$data12=array();
	$config['upload_path'] = './images';
    $config['allowed_types'] = 'gif|jpg|png|jpeg';
    $config['max_size']      = '200000';
    $config['min_width']     = '14';
    $config['min_height']    = '7';
    $this->load->library('upload', $config);
    $this->upload->do_upload('img');
    $data12= $this->upload->data();
    $n=$data12['file_name'];
    $data=array();
    $data['productcode']=$this->input->get_post('code');
    $data['name']=$n;
	$data['pdt']=$this->Onlinemodel->insert_image($data);
	$data['pdt']=$this->Onlinemodel->getproduct();
	$this->load->view('header');
	$this->load->view('images',$data);
	$this->load->view('footer');
	}

	public function imagehandler()
	 {
		if($this->session->userdata('role')=="Super Admin")
		{
			$data['img']=$this->Onlinemodel->getimagehandler();
			$data['typeselect']=$this->Onlinemodel->gettypehandler();
			$this->load->view('header');
			$this->load->view('imagehandler',$data);
			$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Branch User")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
			</script>
			<?php
			$this->index();
		}
	 }
	 
	public function insertimagehandler()
	{
		$action=$this->input->get_post('save');
		if($action=="Save")
		{
			 	// $existence=$this->Onlinemodel->checkexistence_image($data);
				// if($existence==0)
				// {
				$data12=array();
				$config['upload_path'] = './images';
    			$config['allowed_types'] = 'gif|jpg|png|jpeg';
    			$config['max_size']      = '200000';
    			$config['min_width']     = '14';
    			$config['min_height']    = '7';
    			$this->load->library('upload', $config);
    			$this->upload->do_upload('img');
    			$data12= $this->upload->data();
    			$n=$data12['file_name'];
				$data=array();
				// $data['productcode']=$this->input->get_post('code');
				$data['type']=$this->input->get_post('type');
    			$data['name']=$n;
				$data['pdt']=$this->Onlinemodel->insertimagehandler($data);
				
				?>
				<script>alert("Image Uploaded Successfully!")</script>
				<?php
				$this->imagehandler();
		 	// }
		 	// else
		 	// {
		 	// }
		}
		//  $update=$this->Onlinemodel->updateimagehandler($id,$data);
		//  if ($update==true) 
		//  {	
		// }

	}
	

	public function deleteimagehandler()
	{
		$imgcode = $this->input->get_post("code");
		$imgname = $this->input->get_post("imgname");
		$imagepath = $this->input->get_post("imagepath");
		$this->imagehandler();
	}

	 
	 //image ajax

	 public function getimg()
	 {
	 	$data=array();
	 	$pdt=$this->input->get_post('b');
	 	$result=$this->Onlinemodel->getimg($pdt);
	 	echo json_encode($result);
	 }

	
	public function branchpaymentvoucher()
	{
		$branchid=$this->session->userdata('branch');
		if($this->session->userdata('name'))
		{
			$data=array();
			$this->load->model('Onlinemodel');
			$data['voucherno']=$this->Onlinemodel->Autogenerate_branchexpense();
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['supp']=$this->Onlinemodel->getpaymentledger();
				$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
				$data['pay']=$this->Onlinemodel->getbranchexpense();
				// $data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				// $data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
				$this->load->view('header');
				$this->load->view('branchexpense',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				$data['supp']=$this->Onlinemodel->getpaymentledgerbybranch($branchid);
				$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgersbybranch($branchid);
				$data['pay']=$this->Onlinemodel->getbranchexpensebybranch($branchid);
				// $data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				// $data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
				$this->load->view('header');
				$this->load->view('branchexpense',$data);
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


	public function insert_branchexpense()
    {
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->get_post('VendorInvoiceNo');
    	$data['supplier']=$this->input->get_post('supplier');
    	$data['date']=$this->input->get_post('date')." ".date('H:i:s');
    	$data['currentbalance']=$this->input->get_post('currentbalance');
    	$data['narration']=$this->input->get_post('narration');
    	$data['totalamount']=$this->input->get_post('totalamount');
    	$data['cashorbank']=$this->input->get_post('cashorbank');
    	$data['voucherno']=$this->input->get_post('voucherno');
    	$data['userid']=$this->session->userdata('user');
		// $this->Onlinemodel->insert_paymentvoucher($data);
		$action=$this->input->get_post('btnsave');
		if($action=="Save")
		{
			$value=$this->input->get_post('voucherno');
			$existence=$this->Onlinemodel->checkexistence_branchexpense($value);
			if($existence==0)
			{
				$result=$this->Onlinemodel->insert_branchexpense($data);
				if($result)
				{
					$cashorbank= $data['cashorbank'];
					$ledgername=$data['supplier'];
					$amount=$data['totalamount'];
					$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
					$result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
					if($result2)
					{
						$data2=array();
						$data2['invoiceno']=$data['voucherno'];
						$data2['accountType']='Branch Expense';
						$data2['date']=$data['date'];
						$data2['ledgername']=$ledgername;
						$data2['userid']=$this->session->userdata('user');
						$data2['debit']=$data['totalamount'];
						$data2['credit']=0;
						$data2['opposite']=$cashorbank;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						$data2['ledgername']=$cashorbank;
						$data2['debit']=0;
						$data2['credit']=$data['totalamount'];
						$data2['opposite']=$ledgername;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						if($result3==false)
						{
							?><script type="text/javascript">
							alert('Failed Daybook insertion........');
							<?php
						}
						?><script type="text/javascript">
						alert('Saved successfully........');
						</script>
						<?php
					}
					else
					{
						?><script type="text/javascript">
						alert('Insertion failed. please check the inputs!!!');
						</script><?php
					}
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('voucherno name already exists!!!. please refresh');
					</script><?php
				}
			}
		}
		$this->branchpaymentvoucher();
	}

	public function paymentvoucher()
	{
		$loadinvno=$this->input->get_post('a');
		if($loadinvno==null)
		{
			$loadinvno=0;
		}
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
        		$this->load->model('Onlinemodel');
        		$data['loadinvno']=$loadinvno;
				$data['ledger']=$this->Onlinemodel->all_accountledger();
				$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
				// $data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				// $data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
        		$data['voucherno']=$this->Onlinemodel->Autogenerate_payVoucherNo();
        		$data['pay']=$this->Onlinemodel->getpaymentvoucher();
				$this->load->view('header');
				$this->load->view('PaymentVoucher',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}
	

	public function insert_paymentvoucher()
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
    	$data['userid']=$this->session->userdata('user');
		
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
		                $data2['userid']=$this->session->userdata('user');
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
				
				echo json_encode($existence);
			}
		
		
			public function delete_paymentvoucher()
			{
				$data=array();
				$data['vendorinvoiceno']=$this->input->post('VendorInvoiceNo');
				$data['ledger']=$this->input->post('ledger');
				$data['date']=$this->input->post('date');
				$data['currentbalance']=$this->input->post('currentbalance');
				$data['narration']=$this->input->post('narration');
				$data['totalamount']=$this->input->post('totalamount');
				$data['cashorbank']=$this->input->post('cashorbank');
				$data['voucherno']=$this->input->post('voucherno');
				$id=$this->input->get_post('voucherno');
				$this->load->model('Onlinemodel');
				$delete = $this->Onlinemodel->delete_paymentvoucher($id);
				if($delete)
				{                                    
					// $supplierid= $data['supplier'];
					// $data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
					$cashorbank= $data['cashorbank'];
					$ledgername=$data['ledger'];
					$amount=$data['totalamount'];
					$data['records']=$this->Onlinemodel->Select_ledger($ledgername);	
					$rootid=$data['records']['rootid'];
					// if($rootid==1 || $rootid==4)
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
					// }
					// else
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
					// }
					// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
					// if($result2)
					// {
					$d=strtotime($this->input->get_post('date')); $duration=60;$e=$d+$duration;
						$data2=array();
						$data2['invoiceno']=$data['voucherno'];
						$data2['accountType']='Payment Voucher delete';
						$data2['date']=date('Y-m-d H:i:s',$e);
						$data2['ledgername']=$ledgername;
						$data2['debit']=0;
						$data2['credit']=$data['totalamount'];
						$data2['opposite']=$cashorbank;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						$data2['ledgername']=$cashorbank;
						$data2['debit']=$data['totalamount'];
						$data2['credit']=0;
						$data2['opposite']=$ledgername;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						?><script type="text/javascript">
						alert('paymentvoucher deleted successfully');
						</script><?php
					// }
					
				}
		}
		
		public function getpaymentvoucherbyvoucherno()
		{
			$voucherno=$this->input->post('voucherno');
			$data=$this->Onlinemodel->getpaymentvoucherbyvoucherno($voucherno);
			echo json_encode($data);
		}
		
		
	public function chequepayment()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$type ="payment";
				$data=array();
        		$this->load->model('Onlinemodel');
				$data['supp']=$this->Onlinemodel->getsupplier();
				$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
        		$data['chequeVoucherNo']=$this->Onlinemodel->Autogenerate_chequeVoucherNo($type);
				$this->load->view('header');
				$this->load->view('ChequePayment',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
	public function chequereceipt()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$type ="receipt";
				$data=array();
        		$this->load->model('Onlinemodel');
				$data['customer']=$this->Onlinemodel->getcustomer();
				$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
        		$data['chequeVoucherNo']=$this->Onlinemodel->Autogenerate_chequeVoucherNo($type);
				$this->load->view('header');
				$this->load->view('ChequeReceipt',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function chequePage()
	{
		if($this->session->userdata('name'))
		{
			$branchid = $this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$fromdate=$this->input->get_post('fromdate');
				$todate=$this->input->get_post('todate');
				if($fromdate!=null && $todate != null)
				{
					$data['cheque']=$this->Onlinemodel->getchequebetweendates($fromdate,$todate);
				}
				else if($fromdate!=null && $todate == null)
				{
					$data['cheque']=$this->Onlinemodel->getchequefromdate($fromdate);
				}
				else if($fromdate==null && $todate != null)
				{
					$data['cheque']=$this->Onlinemodel->getchequetodate($todate);
				}
				else
				{
					$data['cheque']=$this->Onlinemodel->getcheque();
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('Cheque',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Admin")
			{
				$data=array();
				$fromdate=$this->input->get_post('fromdate');
				$todate=$this->input->get_post('todate');
				if($fromdate!=null && $todate != null)
				{
					$data['cheque']=$this->Onlinemodel->getchequebetweendatesbranch($fromdate,$todate,$branchid);
				}
				else if($fromdate!=null && $todate == null)
				{
					$data['cheque']=$this->Onlinemodel->getchequefromdatebranch($fromdate,$branchid);
				}
				else if($fromdate==null && $todate != null)
				{
					$data['cheque']=$this->Onlinemodel->getchequetodatebranch($todate,$branchid);
				}
				else
				{
					$data['cheque']=$this->Onlinemodel->getchequebranch($branchid);
				}
				if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('Cheque',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script><?php 
        	$this->index();
        } 
	}

	public function insert_chequepayment()
	{
		     
		$data=array(
		'voucherno'=>$this->input->post('voucherno'),
		'vendorinvoiceno'=>$this->input->post('vendorinvoiceno'),
		'date'=>$this->input->post('date'),
		'supplier'=>$this->input->post('supplier'),
		'current_balance'=>$this->input->post('currentbalance'),
		'chqno'=>$this->input->post('chqno1'),
		'bank'=>$this->input->post('bank1'),
		'status'=>$this->input->post('status1'),
		'date1'=>$this->input->post('date1'),
		'total_amount1'=>$this->input->post('totalamount1'),
		'narration'=>$this->input->post('narration'),
		'total_amount'=>$this->input->post('totalamount'),
		'type'=>$this->input->post('type')
		);	 
		$status=$this->input->post('status1');
		$type=$this->input->post('type');
		$dat1=$this->Onlinemodel->insert_chequepayment($data);
		if($type=='receipt'){
if($status=="Cleared")
		{$value=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();
					$existence=$this->Onlinemodel->checkexistence_receiptvoucherno($value);
			if($existence==0)
			{    $data1=array();
    	
    	$data1['ledger']=$this->input->post('supplier');
    	$data1['receiptdate']=date("Y-m-d");
    	$data1['currentbalance']=$this->input->post('currentbalance');
    	
    	$data1['amount']=$this->input->post('totalamount1');
    	$data1['cashorbank']=$this->input->post('bank1');
    	
    	$data1['voucherno']=$value->result_array()[0]['NO'];
    	$data1['branchid']='1';
    	$data1['userid']=$this->session->userdata('user');
				$result=$this->Onlinemodel->insert_ReceiptVoucher($data1);
				if($result==true)
				{
					//1)Update customerbalance in AccountLedger_Start
					//Fetching customeraccount name using customerid
					$cashorbank= $data['bank'];
					$ledgername= $data['supplier'];
					$amount=$data['total_amount1'];log_message('error',$amount);
					$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
					$rootid=$data['records']['rootid'];
					// if($rootid==1 || $rootid==4)
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
					// }
					// else
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
					// }
					// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
					// if($result2==false)
					// {
						
					// }
					$cashorbank=$data['bank'];
					$data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
					$data2=array();
					$data2['invoiceno']=$data1['voucherno'];
		            $data2['accountType']='Receipt Voucher';
		            $data2['date']=date('Y-m-d H:i:s');
		            $data2['ledgername']=$ledgername;
					$data2['userid']=$this->session->userdata('user');
					$data2['debit']=0;
					$data2['credit']=$amount;
					$data2['opposite']=$cashorbank;
					$result3=$this->Onlinemodel->insert_newdaybook($data2);
					$data2['ledgername']=$cashorbank;
					$data2['debit']=$amount;
					$data2['credit']=0;
					$data2['opposite']=$ledgername;
					$result3=$this->Onlinemodel->insert_newdaybook($data2);
					// if($result3==false)
					// {
					// }
					
					
				}
				else
				{
				}
			}
			else
			{
			}
		}
		}
		else{
			if($status=="Cleared"){
           log_message('error',$status);
             $value=$this->Onlinemodel->Autogenerate_payVoucherNo();
			
			$existence=$this->Onlinemodel->checkexistence_payment($value);log_message('error',$existence);
			if($existence==0)
			{   	
	    $data=array();
    	$data['vendorinvoiceno']=$this->input->post('vendorinvoiceno');
    	$data['ledger']=$this->input->post('supplier');
    	$data['date']=date("Y-m-d");
    	$data['currentbalance']=$this->input->post('currentbalance');
    	$data['narration']=$this->input->post('narration');
    	$data['totalamount']=$this->input->post('totalamount1');
    	$data['cashorbank']=$this->input->post('bank1');
    	$data['userid']=$this->session->userdata('user');
    	
          $data['voucherno']=$value->result_array()[0]['NO'];
				$result=$this->Onlinemodel->insert_paymentvoucher($data);
				if($result)
				{
					$cashorbank= $data['cashorbank'];
					$ledgername=$data['ledger'];
					$amount=$data['totalamount'];
					$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
					$rootid=$data['records']['rootid'];
					// if($rootid==1 || $rootid==4)
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
					// }
					// else
					// {
					// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
					// }
					// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
						$data2=array();
						$data2['invoiceno']=$data['voucherno'];
				     	$data2['accountType']='Payment Voucher';
		                $data2['date']=date('Y-m-d H:i:s');
		                $data2['ledgername']=$ledgername;
		                $data2['userid']=$this->session->userdata('user');
		                $data2['debit']=$amount;
		                $data2['credit']=0;
		                $data2['opposite']=$cashorbank;
		                $result3=$this->Onlinemodel->insert_newdaybook($data2);
		                $data2['ledgername']=$cashorbank;
		                $data2['debit']=0;
		                $data2['credit']=$amount;
		                $data2['opposite']=$ledgername;
                        $result3=$this->Onlinemodel->insert_newdaybook($data2);
				}
				else
				{
					
				}
			}
		}
		}
		
		echo json_encode($dat1);
	}

	public function Chequedelete()
	{
		$id=$this->input->post('id');
		$dat1=$this->Onlinemodel->delete_cheque($id);
		echo json_encode($dat1);
	}

	public function ChequetoPayment(){

		$status=$this->input->post('status');
		$id=$this->input->post('id');
		$res =$this->Onlinemodel->update_chequestatus($status,$id);
		
			$data=array();
			$data['vendorinvoiceno']=$this->input->post('vendorinvoiceno');
			$data['ledger']=$this->input->post('ledger');
			$data['date']=date("Y-m-d");
			$data['currentbalance']=$this->input->post('currentbalance');
			$data['narration']=$this->input->post('narration');
			$data['totalamount']=$this->input->post('totalamount');
			$data['cashorbank']=$this->input->post('cashorbank');
			$data['userid']=$this->session->userdata('user');
			$result=$this->Onlinemodel->Autogenerate_payVoucherNo();
			  $data['voucherno']=$result->result_array()[0]['NO'];
			// $this->Onlinemodel->insert_paymentvoucher($data);
			if($status=="Cleared"){
			   log_message('error',$status);
	
				$value=$data['voucherno'];
				$existence=$this->Onlinemodel->checkexistence_payment($value);
				if($existence==0)
				{
					$result=$this->Onlinemodel->insert_paymentvoucher($data);log_message('error',$result);
					if($result)
					{
						$cashorbank= $data['cashorbank'];
						$ledgername=$data['ledger'];
						$amount=$data['totalamount'];
						$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
						$rootid=$data['records']['rootid'];
						// if($rootid==1 || $rootid==4)
						// {
						// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
						// }
						// else
						// {
						// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
						// }
						// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
						
							$data2=array();
							$data2['invoiceno']=$data['voucherno'];
							 $data2['accountType']='Payment Voucher';
							$data2['date']=date('Y-m-d H:i:s');
							$data2['ledgername']=$ledgername;
							$data2['userid']=$this->session->userdata('user');
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
					else
					{
						
					}
				}
			}
		 echo json_encode($status); 	
	}

	public function ChequetoReceipt(){
		$status=$this->input->post('status');
		$id=$this->input->post('id');
		$res =$this->Onlinemodel->update_chequestatus($status,$id);
		
			$data=array();
			
			$data['ledger']=$this->input->post('ledger');
			$data['receiptdate']=date("Y-m-d");
			$data['currentbalance']=$this->input->post('currentbalance');
			
			$data['amount']=$this->input->post('totalamount');
			$data['cashorbank']=$this->input->post('cashorbank');
			$result=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();
			$data['voucherno']=$result->result_array()[0]['NO'];
			$data['branchid']='1';
			$data['userid']=$this->session->userdata('user');
					
			if($status=="Cleared")
			{
				$value=$data['voucherno'];
				$existence=$this->Onlinemodel->checkexistence_receiptvoucherno($value);
				if($existence==0)
				{
					$result=$this->Onlinemodel->insert_ReceiptVoucher($data);
					if($result==true)
					{
						//1)Update customerbalance in AccountLedger_Start
						//Fetching customeraccount name using customerid
						$cashorbank= $data['cashorbank'];
						$ledgername= $data['ledger'];
						$amount=$data['amount'];
						$data['records']=$this->Onlinemodel->Select_ledger($ledgername);
						$rootid=$data['records']['rootid'];
						// if($rootid==1 || $rootid==4)
						// {
						// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
						// }
						// else
						// {
						// 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
						// }
						// $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
						// if($result2==false)
						// {
							
						// }
						$cashorbank=$data['cashorbank'];
						$data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
						$data2=array();
						$data2['invoiceno']=$data['voucherno'];
						$data2['accountType']='Receipt Voucher';
						$data2['date']=date('Y-m-d H:i:s');
						$data2['ledgername']=$ledgername;
						$data2['userid']=$this->session->userdata('user');
						$data2['debit']=0;
						$data2['credit']=$data['amount'];
						$data2['opposite']=$cashorbank;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						$data2['ledgername']=$cashorbank;
						$data2['debit']=$data['amount'];
						$data2['credit']=0;
						$data2['opposite']=$ledgername;
						$result3=$this->Onlinemodel->insert_newdaybook($data2);
						// if($result3==false)
						// {
						// }
					}
					else
					{
					}
				}
				else
				{
				}
			}
	}


		
  public function munit()
   {

       	    if($this->session->userdata('name'))
		{
   	       $data['product']=$this->Onlinemodel->getproduct();
   	              $data['unit']=$this->Onlinemodel->getunit();
   	                 $data['munit']=$this->Onlinemodel->getmunit();
 	     $this->load->view('header');
		 $this->load->view('munit',$data);
		 $this->load->view('footer');
		  }
			                        else{
			                        	?>
<script type="text/javascript">
	alert("please login again");
</script>
<?php 
			                        	$this->index();
			                        } 
   }
   public function insert_munit()
   {
       $action=$this->input->get_post('save');
	
         if($action=="Save"){
         	 $data=array();

		        	$data['product_id']=$this->input->get_post('product');
   	$data['unit']=$this->input->get_post('unit');
   	$data['count']=$this->input->get_post('nounit');
   	$data['bunit']=$this->input->get_post('bunit');
   	$data['rate']=$this->input->get_post('rate');
   	// $data['product_id']=$this->input->get_post('');
   	$result=$this->Onlinemodel->insert_munit($data);
             

                      
	                         
	                         	if ($result==true) {
                           	                            
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         
	                      
         }
         elseif($action=="Update"){

		      $data=array();
	     	

		        	$data['product_id']=$this->input->get_post('product');
   	$data['unit']=$this->input->get_post('unit');
   	$data['count']=$this->input->get_post('nounit');
   	$data['bunit']=$this->input->get_post('bunit');
   	$data['rate']=$this->input->get_post('rate');
		$id=$this->input->get_post('unitid');
		// echo $id;
		 $this->load->model('Onlinemodel');
         $update =$this->Onlinemodel->update_multiunit($id,$data);
         if(!$update){
         	 ?> <script type="text/javascript">
	alert('updation failed');
</script>
<?php 
         }
         else
         {
         	
         }
          

                           	                          
         }
       
                 
         
          $data['product']=$this->Onlinemodel->getproduct();
   	              $data['unit']=$this->Onlinemodel->getunit();
   	              $data['munit']=$this->Onlinemodel->getmunit();
 	                    $this->load->view('header');
		                $this->load->view('munit',$data);
		                $this->load->view('footer');
         	

   }
   	public function delete_multiunit()
	{
                          $id=$this->input->get_post('unitid');
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_multiunit($id);
                        if (!$delete) {
                        	?> <script type="text/javascript">
	alert('multiunitdeletion failed ');   
</script> <?php 
                        }
                      
                           	                           $data['product']=$this->Onlinemodel->getproduct();
   	              $data['unit']=$this->Onlinemodel->getunit();
   	              $data['munit']=$this->Onlinemodel->getmunit();
 	                    $this->load->view('header');
		                $this->load->view('munit',$data);
						$this->load->view('footer');
					}
	
	public function cust_accview()
	{
		if($this->session->userdata('name'))
		{
			$branchid = $this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['accountledger']=$this->Onlinemodel->getaccountledger();
				$data['day']=$this->Onlinemodel->viewdaybook($cdate);
				$customerledger=$this->input->get_post('customerledger');
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				$data['customerledger'] =$customerledger;
				$data['fdate'] =$fdate;
				$data['tdate'] =$tdate;
				if( !empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->ltddaybookbyledger($fdate,$tdate,$customerledger);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybookbyledger($cdate,$customerledger);
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('cust_accview',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Admin")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['accountledger']=$this->Onlinemodel->getaccountledgerbranch($branchid);
				$data['day']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				$customerledger=$this->input->get_post('customerledger');
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				$data['customerledger'] =$customerledger;
				$data['fdate'] =$fdate;
				$data['tdate'] =$tdate;
				if( !empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->ltddaybookbyledgerbranch($fdate,$tdate,$customerledger,$branchid);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybookbyledgerbranch($cdate,$customerledger,$branchid);
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('cust_accview',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
  
  	public function FillCashBankLedgers()
	{

		$vouch=$this->input->get_post('id');
		$data=array();

		$data['CashLedg']=$this->Onlinemodel->FillCashLedgersss($vouch);
		$data['BankLedg']=$this->Onlinemodel->FillBankLedgersbb($vouch);
		$data['BranchCurrncy']=$this->Onlinemodel->FillBranchCurrency($vouch);

		echo json_encode($data);

	}
	
	public function pur_invoice()
	{
		$loadinvno=$this->input->get_post('a');
		if($loadinvno==null)
		{
			$loadinvno=0;
		}
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['product']=$this->Onlinemodel->getproduct();
				$data['unit']=$this->Onlinemodel->getunit();
				$data['supplier']=$this->Onlinemodel->getsupplier();
				$data['voucherno']=$this->Onlinemodel->Autogenerate_VoucherNo();
				$data['batch']=$this->Onlinemodel->getbatch();
				$data['brand']=$this->Onlinemodel->getbrand();
				$data['group']=$this->Onlinemodel->get_productgroup();
				$data['size']=$this->Onlinemodel->getsize();
				$data['branch']=$this->Onlinemodel->getBranch();
				$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
				$data['loadinvno']=$loadinvno;
				$this->load->view('admin/header');
				$this->load->view('Purchase',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function pur_return_branch()
	{
		$loadinvno=$this->input->get_post('a');

		$data=array();
		$data['product']=$this->Onlinemodel->getproduct();
		$data['unit']=$this->Onlinemodel->getunit();
		$data['brand']=$this->Onlinemodel->getbrand();
		$data['branch']=$this->Onlinemodel->getBranch();
		$data['size']=$this->Onlinemodel->getsize();
		$data['batch']=$this->Onlinemodel->getbatch();
		$data['group']=$this->Onlinemodel->get_productgroup();
		$data['supplier']=$this->Onlinemodel->getsupplier();
		$data['voucherno']=$this->Onlinemodel->Autogenerate_PurRetNo();
		$data['purchase']=$this->Onlinemodel->getpurchase();
		$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
		$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
		$data['loadinvno']=$loadinvno;
		$this->load->view('header_2');
		$this->load->view('PurchaseReturn_branch',$data);
		$this->load->view('footer');

	}



	public function pur_invoice_branch()
	{
		$loadinvno=$this->input->get_post('a');

			$data=array();
			$data['product']=$this->Onlinemodel->getproduct();
			$data['unit']=$this->Onlinemodel->getunit();
			$data['supplier']=$this->Onlinemodel->getsupplier();
			$data['voucherno']=$this->Onlinemodel->Autogenerate_VoucherNo();
			$data['batch']=$this->Onlinemodel->getbatch();
			$data['brand']=$this->Onlinemodel->getbrand();
			$data['group']=$this->Onlinemodel->get_productgroup();
			$data['size']=$this->Onlinemodel->getsize();
			$data['branch']=$this->Onlinemodel->getBranch();
			$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
			$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
			$data['loadinvno']=$loadinvno;

			$this->load->view('header_2');
			$this->load->view('Purchase_branch',$data);
			$this->load->view('footer');

	}


	 public function insert_jsimage(){ $image_name="";

	 $count = count($_FILES['image']['name']);
	 for ($i=0; $i < $count; $i++) { 

	 	$_FILES['file']['name'] = $_FILES['image']['name'][$i];
	 	$_FILES['file']['type'] = $_FILES['image']['type'][$i];
	 	$_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'][$i];
	 	$_FILES['file']['error'] = $_FILES['image']['error'][$i];
	 	$_FILES['file']['size'] = $_FILES['image']['size'][$i];
	 	$config['upload_path'] = './images';
	 	$config['allowed_types'] = '*';
	 	$config['max_size'] = 100;
	 	$config['max_width'] = 1024;
	 	$config['max_height'] = 768;
	 	$config['file_name'] = $_FILES['image']['name'][$i];
	 	$this->load->library('upload', $config);
	 	$this->upload->initialize($config);

	 	if($this->upload->do_upload('file')){

	 		$data['upload_data'] = $this->upload->data('file_name');
	 		$image_name = $image_name.",".$data['upload_data'];
	 	}
	 	else
	 	{
	 		$image_name = '';
	 	}

	 	$result['status'] = true;

	 	$result['message'] = "Data inserted successfully.";

	 }
        echo json_encode($image_name);
    }

	public function pur_return()
	{
		$loadinvno=$this->input->get_post('a');
		if($loadinvno==null){
			$loadinvno=0;
		}
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['product']=$this->Onlinemodel->getproduct();
				$data['unit']=$this->Onlinemodel->getunit();
				$data['brand']=$this->Onlinemodel->getbrand();
				$data['branch']=$this->Onlinemodel->getBranch();
				$data['size']=$this->Onlinemodel->getsize();
				$data['batch']=$this->Onlinemodel->getbatch();
				$data['group']=$this->Onlinemodel->get_productgroup();
				$data['supplier']=$this->Onlinemodel->getsupplier();
				$data['voucherno']=$this->Onlinemodel->Autogenerate_PurRetNo();
				$data['purchase']=$this->Onlinemodel->getpurchase();
				$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
				$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
				$data['loadinvno']=$loadinvno;
				$this->load->view('header');
				$this->load->view('PurchaseReturn',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
	
			 //Branch_start
			
			
		public function branch()
		{
			if($this->session->userdata('name'))
			{
				if($this->session->userdata('role')=="Super Admin")
				{
					$data=array();
				  	$data['branch']=$this->Onlinemodel->getBranch();
				  	$this->load->view('header');
				  	$this->load->view('Branch',$data);
				  	$this->load->view('footer');
				}
				else if($this->session->userdata('role')=="Branch User")
				{
					?>
					<script type="text/javascript">
					alert("Access Denied...!");
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

    public function insert_branch()
    {
		$action=$this->input->get_post('btnsave');
		$data=array();
		$data['branchname']=$this->input->get_post('branchname');
		$data['branchincharge']=$this->input->get_post('branchincharge');
		$data['gstno']=$this->input->get_post('gstno');
		$data['phonenumber']=$this->input->get_post('phonenumber');
		$data['address']=$this->input->get_post('address');
		$country=$this->input->get_post('country');

		if ($country == 0) {
			$data['currencyid'] = 1;
		}elseif ($country == 1) {
			$data['currencyid'] = 3;
		}elseif ($country == 2) {
			$data['currencyid'] = 2;
		}else{

		}

		if($action=="Save")
		{
			$value=$data['branchname'];
			$existence=$this->Onlinemodel->checkexistence_branch($value);
			if($existence==0)
			{

				$branchid=$this->Onlinemodel->insert_branch($data);

				if($branchid==true)
				{
					$data2=array();
					$data2['ledgername']="Supplier_".$this->input->get_post('branchname');
					$data2['accountgroup']='16';
					$data2['interestcalculation']=0;
					$data2['openingbalance']=0;
					$data2['creditordebit']='Cr';
					$data2['rootid']='2';
					$data2['narration']='Autogenerated for Supplier';
					$data2['currentbalance']=0;
					$data2['branchid']=$branchid;
					$value2=$data2['ledgername'];
					$ledgervalues=$this->Onlinemodel->insert_accountledger($data2);

					$data_1=array();
					$data_1['suppliername']="Supplier_".$this->input->get_post('branchname');
					$data_1['address']=$this->input->get_post('address');
					$data_1['creationdate']= date("d-m-y h:i:sa ");
					$data_1['mobile']=$this->input->get_post('phonenumber');
					$data_1['vatno']=$this->input->get_post('gstno');
					$data_1['supplieraccount']=$ledgervalues;
					$data_1['branch']=$branchid;
					$result=$this->Onlinemodel->insert_supplier($data_1);

				$data_2=array();
				$data_2['ledgername']="Generator/Fuel/Elect.Maintenance_".$this->input->get_post('branchname');
				$data_2['accountgroup']='9';
				$data_2['interestcalculation']=0;
				$data_2['openingbalance']=0;
				$data_2['creditordebit']='Dr';
				$data_2['rootid']='4';
				$data_2['currentbalance']=0;
				$data_2['branchid']=$branchid;
				$value2=$data_2['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_2);

				$data_3=array();
				$data_3['ledgername']="PETTY_".$this->input->get_post('branchname');
				$data_3['accountgroup']='25';
				$data_3['interestcalculation']=0;
				$data_3['openingbalance']=0;
				$data_3['creditordebit']='Dr';
				$data_3['rootid']='4';
				$data_3['currentbalance']=0;
				$data_3['branchid']=$branchid;
				$value2=$data_3['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_3);

				$data_4=array();
				$data_4['ledgername']="BANK_".$this->input->get_post('branchname');
				$data_4['accountgroup']='19';
				$data_4['interestcalculation']=0;
				$data_4['openingbalance']=0;
				$data_4['creditordebit']='Dr';
				$data_4['rootid']='1';
				$data_4['currentbalance']=0;
				$data_4['branchid']=$branchid;
				$value2=$data_4['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_4);

				$data_5=array();
				$data_5['ledgername']="CASH_".$this->input->get_post('branchname');
				$data_5['accountgroup']='18';
				$data_5['interestcalculation']=0;
				$data_5['openingbalance']=0;
				$data_5['creditordebit']='Dr';
				$data_5['rootid']='1';
				$data_5['currentbalance']=0;
				$data_5['branchid']=$branchid;
				$value2=$data_5['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_5);

				$data_6=array();
				$data_6['ledgername']="Rent_".$this->input->get_post('branchname');
				$data_6['accountgroup']='9';
				$data_6['interestcalculation']=0;
				$data_6['openingbalance']=0;
				$data_6['creditordebit']='Dr';
				$data_6['rootid']='4';
				$data_6['currentbalance']=0;
				$data_6['branchid']=$branchid;
				$value2=$data_6['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_6);

				$data_7=array();
				$data_7['ledgername']="OTHER  EXPENSES_".$this->input->get_post('branchname');
				$data_7['accountgroup']='9';
				$data_7['interestcalculation']=0;
				$data_7['openingbalance']=0;
				$data_7['creditordebit']='Dr';
				$data_7['rootid']='4';
				$data_7['currentbalance']=0;
				$data_7['branchid']=$branchid;
				$value2=$data_7['ledgername'];
				$ledgervalues=$this->Onlinemodel->insert_accountledger($data_7);

				$data['branchid']=$branchid;

					?><script type="text/javascript">
					alert('Saved successfully........');
					</script>
					<?php
				}
				else
				{
					?><script type="text/javascript">
					alert('Insertion failed. please check the inputs!!!');
					</script><?php 
	            }
			}
			else
			{
				?><script type="text/javascript">
				alert('Branch name already exists!!!. please use another name');
				</script> <?php 
	        }
	    }
	    else if($action=="Update")
	    {
			$id=$this->input->get_post('branchid');
			$update =$this->Onlinemodel->update_branch($id,$data);
			if($update==true)
			{

		$oldbr=$this->input->get_post('oldbrname');
		$newbr=$this->input->get_post('branchname');

		$data_old="Supplier_".$oldbr;
		$data_new="Supplier_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old,$data_new);

		$data_old2="Generator/Fuel/Elect.Maintenance_".$oldbr;
		$data_new2="Generator/Fuel/Elect.Maintenance_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old2,$data_new2);

		$data_old3="PETTY_".$oldbr;
		$data_new3="PETTY_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old3,$data_new3);

		$data_old4="BANK_".$oldbr;
		$data_new4="BANK_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old4,$data_new4);

		$data_old5="CASH_".$oldbr;
		$data_new5="CASH_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old5,$data_new5);

		$data_old6="Rent_".$oldbr;
		$data_new6="Rent_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old6,$data_new6);

		$data_old7="OTHER  EXPENSES_".$oldbr;
		$data_new7="OTHER  EXPENSES_".$newbr;
		$update =$this->Onlinemodel->update_ledger($id,$data_old7,$data_new7);

				
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
		}
		else
	    {
			echo $action;
		}
		$data['branch']=$this->Onlinemodel->getBranch();
		// $data['branchid']=1;

		$this->load->view('header');
		$this->load->view('Branch',$data);
		$this->load->view('footer');
	}
	
	
	public function delete_branch()
    {
		$id=$this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
        $delete=$this->Onlinemodel->delete_branch($id);
		if($delete)
		{
			?>
			<script type="text/javascript">
			alert('Branch deleted successfully...');
			</script>
			<?php
		}
		$data['branch']=$this->Onlinemodel->getBranch();
		$this->load->view('header');
		$this->load->view('Branch',$data);
		$this->load->view('footer');
	}
	
	public function Autofill_Hsn()
	{  
		$this->load->model('Onlinemodel');
        $code= $this->input->post('b');
		$data=$this->Onlinemodel->Autofill_Hsn($code);
        echo json_encode($data); 
	}

	public function insertsize()
	{   $data =array();
		$data['sizevalue']=$this->input->post('b');
		$this->load->model('Onlinemodel');
		$size =$data['sizevalue'];
		$existence =$this->Onlinemodel->checkexistence_size($size);
		if($existence==0){
			$data1=$this->Onlinemodel->insertsize($data);
			
		}
		else{
			$data1=false;
		}
		echo json_encode($data1);	
	}
    
	//Branch_End
		  


	public function profitnloss()
	{
		if($this->session->userdata('name'))
		{
			$branchid = $this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['day']=$this->Onlinemodel->viewdaybook($cdate);
				$data['day1']=$this->Onlinemodel->viewdaybook($cdate);
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				if(!empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->profloss1($fdate,$tdate);
					$data['day1']=$this->Onlinemodel->profloss2($fdate,$tdate);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybook($cdate);
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('profitandloss',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['day']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				$data['day1']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				if(!empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->proflossbranch1($fdate,$tdate,$branchid);
					$data['day1']=$this->Onlinemodel->proflossbranch2($fdate,$tdate,$branchid);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('profitandloss',$data);
				$this->load->view('footer');
			}
			else
			{
				?>
				<script type="text/javascript">
				alert("Acess Denied...!!");
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

	public function balancesheet()
	{
		if($this->session->userdata('name'))
		{
			$data=array();
			$branchid=$this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['asset']=$this->Onlinemodel->GetAsset();
				$data['liabil']=$this->Onlinemodel->GetLiabilities();
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('balancesheet',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				$data['asset']=$this->Onlinemodel->GetAssetbranch($branchid);
				$data['liabil']=$this->Onlinemodel->GetLiabilitiesbranch($branchid);
						if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('balancesheet',$data);
				$this->load->view('footer');
			}
			else
			{
				?>
				<script type="text/javascript">
				alert("Acess Denied...!!");
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

	//UserRegistration_Start

	public function AddUser()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['adduser']=$this->Onlinemodel->getadduser();
				$data['branch']=$this->Onlinemodel->getBranch();
				$this->load->view('header');
          		$this->load->view('AddUser',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		} 
	}
	
	public function insert_adduser()
	{
		$action=$this->input->get_post('btnsave');
		$data=array();
		$data['firstname']=$this->input->get_post('firstname');
		$data['nickname']=$this->input->get_post('lastname');
		$data['role']=$this->input->get_post('role');
		$data['branch']=$this->input->get_post('branch');
		$data['phonenumber']=$this->input->get_post('phonenumber');
		$data['idnumber']=$this->input->get_post('idnumber');
		$data['email']=$this->input->get_post('email');
		$data['username']=$this->input->get_post('username');
		$pass=$this->input->get_post('password');
		$data['password']= password_hash($pass,PASSWORD_DEFAULT);
		$cpw=$this->input->get_post('confirmpassword');
		if($action=="Save")
		{
			$value=$data['username'];
			$existence=$this->Onlinemodel->checkexistence_adduser($value);
			if($existence==0)
			{
				if($cpw==$pass)
				{
					$result=$this->Onlinemodel->insert_adduser($data);
					if($result==true)
					{
						?> <script type="text/javascript">
						alert('Saved successfully........');
						</script>
						<?php 
					}
					else
					{
						?> <script type="text/javascript">
						alert('Insertion failed. please check the inputs!!!');
						</script> <?php
					}
				}
				else
				{
					?><script type="text/javascript">
					alert('Please ensure that Password and Confirm Password are same.');
					</script><?php 
			    }
			}
			else
			{
				?><script type="text/javascript">
				alert('User name already exists!!!. please use another name');
				</script> <?php
			}
		}
		else if($action=="Update")
		{
			if($cpw==$data['password'])
			{
				$id=$this->input->get_post('userid');
				$update =$this->Onlinemodel->update_adduser($data,$id);
				if($update==true)
				{
					?> <script type="text/javascript">
					alert('Updated Successfully...');
					</script>
					<?php 
		        } 
		        else
		        {
					?><script type="text/javascript">
					alert('Updation failed. please check the inputs!!!');
					</script> <?php 
		        }
		    }
			else
			{
				?><script type="text/javascript">
				alert('Please ensure that Password and Confirm Password are same.');
				</script> <?php 
			}
		}
		else
		{
			echo $action;
		}
		$data['adduser']=$this->Onlinemodel->getadduser();
		$data['branch']=$this->Onlinemodel->getBranch();
		$this->load->view('header');
		$this->load->view('AddUser',$data);
		$this->load->view('footer');
	}
	
	public function delete_adduser()
    {
		$id=$this->input->get_post('userid');
        $this->load->model('Onlinemodel');
        $delete=$this->Onlinemodel->delete_adduser($id);
		if($delete)
		{
			?><script type="text/javascript">
			alert('Deleted Successfully...');
			</script>
			<?php
		}
		else
		{
			?><script type="text/javascript">
			alert('Deletion failed!!!Please check the inputs.');
			</script>
			<?php
		}
		$data['adduser']=$this->Onlinemodel->getadduser();
		$data['branch']=$this->Onlinemodel->getBranch();
		$this->load->view('header');
		$this->load->view('AddUser',$data);
		$this->load->view('footer');
	}
	
	//UserRegistration_End

	public function Autofill_New()
	{  
		$this->load->model('Onlinemodel');
        $code  = $this->input->post('b');
        $data=$this->Onlinemodel->Autofill_Productdetails_TEST_new($code);
        echo json_encode($data);
	}
    
    public function salesinvoice()
	{
		if( $this->session->userdata('name'))
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
			$data['batch']=$this->Onlinemodel->getbatch();
			$data['size']=$this->Onlinemodel->getsize();
			$data['finyear']=$this->Onlinemodel->getfnyear($finyear);
			$data['invoiceno']=$this->Onlinemodel->Autogenerate_InvoiceNo($branchid,$finyear);
			$data['customer']=$this->Onlinemodel->getcustomer();
			$data['salesman']=$this->Onlinemodel->getsalesman();
			$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
			$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
			$data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
			if($this->session->userdata('role')=="Branch User")
			{
				$this->load->view('header_2');
			}
			else{
				$this->load->view('header');

			}
			$this->load->view('SalesInvoice',$data);
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
		
	
	//ChangePassword_Start
	
	public function Changepassword()
	{
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				// $data=array();
				// $data['adduser']=$this->Onlinemodel->getadduser();
				// $data['branch']=$this->Onlinemodel->getBranch();
				$this->load->view('header');
				$this->load->view('ChangePassword');
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}
	public function update_Changepassword()
	{
				$username = $this->input->get_post('username');
		        $oldpassword=$this->input->get_post('oldpassword');
		        $this->load->model('Onlinemodel');
		        $login['log']=$this->Onlinemodel->CheckUser($username);

				if($login['log'])
				{
		            foreach ($login['log']->result() as $key)
		            {
			            if(password_verify($oldpassword,$key->password))
						{
			            $newpassword=$this->input->get_post('newpassword');
			        	$confirmpassword=$this->input->get_post('confirmpassword');
			        	if($newpassword == $confirmpassword)
			        	{
			    		$username=$this->input->get_post('username');
			    		$columns=array();
			    		$columns['username']=$this->input->get_post('username');
			    		$pass=$this->input->get_post('newpassword');
						$columns['password']= password_hash($pass,PASSWORD_DEFAULT);

			    		$update=$this->Onlinemodel->update_user($username,$columns);
			    		if($update)
			          	{
			          	?>
						<script type="text/javascript">
							alert('Password Changed Successfully...');
						</script>
						<?php
			          	}
			          	else
			          	{
			          		?>
						<script type="text/javascript">
							alert('Updation failed!!!Please check the inputs.');
						</script>
						<?php
				        }

				        $this->session->unset_userdata('name');
		            	$this->load->view('LoginForm');
			            }
			        	else
				        	{
							?> <script type="text/javascript">
							alert('New Password doesn\'t match with Confirm Password');
							</script> <?php 
					        $this->load->view('ChangePassword');
			            	}
		                }
		                else 
		                {
	                	?> <script type="text/javascript">
						alert('Username doesn\'t match with old Password');
						</script> <?php 
						$this->load->view('header');
				        $this->load->view('ChangePassword');
				        $this->load->view('admin/footer');
		                }
			        }
			    	}
			    	else 
			    	{
			    		// wrng
			    	}

				}

			public function LoginCheck()
			{
				if( $this->session->userdata('name'))
				{
				
					if ($this->session->userdata('role')=="Branch User"){
						
						$this->load->view('admin/header_2');
					}
					else{
					$this->load->view('admin/header');

					}
		            $this->load->view('admin/index.html');
					$this->load->view('admin/footer');
				}
				else
				{

					$data=array();
					$username = $this->input->get_post('username');
					$password=$this->input->get_post('password');
					$this->load->model('Onlinemodel');
					$login['log']=$this->Onlinemodel->CheckUser($username);
					$finyear =$this->Onlinemodel->Fineyear();

					if($login['log'])
					{
						foreach ($login['log']->result() as $key)
						{
							if(password_verify($password,$key->password))
							{
								$name=$key->firstname;
								$user=$key->userid;
								$username=$key->username;
								$branch=$key->branch;
								$role =$key->role;
								$this->session->set_userdata('user', $user);
								$this->session->set_userdata('username', $username);
								$this->session->set_userdata('name', $name);
								$this->session->set_userdata('branch', $branch);
								$this->session->set_userdata('role', $role);
								$this->session->set_userdata('finyear', $finyear);
								if ($this->session->userdata('role')=="Branch User"){

									$this->load->view('admin/header_2');
								}
								else{
									$this->load->view('admin/header');

								}
								$this->load->view('admin/index.html');
								$this->load->view('admin/footer');
							}
							else
							{
								?><script type="text/javascript">
								alert('incorrect username or password');
								</script> <?php
								$this->index();
							}
						}
					}
				}
			}

          //ChangePassword_ENd

			//PurchaseReport_STA

//PurchaseReport_START
            //  public function password_hash(){
			// 	$this->load->model('Onlinemodel');
			// 	 $data =$this->Onlinemodel->getalluser();
			// 	 foreach($data->result() as $key){
			// 		 $id =$key->userid;
			// 		 $password =$key->password;
			// 		 $hash =password_hash($password,PASSWORD_DEFAULT);
			// 		 $data1 =$this->Onlinemodel->converttohash($id,$hash);
			// 	 }
			// 	 if($data1)
			// 	 $this->index();
			//  }
			public function PurchaseReport()
			{

				$branchid = $this->session->userdata('branch');
				$branchh=$branchid;

				if( $this->session->userdata('name'))
				{
					$data=array();


					$branchid=$this->input->get_post('branch');
					if($branchid==null)
					{
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
					$data['fromdate'] =  $fromdate;
					$data['todate'] =  $todate;

					$data['PurchaseDetailsAll']=$this->Onlinemodel->LoadPurchaseDetails_All_branch($fromdate,$todate,$branchid);

					if($this->session->userdata('role')=="Branch User")
					{
						$data['branch']=$this->Onlinemodel->getUserBranch($branchh);
						$this->load->view('header_2');
					}
					else{

						$data['branch']=$this->Onlinemodel->getBranch();
						$this->load->view('header');

					}
					// $this->load->view('header');
					$this->load->view('PurchaseReport',$data);
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

			
			//PurchaseReport_END


			public function PurchaseReturnReport()
			{

				$branchid = $this->session->userdata('branch');

				if( $this->session->userdata('name'))
				{
					$data=array();

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
					$data['fromdate'] =  $fromdate;
					$data['todate'] =  $todate;



$data['PurchaseReturnDetailsAll']=$this->Onlinemodel->LoadPurchaseReturnDetails_All_branch($fromdate,$todate,$branchid);
$data['branch']=$this->Onlinemodel->getUserBranch($branchid);

					$this->load->view('header_2');
					$this->load->view('PurchaseReturnReport',$data);
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

           //salesreport 

			// public function salesreport

			public function loadPurchaseDetailsAll()
			{
				$data=array();
				$data['PurchaseDetailsAll']=$this->Onlinemodel->LoadPurchaseDetails_All();
			}

			public function StockReport_group()
			{

$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');

$data['groupid']=$groupid;
$data['branchid']= $branchid;

$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only_group($branchid,$groupid);

$data['below2t']=$this->Onlinemodel->LoadAllstock_branch_only_group_below2t($branchid,$groupid);

$cur_stock =0;
$sz_cont =0;
$n_cont =0;

foreach ($data['below2t']->result() as $value) {
$n_cont ++;

	$cur_stock+= $value->currntStock;
	$sz_cont+= $value->sizeCount;
}

$data['cur_stock']=$cur_stock;
$data['sz_cont']= $sz_cont;
$data['n_cont']= $n_cont;


$data['2t2_5']=$this->Onlinemodel->LoadAllstock_branch_only_group_2t2_5($branchid,$groupid);

$cur_stock2_5 =0;
$sz_cont2_5 =0;
$n_cont2_5 =0;

foreach ($data['2t2_5']->result() as $value) {
$n_cont2_5 ++;

	$cur_stock2_5+= $value->currntStock;
	$sz_cont2_5+= $value->sizeCount;
}

$data['cur_stock2_5']=$cur_stock2_5;
$data['sz_cont2_5']= $sz_cont2_5;
$data['n_cont2_5']= $n_cont2_5;

$data['2_5t3']=$this->Onlinemodel->LoadAllstock_branch_only_group_2_5t3($branchid,$groupid);

$cur_stockt3 =0;
$sz_contt3 =0;
$n_contt3 =0;

foreach ($data['2_5t3']->result() as $value) {
$n_contt3 ++;
	$cur_stockt3+= $value->currntStock;
	$sz_contt3+= $value->sizeCount;
}

$data['cur_stockt3']=$cur_stockt3;
$data['sz_contt3']= $sz_contt3;
$data['n_contt3']= $n_contt3;

$data['3t3_5']=$this->Onlinemodel->LoadAllstock_branch_only_group_3t3_5($branchid,$groupid);

$cur_stockt3_5 =0;
$sz_contt3_5 =0;
$n3_5 = 0 ;

foreach ($data['3t3_5']->result() as $value) {
	$n3_5 ++ ;
	$cur_stockt3_5+= $value->currntStock;
	$sz_contt3_5+= $value->sizeCount;
}

$data['cur_stockt3_5']=$cur_stockt3_5;
$data['sz_contt3_5']= $sz_contt3_5;
$data['n3_5']= $n3_5;

$data['3_5t4']=$this->Onlinemodel->LoadAllstock_branch_only_group_3_5t4($branchid,$groupid);

$cur_stockt4t =0;
$sz_contt4t =0;
$n_contt4t =0;

foreach ($data['3_5t4']->result() as $value) {
$n_contt4t ++;
	$cur_stockt4t+= $value->currntStock;
	$sz_contt4t+= $value->sizeCount;
}

$data['cur_stockt4t']=$cur_stockt4t;
$data['sz_contt4t']= $sz_contt4t;
$data['n_contt4t']= $n_contt4t;

$data['4t4_5']=$this->Onlinemodel->LoadAllstock_branch_only_group_4t4_5($branchid,$groupid);

$cur_stockt4_5 =0;
$sz_contt4_5 =0;
$n_contt4_5 =0;

foreach ($data['4t4_5']->result() as $value) {
$n_contt4_5 ++;
	$cur_stockt4_5+= $value->currntStock;
	$sz_contt4_5+= $value->sizeCount;
}

$data['cur_stockt4_5']=$cur_stockt4_5;
$data['sz_contt4_5']= $sz_contt4_5;
$data['n_contt4_5']= $n_contt4_5;


$data['4_5t5']=$this->Onlinemodel->LoadAllstock_branch_only_group_4_5t5($branchid,$groupid);

$cur_stockt5t =0;
$sz_contt5t =0;
$n_contt5t =0;

foreach ($data['4_5t5']->result() as $value) {
$n_contt5t ++;
	$cur_stockt5t+= $value->currntStock;
	$sz_contt5t+= $value->sizeCount;
}

$data['cur_stockt5t']=$cur_stockt5t;
$data['sz_contt5t']= $sz_contt5t;
$data['n_contt5t']= $n_contt5t;


$data['above5t']=$this->Onlinemodel->LoadAllstock_branch_only_group_above5t($branchid,$groupid);

$cur_stockt5abv =0;
$sz_contt5abv =0;
$n_contt5abv =0;

foreach ($data['above5t']->result() as $value) {
$n_contt5abv ++;
	$cur_stockt5abv+= $value->currntStock;
	$sz_contt5abv+= $value->sizeCount;
}

$data['cur_stockt5abv']=$cur_stockt5abv;
$data['sz_contt5abv']= $sz_contt5abv;
$data['n_contt5abv']= $n_contt5abv;


$this->load->view('header');
$this->load->view('stockreport_group',$data);
$this->load->view('footer');


			}



			public function StockReport_group_all()
			{

				$groupid=$this->input->get_post('groupid');
				$branchid = $this->input->get_post('branch');
				$price = $this->input->get_post('price');

				$data['below2t']=$this->Onlinemodel->LoadAllstock_branch_only_group_below2t($branchid,$groupid);

				$data['b2t25']=$this->Onlinemodel->LoadAllstock_branch_only_group_2t2_5($branchid,$groupid);

				$data['b25t3']=$this->Onlinemodel->LoadAllstock_branch_only_group_2_5t3($branchid,$groupid);

				$data['b3t35']=$this->Onlinemodel->LoadAllstock_branch_only_group_3t3_5($branchid,$groupid);

				$data['b35t4']=$this->Onlinemodel->LoadAllstock_branch_only_group_3_5t4($branchid,$groupid);


				$data['b4t45']=$this->Onlinemodel->LoadAllstock_branch_only_group_4t4_5($branchid,$groupid);


				$data['b45t5']=$this->Onlinemodel->LoadAllstock_branch_only_group_4_5t5($branchid,$groupid);


				$data['above5t']=$this->Onlinemodel->LoadAllstock_branch_only_group_above5t($branchid,$groupid);


				$this->load->view('header');
				$this->load->view('stockreport_group_all',$data);
				$this->load->view('footer');


			}

public function StockReport_group_all_below2t()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_below2t($branchid,$groupid);

$data['range'] = 'Below 2000';

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_2t2_5()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 2000 - 2500';


$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_2t2_5($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_2_5t3()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 2500 - 3000';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_2_5t3($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_3t3_5()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 3000 - 3500';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_3t3_5($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_3_5t4()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 3500 - 4000';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_3_5t4($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_4t4_5()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 4000 - 4500';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_4t4_5($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_4_5t5()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Between 4500 - 5000';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_4_5t5($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}

public function StockReport_group_all_above5t()
{
$groupid=$this->input->get_post('groupid');
$branchid = $this->input->get_post('branch');
$data['range'] = 'Above 5000';

$data['price_range']=$this->Onlinemodel->LoadAllstock_branch_only_group_above5t($branchid,$groupid);

$this->load->view('header');
$this->load->view('stockreport_group_all',$data);
$this->load->view('footer');
}


			public function stockregisterPDTreport()
			{
				if($this->session->userdata('name'))
				{

					if($this->session->userdata('role')=="Super Admin")
					{
						$data=array();
						$fromdate=$this->input->get_post('fromdate');
						$todate=$this->input->get_post('todate');
						$branch=$this->input->get_post('branch');

						if($branch==null)
						{
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

						$data['branchname']=$branchid;
						$data['fromdate'] = $fromdate;
						$data['todate'] =  $todate;


						$data['branch']=$this->Onlinemodel->getBranch();

						$data['product']=$this->Onlinemodel->getproduct();


						$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only($branchid);


						$this->load->view('header');
						$this->load->view('StockRegPDTReport',$data);
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



			//stock register Report

			public function stockregisterreport()
			{
				if($this->session->userdata('name'))
				{

					if($this->session->userdata('role')=="Super Admin")
					{
						$data=array();
						$fromdate=$this->input->get_post('fromdate');
						$todate=$this->input->get_post('todate');
						$branch=$this->input->get_post('branch');

						if($branch==null)
						{
							$branchid=$this->session->userdata('branch');

						}

						// $fromdate=$this->input->get_post('fromdate');
						// if($fromdate==null)
						// {
						// 	$fromdate=date('Y-m-01');
						// }
						// $todate=$this->input->get_post('todate');
						// if($todate==null)
						// {
						// 	$todate=date('Y-m-t');
						// 	$tdate=$todate;
						// }
						// else
						// {
						// 	$tdate=date_add(date_create($todate),date_interval_create_from_date_string("1 days"));
						// 	$tdate=date_format($tdate,"Y-m-d");
						// }

						$data['branchname']=$branchid;
						$data['fromdate'] = $fromdate;
						$data['todate'] =  $todate;


						$data['branch']=$this->Onlinemodel->getBranch();

				$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only($branchid);

						$this->load->view('header');
						$this->load->view('StockRegReport',$data);
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


			//StockReport_Start

			public function StockReport()
			{
				if($this->session->userdata('name'))
				{
					$branchid = $this->session->userdata('branch');
					$branchh=$branchid;
					if($this->session->userdata('role')=="Super Admin")
					{
						$data=array();
						$fromdate=$this->input->get_post('fromdate');
						$todate=$this->input->get_post('todate');
						$branch=$this->input->get_post('branch');

						// echo $fromdate;
						// echo $todate;
						$Searchoption=$this->input->get_post('searchoption');
						$data['branch']=$this->Onlinemodel->getBranch();

						if($Searchoption=="NegativeStock")
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadNegativeStock();
						}
						else if($Searchoption=="Reorderlevel")
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadReorderLevel();
						}
						else if($Searchoption=="Unused")
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadUnused();
						}
						else if($Searchoption=="Fastmoving")
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadFastMoving();
						}
						else if($Searchoption=="Slowmoving")
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadSlowMoving();
						}
						else if($Searchoption=="Fastmoving" && !empty($fromdate) && !empty($todate))
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadFastMovingBtwDates($fromdate,$todate);
						}
						else if($Searchoption=="Slowmoving" && !empty($fromdate) && !empty($todate))
						{
							$data['Stockdetails']=$this->Onlinemodel->LoadSlowMovingBtwDates($fromdate,$todate);
						}
						else
						{
						if ($branch!=null) {

						$brancch=$this->input->get_post('branch');

						}else{

						$brancch = $this->session->userdata('branch');

						}

						// if ($fromdate == null) {

					$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only($brancch);
					$data['branchname']=$brancch;

					$sum = 0;
					$sums = 0;
					$qttyy = 0;

					$groupid_Pins = 0;
					$qty_Pins = 0;
					$pinsum = 0;
					$pinsums = 0;

					$hijasum = 0;
					$hijasums = 0;
					$qty_Hijab = 0;
					$groupid_Hijab = 0;

					$qty_MISWAK = 0;
					$misums = 0;
					$misum = 0;
					$groupid_Miswak = 0;


					$qty_prmy = 0;
					$prmysum = 0;
					$prmysums = 0;
					$groupid_Primary = 0;

					$qty_cps = 0;
					$cpssum = 0;
					$cpssums = 0;
					$groupid_Caps = 0;

					$inn_qty = 0;
					$inn_sum = 0;
					$inn_sums = 0;
					$groupid_Inner = 0;

					$Tops_qty = 0;
					$Tops_sum = 0;
					$Tops_sums = 0;
					$groupid_Tops = 0;

					$Acc_qty = 0;
					$Acc_sum = 0;
					$Acc_sums = 0;
					$groupid_Acces = 0;

					$Nigh_qty = 0;
					$Nigh_sum = 0;
					$Nigh_sums = 0;
					$groupid_Night = 0;

					$Night_qty = 0;
					$Night_sum = 0;
					$Night_sums = 0;
					$groupid_Nighti = 0;

					$Pants_qty = 0;
					$Pants_sum = 0;
					$Pants_sums = 0;
					$groupid_Pants = 0;

					$AbaW_qty = 0;
					$AbaW_sum = 0;
					$AbaW_sums = 0;
					$groupid_AbayaWash = 0;

					$cos_qty = 0;
					$cos_sum = 0;
					$cos_sums = 0;
					$groupid_Cosm = 0;

					$jaz_qty = 0;
					$jaz_sum = 0;
					$jaz_sums = 0;
					$groupid_Jaza = 0;

					$on_qty = 0;
					$on_sum = 0;
					$on_sums = 0;
					$groupid_Online = 0;

					$aba_qty = 0;
					$aba_sum = 0;
					$aba_sums = 0;
					$groupid_Abayas = 0;

					$aba2_qty = 0;
					$aba2_sum = 0;
					$aba2_sums = 0;
					$groupid_Abayas2 = 0;

					$mod_qty = 0;
					$mod_sum = 0;
					$mod_sums = 0;
					$groupid_Mod = 0;

					$cons_qty = 0;
					$cons_sum = 0;
					$cons_sums = 0;
					$groupid_Consu = 0;

					$new_qty = 0;
					$new_sum = 0;
					$new_sums = 0;
					$groupid_New = 0;

                  $i=0;
                  $cleanarray = array();

                  foreach ($data['Stockdetails']->result() as $value) {
                    $sum+= $value->purchaserate*$value->currentstock;
                    $sums+= $value->mrp*$value->currentstock;
                    $qttyy+= $value->currentstock;

                    if ($value->groupname == 'Pins') {
                    $groupid_Pins = $value->groupid;

                    $qty_Pins+= $value->currentstock;
                    $pinsum+= $value->purchaserate*$value->currentstock;
                    $pinsums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'MISWAK') {
                    $groupid_Miswak = $value->groupid;

                    $qty_MISWAK+= $value->currentstock;
                    $misum+= $value->purchaserate*$value->currentstock;
                    $misums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Hijab') {
                    $groupid_Hijab = $value->groupid;

                    $qty_Hijab+= $value->currentstock;
                    $hijasum+= $value->purchaserate*$value->currentstock;
                    $hijasums+= $value->mrp*$value->currentstock;


                    }elseif ($value->groupname == 'primary') {
                    $groupid_Primary = $value->groupid;

                    $qty_prmy+= $value->currentstock;
                    $prmysum+= $value->purchaserate*$value->currentstock;
                    $prmysums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Caps') {
                    $groupid_Caps = $value->groupid;

                    $qty_cps+= $value->currentstock;
                    $cpssum+= $value->purchaserate*$value->currentstock;
                    $cpssums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Innerwears') {
                    $groupid_Inner = $value->groupid;

                    $inn_qty+= $value->currentstock;
                    $inn_sum+= $value->purchaserate*$value->currentstock;
                    $inn_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Tops') {
                    $groupid_Tops = $value->groupid;

                    $Tops_qty+= $value->currentstock;
                    $Tops_sum+= $value->purchaserate*$value->currentstock;
                    $Tops_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Accessories') {
                    $groupid_Acces = $value->groupid;

                    $Acc_qty+= $value->currentstock;
                    $Acc_sum+= $value->purchaserate*$value->currentstock;
                    $Acc_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Nightwears') {
                    $groupid_Night = $value->groupid;

                    $Nigh_qty+= $value->currentstock;
                    $Nigh_sum+= $value->purchaserate*$value->currentstock;
                    $Nigh_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Nighties') {
                    $groupid_Nighti = $value->groupid;

                    $Night_qty+= $value->currentstock;
                    $Night_sum+= $value->purchaserate*$value->currentstock;
                    $Night_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Pants') {
                    $groupid_Pants = $value->groupid;

                    $Pants_qty+= $value->currentstock;
                    $Pants_sum+= $value->purchaserate*$value->currentstock;
                    $Pants_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Abaya Wash (Liquid)') {
                    $groupid_AbayaWash = $value->groupid;

                    $AbaW_qty+= $value->currentstock;
                    $AbaW_sum+= $value->purchaserate*$value->currentstock;
                    $AbaW_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'Cosmetics') {
                    $groupid_Cosm = $value->groupid;

                    $cos_qty+= $value->currentstock;
                    $cos_sum+= $value->purchaserate*$value->currentstock;
                    $cos_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'JAZA PARDHA') {
                    $groupid_Jaza = $value->groupid;

                    $jaz_qty+= $value->currentstock;
                    $jaz_sum+= $value->purchaserate*$value->currentstock;
                    $jaz_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'ONLINE') {
                    $groupid_Online = $value->groupid;

                    $on_qty+= $value->currentstock;
                    $on_sum+= $value->purchaserate*$value->currentstock;
                    $on_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'ABAYAS') {
                    $groupid_Abayas = $value->groupid;

                    $aba_qty+= $value->currentstock;
                    $aba_sum+= $value->purchaserate*$value->currentstock;
                    $aba_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'ABAYA 2') {
                    $groupid_Abayas2 = $value->groupid;

                    $aba2_qty+= $value->currentstock;
                    $aba2_sum+= $value->purchaserate*$value->currentstock;
                    $aba2_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'MODEST WEAR') {
                    $groupid_Mod = $value->groupid;

                    $mod_qty+= $value->currentstock;
                    $mod_sum+= $value->purchaserate*$value->currentstock;
                    $mod_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'CONSUMABLES') {
                    $groupid_Consu = $value->groupid;

                    $cons_qty+= $value->currentstock;
                    $cons_sum+= $value->purchaserate*$value->currentstock;
                    $cons_sums+= $value->mrp*$value->currentstock;

                    }elseif ($value->groupname == 'NEW ABAYAS') {
                    $groupid_New = $value->groupid;

                    $new_qty+= $value->currentstock;
                    $new_sum+= $value->purchaserate*$value->currentstock;
                    $new_sums+= $value->mrp*$value->currentstock;
                    } else{ }

                  }

                  $cleanname[$i] = 'Pins';
                  $grouparray[$i] = $groupid_Pins;
                  $cleanarray[$i] = $qty_Pins;
                  $cleancost[$i] = $pinsum;
                  $cleancosts[$i] = $pinsums;

                  $i++;

                  $cleanname[$i] = 'Hijab';
                  $cleanarray[$i] = $qty_Hijab;
                  $cleancost[$i] = $hijasum;
                  $cleancosts[$i] = $hijasums;
                  $grouparray[$i] = $groupid_Hijab;
                  $i++;

                  $cleanname[$i] = 'MISWAK';
                  $cleanarray[$i] = $qty_MISWAK;
                  $cleancost[$i] = $misum;
                  $cleancosts[$i] = $misums;
                  $grouparray[$i] = $groupid_Miswak;

                  $i++;

                  $cleanname[$i] = 'primary';
                  $cleanarray[$i] = $qty_prmy;
                  $cleancost[$i] = $prmysum;
                  $cleancosts[$i] = $prmysums;
                  $grouparray[$i] = $groupid_Primary;

                  $i++;

                  $cleanname[$i] = 'Caps';
                  $cleanarray[$i] = $qty_cps;
                  $cleancost[$i] = $cpssum;
                  $cleancosts[$i] = $cpssums;
                  $grouparray[$i] = $groupid_Caps;

                  $i++;

                  $cleanname[$i] = 'Innerwears';
                  $cleanarray[$i] = $inn_qty;
                  $cleancost[$i] = $inn_sum;
                  $cleancosts[$i] = $inn_sums;
                  $grouparray[$i] = $groupid_Inner;

                  $i++;

                  $cleanname[$i] = 'Tops';
                  $cleanarray[$i] = $Tops_qty;
                  $cleancost[$i] = $Tops_sum;
                  $cleancosts[$i] = $Tops_sums;
                  $grouparray[$i] = $groupid_Tops;

                  $i++;

                  $cleanname[$i] = 'Accessories';
                  $cleanarray[$i] = $Acc_qty;
                  $cleancost[$i] = $Acc_sum;
                  $cleancosts[$i] = $Acc_sums;
                  $grouparray[$i] = $groupid_Acces;

                  $i++;

                  $cleanname[$i] = 'Nightwears';
                  $cleanarray[$i] = $Nigh_qty;
                  $cleancost[$i] = $Nigh_sum;
                  $cleancosts[$i] = $Nigh_sums;
                  $grouparray[$i] = $groupid_Night;

                  $i++;

                  $cleanname[$i] = 'Nighties';
                  $cleanarray[$i] = $Night_qty;
                  $cleancost[$i] = $Night_sum;
                  $cleancosts[$i] = $Night_sums;
                  $grouparray[$i] = $groupid_Nighti;

                  $i++;

                  $cleanname[$i] = 'Pants';
                  $cleanarray[$i] = $Pants_qty;
                  $cleancost[$i] = $Pants_sum;
                  $cleancosts[$i] = $Pants_sums;
                  $grouparray[$i] = $groupid_Pants;

                  $i++;


                  $cleanname[$i] = 'Abaya Wash (Liquid)';
                  $cleanarray[$i] = $AbaW_qty;
                  $cleancost[$i] = $AbaW_sum;
                  $cleancosts[$i] = $AbaW_sums;
                  $grouparray[$i] = $groupid_AbayaWash;

                  $i++;

                  $cleanname[$i] = 'Cosmetics';
                  $cleanarray[$i] = $cos_qty;
                  $cleancost[$i] = $cos_sum;
                  $cleancosts[$i] = $cos_sums;
                  $grouparray[$i] = $groupid_Cosm;

                  $i++;

                  $cleanname[$i] = 'JAZA PARDHA';
                  $cleanarray[$i] = $jaz_qty;
                  $cleancost[$i] = $jaz_sum;
                  $cleancosts[$i] = $jaz_sums;
                  $grouparray[$i] = $groupid_Jaza;

                  $i++;

                  $cleanname[$i] = 'ONLINE';
                  $cleanarray[$i] = $on_qty;
                  $cleancost[$i] = $on_sum;
                  $cleancosts[$i] = $on_sums;
                  $grouparray[$i] = $groupid_Online;

                  $i++;

                  $cleanname[$i] = 'ABAYAS';
                  $cleanarray[$i] = $aba_qty;
                  $cleancost[$i] = $aba_sum;
                  $cleancosts[$i] = $aba_sums;
                  $grouparray[$i] = $groupid_Abayas;

                  $i++;

                  $cleanname[$i] = 'ABAYAS 2';
                  $cleanarray[$i] = $aba2_qty;
                  $cleancost[$i] = $aba2_sum;
                  $cleancosts[$i] = $aba2_sums;
                  $grouparray[$i] = $groupid_Abayas2;

                  $i++;

                  $cleanname[$i] = 'MODEST WEAR';
                  $cleanarray[$i] = $mod_qty;
                  $cleancost[$i] = $mod_sum;
                  $cleancosts[$i] = $mod_sums;
                  $grouparray[$i] = $groupid_Mod;

                  $i++;

                  $cleanname[$i] = 'CONSUMABLES';
                  $cleanarray[$i] = $cons_qty;
                  $cleancost[$i] = $cons_sum;
                  $cleancosts[$i] = $cons_sums;
                  $grouparray[$i] = $groupid_Consu;

                  $i++;

                  $cleanname[$i] = 'NEW ABAYAS';
                  $cleanarray[$i] = $new_qty;
                  $cleancost[$i] = $new_sum;
                  $cleancosts[$i] = $new_sums;
                  $grouparray[$i] = $groupid_New;

                  $i++;
                  
                  $data['contentsgroup']= $grouparray;
                  $data['contentsqty']= $cleanarray;
                  $data['contentsname']= $cleanname;
                  $data['contentscost']= $cleancost;
                  $data['contentscosts']= $cleancosts;

                  // die();
                  $data['summ']=$sum;
                  $data['summs']=$sums;
                  $data['qtty']= $qttyy;				

					// }else{

					// 	$data['costamont']=$this->Onlinemodel->getsalescost($branch,$fromdate,$todate);

					// 	$data['branchname']='All Branch';

					// 	$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch($branch,$fromdate,$todate);

					// 	$sum = 0;
					// 	$sums = 0;

					// 	foreach ($data['Stockdetails']->result() as $value) {
					// 		$sum+= $value->purchaserate*$value->currentstock;
					// 		$sums+= $value->mrp*$value->currentstock;

					// 	}

					// 	$data['summ']=$sum;
					// 	$data['summs']=$sums;
					// 	$data['qtty']=200;
					// }

					// }else{

					// 	$data['summ']=0;
					// 	$data['summs']=0;
					// 	$data['qtty']=0;

					// 	$data['contentsqty']= 0;
					// 	$data['contentsname']= 0;
					// 	$data['contentscost']= 0;
					// 	$data['contentscosts']=0;
					// 	$data['branchname']='All Branch';

					// 	// $data['costamont']=$this->Onlinemodel->getsalescost1($branchid);
					// 	// $data['Stockdetails']=$this->Onlinemodel->LoadAllstock();
					// 	$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only($branchid);

					// }

				}

						$data['branchid']=$branchh;
						if($this->session->userdata('role')=="Branch User")
						{
							$this->load->view('header_2');
						}
						else{
							$this->load->view('header');

						}
						$this->load->view('StockReport',$data);
						$this->load->view('footer');
					}
					else if($this->session->userdata('role')=="Branch User")
					{
						$data=array();
						$fromdate=$this->input->get_post('fromdate');
						$todate=$this->input->get_post('todate');
						$data['branchname']=$branchid;


						$data['branch']=$this->Onlinemodel->getUserBranch($branchid);

						$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only($branchid);



									$sum = 0;
									$sums = 0;
									$qttyy = 0;

									$groupid_Pins = 0;
									$qty_Pins = 0;
									$pinsum = 0;
									$pinsums = 0;
									
									$hijasum = 0;
									$hijasums = 0;
									$qty_Hijab = 0;
									$groupid_Hijab = 0;

									$qty_MISWAK = 0;
									$misums = 0;
									$misum = 0;
									$groupid_Miswak = 0;


									$qty_prmy = 0;
									$prmysum = 0;
									$prmysums = 0;
									$groupid_Primary = 0;

									$qty_cps = 0;
									$cpssum = 0;
									$cpssums = 0;
									$groupid_Caps = 0;

									$inn_qty = 0;
									$inn_sum = 0;
									$inn_sums = 0;
									$groupid_Inner = 0;

									$Tops_qty = 0;
									$Tops_sum = 0;
									$Tops_sums = 0;
									$groupid_Tops = 0;

									$Acc_qty = 0;
									$Acc_sum = 0;
									$Acc_sums = 0;
									$groupid_Acces = 0;

									$Nigh_qty = 0;
									$Nigh_sum = 0;
									$Nigh_sums = 0;
									$groupid_Night = 0;

									$Night_qty = 0;
									$Night_sum = 0;
									$Night_sums = 0;
									$groupid_Nighti = 0;

									$Pants_qty = 0;
									$Pants_sum = 0;
									$Pants_sums = 0;
									$groupid_Pants = 0;

									$AbaW_qty = 0;
									$AbaW_sum = 0;
									$AbaW_sums = 0;
									$groupid_AbayaWash = 0;

									$cos_qty = 0;
									$cos_sum = 0;
									$cos_sums = 0;
									$groupid_Cosm = 0;

									$jaz_qty = 0;
									$jaz_sum = 0;
									$jaz_sums = 0;
									$groupid_Jaza = 0;

									$on_qty = 0;
									$on_sum = 0;
									$on_sums = 0;
									$groupid_Online = 0;

									$aba_qty = 0;
									$aba_sum = 0;
									$aba_sums = 0;
									$groupid_Abayas = 0;

									$aba2_qty = 0;
									$aba2_sum = 0;
									$aba2_sums = 0;
									$groupid_Abayas2 = 0;

									$mod_qty = 0;
									$mod_sum = 0;
									$mod_sums = 0;
									$groupid_Mod = 0;

									$cons_qty = 0;
									$cons_sum = 0;
									$cons_sums = 0;
									$groupid_Consu = 0;

									$new_qty = 0;
									$new_sum = 0;
									$new_sums = 0;
									$groupid_New = 0;

									$i=0;
									$cleanarray = array();

									foreach ($data['Stockdetails']->result() as $value) {
										$sum+= $value->purchaserate*$value->currentstock;
										$sums+= $value->mrp*$value->currentstock;
										$qttyy+= $value->currentstock;

										if ($value->groupname == 'Pins') {
										$groupid_Pins = $value->groupid;

										$qty_Pins+= $value->currentstock;
										$pinsum+= $value->purchaserate*$value->currentstock;
										$pinsums+= $value->mrp*$value->currentstock;


										}elseif ($value->groupname == 'MISWAK') {
										$groupid_Miswak = $value->groupid;

										$qty_MISWAK+= $value->currentstock;
										$misum+= $value->purchaserate*$value->currentstock;
										$misums+= $value->mrp*$value->currentstock;



										}elseif ($value->groupname == 'Hijab') {
										$groupid_Hijab = $value->groupid;

										$qty_Hijab+= $value->currentstock;
										$hijasum+= $value->purchaserate*$value->currentstock;
										$hijasums+= $value->mrp*$value->currentstock;


										}elseif ($value->groupname == 'primary') {
										$groupid_Primary = $value->groupid;

										$qty_prmy+= $value->currentstock;
										$prmysum+= $value->purchaserate*$value->currentstock;
										$prmysums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Caps') {
										$groupid_Caps = $value->groupid;

										$qty_cps+= $value->currentstock;
										$cpssum+= $value->purchaserate*$value->currentstock;
										$cpssums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Innerwears') {
										$groupid_Inner = $value->groupid;

										$inn_qty+= $value->currentstock;
										$inn_sum+= $value->purchaserate*$value->currentstock;
										$inn_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Tops') {
										$groupid_Tops = $value->groupid;

										$Tops_qty+= $value->currentstock;
										$Tops_sum+= $value->purchaserate*$value->currentstock;
										$Tops_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Accessories') {
										$groupid_Acces = $value->groupid;

										$Acc_qty+= $value->currentstock;
										$Acc_sum+= $value->purchaserate*$value->currentstock;
										$Acc_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Nightwears') {
										$groupid_Night = $value->groupid;

										$Nigh_qty+= $value->currentstock;
										$Nigh_sum+= $value->purchaserate*$value->currentstock;
										$Nigh_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Nighties') {
										$groupid_Nighti = $value->groupid;

										$Night_qty+= $value->currentstock;
										$Night_sum+= $value->purchaserate*$value->currentstock;
										$Night_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Pants') {
										$groupid_Pants = $value->groupid;

										$Pants_qty+= $value->currentstock;
										$Pants_sum+= $value->purchaserate*$value->currentstock;
										$Pants_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Abaya Wash (Liquid)') {
										$groupid_AbayaWash = $value->groupid;

										$AbaW_qty+= $value->currentstock;
										$AbaW_sum+= $value->purchaserate*$value->currentstock;
										$AbaW_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'Cosmetics') {
										$groupid_Cosm = $value->groupid;

										$cos_qty+= $value->currentstock;
										$cos_sum+= $value->purchaserate*$value->currentstock;
										$cos_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'JAZA PARDHA') {
										$groupid_Jaza = $value->groupid;

										$jaz_qty+= $value->currentstock;
										$jaz_sum+= $value->purchaserate*$value->currentstock;
										$jaz_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'ONLINE') {
										$groupid_Online = $value->groupid;

										$on_qty+= $value->currentstock;
										$on_sum+= $value->purchaserate*$value->currentstock;
										$on_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'ABAYAS') {
										$groupid_Abayas = $value->groupid;

										$aba_qty+= $value->currentstock;
										$aba_sum+= $value->purchaserate*$value->currentstock;
										$aba_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'ABAYA 2') {
										$groupid_Abayas2 = $value->groupid;

										$aba2_qty+= $value->currentstock;
										$aba2_sum+= $value->purchaserate*$value->currentstock;
										$aba2_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'MODEST WEAR') {
										$groupid_Mod = $value->groupid;

										$mod_qty+= $value->currentstock;
										$mod_sum+= $value->purchaserate*$value->currentstock;
										$mod_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'CONSUMABLES') {
										$groupid_Consu = $value->groupid;

										$cons_qty+= $value->currentstock;
										$cons_sum+= $value->purchaserate*$value->currentstock;
										$cons_sums+= $value->mrp*$value->currentstock;

										}elseif ($value->groupname == 'NEW ABAYAS') {
										$groupid_New = $value->groupid;

										$new_qty+= $value->currentstock;
										$new_sum+= $value->purchaserate*$value->currentstock;
										$new_sums+= $value->mrp*$value->currentstock;

										}
										else{

										}

									}

									$cleanname[$i] = 'Pins';
									$grouparray[$i] = $groupid_Pins;
									$cleanarray[$i] = $qty_Pins;
									$cleancost[$i] = $pinsum;
									$cleancosts[$i] = $pinsums;

									$i++;

									$cleanname[$i] = 'Hijab';
									$cleanarray[$i] = $qty_Hijab;
									$cleancost[$i] = $hijasum;
									$cleancosts[$i] = $hijasums;
									$grouparray[$i] = $groupid_Hijab;
									$i++;

									$cleanname[$i] = 'MISWAK';
									$cleanarray[$i] = $qty_MISWAK;
									$cleancost[$i] = $misum;
									$cleancosts[$i] = $misums;
									$grouparray[$i] = $groupid_Miswak;

									$i++;

									$cleanname[$i] = 'primary';
									$cleanarray[$i] = $qty_prmy;
									$cleancost[$i] = $prmysum;
									$cleancosts[$i] = $prmysums;
									$grouparray[$i] = $groupid_Primary;

									$i++;

									$cleanname[$i] = 'Caps';
									$cleanarray[$i] = $qty_cps;
									$cleancost[$i] = $cpssum;
									$cleancosts[$i] = $cpssums;
									$grouparray[$i] = $groupid_Caps;

									$i++;

									$cleanname[$i] = 'Innerwears';
									$cleanarray[$i] = $inn_qty;
									$cleancost[$i] = $inn_sum;
									$cleancosts[$i] = $inn_sums;
									$grouparray[$i] = $groupid_Inner;

									$i++;

									$cleanname[$i] = 'Tops';
									$cleanarray[$i] = $Tops_qty;
									$cleancost[$i] = $Tops_sum;
									$cleancosts[$i] = $Tops_sums;
									$grouparray[$i] = $groupid_Tops;

									$i++;

									$cleanname[$i] = 'Accessories';
									$cleanarray[$i] = $Acc_qty;
									$cleancost[$i] = $Acc_sum;
									$cleancosts[$i] = $Acc_sums;
									$grouparray[$i] = $groupid_Acces;

									$i++;

									$cleanname[$i] = 'Nightwears';
									$cleanarray[$i] = $Nigh_qty;
									$cleancost[$i] = $Nigh_sum;
									$cleancosts[$i] = $Nigh_sums;
									$grouparray[$i] = $groupid_Night;

									$i++;

									$cleanname[$i] = 'Nighties';
									$cleanarray[$i] = $Night_qty;
									$cleancost[$i] = $Night_sum;
									$cleancosts[$i] = $Night_sums;
									$grouparray[$i] = $groupid_Nighti;

									$i++;

									$cleanname[$i] = 'Pants';
									$cleanarray[$i] = $Pants_qty;
									$cleancost[$i] = $Pants_sum;
									$cleancosts[$i] = $Pants_sums;
									$grouparray[$i] = $groupid_Pants;

									$i++;


									$cleanname[$i] = 'Abaya Wash (Liquid)';
									$cleanarray[$i] = $AbaW_qty;
									$cleancost[$i] = $AbaW_sum;
									$cleancosts[$i] = $AbaW_sums;
									$grouparray[$i] = $groupid_AbayaWash;

									$i++;

									$cleanname[$i] = 'Cosmetics';
									$cleanarray[$i] = $cos_qty;
									$cleancost[$i] = $cos_sum;
									$cleancosts[$i] = $cos_sums;
									$grouparray[$i] = $groupid_Cosm;

									$i++;

									$cleanname[$i] = 'JAZA PARDHA';
									$cleanarray[$i] = $jaz_qty;
									$cleancost[$i] = $jaz_sum;
									$cleancosts[$i] = $jaz_sums;
									$grouparray[$i] = $groupid_Jaza;

									$i++;

									$cleanname[$i] = 'ONLINE';
									$cleanarray[$i] = $on_qty;
									$cleancost[$i] = $on_sum;
									$cleancosts[$i] = $on_sums;
									$grouparray[$i] = $groupid_Online;

									$i++;

									$cleanname[$i] = 'ABAYAS';
									$cleanarray[$i] = $aba_qty;
									$cleancost[$i] = $aba_sum;
									$cleancosts[$i] = $aba_sums;
									$grouparray[$i] = $groupid_Abayas;

									$i++;

									$cleanname[$i] = 'ABAYAS 2';
									$cleanarray[$i] = $aba2_qty;
									$cleancost[$i] = $aba2_sum;
									$cleancosts[$i] = $aba2_sums;
									$grouparray[$i] = $groupid_Abayas2;

									$i++;

									$cleanname[$i] = 'MODEST WEAR';
									$cleanarray[$i] = $mod_qty;
									$cleancost[$i] = $mod_sum;
									$cleancosts[$i] = $mod_sums;
									$grouparray[$i] = $groupid_Mod;

									$i++;

									$cleanname[$i] = 'CONSUMABLES';
									$cleanarray[$i] = $cons_qty;
									$cleancost[$i] = $cons_sum;
									$cleancosts[$i] = $cons_sums;
									$grouparray[$i] = $groupid_Consu;

									$i++;

									$cleanname[$i] = 'NEW ABAYAS';
									$cleanarray[$i] = $new_qty;
									$cleancost[$i] = $new_sum;
									$cleancosts[$i] = $new_sums;
									$grouparray[$i] = $groupid_New;

									$i++;
									

									$data['contentsgroup']= $grouparray;
									$data['contentsqty']= $cleanarray;
									$data['contentsname']= $cleanname;
									$data['contentscost']= $cleancost;
									$data['contentscosts']= $cleancosts;

									// die();
									$data['summ']=$sum;
									$data['summs']=$sums;
									$data['qtty']= $qttyy;



						foreach ($data['Stockdetails']->result() as $value) {
							$sum+= $value->purchaserate*$value->currentstock;
							$sums+= $value->mrp*$value->currentstock;
							$qttyy+= $value->currentstock;


						}

						$data['branchid']=$branchh;




						if($this->session->userdata('role')=="Branch User")
						{

							$this->load->view('header_2');
						}
						else{
							$this->load->view('header');

						}
						$this->load->view('StockReport',$data);
						$this->load->view('footer');
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



			public function direct_stock_report()
			{
				$branchid = $this->session->userdata('branch');
				$branchh=$branchid;

				$data=array();
				$branch=$this->input->get_post('branch');

				$Searchoption=$this->input->get_post('searchoption');
				$data['branch']=$this->Onlinemodel->getBranch();

				if ($branch!=null) {

					$data['Stockdetails']=$this->Onlinemodel->LoadAllstock_branch_only2($branch);

				}else{
					$data['Stockdetails']=$this->Onlinemodel->LoadAllstock2();
				}

				$data['branchid']=$branchh;
				$this->load->view('header');
				$this->load->view('DirectStockReport',$data);
				$this->load->view('footer');
			}

			

			//StockReport_End

			public function loadvoucher()
    {
		$a=$this->input->get_post('voucherno');
		
      	$data=array();
      	// echo current_url();
      	$data['master']=$this->Onlinemodel->getjoumaster($a);
		$data['detailes']=$this->Onlinemodel->getjoudetailes($a);
		
		echo json_encode($data);
	}

			public function journelvoucher()
			{
				$loadinvno=$this->input->get_post('a');
				if($loadinvno==null)
				{
					$loadinvno=0;
				}
				if( $this->session->userdata('name'))
				{
					$branchid = $this->session->userdata('branch');
					$data=array();
					if($this->session->userdata('role')=="Super Admin")
					{
						$data['accountledger']=$this->Onlinemodel->getaccountledger();
						$data['voucherno']=$this->Onlinemodel->Autogenerate_Journal_VoucherNo();
						$data['loadinvno']=$loadinvno;
						$this->load->view('header');
						$this->load->view('JournalVoucher',$data);
						$this->load->view('footer');
					}
					else if($this->session->userdata('role')=="Admin")
					{
						$data['accountledger']=$this->Onlinemodel->getaccountledgerbranch($branchid);
						$data['voucherno']=$this->Onlinemodel->Autogenerate_Journal_VoucherNo();
						$data['loadinvno']=$loadinvno;
						$this->load->view('header');
						$this->load->view('JournalVoucher',$data);
						$this->load->view('footer');
					}
					else if($this->session->userdata('role')=="Branch User")
					{
						?>
						<script type="text/javascript">
						alert("Access Denied...!");
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

	public function insert_journalmaster()
	{
		$data=array();
		$data['voucherno']=$this->input->get_post('voucherno');
		$data['journaldate']=$this->input->get_post('date');
		$data['totalamount']=$this->input->get_post('totalamount');
		$data['narration']=$this->input->get_post('narration');
		$data['userid']=$this->session->userdata('user');
		$value=$data['voucherno'];
		$existence=$this->Onlinemodel->checkexistence_journalvoucher($value);
		if($existence==0)
		{
			$result=$this->Onlinemodel->insert_journalmaster($data);
			if($result==true)
			{
				
			}
			else
			{
				?>
				<script type="text/javascript">
				alert('Insertion failed. please check the inputs');
				</script><?php
			}
		}
		else
		{
			?>
			<script type="text/javascript">
			alert('voucherno already exists!!!!.');
			</script><?php
		}
	}

	public function insert_journaldetails()
	{
		$data=array();
		$data['voucherno']=$this->input->get_post('voucherno');
		$data['ledgerid']=$this->input->get_post('ledgerid');
		$data['debit']=$this->input->get_post('debit');
		$data['credit']=$this->input->get_post('credit');
		$data['narration']=$this->input->get_post('narration');
		$ledgerid=$data['ledgerid'];
		$date=$this->input->get_post('date');
		$type =$this->input->get_post('type');
		$result=$this->Onlinemodel->insert_journaldetails($data);
		if ($result==true)
		{ 
			$sum =$data['debit']*1 - $data['credit']*1;
			$result2=0;
			// if($type==Cr)
			// {
			// $result2=$this->Onlinemodel->update_customerledgerbalance($ledgerid,$sum);
			//              }
			//          else{
			//               $result2=$this->Onlinemodel->update_customerledgerbalance($ledgerid,$sum*-1);
			//               }
			if($result)
			{
				$data2=array();
				$data2['invoiceno']=$data['voucherno'];
				$data2['accountType']='Journal Voucher_save';
				$data2['date']=$date;
				$data2['ledgername']= $data['ledgerid'];
				$data2['debit']= $data['debit'];
				$data2['credit']=$data['credit'];
				$data2['userid']=$this->session->userdata('user');
				$data2['opposite']=$ledgerid;
				$result3=$this->Onlinemodel->insert_newdaybook($data2);
			}
		}
		else
		{
			?><script type="text/javascript">
			alert('Insertion failed. please check the inputs');
			</script><?php
		}
	}

	
    //Stock transfer
    public function stocktransfer()
    {
		if( $this->session->userdata('name'))
		{
			$branchid = $this->session->userdata('branch');
			$data['voucherno']=$this->Onlinemodel->Autogenerate_StockVoucherNo();
			$data['product']=$this->Onlinemodel->getproduct();
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['branch']=$this->Onlinemodel->getBranch();
				$data['batch']=$this->Onlinemodel->getBatch();
				// $data['branchid']=$branchh;
				$this->load->view('header');
				$this->load->view('StockTransfer',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

    public function direct_stock_update()
    {
    	$d=strtotime("now");
    	$date=date("Y-m-d H:i:s",$d);

    	$data['direct_stock']=$this->Onlinemodel->getdirectStockregister();


    	foreach ($data['direct_stock']->result() as $key){

    		$size = $key->sizz;  
    		$branch = $key->branch;  
    		$productid = $key->productid;  
    		$qty = $key->qty;  


    		if ($size == 'NA') {
    			$sizee = 0;

    		}elseif ($size == 'l') {
    			$sizee = 6;
    		}elseif ($size == 56) {
    			$sizee = 11;
    		}else{
    			$sizee = $size;
    		}

    		// $stock11=$this->Onlinemodel->checkstock($sizee,$branch,$productid);
    		// $size12=$stock11['size'];


    		$stock=$this->Onlinemodel->updatestock_register($sizee,$branch,$productid,$qty);

    	}

    }

    public function direct_stock()
    {
    	$d=strtotime("now");
		$date=date("Y-m-d H:i:s",$d);
    	if( $this->session->userdata('name'))
    	{
    		if($this->session->userdata('role')=="Super Admin")
    		{
    			$voucherno='Direct_ulike';
    			$transactiontype='Direct Invoice';
    			$date=$date;
    			$userid=$this->session->userdata('user');
    			$data['direct_stock']=$this->Onlinemodel->getdirectStock();

    			foreach ($data['direct_stock']->result() as $key){

    				$code = $key->CODE;  

	    				if ($key->SIZE == null) {
	    					$size = 'NA';
	    				}else{
	    					$size = $key->SIZE;  
	    				}
    				$qty = $key->QTY; 

    				$branch = 30;
    				$batch =0;
    				$name = $key->CODE; 

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
	    					elseif ($size1 == '0') {

	    						$qnty = $key->QTY; 
	    					}
	    					else
	    					{
	    						$qnty=1;
	    					}
	    					$check=$this->Onlinemodel->checkproduct2($name,$size1,$branch,$batch);
	    					if($check>0)
	    					{
	    						$stock=$this->Onlinemodel->updatestock2($name,$size1,$qnty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
	    					}
	    					else
	    					{
	    						$stck=array();
	    						$stck['productid']=$name;
	    						$stck['size']=$size1;
	    						$stck['currentstock']=$qnty;
	    						$stck['branch']=$branch;
	    						$stck['batchid']=$batch;
	    						$stock1=$this->Onlinemodel->insertstock2($stck,$voucherno,$transactiontype,$date,$userid);
	    					}

	    					
	    				}
			    				// print_r($qnty);
			    				// die();

    			}

    		}

    		$this->index();

    	}
    	else 
    	{
    		?>
    		<script type="text/javascript">
    			alert("Access Denied...!");
    		</script>
    		<?php
    		$this->index();
    	}
    }


    public function auto_database_stock()
    {
    	$d=strtotime("now");
    	$date=date("Y-m-d H:i:s",$d);
    	if( $this->session->userdata('name'))
    	{
    		if($this->session->userdata('role')=="Super Admin")
    		{

    			$branch = 30;

    			$data['get_stockSize']=$this->Onlinemodel->get_stockSize($branch);

    			foreach ($data['get_stockSize']->result() as $key){

    				if ($key->size == $key->sizevalue) {

								$qnty = $key->currentstock; 
								$branch = 30;
								$batch =0;
								$name = $key->productid; 
								$size1 = $key->sizeid; 
								$stockid = $key->stockid; 
								
								$check=$this->Onlinemodel->checkproduct2($name,$size1,$branch,$batch);
								if($check>0)
								{
									$stock=$this->Onlinemodel->updatestock_db($name,$size1,$qnty,$branch,$batch);
									$this->Onlinemodel->did_update_row($stockid);
									
								}
								else
								{
									$stck=array();
									$stck['productid']=$name;
									$stck['size']=$size1;
									$stck['currentstock']=$qnty;
									$stck['branch']=$branch;
									$stck['batchid']=$batch;
									$stock1=$this->Onlinemodel->insertstock_db($stck);

									$this->Onlinemodel->did_update_row($stockid);
								} 


    				}else{


    				}


    			}

    		}

    		$this->index();

    	}
    	else 
    	{
    		?>
    		<script type="text/javascript">
    			alert("Access Denied...!");
    		</script>
    		<?php
    		$this->index();
    	}
    }
 

	public function update()
	{
 if( $this->session->userdata('name'))
    	 {
		$data['stock']=$this->Onlinemodel->getstocktransfer();
		$this->load->view('header');
		$this->load->view('update',$data);
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
	


    public function physicalstock()
    {
		if($this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$this->load->view('header');
        		$this->load->view('PhysicalStock');
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

    public function pur_order()
    {
    	 	 if( $this->session->userdata('name'))
    	 {
        $this->load->view('header');
        $this->load->view('purchaseorder');
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
	

	public function purorder()
    {
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$this->load->view('header');
				$this->load->view('purchaseorder');
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
	
	public function getbranchbyid()
    {
        $branchid = $this->input->get_post('branchid');
        $this->load->model('Onlinemodel');
		$ans=$this->Onlinemodel->api_getbranchbyid($branchid);
        echo json_encode($ans); 
	}
	
	public function salescost()
    {   $fromdate=$this->input->get_post('fromdate');
		if($fromdate==null){
            $fromdate=date('Y-m-01');
		}
		
		$todate=$this->input->get_post('todate');
		if($todate==null){
			 $todate=date('Y-m-t');
		}
		if( $this->session->userdata('name'))
		{
			$this->load->model('Onlinemodel');
			$branchid = $this->session->userdata('branch');
			$branchh=$branchid;
			$data=array();
			$userid=$this->session->userdata('user');
			$data['users']=$this->Onlinemodel->getuserid($userid);
			if($this->session->userdata('role')=="Super Admin")
			{
				$data['branch']=$this->Onlinemodel->getBranch();
			}
			else
			{
				$data['branch']=$this->Onlinemodel->getUserBranch($branchid);
			}
			$data['branchid']=$branchh;
			$data['fromdate'] =  $fromdate;
			$data['todate'] =  $todate;
			
			if($this->session->userdata('role')=="Branch User")
			{
				$this->load->view('header_2');
			}
			else{
				$this->load->view('header');

			}
			$this->load->view('salescost',$data);
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

	public function getsalescost()
    {
		$data=array();
		$branch = $this->input->get_post('branch');
		$fdate = $this->input->get_post('fdate');
		$tdate = $this->input->get_post('tdate');
		$todate=date_add(date_create($tdate),date_interval_create_from_date_string("1 days"));
		$todate=date_format($todate,"Y-m-d");
		$data=$this->Onlinemodel->getcostofsales($fdate,$todate,$branch);
		echo json_encode($data);
	}

	public function upd_salescost()
    {     
		$branchid=$this->input->get_post('branch');
		$cost=$this->input->get_post('cost');
		$paiddate=$this->input->get_post('currentdate');
		$paidamount=$this->input->get_post('payment');
		$saledate=$this->input->get_post('saledate');
		$data=array();
		$data['branchid']= $branchid;
		$data['paiddate']=$paiddate;
		$data['salesdate']=$saledate;
		$data['costtopay']=$cost;
		$data['paidamount']=$paidamount;
		$data['balance']=$this->input->get_post('balance');
		$data['userid']=0;
		// $data=array();
		$dat1['records']=$this->Onlinemodel->getsupplierbybranch($branchid);
		$data['supplierid']=$dat1['records']['supplierid'];
		$supaccnt=$dat1['records']['supplieraccount'];
		$dat2['records']=$this->Onlinemodel->getbankbybranch($branchid);
		$bankledger=$dat2['records']['ledgerid'];
		$data['bankaccount']=$bankledger;log_message('error',$bankledger);
		$result=$this->Onlinemodel->insertcostpayment($data);
		if($result)
		{
			$ans=$this->Onlinemodel->costaccount($paidamount,$bankledger,$supaccnt);
			$data2=array();	
			//bank account
			$data2['invoiceno']=$result;
			$data2['accountType']='Cost Payment';
			$data2['date']=$saledate;
            $data2['userid']=$this->session->userdata('user');
			$data2['ledgername']=$bankledger;
			$data2['debit']=0;
			$data2['credit']=$paidamount;
            $data2['opposite']=$supaccnt;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
        	//supplier accnt
			$data2['ledgername']=$supaccnt;
			$data2['debit']=$paidamount;
			$data2['credit']=0;
            $data2['opposite']=$bankledger;
			$data22=$this->Onlinemodel->insert_newdaybook($data2);
		}
		else
		{
			?>
			<script>alert("Please Try Again");</script>
			<?php
		}
		echo json_encode($result);

	}

    public function salesorder()
    {
		if( $this->session->userdata('name'))
		{
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('SalesOrder');
			$this->load->view('footer');
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}
   
	public function salesreturn()
	{
		if( $this->session->userdata('name'))
    	{ 
			$branchid = $this->session->userdata('branch');
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
			$data['batch']=$this->Onlinemodel->getbatch();
			$data['size']=$this->Onlinemodel->getsize();
			$data['returnno']=$this->Onlinemodel->Autogenerate_ReturnNo($branchid);
			$data['customer']=$this->Onlinemodel->getcustomer();
			$data['salesman']=$this->Onlinemodel->getsalesman();
			$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
			$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
			$data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
			$this->load->view('SalesReturns',$data);
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
	
	
	public function acc_group()
	{
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['accountgroup']=$this->Onlinemodel->getaccountgroup();
				$data['FiilTableAccountgroup']=$this->Onlinemodel->FiilTableAccountgroup();
				$data['branch']=$this->Onlinemodel->getBranch();
				$this->load->view('header');
				$this->load->view('AccountGroup',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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
	

	public function insert_accountgroup()
	{   
		$action=$this->input->get_post('btnsave');
	
         if($action=="Save"){
         	 $data=array();

		       $data['accountgroup']=$this->input->get_post('accountgroup');
		       $data['under']=$this->input->get_post('under');
		       $data['rootid']=$this->input->get_post('root');
		       $data['narration']=$this->input->get_post('narration');
               $value=$data['accountgroup'];

                       $existence=$this->Onlinemodel->checkexistence_accountgroup($value);
	                          if($existence==0)
	                          {
	                         	$result=$this->Onlinemodel->insert_accountgroup($data);
	                         	if ($result==true) {
                           	                           ?> <script type="text/javascript">
	alert('Account group saved successfully');
</script>
<?php 
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('Account group already exists!!!!. please use another name');
</script> <?php 
                           }
         }
         elseif($action=="Update"){

		 $data=array();
		 $data['accountgroup']=$this->input->get_post('accountgroup');
		 $data['under']=$this->input->get_post('under');
		       $data['rootid']=$this->input->get_post('root');
		 $data['narration']=$this->input->get_post('narration');
		 $id=$this->input->get_post('accountgroupid');
		 
        $update =$this->Onlinemodel->update_accountgroup($id,$data);
          if ($update==true) {
                           	                           ?> <script type="text/javascript">
	alert('Updated Successfully');
</script>
<?php 
                                                   } 
                                                   else {
                           	                         ?> <script type="text/javascript">
	alert('Updation failed. please check the inputs');
</script> <?php 
                                                   }


                                       }
		
                                        else
         {
         	echo $action;
         }
                 
         
          $data['accountgroup']=$this->Onlinemodel->getaccountgroup();
          $data['FiilTableAccountgroup']=$this->Onlinemodel->FiilTableAccountgroup();

                                                        $this->load->view('header');
	                                                	$this->load->view('AccountGroup',$data);
		                                                $this->load->view('footer');
                      

                           	                          
         }
        

		       
	

	public function delete_accountgroup()
	{
                          $id=$this->input->get_post('accountgroupid');
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_accountgroup($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('Account group deleted successfully');
</script> <?php 
                        }
                      
                           	                            $data['accountgroup']=$this->Onlinemodel->getaccountgroup();
                           	                            $data['FiilTableAccountgroup']=$this->Onlinemodel->FiilTableAccountgroup();

                                                        $this->load->view('header');
	                                                	$this->load->view('AccountGroup',$data);
		                                                $this->load->view('footer');
                      
                           

	}


	//ACCOUNT LEDGER_START
	public function acc_ledger()
	{
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['accountledger']=$this->Onlinemodel->getaccountledger();
				$data['accountgroup']=$this->Onlinemodel->getaccountgroup();
				$data['branch']=$this->Onlinemodel->getBranch();
				$data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();
				$this->load->view('header');
				$this->load->view('AccountLedger',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
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

	public function insert_accountledger()
	{   
		$action=$this->input->get_post('btnsave');
	
         if($action=="Save"){
         	 $data=array();

		       $data['ledgername']=$this->input->get_post('ledgername');
			   $data['accountgroup']=$this->input->get_post('accountgroup');
			   $getrootid = $data['accountgroup'];
			   $result = $this->Onlinemodel->getrootid($getrootid);
			   $data['rootid'] =$result;
			   $data['interestcalculation']=$this->input->get_post('interestcalculation');
			   $data['openingbalance']=$this->input->get_post('openingbalance');
		       $data['branchid']=$this->input->get_post('branch');
		       $data['creditordebit']=$this->input->get_post('creditordebit');
		       $data['narration']=$this->input->get_post('narration');
		       $data['currentbalance']=$this->input->get_post('openingbalance');
               $value=$data['ledgername'];

                       $existence=$this->Onlinemodel->checkexistence_accountledger($value);
	                          if($existence==0)
	                          {
	                         	$result=$this->Onlinemodel->insert_accountledger($data);
	                         	if ($result==true) {
                           	                           ?> <script type="text/javascript">
	alert('Account Ledger saved successfully');
</script>
<?php 
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('Account Ledger already exists!!!!. please use another name');
</script> <?php 
                           }
         }
         elseif($action=="Update"){

		$data=array();

		       $data['ledgername']=$this->input->get_post('ledgername');
		       $data['accountgroup']=$this->input->get_post('accountgroup');
			   $data['interestcalculation']=$this->input->get_post('interestcalculation');
			   $branchid=$this->input->get_post('branch');
			   $data['branchid']=$branchid;
		       $data['openingbalance']=$this->input->get_post('openingbalance');
		       $data['creditordebit']=$this->input->get_post('creditordebit');
		       $data['narration']=$this->input->get_post('narration');
		       $data['currentbalance']=$this->input->get_post('openingbalance');
		 $id=$this->input->get_post('ledgerid');
		 
        $update =$this->Onlinemodel->api_update_accountledger($id,$data);
          if ($update==true) {
                           	                           ?> <script type="text/javascript">
	alert('Updated Successfully');
</script>
<?php 
                                                   } 
                                                   else {
                           	                         ?> <script type="text/javascript">
	alert('Updation failed. please check the inputs');
</script> <?php 
                                                   }


                                       }
		
                                        else
         {
         	echo $action;
         }
                 
        // $data['accountledger']=$this->Onlinemodel->getaccountledger();
        // $data['accountgroup']=$this->Onlinemodel->getaccountgroup();
		// $data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();


        //                                                 $this->load->view('header');
	    //                                             	$this->load->view('AccountLedger',$data);
		//                                                 $this->load->view('footer');
                      
			$this->acc_ledger();
                           	                          
		 }
		 public function delete_accountledger()
	{
                          $id=$this->input->get_post('ledgerid');
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_accountledger($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('Account ledger deleted successfully');
</script> <?php 
                        }
                      
						$data=array();
						$data['accountledger']=$this->Onlinemodel->getaccountledger();
						$data['accountgroup']=$this->Onlinemodel->getaccountgroup();
						$data['branch']=$this->Onlinemodel->getBranch();
						$data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();
				
                                                        $this->load->view('header');
	                                                	$this->load->view('AccountLedger',$data);
		                                                $this->load->view('footer');
                      
                           

	}

	public function aa()
	{
		
		$this->load->view('aa');

	}
public function search()
{
    
    $term = $this->input->get('query');
    $getDetail = $this->Onlinemodel->getSearch($term);
    $data = array();
     $output = '<ul class="list-unstyled">';  
    foreach ($getDetail->result() as $value) {
              $output .= '<li>'.$value->pdt_name.'</li>';  
    }
    $output .= '</ul>';
    echo json_encode($output);
}

public function editpur()
{
	$fromdate=$this->input->get_post('fromdate');
	$todate=$this->input->get_post('todate');
	if( $this->session->userdata('name'))
	{
		if($this->session->userdata('role')=="Super Admin")
		{
			$data=array();
			$data['voch']=$this->Onlinemodel->getvoucherbydate($fromdate,$todate);
			$this->load->view('header');
			$this->load->view('editpurchase',$data);
			$this->load->view('footer');
		}
		else if($this->session->userdata('role')=="Branch User")
		{
			?>
			<script type="text/javascript">
			alert("Access Denied...!");
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


public function viewpur()
{    $loadinvno=$this->input->get_post('a');
	if($loadinvno==null){
		$loadinvno=0;
	}

	if( $this->session->userdata('name'))
    	 {
	$data=array();

	$data['product']=$this->Onlinemodel->getproduct();
    $data['unit']=$this->Onlinemodel->getunit();
    $data['supplier']=$this->Onlinemodel->getsupplier();
    // $data['voucherno']=$this->Onlinemodel->Autogenerate_VoucherNo();
    $data['batch']=$this->Onlinemodel->getbatch();
    $data['brand']=$this->Onlinemodel->getbrand();
    $data['group']=$this->Onlinemodel->get_productgroup();
    $data['size']=$this->Onlinemodel->getsize();
	$data['branch']=$this->Onlinemodel->getBranch();
	$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
	$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
	$vouch=$this->input->get_post('voucher');
	$data['loadinvno']=$vouch;
	$data['master']=$this->Onlinemodel->get_purmaster($vouch);
	$data['detailes']=$this->Onlinemodel->get_purdetailes($vouch);
	$this->load->view('header');
	$this->load->view('updpurchase',$data);
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

public function salesestimate()
	{
		if( $this->session->userdata('name'))
    	{
			$data=array();
			$data['product']=$this->Onlinemodel->getproduct();
			$data['branch']=$this->Onlinemodel->getBranch();
			$data['batch']=$this->Onlinemodel->getbatch();
			$data['salesman']=$this->Onlinemodel->getsalesman();
			$data['invoiceno']=$this->Salesmodel->Autogenerate_InvoiceNo();
			$data['customer']=$this->Onlinemodel->getcustomer();
			$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
			$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
			$data['master']=$this->Onlinemodel->getsalesmaster();
			$this->load->view('header');
			$this->load->view('Salesestimate',$data);
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

	public function Autofill()
	{
		$this->load->model('Onlinemodel');
        $code  = $this->input->post('b');
        $data=$this->Onlinemodel->Autofill_Productdetails_TEST($code);
        echo json_encode($data);
	}

	public function Autofill1()
	{
		//$a=$this->input->get_post('a');
   		//$data = array(
   		//'pdt_name'  => $this->input->post('a'), 
   		//'pdt_code'  => $this->input->post('b'), 
   		//'groupid' => $this->input->post('c'), 
   		//'unitid' => $this->input->post('d'), 
   		//'brandid' => $this->input->post('e'), 
   		//'tax' => $this->input->post('f'), 
   		//'mrp' => $this->input->post('g'), 
		//'openingstock' => $this->input->post('h'),
		// 'product_price' => $this->input->post('price'), 
   		//);
		$code  = $this->input->get_post('b');
		echo $code;
        $data=$this->Onlinemodel->Autofill_Productdetails_TEST($code);
        echo json_encode($data);
	}

	public function getValFromDb()
    {
		$state = $this->input->post('selection');
        $query1 = $this->Onlinemodel->test($state);
        echo json_encode(array('data'=>$query1));	
	}
	
	//Customer_Start

	public function customer(){
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['customer']=$this->Onlinemodel->getcustomer();
				$this->load->view('header');
				$this->load->view('customer',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}		
		}
		else
		{
			?> <script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}

	public function insert_customer()
	{
		$action=$this->input->get_post('btnsave');
		$data=array();
		$data['customername']=$this->input->get_post('customername');
		$data['customercode']=$this->input->get_post('phonenumber');
		$data['address']=$this->input->get_post('address');
		$data['email']=$this->input->get_post('email');
		$data['phonenumber']=$this->input->get_post('phonenumber');
		$data['website']=$this->input->get_post('website');
		$data['state']=$this->input->get_post('state');
		$data['country']=$this->input->get_post('country');
		$data['vatno']=$this->input->get_post('vatno');
		$data['crlimit']=$this->input->get_post('limit');
		$data['openingbalance']=$this->input->get_post('openingbalance');
		$data['customerbalance']=$this->input->get_post('openingbalance');
		$data['branchid']='1';
		if($action=="Save")
		{
			$code=$data['phonenumber'];
			$pho=$data['phonenumber'];
			$existence=$this->Onlinemodel->checkexistence_customer($code,$pho);
			if($existence==0)
			{
				//Ledger Insertion_start
				$data2=array();
				$data2['ledgername']=$pho;
				$data2['accountgroup']='17';
				$data2['interestcalculation']=0;
				$data2['openingbalance']=$this->input->get_post('openingbalance');
				$data2['creditordebit']='Dr';
				$data2['rootid']='1';
				$data2['narration']='Autogenerated for Customer';
				$data2['currentbalance']=$this->input->get_post('openingbalance');
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
		else if($action=="Update")
		{
			// echo $this->input->get_post('customerid');
			// echo $this->input->get_post('phonenumber');
			$data2=array();
			$data2['ledgername']=$data['phonenumber'];
			$data2['openingbalance']=$this->input->get_post('openingbalance');
			$id=$this->input->get_post('customerid');
			$value2=$data2['ledgername'];
			$data3=array();
			$data3=$this->Onlinemodel->Select_customerledger($id);
			$ledgerid=$data3['customeraccount'];
			$result=$this->Onlinemodel->api_update_accountledger($ledgerid,$data2);
			// print_r($result);
			if($result=true)
			{
				$id=$this->input->get_post('customerid');
				$update=$this->Onlinemodel->update_customer($data,$id);
				// print_r($update);
				if ($update=true)
				{
					// echo $update;
					?> <script type="text/javascript">
					alert('Updated Successfully...');
					</script>
					<?php
				}
				else
				{
					?> <script type="text/javascript">
					alert('Updation failed. please check the inputs!!!');
					</script> <?php
				}	
				  // }
			}
		}
		else
		{
			echo $action;
		}
		$data['customer']=$this->Onlinemodel->getcustomer();
		$this->load->view('header');
		$this->load->view('customer',$data);
		$this->load->view('footer');
	}

	public function delete_customer()
	{
		$id=$this->input->get_post('customerid');
		$pho=$this->input->get_post('phonenumber');
		$this->load->model('Onlinemodel');
		$delete=$this->Onlinemodel->delete_customer($id);
		if(!$delete)
		{
			?><script type="text/javascript">
			alert('deletion failed!!!!');
			</script><?php
		}
		else
		{
			$result=$this->Onlinemodel->delete_ledgercustomer($pho);
			if($result==true)
			{
				?> <script type="text/javascript">
				alert('Deleted Successfully.....');
				</script> <?php
			}
			else
			{
				?><script type="text/javascript">
				alert('deletion failed!!!!');
			</script><?php

			}
		}
		$this->customer();
	}
	//Customer_End
	
	
	//SalesReport_Start
	public function salesreport()
	{
		if( $this->session->userdata('name'))
		{
			$data=array();
			$branchid = $this->session->userdata('branch');


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
			$data['fromdate'] =  $fromdate;
			$data['todate'] =  $todate;



			$SearchBy=$this->input->get_post('searchby');
			$supplier=$this->input->get_post('supplier');
			$productname=$this->input->get_post('productname');
			$brand=$this->input->get_post('brandname');
			$data['productname']=$this->Onlinemodel->FillProduct();
			$data['brand']=$this->Onlinemodel->getbrand();
			$finyear = $this->session->userdata('finyear');

			// echo $productname;
			// echo $supplier;
			if($this->session->userdata('role')=="Super Admin")
			{
				if($SearchBy=="Supplier-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_Supplierwise($fromdate,$todate,$supplier,$finyear);
				}
				else if($SearchBy=="Product-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->LoadSalesdetails_ProductNamewise($fromdate,$todate,$productname,$finyear);
				}
				else if($SearchBy=="Brand-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_Brandwise($fromdate,$todate,$brand,$finyear);
				}
				else
				{
					$data['SalesDetails']=$this->Onlinemodel->LoadSalesDetails_All($fromdate,$todate,$finyear);
				}
				$data['supplier']=$this->Onlinemodel->getsupplier();
				if($this->session->userdata('role')=="Branch User")
				{
					$this->load->view('header_2');
				}
				else{
					$this->load->view('header');

				}
				$this->load->view('salesreport',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Admin")
			{
				if($SearchBy=="Supplier-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_SupplierwiseBranch($fromdate,$todate,$supplier,$branchid,$finyear);
				}
				else if($SearchBy=="Product-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->LoadSalesdetails_ProductNamewiseBranch($fromdate,$todate,$productname,$branchid,$finyear);
				}
				else if($SearchBy=="Brand-wise")
				{
					$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_BrandwiseBranch($fromdate,$todate,$brand,$branchid,$finyear);
				}
				else
				{
					$data['SalesDetails']=$this->Onlinemodel->LoadSalesDetails_AllBranch($fromdate,$todate,$branchid,$finyear);
				}
				$data['supplier']=$this->Onlinemodel->getsupplierbranch($branchid);

				if($this->session->userdata('role')=="Branch User")
				{
					$this->load->view('header_2');
				}
				else{
					$this->load->view('header');

				}
				$this->load->view('salesreport',$data);
				$this->load->view('footer');
			}
			else if ($this->session->userdata('role')=="Branch User") {


				$data['SalesDetails']=$this->Onlinemodel->LoadSalesDetails_AllBranch($fromdate,$todate,$branchid,$finyear);

				$data['supplier']=$this->Onlinemodel->getsupplierbranch($branchid);


				$this->load->view('header_2');
				$this->load->view('salesreport',$data);
				$this->load->view('footer');

			}
			else
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script>
			<?php
			$this->index();
		}
	}
	
	//SalesReport_End

	//SalesReturnReport_Start
	public function salesrtnreport()
	{
		if( $this->session->userdata('name'))
		{
			$data=array();
			$branchid = $this->session->userdata('branch');
			$fromdate=$this->input->get_post('fromdate');
			$todate=$this->input->get_post('todate');
			$branch=$this->input->get_post('branchname');
			$data['branch']=$this->Onlinemodel->getBranch();


			if($this->session->userdata('role')=="Super Admin")
			{

				$data['SalesDetails']=$this->Onlinemodel->LoadSalesReturnDetails_All($fromdate,$todate,$branch);

				$this->load->view('header');
				$this->load->view('salesrtnreport',$data);
				$this->load->view('footer');
			}
			else
			{
				?><script type="text/javascript">
					alert("please login again");
				</script>
				<?php
				$this->index();
			}
	}
	}
	
	//SalesReturnReport_End

		public function salesrtnreport_ogi()
	{
		if( $this->session->userdata('name'))
		{
			$data=array();
			$branchid = $this->session->userdata('branch');
			$fromdate=$this->input->get_post('fromdate');
			$todate=$this->input->get_post('todate');
			$branch=$this->input->get_post('branchname');
			$data['branch']=$this->Onlinemodel->getBranch();

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
			$data['fromdate'] =  $fromdate;
			$data['todate'] =  $todate;


			if($this->session->userdata('role')=="Super Admin")
			{

				$data['SalesDetails']=$this->Onlinemodel->LoadSalesReturnMaster_All($fromdate,$todate,$branch);

				$this->load->view('header');
				$this->load->view('salesrtnreport2',$data);
				$this->load->view('footer');
			}elseif($this->session->userdata('role')=="Branch User")
			{

				$data['SalesDetails']=$this->Onlinemodel->LoadSalesReturnMaster_All($fromdate,$todate,$branchid);
				$data['branch']=$this->Onlinemodel->getUserBranch($branchid);


				$this->load->view('header_2');
				$this->load->view('salesrtnreport2',$data);
				$this->load->view('footer');
			}
			else
			{
				?><script type="text/javascript">
					alert("please login again");
				</script>
				<?php
				$this->index();
			}
	}
	}

	//ReceiptVoucher_start

	public function receiptvoucher()
    {
		$loadinvno=$this->input->get_post('a');
		if($loadinvno==null)
		{
			$loadinvno=0;
		}
		if( $this->session->userdata('name'))
		{
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$data['loadinvno']=$loadinvno;
				$data["voucherno"]=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();
				$data['ledger']=$this->Onlinemodel->all_accountledger();
				$data['getreceiptvoucher']=$this->Onlinemodel->getreceiptvoucher();
				$data['BankAndCashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
				$this->load->view('header');
				$this->load->view('ReceiptVoucher',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				?>
				<script type="text/javascript">
				alert("Access Denied...!");
				</script>
				<?php
				$this->index();
			}
		}
		else
		{
			?><script type="text/javascript">
			alert("please login again");
			</script><?php
			$this->index();
		}
	}	
	
	public function getreceiptvoucherbyvoucherno()
    {
		$voucherno=$this->input->post('voucherno');
		$data=$this->Onlinemodel->getreceiptvoucherbyvoucherno($voucherno);
		echo json_encode($data);
	}
	

	public function insert_receiptvoucher()
	{
		
  $data=array();
  $data['voucherno']=$this->input->post('voucherno');
  $data['ledger']=$this->input->post('ledger');
			  $ledgername= $data['ledger'];
			  
			  $data1['records']=$this->Onlinemodel->Select_ledger($ledgername);
			  $rootid=$data1['records']['rootid'];
			  if($rootid==1 || $rootid==4)
			  {
				  $data['currentbalance']=$this->input->get_post('balance')-$this->input->get_post('amount');
			  }
			else{
				  $data['currentbalance']=$this->input->get_post('balance')+$this->input->get_post('amount');
				  }
  $data['amount']=$this->input->post('amount');
  $amount=$data['amount'];
  $data['receiptdate']=$this->input->post('receiptdate');
  $data['cashorbank']=$this->input->post('cashorbank');
  $data['narration']=$this->input->post('narration');
  $data['branchid']='1';
  $data['userid']=$this->session->userdata('user');
  
	  $value=$data['voucherno'];
	  $existence=$this->Onlinemodel->checkexistence_receiptvoucherno($value);
	  if($existence==0)
	  {
		  $result=$this->Onlinemodel->insert_ReceiptVoucher($data);
		  if($result==true)
		  {
			 
			  $cashorbank= $data['cashorbank'];
			  
			 
			  $cashorbank=$data['cashorbank'];
			  $data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
			  $data2=array();
			  $data2['invoiceno']=$data['voucherno'];
			  $data2['accountType']='Receipt Voucher';
			  $data2['date']=$this->input->post('receiptdate');
			  $data2['ledgername']=$ledgername;
			  $data2['userid']=$this->session->userdata('user');
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
  
	  echo json_encode($existence);
	}
	
	public function delete_receiptvoucher()
	{
		$id=$this->input->post('voucherno');
  $this->load->model('Onlinemodel');
  $delete=$this->Onlinemodel->delete_receiptvoucher($id);
  if($delete)
  {
	  $data=array();
	  $cashorbank=$this->input->post('cashorbank');
	  $ledgername= $this->input->post('ledger');
	  $amount=$this->input->post('amount');
	  $data['records']=$this->Onlinemodel->Select_ledger($ledgername);
	  $rootid=$data['records']['rootid'];
	  // if($rootid==1 || $rootid==4)
	  // {
	  // 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount*-1);
	  // }
	  // else
	  // {
	  // 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
	  // }
	  // $result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
	  if($result2==false)
	  {
		  ?><script type="text/javascript">
		  alert('Failed updation in ledgerbalance........');
		  </script>
		  <?php # code...
	  }
	  	$d=strtotime($this->input->get_post('receiptdate')); 
	  	$duration=60;
	  	$e=$d+$duration;

	  $cashorbank=$this->input->post('cashorbank');
	  $data2=array();
	  $data2['invoiceno']=$this->input->post('voucherno');
	  $data2['accountType']='Receipt Voucher_Delete';
	  $data2['date']=date('Y-m-d H:i:s',$e);
	  $data2['ledgername']=$ledgername; 	
	  $data2['debit']=($this->input->post('amount'));
	  $data2['credit']=0;
	  $data2['opposite']=$cashorbank;

	  $result3=$this->Onlinemodel->insert_newdaybook($data2);
	  $data2['ledgername']=$cashorbank;    		 	
	  $data2['debit']=0;
	  $data2['credit']=($this->input->post('amount'));;
	  $data2['opposite']=$ledgername;
	  $result3=$this->Onlinemodel->insert_newdaybook($data2);
	  if($result3==false)
	  {
		  ?><script type="text/javascript">
		  alert('Failed Daybook insertion........');
		  </script><?php
	  }
	  ?> <script type="text/javascript">
	  alert('Deleted Successfully...');
	  </script><?php
  }
  else
  {
	  ?><script type="text/javascript">
	  alert('Deletion failed!!!Please check the inputs.');
	  </script><?php
  }
}
		  

		public function salesman()
		{
			if($this->session->userdata('name'))
			{
				if($this->session->userdata('role')=="Super Admin")
				{
					$data['salesman']=$this->Onlinemodel->getsalesman();
					$data['branch']=$this->Onlinemodel->getBranch();
					$this->load->view('header');
					$this->load->view('Salesman',$data);
					$this->load->view('footer');
				}
				else if($this->session->userdata('role')=="Branch User")
				{
					?>
					<script type="text/javascript">
					alert("Access Denied...!");
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

		public function insert_salesman()
          {
          	$action=$this->input->get_post('btnsave');
	
	         
	         	 $data=array();

			       $data['salesmanname']=$this->input->get_post('fullname');
			       $data['salesmancode']=$this->input->get_post('salescode');
			       $data['address']=$this->input->get_post('address');
			       $data['branchid']=$this->input->get_post('branch');
			       $data['phoneno']=$this->input->get_post('phonenumber');
			       $data['incentive']=$this->input->get_post('incentive');

			    if($action=="Save")
			    {   
				   $value1=$data['salesmancode'];
				   $value2=$data['phoneno'];
				   $existence=$this->Onlinemodel->checkexistence_salesman($value1,$value2);
		           if($existence==0)
		           {
					   $result=$this->Onlinemodel->insert_salesman($data);
					   if ($result==true)
					   {
						   ?> <script type="text/javascript">
						   alert('Saved successfully........');
						   </script>
						   <?php 
					   }
					   else
					   {
						   ?> <script type="text/javascript">
						   alert('Insertion failed. please check the inputs!!!');
						   </script> <?php 
	                   }
		            }
					else
					{
						?>
						<script type="text/javascript">
						alert('Salesman already exists!!!. ');
						</script> <?php 
	                }
		        }
		         elseif($action=="Update")
		         {
					 $id=$this->input->get_post('salesmanid');
				 	 $update =$this->Onlinemodel->update_salesman($data,$id);
				     if ($update==true) 
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
		        }
		        else
		        {
					?><script type="text/javascript">
					alert('Updation Successfull.');
					</script><?php 
		        }
		                 
		    $data['salesman']=$this->Onlinemodel->getsalesman();
			$data['branch']=$this->Onlinemodel->getBranch();
			$this->load->view('header');
			$this->load->view('Salesman',$data);
			$this->load->view('footer');
          }

        public function delete_salesman()
          {
          	$id=$this->input->get_post('salesmanid');
          	$this->load->model('Onlinemodel');
          	$delete=$this->Onlinemodel->delete_salesman($id);
          	if($delete)
          	{
				  ?>
				  <script type="text/javascript">
				  alert('Deleted Successfully...');
				  </script>
				  <?php
          	}
          	else
          	{
				  ?>
				  <script type="text/javascript">
				  alert('Deletion failed!!!Please check the inputs.');
				  </script>
				  <?php
          	}

			$data['salesman']=$this->Onlinemodel->getsalesman();
			$data['branch']=$this->Onlinemodel->getBranch();
			$this->load->view('header');
			$this->load->view('Salesman',$data);
			$this->load->view('footer');
          }



        public function Autofill_customerbalance()
		{
			$this->load->model('Onlinemodel');
	        $ledgername  = $this->input->post('b');
	        $data=$this->Onlinemodel->Autofill_customerbalance($ledgername);
	        echo json_encode($data);
		}

    //ReceiptVoucher_End
	//PurchaseInvoice_DyaBook_Insertion_End

	public function Autofill_Productdetails_byName()
	{  
		$this->load->model('Onlinemodel');
        $name= $this->input->post('b');
        $data=$this->Onlinemodel->Autofill_Productdetails_byName($name);
        echo json_encode($data);
	}
	
	
	public function upd_shporder()
	{
		$data=array(
	'stck_amnt'=>$this->input->post('stckamt'),
	'stitch'=>$this->input->post('stitch'),
	'dispatch'=>$this->input->post('dispatch'),
	'received'=>$this->input->post('received'),
	'delivery'=>$this->input->post('delivery')
	);
	$a=$this->input->post('shoporderno');
	$dat=$this->Onlinemodel->update_shprder($a,$data);
	echo json_encode($a);
	}
	public function upd_ecomfromproduction()
	{
		$data=array(
	
	'item_stitch'=>$this->input->post('stitch'),
	'item_dispatch'=>$this->input->post('dispatch'),
	'item_received'=>$this->input->post('received'),
	'item_delivery'=>$this->input->post('delivery'),
	'item_shipped'=>$this->input->post('shipped'),
	'status'=>$this->input->post('status'),

	);
	$a=$this->input->post('referenceno');
	$dat=$this->Onlinemodel->update_ecomfromproduction($a,$data);
	echo json_encode($a);
	}

	public function ShopOrder()
	{
		$data=array();
		$cdate = date('Y-m-d');
		$branchid = $this->session->userdata('branch');
		$userid=$this->session->userdata('user');
		$fdate = $this->input->get_post('fdate');
		$tdate= $this->input->get_post('tdate');
		if($this->session->userdata('role')=="Super Admin")
		{
			if( !empty($fdate) && !empty($tdate))
			{
				$data['shop']=$this->Onlinemodel->ltdshoporder($fdate,$tdate);
			}
			else
			{
				$data['shop']=$this->Onlinemodel->viewshoporder($cdate);
			}
		}
		else
		{
			if( !empty($fdate) && !empty($tdate))
			{
				$data['shop']=$this->Onlinemodel->ltdshoporderbranch($fdate,$tdate,$branchid);
			}
			else
			{
				$data['shop']=$this->Onlinemodel->viewshoporderbranch($cdate,$branchid);
			}
		}
		$data['users']=$this->Onlinemodel->getuserid($userid);
			if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
		$this->load->view('shoporder',$data);
		$this->load->view('footer');
	}

	public function getmrp()
	{  
		
		$this->load->model('Onlinemodel');
        $var= $this->input->post('b');
		$ans=$this->Onlinemodel->singleproduct($var);
        echo json_encode($ans); 
	}
	
	public function esalesinvoice()
	{
		if( $this->session->userdata('name'))
    	{ 
			$branchid = $this->session->userdata('branch');
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
			$data['batch']=$this->Onlinemodel->getbatch();
			$data['size']=$this->Onlinemodel->getsize();
			$data['invoiceno']=$this->Onlinemodel->Autogenerate_EInvoiceNo($branchid);
			$data['customer']=$this->Onlinemodel->getcustomer();
			$data['salesman']=$this->Onlinemodel->getsalesman1();
			$data['CashLedgers']=$this->Onlinemodel->FillCashLedgers();
			$data['BankLedgers']=$this->Onlinemodel->FillBankLedgers();
			// $data['master']=$this->Onlinemodel->getsalesmaster();
			$data['branchid']=$branchh;
			if ($this->session->userdata('role')=="Branch User"){
						
						$this->load->view('admin/header_2');
					}
					else{
						echo "qqqq"; die();
					$this->load->view('admin/header');

					}
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

	public function eCommerce()
	{
		if($this->session->userdata('name'))
		{
			$data=array();
			$cdate = date('Y-m-d');
			$data['eorder']=$this->Onlinemodel->geteorder($cdate);
			$fdate=$this->input->get_post('fdate');
			if($fdate==null)
			{
            	$fdate=date('Y-m-01');
			}
			$tdate=$this->input->get_post('tdate');
			if($tdate==null)
			{
				$tdate=date('Y-m-t');
			}
			if( !empty($fdate) && !empty($tdate))
			{
				$data['eorder']=$this->Onlinemodel->geteorder1($fdate,$tdate);
				$data['fdate'] =  $fdate;
				$data['tdate'] =  $tdate;
			}
			else
			{
				$data['eorder']=$this->Onlinemodel->geteorder($cdate);
			}
			$this->load->view('header');
			$this->load->view('ecommerce_order',$data);
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

	public function eorder()
    {
		$branchid = $this->session->userdata('branch');
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

		$data['order']=$this->Onlinemodel->getorder($a);
		$data['status']=$this->Onlinemodel->getstatus();
		// echo $a;

      	$this->load->view('header');
		$this->load->view('details',$data);
		$this->load->view('footer');
	}

	public function update_eorder()
          {
 
	     	 		$data=array();
		       		$data['amount']=$this->input->get_post('amount');
		       		$data['qty']=$this->input->get_post('qty');
		       		$data['description']=$this->input->get_post('descri');
		       		$data['status']=$this->input->get_post('status');

					 $id=$this->input->get_post('id');

	                     echo $id;
						 
				 	 $update =$this->Onlinemodel->update_eorder($data,$id);
				     if ($update==true) 
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

	
		  
		public function chat_room()
		{
			if( $this->session->userdata('name'))
			{
				if($this->session->userdata('role')=="Super Admin")
				{
					$this->load->model('Onlinemodel');
					$data['table']=$this->Onlinemodel->get_productgroup();
					$this->load->view('header');
					$this->load->view('chatroom',$data);
					$this->load->view('footer');
				}
				else if($this->session->userdata('role')=="Branch User")
				{
					?>
					<script type="text/javascript">
					alert("Access Denied...!");
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



	

	
	//PurchaseInvoice_DyaBook_Insertion_Start

	public function daybook()
	{
		if($this->session->userdata('name'))
		{
			$branchid = $this->session->userdata('branch');
			if($this->session->userdata('role')=="Super Admin")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['day']=$this->Onlinemodel->viewdaybook($cdate);
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				$data['fdate'] =$fdate;
				$data['tdate'] =$tdate;
				if( !empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->ltddaybook($fdate,$tdate);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybook($cdate);
				}
						if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('daybook',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Branch User")
			{
				$data=array();
				$cdate = date('Y-m-d');
				$data['day']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				$fdate = $this->input->get_post('fdate');
				$tdate= $this->input->get_post('tdate');
				$data['fdate'] =$fdate;
				$data['tdate'] =$tdate;
				if( !empty($fdate) && !empty($tdate))
				{
					$data['day']=$this->Onlinemodel->ltddaybookbranch($fdate,$tdate,$branchid);
				}
				else
				{
					$data['day']=$this->Onlinemodel->viewdaybookbranch($cdate,$branchid);
				}
					if($this->session->userdata('role')=="Branch User")
			{
			$this->load->view('header_2');
		}
		else{
			$this->load->view('header');

		}
				$this->load->view('daybook',$data);
				$this->load->view('footer');
			}
			else if($this->session->userdata('role')=="Admin")
			{
				?><script type="text/javascript">
				alert("Access Denied...!");
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
	
	public function test()
	{
		$this->load->library('encrypt');
		$a="o3NZhNfSWtDfWVNvQhuFsrt5p6WzXCXuRA/IeGhYb4oT5gMtPZ9OTHUoP4Aey5TQtyeFt8WiXT+tSIM8wKvLnQ==";
		$data = $this->encrypt->decode($a);
		echo $data;
	}

    public function demo()
    {
		$this->load->view('admin/header');
		$this->load->view('admin/adv');
		$this->load->view('admin/footer');
    }
    public function testt(){
    	log_message('error','here');
    	$table = $this->input->post('table');
    	 foreach($table as $k){
    	 	log_message('error','here');
        
       
                                }
    	 echo $k ;
    }
	
		 







}
     
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stockcontrol extends CI_Controller {

	public function __cunstruct()
	    {
		   parent::__cunstruct();
		   $this->load->helper(array('form', 'url'));
           $this->load->library('form_validation');
           $this->load->library('session'); 
           $this->load->helper('form');
		   $this->load->model('Stockmodel');
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
		
		public function insertstockmaster()
		{
			$data=array(
			'voucherno'=>$this->input->post('voucherno'),
			'totalcost'=>$this->input->post('totalcost'),
			'date'=>$this->input->post('date'),
			'narration'=>$this->input->post('narration'),
			'tbranch'=>$this->input->post('tbranch'),
			'fbranch'=>$this->input->post('fbranch'),
			// 'branchid'=>$this->input->post('branchid')
			 );
			 $stock=$this->Stockmodel->stockmaster($data);
			 echo json_encode($stock);
		}


		public function Stockdetails()
		{
			$data=array(
			'voucherno'=>$this->input->get_post('voucherno'),
			'product'=>$this->input->get_post('product'),
			'productid'=>$this->input->get_post('productid'),
			'qty'=>$this->input->get_post('qty'),
			'mrp'=>$this->input->get_post('mrp'),
			'batchid'=>$this->input->get_post('batch')
			);
			$details=$this->Stockmodel->Stockdetails($data);
			$fb=$this->input->get_post('fbranch');
			$tb=$this->input->get_post('tbranch');
			$qty=$this->input->get_post('qty');
			$pdt=$this->input->get_post('productid');
			$batch=$this->input->get_post('batch');
			$stock=$this->Onlinemodel->transferstock($fb,$tb,$qty,$pdt,$batch);
			echo json_encode($stock);
		}

		public function deletestocktransfer()
		{
			$a=$this->input->get_post('a');
			$stock=$this->Onlinemodel->deletetransfer($a);
			$data['stock']=$this->Onlinemodel->getstocktransfer();
			$this->load->view('header');
			$this->load->view('update',$data);
			$this->load->view('footer');
		}


		public function editstocktransfer()
		{
			$a=$this->input->get_post('a');
			$data['master']=$this->Onlinemodel->getstockmasterid($a);
			$data['details']=$this->Onlinemodel->getstockdetailsid($a);
			$data['branch']=$this->Onlinemodel->getBranch();
			$this->load->view('header');
			$this->load->view('editstock',$data);
			$this->load->view('footer');
		}

		public function Autogenerate_StockVoucherNo()
		{
			$data=$this->Onlinemodel->Autogenerate_StockVoucherNo();
			echo json_encode($data);
		}
	
		public function editstockmaster()
		{
			if( $this->session->userdata('name'))
			{
				$data=array(
				'voucherno'=>$this->input->post('voucherno'),
				'totalcost'=>$this->input->post('totalcost'),
				'date'=>$this->input->post('date'),
				'narration'=>$this->input->post('narration'),
				'tbranch'=>$this->input->post('tbranch'),
				'fbranch'=>$this->input->post('fbranch'),
				// 'branchid'=>$this->input->post('branchid')
				);
				$a=$this->input->post('voucherno');
				$stock=$this->Onlinemodel->editstockmaster($data,$a);
				echo json_encode($stock);
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
	
		public function editStockdetails()
		{
			$data=array(
			'voucherno'=>$this->input->get_post('voucherno'),
			'product'=>$this->input->get_post('product'),
			'productid'=>$this->input->get_post('productid'),
			'qty'=>$this->input->get_post('qty'),
			'mrp'=>$this->input->get_post('mrp')
			);
			$details=$this->Onlinemodel->Stockdetails($data);
			$fb=$this->input->get_post('fbranch');
			$tb=$this->input->get_post('tbranch');
			$qty=$this->input->get_post('qty');
			$pdt=$this->input->get_post('productid');
			$stock=$this->Onlinemodel->transferstock($fb,$tb,$qty,$pdt);
			echo json_encode($stock);
		}

		public function editstock()
		{
			$fb=$this->input->get_post('fbranch');
			$tb=$this->input->get_post('tbranch');
			$qty=$this->input->get_post('qty');
			$pdt=$this->input->get_post('productid');
			$stock=$this->Onlinemodel->transferstock($fb,$tb,$qty,$pdt);
			echo json_encode($stock);
		}

		//damage stock

		public function damagestock()
		{
			if( $this->session->userdata('name'))
			{
				if($this->session->userdata('role')=="Super Admin")
				{
					$this->load->model('Onlinemodel');
					$data=array();
					$branchid = $this->session->userdata('branch');
					$branchh=$branchid;
					if($this->session->userdata('role')=="Super Admin")
					{
						$data['branch']=$this->Onlinemodel->getBranch();
					}
					else
					{
						$data['branch']=$this->Onlinemodel->getUserBranch($branchid);
					}
					$data['branchid']=$branchh;
					$data['product']=$this->Onlinemodel->getproduct();
					$data['size']=$this->Onlinemodel->getsize();
					$data['damage']=$this->Stockmodel->getdamagestock();
					$data['batch']=$this->Onlinemodel->getbatch();
					$this->load->view('header');
					$this->load->view('damage_stock',$data);
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

		public function insertdamage()
		{
			$this->load->model('Stockmodel');
			$this->load->model('Onlinemodel');
			$this->load->model('Salesmodel');
			$data=array();
			$action=$this->input->get_post('save');
			$data['productcode']=$this->input->get_post('productcode');
			$data['referenceno']=$this->input->get_post('referenceno');
			$data['productname']=$this->input->get_post('productname');
			$data['branchid']=$this->input->get_post('branch');
			$data['date']=$this->input->get_post('retdate');
			$data['batchid']=$this->input->get_post('batch');
			$data['size']=$this->input->get_post('getsize');
			$data['qty']=$this->input->get_post('qty');
			$data['purchaserate']=$this->input->get_post('purchaserate');
			$data['damagestockamount']=$this->input->get_post('totaldamagedamount');
			$qty=$data['qty']*-1;
			$productcode=$data['productcode'];
			$referenceno=$data['referenceno'];
			$damagestockamount=$data['damagestockamount'];
			$branch=$data['branchid'];
			$date=$data['date'];
			$batch=$data['batchid'];
			$size=$data['size'];
			$voucherno=$data['referenceno'];
    		$transactiontype='Damage Stock';
    		$date=$this->input->post('retdate')." ".date("H:i:s");
    		$userid=$this->session->userdata('user');
			//stock update
			$stck=array();
			$stck['productid']=$productcode;
			$stck['currentstock']=$data['qty']*-1;
			$stck['branch']=$branch;
			$stck['batchid']=$batch;
			$stck['size']=$size;
			if($action=="Save")
			{
				$res=$this->Stockmodel->insert_damagestock($data);
				if($res)
				{
					$check=$this->Salesmodel->checkproduct($productcode,$branch,$batch,$size);
					if($check==0)
					{
						$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
					}
					else
					{
						$stock=$this->Onlinemodel->updatestock($productcode,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
					}
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('Damage Stock Not Added....!Please Try Again.');
					</script> 
					<?php 
				}
				// $acc=array();
				// $acc=$this->Stockmodel->damageaccount($damagestockamount);
				$data2['invoiceno']=$referenceno;
				$data2['accountType']='Damage Stock';
				$data2['date']=$date;
				$data2['userid']=$this->session->userdata('user');
				//stock account
				$data2['ledgername']=4;
				$data2['debit']=0;
				$data2['credit']=$damagestockamount;
				$data2['opposite']=9;
				$data22=$this->Onlinemodel->insert_newdaybook($data2);
				//damage account
				$data2['ledgername']=9;
				$data2['debit']=$damagestockamount;
				$data2['credit']=0;
				$data2['opposite']=4;
				$day22=$this->Onlinemodel->insert_newdaybook($data2);
				?>
				<script type="text/javascript">
				alert('Damage Stock Added Successfully.');
				</script>
				<?php 
				$this->damagestock();
			}
			else
			{
				?>
				<script type="text/javascript">
				alert('Damage Stock Not Added....!Please Try Again.');
				</script>
				<?php
				$this->damagestock();
			}
		}
		public function delete_damagestock()
		{
			$productcode=$this->input->get_post('productcode');
			$referenceno=$this->input->get_post('referenceno');
			$branch=$this->input->get_post('branch');
			$batch=$this->input->get_post('batch');
			$size=$this->input->get_post('getsize');
			$qty=$this->input->get_post('qty');
			$damagestockamount=$this->input->get_post('totaldamagedamount');
			$date=$this->input->post('retdate')." ".date("H:i:s");
    		$userid=$this->session->userdata('user');
			$transactiontype='Damage Stock Delete';
			$voucherno=$referenceno;
			$stck['productid']=$productcode;
			$stck['currentstock']=$qty;
			$stck['branch']=$branch;
			$stck['batchid']=$batch;
			$stck['size']=$size;
				$res=$this->Stockmodel->deletdamagestock($referenceno);
				if($res)
				{
					$check=$this->Salesmodel->checkproduct($productcode,$branch,$batch,$size);
					if($check==0)
					{
						$stock1=$this->Onlinemodel->insertstock($stck,$voucherno,$transactiontype,$date,$userid);
					}
					else
					{
						$stock=$this->Onlinemodel->updatestock($productcode,$size,$qty,$branch,$batch,$voucherno,$transactiontype,$date,$userid);
					}
				}
				else
				{
					?>
					<script type="text/javascript">
					alert('Damage Stock Not Added....!Please Try Again.');
					</script>
					<?php 
					$this->damagestock();
				}
				// $acc=array();
				// $acc=$this->Stockmodel->damageaccount($damagestockamount);
				// echo json_encode($acc);
				$data2['invoiceno']=$referenceno;
				$data2['accountType']='Damage Stock Delete';
				$data2['date']=$date;
				$data2['userid']=$this->session->userdata('user');
				//stock account
				$data2['ledgername']=4;
				$data2['debit']=$damagestockamount;
				$data2['credit']=0;
				$data2['opposite']=9;
				$data22=$this->Onlinemodel->insert_newdaybook($data2);
				//damage account
				$data2['ledgername']=9;
				$data2['debit']=0;
				$data2['credit']=$damagestockamount;
				$data2['opposite']=4;
				$day22=$this->Onlinemodel->insert_newdaybook($data2);
				?>
				<script type="text/javascript">
				alert('Damage Stock Deleted Successfully.');
				</script>
				<?php 
				$this->damagestock();
		}
		

}
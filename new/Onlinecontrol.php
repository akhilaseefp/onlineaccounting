<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Onlinecontrol extends CI_Controller {

	public function __cunstruct()
	    {
		   parent::__cunstruct();
		   $this->load->helper(array('form', 'url'));
           $this->load->library('form_validation');
           $this->load->library('session'); 
           $this->load->helper('form');
		  }
	public function index()
	{
		 // $this->load->view('admin/header');
		 //                                       $this->load->view('admin/index.html');
		 //                                       $this->load->view('admin/footer');
	      $this->load->view('login.html');
	}
	public function Login()
	{ 
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
	                {                            ?> <script type="text/javascript">
	alert('incorrect username or password');
</script> <?php 
		                      $this->load->view('admin/index.html');
                                       // $this->load->view('LoginForm');
	                }
		
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
		                $this->load->model('Onlinemodel');
	                            
		                         $data['table']=$this->Onlinemodel->get_productgroup();
		                         
                                $this->load->view('header');

		                        $this->load->view('Productgroup',$data);
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

	public function insert_productgroup()
	{$action=$this->input->get_post('save');
	if ($action=="Save") {
                           $data['groupname']=$_POST['groupname'];
                           $data['narration']=$_POST['narration'];
                           $data['groupunder']=$_POST['groupunder'];
                            $value=$data['groupname'];
                           $this->load->model('Onlinemodel'); 
                          
                           $existence=$this->Onlinemodel->checkexistence_productgroup($value);

                           if ($existence==0 ) {
                           	                         $insert_productgroup =  $this->Onlinemodel->insert_productgroup($data);
                                                   if ($insert_productgroup==true) {
                           	                                     
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
                           
                           }
                            else {
                           	?> <script type="text/javascript">
	alert('product group name already exists!!!!. please use another name');
</script> <?php 
                           }
                            }
               else{
                         $id=$_POST['groupid'];  
		                  
                           $data['groupname']=$_POST['groupname'];
                           $data['narration']=$_POST['narration'];
                          $data['groupunder']=$_POST['groupunder'];
                            $this->load->model('Onlinemodel');
                        $update=  $this->Onlinemodel->update_productgroup($id,$data);
                        if ($update!=true) {
                        	?> <script type="text/javascript">
	alert('updation failed!!!!!');
</script> <?php 
                        }
                            }
                       
                           $tablename="product_group";
                           $data['table']=$this->Onlinemodel->get_productgroup();
                           $this->load->view('header');
		                        $this->load->view('Productgroup',$data);
			                        	$this->load->view('footer');
	}
	public function delete_productgroup()
	{
                          $id=$_POST['groupid'];
                          $this->load->model('Onlinemodel');
                        $delete=  $this->Onlinemodel->delete_productgroup($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('product group deleted successfully');
</script> <?php 
                        }
                        
                           $tablename="product_group";
                           $data['table']=$this->Onlinemodel->get_productgroup();
                           $this->load->view('header');
		                        $this->load->view('Productgroup',$data);
			                        	$this->load->view('footer');


	}
	
	public function home()
	{
       $this->load->view('header');
		                       $this->load->view('AccountGroup');
		                      		$this->load->view('footer');
	}
	
		public function unit()
	{
		   
		    if( $this->session->userdata('name'))
		             {           $data['query']=$this->Onlinemodel->getunit();

                                                      $this->load->view('header');
		                      
	                                                	$this->load->view('unit',$data);
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
	public function insert_unit()
	{  $action=$this->input->get_post('save');
	if ($action=="Save") {
		                        $data=array();
		$data['unitname']=$this->input->get_post('uname');
		$data['narration']=$this->input->get_post('narration');
         $value=$data['unitname'];
		   $this->load->model('Onlinemodel');
	                        
	                         $existence=$this->Onlinemodel->checkexistence_unit($value);
	                         if($existence==0){
	                         	$result=$this->Onlinemodel->insert_unit($data);
	                         	if ($result==true) { 
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('product group name already exists!!!!. please use another name');
</script> <?php 
                           }
		
	} else
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

                        		                            /*  if(confirm("confirm delete???")){
                        		                              	<?php
                        			                                    $id=$_POST['unitId'];
                                                                        $this->load->model('Onlinemodel');
                                                                         $delete=  $this->Onlinemodel->delete_unit($id);
                                                                         ?>

}
else{

}*/
public function delete_unit()
{
$id=$this->input->get_post('unitId');
$this->load->model('Onlinemodel');
$delete= $this->Onlinemodel->delete_unit($id);
if ($delete) {
?> <script type="text/javascript">
	alert('unit deleted successfully');
</script> <?php 
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
          $this->load->model('Onlinemodel');
		
	  $data['query']=$this->Onlinemodel->getsupplier();
		    $this->load->view('header');
		                      
		$this->load->view('supplier',$data);
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

public function insert_supplier()
		{  $action=$this->input->get_post('save');
		
			$data=array();
			$data['suppliername']=$this->input->get_post('suppliername');
			$data['address']=$this->input->get_post('address');
			$data['email']=$this->input->get_post('email');
			$data['website']=$this->input->get_post('website');
			$data['date']= date("d-m-y h:i:sa ");
			$data['mobile']=$this->input->get_post('phone');
			$data['code']=$this->input->get_post('code');
			$data['city']=$this->input->get_post('city');
			
			$data['country']=$this->input->get_post('country');
			$data['vatno']=$this->input->get_post('vatno');
			$data['openingbalance']=$this->input->get_post('openingbalance');
			$data['supplierbalance']=$this->input->get_post('openingbalance');
			$data['supplieraccount']=$data['suppliername'];
	        $value=$data['suppliername'];
	         if($action=="Save"){


		                       $existence=$this->Onlinemodel->checkexistence_supplier($value);
		                          if($existence==0)
		                          {
		                         	       $result=$this->Onlinemodel->insert_supplier($data);
		                                         	if ($result==true) {

		                                        //Ledger Insertion_start
			                         			$data2=array();
			                         			$data2['ledgername']=$data['supplieraccount'];
			                         			$data2['accountgroup']='16';
											       $data2['interestcalculation']=0;
											       $data2['openingbalance']=$this->input->get_post('openingbalance');
											       $data2['creditordebit']='Cr';
											       $data2['narration']='Autogenerated for Supplier';
											       $data2['currentbalance']=$this->input->get_post('openingbalance');
									               $value2=$data2['ledgername'];

			                         			$ledgervalues=$this->Onlinemodel->insert_accountledger($data2);
			                         			echo 'ledgersuccess';
			                         			if($ledgervalues!=true)
			                         			{
			                         				?> <script type="text/javascript">
	alert('Error in Ledger creation........');
</script>
<?php 
			                         			}

			                         			//Ledger Insertion_End



	                                           	                           ?> <script type="text/javascript">
	alert('supplier detailes saved successfully');
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
	alert('supplier name already exists!!!!. please use another name');
</script> <?php 
	                                           }
	                                            
	                                       }
	                       else{
	                         $id=$this->input->get_post('supplierid');
	                       	 $this->load->model('Onlinemodel');
	         $update =$this->Onlinemodel->update_supplier($id,$data);
	         if(!$update){
	         	?>
<script type="text/javascript">
	alert('updation failed');
</script> <?php 
	         }
	                       }                  $data['query']=$this->Onlinemodel->getsupplier();
	                                                        $this->load->view('header');
		                                                	$this->load->view('supplier',$data);
			                                                $this->load->view('footer');
	                      


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
                        if (!$delete) {
                        	?> <script type="text/javascript">
	alert('deletion failed!!!!');
</script> <?php 
                        }
                        else
                        {
                        	?> <script type="text/javascript">
	alert('Deleted Successfully.....');
</script> <?php
                        }
                      
                           	                            $data['query']=$this->Onlinemodel->getsupplier();
                                                        $this->load->view('header');
	                                                	$this->load->view('supplier',$data);
		                                                $this->load->view('footer');
                      
                           

	}

		public function brand()
	{
	    if($this->session->userdata('name'))
		{
	    $data['query']=$this->Onlinemodel->getbrand();

                                                        $this->load->view('header');
	                                                	$this->load->view('brand',$data);
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
			                        else{
			                        	?>
<script type="text/javascript">
	alert("please login again");
</script>
<?php 
			                        	$this->index();
			                        } 
	}
	
	

	public function insert_batch()
	{   $action=$this->input->get_post('save');
	
         if($action=="Save"){
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
	
	
	public function product()
	{
       	    if($this->session->userdata('name'))
		{
       $data=array();
       $data['product']=$this->Onlinemodel->getproduct();
       $data['unit']=$this->Onlinemodel->getunit();
       $data['group']=$this->Onlinemodel->get_productgroup();
       $data['brand']=$this->Onlinemodel->getbrand();
       $data['code']=$this->Onlinemodel->Autogenerate_pdt();
	    $this->load->view('header');                  
		$this->load->view('product',$data);
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
	public function insert_product()
	{ 
		$action=$this->input->get_post('save');
		$unitname=$this->input->get_post('unitname');
		  $data['pdt_name']=$this->input->get_post('product');
		$data['pdt_code']=$this->input->get_post('code');
		$data['groupid']=$this->input->get_post('group');
		$data['purchaserate']=$this->input->get_post('pur_rate');
		
		$data['brandid']=$this->input->get_post('brand');
		$data['mrp']=$this->input->get_post('mrp');
		$data['unitid']=$this->input->get_post('unit');
		
		$data['tax']=$this->input->get_post('tax');
		$data['minimumstock']=$this->input->get_post('minimumstock');
		$data['openingstock']=$this->input->get_post('openingstock');
		$data['currentstock']=$this->input->get_post('openingstock');

		$data['narration']=$this->input->get_post('narration');

		    $value=$data['pdt_name'];
		    $id=$this->input->get_post('productid');


         if($action=="Save"){


	                       $existence=$this->Onlinemodel->checkexistence_product($value);
	                          if($existence==0)
	                          {
	                         	$result=$this->Onlinemodel->insert_product($data);
	                         	if ($result!=0) {   


	                                       	        	$data1['product_id']=$result;
                                          	$data1['unit']=$unitname;
                                          	$data1['count']="1";
                                          	$data1['bunit']=$this->input->get_post('unit');
                                          	$data1['rate']=$this->input->get_post('mrp');
                                          	// $data['product_id']=$this->input->get_post('');
											  $result=$this->Onlinemodel->insert_munit($data1);
											  $data2=array();
											  $data2['productid']=$this->input->get_post('code');
											  $data2['branch']="Head Office";
											  $data2['currentstock']=$this->input->get_post('openingstock');
											  $this->Onlinemodel->insertstock($data2);
             

                      
	                         
	                         	                  if ($result==true) {
                           	                            
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
                           	                           
                                    } else {
                           	                         ?> <script type="text/javascript">
	alert('insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('product name already exists!!!!. please use another name');
</script> <?php 
                           }
                          

                             }
         else      {
            
                           $update=$this->Onlinemodel->update_product($id,$data);
                           if ($update==true) {
                           	                       $data=array();
	     	

		        	$data1['product_id']=$id;
		        	
                  	$data1['unit']=$unitname;
                	$data1['count']="1";
                	$data1['bunit']=$this->input->get_post('unit');
                	$UNITID=$data1['bunit'];
   	                $data1['rate']=$this->input->get_post('mrp');
		
		// echo $id;
		 $this->load->model('Onlinemodel');
         $update =$this->Onlinemodel->update_productunit($id,$data1);
         if(!$update){
         	 ?> <script type="text/javascript">
	alert('updation failed');
</script>
<?php 
         }

                           	                       }
                           	                       else{
                           	                           ?> <script type="text/javascript">
	alert('updation failed');
</script>
<?php 
                                                   } 

                                       }
		
                         $data['product']=$this->Onlinemodel->getproduct();
                                  $data['unit']=$this->Onlinemodel->getunit();
$data['code']=$this->Onlinemodel->Autogenerate_pdt();

       $data['group']=$this->Onlinemodel->get_productgroup();
       $data['brand']=$this->Onlinemodel->getbrand();
	    $this->load->view('header');                  
		$this->load->view('product',$data);
		$this->load->view('footer');
	    

	}
	public function delete_product()
	{
          $id=$this->input->get_post('productid');
                         
                        $delete=  $this->Onlinemodel->delete_product($id);
                        if ($delete) {
                        	?> <script type="text/javascript">
	alert('product deleted successfully');
</script> <?php 
                        }
                      
                         $data['product']=$this->Onlinemodel->getproduct();
                                  $data['unit']=$this->Onlinemodel->getunit();
       $data['group']=$this->Onlinemodel->get_productgroup();
       $data['brand']=$this->Onlinemodel->getbrand();
$data['code']=$this->Onlinemodel->Autogenerate_pdt();

	    $this->load->view('header');                  
		$this->load->view('product',$data);
		$this->load->view('footer');
                           	                          
	}
	

	
	public function paymentvoucher()
	{

       	    if($this->session->userdata('name'))
		{
        $data=array();
        $this->load->model('Onlinemodel');
        $data['supp']=$this->Onlinemodel->getsupplier();
        $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
        $data['voucherno']=$this->Onlinemodel->Autogenerate_payVoucherNo();
        $data['pay']=$this->Onlinemodel->getpaymentvoucher();
		$this->load->view('header');
		$this->load->view('PaymentVoucher',$data);
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

    public function insert_paymentvoucher()
    {
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->get_post('VendorInvoiceNo');
    	$data['supplier']=$this->input->get_post('supplier');
    	$data['date']=$this->input->get_post('date');
    	$data['currentbalance']=$this->input->get_post('currentbalance');
    	$data['narration']=$this->input->get_post('narration');
    	$data['totalamount']=$this->input->get_post('totalamount');
    	$data['cashorbank']=$this->input->get_post('cashorbank');
    	$data['voucherno']=$this->input->get_post('voucherno');
    	// $this->Onlinemodel->insert_paymentvoucher($data);

$action=$this->input->get_post('btnsave');
         if($action=="Save")
			    {   
	               $value=$this->input->get_post('voucherno');

	                       $existence=$this->Onlinemodel->checkexistence_payment($value);
		                          if($existence==0)
		                          {
		                         	$result=$this->Onlinemodel->insert_paymentvoucher($data);
		                         	if ($result) {
		                         		    $supplierid= $data['supplier'];
		                         		 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
		                         		 	$cashorbank= $data['cashorbank'];

		                         		 	
		                         		 	$ledgername=$data['records']['supplieraccount'];

		                         		 	$amount=$data['totalamount'];
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount);
		                         		 	if($result2){

		                         		 		$data2=array();	
		                         		 	$data2['invoiceno']=$data['voucherno'];
		                         		 	$data2['accountType']='Payment Voucher';
		                         		 	$data2['date']=$data['date'];
		                         		 	$data2['ledgername']=$ledgername;
		                         		 	$data2['userid']=$this->session->userdata('user');
		                         		 
		                         		 	$data2['debit']=$data['totalamount'];
		                         		 	$data2['credit']=0;

		                         		 	
		                         		 	$result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	$data2['ledgername']=$cashorbank;
		                         		 	
		                         		 	$data2['debit']=0;
		                         		 	$data2['credit']=$data['totalamount'];
                                              $result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	if($result3==false)
		                         		 	{
 												?> <script type="text/javascript">
	alert('Failed Daybook insertion........');
	<?php
		                         		 	}
	                           	                           ?> <script type="text/javascript">
	alert('Saved successfully........');
</script>
<?php 
	                                                   } else {
	                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs!!!');
</script> <?php 
	                                                   }
		                         }
		                         
	                            else {
	                           	?>
<script type="text/javascript">
	alert('voucherno name already exists!!!. please refresh');
</script> <?php 
	                           }
	         }
	     }
	        
			
	         
        $data['supp']=$this->Onlinemodel->getsupplier();
        $data['voucherno']=$this->Onlinemodel->Autogenerate_payVoucherNo();
        $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
        $data['pay']=$this->Onlinemodel->getpaymentvoucher();
		$this->load->view('header');
		$this->load->view('PaymentVoucher',$data);
		$this->load->view('footer');
	}


    

 public function delete_paymentvoucher()
    {
    	$data=array();
    	$data['vendorinvoiceno']=$this->input->get_post('VendorInvoiceNo');
    	$data['supplier']=$this->input->get_post('supplier');
    	$data['date']=$this->input->get_post('date');
    	$data['currentbalance']=$this->input->get_post('currentbalance');
    	$data['narration']=$this->input->get_post('narration');
    	$data['totalamount']=$this->input->get_post('totalamount');
    	$data['cashorbank']=$this->input->get_post('cashorbank');
    	$data['voucherno']=$this->input->get_post('voucherno');
        $id=$this->input->get_post('voucherno');
        $this->load->model('Onlinemodel');
        $delete = $this->Onlinemodel->delete_paymentvoucher($id);
        if($delete)
        {                                    $supplierid= $data['supplier'];
		                         		 	$data['records']=$this->Onlinemodel->Select_supplierledger($supplierid);
		                         		 	$cashorbank= $data['cashorbank'];

		                         		 	
		                         		 	$ledgername=$data['records']['supplieraccount'];

		                         		 	$amount=$data['totalamount'];
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,-1*$amount);
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,-1*$amount);
		                         		 	if($result2){

		                         		 		$data2=array();	
		                         		 	$data2['invoiceno']=$data['voucherno'];
		                         		 	$data2['accountType']='Payment Voucher delete';
		                         		 	$data2['date']=$data['date'];
		                         		 	$data2['ledgername']=$ledgername;
		                         		 	$data2['debit']=0;
		                         		 	$data2['credit']=$data['totalamount'];
                    		 	      		 $result3=$this->Onlinemodel->insert_daybook($data2);

		                         		 	$data2['ledgername']=$cashorbank;
		                         		  	$data2['debit']=$data['totalamount'];
		                         		 	$data2['credit']=0;
                                              $result3=$this->Onlinemodel->insert_daybook($data2);
                                                  ?><script type="text/javascript">
	                                                 alert('paymentvoucher deleted successfully');
                                                              </script><?php
                                                 }
         $data['supp']=$this->Onlinemodel->getsupplier();
         $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
        $data['voucherno']=$this->Onlinemodel->Autogenerate_payVoucherNo();
        $data['pay']=$this->Onlinemodel->getpaymentvoucher();
        $this->load->view('header');
        $this->load->view('PaymentVoucher',$data);
        $this->load->view('footer');
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
	alert('multiunit deletion failed ');   
</script> <?php 
                        }
                      
                           	                           $data['product']=$this->Onlinemodel->getproduct();
   	              $data['unit']=$this->Onlinemodel->getunit();
   	              $data['munit']=$this->Onlinemodel->getmunit();
 	                    $this->load->view('header');
		                $this->load->view('munit',$data);
		                $this->load->view('footer');
         	
                      
                           

	}
	

		
		
	
		public function PurchaseInvoice_AccountInsertion()
				{
					 
					
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

		            $cashorbank=$this->input->post('cashorbank');
		            $data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
		            // echo $data['records2']['accountgroup'],
		            $accountgroupid=$data['records2']['accountgroup'];
		            $CashAccountAmt=0;
		            $BankAccountAmt=0;
		            $paidamount=$this->input->post('paidamount');
		            $Bankaccount="";
		            if($accountgroupid==19)
		            {
		            	if($balance>0)
		            	{
		            		$BankAccountAmt=$paidamount-$balance;
		            	}
		            	else if($balance<0)
		            	{
		            		$BankAccountAmt=$paidamount;
		            	}

		            	$Bankaccount=$this->input->post('Bankaccount');
		            }
		            else if($accountgroupid==18)
		            {
		            	if($balance>0)
		            	{
		            		$CashAccountAmt=$paidamount-$balance;
		            	}
		            	else  if($balance<0)
		            	{
		            		$CashAccountAmt=$paidamount;
		            	}	
		            }

		            echo $PurchaseDiscount,0;
					 $data=$this->Onlinemodel->PurchaseInvoice_AccountInsertion($PurchaseDiscount,$TotalTaxAmt,
            		 $TotalPurchasedStockAmount,$balance,$Supplieraccount,$CashAccountAmt,$BankAccountAmt,$Bankaccount);

					  
			        echo json_encode($data);
				}


	
	
		public function pur_invoice()
	{

       	    if($this->session->userdata('name'))
		{
	$data=array();
			       $data['product']=$this->Onlinemodel->getproduct();
			       $data['unit']=$this->Onlinemodel->getunit();
			       $data['brand']=$this->Onlinemodel->getbrand();
			       $data['branch']=$this->Onlinemodel->getBranch();
			       $data['batch']=$this->Onlinemodel->getbatch();
			       $data['group']=$this->Onlinemodel->get_productgroup();
			       $data['supplier']=$this->Onlinemodel->getsupplier();
			       $data['voucherno']=$this->Onlinemodel->Autogenerate_VoucherNo();
			       $data['purchase']=$this->Onlinemodel->getpurchase();
			       $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();

			     
					$this->load->view('header');
					$this->load->view('Purchase',$data);
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
	

	


	public function inserttable()
	{
		 $name=$this->input->post('productname');
		 $code=$this->input->post('productcode');
		 // $pdt=$this->Onlinemodel->checkexistence_product2($name,$code);



		     $data['voucherno']=$this->input->post('voucherno');
		     $data['invoicedate']=$this->input->post('invoicedate');
		     $data['productname']=$this->input->post('productname');
		 	 $data['productcode']=$this->input->post('productcode');
		 	 $data['qty']=$this->input->post('qty');
		 	 $data['unitprice']=$this->input->post('unitprice');
		 	 $data['netamount']=$this->input->post('netamount');
		 	 $data['tax']=$this->input->post('tax');
		 	 $data['taxamount']=$this->input->post('taxamount');
		 	 $data['amount']=$this->input->post('amount');
		 	 $data['batchid']=$this->input->post('batch');
 
		 	 
		 	
	     $branch=$this->input->post('branch');		
		 $name=$data['productcode'];
		 $qty=$data['qty'];
		 $batch=$data['batchid'];

		  $data=$this->Onlinemodel->insertpurchasegrid($data);
		  $check=$this->Onlinemodel->checkproduct($name,$branch,$batch);
		  if($check > 0)
		  {


		  $stock=$this->Onlinemodel->updatestock($name,$qty,$branch,$batch);
		}
		else
		{
			$stck=array();
			$stck['productid']=$name;
			$stck['currentstock']=$qty;
			$stck['branch']=$branch;
			$stck['batchid']=$batch;
			$stock=$this->Onlinemodel->insertstock($stck);

		}

		   
        echo json_encode($qty);
	}

	public function editdetailes()
	{
		 $data=array(

		 'voucherno'=>$this->input->post('voucherno'),
		 'suppliername'=>$this->input->post('supplier'),
		 'orderno'=>$this->input->post('order'),
		 'vendorinvoiceno'=>$this->input->post('vendor'),
		 'invoicedate'=>$this->input->post('date'),
		 'paymentmode'=>$this->input->post('payment'),
		 'narration'=>$this->input->post('narration'),
		  'transportcompany'=>$this->input->post('company'),
		 	'totalqty'=>$this->input->post('totalqty'),
		 	'totalamount'=>$this->input->post('totalamount'),
		 	'additionalcost'=>$this->input->post('additionalcost'),
		 	'taxamount'=>$this->input->post('tax'),
		 	'billdiscount'=>$this->input->post('discount'),
		 	'totalamount'=>$this->input->post('total'),
		 	'oldbalance'=>$this->input->post('oldbalance'),
		 	'cashorbank'=>$this->input->post('bank'),
		 	'paidamount'=>$this->input->post('paidamount'),
		 	'balance'=>$this->input->post('balance'),
		 	);		 
		 $a=$this->input->post('voucherno');

		  // $data=$this->Onlinemodel->editdetailes($a,$data);
		   // $data=$this->Onlinemodel->save_product($data);
        echo json_encode($a);
		 	}



public function inserttable1()
	{
		 $name=$this->input->post('productname');
		 $code=$this->input->post('productcode');
		 // $pdt=$this->Onlinemodel->checkexistence_product2($name,$code);



		     $data['voucherno']=$this->input->post('voucherno');
		     $data['invoicedate']=$this->input->post('invoicedate');
		     $data['productname']=$this->input->post('productname');
		 	 $data['productcode']=$this->input->post('productcode');
		 	 $data['qty']=$this->input->post('qty');
		 	 $data['unitprice']=$this->input->post('unitprice');
		 	 $data['netamount']=$this->input->post('netamount');
		 	 $data['tax']=$this->input->post('tax');
		 	 $data['taxamount']=$this->input->post('taxamount');
		 	 $data['amount']=$this->input->post('amount');
		 	 $pre=$this->input->get_post('pre');
		 $qty=$data['qty'];
		 $vouch=$data['voucherno'];
		 $code=$data['productcode'];

 
		 	 // if($pre>0)
		 	 // {
		 	 // 	if($pre!=$qty){
		 	 // 		$data=$this->Onlinemodel->updatepurchase()
		 	 // 	}
		 	 // }
		 	
	 //     $branch=$this->input->post('branch');		
		 $name=$data['productcode'];

		  // $data=$this->Onlinemodel->insertpurchasegrid($data);
		//   $check=$this->Onlinemodel->checkproduct($name,$branch);
		//   if($check > 0)
		//   {
		//   $stock=$this->Onlinemodel->updatestock($name,$qty,$branch);
		// }
		// else
		// {
		// 	$stck=array();
		// 	$stck['productid']=$name;
		// 	$stck['currentstock']=$qty;
		// 	$stck['branch']=$branch;
		// 	$stock=$this->Onlinemodel->insertstock($stck);
		// }
        echo json_encode($name);
	}




	public function insertdetailes()
	{
		 $data=array(

		 'voucherno'=>$this->input->post('voucherno'),
		 'suppliername'=>$this->input->post('supplier'),
		 'orderno'=>$this->input->post('order'),
		 'vendorinvoiceno'=>$this->input->post('vendor'),
		 'invoicedate'=>$this->input->post('date'),
		 'paymentmode'=>$this->input->post('payment'),
		 'narration'=>$this->input->post('narration'),
		  'transportcompany'=>$this->input->post('company'),
		 	'totalqty'=>$this->input->post('totalqty'),
		 	'totalamount'=>$this->input->post('totalamount'),
		 	'additionalcost'=>$this->input->post('additionalcost'),
		 	'taxamount'=>$this->input->post('tax'),
		 	'billdiscount'=>$this->input->post('discount'),
		 	'grandtotal'=>$this->input->post('total'),
		 	'oldbalance'=>$this->input->post('oldbalance'),
		 	'cashorbank'=>$this->input->post('bank'),
		 	'paidamount'=>$this->input->post('paidamount'),
		 	'balance'=>$this->input->post('balance'),
		 	);		 
		  $data=$this->Onlinemodel->insertdetailes($data);
		   // $data=$this->Onlinemodel->save_product($data);
        echo json_encode($data);
		 	}
		 	//Branch_start

          public function branch()
          {

       	    if($this->session->userdata('name'))
		{
           $data=array();
           $data['branch']=$this->Onlinemodel->getBranch();

            $this->load->view('header');
            $this->load->view('Branch',$data);
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

          public function insert_branch()
          {
          	$action=$this->input->get_post('btnsave');
	
	         
	         	 $data=array();

			       $data['branchname']=$this->input->get_post('branchname');
			       $data['branchincharge']=$this->input->get_post('branchincharge');
			       $data['phonenumber']=$this->input->get_post('phonenumber');
			       $data['address']=$this->input->get_post('address');

			    if($action=="Save")
			    {   
	               $value=$data['branchname'];

	                       $existence=$this->Onlinemodel->checkexistence_branch($value);
		                          if($existence==0)
		                          {
		                         	$result=$this->Onlinemodel->insert_branch($data);
		                         	if ($result==true) {
	                           	                           ?> <script type="text/javascript">
	alert('Saved successfully........');
</script>
<?php 
	                                                   } else {
	                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs!!!');
</script> <?php 
	                                                   }
		                         }
		                         
	                            else {
	                           	?>
<script type="text/javascript">
	alert('Branch name already exists!!!. please use another name');
</script> <?php 
	                           }
	         }
	         elseif($action=="Update")
	         {

			
			 	$id=$this->input->get_post('branchid');
			 
	        	$update =$this->Onlinemodel->update_branch($id,$data);
	          if ($update==true) 
	          {
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


	                                       }
			
	         else
	         {
	         	echo $action;
	         }
	                 
	          $data['branch']=$this->Onlinemodel->getBranch();

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
<?PHP
          	}
          	$data['branch']=$this->Onlinemodel->getBranch();
          	$this->load->view('header');
          	$this->load->view('Branch',$data);
          	$this->load->view('footer');
          }



          //Branch_End

          //UserRegistration_Start

          public function AddUser()
          {

       	    if($this->session->userdata('name'))
		{
          	$data=array();
          	$data['adduser']=$this->Onlinemodel->getadduser();
          	$data['branch']=$this->Onlinemodel->getBranch();

          	$this->load->view('header');
          	$this->load->view('AddUser',$data);
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

          public function insert_adduser()
          {
          	$action=$this->input->get_post('btnsave');
	
	         
	         	 $data=array();

			       $data['firstname']=$this->input->get_post('firstname');
			       $data['lastname']=$this->input->get_post('lastname');
			       $data['role']=$this->input->get_post('role');
			       $data['branch']=$this->input->get_post('branch');
			       $data['phonenumber']=$this->input->get_post('phonenumber');
			       $data['idnumber']=$this->input->get_post('idnumber');
			       $data['email']=$this->input->get_post('email');
			       $data['username']=$this->input->get_post('username');
			       $data['password']=$this->input->get_post('password');
			       $cpw=$this->input->get_post('confirmpassword');

			    if($action=="Save")
			    {   
	               $value=$data['username'];

	                       $existence=$this->Onlinemodel->checkexistence_adduser($value);
		                          if($existence==0)
		                          {
		                          	if($cpw==$data['password'])
		                          	{
		                          		$result=$this->Onlinemodel->insert_adduser($data);
		                         		if ($result==true) {
	                           	                           ?> <script type="text/javascript">
	alert('Saved successfully........');
</script>
<?php 
	                                                   } else {
	                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs!!!');
</script> <?php 
	                                                   }
		                          	
		                          	}
		                          	else {
			                           	?>
<script type="text/javascript">
	alert('Please ensure that Password and Confirm Password are same.');
</script> <?php 
			                           }
		                          		
		                          	
		                         }
		                         
	                            else {
	                           	?>
<script type="text/javascript">
	alert('User name already exists!!!. please use another name');
</script> <?php 
	                           }
		         }
		         elseif($action=="Update")
		         {
		         	if($cpw==$data['password'])
		         	{

		         		$id=$this->input->get_post('userid');
				 
		        		$update =$this->Onlinemodel->update_adduser($data,$id);
				          if ($update==true) 
				          {

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
		         	}
						else
						 {
			                           	?>
<script type="text/javascript">
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

          	 $data['adduser']=$this->Onlinemodel->getadduser();
		          $data['branch']=$this->Onlinemodel->getBranch();

	            $this->load->view('header');
	            $this->load->view('AddUser',$data);
	            $this->load->view('footer');
          }



          //UserRegistration_End

       //ChangePassword_Start

           public function Changepassword()
          {
          	// $data=array();
          	// $data['adduser']=$this->Onlinemodel->getadduser();
          	// $data['branch']=$this->Onlinemodel->getBranch();

          	$this->load->view('ChangePassword');
          }

          public function update_Changepassword()
			{
									$data['username'] = $this->input->get_post('username');
			                        $data['password']=$this->input->get_post('oldpassword');
			                        $this->load->model('Onlinemodel');
			                        $CheckUser=$this->Onlinemodel->CheckUser($data);
			
			  if($CheckUser==true)
			                {

			                	$newpassword=$this->input->get_post('newpassword');
			                	$confirmpassword=$this->input->get_post('confirmpassword');
			                	if($newpassword == $confirmpassword)
			                	{
			                		$username=$this->input->get_post('username');
			                		$columns=array();
			                		$columns['username']=$this->input->get_post('username');
			                		$columns['password']=$this->input->get_post('newpassword');

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
		                                       $this->load->view('ChangePassword');
			                }
			}

			public function LoginCheck()
			{ 
			                        $data['username'] = $this->input->get_post('username');
			                        $data['password']=$this->input->get_post('password');
			                        $this->load->model('Onlinemodel');
			                        $login['log']=$this->Onlinemodel->CheckUser($data);
			                        // print_r($login['log']);

			  if($login['log'])
			                {
			                	foreach ($login['log']->result() as $key) {

			                		$name=	$key->firstname;
			                		$user=	$key->userid;
			                		$branch=$key->branch;
       $this->session->set_userdata('user', $user);
       $this->session->set_userdata('name', $name);
       $this->session->set_userdata('branch', $branch);
			                	}
			                 $this->load->view('admin/header');
		                                       $this->load->view('admin/index.html');
		                                       $this->load->view('admin/footer');


       
// print_r($this->session->userdata); 


			                }
			                else
			                {              
			                              ?> <script type="text/javascript">
	alert('incorrect username or password');
</script> <?php 
		                                       $this->index();
			                }
			
				
			}

          //ChangePassword_ENd

			//PurchaseReport_START

//PurchaseReport_START

			public function PurchaseReport()
			{
				
		             if( $this->session->userdata('name'))
		             { 
				$data=array();

				$fromdate=$this->input->get_post('fromdate');
				$todate=$this->input->get_post('todate');
				$SearchBy=$this->input->get_post('searchby');
				$supplier=$this->input->get_post('supplier');
				$productname=$this->input->get_post('productname');
				

					if($SearchBy=="Supplier-wise")
					{
						$data['PurchaseDetails']=$this->Onlinemodel->Loadpurchasedetails_Supplierwise($fromdate,$todate,$supplier);
					}
					else if($SearchBy=="Product-wise")
					{
						$data['PurchaseDetails']=$this->Onlinemodel->Loadpurchasedetails_ProductNamewise($fromdate,$todate,$productname);
					}
					else
					{
						$data['PurchaseDetails']=$this->Onlinemodel->LoadPurchaseDetails_All($fromdate,$todate);
					}
				

				$data['supplier']=$this->Onlinemodel->getsupplier();
				$data['productname']=$this->Onlinemodel->FillProduct();
				$this->load->view('header');
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

           //salesreport 

			// public function salesreport

			public function loadPurchaseDetailsAll()
			{
				$data=array();
				$data['PurchaseDetailsAll']=$this->Onlinemodel->LoadPurchaseDetails_All();
			}


			//StockReport_Start

			public function StockReport()
			{

       	    if($this->session->userdata('name'))
		{
				$data=array();
				$fromdate=$this->input->get_post('fromdate');
				$todate=$this->input->get_post('todate');
				echo $fromdate;
				echo $todate;
				$Searchoption=$this->input->get_post('searchoption');

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
					$data['Stockdetails']=$this->Onlinemodel->LoadAllstock();
				}
				

				$this->load->view('header');
				$this->load->view('StockReport',$data);
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

			

			//StockReport_End

    public function journelvoucher()
    {
    	 if( $this->session->userdata('name'))
		             {  $data=array();
		             	$data['accountledger']=$this->Onlinemodel->getaccountledger();
                        $data['voucherno']=$this->Onlinemodel->Autogenerate_Journal_VoucherNo();
                        $this->load->view('header');
                        $this->load->view('JournalVoucher',$data);
                        $this->load->view('footer');
                      }
                 else{
        	         $this->load->view('login.html');
                      }
        
    }
    public function insert_journalmaster(){
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
	                         	if ($result==true) {
                           	                          
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            else {
                           	?>
<script type="text/javascript">
	alert('voucherno already exists!!!!.');
</script> <?php 
                           }
    }
     public function insert_journaldetails(){
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
	                         	if ($result==true) {  $sum =$data['debit']*1 - $data['credit']*1;
	                         		                  $result2=0;
                           	                                   if($type==Cr){
                                                                             $result2=$this->Onlinemodel->update_customerledgerbalance($ledgerid,$sum);

                           	                                                }
                           	                                            else{
                                                                             $result2=$this->Onlinemodel->update_customerledgerbalance($ledgerid,$sum*-1);

                           	                                                 }
                           	                                                 if(result2){

                           	                                                 		$data2=array();	
		                         		                                        	$data2['invoiceno']=$data['voucherno'];
		                         		                                           	$data2['accountType']='Journal Voucher_save';
		                         		                                           	$data2['date']=$date;
		                         		                                           	$data2['ledgername']= $data['ledgerid'];
		                         		 	                                       	$data2['debit']= $data['debit'];
		                         		                                           	$data2['credit']=$data['credit'];
		                         		                                           	$data2['userid']=$this->session->userdata('user');
		                         		 	
		                         		                                           	$result3=$this->Onlinemodel->insert_daybook($data2);
                           	                                                 }

                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs');
</script> <?php 
                                                   }
	                         
    }
    //Stock transfer
    public function stocktransfer()
    {
    	 if( $this->session->userdata('name'))
    	 {
	  $data['voucherno']=$this->Onlinemodel->Autogenerate_StockVoucherNo();
	 
      $data['product']=$this->Onlinemodel->getproduct();
      $data['branch']=$this->Onlinemodel->getBranch();
      $data['batch']=$this->Onlinemodel->getBatch();
        $this->load->view('header');
        $this->load->view('StockTransfer',$data);
        $this->load->view('footer');
        }
        else
        {
        	$this->index();
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
   	$stock=$this->Onlinemodel->stockmaster($data);
        echo json_encode($stock);

   }
   public function Stockdetails()
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
					
			?>
<script type="text/javascript">
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


    public function physicalstock()
    {
        $this->load->view('header');
        $this->load->view('PhysicalStock');
        $this->load->view('footer');
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
	public function pur_return()
	{
		 if( $this->session->userdata('name'))
    	 {
		$this->load->view('header');
		$this->load->view('PurchaseReturn');
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


    public function salesorder()
    {
    	 if( $this->session->userdata('name'))
    	 {
        $this->load->view('header');
        $this->load->view('SalesOrder');
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
    public function salesreturns()
    {
    	 if( $this->session->userdata('name'))
    	 {
        $this->load->view('header');
        $this->load->view('SalesReturns');
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
		$data=array();
		$data['accountgroup']=$this->Onlinemodel->getaccountgroup();
		$data['FiilTableAccountgroup']=$this->Onlinemodel->FiilTableAccountgroup();

		$this->load->view('header');
		$this->load->view('AccountGroup',$data);
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
		$data=array();
		$data['accountledger']=$this->Onlinemodel->getaccountledger();
		$data['accountgroup']=$this->Onlinemodel->getaccountgroup();
		$data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();

		$this->load->view('header');
		$this->load->view('AccountLedger',$data);
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

	public function insert_accountledger()
	{   
		$action=$this->input->get_post('btnsave');
	
         if($action=="Save"){
         	 $data=array();

		       $data['ledgername']=$this->input->get_post('ledgername');
		       $data['accountgroup']=$this->input->get_post('accountgroup');
		       $data['interestcalculation']=$this->input->get_post('interestcalculation');
		       $data['openingbalance']=$this->input->get_post('openingbalance');
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
		       $data['openingbalance']=$this->input->get_post('openingbalance');
		       $data['creditordebit']=$this->input->get_post('creditordebit');
		       $data['narration']=$this->input->get_post('narration');
		       $data['currentbalance']=$this->input->get_post('openingbalance');
		 $id=$this->input->get_post('ledgerid');
		 
        $update =$this->Onlinemodel->update_accountledger($id,$data);
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
                 
          $data['accountledger']=$this->Onlinemodel->getaccountledger();
          $data['accountgroup']=$this->Onlinemodel->getaccountgroup();
		$data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();


                                                        $this->load->view('header');
	                                                	$this->load->view('AccountLedger',$data);
		                                                $this->load->view('footer');
                      

                           	                          
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
                      
          $data['accountledger']=$this->Onlinemodel->getaccountledger();
          $data['accountgroup']=$this->Onlinemodel->getaccountgroup();
		$data['FiilTableAccountledger']=$this->Onlinemodel->FiilTableAccountledger();
                                                        $this->load->view('header');
	                                                	$this->load->view('AccountLedger',$data);
		                                                $this->load->view('footer');
                      
                           

	}
		

	//AccountLedger_End
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
	$data=array();
	$data['voch']=$this->Onlinemodel->getvoucher();
	$this->load->view('header');
	$this->load->view('editpurchase',$data);
	$this->load->view('footer');
}
public function viewpur()
{
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
			       $data['branch']=$this->Onlinemodel->getBranch();

	$vouch=$this->input->get_post('voucher');
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


	//SalesInvoice_Start

	public function salesinvoice()
	{
		if( $this->session->userdata('name'))
    	 {
		$data=array();
		$data['product']=$this->Onlinemodel->getproduct();
		$data['branch']=$this->Onlinemodel->getBranch();
		$data['batch']=$this->Onlinemodel->getbatch();
		$data['invoiceno']=$this->Onlinemodel->Autogenerate_InvoiceNo();
		$data['customer']=$this->Onlinemodel->getcustomer();
			       $data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
			       $data['master']=$this->Onlinemodel->getsalesmaster();
			       $data['branch']=$this->Onlinemodel->getBranch();
		
		$this->load->view('header');
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

	public function insert_salesinvoice()
	{ 
		$action=$this->input->get_post('btnsave');
		$data=array();
		$data1=array();
		$data['invoiceno']=$this->input->get_post('invoiceno');
		$data['customer']=$this->input->get_post('customer');
		$data['salesorderno']=$this->input->get_post('salesorderno');
		
		$radioValue = $this->input->get_post["Paymentmode"];
		
		if($radioValue == "Cash")
		{
		    $data['paymentmode']="Cash";
		}
		else if ($radioValue == "Credit")
		{
		    $data['paymentmode']="Credit";
		}
		
		
		$data['salesdate']=$this->input->get_post('salesdate');
		$data['totalqty']=$this->input->get_post('totalqty');
		
		$data['totalamount']=$this->input->get_post('totalamount');
		$data['additionalcost']=$this->input->get_post('additionalcost');
		$data['taxamount']=$this->input->get_post('taxamount');
		$data['billdiscount']=$this->input->get_post('billdiscount');

		$data['grandtotal']=$this->input->get_post('grandtotal');
		$data['oldbalance']=$this->input->get_post('oldbalance');
		$data['cashorbank']=$this->input->get_post('cashorbank');
		$data['paidamount']=$this->input->get_post('paidamount');
		$data['balance']=$this->input->get_post('balance');
		$data['narration']=$this->input->get_post('narration');
		$data['transportcompany']=$this->input->get_post('transportcompany');
	

		$value=$data['invoiceno'];
       
         if($action=="Save"){


	                       
	                         	$result=$this->Onlinemodel->insert_salesinvoicemaster($data);
	                         	if ($result==true) {
                           	                           ?> <script type="text/javascript">
	alert('Saved successfully');
</script>
<?php 
                                                   } else {
                           	                         ?> <script type="text/javascript">
	alert('Insertion failed.Please check the inputs');
</script> <?php 
                                                   }
	                         }
	                         
                            
                             
         
		
       $data['invoiceno']=$this->Onlinemodel->Autogenerate_InvoiceNo();
		$data['customer']=$this->Onlinemodel->getcustomer();
		$this->load->view('header');
		$this->load->view('SalesInvoice',$data);
		$this->load->view('footer');
	    

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
		// $a=$this->input->get_post('a');
   // $data = array(
   //              'pdt_name'  => $this->input->post('a'), 
   //              'pdt_code'  => $this->input->post('b'), 
   //              'groupid' => $this->input->post('c'), 
   //              'unitid' => $this->input->post('d'), 
   //              'brandid' => $this->input->post('e'), 
   //              'tax' => $this->input->post('f'), 
   //              'mrp' => $this->input->post('g'), 
   //              'openingstock' => $this->input->post('h'), 
   //              // 'product_price' => $this->input->post('price'), 

   //          );
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

    public function insert_salesinvoicemaster()
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
		 	'cashorbank'=>$this->input->post('cashorbank'),
		 	'paidamount'=>$this->input->post('paidamount'),
		 	'balance'=>$this->input->post('balance'),
		 	'narration'=>$this->input->post('narration'),
		 	// 'transportcompany'=>$this->input->post('transportcompany'),
		 	'branchid'=>$this->input->post('branchid')
		 	);		 
		  $dat=$this->Onlinemodel->insert_salesinvoicemaster($data);
    
            $sales=$this->input->post('totalamount');
            $taxamount=$this->input->post('taxamount');
            $cost=$this->input->post('grandtotal');
            // $amount=$this->Onlinemodel->salesaccount($sales,$taxamount,$cost);
		   // $data=$this->Onlinemodel->save_product($data);
        echo json_encode($dat);
	}


	public function insert_salesinvoicedetails()
	{
		 $data=array(

		 'invoiceno'=>$this->input->post('invoiceno'),
		 'salesdate'=>$this->input->post('salesdate'),
		 'productname'=>$this->input->post('productname'),
		 	'productcode'=>$this->input->post('productcode'),
		 	'qty'=>$this->input->post('qty'),
		 	'unitprice'=>$this->input->post('unitprice'),
		 	'netamount'=>$this->input->post('netamount'),
		 	'tax'=>$this->input->post('tax'),
		 	'taxamount'=>$this->input->post('taxamount'),
		 	'amount'=>$this->input->post('amount'),
		 	'branchid'=>$this->input->post('branchid'),
		 	
		 	);		 
		  $data=$this->Onlinemodel->insert_salesinvoicedetails($data);
		  $branch=$this->input->post('branchid');
		  $product=$this->input->post('productcode');
		  $qty=$this->input->post('qty');
		  $stock=$this->Onlinemodel->sales_stock($product,$qty,$branch);

        echo json_encode($data);
	}       


	//SalesInvoice_End

   

//Customer_Start

	public function customer()
	{
		if( $this->session->userdata('name'))
    	 {
		$data=array();
		$data['customer']=$this->Onlinemodel->getcustomer();
		$this->load->view('header');
		$this->load->view('customer',$data);
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
public function insert_customer()
          {
          	$action=$this->input->get_post('btnsave');
	         
	         	 $data=array();

			       $data['customername']=$this->input->get_post('customername');
			       $data['customercode']=$this->input->get_post('customercode');
			       $data['address']=$this->input->get_post('address');
			       $data['email']=$this->input->get_post('email');
			       $data['phonenumber']=$this->input->get_post('phonenumber');
			       $data['website']=$this->input->get_post('website');
			       $data['state']=$this->input->get_post('state');
			       $data['country']=$this->input->get_post('country');
			       $data['vatno']=$this->input->get_post('vatno');
			       $data['openingbalance']=$this->input->get_post('openingbalance');
			       $data['customerbalance']=$this->input->get_post('openingbalance');
			      
			       
			       $data['branchid']='1';

			    if($action=="Save")
			    {   
	               $value=$data['customername'];

	                       $existence=$this->Onlinemodel->checkexistence_customer($value);
		                          if($existence==0)
		                          {    //Ledger Insertion_start
		                         			$data2=array();
		                         			$data2['ledgername']=$data['customername'];
		                         			$data2['accountgroup']='17';
										       $data2['interestcalculation']=0;
										       $data2['openingbalance']=$this->input->get_post('openingbalance');
										       $data2['creditordebit']='Dr';
										       $data2['narration']='Autogenerated for Customer';
										       $data2['currentbalance']=$this->input->get_post('openingbalance');
								               $value2=$data2['ledgername'];

		                         			$result=$this->Onlinemodel->insert_accountledger($data2);
		                         			
		                          		 $data['customeraccount']=$result;
		                         		if ($result==true) 
		                         		{
		                         			$ledgervalues=$this->Onlinemodel->insert_customer($data);
		                         			// echo 'ledgersuccess';
		                         			if($ledgervalues!=true)
		                         			{
																		 ?>
<script type="text/javascript">
	alert('Error in Ledger creation........');
</script>
<?php 
		                         			}

		                         			//Ledger Insertion_End
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
		                         
	                            else {
	                           	?>
<script type="text/javascript">
	alert('Customer name already exists!!!. please use another name');
</script> <?php 
	                           }
		         }
		         elseif($action=="Update")
		         {
		         	// $value=$data['customername'];

	           //             $existence=$this->Onlinemodel->checkexistence_customer($value);
		          //                 if($existence==0)
		          //                 {    //Ledger Insertion_start
		                         			$data2=array();
		                         			$data2['ledgername']=$data['customername'];
		                         			
										      
										       $data2['openingbalance']=$this->input->get_post('openingbalance');
										     
										       
										       $id=$this->input->get_post('customerid');
								               $value2=$data2['ledgername'];
								               $data3=array();
                                            $data3=$this->Onlinemodel->Select_customerledger($id);
                                            $ledgerid=$data3['customeraccount'];
		                         			$result=$this->Onlinemodel->update_accountledger($ledgerid,$data2);
                       if($result){
		         		                $id=$this->input->get_post('customerid');
				 
		        		               $update =$this->Onlinemodel->update_customer($data,$id);
				          if ($update==true) 
				          {

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



	//Customer_End


          //SalesReport_Start

          public function SalesReport()
			{if( $this->session->userdata('name'))
    	 {

				$data=array();

				$fromdate=$this->input->get_post('fromdate');
				$todate=$this->input->get_post('todate');
				$SearchBy=$this->input->get_post('searchby');
				$supplier=$this->input->get_post('supplier');
				$productname=$this->input->get_post('productname');
				$brand=$this->input->get_post('brandname');
				// echo $productname;
				echo $supplier;
				

					if($SearchBy=="Supplier-wise")
					{
						$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_Supplierwise($fromdate,
							$todate,$supplier);
					}
					else if($SearchBy=="Product-wise")
					{
						$data['SalesDetails']=$this->Onlinemodel->LoadSalesdetails_ProductNamewise($fromdate,
							$todate,$productname);
					}
					else if($SearchBy=="Brand-wise")
					{
						$data['SalesDetails']=$this->Onlinemodel->Loadsalesdetails_Brandwise($fromdate,$todate,
							$brand);
					}
					else
					{
						$data['SalesDetails']=$this->Onlinemodel->LoadSalesDetails_All($fromdate,$todate);
					}
				

				$data['supplier']=$this->Onlinemodel->getsupplier();
				$data['productname']=$this->Onlinemodel->FillProduct();
				$data['brand']=$this->Onlinemodel->getbrand();
				$this->load->view('header');
				$this->load->view('SalesReport',$data);
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

          //SalesReport_End

//ReceiptVoucher_start
	public function receiptvoucher()
    {
    	if( $this->session->userdata('name'))
    	 {
    	$data=array();
    	$data["voucherno"]=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();
    	$data['customer']=$this->Onlinemodel->getcustomer();
		$data['getreceiptvoucher']=$this->Onlinemodel->getreceiptvoucher();
		$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();


        $this->load->view('header');
        $this->load->view('ReceiptVoucher',$data);
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

    public function insert_receiptvoucher()
          {
          	$action=$this->input->get_post('btnsave');
	         	 $data=array();

			       $data['voucherno']=$this->input->get_post('voucherno');
			       $data['customerid']=$this->input->get_post('customer');
			      
			       $data['amount']=$this->input->get_post('amount');
			       $customerbalance=$this->input->get_post('customerbalance');
			       $data['currentbalance']=$customerbalance-$data['amount'];
			       $data['receiptdate']=$this->input->get_post('receiptdate');
			       $data['cashorbank']=$this->input->get_post('cashorbank');
			      
			       $data['branchid']='1';

			    if($action=="Save")
			    {   
	               $value=$data['voucherno'];

	                       $existence=$this->Onlinemodel->checkexistence_receiptvoucherno($value);
		                          if($existence==0)
		                          {
		                          		$result=$this->Onlinemodel->insert_ReceiptVoucher($data);
		                         		if ($result==true)
		                         		 {
		                         		 	//1)Update customerbalance in AccountLedger_Start

		                         		 	//Fetching customeraccount name using customerid
		                         		 	$customerid= $data['customerid'];
		                         		 	$data['records']=$this->Onlinemodel->Select_customerledger($customerid);
		                         		 	$cashorbank= $data['cashorbank'];

		                         		 	
		                         		 	$ledgername=$data['records']['customeraccount'];

		                         		 	$amount=$data['amount'];
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
		                         		 	if ($result2==false)
		                         		 	{
		                         		 		 ?> <script type="text/javascript">
	alert('Failed updation in ledgerbalance........');
</script>
<?php
		                         		 	}

		                         		 	//Update customerbalance in AccountLedger_End

		                         		 	//2)Inserting into Daybook_Start

		                         		 	//Selecting previous balance from daybook
		                         		 	$cashorbank=$data['cashorbank'];
		                         		 	$data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
		                         		 	// //echo $data['records2']['accountgroup'];
		                         		 	// $accountgroupid=$data['records2']['accountgroup'];
		                         		 	// $Daybook_currentbalance=0;
		                         		 	// if($accountgroupid==18)
		                         		 	// {
		                         		 	// 	$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousCashBalance();
		                         		 	// 	echo $data['balance']['cashbalance'];
		                         		 	// 	$Daybook_currentbalance=$data['balance']
		                         		 	// 	['cashbalance'];
		                         		 	// }
		                         		 	// else if($accountgroupid==19)
		                         		 	// {
		                         		 	// 	$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousBankBalance();
		                         		 	// 	echo $data['balance']['bankbalance'];
		                         		 	// 	$Daybook_currentbalance=$data['balance']
		                         		 	// 	['bankbalance'];
		                         		 	// }
		                         		 	
		                         		 	$data2=array();	
		                         		 	$data2['invoiceno']=$data['voucherno'];
		                         		 	$data2['accountType']='Receipt Voucher_save';
		                         		 	$data2['date']=$data['receiptdate'];
		                         		 	$data2['ledgername']=$ledgername;
		                         		 	$data2['userid']=$this->session->userdata('user');
		                         		 	// $data2['taxableamount']=0;
		                         		 	// $data2['tax']=0;
		                         		 	$data2['debit']=0;
		                         		 	$data2['credit']=$data['amount'];

		                         		 	
		                         		 	$result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	$data2['ledgername']=$cashorbank;
		                         		 	// $data2['taxableamount']=0;
		                         		 	// $data2['tax']=0;
		                         		 	$data2['debit']=$data['amount'];
		                         		 	$data2['credit']=0;
                                              $result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	if($result3==false)
		                         		 	{
 												?> <script type="text/javascript">
	alert('Failed Daybook insertion........');
</script>
<?php 
		                         		 	}

		                         		 	//Inserting into daybook_End

		                         		 	//Update "customerbalance" in table customer_Start
		                         		 	$amount=$data['amount'];
		                         		 	// $result4=$this->Onlinemodel->update_customerbalancefromReceiptVoucher($customerid,$amount);
		                         		 	if ($result2==false)
		                         		 	{
		                         		 		 ?> <script type="text/javascript">
	alert('Failed updation in customerbalance........');
</script>
<?php
		                         		 	}

		                         		 	//Update "customerbalance" in table customer_End

	                           	                           ?> <script type="text/javascript">
	alert('Saved successfully........');
</script>
<?php 
	                                                   } else {
	                           	                         ?> <script type="text/javascript">
	alert('Insertion failed. please check the inputs!!!');
</script> <?php 
		                         		 	}
		                         		 }
	                                    
		                         
	                            else
	                           {
	                           	?>
<script type="text/javascript">
	alert('Voucher No already exists!!!. please use another number');
</script> <?php 
	                           }
		         }

				$data["voucherno"]=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();                
				$data['customer']=$this->Onlinemodel->getcustomer();
				$data['getreceiptvoucher']=$this->Onlinemodel->getreceiptvoucher();
				$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();

				$this->load->view('header');
				$this->load->view('ReceiptVoucher',$data);
				$this->load->view('footer');
          }

          public function delete_receiptvoucher()
          {
          	$id=$this->input->get_post('receiptvoucherid');
          	$this->load->model('Onlinemodel');
          	$delete=$this->Onlinemodel->delete_receiptvoucher($id);
          	if($delete)
          	{
          		//Update customerbalance in AccountLedger_Start

		                         		 	//Fetching customeraccount name using customerid
          		$data=array();
		                         		 	$customerid= $this->input->get_post('customer');
		                         		 	$data['records']=$this->Onlinemodel->Select_customerledger($customerid);
		                         		 	

		                         		 	
		                         		 	$ledgername=$data['records']['customeraccount'];
		                         		 	$amount=$this->input->get_post('amount');
		                         		 	$cashorbank=$this->input->get_post('cashorbank');
		                         		 	$amount=$amount*-1;
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($ledgername,$amount);
		                         		 	$result2=$this->Onlinemodel->update_customerledgerbalance($cashorbank,$amount*-1);
		                         		 	if ($result2==false)
		                         		 	{
		                         		 		 ?> <script type="text/javascript">
	alert('Failed updation in ledgerbalance........');
</script>
<?php # code...
		                         		 	}

		                         		 	//Update customerbalance in AccountLedger_End


		                         		 	//Inserting into Daybook_Start

		                         		 	//Selecting previous balance from daybook
		                         		 	$cashorbank=$this->input->get_post('cashorbank');
		                         		 	// $data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
		                         		 	//echo $data['records2']['accountgroup'];
		                         		 	// $accountgroupid=$data['records2']['accountgroup'];
		                         		 	// $Daybook_currentbalance=0;
		                         		 	// if($accountgroupid==18)
		                         		 	// {
		                         		 	// 	$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousCashBalance();
		                         		 	// 	echo $data['balance']['cashbalance'];
		                         		 	// 	$Daybook_currentbalance=$data['balance']
		                         		 	// 	['cashbalance'];
		                         		 	// }
		                         		 	// else if($accountgroupid==19)
		                         		 	// {
		                         		 	// 	$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousBankBalance();
		                         		 	// 	echo $data['balance']['bankbalance'];
		                         		 	// 	$Daybook_currentbalance=$data['balance']
		                         		 	// 	['bankbalance'];
		                         		 	// }
		                         		 	
		                         		 	$data2=array();	
		                         		 	$data2['invoiceno']=$this->input->get_post('voucherno');
		                         		 	$data2['accountType']='Receipt Voucher_Delete';
		                         		 	$data2['date']=$this->input->get_post('receiptdate');
		                         		 	$data2['ledgername']=$ledgername;
		                         		 	
		                         		 	$data2['debit']=($this->input->get_post('amount'));
		                         		 	
		                         		 	$data2['credit']=0;

		                         		 
		                         		 	$result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	$data2['ledgername']=$cashorbank;
		                         		 	
		                         		 	$data2['debit']=0;
		                         		 	
		                         		 	$data2['credit']=($this->input->get_post('amount'));;
		                         		 	$result3=$this->Onlinemodel->insert_daybook($data2);
		                         		 	if($result3==false)
		                         		 	{
 												?> <script type="text/javascript">
	alert('Failed Daybook insertion........');
</script>
<?php 
		                         		 	}

		                         		 	//Inserting into daybook_End

		                         		 	//Update "customerbalance" in table customer_Start
		                         		 
		                         		 	
		                         		 	if ($result2==false)
		                         		 	{
		                         		 		 ?> <script type="text/javascript">
	alert('Failed updation in customerbalance........');
</script>
<?php
		                         		 	}

		                         		 	//Update "customerbalance" in table customer_End


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

          	$data["voucherno"]=$this->Onlinemodel->Autogenerate_ReceiptVoucherNo();                
			$data['customer']=$this->Onlinemodel->getcustomer();
			$data['getreceiptvoucher']=$this->Onlinemodel->getreceiptvoucher();
			$data['BankAndcashLedgers']=$this->Onlinemodel->FillBankAndCashLedgers();
			$this->load->view('header');
			$this->load->view('ReceiptVoucher',$data);
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

public function Autogenerate_PurchaseVoucherNo()
	{
		$data=$this->Onlinemodel->Autogenerate_PurchaseVoucherNo();
		echo json_encode($data);

	}
	public function Autogenerate_journalVoucherNo()
	{
		$data=$this->Onlinemodel->Autogenerate_Journal_VoucherNo1();
		
		echo json_encode($data);

	}
	
	//PurchaseInvoice_DyaBook_Insertion_Start

	public function PurchaseInvoice_DyaBookInsertion()
	{
		//2)Inserting into Daybook_Start
		$data=array();
		                         		 	//Selecting previous balance from daybook
		                         		 	$cashorbank=$this->input->post('cashorbank');
		                         		 	$data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
		                         		 	//echo $data['records2']['accountgroup'];
		                         		 	$accountgroupid=$data['records2']['accountgroup'];
		                         		 	$Daybook_currentbalance=0;
		                         		 	if($accountgroupid==18)//Cash A/C
		                         		 	{
		                         		 		$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousCashBalance();
		                         		 		echo $data['balance']['cashbalance'];
		                         		 		$Daybook_currentbalance=$data['balance']
		                         		 		['cashbalance'];
		                         		 	}
		                         		 	else if($accountgroupid==19)//Bank A/C
		                         		 	{
		                         		 		$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousBankBalance();
		                         		 		echo $data['balance']['bankbalance'];
		                         		 		$Daybook_currentbalance=$data['balance']
		                         		 		['bankbalance'];
		                         		 	}
		                         		 	
		                         		 	$data2=array();	
		                         		 	// $PAYMENTMODE=$this->input->post('paymentmode');
		                         		 	// if($PAYMENTMODE=="Cash")
		                         		 	// {
		                         		 	// 	$data2['invoiceno']=$this->input->post('voucherno');
			                         		 // 	$data2['accountType']='Purchase Invoice';
			                         		 // 	$data2['date']=$this->input->post('date');
			                         		 // 	$data2['ledgername']='';
			                         		 // 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 // 	$data2['tax']=$this->input->post('tax');
			                         		 // 	$data2['debit']=0;
			                         		 // 	$data2['credit']=$this->input->post('paidamount');
		                         		 	// }
		                         		 	// else if($PAYMENTMODE=="Credit")
		                         		 	// {
		                         		 	// 	$data2['invoiceno']=$this->input->post('voucherno');
			                         		 // 	$data2['accountType']='Purchase Invoice';
			                         		 // 	$data2['date']=$this->input->post('date');
			                         		 // 	$data2['ledgername']=$this->input->post('cashorbank');;
			                         		 // 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 // 	$data2['tax']=$this->input->post('tax');
			                         		 // 	$data2['debit']=0;
			                         		 // 	$data2['credit']=0;
		                         		 	// }

		                         		 		$data2['invoiceno']=$this->input->post('voucherno');
			                         		 	$data2['accountType']='Purchase Invoice';
			                         		 	$data2['date']=$this->input->post('date');
			                         		 	$data2['ledgername']='';
			                         		 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 	$data2['tax']=$this->input->post('tax');
			                         		 	$data2['debit']=0;
			                         		 	$data2['credit']=$this->input->post('paidamount');

		                         		 	if($accountgroupid==18)
		                         		 	{
		                         		 		$data2['cashbalance']=$Daybook_currentbalance-$data2['credit'];
		                         		 		$data2['bankbalance']=0;
		                         		 	}
		                         		 	else if($accountgroupid==19)
		                         		 	{
		                         		 		$data2['cashbalance']=0;
		                         		 		$data2['bankbalance']=$Daybook_currentbalance-$data2['credit'];
		                         		 	}
		                         		 	$data2=$this->Onlinemodel->insert_daybook($data2);
		                         		 	
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

	//PurchaseInvoice_DyaBook_Insertion_End
	
	public function Autofill_Productdetails_byName()
	{  
		 $this->load->model('Onlinemodel');
        $name= $this->input->post('b');
        $data=$this->Onlinemodel->Autofill_Productdetails_byName($name);
        
        echo json_encode($data);
       
    
	}
	
	public function Autofill_New()
	{  
		 $this->load->model('Onlinemodel');
        $code  = $this->input->post('b');
        $data=$this->Onlinemodel->Autofill_Productdetails_TEST_new($code);
        
        echo json_encode($data);
	}

	
		//PurchaseInvoice_DyaBook_Insertion_Start

	public function SalesInvoice_DyaBookInsertion()
	{
		//2)Inserting into Daybook_Start
		$data=array();
		                         		 	//Selecting previous balance from daybook
		                         		 	$cashorbank=$this->input->post('cashorbank');
		                         		 	$data['records2']=$this->Onlinemodel->selectAccountGroup($cashorbank);
		                         		 	//echo $data['records2']['accountgroup'];
		                         		 	$accountgroupid=$data['records2']['accountgroup'];
		                         		 	$Daybook_currentbalance=0;
		                         		 	if($accountgroupid==18)//Cash A/C
		                         		 	{
		                         		 		$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousCashBalance();
		                         		 		echo $data['balance']['cashbalance'];
		                         		 		$Daybook_currentbalance=$data['balance']
		                         		 		['cashbalance'];
		                         		 	}
		                         		 	else if($accountgroupid==19)//Bank A/C
		                         		 	{
		                         		 		$data['balance']=$this->Onlinemodel->Daybook_SelectPreviousBankBalance();
		                         		 		echo $data['balance']['bankbalance'];
		                         		 		$Daybook_currentbalance=$data['balance']
		                         		 		['bankbalance'];
		                         		 	}
		                         		 	
		                         		 	$data2=array();	
		                         		 	// $PAYMENTMODE=$this->input->post('paymentmode');
		                         		 	// if($PAYMENTMODE=="Cash")
		                         		 	// {
		                         		 	// 	$data2['invoiceno']=$this->input->post('voucherno');
			                         		 // 	$data2['accountType']='Purchase Invoice';
			                         		 // 	$data2['date']=$this->input->post('date');
			                         		 // 	$data2['ledgername']='';
			                         		 // 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 // 	$data2['tax']=$this->input->post('tax');
			                         		 // 	$data2['debit']=0;
			                         		 // 	$data2['credit']=$this->input->post('paidamount');
		                         		 	// }
		                         		 	// else if($PAYMENTMODE=="Credit")
		                         		 	// {
		                         		 	// 	$data2['invoiceno']=$this->input->post('voucherno');
			                         		 // 	$data2['accountType']='Purchase Invoice';
			                         		 // 	$data2['date']=$this->input->post('date');
			                         		 // 	$data2['ledgername']=$this->input->post('cashorbank');;
			                         		 // 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 // 	$data2['tax']=$this->input->post('tax');
			                         		 // 	$data2['debit']=0;
			                         		 // 	$data2['credit']=0;
		                         		 	// }

		                         		 		$data2['invoiceno']=$this->input->post('voucherno');
			                         		 	$data2['accountType']='Purchase Invoice';
			                         		 	$data2['date']=$this->input->post('date');
			                         		 	$data2['ledgername']='';
			                         		 	$data2['taxableamount']=$this->input->post('totalamount');
			                         		 	$data2['tax']=$this->input->post('tax');
			                         		 	$data2['debit']=0;
			                         		 	$data2['credit']=$this->input->post('paidamount');

		                         		 	if($accountgroupid==18)
		                         		 	{
		                         		 		$data2['cashbalance']=$Daybook_currentbalance-$data2['credit'];
		                         		 		$data2['bankbalance']=0;
		                         		 	}
		                         		 	else if($accountgroupid==19)
		                         		 	{
		                         		 		$data2['cashbalance']=0;
		                         		 		$data2['bankbalance']=$Daybook_currentbalance-$data2['credit'];
		                         		 	}
		                         		 	$data2=$this->Onlinemodel->insert_daybook($data2);
		                         		 	
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
}
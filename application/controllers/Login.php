<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct() {
        parent::__construct();
    }
	public function index()
	{
		$this->load->view('login');
	}
	public function reg(){
		$this->load->view('register');

	}
	public function home(){
		$this->load->model('loginmodel');
		$data['table']=$this->loginmodel->table();
		$this->load->view('home',$data);

	}
	
	public function forgot(){
		$this->load->view('forgot');

	}
	public function insert(){
		$data=array();

$data['username']=$this->input->get_post('username');
$data['email']=$this->input->get_post('email');
$data['pswd']=$this->input->get_post('password');
$data['retype_psw']=$this->input->get_post('rpsw');
$this->load->model('loginmodel');
$insert=$this->loginmodel->insert($data);
if ($insert) {
	?> <script type="text/javascript"> alert ('registration successfull');
	document.location.href="http://localhost/codeigniter/index.php/Login/index"
	             </script> <?php

	# code...
}


	}
	public function login() {
		$data=array();
		$data['email']=$this->input->get_post('email');
        $data['pswd']=$this->input->get_post('password');
        $this->load->model('loginmodel');
        $login=$this->loginmodel->login($data);
            if ($login) {
            	$data['table']=$this->loginmodel->table();

            	$this->load->view('home',$data);

            }
            else{
            	?> <script type="text/javascript"> alert ('invalid username/password');
            	document.location.href="http://localhost/codeigniter/index.php/Login/index"</script><?php

            }

        


	}
	public function show(){
		$id=$this->input->get_post('userid');
		$this->load->model('loginmodel');
		$data['table']=$this->loginmodel->getbyid($id);
		$this->load->view('update',$data);


	}
	public function update(){
		$id=$this->input->get_post('userid');
		$data=array();
		$data['username']=$this->input->get_post('username');
        $data['email']=$this->input->get_post('email');
        $data['pswd']=$this->input->get_post('password');
        $data['retype_psw']=$this->input->get_post('rpsw');
        $this->load->model('loginmodel');
        $result=$this->loginmodel->update($id,$data);
        if($result){
        ?> <script type="text/javascript"> alert ('updation successfull');
	document.location.href="http://localhost/codeigniter/index.php/Login/home"
	             </script> <?php
	         }

	}

	public function delete(){
		$id=$this->input->get_post('userid');
		$this->load->model('loginmodel');
		$result=$this->loginmodel->delete($id);
		if($result){
        ?> <script type="text/javascript"> alert ('deletion successfull');
	document.location.href="http://localhost/codeigniter/index.php/Login/home"
	             </script> <?php
	         }
	         
		$data['table']=$this->loginmodel->table();
		$this->load->view('home',$data);


	}
}


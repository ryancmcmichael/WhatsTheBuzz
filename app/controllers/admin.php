<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class admin extends CI_Controller {

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
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->view('admin/admin');
    }
    public function exportemail()
    {
        $this->load->view('admin/exportemail');
    }
    public function addLogo()
    {
        $this->load->view('admin/addlogo');
    }
    public function coupon()
    {
        $this->load->view('admin/coupon');
    }
    public function reportSummary()
    {
        $this->load->view('admin/reportsummary');
    }
    public function graphs()
    {
        $this->load->view('admin/graphs');
    }
    public function settings()
    {
        $this->load->view('admin/settings');
    }
    public function report($which=0)
    {
        //	Report type will be coded
        //	1 = full summary (Active only at 10.22.2016
        //	2 = By Date (next to code)
        //	3 = By Server (next to code)

        $data['which'] = $which;
        $this->load->view('admin/report',$data);
    }
    public function password()
    {
        $this->load->view('admin/password');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
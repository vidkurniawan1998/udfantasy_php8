<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'vendor/autoload.php';
use Mpdf\Mpdf;
class Print_pdf extends Mpdf
{
    public $filename;
    public $formatPage;
    public $orientationPage;
    public function __construct()
    {
        parent::__construct(array('mode' => 'utf-8', 'tempDir' => FCPATH.'/upload/images', 'format' => 'A4-L'));
        $this->filename = "laporan.pdf";
    }

    protected function ci()
    {
        return get_instance();
    }

    public function load_view($view, $data = array())
    {
//        error_reporting(E_ALL);
//        ini_set('display_errors', true);

        $html = $this->ci()->load->view('admins/'.$view, $data, true);

        $this->showImageErrors = true;
        $this->setTitle('Checkout '. $data['checkout']->invoice);
        $this->setAuthor('RedSystem');
        $this->WriteHTML($html);
        $this->Output();
    }
}
<?php
class Firma_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function firmadb()
    {
        return $this->load->database('firma', TRUE);
    }
    public $musteriTablosu = "TBLCASABIT";
    public $stokTablosu = "TBLSTSABIT";
    public function musteri_bilgileri($aranacak,$ara){
        return $this->firmadb()->like($aranacak,$ara)->get($this->musteriTablosu)->result();
    }
    public function stok($aranacak,$ara){
        return $this->firmadb()->like($aranacak,$ara)->get($this->stokTablosu)->result();
    }
}
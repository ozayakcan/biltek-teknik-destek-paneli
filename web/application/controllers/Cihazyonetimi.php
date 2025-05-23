<?php
require_once("Varsayilancontroller.php");

class Cihazyonetimi extends Varsayilancontroller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model("Ayarlar_Model");
	}

	public function index()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$this->load->model("Islemler_Model");
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Anasayfa", "cihaz_yonetimi", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari("cikis");
		}
	}
	public function musterileriAktar()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$this->Cihazlar_Model->musterileriAktar();
			redirect(base_url());
		}
	}
	public function yapilanIslemleriAktar()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$this->Cihazlar_Model->yapilanIslemleriAktar();
			redirect(base_url());
		}
	}
	public function bilgisayardaAcGetir($id){
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->bilgisayardaAcGetir($id));
		}
	}
	public function cihazlarJQ($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarJQ($id));
		}
	}
	
	public function tekCihazJQ($id)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->tekCihazJQ($id));
		}
	}
	public function cihazlarTumuJQ()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->cihazlarTumuJQ());
		}
	}
	
    public function cihazlarTumuSayi()
    {
        if ($this->Giris_Model->kullaniciGiris()) {
            echo $this->Cihazlar_Model->cihazlarTumuTablo()->num_rows();
        }else{
            echo 1;
        }
    }
	public function sonCihazJQ()
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			echo json_encode($this->Cihazlar_Model->sonCihazJQ());
		}
	}
	public function cihazEkle($tur)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$ekle = $this->Cihazlar_Model->cihazEkle($tur);
			if(isset($ekle["yonlendir"])){
				redirect($ekle["yonlendir"]);
			}else if($tur == "POST" || $tur == "post"){
				echo json_encode($ekle);
			}else{
				$this->Kullanicilar_Model->girisUyari("", $ekle["mesaj"] );
			}
		} else {
			if($tur == "POST" || $tur == "post"){
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için kullanıcı girişi yapmanız gerekmektedir. Lütfen sayfayı yenileyip tekrar deneyin.", "sonuc" => 0));
			}else{
				$this->Kullanicilar_Model->girisUyari("cikis");
			}
		}
	}
	public function teslimAlanDuzenle($id){
		if ($this->Giris_Model->kullaniciGiris()) {
			
			$alan = $this->input->post('alan');
			$this->Cihazlar_Model->cihazDuzenle($id, array("teslim_alan" => $alan));
			echo json_encode(array("mesaj" => "", "sonuc" => 1));
		} else {
			
		}
	}
	public function cihazSil($id, $tur)
	{
		if ($this->Giris_Model->kullaniciGiris()) {
			$sil = $this->Cihazlar_Model->cihazSil($id);
			$this->Cihazlar_Model->deleteTrigger($id);
			if($tur == "POST" || $tur == "post"){
				if ($sil) {
					echo json_encode(array("mesaj" => "", "sonuc" => 1));
				}else{
					echo json_encode(array("mesaj" => "Silme işlemi gerçekleştirilemedi. " . $this->db->error()["message"], "sonuc" => 0));
				}
			}else{
				if ($sil) {
					redirect(base_url(""));
				} else {
					$this->Kullanicilar_Model->girisUyari("", "Silme işlemi gerçekleştirilemedi");
				}
			}
		} else {
			if($tur == "POST" || $tur == "post"){
				echo json_encode(array("mesaj" => "Bu işlemi gerçekleştirebilmek için kullanıcı girişi yapmanız gerekmektedir. Lütfen sayfayı yenileyip tekrar deneyin.", "sonuc" => 0));
			}else{
				$this->Kullanicilar_Model->girisUyari("cikis");
			}
		}
	}
	public function silinenCihazlariBul()
	{
		echo json_encode($this->Cihazlar_Model->silinenCihazlariBul());
	}
	public function veriGuncellendi(){
		echo json_encode($this->Cihazlar_Model->veriGuncellendi());
	}
}

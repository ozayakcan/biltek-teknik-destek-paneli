<?php
require_once("Varsayilancontroller.php");

class Yonetim extends Varsayilancontroller
{

	public function __construct()
	{
		parent::__construct();
	}
	public function index()
	{
		redirect(base_url());
	}
	public function kullanicilar()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Kullanıcılar", "yonetim/kullanicilar", array("baslik" => "Kullanıcılar"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function personel()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Personel", "yonetim/personel", array("baslik" => "Personel"), "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciEkle($tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"])) {
						$sifre = $veri["sifre"];
						$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
						$ekle = $this->Kullanicilar_Model->ekle($veri);
						if ($ekle) {
							redirect(base_url($this->konum($tur)));
						} else {
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Hesap eklenemedi lütfen daha sonra tekrar deneyin");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciDuzenle($id, $tur = 0)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Kullanicilar_Model->kullaniciPost(true);
			if (strlen($veri["kullanici_adi"]) >= 3) {
				if (strlen($veri["sifre"]) >= 6) {
					if ($this->Kullanicilar_Model->kullaniciAdiKontrol($veri["kullanici_adi"]) || $veri["kullanici_adi"] == $this->input->post("kullanici_adi_orj" . $id)) {
						$kullanici = $this->Kullanicilar_Model->kullaniciListesi($id)[0];
						if ($kullanici->sifre != $veri["sifre"]) {
							$sifre = $veri["sifre"];
							$veri["sifre"] = $this->Islemler_Model->sifrele($sifre);
						}
						$duzenle = $this->Kullanicilar_Model->duzenle($id, $veri);
						if ($duzenle) {
							redirect(base_url($this->konum($tur)));
						} else {
							$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Hesap düzenlenemedi lütfen daha sonra tekrar deneyin");
						}
					} else {
						$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#kullaniciDuzenleModal" . $id, "Bu kullanıcı adı zaten mevcut.");
					}
				} else {
					$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Şifre en az 6 karakter olmalıdır.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur) . "#yeniKullaniciEkleModal", "Kullanıcı adı en az 3 karakter olmalıdır.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function kullaniciSil($id, $tur = 0)
	{

		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Kullanicilar_Model->sil($id);
			if ($sil) {
				redirect(base_url($this->konum($tur)));
			} else {
				$this->Kullanicilar_Model->girisUyari($this->konum($tur), "Hesap silinemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function konum($tur = 0)
	{
		$konum = "yonetim/personel";
		if ($tur == 1) {
			$konum = "yonetim/kullanicilar";
		}
		return $konum;
	}
	public function ayarlar()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Site Ayarları", "yonetim/ayarlar", array("baslik" => "Site Ayarları")));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function env_duzenle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			//$DB_DRIVER = $this->input->post("db_driver");
			//$DB_HOST = $this->input->post("db_host") . "," . $this->input->post("db_port");
			//$TEKNIK_SERVIS_URL = $this->input->post("db_base_url");
			$SITE_BASLIGI = $this->input->post("db_baslik");
			$FIRMA_SITE_URL = $this->input->post("db_anasayfa");
			$TABLO_OGE = $this->input->post("db_tablo_oge");
			//$DB_DATABASE_TS = $this->input->post("db_ts");
			//$DB_DATABASE_F = $this->input->post("db_f");
			//$DB_USERNAME = $this->input->post("db_user");
			//$DB_PASSWORD = $this->input->post("db_pass");
			$path = FCPATH . '.env';
			if (file_exists($path)) {
				$icerik = file_get_contents($path);
				$icerik = str_replace(
					'SITE_BASLIGI="' . getenv("SITE_BASLIGI") . '"',
					'SITE_BASLIGI="' . $SITE_BASLIGI . '"',
					$icerik
				);
				$icerik = str_replace(
					'FIRMA_SITE_URL=' . getenv("FIRMA_SITE_URL"),
					'FIRMA_SITE_URL=' . $FIRMA_SITE_URL,
					$icerik
				);
				$icerik = str_replace(
					'TABLO_OGE=' . getenv("TABLO_OGE"),
					'TABLO_OGE=' . $TABLO_OGE,
					$icerik
				);
				if (file_put_contents($path, $icerik)) {
					redirect(base_url("yonetim/ayarlar"));
				} else {
					$this->Kullanicilar_Model->girisUyari("yonetim/ayarlar", "Ayarlar düzenlenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.");
				}
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/ayarlar", "Ayar dosyası bulunamadı. Lütfen bir README.md dosyasındaki talimatlara göre bir .env dosyası oluşturun.");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function rapor()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Rapor", "yonetim/rapor", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihaz_turleri()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$this->load->view("tasarim", $this->Islemler_Model->tasarimArray("Cihaz Türleri", "yonetim/cihaz_turleri", [], "inc/datatables"));
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruEkle()
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruEkle($veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri#yeniCihazTuruEkleModal", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruDuzenle($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$veri = $this->Cihazlar_Model->cihazTuruPost();
			$ekle = $this->Cihazlar_Model->cihazTuruDuzenle($id, $veri);
			if ($ekle) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri#yeniCihazTuruEkleModal", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
	public function cihazTuruSil($id)
	{
		if ($this->Kullanicilar_Model->yonetici()) {
			$sil = $this->Cihazlar_Model->cihazTuruSil($id);
			if ($sil) {
				redirect(base_url("yonetim/cihaz_turleri"));
			} else {
				$this->Kullanicilar_Model->girisUyari("yonetim/cihaz_turleri", "Cihaz türü eklenemedi lütfen daha sonra tekrar deneyin");
			}
		} else {
			$this->Kullanicilar_Model->girisUyari();
		}
	}
}
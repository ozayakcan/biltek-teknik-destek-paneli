<?php
class Kullanicilar_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function girisUyari($konum = "", $hata = "")
    {
        echo '<script>
        var r = confirm("' . ($hata == "" ? "Bu işlemi gerçekleştirmek için gerekli yetkiniz bulunmuyor!" : $hata) . '");
        if (r == true) {
            window.location.replace("' . base_url($konum) . '");
        }else{
            window.location.replace("' . base_url($konum) . '");
        }</script>';
    }
    public $kullanicilarTablosu = "kullanicilar";

    public function kullaniciTablosu($id = "", $kullanici_adi = "", $ad_soyad = "", $sifre = "", $yonetici = 0)
    {
        return array(
            "id" => $id,
            "kullanici_adi" => $kullanici_adi,
            "ad_soyad" => $ad_soyad,
            "sifre" => $sifre,
            "yonetici" => $yonetici
        );
    }

    public function kullaniciBilgileri()
    {
        if ($this->Giris_Model->kullaniciTanimi()) {
            $kullaniciTablo = $this->db->where("id", $_SESSION["KULLANICI_ID"])->get($this->kullanicilarTablosu);
            if ($kullaniciTablo->num_rows() > 0) {
                $kullanici = $kullaniciTablo->result()[0];
                return $this->kullaniciTablosu($kullanici->id, $kullanici->kullanici_adi, $kullanici->ad_soyad, $kullanici->sifre, $kullanici->yonetici);
            } else {
                return $this->kullaniciTablosu();
            }
        } else {
            return $this->kullaniciTablosu();
        }
    }
    public function yonetici()
    {
        return $this->kullaniciBilgileri()["yonetici"] == 1;
    }
    public function kullaniciListesi($id = "")
    {
        if ($id == "") {
            return $this->db->get($this->kullanicilarTablosu)->result();
        } else {
            return $this->db->where(array("id" => $id))->get($this->kullanicilarTablosu)->result();
        }
    }
    public function kullanicilar($where){
        return $this->db->where($where)->get($this->kullanicilarTablosu)->result();
    }
    public function tekKullanici($id)
    {
        $sonuc = $this->db->where(array("id" => $id))->get($this->kullanicilarTablosu);
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }
    public function tekKullaniciIsım($isim)
    {
        $sonuc = $this->db->where(array("ad_soyad" => $isim))->get($this->kullanicilarTablosu);
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }
    public function tekKullaniciAdi($kullaniciAdi)
    {
        $sonuc = $this->db->where(array("kullanici_adi" => $kullaniciAdi))->get($this->kullanicilarTablosu);
        if ($sonuc->num_rows() > 0) {
            return $sonuc->result()[0];
        } else {
            return null;
        }
    }
    public function ekle($veri)
    {
        return $this->db->insert($this->kullanicilarTablosu, $veri);
    }
    public function duzenle($id, $veri)
    {
        return $this->db->where("id", $id)->update($this->kullanicilarTablosu, $veri);
    }
    public function sil($id)
    {
        return $this->db->where("id", $id)->delete($this->kullanicilarTablosu);
    }

    public function kullaniciPost($yonetici_dahil = false)
    {
        $veri = array(
            "kullanici_adi" => $this->input->post("kullanici_adi"),
            "ad_soyad" => $this->input->post("ad_soyad"),
            "sifre" => $this->input->post("sifre")
        );
        if ($yonetici_dahil) {
            $veri["yonetici"] = $this->input->post("yonetici");
        }
        return $veri;
    }
    public function kullaniciAdiKontrol($kullanici_adi)
    {
        $where = array(
            "kullanici_adi" => $kullanici_adi
        );
        $query = $this->db->where($where)->get($this->kullanicilarTablosu);
        return !($query->num_rows() > 0);
    }
}
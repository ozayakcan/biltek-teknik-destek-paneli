<?php
class Cihazlar_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Islemler_Model");
    }
    public function cihazlarTabloAdi()
    {
        return DB_ON_EK_STR . "cihazlar";
    }
    public function islemlerTabloAdi()
    {
        return DB_ON_EK_STR . "islemler";
    }
    public function cihazTurleriTabloAdi()
    {
        return DB_ON_EK_STR . "cihazturleri";
    }
    public function cihazAcTabloAdi()
    {
        return DB_ON_EK_STR . "cihaz_ac";
    }
    public function cihazDurumlariTabloAdi()
    {
        return DB_ON_EK_STR . "cihazdurumlari";
    }
    public function silinenCihazlarTabloAdi()
    {
        return DB_ON_EK_STR . "silinencihazlar";
    }
    public function medyalarTabloAdi()
    {
        return DB_ON_EK_STR . "medyalar";
    }

    public function tahsilatSekilleriTabloAdi()
    {
        return DB_ON_EK_STR . "tahsilatsekilleri";
    }
    public function guncellemeTabloAdi()
    {
        return DB_ON_EK_STR . "guncelleme";
    }
    public function musterileriAktar()
    {
        $this->load->model("Firma_Model");
        $cihazlar = $this->db->reset_query()->order_by("tarih", "DESC")->group_by("musteri_adi")->get($this->cihazlarTabloAdi())->result();
        foreach ($cihazlar as $cihaz) {
            $this->db->reset_query()->insert($this->Firma_Model->musteriTablosu(), array(
                "musteri_adi" => $cihaz->musteri_adi,
                "adres" => $cihaz->adres,
                "telefon_numarasi" => $cihaz->telefon_numarasi
            ));
            $son_eklenen = $this->db->insert_id();
            $this->db->reset_query()->where("musteri_adi", $cihaz->musteri_adi)->update($this->cihazlarTabloAdi(), array(
                "musteri_kod" => $son_eklenen
            ));
        }
        $this->veriGuncellendiEkle();
    }
    public function yapilanIslemleriAktar()
    {
        $cihazlar = $this->db->reset_query()->order_by("id", "ASC")->get($this->cihazlarTabloAdi())->result();
        foreach ($cihazlar as $cihaz) {
            if (isset($cihaz->i_ad_1)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 1,
                    "ad" => $cihaz->i_ad_1,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_1,
                    "miktar" => $cihaz->i_miktar_1,
                    "kdv" => $cihaz->i_kdv_1
                ));
            }
            if (isset($cihaz->i_ad_2)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 2,
                    "ad" => $cihaz->i_ad_2,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_2,
                    "miktar" => $cihaz->i_miktar_2,
                    "kdv" => $cihaz->i_kdv_2
                ));
            }
            if (isset($cihaz->i_ad_3)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 3,
                    "ad" => $cihaz->i_ad_3,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_3,
                    "miktar" => $cihaz->i_miktar_3,
                    "kdv" => $cihaz->i_kdv_3
                ));
            }
            if (isset($cihaz->i_ad_4)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 4,
                    "ad" => $cihaz->i_ad_4,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_4,
                    "miktar" => $cihaz->i_miktar_4,
                    "kdv" => $cihaz->i_kdv_4
                ));
            }
            if (isset($cihaz->i_ad_5)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 5,
                    "ad" => $cihaz->i_ad_5,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_5,
                    "miktar" => $cihaz->i_miktar_5,
                    "kdv" => $cihaz->i_kdv_5
                ));
            }
            if (isset($cihaz->i_ad_6)) {
                $ekle = $this->db->reset_query()->insert($this->islemlerTabloAdi(), array(
                    "cihaz_id" => $cihaz->id,
                    "islem_sayisi" => 6,
                    "ad" => $cihaz->i_ad_6,
                    "birim_fiyat" => $cihaz->i_birim_fiyat_6,
                    "miktar" => $cihaz->i_miktar_6,
                    "kdv" => $cihaz->i_kdv_6
                ));
            }
        }
        $this->veriGuncellendiEkle();
    }
    public function cihazBul($id)
    {
        return $this->db->reset_query()->where("id", $id)->limit(1)->get($this->cihazlarTabloAdi());
    }
    public function takipNumarasi($takip_numarasi)
    {
        $bul = array(
            "takip_numarasi" => $takip_numarasi,
        );
        return $this->db->reset_query()->where($bul)->limit(1)->get($this->cihazlarTabloAdi());
    }
    public function cihazTuru($tur_id)
    {
        $query = $this->db->reset_query()->where("id", $tur_id)->get($this->cihazTurleriTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->isim;
        } else {
            return "Belirtilmemiş";
        }
    }
    public function cihazTurleri()
    {
        return $this->db->reset_query()->where(array(
            "goster"=> 1,
        ))->order_by("siralama DESC, isim ASC")->get($this->cihazTurleriTabloAdi())->result();
    }
    public function cihazTuruEkle($veri)
    {
        return $this->db->reset_query()->insert($this->cihazTurleriTabloAdi(), $veri);
    }
    public function cihazTuruDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->cihazTurleriTabloAdi(), $veri);
    }
    public function cihazTuruSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->cihazTurleriTabloAdi());
    }
    public function cihazTuruPost()
    {
        $veri = array(
            "isim" => $this->input->post("isim"),
            "sifre" => $this->input->post("sifre"),
        );
        return $veri;
    }
    public function cihazDurumuEkle($veri)
    {
        $siralamaMax = $this->db->reset_query()->select_max('siralama')->get($this->Cihazlar_Model->cihazDurumlariTabloAdi())->result();
        $siralama = 1;
        if (isset($siralamaMax[0]->siralama)) {
            $siralama = $siralamaMax[0]->siralama + 1;
        }
        return $this->db->reset_query()->insert($this->cihazDurumlariTabloAdi(), array_merge($veri, array("siralama" => $siralama)));
    }
    public function cihazDurumuYukariTasi($id)
    {
        $tbl = $this->db->reset_query()->where("id", $id)->get($this->cihazDurumlariTabloAdi());
        if ($tbl->num_rows() > 0) {
            $res = $tbl->result()[0];
            if ($res->siralama > 1) {
                //$bosalt = $this->db->reset_query()->empty_table($this->Cihazlar_Model->cihazDurumlariTabloAdi());
                $oncekiDurum = $this->db->reset_query()->where('siralama', $res->siralama - 1)->get($this->cihazDurumlariTabloAdi())->result()[0];
                $duzenle1 = $this->db->reset_query()->where("id", $oncekiDurum->id)->update($this->cihazDurumlariTabloAdi(), array("siralama" => $oncekiDurum->siralama + 1));
                if (!$duzenle1) {
                    return False;
                }
                $duzenle2 = $this->db->reset_query()->where("id", $res->id)->update($this->cihazDurumlariTabloAdi(), array("siralama" => $res->siralama - 1));
                return $duzenle2;
            } else {
                return False;
            }
        } else {
            return False;
        }
        //return $this->db->reset_query()->where("id", $id)->update($this->cihazDurumlariTabloAdi(), $veri);
    }
    public function cihazDurumuAltaTasi($id)
    {
        $tbl = $this->db->reset_query()->where("id", $id)->get($this->cihazDurumlariTabloAdi());
        if ($tbl->num_rows() > 0) {
            $res = $tbl->result()[0];
            $cihazDurumlari = $this->db->reset_query()->where('id !=', $res->id)->order_by("siralama", "ASC")->get($this->cihazDurumlariTabloAdi())->result();
            if ($res->siralama <= count($cihazDurumlari)) {
                //$bosalt = $this->db->reset_query()->empty_table($this->Cihazlar_Model->cihazDurumlariTabloAdi());
                $sonrakiDurum = $this->db->reset_query()->where('siralama', $res->siralama + 1)->get($this->cihazDurumlariTabloAdi())->result()[0];
                $duzenle1 = $this->db->reset_query()->where("id", $sonrakiDurum->id)->update($this->cihazDurumlariTabloAdi(), array("siralama" => $sonrakiDurum->siralama - 1));
                if (!$duzenle1) {
                    return False;
                }
                $duzenle2 = $this->db->reset_query()->where("id", $res->id)->update($this->cihazDurumlariTabloAdi(), array("siralama" => $res->siralama + 1));
                return $duzenle2;
            } else {
                return False;
            }
        } else {
            return False;
        }
    }
    public function cihazDurumuVarsayilanYap($id)
    {
        $this->db->reset_query()->update($this->cihazDurumlariTabloAdi(), array("varsayilan" => 0));
        return $this->db->reset_query()->where("id", $id)->update($this->cihazDurumlariTabloAdi(), array("varsayilan" => 1));
    }
    public function cihazDurumuDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->cihazDurumlariTabloAdi(), $veri);
    }
    public function cihazDurumuSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->cihazDurumlariTabloAdi());
    }
    public function cihazDurumuPost()
    {
        $veri = array(
            "durum" => $this->input->post("durum"),
            "kilitle" => $this->input->post("kilitle"),
            "renk" => $this->input->post("renk"),
        );
        return $veri;
    }
    public function cihazDurumlari()
    {
        return $this->db->reset_query()->order_by("siralama", "ASC")->get($this->cihazDurumlariTabloAdi())->result();
    }
    public function cihazDurumuBul($id)
    {
        return $this->db->reset_query()->where("id", $id)->get($this->cihazDurumlariTabloAdi());
    }
    public function cihazDurumuKilitle($id)
    {
        $cDurum = $this->cihazDurumuBul($id);
        $kilitle = False;
        if ($cDurum->num_rows() > 0) {
            $kilitle = $cDurum->result()[0]->kilitle == 0 ? False : True;
        }
        return $kilitle;
    }
    public function cihazDurumuIsım($id)
    {
        $cDurum = $this->cihazDurumuBul($id);
        if ($cDurum->num_rows() > 0) {
            return $cDurum->result()[0]->durum;
        }
        return "Belirtilmemiş";
    }
    public function cihazDurumuRenk($id)
    {
        $cDurum = $this->cihazDurumuBul($id);
        if ($cDurum->num_rows() > 0) {
            return $cDurum->result()[0]->renk;
        }
        return "Belirtilmemiş";
    }
    public function tahsilatSekli($tur_id)
    {
        $query = $this->db->reset_query()->where("id", $tur_id)->get($this->tahsilatSekilleriTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->isim;
        } else {
            return "";
        }
    }
    public function tahsilatSekilleri()
    {
        return $this->db->reset_query()->get($this->tahsilatSekilleriTabloAdi())->result();
    }
    public function tahsilatSekliEkle($veri)
    {
        return $this->db->reset_query()->insert($this->tahsilatSekilleriTabloAdi(), $veri);
    }
    public function tahsilatSekliDuzenle($id, $veri)
    {
        return $this->db->reset_query()->where("id", $id)->update($this->tahsilatSekilleriTabloAdi(), $veri);
    }
    public function tahsilatSekliSil($id)
    {
        return $this->db->reset_query()->where("id", $id)->delete($this->tahsilatSekilleriTabloAdi());
    }
    public function tahsilatSekliPost()
    {
        $veri = array(
            "isim" => $this->input->post("isim"),
        );
        return $veri;
    }
    public function cihazVerileriniDonustur($result, $nullariDuzelt = FALSE)
    {
        $this->load->model("Islemler_Model");
        for ($i = 0; $i < count($result); $i++) {
            if(property_exists($result[$i], "cID")){
                $result[$i]->id = $result[$i]->cID;
            }
            $result[$i]->tarih = $this->Islemler_Model->tarihDonustur($result[$i]->tarih);
            $result[$i]->bildirim_tarihi = $this->Islemler_Model->tarihDonustur($result[$i]->bildirim_tarihi);
            $result[$i]->cikis_tarihi = $this->Islemler_Model->tarihDonustur($result[$i]->cikis_tarihi);
            $result[$i]->cihaz_turu_val = $result[$i]->cihaz_turu;
            $result[$i]->cihaz_turu = $this->cihazTuru($result[$i]->cihaz_turu);
            $result[$i]->tahsilat_sekli_val = $result[$i]->tahsilat_sekli;
            $result[$i]->tahsilat_sekli = $this->tahsilatSekli($result[$i]->tahsilat_sekli);
            $sorumlu_per = $this->Kullanicilar_Model->tekKullanici($result[$i]->sorumlu);
            $result[$i]->sorumlu_val = $result[$i]->sorumlu;
            $result[$i]->sorumlu = isset($sorumlu_per) ? $sorumlu_per->ad_soyad : "Atanmamış";
            $result[$i]->islemler = $this->islemleriGetir($result[$i]->id);
            $result[$i]->guncel_durum_text = $this->cihazDurumuIsım($result[$i]->guncel_durum);
            $result[$i]->guncel_durum_renk = $this->cihazDurumuRenk($result[$i]->guncel_durum);
            if ($nullariDuzelt) {
                if ($result[$i]->musteri_kod == null) {
                    $result[$i]->musteri_kod = "0";
                }
                if ($result[$i]->cihaz_sifresi == null) {
                    $result[$i]->cihaz_sifresi = "";
                }
                if ($result[$i]->ariza_aciklamasi == null) {
                    $result[$i]->ariza_aciklamasi = "";
                }
                if ($result[$i]->teslim_alinanlar == null) {
                    $result[$i]->teslim_alinanlar = "";
                }
                if ($result[$i]->yapilan_islem_aciklamasi == null) {
                    $result[$i]->yapilan_islem_aciklamasi = "";
                }
                if ($result[$i]->notlar == null) {
                    $result[$i]->notlar = "";
                }
                if ($result[$i]->bildirim_tarihi == null) {
                    $result[$i]->bildirim_tarihi = "";
                }
                if ($result[$i]->cikis_tarihi == null) {
                    $result[$i]->cikis_tarihi = "";
                }
                if ($result[$i]->i_stok_kod_1 == null) {
                    $result[$i]->i_stok_kod_1 = "";
                }
                if ($result[$i]->i_ad_1 == null) {
                    $result[$i]->i_ad_1 = "";
                }
                if ($result[$i]->i_ad_1 == null) {
                    $result[$i]->i_ad_1 = "";
                }
                if ($result[$i]->i_stok_kod_2 == null) {
                    $result[$i]->i_stok_kod_2 = "";
                }
                if ($result[$i]->i_ad_2 == null) {
                    $result[$i]->i_ad_2 = "";
                }
                if ($result[$i]->i_stok_kod_3 == null) {
                    $result[$i]->i_stok_kod_3 = "";
                }
                if ($result[$i]->i_ad_3 == null) {
                    $result[$i]->i_ad_3 = "";
                }
                if ($result[$i]->i_stok_kod_4 == null) {
                    $result[$i]->i_stok_kod_4 = "";
                }
                if ($result[$i]->i_ad_4 == null) {
                    $result[$i]->i_ad_4 = "";
                }
                if ($result[$i]->i_stok_kod_5 == null) {
                    $result[$i]->i_stok_kod_5 = "";
                }
                if ($result[$i]->i_ad_5 == null) {
                    $result[$i]->i_ad_5 = "";
                }
                if ($result[$i]->i_stok_kod_6 == null) {
                    $result[$i]->i_stok_kod_6 = "";
                }
                if ($result[$i]->i_ad_6 == null) {
                    $result[$i]->i_ad_6 = "";
                }
                if ($result[$i]->i_ad_5 == null) {
                    $result[$i]->i_ad_5 = "";
                }
                if ($result[$i]->i_ad_5 == null) {
                    $result[$i]->i_ad_5 = "";
                }
            }
        }
        return $result;
    }
    public function cihazlar($limit = 0)
    {
        $result = $this->db->reset_query()->order_by("id", "DESC");
        if ($limit > 0) {
            $result = $result->limit($limit);
        }
        $result = $result->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function islemleriGetir($cihazID)
    {
        return $this->db->reset_query()->where("cihaz_id", $cihazID)->order_by("islem_sayisi", "ASC")->get($this->islemlerTabloAdi())->result();
    }
    public function cihazlarTekTur($tur)
    {
        $where = array(
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonel($tur, $limit = 0)
    {
        $where = array(
            "sorumlu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC');
        if ($limit > 0) {
            $result = $result->limit($limit);
        }
        $result = $result->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarJQ($id)
    {
        $where = array(
            "id >" => $id,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function tekCihazJQ($id)
    {
        $where = array(
            "id" => $id,
        );
        $result = $this->db->reset_query()->where($where)->limit(1)->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurJQ($tur, $id)
    {
        $where = array(
            "id >" => $id,
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelJQ($sorumlu_personel, $id)
    {
        $where = array(
            "id >" => $id,
            "sorumlu" => $sorumlu_personel,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTumuJQ($sorumlu = "")
    {
        $result = $this->cihazlarTumuTablo($sorumlu)->result();
        
        //throw new Exception($this->cihazlarTumuSelect($sorumlu)->get_compiled_select());
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTumuTablo($sorumlu = "")
    {   
        
        return $this->cihazlarTumuSelect($sorumlu)->get($this->cihazlarTabloAdi());
    }
    public function cihazlarTumuSelect($sorumlu = ""){
        $spesifik = $this->input->post('spesifik');
        $dondurme = FALSE;
        if(!isset($spesifik)){
            $spesifik = array();
        }else{
            $dondurme = TRUE;
        }
        $limit = $this->input->post("limit");
        $sayfa = $this->input->post("sayfa");
        if(!isset($limit)){
            $limit = "";
        }
        if(!isset($sayfa)){
            $sayfa = "";
        }
        $arama = $this->input->post("arama");
        if(!isset($arama)){
            $arama = "";
        }
        if(count($spesifik) == 0 && $dondurme){
            throw new Exception("Specifik boşsa değer döndürülemez");
        }
        $where = array();
        if ($sorumlu != "") {
            $where["sorumlu"] = $sorumlu;
        }

        $result = $this->db->reset_query();
        $this->load->model("Kullanicilar_Model");
        if(strlen($limit) > 0 && strlen($sayfa) > 0){
            $result = $result->select($this->Kullanicilar_Model->kullanicilarTabloAdi() . ".id as kID, ".$this->Kullanicilar_Model->kullanicilarTabloAdi() . ".ad_soyad as kAdSoyad, ".$this->cihazDurumlariTabloAdi() . ".id as cdID, ".$this->cihazlarTabloAdi().".id as cID, ".$this->cihazlarTabloAdi().".*, ".$this->cihazDurumlariTabloAdi() .".*");
        }else{
            $result = $result->select($this->Kullanicilar_Model->kullanicilarTabloAdi() . ".id as kID, ".$this->Kullanicilar_Model->kullanicilarTabloAdi() . ".ad_soyad as kAdSoyad, ".$this->cihazlarTabloAdi().".*");
        }

        $result = $result->where($where);

        if (count($spesifik) > 0) {
            $result = $result->where_in($this->cihazlarTabloAdi().".id", $spesifik);
        }
        if (strlen($arama) > 0) {
            $result = $result->group_start();
            $result = $result->like("servis_no", $arama);
            $result = $result->or_like("musteri_adi", $arama);
            $result = $result->or_like("cihaz", $arama);
            $result = $result->or_like("cihaz_modeli", $arama);
            $result = $result->or_like($this->Kullanicilar_Model->kullanicilarTabloAdi().".ad_soyad", $arama);
            $result = $result->group_end();
        }

        $orderIsim = $this->input->post("orderIsim");
        if(!isset($orderIsim)){
            $orderIsim = "";
        }

        $orderDurum = $this->input->post("orderDurum");
        if(!isset($orderDurum)){
            $orderDurum = "";
        }
        
        $durumSpec = $this->input->post("durumSpec");
        if(!isset($durumSpec)){
            $durumSpec = "";
        }
        if(strlen($durumSpec) > 0){
            $result = $result->where("guncel_durum", $durumSpec);
        }
        $turSpec = $this->input->post("turSpec");
        if(!isset($turSpec)){
            $turSpec = "";
        }
        if(strlen($turSpec) > 0){
            $result = $result->where("cihaz_turu", $turSpec);
        }
        
        if(strlen($orderIsim) > 0){
            switch ($orderIsim) {
                case 'Servis No':
                    $orderIsim = "servis_no";
                    break;
                case 'Müşteri Adı':
                    $orderIsim = "musteri_adi";
                    break;
                case 'GSM':
                    $orderIsim = "telefon_numarasi";
                    break;
                case 'Tür':
                    $orderIsim = "cihaz_turu";
                    break;
                case 'Cihaz':
                    $orderIsim = "cihaz";
                    break;
                case 'Giriş Tarihi':
                    $orderIsim = "tarih";
                    break;
                case 'Güncel Durum':
                    $orderIsim = "guncel_durum";
                    break;
                case 'Sorumlu Personel':
                    $orderIsim = "sorumlu";
                    break;
                
                default:
                    $orderIsim = "";
                    $orderDurum = "";
            }
        }
        $orderText = $this->cihazlarTabloAdi().".id DESC";
        
        $result = $result->join($this->Kullanicilar_Model->kullanicilarTabloAdi(), $this->cihazlarTabloAdi() . ".sorumlu = " . $this->Kullanicilar_Model->kullanicilarTabloAdi() . ".id", "left");
        if(strlen($limit) > 0 && strlen($sayfa) > 0){
            
            $result = $result->join($this->cihazDurumlariTabloAdi(), $this->cihazlarTabloAdi() . ".guncel_durum = " . $this->cihazDurumlariTabloAdi() . ".id");
            if(strlen($orderIsim) > 0 && strlen($orderDurum)){
                if($orderIsim == "cihaz"){
                    $orderText = $this->cihazlarTabloAdi() . ".".$orderIsim." ".$orderDurum.", ". $this->cihazlarTabloAdi() . ".cihaz_modeli ".$orderDurum;
                }else if($orderIsim == "guncel_durum"){
                    $orderText = $this->cihazDurumlariTabloAdi() . ".siralama ".$orderDurum;
                }else{
                    $orderText = $this->cihazlarTabloAdi() . ".".$orderIsim." ".$orderDurum;
                }
            }
            else{
                $orderText = $this->cihazDurumlariTabloAdi() . ".siralama ASC, " . $this->cihazlarTabloAdi() . ".tarih DESC";
            }
            
            $result = $result->order_by($orderText);
            $result = $result->limit($limit, ($sayfa - 1) * $limit);
        }else{
            $result = $result->order_by($this->cihazlarTabloAdi().".id", "DESC");
        }
        return $result;
    }
    public function cihazlarTumuApp($sorumlu = "", $spesifik = array(), $sira = 0, $limit = 50, $arama = "")
    {
        // $spesifik =  Görünen cihaz idleri.
        $where = array();
        if ($sorumlu != "") {
            $where[$this->cihazlarTabloAdi() . ".sorumlu"] = $sorumlu;
        }

        $result = $this->db->reset_query()->select($this->cihazlarTabloAdi() . ".*, " . $this->cihazDurumlariTabloAdi() . ".id as cihazDurumuID, " . $this->cihazDurumlariTabloAdi() . ".siralama as siralama");
        $result = $result->where($where);

        if (count($spesifik) > 0) {
            $result = $result->where_in($this->cihazlarTabloAdi() . ".id", $spesifik);
        }

        if (strlen($arama) > 0) {
            $result = $result->group_start();
            $result = $result->like("servis_no", $arama);
            $result = $result->or_like("musteri_adi", $arama);
            $result = $result->or_like("cihaz", $arama);
            $result = $result->or_like("cihaz_modeli", $arama);
            $result = $result->group_end();
        }
        $result = $result->join($this->cihazDurumlariTabloAdi(), $this->cihazlarTabloAdi() . ".guncel_durum = " . $this->cihazDurumlariTabloAdi() . ".id")->order_by($this->cihazDurumlariTabloAdi() . ".siralama ASC, " . $this->cihazlarTabloAdi() . ".tarih DESC");
        $result = $result->limit($limit)->offset($sira);
        $result = $result->get($this->cihazlarTabloAdi())->result();
        //return  $this->db->last_query();
        return $this->cihazVerileriniDonustur($result, TRUE);
    }
    public function tekCihazApp($servis_no = "", $takip_no = "")
    {
        $where = array();

        $sorunlu = 0;
        if(strlen($servis_no) > 0){
            $where["servis_no"] = $servis_no;
        }else{
            $sorunlu++;
        }
        if(strlen($takip_no) > 0){
            $where["takip_numarasi "] = $takip_no;
        }else{
            $sorunlu++;
        }

        if($sorunlu >= 2){
            return null;
        }

        $result = $this->db->reset_query()->where($where)->limit(1);

        $result = $result->get($this->cihazlarTabloAdi());
        if($result->num_rows() > 0){
            $result = $result->result();
            return $this->cihazVerileriniDonustur($result, TRUE)[0];
        }else{
            return null;
        }
    }
    public function bilgisayardaAcGetir($kullanici_id){
        $kontrol = $this->db->reset_query()->where("kullanici_id", $kullanici_id)->get($this->cihazAcTabloAdi());
        if($kontrol->num_rows() > 0){
            $sonuc = $kontrol->result();
            $this->bilgisayardaAcSifirla($kullanici_id);
            return $this->tekCihazApp($sonuc[0]->servis_no);
        }else{
            return array();
        }
    }
    public function bilgisayardaAc($servis_no, $kullanici_id)
    {
        $kontrol = $this->db->reset_query()->where("kullanici_id", $kullanici_id)->get($this->cihazAcTabloAdi());
        if($kontrol->num_rows() > 0){
            $this->db->reset_query()->where("kullanici_id", $kullanici_id)->update($this->cihazAcTabloAdi(), array(
                "servis_no" => $servis_no,
            ));
        }else{
            $this->db->reset_query()->insert($this->cihazAcTabloAdi(), array(
                "kullanici_id" => $kullanici_id,
                "servis_no" => $servis_no,
            ));
        }
    }
    public function bilgisayardaAcSifirla($kullanici_id)
    {
        $this->db->reset_query()->where("kullanici_id", $kullanici_id)->delete($this->cihazAcTabloAdi());
    }
    public function sonCihazJQ($sorumlu = "")
    {
        $where = array();
        if ($sorumlu != "") {
            $where["sorumlu"] = $sorumlu;
        }
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->LIMIT(1)->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekTurTumuJQ($tur)
    {
        $where = array(
            "cihaz_turu" => $tur,
        );
        $result = $this->db->reset_query()->where($where)->order_by('id', 'DESC')->get($this->cihazlarTabloAdi())->result();
        return $this->cihazVerileriniDonustur($result);
    }
    public function cihazlarTekPersonelTumuJQ($sorumlu_personel)
    {
        return $this->cihazlarTumuJQ($sorumlu_personel);
    }
    public $telefon_numarasi_bos = "+90 (___) ___-____";
    public function cihazPost($yeni = TRUE)
    {
        $musteri_kod = $this->input->post("musteri_kod");
        $veri = array(
            "musteri_kod" => (strlen($musteri_kod) > 0) ? $musteri_kod : null,
            "musteri_adi" => $this->input->post("musteri_adi"),
            "teslim_eden" => $this->input->post("teslim_eden"),
            "adres" => $this->input->post("adres"),
            "cihaz_turu" => $this->input->post("cihaz_turu"),
            "cihaz" => $this->input->post("cihaz"),
            "cihaz_modeli" => $this->input->post("cihaz_modeli"),
            "seri_no" => $this->input->post("seri_no"),
            "cihaz_sifresi" => $this->input->post("cihaz_sifresi"),
            "cihaz_deseni" => $this->input->post("cihaz_deseni"),
            "hasar_tespiti" => $this->input->post("hasar_tespiti"),
            "cihazdaki_hasar" => $this->input->post("cihazdaki_hasar"),
            "ariza_aciklamasi" => $this->input->post("ariza_aciklamasi"),
            "teslim_alinanlar" => $this->input->post("teslim_alinanlar"),
            "servis_turu" => $this->input->post("servis_turu"),
            "yedek_durumu" => $this->input->post("yedek_durumu"),
        );
        $tel_no = $this->input->post("telefon_numarasi");
        if (isset($tel_no)) {
            if ($tel_no == $this->telefon_numarasi_bos) {
                $tel_no = "";
            }
            $veri["telefon_numarasi"] = $tel_no;
        }
        if ($yeni) {
            $veri["takip_numarasi"] = time();
        }
        $sorumlu = $this->input->post("sorumlu");
        if (isset($sorumlu)) {
            $veri["sorumlu"] = $sorumlu;
        }
        $tarih = $this->input->post("tarih");
        if (isset($tarih)) {
            $veri["tarih"] = $this->Islemler_Model->tarihDonusturSQL($tarih);
        }
        $tarih_girisi = $this->input->post("tarih_girisi");
        if (isset($tarih_girisi)) {
            if ($tarih_girisi == "oto") {
                $veri["tarih"] = $this->Islemler_Model->tarihDonusturSQLTime(time());
            }
        }
        return $veri;
    }
    public function cihazDuzenle($id, $veri)
    {
        $this->veriGuncellendiEkle();
        return $this->db->reset_query()->where("id", $id)->update($this->cihazlarTabloAdi(), $veri);
    }
    public function islemDuzenle($id, $veri)
    {
        $this->veriGuncellendiEkle();
        $konum = array(
            "cihaz_id" => $id,
            "islem_sayisi" => $veri["islem_sayisi"]
        );
        $islem_bul = $this->db->reset_query()->where($konum)->get($this->islemlerTabloAdi());
        if ($islem_bul->num_rows() > 0) {
            return $this->db->reset_query()->where($konum)->update($this->islemlerTabloAdi(), $veri);
        } else {
            return $this->db->reset_query()->insert($this->islemlerTabloAdi(), $veri);
        }
    }

    public function islemSil($id, $islem_sayisi)
    {
        $this->veriGuncellendiEkle();
        return $this->db->reset_query()->where(array(
            "cihaz_id" => $id,
            "islem_sayisi" => $islem_sayisi
        ))->delete($this->islemlerTabloAdi());
    }
    public function cihazEkle($tur)
    {
        $veri = $this->cihazPost();
        $servis_no = $this->insertTrigger();
        $cihaz_id = 0;
        if ($servis_no != 0) {
            $veri["servis_no"] = $servis_no;
            $this->veriGuncellendiEkle();
            $varsayilanDurum = $this->db->reset_query()->where("varsayilan", 1)->get($this->cihazDurumlariTabloAdi())->result();
            if (count($varsayilanDurum) > 0) {
                $veri["guncel_durum"] = $varsayilanDurum[0]->id;
            }
            $ekle =  $this->db->reset_query()->insert($this->cihazlarTabloAdi(), $veri);

            if($ekle){
                $cihaz_id = $this->db->insert_id();
            }
            if(isset($veri["sorumlu"])){
                $this->Kullanicilar_Model->bildirimGonderCihaz($veri["sorumlu"], $cihaz_id);
            }
            if ($ekle) {
                $musteriyi_kaydet = $this->input->post('musteriyi_kaydet');
                if(((int)$musteriyi_kaydet) == 1){
                    if($veri["musteri_kod"] == NULL){
                        $musteri_bilgileri =  array(
                            "musteri_adi" => $veri["musteri_adi"],
                            "adres" => $veri["adres"],
                        );
                        if(isset($veri["telefon_numarasi"])){
                            $musteri_bilgileri["telefon_numarasi"] = $veri["telefon_numarasi"];
                        }
                        $this->db->reset_query()->insert(
                            $this->Firma_Model->musteriTablosu(),
                            $musteri_bilgileri,
                        );
                    }
                }
                if($tur == "POST" || $tur == "post"){
                    return array("mesaj" => "", "sonuc" => 1, "id" => $cihaz_id);
                }else{
                    return array("mesaj" => "", "sonuc" => 1, "id" => $cihaz_id, "yonlendir"=> base_url("") . "#" . $this->cihazDetayModalAdi() . $cihaz_id);
                }
            } else {
                return array("mesaj" => "Ekleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"], "sonuc" => 0, "id" =>$cihaz_id);
            }
        } else {
            return array("mesaj" => "Ekleme işlemi gerçekleştirilemedi. " . $this->db->error()["message"], "sonuc" => 0, "id" => $cihaz_id);
        }
    }
    public function ozelIDTabloAdi()
    {
        return DB_ON_EK_STR . "ozelid";
    }
    public function insertTrigger()
    {
        $isim = date("Y");
        $grup = date("Y");
        $sonID = $this->Cihazlar_Model->sonIDBul($isim, $grup);
        if ($sonID == 0) {
            $sonID = $sonID + 1;
            $ekle = $this->Cihazlar_Model->sonIDEkle($isim, $grup, $sonID);
            if (!$ekle) {
                return 0;
            }
        } else {
            $sonID = $sonID + 1;
            $duzenle1 = $this->Cihazlar_Model->sonIDGuncelle($isim, $grup, $sonID);
            if (!$duzenle1) {
                return 0;
            }
        }
        return $grup . sprintf('%06d', $sonID);
    }
    public function deleteTrigger($id)
    {
        $this->db->reset_query()->query("DELETE FROM " . $this->silinenCihazlarTabloAdi() . " WHERE silinme_tarihi < now() - interval 1 day");
        return $this->db->reset_query()->insert($this->silinenCihazlarTabloAdi(), array("id" => $id));
    }
    public function sonIDEkle($isim, $grup, $sonID)
    {
        $veri = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
            "id_val" => $sonID,
        );
        return $this->db->reset_query()->insert($this->ozelIDTabloAdi(), $veri);
    }
    public function sonIDGuncelle($isim, $grup, $sonID)
    {
        $where = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
        );
        return $this->db->reset_query()->where($where)->update($this->ozelIDTabloAdi(), array("id_val" => $sonID));
    }
    public function sonIDBul($isim, $grup)
    {
        $where = array(
            "id_adi" => $isim,
            "id_grup" => $grup,
        );
        $query = $this->db->reset_query()->where($where)->limit(1)->get($this->ozelIDTabloAdi());
        if ($query->num_rows() > 0) {
            return $query->result()[0]->id_val;
        } else {
            return 0;
        }
    }
    public function cihazSil($id)
    {
        $this->veriGuncellendiEkle();
        return $this->db->reset_query()->where("id", $id)->delete($this->cihazlarTabloAdi());
    }
    public function silinenCihazlariBul()
    {
        $results = $this->db->reset_query()->get($this->silinenCihazlarTabloAdi())->result();
        //$this->db->reset_query()->empty_table($this->silinenCihazlarTabloAdi());
        return $results;
    }

    public function yapilanIslemArray($cihaz_id, $islem_sayisi, $ad, $maliyet, $birim_fiyat, $miktar, $kdv)
    {
        return array(
            "cihaz_id" => $cihaz_id,
            "islem_sayisi" => $islem_sayisi,
            "ad" => $ad,
            "maliyet" => $maliyet,
            "birim_fiyat" => $birim_fiyat,
            "miktar" => $miktar,
            "kdv" => $kdv
        );
    }
    public function cihazDetayModalAdi()
    {
        return "cihazDetay";
    }
    public function medyaYukle($id){
        if (!isset($_FILES["yuklenecekDosya"])) {
            echo json_encode(array("mesaj" => "Hata: Lütfen bir resim seçin", "sonuc" => 0));
        } else {
            if ($_FILES["yuklenecekDosya"]["error"] !== UPLOAD_ERR_OK) {
                echo json_encode(array("mesaj" => "Dosya yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0));
            } else {
                $gecici_dosya_adi = $_FILES["yuklenecekDosya"]["tmp_name"];
                $orjinal_dosya_adi = $_FILES["yuklenecekDosya"]["name"];
                $basariyla_yuklendi = FALSE;
                $uzanti = pathinfo($_FILES['yuklenecekDosya']['name'], PATHINFO_EXTENSION);
                $uzanti = strtolower($uzanti);
                if (($_FILES["yuklenecekDosya"]["type"] == "image/pjpeg")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/jpeg")
                    //|| ($_FILES["yuklenecekDosya"]["type"] == "video/mp4")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/png")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/gif")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/bmp")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/tiff")
                    || ($_FILES["yuklenecekDosya"]["type"] == "image/webp")
                    || ($_FILES["yuklenecekDosya"]["type"] == "application/octet-stream")
                ) {
                    $tur = ($_FILES["yuklenecekDosya"]["type"] == "video/mp4") ? "video" : "resim";
                    $yukleVeri = array(
                        "cihaz_id" => $id,
                        "tur" => $tur,
                        "yerel"=> 1,
                    );
                    $medya_cihazi = $this->db->reset_query()->where("id", $id)->get($this->cihazlarTabloAdi());

                    if($medya_cihazi->num_rows() > 0){
                        $servis_no = $medya_cihazi->result()[0]->servis_no;
                        if(DOSYA_YUKLEME_URL == "/"){
                            /*$boyut = $_FILES["yuklenecekDosya"]["size"];
                            $boyut_mb = number_format(($boyut / 1048576), 2);*/
                            $dosyaKonumu = "yuklemeler/$servis_no/";
                            $tasinacakKonum = $this->Islemler_Model->dosyaAdiOlustur($dosyaKonumu, $_FILES["yuklenecekDosya"]["name"]);
                            if (move_uploaded_file($gecici_dosya_adi, $tasinacakKonum)) {
                                $yukleVeri["konum"] = $tasinacakKonum;
                                $basariyla_yuklendi = TRUE;
                            }
                        } else {
                            $yukleVeri["yerel"] = 0;
                            $cfile = new CURLFile($gecici_dosya_adi, mime_content_type($gecici_dosya_adi), $orjinal_dosya_adi);
                            $post_data = [
                                "file" => $cfile,
                                "id"=> $servis_no
                            ];
                            $ch = curl_init();
                            curl_setopt($ch, CURLOPT_URL, DOSYA_YUKLEME_URL);
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                            // Flask sunucusundan gelen yanıtı al
                            $response = curl_exec($ch);
                            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                            curl_close($ch);
                            try{
                                $sonuc = json_decode($response, FALSE);
                                if($sonuc != null){
                                    if(property_exists($sonuc, "basarili")) 
                                    {
                                        if($sonuc->basarili){
                                            $yukleVeri["konum"] = $sonuc->dosya;
                                            $basariyla_yuklendi = TRUE;
                                        }
                                    }
                                }
                            }catch(Exception $e){
                                $basariyla_yuklendi = FALSE;
                            }
                        }
                    }else{
                        return array("mesaj" => "Medya eklenecek cihaz bulunamadı.", "sonuc" => 0);
                    }
                    
                    
                    if($basariyla_yuklendi){
                        $ekle = $this->medyaKaydet($yukleVeri);
                        if ($ekle) {
                            return array("mesaj" => "$orjinal_dosya_adi dosyasının yüklemesi tamamlandı.", "sonuc" => 1);
                        } else {
                            return array("mesaj" => "Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0);
                        }
                    }else{
                        return array("mesaj" => "Resim yüklenirken bir hata oluştu. Lütfen daha sonra tekrar deneyin.", "sonuc" => 0);
                    }
                } else {
                    return array("mesaj" => "Geçerli bir resim dosyası seçin.", "sonuc" => 0);
                }
            }  
        }
    }
    public function medyaKaydet($veri)
    {
        $this->veriGuncellendiEkle();
        return $this->db->reset_query()->insert($this->medyalarTabloAdi(), $veri);
    }
    public function medyaSil($id)
    {
        $this->veriGuncellendiEkle();
        return $this->db->reset_query()->where("id", $id)->delete($this->medyalarTabloAdi());
    }

    public function medyaBul($id)
    {
        $medya = $this->db->reset_query()->where("id", $id)->get($this->medyalarTabloAdi());
        if($medya->num_rows() == 0){
            return null;
        }
        return $medya->result()[0];
    }
    public function medyalar($id)
    {
        return $this->db->reset_query()->where("cihaz_id", $id)->get($this->medyalarTabloAdi())->result();
    }
    public function veriGuncellendiGetir()
    {
        return $this->db->reset_query()->get($this->guncellemeTabloAdi());
    }
    public function veriGuncellendi()
    {
        $query = $this->veriGuncellendiGetir();
        if ($query->num_rows() > 0) {
            return $this->veriGuncellendiGetir()->first_row();
        } else {
            return array("id" => 0, "guncelleme_tarihi" => strtotime("10 September 2023"));
        }
    }
    public function veriGuncellendiEkle()
    {
        $query = $this->veriGuncellendiGetir();
        if ($query->num_rows() > 0) {
            $son_guncellenen = $query->first_row();
            $this->db->reset_query()->where("id", $son_guncellenen->id)->update($this->guncellemeTabloAdi(), array(
                "guncelleme_tarihi" => time()
            ));
        } else {
            $this->db->reset_query()->insert($this->guncellemeTabloAdi(), array(
                "guncelleme_tarihi" => time()
            ));
        }
    }
}
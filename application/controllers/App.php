<?php
class App extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ayarlar_Model");
        $this->load->model("Giris_Model");
        $this->load->model("Kullanicilar_Model");
        $this->load->model("Cihazlar_Model");
    }
    public function index()
    {
        redirect(base_url());
    }
    public function token($token)
    {
        if (isset($token)) {
            if ($token == AUTH_TOKEN) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function hataMesaji($kod)
    {
        $sonuc = array(
            "hata" => $kod
        );
        switch ($kod) {
            case 1:
                $sonuc["mesaj"] = "Yetkisiz İşlem";
                break;
            case 2:
                $sonuc["mesaj"] = "Hatalı post";
                break;
            default:
                $sonuc["kod"] = 99;
                $sonuc["mesaj"] = "Bir hata oluştu";
                break;
        }
        return $sonuc;
    }
    public function tokenPost()
    {
        return $this->input->post("token");
    }
    public function girisyap()
    {
        $this->headerlar();
        $kullaniciAdi = $this->input->post("kullaniciAdi");
        $sifre = $this->input->post("sifre");
        $token = $this->tokenPost();
        if (isset($kullaniciAdi)) {
            if (isset($sifre)) {
                if (isset($token)) {
                    if ($this->token($token)) {
                        $durum = $this->Giris_Model->girisDurumu($kullaniciAdi, $sifre);
                        $sonuc = array(
                            "id" => "0",
                            "durum" => "false"
                        );
                        if ($durum) {
                            $kullaniciBilgileri = $this->Kullanicilar_Model->tekKullaniciAdi($kullaniciAdi);
                            if (isset($kullaniciBilgileri)) {
                                $sonuc["durum"] = "true";
                                $sonuc["id"] = $kullaniciBilgileri->id;
                            }
                        }
                        echo json_encode($sonuc);
                    } else {
                        echo json_encode($this->hataMesaji(1));
                    }
                } else {
                    echo json_encode($this->hataMesaji(2));
                }
            } else {
                echo json_encode($this->hataMesaji(2));
            }
        } else {
            echo json_encode($this->hataMesaji(2));
        }
    }
    public function kullaniciBilgileri()
    {
        $this->headerlar();
        $id = $this->input->post("id");
        $token = $this->tokenPost();
        if (isset($id)) {
            if (isset($token)) {
                if ($this->token($token)) {
                    $kullanici = $this->Kullanicilar_Model->tekKullanici($id);
                    echo json_encode($kullanici);
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(2));
            }
        } else {
            echo json_encode($this->hataMesaji(2));
        }
    }
    public function cihazlarTumu()
    {
        $this->headerlar();
        $sorumlu = $this->input->post("sorumlu");
        $token = $this->tokenPost();
        if (isset($sorumlu)) {
            if (isset($token)) {
                if ($this->token($token)) {
                    echo json_encode($this->Cihazlar_Model->cihazlarTumuJQ($sorumlu == 0 ? "" : $sorumlu));
                } else {
                    echo json_encode($this->hataMesaji(1));
                }
            } else {
                echo json_encode($this->hataMesaji(2));
            }
        } else {
            echo json_encode($this->hataMesaji(2));
        }
    }
    public function headerlar()
    {
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            header("Access-Control-Allow-Origin: *");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
}

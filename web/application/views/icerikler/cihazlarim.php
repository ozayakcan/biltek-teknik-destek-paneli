<?php
echo '
<script>
';
$this->load->view("inc/ortak_cihaz_script.php");
echo '
</script>
';
echo '<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>' . $baslik . '</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="' . base_url() . '">Anasayfa</a></li>
                        <li class="breadcrumb-item active">' . $baslik . '</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">';
$this->load->view("icerikler/cihaz_tablosu", array("suankiPersonel" => $suankiPersonel, "silButonuGizle" => true));
echo '</div>
        </div>
    </section>
</div>';

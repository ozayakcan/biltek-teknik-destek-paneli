<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <input id="cihaz_modeli" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="cihaz_modeli" placeholder="Modeli" value="';
if (isset($cihaz_modeli_value)) {
    echo $cihaz_modeli_value;
}
echo '">
</div>';

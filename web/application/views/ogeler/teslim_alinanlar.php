<?php
echo '<div class="col';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
echo '">
    <textarea id="teslim_alinanlar" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" name="teslim_alinanlar" class="form-control" rows="3" placeholder="Teslim Alınanlar">';
if (isset($teslim_alinanlar_value)) {
    echo $teslim_alinanlar_value;
}
echo '</textarea>
</div>';

<?php
echo '<div class="col-12';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Stok Kodu";
echo '">
    <label class="form-label" for="stokkodu">'.$input_basligi.'</label>
    <input id="stokkodu" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="text" name="stokkodu" placeholder="'.$input_basligi.'" value="';
if (isset($stokkodu_value)) {
    echo $stokkodu_value;
}
echo '">
</div>';

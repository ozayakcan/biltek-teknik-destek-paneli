<?php
echo '<div class="form-group';
if (isset($sifirla)) {
    echo " p-0 m-0";
}
$input_basligi = "Stok Adeti *";
echo ' col-12">
    <label for="stokadeti">'.$input_basligi.'</label>
    <input id="stokadeti" autocomplete="'.$this->Islemler_Model->rastgele_yazi().'" class="form-control" type="number" step="1" name="stokadeti" placeholder="'.$input_basligi.'" value="';
if (isset($stokadeti_value)) {
    echo $stokadeti_value;
}
else{
    echo '0';
}
echo '" required>
</div>';
<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("inc/meta"); ?>

    <title>Barkod <?= $cihaz->id; ?></title>

    <?php $this->load->view("inc/styles"); ?>
    <?php $this->load->view("inc/scripts"); ?>
    <?php
    $style = "width: 8cm;
            height: 4cm;
            size: 8cm 4cm;
            font-size:10px;
            word-break: break-word;
            page-break-before: always;
            display: inline;";
    ?>
    <style>
        body {
            margin: 0;
            <?= $style; ?>
        }

        @page {
            margin: 0;
            <?= $style; ?>
        }

        @media print {
            body {
                margin: 0;
                <?= $style; ?>
            }

            @page {
                margin: 0;
                <?= $style; ?>
            }
        }
    </style>
</head>

<body onafterprint="self.close()">
    <table class="table">
        <thead>
            <tr></tr>
            <tr></tr>
        </thead>
        <tbody class="p-1">
            <tr class="pl-1">
                <th class="p-0 pl-1 m-0"><?php
                                            $basamak = 3;
                                            $sifirSayisi = 3 - strlen($cihaz->id);
                                            $id = "";
                                            if ($sifirSayisi > 0) {
                                                for ($i = 0; $i < $sifirSayisi; $i++) {
                                                    $id .= "0";
                                                }
                                            }
                                            $id .= $cihaz->id;
                                            echo $id;
                                            ?></th>
                <td class="p-0 pr-1 m-0 text-right"><?= $cihaz->tarih; ?></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0" colspan="2"><?= $cihaz->musteri_adi; ?></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0" colspan="2"><?= $cihaz->cihaz . " " . $cihaz->cihaz_modeli; ?></td>
            </tr>
            <tr>
                <td class="p-0 pl-1 pr-1 m-0" colspan="2">
                    <p><?= $cihaz->ariza_aciklamasi; ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
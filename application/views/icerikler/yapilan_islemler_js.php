<script>
  setInterval(() => {
    $.get('<?= base_url("cihazlar/yapilanIslemlerJQ/" . $id); ?>', {}, function(data) {
      var jsonData = JSON.parse(data);
      var htmlRes = "";
      var islemlerSatiri = '<?= $yapilanIslemlerSatiri; ?>';
      var islemlerSatiriBos = '<?= $yapilanIslemlerSatiriBos; ?>';
      var toplam = 0;
      if (Object.keys(jsonData).length > 0) {
        $.each(jsonData, function(index, value) {
          toplam = toplam + value.fiyat;
          htmlRes += islemlerSatiri
            .replaceAll("{islem}", value.islem)
            .replaceAll("{miktar}", value.miktar)
            .replaceAll("{fiyat}", value.fiyat);
        });
      } else {
        var htmlRes = islemlerSatiriBos;
      }
      var yapilanIslemToplam = '<?= $yapilanIslemToplam; ?>';
      var toplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Toplam").replaceAll("{toplam_fiyat}", toplam);
      var kdv = toplam * 0.18;
      var kdvDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "KDV (%18)").replaceAll("{toplam_fiyat}", kdv);
      var genelToplamDiv = yapilanIslemToplam.replaceAll("{toplam_aciklama}", "Genel Toplam").replaceAll("{toplam_fiyat}", toplam + kdv);
      htmlRes += toplamDiv + kdvDiv + genelToplamDiv;
      $("#yapilanIslem<?= $id; ?>").html(htmlRes);
    });
  }, 5000);
</script>
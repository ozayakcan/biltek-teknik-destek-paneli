var base_url = window.location.origin;
var musteri_bilgileri_onaylandi = false;
var musteri_listesi_hover = false;
$(document).ready(function () {
	var musteri_adi_input = $("#musteri_adi");
	$("#musteri_adi_liste").hover(
		function () {
			musteri_listesi_hover = true;
		},
		function () {
			musteri_listesi_hover = false;
		}
	);
	musteri_adi_input.focusout(function () {
		if (!musteri_listesi_hover) {
			$("#musteri_adi_liste").hide();
		}
	});
	musteri_adi_input.focus(function () {
		if (!musteri_bilgileri_onaylandi) {
			musteriVerileriniGetirAd(musteri_adi_input);
		}
	});
	musteri_adi_input.keyup(function () {
		$("#musteri_kod").val("");
		musteriVerileriniGetirAd(musteri_adi_input);
	});
});
function musteriVerileriniGetirAd(musteri_adi_input) {
	var musteri_adi_input_st = musteri_adi_input.val();
	if (musteri_adi_input_st.length > 1) {
		$.get(
			base_url + "/js/musteri_adi/" + musteri_adi_input_st,
			{},
			function (data) {
				var jsonData = JSON.parse(data);
				if (Object.keys(jsonData).length > 0) {
					$("#musteri_adi_liste").html("");
					$.each(JSON.parse(data), function (index, value) {
						var oge = $(
							'<li class="active"><a class="dropdown-item" href="javascript:void(0);" id="musteri_adi_liste_oge_' +
								index +
								'" role="option">' +
								value.CARI_ISIM +
								(value.CARI_ULKE_KODU ? " / " + value.CARI_ULKE_KODU : "") +
								(value.CARI_IL ? " / " + value.CARI_IL : "") +
								(value.CARI_ILCE ? " / " + value.CARI_ILCE : "") +
								(value.CARI_ADRES ? " / " + value.CARI_ADRES : "") +
								"</a></li>"
						);
						$("#musteri_adi_liste").append(oge);
						$("#musteri_adi_liste_oge_" + index).on("click", function () {
							cihazGirisiVerileri(value);
						});
					});
					$("#musteri_adi_liste").show();
				} else {
					$("#musteri_adi_liste").html("");
					$("#musteri_adi_liste").hide();
				}
			}
		);
	}
}
function cihazGirisiVerileri(value) {
	$("#musteri_adi").val(value.CARI_ISIM ? value.CARI_ISIM : "", "");
	$("#adres").val(
		+(value.CARI_ADRES ? value.CARI_ADRES : "") +
			(value.CARI_ILCE ? ", " + value.CARI_ILCE : "") +
			(value.CARI_IL ? ", " + value.CARI_IL : "") +
			(value.CARI_ULKE_KODU ? ", " + value.CARI_ULKE_KODU : "")
	);
	$("#gsm_mail").val(
		value.CARI_TEL
			? value.CARI_TEL
			: value.GSM1
			? value.GSM1
			: value.GSM2
			? value.GSM2
			: ""
	);
	$("#musteri_kod").val(value.CARI_KOD ? value.CARI_KOD : "");
	musteri_bilgileri_onaylandi = true;
	$("#musteri_adi_liste").hide();
}
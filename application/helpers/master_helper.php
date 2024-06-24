<?php 
 
function formatHariTanggal($waktu)
{
    $hari_array = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );
    $hr = date('w', strtotime($waktu));
    $hari = $hari_array[$hr];
    $tanggal = date('j', strtotime($waktu));
    $bulan_array = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    );
    $bl = date('n', strtotime($waktu));
    $bulan = $bulan_array[$bl];
    $tahun = date('Y', strtotime($waktu));
    $jam = date( 'H:i:s', strtotime($waktu));
    
    return "$hari, $tanggal $bulan $tahun";
}

function untitik($n)
{
	$output = str_replace(',', '', $n);
	return $output;
}

function singkat_angka($n, $presisi=1) 
{
	if ($n < 900) {
		$format_angka = number_format($n, $presisi);
		$simbol = '';
	} else if ($n < 900000) {
		$format_angka = number_format($n / 1000, $presisi);
		$simbol = 'rb';
	} else if ($n < 900000000) {
		$format_angka = number_format($n / 1000000, $presisi);
		$simbol = 'jt';
	} else if ($n < 900000000000) {
		$format_angka = number_format($n / 1000000000, $presisi);
		$simbol = 'M';
	} else {
		$format_angka = number_format($n / 1000000000000, $presisi);
		$simbol = 'T';
	}
 
	if ( $presisi > 0 ) {
		$pisah = '.' . str_repeat( '0', $presisi );
		$format_angka = str_replace( $pisah, '', $format_angka );
	}
	
	return $format_angka . $simbol;
}

function tglindonesia($tanggal)
{
	if (!empty($tanggal)) {
		$ntgl = date('d', strtotime($tanggal));
		$nbln = date('m', strtotime($tanggal));
		$nthn = date('Y', strtotime($tanggal));

		switch ($nbln) {
			case '01':
				$cBln = 'Jan';
				break;
			case '02':
				$cBln = 'Feb';
				break;
			case '03':
				$cBln = 'Mar';
				break;
			case '04':
				$cBln = 'Apr';
				break;
			case '05':
				$cBln = 'Mei';
				break;
			case '06':
				$cBln = 'Jun';
				break;
			case '07':
				$cBln = 'Jul';
				break;
			case '08':
				$cBln = 'Ags';
				break;
			case '09':
				$cBln = 'Sep';
				break;
			case '10':
				$cBln = 'Okt';
				break;
			case '11':
				$cBln = 'Nov';
				break;
			default:
				$cBln = 'Des';
				break;
		}

		return $ntgl.' '.$cBln.' '.$nthn;
	}else{
		return '';
	}

}
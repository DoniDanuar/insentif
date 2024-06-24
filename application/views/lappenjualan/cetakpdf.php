<?php

class MYPDF extends TCPDF
{

    //Page header
    public function Header()
    {

        $this->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $this->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $this->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set margins
        //$this->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->SetMargins(PDF_MARGIN_LEFT, 3, PDF_MARGIN_RIGHT);
        $this->SetHeaderMargin(PDF_MARGIN_HEADER);
        $this->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set image scale factor
        $this->setImageScale(PDF_IMAGE_SCALE_RATIO);

    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 5, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->AddPage();

$pdf->SetTopMargin(0);
$title = '
    <br>
    <br>
    <table style="" border="0">
        <tbody>
            <tr>
                <td style="width:100%; text-align:center;">
                    <span style="color: black; font-weight:bold;">
                        SISTEM INFORMASI INSENTIF<br>
                        LAPORAN PENJUALAN
                    </span>
                </td>
            </tr>
        </tbody>
    </table>
    <br><hr>
';
$pdf->SetFont('times', '', 17);
$pdf->writeHTML($title, true, false, false, false, '');
$pdf->SetTopMargin(1);

$table = '
    <table border="0" cellpadding="2">
        <tbody>
            <tr>
                <td style="width: 100%;">' . implode("<br>", $dataFilter) . '</td>
            </tr>

            <tr>
                <td style="width: 100%;"></td>
            </tr>
        </tbody>
    </table>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th style="width: 5%; text-align:center;">No</th>
                <th style="width: 10%; text-align: center;">ID. Penjualan</th>
                <th style="width: 11%; text-align: center;">Tanggal</th>
                <th style="width: 18%; text-align: center;">Konsumen</th>
                <th style="width: 28%; text-align: center;">Keterangan</th>
                <th style="width: 10%; text-align: center;">Total Harga <br>(Rp.)</th>
                <th style="width: 18%; text-align: center;">Karyawan</th>
            </tr>
        </thead>
        <tbody>';

$no    = 1;
$total = 0;
if ($data->num_rows() > 0) {
    foreach ($data->result() as $row) {

        $dataDetail = array();
        $query      = $this->db->query("SELECT * FROM v_penjualan_detail WHERE idpenjualan='$row->idpenjualan' ORDER BY namabarang ");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rowDetail) {

                array_push($dataDetail,
                    "<span style='text-align:right;'><b>" . $rowDetail->namabarang . "</b> " . number_format($rowDetail->qty) . ' / ' . $rowDetail->satuan . ' x Rp. ' . number_format($rowDetail->hargajual) . ' = Rp. ' . number_format($rowDetail->totalharga) . '</span>');

            }
        }

        $table .= '

            <tr>
                <td style="width: 5%; text-align:center;">' . $no++ . '</td>
                <td style="width: 10%; text-align: center;">' . $row->idpenjualan . '</td>
                <td style="width: 11%; text-align: left;">' . formatHariTanggal($row->tglpenjualan) . '</td>
                <td style="width: 18%; text-align: left;">' . '<span style="font-size:11px;">
                                                                    ID. ' . $row->idkonsumen . ' <br>
                                                                    <b>' . $row->namakonsumen . '</b> <br>
                                                                    No. Telp : ' . $row->notelp . '
                                                                </span>' . '</td>
                <td style="width: 28%; text-align: left;">Ket. ' . $row->keterangan . ' <br>
                                                            <span style="font-size: 10px;">' . implode('<br>&nbsp;&nbsp; ', $dataDetail) . '</span>
                                                        </td>
                <td style="width: 10%; text-align: right;">' . 'Rp. ' . number_format($row->totalharga) . '</td>
                <td style="width: 18%; text-align: left;">' . '<span style="font-size:11px;">
                                                                ID. ' . $row->idkaryawan . ' <br>
                                                                <b>' . $row->namakaryawan . '</b> <br>
                                                                Jabatan : ' . $row->jabatan . '
                                                            </span>' . '</td>
            </tr>

        ';

        $total += $row->totalharga;
    }
}

$table .= '
                    <tr>
                        <td style="width: 72%; text-align:right; font-weight: bold;" colspan="5">Total :</td>
                        <td style="width: 28%; text-align:right; font-weight: bold;">Rp. ' . number_format($total) . '</td>
                    </tr>

                ';

$table .= '

        </tbody>
    </table>
';

$pdf->SetTopMargin(35);
$pdf->SetFont('times', '', 10);
$pdf->writeHTML($table, true, false, false, false, '');

$tglcetak = date('d-m-Y');

$pdf->Output();

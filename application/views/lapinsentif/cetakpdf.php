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
                        LAPORAN INSENTIF CANVASSER
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
                <td style="width: 100%; ">' . implode("<br>", $dataFilter) . '</td>
            </tr>

            <tr>
                <td style="width: 100%;"></td>
            </tr>
        </tbody>
    </table>

    <table border="1" cellpadding="2">
        <thead>
            <tr>
                <th style="width: 5%; text-align:center;">No</th>
                <th style="width: 10%; text-align: center;">ID. Insentif /<br> Tanggal</th>
                <th style="width: 18%; text-align: center;">Karyawan</th>
                <th style="width: 18%; text-align: center;">Target</th>
                <th style="width: 23%; text-align: center;">Keterangan Insentif</th>
                <th style="width: 16%; text-align: center;">Bonus</th>
                <th style="width: 10%; text-align: center;">Total Insentif <br>(Rp.)</th>
            </tr>
        </thead>
        <tbody>';

$no    = 1;
$total = 0;
if ($data->num_rows() > 0) {
    foreach ($data->result() as $row) {

        $grandTotal = 0;
        $grandTotal = $row->besarbonus + $row->totalbonusbarang;

        $table .= '
            <tr>
                <td style="width: 5%; text-align:center;">' . $no++ . '</td>
                <td style="width: 10%; text-align: center;"><b>' . $row->idmapping . '</b> <br> ' . formatHariTanggal($row->tglmapping) . '</td>
                <td style="width: 18%; text-align: left;">' . '<span style="font-size:12px;">
                                                                ID. ' . $row->idkaryawan . ' <br>
                                                                <b>' . $row->namakaryawan . '</b> <br>
                                                                Jabatan : ' . $row->jabatan . '
                                                            </span>' . '</td>
                <td style="width: 18%; text-align: left;">Total Target : <b>Rp. ' . number_format($row->target) . '</b></td>
                <td style="width: 23%; text-align: left;">Target Terjual : <b>Rp. ' . number_format($row->tagerterjual) . '</b></td>
                <td style="width: 16%; text-align: right;"><b>Rp. ' . number_format($row->besarbonus) . '</b></td>
                <td style="width: 10%; text-align: right;"><b>Rp. ' . number_format($grandTotal) . '</b></td>
            </tr>

        ';

        $query = $this->db->query("SELECT * FROM v_mapping_insentif_detail WHERE idmapping='$row->idmapping' ORDER BY namabarang, targetqty_awal ");
        if ($query->num_rows() > 0) {
            $table .= '
                            <tr>
                                <td style="width: 5%; text-align:center;"></td>
                                <td style="width: 28%; text-align: left;" colspan="2"><b>Detail Insetif Per Barang</b></td>
                                <td style="width: 18%; text-align: left;"></td>
                                <td style="width: 23%; text-align: left;"></td>
                                <td style="width: 16%; text-align: left;"></td>
                                <td style="width: 10%; text-align: right;"></td>
                            </tr>

                        ';

            foreach ($query->result() as $rowDetail) {

                $table .= '
                            <tr>
                                <td style="width: 5%; text-align:center;"></td>
                                <td style="width: 28%; text-align: left;" colspan="2">' . $rowDetail->namabarang . '</td>
                                <td style="width: 18%; text-align: left;">Target Qty : <b>' . $rowDetail->targetqty_awal . ' s/d ' . $rowDetail->targetqty_akhir . '</b></td>
                                <td style="width: 23%; text-align: left;">Qty Terjual : <b>' . $rowDetail->qtyterjual . ' ' . $rowDetail->satuan . '</b></td>
                                <td style="width: 16%; text-align: right;"><b>Rp. ' . number_format($rowDetail->bonus) . '</b></td>
                                <td style="width: 10%; text-align: right;"></td>
                            </tr>

                        ';

            }
        }

        $total += $grandTotal;
    }
}

$table .= '
                    <tr>
                        <td style="width: 90%; text-align:right; font-weight: bold;" colspan="5">Total :</td>
                        <td style="width: 10%; text-align:right; font-weight: bold;">Rp. ' . number_format($total) . '</td>
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

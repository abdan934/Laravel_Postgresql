<div>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Kartu Hasil Studi</title>
        <style>
            body {
                font-family: "Times New Roman", Times, serif;
            }

            .container {
                margin: 10px auto;
                max-width: 800px;
            }

            .header {
                display: flex;
                align-items: center;
                border-bottom: 4px solid #000;
                padding-bottom: 10px;
                margin-bottom: 2px;
            }

            .header .logo {
                flex: 0 0 120px;
                /* Fixed width for the logo */
                margin-right: 10px;
            }

            .header .institution {
                text-align: center;
                flex-grow: 1;
            }

            .header .institution h3 {
                margin: 0;
                font-size: 18px;
            }

            .header .institution p {
                margin: 0;
                font-size: 15px;
            }


            .border-code {
                border-bottom: 2px solid #000;
                padding-bottom: 10px;
                margin-bottom: 2px;
            }

            .mb-c {
                margin-bottom: 5px;
                font-size: 10px;
            }

            .fw-bold {
                font-weight: normal;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 10px;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                font-size: 15px;
            }

            th {
                background-color: #fff;
            }

            .signature {
                text-align: right;
                margin-top: 50px;
            }

            .student-info {
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            .student-info td {
                padding: 10px;
                border: none;
                font-size: 11px
            }

            .student-info td:first-child {
                font-weight: bold;
                border: none;
            }

            .student-info td:last-child {
                text-align: left;
                border: none;
            }

            .student-info td:last-child::before {
                margin-right: 5px;
            }

            .total-row-bottom tr {
                border: 2px solid black;
            }

            .total-row-bottom td {
                border: none;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="header">
                <table>
                    <tr>
                        <td style="text-align: center;border: none">
                            <div class="logo">
                                <img style="height: 100px; width: auto;"
                                    src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('asset/img/pnc-nobg.png'))) }}"
                                    alt="Logo" />
                            </div>
                        </td>
                        <td style="border: none">
                            <div class="institution">
                                <h3 style="font-weight: normal; margin-bottom: 5px; font-size: 15px">
                                    KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, <br />
                                    RISET, DAN TEKNOLOGI
                                </h3>
                                <h3 style="font-size: 15px">POLITEKNIK NEGERI CILACAP</h3>
                                <p>
                                    Jalan Dr. Soetomo No. 1, Sidakaya - CILACAP 53212 Jawa Tengah <br />
                                    Telepone: (0282) 533329, Fax: (0282) 537992 <br />
                                    www.pnc.ac.id, Email: sekretariat@pnc.ac.id
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="border-code">
                <div class="mb-c">FM. PM-EHBY-C. 02-R. 0</div>
            </div>
            <div style="padding-bottom: 10px">
                <div class="fw-bold"
                    style="
                font-size: 11px;
                border-bottom: 2px solid #000;
                text-align: center;
            ">
                    KARTU HASIL STUDI
                </div>
            </div>
            <table class="student-info" style="line-height: 0.1">
                <tr>
                    <td style="font-weight: normal">Nama</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->name_mhs }}</td>
                    <td>Jurusan</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->name_jurusan }}</td>
                </tr>
                <tr>
                    <td style="font-weight: normal">NPM</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->npm }}</td>
                    <td>Jenjang</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->jenjang_prodi . ' ' . $data_nilai['nilaiList'][0]->name_prodi }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: normal">Semester/T.A</td>
                    <td>:</td>
                    <td>{{ $data_nilai['semester'] . '/' . $data_nilai['nilaiList'][0]->tahun_ajar_awal_nilai . '-' . $data_nilai['nilaiList'][0]->tahun_ajar_akhir_nilai }}
                    </td>
                    <td>Kelas</td>
                    <td>:</td>
                    @php
                        $name_prodi = $data_nilai['nilaiList'][0]->name_prodi;
                        $words = explode(' ', $name_prodi);
                        $singkatan = '';
                        foreach ($words as $word) {
                            $singkatan .= strtoupper($word[0]);
                        }

                    @endphp
                    <td>{{ $singkatan . '-' . $data_nilai['nilaiList'][0]->kelas_nilai }}</td>
                </tr>
            </table>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: center; font-size:10px">NO</th>
                        <th style="text-align: center; font-size:10px">KODE MK</th>
                        <th style="text-align: center; font-size:10px">MATA KULIAH</th>
                        <th style="text-align: center; font-size:10px">SKS</th>
                        <th style="text-align: center; font-size:10px">NILAI HURUF</th>
                        <th style="text-align: center; font-size:10px">NILAI MUTU</th>
                        <th style="text-align: center; font-size:10px">KET.</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($data_nilai['nilaiList'] as $index => $nilai)
                        @if ($index < 10)
                            <tr style="line-height: 0.2">
                                <td style="font-size:10px; border: 1px solid black;text-align: center;">
                                    {{ $no++ }}</td>
                                <td style="font-size:10px; border: 1px solid black">{{ $nilai->kode_matkul }}</td>
                                <td style="width:40%; font-size:10px; border: 1px solid black">
                                    {{ $nilai->nama_matkul_ind }}</td>
                                <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                    {{ $nilai->sks }}</td>
                                <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                    {{ $nilai->predikat }}</td>
                                <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                    {{ round($nilai->angka_nilai) }}</td>
                                <td style="border: 1px solid black"></td>
                            </tr>
                        @endif
                    @endforeach
                    @for ($i = count($data_nilai['nilaiList']); $i < 10; $i++)
                        <tr style="line-height: 0.2">
                            <td style="font-size:10px; border: 1px solid black;text-align: center;">{{ $no++ }}
                            </td>
                            <td style="font-size:10px; border: 1px solid black"></td>
                            <td style="width:40%; font-size:10px; border: 1px solid black"></td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black"></td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black"></td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black"></td>
                            <td style="border: 1px solid black"></td>
                        </tr>
                    @endfor
                    <tr class="total-row-bottom" style="border-right: 1px solid black; border-left: 1px solid black">
                        <td colspan="3"
                            style="text-align: right; font-size: 11px; padding: 10px; border: none; line-height: 0.2">
                            JUMLAH :</td>
                        <td style="text-align: center; font-size: 11px; padding: 10px; border: none; line-height: 0.2">
                            {{ $data_nilai['totalSKS'] }}</td>
                        <td style="border: none"></td>
                        <td style="text-align: center; font-size: 11px; padding: 10px; border: none; line-height: 0.2">
                            {{ $data_nilai['NilaiMutu'] }}</td>
                        <td style="border: none"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 2px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">INDEKS PRESTASI</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ $data_nilai['ips'] }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 2px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">INDEKS PRESTASI
                                KUMULATIF</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ $data_nilai['ipk'] }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;border-bottom: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 2px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">STATUS KELULUSAN</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ $data_nilai['statusLulus'] }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding-left: 2px;padding-right: 2px;padding-bottom: 2px;padding-top: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 50%; text-align: left;">Ketidakhadiran karena :
                            </span>
                            <span style="display: inline-block; width: 10%; text-align: right;">Catatan :</span>
                        </td>
                        <td style="border: none;">
                        </td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding-left: 120px;padding-right: 2px;padding-bottom: 2px;padding-top: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 10%; text-align: left;">Sakit
                            </span>
                            <span style="display: inline-block; width: 3%; text-align: left;">:</span>
                            <span
                                style="display: inline-block; width: 7%; text-align: left;">{{ $data_nilai['totalSakit'] }}</span>
                            <span style="display: inline-block; width: 3%; text-align: right;">Jam</span>
                        </td>
                        <td style="border: none;">
                        </td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding-left: 120px;padding-right: 2px;padding-bottom: 2px;padding-top: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 10%; text-align: left;">Ijin
                            </span>
                            <span style="display: inline-block; width: 3%; text-align: left;">:</span>
                            <span
                                style="display: inline-block; width: 7%; text-align: left;">{{ $data_nilai['totalIzin'] }}</span>
                            <span style="display: inline-block; width: 3%; text-align: right;">Jam</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;border-bottom: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding-left: 120px;padding-right: 2px;padding-bottom: 10px;padding-top: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 10%; text-align: left;">Alpa
                            </span>
                            <span style="display: inline-block; width: 3%; text-align: left;">:</span>
                            <span
                                style="display: inline-block; width: 7%; text-align: left;">{{ $data_nilai['totalAlpha'] }}</span>
                            <span style="display: inline-block; width: 3%; text-align: right;">Jam</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>

                </tbody>
            </table>
            <table style="line-height: 0.1">
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;">Keterangan :</td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">A</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Sangat Istimewa
                            4,00/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">AB</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Istimewa 3,50/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">B</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Baik 3,00/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">BC</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Cukup Baik 2,50/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">C</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Cukup 2,00/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">D</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Kurang 1,00/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
                <tr style="border:none;">
                    <td style="font-size: 11px;border: none;width: 10%;"></td>
                    <td colspan="5" style="font-size: 11px; border: none; text-align: left;">
                        <span style="display: inline-block; width: 4%; text-align: left;">E</span>
                        <span style="display: inline-block; width: 2%; text-align: left;">:</span>
                        <span style="display: inline-block; width: 50%; text-align: left;">Gagal 0/SKS</span>
                    </td>
                    <td style="border: none;"></td>
                </tr>
            </table>
            <table style="line-height: 0.2">
                <tr>
                    <td style="border: none;font-size:11px">Mengetahui,</td>
                    <td style="border: none"></td>
                    <td style="border: none; text-align: start;font-size:11px">
                        Cilacap, &nbsp;&nbsp;{{ $data_nilai['sekarang'] }}
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td style="border: none;font-size:11px">Ketua Jurusan,</td>
                    <td style="border: none;font-size:11px">Koordinator Prodi,</td>
                    <td style="border: none; width: 30%;font-size:11px">Dosen Wali,</td>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none; width: 30%"></td>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none; width: 30%"></td>
                </tr>
                <tr>
                    <td style="border: none;font-size:11px">
                        <u>{{ !empty($data_nilai['kajur']->name_dosen) ? $data_nilai['kajur']->name_dosen : '' }}</u>
                    </td>
                    <td style="border: none;font-size:11px">
                        <u>{{ !empty($data_nilai['kaprodi']->name_dosen) ? $data_nilai['kaprodi']->name_dosen : '' }}</u>
                    </td>
                    <td style="border: none; width: 30%;font-size:11px">
                        <u> Andesita Prihantara, ST., M. Eng. </u>
                    </td>
                </tr>
                <tr>
                    <td style="border: none;font-size:11px">NIP.
                        {{ !empty($data_nilai['kajur']->nip) ? $data_nilai['kajur']->nip : '' }}</td>
                    <td style="border: none;font-size:11px">NIP.
                        {{ !empty($data_nilai['kaprodi']->nip) ? $data_nilai['kaprodi']->nip : '' }}</td>
                    <td style="border: none; width: 30%;font-size:11px">NIP. 1234567890</td>
                </tr>
            </table>

            <div style="margin-top: 20px; font-size: 8px">
                <em>*mahasiswa harap memfotocopy/scan khs ini untuk arsip sendiri</em>
            </div>
        </div>
    </body>

    </html>
</div>

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
            <div style="padding-bottom: 10px">
                <div class="fw-bold"
                    style="
                font-size: 11px;
                text-align: center;
                padding: 10px;
                font-weight: bold;
            ">
                    TRANSKRIP AKADEMIK
                </div>
            </div>
            <table class="student-info" style="line-height: 0.1">
                <tr>
                    <td style="font-weight: normal">NAMA MAHASISWA</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->name_mhs }}</td>
                    <td>JURUSAN</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->name_jurusan }}</td>
                </tr>
                <tr>
                    <td style="font-weight: normal">NOMOR POKOK MAHASISWA</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->npm }}</td>
                    <td>PROGRAM STUDI</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->jenjang_prodi . ' ' . $data_nilai['nilaiList'][0]->name_prodi }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: normal">TEMPAT, TANGGAL LAHIR</td>
                    <td>:</td>
                    <td>
                        {{ $data_nilai['ttgl_lahir'] }}
                    </td>
                    <td>TAHUN MASUK</td>
                    <td>:</td>
                    <td>{{ $data_nilai['nilaiList'][0]->tahun_masuk }}</td>
                </tr>
                <tr>
                    <td style="font-weight: normal">JENIS KELAMIN</td>
                    <td>:</td>
                    <td>
                        {{ $data_nilai['nilaiList'][0]->jk_mhs == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </td>
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
                        <tr style="line-height: 0.2">
                            <td style="font-size:10px; border: 1px solid black;text-align: center;">
                                {{ $no++ }}</td>
                            <td style="font-size:10px; border: 1px solid black">{{ $nilai->kode_matkul }}</td>
                            <td style="width:40%; font-size:10px; border: 1px solid black">
                                {{ $nilai->nama_matkul_ind }}</td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                {{ $nilai->sks }}</td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                {{ $nilai->predikatAll }}</td>
                            <td style=" text-align: center; font-size:10px; border: 1px solid black">
                                {{ round($nilai->angka_nilai) }}</td>
                            <td style="border: 1px solid black"></td>
                        </tr>
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
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">TOTAL SKS</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ $data_nilai['totalSKS'] }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">TOTAL MUTU</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ round($data_nilai['TotalMutu']) }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>
                    <tr class="no-total-row-bottom"
                        style="border-right: 1px solid black; border-left: 1px solid black;border-bottom: 1px solid black;">
                        <td style="border: none;"></td>
                        <td colspan="5"
                            style="font-size: 11px; padding: 10px; border: none; line-height: 0.2; text-align: left;">
                            <span style="display: inline-block; width: 35%; text-align: left;">INDEKS PRESTASI
                                KUMULATIF</span>
                            <span style="display: inline-block; width: 5%; text-align: center;">:</span>
                            <span
                                style="display: inline-block; width: 10%; text-align: center;">{{ $data_nilai['ipk'] }}</span>
                        </td>
                        <td style="border: none;"></td>
                    </tr>

                </tbody>
            </table>
            <table style="line-height: 0.2">
                <tr>
                    {{-- <td style="border: none;font-size:11px">Mengetahui,</td> --}}
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none; text-align: start;font-size:11px">
                        Cilacap, &nbsp;&nbsp;{{ $data_nilai['sekarang'] }}
                    </td>
                </tr>
                <tr>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none;font-size:11px">Ketua Jurusan
                        {{ ucwords(strtolower($data_nilai['nilaiList'][0]->name_jurusan)) }},</td>
                    {{-- <td style="border: none;font-size:11px">Koordinator Prodi,</td>
                    <td style="border: none; width: 30%;font-size:11px">Dosen Wali,</td> --}}
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
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none;font-size:11px">
                        <u>{{ !empty($data_nilai['kajur']->name_dosen) ? $data_nilai['kajur']->name_dosen : '' }}</u>
                    </td>
                </tr>
                <tr>
                    <td style="border: none"></td>
                    <td style="border: none"></td>
                    <td style="border: none;font-size:11px">NIP.
                        {{ !empty($data_nilai['kajur']->nip) ? $data_nilai['kajur']->nip : '' }}</td>

                </tr>
            </table>

        </div>
    </body>

    </html>
</div>

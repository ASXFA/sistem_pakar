<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
    *{
        font-size: 12px;
    }

    body {
        margin:0;
    }

	.table1 {
        width: 100%;
        height: 100%;
        font-family: sans-serif;
        color: black;
        border-collapse: collapse;
        margin-bottom: 5px;
    }

    .container {
        padding: 4em 1em;
    }

    .table-borderless{
        width: 100%;
        height: 100%;
        font-family: sans-serif;
        border-collapse: collapse;   
        margin-bottom: 5px;
    }

    .table-borderless, th, td {
        padding: 3px 5px;
        font-size: 12px;
    }
    
    .table1 th, .table1 td {
        border: 1px solid black;
        padding: 3px 5px;
    }

    .text-center{
        text-align: center;
    }
    .text-left{
        text-align: left;
    }
    .text-justify{
        text-align:justify;
    }

    .text-right{
        text-align:right;
    }

    .font-weight-normal{
        font-weight: normal;
    }
    </style>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    
    <title>Document</title>
</head>
    <body>
        <h2 class="text-center"><strong><u>HASIL KONSULTASI</u></strong></h2>
        <p class="text-justify">Terimakasih telah menggunakan aplikasi ini untuk berkonsultasi perihal ketidaknyamanan pada gigi & mulut anda. Kami menangkap dan menyimpan profil yang anda masukan sebelumnya sebagai berikut : </p>
        <table class="table-borderless">
            <tr>
                <td width="15%"><strong>Nama</strong></td>
                <td width="5%">:</td>
                <td >{{tamu.nama}}</td>
            </tr>
            <tr>
                <td width="15%"><strong>Jenis Kelamin</strong></td>
                <td width="5%">:</td>
                <td >{{tamu.jenis_kelamin}}</td>
            </tr>
            <tr>
                <td width="15%"><strong>No Handphone</strong></td>
                <td width="5%">:</td>
                <td>{{tamu.no_hp}}</td>
            </tr>
        </table>
        <p>Dan berikut hasil analisa kami terhadap gejala-gejala yang anda alami : </p>
        <h4><strong><u>Gejala yang anda alami</u></strong></h4>
        <table class="table-borderless">
        {% for item in konsultasi %}
        {% if item.jawaban=='YA' %}
            <tr>
                {% for items in gejala %}
                {% if items.id == item.id_gejala %}
                <td>{{items.nama_gejala}} </td>
                {% endif %}
                {% endfor %}
            </tr>
        {% endif %}
        {% endfor %}
        </table>
        <h4><strong><u>Penyakit</u></strong></h4>
        <table class="table-borderless">
            <tr>
                <td width="20%"><strong>Nama Penyakit</strong></td>
                <td width="5%">:</td>
                <td>{{ penyakit.nama_penyakit }}</td>
            </tr>
            <tr>
                <td width="25%"><strong>Solusi yang dianjurkan </strong></td>
                <td width="5%">:</td>
                <td>{{ solusi.nama_solusi }}</td>
            </tr>
        </table>
        <p class="text-justify">Demikian hasil analisa sistem kami terhadap penyakit dan gejala-gejala yang anda alami, kami harap anda selalu menjaga kesehatan gigi dan mulut anda agar terhindar dari segala penyakit yang menyerang gigi dan mulut anda.</p>
        <p class="text-justify">Terimakasih telah menggunakan aplikasi sistem pakar gigi dan mulut, kami akan memberikan rekap konsultasi setiap pertanyaan yang kami berikan kepada anda pada halaman berikutnya.</p>
        <br>
        <p><strong>Regards,</strong></p>
        <br>
        <br>
        <p><strong>Tim Pakar</strong></p>
        <pagebreak/>
        <h3 class="text-center"><strong><u>REKAP KONSULTASI</u></strong></h3>
        <table class="table-borderless">
        {% for item in konsultasi %}
            <tr>
                {% for items in gejala %}
                {% if items.id == item.id_gejala %}
                <td>Apakah anda mengalami gejala {{items.nama_gejala}} ? </td>
                <td><strong>{{item.jawaban}}</strong></td>
                {% endif %}
                {% endfor %}
            </tr>
        {% endfor %}
        </table>
    </body>
</html>

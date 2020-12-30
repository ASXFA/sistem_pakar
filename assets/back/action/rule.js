$(function(){
    $('#d-down-penyakit').attr('class','sidebar-item selected');
    $('#a-d-down-penyakit').attr('class','sidebar-link has-arrow waves-effect waves-dark active');
    $('#ul-d-down-penyakit').attr('class','collapse first-level in');
    $('#rule-page').attr('class','sidebar-link active');

    $('#table-rule').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"ruleLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    $('#btnTambahRule').click(function(){
        $('#modalRule').modal('show');
        $('#btnTambah').val('Tambah');
        $('#operation').val('Tambah');
        getPenyakit();
        getGejala();
    })

    $('.select2').select2({
        dropdownParent: $('#modalRule')
    });

    aturanTab();

    // function getKode(){
    //     $.ajax({
    //         method:'GET',
    //         dataType:'JSON',
    //         url:'getKoderule',
    //         success:function(result){
    //             $('#kode_rule').val(result.kode);  
    //         }
    //     })
    // }

    function getPenyakit(id_penyakit){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getAllPenyakit',
            success:function(result){
                var html='';
                var i=0;
                for(i; i<result.length; i++){
                    if (id_penyakit == result[i].id) {
                        html += "<option value='"+result[i].id+"' selected>["+result[i].kode_penyakit+"] "+result[i].nama_penyakit+"</option>";
                    }else{
                        html += "<option value='"+result[i].id+"'>["+result[i].kode_penyakit+"] "+result[i].nama_penyakit+"</option>";
                    }
                }
                $('#id_penyakit').html(html);
            }
        })
    }

    function getGejala(id_gejala){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getAllGejala',
            success:function(result){
                var html='';
                var i=0;
                for(i; i<result.length; i++){
                    if (id_gejala == result[i].id) {
                        html += "<option value='"+result[i].id+"' selected>["+result[i].kode_gejala+"] "+result[i].nama_gejala+"</option>";
                    }else{
                        html += "<option value='"+result[i].id+"'>["+result[i].kode_gejala+"] "+result[i].nama_gejala+"</option>";
                    }
                }
                $('#id_gejala').html(html);
            }
        })
    }

    $('#formRule').submit(function(e){
        e.preventDefault();
        var id_rule = $('#id_rule').val();
        var kode_rule = $('#kode_rule').val();
        var id_penyakit = $('#id_penyakit').val();
        var id_gejala = $('#id_gejala').val();
        var operation = $('#operation').val();
        if (id_penyakit != '' && id_gejala != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_rule:id_rule,id_penyakit:id_penyakit,id_gejala:id_gejala,operation:operation},
                url:'doRule',
                success:function(result){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil '+operation+' !',
                        timer:3000,
                    }).then((results) => {
                        /* Read more about handling dismissals below */
                        if (results.dismiss === Swal.DismissReason.timer) {
                            $('#table-rule').DataTable().ajax.reload();
                            $('#modalRule').modal('hide');
                            aturanTab();
                        }else if(results.isConfirmed){
                            $('#table-rule').DataTable().ajax.reload();
                            $('#modalRule').modal('hide');
                            aturanTab();
                        }
                    })
                }
            })
        }else{
            Swal.fire({
                icon: 'Warning',
                title: 'Peringatan !',
                text: 'Field Tidak boleh kosong !'
            })
        }
    })

    $(document).on('click','.editRule',function(){
        var id = $(this).attr('id');
        $('#modalRule').modal('show');
        $('#id_rule').val(id);
        $('#btnTambah').val('Edit');
        $('#operation').val('Edit');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'ruleById',
            success:function(result){
                getPenyakit(result.id_penyakit);
                getGejala(result.id_gejala);
            }
        })
    })

    $(document).on('click','.deleteRule',function(){
        Swal.fire({
            title: 'Yakin Di Hapus ?',
            text: 'Data akan terhapus permanen !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus !'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr('id');
                $.ajax({
                    method:'POST',
                    dataType:'JSON',
                    data:{id:id},
                    url:'deleteRule',
                    success:function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil dihapus !',
                            timer:3000,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                $('#table-rule').DataTable().ajax.reload();
                                aturanTab();
                            }else if(results.isConfirmed){
                                $('#table-rule').DataTable().ajax.reload();
                                aturanTab();
                            }
                        })
                    }
                })
            }
        })
    })
    function aturanTab(){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'aturanRincian',
            success:function(result){
                var html = '';
                var i = 0;
                var start = 0;
                for(i; i<result.penyakit.length; i++){
                    html += "<div class='col-md-12'>";
                    html += "<div class='card'>";
                    html += "<div class='card-title'><h4> Rules "+(i+1)+"</h4></div>";
                    html += "<div class='card-body'>";
                    var j = 0;
                    var hitung = 0;
                    for(j; j<result.rules.length; j++){
                        if (result.rules[j].id_penyakit == result.penyakit[i].id) {
                            if (j == start) {
                                html += "<h5><span class='text-success'> JIKA </span>"+result.rules[j].nama_gejala+"</h5>";
                            }else{
                                html += "<h5 class='ml-4'>DAN "+result.rules[j].nama_gejala+"</h5>";
                            }
                            hitung += 1;
                        }
                    }
                    start += hitung;
                    // console.log(hitung);
                    // console.log(start);
                    html+="<h5> Mengalami penyakit : <span class='text-danger'>"+result.penyakit[i].nama_penyakit+"</span></h5>";
                    html+="</div>";
                    html+="</div>";
                    html+="</div>";
                }
                $('#card-aturan').html(html);
            }
        })
    }
})
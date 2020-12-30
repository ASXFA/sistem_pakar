$(function(){
    $('#d-down-penyakit').attr('class','sidebar-item selected');
    $('#a-d-down-penyakit').attr('class','sidebar-link has-arrow waves-effect waves-dark active');
    $('#ul-d-down-penyakit').attr('class','collapse first-level in');
    $('#solusi-page').attr('class','sidebar-link active');

    $('#table-solusi').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"solusiLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    $('#btnTambahSolusi').click(function(){
        $('#modalSolusi').modal('show');
        $('#btnTambah').val('Tambah');
        $('#operation').val('Tambah');
        getKode();
        getPenyakit();
        $('#nama_solusi').val('');
    })

    $('.select2').select2({
        dropdownParent: $('#modalSolusi')
    });

    function getKode(){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getKodeSolusi',
            success:function(result){
                $('#kode_solusi').val(result.kode);  
            }
        })
    }

    function getPenyakit(id_penyakit){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getAllPenyakit',
            success:function(result){
                console.log(id_penyakit);
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

    $('#formSolusi').submit(function(e){
        e.preventDefault();
        var id_solusi = $('#id_solusi').val();
        var kode_solusi = $('#kode_solusi').val();
        var id_penyakit = $('#id_penyakit').val();
        var nama_solusi = $('#nama_solusi').val();
        var operation = $('#operation').val();
        if (kode_solusi != '' && nama_solusi != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_solusi:id_solusi,kode_solusi:kode_solusi,id_penyakit:id_penyakit,nama_solusi:nama_solusi,operation:operation},
                url:'doSolusi',
                success:function(result){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil '+operation+' !',
                        timer:3000,
                    }).then((results) => {
                        /* Read more about handling dismissals below */
                        if (results.dismiss === Swal.DismissReason.timer) {
                            $('#table-solusi').DataTable().ajax.reload();
                            $('#modalSolusi').modal('hide');
                        }else if(results.isConfirmed){
                            $('#table-solusi').DataTable().ajax.reload();
                            $('#modalSolusi').modal('hide');
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

    $(document).on('click','.editSolusi',function(){
        var id = $(this).attr('id');
        $('#modalSolusi').modal('show');
        $('#id_solusi').val(id);
        $('#btnTambah').val('Edit');
        $('#operation').val('Edit');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'solusiById',
            success:function(result){
                $('#kode_solusi').val(result.kode_solusi);
                getPenyakit(result.id_penyakit);
                $('#nama_solusi').val(result.nama_solusi);
            }
        })
    })

    $(document).on('click','.deleteSolusi',function(){
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
                    url:'deleteSolusi',
                    success:function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil dihapus !',
                            timer:3000,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                $('#table-solusi').DataTable().ajax.reload();
                            }else if(results.isConfirmed){
                                $('#table-solusi').DataTable().ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })
})
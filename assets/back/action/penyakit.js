$(function(){
    $('#d-down-penyakit').attr('class','sidebar-item selected');
    $('#a-d-down-penyakit').attr('class','sidebar-link has-arrow waves-effect waves-dark active');
    $('#ul-d-down-penyakit').attr('class','collapse first-level in');
    $('#penyakit-page').attr('class','sidebar-link active');

    $('#table-penyakit').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"penyakitLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    $('#btnTambahPenyakit').click(function(){
        $('#modalPenyakit').modal('show');
        $('#btnTambah').val('Tambah');
        $('#operation').val('Tambah');
        getKode();
        $('#nama_penyakit').val('');
    })

    function getKode(){
        $.ajax({
            method:'GET',
            dataType:'JSON',
            url:'getKodePenyakit',
            success:function(result){
                $('#kode_penyakit').val(result.kode);  
            }
        })
    }

    $('#formPenyakit').submit(function(e){
        e.preventDefault();
        var id_penyakit = $('#id_penyakit').val();
        var kode_penyakit = $('#kode_penyakit').val();
        var nama_penyakit = $('#nama_penyakit').val();
        var operation = $('#operation').val();
        if (kode_penyakit != '' && nama_penyakit != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_penyakit:id_penyakit,kode_penyakit:kode_penyakit,nama_penyakit:nama_penyakit,operation:operation},
                url:'doPenyakit',
                success:function(result){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil '+operation+' !',
                        timer:3000,
                    }).then((results) => {
                        /* Read more about handling dismissals below */
                        if (results.dismiss === Swal.DismissReason.timer) {
                            $('#table-penyakit').DataTable().ajax.reload();
                            $('#modalPenyakit').modal('hide');
                        }else if(results.isConfirmed){
                            $('#table-penyakit').DataTable().ajax.reload();
                            $('#modalPenyakit').modal('hide');
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

    $(document).on('click','.editPenyakit',function(){
        var id = $(this).attr('id');
        $('#modalPenyakit').modal('show');
        $('#id_penyakit').val(id);
        $('#btnTambah').val('Edit');
        $('#operation').val('Edit');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'penyakitById',
            success:function(result){
                $('#kode_penyakit').val(result.kode_penyakit);
                $('#nama_penyakit').val(result.nama_penyakit);
            }
        })
    })

    $(document).on('click','.deletePenyakit',function(){
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
                    url:'deletePenyakit',
                    success:function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil dihapus !',
                            timer:3000,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                $('#table-penyakit').DataTable().ajax.reload();
                            }else if(results.isConfirmed){
                                $('#table-penyakit').DataTable().ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })
})
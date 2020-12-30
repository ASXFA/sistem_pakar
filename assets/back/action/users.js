$(function(){
    $('#li-users').attr('class','sidebar-item selected');

    $('#table-users').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"userLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

    $('#btnTambahUsers').click(function(){
        $('#modalUsers').modal('show');
        $('#btnTambah').val('Tambah');
        $('#operation').val('Tambah');
        $('#nama_user').val('');
        $('#username').val('');
    })

    $('#formUsers').submit(function(e){
        e.preventDefault();
        var id_users = $('#id_users').val();
        var nama = $('#nama_user').val();
        var username = $('#username').val();
        var operation = $('#operation').val();
        if (nama != '' && username != '') {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{id_users:id_users,nama:nama,username:username,operation:operation},
                url:'doUsers',
                success:function(result){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil '+operation+' !',
                        timer:3000,
                    }).then((results) => {
                        /* Read more about handling dismissals below */
                        if (results.dismiss === Swal.DismissReason.timer) {
                            $('#table-users').DataTable().ajax.reload();
                            $('#btnTambah').val('Tambah');
                            $('#operation').val('Tambah');
                            $('#nama_user').val('');
                            $('#username').val('');
                            $('#id_users').val('');
                            $('#modalUsers').modal('hide');
                        }else if(results.isConfirmed){
                            $('#table-users').DataTable().ajax.reload();
                            $('#btnTambah').val('Tambah');
                            $('#operation').val('Tambah');
                            $('#nama_user').val('');
                            $('#username').val('');
                            $('#id_users').val('');
                            $('#modalUsers').modal('hide');
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

    $(document).on('click','.gantiStatus',function(){
        Swal.fire({
            title: 'Yakin Ganti Status ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ganti !'
        }).then((result) => {
            if (result.isConfirmed) {
                var id = $(this).attr('id');
                var status = $(this).attr('data-status');
                $.ajax({
                    method:'POST',
                    dataType:'JSON',
                    data:{id:id,status:status},
                    url:'gantiStatusUsers',
                    success:function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil diganti !',
                            timer:3000,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                $('#table-users').DataTable().ajax.reload();
                            }else if(results.isConfirmed){
                                $('#table-users').DataTable().ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })

    $(document).on('click','.editUsers',function(){
        var id = $(this).attr('id');
        $('#modalUsers').modal('show');
        $('#id_users').val(id);
        $('#btnTambah').val('Edit');
        $('#operation').val('Edit');
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id:id},
            url:'usersById',
            success:function(result){
                $('#nama_user').val(result.nama);
                $('#username').val(result.username);
            }
        })
    })

    $(document).on('click','.deleteUsers',function(){
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
                    url:'deleteUsers',
                    success:function(result){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil dihapus !',
                            timer:3000,
                        }).then((results) => {
                            /* Read more about handling dismissals below */
                            if (results.dismiss === Swal.DismissReason.timer) {
                                $('#table-users').DataTable().ajax.reload();
                            }else if(results.isConfirmed){
                                $('#table-users').DataTable().ajax.reload();
                            }
                        })
                    }
                })
            }
        })
    })

})
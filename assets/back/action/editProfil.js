$(function(){
    $('#saveProfil').attr('disabled','disabled');
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    
    $('#username').keydown(function(){
        var username = $('#username').val();
        if (username == "") {
            Toast.fire({
                icon: 'error',
                title: 'Username tidak boleh kosong !'
            })
            $('#saveProfil').attr('disabled','disabled');
        }else if(username.length < 6 ){
            Toast.fire({
                icon: 'error',
                title: 'Username kurang dari 6 karakter !'
            })
            $('#saveProfil').attr('disabled','disabled');
        }else{
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{username:username},
                url:'cekUsername',
                success:function(result){
                    if (result.cond == 0) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Username Sudah ada !'
                        })
                        $('#saveProfil').attr('disabled','disabled');
                    }else{
                        Toast.fire({
                            icon: 'success',
                            title: 'Username bisa digunakan !'
                        })
                        $('#saveProfil').removeAttr('disabled','disabled');
                    }
                }
            })
        }
    })

    $('#formEditProfil').submit(function(e){
        e.preventDefault();
        var nama = $('#nama').val();
        var username= $('#username').val();

        if (nama != "" && username != "") {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{nama:nama,username:username},
                url:'aksi_editProfil',
                success:function(result){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil diganti !',
                        timer:3000,
                    }).then((results) => {
                        if (results.dismiss === Swal.DismissReason.timer) {
                            location.reload();
                        }else if(results.isConfirmed){
                            location.reload();
                        }
                    });
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
    $('#savePassword').attr('disabled','disabled');
    $('#conf_pass').keyup(function(){
        var pass_baru = $('#pass_baru').val();
        var conf_pass = $('#conf_pass').val();
        if (pass_baru != conf_pass) {
            $('#conf_pass').attr('class','form-control border border-danger');
            $('#savePassword').attr('disabled','disabled');
        }else{
            $('#conf_pass').attr('class','form-control border border-success');
            $('#savePassword').removeAttr('disabled','disabled');
        }
    })
    

    $('#formEditPassword').submit(function(e){
        e.preventDefault();
        var pass_lama = $('#pass_lama').val();
        var pass_baru = $('#pass_baru').val();
        var conf_pass = $('#conf_pass').val();

        if (pass_lama != "" && pass_baru != "" && conf_pass !="") {
            $.ajax({
                method:'POST',
                dataType:'JSON',
                data:{pass_lama:pass_lama,pass_baru:pass_baru},
                url:'editPassword',
                success:function(result){
                    if (result.cond == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Peringatan !',
                            text: 'Password Lama Anda Salah !'
                        })
                    }else if(result.cond == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil diganti !',
                            timer:3000,
                        }).then((results) => {
                            if (results.dismiss === Swal.DismissReason.timer) {
                                window.location.href='logout';
                            }else if(results.isConfirmed){
                                window.location.href='logout';
                            }
                        });
                    }
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

})
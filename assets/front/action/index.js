$(function(){
    $('#mulaiKonsultasi1').click(function(){
        $('#modalDataDiri').modal('show');
    });
    $('#mulaiKonsultasi2').click(function(){
        $('#modalDataDiri').modal('show');
    });
    $('#mulaiKonsultasi3').click(function(){
        $('#modalDataDiri').modal('show');
    });

    $('#formDataDiri').submit(function(e){
        e.preventDefault();
        var nama_tamu = $('#nama_tamu').val();
        var jenis_kelamin = $('#jenis_kelamin').val();
        var no_hp = $('#no_hp').val();
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{nama_tamu:nama_tamu,jenis_kelamin:jenis_kelamin,no_hp:no_hp},
            url:'tambahTamu',
            success:function(result){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil !',
                    timer:3000,
                }).then((results) => {
                    /* Read more about handling dismissals below */
                    if (results.dismiss === Swal.DismissReason.timer) {
                        window.location.href='konsultasi';
                    }else if(results.isConfirmed){
                        window.location.href='konsultasi';
                    }
                })
            }
        })
    })
})
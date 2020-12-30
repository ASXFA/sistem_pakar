$(function(){
    $('#header').attr('class','fixed-top header-scrolled');
    $('#home').hide();
    $('#tentang').hide();
    $('#pelayanan').hide();
    $('#mulaiKonsultasi1').hide();

    $('#cancelKonsul').click(function(){
        Swal.fire({
            title: 'Yakin Cancel Konsultasi ?',
            text: 'Proses konsultasi akan berhenti dan anda tidak mendapatkan hasil !',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Yakin !'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href='cancelKonsul';
            }
        });
    })

    $('#btnLihatHasil').click(function(){
        Swal.fire({
            title:'Mohon Tunggu  ',
            text:'Hasil hanya bisa dilihat 1x, Unduh langsung hasil anda !',
            timer: 5000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading()
            }
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
                window.open('lihatHasil','_blank');
                window.location.href='cancelKonsul';
            }
        })
    })

    $('#formKonsul').submit(function(e){
        e.preventDefault();
        var id_gejala = $('#id_gejala').val();
        var id_tamu = $('#id_tamu').val();
        var pilihan = $("input[name='pilihanKonsul']:checked").val();
        $.ajax({
            method:'POST',
            dataType:'JSON',
            data:{id_gejala:id_gejala,id_tamu:id_tamu,pilihan:pilihan},
            url:'tambahKonsul',
            success:function(result){
                location.reload();
            }
        })
    })

})
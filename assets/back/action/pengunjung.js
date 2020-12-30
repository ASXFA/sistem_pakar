$(function(){
    $('#li-pengunjung').attr('class','sidebar-item selected');

    $('#table-tamu').DataTable({
        "processing": true,
        "serverSide": true, 
        "order":[],
        "ajax":{
            url:"tamuLists",
            type:"post",
        },
        "columnDefs":[
            {
                "targets":[-1],
                "orderable":false,
            },
        ],
    });

})
    function checkList(){
        var checkboxes = document.getElementsByClassName('checkbox-list');
        var check = null;
        var notAll = null;
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked == true) {
                    check = 1;
                }else{
                    notAll = 1;
                }
            }
            if(check == 1){
                $('.btnDeleteAll').show();
            }else{
                $('.btnDeleteAll').hide();
            }
            if(notAll==1){
                $('#customCheckAll').prop('checked', false);
            }else{

                $('#customCheckAll').prop('checked', true);
            }
            
    }
    function checkPin(id,url,checked){
        if(checked == 'checked'){
            $.ajax({
               type: "GET",
               url: url+"/removePin/"+id,
               success: function( result ) {
                    location.reload();
               }
           });
        }else{
            $.ajax({
               type: "GET",
               url: url+"/checkPin/"+id,
               success: function( result ) {
                    location.reload();
               }
           });
        }
    }
     function checkAll(ele) {
        var checkboxes = document.getElementsByClassName('checkbox-list');
        if (ele.checked) {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = true;
                }
            }
            $('.btnDeleteAll').show();
        } else {
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].type == 'checkbox') {
                    checkboxes[i].checked = false;
                }
            }
            $('.btnDeleteAll').hide();
        }
    }
    function changeStatus(id,value,module) {
        // return console.log(value);
        if(value == true){
            value = 1;
        }else{
            value = 0;
        }
        var token = document.getElementById("token").value;
        $.ajax({
            type: "POST",
            url: module+"/changeStatus",
            data:{
                '_token': token,
                'id': id,
                'status': value,
            },
            success: function( result ) {
            }
        });
   }
   function changeSort(id,sort,sort_more,module) {
    //    return console.log(module);
       var token = document.getElementById("token").value;
       $.ajax({
           type: "POST",
           url: module+"/changeSort",
           data:{
               '_token': token,
               'id': id,
               'sort': sort,
               'sort_more': sort_more,
           },
           success: function( result ) {
                location.reload();
           }
       });
  }
     function btnDeleteAll() {
        $('#modalDeleteAll').modal('show');
     }
     function deleteAll(module) {
        var checkboxes = document.getElementsByClassName('checkbox-list');
        var token = document.getElementById("token").value;
        var id = [];
            for (var i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked == true) {
                    if(checkboxes[i].value != 'on'){
                        id.push(checkboxes[i].value)
                    }
                }
            }
        $.ajax({
            type: "DELETE",
            url: module+"/delete/"+id,
            data:{
                '_token': token,
            },
            success: function( result ) {
                if(result == 1){
                    $('#modalDeleteAll').modal('hide');
                    $('#deleteSuccess').modal('show');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                }
            }   
        });
    }
    function cancelDelete(){
        $('#exampleModalScrollable').modal('hide');
        $('#modalDeleteAll').modal('hide');
    }
    function deleteFromTable(id){
        $('#exampleModalScrollable').modal('show');
        $('.confirmDelete').attr("id",id);
    }
    function deleteData(module) {
        var id = $('.confirmDelete').attr("id");
        var token = document.getElementById("token").value;
        $.ajax({
            type: "DELETE",
            url: module+"/delete/"+id,
            data:{
                '_token': token,
            },
            success: function( result ) {
                if(result == 1){
                    $('#exampleModalScrollable').modal('hide');
                    $('#deleteSuccess').modal('show');
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                }
            }   
        });
    }

    $(document).ready(function(){
        $('.select2').select2({
            multiple: true
        });
    });
    
        // function formfocus() {
        //     $('html, body').animate({ // สร้างการเคลื่อนไหว
        //         scrollTop: $(document.body).offset().top // ให้หน้าเพจเลื่อนไปทำตำแหน่งบนสุด
        //     }, 500);
        //     setTimeout(function(){
        // 	    document.getElementById('productCode').focus();
        //     }, 500);
        // }
        // window.onload = formfocus;
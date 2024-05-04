<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('inc_header')
    @php
        $memberName = "password"
    @endphp
</head>
<body>
    <div class="thetop"></div>
    @include('inc_topmenu')
    
    <!--------------- N A V - B A R --------------->
    <div class="navBK">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    <div class="col">
                        <ul class="bread-crumb">
                            <li><a href="/">หน้าแรก</a></li>
                            <li>บัญชีของฉัน</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!---------- M E M B E R :: M Y - A C C O U N T ---------->
    <div class="content-padding pad-foot">
        <div class="container-fluid">
            <div class="wrap-pad">
                <div class="row">
                    
                    @include('inc_membermenu')
                    
                    <div class="col-lg-9 col-12">
                        <div class="row">
                            <div class="col">
                                <div class="member-topic">
                                    <h3>เปลี่ยนรหัสผ่าน</h3>
                                </div> 
                            </div>
                        </div>
                        <form id="passwordForm" action="opi" method="POST">
                        <!---------- M E M B E R :: P A S S W O R D ---------->
                        <div class="profile-part">
                            <div class="row">
                                <div class="col">
                                    <div class="gray-header decor-none">
                                        <div class="gray-header-topic">ข้อมูลผู้ใช้งาน</div>
                                    </div> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-3 col-md-3 col-12">
                                    <div class="img-center pt-2"><img src="images/member/icon-password.png"></div>
                                </div>
                                <div class="col-lg-9 col-md-9 col-12">
                                    <div class="order-info">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">อีเมล</div>
                                            <div class="col-lg-9 col-md-9 col-12 form-group">{{$member->username}}</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">รหัสผ่านปัจจุบัน</div>
                                            <div class="col-lg-6 col-md-6 col-12 form-group"><input type="password" class="form-control" id="present_password" required></div>
                                            <strong id="invalidPresent" style="color: red">
                                            </strong>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">รหัสผ่านใหม่</div>
                                            <div class="col-lg-6 col-md-6 col-12 form-group"><input type="password" oninput="Pconfirm()" class="form-control" id="new_password" required></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-md-3 col-12">ยืนยันรหัสผ่าน</div>
                                            <div class="col-lg-6 col-md-6 col-12 form-group"><input type="password" oninput="Pconfirm()" class="form-control" id="conform_password" required></div>
                                            <strong id="invalidConform" style="color: red">
                                            </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100">
                            <div class="row">
                                <div class="col">
                                    <div class="content-center">
                                        <button class="buttonBK mt-2" type="submit"><i class="fas fa-edit"></i>บันทึก</button>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </form>
                            
                    </div>
                </div>
                
            </div>
                
        </div>
    </div>
    
    @include('inc_topbutton')
    @include('inc_footer')
<script>
    
    document.getElementById("passwordForm").addEventListener("submit",async function(event){
        event.preventDefault()
        var present_password = $('#present_password').val();
        var submit = 1;

        await $.ajax({
            type: "POST",
            url: "{{url('password/checkPassword')}}/"+present_password,
            data: {_token:'{{ csrf_token() }}'},
            success: function($data) {
                if($data != true){
                    $('#invalidPresent').html($data);
                    $('#present_password').attr('class','form-control is-invalid')
                    submit = 0;
                }else{
                    $('#invalidPresent').html("");
                    $('#present_password').attr('class','form-control')
                }
            }
        });


        var new_password = $('#new_password').val();
        var passwordConfirm = $('#conform_password').val();
        if(new_password != passwordConfirm){

            clearPsswordStyle();

            $('#conform_password').attr('class','form-control is-invalid')
            $('#invalidConform').html('รหัสผ่านใหม่ และ ยืนยันรหัสผ่าน ไม่ตรงกัน');
            submit = 0;
        }else{
            greenPsswordStyle();
        }

        if(submit != 1){ return }
        
        $.ajax({
            type: "POST",
            url: "{{url('password/changePassword')}}",
            data: {_token:'{{ csrf_token() }}',password: new_password},
            success: function($data) {
                if($data == true){
                    document.getElementById('passwordForm').reset();
                    clearPsswordStyle();
                }
            }
        });
        
});

function Pconfirm(v){
    var new_password = $('#new_password').val();
    var conform_password = $('#conform_password').val();
    if(conform_password==new_password){
            this.greenPsswordStyle();
            $('#invalidConform').html('');
    }else{
        this.clearPsswordStyle();
    }
}
function clearPsswordStyle(){
        $('#new_password').attr('style','');
        $('#conform_password').attr('style','');
}
function greenPsswordStyle(){
        $('#conform_password').attr('class','form-control')
        $('#new_password').attr('style','border-color:#25de4f!important');
        $('#conform_password').attr('style','border-color:#25de4f!important');
}
</script>
</body>
</html>
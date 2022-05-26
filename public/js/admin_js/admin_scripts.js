$(document).ready(function(){
    $('#current_pwd').keyup(function(){
        var current_pwd = $('#current_pwd').val();
        //alert(current_pwd);
        $.ajax({
            type:'post',
            url:'/admin/check-current-pwd',
            data:{current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#checkCurrentPwd").html("<font color=red>Le mot de passe saisi est incorrect</font>");
                }else if(resp == "true"){
                    $("#checkCurrentPwd").html("<font color=green>Le mot de passe saisi est correct</font>");
                }
            },error:function(){
                alert('Erreur')
            }
        })
    })


    $(".updateSectionStatus").click(function(){
        var status = $(this).text();
        var section_id = $(this).attr('section_id');
        $.ajax({
            type:'post',
            url: '/admin/update-section-status',
            data:{status: status,section_id:section_id},
            success:function(resp){
                alert(resp['status']);
                alert(resp['section_id']);
            },error:function(){
                alert("Erreur")
            }
        })
    })
});







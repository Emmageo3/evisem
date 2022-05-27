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
            data:{status:status,section_id:section_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#section-"+section_id).html("<a href='javascript:void(0)' class='updateSectionStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $(".updateCategoryStatus").click(function(){
        var status = $(this).text();
        var category_id = $(this).attr('category_id');
        $.ajax({
            type:'post',
            url: '/admin/update-category-status',
            data:{status:status,category_id:category_id},
            success:function(resp){
                if(resp['status']==0){
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus'>Inactif</a>")
                }else if(resp['status']==1){
                    $("#category-"+category_id).html("<a href='javascript:void(0)' class='updateCategoryStatus'>Actif</a>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $('#section_id').change(function(){
        var section_id = $(this).val();
        $.ajax({
            type:'post',
            url:'/admin/append-categories-level',
            data:{section_id:section_id},
            success:function(resp){
                $("#appendCategoriesLevel").html(resp)
            },error:function(){
                alert('Erreur');
            }
        })
    })
});







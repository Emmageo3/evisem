$(document).ready(function(){
   /* $("#sort").on('change', function(){
        this.form.submit();
    })*/

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $("#sort").on('change', function(){
        var sort = $(this).val()
        var url = $("#url").val()
        $.ajax({
            url:url,
            method:"post",
            data:{sort:sort,url:url},
            success:function(data){
                $('.filter_products').html(data)
            }
        })
    })


    $('#getPrice').change(function(){
        var size = $(this).val();
        if(size==""){
            alert("veuillez choisir une taille")
            return false
        }
        var product_id = $(this).attr('product-id')
       $.ajax({
           url:'/get-product-price',
           data:{size:size,product_id:product_id},
           type:'post',
           success:function(resp){
               if(resp['discounted_price']>0){
                    $(".getAttrPrice").html("<del>"+resp['product_price'] + " Fcfa</del>"+resp['discounted_price']+" Fcfa")
               }else{
                    $(".getAttrPrice").html(resp['product_price'] + " Fcfa")
               }
           },error:function(){
               alert('erreur')
           }
       })
    })


})

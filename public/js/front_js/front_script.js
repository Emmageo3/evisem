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
               if(resp['discount']>0){
                    $(".getAttrPrice").html("<del>"+resp['product_price'] + " Fcfa</del>"+resp['final_price']+" Fcfa")
               }else{
                    $(".getAttrPrice").html(resp['product_price'] + " Fcfa")
               }
           },error:function(){
               alert('erreur')
           }
       })
    })

    $(document).on('click','.btnItemUpdate', function(){
        if($(this).hasClass('qtyMinus')){
            var quantity = $(this).prev().val();
            if(quantity<=1){
                alert('Vous ne pouvez pas réduire la quantité à 0')
                return false
            }else{
                new_qty = parseInt(quantity)-1;
            }
        }
        if($(this).hasClass('qtyPlus')){
            var quantity = $(this).prev().prev().val();
            new_qty = parseInt(quantity)+1;
        }
        alert(new_qty)
    })


})

$(document).ready(function(){
   /* $("#sort").on('change', function(){
        this.form.submit();
    })*/

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


})

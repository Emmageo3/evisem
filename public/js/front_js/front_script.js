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
        var cartid = $(this).data('cartid')
        $.ajax({
            data:{"cartid":cartid,"qty":new_qty},
            url:'/update-cart-item-qty',
            type:'post',
            success:function(resp){
                if(resp.status==false)
                {
                    alert(resp.message)
                }
                $(".totalCartItems").html(resp.totalCartItems)
                $("#AppendCartItems").html(resp.view)
            }, error:function(){
                alert('erreur')
            }
        })
    })

    $(document).on('click','.btnItemDelete', function(){
        var cartid = $(this).data('cartid')
        var result = confirm("Voulez vous vraiment supprimer cet article ?")
        if(result){
            $.ajax({
                data:{"cartid":cartid},
                url:'/delete-cart-item',
                type:'post',
                success:function(resp){
                    $(".totalCartItems").html(resp.totalCartItems)
                    $("#AppendCartItems").html(resp.view)
                }, error:function(){
                    alert('erreur')
                }
            })
        }

    })

	$("#registerForm").validate({
			rules: {
				name: "required",
				mobile: {
					required: true,
					minlength: 9,
                    maxlength: 14,
                    digits: true,
				},
				email: {
					required: true,
					email: true,
                    remote:"check-email"
				},
				password: {
					required: true,
					minlength: 6
				}
			},
			messages: {
				name: "Veuillez entrer votre nom complet",
				mobile: {
					required: "Veuillez entrer votre numéro de téléphone",
					minlength: "Veuillez entrer un numéro de téléphone valide"
				},
				password: {
					required: "Veuillez entrer un mot de passe",
					minlength: "Votre mot de passe doit contenir au moins 6 caractères"
				},
				email: {
                    required: "Veuillez entrer une adresse email valide",
                    remote: "Cette adresse e-mail existe déja"
                }

			}
	});

	$("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            password: {
                required: "Veuillez entrer votre mot de passe",
                minlength: "Votre mot de passe doit contenir au moins 6 caractères"
            },
            email: {
                required: "Veuillez entrer une adresse email",
                email: "Veuillez entrer une adresse email valide"
            }

        }
    });

    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                accept: "[a-zA-Z]+"
            },
            mobile: {
                required: true,
                minlength: 9,
                maxlength: 14,
                digits: true,
            }
        },
        messages: {
            name: {
                required: "Veuillez entrer votre nom complet",
                accept: "Vous ne pouvez utiliser que des lettres"
            },
            mobile: {
                required: "Veuillez entrer votre numéro de téléphone",
                minlength: "Veuillez entrer un numéro de téléphone valide"
            },
            password: {
                required: "Veuillez entrer un mot de passe",
                minlength: "Votre mot de passe doit contenir au moins 6 caractères"
            },
            email: {
                required: "Veuillez entrer une adresse email valide",
                remote: "Cette adresse e-mail existe déja"
            }

        }
    });

    $("#current_pwd").keyup(function(){
        var current_pwd = $(this).val()
        $.ajax({
            type:'post',
            url: '/check-user-pwd',
            data: {current_pwd:current_pwd},
            success:function(resp){
                if(resp == "false"){
                    $("#checkPwd").html("<font color='red'>Votre mot de passe est incorrect</font>")
                }else if(resp == "true"){
                    $("#checkPwd").html("<font color='green'>Votre mot de passe est correct</font>")
                }
            },error:function(){
                alert("Erreur")
            }
        })
    })

    $("#passwordForm").validate({
        rules: {
            current_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            new_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20,
            },
            confirm_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo:"#new_pwd"
            }
        },
        messages: {
            current_pwd: {
                required: "Veuillez entrer votre mot de passe",
                accept: "Vous ne pouvez utiliser que des lettres"
            },
            new_pwd: {
                required: "Veuillez saisir un nouveau mot de passe",
                minlength: "Veuillez entrer un mot de passe valide"
            },
            confirm_pwd: {
                equalTo: "Veuillez saisir le meme mot de passe"
            }

        }
    });

})

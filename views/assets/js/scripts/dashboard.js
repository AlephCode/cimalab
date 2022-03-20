$(document).ready(function (){

    let i=0;

    $('.lab-amount').each(function (){
        i++;
        let amount = $(this).attr('value');
        let spanValue = $('.span-status'+i);
        let progressBar = $('.progress-bar'+i);

        let percent = amount / 7 * 100;
        progressBar.css('width',percent + '%');

        if(amount == 7){
            spanValue.html('Lleno');
            spanValue.css("background-color","#f5c6cb");
            spanValue.css("color","#721c24");
        }else{
            spanValue.html('Disponible');
            spanValue.css("background-color","#d4edda");
            spanValue.css("color","#155724");

        }
    });

});

$(document).on('click','.card_userList',function (){

    let input = $(this);
    let id = input.attr('value');

    console.log("ID laboratorio: " + id);
    let data = new FormData();

    data.append("modal_users_id",id);

    $.ajax({
        url:url+"views/ajax/ajax_dashboard.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success:function (request){
            console.log(request);

            let x = JSON.parse(request);

            let email = x.email;
            let chainEmails = "";
            for (let i = 0; i < x.length ; i++){
                console.log(x[i].email);
                chainEmails += x[i].email + "<br>";
            }

            $("#modal-usersList").html(chainEmails);

        }
    });

});

$(document).on('click','.card_userAdd',function (){


    let input = $(this);
    let email = input.attr('email');
    let id_laboratory = input.attr('value');

    console.log("email: " + email + " " + id_laboratory);

    let data =  new FormData;

    data.append("addUserInLab_email",email);
    data.append("addUserInLab_id_laboratory",id_laboratory);

    $.ajax({
        url:url+"views/ajax/ajax_dashboard.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success:function (request){
            console.log(request);
            window.location.reload();
        }
    });


});
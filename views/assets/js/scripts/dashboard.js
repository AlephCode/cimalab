//Al hacer click en el icono del ojo abre el modal y muestra las matriculas y la hora
$(document).on('click','.card_userList',function (){

    let input = $(this);
    let id = input.attr('value');

    // console.log("ID laboratorio: " + id);

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

            // const tiempoTranscurrido = Date.now();
            // const hoy = new Date(tiempoTranscurrido);
            // console.log(hoy.toDateString()); // "Sun Jun 14 2020");
            // console.log(x[0].time);


            let x = JSON.parse(request);

            let email = x.matricula;
            let time = x.time;

            let chainEmails = "";
            for (let i = 0; i < x.length ; i++){
                chainEmails += x[i].matricula +  "<br>";
            }
            let chainTime = "";
            for (let i = 0; i < x.length ; i++){
                chainTime += x[i].time.substring(0,5) +  "<br>";
            }

            $("#modal-usersList-matricula").html(chainEmails);
            $("#modal-usersList-time").html(chainTime);

        }
    });

});
//Esta funcion no funciona por ahora, queda pendiente solo era para pruebas
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

function updateCardsFunction(){
    $.ajaxSetup ({
        cache: false
    });


    var spinner = "Hola";

    var url = "http://localhost/cimalab/views/modules/cards.php";

    $("#result").html(spinner).load(url);
}

//======NO SE IMPLEMENTA YA QUE ES PARTE DE LA ALTERNATIVA PARA ACTUALIZAR LOS CARDS=====

/*En cuanto hago reload y llama a la funcion que se encarga de
actualizar el status y la barra de las tarjetas de los laboratorios*/
//
// let identificadorTiempoDeEspera;
//
// temporizadorDeRetraso();
//
// function temporizadorDeRetraso() {
//     identificadorTiempoDeEspera = setTimeout(funcionConRetraso, 100);
// }
//
// function funcionConRetraso() {
//
//     let i=0;
//
//     $('.lab-amount').each(function (){
//
//         i++;
//         let amount = parseInt($(this).attr('value'));
//         let spanValue = $('.span-status'+i);
//         let progressBar = $('.progress-bar'+i);
//         let limit =   parseInt($('.hidden_limit'+i).val());
//
//         let percent = amount / limit * 100;
//         progressBar.css('width',percent + '%');
//
//         // console.log(typeof amount );
//         if(amount >= limit){
//             spanValue.html('Lleno');
//             spanValue.css("background-color","#f5c6cb");
//             spanValue.css("color","#721c24");
//         }else{
//             spanValue.html('Disponible');
//             spanValue.css("background-color","#d4edda");
//             spanValue.css("color","#155724");
//
//         }
//     });
// }

/*Se llama en cuanto inicia la pagina y trae los cards y actualiza cada 5 segundos*/
// $(function() {
//      updateCardsFunction();
//      let identificadorIntervaloDeTiempo;
//
//      repetirCadaSegundo();
//
//      function repetirCadaSegundo() {
//          identificadorIntervaloDeTiempo = setInterval(mandarMensaje, 5000);
//      }
//
//      function mandarMensaje() {
//          $('#closeModalbtn').trigger('click');
//          updateCardsFunction();
//          temporizadorDeRetraso();
//
//      }
// });

//=================================END====================================


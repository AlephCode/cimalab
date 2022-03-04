$(document).ready(function (){

    let i=0;

    $('.lab-amount').each(function (){
        i++;
        let amount = $(this).attr('value');
        let spanValue = $('.span-status'+i);
        let progressBar = $('.progress-bar'+i);

        let percent = amount / 7 * 100;
        console.log(percent);
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
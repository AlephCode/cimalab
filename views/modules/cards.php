<script type="text/javascript">

    var mouseOnmove;

    var timeout;
    document.onmousemove = function(){
        clearTimeout(timeout);
        mouseOnmove = true;
        timeout = setTimeout(function(){
        mouseOnmove = false;
        }, 300);

    }


    function table(){
        const xhttp = new XMLHttpRequest();


        xhttp.onload = function(){

            if(!mouseOnmove){
                document.getElementById("table").innerHTML = this.responseText;
                updateCards();

            }


        }
        xhttp.open("GET", "views/modules/system.php");
        xhttp.send();
    }

    setInterval(function(){
        table();
    }, 1);


    function updateCards(){
        let i=0;

        $('.lab-amount').each(function (){

            i++;
            let amount = parseInt($(this).attr('value'));
            let spanValue = $('.span-status'+i);
            let progressBar = $('.progress-bar'+i);
            let limit =   parseInt($('.hidden_limit'+i).val());

            let percent = amount / limit * 100;
            progressBar.css('width',percent + '%');

            // console.log(typeof amount );
            if(amount >= limit){
                spanValue.html('Lleno');
                spanValue.css("background-color","#f5c6cb");
                spanValue.css("color","#721c24");
            }else{
                spanValue.html('Disponible');
                spanValue.css("background-color","#d4edda");
                spanValue.css("color","#155724");

            }
        });
    }

</script>
<div id="table">

</div>

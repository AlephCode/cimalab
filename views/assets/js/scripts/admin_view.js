$(document).on("click",".submit-lab_add",function () {

    let labName = $("#form-lab_name").val();
    let labCapacity = $("#form-lab_capacity").val();

    var data = new FormData();

    data.append("labName",labName);
    data.append("labCapacity",labCapacity);

    $.ajax({
        url:url+"views/ajax/ajax_admin_view.php",
        method: "POST",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success:function (request){
            alert("Se agrego");
        }

    });

});

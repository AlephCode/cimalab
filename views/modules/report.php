<?php
require_once "../../models/connection.php";
$id = 3;
$stmt = Conexion::connect()->prepare("SELECT *, DATE_FORMAT(time,'%h:%i') AS time FROM laboratories_users WHERE id_laboratory=:id");

$stmt->bindParam(":id",$id,PDO::PARAM_STR);

$stmt->execute();

$list =  $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<?php
ob_start()
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

<!--        Bootstrap-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
<!--    HEADER DEL DOCUMENTO-->

    <div class="row">

        <div class="col">
            Laboratorio: PECERA
        </div>
        <div class="col">
            <img src="http://localhost/cimalab/views/assets/img/navbar_logo.png" alt="logo_uabc" class="float-right" width="100">
        </div>
    </div>

<br><br><br>
    <div class="table-responsive">
        <table class="table table-striped" id="">
            <thead class="thead-dark">
            <tr>

                <th>#</th>
                <th>Matrícula</th>
                <th>Hora</th>

            </tr>
            </thead>

            <tbody>

            <?php foreach ($list as $key=> $value):?>


                <tr>

                    <td><?php echo ($key+1)?></td>
                    <td><?php echo $value['matricula']?></td>
                    <td><?php echo $value['time']?></td>

                </tr>

            <?php endforeach;?>

            </tbody>
        </table>

    </div>
    </body>
</html>

<?php


    $html = ob_get_clean();
//    echo $html;

    require_once "../../dompdf_1-2-2/dompdf/autoload.inc.php";
    use Dompdf\Dompdf;
    $dompdf = new Dompdf();

    $options = $dompdf->getOptions();
    $options->set(array('isRemoteEnabled'=>true));
    $dompdf->setOptions($options);

    $dompdf->loadHtml($html);
    $dompdf->setPaper("letter");
//    $dompdf->setPaper('A4','landscape');
    $dompdf->render();
    $dompdf->stream("reporte_.pdf",array("Attachment"=>false));
?>



<?php
require("abifunktsioonid.php");

if(isSet($_REQUEST["grupilisamine"] ))
{
    if (!empty($_REQUEST["uuegrupinimi"]))
    {
        lisaGrupp($_REQUEST["uuegrupinimi"]);
        header("Location: kaubaMuutmine.php");
        exit();
    }
    else
    {
       echo '<script>                
                alert("Viga: rida (uuegrupinimi) peab olema täidetud!");
                window.location.href = "kaubaMuutmine.php";
             </script>';
    }
}



if(isSet($_REQUEST["kaubalisamine"])){
    if (!empty($_REQUEST["nimetus"]) && $_REQUEST["hind"] !== null)
    {
        lisaKaup($_REQUEST["nimetus"], $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);  header("Location: kaubaMuutmine.php");
        exit();
    }
    else
    {
        echo '<script>                
                alert("Viga: rida (nimetus) ja (hind) peab olema täidetud!");
                window.location.href = "kaubaMuutmine.php";
             </script>';
    }

}

if(isSet($_REQUEST["kustutusid"])){
    kustutaKaup($_REQUEST["kustutusid"]);
}

if(isSet($_REQUEST["muutmine"])){
    muudaKaup($_REQUEST["muudetudid"], $_REQUEST["nimetus"],
        $_REQUEST["kaubagrupi_id"], $_REQUEST["hind"]);
}

$sorttulp="nimetus";
$otsisona="";
if(isSet($_REQUEST["sort"])){
    $sorttulp=$_REQUEST["sort"];
}
if(isSet($_REQUEST["otsisona"])){
    $otsisona=$_REQUEST["otsisona"];
}
$kaubad=kysiKaupadeAndmed($sorttulp, $otsisona);



?>

<!DOCTYPE html>
<html lang="et">

<head>
    <title>Kaupade leht</title>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta charset="UTf-8">
    <link rel="stylesheet" type="text/css" href="css/form_style.css">
    <link rel="stylesheet" type="text/css" href="css/style_second_design.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
<body>
<header>
    <h1>Ivanenko leht</h1>
    <h2>KaubaMuutmine</h2>
</header>
<div class="container-fluid">
<div class="row">
<div class="col-md">
<div class="card">
<form action="kaubaMuutmine.php">

    <div class="card-body">
        <div class="card-title" style="font-size: x-large">Kaupade loetelu</div>
        <div class="card-text">
            Otsi: <input type="text" name="otsisona" />
            <button onClick="window.location.reload();" class="btn btn-info">Reload</button>
        </div>
        </br>


        <table class="table table-striped table-bordered">
            <tr>
                <th width="15%">
                    Haldus
                </th>
                <th>
                    <a href="kaubaMuutmine.php?sort=nimetus">Nimetus</a>
                </th>
                <th>
                    <a href="kaubaMuutmine.php?sort=grupinimi">Kaubagrupp</a>
                </th>
                <th>
                    <a href="kaubaMuutmine.php?sort=hind">Hind</a>
                </th>
            </tr>
            <?php foreach($kaubad as $kaup): ?>
                <tr>
                    <?php if(isSet($_REQUEST["muutmisid"]) &&
                        intval($_REQUEST["muutmisid"])==$kaup->id): ?>
                    <td>
                        <input type="submit" name="muutmine" value="Muuda" class="btn btn-warning"/>
                        <input type="submit" name="katkestus" value="Katkesta" class="btn btn-info" />
                        <input type="hidden" name="muudetudid" value="<?=$kaup->id ?>" />
                    </td>
                    <td>
                        <label>
                            <input type="text" name="nimetus" value="<?=$kaup->nimetus ?>" />
                        </label>
                    </td>
                    <td>
                        <?php
                        echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id", $kaup->kaubagrupi_id);
                        ?>
                    </td>
                    <td>
                        <label>
                            <input type="text" name="hind" value="<?=$kaup->hind ?>" />
                        </label>
                    </td>  <?php else: ?>
                    <td>
                        <a href="kaubaMuutmine.php?kustutusid=<?=$kaup->id ?>"  onclick="return confirm('Kas ikka soovid kustutada?')">
                            <button type="button" class="btn btn-danger">Delete</button></a>
                        <a href="kaubaMuutmine.php?muutmisid=<?=$kaup->id ?>">
                            <button type="button" class="btn btn-warning">Modify</button></a>
                    </td>
                    <td><?=$kaup->nimetus ?></td>
                    <td><?=$kaup->grupinimi ?></td>
                    <td><?=$kaup->hind ?></td>
                <?php endif ?>
                </tr>

            <?php endforeach; ?>
        </table>
    </div>
</form>
</div>
</div>
</div>
    <br>
<div class="row">
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <form action="kaubaMuutmine.php">
                <dl>
                <div class="card-title" style="font-size: x-large">Kauba lisamine</div>
                <dt>Nimetus:</dt>
                <dd>
                <input type="text" name="nimetus" class="form-control" />
                </dd>
                <dt>Kaubagrupp:</dt>
                <dd>
                    <?php
                    echo looRippMenyy("SELECT id, grupinimi FROM kaubagrupid",   "kaubagrupi_id");
                    ?>
                </dd>
                <dt>Hind:</dt>
                <dd>
                <input type="text" name="hind" class="form-control"/>
                </dd>
                </dl>
                <input type="submit" name="kaubalisamine" value="Lisa kaup" class="btn btn-success" />
                </form>
            </div>
        </div>
    </div>
    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <form action="kaubaMuutmine.php">
                    <div class="card-title" style="font-size: x-large">Grupi lisamine</div>
                        <input type="text" name="uuegrupinimi" class="form-control"/>
                    <p></p>
                    <input type="submit" name="grupilisamine" value="Lisa grupp" class="btn btn-success"/>
                </form>
            </div>
        </div>
    </div>
</div>
</div>


</body>
</html>
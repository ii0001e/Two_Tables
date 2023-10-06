<?php
 require("abifunktsioonid.php");
 $kaubad=kysiKaupadeAndmed();
?>
<!DOCTYPE html>
<html lang="et">
 <head>
 <title>Kaupade leht</title>
 <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />  </head>
 <body>
 <table>
 <tr>
 <th>Nimetus</th>
 <th>Kaubagrupp</th>
 <th>Hind</th>
 </tr>
 <?php foreach($kaubad as $kaup): ?>
 <tr>
 <td><?=$kaup->nimetus ?></td>
 <td><?=$kaup->grupinimi ?></td>
 <td><?=$kaup->hind ?></td>
 </tr>
 <?php endforeach; ?>
 </table>
 </body>
</html>
<?php $this->layout('template', ['title' => $paja['nimi']]) ?>

<?php
  $start = new DateTime($paja['paj_alkaa']);
  $end = new DateTime($paja['paj_loppuu']);
?>

<h1><?=$paja['nimi']?></h1>
<div><?=$paja['kuvaus']?></div><br>
<div>Alkaa: <?=$start->format('j.n.Y G:i')?></div>
<div>Loppuu: <?=$end->format('j.n.Y G:i')?></div>

<?php
   if ($loggeduser) {
    if (!$osallistuminen) {
      echo "<div class='flexarea'><a href='osallistu?id=$paja[idpaja]' class='button'>OSALLISTU PAJAAN</a></div>";    
    } else {
      echo "<div class='flexarea'>";
      echo "<div>Olet osallistumassa pajaan!</div>";
      echo "<a href='peru?id=$paja[idpaja]' class='button'>PERU PAJAAN OSALLISTUMINEN</a>";
      echo "</div>";
    }
  }

?>



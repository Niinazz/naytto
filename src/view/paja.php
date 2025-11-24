<?php $this->layout('template', ['title' => $paja['nimi']]) ?>

<?php
  $start = new DateTime($paja['paj_alkaa']);
  $end = new DateTime($paja['paj_loppuu']);
?>

<h1><?=$paja['nimi']?></h1>
<div><?=$paja['kuvaus']?></div>
<div>Alkaa: <?=$start->format('j.n.Y G:i')?></div>
<div>Loppuu: <?=$end->format('j.n.Y G:i')?></div>

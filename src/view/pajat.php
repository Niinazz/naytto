<?php $this->layout('template', ['title' => 'Tulevat joulupajat']) ?>

<h1>Vuoden 2025 Tonttulan joulupajat🌟</h1>

<?php if (!isset($_SESSION['user'])): ?>
    <div class="info">Kirjaudu sisään osallistuaksesi pajoihin 🎄</div>
<?php endif; ?>




<div class='pajat'>
<?php

foreach ($pajat as $paja) {

  $start = new DateTime($paja['paj_alkaa']);
  $end = new DateTime($paja['paj_loppuu']);

  echo "<div>";
    echo "<div>♡ $paja[nimi]</div>";
    echo "<div>" . $start->format('j.n.Y') . "-" . $end->format('j.n.Y') . "</div>";
    echo "<div><a href='paja?id=" . $paja['idpaja'] . "'>Avaa</a></div>";
  echo "</div>";


}

?>
</div>

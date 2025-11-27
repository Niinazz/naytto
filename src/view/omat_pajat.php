<?php $this->layout('template', ['title' => 'Omat pajat']) ?>

<h1>Omat ilmoittautumisesi</h1>

<?php if (empty($pajat)): ?>
    <p>Et ole ilmoittautunut vielä mihinkään pajaan.</p>
<?php else: ?>
    <div class="pajat">
    <?php foreach ($pajat as $paja): 
        $start = new DateTime($paja['paj_alkaa']);
        $end = new DateTime($paja['paj_loppuu']);
    ?>
        <div>
            <div><?=$paja['nimi']?></div>
            <div><?= $start->format('j.n.Y') ?> - <?= $end->format('j.n.Y') ?></div>
            <div><a href="paja?id=<?=$paja['idpaja']?>">Lisätietoa</a></div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>


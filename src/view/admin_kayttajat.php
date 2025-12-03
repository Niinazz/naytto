<?php $this->layout('template', ['title' => 'Käyttäjien hallinta']) ?>

<h1>Palvelun käyttäjät</h1>

<table border="1" cellpadding="5">
  <tr>
    <th>ID</th>
    <th>Sähköposti</th>
    <th>Ylläpitäjä</th>
    <th>Vahvistettu</th>
  </tr>
  <?php foreach ($users as $user): ?>
    <tr>
      <td><?= htmlspecialchars($user['id']) ?></td>
      <td><?= htmlspecialchars($user['email']) ?></td>
      <td><?= $user['admin'] ? 'Kyllä' : 'Ei' ?></td>
      <td><?= $user['vahvistettu'] ? 'Kyllä' : 'Ei' ?></td>
    </tr>
  <?php endforeach; ?>
</table>

<p><a href="<?= htmlspecialchars($config['urls']['baseUrl']) ?>">← Takaisin etusivulle ♡ </a></p>


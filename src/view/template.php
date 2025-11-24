<!DOCTYPE html>
<html lang="fi">
  <head>
        <link href="styles/styles.css" rel="stylesheet">
    <title>Joulupajat- <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
  </head>
  <body>
       <header>
      <h1><a href="<?=BASEURL?>">Tonttulan Joulupajat</a></h1>
    </header>

    <section>
      <?=$this->section('content')?>
    </section>
    <footer>
      <hr>
      <div>Pajat by Niina</div>
    </footer>
  </body>
</html>

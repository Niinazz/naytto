<!DOCTYPE html>
<html lang="fi">
<head>
    <link href="styles/styles.css" rel="stylesheet">
    <title>Joulupajat- <?=$this->e($title)?></title>
    <meta charset="UTF-8">    
</head>
<body>
    <header>
        <h1><a href="<?=BASEURL?>">Tonttulan joulupajat</a></h1>
        <div class="profile">
            <?php
              if (isset($_SESSION['user'])) {
                echo "<div>$_SESSION[user]</div>";
                echo "<div><a href='logout'>Kirjaudu ulos</a></div>";
              } else {
                echo "<div><a href='kirjaudu'>Kirjaudu</a></div>";
              }
            ?>
        </div>
    </header>

    <section>
      <?=$this->section('content')?>
    </section>

    <footer>
      <hr>
      <div>Pajat by Niina</div>
    </footer>

    <!-- 🎄 Lumisade alkaa tästä -->
    <canvas id="snow"></canvas>
    <script>
    const canvas = document.getElementById("snow");
    const ctx = canvas.getContext("2d");

    function resize() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
    }
    resize();
    window.onresize = resize;

    const flakes = [];
    for (let i = 0; i < 80; i++) {
        flakes.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            r: Math.random() * 3 + 1,
            d: Math.random() + 1
        });
    }

    function drawSnow() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = "white";
        ctx.beginPath();
        for (let i = 0; i < flakes.length; i++) {
            const f = flakes[i];
            ctx.moveTo(f.x, f.y);
            ctx.arc(f.x, f.y, f.r, 0, Math.PI * 2, true);
        }
        ctx.fill();
        updateSnow();
    }

    let angle = 0;

    function updateSnow() {
        angle += 0.01;
        for (let i = 0; i < flakes.length; i++) {
            const f = flakes[i];
            f.y += Math.pow(f.d, 2) + 1;
            f.x += Math.sin(angle) * 0.5;

            if (f.y > canvas.height) {
                flakes[i] = {
                    x: Math.random() * canvas.width,
                    y: 0,
                    r: f.r,
                    d: f.d
                };
            }
        }
    }

    setInterval(drawSnow, 30);
    </script>
</body>
</html>


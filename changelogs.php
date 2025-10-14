<?php
// changelogs.php

$filename = 'changelogs.txt';
$changelogs = [];

if (file_exists($filename)) {
  $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lines as $line) {
    list($version, $date, $changesRaw) = explode('|', $line);
    $changes = explode(';', $changesRaw);
    $changelogs[] = [
      'version' => trim($version),
      'date' => trim($date),
      'changes' => array_map('trim', $changes)
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clever | Changelogs</title>
<link rel="icon" href="https://assets.clever.com/launchpad/4cfe59076/favicon.ico" type="image/x-icon">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#000;color:#f5f5f5;min-height:100vh;padding:2rem}
.wrap{max-width:1100px;margin:auto;display:grid;gap:1.5rem}
header{display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem}
h1{font-size:1.2rem;font-weight:700;background:linear-gradient(45deg,#fff,#aaa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:.5rem}
#version-indicator{font-weight:400;color:#aaa;font-size:2rem;}
.search-container{text-align:center;margin-bottom:1rem}
.search-container input{width:35%;padding:.75rem 1rem;font-size:1rem;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.05);color:#fff;border-radius:25px;outline:none;transition:.3s}
.search-container input:focus{border-color:#8aa0ff;background:rgba(255,255,255,.1)}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem}
.card{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:15px;padding:1rem;transition:.3s;overflow:hidden;cursor:pointer}
.card:hover{transform:translateY(-5px);box-shadow:0 10px 20px rgba(0,0,0,.5)}
.card h2{font-size:1.2rem;font-weight:700;background:linear-gradient(45deg,#fff,#aaa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:.5rem}
.card p{margin:4px 0;color:#ccc;opacity:.85}
.divider{height:1px;background:rgba(255,255,255,.1);margin:8px 0}
.change-list{list-style:none;padding-left:0}
.change-list li{position:relative;padding-left:1.2em;margin-bottom:.3em}
.change-list li::before{content:"•";position:absolute;left:0;color:#8aa0ff}
</style>
</head>
<body>
<div class="wrap">
<header>
  <div style="display:flex; align-items:center; gap:.5rem;">
    <h1 style="font-size:2rem;">Changelogs |</h1>
    <h1 id="version-indicator">Version: ...</h1>
  </div>
</header>

<div class="search-container">
  <input type="text" id="search" placeholder="Search changelogs..." onkeyup="filterLogs()">
</div>

<div class="grid" id="changelog-grid">
  <?php foreach ($changelogs as $log): ?>
    <div class="card">
      <h2><?= htmlspecialchars($log['version']); ?></h2>
      <p><strong>Date:</strong> <?= htmlspecialchars($log['date']); ?></p>
      <div class="divider"></div>
      <ul class="change-list">
        <?php foreach ($log['changes'] as $change): ?>
          <li><?= htmlspecialchars($change); ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endforeach; ?>
</div>
</div>

<script>
/* Reload page once on first visit */
(function(){
  if(window.localStorage){
    if(!localStorage.getItem('firstLoad')){
      localStorage['firstLoad']=true;
      location.reload();
    } else {
      localStorage.removeItem('firstLoad');
    }
  }
})();

function filterLogs() {
  const input = document.getElementById('search');
  const filter = input.value.toLowerCase();
  const cards = document.querySelectorAll('.card');
  cards.forEach(card => {
    const text = card.innerText.toLowerCase();
    card.style.display = text.includes(filter) ? '' : 'none';
  });
}

/* Fetch version from GitHub with timestamp and formatted time */
const ts = () => Date.now();
const versionURL = `https://raw.githubusercontent.com/Calvin99Cooler/bazinga-games/main/version.txt?t=${ts()}`;

fetch(versionURL)
  .then(res => res.text())
  .then(v => {
    const now = new Date();
    const options = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: '2-digit' };
    const formatted = now.toLocaleString(undefined, options);
    document.getElementById('version-indicator').textContent =
      `Version: ${v.trim()}`;
  })
  .catch(() => {
    document.getElementById('version-indicator').textContent = 'Version: unavailable';
  });
</script>

<script>
(function() {
  const homepage = "https://bazinga.great-site.net/";
  const allowedDomain = "https://bazinga.great-site.net/";
  const referrer = document.referrer;
  if (referrer && !referrer.startsWith(allowedDomain)) {
    window.location.replace(homepage);
  }
})();
</script>
</body>
</html>

<?php
// File to store recommendations
$file = "recommend.txt";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $gameName = trim($_POST['game_name']);
    $why = trim($_POST['why']);

    if (strlen($gameName) > 20) {
        $error = "The game name must be 20 characters or less.";
    } elseif (strlen($why) > 100) {
        $error = "The reason must be 100 characters or less.";
    } elseif (!empty($gameName) && !empty($why)) {
        $line = $gameName . " | " . $why . PHP_EOL;
        file_put_contents($file, $line, FILE_APPEND | LOCK_EX);

        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='refresh' content='10;url=index.html'>
            <title>Thank You</title>
            <style>
                *{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
                body{background:#000;color:#f5f5f5;display:flex;justify-content:center;align-items:center;height:100vh}
                .message{background:rgba(255,255,255,.05);padding:2rem 3rem;border-radius:15px;text-align:center;box-shadow:0 10px 20px rgba(0,0,0,.5)}
                .message h2{font-size:1.5rem;font-weight:700;background:linear-gradient(45deg,#fff,#aaa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:1rem}
                .message p{color:#ccc}
            </style>
        </head>
        <body>
            <div class='message'>
                <h2>Thank you! Your recommendation has been saved.</h2>
                <p>You will be redirected to the homepage in 10 seconds...</p>
            </div>
        </body>
        </html>";
        exit;
    } else {
        $error = "Please fill out both fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Recommend a Game</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#000;color:#f5f5f5;min-height:100vh;padding:2rem;display:flex;justify-content:center;align-items:center}
form{background:rgba(255,255,255,.05);padding:2rem;border-radius:15px;box-shadow:0 10px 20px rgba(0,0,0,.5);width:320px;text-align:center}
form h2{font-size:1.8rem;font-weight:700;background:linear-gradient(45deg,#fff,#aaa);-webkit-background-clip:text;-webkit-text-fill-color:transparent;margin-bottom:1.5rem}
input[type="text"], textarea{width:100%;padding:.75rem 1rem;margin:8px 0;border-radius:25px;border:1px solid rgba(255,255,255,.2);background:rgba(255,255,255,.05);color:#fff;outline:none;font-size:1rem}
input[type="text"]:focus, textarea:focus{border-color:rgba(255,255,255,.4)}
input[type="submit"]{width:100%;padding:.75rem 1rem;margin-top:1rem;border:none;border-radius:25px;background:linear-gradient(45deg,#fff,#aaa);color:#000;font-weight:600;cursor:pointer;transition:transform .3s,box-shadow .3s}
input[type="submit"]:hover{transform:translateY(-3px);box-shadow:0 5px 15px rgba(0,0,0,.5)}
small{display:block;margin-top:4px;color:#888}
.error{color:#ff4d4d;margin-bottom:8px;text-align:center}
</style>

<script>
(function() {
    if (window.localStorage) {
        if (!localStorage.getItem('firstLoad')) {
            localStorage['firstLoad'] = true;
            location.reload();
        } else {
            localStorage.removeItem('firstLoad');
        }
    }
})();
</script>
</head>
<body>

<form action="" method="POST">
    <h2>Recommend a Game</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <label for="game_name">Game Name:</label>
    <input type="text" id="game_name" name="game_name" maxlength="20" required>
    <small>Max 20 characters</small>

    <label for="why">Why do you want this game?</label>
    <textarea id="why" name="why" rows="4" maxlength="100" required></textarea>
    <small>Max 100 characters</small>

    <input type="submit" value="Submit">
</form>

</body>
<script>
(function() {
  const homepage = "https://bazinga.great-site.net/";
  const allowedDomain = "https://bazinga.great-site.net/";

  // Get the referring URL
  const referrer = document.referrer;

  // If the referrer exists and is NOT from your domain, redirect
  if (referrer && !referrer.startsWith(allowedDomain)) {
    window.location.replace(homepage);
  }
})();
</script>
</html>

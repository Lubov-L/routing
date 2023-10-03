<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
Index Page
<div>
    Load
    <div>
        <form action="/posts" method="Post">
            <label>
                <input type="text" placeholder="value" name="title">
            </label>
            <label>
                <input type="submit">
            </label>
        </form>
    </div>
    <div>
        This is title
        <div>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
        </div>
    </div>
</div>
</body>
</html>
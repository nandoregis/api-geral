<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <title>{@title}</title>
</head>
<body>
    <h2>{@texto}</h2>
    <form method="POST">
        <input type="text" name="user">
        <input type="password" name="pass" id="">
        </br>
        <button type="submit">
            Entrar
        </button>
    </form>
    {@message}
</body>
</html>
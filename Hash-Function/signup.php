<!DOCTYPE html>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <form method="POST" action="process.php">
            <label>Username : </label>
            <input type="text" name="username"><br><br>
            <label>Password : </label>
            <input type="password" name="password">
            <br><br>
            <input type="hidden" name="signupsave" value="0">
            <button onclick="submit">Kumpulkan</button>
        </form>
    </body>
</html>
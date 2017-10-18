<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        .page_not_found__wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: center;
            font-size: 100px;
        }

        p {
            margin: 0;
        }

        .e_404 {
            color: red;
        }
    </style>
</head>
<body>
<div class="page_not_found__wrapper">
    <p class="e_404"><?= $code ?></p>
    <p><?= $message ?></p>
</div>
</body>
</html>
<body>

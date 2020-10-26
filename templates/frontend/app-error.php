<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>
<body>
<h1>An Error occured</h1>
<dl>
    <dt>Code</dt>
    <dd><?= $exception->getCode() ?></dd>
    <dt>Message</dt>
    <dd><?= $exception->getMessage() ?></dd>
    <dt>File</dt>
    <dd><?= $exception->getFile() ?></dd>
    <dt>Line</dt>
    <dd><?= $exception->getLine() ?></dd>
</dl>
</body>
</html>
<?php
echo json_encode(
    [
        'carreras' => $carreras,
        'ident' => 1
    ],
    JSON_UNESCAPED_UNICODE
);
<?php
echo json_encode(
    [
        'directores' => $directores,
        'ident' => 1
    ],
    JSON_UNESCAPED_UNICODE
);
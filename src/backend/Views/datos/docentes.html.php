<?php
echo json_encode(
    [
        'docentes' => $docentes,
        'ident' => 1
    ],
    JSON_UNESCAPED_UNICODE
);
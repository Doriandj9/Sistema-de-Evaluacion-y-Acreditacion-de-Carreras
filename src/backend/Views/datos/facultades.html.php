<?php
echo json_encode(
    [
        'facultades' => $facultades,
        'ident' => 1
    ],
    JSON_UNESCAPED_UNICODE
);
<?php
echo json_encode(
    [
        'periodoAcademico' => $periodoAcademico,
        'ident' => 1
    ],
    JSON_UNESCAPED_UNICODE
);
<?php

// Config SMTP
// Имя пользователя для SMTP авторизации
define( 'SMTP_USER', 'mail@mail.ru' );
// Пароль пользователя для SMTP авторизации
define( 'SMTP_PASS', 'mail_password' );
// Хост почтового сервера
define( 'SMTP_HOST', 'smtp.yandex.ru' );
// Обратный Email
define( 'SMTP_FROM', 'mail@mail.ru' );
// Имя для обратного мыла
define( 'SMTP_NAME', 'Site Name' );
// Номер порта (25, 465, 587)
define( 'SMTP_PORT', '465' );
// Тип шифиования (ssl или tls)
define( 'SMTP_SECURE', 'ssl' );
// Включение/отключение шифрования
define( 'SMTP_AUTH', true );
// Режим отладки (0, 1, 2)
define( 'SMTP_DEBUG', 0 );

// Let's log!
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DEBUG_LOG', true );
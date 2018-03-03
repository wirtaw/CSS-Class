<?php

ob_start();

/* Функция mkdir не поддерживает рекурсии в версии PHP на Yahoo! Web Hosting. */

function mkdir_r( $dir_name, $rights=0777 ) {
   $dirs = explode( "/", $dir_name );
   $dir = "";
   foreach ( $dirs as $part ) {
       $dir .= $part . "/";
       if ( !is_dir( $dir ) && strlen( $dir ) > 0 )
           mkdir( $dir, $rights );
   }
}

/* Список, расширений файлов, которые будут сжиматься. */

$known_content_types = array(
    "htm"  => "text/html",
    "html" => "text/html",
    "js"   => "text/javascript",
    "css"  => "text/css",
    "xml"  => "text/xml",
    "gif"  => "image/gif",
    "jpg"  => "image/jpeg",
    "jpeg" => "image/jpeg",
    "png"  => "image/png",
    "txt"  => "text/plain"
);

/* Получаем путь, запрошенного файла. */

if ( !isset( $_GET["uri"] ) ) {
    header( "HTTP/1.1 400 Bad Request" );
    echo( "<html><body><h1>HTTP 400 - Bad Request</h1></body></html>" );
    exit;
}

/* Проверяем наличие запрошенного файла, возвращаем HTTP 404, если надо. */

if (($src_uri = realpath( $_GET["uri"] )) === false) {
    /* The file does not exist */
    header( "HTTP/1.1 404 Not Found" );
    echo( "<html><body><h1>HTTP 404 - Not Found</h1></body></html>" );
    exit;
}

/* Безопасность: проверяем чтобы файл лежал в корневом каталоге. */

$doc_root = realpath( "." );

if (strpos($src_uri, $doc_root) !== 0) {
    header( "HTTP/1.1 403 Forbidden" );
    echo( "<html><body><h1>HTTP 403 - Forbidden</h1></body></html>" );
    exit;
}

/* Устанавливаем заголовки ответа HTTP,
чтобы клиент кешировал ресурс. */

$file_last_modified = filemtime( $src_uri );
header( "Last-Modified: " . date( "r", $file_last_modified ) );

$max_age = 300 * 24 * 60 * 60; // 300 days

$expires = $file_last_modified + $max_age;
header( "Expires: " . date( "r", $expires ) );

$etag = dechex( $file_last_modified );
header( "ETag: " . $etag );

$cache_control = "must-revalidate, proxy-revalidate, max-age=" . $max_age . ", s-maxage=" . $max_age;
header( "Cache-Control: " . $cache_control );

/* Проверяем, если клиент может использовать прокешированную
версию, возвращаем HTTP 304. */

if ( function_exists( "http_match_etag" ) && function_exists( "http_match_modified" ) ) {
    if ( http_match_etag( $etag ) || http_match_modified( $file_last_modified ) ) {
        header( "HTTP/1.1 304 Not Modified" );
        exit;
    }
} else {
    error_log( "The HTTP extensions to PHP does not seem to be installed..." );
}

/* Извлекаем директорию, имя файла и расширение
файла из параметра "uri". */

$uri_dir = "";
$file_name = "";
$content_type = "";

$uri_parts = explode( "/", $src_uri );

for ( $i=0 ; $i<count( $uri_parts ) - 1 ; $i++ )
    $uri_dir .= $uri_parts[$i] . "/";

$file_name = end( $uri_parts );

$file_parts = explode( ".", $file_name );
if ( count( $file_parts ) > 1 ) {
    $file_extension = end( $file_parts );
    $content_type = $known_content_types[$file_extension];
}

/*
Получаем целевой файл
Если браузер принимает кодировку gzip, будем сжимать файл
*/

$dst_uri = $src_uri;

$compress = true;

/* Будем сжимать только текстовые файлы */

$compress = $compress && ( strpos( $content_type, "text" ) !== false );

/* В заключение, если клиент посылает нам корректный Accept-encoding: header value... */

$compress = $compress && ( strpos( $_SERVER["HTTP_ACCEPT_ENCODING"], "gzip" ) !== false );

if ( $compress ) {
    $gz_uri = "tmp/gzip/" . $src_uri . ".gz";

    if ( file_exists( $gz_uri ) ) {
        $src_last_modified = filemtime( $src_uri );
        $dst_last_modified = filemtime( $gz_uri );
        // The gzip version of the file exists, but it is older
        // than the source file. We need to recreate it...
        if ( $src_last_modified > $dst_last_modified )
            unlink( $gz_uri );
    }

    if ( !file_exists( $gz_uri ) ) {
        if ( !file_exists( "tmp/gzip/" . $uri_dir ) )
            mkdir_r( "tmp/gzip/" . $uri_dir );
        $error = false;
        if ( $fp_out = gzopen( $gz_uri, "wb" ) ) {
            if ( $fp_in = fopen( $src_uri, "rb" ) ) {
                while( !feof( $fp_in ) )
                    gzwrite( $fp_out, fread( $fp_in, 1024*512 ) );
                fclose( $fp_in );
            } else {
                $error = true;
            }
            gzclose( $fp_out );
        } else {
            $error = true;
        }

        if ( !$error ) {
            $dst_uri = $gz_uri;
            header( "Content-Encoding: gzip" );
        }
    } else {
        $dst_uri = $gz_uri;
        header( "Content-Encoding: gzip" );
    }
}

/* Выводим целевой файл и устанавливаем HTTP заголовки */

if ( $content_type )
    header( "Content-Type: " . $content_type );

header( "Content-Length: " . filesize( $dst_uri ) );
readfile( $dst_uri );

ob_end_flush();

?>
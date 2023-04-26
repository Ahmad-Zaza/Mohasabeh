<?php return array (
  '-lfm' => 
  array (
    'use_package_routes' => true,
    'middlewares' => 
    array (
      0 => 'web',
      1 => '\\crocodicstudio_voila\\crudbooster\\middlewares\\CBBackend',
    ),
    'prefix' => 'laravel-filemanager',
    'urls_prefix' => '',
    'allow_multi_user' => true,
    'allow_share_folder' => true,
    'user_field' => 
    Closure::__set_state(array(
    )),
    'base_directory' => 'storage/app',
    'images_folder_name' => 'uploads',
    'files_folder_name' => 'uploads',
    'shared_folder_name' => 'shares',
    'thumb_folder_name' => 'thumbs',
    'images_startup_view' => 'grid',
    'files_startup_view' => 'list',
    'rename_file' => false,
    'alphanumeric_filename' => true,
    'alphanumeric_directory' => true,
    'should_validate_size' => false,
    'max_image_size' => 50000,
    'max_file_size' => 50000,
    'should_validate_mime' => false,
    'valid_image_mimetypes' => 
    array (
      0 => 'image/jpeg',
      1 => 'image/pjpeg',
      2 => 'image/png',
      3 => 'image/gif',
      4 => 'image/svg+xml',
    ),
    'valid_file_mimetypes' => 
    array (
      0 => 'image/jpeg',
      1 => 'image/pjpeg',
      2 => 'image/png',
      3 => 'image/gif',
      4 => 'image/svg+xml',
      5 => 'application/pdf',
      6 => 'text/plain',
    ),
    'thumb_img_width' => 200,
    'thumb_img_height' => 200,
    'file_type_array' => 
    array (
      'pdf' => 'Adobe Acrobat',
      'doc' => 'Microsoft Word',
      'docx' => 'Microsoft Word',
      'xls' => 'Microsoft Excel',
      'xlsx' => 'Microsoft Excel',
      'zip' => 'Archive',
      'gif' => 'GIF Image',
      'jpg' => 'JPEG Image',
      'jpeg' => 'JPEG Image',
      'png' => 'PNG Image',
      'ppt' => 'Microsoft PowerPoint',
      'pptx' => 'Microsoft PowerPoint',
    ),
    'file_icon_array' => 
    array (
      'pdf' => 'fa-file-pdf-o',
      'doc' => 'fa-file-word-o',
      'docx' => 'fa-file-word-o',
      'xls' => 'fa-file-excel-o',
      'xlsx' => 'fa-file-excel-o',
      'zip' => 'fa-file-archive-o',
      'gif' => 'fa-file-image-o',
      'jpg' => 'fa-file-image-o',
      'jpeg' => 'fa-file-image-o',
      'png' => 'fa-file-image-o',
      'ppt' => 'fa-file-powerpoint-o',
      'pptx' => 'fa-file-powerpoint-o',
    ),
    'php_ini_overrides' => 
    array (
      'memory_limit' => '256M',
    ),
  ),
  'app' => 
  array (
    'name' => 'Laravel',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost',
    'timezone' => 'UTC',
    'locale' => 'en',
    'available_locales' => 
    array (
      0 => 'en',
      1 => 'ar',
    ),
    'fallback_locale' => 'en',
    'key' => 'base64:Cr5yOGbRp9upNSkANvf+UufEHBoiLWwkIwUDxuk8loA=',
    'cipher' => 'AES-256-CBC',
    'log' => 'daily',
    'log_level' => 'debug',
    'providers' => 
    array (
      0 => 'Illuminate\\Auth\\AuthServiceProvider',
      1 => 'Illuminate\\Broadcasting\\BroadcastServiceProvider',
      2 => 'Illuminate\\Bus\\BusServiceProvider',
      3 => 'Illuminate\\Cache\\CacheServiceProvider',
      4 => 'Illuminate\\Foundation\\Providers\\ConsoleSupportServiceProvider',
      5 => 'Illuminate\\Cookie\\CookieServiceProvider',
      6 => 'Illuminate\\Database\\DatabaseServiceProvider',
      7 => 'Illuminate\\Encryption\\EncryptionServiceProvider',
      8 => 'Illuminate\\Filesystem\\FilesystemServiceProvider',
      9 => 'Illuminate\\Foundation\\Providers\\FoundationServiceProvider',
      10 => 'Illuminate\\Hashing\\HashServiceProvider',
      11 => 'Illuminate\\Mail\\MailServiceProvider',
      12 => 'Illuminate\\Notifications\\NotificationServiceProvider',
      13 => 'Illuminate\\Pagination\\PaginationServiceProvider',
      14 => 'Illuminate\\Pipeline\\PipelineServiceProvider',
      15 => 'Illuminate\\Queue\\QueueServiceProvider',
      16 => 'Illuminate\\Redis\\RedisServiceProvider',
      17 => 'Illuminate\\Auth\\Passwords\\PasswordResetServiceProvider',
      18 => 'Illuminate\\Session\\SessionServiceProvider',
      19 => 'Illuminate\\Translation\\TranslationServiceProvider',
      20 => 'Illuminate\\Validation\\ValidationServiceProvider',
      21 => 'Illuminate\\View\\ViewServiceProvider',
      22 => 'App\\Providers\\AppServiceProvider',
      23 => 'App\\Providers\\AuthServiceProvider',
      24 => 'App\\Providers\\EventServiceProvider',
      25 => 'App\\Providers\\RouteServiceProvider',
    ),
    'aliases' => 
    array (
      'App' => 'Illuminate\\Support\\Facades\\App',
      'Artisan' => 'Illuminate\\Support\\Facades\\Artisan',
      'Auth' => 'Illuminate\\Support\\Facades\\Auth',
      'Blade' => 'Illuminate\\Support\\Facades\\Blade',
      'Broadcast' => 'Illuminate\\Support\\Facades\\Broadcast',
      'Bus' => 'Illuminate\\Support\\Facades\\Bus',
      'Cache' => 'Illuminate\\Support\\Facades\\Cache',
      'Config' => 'Illuminate\\Support\\Facades\\Config',
      'Cookie' => 'Illuminate\\Support\\Facades\\Cookie',
      'Crypt' => 'Illuminate\\Support\\Facades\\Crypt',
      'DB' => 'Illuminate\\Support\\Facades\\DB',
      'Eloquent' => 'Illuminate\\Database\\Eloquent\\Model',
      'Event' => 'Illuminate\\Support\\Facades\\Event',
      'File' => 'Illuminate\\Support\\Facades\\File',
      'Gate' => 'Illuminate\\Support\\Facades\\Gate',
      'Hash' => 'Illuminate\\Support\\Facades\\Hash',
      'Lang' => 'Illuminate\\Support\\Facades\\Lang',
      'Log' => 'Illuminate\\Support\\Facades\\Log',
      'Mail' => 'Illuminate\\Support\\Facades\\Mail',
      'Notification' => 'Illuminate\\Support\\Facades\\Notification',
      'Password' => 'Illuminate\\Support\\Facades\\Password',
      'Queue' => 'Illuminate\\Support\\Facades\\Queue',
      'Redirect' => 'Illuminate\\Support\\Facades\\Redirect',
      'Redis' => 'Illuminate\\Support\\Facades\\Redis',
      'Request' => 'Illuminate\\Support\\Facades\\Request',
      'Response' => 'Illuminate\\Support\\Facades\\Response',
      'Route' => 'Illuminate\\Support\\Facades\\Route',
      'Schema' => 'Illuminate\\Support\\Facades\\Schema',
      'Session' => 'Illuminate\\Support\\Facades\\Session',
      'Storage' => 'Illuminate\\Support\\Facades\\Storage',
      'URL' => 'Illuminate\\Support\\Facades\\URL',
      'Validator' => 'Illuminate\\Support\\Facades\\Validator',
      'View' => 'Illuminate\\Support\\Facades\\View',
      'Str' => 'Illuminate\\Support\\Str',
    ),
    'mohasabeh_settings' => 
    array (
      'DIRECT_ADMIN_USER_USER' => NULL,
      'DIRECT_ADMIN_USER_PASSWORD' => NULL,
    ),
    'recaptcha_site_key' => '6LdaFbIlAAAAAG6kVnDaynF6Tzx3Zhq8u3XEVj1G',
    'recaptcha_secret_key' => '6LdaFbIlAAAAAMMUdeH_2o3wQuvEtv0qmg9lPQd-',
  ),
  'auth' => 
  array (
    'defaults' => 
    array (
      'guard' => 'web',
      'passwords' => 'users',
    ),
    'guards' => 
    array (
      'web' => 
      array (
        'driver' => 'session',
        'provider' => 'users',
      ),
      'api' => 
      array (
        'driver' => 'token',
        'provider' => 'users',
      ),
    ),
    'providers' => 
    array (
      'users' => 
      array (
        'driver' => 'eloquent',
        'model' => 'App\\User',
      ),
    ),
    'passwords' => 
    array (
      'users' => 
      array (
        'provider' => 'users',
        'table' => 'password_resets',
        'expire' => 60,
      ),
    ),
  ),
  'broadcasting' => 
  array (
    'default' => 'log',
    'connections' => 
    array (
      'pusher' => 
      array (
        'driver' => 'pusher',
        'key' => '',
        'secret' => '',
        'app_id' => '',
        'options' => 
        array (
          'cluster' => 'mt1',
          'encrypted' => true,
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
      'log' => 
      array (
        'driver' => 'log',
      ),
      'null' => 
      array (
        'driver' => 'null',
      ),
    ),
  ),
  'cache' => 
  array (
    'default' => 'file',
    'stores' => 
    array (
      'apc' => 
      array (
        'driver' => 'apc',
      ),
      'array' => 
      array (
        'driver' => 'array',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'cache',
        'connection' => NULL,
      ),
      'file' => 
      array (
        'driver' => 'file',
        'path' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\framework/cache/data',
      ),
      'memcached' => 
      array (
        'driver' => 'memcached',
        'persistent_id' => NULL,
        'sasl' => 
        array (
          0 => NULL,
          1 => NULL,
        ),
        'options' => 
        array (
        ),
        'servers' => 
        array (
          0 => 
          array (
            'host' => '127.0.0.1',
            'port' => 11211,
            'weight' => 100,
          ),
        ),
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
      ),
    ),
    'prefix' => 'laravel_cache',
  ),
  'crudbooster' => 
  array (
    'ADMIN_PATH' => 'admin',
    'API_USER_AGENT_ALLOWED' => 
    array (
    ),
    'USER_TABLE' => 'cms_users',
    'IMAGE_FIELDS_CANDIDATE' => 'image,picture,photo,photos,foto,gambar,thumbnail',
    'PASSWORD_FIELDS_CANDIDATE' => 'password,pass,pwd,passwrd,sandi,pin',
    'DATE_FIELDS_CANDIDATE' => 'date,tanggal,tgl,created_at,updated_at,deleted_at',
    'EMAIL_FIELDS_CANDIDATE' => 'email,mail,email_address',
    'PHONE_FIELDS_CANDIDATE' => 'phone,phonenumber,phone_number,telp,hp,no_hp,no_telp',
    'NAME_FIELDS_CANDIDATE' => 'name,nama,person_name,person,fullname,full_name,nickname,nick,nick_name,title,judul,content',
    'URL_FIELDS_CANDIDATE' => 'url,link',
    'UPLOAD_TYPES' => 'jpg,png,jpeg,gif,bmp,pdf,xls,xlsx,doc,docx,txt,zip,rar,7z',
    'DEFAULT_THUMBNAIL_WIDTH' => 0,
    'DEFAULT_UPLOAD_MAX_SIZE' => 1000,
    'IMAGE_EXTENSIONS' => 'jpg,png,jpeg,gif,bmp',
    'MAIN_DB_DATABASE' => 'mohasabeh',
    'MULTIPLE_DATABASE_MODULE' => 
    array (
    ),
    'ADMIN_LAYOUT' => '',
    'filemanager_upload_dir' => '/files/',
    'filemanager_current_path' => 'files/',
    'filemanager_thumbs_base_path' => 'thumbs/',
    'filemanager_thumbs_upload_dir' => '/thumbs/',
    'filemanager_MaxSizeUpload' => 100,
    'filemanager_default_view' => 0,
    'filemanager_delete_files' => true,
    'filemanager_create_folders' => true,
    'filemanager_delete_folders' => true,
    'filemanager_upload_files' => true,
    'filemanager_rename_files' => true,
    'filemanager_rename_folders' => true,
    'filemanager_duplicate_files' => true,
    'filemanager_extract_files' => true,
    'filemanager_copy_cut_files' => true,
    'filemanager_copy_cut_dirs' => true,
    'filemanager_chmod_files' => true,
    'filemanager_chmod_dirs' => true,
    'filemanager_preview_text_files' => true,
    'filemanager_edit_text_files' => true,
    'filemanager_create_text_files' => true,
    'filemanager_download_files' => true,
    'reset_password_expired_time' => 60,
  ),
  'database' => 
  array (
    'default' => 'mysql',
    'connections' => 
    array (
      'sqlite' => 
      array (
        'driver' => 'sqlite',
        'database' => 'mohasabeh',
        'prefix' => '',
      ),
      'mysql' => 
      array (
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'mohasabeh',
        'username' => 'root',
        'password' => '',
        'unix_socket' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => NULL,
        'modes' => 
        array (
          0 => 'ONLY_FULL_GROUP_BY',
          1 => 'STRICT_TRANS_TABLES',
          2 => 'NO_ZERO_IN_DATE',
          3 => 'NO_ZERO_DATE',
          4 => 'ERROR_FOR_DIVISION_BY_ZERO',
          5 => 'NO_ENGINE_SUBSTITUTION',
        ),
      ),
      'pgsql' => 
      array (
        'driver' => 'pgsql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'mohasabeh',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
        'schema' => 'public',
        'sslmode' => 'prefer',
      ),
      'sqlsrv' => 
      array (
        'driver' => 'sqlsrv',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'mohasabeh',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'prefix' => '',
      ),
    ),
    'migrations' => 'migrations',
    'redis' => 
    array (
      'client' => 'predis',
      'default' => 
      array (
        'host' => '127.0.0.1',
        'password' => NULL,
        'port' => '6379',
        'database' => 0,
      ),
    ),
  ),
  'dompdf' => 
  array (
    'show_warnings' => false,
    'orientation' => 'portrait',
    'defines' => 
    array (
      'font_dir' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\fonts/',
      'font_cache' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\fonts/',
      'temp_dir' => 'C:\\Users\\M\\AppData\\Local\\Temp',
      'chroot' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website',
      'enable_font_subsetting' => false,
      'pdf_backend' => 'CPDF',
      'default_media_type' => 'screen',
      'default_paper_size' => 'a4',
      'default_font' => 'serif',
      'dpi' => 96,
      'enable_php' => false,
      'enable_javascript' => true,
      'enable_remote' => true,
      'font_height_ratio' => 1.1,
      'enable_html5_parser' => false,
    ),
  ),
  'filesystems' => 
  array (
    'default' => 'local',
    'cloud' => 's3',
    'disks' => 
    array (
      'local' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\app',
      ),
      'public' => 
      array (
        'driver' => 'local',
        'root' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\app/public',
        'url' => 'http://localhost/storage',
        'visibility' => 'public',
      ),
      's3' => 
      array (
        'driver' => 's3',
        'key' => NULL,
        'secret' => NULL,
        'region' => NULL,
        'bucket' => NULL,
      ),
    ),
  ),
  'laravellocalization' => 
  array (
    'supportedLocales' => 
    array (
      'en' => 
      array (
        'name' => 'English',
        'script' => 'Latn',
        'native' => 'English',
        'regional' => 'en_GB',
      ),
      'ar' => 
      array (
        'name' => 'Arabic',
        'script' => 'Arab',
        'native' => '???????',
        'regional' => 'ar_AE',
      ),
    ),
    'useAcceptLanguageHeader' => true,
    'hideDefaultLocaleInURL' => false,
    'localesOrder' => 
    array (
    ),
    'localesMapping' => 
    array (
    ),
    'utf8suffix' => '.UTF-8',
    'urlsIgnored' => 
    array (
      0 => '/skipped',
    ),
    'httpMethodsIgnored' => 
    array (
      0 => 'POST',
      1 => 'PUT',
      2 => 'PATCH',
      3 => 'DELETE',
    ),
  ),
  'mail' => 
  array (
    'driver' => 'smtp',
    'host' => 'smtp.mailtrap.io',
    'port' => '2525',
    'from' => 
    array (
      'address' => 'hello@example.com',
      'name' => 'Example',
    ),
    'encryption' => NULL,
    'username' => NULL,
    'password' => NULL,
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => 
    array (
      'theme' => 'default',
      'paths' => 
      array (
        0 => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\resources\\views/vendor/mail',
      ),
    ),
  ),
  'queue' => 
  array (
    'default' => 'sync',
    'connections' => 
    array (
      'sync' => 
      array (
        'driver' => 'sync',
      ),
      'database' => 
      array (
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'beanstalkd' => 
      array (
        'driver' => 'beanstalkd',
        'host' => 'localhost',
        'queue' => 'default',
        'retry_after' => 90,
      ),
      'sqs' => 
      array (
        'driver' => 'sqs',
        'key' => 'your-public-key',
        'secret' => 'your-secret-key',
        'prefix' => 'https://sqs.us-east-1.amazonaws.com/your-account-id',
        'queue' => 'your-queue-name',
        'region' => 'us-east-1',
      ),
      'redis' => 
      array (
        'driver' => 'redis',
        'connection' => 'default',
        'queue' => 'default',
        'retry_after' => 90,
      ),
    ),
    'failed' => 
    array (
      'database' => 'mysql',
      'table' => 'failed_jobs',
    ),
  ),
  'services' => 
  array (
    'mailgun' => 
    array (
      'domain' => NULL,
      'secret' => NULL,
    ),
    'ses' => 
    array (
      'key' => NULL,
      'secret' => NULL,
      'region' => 'us-east-1',
    ),
    'sparkpost' => 
    array (
      'secret' => NULL,
    ),
    'stripe' => 
    array (
      'model' => 'App\\User',
      'key' => NULL,
      'secret' => NULL,
    ),
  ),
  'session' => 
  array (
    'driver' => 'file',
    'lifetime' => '120',
    'expire_on_close' => false,
    'encrypt' => false,
    'files' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\framework/sessions',
    'connection' => NULL,
    'table' => 'sessions',
    'store' => NULL,
    'lottery' => 
    array (
      0 => 2,
      1 => 100,
    ),
    'cookie' => 'laravel_session',
    'path' => '/',
    'domain' => NULL,
    'secure' => NULL,
    'http_only' => true,
    'same_site' => NULL,
  ),
  'view' => 
  array (
    'paths' => 
    array (
      0 => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\resources\\views',
    ),
    'compiled' => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\storage\\framework\\views',
  ),
  'image' => 
  array (
    'driver' => 'gd',
  ),
  'excel' => 
  array (
    'exports' => 
    array (
      'chunk_size' => 1000,
      'pre_calculate_formulas' => false,
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => '
',
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
      ),
    ),
    'imports' => 
    array (
      'read_only' => true,
      'heading_row' => 
      array (
        'formatter' => 'slug',
      ),
      'csv' => 
      array (
        'delimiter' => ',',
        'enclosure' => '"',
        'escape_character' => '\\',
        'contiguous' => false,
        'input_encoding' => 'UTF-8',
      ),
    ),
    'extension_detector' => 
    array (
      'xlsx' => 'Xlsx',
      'xlsm' => 'Xlsx',
      'xltx' => 'Xlsx',
      'xltm' => 'Xlsx',
      'xls' => 'Xls',
      'xlt' => 'Xls',
      'ods' => 'Ods',
      'ots' => 'Ods',
      'slk' => 'Slk',
      'xml' => 'Xml',
      'gnumeric' => 'Gnumeric',
      'htm' => 'Html',
      'html' => 'Html',
      'csv' => 'Csv',
      'tsv' => 'Csv',
      'pdf' => 'Dompdf',
    ),
    'value_binder' => 
    array (
      'default' => 'Maatwebsite\\Excel\\DefaultValueBinder',
    ),
    'transactions' => 
    array (
      'handler' => 'db',
    ),
    'temporary_files' => 
    array (
      'local_path' => 'C:\\Users\\M\\AppData\\Local\\Temp',
      'remote_disk' => NULL,
      'remote_prefix' => NULL,
    ),
  ),
  'trustedproxy' => 
  array (
    'proxies' => NULL,
    'headers' => 30,
  ),
  'imagecache' => 
  array (
    'route' => NULL,
    'paths' => 
    array (
      0 => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\public\\upload',
      1 => 'C:\\wamp64\\www\\mohasabeh website\\mohasabeh-website\\public\\images',
    ),
    'templates' => 
    array (
      'small' => 'Intervention\\Image\\Templates\\Small',
      'medium' => 'Intervention\\Image\\Templates\\Medium',
      'large' => 'Intervention\\Image\\Templates\\Large',
    ),
    'lifetime' => 43200,
  ),
  'tinker' => 
  array (
    'commands' => 
    array (
    ),
    'alias' => 
    array (
    ),
    'dont_alias' => 
    array (
      0 => 'App\\Nova',
    ),
  ),
);

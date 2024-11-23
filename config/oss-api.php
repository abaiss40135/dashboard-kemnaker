<?php

return [
    'env'           => env('OSS_ENV', 'local'),
    'prod_url'      => env('OSS_PROD_API_URL', 'https://services.oss.go.id/'),
    'dev_url'       => env('OSS_DEV_API_URL', 'https://api-stg.oss.go.id/stg/v1/kl/rba/'),
    'rba_url'       => env('OSS_RBA_API_URL', 'https://api-stg.oss.go.id/stg/v1/kl/rba/'),
    'sso_prod_url'  => env('OSS_SSO_PROD_URL', 'https://api-prd.oss.go.id/v1/sso/users/'),
    'sso_dev_url'   => env('OSS_DEV_API_URL' . 'sso/users/', 'https://api-stg.oss.go.id/stg/v1/sso/users/'),
    'username'      => env('OSS_USERNAME'),
    'password'      => env('OSS_PASSWORD'),
    'security_key'  => env('OSS_SECURITY_KEY', ''),
    'user_key'      => env('OSS_USER_KEY', ''),
    'client_secret' => env('OSS_CLIENT_SECRET', '')
];

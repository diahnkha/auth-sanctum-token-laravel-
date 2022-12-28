//bikin auth token
// nanti ada migrate personal access tokens table

1. php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

2. php artisan migrate
3. php artisan make:model PersonalAccessToken
4. use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken

5. edit di model/user.php
import use Illuminate\Support\Facades\Hash;
6. di http, kernel. cari yang middleware group api, diuncoment yan gensure frontend 

7. di seeders/database seeder .pho isi user query.
tambahin import use Illuminate\Support\Str;
use App\Models\User;

//factory untuk random user atau random data

8. kalau udh di seed
9. php artisan db:seed
10. 
di personalaccesstoken.php edit tambahin boot func
include Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

11. php artisan make:controller AuthController
12. edit auth controller buat fungsi login, bikin fungsi get user
13. app/exception/handler.php 
edit this renderable
ngecek handler yang udh bener apa ga
kalau ada error di handlernya di sini
tambahin import 
use Illuminate\Auth\AuthenticationException;

14. baru masuk ke route di api.php
Route::post("/login", [AuthController::class, "login"]);
Route::get("/me", [AuthController::class, "getUser"])
    ->middleware("auth:sanctum");

15. coba di run
php artisan serve
http://127.0.0.1:8000/api/login
form-data
body 
email : fulan@gmail.com
password : fulan123

{
    "status": true,
    "message": "",
    "data": {
        "auth": {
            "token": "1|Xd1uC8uqomZq5B9BpM4adxBd6lX62ETiKwjzQ4gj",
            "token_type": "Bearer"
        },
        "user": {
            "id": 1,
            "name": "Fulan",
            "email": "fulan@gmail.com",
            "email_verified_at": "2022-12-28T02:39:56.000000Z",
            "created_at": "2022-12-28T02:39:56.000000Z",
            "updated_at": "2022-12-28T02:39:56.000000Z"
        }
    }
}

http://127.0.0.1:8000/api/me
headers 
Authorization
Bearer 1|Xd1uC8uqomZq5B9BpM4adxBd6lX62ETiKwjzQ4gj



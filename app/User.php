<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\CustomClasses\Token;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password'];

    public function create(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return $user;
    }

    public function applicationsUse()
    {
        return $this->belongsToMany('App\Applications', 'usage');
    }

    public function applicationsRestrict()
    {
        return $this->belongsToMany('App\Applications', 'restrict');
    }

    public static function by_field($key, $value)
    {
        $users = self::where($key, $value)->get();
        foreach ($users as $key => $user) {
            return $user;
        }
    }
    
    public function is_authorized(Request $request)
    {
        $token = new Token();
        $header = $request->header("Authorization");    

        if (!isset($header)) {
            return false;
        }
        $data = $token->decode($header);
        return !empty(self::by_field('email', $data->email));
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Application extends Model
{
    
    protected $table = 'applications';
    protected $fillable = ['name', 'icon'];

    public function create(Request $request)
    {
        $app = new User();
        $app->name = $request->name;
        $app->icon = $request->icon;
        $app->save();

        return $app;
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}

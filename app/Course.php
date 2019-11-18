<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Webpatser\Uuid\Uuid;

class Course extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','created_by','updated_by'
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    protected $casts = [
      'id' => 'string'
    ];

     public static function rules($id = '') 
    {
      return [
          'name' => ['required', 'unique:courses'],
      ];
    }

    public static function messages($id = '') 
    {
      return [
          'name.required' => 'You must enter year name.',
          'name.unique' => 'The year name is already exists.',
      ];
    }
}

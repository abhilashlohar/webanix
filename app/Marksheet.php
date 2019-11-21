<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Webpatser\Uuid\Uuid;
use Illuminate\Validation\Rule;

class Marksheet extends Model
{
    protected $fillable = [
        'student_id','semester_id','year_id','marksheet_src'
    ];


    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    protected $casts = [
      'id' => 'string',
      'student_id' => 'string',
      'semester_id' => 'string',
      'year_id' => 'string',
    ];

    public static function rules($id = '') 
    {
      return [
          'semester_id' => 'required',
          'marksheet_file' => 'required|mimes:pdf|max:2048',
          'year_id' => 'required',
      ];
    }

    public static function messages($id = '') 
    {
      return [
          'semester_id.required' => 'You must select semester.',
          'year_id.required' => 'You must select year.',
          'marksheet_file.required' => 'You must select marksheet.',
      ];
    }

    public function getKeyType()
    {
        return 'string';
    }

    public function student(){
      return $this->belongsTo(Student::class);
    }

    public function year(){
      return $this->belongsTo(Year::class);
    }

    public function semester(){
      return $this->belongsTo(Semester::class);
    }
}

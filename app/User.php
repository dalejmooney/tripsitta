<?php

namespace App;

use App\Models\Babysitter;
use App\Models\Family;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $fillable = [
        'name', 'surname', 'email', 'password', 'dob', 'role', 'phone_number', 'home_phone_number', 'emergency_name', 'emergency_relationship', 'emergency_phone_number', 'provider', 'provider_id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'dob'
    ];

    public function babysitter()
    {
       return $this->belongsTo(Babysitter::class,'id');
    }

    public function family()
    {
        return $this->belongsTo(Family::class,'id');
    }

    /**
     * Get user data by slug. Works only for babysitters. Used for public babysitter profile pages.
     * Kind of over complicated with the day and seconds thing... Added to avoid duplicates to keep it dynamic. Not ideal solution...
     *
     * @param $query
     * @param $slug
     * @return mixed
     */
    public function scopeHasSlug($query, $slug)
    {
        $slug = str_replace('_', ' ', $slug);

        return $query->where(DB::raw("LOWER(CONCAT(name, ' ', surname, ' ', DAY(created_at), SECOND(created_at)))"), $slug)->where('role', 'babysitter');
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

    public function getFullNameWithLinkAttribute()
    {
        if($this->role == 'babysitter') return '<a href="'.route('admin.b.babysitters.show', $this->id).'">'.$this->name.' '.$this->surname.'</a>';
        elseif($this->id === 0) return $this->name.' '.$this->surname;
        return '<a href="'.route('admin.families.show', $this->id).'">'.$this->name.' '.$this->surname.'</a>';
    }

    /**
     * Get babysitters slug
     *
     * @return string
     * @throws \Exception
     */
    public function getSlugAttribute()
    {
        $name = strtolower(str_replace(' ', '_', $this->name));
        $surname = strtolower(str_replace(' ', '_', $this->surname));
        $digits = new \DateTime($this->created_at);
        $digits = $digits->format('js');

        return urlencode($name).'_'.urlencode($surname).'_'.$digits;
    }
}

<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Admin extends Authenticatable
{
    use HasRoles, HasFactory, Notifiable, LogsActivity, SoftDeletes;

    protected $fillable = ['nome_completo', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];

    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
    protected static $logAttributes = ['nome_completo', 'email'];
    protected static $logName = 'Administrador';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('admin')
            ->logOnly(['nome_completo', 'email']);
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }

    public function adminlte_profile_url()
    {
        return route('admin.home');
    }
}

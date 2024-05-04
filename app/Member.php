<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class Member extends Authenticatable
    {
        use Notifiable;

        protected $guard = 'member';

        protected $fillable = [
            'name', 'username', 'password',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
        protected $primaryKey = 'id';
        public function address()
        {
            return $this->hasMany('App\MemberAddress', 'ref_member_id', 'id');
        }
    }
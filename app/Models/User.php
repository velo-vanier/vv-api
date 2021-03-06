<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'User';
    public $timestamps = false;

    protected $primaryKey = 'ID_User';

    public $fillable = [
        'Role',
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'PostalCode',
        'Password',
        'ParentID'
    ];

    /**
     * Strip spaces from postal code, uppercase
     *
     * @param $postalCode
     *
     * @return string
     */
    public function formatPostalCode($postalCode)
    {
        return str_replace(' ', '', strtoupper($postalCode));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dependents()
    {
        return $this->hasMany(User::class, 'ParentID', 'ID_User');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany(BikeHistory::class, 'ID_BikeUser', 'ID_User');
    }

    /**
     * Retrieve the photos attached to the user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function photos()
    {
        return $this->hasManyThrough(
            Photo::class,
            BikePhoto::class,
            'ID_Bike',
            'ID_Photo',
            'ID_Bike',
            'ID_Photo'
        );
    }
}
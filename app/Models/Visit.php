<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'visits';

	public $timestamps = true;

	/**
	 * Test relationship
	 */
    public function tests()
    {
        return $this->hasMany('Test');
    }

	/**
	 * Patient relationship
	 */
	public function patient()
	{
		return $this->belongsTo('Patient');
	}
}

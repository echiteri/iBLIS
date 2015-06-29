<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Commodity extends Eloquent
{
	use SoftDeletingTrait;
	protected $table = 'commodities';
	protected $dates = ['deleted_at'];

	/**
	* Relationship between receipts and 
	*/
	public function receipts()
	{
		return $this->hasMany('Receipt');
	}

	/**
	* Relationship between commodity and the user who handled it
	*/
	public function user(){
		return $this->belongsTo('user');
	}

	/**
	* Relationship with metric
	*/
	public function metric()
	{
		return $this->belongsTo('Metric');
	}

	/**
	* Function to get the remaining comodities
	*/
	public function available()
	{
		//Total received - total issued
		$totalReceived = $this->receipts->sum('quantity');
		$totalIssued = 0;
		foreach ($this->receipts as $receipt) {
			$totalIssued+=$receipt->issues->sum('quantity_issued');
		}

		return $totalReceived - $totalIssued;
	}
}
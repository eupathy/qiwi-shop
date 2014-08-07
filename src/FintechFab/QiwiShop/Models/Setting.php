<?php

namespace FintechFab\QiwiShop\Models;

use Eloquent;

/**
 * Class Setting
 *
 * @package FintechFab\QiwiShop\Models
 *
 * @property integer   $id
 * @property string    $name
 * @property integer   $gate_id
 * @property string    $gate_password
 * @property string    $gate_key
 * @property string    $lifetime
 * @property string    $gate_url
 * @property string    $pay_url
 * @property string    $created_at
 * @property string    $updated_at
 *
 * @method static Setting find()
 * @method static Setting first()
 * @method static Setting whereUserId()
 * @method static Setting whereGateId()
 */
class Setting extends Eloquent
{

	protected $fillable = array(
		'name', 'gate_id', 'gate_password', 'gate_key', 'lifetime', 'gate_url', 'pay_url'
	);
	protected $table = 'settings';
	protected $connection = 'ff-qiwi-shop';

	public function newSettings($data)
	{
		$this->id = $data['user_id'];
		$this->name = $data['name'];
		$this->gate_id = $data['gateId'];
		$this->gate_password = $data['password'];
		$this->gate_key = $data['key'];
		$this->lifetime = $data['lifetime'];
		$this->gate_url = $data['gateUrl'];
		$this->pay_url = $data['payUrl'];
		$this->save();
	}

} 
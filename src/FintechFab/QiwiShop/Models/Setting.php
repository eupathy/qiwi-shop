<?php

namespace FintechFab\QiwiShop\Models;

use Eloquent;

/**
 * Class Setting
 *
 * @package FintechFab\QiwiShop\Models
 *
 * @property integer   $user_id
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
 * @method static Setting whereUserId()
 */
class Setting extends Eloquent
{

	protected $fillable = array(
		'user_id', 'name', 'gate_id', 'gate_password', 'gate_key', 'lifetime', 'gate_url', 'pay_url'
	);
	protected $table = 'settings';
	protected $connection = 'ff-qiwi-shop';

	public function newSetting($data)
	{
		$this->user_id = $data['user_id'];
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
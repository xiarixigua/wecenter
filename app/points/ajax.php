<?php
/*
+--------------------------------------------------------------------------
|   WeCenter [#RELEASE_VERSION#]
|   ========================================
|   by WeCenter Software
|   © 2011 - 2014 WeCenter. All Rights Reserved
|   http://www.wecenter.com
|   ========================================
|   Support: WeCenter@qq.com
|
+---------------------------------------------------------------------------
*/

define('IN_AJAX', TRUE);


if (!defined('IN_ANWSION'))
{
	die;
}

class ajax extends AWS_CONTROLLER
{
	public $per_page;

	public function get_access_rule()
	{
		$rule_action['rule_type'] = 'white'; //'black'黑名单,黑名单中的检查  'white'白名单,白名单以外的检查

		return $rule_action;
	}

	public function setup()
	{
		if (get_setting('index_per_page'))
		{
			$this->per_page = get_setting('index_per_page');
		}

		HTTP::no_cache_header();
	}

	public function qiandao_list_action()
	{
		if($this->user_id)
		{
			if ($lists = $this->model('points')->get_qiandao_list($this->user_id, 0, (intval($_GET['page']) * 15) . ", 15"))
			{
				TPL::assign('lists', $lists);
			}			
		}

		TPL::output('points/ajax/qiandao');
	}
	
	public function qiandao_list_me_action()
	{
		if($this->user_id)
		{
			if ($lists = $this->model('points')->get_qiandao_list($this->user_id, 1, (intval($_GET['page']) * 15) . ", 15"))
			{
				TPL::assign('lists', $lists);
			}			
		}

		TPL::output('points/ajax/qiandao');
	}	
	
	public function myextension_list_me_action()
	{
		if($this->user_id)
		{
			if ($lists = $this->model('points')->get_myextension_list($this->user_id, (intval($_GET['page']) * 15) . ", 15"))
			{
				TPL::assign('lists', $lists);
			}			
		}

		TPL::output('points/ajax/myextension');
	}
	
	public function send_qiandao_action()
	{
		if(!$this->user_id)
		{
			H::ajax_json_output(AWS_APP::RSM(null, '-1', AWS_APP::lang()->_t('只有会员才享受签到权利')));
		}
		else
		{
			$q_time=date('Ymd',time());
			
			if($qdlist = $this->model('points')->get_qiandao_list_by_uid($this->user_id, $q_time)){
				H::ajax_json_output(AWS_APP::RSM(null, '-1', AWS_APP::lang()->_t('您今天已经签到过啦')));
			}else{
				$jifena = intval(get_setting('integral_system_config_qiandao'));
				$jifenb = rand(1,$jifena);
				$jifenc = $jifena+$jifenb;
				$strs = array(
					'uid' => $this->user_id,
					'jifen' => $jifena,
					'status' => $jifenb,
					'time' => $q_time,
					'add_time' => time(),
				);
				if($b = $this->model('points')->insert_qiandao($strs)){
					$this->model('integral')->process($this->user_id, 'AWARD', $jifenc, '会员签到得积分：'.$jifenc);
					$this->model('points')->update_qiandao_count($this->user_id);					
					$qdinfo = $this->model('points')->get_qiandao_list_by_uid_time_jian($this->user_id, $q_time);
					if($qdinfo){
						$this->model('points')->update_qiandao_countday($this->user_id,1);
					}else{
						$this->model('points')->update_qiandao_countday($this->user_id,0);
					}						
				}
				H::ajax_json_output(AWS_APP::RSM(array(
					'url' => get_js_url('/points')
				), 1, null));	
			}
		}	
	}
}
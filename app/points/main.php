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


if (!defined('IN_ANWSION'))
{
	die;
}

class main extends AWS_CONTROLLER
{
	public function get_access_rule()
	{
		$rule_action['rule_type'] = 'white';
		$rule_action['actions'] = array(
			'points'
		);

		return $rule_action;
	}

	public function setup()
	{
		if (is_mobile() AND !$_GET['ignore_ua_check'])
		{
			switch ($_GET['app'])
			{
				default:
					HTTP::redirect('/m/');
				break;
			}
		}
	}

	public function index_action()
	{
		if (! $this->user_id)
		{
			HTTP::redirect('/explore/');
		}
		
		TPL::assign('setting', get_setting(null, false));
		
		if($_GET['points']=='qiandao')
		{
			$this->crumb(AWS_APP::lang()->_t('在线签到'), '/points/points-qiandao');
			//签到
			if($this->user_id){
				TPL::assign('qiandao_list', $this->model('points')->get_qiandao_list_by_uid($this->user_id, date('Ymd',time())));
			}
			//广告
			TPL::assign('ad_list', $this->model('ads')->get_ads_list_all(1,10));
			TPL::output('points/qiandao');
		}
		elseif($_GET['points']=='myqiandao')
		{
			$this->crumb(AWS_APP::lang()->_t('签到记录'), '/points/points-myqiandao');
			$a=$this->model('points')->count_qiandao_jifen_count($this->user_id);
			$b=$this->model('points')->count_qiandao_status_count($this->user_id);
			//签到
			if($this->user_id){
				TPL::assign('qiandao_list', $this->model('points')->get_qiandao_list_by_uid($this->user_id, date('Ymd',time())));
			}
			TPL::assign('myqiandao_count', $a+$b);
			TPL::output('points/myqiandao');
		}
		elseif($_GET['points']=='extension')
		{
			$this->crumb(AWS_APP::lang()->_t('推广中心'), '/points/points-extension');
			TPL::output('points/extension');
		}
		elseif($_GET['points']=='myextension')
		{
			$this->crumb(AWS_APP::lang()->_t('推广详情'), '/points/points-myextension');
			$a=$this->model('points')->count_myextensio_jifen_count($this->user_id);
			TPL::assign('myextension_count', $a);
			TPL::output('points/myextension');
		}
		else
		{
			$this->crumb(AWS_APP::lang()->_t('会员积分'), '/points/');
			//签到
			if($this->user_id){
				TPL::assign('qiandao_list', $this->model('points')->get_qiandao_list_by_uid($this->user_id, date('Ymd',time())));
			}
			TPL::output('points/index');
		}
		
	}

}
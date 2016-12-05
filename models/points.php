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

class points_class extends AWS_MODEL
{
	public function count_qiandao_status_count($uid)
	{
		$res=$this->query("select COALESCE(sum(status),0) AS count from " . get_table('qiandao_log') . " where uid = " . intval($uid) . " ")->fetchAll();
		if($res){
			return $res[0]['count'];
		}		
	}
	public function count_qiandao_jifen_count($uid)
	{
		$res=$this->query("select COALESCE(sum(jifen),0) AS count from " . get_table('qiandao_log') . " where uid = " . intval($uid) . " ")->fetchAll();
		if($res){
			return $res[0]['count'];
		}		
	}
	
	public function count_myextensio_jifen_count($uid)
	{
		$res=$this->query("select COALESCE(sum(status),0) AS count from " . get_table('do_work') . " where work_type=1 and uid = " . intval($uid) . "")->fetchAll();
		if($res){
			return $res[0]['count'];
		}		
	}
	
	public function get_qiandao_list_by_uid($uid, $time)
    {
        return $this->fetch_one('qiandao_log', 'uid', "uid = " . intval($uid) . " and time=" . intval($time) . "");
    }
	
	public function get_qiandao_list_by_uid_time($uid, $time)
    {
        return $this->fetch_row('qiandao_log', "uid = " . intval($uid) . " and time=" . intval($time) . "");
    }
	
	public function get_qiandao_list_by_uid_time_jian($uid, $time)
    {
        return $this->fetch_row('qiandao_log', "uid = " . intval($uid) . " and time=" . intval($time-1) . "");
    }
	
	public function get_qiandao_list($uid, $type = 0, $limit = 20)
	{
		if(!$uid){
			return false;
		}
		if($type<>0){
			$where[] = 'uid = ' . intval($uid);
		}
		$lists = $this->fetch_all('qiandao_log', implode(' AND ', $where), 'add_time DESC', $limit);
		
		foreach($lists as $key => $val){
			$lists[$key]['user_info'] = $this->model('account')->get_user_info_by_uid($val['uid'], true);
		}
		return $lists;
	}
	
	public function update_qiandao_count($uid)
    {
        return $this->shutdown_query("UPDATE " . $this->get_table('users') . " SET qiandao_count = qiandao_count + 1 WHERE uid = " . intval($uid));        
    }
	
	public function update_qiandao_countday($uid, $num)
    {
		if($num==1){
			$this->shutdown_query("UPDATE " . $this->get_table('users') . " SET qiandao_countday = qiandao_countday + 1 WHERE uid = " . intval($uid));
		}elseif($num==0){
			$this->shutdown_query("UPDATE " . $this->get_table('users') . " SET qiandao_countday = 1 WHERE uid = " . intval($uid));
		}
    }
	
	public function get_myextension_list($uid, $limit = 20)
	{
		if(!$uid){
			return false;
		}
		$lists = $this->fetch_all('do_work', 'work_type=1 and uid = ' . intval($uid), 'work_time DESC', $limit);
		
		foreach($lists as $key => $val){
			$lists[$key]['user_info'] = $this->model('account')->get_user_info_by_uid($val['touid'], true);
		}
		return $lists;
	}

	public function insert_qiandao($str)
	{
		return $this->insert('qiandao_log',$str);
	}
	
	public function get_myextension_list_by_uid_info($uid)
    {
        if(!$user_info=$this->fetch_row('do_work', "work_type=1 and touid = " . intval($uid) . ""))
		{
			return false;
		}else{
			$user_info['users'] = $this->model('account')->get_user_info_by_uid($user_info['uid'], true);
			return $user_info;
		}
    }
	
}
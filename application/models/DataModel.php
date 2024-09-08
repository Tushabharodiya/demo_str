<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DataModel extends CI_Model {
    function __construct() {
		parent::__construct();
	}
	
	// ======================================================== //
    /* Extra Functions */
    // ======================================================== //
	function countData($where, $table){
		$this->db->select('*');
		if($where){
		    $this->db->where($where);
		}
		$this->db->from($table);
		$result = $this->db->count_all_results();
		return $result;
	}

	// ======================================================== //
    /* Common Functions */
    // ======================================================== //
	function insertData($table, $data){
		$result = $this->db->insert($table, $data);
		if($result)
			return $this->db->insert_id();
		else
			return false;
	}
	
	function getData($where, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function viewData($order, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($where){ $this->db->where($where); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function viewGroupData($order, $where, $group, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($where){ $this->db->where($where); }
		if($group){ $this->db->group_by($group); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function editData($where, $table, $editData){
		$this->db->where($where);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
	function deleteData($where, $table){
		$this->db->where($where);
		$result = $this->db->delete($table);
		if($result)
			return true;
		else
			return false;
	}
    
    // ======================================================== //
    /* Master Functions */
    // ======================================================== //
    // Permission Functions
    function getPermissionData($userID, $alias, $table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('user_id', $userID);
		$this->db->where('permission_alias', $alias);
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
    function viewNotDepartmentData($order, $departmentID, $whereArray, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($departmentID){ $this->db->where('department_id', $departmentID); }
		if($whereArray){ $this->db->where_not_in('permission_id', $whereArray); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	function viewNotUserData($order, $userID, $whereArray, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by($order);
		if($order){ $this->db->order_by($order); }
		if($userID){ $this->db->where('user_id', $userID); }
		if($whereArray){ $this->db->where_not_in('permission_id', $whereArray); }
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
    function getDepartmentPermissionData($rightsID, $departmentID, $permissionID, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($rightsID){ $this->db->where('rights_id', $rightsID); }
		if($departmentID){ $this->db->where('department_id', $departmentID); }
		if($permissionID){ $this->db->where('permission_id', $permissionID); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function getUserPermissionData($rightsID, $userID, $permissionID, $table){
		$this->db->select('*');
		$this->db->from($table);
		if($rightsID){ $this->db->where('rights_id', $rightsID); }
		if($userID){ $this->db->where('user_id', $userID); }
		if($permissionID){ $this->db->where('permission_id', $permissionID); }
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
	}
	
	function deleteUserData($departmentID, $permissionID, $table){
		$this->db->where($departmentID);
		$this->db->where($permissionID);
		$result = $this->db->delete($table);
		if($result)
			return true;
		else
			return false;
	}
	
	function editUserData($userID, $departmentID, $permissionID, $table, $editData){
		$this->db->where($userID);
		$this->db->where($departmentID);
		$this->db->where($permissionID);
        $result = $this->db->update($table, $editData);
		if($result)
			return  true;
		else
			return false;
	}
	
	function userPermissionData($aliasName){
        $this->db->select('*');
		$this->db->from(PERMISSION_USER_TABLE);
		$this->db->where('user_id',$this->session->userdata['user_id']); 
		$this->db->where('permission_alias',$aliasName); 
		$query = $this->db->get();
		$result = $query->row_array();
		return $result;
    }
    
    function viewLoginActivityData($userID, $table){
	    $this->db->select('*');
		$this->db->from($table);
		if($userID){ $this->db->where($userID); }
		$this->db->where('user_role !=', 'Super');
		$query = $this->db->get();
		$result = $query->result_array();
		return $result;
	}
	
	// ======================================================== //
    /* Keyboard Functions */
    // ======================================================== //
	// Keyboard Category Functions
	function viewKeyboardCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('category_id','DESC');
		if(!empty($params['search_keyboard_category'])){
            $searchKeyboardCategory = $params['search_keyboard_category'];
            $likeArr = array('category_name' => $searchKeyboardCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_keyboard_category_status'])){
            $searchKeyboardCategoryStatus = $params['search_keyboard_category_status'];
            $this->db->where('category_status', $searchKeyboardCategoryStatus);
        }
        if(array_key_exists("category_id",$params)){
            $this->db->where('category_id',$params['category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countKeyboardCategory($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('category_id','DESC');
		if(!empty($params['search_keyboard_category'])){
            $searchKeyboardCategory = $params['search_keyboard_category'];
            $likeArr = array('category_name' => $searchKeyboardCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_keyboard_category_status'])){
            $searchKeyboardCategoryStatus = $params['search_keyboard_category_status'];
            $this->db->where('category_status', $searchKeyboardCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Keyboard Data Functions
	function viewKeyboardData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(KEYBOARD_CATEGORY_TABLE, KEYBOARD_DATA_TABLE . '.category_id = ' . KEYBOARD_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_keyboard_data'])){
            $searchKeyboardData = $params['search_keyboard_data'];
            $likeArr = array(KEYBOARD_CATEGORY_TABLE . '.category_name' => $searchKeyboardData, 'keyboard_name' => $searchKeyboardData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_keyboard_data_premium'])){
            $searchKeyboardDataPremium = $params['search_keyboard_data_premium'];
            $this->db->where('keyboard_premium', $searchKeyboardDataPremium);
        }
        if(!empty($params['search_keyboard_data_status'])){
            $searchKeyboardDataStatus = $params['search_keyboard_data_status'];
            $this->db->where('keyboard_status', $searchKeyboardDataStatus);
        }
        if(!empty($params['search_keyboard_data_view'])){
            $searchKeyboardDataView = $params['search_keyboard_data_view'];
            $this->db->order_by('keyboard_view', $searchKeyboardDataView);
        }
        if(!empty($params['search_keyboard_data_download'])){
            $searchKeyboardDataDownload = $params['search_keyboard_data_download'];
            $this->db->order_by('keyboard_download', $searchKeyboardDataDownload);
        }
        if(empty($params['search_keyboard_data_view']) and empty($params['search_keyboard_data_download'])){
		    $this->db->order_by('keyboard_id','DESC');
		}
        if(array_key_exists("keyboard_id",$params)){
            $this->db->where('keyboard_id',$params['keyboard_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countKeyboardData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(KEYBOARD_CATEGORY_TABLE, KEYBOARD_DATA_TABLE . '.category_id = ' . KEYBOARD_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_keyboard_data'])){
            $searchKeyboardData = $params['search_keyboard_data'];
            $likeArr = array(KEYBOARD_CATEGORY_TABLE . '.category_name' => $searchKeyboardData, 'keyboard_name' => $searchKeyboardData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_keyboard_data_premium'])){
            $searchKeyboardDataPremium = $params['search_keyboard_data_premium'];
            $this->db->where('keyboard_premium', $searchKeyboardDataPremium);
        }
        if(!empty($params['search_keyboard_data_status'])){
            $searchKeyboardDataStatus = $params['search_keyboard_data_status'];
            $this->db->where('keyboard_status', $searchKeyboardDataStatus);
        }
        if(!empty($params['search_keyboard_data_view'])){
            $searchKeyboardDataView = $params['search_keyboard_data_view'];
            $this->db->order_by('keyboard_view', $searchKeyboardDataView);
        }
        if(!empty($params['search_keyboard_data_download'])){
            $searchKeyboardDataDownload = $params['search_keyboard_data_download'];
            $this->db->order_by('keyboard_download', $searchKeyboardDataDownload);
        }
        if(empty($params['search_keyboard_data_view']) and empty($params['search_keyboard_data_download'])){
		    $this->db->order_by('keyboard_id','DESC');
		}
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Keyboard Category Data Functions
	function viewKeyboardCategoryData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(KEYBOARD_CATEGORY_TABLE, KEYBOARD_DATA_TABLE . '.category_id = ' . KEYBOARD_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_keyboard_category_data'])){
            $searchKeyboardCategoryData = $params['search_keyboard_category_data'];
            $likeArr = array(KEYBOARD_CATEGORY_TABLE . '.category_name' => $searchKeyboardCategoryData, 'keyboard_name' => $searchKeyboardCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_keyboard_category_data_premium'])){
            $searchKeyboardCategoryDataPremium = $params['search_keyboard_category_data_premium'];
            $this->db->where('keyboard_premium', $searchKeyboardCategoryDataPremium);
        }
        if(!empty($params['search_keyboard_category_data_status'])){
            $searchKeyboardCategoryDataStatus = $params['search_keyboard_category_data_status'];
            $this->db->where('keyboard_status', $searchKeyboardCategoryDataStatus);
        }
        if(!empty($params['search_keyboard_category_data_view'])){
            $searchKeyboardCategoryDataView = $params['search_keyboard_category_data_view'];
            $this->db->order_by('keyboard_view', $searchKeyboardCategoryDataView);
        }
        if(!empty($params['search_keyboard_category_data_download'])){
            $searchKeyboardCategoryDataDownload = $params['search_keyboard_category_data_download'];
            $this->db->order_by('keyboard_download', $searchKeyboardCategoryDataDownload);
        }
        if(empty($params['search_keyboard_category_data_view']) and empty($params['search_keyboard_category_data_download'])){
		    $this->db->order_by('keyboard_id','DESC');
		}
        $this->db->where(KEYBOARD_DATA_TABLE . '.category_id',$where);
        if(array_key_exists("keyboard_id",$params)){
            $this->db->where('keyboard_id',$params['keyboard_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countKeyboardCategoryData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join(KEYBOARD_CATEGORY_TABLE, KEYBOARD_DATA_TABLE . '.category_id = ' . KEYBOARD_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_keyboard_category_data'])){
            $searchKeyboardCategoryData = $params['search_keyboard_category_data'];
            $likeArr = array(KEYBOARD_CATEGORY_TABLE . '.category_name' => $searchKeyboardCategoryData, 'keyboard_name' => $searchKeyboardCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_keyboard_category_data_premium'])){
            $searchKeyboardCategoryDataPremium = $params['search_keyboard_category_data_premium'];
            $this->db->where('keyboard_premium', $searchKeyboardCategoryDataPremium);
        }
        if(!empty($params['search_keyboard_category_data_status'])){
            $searchKeyboardCategoryDataStatus = $params['search_keyboard_category_data_status'];
            $this->db->where('keyboard_status', $searchKeyboardCategoryDataStatus);
        }
        if(!empty($params['search_keyboard_category_data_view'])){
            $searchKeyboardCategoryDataView = $params['search_keyboard_category_data_view'];
            $this->db->order_by('keyboard_view', $searchKeyboardCategoryDataView);
        }
        if(!empty($params['search_keyboard_category_data_download'])){
            $searchKeyboardCategoryDataDownload = $params['search_keyboard_category_data_download'];
            $this->db->order_by('keyboard_download', $searchKeyboardCategoryDataDownload);
        }
        if(empty($params['search_keyboard_category_data_view']) and empty($params['search_keyboard_category_data_download'])){
		    $this->db->order_by('keyboard_id','DESC');
		}
        $this->db->where(KEYBOARD_DATA_TABLE . '.category_id',$where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ======================================================== //
    /* Charging Functions */
    // ======================================================== //
	// Charging Category Functions
	function viewChargingCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('category_id','DESC');
		if(!empty($params['search_charging_category'])){
            $searchChargingCategory = $params['search_charging_category'];
            $likeArr = array('category_name' => $searchChargingCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_category_status'])){
            $searchChargingCategoryStatus = $params['search_charging_category_status'];
            $this->db->where('category_status', $searchChargingCategoryStatus);
        }
        if(array_key_exists("category_id",$params)){
            $this->db->where('category_id',$params['category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countChargingCategory($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('category_id','DESC');
		if(!empty($params['search_charging_category'])){
            $searchChargingCategory = $params['search_charging_category'];
            $likeArr = array('category_name' => $searchChargingCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_category_status'])){
            $searchChargingCategoryStatus = $params['search_charging_category_status'];
            $this->db->where('category_status', $searchChargingCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Charging Data Functions
	function viewChargingData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(CHARGING_CATEGORY_TABLE, CHARGING_DATA_TABLE . '.category_id = ' . CHARGING_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_charging_data'])){
            $searchChargingData = $params['search_charging_data'];
            $likeArr = array(CHARGING_CATEGORY_TABLE . '.category_name' => $searchChargingData, 'charging_name' => $searchChargingData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_data_type'])){
            $searchChargingDataType = $params['search_charging_data_type'];
            $this->db->where('charging_type', $searchChargingDataType);
        }
        if(!empty($params['search_charging_data_premium'])){
            $searchChargingDataPremium = $params['search_charging_data_premium'];
            $this->db->where('is_premium', $searchChargingDataPremium);
        }
        if(!empty($params['search_charging_data_music'])){
            $searchChargingDataMusic = $params['search_charging_data_music'];
            $this->db->where('is_music', $searchChargingDataMusic);
        }
        if(!empty($params['search_charging_data_status'])){
            $searchChargingDataStatus = $params['search_charging_data_status'];
            $this->db->where('charging_status', $searchChargingDataStatus);
        }
        if(!empty($params['search_charging_data_view'])){
            $searchChargingDataView = $params['search_charging_data_view'];
            $this->db->order_by('charging_view', $searchChargingDataView);
        }
        if(!empty($params['search_charging_data_download'])){
            $searchChargingDataDownload = $params['search_charging_data_download'];
            $this->db->order_by('charging_download', $searchChargingDataDownload);
        }
        if(!empty($params['search_charging_data_applied'])){
            $searchChargingDataApplied = $params['search_charging_data_applied'];
            $this->db->order_by('charging_applied', $searchChargingDataApplied);
        }
        if(empty($params['search_charging_data_view']) and empty($params['search_charging_data_download']) and empty($params['search_charging_data_applied'])){
		    $this->db->order_by('charging_id','DESC');
		}
        if(array_key_exists("charging_id",$params)){
            $this->db->where('charging_id',$params['charging_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countChargingData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
		$this->db->join(CHARGING_CATEGORY_TABLE, CHARGING_DATA_TABLE . '.category_id = ' . CHARGING_CATEGORY_TABLE . '.category_id'); 
		if(!empty($params['search_charging_data'])){
            $searchChargingData = $params['search_charging_data'];
            $likeArr = array(CHARGING_CATEGORY_TABLE . '.category_name' => $searchChargingData, 'charging_name' => $searchChargingData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_data_type'])){
            $searchChargingDataType = $params['search_charging_data_type'];
            $this->db->where('charging_type', $searchChargingDataType);
        }
        if(!empty($params['search_charging_data_premium'])){
            $searchChargingDataPremium = $params['search_charging_data_premium'];
            $this->db->where('is_premium', $searchChargingDataPremium);
        }
        if(!empty($params['search_charging_data_music'])){
            $searchChargingDataMusic = $params['search_charging_data_music'];
            $this->db->where('is_music', $searchChargingDataMusic);
        }
        if(!empty($params['search_charging_data_status'])){
            $searchChargingDataStatus = $params['search_charging_data_status'];
            $this->db->where('charging_status', $searchChargingDataStatus);
        }
        if(!empty($params['search_charging_data_view'])){
            $searchChargingDataView = $params['search_charging_data_view'];
            $this->db->order_by('charging_view', $searchChargingDataView);
        }
        if(!empty($params['search_charging_data_download'])){
            $searchChargingDataDownload = $params['search_charging_data_download'];
            $this->db->order_by('charging_download', $searchChargingDataDownload);
        }
        if(!empty($params['search_charging_data_applied'])){
            $searchChargingDataApplied = $params['search_charging_data_applied'];
            $this->db->order_by('charging_applied', $searchChargingDataApplied);
        }
        if(empty($params['search_charging_data_view']) and empty($params['search_charging_data_download']) and empty($params['search_charging_data_applied'])){
		    $this->db->order_by('charging_id','DESC');
		}
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Charging Category Data Functions
	function viewChargingCategoryData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(CHARGING_CATEGORY_TABLE, CHARGING_DATA_TABLE . '.category_id = ' . CHARGING_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_charging_category_data'])){
            $searchChargingCategoryData = $params['search_charging_category_data'];
            $likeArr = array(CHARGING_CATEGORY_TABLE . '.category_name' => $searchChargingCategoryData, 'charging_name' => $searchChargingCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_charging_category_data_type'])){
            $searchChargingCategoryDataType = $params['search_charging_category_data_type'];
            $this->db->where('charging_type', $searchChargingCategoryDataType);
        }
        if(!empty($params['search_charging_category_data_premium'])){
            $searchChargingCategoryDataPremium = $params['search_charging_category_data_premium'];
            $this->db->where('is_premium', $searchChargingCategoryDataPremium);
        }
        if(!empty($params['search_charging_category_data_music'])){
            $searchChargingCategoryDataMusic = $params['search_charging_category_data_music'];
            $this->db->where('is_music', $searchChargingCategoryDataMusic);
        }
        if(!empty($params['search_charging_category_data_status'])){
            $searchChargingCategoryDataStatus = $params['search_charging_category_data_status'];
            $this->db->where('charging_status', $searchChargingCategoryDataStatus);
        }
        if(!empty($params['search_charging_category_data_view'])){
            $searchChargingCategoryDataView = $params['search_charging_category_data_view'];
            $this->db->order_by('charging_view', $searchChargingCategoryDataView);
        }
        if(!empty($params['search_charging_category_data_download'])){
            $searchChargingCategoryDataDownload = $params['search_charging_category_data_download'];
            $this->db->order_by('charging_download', $searchChargingCategoryDataDownload);
        }
        if(!empty($params['search_charging_category_data_applied'])){
            $searchChargingCategoryDataApplied = $params['search_charging_category_data_applied'];
            $this->db->order_by('charging_applied', $searchChargingCategoryDataApplied);
        }
        if(empty($params['search_charging_category_data_view']) and empty($params['search_charging_category_data_download']) and empty($params['search_charging_category_data_applied'])){
		    $this->db->order_by('charging_id','DESC');
		}
        $this->db->where(CHARGING_DATA_TABLE . '.category_id',$where);
        if(array_key_exists("charging_id",$params)){
            $this->db->where('charging_id',$params['charging_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countChargingCategoryData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
		$this->db->join(CHARGING_CATEGORY_TABLE, CHARGING_DATA_TABLE . '.category_id = ' . CHARGING_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_charging_category_data'])){
            $searchChargingCategoryData = $params['search_charging_category_data'];
            $likeArr = array(CHARGING_CATEGORY_TABLE . '.category_name' => $searchChargingCategoryData, 'charging_name' => $searchChargingCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_charging_category_data_type'])){
            $searchChargingCategoryDataType = $params['search_charging_category_data_type'];
            $this->db->where('charging_type', $searchChargingCategoryDataType);
        }
        if(!empty($params['search_charging_category_data_premium'])){
            $searchChargingCategoryDataPremium = $params['search_charging_category_data_premium'];
            $this->db->where('is_premium', $searchChargingCategoryDataPremium);
        }
        if(!empty($params['search_charging_category_data_music'])){
            $searchChargingCategoryDataMusic = $params['search_charging_category_data_music'];
            $this->db->where('is_music', $searchChargingCategoryDataMusic);
        }
        if(!empty($params['search_charging_category_data_status'])){
            $searchChargingCategoryDataStatus = $params['search_charging_category_data_status'];
            $this->db->where('charging_status', $searchChargingCategoryDataStatus);
        }
        if(!empty($params['search_charging_category_data_view'])){
            $searchChargingCategoryDataView = $params['search_charging_category_data_view'];
            $this->db->order_by('charging_view', $searchChargingCategoryDataView);
        }
        if(!empty($params['search_charging_category_data_download'])){
            $searchChargingCategoryDataDownload = $params['search_charging_category_data_download'];
            $this->db->order_by('charging_download', $searchChargingCategoryDataDownload);
        }
        if(!empty($params['search_charging_category_data_applied'])){
            $searchChargingCategoryDataApplied = $params['search_charging_category_data_applied'];
            $this->db->order_by('charging_applied', $searchChargingCategoryDataApplied);
        }
        if(empty($params['search_charging_category_data_view']) and empty($params['search_charging_category_data_download']) and empty($params['search_charging_category_data_applied'])){
		    $this->db->order_by('charging_id','DESC');
		}
        $this->db->where(CHARGING_DATA_TABLE . '.category_id',$where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Charging Search Functions
	function viewChargingSearchData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('search_id','DESC');
		if(!empty($params['search_charging_search'])){
            $searchChargingSearch = $params['search_charging_search'];
            $likeArr = array('search_query' => $searchChargingSearch);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_search_status'])){
            $searchChargingSearchStatus = $params['search_charging_search_status'];
            $this->db->where('search_status', $searchChargingSearchStatus);
        }
        if(array_key_exists("search_id",$params)){
            $this->db->where('search_id',$params['search_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countChargingSearchData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('search_id','DESC');
		if(!empty($params['search_charging_search'])){
            $searchChargingSearch = $params['search_charging_search'];
            $likeArr = array('search_query' => $searchChargingSearch);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_charging_search_status'])){
            $searchChargingSearchStatus = $params['search_charging_search_status'];
            $this->db->where('search_status', $searchChargingSearchStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ======================================================== //
    /* Applock Functions */
    // ======================================================== //
	// Applock Category Functions
	function viewApplockCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('category_id','DESC');
		if(!empty($params['search_applock_category'])){
            $searchApplockCategory = $params['search_applock_category'];
            $likeArr = array('category_name' => $searchApplockCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_applock_category_status'])){
            $searchApplockCategoryStatus = $params['search_applock_category_status'];
            $this->db->where('category_status', $searchApplockCategoryStatus);
        }
        if(array_key_exists("category_id",$params)){
            $this->db->where('category_id',$params['category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countApplockCategory($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('category_id','DESC');
		if(!empty($params['search_applock_category'])){
            $searchApplockCategory = $params['search_applock_category'];
            $likeArr = array('category_name' => $searchApplockCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_applock_category_status'])){
            $searchApplockCategoryStatus = $params['search_applock_category_status'];
            $this->db->where('category_status', $searchApplockCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Applock Data Functions
	function viewApplockData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(APPLOCK_CATEGORY_TABLE, APPLOCK_DATA_TABLE . '.category_id = ' . APPLOCK_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_applock_data'])){
            $searchApplockData = $params['search_applock_data'];
            $likeArr = array(APPLOCK_CATEGORY_TABLE . '.category_name' => $searchApplockData, 'applock_name' => $searchApplockData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_applock_data_type'])){
            $searchApplockDataType = $params['search_applock_data_type'];
            $this->db->where('applock_type', $searchApplockDataType);
        }
        if(!empty($params['search_applock_data_premium'])){
            $searchApplockDataPremium = $params['search_applock_data_premium'];
            $this->db->where('is_premium', $searchApplockDataPremium);
        }
        if(!empty($params['search_applock_data_status'])){
            $searchApplockDataStatus = $params['search_applock_data_status'];
            $this->db->where('applock_status', $searchApplockDataStatus);
        }
        if(!empty($params['search_applock_data_view'])){
            $searchApplockDataView = $params['search_applock_data_view'];
            $this->db->order_by('applock_view', $searchApplockDataView);
        }
        if(!empty($params['search_applock_data_download'])){
            $searchApplockDataDownload = $params['search_applock_data_download'];
            $this->db->order_by('applock_download', $searchApplockDataDownload);
        }
        if(!empty($params['search_applock_data_applied'])){
            $searchApplockDataApplied = $params['search_applock_data_applied'];
            $this->db->order_by('applock_applied', $searchApplockDataApplied);
        }
        if(empty($params['search_applock_data_view']) and empty($params['search_applock_data_download']) and empty($params['search_applock_data_applied'])){
		    $this->db->order_by('applock_id','DESC');
		}
        if(array_key_exists("applock_id",$params)){
            $this->db->where('applock_id',$params['applock_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countApplockData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
		$this->db->join(APPLOCK_CATEGORY_TABLE, APPLOCK_DATA_TABLE . '.category_id = ' . APPLOCK_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_applock_data'])){
            $searchApplockData = $params['search_applock_data'];
            $likeArr = array(APPLOCK_CATEGORY_TABLE . '.category_name' => $searchApplockData, 'applock_name' => $searchApplockData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_applock_data_type'])){
            $searchApplockDataType = $params['search_applock_data_type'];
            $this->db->where('applock_type', $searchApplockDataType);
        }
        if(!empty($params['search_applock_data_premium'])){
            $searchApplockDataPremium = $params['search_applock_data_premium'];
            $this->db->where('is_premium', $searchApplockDataPremium);
        }
        if(!empty($params['search_applock_data_status'])){
            $searchApplockDataStatus = $params['search_applock_data_status'];
            $this->db->where('applock_status', $searchApplockDataStatus);
        }
        if(!empty($params['search_applock_data_view'])){
            $searchApplockDataView = $params['search_applock_data_view'];
            $this->db->order_by('applock_view', $searchApplockDataView);
        }
        if(!empty($params['search_applock_data_download'])){
            $searchApplockDataDownload = $params['search_applock_data_download'];
            $this->db->order_by('applock_download', $searchApplockDataDownload);
        }
        if(!empty($params['search_applock_data_applied'])){
            $searchApplockDataApplied = $params['search_applock_data_applied'];
            $this->db->order_by('applock_applied', $searchApplockDataApplied);
        }
        if(empty($params['search_applock_data_view']) and empty($params['search_applock_data_download']) and empty($params['search_applock_data_applied'])){
		    $this->db->order_by('applock_id','DESC');
		}
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Applock Category Data Functions
	function viewApplockCategoryData($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->join(APPLOCK_CATEGORY_TABLE, APPLOCK_DATA_TABLE . '.category_id = ' . APPLOCK_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_applock_category_data'])){
            $searchApplockCategoryData = $params['search_applock_category_data'];
            $likeArr = array(APPLOCK_CATEGORY_TABLE . '.category_name' => $searchApplockCategoryData, 'applock_name' => $searchApplockCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_applock_category_data_type'])){
            $searchApplockCategoryDataType = $params['search_applock_category_data_type'];
            $this->db->where('applock_type', $searchApplockCategoryDataType);
        }
        if(!empty($params['search_applock_category_data_premium'])){
            $searchApplockCategoryDataPremium = $params['search_applock_category_data_premium'];
            $this->db->where('is_premium', $searchApplockCategoryDataPremium);
        }
        if(!empty($params['search_applock_category_data_status'])){
            $searchApplockCategoryDataStatus = $params['search_applock_category_data_status'];
            $this->db->where('applock_status', $searchApplockCategoryDataStatus);
        }
        if(!empty($params['search_applock_category_data_view'])){
            $searchApplockCategoryDataView = $params['search_applock_category_data_view'];
            $this->db->order_by('applock_view', $searchApplockCategoryDataView);
        }
        if(!empty($params['search_applock_category_data_download'])){
            $searchApplockCategoryDataDownload = $params['search_applock_category_data_download'];
            $this->db->order_by('applock_download', $searchApplockCategoryDataDownload);
        }
        if(!empty($params['search_applock_category_data_applied'])){
            $searchApplockCategoryDataApplied = $params['search_applock_category_data_applied'];
            $this->db->order_by('applock_applied', $searchApplockCategoryDataApplied);
        }
        if(empty($params['search_applock_category_data_view']) and empty($params['search_applock_category_data_download']) and empty($params['search_applock_category_data_applied'])){
		    $this->db->order_by('applock_id','DESC');
		}
        $this->db->where(APPLOCK_DATA_TABLE . '.category_id',$where);
        if(array_key_exists("applock_id",$params)){
            $this->db->where('applock_id',$params['applock_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countApplockCategoryData($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
		$this->db->join(APPLOCK_CATEGORY_TABLE, APPLOCK_DATA_TABLE . '.category_id = ' . APPLOCK_CATEGORY_TABLE . '.category_id');
		if(!empty($params['search_applock_category_data'])){
            $searchApplockCategoryData = $params['search_applock_category_data'];
            $likeArr = array(APPLOCK_CATEGORY_TABLE . '.category_name' => $searchApplockCategoryData, 'applock_name' => $searchApplockCategoryData);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_applock_category_data_type'])){
            $searchApplockCategoryDataType = $params['search_applock_category_data_type'];
            $this->db->where('applock_type', $searchApplockCategoryDataType);
        }
        if(!empty($params['search_applock_category_data_premium'])){
            $searchApplockCategoryDataPremium = $params['search_applock_category_data_premium'];
            $this->db->where('is_premium', $searchApplockCategoryDataPremium);
        }
        if(!empty($params['search_applock_category_data_status'])){
            $searchApplockCategoryDataStatus = $params['search_applock_category_data_status'];
            $this->db->where('applock_status', $searchApplockCategoryDataStatus);
        }
        if(!empty($params['search_applock_category_data_view'])){
            $searchApplockCategoryDataView = $params['search_applock_category_data_view'];
            $this->db->order_by('applock_view', $searchApplockCategoryDataView);
        }
        if(!empty($params['search_applock_category_data_download'])){
            $searchApplockCategoryDataDownload = $params['search_applock_category_data_download'];
            $this->db->order_by('applock_download', $searchApplockCategoryDataDownload);
        }
        if(!empty($params['search_applock_category_data_applied'])){
            $searchApplockCategoryDataApplied = $params['search_applock_category_data_applied'];
            $this->db->order_by('applock_applied', $searchApplockCategoryDataApplied);
        }
        if(empty($params['search_applock_category_data_view']) and empty($params['search_applock_category_data_download']) and empty($params['search_applock_category_data_applied'])){
		    $this->db->order_by('applock_id','DESC');
		}
        $this->db->where(APPLOCK_DATA_TABLE . '.category_id',$where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ======================================================== //
    /* Gallery Functions */
    // ======================================================== //
	// Ai Gallery Category Functions
	function viewAiGalleryCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('category_id','DESC');
		if(!empty($params['search_ai_gallery_category'])){
            $searchAiGalleryCategory = $params['search_ai_gallery_category'];
            $likeArr = array('category_name' => $searchAiGalleryCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_category_status'])){
            $searchAiGalleryCategoryStatus = $params['search_ai_gallery_category_status'];
            $this->db->where('category_status', $searchAiGalleryCategoryStatus);
        }
        if(array_key_exists("category_id",$params)){
            $this->db->where('category_id',$params['category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiGalleryCategory($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('category_id','DESC');
		if(!empty($params['search_ai_gallery_category'])){
            $searchAiGalleryCategory = $params['search_ai_gallery_category'];
            $likeArr = array('category_name' => $searchAiGalleryCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_category_status'])){
            $searchAiGalleryCategoryStatus = $params['search_ai_gallery_category_status'];
            $this->db->where('category_status', $searchAiGalleryCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Gallery Data Functions
	function viewAiGalleryData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('image_id','DESC');
		if(!empty($params['search_ai_gallery_data'])){
            $searchAiGalleryData = $params['search_ai_gallery_data'];
            $likeArr = array('image_prompt' => $searchAiGalleryData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_data_style'])){
            $searchAiGalleryDataStyle = $params['search_ai_gallery_data_style'];
            $this->db->where('image_style', $searchAiGalleryDataStyle);
        }
        if(!empty($params['search_ai_gallery_data_size'])){
            $searchAiGalleryDataSize = $params['search_ai_gallery_data_size'];
            $this->db->where('image_size', $searchAiGalleryDataSize);
        }
        if(!empty($params['search_ai_gallery_data_show'])){
            $searchAiGalleryDataShow = $params['search_ai_gallery_data_show'];
            $this->db->where('image_show', $searchAiGalleryDataShow);
        }
        if(!empty($params['search_ai_gallery_data_status'])){
            $searchAiGalleryDataStatus = $params['search_ai_gallery_data_status'];
            $this->db->where('image_status', $searchAiGalleryDataStatus);
        }
        if(array_key_exists("image_id",$params)){
            $this->db->where('image_id',$params['image_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiGalleryData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('image_id','DESC');
        if(!empty($params['search_ai_gallery_data'])){
            $searchAiGalleryData = $params['search_ai_gallery_data'];
            $likeArr = array('image_prompt' => $searchAiGalleryData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_data_style'])){
            $searchAiGalleryDataStyle = $params['search_ai_gallery_data_style'];
            $this->db->where('image_style', $searchAiGalleryDataStyle);
        }
        if(!empty($params['search_ai_gallery_data_size'])){
            $searchAiGalleryDataSize = $params['search_ai_gallery_data_size'];
            $this->db->where('image_size', $searchAiGalleryDataSize);
        }
        if(!empty($params['search_ai_gallery_data_show'])){
            $searchAiGalleryDataShow = $params['search_ai_gallery_data_show'];
            $this->db->where('image_show', $searchAiGalleryDataShow);
        }
        if(!empty($params['search_ai_gallery_data_status'])){
            $searchAiGalleryDataStatus = $params['search_ai_gallery_data_status'];
            $this->db->where('image_status', $searchAiGalleryDataStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Gallery Image Functions
	function viewAiGalleryImage($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('image_id','DESC');
		if(!empty($params['search_ai_gallery_image'])){
            $searchAiGalleryImage = $params['search_ai_gallery_image'];
            $likeArr = array('image_prompt' => $searchAiGalleryImage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_image_style'])){
            $searchAiGalleryImageStyle = $params['search_ai_gallery_image_style'];
            $this->db->where('image_style', $searchAiGalleryImageStyle);
        }
        if(!empty($params['search_ai_gallery_image_size'])){
            $searchAiGalleryImageSize = $params['search_ai_gallery_image_size'];
            $this->db->where('image_size', $searchAiGalleryImageSize);
        }
        if(!empty($params['search_ai_gallery_image_show'])){
            $searchAiGalleryImageShow = $params['search_ai_gallery_image_show'];
            $this->db->where('image_show', $searchAiGalleryImageShow);
        }
        if(!empty($params['search_ai_gallery_image_status'])){
            $searchAiGalleryImageStatus = $params['search_ai_gallery_image_status'];
            $this->db->where('image_status', $searchAiGalleryImageStatus);
        }
        if(array_key_exists("image_id",$params)){
            $this->db->where('image_id',$params['image_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiGalleryImage($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('image_id','DESC');
        if(!empty($params['search_ai_gallery_image'])){
            $searchAiGalleryImage = $params['search_ai_gallery_image'];
            $likeArr = array('image_prompt' => $searchAiGalleryImage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_image_style'])){
            $searchAiGalleryImageStyle = $params['search_ai_gallery_image_style'];
            $this->db->where('image_style', $searchAiGalleryImageStyle);
        }
        if(!empty($params['search_ai_gallery_image_size'])){
            $searchAiGalleryImageSize = $params['search_ai_gallery_image_size'];
            $this->db->where('image_size', $searchAiGalleryImageSize);
        }
        if(!empty($params['search_ai_gallery_image_show'])){
            $searchAiGalleryImageShow = $params['search_ai_gallery_image_show'];
            $this->db->where('image_show', $searchAiGalleryImageShow);
        }
        if(!empty($params['search_ai_gallery_image_status'])){
            $searchAiGalleryImageStatus = $params['search_ai_gallery_image_status'];
            $this->db->where('image_status', $searchAiGalleryImageStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Gallery Category Image Functions
	function viewAiGalleryCategoryImage($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('image_id','DESC');
		if(!empty($params['search_ai_gallery_category_image'])){
            $searchAiGalleryCategoryImage = $params['search_ai_gallery_category_image'];
            $likeArr = array('image_prompt' => $searchAiGalleryCategoryImage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_category_image_style'])){
            $searchAiGalleryCategoryImageStyle = $params['search_ai_gallery_category_image_style'];
            $this->db->where('image_style', $searchAiGalleryCategoryImageStyle);
        }
        if(!empty($params['search_ai_gallery_category_image_size'])){
            $searchAiGalleryCategoryImageSize = $params['search_ai_gallery_category_image_size'];
            $this->db->where('image_size', $searchAiGalleryCategoryImageSize);
        }
        if(!empty($params['search_ai_gallery_category_image_show'])){
            $searchAiGalleryCategoryImageShow = $params['search_ai_gallery_category_image_show'];
            $this->db->where('image_show', $searchAiGalleryCategoryImageShow);
        }
        if(!empty($params['search_ai_gallery_category_image_status'])){
            $searchAiGalleryCategoryImageStatus = $params['search_ai_gallery_category_image_status'];
            $this->db->where('image_status', $searchAiGalleryCategoryImageStatus);
        }
        $this->db->where('category_id',$where);
        if(array_key_exists("image_id",$params)){
            $this->db->where('image_id',$params['image_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiGalleryCategoryImage($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
		$this->db->order_by('image_id','DESC');
		if(!empty($params['search_ai_gallery_category_image'])){
            $searchAiGalleryCategoryImage = $params['search_ai_gallery_category_image'];
            $likeArr = array('image_prompt' => $searchAiGalleryCategoryImage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_gallery_category_image_style'])){
            $searchAiGalleryCategoryImageStyle = $params['search_ai_gallery_category_image_style'];
            $this->db->where('image_style', $searchAiGalleryCategoryImageStyle);
        }
        if(!empty($params['search_ai_gallery_category_image_size'])){
            $searchAiGalleryCategoryImageSize = $params['search_ai_gallery_category_image_size'];
            $this->db->where('image_size', $searchAiGalleryCategoryImageSize);
        }
        if(!empty($params['search_ai_gallery_category_image_show'])){
            $searchAiGalleryCategoryImageShow = $params['search_ai_gallery_category_image_show'];
            $this->db->where('image_show', $searchAiGalleryCategoryImageShow);
        }
        if(!empty($params['search_ai_gallery_category_image_status'])){
            $searchAiGalleryCategoryImageStatus = $params['search_ai_gallery_category_image_status'];
            $this->db->where('image_status', $searchAiGalleryCategoryImageStatus);
        }
        $this->db->where('category_id',$where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ======================================================== //
    /* Chat Functions */
    // ======================================================== //
    // Ai Chat Language Functions
	function viewAiChatLanguage($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('language_id','DESC');
		if(!empty($params['search_ai_chat_language'])){
            $searchAiChatLanguage = $params['search_ai_chat_language'];
            $likeArr = array('language_title' => $searchAiChatLanguage, 'language_name' => $searchAiChatLanguage, 'language_code' => $searchAiChatLanguage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_language_status'])){
            $searchAiChatLanguageStatus = $params['search_ai_chat_language_status'];
            $this->db->where('language_status', $searchAiChatLanguageStatus);
        }
        if(array_key_exists("language_id",$params)){
            $this->db->where('language_id',$params['language_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatLanguage($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('language_id','DESC');
		if(!empty($params['search_ai_chat_language'])){
            $searchAiChatLanguage = $params['search_ai_chat_language'];
            $likeArr = array('language_title' => $searchAiChatLanguage, 'language_name' => $searchAiChatLanguage, 'language_code' => $searchAiChatLanguage);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_language_status'])){
            $searchAiChatLanguageStatus = $params['search_ai_chat_language_status'];
            $this->db->where('language_status', $searchAiChatLanguageStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
    // Ai Chat Model Functions
	function viewAiChatModel($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('model_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_MODEL_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		if(!empty($params['search_ai_chat_model'])){
            $searchAiChatModel = $params['search_ai_chat_model'];
            $likeArr = array('model_name' => $searchAiChatModel, 'model_description' => $searchAiChatModel, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatModel, 'model_position' => $searchAiChatModel, 'model_premium' => $searchAiChatModel);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_model_status'])){
            $searchAiChatModelStatus = $params['search_ai_chat_model_status'];
            $this->db->where('model_status', $searchAiChatModelStatus);
        }
        if(array_key_exists("model_id",$params)){
            $this->db->where('model_id',$params['model_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatModel($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('model_id','DESC');
        $this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_MODEL_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		if(!empty($params['search_ai_chat_model'])){
            $searchAiChatModel = $params['search_ai_chat_model'];
            $likeArr = array('model_name' => $searchAiChatModel, 'model_description' => $searchAiChatModel, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatModel, 'model_position' => $searchAiChatModel, 'model_premium' => $searchAiChatModel);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_model_status'])){
            $searchAiChatModelStatus = $params['search_ai_chat_model_status'];
            $this->db->where('model_status', $searchAiChatModelStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Main Category Functions
	function viewAiChatMainCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('main_category_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_MAIN_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		if(!empty($params['search_ai_chat_main_category'])){
            $searchAiChatMainCategory = $params['search_ai_chat_main_category'];
            $likeArr = array('main_category_name' => $searchAiChatMainCategory, 'main_category_title' => $searchAiChatMainCategory, 'main_category_description' => $searchAiChatMainCategory, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatMainCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_main_category_status'])){
            $searchAiChatMainCategoryStatus = $params['search_ai_chat_main_category_status'];
            $this->db->where('main_category_status', $searchAiChatMainCategoryStatus);
        }
        if(array_key_exists("main_category_id",$params)){
            $this->db->where('main_category_id',$params['main_category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatMainCategory($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('main_category_id','DESC');
        $this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_MAIN_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		if(!empty($params['search_ai_chat_main_category'])){
            $searchAiChatMainCategory = $params['search_ai_chat_main_category'];
            $likeArr = array('main_category_name' => $searchAiChatMainCategory, 'main_category_title' => $searchAiChatMainCategory, 'main_category_description' => $searchAiChatMainCategory, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatMainCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_main_category_status'])){
            $searchAiChatMainCategoryStatus = $params['search_ai_chat_main_category_status'];
            $this->db->where('main_category_status', $searchAiChatMainCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAiChatMainCategoryData($order, $where, $table) {
        $this->db->select('*');
        $this->db->from($table);
        if($order){ $this->db->order_by($order); }
        if($where){ $this->db->where($where); }
        $query = $this->db->get();
        $result = $query->result_array();
        $uniqueResult = [];
        foreach($result as $item){
            $uniqueResult[$item['main_category_identifier_name']] = $item;
        }
        $uniqueResult = array_values($uniqueResult);
        return $uniqueResult;
    }
	
	// Ai Chat Sub Category Functions
	function viewAiChatSubCategory($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sub_category_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_MAIN_CATEGORY_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id = ' . AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_id');
		if(!empty($params['search_ai_chat_sub_category'])){
            $searchAiChatSubCategory = $params['search_ai_chat_sub_category'];
            $likeArr = array(AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_name' => $searchAiChatSubCategory, 'sub_category_name' => $searchAiChatSubCategory, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatSubCategory, 'sub_category_position' => $searchAiChatSubCategory, 'sub_category_view' => $searchAiChatSubCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_sub_category_status'])){
            $searchAiChatSubCategoryStatus = $params['search_ai_chat_sub_category_status'];
            $this->db->where('sub_category_status', $searchAiChatSubCategoryStatus);
        }
        if(array_key_exists("sub_category_id",$params)){
            $this->db->where('sub_category_id',$params['sub_category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatSubCategory($params, $table){
        $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sub_category_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_MAIN_CATEGORY_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id = ' . AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_id');
		if(!empty($params['search_ai_chat_sub_category'])){
            $searchAiChatSubCategory = $params['search_ai_chat_sub_category'];
            $likeArr = array(AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_name' => $searchAiChatSubCategory, 'sub_category_name' => $searchAiChatSubCategory, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatSubCategory, 'sub_category_position' => $searchAiChatSubCategory, 'sub_category_view' => $searchAiChatSubCategory);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_sub_category_status'])){
            $searchAiChatSubCategoryStatus = $params['search_ai_chat_sub_category_status'];
            $this->db->where('sub_category_status', $searchAiChatSubCategoryStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Sub Categories Functions
	function viewAiChatSubCategories($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sub_category_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_MAIN_CATEGORY_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id = ' . AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_id');
		if(!empty($params['search_ai_chat_sub_categories'])){
            $searchAiChatSubCategories = $params['search_ai_chat_sub_categories'];
            $likeArr = array(AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_name' => $searchAiChatSubCategories, 'sub_category_name' => $searchAiChatSubCategories, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatSubCategories, 'sub_category_position' => $searchAiChatSubCategories, 'sub_category_view' => $searchAiChatSubCategories);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ai_chat_sub_categories_status'])){
            $searchAiChatSubCategoriesStatus = $params['search_ai_chat_sub_categories_status'];
            $this->db->where('sub_category_status', $searchAiChatSubCategoriesStatus);
        }
        $this->db->where(AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id', $where);
        if(array_key_exists("sub_category_id",$params)){
            $this->db->where('sub_category_id',$params['sub_category_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatSubCategories($params, $where, $table){
        $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('sub_category_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_MAIN_CATEGORY_TABLE, AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id = ' . AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_id');
		if(!empty($params['search_ai_chat_sub_categories'])){
            $searchAiChatSubCategories = $params['search_ai_chat_sub_categories'];
            $likeArr = array(AI_CHAT_MAIN_CATEGORY_TABLE . '.main_category_name' => $searchAiChatSubCategories, 'sub_category_name' => $searchAiChatSubCategories, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatSubCategories, 'sub_category_position' => $searchAiChatSubCategories, 'sub_category_view' => $searchAiChatSubCategories);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ai_chat_sub_categories_status'])){
            $searchAiChatSubCategoriesStatus = $params['search_ai_chat_sub_categories_status'];
            $this->db->where('sub_category_status', $searchAiChatSubCategoriesStatus);
        }
        $this->db->where(AI_CHAT_SUB_CATEGORY_TABLE . '.main_category_id', $where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	function viewAiChatSubCategoryData($order, $where, $table) {
        $this->db->select('*');
        $this->db->from($table);
        if($order){ $this->db->order_by($order); }
        if($where){ $this->db->where($where); }
        $query = $this->db->get();
        $result = $query->result_array();
        $uniqueResult = [];
        foreach($result as $item){
            $uniqueResult[$item['sub_category_identifier_name']] = $item;
        }
        $uniqueResult = array_values($uniqueResult);
        return $uniqueResult;
    }
    
	// Ai Chat Data Functions
	function viewAiChatData($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('data_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_DATA_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_SUB_CATEGORY_TABLE, AI_CHAT_DATA_TABLE . '.sub_category_id = ' . AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_id');
		if(!empty($params['search_ai_chat_data'])){
            $searchAiChatData = $params['search_ai_chat_data'];
            $likeArr = array(AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_name' => $searchAiChatData, 'data_title' => $searchAiChatData, 'data_prompt' => $searchAiChatData, 'data_note' => $searchAiChatData, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatData, 'data_position' => $searchAiChatData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_data_status'])){
            $searchAiChatDataStatus = $params['search_ai_chat_data_status'];
            $this->db->where('data_status', $searchAiChatDataStatus);
        }
        if(array_key_exists("data_id",$params)){
            $this->db->where('data_id',$params['data_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatData($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('data_id','DESC');
        $this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_DATA_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_SUB_CATEGORY_TABLE, AI_CHAT_DATA_TABLE . '.sub_category_id = ' . AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_id');
		if(!empty($params['search_ai_chat_data'])){
            $searchAiChatData = $params['search_ai_chat_data'];
            $likeArr = array(AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_name' => $searchAiChatData, 'data_title' => $searchAiChatData, 'data_prompt' => $searchAiChatData, 'data_note' => $searchAiChatData, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatData, 'data_position' => $searchAiChatData);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_data_status'])){
            $searchAiChatDataStatus = $params['search_ai_chat_data_status'];
            $this->db->where('data_status', $searchAiChatDataStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Datas Functions
	function viewAiChatDatas($params, $where, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('data_id','DESC');
		$this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_DATA_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_SUB_CATEGORY_TABLE, AI_CHAT_DATA_TABLE . '.sub_category_id = ' . AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_id');
		if(!empty($params['search_ai_chat_datas'])){
            $searchAiChatDatas = $params['search_ai_chat_datas'];
            $likeArr = array(AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_name' => $searchAiChatDatas, 'data_title' => $searchAiChatDatas, 'data_prompt' => $searchAiChatDatas, 'data_note' => $searchAiChatDatas, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatDatas, 'data_position' => $searchAiChatDatas);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ai_chat_datas_status'])){
            $searchAiChatDatasStatus = $params['search_ai_chat_datas_status'];
            $this->db->where('data_status', $searchAiChatDatasStatus);
        }
        $this->db->where(AI_CHAT_DATA_TABLE . '.sub_category_id', $where);
        if(array_key_exists("data_id",$params)){
            $this->db->where('data_id',$params['data_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatDatas($params, $where, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('data_id','DESC');
        $this->db->join(AI_CHAT_LANGUAGE_TABLE, AI_CHAT_DATA_TABLE . '.language_code = ' . AI_CHAT_LANGUAGE_TABLE . '.language_code');
		$this->db->join(AI_CHAT_SUB_CATEGORY_TABLE, AI_CHAT_DATA_TABLE . '.sub_category_id = ' . AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_id');
		if(!empty($params['search_ai_chat_datas'])){
            $searchAiChatDatas = $params['search_ai_chat_datas'];
            $likeArr = array(AI_CHAT_SUB_CATEGORY_TABLE . '.sub_category_name' => $searchAiChatDatas, 'data_title' => $searchAiChatDatas, 'data_prompt' => $searchAiChatDatas, 'data_note' => $searchAiChatDatas, AI_CHAT_LANGUAGE_TABLE . '.language_name' => $searchAiChatDatas, 'data_position' => $searchAiChatDatas);
            $this->db->group_start();
            $this->db->or_like($likeArr);
            $this->db->group_end();
        }
        if(!empty($params['search_ai_chat_datas_status'])){
            $searchAiChatDatasStatus = $params['search_ai_chat_datas_status'];
            $this->db->where('data_status', $searchAiChatDatasStatus);
        }
        $this->db->where(AI_CHAT_DATA_TABLE . '.sub_category_id', $where);
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Prompt Functions
	function viewAiChatPrompt($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('chat_id','DESC');
		if(!empty($params['search_ai_chat_prompt'])){
            $searchAiChatPrompt = $params['search_ai_chat_prompt'];
            $likeArr = array('chat_prompt' => $searchAiChatPrompt);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_prompt_model'])){
            if($params['search_ai_chat_prompt_model'] == 'gpt-3.5-turbo-0613'){
                $searchAiChatPromptModel = array('gpt-3.5-turbo-0613','gpt-3.5-turbo-0125');
            } else if($params['search_ai_chat_prompt_model'] == 'gpt-4-0613'){
                $searchAiChatPromptModel = array('gpt-4-0613','gpt-4-0125-preview');
            } else if($params['search_ai_chat_prompt_model'] == 'mistral-tiny'){
                $searchAiChatPromptModel = array('mistral-tiny');
            } else if($params['search_ai_chat_prompt_model'] == 'claude-3-haiku'){
                $searchAiChatPromptModel = array('claude-3-haiku');
            } else if($params['search_ai_chat_prompt_model'] == 'gemini-pro'){
                $searchAiChatPromptModel = array('gemini-pro');
            }
            $this->db->where_in('chat_model', $searchAiChatPromptModel);
        }
        if(!empty($params['search_ai_chat_prompt_status'])){
            $searchAiChatPromptStatus = $params['search_ai_chat_prompt_status'];
            $this->db->where('chat_status', $searchAiChatPromptStatus);
        }
        if(array_key_exists("chat_id",$params)){
            $this->db->where('chat_id',$params['chat_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatPrompt($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('chat_id','DESC');
        if(!empty($params['search_ai_chat_prompt'])){
            $searchAiChatPrompt = $params['search_ai_chat_prompt'];
            $likeArr = array('chat_prompt' => $searchAiChatPrompt);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_prompt_model'])){
            if($params['search_ai_chat_prompt_model'] == 'gpt-3.5-turbo-0613'){
                $searchAiChatPromptModel = array('gpt-3.5-turbo-0613','gpt-3.5-turbo-0125');
            } else if($params['search_ai_chat_prompt_model'] == 'gpt-4-0613'){
                $searchAiChatPromptModel = array('gpt-4-0613','gpt-4-0125-preview');
            } else if($params['search_ai_chat_prompt_model'] == 'mistral-tiny'){
                $searchAiChatPromptModel = array('mistral-tiny');
            } else if($params['search_ai_chat_prompt_model'] == 'claude-3-haiku'){
                $searchAiChatPromptModel = array('claude-3-haiku');
            } else if($params['search_ai_chat_prompt_model'] == 'gemini-pro'){
                $searchAiChatPromptModel = array('gemini-pro');
            }
            $this->db->where_in('chat_model', $searchAiChatPromptModel);
        }
        if(!empty($params['search_ai_chat_prompt_status'])){
            $searchAiChatPromptStatus = $params['search_ai_chat_prompt_status'];
            $this->db->where('chat_status', $searchAiChatPromptStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Feedback Functions
	function viewAiChatFeedback($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('feedback_id','DESC');
		if(!empty($params['search_ai_chat_feedback'])){
            $searchAiChatFeedback = $params['search_ai_chat_feedback'];
            $likeArr = array('feedback_message' => $searchAiChatFeedback, 'feedback_language' => $searchAiChatFeedback, 'feedback_date' => $searchAiChatFeedback);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_feedback_status'])){
            $searchAiChatFeedbackStatus = $params['search_ai_chat_feedback_status'];
            $this->db->where('feedback_status', $searchAiChatFeedbackStatus);
        }
        if(array_key_exists("feedback_id",$params)){
            $this->db->where('feedback_id',$params['feedback_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatFeedback($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('feedback_id','DESC');
		if(!empty($params['search_ai_chat_feedback'])){
            $searchAiChatFeedback = $params['search_ai_chat_feedback'];
            $likeArr = array('feedback_message' => $searchAiChatFeedback, 'feedback_language' => $searchAiChatFeedback, 'feedback_date' => $searchAiChatFeedback);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_feedback_status'])){
            $searchAiChatFeedbackStatus = $params['search_ai_chat_feedback_status'];
            $this->db->where('feedback_status', $searchAiChatFeedbackStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// Ai Chat Purchase Functions
	function viewAiChatPurchase($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('purchase_id','DESC');
		if(!empty($params['search_ai_chat_purchase'])){
            $searchAiChatPurchase = $params['search_ai_chat_purchase'];
            $likeArr = array('purchase_package' => $searchAiChatPurchase, 'purchase_order_id' => $searchAiChatPurchase, 'purchase_product_id' => $searchAiChatPurchase);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_purchase_acknowledged'])){
            $searchAiChatPurchaseAcknowledged = $params['search_ai_chat_purchase_acknowledged'];
            $this->db->where('purchase_acknowledged', $searchAiChatPurchaseAcknowledged);
        }
        if(array_key_exists("purchase_id",$params)){
            $this->db->where('purchase_id',$params['purchase_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countAiChatPurchase($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('purchase_id','DESC');
		if(!empty($params['search_ai_chat_purchase'])){
            $searchAiChatPurchase = $params['search_ai_chat_purchase'];
            $likeArr = array('purchase_package' => $searchAiChatPurchase, 'purchase_order_id' => $searchAiChatPurchase, 'purchase_product_id' => $searchAiChatPurchase);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_ai_chat_purchase_acknowledged'])){
            $searchAiChatPurchaseAcknowledged = $params['search_ai_chat_purchase_acknowledged'];
            $this->db->where('purchase_acknowledged', $searchAiChatPurchaseAcknowledged);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
	
	// ======================================================== //
    /* Privacy Policy Functions */
    // ======================================================== //
    // Privacy Policy Functions
	function viewPrivacyPolicy($params, $table){
	    $this->db->select('*');
		$this->db->from($table);
		$this->db->order_by('privacy_id','DESC');
		if(!empty($params['search_privacy_policy'])){
            $searchPrivacyPolicy = $params['search_privacy_policy'];
            $likeArr = array('app_name' => $searchPrivacyPolicy, 'app_code' => $searchPrivacyPolicy, 'app_privacy_slug' => $searchPrivacyPolicy, 'app_terms_slug' => $searchPrivacyPolicy, 'app_privacy' => $searchPrivacyPolicy, 'app_terms' => $searchPrivacyPolicy);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_privacy_policy_status'])){
            $searchPrivacyPolicyStatus = $params['search_privacy_policy_status'];
            $this->db->where('privacy_status', $searchPrivacyPolicyStatus);
        }
        if(array_key_exists("privacy_id",$params)){
            $this->db->where('privacy_id',$params['privacy_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        return $result;
    }
    
	function countPrivacyPolicy($params, $table){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('privacy_id','DESC');
        if(!empty($params['search_privacy_policy'])){
            $searchPrivacyPolicy = $params['search_privacy_policy'];
            $likeArr = array('app_name' => $searchPrivacyPolicy, 'app_code' => $searchPrivacyPolicy, 'app_privacy_slug' => $searchPrivacyPolicy, 'app_terms_slug' => $searchPrivacyPolicy, 'app_privacy' => $searchPrivacyPolicy, 'app_terms' => $searchPrivacyPolicy);
            $this->db->or_like($likeArr);
        }
        if(!empty($params['search_privacy_policy_status'])){
            $searchPrivacyPolicyStatus = $params['search_privacy_policy_status'];
            $this->db->where('privacy_status', $searchPrivacyPolicyStatus);
        }
		$result = $this->db->count_all_results();
		return $result;
	}
}
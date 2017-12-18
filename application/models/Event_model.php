<?php
/**
 * Created by PhpStorm.
 * User: Ray HONG
 * Date: 2017/12/17
 * Time: 上午3:05
 */


class Event_model extends CI_Model
{
    public $code;
    public $name;
    public $venue;
    public $closure_type;
    public $start_time;
    public $end_time;
    public $portrait = "../../images/ac2.jpg";
    public $sponsor;
    public $details;
    public $agenda;
    public $is_active = 1;
    public $is_public = 0;
    public $need_approval = 0;
    public $need_password = 0;
    public $password;
    public $can_comment = 1;
    public $allow_self_reg = 0;
    public $creator_open_id;
    public $has_lucky_draw = 0;
    public $create_time;


    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert_entry()
    {
        $this->create_time = time();

        $this->load->database();
        $this->db->insert('Event', $this);
    }


    public function get_managing_events()
    {
        $open_id = 'odun00FOoFBjr1RnrpCWRl9vX2tk';
        return $this->get_my_events(1, $open_id);
    }



    public function get_joining_events()
    {
        $open_id = 'odun00FOoFBjr1RnrpCWRl9vX2tk';
        return $this->get_my_events(2, $open_id);
    }

    public function get_my_events($role_id, $open_id)
    {
        $this->load->database();
        $this->db->select('code, name, venue, start_time, portrait');
        $this->db->from('Event');
        $this->db->join('EventUser', 'Event.id = EventUser.event_id');
        $this->db->where('EventUser.role_id', $role_id);
        $this->db->where('EventUser.user_open_id', $open_id);
        $query = $this->db->get();
        return $query->result();
    }


    public function is_admin($open_id, $id)
    {
        $this->load->database();
        $sql = "SELECT id FROM EventUser WHERE user_open_id = ? and event_id = ?";
        $query = $this->db->query($sql,array($open_id, $id));
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }


    public function exist($id)
    {
        $this->load->database();
        $sql = "SELECT id FROM Event WHERE id = ? and event_id = ?";
        $query = $this->db->query($sql,array($open_id, $id));
        if($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        $this->load->database();
        $this->db->trans_start();
        $this->db->delete('Event', array('id' => $id)); // Delete main table
        $this->db->delete('EventUser', array('event_id' => $id)); // Delete linked table
        $this->db->trans_complete();
    }

    public function get($id)
    {
        $this->load->database();
        return $this->db->get_where('Event', array('id' => $id))->result();
    }

    public function find_by_code()
    {
        //如传入$username及$password,查询主键id
        $sql = "SELECT id FROM user WHERE username = ? and passsword = ?";
        $query = $this->db->query($sql,array($username, $password));
        if($query->num_rows() > 0){ //处理查询结果前先判断数据是否在
            //****执行成功
            $id = $query->row()->id;
            //如果结果只有一行，row()返回对象，row_array()返回结果数组，按需选择
            //如果多行就用$query()->result_array()
        }
    }

}
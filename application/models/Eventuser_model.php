<?php
/**
 * Created by PhpStorm.
 * User: Ray HONG
 * Date: 2017/12/17
 * Time: 上午3:05
 */


class Eventuser_model extends CI_Model
{
    public $user_open_id;
    public $event_id;
    public $event_code;
    public $nickname;
    public $role_id = 1;
    public $enroll_status = 1;

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
    }

    public function insert_entry()
    {
        $this->db->insert('EventUser', $this);
    }



}
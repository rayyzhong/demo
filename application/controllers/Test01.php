<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test01 extends CI_Controller {

    public function index() {

        $this->load->database();//连接数据库
        $queryStr = 'insert into User (username, userinfo) values (\'Tom\', \'Tom Cat\')'; //编写SQL语句，用途是插入一条数据。
        $query = $this->db->query($queryStr);//执行SQL语句
        $response = $query;//数据库返回执行结果
        echo json_encode($response, JSON_FORCE_OBJECT);
    }

}

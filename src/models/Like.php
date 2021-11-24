<?php

namespace Marcosrivasr\Instagram\models;
use Marcosrivasr\Instagram\lib\Model;
use PDOException;

class Like extends Model{

    private string $id;
    public function __construct(private int $post_id)
    {
        parent::__construct();
    }

    public function save($user_id){
        try{
            error_log('post_id = ' . $this->post_id . '; user_id = ' . $this->user_id);
            $query = $this->prepare('INSERT INTO likes (post_id, user_id) VALUES(:post_id, :user_id)');
            $query->execute([
                'post_id'  => $this->post_id, 
                'user_id'  => $user_id
                ]);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function remove($user_id){
        try{
            
            $query = $this->db->execute('DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id');
            $query->execute([
                'post_id'  => $this->post_id, 
                'user_id'  => $user_id
                ]);
            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function setId($value){
        $this->id = $value;
    }

    public function getId(){
        return $this->id;
    }


    public function getPostId(){
        return $this->post_id;
    }
    public function getUserId(){
        return $this->user_id;
    }

}
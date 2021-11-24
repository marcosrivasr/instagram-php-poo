<?php

namespace Marcosrivasr\Instagram\models;
use Marcosrivasr\Instagram\models\Post;
use Marcosrivasr\Instagram\lib\Database;
use PDO;
use PDOException;

class PostImage extends Post{

    public function __construct(
        string $title, 
        private string $image
    )
    {
        parent::__construct($title);

        error_log( "title: " . $title);
    }

    public function publish($user_id){
        parent::publish($user_id);

        try{
            $query = $this->prepare('INSERT INTO posts (user_id, title, media) VALUES (:user_id, :title, :media)');
            $query->execute([ 'user_id' => $user_id, 'title' => $this->getTitle(), 'media' => $this->image]);

            return true;
        }catch(PDOException $e){
            return false;
        }
    }

    public function getImage(){
        return $this->image;
    }

    public static function get($id){
        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM posts WHERE post_id = :post_id');
            $query->execute([ 'post_id' => $id]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            
            $post = new PostImage($data['title'], $data['media']);
            $post->setId($data['post_id']);
            error_log($post->getTitle());
            return $post;
        }catch(PDOException $e){
            return false;
        }
    }

    public static function getAll($user_id){
        $items = [];
        error_log('getAll' . $user_id);
        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM posts WHERE user_id = :user_id');
            $query->execute(['user_id' => $user_id]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new PostImage($p['title'], $p['media']);
                $item->setId($p['post_id']);
                $item->setLikes($item->fetchLikes($item->getId(), $user_id));

                array_push($items, $item);
            }
            return $items;


        }catch(PDOException $e){
            echo $e;
        }
    }

    public static function getFeed(){
        $items = [];

        try{
            $db = new Database();
            $query = $db->connect()->query('SELECT * FROM posts ORDER BY post_id DESC');

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new PostImage($p['title'], $p['media']);
                $item->setId($p['post_id']);
                $item->setLikes($item->fetchLikes($item->getId()));
                $user = User::getById($p['user_id']);
                $item->setUser($user);

                array_push($items, $item);
            }
            return $items;


        }catch(PDOException $e){
            echo $e;
        }
    }

}
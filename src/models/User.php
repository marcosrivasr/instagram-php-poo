<?php

namespace Marcosrivasr\Instagram\models;

use Marcosrivasr\Instagram\lib\Database;
use Marcosrivasr\Instagram\lib\Model;
use PDO;
use PDOException;

class User extends Model{

    private string $id;
    private array $posts;
    private string $profile;

    public function __construct(
        private string $username,
        private string $password
    )
    {
        parent::__construct();
        $this->posts = [];
        $this->profile = '';
    }

    public static function exists($username){
        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT username FROM users WHERE username = :username');
            $query->execute( ['username' => $username]);
            
            if($query->rowCount() > 0){
                return true;
            }else{
                return false;
            }
        }catch(PDOException $e){
            echo $e;
            return false;
        }
    }

    private function getHashedPassword($password){
        return password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);
    }

    public function comparePasswords($current){
        try{
            return password_verify($current, $this->password);
        }catch(PDOException $e){
            return NULL;
        }
    }

    public function save(){
        try{
            $hash = $this->getHashedPassword($this->password);
            $query = $this->prepare('INSERT INTO users (username, password, profile) VALUES(:username, :password, :profile)');
            $query->execute([
                'username'  => $this->username, 
                'password'  => $hash,
                'profile'  => $this->profile,
                ]);
            return true;
        }catch(PDOException $e){
            error_log($e);
            return false;
        }
    } 

    public static function get($username){
        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users WHERE username = :username');
            $query->execute([ 'username' => $username]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            error_log($data['username']);
            error_log($data['password']);
            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);
            return $user;
        }catch(PDOException $e){
            return false;
        }
    }

    public static function getById($user_id){
        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM users WHERE user_id = :user_id');
            $query->execute([ 'user_id' => $user_id]);
            $data = $query->fetch(PDO::FETCH_ASSOC);
            $user = new User($data['username'], $data['password']);
            $user->setId($data['user_id']);
            $user->setProfile($data['profile']);
            return $user;
        }catch(PDOException $e){
            return false;
        }
    }

    public function getAll(){
        $items = [];

        try{
            $query = $this->query('SELECT * FROM users');

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new User($p['username'], $p['password']);
                $item->setId($p['user_id']);
                $item->setProfile($p['profile']);

                array_push($items, $item);
            }
            return $items;


        }catch(PDOException $e){
            echo $e;
        }
    }

    public function getId():string{
        return $this->id;
    }

    public function setId(string $value){
        $this->id = $value;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPosts(){
        return $this->posts;
    }

    public function setPosts($value){
        $this->posts = $value;
    }

    public function setProfile($value){
        $this->profile = $value;
    }

    public function getProfile(){
        return $this->profile;
    }

    public function publish(Post $post){
        $res = $post->publish($this->id);
        array_push($this->posts, $res);
    }

    public function fetchPosts(){
        $this->posts = PostImage::getAll($this->getId());
    }

    /* 

    public function getUsername():string{
        return $this->username;
    } */

    /*  */

   /*  public function getPosts():array{
        return $this->posts;
    }

    public function getFollowers():array{
        return $this->followers;
    }

    public function showPosts(){
        foreach($this->posts as $post){
            var_dump($post->toString());
        }
    }

    private function hasFollower(User $user){
        $found = array_filter(
            $this->followers, 
            fn (User $follower) => $follower->id === $user->id
        );

        return count($found) === 1;
    }

    public function addFollower(User $user){
        if(!$this->hasFollower($user)){
            if($this->id === $user->id){
                print_r("No te puedes agregar a ti mismo como follower \n");
            }else{
                array_push($this->followers, $user);
            }
        }else{
            print_r("El usuario $user->username ya es un follower \n");
        }
    }

    public static function showProfile(User $user){
        $profile = "Nombre: $user->username \n";
        $profile .= "Followers: " . count($user->followers) . "\n";
        $profile .= "Posts: " . count($user->posts) . "\n\n";

        return $profile;
    } */


    

}
<?php

namespace Marcosrivasr\Instagram\models;
use Marcosrivasr\Instagram\lib\Model;
use Marcosrivasr\Instagram\lib\Database;
use PDO;
use PDOException;

class Post extends Model{

    private string $id;
    private array $likes;
    private User $user;

    protected function __construct(private string $title)
    {
        parent::__construct();
        $this->likes = [];
    }

    public function getId():string{
        return $this->id;
    }

    public function setId(string $id){
        $this->id = $id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getLikes(){
        return count($this->likes);
    }

    public function publish($user_id){
        
    }
    protected function fetchLikes($post_id){
        $items = [];

        try{
            $db = new Database();
            $query = $db->connect()->prepare('SELECT * FROM likes WHERE post_id = :post_id');
            $query->execute(['post_id' => $post_id]);

            while($p = $query->fetch(PDO::FETCH_ASSOC)){
                $item = new Like($p['post_id']);
                $item->setId($p['user_id']);

                array_push($items, $item);
            }
            return $items;


        }catch(PDOException $e){
            echo $e;
        }
    }

    public function addLike(User $user){
       if($this->checkIfUserLiked($user)){
            $this->removeLike($user);
        }else{
            
            $like = new Like( intval($this->id) , intval($user->getId()) );
            $like->save($user->getId());
            array_push($this->likes, $like); 
        }
    }

    public function setLikes($value){
        $this->likes = $value;
    }

    protected function checkIfUserLiked(User $user):bool{
        $found = array_filter(
            $this->likes,
            function(Like $like) use ($user){
                return $like->getUserId() === $user->getId();
            }
        );
        return count($found) === 1;

    }

    public function removeLike(User $user){
        $found = array_filter(
            $this->likes,
            function(Like $like) use ($user){
                return $like->getUserId() === $user->getId();
            }
        );
        $found[0]->remove($user->getId());
    }

    public function setUser(User $value){
        $this->user = $value;
    }
    public function getUser(){
        return $this->user;
    }
}
<?php
namespace App\Models;
use System\Model;

class Session extends Model {
    public function __construct(
        public User $user,
        public string|null $token=null,
        public int|null $updatedAt=null,
        public bool $existsInDb=false
    ) {
        $this->token=$token??bin2hex(random_bytes(16));
        $this->updatedAt=$updatedAt??time();
    }
    public static function getByToken(string $token) {
        $st=self::dbQuery("SELECT * FROM sessions WHERE token = ?",[$token]);
        $r=$st->fetch(\PDO::FETCH_ASSOC);
        if($r) {
            $session=new self(User::getById($r["user_id"]),$r["token"],$r["updated_at"],true);
            return $session->deleteIfExpired();
        } else return false;
    }
    public function save() {
        $this->updatedAt=time();
        if($this->existsInDb) self::dbQuery("UPDATE sessions SET updated_at = ? WHERE token = ?",[$this->updatedAt,$this->token]);
        else self::dbQuery("INSERT INTO sessions VALUES(?, ?, ?)",[
            $this->token,
            $this->user->id,
            $this->updatedAt
        ]);
        $this->existsInDb=true;
    }
    public function delete() {
        self::dbQuery("DELETE FROM sessions WHERE token = ?",[$this->token]);
        $this->existsInDb=false;
    }
    public function deleteIfExpired() {
        $week=60*60*24*7;
        $updatedAt=$this->updatedAt;
        $time=time();
        if($time-$updatedAt>$week) {
            $this->delete();
            return false;
        } else return $this;
    }
    public static function getByUser(User $user) {
        $st=self::dbQuery("SELECT * FROM sessions WHERE user_id = ?",[$user->id]);
        $ss=[];
        while($r=$st->fetch(\PDO::FETCH_ASSOC)) {
            $session=new self(User::getById($r["user_id"]),$r["token"],$r["updated_at"],true);
            $ss[]=$session->deleteIfExpired();
        }
        return $ss;
    }
}
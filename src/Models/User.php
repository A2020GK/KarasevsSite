<?php
namespace App\Models;
use System\Model;

class User extends Model {
    public array $roles;
    public function __construct(
        public int|null $id,
        public string $username,
        public string $password,
        public int $birthday,
        public string $name,
        string $roles="user"
    ){
        $this->roles=explode(",",$roles);
    }
    public static function getById(int $id):self|false {
        return self::unpackFromStatement(self::dbQuery("SELECT * FROM users WHERE id = ?",[$id]));
    }
    public static function getByUsername(string $username):self|false {
        return self::unpackFromStatement(self::dbQuery("SELECT * FROM users WHERE username = ?",[$username]));
    }
    protected static function unpackFromStatement(\PDOStatement $st) {
        $data=$st->fetch(\PDO::FETCH_ASSOC);
        if($data) return new self(...$data); else return false;
    }
    public function save() {
        $st=null;
        if($this->id) {
            $st=self::dbQuery("UPDATE users SET password = ?, birthday = ?, name = ? WHERE id = ?",[
                $this->password,
                $this->birthday,
                $this->name,
                $this->id
            ]);
        } else {
            $st=self::dbQuery("INSERT INTO users VALUES(NULL, ?, ?, ?, ?) RETURNING id",[
                $this->username,
                $this->password,
                $this->birthday,
                $this->name
            ]);
            $r=$st->fetch(\PDO::FETCH_NUM);
            $this->id=$r[0];
        }
        return $st->rowCount()>0;
    }
    public function hasRole(string $role):bool {
        return in_array($role,$this->roles);
    }
}
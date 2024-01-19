<?php
// スーパークラスであるDbDataを利用するため
require_once __DIR__ . '/dbdata.php';
require_once __DIR__ . '/../logger/debug.php';
require_once __DIR__ . '/../uuid/uuid.php';

class User extends DbData
{
    // ログイン認証処理
    public function authUser($userEmail, $password): ?array
    {
        $sql = "select userId, userName, password from users where userEmail = ?";   // SQL文を定義
        $stmt = $this->query($sql, [$userEmail]); // DbDataクラスのquery()メソッドを呼び出す
        $result = $stmt->fetch();   // fetch()メソッドでデータを取り出す

        if (!$result) {
            return [null, null];
        }

        if (password_verify($password, $result['password'])) {
            return [$result['userId'], $result['userName']];
        } else {
            return [null, null];
        }
    }

    // ユーザー登録処理
    public function signUp($userName, $userEmail, $password): string
    {
        try {
            $sql = "select userEmail from users where userEmail = ?"; // userEmailを条件とするSELECT文の定義
            $stmt = $this->query($sql, [$userEmail]);  // dbdata.phpのquery()メソッドの実行
            $result = $stmt->fetch();  // 抽出したデータを取り出す
            // 登録しようとしているEメールが既に登録されている場合
            if ($result) {
                $_SESSION['signup_error'] = 'この' . $userEmail . 'は既に登録されています。';  // エラーメッセージをセットし
                header('Location: ./signup.php');  // signup.phpへ遷移する
                exit();
            }
            // uniqidを作成
            $userId = (new UUID)->createUUid();
            // パスワードハッシュ化
            $password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "insert into users(userId, userName, userEmail, password) values(?, ?, ?, ?)";
            $result = $this->exec($sql, [$userId, $userName, $userEmail, $password]);

            return $userId;
        } catch (\Throwable $e) {
            debug::logging($password);
            debug::logging($e);
            return '';
        }
    }

    // メールアドレスを取得
    public function getEmail($userId)
    {
        $sql = "select userEmail from users where userId = ?";
        $stmt = $this->query($sql, [$userId]);  // dbdata.phpのquery()メソッドの実行
        $result = $stmt->fetch();  // 抽出したデータを取り出す
        return $result['userEmail'];
    }

    // ユーザー情報更新処理
    public function updateEmail($userId, $userEmail)
    {
        $sql = "update users set userEmail = ? where userId = ?";
        $result = $this->exec($sql, [$userEmail, $userId]);
        if ($result === false) {
            return 'メールアドレスの更新に失敗しました。';
        }
        return "";
    }

    // ユーザー情報更新処理
    public function updateName($userId, $userName)
    {
        $sql = "update users set userName = ? where userId = ?";
        $result = $this->exec($sql, [$userName, $userId]);
        if ($result === false) {
            return 'メールアドレスの更新に失敗しました。';
        }
        return "";
    }

    // nonceの追加
    public function updateNonce($nonce, $userId)
    {
        $sql = "update users set nonce = ? where userId = ?";
        $this->exec($sql, [$nonce, $userId]);
    }

    // LINEuserIdの追加
    public function updateLINEuserId($LINEuserId, $nonce)
    {
        $sql = "update users set LINEuserId = ? where nonce = ?";
        $this->exec($sql, [$LINEuserId, $nonce]);
    }

    // LINEとの連携を解除
    public function deleteLINEuserId($LINEuserId)
    {
        $sql = "select LINEuserId from users where LINEuserId = ?";
        $stmt = $this->query($sql, [$LINEuserId]);
        $result = $stmt->fetch();

        if (is_null($result)) {
            return 'LINEuserIdは設定されていません';
        } else {
            $sql = "update users set LINEuserId = NULL where LINEuserId = ?";
            $this->exec($sql, [$LINEuserId]);
        }
    }
}

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
        $sql = "select userID, userName, password from users where userEmail = ?";   // SQL文を定義
        $stmt = $this->query($sql, [$userEmail]); // DbDataクラスのquery()メソッドを呼び出す
        $result = $stmt->fetch();   // fetch()メソッドでデータを取り出す

        if (!$result) {
            return [null, null];
        }

        if (password_verify($password, $result['password'])) {
            return [$result['userID'], $result['userName']];
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
            $userID = (new UUID)->createUUid();
            // パスワードハッシュ化
            $password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "insert into users(userID, userName, userEmail, password) values(?, ?, ?, ?)";
            $result = $this->exec($sql, [$userID, $userName, $userEmail, $password]);

            return $userID;
        } catch (\Throwable $e) {
            debug::logging($password);
            debug::logging($e);
            return '';
        }
    }

    // メールアドレスを取得
    public function getEmail($userID)
    {
        $sql = "select userEmail from users where userID = ?";
        $stmt = $this->query($sql, [$userID]);  // dbdata.phpのquery()メソッドの実行
        $result = $stmt->fetch();  // 抽出したデータを取り出す
        return $result['userEmail'];
    }

    // ユーザー情報更新処理
    public function updateEmail($userID, $userEmail)
    {
        $sql = "update users set userEmail = ? where userID = ?";
        $result = $this->exec($sql, [$userEmail, $userID]);
        if ($result === false) {
            return 'メールアドレスの更新に失敗しました。';
        }
        return "";
    }

    // ユーザー情報更新処理
    public function updateName($userID, $userName)
    {
        $sql = "update users set userName = ? where userID = ?";
        $result = $this->exec($sql, [$userName, $userID]);
        if ($result === false) {
            return 'メールアドレスの更新に失敗しました。';
        }
        return "";
    }

    // nonceの追加
    public function updateNonce($nonce, $userID)
    {
        $sql = "update users set nonce = ? where userID = ?";
        $this->exec($sql, [$nonce, $userID]);
    }

    // LINEuserIDの追加
    public function updateLINEuserID($LINEuserID, $nonce)
    {
        $sql = "update users set LINEuserID = ? where nonce = ?";
        $this->exec($sql, [$LINEuserID, $nonce]);
    }

    // LINEとの連携を解除
    public function deleteLINEuserID($LINEuserID)
    {
        $sql = "select LINEuserID from users where LINEuserID = ?";
        $stmt = $this->query($sql, [$LINEuserID]);
        $result = $stmt->fetch();

        if (is_null($result)) {
            return 'LINEuserIDは設定されていません';
        } else {
            $sql = "update users set LINEuserID = NULL where LINEuserID = ?";
            $this->exec($sql, [$LINEuserID]);
        }
    }
}

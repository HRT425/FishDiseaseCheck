<p align="center">
<img src="https://github.com/HRT425/FishDiseaseCheck/assets/107521705/66ae48a8-52c6-44e2-a355-284ceb3f8eed" width=50%> 
</p>

# 魚の健康を判定するWebアプリ

使用技術一覧
---
フロントエンド  
<img src="https://img.shields.io/badge/-Html5-E34F26.svg?logo=html5&style=plastic">
<img src="https://img.shields.io/badge/-Css3-1572B6.svg?logo=css3&style=plastic">
<img src="https://img.shields.io/badge/-Javascript-000.svg?logo=javascript&style=plastic">

バックエンド  
<img src="https://img.shields.io/badge/-PHP-6777B4.svg?logo=php&style=plastic">  <img src="https://img.shields.io/badge/-Python-3755AB.svg?logo=python&style=plastic">
<img src="https://img.shields.io/badge/-Mysql-445691.svg?logo=mysql&style=plastic">

開発環境  
<img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=plastic">

## 目次

1. [ウオッチングについて](#ウオッチングについて)
2. [環境](#環境)
3. [ディレクトリ構成](#ディレクトリ構成)
4. [開発環境構築](#開発環境構築)
5. [トラブルシューティング](#トラブルシューティング)



<!-- プロジェクトについて -->

## ウオッチングについて

観賞魚のへい死を未然に防ぐために作成された、
魚の健康管理Webアプリです。  
yolov8を用いて、魚種分類➞魚病分類を行います。

<p align="right">(<a href="#top">トップへ</a>)</p>

## 環境

<!-- 言語、フレームワーク、ミドルウェア、インフラの一覧とバージョンを記載 -->

| 言語・フレームワーク  | バージョン |
| --------------------- | ---------- |
| Python                | 3.11.7     |
| Flask                 | 3.0.1      |
| flask-restful         | 0.3.10     |
| Pillow                | 10.2.0     |
| ultralytics           | 8.1.6      |
| MySQL                 | 8.0        |
| PHP                   | 8.3.1      |

<p align="right">(<a href="#top">トップへ</a>)</p>

## ディレクトリ構成
```
.
├── app
│   ├── AI (病気チェックを行うAPI)
│   │   ├── model (学習済みモデル)
│   │       ├── disease.pt (病種分類yolo)
│   │       └── fish.pt (魚種分類yolo)
│   │   ├── api.py (webアプリから呼び出される部分)
│   │   ├── yolo.py (学習済みモデルを用いて、推論を行う)
│   ├── web (webアプリのメイン)
│   │   ├── config
│   │   |    ├── .env (環境変数) ※ 各自で作成
│   │   |    └── config.php (環境変数の取り出しを行う)
│   │   ├── css
│   │   |    ├── front-page.css (トップページのcss)
│   │   |    ├── home.css (ホーム画面のcss)
│   │   |    └── login.css (ログイン画面のcss)
│   │   ├── database
│   │   |    ├── conditon.php (アップロードした写真の判定結果を保存する機能)
│   │   |    ├── dbdata.php (データベースへのアクセスに関する機能)
│   │   |    └── user.php (ユーザ情報の登録・取得に関する機能)
│   │   ├── image
│   │   |    ├── uploadPicture (アップロードした写真の保存場所)
│   │   |    └── 以下、htmlで使う写真
│   │   ├── js
│   │   |    └── camera.js (カメラ機能)
│   │   ├── logger
│   │   |    ├── debug.log (情報を追記する) ※ 各自で作成
│   │   |    └── debug.php (debug.logに情報を追加する)
│   │   ├── upload
│   │   |    ├── upload.php (受け取った写真をAPIに送り結果を返す)
│   │   |    └── uploadController.php (データベース処理やAPIへのアクセスを行う)
│   │   ├── user
│   │   |    ├── login_db.php (ログイン処理を行う)
│   │   |    ├── login.php (ユーザーがログインを行う画面を表示)
│   │   |    ├── session.php (ログインされているかの確認)
│   │   |    ├── signup_db.php (サインアップ処理を行う)
│   │   |    └── signup.php (ユーザーがサインアップを行う画面を表示)
│   │   ├── uuid
│   │   |    └── uuid.php (一意のデータを作成する)
│   │   ├── front-page.php (トップページ)
│   │   ├── home-camera.php (カメラ画面)
│   │   ├── home.php (ログイン後のホーム画面)
│   │   └── pre_sub.php (遷移管理)
│   └── index.php (初めにリダイレクトされるファイル)
├── docker
│   ├── mysql
│   │   └── initdb.d
│   │        └── init.sql (データベース作成時に実行されるSQL)
│   ├── php
│   │   └── dockerfile (phpのimageを作成する)
│   ├── python
│   │   ├── dockerfile (pythonのimageを作成する)
│   │   └── requirements.txt (pythonのライブラリを設定)
│   └── SchemaSpy (データベースの可視化)
│   │   ├── config 
│   │   |    └── schemaspy.properties (SchemaSpyの設定) ※ 各自で作成
│   │   └── dockerfile (SchemaSpyのimageを作成)
├── .env (docker-compose.ymlで使用する設定) ※ 各自で作成
├── .gitignore (github上に挙げたくないファイルを設定)
├── docker-compose.yml (dockerのコンテナを作成する)
└── README.md
```

<p align="right">(<a href="#top">トップへ</a>)</p>

## 開発環境構築

<!-- コンテナの作成方法、パッケージのインストール方法など、開発環境構築に必要な情報を記載 -->

### コンテナの作成と起動

.env ファイルを以下の環境変数例と[環境変数の一覧](#環境変数の一覧)を元に作成

.env  
```
MYSQL_ROOT_PASSWORD=root
MYSQL_USER=test
MYSQL_PASSWORD=test
MYSQL_DATABASE=aqua
PMA_HOSTS=mysql  
PMA_USER=test  
PMA_PASSWORD=test
```

web/config/.env  
```
dbname=aqua  
host=mysql  
username=test  
password=test
```
docker/SchemaSpy/config/schemaspy.properties  
```
schemaspy.t=mysql
schemaspy.dp=drivers/mysql-connector-java-8.0.30.jar
schemaspy.host=mysql
schemaspy.port=3306
schemaspy.db=aqua
schemaspy.u=test
schemaspy.p=test
schemaspy.o=/../database-configuration
schemaspy.s=aqua
```

.env ファイルを作成後、以下のコマンドで開発環境を構築

docker-compose up -d

### 動作確認

http://localhost:8000/ にアクセスできるか確認
アクセスできたら成功

### コンテナの停止

以下のコマンドでコンテナを停止することができます

docker-compose down

### 環境変数の一覧

| 変数名                 | 役割                                      | デフォルト値                       | DEV 環境での値                           |
| ---------------------- | ----------------------------------------- | ---------------------------------- | ---------------------------------------- |
| MYSQL_ROOT_PASSWORD    | MySQL のルートパスワード（Docker で使用） | root                               |    指定なし                                     |
| MYSQL_DATABASE         | MySQL のデータベース名（Docker で使用）   | aqua                          |     指定なし                                     |
| MYSQL_USER             | MySQL のユーザ名（Docker で使用）         | test                             |    指定なし                                      |
| MYSQL_PASSWORD         | MySQL のパスワード（Docker で使用）       | test                             |     指定なし                                     |
| PMA_HOSTS             | phpMyadmin のホスト名（Docker で使用）         | mysql                                 |   指定なし                                       |
| PMA_USER             | phpMyadmin のユーザ名（Docker で使用）       | test                               |    指定なし                                      |
| PMA_PASSWORD             | phpMyadminのパスワード (Docker で使用)                 | test                          | 指定なし |
| dbname          | MySQLのデータベース名(アプリ内の環境変数で使用)              | aqua | 指定なし                       |
| host                  | MySQLのホスト名(アプリ内の環境変数で使用)                  | mysql                               | 指定なし                                    |
| username        | MySQLのユーザ名(アプリ内の環境変数で使用)                  | test                   |         指定なし                                  |
| password | MySQLのパスワード(アプリ内の環境変数で使用)   | test             | 指定なし                     |

### コマンド一覧

| Make                | 実行する処理                                                            |                                                                               
 ------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------- 
| docker-compose up -d            | コンテナの起動                                                                     |
| docker-compose build          | イメージのビルド                                                        | 
| docker-compose down           | コンテナの停止                                                          | 


## トラブルシューティング

### .env: no such file or directory

.env ファイルがないので環境変数の一覧を参考に作成しましょう

### docker daemon is not running

Docker Desktop が起動できていないので起動させましょう

### Ports are not available: address already in use

別のコンテナもしくはローカル上ですでに使っているポートがある可能性があります
<br>
下記記事を参考にしてください
<br>
[コンテナ起動時に Ports are not available: address already in use が出た時の対処法について](https://qiita.com/shun198/items/ab6eca4bbe4d065abb8f)

### Module not found

make build

を実行して Docker image を更新してください

<p align="right">(<a href="#top">トップへ</a>)</p>
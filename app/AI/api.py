# 画像をアップロードされたら推論するAIを呼び出す用のAPI
from flask import Flask, Response
from flask_restful import Resource, Api
from anomalie_detection import fine_tuned 
import json

# Flaskを初期化
app = Flask(__name__)
# 日本語の文字化け防止
# app.config["JSON_AS_ASCII"] = False

# RestFulを初期化
api = Api(app)

# AIモデルを構築
ft = fine_tuned()

# 呼び出し時に実行するclass
class Inference(Resource):

    def get(self, filename):
        """
        推論を行う関数を呼び出し、結果をJSON形式で返す。
        """

        # 判定
        class_names = {0: '病気の可能性あり', 1: '健康体'}

        # 入力画像のパス
        image_path = '/app/image/' + filename
        
        # 推論結果を取得する
        result = ft.inference(image_path)

        # 結果を辞書に変更
        response_data = {
            "result": class_names[result], 
            }
        
        # 辞書をJSON形式に変更
        response_json = json.dumps(response_data, ensure_ascii=False)

        # 日本語の文字化けを防ぐために、utf-8を設定
        return Response(response_json, content_type="application/json; charset=utf-8")

# APIにclassとrouteを設定
api.add_resource(Inference, '/inference/<string:filename>')

if __name__ == '__main__':
    # APIを起動する
    app.run(host='0.0.0.0', port=80, debug=True)


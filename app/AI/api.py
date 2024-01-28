# 画像をアップロードされたら推論するAIを呼び出す用のAPI
from flask import Flask, Response
from flask_restful import Resource, Api
import yolo 
import json

# Flaskを初期化
app = Flask(__name__)
# 日本語の文字化け防止
# app.config["JSON_AS_ASCII"] = False

# RestFulを初期化
api = Api(app)

# 呼び出し時に実行するclass
class Inference(Resource):

    def get(self, image_path):
        """
        推論を行う関数を呼び出し、結果をJSON形式で返す。
        """
        # 魚が撮影出来ているか
        fish_photographed_flag = 0
        # 推論結果を取得する
        YoloExecute = yolo.YoloExecute(image_path)
        flag = YoloExecute.fish_yolo_execute()
        if flag:
            YoloExecute.resizeImage()
            fish_disease_flg, result_credibility = YoloExecute.disease_yolo_execute()
        else:
            fish_disease_flg = 0
            result_credibility = 0
            fish_photographed_flag = 1

        # 結果を辞書に変更
        response_data = {
            "result": fish_disease_flg,
            "credibility": result_credibility,
            "fish_photographed_flag": fish_photographed_flag
            }
        
        # 辞書をJSON形式に変更
        response_json = json.dumps(response_data, ensure_ascii=False)

        # 日本語の文字化けを防ぐために、utf-8を設定
        return Response(response_json, content_type="application/json; charset=utf-8")

# APIにclassとrouteを設定
api.add_resource(Inference, '/inference/<string:image_path>')

if __name__ == '__main__':
    # APIを起動する
    app.run(host='0.0.0.0', port=80, debug=True)


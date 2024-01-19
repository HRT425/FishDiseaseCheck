import torch
from torchvision.transforms import transforms
from PIL import Image
from torchvision.models import vgg19_bn
import torch.nn as nn

import time

# モデルの定義
class VGG(nn.Module):

    def __init__(self, in_features, out_features):
        """
        モデルの初期化を行う
        """
        super(VGG, self).__init__()

        # vgg19モデルを呼び出す
        self.features = vgg19_bn(weights=None).features

        # 分類気を変更する
        self.classifier = nn.Sequential(
            nn.Linear(in_features, 4096),
            nn.ReLU(inplace=True),
            nn.Dropout(p=0.5, inplace=False),
            nn.Linear(4096, 4096),
            nn.ReLU(inplace=True),
            nn.Dropout(p=0.5, inplace=False),
            nn.Linear(4096, out_features),  # クラス数に合わせて変更
        )

    def forward(self, x):
        x = self.features(x)
        x = x.view(x.size(0), -1)
        x = self.classifier(x)
        return x


# 
class fine_tuned():
    
    def __init__(self):

        """
        ファインチューニングしたモデルをロードする
        """

        # デバイス設定
        self.device = torch.device("cuda:0" if torch.cuda.is_available() else "cpu")

        # ファインチューニング後のモデルのロード
        self.in_features = 25088
        self.out_features = 2  # クラス数に合わせて変更
        # vgg19をロード
        self.fine_tuned_model = VGG(self.in_features, self.out_features)
        # ファインチューニングした結果をロード
        self.fine_tuned_model.load_state_dict(torch.load('/app/AI/fine_tuned_model.pth', map_location=torch.device('cpu')))
        # デバイスを設定
        self.fine_tuned_model = self.fine_tuned_model.to(self.device)
        # 推論モード
        self.fine_tuned_model.eval()


    def inference(self, image_path):
        """
        推論を行う関数
        """

        # 画像の前処理設定
        transform = transforms.Compose([
            transforms.Resize(224),
            transforms.CenterCrop(224),
            transforms.ToTensor(),
            transforms.Normalize(0.5, 0.5)
        ])

        # 画像の読み込み
        image = Image.open(image_path).convert('RGB')
        # 前処理
        input_image = transform(image).unsqueeze(0).to(self.device)

        # モデルの設定
        model = self.fine_tuned_model
        # 画像を入力し、推論
        output = model(input_image)
        # 結果を取得
        _, predicted_class = torch.max(output, 1)

        # 結果の値だけを取り出す(0または1)
        result = predicted_class.item()

        return result


if __name__ == '__main__':

    # 入力画像のパス
    image_path = '/app/image/' + '1700566619_655c965bd05aa.jpg'

    start = time.time()

    ft = fine_tuned()
    
    result = ft.inference(image_path)

    end = time.time()

    print('実行時間：', end-start)

    print(result)
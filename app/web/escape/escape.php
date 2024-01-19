<?php
// エスケープ処理用の関数を定義
function h($data)
{
  return htmlspecialchars($data, ENT_QUOTES, "UTF-8");
}

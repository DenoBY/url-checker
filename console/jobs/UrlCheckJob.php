<?php

namespace console\jobs;

use common\models\Url;
use common\models\UrlCheck;
use Yii;
use yii\base\BaseObject;
use yii\db\Exception;
use yii\queue\JobInterface;
use yii\queue\Queue;

class UrlCheckJob extends BaseObject implements JobInterface
{
    public int $urlId;

    private const HTTP_OK = 200;

    public function execute($queue): void
    {
        $url = Url::findOne($this->urlId);

        if (empty($url)) {
            return;
        }

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $responseCode = $this->checkUrl($url->url);

            $urlCheck = new UrlCheck();
            $urlCheck->url_id = $url->id;
            $urlCheck->status_code = $responseCode;
            $urlCheck->save();

            $this->handleUrlCheckResult($queue, $url, $urlCheck);

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            Yii::error("Failed to check URL: {$e->getMessage()}", __METHOD__);
        }
    }

    private function checkUrl(string $url): int
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);

            Yii::error("cURL ({$this->urlId}) Error: {$error}", __METHOD__);

            return -1;
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpCode;
    }

    private function handleUrlCheckResult(Queue $queue, Url $url, UrlCheck $urlCheck): void
    {
        if ($urlCheck->status_code !== self::HTTP_OK ) {
            $url->retry_count -= 1;
            $url->save();

            if ($url->retry_count > 0) {
                $queue->delay($url->retry_delay * 60)->push(new self([
                    'urlId' => $url->id,
                ]));

                return;
            }

            return;
        }


        $queue->delay($url->check_interval * 60)->push(new self([
            'urlId' => $this->urlId,
        ]));
    }
}
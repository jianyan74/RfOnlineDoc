<?php

namespace addons\RfOnlineDoc\services\doc;

use common\components\Service;
use addons\RfOnlineDoc\common\models\Template;
use common\enums\StatusEnum;

/**
 * Class TemplateService
 * @package addons\RfOnlineDoc\services\doc
 * @author jianyan74 <751393839@qq.com>
 */
class TemplateService extends Service
{
    /**
     * @param $type
     * @return array|\yii\db\ActiveRecord[]
     */
    public function findByType($type)
    {
        return Template::find()
            ->where(['status' => StatusEnum::ENABLED])
            ->where(['type' => $type])
            ->andFilterWhere(['merchant_id' => $this->getMerchantId()])
            ->orderBy('sort asc, id desc')
            ->asArray()
            ->all();
    }
}
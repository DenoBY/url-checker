<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionCreateAdmin(): void
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');

        if ($role === null) {
            $role = $auth->createRole('admin');
            $auth->add($role);
            echo "Role 'admin' created.\n";
        }

        $user = new User();
        $user->username = 'admin';
        $user->email = 'admin@example.com';
        $user->password_hash = Yii::$app->security->generatePasswordHash('admin');
        $user->auth_key = Yii::$app->security->generateRandomString();
        $user->status = User::STATUS_ACTIVE;
        $user->created_at = time();
        $user->updated_at = time();

        if ($user->save()) {
            echo "User 'admin' created with ID: {$user->id}\n";

            $auth->assign($role, $user->id);
            echo "Admin role assigned to user ID {$user->id}.\n";

            return;
        }

        echo "Failed to create user.\n";
    }
}
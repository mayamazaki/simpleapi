<?php
namespace App\Controller\Student;

use App\Controller\Student\AppController;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LicensesController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * (Api) ライセンス登録（ユーザー情報に、ID紐づけして登録）【⑤必要】
     *
     */
    public function save()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        // response
        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $usersTable = $this->getTableLocator()->get('Users');
        $userResult = $usersTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($userResult)) {
            $response['status'] = 401;
        } else if (!empty($userResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $userResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        // request
        $userId = $this->request->getData('user_id');
        $licenseId = $this->request->getData('license_id');

        // table
        $usersTable = $this->getTableLocator()->get('Users');
        $licensePartnersTable = $this->getTableLocator()->get('LicensePartners');

        if (empty($userId) || empty($licenseId)) {
            // Invalid user supplied
            $response['status'] = 400;
        } else if (!($usersTable->exists(['id' => $userId])
        && $this->Licenses->exists(['id' => $licenseId]))) {
            // User not found
            $response['status'] = 404;
        } else {
            $license = $this->Licenses->find()
                ->where(['id' => $licenseId])
                ->first();
            $data = [];
            $data['license_id'] = $license->id;
            $data['disp_no'] = $license->disp_no;
            $data['is_valid'] = $license->is_valid;
            $data['license_code'] = $license->license_code;
            $data['exp_s_dt'] = $license->exp_s_dt->format('Y-m-d');
            $data['exp_f_dt'] = $license->exp_f_dt->format('Y-m-d');
            $data['auth_datetime'] = $license->auth_datetime->format('Y-m-d H:i:s');
            $data['user_id'] = $userId;
            $licensePartner = $licensePartnersTable->newEntity();
            $licensePartner = $licensePartnersTable->patchEntity($licensePartner, $data);
            if ($licensePartnersTable->save($licensePartner)) {
                // success
                $response['status'] = 200;
            } else {
                // fail
                $response['status'] = 500;
            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) ライセンス追加（ユーザー情報に、ID紐づけして登録）【⑥必要】
     *
     */
    public function add()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        // response
        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $usersTable = $this->getTableLocator()->get('Users');
        $userResult = $usersTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($userResult)) {
            $response['status'] = 401;
        } else if (!empty($userResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $userResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        // request
        $userId = $this->request->getData('user_id');
        $licenseId = $this->request->getData('license_id');

        // table
        $usersTable = $this->getTableLocator()->get('Users');
        $licensePartnersTable = $this->getTableLocator()->get('LicensePartners');

        if (empty($userId) || empty($licenseId)) {
            // Invalid user supplied
            $response['status'] = 400;
        } else if (!($usersTable->exists(['id' => $userId])
        && $this->Licenses->exists(['id' => $licenseId]))) {
            // User not found
            $response['status'] = 404;
        } else {
            $license = $this->Licenses->find()
                ->where(['id' => $licenseId])
                ->first();
            $data = [];
            $data['license_id'] = $license->id;
            $data['disp_no'] = $license->disp_no;
            $data['is_valid'] = $license->is_valid;
            $data['license_code'] = $license->license_code;
            $data['exp_s_dt'] = $license->exp_s_dt->format('Y-m-d');
            $data['exp_f_dt'] = $license->exp_f_dt->format('Y-m-d');
            $data['auth_datetime'] = $license->auth_datetime->format('Y-m-d H:i:s');
            $data['user_id'] = $userId;
            $licensePartner = $licensePartnersTable->newEntity();
            $licensePartner = $licensePartnersTable->patchEntity($licensePartner, $data);
            if ($licensePartnersTable->save($licensePartner)) {
                // success
                $response['status'] = 200;
            } else {
                // fail
                $response['status'] = 500;
            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

}

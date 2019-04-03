<?php
namespace App\Controller\CramSchool;

use App\Controller\CramSchool\AppController;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * (Api) ログイン
     *
     */
    public function login()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        $response = [];

        $loginId = $this->request->getData('login_id');
        $password = $this->request->getData('password');
        if (empty($loginId) || empty($password)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['login_id' => $loginId])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        $hasher = new DefaultPasswordHasher();
        $passwordEqual = $hasher->check($password, $cramSchoolResult->password);
        if (!$passwordEqual) {
            // パスワードが一致しない
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        // token 生成
        $token = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 36);

        $cramSchool = $cramSchoolsTable->get($cramSchoolResult->id, ['contain' => []]);
        $data = [];
        $data['id'] = $cramSchoolResult->id;
        $data['token'] = $token;
        $data['last_login_api_datetime'] = date('Y-m-d H:i:s');
        $cramSchool = $cramSchoolsTable->patchEntity($cramSchool, $data);
        if ($cramSchoolsTable->save($cramSchool)) {
            $response['status'] = 200;
            $response['token'] = $token;
        } else {
            $response['status'] = 500;
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) ログアウト
     *
     */
    public function logout()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        $response = [];

        $loginId = $this->request->getData('login_id');

        if (empty($loginId)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['login_id' => $loginId])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        // token 生成
        $cramSchool = $cramSchoolsTable->get($cramSchoolResult->id, ['contain' => []]);
        $data = [];
        $data['token'] = null;
        $data['last_login_api_datetime'] = null;
        $cramSchool = $cramSchoolsTable->patchEntity($cramSchool, $data);
        if ($cramSchoolsTable->save($cramSchool)) {
            $response['status'] = 200;
        } else {
            $response['status'] = 500;
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) クラスと生徒の紐づけ
     *
     */
    public function updateStudentBelongToClass()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $classId = $this->request->getData('class_id');

        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        if (!($this->Users->exists(['id' => $userId])
        && $cramSchoolClassesTable->exists(['id' => $classId]))) {
            $response['status'] = 404;
        } else {

            $studentsTable = $this->getTableLocator()->get('Students');
            $studentResult = $studentsTable->find()
                ->where(['user_id' => $userId])
                ->first();

            $data = [];
            $data['user_id'] = $userId;
            $data['cram_school_class_id'] = $classId;
            if (!empty($studentResult)) {
                // update
                $data['id'] = $studentResult->id;
                $student = $studentsTable->get($studentResult->id, [
                    'contain' => []
                ]);
                $student = $studentsTable->patchEntity($student, $data);

            } else {
                // insert
                $student = $studentsTable->newEntity();
                $student = $studentsTable->patchEntity($student, $data);

            }
            if ($studentsTable->save($student)) {
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
     * (Api) ユーザー情報の登録
     *
     */
    public function insert()
    {
        // post
        $this->request->allowMethod(['post']);

        $this->autoRender = false;
        $this->viewBuilder()->enableAutoLayout(false);

        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $request = $this->request->getData();
        unset($request['token']);

        $user = $this->Users->newEntity();
        $user = $this->Users->patchEntity($user, $request);

        if ($this->Users->save($user)) {
            // success
            $response['status'] = 200;
            $response['user_id'] = $user->id;
        } else {
            // fail
            $response['status'] = 500;
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) ユーザー情報の更新
     *
     */
    public function update($id = null)
    {
        // post
        $this->request->allowMethod(['put']);

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
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        if (empty($id)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else {

            if (!$this->Users->exists(['id' => $id])) {
                // User not found
                $response['status'] = 404;

            } else {

                // request
                $request = $this->request->getData();
                unset($request['token']);

                $user = $this->Users->get($id, [
                    'contain' => []
                ]);
                $user = $this->Users->patchEntity($user, $request);
                if ($this->Users->save($user)) {
                    $response['status'] = 200;
                } else {
                    $response['status'] = 500;
                }

            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) ユーザー情報の削除
     *
     */
    public function delete($id = null)
    {
        // put
        $this->request->allowMethod(['delete']);

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
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        if (empty($id)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else {

            if (!$this->Users->exists(['id' => $id])) {
                // User not found
                $response['status'] = 404;

            } else {

                $user = $this->Users->get($id, [
                    'contain' => []
                ]);

                $data = [];
                $data['id'] = $id;
                $data['is_valid'] = 0; // 0.無効
                $user = $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {
                    $response['status'] = 200;
                } else {
                    $response['status'] = 500;
                }

            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) 生徒のパスワードリセット
     *
     */
    public function passwordReset($id = null)
    {
        // post
        $this->request->allowMethod(['put']);

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
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        if (empty($id)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else {

            if (!$this->Users->exists(['id' => $id])) {
                // User not found
                $response['status'] = 404;

            } else {

                $user = $this->Users->get($id, [
                    'contain' => []
                ]);

                $data = [];
                $data['password'] = "00000000"; // 初期化
                $user = $this->Users->patchEntity($user, $data);
                if ($this->Users->save($user)) {
                    $response['status'] = 200;
                } else {
                    $response['status'] = 500;
                }

            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

    /**
     * (Api) 生徒のパスワードセット
     *
     */
    public function passwordUpdate($id = null)
    {
        // post
        $this->request->allowMethod(['put']);

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
        $cramSchoolsTable = $this->getTableLocator()->get('CramSchools');
        $cramSchoolResult = $cramSchoolsTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        if (empty($id)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else {

            if (!$this->Users->exists(['id' => $id])) {
                // User not found
                $response['status'] = 404;

            } else {

                $user = $this->Users->get($id, [
                    'contain' => []
                ]);

                $oldPassword = $this->request->getData('old_password');

                $hasher = new DefaultPasswordHasher();
                $passwordEqual = $hasher->check($oldPassword, $user->password);
                if (!$passwordEqual) {
                    // パスワードが一致しない
                    $response['status'] = 401;

                } else {

                    $data = [];
                    $data['password'] = $this->request->getData('new_password');
                    $user = $this->Users->patchEntity($user, $data);
                    if ($this->Users->save($user)) {
                        $response['status'] = 200;
                    } else {
                        $response['status'] = 500;
                    }

                }

            }
        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

}

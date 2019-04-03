<?php
namespace App\Controller\CramSchoolClass;

use App\Controller\CramSchoolClass\AppController;
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

        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['login_id' => $loginId])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        $hasher = new DefaultPasswordHasher();
        $passwordEqual = $hasher->check($password, $cramSchoolClassResult->password);
        if (!$passwordEqual) {
            // パスワードが一致しない
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        // token 生成
        $token = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 36);

        $cramSchoolClass = $cramSchoolClassesTable->get($cramSchoolClassResult->id, ['contain' => []]);
        $data = [];
        $data['token'] = $token;
        $data['last_login_api_datetime'] = date('Y-m-d H:i:s');
        $cramSchoolClass = $cramSchoolClassesTable->patchEntity($cramSchoolClass, $data);
        if ($cramSchoolClassesTable->save($cramSchoolClass)) {
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

        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['login_id' => $loginId])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }

        // token 生成
        $cramSchoolClass = $cramSchoolClassesTable->get($cramSchoolClassResult->id, ['contain' => []]);
        $data = [];
        $data['token'] = null;
        $data['last_login_api_datetime'] = null;
        $cramSchoolClass = $cramSchoolClassesTable->patchEntity($cramSchoolClass, $data);
        if ($cramSchoolClassesTable->save($cramSchoolClass)) {
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

        // response
        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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

        // response
        $response = [];

        // token check
        $token = $this->request->getData('token');
        if (empty($token)) {
            // token invalid
            $response['status'] = 401;
        }
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
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

   /**
     * (Api) クラスの生徒情報を取得（一覧表示用）
     *
     */
    public function findStudentsByClassId($id = null)
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
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');
        $cramSchoolClassResult = $cramSchoolClassesTable->find()
            ->where(['token' => $token])
            ->where(['is_valid' => 1]) // 1.有効
            ->first();
        if (empty($cramSchoolClassResult)) {
            $response['status'] = 401;
        } else if (!empty($cramSchoolClassResult->last_login_api_datetime)
        && (date('Y-m-d H:i:s') >= $cramSchoolClassResult->last_login_api_datetime->modify("+6 hours")->format('Y-m-d H:i:s'))) {
            // 有効期限6時間
            $response['status'] = 401;
        }
        if (!empty($response['status'])) {
            // json
            $this->response->getType('application/json');
            echo json_encode($response);
            exit;
        }


        $response['users'] = [];

        if (empty($id)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else {

            $response['status'] = 200;

            $users = $this->Users->find()
                ->contain(['CramSchools'])
                ->where(['Students.cram_school_class_id' => $id])
                ->where(['Users.is_valid' => 1]) // 1.有効
                ->join([
                    'table' => 'students',
                    'alias' => 'Students',
                    'type' => 'LEFT',
                    'conditions' => 'Students.user_id = Users.id',
                ])
                ->join([
                    'table' => 'cram_school_classes',
                    'alias' => 'CramSchoolClasses',
                    'type' => 'LEFT',
                    'conditions' => 'CramSchoolClasses.id = Students.cram_school_class_id',
                ])
                ->order(['Users.id' => 'asc'])
                ->select([
                    'id' => 'Users.id',
                    'disp_no' => 'Users.disp_no',
                    'is_valid' => 'Users.is_valid',
                    'name' => 'Users.name',
                    'voice_type' => 'Users.voice_type',
                    'birthday' => 'Users.birthday',
                    'login_id' => 'Users.login_id',
                    'password' => 'Users.password',
                    'tel' => 'Users.tel',
                    'zip' => 'Users.zip',
                    'address' => 'Users.address',
                    'memo' => 'Users.memo',
                    'host' => 'Users.host',
                    'created' => 'Users.created',
                    'modified' => 'Users.modified',
                    'cram_school_id' => 'Users.cram_school_id',
                    'cram_school_name' => 'CramSchools.name',
                    'cram_school_class_id' => 'CramSchoolClasses.id',
                    'cram_school_class_name' => 'CramSchoolClasses.name'
                ])
                ->all();

            if (!empty($users)) {
                foreach ($users as $i => $user) {

                    $response['users'][$i]['id'] = $user->id;
                    $response['users'][$i]['disp_no'] = $user->disp_no;
                    $response['users'][$i]['is_valid'] = $user->is_valid;
                    $response['users'][$i]['name'] = $user->name;
                    $response['users'][$i]['voice_type'] = $user->voice_type;
                    $response['users'][$i]['birthday'] = $user->birthday->format('Y/n/j');
                    $response['users'][$i]['login_id'] = $user->login_id;
                    $response['users'][$i]['password'] = "********";
                    $response['users'][$i]['tel'] = $user->tel;
                    $response['users'][$i]['zip'] = $user->zip;
                    $response['users'][$i]['address'] = $user->address;
                    $response['users'][$i]['memo'] = $user->memo;
                    $response['users'][$i]['host'] = $user->host;
                    $response['users'][$i]['created'] = $user->created->format('Y/n/j');
                    $response['users'][$i]['modified'] = $user->modified->format('Y/n/j');
                    $response['users'][$i]['cram_school_id'] = $user->cram_school_id;
                    $response['users'][$i]['cram_school_name'] = $user->cram_school_name;
                    $response['users'][$i]['cram_school_class_id'] = $user->cram_school_class_id;
                    $response['users'][$i]['cram_school_class_name'] = $user->cram_school_class_name;

                }
            }

        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

}

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
class VoiceTrainingController extends AppController
{
    public function initialize()
    {
        parent::initialize();
    }

    /**
     * (Api) 発音トレーニング結果の登録
     *
     */
    public function save($userId = null)
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

        // table
        $usersTable = $this->getTableLocator()->get('Users');
        $studentsTable = $this->getTableLocator()->get('Students');
        if (empty($userId)) {
            // Invalid user supplied
            $response['status'] = 400;
        } else if (!isset($_FILES['file'])) {
            // Invalid file
            $response['status'] = 400;
          } else if (!($usersTable->exists(['id' => $userId])
           && $studentsTable->exists(['user_id' => $userId]))) {
            // User not found
            $response['status'] = 404;
        } else {

            // file
            $fileName = $_FILES['file']['name'];
            $tmpFile = $_FILES['file']['tmp_name'];

            $studentResult = $studentsTable->find()
                ->contain(['Users'])
                ->where(['user_id' => $userId])
                ->first();
            $cramSchoolId = $studentResult->user->cram_school_id;
            $cramSchoolClassId = $studentResult->cram_school_class_id;

            // Directory
            if (!file_exists(WWW_ROOT . "voice_training/{$cramSchoolId}")) {
                mkdir(WWW_ROOT . "voice_training/{$cramSchoolId}", 0777);
            }
            if (!file_exists(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}")) {
                mkdir(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}", 0777);
            }
            if (!file_exists(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}/{$userId}")) {
                mkdir(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}/{$userId}", 0777);
            } else {
                foreach (glob(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}/{$userId}/*.*") as $delFile) {
                    unlink($delFile);
                }
            }

            // upload
            $zip = new \ZipArchive();
            $zipFileName = date('YmdHis') . ".zip";
            $compress = $zip->open(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}/{$userId}/{$zipFileName}", \ZipArchive::CREATE);
            if ($compress === true) {
                $zip->addFile($tmpFile, $fileName);
                $zip->close();
                $response['status'] = 200;
            } else {
                $response['status'] = 500;
            }

        }
        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }


    /**
      * (Api) 発音トレーニング結果の取得（クラスID毎に取得）【⑧必要】
      *
      */
    public function findFileByClassId($classId = null)
    {
        // get
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


        // table
        $cramSchoolClassesTable = $this->getTableLocator()->get('CramSchoolClasses');

        if (empty($classId)) {
            // Invalid class supplied
            $response['status'] = 400;

        } else if (!($cramSchoolClassesTable->exists(['id' => $classId]))) {
            // Class not found
            $response['status'] = 404;

        } else {

            $response['status'] = 200;

            $cramSchoolClasseResult = $cramSchoolClassesTable->find()
                ->where(['id' => $classId])
                ->first();
            $cramSchoolId = $cramSchoolClasseResult->cram_school_id;

            if (empty(glob(WWW_ROOT . "voice_training/{$cramSchoolId}/{$classId}/*/*.*"))) {
                $response['status'] = 404;
                $this->response->getType('application/json');
                echo json_encode($response);
                exit;
            }

            $zipFile = date('YmdHis') . ".zip";
            $zip = new \ZipArchive();
            $compress = $zip->open(WWW_ROOT . "voice_training/tmp/{$zipFile}", \ZipArchive::CREATE);
            if ($compress === true) {
                foreach(glob(WWW_ROOT . "voice_training/{$cramSchoolId}/{$classId}/*/*.*") as $file) {
                    if (is_file($file)) {
                        $fileName = basename($file);
                        $zip->addFile($file, $fileName);
                    }
                }
                $zip->close();
                // $this->response->file(WWW_ROOT . "voice_training/tmp/{$zipFile}", ['download' => true, 'name' => $zipFile]);
                // $this->response->withFile(WWW_ROOT . "voice_training/tmp/{$zipFile}", ['download' => true, 'name' => $zipFile]);
                header('Content-Type: application/zip');
                header('Content-Disposition: attachment; filename="' . $zipFile . '"');
                header('Content-Length: '.filesize(WWW_ROOT . "voice_training/tmp/{$zipFile}"));
                ob_end_clean();

                readfile(WWW_ROOT . "voice_training/tmp/{$zipFile}");
                unlink(WWW_ROOT . "voice_training/tmp/{$zipFile}");
                exit;
                // $response['status'] = 200;
                // return $this->response;
            } else {
                $response['status'] = 500;
            }

        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }


    /**
      * (Api) 発音トレーニング結果の取得（生徒毎に取得）【⑨必要】
      *
      */
    public function findFileByStudentId($userId = null)
    {
        // get
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


        // table
        $usersTable = $this->getTableLocator()->get('Users');
        $studentsTable = $this->getTableLocator()->get('Students');

        if (empty($userId)) {
            // Invalid user supplied
            $response['status'] = 400;

        } else if (!($usersTable->exists(['id' => $userId])
        && $studentsTable->exists(['user_id' => $userId]))) {
            // User not found
            $response['status'] = 404;
        } else {

            $response['status'] = 200;

            $studentResult = $studentsTable->find()
                ->contain(['Users'])
                ->where(['user_id' => $userId])
                ->first();
            $cramSchoolClassId = $studentResult->cram_school_class_id;
            $cramSchoolId = $studentResult->user->cram_school_id;

            $downloadFilePath = "";
            foreach(glob(WWW_ROOT . "voice_training/{$cramSchoolId}/{$cramSchoolClassId}/{$userId}/*.*") as $file) {
                if (is_file($file)) {
                    $downloadFilePath = $file;
                    break;
                }
            }
            if (empty($downloadFilePath)) {
                $response['status'] = 404;
                $this->response->getType('application/json');
                echo json_encode($response);
                exit;
            }

            $downloadFileName = basename($downloadFilePath);
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $downloadFileName . '"');
            header('Content-Length: '.filesize($downloadFilePath));
            ob_end_clean();

            readfile($downloadFilePath);
            exit;
            // $this->response->withFile($downloadFilePath, ['download' => true, 'name' => $downloadFileName]);
            // return $this->response;

        }

        // json
        $this->response->getType('application/json');
        echo json_encode($response);
        exit;

    }

}

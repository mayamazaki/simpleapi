<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

Router::extensions(['json']);
/**
 *  塾 API
 */
Router::scope('/CramSchool', function (RouteBuilder $routes) {

    // ログイン
    // post
    $routes->post(
        '/user/login',
        ['controller' => 'users', 'action' => 'login', 'prefix' => 'CramSchool']
    );
    // ログアウト
    // post
    $routes->post(
        '/user/logout',
        ['controller' => 'users', 'action' => 'logout', 'prefix' => 'CramSchool']
    );

    // 2.クラス、ユーザーの紐づけ情報の更新【②必要】
    // post
    $routes->post(
        '/user/updateStudentBelongToClass',
        ['controller' => 'users', 'action' => 'updateStudentBelongToClass', 'prefix' => 'CramSchool']
    );

    // 3.生徒情報の登録・変更・削除【③必要】
    // 登録
    // post
    $routes->post(
        '/user',
        ['controller' => 'users', 'action' => 'insert', 'prefix' => 'CramSchool']
    );
    // 更新
    // put
    $routes->put(
        '/user/*',
        ['controller' => 'users', 'action' => 'update', 'prefix' => 'CramSchool']
    );
    // 削除
    // delete
    $routes->delete(
        '/user/*',
        ['controller' => 'users', 'action' => 'delete', 'prefix' => 'CramSchool']
    );

    // 4.生徒のパスワードセット、リセット
    // パスワードリセット
    $routes->put(
        '/user/passwordReset/*',
        ['controller' => 'users', 'action' => 'passwordReset', 'prefix' => 'CramSchool']
    );
    // パスワードアップデート
    $routes->put(
        '/user/passwordUpdate/*',
        ['controller' => 'users', 'action' => 'passwordUpdate', 'prefix' => 'CramSchool']
    );

    // 5.ライセンス登録（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/save',
        ['controller' => 'licenses', 'action' => 'save', 'prefix' => 'CramSchool']
    );
    // 6.ライセンス追加（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/add',
        ['controller' => 'licenses', 'action' => 'add', 'prefix' => 'CramSchool']
    );

    // 7.発音トレーニング結果の登録【⑦必要】
    // 登録
    // post
    $routes->post(
        '/voiceTraining/*',
        ['controller' => 'voiceTraining', 'action' => 'save', 'prefix' => 'CramSchool']
    );
    // 8.発音トレーニング結果の取得（クラスID毎に取得）【⑧必要】
    $routes->post(
        '/voiceTraining/findFileByClassId/*',
        ['controller' => 'voiceTraining', 'action' => 'findFileByClassId', 'prefix' => 'CramSchool']
    );
    // 9.発音トレーニング結果の取得（生徒毎に取得）【⑨必要】
    $routes->post(
        '/voiceTraining/findFileByStudentId/*',
        ['controller' => 'voiceTraining', 'action' => 'findFileByStudentId', 'prefix' => 'CramSchool']
    );

});

/**
 * クラス API
 */
Router::scope('/CramSchoolClass', function (RouteBuilder $routes) {

    // ログイン
    // post
    $routes->post(
        '/user/login',
        ['controller' => 'users', 'action' => 'login', 'prefix' => 'CramSchoolClass']
    );
    // ログアウト
    // post
    $routes->post(
        '/user/logout',
        ['controller' => 'users', 'action' => 'logout', 'prefix' => 'CramSchoolClass']
    );

    // 2.クラス、ユーザーの紐づけ情報の更新【②必要】
    // post
    $routes->post(
        '/user/updateStudentBelongToClass',
        ['controller' => 'users', 'action' => 'updateStudentBelongToClass', 'prefix' => 'CramSchoolClass']
    );

    // 3.生徒情報の登録・変更・削除【③必要】
    // 登録
    // post
    $routes->post(
        '/user',
        ['controller' => 'users', 'action' => 'insert', 'prefix' => 'CramSchoolClass']
    );
    // 更新
    // put
    $routes->put(
        '/user/*',
        ['controller' => 'users', 'action' => 'update', 'prefix' => 'CramSchoolClass']
    );
    // 削除
    // delete
    $routes->delete(
        '/user/*',
        ['controller' => 'users', 'action' => 'delete', 'prefix' => 'CramSchoolClass']
    );

    // 4.生徒のパスワードセット、リセット
    // パスワードリセット
    $routes->put(
        '/user/passwordReset/*',
        ['controller' => 'users', 'action' => 'passwordReset', 'prefix' => 'CramSchoolClass']
    );
    // パスワードアップデート
    $routes->put(
        '/user/passwordUpdate/*',
        ['controller' => 'users', 'action' => 'passwordUpdate', 'prefix' => 'CramSchoolClass']
    );

    // 5.ライセンス登録（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/save',
        ['controller' => 'licenses', 'action' => 'save', 'prefix' => 'CramSchoolClass']
    );
    // 6.ライセンス追加（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/add',
        ['controller' => 'licenses', 'action' => 'add', 'prefix' => 'CramSchoolClass']
    );

    // 7.発音トレーニング結果の登録【⑦必要】
    // 登録
    // post
    $routes->post(
        '/voiceTraining/*',
        ['controller' => 'voiceTraining', 'action' => 'save', 'prefix' => 'CramSchoolClass']
    );
    // 8.発音トレーニング結果の取得（クラスID毎に取得）【⑧必要】
    $routes->post(
        '/voiceTraining/findFileByClassId/*',
        ['controller' => 'voiceTraining', 'action' => 'findFileByClassId', 'prefix' => 'CramSchoolClass']
    );
    // 9.発音トレーニング結果の取得（生徒毎に取得）【⑨必要】
    $routes->post(
        '/voiceTraining/findFileByStudentId/*',
        ['controller' => 'voiceTraining', 'action' => 'findFileByStudentId', 'prefix' => 'CramSchoolClass']
    );

    // 10.クラスの生徒情報を取得（一覧表示用）
    $routes->post(
        '/user/findStudentsByClassId/*',
        ['controller' => 'users', 'action' => 'findStudentsByClassId', 'prefix' => 'CramSchoolClass']
    );

});


/**
 * 学生 API
 */
Router::scope('/Student', function (RouteBuilder $routes) {

    // ログイン
    // post
    $routes->post(
        '/user/login',
        ['controller' => 'users', 'action' => 'login', 'prefix' => 'Student']
    );
    // ログアウト
    // post
    $routes->post(
        '/user/logout',
        ['controller' => 'users', 'action' => 'logout', 'prefix' => 'Student']
    );

    // 3.生徒情報の登録・変更・削除【③必要】
    // 登録
    // post
    $routes->post(
        '/user',
        ['controller' => 'users', 'action' => 'insert', 'prefix' => 'Student']
    );
    // 更新
    // put
    $routes->put(
        '/user/*',
        ['controller' => 'users', 'action' => 'update', 'prefix' => 'Student']
    );
    // 削除
    // delete
    $routes->delete(
        '/user/*',
        ['controller' => 'users', 'action' => 'delete', 'prefix' => 'Student']
    );

    // 4.生徒のパスワードセット、リセット
    // パスワードリセット
    $routes->put(
        '/user/passwordReset/*',
        ['controller' => 'users', 'action' => 'passwordReset', 'prefix' => 'Student']
    );
    // パスワードアップデート
    $routes->put(
        '/user/passwordUpdate/*',
        ['controller' => 'users', 'action' => 'passwordUpdate', 'prefix' => 'Student']
    );

    // 5.ライセンス登録（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/save',
        ['controller' => 'licenses', 'action' => 'save', 'prefix' => 'Student']
    );
    // 6.ライセンス追加（ユーザー情報に、ID紐づけして登録）
    // post
    $routes->post(
        '/licenses/add',
        ['controller' => 'licenses', 'action' => 'add', 'prefix' => 'Student']
    );

    // 7.発音トレーニング結果の登録【⑦必要】
    // 登録
    // post
    $routes->post(
        '/voiceTraining/*',
        ['controller' => 'voiceTraining', 'action' => 'save', 'prefix' => 'Student']
    );
    // 9.発音トレーニング結果の取得（生徒毎に取得）【⑨必要】
    $routes->post(
        '/voiceTraining/findFileByStudentId/*',
        ['controller' => 'voiceTraining', 'action' => 'findFileByStudentId', 'prefix' => 'Student']
    );

});

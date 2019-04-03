<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Licenses Model
 *
 * @property \App\Model\Table\LicensePartnersTable|\Cake\ORM\Association\HasMany $LicensePartners
 *
 * @method \App\Model\Entity\License get($primaryKey, $options = [])
 * @method \App\Model\Entity\License newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\License[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\License|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\License|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\License patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\License[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\License findOrCreate($search, callable $callback = null, $options = [])
 */
class LicensesTable extends Table
{

    public static function defaultConnectionName() {
        return 'prontest';
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('licenses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('LicensePartners', [
            'foreignKey' => 'license_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        // ID
        $validator
            ->nonNegativeInteger('id')
            ->allowEmpty('id', 'create');

        // 表示順
        $validator
            ->scalar('disp_no')
            ->allowEmpty('disp_no')
            ->add('disp_no', [
                    'naturalNumber' => [
                        'rule' => ['naturalNumber', true],
                        'message' => '表示順は数字で入力してください。'
            ]]);

        // 有効無効フラグ
        $validator
            ->requirePresence('is_valid', 'create')
            ->notEmpty('is_valid', '有効無効フラグを選択してください。');

        // ライセンスコード
        $validator
            ->scalar('license_code')
            ->maxLength('license_code', 255, 'ライセンスコードは255文字以内で入力してください。')
            ->requirePresence('license_code', 'create')
            ->notEmpty('license_code', 'ライセンスコードを入力してください。');

        // ライセンス有効期間（開始日）
        $validator
            ->date('exp_s_dt')
            ->allowEmpty('exp_s_dt')
            ->add('exp_s_dt', 'date_format', [
                'rule' => ['date', "ymd"],
                'message' => 'ライセンス有効期間（開始日）の日付形式が不正です。'
            ]);

        // ライセンス有効期間（終了日）
        $validator
            ->date('exp_f_dt')
            ->allowEmpty('exp_f_dt')
            ->add('exp_f_dt', 'date_format', [
                'rule' => ['date', "ymd"],
                'message' => 'ライセンス有効期間（終了日）の日付形式が不正です。'
            ]);

        // 認証日時
        $validator
            ->dateTime('auth_datetime')
            ->allowEmpty('auth_datetime')
            ->add('auth_datetime', 'date_format', [
                'rule' => ['date', "ymdhis"],
                'message' => '認証日時の日時形式が不正です。'
            ]);

        // 認証に絡む情報１（予備）
        $validator
            ->scalar('auth_info1')
            ->maxLength('auth_info1', 255, '認証に絡む情報１（予備）は255文字以内で入力してください。')
            ->allowEmpty('auth_info1');

        // 認証に絡む情報２（予備）
        $validator
            ->scalar('auth_info2')
            ->maxLength('auth_info2', 255, '認証に絡む情報２（予備）は255文字以内で入力してください。')
            ->allowEmpty('auth_info2');

        // 認証に絡む情報３（予備）
        $validator
            ->scalar('auth_info3')
            ->maxLength('auth_info3', 255, '認証に絡む情報３（予備）は255文字以内で入力してください。')
            ->allowEmpty('auth_info3');

        return $validator;
    }
}

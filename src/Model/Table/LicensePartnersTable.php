<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LicensePartners Model
 *
 * @property \App\Model\Table\LicensesTable|\Cake\ORM\Association\BelongsTo $Licenses
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\LicensePartner get($primaryKey, $options = [])
 * @method \App\Model\Entity\LicensePartner newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LicensePartner[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LicensePartner|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LicensePartner|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LicensePartner patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LicensePartner[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LicensePartner findOrCreate($search, callable $callback = null, $options = [])
 */
class LicensePartnersTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('license_partners');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // $this->belongsTo('Licenses', [
        //     'foreignKey' => 'license_id',
        //     'joinType' => 'INNER'
        // ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
        $validator
            ->nonNegativeInteger('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('disp_no')
            ->allowEmpty('disp_no');

        $validator
            ->requirePresence('is_valid', 'create')
            ->notEmpty('is_valid');

        $validator
            ->scalar('license_code')
            ->maxLength('license_code', 255)
            ->requirePresence('license_code', 'create')
            ->notEmpty('license_code');

        $validator
            ->date('exp_s_dt')
            ->allowEmpty('exp_s_dt');

        $validator
            ->date('exp_f_dt')
            ->allowEmpty('exp_f_dt');

        $validator
            ->dateTime('auth_datetime')
            ->requirePresence('auth_datetime', 'create')
            ->notEmpty('auth_datetime');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        // $rules->add($rules->existsIn(['license_id'], 'Licenses'));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}

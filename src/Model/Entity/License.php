<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * License Entity
 *
 * @property int $id
 * @property int $disp_no
 * @property int $is_valid
 * @property string $license_code
 * @property \Cake\I18n\FrozenDate $exp_s_dt
 * @property \Cake\I18n\FrozenDate $exp_f_dt
 * @property \Cake\I18n\FrozenTime $auth_datetime
 * @property string $auth_info1
 * @property string $auth_info2
 * @property string $auth_info3
 *
 * @property \App\Model\Entity\LicensePartner[] $license_partners
 */
class License extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'disp_no' => true,
        'is_valid' => true,
        'license_code' => true,
        'exp_s_dt' => true,
        'exp_f_dt' => true,
        'auth_datetime' => true,
        'auth_info1' => true,
        'auth_info2' => true,
        'auth_info3' => true,
        'license_partners' => true
    ];
}

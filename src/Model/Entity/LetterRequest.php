<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LetterRequest Entity
 *
 * @property int $id
 * @property int $matrix_id
 * @property int $template_id
 * @property int|null $admin_id
 * @property string $purpose
 * @property string $organization_name
 * @property string $organization_address
 * @property string $program_name
 * @property string|null $reason
 * @property string $status
 * @property string|null $admin_remarks
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\LetterTemplate $letter_template
 */
class LetterRequest extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'matrix_id' => true,
        'template_id' => true,
        'admin_id' => true,
        'purpose' => true,
        'organization_name' => true,
        'address1' => true,         // Pastikan ini true
        'address2' => true,         // Pastikan ini true
        'address3' => true,         // Pastikan ini true
        'program_name' => true,
        'method' => true,
        'supporting_document' => true, // Pastikan ini true
        'group_members' => true,    // Pastikan ini true
        'status' => true,
        'reason' => true,
        'admin_remarks' => true,
        'created_at' => true,
        'updated_at' => true,
        '*' => true,
    ];
}

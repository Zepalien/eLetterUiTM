<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LetterTemplate Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $subject_line
 * @property string|null $body_content
 * @property string $content
 * @property int|null $created_by
 * @property \Cake\I18n\DateTime $created_at
 * @property \Cake\I18n\DateTime $updated_at
 *
 * @property \App\Model\Entity\LetterRequest[] $letter_requests
 */
class LetterTemplate extends Entity
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
        'title' => true,
        'subject_line' => true,
        'paragraph_1' => true,
        'paragraph_2' => true,
        'paragraph_3' => true,
        'signatory_name' => true,
        'signatory_role' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
    ];
}

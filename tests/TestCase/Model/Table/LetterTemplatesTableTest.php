<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LetterTemplatesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LetterTemplatesTable Test Case
 */
class LetterTemplatesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LetterTemplatesTable
     */
    protected $LetterTemplates;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.LetterTemplates',
        'app.LetterRequests',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LetterTemplates') ? [] : ['className' => LetterTemplatesTable::class];
        $this->LetterTemplates = $this->getTableLocator()->get('LetterTemplates', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LetterTemplates);

        parent::tearDown();
    }
}

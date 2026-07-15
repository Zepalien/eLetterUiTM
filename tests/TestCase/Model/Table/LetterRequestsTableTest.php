<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LetterRequestsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LetterRequestsTable Test Case
 */
class LetterRequestsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LetterRequestsTable
     */
    protected $LetterRequests;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.LetterRequests',
        'app.Users',
        'app.LetterTemplates',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('LetterRequests') ? [] : ['className' => LetterRequestsTable::class];
        $this->LetterRequests = $this->getTableLocator()->get('LetterRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LetterRequests);

        parent::tearDown();
    }
}

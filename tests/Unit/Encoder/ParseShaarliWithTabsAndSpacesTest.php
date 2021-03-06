<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;
use PHPUnit\Framework\TestCase;

class ParseShaarliWithTabsAndSpacesTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    public const EXPECTED = [
        [
            'name' => 'Note: Code tests',
            'image'  => null,
            'url'   => '?KvNdlQ',
            'tags'  => ['dev'],
            'dateCreated'  => 1591456706,
            'public'   => false,
        ],
    ];

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse flat Shaarli bookmarks (no directories).
     */
    public function testParseFlat(): void
    {
        $content = file_get_contents(self::FIXTURE_DIRECTORY . 'input/shaarli_with_tabs_and_spaces.htm');
        $result = $this->decoder->decode($content);

        $expected = [
            [
                'name' => 'Note: Code tests',
                'image'  => null,
                'url'   => '?KvNdlQ',
                'tags'  => ['dev'],
                'description'  => null,
                'dateCreated'  => 1591456706,
                'public'   => false,
            ],
        ];
        $expected[0]['description'] = trim(
            file_get_contents(self::FIXTURE_DIRECTORY . 'output/shaarli_with_tabs_and_spaces.txt')
        );

        $this->assertSame($expected, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $context = [
            NetscapeBookmarkDecoder::KEEP_NESTED_TAGS => false,
        ];

        $this->decoder = new NetscapeBookmarkDecoder($context);
    }

    protected function tearDown(): void
    {
        $this->decoder = null;
    }
}

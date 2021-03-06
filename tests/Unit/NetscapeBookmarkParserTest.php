<?php

declare(strict_types=1);

/*
 * This file is part of the Shaarli Netscape Bookmark Parser package.
 *
 * (c) "Matthias Morin" <mat@tangoman.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\NetscapeBookmarkParser;

/**
 * @author "Matthias Morin" <mat@tangoman.io>
 */
class NetscapeBookmarkParserTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../Fixtures/Encoder/';

    // phpcs:disable Generic.Files.LineLength
    public const EXPECTED_1 = [
        [
            'name'        => 'Cozy - Simple, versatile, yours',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACeElEQVQ4jX1TW0hUURRd+8yZuaPOdQxNiSiipAdjICISNhBFVIIRiBoYRP9BSSBFBXPnoyj666O+AoOEmMmpNBUKHSQRiTCDKYqeX6KBzuOa4zzu2X3M+NbW1zn77LX3WntzgI1gsFh1Z6Z1sTzkuggzgUgBAB4nSt1SqThRFADn33jzAvmEPU/jDXA6L1E6tUMxVFn3wg9rIen/TTSxtgitIAsQqf2BeBsT34bNfnlfeeFQZDIqSMhWCe7IZLjt51f3eM5mXiUAoIVtee/yYCgeORCarVrrbG9g5mxVKBbeYE5MAFD9PFpS22c+rHkZ688lhJftBXIN6nvjX04MzXVUPpkpXrQsAOL6vsQFTWLEoWkuAXULzAQML0tsJQsA0hbfTMBRXVpMo95XsRYQMR0eiDaRwh3Fsmm0UY9sspVVkz/UG6uRQnURc7vUiK6RxMXBk3oEYZYY9qvKunP27++6MjAMBSL2BNjx6TOyeb4YO03jx15Hr5OiG9QwGP0l55Oe3sZtSfj9BMNQx9/Mep02WafY6ibBuhDijFOlHwWPlk8BTDD85K1td+savxd2sJovcBW0BIMCPh8DTFn5cYyt9IAg4UGWt3Mi2xkcfvBnkWz4fCgpyBZKwRlqHoq+gA0Tz45sMdb5/w+aw7P3FKOC2t7GdrNl9ZBAyGXZ7yfT88lpAG6HoFSCCADcu8rU9NQ0KgDAVVRkqcwVZpxKWdxIAHB+ZHKnUtpdaYOHhC3DSoFZ5UZPAEGAAGYiAitpKf4gNefVzjrXFK1cU0P/t+KS8gqHjjmYJqDrLphmTrKuAyaAvwupVI93q7m04qXDJt91QzCLRfI/LI8pZq5PEwYAAAAASUVORK5CYII=',
            'url'         => 'https://cozy.io/en/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009029,
            'public'      => null,
        ],
        [
            'name'        => 'Framasoft ~ Page portail du réseau',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABqklEQVQ4jaWTz0vTYRzHX+/vKnOpEHWpCApslwaVs0GHIpDIykNdkoRunrQoO4TtD7CuHbY/oCCY0C3rpAQdCnQRhhUlEYqyGKMi5MsyeXvYRmv5DaL36YH383k9nx/PRzRpuH8sYWvAJiWRArApSBQkP8jmM+8b7+vX0Rruv33N1hjQ2gyuKZScyeZv3QW5AWANXbzzCDgbEdisx7nx0T6QY9W0W66Dru7r3MXJM91s39HB8mIJ21GAA+nks6/Tc5MvVKv5VT1tSVweOsfuvTt5eG+KD28WoiCh5MOBrYHGmm1zPzdBpbLK4I3zbGnZHAVotXUpsKudbpRtnk/N0tYep/fCschG2HQH9VE16/XLeWw42NUZCZBIBVHmyveQtZ9rtHfEIwEAgU0hyix9/kJ821baIiA2hUCKBjx9MkNsU4zjp45s6EvMxNLJnmXQIPBHuxc+FsFw4nQX5dI3ikvlRjuUfCU2PTdZTid7VkC9G70y/3aRd7OfOHQ0wf7EHopLZX5UVpF8M5vPTPz3V65NQc6Nj/ZJHgHCvwSGkkfqwfDbNlb1r+u8Dmi/rn7y/d+2AAAAAElFTkSuQmCC',
            'url'         => 'https://framasoft.org/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009059,
            'public'      => null,
        ],
        [
            'name'        => 'The Linux Kernel Archives',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACdUlEQVQ4jZVSTUhUURg9975nb35y/JnxJ5tkMlMzEhmjv0VYGhkiLmJESqNFqyJaFLUSxlWtQiSCCIu20WKgCFxJYomGxGAJzaQVmYJkRfnm571779fCGVMyo7P5Fvec7/vOdy6wMep0XT8cDof5P3hrwDL1MgDTYRgpn6/oKQDP/zTRysu3TTpzfRRs2J/2+7cSgLPZt9VE/Q8pgYGBt7Z18N3+BLl9VTQyHpcDd28HiIgzxrBhA+oFY4Daqd//eaElgblZYkNz+ZphbC5FL1sesQrrHCcMADKl1erR1x6m57fzXXtPksvtOsHCyAWgNvLOAcDr9XaPjkXl/OdZYUmihcUfts/nJQB9GR5bV01EHEBZY2PjAimppFIimTApHo/J011dAoAE0PS37TmFwT0eR8/g4CAREdm2rYQQSgihhoef2YWFBaTr2lBGvHYLopAGIG97ZXBaCEulUilhmglFRJKIaMlMq5rqagUgCaA6ayWbAmfsobp6igXdxaLCEjlgZPJ0Og2Xy8lBBJGIwZKA0+HGji2mMTmD34lSGHz+CVrVy9IJigfo0cA58eHTF2VZaWlZFllCKPPVUdlSB/vBjSJJ0ZLOrA4AMH0Necnxku/0Jkg0ddAevQd1q/+6pAzMFMlYpEbSWK6gqT1Eb4Pv0hP+upVLRh0wOIQLLgFA6gcOVbDQvkk+8nwMkUgE3R3t/NviR47SWg3QkRSWYFqOYyXPUAibLh3BeYOz5oJCd31xEcoij5dmztzUhgFpAfC96NOOByrdzth7+07XxWTPLPB1va9gVABV/R1o66x3BJbTCfOGhjbXlWY09x5DU3Zo1v8v0xEfb77i9asAAAAASUVORK5CYII=',
            'url'         => 'https://www.kernel.org/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009167,
            'public'      => null,
        ],
        [
            'name'        => 'Regex Crossword',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAB2UlEQVQ4jYWTz2uScRzHXz5uQfp46i6uQ4QhQf4DgzpFPVtKlxmNrkG2npOSY1rgcX/ARoeCdliroHaJLYg8RoeQIDoEQqvUkqRNI/V5dzAft/mjL3zh++HL683788vzfI71Cye4jIeB87sNjsA3OfiHYPMjjzzKomFwowWL70+DMUHu5FvMI8NFjHFwemWbzOoWSx+i7P4ZIuABYxR8Y/kppmni8/m4ufxkpIhxGL724hjplW1CoSm+ff3Czs5ngsEgmdUtUu8iAyLGfth6COtvfpDP5/lerTI7e4kZa4ZKpUy73eLO/VeDTpRDexl0dgp1y4JM09SthQU3zmaX1Gg0JEmlUkl2PKpft5FyiObiQThgmioUCnIcR+lUSrZty3Ec1et1VStlNZtN1Wo12fGo9jLI6FXTdSThdDq9LrmnWCxy0bKo138iCfSv+24Kx/su/H6/riQSbpxMJhUIBAToVDgsO3ZGu70UlOs+Dov0biQSUaVcVjqVEqDpEC6sHPIo13faaIG1Bi8/uXPCxuMNYrE4tVqN6+fD3DtXxr9vKif299Q3Cc/m+iIC5q/O4/V6ef3g7gAMcMDBKCfTIdhMMAB3BcYsk7UGHWc0jMDzv3WW4OiYdf4LzLYa1HClursAAAAASUVORK5CYII=',
            'url'         => 'https://regexcrossword.com/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009412,
            'public'      => null,
        ],
        [
            'name'        => 'WINDOWS93',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAjElEQVQ4jaVTMRLAIAwKnt/q6/swOlTbFJPqnSw6ACExmm0CizxmupmBCocAaKTI6BGfYnM4dgkEVLEXHPgaFqk+izwARtKAtAWN75P0BI1OPme/L6B8qidCnYFHpZEwIGgjHKS2VF/2bUS7U0BeNptFhb2Vu/ivBTVbWqQ/VHfvRpEwnc9siXb/yhwXQHI8D4Tvv90AAAAASUVORK5CYII=',
            'url'         => 'http://www.windows93.net/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009435,
            'public'      => null,
        ],
        [
            'name'        => 'Are there any worse sorting algorithms than Bogosort (a.k.a Monkey Sort)? - Stack Overflow',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABXklEQVQ4jbWQsUsCYRjGn/fuSu/Sk3ALmlzNtoagKRqSaHMKGkKhEOV0KWispSXPQaglAnNobOgfaCyIcgicmxO9zFPv/N5WwTs5gt7x+5739/2eDwgw/bK67HcnBQG4Ag3L0LJ/BoBFDuDzTiGUCAywDC3bNbRtANCrwxaBziRZanAGcjADwR8AX1uGesEZyFGzXwO43VsKn07GaJa5lY/GMefUAYooEvaELDnCEW9M2I1V7GdPg04hlLAM7dYqqut67ftLNwdpMB5dgRfXdVMgHIFpx9egfbwYk0eDA2LKAWJMkK6cUOhOGdkpZmoQiy29OmwFq1AKb5CgQyakAXqQJKpELn/eJzPK1JKhPhHjk4EmMzUVmU/coVLkeXff672pk155YXUsxikCJQFeYVCSgCiAV920N311b+r37FslH413S+qaV86rggfIBbG38RRAN+2ZHzsTMKvGv80vvziHGAusG84AAAAASUVORK5CYII=',
            'url'         => 'http://stackoverflow.com/questions/2609857/are-there-any-worse-sorting-algorithms-than-bogosort-a-k-a-monkey-sort',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009639,
            'public'      => null,
        ],
        [
            'name'        => 'GitHub - lhartikk/ArnoldC: Arnold Schwarzenegger based programming language',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACJElEQVQ4jY1TMWsUQRT+5r3d3Cbe7t3u3hEDdoJgIVieGo1YBixsBIsUtvkHNpaCnaJFUMEihSlEbGxFE8XCRrDWIAqJyd3t3JGcuduZeRa5DUtAk6968/i+733zhlE4hHq9foWZbwG4pkRmAECU2gDw1lr7Qmu9WuarUs2NOH7Onrdw2LQMa8xyO8tuA7BlA07TdM0juvA/cQHj3KdOp3MZgGUAaMTxssc8nxuzOsrzm90s2yDmU6TUtoh0BKhut9t3Rnl+1/O8Mz7z7GSlcnqwt/cKURS1pptNmW42JUmSpfGQKoCp0tBqkTZJkqWCH0VRiyaYFw/uZ+2zcbkDYFAy2AEgAOCcWymaE8yLBOZZALDOjQB0jrGCdevccH9zPEsYPxWU2uz1eutHqbXWP6DUbwCAyAwV0QDUANAxEhBE6uNaSICfAMBK1dI0vX6UOo7jeSaKsD/5F5FSa04EW+22dca8jMPw0r/ESRheZKKnxVlE3lFuzOPRMIeIWN3v93u7ux+IaBBFUasgBkFwlYi2/SD4yEQnSwaPSGv9xa/4T6abzYm6789Vq9WFMAw/K6W2CmKlUtmJoqhRTmNFHmRZ9vXgLyRx/J6IzlnnzotIX2utS/ywkaabTDQFANaY1+0su7G/0TG6WTYHpVaY6LvH/A3ATMngRCE2xtwrxADA5ViDweDNZBDsQamG7/vLw+HwDwDUajVfiZx1wMNOt3u/rPkLJe7aBdfH1TYAAAAASUVORK5CYII=',
            'url'         => 'https://github.com/lhartikk/ArnoldC',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466009667,
            'public'      => null,
        ],
        [
            'name'        => 'OpenClassrooms, MOOCs and courses open for all',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAADBElEQVQ4jb2TW0hTcRzHf/9zNp27uM3tzM2ZObwMybA0MrWbiTUkwojCLH0wsaRQyUBIi5GSLwlmD2VQT0FREIZd6AKtpUXiCou8K5o5dbo2j+64c87O+feU2INPQZ+378vn4cv3C/CPoLXhvT49AyFU9UYxVp1GKeKzY+U1WCRbjE8Gv60nkAAAXDJTxwgCdwGLQzwm62DCT1sSohgMIEjJkI+5dTAryPCS8WsLrm1uF7NWQNopSoklqBAL2F3UnLKYdN8xtdNs6Ohf4ETb48JnygKrwI94rwRnhAJPD3MzTS0xZWsiFt7SgWkAANLBMJyTDjiet+wrEQUcuvp0ZHS3ShEccnvuH63Z4RQxKJpKX1KiPvztnjuZ2uQEBVaEo+0b5nmNk2Y+SwLtBXflLK5kQFz82D1b1hBLEWczI0cIrO6m7w2c7L/hj9cZlMlRSRoNgTAdgQQ2QiRCSjGs6ENWgkNCEGQjqupkAaC9wUwdRIDipATRJ4j4y+TjHwAh5X5bivXcxjwDz73/0RrsmUpQD4p0DmfMtRgCtQgAYO5I4mUSiIe6zcXDy9Ef9KrKV556s/48AnRxaHo++hGAAABwFIC80ZL/Qp1K8dIUKqdp14N+EgCg1qqXC4AXyXSuEBHEO/t12wuVl9HoKbm//vtc55/G+wFwGTJlBoeXRDTh9pkStV6iW7N141iXsm3SqQIgiWdkYlRrkGbrjCbFhpzdMZbeigz1H4HHvlfJ0SEzP8spuK+eOMogl6wOyR4TIw8hviGvelPbm9aBTITEjvTtOusBW+IDfsBzgQ9yojw9tlmWHy9lfrJ032FX7utwd+OqALdnSF86QsldTvdxDNBXXpGaq6dk8yvOyTxVadoUS4N0sH7UOJkhzEabZNyWmEjt84fjJcTqpk+7+APWwwOAcQ8AkimxwHATfvMvf5Cj51gh4MXCIs1yvjGfsDyztBKmJRuLXcMLf31hLXOHLNEskpTf7vWf2MWbZngkRH6SzstPndl0R6eT3lNVvvKs+7D/ym//plTn6CKKEQAAAABJRU5ErkJggg==',
            'url'         => 'https://openclassrooms.com/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466010140,
            'public'      => null,
        ],
        [
            'name'        => 'Timeline of the Elves in Tolkien’s works | LotrProject Blog',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAoUlEQVQ4jaWT0Q3DIAxE3zkdLKNVXaULdAQGCzgfQJqUJg3NSXwg+Y5nWwhwAEm4O71SDfhXJumK/zeBCZLnwqq1YQmo/X8jShuzYRJyARN2FtXKGcpjL6Y+gvqSDGICaUAeuZ0lWFpIhiSerj6CdTNSykN1zhM8yh7uGPg7snsGn2oIQgib+ziOh2QNQVMgEcnrOwzYkwnc94uuf6YrZoAZgvY+bSu6dgkAAAAASUVORK5CYII=',
            'url'         => 'http://lotrproject.com/blog/2013/02/08/timeline-of-the-elves-in-tolkiens-works/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466010205,
            'public'      => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkParser|null
     */
    private $parser;

    // --------------------------------------------------
    // Business Logic
    // --------------------------------------------------

    public function testParseFileShouldReturnExpectedResult(): void
    {
        $filePath = self::FIXTURE_DIRECTORY . 'input/chromium_flat.htm';
        $result = $this->parser->parseFile($filePath);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    public function testParseStringShouldReturnExpectedResult(): void
    {
        $filePath = self::FIXTURE_DIRECTORY . 'input/chromium_flat.htm';
        $data = file_get_contents($filePath);
        $result = $this->parser->parseString($data);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->parser = new NetscapeBookmarkParser();
    }

    protected function tearDown(): void
    {
        $this->parser = null;
    }
}

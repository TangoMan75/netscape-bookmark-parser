<?php

declare(strict_types=1);

namespace Shaarli\NetscapeBookmarkParser\Tests\Unit\Encoder;

use PHPUnit\Framework\TestCase;
use Shaarli\NetscapeBookmarkParser\Encoder\NetscapeBookmarkDecoder;

/**
 * Ensure Chromium exports are properly parsed.
 *
 * The reference data has been dumped with Chromium 51.0.2704.84
 */
class ParseChromiumBookmarksTest extends TestCase
{
    public const FIXTURE_DIRECTORY = __DIR__ . '/../../Fixtures/Encoder/';

    // https://github.com/squizlabs/PHP_CodeSniffer/wiki/Advanced-Usage#ignoring-parts-of-a-file
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

    public const EXPECTED_2 = [
        [
            'name'        => 'jabber.org - the original XMPP instant messaging service',
            'image'       => null,
            'url'         => 'http://www.jabber.org/',
            'tags'        => [
                'personal',
                'toolbar',
            ],
            'description' => null,
            'dateCreated' => 1466010266,
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
            'name'        => 'Timeline of the Elves in Tolkien’s works | LotrProject Blog',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAAoUlEQVQ4jaWT0Q3DIAxE3zkdLKNVXaULdAQGCzgfQJqUJg3NSXwg+Y5nWwhwAEm4O71SDfhXJumK/zeBCZLnwqq1YQmo/X8jShuzYRJyARN2FtXKGcpjL6Y+gvqSDGICaUAeuZ0lWFpIhiSerj6CdTNSykN1zhM8yh7uGPg7snsGn2oIQgib+ziOh2QNQVMgEcnrOwzYkwnc94uuf6YrZoAZgvY+bSu6dgkAAAAASUVORK5CYII=',
            'url'         => 'http://lotrproject.com/blog/2013/02/08/timeline-of-the-elves-in-tolkiens-works/',
            'tags'        => [],
            'description' => null,
            'dateCreated' => 1466010205,
            'public'      => null,
        ],
        [
            'name'        => 'PHP Standards Recommendations - PHP-FIG',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACK0lEQVQ4jX2SO0+UURCGn/d8u8viekEEYhRlV2Ik+bg01saYqGCtNiKVFjQ2/gFjQWtiAz9AbSAxohEsVBJbCyNs4iVBwGAiYITCvbD7nbHYZXUFnGaSeeeZk5n3iF1iz7FTR1B8GgAr9ee+fvy2U5/qoI6eS4YNm9ka0mlJ3QBmNofZW0ktQqO5xdnnOww4G0um12blXBdmldJWlmrZvP9QWGjpgZkyQABAGCYaUvkbTrqGmdttreqMpqAptxIdbX3P6mok2sPmZMADSReBnWEJzFaBPNJxzLyZvShEDLqkLJTcwH9hzw8jdtXLXcDbFyQnuYGkLHSy+Dxmy3/OobqdMX56uF5YeDdj5VK8ognMlmXxeRcF0X5EosIrb97uYH4S58DY8MZgcXF2am9nb3cQCx4jMuBBJKIg2h8kmltfgctUhvqXhaXszXLzvqm4xdqjSCObS7PPUpmwz3ueIHXWnEEpJzujZDr8JLmTVaFoxt3C4tzI1glSmbDPm6u8XIOrlpr/HMSaDj0F1ycpA8QkzsUOtJXKGytvEumeLsEk0ontsL2G+GUBNKTDfoebglqTx7iH7DxyvXVw9dAeP1BcyE7HABS5HEHNbwCH021MbIMrzlQYqj+x3Hh4LYj7Rkkp4OBWfYfYRMp6/KNi0T3k1/eS6vUrQWNHdhgX3MesXpMMH93KL4ajMB5tlf/5feNRPtM2htkEaN08Q+YZAtYxm8hn2sb+hgF+A8fT7/CxquCOAAAAAElFTkSuQmCC',
            'url'         => 'http://www.php-fig.org/psr/',
            'tags'        => [
                'dev',
                'php',
            ],
            'description' => null,
            'dateCreated' => 1466013084,
            'public'      => null,
        ],
        [
            'name'        => 'php - Best practices to test protected methods with PHPUnit - Stack Overflow',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABXklEQVQ4jbWQsUsCYRjGn/fuSu/Sk3ALmlzNtoagKRqSaHMKGkKhEOV0KWispSXPQaglAnNobOgfaCyIcgicmxO9zFPv/N5WwTs5gt7x+5739/2eDwgw/bK67HcnBQG4Ag3L0LJ/BoBFDuDzTiGUCAywDC3bNbRtANCrwxaBziRZanAGcjADwR8AX1uGesEZyFGzXwO43VsKn07GaJa5lY/GMefUAYooEvaELDnCEW9M2I1V7GdPg04hlLAM7dYqqut67ftLNwdpMB5dgRfXdVMgHIFpx9egfbwYk0eDA2LKAWJMkK6cUOhOGdkpZmoQiy29OmwFq1AKb5CgQyakAXqQJKpELn/eJzPK1JKhPhHjk4EmMzUVmU/coVLkeXff672pk155YXUsxikCJQFeYVCSgCiAV920N311b+r37FslH413S+qaV86rggfIBbG38RRAN+2ZHzsTMKvGv80vvziHGAusG84AAAAASUVORK5CYII=',
            'url'         => 'http://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit/2798203#2798203',
            'tags'        => [
                'dev',
                'php',
            ],
            'description' => null,
            'dateCreated' => 1466013093,
            'public'      => null,
        ],
        [
            'name'        => 'Welcome :: CheckiO',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACRElEQVQ4jZ2Tz0tUURiGn3PO3Bnn6kjTkGREIYESYSBBZJvAoiIdbNFEmwiEDPoPBInZhAlBRfRjmZsWSosIAimC0CDCRW0iyHRRUDE249yZO869c889LcZM0xL6duc93/t+B87zwf9WNisBsUoxYlnczLlJjzECjFinZzJqzfnC9QOMPt3JSvODmV4evkv/HmTqT1xnHDnOmeFHjDzO8+TTqbrZILj/+jmpRA9W5DYLn69y8dj3FVM6a9MoT2NFBvH9I+zaDYe7a2D66gE3pztQcoZEg6JlaxytZ4nGhpgYm6LCOZQYQEb2UwugualEz1GJEjY1fTICgBQnsBNN1LwyruvilNqYnx3DDYqoaCuhAd81xO0lursllmok0BohRD0gGutFoikUazj5CrlcgrKr2NaaQusSoVZ4XkBXlya5JYnnGYQEDBGuveykkDvE4kKV/IJNyw6LPXttQm0whJgwjhCGsuOhjcJ1KzQ0xAm0wBgj+TGXY/7jJBW3EaViOAVJdclHa0VQs4AI1WoVr9JEqZxg/ktIwXGQ0qCk+vXfkst3riDkMEFN0dZeJJlqRmuBDso4i2BCGyElVgzCEJrjeban+gV1HA0Al271A/dIplpp6/AJAo1TiGBFLcIQfK+IEG8w5gXe0jM+TLxdRVxWQjZkYLSDeOIu7Z09+FWfauUbSr0i1JMoNcVQ39xqrv5AdjkkPWhzsO88Sn4lV5nmxtn8WqzHFfveG7LZcB3yG+4BRpAZVxvf/a0y42plH/5RPwGlE+0Z56LIlQAAAABJRU5ErkJggg==',
            'url'         => 'https://checkio.org/',
            'tags'        => [
                'dev',
                'python',
            ],
            'description' => null,
            'dateCreated' => 1466011820,
            'public'      => null,
        ],
        [
            'name'        => 'Welcome to the tox automation project — tox 2.3.2 documentation',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACT0lEQVQ4jWWTO2uUQRSGnzMzuzubZONGlKitEASjFoqCaOcFG8VbtBYL/4J4RxFBBBtBUAQrRa1sRLQVRVG8JCksLDWJScyyi9lkZ+ZY7H7fJniquTG8z3vOK/sOn9QYAiG0AKFdinMFjHU0GnWSKlmJCKqKL5Xw3uNCCKwaXMPqwXXEGAGw1jI18ZPa7G9Gjh6hVCqSkiICIUR8qcTX0TFGx8dxIbRYNbiWTVt30KjXAejrr/D5/Vvqf6Y5cewIzlpCDIgYnLOsXNHHvYeP+PDpE04QUkw06nVeP38CwJ5DI6QYEREmp6a4duMmc7UalUqFqxfPYYyh2ZzHGIPJ2IzJl8vW1trcl2xvrc3fOARUE8459hw83j50DlUlpYT3nju3b5FiBBEWFhZIMeWGO7TtbEqJH9/HARjauAURQUQIIfDi5Sv+zs/jSyV279qJGMkVdT4wxBj58v4NAOs3DCMiGGNYXFzk7v0HzMzOUK0OsGP7to58XY5grWXztp05Z4ZQLBY5c/pUrqBYLJLSUgQBVcUYw9DwltxEVUVVcc5xYP/eZR5o0v89UFUWmk0Ayj09iIA1lmazydkLl5mrzVGp9HP9ykUGBqrLEbIRzVojko10t5XW2CUt7ZYDct42G6SUUIXUae/VS+eJISDG4Kyl1Qqk1FGgqljn8OUessj4cg/WOUCpVqtU+nqJnclsLbYYWNGL956UEs65AtOTv/j28V0nkeBcgZmpCZIKj58+o+BcHqZ2Ej3fRscoe48sjXPG3na/G2ftmp7fZ3H+BzaBF12WwHSWAAAAAElFTkSuQmCC',
            'url'         => 'https://tox.readthedocs.io/en/latest/',
            'tags'        => [
                'dev',
                'python',
            ],
            'description' => null,
            'dateCreated' => 1466012966,
            'public'      => null,
        ],
        [
            'name'        => 'Overview — Sphinx 1.4.4 documentation',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACT0lEQVQ4jWWTO2uUQRSGnzMzuzubZONGlKitEASjFoqCaOcFG8VbtBYL/4J4RxFBBBtBUAQrRa1sRLQVRVG8JCksLDWJScyyi9lkZ+ZY7H7fJniquTG8z3vOK/sOn9QYAiG0AKFdinMFjHU0GnWSKlmJCKqKL5Xw3uNCCKwaXMPqwXXEGAGw1jI18ZPa7G9Gjh6hVCqSkiICIUR8qcTX0TFGx8dxIbRYNbiWTVt30KjXAejrr/D5/Vvqf6Y5cewIzlpCDIgYnLOsXNHHvYeP+PDpE04QUkw06nVeP38CwJ5DI6QYEREmp6a4duMmc7UalUqFqxfPYYyh2ZzHGIPJ2IzJl8vW1trcl2xvrc3fOARUE8459hw83j50DlUlpYT3nju3b5FiBBEWFhZIMeWGO7TtbEqJH9/HARjauAURQUQIIfDi5Sv+zs/jSyV279qJGMkVdT4wxBj58v4NAOs3DCMiGGNYXFzk7v0HzMzOUK0OsGP7to58XY5grWXztp05Z4ZQLBY5c/pUrqBYLJLSUgQBVcUYw9DwltxEVUVVcc5xYP/eZR5o0v89UFUWmk0Ayj09iIA1lmazydkLl5mrzVGp9HP9ykUGBqrLEbIRzVojko10t5XW2CUt7ZYDct42G6SUUIXUae/VS+eJISDG4Kyl1Qqk1FGgqljn8OUessj4cg/WOUCpVqtU+nqJnclsLbYYWNGL956UEs65AtOTv/j28V0nkeBcgZmpCZIKj58+o+BcHqZ2Ej3fRscoe48sjXPG3na/G2ftmp7fZ3H+BzaBF12WwHSWAAAAAElFTkSuQmCC',
            'url'         => 'http://www.sphinx-doc.org/en/stable/',
            'tags'        => [
                'dev',
                'python',
            ],
            'description' => null,
            'dateCreated' => 1466012980,
            'public'      => null,
        ],
        [
            'name'        => 'GitHub - lhartikk/ArnoldC: Arnold Schwarzenegger based programming language',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACJElEQVQ4jY1TMWsUQRT+5r3d3Cbe7t3u3hEDdoJgIVieGo1YBixsBIsUtvkHNpaCnaJFUMEihSlEbGxFE8XCRrDWIAqJyd3t3JGcuduZeRa5DUtAk6968/i+733zhlE4hHq9foWZbwG4pkRmAECU2gDw1lr7Qmu9WuarUs2NOH7Onrdw2LQMa8xyO8tuA7BlA07TdM0juvA/cQHj3KdOp3MZgGUAaMTxssc8nxuzOsrzm90s2yDmU6TUtoh0BKhut9t3Rnl+1/O8Mz7z7GSlcnqwt/cKURS1pptNmW42JUmSpfGQKoCp0tBqkTZJkqWCH0VRiyaYFw/uZ+2zcbkDYFAy2AEgAOCcWymaE8yLBOZZALDOjQB0jrGCdevccH9zPEsYPxWU2uz1eutHqbXWP6DUbwCAyAwV0QDUANAxEhBE6uNaSICfAMBK1dI0vX6UOo7jeSaKsD/5F5FSa04EW+22dca8jMPw0r/ESRheZKKnxVlE3lFuzOPRMIeIWN3v93u7ux+IaBBFUasgBkFwlYi2/SD4yEQnSwaPSGv9xa/4T6abzYm6789Vq9WFMAw/K6W2CmKlUtmJoqhRTmNFHmRZ9vXgLyRx/J6IzlnnzotIX2utS/ywkaabTDQFANaY1+0su7G/0TG6WTYHpVaY6LvH/A3ATMngRCE2xtwrxADA5ViDweDNZBDsQamG7/vLw+HwDwDUajVfiZx1wMNOt3u/rPkLJe7aBdfH1TYAAAAASUVORK5CYII=',
            'url'         => 'https://github.com/lhartikk/ArnoldC',
            'tags'        => [
                'dev',
            ],
            'description' => null,
            'dateCreated' => 1466011676,
            'public'      => null,
        ],
        [
            'name'        => 'Are there any worse sorting algorithms than Bogosort (a.k.a Monkey Sort)? - Stack Overflow',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABXklEQVQ4jbWQsUsCYRjGn/fuSu/Sk3ALmlzNtoagKRqSaHMKGkKhEOV0KWispSXPQaglAnNobOgfaCyIcgicmxO9zFPv/N5WwTs5gt7x+5739/2eDwgw/bK67HcnBQG4Ag3L0LJ/BoBFDuDzTiGUCAywDC3bNbRtANCrwxaBziRZanAGcjADwR8AX1uGesEZyFGzXwO43VsKn07GaJa5lY/GMefUAYooEvaELDnCEW9M2I1V7GdPg04hlLAM7dYqqut67ftLNwdpMB5dgRfXdVMgHIFpx9egfbwYk0eDA2LKAWJMkK6cUOhOGdkpZmoQiy29OmwFq1AKb5CgQyakAXqQJKpELn/eJzPK1JKhPhHjk4EmMzUVmU/coVLkeXff672pk155YXUsxikCJQFeYVCSgCiAV920N311b+r37FslH413S+qaV86rggfIBbG38RRAN+2ZHzsTMKvGv80vvziHGAusG84AAAAASUVORK5CYII=',
            'url'         => 'http://stackoverflow.com/questions/2609857/are-there-any-worse-sorting-algorithms-than-bogosort-a-k-a-monkey-sort',
            'tags'        => [
                'dev',
            ],
            'description' => null,
            'dateCreated' => 1466011763,
            'public'      => null,
        ],
        [
            'name'        => 'OpenClassrooms, MOOCs and courses open for all',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAADBElEQVQ4jb2TW0hTcRzHf/9zNp27uM3tzM2ZObwMybA0MrWbiTUkwojCLH0wsaRQyUBIi5GSLwlmD2VQT0FREIZd6AKtpUXiCou8K5o5dbo2j+64c87O+feU2INPQZ+378vn4cv3C/CPoLXhvT49AyFU9UYxVp1GKeKzY+U1WCRbjE8Gv60nkAAAXDJTxwgCdwGLQzwm62DCT1sSohgMIEjJkI+5dTAryPCS8WsLrm1uF7NWQNopSoklqBAL2F3UnLKYdN8xtdNs6Ohf4ETb48JnygKrwI94rwRnhAJPD3MzTS0xZWsiFt7SgWkAANLBMJyTDjiet+wrEQUcuvp0ZHS3ShEccnvuH63Z4RQxKJpKX1KiPvztnjuZ2uQEBVaEo+0b5nmNk2Y+SwLtBXflLK5kQFz82D1b1hBLEWczI0cIrO6m7w2c7L/hj9cZlMlRSRoNgTAdgQQ2QiRCSjGs6ENWgkNCEGQjqupkAaC9wUwdRIDipATRJ4j4y+TjHwAh5X5bivXcxjwDz73/0RrsmUpQD4p0DmfMtRgCtQgAYO5I4mUSiIe6zcXDy9Ef9KrKV556s/48AnRxaHo++hGAAABwFIC80ZL/Qp1K8dIUKqdp14N+EgCg1qqXC4AXyXSuEBHEO/t12wuVl9HoKbm//vtc55/G+wFwGTJlBoeXRDTh9pkStV6iW7N141iXsm3SqQIgiWdkYlRrkGbrjCbFhpzdMZbeigz1H4HHvlfJ0SEzP8spuK+eOMogl6wOyR4TIw8hviGvelPbm9aBTITEjvTtOusBW+IDfsBzgQ9yojw9tlmWHy9lfrJ032FX7utwd+OqALdnSF86QsldTvdxDNBXXpGaq6dk8yvOyTxVadoUS4N0sH7UOJkhzEabZNyWmEjt84fjJcTqpk+7+APWwwOAcQ8AkimxwHATfvMvf5Cj51gh4MXCIs1yvjGfsDyztBKmJRuLXcMLf31hLXOHLNEskpTf7vWf2MWbZngkRH6SzstPndl0R6eT3lNVvvKs+7D/ym//plTn6CKKEQAAAABJRU5ErkJggg==',
            'url'         => 'https://openclassrooms.com/',
            'tags'        => [
                'mooc',
            ],
            'description' => null,
            'dateCreated' => 1466011755,
            'public'      => null,
        ],
        [
            'name'        => 'Coursera',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACI0lEQVQ4jc2SzUtUYRTGn/O+79yZO+pM3cAyWkQELoYWFhWYi2JSITAUmhYtqm2LaiOVVHTJIE2CoEUIbdoOGIFWkIlSZtKqD9wFEVSQ5TiOo3fu13vaTM6M/gF1Vuc5P86Bc84D/D+RycoabduinBFsFrWsoqm6ftieVL4ZMRPfCt7z+8fcarb7/LPo1h27jLzz0Z2zT3o1A1L2nNEUL1wXLLoA3gnwPDO/ypWMCwZ+xxrim20wd4CwjYDvWtCYX1ztn7KPFGnf8HDEWkyNRBONXTrw4DsFmFYTnIUf07lStNMyvelovdWiAw+B50BF6yCUgVLh58RiKX9cJXOpMypW3+UVcwHr8I7WGHOWfh3wSY5Ypnct2rClxV1ecFjjBrOeZT9/lJS6FIkl0hbTaSWI9spYPAzc4vj4lbar5dXetg59aIzolXPad8Gsb77saxsqs9ftAzP7pRHrDEoraSEAsA4FQVrVn4iHxVtGXTLpl4pfQ2C0ck4mEBJgBhG71H57JiMMIwtm6MB7yqApYm6GoLPKMJXvrj4gIA3QJIBPANIkZQ8JidAPugkA2gfe3IvEExelMsBggATAgLM0/4iIP5ubtveDNXQYQEiFwHXgOct3J/oO9a75oGNw9gQJ0aPDYI9QkS8aenS89+BDANQx+O4UJHVz4DULZbzn0H/84nLrk/U+wl9PbCiusWw1W9ecyUqAqSJZ1rJyAzNtsP0/jT96ceveE5d6tQAAAABJRU5ErkJggg==',
            'url'         => 'https://www.coursera.org/',
            'tags'        => [
                'mooc',
            ],
            'description' => null,
            'dateCreated' => 1466011780,
            'public'      => null,
        ],
        [
            'name'        => 'The Linux Kernel Archives',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACdUlEQVQ4jZVSTUhUURg9975nb35y/JnxJ5tkMlMzEhmjv0VYGhkiLmJESqNFqyJaFLUSxlWtQiSCCIu20WKgCFxJYomGxGAJzaQVmYJkRfnm571779fCGVMyo7P5Fvec7/vOdy6wMep0XT8cDof5P3hrwDL1MgDTYRgpn6/oKQDP/zTRysu3TTpzfRRs2J/2+7cSgLPZt9VE/Q8pgYGBt7Z18N3+BLl9VTQyHpcDd28HiIgzxrBhA+oFY4Daqd//eaElgblZYkNz+ZphbC5FL1sesQrrHCcMADKl1erR1x6m57fzXXtPksvtOsHCyAWgNvLOAcDr9XaPjkXl/OdZYUmihcUfts/nJQB9GR5bV01EHEBZY2PjAimppFIimTApHo/J011dAoAE0PS37TmFwT0eR8/g4CAREdm2rYQQSgihhoef2YWFBaTr2lBGvHYLopAGIG97ZXBaCEulUilhmglFRJKIaMlMq5rqagUgCaA6ayWbAmfsobp6igXdxaLCEjlgZPJ0Og2Xy8lBBJGIwZKA0+HGji2mMTmD34lSGHz+CVrVy9IJigfo0cA58eHTF2VZaWlZFllCKPPVUdlSB/vBjSJJ0ZLOrA4AMH0Necnxku/0Jkg0ddAevQd1q/+6pAzMFMlYpEbSWK6gqT1Eb4Pv0hP+upVLRh0wOIQLLgFA6gcOVbDQvkk+8nwMkUgE3R3t/NviR47SWg3QkRSWYFqOYyXPUAibLh3BeYOz5oJCd31xEcoij5dmztzUhgFpAfC96NOOByrdzth7+07XxWTPLPB1va9gVABV/R1o66x3BJbTCfOGhjbXlWY09x5DU3Zo1v8v0xEfb77i9asAAAAASUVORK5CYII=',
            'url'         => 'https://www.kernel.org/',
            'tags'        => [
                'linux',
                'unix os',
                'other stuff',
            ],
            'description' => null,
            'dateCreated' => 1466011739,
            'public'      => null,
        ],
        [
            'name'        => 'Cozy - Simple, versatile, yours',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACeElEQVQ4jX1TW0hUURRd+8yZuaPOdQxNiSiipAdjICISNhBFVIIRiBoYRP9BSSBFBXPnoyj666O+AoOEmMmpNBUKHSQRiTCDKYqeX6KBzuOa4zzu2X3M+NbW1zn77LX3WntzgI1gsFh1Z6Z1sTzkuggzgUgBAB4nSt1SqThRFADn33jzAvmEPU/jDXA6L1E6tUMxVFn3wg9rIen/TTSxtgitIAsQqf2BeBsT34bNfnlfeeFQZDIqSMhWCe7IZLjt51f3eM5mXiUAoIVtee/yYCgeORCarVrrbG9g5mxVKBbeYE5MAFD9PFpS22c+rHkZ688lhJftBXIN6nvjX04MzXVUPpkpXrQsAOL6vsQFTWLEoWkuAXULzAQML0tsJQsA0hbfTMBRXVpMo95XsRYQMR0eiDaRwh3Fsmm0UY9sspVVkz/UG6uRQnURc7vUiK6RxMXBk3oEYZYY9qvKunP27++6MjAMBSL2BNjx6TOyeb4YO03jx15Hr5OiG9QwGP0l55Oe3sZtSfj9BMNQx9/Mep02WafY6ibBuhDijFOlHwWPlk8BTDD85K1td+savxd2sJovcBW0BIMCPh8DTFn5cYyt9IAg4UGWt3Mi2xkcfvBnkWz4fCgpyBZKwRlqHoq+gA0Tz45sMdb5/w+aw7P3FKOC2t7GdrNl9ZBAyGXZ7yfT88lpAG6HoFSCCADcu8rU9NQ0KgDAVVRkqcwVZpxKWdxIAHB+ZHKnUtpdaYOHhC3DSoFZ5UZPAEGAAGYiAitpKf4gNefVzjrXFK1cU0P/t+KS8gqHjjmYJqDrLphmTrKuAyaAvwupVI93q7m04qXDJt91QzCLRfI/LI8pZq5PEwYAAAAASUVORK5CYII=',
            'url'         => 'https://cozy.io/en/',
            'tags'        => [
                'self-hosting',
            ],
            'description' => null,
            'dateCreated' => 1466011652,
            'public'      => null,
        ],
        [
            'name'        => 'Framasoft ~ Page portail du réseau',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABqklEQVQ4jaWTz0vTYRzHX+/vKnOpEHWpCApslwaVs0GHIpDIykNdkoRunrQoO4TtD7CuHbY/oCCY0C3rpAQdCnQRhhUlEYqyGKMi5MsyeXvYRmv5DaL36YH383k9nx/PRzRpuH8sYWvAJiWRArApSBQkP8jmM+8b7+vX0Rruv33N1hjQ2gyuKZScyeZv3QW5AWANXbzzCDgbEdisx7nx0T6QY9W0W66Dru7r3MXJM91s39HB8mIJ21GAA+nks6/Tc5MvVKv5VT1tSVweOsfuvTt5eG+KD28WoiCh5MOBrYHGmm1zPzdBpbLK4I3zbGnZHAVotXUpsKudbpRtnk/N0tYep/fCschG2HQH9VE16/XLeWw42NUZCZBIBVHmyveQtZ9rtHfEIwEAgU0hyix9/kJ821baIiA2hUCKBjx9MkNsU4zjp45s6EvMxNLJnmXQIPBHuxc+FsFw4nQX5dI3ikvlRjuUfCU2PTdZTid7VkC9G70y/3aRd7OfOHQ0wf7EHopLZX5UVpF8M5vPTPz3V65NQc6Nj/ZJHgHCvwSGkkfqwfDbNlb1r+u8Dmi/rn7y/d+2AAAAAElFTkSuQmCC',
            'url'         => 'https://framasoft.org/',
            'tags'        => [
                'self-hosting',
            ],
            'description' => null,
            'dateCreated' => 1466011661,
            'public'      => null,
        ],
        [
            'name'        => 'GitHub - shaarli/Shaarli: The personal, minimalist, super-fast, database free, bookmarking service - community repo',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAACJElEQVQ4jY1TMWsUQRT+5r3d3Cbe7t3u3hEDdoJgIVieGo1YBixsBIsUtvkHNpaCnaJFUMEihSlEbGxFE8XCRrDWIAqJyd3t3JGcuduZeRa5DUtAk6968/i+733zhlE4hHq9foWZbwG4pkRmAECU2gDw1lr7Qmu9WuarUs2NOH7Onrdw2LQMa8xyO8tuA7BlA07TdM0juvA/cQHj3KdOp3MZgGUAaMTxssc8nxuzOsrzm90s2yDmU6TUtoh0BKhut9t3Rnl+1/O8Mz7z7GSlcnqwt/cKURS1pptNmW42JUmSpfGQKoCp0tBqkTZJkqWCH0VRiyaYFw/uZ+2zcbkDYFAy2AEgAOCcWymaE8yLBOZZALDOjQB0jrGCdevccH9zPEsYPxWU2uz1eutHqbXWP6DUbwCAyAwV0QDUANAxEhBE6uNaSICfAMBK1dI0vX6UOo7jeSaKsD/5F5FSa04EW+22dca8jMPw0r/ESRheZKKnxVlE3lFuzOPRMIeIWN3v93u7ux+IaBBFUasgBkFwlYi2/SD4yEQnSwaPSGv9xa/4T6abzYm6789Vq9WFMAw/K6W2CmKlUtmJoqhRTmNFHmRZ9vXgLyRx/J6IzlnnzotIX2utS/ywkaabTDQFANaY1+0su7G/0TG6WTYHpVaY6LvH/A3ATMngRCE2xtwrxADA5ViDweDNZBDsQamG7/vLw+HwDwDUajVfiZx1wMNOt3u/rPkLJe7aBdfH1TYAAAAASUVORK5CYII=',
            'url'         => 'https://github.com/shaarli/Shaarli',
            'tags'        => [
                'self-hosting',
            ],
            'description' => null,
            'dateCreated' => 1466012934,
            'public'      => null,
        ],
        [
            'name'        => 'ownCloud.org',
            'image'       => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAC2ElEQVQ4jW2TS2hdVRSGv7XPud7cvBrbmMQ0NyZtIokltVgbFUuiNgUtGWhBKtiOHAh2kI50VOhA6NSJOBacxEkmHRTFFDKoz0pbk9IohYrEPBriI7nnpvfcs34H96Y+cLNhb/Ze++ffa63PeobHBi3KfSizl5ACgJkZ/zMkiVqAmzSrLD0btXQNTIcod1xy1d9aXYQQApKQhJn9LWymEOUGHIatZ2SiWpcPZmYhBCFZUt4mrVZpLBSI4wh3B5CZmWqKDhAbRFLtwt21uVUyM2P0qREeK3Yzd/Vbfv9jk0JDnmrmJkl1JwGwuHaAuUtNjQU7Nv4s3Z2PcOG9d8jnH2Lh9k+8euYcK6vrtO1qYcfBzhq1duy7EMcRpVJi488f4eL5KQb29dLZsYfl1XXy+Tz9vd08MbSfG/OL1LNr9bxYHEJge7vC/UpKX7Gbza2EO3d/oVy+T/vuNippyuD+Pt58fZKN3/7kg48+ptjTjZkhiThJyvT17uXQyBDvnnuL1uYm1u5tcPDAIIWGBgDStMrs3NecOD7Gw22tfPLpJZJymTiO4OiJM1peuadbi3dUqVS0tr6ha9cXJElpmipNU7m7bswvqpQkkqTpmcsq7H1aXcMvKJycnKCrs51cLuaba/Nc/+E2O+V2F+56YHerVKZSSTk2/gxTb5+m+GgX8c2FHwEY6O9laXmVF4+O8uvKGkl5m8ZC7QtJeZssczradwOwfGedi+eneL+xAet4fMxPvfayPXfkSc1d/c5GDx/k+5u3uPvzEm+cfAUB0zOXaSoUOH1qkqXlVT6b/VKHDx2wmUufy4ojE9oqJaqXRoDl4pjMHUkgCFEAIAQjy1xmWKVSVVNjwWJB1trSjOqtXGfmPzzpwTTDJNTSHDxzJ0i6IkLkkmdZJnc3SWRZhrvj7mSZ4zWozN3lkrsscvcr0a49xa+AIcz6gR0S/+VgZ/8PnIVnX5ClZ/8Ce+CJ7pbOimUAAAAASUVORK5CYII=',
            'url'         => 'https://owncloud.org/',
            'tags'        => [
                'self-hosting',
            ],
            'description' => null,
            'dateCreated' => 1466013448,
            'public'      => null,
        ],
    ];
    // phpcs:enable

    /**
     * @var NetscapeBookmarkDecoder|null
     */
    private $decoder;

    /**
     * Parse flat Chromium bookmarks (no directories).
     */
    public function testParseFlat(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/chromium_flat.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_1, $result);
    }

    /**
     * Parse nested Chromium bookmarks (directories and subdirectories).
     */
    public function testParseNested(): void
    {
        $content = \file_get_contents(self::FIXTURE_DIRECTORY . 'input/chromium_nested.htm');
        $result = $this->decoder->decode($content);

        $this->assertSame(self::EXPECTED_2, $result);
    }

    // --------------------------------------------------
    // Setup / Tear Down
    // --------------------------------------------------

    protected function setUp(): void
    {
        $this->decoder = new NetscapeBookmarkDecoder();
    }

    protected function tearDown(): void
    {
        $this->decoder = null;
    }
}

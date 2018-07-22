<?php

namespace Tests\TestCase;

use DataMapper\Aggregation\ArrayAggregation;
use DataMapper\Aggregation\Specification\IncrementValueSpecification;
use PHPUnit\Framework\TestCase;

/**
 * Class DataAggregationTest
 */
class DataAggregationTest extends TestCase
{
    /**
     * @param array $raw
     * @param int   $expectedKills
     * @dataProvider rawDataProvider
     */
    public function testRawAggregation(array $raw, int $expectedKills): void
    {
        $summonerId = $raw['summoner_id'];
        $aggregate = new ArrayAggregation();
        $keys = ['season'];
        $valuesKeys = ['kills'];
        $aggregate->registerKeys($keys, function (array $game): array {
            return [$game['season_id']];
        });
        $aggregate->registerValues($valuesKeys, function (array $game) use ($summonerId) {
            $kills = 0;

            foreach ($game['summoners'] as $player) {
                if ($player['summoner_id'] === $summonerId) {
                    $kills = $player['kills'];
                }
            }

            return [$kills];
        });
        $result = $aggregate->aggregate($raw['games'], IncrementValueSpecification::create());
        $this->assertEquals($expectedKills, end($result)['values']['kills']);
    }

    /**
     * @return array
     */
    public function rawDataProvider(): array
    {
        return [
            [
                [
                    'summoner_id' => 777777,
                    'account_id' => 8888,
                    'server' => 99999,
                    'games' => [
                        [
                            'game_id' => 1876754467,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 66787105,
                                    'account_id' => 223802142,
                                    'name' => 'Gok Sonu',
                                    'champion_id' => 141,
                                    'win' => true,
                                    'kills' => 0,
                                    'deaths' => 7,
                                    'assists' => 10
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 71047809,
                                    'account_id' => 228056776,
                                    'name' => 'iustitare1',
                                    'champion_id' => 157,
                                    'win' => true,
                                    'kills' => 7,
                                    'deaths' => 3,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 69326823,
                                    'account_id' => 225991113,
                                    'name' => 'onutzftw',
                                    'champion_id' => 74,
                                    'win' => true,
                                    'kills' => 25,
                                    'deaths' => 6,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70697171,
                                    'account_id' => 227355288,
                                    'name' => 'RojberEasy',
                                    'champion_id' => 35,
                                    'win' => true,
                                    'kills' => 0,
                                    'deaths' => 2,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 66825849,
                                    'account_id' => 223776980,
                                    'name' => 'mimilando',
                                    'champion_id' => 17,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 0,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70286939,
                                    'account_id' => 226909560,
                                    'name' => 'dotijan buda',
                                    'champion_id' => 76,
                                    'win' => false,
                                    'kills' => 6,
                                    'deaths' => 3,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 7,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 18,
                                    'win' => false,
                                    'kills' => 8,
                                    'deaths' => 13,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 68106966,
                                    'account_id' => 224485537,
                                    'name' => 'ziadforfeed',
                                    'champion_id' => 53,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 3,
                                    'assists' => 8
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 69013131,
                                    'account_id' => 225298801,
                                    'name' => 'the troler12',
                                    'champion_id' => 86,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 10,
                                    'assists' => 3
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1854459222,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70716790,
                                    'account_id' => 227420756,
                                    'name' => 'MeineKleineSmurf',
                                    'champion_id' => 201,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 1,
                                    'assists' => 16
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 66433417,
                                    'account_id' => 223522381,
                                    'name' => 'MARIUSH96',
                                    'champion_id' => 202,
                                    'win' => true,
                                    'kills' => 3,
                                    'deaths' => 5,
                                    'assists' => 10
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70763509,
                                    'account_id' => 227569049,
                                    'name' => 'Krystek1122',
                                    'champion_id' => 86,
                                    'win' => true,
                                    'kills' => 18,
                                    'deaths' => 1,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 36783908,
                                    'account_id' => 200475732,
                                    'name' => 'Patryk1122rt35',
                                    'champion_id' => 11,
                                    'win' => true,
                                    'kills' => 10,
                                    'deaths' => 2,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70693791,
                                    'account_id' => 227277229,
                                    'name' => 'Lovekasie',
                                    'champion_id' => 21,
                                    'win' => true,
                                    'kills' => 1,
                                    'deaths' => 5,
                                    'assists' => 12
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 111,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 8,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 4,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 23,
                                    'win' => false,
                                    'kills' => 5,
                                    'deaths' => 9,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 45,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 7,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70323594,
                                    'account_id' => 226736278,
                                    'name' => 'SCORT CCC',
                                    'champion_id' => 32,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 8,
                                    'assists' => 4
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1854432738,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 111,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 2,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70253556,
                                    'account_id' => 226737838,
                                    'name' => 'jkonegin',
                                    'champion_id' => 420,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 9,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 6,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 23,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 6,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 45,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 8,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 47723437,
                                    'account_id' => 210756951,
                                    'name' => 'TheMistaker',
                                    'champion_id' => 143,
                                    'win' => true,
                                    'kills' => 3,
                                    'deaths' => 1,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70587855,
                                    'account_id' => 227470787,
                                    'name' => 'Kaszyr',
                                    'champion_id' => 86,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 0,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70707821,
                                    'account_id' => 227471592,
                                    'name' => '102kg 102IQ 25cm',
                                    'champion_id' => 32,
                                    'win' => true,
                                    'kills' => 0,
                                    'deaths' => 2,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 69037097,
                                    'account_id' => 225491496,
                                    'name' => 'Airarret',
                                    'champion_id' => 103,
                                    'win' => true,
                                    'kills' => 6,
                                    'deaths' => 3,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 24524318,
                                    'account_id' => 29039106,
                                    'name' => 'Deadlinee',
                                    'champion_id' => 67,
                                    'win' => true,
                                    'kills' => 18,
                                    'deaths' => 1,
                                    'assists' => 1
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1854396739,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70584668,
                                    'account_id' => 227315900,
                                    'name' => 'SheGotPregnatXXX',
                                    'champion_id' => 121,
                                    'win' => true,
                                    'kills' => 6,
                                    'deaths' => 1,
                                    'assists' => 8
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70773675,
                                    'account_id' => 227388934,
                                    'name' => 'chatniboyxxx',
                                    'champion_id' => 22,
                                    'win' => true,
                                    'kills' => 5,
                                    'deaths' => 3,
                                    'assists' => 19
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 65937940,
                                    'account_id' => 223373405,
                                    'name' => 'donkeymonkey1234',
                                    'champion_id' => 45,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 4,
                                    'assists' => 11
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70854838,
                                    'account_id' => 227634656,
                                    'name' => 'd1ll3rd4ll3r',
                                    'champion_id' => 21,
                                    'win' => true,
                                    'kills' => 22,
                                    'deaths' => 1,
                                    'assists' => 12
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 52430550,
                                    'account_id' => 216192118,
                                    'name' => 'xXxtruckyoshixXx',
                                    'champion_id' => 53,
                                    'win' => true,
                                    'kills' => 1,
                                    'deaths' => 0,
                                    'assists' => 26
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 8,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70253556,
                                    'account_id' => 226737838,
                                    'name' => 'jkonegin',
                                    'champion_id' => 86,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 11,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 5,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 19,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 7,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 45,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 7,
                                    'assists' => 3
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1852885916,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 17,
                                    'assists' => 14
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 6,
                                    'deaths' => 19,
                                    'assists' => 13
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70629106,
                                    'account_id' => 227527201,
                                    'name' => 'marksmen suck',
                                    'champion_id' => 21,
                                    'win' => false,
                                    'kills' => 30,
                                    'deaths' => 11,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 68556723,
                                    'account_id' => 224949850,
                                    'name' => 'BooperDooperGG',
                                    'champion_id' => 78,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 15,
                                    'assists' => 13
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70654373,
                                    'account_id' => 227304287,
                                    'name' => 'SpongeBob5240',
                                    'champion_id' => 19,
                                    'win' => false,
                                    'kills' => 13,
                                    'deaths' => 20,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70658727,
                                    'account_id' => 227508414,
                                    'name' => 'ReiY1',
                                    'champion_id' => 51,
                                    'win' => true,
                                    'kills' => 23,
                                    'deaths' => 9,
                                    'assists' => 19
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70873939,
                                    'account_id' => 227587743,
                                    'name' => 'KenDuk',
                                    'champion_id' => 53,
                                    'win' => true,
                                    'kills' => 6,
                                    'deaths' => 8,
                                    'assists' => 29
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70706884,
                                    'account_id' => 227425857,
                                    'name' => 'KeisukeTakahashi',
                                    'champion_id' => 77,
                                    'win' => true,
                                    'kills' => 32,
                                    'deaths' => 8,
                                    'assists' => 17
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70844576,
                                    'account_id' => 227621717,
                                    'name' => 'Papru00f8',
                                    'champion_id' => 58,
                                    'win' => true,
                                    'kills' => 18,
                                    'deaths' => 9,
                                    'assists' => 18
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 69265819,
                                    'account_id' => 225937369,
                                    'name' => 'Provexo',
                                    'champion_id' => 4,
                                    'win' => true,
                                    'kills' => 3,
                                    'deaths' => 17,
                                    'assists' => 13
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1852859409,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 69087503,
                                    'account_id' => 225772061,
                                    'name' => 'Norriz1337',
                                    'champion_id' => 56,
                                    'win' => true,
                                    'kills' => 13,
                                    'deaths' => 3,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => true,
                                    'kills' => 8,
                                    'deaths' => 3,
                                    'assists' => 13
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 40,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 3,
                                    'assists' => 10
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70659109,
                                    'account_id' => 227526939,
                                    'name' => 'eZzCov3rTeZz',
                                    'champion_id' => 157,
                                    'win' => true,
                                    'kills' => 10,
                                    'deaths' => 4,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70784204,
                                    'account_id' => 227602469,
                                    'name' => 'error 0107',
                                    'champion_id' => 103,
                                    'win' => true,
                                    'kills' => 5,
                                    'deaths' => 3,
                                    'assists' => 11
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 54473029,
                                    'account_id' => 217438864,
                                    'name' => 'dabek12',
                                    'champion_id' => 67,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 10,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70653417,
                                    'account_id' => 227259442,
                                    'name' => 'SramNaMatmie',
                                    'champion_id' => 245,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 8,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70616290,
                                    'account_id' => 227400310,
                                    'name' => 'TheYasuoPlayer12',
                                    'champion_id' => 157,
                                    'win' => false,
                                    'kills' => 15,
                                    'deaths' => 11,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70576576,
                                    'account_id' => 227407586,
                                    'name' => 'GochA12',
                                    'champion_id' => 17,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 2,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 61905350,
                                    'account_id' => 221583125,
                                    'name' => 'mentos1300',
                                    'champion_id' => 90,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 7,
                                    'assists' => 2
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1851845157,
                            'zone' => 'eun1',
                            'queue_id' => 430,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 5,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70353220,
                                    'account_id' => 226721303,
                                    'name' => 'sdBeeT',
                                    'champion_id' => 4,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 5,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 4,
                                    'deaths' => 4,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 23,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 6,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70653781,
                                    'account_id' => 227277319,
                                    'name' => 'Sasori Yuka',
                                    'champion_id' => 86,
                                    'win' => false,
                                    'kills' => 1,
                                    'deaths' => 7,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 69386635,
                                    'account_id' => 225975942,
                                    'name' => 'blackmoose1',
                                    'champion_id' => 29,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 0,
                                    'assists' => 6
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70416114,
                                    'account_id' => 227120910,
                                    'name' => 'Tig4r 2k18',
                                    'champion_id' => 245,
                                    'win' => true,
                                    'kills' => 1,
                                    'deaths' => 0,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70708547,
                                    'account_id' => 227503892,
                                    'name' => 'Shadow of Malec',
                                    'champion_id' => 143,
                                    'win' => true,
                                    'kills' => 0,
                                    'deaths' => 3,
                                    'assists' => 11
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70495542,
                                    'account_id' => 227090288,
                                    'name' => 'Reddak99',
                                    'champion_id' => 23,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 2,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70354877,
                                    'account_id' => 226808205,
                                    'name' => 'Su00e9XTaCy72',
                                    'champion_id' => 67,
                                    'win' => true,
                                    'kills' => 20,
                                    'deaths' => 2,
                                    'assists' => 1
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1850293983,
                            'zone' => 'eun1',
                            'queue_id' => 420,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70637604,
                                    'account_id' => 227461507,
                                    'name' => 'bronz its live',
                                    'champion_id' => 21,
                                    'win' => false,
                                    'kills' => 15,
                                    'deaths' => 5,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 9,
                                    'assists' => 13
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70253556,
                                    'account_id' => 226737838,
                                    'name' => 'jkonegin',
                                    'champion_id' => 86,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 13,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 1,
                                    'win' => false,
                                    'kills' => 4,
                                    'deaths' => 6,
                                    'assists' => 8
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70513295,
                                    'account_id' => 226976278,
                                    'name' => 's10nick',
                                    'champion_id' => 40,
                                    'win' => false,
                                    'kills' => 4,
                                    'deaths' => 8,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70483087,
                                    'account_id' => 226966623,
                                    'name' => 'Tedara90',
                                    'champion_id' => 86,
                                    'win' => true,
                                    'kills' => 1,
                                    'deaths' => 7,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70637093,
                                    'account_id' => 227436997,
                                    'name' => 'oWaRnInGo',
                                    'champion_id' => 23,
                                    'win' => true,
                                    'kills' => 17,
                                    'deaths' => 5,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70667198,
                                    'account_id' => 227437344,
                                    'name' => 'TrollGamerXD2003',
                                    'champion_id' => 22,
                                    'win' => true,
                                    'kills' => 5,
                                    'deaths' => 4,
                                    'assists' => 11
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70588771,
                                    'account_id' => 227512735,
                                    'name' => 'PanGrzybek2115',
                                    'champion_id' => 51,
                                    'win' => true,
                                    'kills' => 8,
                                    'deaths' => 11,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70293465,
                                    'account_id' => 226731612,
                                    'name' => 'Kamimui',
                                    'champion_id' => 11,
                                    'win' => true,
                                    'kills' => 10,
                                    'deaths' => 1,
                                    'assists' => 9
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1849701984,
                            'zone' => 'eun1',
                            'queue_id' => 420,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70609193,
                                    'account_id' => 227538853,
                                    'name' => 'VaIIey',
                                    'champion_id' => 21,
                                    'win' => true,
                                    'kills' => 8,
                                    'deaths' => 17,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 65946003,
                                    'account_id' => 223326551,
                                    'name' => 'Luigi The Man',
                                    'champion_id' => 115,
                                    'win' => true,
                                    'kills' => 8,
                                    'deaths' => 17,
                                    'assists' => 7
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 36,
                                    'win' => true,
                                    'kills' => 5,
                                    'deaths' => 12,
                                    'assists' => 10
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70253556,
                                    'account_id' => 226737838,
                                    'name' => 'jkonegin',
                                    'champion_id' => 22,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 22,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 23,
                                    'win' => true,
                                    'kills' => 19,
                                    'deaths' => 13,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70025313,
                                    'account_id' => 226587589,
                                    'name' => 'lRegretl',
                                    'champion_id' => 103,
                                    'win' => false,
                                    'kills' => 12,
                                    'deaths' => 11,
                                    'assists' => 15
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70638976,
                                    'account_id' => 227529558,
                                    'name' => 'TSM Starter',
                                    'champion_id' => 56,
                                    'win' => false,
                                    'kills' => 31,
                                    'deaths' => 4,
                                    'assists' => 8
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 68383318,
                                    'account_id' => 224538114,
                                    'name' => 'kamkilz',
                                    'champion_id' => 111,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 9,
                                    'assists' => 6
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70616225,
                                    'account_id' => 227396531,
                                    'name' => 'xMufix',
                                    'champion_id' => 114,
                                    'win' => false,
                                    'kills' => 6,
                                    'deaths' => 11,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70708347,
                                    'account_id' => 227495125,
                                    'name' => 'aleksavulke',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 30,
                                    'deaths' => 7,
                                    'assists' => 9
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1849019603,
                            'zone' => 'eun1',
                            'queue_id' => 420,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 56,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 6,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 62844416,
                                    'account_id' => 221886417,
                                    'name' => 'ram2004',
                                    'champion_id' => 86,
                                    'win' => false,
                                    'kills' => 5,
                                    'deaths' => 5,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70335539,
                                    'account_id' => 226845147,
                                    'name' => 'QAshick',
                                    'champion_id' => 22,
                                    'win' => false,
                                    'kills' => 7,
                                    'deaths' => 5,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 45104828,
                                    'account_id' => 208214749,
                                    'name' => '1X0xMurderx0X1',
                                    'champion_id' => 13,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 8,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70616670,
                                    'account_id' => 227419233,
                                    'name' => 'woodadventure',
                                    'champion_id' => 25,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 6,
                                    'assists' => 8
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70396793,
                                    'account_id' => 227158327,
                                    'name' => 'VaNu44',
                                    'champion_id' => 103,
                                    'win' => true,
                                    'kills' => 7,
                                    'deaths' => 5,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70703883,
                                    'account_id' => 227283764,
                                    'name' => 'RupSplinaInVoi',
                                    'champion_id' => 86,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 5,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70496028,
                                    'account_id' => 227116844,
                                    'name' => '2k17ADClovee',
                                    'champion_id' => 81,
                                    'win' => true,
                                    'kills' => 6,
                                    'deaths' => 5,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70445991,
                                    'account_id' => 227116793,
                                    'name' => 'MONSTERKILL88',
                                    'champion_id' => 63,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 3,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70627623,
                                    'account_id' => 227457968,
                                    'name' => 'dark101angel',
                                    'champion_id' => 22,
                                    'win' => true,
                                    'kills' => 9,
                                    'deaths' => 2,
                                    'assists' => 6
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1848479874,
                            'zone' => 'eun1',
                            'queue_id' => 420,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 66723911,
                                    'account_id' => 223633185,
                                    'name' => 'SORka13',
                                    'champion_id' => 80,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 6,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 103,
                                    'win' => false,
                                    'kills' => 3,
                                    'deaths' => 8,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70464915,
                                    'account_id' => 227055805,
                                    'name' => 'Kiramuno',
                                    'champion_id' => 157,
                                    'win' => false,
                                    'kills' => 5,
                                    'deaths' => 10,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 57185882,
                                    'account_id' => 219240288,
                                    'name' => 'AtaraxiaM',
                                    'champion_id' => 25,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 3,
                                    'assists' => 2
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 65935042,
                                    'account_id' => 223307180,
                                    'name' => 'gorrila1',
                                    'champion_id' => 21,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 6,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70285724,
                                    'account_id' => 226849865,
                                    'name' => 'Zloco95',
                                    'champion_id' => 11,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 1,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70284659,
                                    'account_id' => 226796118,
                                    'name' => 'PacoSKy',
                                    'champion_id' => 161,
                                    'win' => true,
                                    'kills' => 9,
                                    'deaths' => 5,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70254642,
                                    'account_id' => 226796035,
                                    'name' => 'iBlastSKy',
                                    'champion_id' => 222,
                                    'win' => true,
                                    'kills' => 10,
                                    'deaths' => 2,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 66464594,
                                    'account_id' => 223548112,
                                    'name' => 'BrokenTrynda',
                                    'champion_id' => 34,
                                    'win' => true,
                                    'kills' => 6,
                                    'deaths' => 2,
                                    'assists' => 9
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 64944132,
                                    'account_id' => 222767568,
                                    'name' => 'Gynlowd',
                                    'champion_id' => 25,
                                    'win' => true,
                                    'kills' => 4,
                                    'deaths' => 4,
                                    'assists' => 2
                                ]
                            ]
                        ],
                        [
                            'game_id' => 1847749574,
                            'zone' => 'eun1',
                            'queue_id' => 420,
                            'season_id' => 10,
                            'summoners' => [
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 42496324,
                                    'account_id' => 205537232,
                                    'name' => 'ZelougeLp',
                                    'champion_id' => 1,
                                    'win' => false,
                                    'kills' => 0,
                                    'deaths' => 13,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70696725,
                                    'account_id' => 227418612,
                                    'name' => 'TIK7TAK',
                                    'champion_id' => 21,
                                    'win' => false,
                                    'kills' => 2,
                                    'deaths' => 7,
                                    'assists' => 5
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70686893,
                                    'account_id' => 227429302,
                                    'name' => 'Ksmaster45',
                                    'champion_id' => 105,
                                    'win' => false,
                                    'kills' => 13,
                                    'deaths' => 8,
                                    'assists' => 4
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 70628254,
                                    'account_id' => 227486622,
                                    'name' => 'SOURPOTATO12',
                                    'champion_id' => 17,
                                    'win' => false,
                                    'kills' => 14,
                                    'deaths' => 3,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 100,
                                    'summoner_id' => 777777,
                                    'accountId' => 8888,
                                    'name' => 'Creado man',
                                    'champion_id' => 103,
                                    'win' => false,
                                    'kills' => 4,
                                    'deaths' => 9,
                                    'assists' => 0
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70597402,
                                    'account_id' => 227445636,
                                    'name' => 'IgorDzingul66',
                                    'champion_id' => 267,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 10,
                                    'assists' => 3
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70424251,
                                    'account_id' => 227023809,
                                    'name' => 'Djooric',
                                    'champion_id' => 203,
                                    'win' => true,
                                    'kills' => 1,
                                    'deaths' => 11,
                                    'assists' => 10
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70595250,
                                    'account_id' => 227345603,
                                    'name' => 'Rito Pantheon',
                                    'champion_id' => 420,
                                    'win' => true,
                                    'kills' => 2,
                                    'deaths' => 3,
                                    'assists' => 1
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70658106,
                                    'account_id' => 227478999,
                                    'name' => 'Qwabolaxa',
                                    'champion_id' => 74,
                                    'win' => true,
                                    'kills' => 8,
                                    'deaths' => 6,
                                    'assists' => 6
                                ],
                                [
                                    'team_id' => 200,
                                    'summoner_id' => 70605001,
                                    'account_id' => 227337130,
                                    'name' => 'CakeDog23',
                                    'champion_id' => 22,
                                    'win' => true,
                                    'kills' => 27,
                                    'deaths' => 4,
                                    'assists' => 5
                                ]
                            ]
                        ]
                    ],
                ],
                30
            ],
        ];
    }
}

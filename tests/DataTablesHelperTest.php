<?php

namespace Michaelthedev\PhpDatatables;

use PHPUnit\Framework\TestCase;

class DataTablesHelperTest extends TestCase
{

    public function testProcessTableRequestWithCorrectId()
    {
        $helper = new DataTablesHelper();
        $expectedData = [
            [
                'id' => 1,
                'name' => 'Michael',
                'nickname' => 'IDAN, 001'
            ],
            [
                'id' => 2,
                'name' => 'Jeffery',
                'email' => 'logickoder'
            ]
        ];

        ## Customer Table ##
        $helper->set('customersTable001', function () use ($expectedData) {
            return $expectedData;
        });

        // Capture the output of the processRequest
        $helper->processTableRequest('customersTable001');
        $output = $this->getActualOutputForAssertion();

        $expectedOutput = json_encode($expectedData);
        $this->expectOutputString($expectedOutput);
        $this->assertJsonStringEqualsJsonString($expectedOutput, $output);
    }

    public function testProcessTableRequestWithInCorrectId()
    {
        $helper = new DataTablesHelper();
        $expectedData = [
            [
                'id' => 1,
                'name' => 'Michael',
                'nickname' => 'IDAN, 001'
            ],
            [
                'id' => 2,
                'name' => 'Jeffery',
                'email' => 'logickoder'
            ]
        ];

        ## Customer Table ##
        $helper->set('customersTable001', function () use ($expectedData) {
            return $expectedData;
        });

        // Capture the output of the processRequest
        $helper->processTableRequest('customersTable002');
        $output = $this->getActualOutputForAssertion();

        $this->expectOutputString('Table not found');
        $this->assertEquals(404, http_response_code());
        $this->assertEquals('Table not found', $output);
    }

    public function testSet()
    {
        $helper = new DataTablesHelper();

        ## Customer Table 1 ##
        $helper->set('customersTable001', function () {
            return [
                [
                    'id' => 1,
                    'name' => 'Michael',
                    'email' => 'mciahel@test.com'
                ],
                [
                    'id' => 2,
                    'name' => 'Jaden',
                    'email' => 'jaden@test.com'
                ]
            ];
        });

        ## Customer Table 2 ##
        $helper->set('customersTable002', function () {
            return [
                [
                    1, 'Michael', 'mciahel@test.com'
                ],
                [
                    2, 'Jaden', 'jaden@test.com'
                ]
            ];
        });

        $this->assertIsArray($helper->getTableIds());

        $this->assertSame([
            'customersTable001',
            'customersTable002'
        ], $helper->getTableIds());
    }
}

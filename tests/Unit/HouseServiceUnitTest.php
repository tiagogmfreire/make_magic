<?php

use App\Services\HouseService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Testing for the HouseService class
 */
class HouseServiceTest extends TestCase
{

    use DatabaseTransactions;

    protected HouseService $houseService;

    /**
     * Extending setUp() to create a HouseService object 
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->houseService = new HouseService();
    }

    /**
     * Testing an invalid integer id
     *
     * @return void
     */
    public function testValidateInvalidIDNumber()
    {
        $id = 12;

        $response = $this->houseService->validate($id);

        $this->assertFalse($response);
    }

    /**
     * Testing an invalid string id
     *
     * @return void
     */
    public function testValidateInvalidIDString()
    {
        $id = 'xxx';

        $response = $this->houseService->validate($id);

        $this->assertFalse($response);
    }

    /**
     * Testing a valid id (will fail without seed)
     *
     * @return void
     */
    public function testValidateValidID()
    {
        $id = '1760529f-6d51-4cb1-bcb1-25087fce5bde';

        $response = $this->houseService->validate($id);

        $this->assertTrue($response);
    }

    /**
     * Testing searching for an invalid integer id
     *
     * @return void
     */
    public function testSearchInvalidIDNumber()
    {
        $id = 12;

        $response = $this->houseService->search($id);

        $this->assertEmpty($response);
    }

    /**
     * Testing searching for an invalid string id
     *
     * @return void
     */
    public function testSearchInvalidIDString()
    {
        $id = 'xxx';

        $response = $this->houseService->validate($id);

        $this->assertEmpty($response);
    }
    
    /**
     * Testing search for a valid id (will fail without seed)
     *
     * @return void
     */
    public function testSearchValidID()
    {
        $id = '1760529f-6d51-4cb1-bcb1-25087fce5bde';

        $response = $this->houseService->validate($id);

        $this->assertNotEmpty($response);
    }

    /**
     * Testing saving an array of houses
     *
     * @return void
     */
    public function testSaveArray()
    {
        $houses['houses'] = [
            [
                'id'=>'001aaabbb',
                'name'=> 'House1',
                'headOfHouse'=> 'Head1',
                'school'=> 'school1',
                'mascot'=> 'mascot1',
                'houseGhost'=> 'ghost1',
                'founder'=> 'founder1'
            ],
            [
                'id'=>'002aaabbb',
                'name'=> 'House2',
                'headOfHouse'=> 'Head2',
                'school'=> 'school2',
                'mascot'=> 'mascot2',
                'houseGhost'=> 'ghost2',
                'founder'=> 'founder2'
            ],
            
        ];

        $response = $this->houseService->saveArray($houses);

        $this->assertTrue($response);
    }

    /**
     * Testing importing data from API
     *
     * @return void
     */
    public function testImportFromAPI()
    {
        $response = $this->houseService->import_from_api();

        $this->assertTrue($response);
    }
}

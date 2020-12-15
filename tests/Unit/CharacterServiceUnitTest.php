<?php

use App\Services\CharacterService;
use App\Services\HouseService;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

/**
 * Testing for the HouseService class
 */
class CharacterServiceTest extends TestCase
{
    use DatabaseTransactions;

    protected CharacterService $characterService;

    /**
     * Extending setUp() to create a HouseService object 
     *
     * @return void
     */
    protected function setUp() : void
    {
        parent::setUp();

        $this->characterService = new CharacterService(
            new HouseService()
        );
    }

    /**
     * Testing an invalid integer id
     *
     * @return void
     */
    public function testValidateInvalidIDNumber()
    {
        $id = -10;

        $response = $this->characterService->validate($id);

        $this->assertFalse($response);
    }

    /**
     * Testing an invalid id string
     *
     * @return void
     */
    public function testValidateInvalidIDString()
    {
        $id = "xxx";

        $response = $this->characterService->validate($id);

        $this->assertFalse($response);
    }

    /**
     * Testing an invalid id float
     *
     * @return void
     */
    public function testValidateInvalidIDFloat()
    {
        $id = 3.5;

        $response = $this->characterService->validate($id);

        $this->assertFalse($response);
    }

    /**
     * Testing a valid id
     *
     * @return void
     */
    public function testValidateValidId()
    {
        $id = 1;

        $response = $this->characterService->validate($id);

        $this->assertTrue($response);
    }

    /**
     * Testing search with a invalid id (0)
     *
     * @return void
     */
    public function testGetInvalidIdNumber()
    {
        $id = 0;

        $response = $this->characterService->get($id);

        $this->assertEmpty($response);
    }

    /**
     * Testing search with a invalid string id
     *
     * @return void
     */
    public function testGetInvalidIdString()
    {
        $id = 'xxx';

        $response = $this->characterService->get($id);

        $this->assertEmpty($response);
    }
}

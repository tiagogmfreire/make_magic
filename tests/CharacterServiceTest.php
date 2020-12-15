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

    /**
     * Testing save characters with no arguments
     *
     * @return void
     */
    public function testSaveCharNoArguments()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save();
        
    }

    /**
     * Testing save characters with wrong types
     *
     * @return void
     */
    public function testSaveCharWrongTypes()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save(
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1
        );
        
    }

    /**
     * Testing save characters with wrong types
     *
     * @return void
     */
    public function testUpdateCharWrongTypes()
    {
        $this->expectException(\Error::class);

        $char = $this->characterService->save(
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            1,
            'xxx'
        );
        
    }


    public function testSaveChar()
    {
        $char = $this->characterService->save(
            '1760529f-6d51-4cb1-bcb1-25087fce5bde',
            'Harry',
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertNotEmpty($char);
    }
}
